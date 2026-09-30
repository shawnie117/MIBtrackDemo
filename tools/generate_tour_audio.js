#!/usr/bin/env node
/* =====================================================================
 * MI-BTrack guided demo - narration generator (ElevenLabs)
 * ---------------------------------------------------------------------
 * Turns the exported voice pack into the mp3 files the tour player uses.
 *
 * Set one or more keys, comma separated. They are pooled: when one runs
 * out the generator moves to the next by itself.
 *
 *   $env:ELEVENLABS_API_KEYS = 'sk_a,sk_b,sk_c'
 *
 *   node tools/generate_tour_audio.js                 # plan only, spends nothing
 *   node tools/generate_tour_audio.js --go            # generate Marathi
 *   node tools/generate_tour_audio.js --go --lang all # generate mr, hi and en
 *   node tools/generate_tour_audio.js --go --lang all --ids f09 # one chapter
 *   node tools/generate_tour_audio.js --go --limit 1  # try a single clip first
 *   node tools/generate_tour_audio.js --go --lang all \
 *     --audio-root tools/voice_pack/new_audio \
 *     --ledger tools/voice_pack/new_generated.json    # stage a replacement pack
 *
 * SAFETY RULES BUILT IN
 *   1. Dry run by default. Nothing is spent without --go.
 *   2. Every key's live quota is read before anything is generated, and
 *      again at the end, so reported cost is measured rather than guessed.
 *   3. A reserve is held back on each key. The pool moves on before a key
 *      is driven to zero.
 *   4. Resumable. A clip already on disk is skipped, so an interrupted run
 *      never pays for the same sentence twice.
 *   5. Priority order. If budget runs out, what exists is the beginning of
 *      a tour you can present, not a random scattering of sentences.
 *   6. Keys are read from the environment only, and the ledger stores just
 *      the last four characters so runs can be told apart. No key is ever
 *      written into this project.
 *
 * WHY A PARTIAL PACK IS STILL FINE
 * The player looks for assets/tour/audio/<lang>/<step-id>.mp3 and, when a
 * file is missing, speaks that step with the browser's own voice. Every
 * step is always explained out loud. Recorded clips just sound better.
 * ===================================================================== */

'use strict';

const fs = require('fs');
const path = require('path');

// ---------------------------------------------------------------------
// Settings
// ---------------------------------------------------------------------

const REPO = path.resolve(__dirname, '..');
const MANIFEST = path.join(REPO, 'tools', 'voice_pack', 'manifest.json');
const AUDIO_ROOT = path.resolve(arg('audio-root', path.join(REPO, '_build', 'assets', 'tour', 'audio')));
const LEDGER = path.resolve(arg('ledger', path.join(REPO, 'tools', 'voice_pack', 'generated.json')));

function arg(name, fallback) {
    const i = process.argv.indexOf('--' + name);
    return i !== -1 && process.argv[i + 1] && !process.argv[i + 1].startsWith('--')
        ? process.argv[i + 1] : fallback;
}
const flag = (name) => process.argv.includes('--' + name);

const GO = flag('go');
const LIMIT = parseInt(arg('limit', '0'), 10) || 0;
const RESERVE = parseInt(arg('reserve', '120'), 10);

const LANG_ARG = arg('lang', 'mr');
const LANGS = LANG_ARG === 'all' ? ['mr', 'hi', 'en'] : LANG_ARG.split(',');
const IDS = arg('ids', '').split(',').map(id => id.trim()).filter(Boolean);

/** V4 Turbo supports English, Hindi and Marathi at half-credit cost. */
const MODEL = arg('model', 'eleven_v4_turbo');
const ALLOW_UNSUPPORTED_MR_V2 = flag('allow-unsupported-marathi-v2');

/** Bella is a clear, warm premade voice usable with free-tier API keys. */
const VOICE = arg('voice', 'hpp4J3VqNfWAUOO0d1Us');

/** Tuned for narration that plays over a live screen. */
const VOICE_SETTINGS = {
    stability: 0.62,
    similarity_boost: 0.75,
    style: 0.0,               // no dramatisation
    use_speaker_boost: true,
    speed: 0.98
};

const API = 'https://api.elevenlabs.io/v1';

// ---------------------------------------------------------------------
// Key pool
// ---------------------------------------------------------------------

function readKeys() {
    const raw = process.env.ELEVENLABS_API_KEYS || process.env.ELEVENLABS_API_KEY || '';
    return raw.split(',').map((k) => k.trim()).filter(Boolean);
}

const tail = (key) => '...' + key.slice(-4);

async function quotaFor(key) {
    const r = await fetch(API + '/user/subscription', { headers: { 'xi-api-key': key } });
    if (!r.ok) { throw new Error('HTTP ' + r.status + ' ' + (await r.text()).slice(0, 160)); }
    const s = await r.json();
    return {
        used: s.character_count,
        limit: s.character_limit,
        left: s.character_limit - s.character_count,
        tier: s.tier,
        resets: s.next_character_count_reset_unix
            ? new Date(s.next_character_count_reset_unix * 1000).toISOString().slice(0, 10) : null
    };
}

/**
 * Build the pool, dropping any key that does not authenticate.
 *
 * A dead key is reported rather than skipped silently: if one of three
 * keys is wrong, that is something the operator needs to know before
 * planning a budget around it.
 */
async function buildPool(keys) {
    const pool = [];
    for (const key of keys) {
        try {
            const q = await quotaFor(key);
            pool.push({
                key,
                label: tail(key),
                tier: q.tier,
                startUsed: q.used,
                limit: q.limit,
                left: q.left,
                resets: q.resets,
                spent: 0,
                dead: false
            });
        } catch (err) {
            console.log('  key ' + tail(key) + ' unusable: ' + err.message);
        }
    }
    return pool;
}

/** First key with room for this clip, after the reserve. */
function pickKey(pool, cost) {
    return pool.find((k) => !k.dead && (k.left - k.spent - RESERVE) >= cost) || null;
}

// ---------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------

const countChars = (t) => Array.from(String(t || '')).length;
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

const MULTIPLIER = /flash|turbo|conversational/.test(MODEL) ? 0.5 : 1;
const costOf = (text) => Math.ceil(countChars(text) * MULTIPLIER);

/**
 * Priority order for spending.
 *
 *   1. the Full Demo, in the order it plays
 *   2. the Short Demo reuse list (normally already covered by Full)
 *   3. any future clip not yet referenced by either sequence
 *
 * Clips are shared between Full and Short, so a recording is never paid
 * for twice merely because both tours use it.
 */
function priorityOrder(manifest) {
    const byId = new Map(manifest.clips.map((c) => [c.id, c]));
    const out = [];
    const seen = new Set();

    const add = (ids, why) => {
        for (const id of ids) {
            if (seen.has(id)) { continue; }
            seen.add(id);
            const clip = byId.get(id);
            if (clip) { out.push({ clip, why }); }
        }
    };

    add(manifest.tours.full.stepIds, 'Full Demo');
    add(manifest.tours.short.stepIds, 'Short Demo reuse');
    add(manifest.clips.map((c) => c.id), 'tour-specific ending');

    return out;
}

function readLedger() {
    if (!fs.existsSync(LEDGER)) { return { runs: [], clips: {} }; }
    try { return JSON.parse(fs.readFileSync(LEDGER, 'utf8')); }
    catch (e) { return { runs: [], clips: {} }; }
}

function writeLedger(ledger) {
    fs.mkdirSync(path.dirname(LEDGER), { recursive: true });
    fs.writeFileSync(LEDGER, JSON.stringify(ledger, null, 2) + '\n', 'utf8');
}

// ---------------------------------------------------------------------
// Generation
// ---------------------------------------------------------------------

/** Does this response mean "this key is finished", as opposed to a blip? */
function isKeyExhausted(status, detail) {
    if (status === 401 || status === 403) { return true; }
    if (status === 429) { return true; }
    return /quota|character.?limit|exceeded|insufficient/i.test(detail);
}

/**
 * Generate one clip, moving through the key pool on failure.
 *
 * A key that reports exhaustion is marked dead so no later clip retries
 * it. A transient error is retried once on the same key before the pool
 * advances.
 */
async function speak(text, pool, cost) {
    const url = API + '/text-to-speech/' + VOICE + '?output_format=mp3_44100_128';
    const body = JSON.stringify({ text, model_id: MODEL, voice_settings: VOICE_SETTINGS });
    const problems = [];

    for (;;) {
        const holder = pickKey(pool, cost);
        if (!holder) {
            throw new Error('no key has room for this clip' +
                (problems.length ? ' (' + problems.join('; ') + ')' : ''));
        }

        let transientRetried = false;
        let networkRetries = 0;
        for (;;) {
            let r;
            try {
                r = await fetch(url, {
                    method: 'POST',
                    headers: { 'xi-api-key': holder.key, 'content-type': 'application/json' },
                    body
                });
            } catch (err) {
                if (networkRetries++ < 3) {
                    await sleep(1500 * networkRetries);
                    continue;
                }
                throw new Error('network request failed after retries: ' +
                    (err.cause && err.cause.code ? err.cause.code : err.message));
            }

            if (r.ok) {
                holder.spent += cost;
                return { audio: Buffer.from(await r.arrayBuffer()), holder };
            }

            const detail = (await r.text()).slice(0, 300);

            if (isKeyExhausted(r.status, detail)) {
                holder.dead = true;
                problems.push(holder.label + ' HTTP ' + r.status);
                break;                                  // advance the pool
            }
            if ((r.status >= 500 || r.status === 408) && !transientRetried) {
                transientRetried = true;
                await sleep(1500);
                continue;                               // same key, one more go
            }
            // A real error with this text, e.g. rejected content. Retrying on
            // another key would fail identically and cost credits.
            throw new Error('HTTP ' + r.status + ' - ' + detail);
        }
    }
}

// ---------------------------------------------------------------------
// Planning
// ---------------------------------------------------------------------

function planLanguage(manifest, ordered, lang, poolBudget, alreadyPlanned) {
    const outDir = path.join(AUDIO_ROOT, lang);
    const planned = [];
    const skipped = [];
    const deferred = [];
    let projected = alreadyPlanned;

    for (const { clip, why } of ordered) {
        const text = clip.narration[lang];
        if (!text) { deferred.push({ id: clip.id, reason: 'no ' + lang + ' narration written' }); continue; }

        if (fs.existsSync(path.join(outDir, clip.id + '.mp3'))) { skipped.push(clip.id); continue; }

        const cost = costOf(text);
        if (projected + cost > poolBudget) {
            deferred.push({ id: clip.id, reason: 'beyond the pooled budget' });
            continue;
        }
        planned.push({ clip, why, cost, chars: countChars(text), text, lang, outDir });
        projected += cost;
    }

    return { planned, skipped, deferred, projected };
}

// ---------------------------------------------------------------------
// Main
// ---------------------------------------------------------------------

(async () => {
    if (LANGS.includes('mr') && /(?:turbo|flash)_v2$/.test(MODEL) && !ALLOW_UNSUPPORTED_MR_V2) {
        console.error('\nGeneration stopped before spending credits.');
        console.error('ElevenLabs documents ' + MODEL + ' as English-only, so it cannot produce reliable Marathi.');
        console.error('Use --model eleven_v3 for supported Marathi, or add');
        console.error('--allow-unsupported-marathi-v2 to knowingly test the requested v2 model.\n');
        process.exit(2);
    }
    const keys = readKeys();
    if (!keys.length) {
        console.error('\nNo keys found. In PowerShell:');
        console.error("  $env:ELEVENLABS_API_KEYS = 'sk_one,sk_two,sk_three'\n");
        process.exit(1);
    }
    if (!fs.existsSync(MANIFEST)) {
        console.error('\nNo manifest. Run this first:\n  node tools/export_tour_voice_pack.js\n');
        process.exit(1);
    }

    const manifest = JSON.parse(fs.readFileSync(MANIFEST, 'utf8'));

    console.log('');
    console.log('MI-BTrack narration generator');
    console.log('  model  : ' + MODEL + '   (character cost x' + MULTIPLIER + ')');
    console.log('  voice  : ' + VOICE);
    console.log('  langs  : ' + LANGS.join(', '));
    console.log('  mode   : ' + (GO ? 'GENERATING' : 'dry run - nothing will be spent'));
    console.log('');
    console.log('  checking ' + keys.length + ' key(s)...');

    const pool = await buildPool(keys);
    if (!pool.length) { throw new Error('none of the supplied keys authenticate'); }

    let poolBudget = 0;
    console.log('');
    console.log('  key       tier    limit   used    left   spendable');
    for (const k of pool) {
        const spendable = Math.max(0, k.left - RESERVE);
        poolBudget += spendable;
        console.log('  ' + k.label.padEnd(9) + (k.tier || '?').padEnd(8) +
            String(k.limit).padStart(6) + String(k.startUsed).padStart(8) +
            String(k.left).padStart(8) + String(spendable).padStart(11) +
            (k.resets ? '   resets ' + k.resets : ''));
    }
    console.log('  ' + ' '.repeat(31) + 'POOL BUDGET: ' + poolBudget);
    console.log('');

    // ---- plan every requested language against one shared budget -----

    const ordered = priorityOrder(manifest).filter(item => !IDS.length || IDS.includes(item.clip.id));
    for (const id of IDS) {
        if (!ordered.some(item => item.clip.id === id)) throw new Error('Unknown clip id: ' + id);
    }
    const plans = {};
    let running = 0;
    let allPlanned = [];

    for (const lang of LANGS) {
        const plan = planLanguage(manifest, ordered, lang, poolBudget, running);
        plans[lang] = plan;
        running = plan.projected;
        allPlanned = allPlanned.concat(plan.planned);
    }

    console.log('  language  on disk  to make  credits  falls back to browser voice');
    for (const lang of LANGS) {
        const p = plans[lang];
        const cost = p.planned.reduce((s, x) => s + x.cost, 0);
        console.log('  ' + lang.padEnd(10) + String(p.skipped.length).padStart(7) +
            String(p.planned.length).padStart(9) + String(cost).padStart(9) +
            String(p.deferred.length).padStart(29));
    }
    console.log('');
    console.log('  total clips to generate : ' + allPlanned.length);
    console.log('  total projected credits : ' + running + ' of ' + poolBudget + ' spendable');
    console.log('');

    if (LIMIT) {
        allPlanned = allPlanned.slice(0, LIMIT);
        console.log('  --limit ' + LIMIT + ': only the first ' + allPlanned.length + ' clip(s) will be generated.');
        console.log('');
    }

    if (!GO) {
        console.log('  Dry run. No credits used. Add --go to generate.');
        console.log('  First few, in spending order:');
        allPlanned.slice(0, 8).forEach((p, i) => console.log('    ' + (i + 1) + '. ' +
            (p.lang + '/' + p.clip.id).padEnd(28) + p.cost + ' credits   [' + p.why + ']'));
        if (allPlanned.length > 8) { console.log('    ... and ' + (allPlanned.length - 8) + ' more'); }
        console.log('');
        return;
    }

    // ---- generate ----------------------------------------------------

    const ledger = readLedger();
    const done = [];
    const failed = [];
    let consecutiveFailures = 0;
    let n = 0;

    for (const item of allPlanned) {
        n++;
        fs.mkdirSync(item.outDir, { recursive: true });
        const label = '[' + String(n).padStart(3) + '/' + allPlanned.length + '] ' +
            (item.lang + '/' + item.clip.id).padEnd(28);
        try {
            const { audio, holder } = await speak(item.text, pool, item.cost);
            fs.writeFileSync(path.join(item.outDir, item.clip.id + '.mp3'), audio);

            ledger.clips[item.lang + '/' + item.clip.id] = {
                characters: item.chars,
                creditsEstimated: item.cost,
                model: MODEL,
                voice: VOICE,
                keyTail: holder.label,
                bytes: audio.length,
                at: new Date().toISOString()
            };
            writeLedger(ledger);   // written after every clip, so a crash loses nothing

            done.push(item.lang + '/' + item.clip.id);
            consecutiveFailures = 0;
            console.log('  ok    ' + label + Math.round(audio.length / 1024) + ' KB  ' + holder.label);
        } catch (err) {
            failed.push({ id: item.lang + '/' + item.clip.id, error: err.message });
            consecutiveFailures++;
            console.log('  FAIL  ' + label + err.message);
            if (/no key has room/.test(err.message)) {
                console.log('\n  The pool is exhausted. Stopping here.');
                break;
            }
            if (consecutiveFailures >= 3) {
                console.log('\n  Three consecutive failures. Stopping to preserve retry budget.');
                break;
            }
        }
        await sleep(300);   // be polite to the API
    }

    // ---- measure ------------------------------------------------------

    console.log('');
    console.log('  measuring actual spend per key...');
    let measured = 0;
    const perKey = [];
    for (const k of pool) {
        try {
            const q = await quotaFor(k.key);
            const spent = q.used - k.startUsed;
            measured += spent;
            perKey.push({ key: k.label, spent, left: q.left });
        } catch (e) {
            perKey.push({ key: k.label, spent: null, left: null, note: 'could not re-read' });
        }
    }

    ledger.runs.push({
        at: new Date().toISOString(),
        languages: LANGS,
        model: MODEL,
        voice: VOICE,
        generated: done.length,
        failed: failed.length,
        creditsProjected: allPlanned.reduce((s, x) => s + x.cost, 0),
        creditsMeasured: measured,
        keys: perKey
    });
    writeLedger(ledger);

    console.log('');
    console.log('  generated : ' + done.length);
    console.log('  failed    : ' + failed.length);
    console.log('');
    console.log('  key       spent   left');
    perKey.forEach((k) => console.log('  ' + k.key.padEnd(9) +
        String(k.spent === null ? '?' : k.spent).padStart(6) +
        String(k.left === null ? '?' : k.left).padStart(7) + (k.note ? '  ' + k.note : '')));
    console.log('  measured total spend: ' + measured +
        '   (projected ' + allPlanned.reduce((s, x) => s + x.cost, 0) + ')');
    console.log('');

    if (failed.length) {
        console.log('  Failures:');
        failed.forEach((f) => console.log('    ' + f.id + ' - ' + f.error));
        console.log('');
    }

    const total = manifest.clips.length;
    for (const lang of LANGS) {
        const dir = path.join(AUDIO_ROOT, lang);
        const onDisk = fs.existsSync(dir) ? fs.readdirSync(dir).filter((f) => f.endsWith('.mp3')).length : 0;
        console.log('  ' + lang + ' pack: ' + onDisk + ' of ' + total + ' clips recorded' +
            (onDisk === total ? '  (complete)' : ''));
    }
    console.log('  Any clip without a recording is spoken by the browser voice,');
    console.log('  so every step of the tour is explained either way.');
    console.log('');
})().catch((err) => {
    console.error('\nGenerator failed: ' + err.message + '\n');
    process.exitCode = 1;
});
