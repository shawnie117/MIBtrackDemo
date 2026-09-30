#!/usr/bin/env node
/* =====================================================================
 * MI-BTrack guided demo - ElevenLabs voice pack exporter
 * ---------------------------------------------------------------------
 * Reads the tour script and writes everything you need to record the
 * narration, without ever changing a single word of it.
 *
 *   node tools/export_tour_voice_pack.js
 *   node tools/export_tour_voice_pack.js --budget 10000 --lang en
 *
 * WHAT IT WRITES  (tools/voice_pack/)
 *   manifest.json          every clip: id, language, chapter, tours,
 *                          character count, expected mp3 path
 *   BUDGET.md              character totals and a batch plan that fits
 *                          the ElevenLabs allowance you gave it
 *   README.md              step-by-step recording instructions
 *   <lang>/script-<tour>.txt   one readable script per tour
 *   <lang>/clips/<id>.txt      one file per clip, ready to paste
 *
 * WHY PER-CLIP FILES
 * ElevenLabs bills per character, and the player advances when a clip
 * ends. One clip per step means a re-recorded sentence costs only that
 * sentence, and no separate timing file ever has to be maintained.
 *
 * WHY THE COUNTS ARE NOT JUST text.length
 * Hindi and Marathi are Devanagari. A JavaScript string counts UTF-16
 * code units, so a single character built from a base letter plus a
 * combining mark can read as two. Array.from() walks code points
 * instead, which is much closer to what the service actually bills.
 * The number is still an estimate - treat it as a planning figure, and
 * check your account's usage page after the first batch.
 *
 * DEDUPLICATION
 * The core, AMC and full tours deliberately share step objects. The
 * player loads audio by step id alone, so a clip recorded once serves
 * every tour containing it. This exporter counts each id ONCE. Counting
 * per tour would roughly double the apparent bill for no benefit.
 * ===================================================================== */

'use strict';

const fs = require('fs');
const path = require('path');
const vm = require('vm');

// ---------------------------------------------------------------------
// Arguments
// ---------------------------------------------------------------------

function arg(name, fallback) {
    const i = process.argv.indexOf('--' + name);
    return i !== -1 && process.argv[i + 1] ? process.argv[i + 1] : fallback;
}

const REPO = path.resolve(__dirname, '..');
const CONTENT_FILE = path.join(REPO, '_build', 'assets', 'js', 'demo-tour-content.js');
const OUT_DIR = path.join(REPO, 'tools', 'voice_pack');

// ElevenLabs free allowance at the time of writing: 10,000 credits a
// month, and standard text-to-speech models bill about one credit per
// character. Override it if your plan differs.
const BUDGET = parseInt(arg('budget', '10000'), 10);

const ALL_LANGS = ['mr', 'hi', 'en'];
const LANGS = arg('lang', '') ? arg('lang', '').split(',') : ALL_LANGS;
const TOURS = ['full', 'short'];

const LANG_NAME = { mr: 'Marathi', hi: 'Hindi', en: 'English' };

// Words that must be pronounced identically in all three languages, so
// the demo never sounds like it is describing two different products.
const KEEP_IN_ENGLISH = ['MI-BTrack', 'AMC', 'CCTV', 'GST', 'Aster Heights Annex', 'Aster CCTV Annual Care'];

// ---------------------------------------------------------------------
// Load the tour script
//
// Runs in a throwaway sandbox with no require, no fs and no network, so
// evaluating the content file cannot touch the project.
// ---------------------------------------------------------------------

function loadContent() {
    if (!fs.existsSync(CONTENT_FILE)) {
        throw new Error('Cannot find the tour script at ' + CONTENT_FILE);
    }
    const source = fs.readFileSync(CONTENT_FILE, 'utf8');
    const sandbox = { window: {} };
    vm.createContext(sandbox);
    try {
        vm.runInContext(source, sandbox, { timeout: 5000, filename: 'demo-tour-content.js' });
    } catch (err) {
        throw new Error('The tour script did not evaluate cleanly: ' + err.message);
    }
    const content = sandbox.window.MIB_TOUR_CONTENT;
    if (!content) { throw new Error('demo-tour-content.js did not set window.MIB_TOUR_CONTENT.'); }
    for (const tour of TOURS) {
        if (!Array.isArray(content[tour])) {
            throw new Error('Tour "' + tour + '" is missing or is not a list of steps.');
        }
    }
    return content;
}

// ---------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------

/** Count characters the way a billing system sees them. */
function countChars(text) {
    return Array.from(String(text || '')).length;
}

/** Rough spoken length. Only used to describe the tour, never to time it. */
function estimateSeconds(chars) {
    return Math.round(chars / 14.5);   // ~14.5 characters a second, unhurried
}

function mmss(totalSeconds) {
    const m = Math.floor(totalSeconds / 60);
    const s = totalSeconds % 60;
    return m + 'm ' + String(s).padStart(2, '0') + 's';
}

function pick(bundle, lang) {
    if (!bundle) { return ''; }
    if (typeof bundle === 'string') { return bundle; }
    return bundle[lang] || bundle.en || '';
}

function ensureDir(dir) {
    fs.mkdirSync(dir, { recursive: true });
}

/** Guard against a step id that would not survive being a filename. */
function assertSafeId(id) {
    if (!/^[a-z0-9][a-z0-9\-]*$/.test(id)) {
        throw new Error('Step id "' + id + '" is not filename safe. Use lowercase letters, digits and hyphens.');
    }
}

// ---------------------------------------------------------------------
// Build the clip list
// ---------------------------------------------------------------------

/**
 * One entry per unique step id, recording which tours use it.
 * Order follows the full tour first, so the scripts read in teaching
 * order, then anything that only appears in a shorter tour is appended.
 */
function buildClips(content) {
    const byId = new Map();
    const order = [];

    const walk = (tour) => {
        content[tour].forEach((step, position) => {
            if (!step.id) {
                throw new Error('A step in the "' + tour + '" tour has no id (position ' + position + ').');
            }
            assertSafeId(step.id);

            if (!byId.has(step.id)) {
                byId.set(step.id, {
                    id: step.id,
                    tours: [],
                    url: step.url || '',
                    selector: step.selector || '',
                    hasCue: !!step.cue,
                    isSubmit: !!(step.cue && []
                        .concat(step.cue)
                        .some((c) => c && c.kind === 'submit')),
                    chapter: {},
                    title: {},
                    text: {}
                });
                order.push(step.id);
            }

            const clip = byId.get(step.id);
            if (!clip.tours.includes(tour)) { clip.tours.push(tour); }

            for (const lang of ALL_LANGS) {
                const chapter = pick(step.chapter, lang);
                const title = pick(step.title, lang);
                const text = pick(step.text, lang);

                // Consistency check: the same id must never carry two
                // different scripts, or one recording would be wrong for
                // one of the tours using it.
                if (clip.text[lang] && clip.text[lang] !== text) {
                    throw new Error('Step id "' + step.id + '" has two different ' + lang +
                        ' narrations. One id must mean exactly one recording.');
                }
                clip.chapter[lang] = chapter;
                clip.title[lang] = title;
                clip.text[lang] = text;
            }
        });
    };

    walk('full');
    walk('short');

    return order.map((id) => byId.get(id));
}

/** Report missing translations rather than silently exporting English. */
function findGaps(clips) {
    const gaps = [];
    for (const clip of clips) {
        for (const lang of ALL_LANGS) {
            if (!clip.text[lang]) {
                gaps.push(clip.id + ' has no ' + lang + ' narration');
            } else if (lang !== 'en' && clip.text[lang] === clip.text.en) {
                gaps.push(clip.id + ' ' + lang + ' narration is identical to English (not translated?)');
            }
        }
    }
    return gaps;
}

// ---------------------------------------------------------------------
// Writing the pack
// ---------------------------------------------------------------------

function writeClipFiles(clips, lang) {
    const dir = path.join(OUT_DIR, lang, 'clips');
    ensureDir(dir);
    for (const clip of clips) {
        // Narration only. No headings, no numbering, no stage directions -
        // whatever is in this file is exactly what should be spoken.
        fs.writeFileSync(path.join(dir, clip.id + '.txt'), clip.text[lang] + '\n', 'utf8');
    }
    return dir;
}

function writeTourScript(content, clips, lang, tour) {
    const byId = new Map(clips.map((c) => [c.id, c]));
    const steps = content[tour];

    const lines = [];
    lines.push('MI-BTrack guided demo - narration script');
    lines.push('Tour: ' + tour + '        Language: ' + LANG_NAME[lang]);
    lines.push('Steps: ' + steps.length);
    lines.push('');
    lines.push('HOW TO USE THIS FILE');
    lines.push('  Record one clip per numbered block below. Save it as the file name');
    lines.push('  shown in [brackets]. Read only the line after "SAY:" - the heading and');
    lines.push('  the screen note are here for your context and must not be spoken.');
    lines.push('');
    lines.push('  Clips are shared between tours. If a file already exists from another');
    lines.push('  tour, skip it - do not record or pay for it twice.');
    lines.push('');
    lines.push('='.repeat(74));
    lines.push('');

    let lastChapter = null;
    let n = 0;
    let chars = 0;

    for (const step of steps) {
        const clip = byId.get(step.id);
        const chapter = clip.chapter[lang];

        if (chapter && chapter !== lastChapter) {
            lines.push('');
            lines.push('---- CHAPTER: ' + chapter + ' ' + '-'.repeat(Math.max(0, 55 - chapter.length)));
            lines.push('');
            lastChapter = chapter;
        }

        n += 1;
        const count = countChars(clip.text[lang]);
        chars += count;

        lines.push(String(n).padStart(3, ' ') + '. [' + clip.id + '.mp3]   (' + count + ' characters)');
        lines.push('     SCREEN: ' + (clip.url || '-') + (clip.selector ? '   focus: ' + clip.selector : ''));
        if (clip.isSubmit) {
            lines.push('     NOTE:   this step presses a real Save button and waits for the');
            lines.push('             page to confirm. Read it at a steady, unhurried pace.');
        }
        lines.push('     SAY:    ' + clip.text[lang]);
        lines.push('');
    }

    lines.push('='.repeat(74));
    lines.push('Total for this tour: ' + chars + ' characters, roughly ' + mmss(estimateSeconds(chars)) + ' of speech.');
    lines.push('Remember that clips shared with another tour only cost once.');
    lines.push('');

    const dir = path.join(OUT_DIR, lang);
    ensureDir(dir);
    fs.writeFileSync(path.join(dir, 'script-' + tour + '.txt'), lines.join('\n'), 'utf8');

    return { steps: steps.length, chars };
}

/**
 * Split an ordered clip list into batches that each fit the allowance.
 *
 * Batches follow teaching order rather than being packed for maximum
 * density. If you can only afford the first batch this month you end up
 * with a coherent opening section you can actually present, rather than a
 * scattered set of unrelated sentences.
 */
function planBatches(orderedClips, lang, budget) {
    const batches = [];
    let current = { clips: [], chars: 0 };

    for (const clip of orderedClips) {
        const count = countChars(clip.text[lang]);
        if (count > budget) {
            throw new Error('Clip ' + clip.id + ' (' + count + ' characters) is larger than the whole budget.');
        }
        if (current.chars + count > budget) {
            batches.push(current);
            current = { clips: [], chars: 0 };
        }
        current.clips.push({ id: clip.id, chars: count, chapter: clip.chapter[lang] });
        current.chars += count;
    }
    if (current.clips.length) { batches.push(current); }
    return batches;
}

/**
 * The clips one tour needs, in the order that tour plays them.
 *
 * Used for the per-tour batch plan, so somebody recording only the AMC
 * story is not asked to pay for sales-tour clips first.
 */
function clipsForTour(content, clips, tour) {
    const byId = new Map(clips.map((c) => [c.id, c]));
    const seen = new Set();
    const out = [];
    for (const step of content[tour]) {
        if (seen.has(step.id)) { continue; }
        seen.add(step.id);
        out.push(byId.get(step.id));
    }
    return out;
}

function writeBudget(content, clips, totals, batchPlans, gaps) {
    const L = [];
    L.push('# Voice pack character budget');
    L.push('');
    L.push('Generated by `tools/export_tour_voice_pack.js` on ' + new Date().toISOString().slice(0, 10) + '.');
    L.push('Allowance used for the batch plan: **' + BUDGET.toLocaleString('en-US') + ' credits**.');
    L.push('');
    L.push('Standard ElevenLabs text-to-speech models bill roughly one credit per');
    L.push('character. These counts use Unicode code points, which is the closest');
    L.push('simple approximation. Check your account usage page after the first');
    L.push('batch and adjust with `--budget` if your plan counts differently.');
    L.push('');

    L.push('## Unique clips per language');
    L.push('');
    L.push('| Language | Clips | Characters | Approx. speech | Batches at ' + BUDGET.toLocaleString('en-US') + ' |');
    L.push('|---|---:|---:|---:|---:|');
    for (const lang of LANGS) {
        L.push('| ' + LANG_NAME[lang] + ' | ' + clips.length + ' | ' +
            totals[lang].toLocaleString('en-US') + ' | ' + mmss(estimateSeconds(totals[lang])) + ' | ' +
            batchPlans[lang].all.length + ' |');
    }
    const grand = LANGS.reduce((sum, l) => sum + totals[l], 0);
    L.push('| **All selected** | | **' + grand.toLocaleString('en-US') + '** | ' +
        mmss(estimateSeconds(grand)) + ' | |');
    L.push('');

    L.push('## What each tour costs');
    L.push('');
    L.push('Clips are shared, so these figures overlap. The per-language total above');
    L.push('is what you actually pay to cover every tour.');
    L.push('');
    L.push('| Tour | Steps | ' + LANGS.map((l) => LANG_NAME[l] + ' chars').join(' | ') + ' | Approx. length |');
    L.push('|---|---:|' + LANGS.map(() => '---:|').join('') + '---:|');
    for (const tour of TOURS) {
        const perLang = LANGS.map((lang) =>
            content[tour].reduce((sum, step) => sum + countChars(pick(step.text, lang)), 0));
        L.push('| ' + tour + ' | ' + content[tour].length + ' | ' +
            perLang.map((c) => c.toLocaleString('en-US')).join(' | ') + ' | ' +
            mmss(estimateSeconds(perLang[0])) + ' |');
    }
    L.push('');

    L.push('## Recommended order on a free allowance');
    L.push('');
    L.push('The Full Demo is the source pack. Short Demo reuses selected clips,');
    L.push('so it never needs duplicate generation. Record in this order:');
    L.push('');
    L.push('1. **Marathi Full Demo**, F01 through F23.');
    L.push('2. Verify every clip in the player at 1× and 2×.');
    L.push('3. Short Demo automatically reuses its selected Full Demo clips.');
    L.push('');
    L.push('Until a clip exists the player speaks that step with the browser voice, so');
    L.push('a partly recorded pack is still fully demonstrable. Nothing breaks.');
    L.push('');

    for (const lang of LANGS) {
        L.push('## Batch plans - ' + LANG_NAME[lang]);
        L.push('');
        L.push('Each plan is ordered the way that tour plays, so a half-finished pack is');
        L.push('still a coherent presentation. Clips are shared: once `w-01-welcome` is');
        L.push('recorded it also serves the Short Demo, so later plans may list clips');
        L.push('you have already paid for. Skip anything that already exists on disk.');
        L.push('');

        for (const tour of TOURS) {
            const plan = batchPlans[lang][tour];
            const total = plan.reduce((s, b) => s + b.chars, 0);
            L.push('### ' + tour + ' tour (' + plan.reduce((s, b) => s + b.clips.length, 0) +
                ' clips, ' + total.toLocaleString('en-US') + ' characters)');
            L.push('');
            plan.forEach((batch, i) => {
                const first = batch.clips[0];
                const last = batch.clips[batch.clips.length - 1];
                L.push('- **Batch ' + (i + 1) + '**: ' + batch.clips.length + ' clips, ' +
                    batch.chars.toLocaleString('en-US') + ' characters (' +
                    Math.round(batch.chars / BUDGET * 100) + '% of the allowance) - ' +
                    '`' + first.id + '` through `' + last.id + '`');
            });
            L.push('');
        }
    }

    L.push('## Licensing - please read before recording');
    L.push('');
    L.push('At the time of writing, ElevenLabs free-plan output carries **no commercial');
    L.push('rights**, requires attribution if published, and upgrading later does not');
    L.push('retroactively license audio that was generated while on the free plan.');
    L.push('');
    L.push('So:');
    L.push('');
    L.push('- Use free-plan audio for internal review and rehearsal only.');
    L.push('- Regenerate the approved final pack under a paid plan before showing it to');
    L.push('  a customer or publishing it.');
    L.push('- Do not assume an upgrade covers what you already made.');
    L.push('');
    L.push('Verify the current terms yourself before the commercial recording:');
    L.push('');
    L.push('- [ElevenLabs pricing](https://elevenlabs.io/pricing)');
    L.push('- [Can I publish the content I generate?](https://help.elevenlabs.io/hc/en-us/articles/13313564601361-Can-I-publish-the-content-I-generate-on-the-platform)');
    L.push('- [Model overview and supported languages](https://elevenlabs.io/docs/overview/models)');
    L.push('');
    L.push('_Terms above were summarised from those pages and may have changed._');
    L.push('');

    if (gaps.length) {
        L.push('## Translation gaps found');
        L.push('');
        L.push('These need a fluent speaker before recording:');
        L.push('');
        gaps.forEach((g) => L.push('- ' + g));
        L.push('');
    }

    ensureDir(OUT_DIR);
    fs.writeFileSync(path.join(OUT_DIR, 'BUDGET.md'), L.join('\n'), 'utf8');
}

function writeReadme(clips, totals) {
    const L = [];
    L.push('# MI-BTrack demo narration - recording pack');
    L.push('');
    L.push('Everything in this folder is generated. Do not edit it by hand.');
    L.push('The wording lives in `_build/assets/js/demo-tour-content.js`; change it');
    L.push('there and run the exporter again:');
    L.push('');
    L.push('```bash');
    L.push('node tools/export_tour_voice_pack.js');
    L.push('```');
    L.push('');
    L.push('## What is here');
    L.push('');
    L.push('```text');
    L.push('BUDGET.md              character counts and a batch plan');
    L.push('manifest.json          every clip, machine readable');
    L.push('<lang>/script-full.txt  read-through script for the 23-step Full Demo');
    L.push('<lang>/script-short.txt read-through script for the 12-step Short Demo');
    L.push('<lang>/clips/<id>.txt  one file per clip, narration only');
    L.push('```');
    L.push('');
    L.push('`' + clips.length + '` unique clips per language.');
    L.push('');
    L.push('## Recording settings');
    L.push('');
    L.push('The listener may be new to computers, so clarity matters more than');
    L.push('personality.');
    L.push('');
    L.push('| Setting | Value | Why |');
    L.push('|---|---|---|');
    L.push('| Format | MP3, 44.1 kHz or better | what the player expects |');
    L.push('| Voice | warm, clear female guide | easy for first-time users to follow |');
    L.push('| Speed | 0.95 to 1.0 | unhurried, easy to follow |');
    L.push('| Stability | medium-high | keeps 60+ clips sounding alike |');
    L.push('| Leading silence | under 250 ms | the clip starts as the step starts |');
    L.push('| Trailing silence | under 400 ms | the player advances on clip end |');
    L.push('| Music or effects | none | they would fight the live screen |');
    L.push('');
    L.push('Say these as separate letters, not as words: **M-I-B-Track**, **A-M-C**,');
    L.push('**C-C-T-V**, **G-S-T**. Keep these in English in all three languages so');
    L.push('the product never sounds like two different things: ' +
        KEEP_IN_ENGLISH.map((w) => '`' + w + '`').join(', ') + '.');
    L.push('');
    L.push('Use a model that explicitly supports the language being generated. The');
    L.push('replacement pack uses Eleven v4 Turbo for Marathi, Hindi and English, with');
    L.push('the Bella premade voice. The free-tier API cannot render Voice Library voices,');
    L.push('so a paid plan or an approved recording would be needed for a native Marathi');
    L.push('speaker. Do not regenerate Marathi with an English-only v2 model.');
    L.push('');
    L.push('## Where to put the finished files');
    L.push('');
    L.push('```text');
    L.push('_build/assets/tour/audio/en/<step-id>.mp3');
    L.push('_build/assets/tour/audio/hi/<step-id>.mp3');
    L.push('_build/assets/tour/audio/mr/<step-id>.mp3');
    L.push('```');
    L.push('');
    L.push('The path is flat on purpose. The player looks a clip up by step id alone,');
    L.push('so one file serves both the Full and Short Demo. Do not create per-tour');
    L.push('sub-folders because that would duplicate recordings and spend credits twice.');
    L.push('');
    L.push('## Testing a partial pack');
    L.push('');
    L.push('You do not have to finish the pack to test it. Drop in whatever clips you');
    L.push('have; any step without a recording is spoken by the browser voice instead.');
    L.push('Recommended first test: start the Full Demo, then switch Marathi → Hindi');
    L.push('→ English on the same step and confirm the caption and clip both change.');
    L.push('');
    L.push('Check these while it plays:');
    L.push('');
    L.push('- The clip stops before the tour moves on, with no overlap.');
    L.push('- Typing on screen is still going when the sentence describing it is read.');
    L.push('- Pause silences the audio immediately; Resume continues sensibly.');
    L.push('- Switching language mid-tour re-reads the current step and does not');
    L.push('  re-type or re-save anything.');
    L.push('');
    L.push('## If you re-word a step');
    L.push('');
    L.push('Re-record only that clip. Because the file name is the step id, dropping');
    L.push('the new mp3 over the old one is the whole update - there is no timing file');
    L.push('to keep in step.');
    L.push('');
    L.push('Never rename a step id after recording. That orphans the clip, and the');
    L.push('player will silently fall back to the browser voice for that step.');
    L.push('');

    ensureDir(OUT_DIR);
    fs.writeFileSync(path.join(OUT_DIR, 'README.md'), L.join('\n'), 'utf8');
}

function writeManifest(content, clips, totals) {
    const manifest = {
        generated: new Date().toISOString(),
        source: 'application/../_build/assets/js/demo-tour-content.js',
        note: 'Generated file. Edit the tour script, not this.',
        audioPathPattern: '_build/assets/tour/audio/{lang}/{id}.mp3',
        languages: ALL_LANGS,
        budgetUsedForPlan: BUDGET,
        tours: TOURS.reduce((acc, tour) => {
            acc[tour] = {
                steps: content[tour].length,
                stepIds: content[tour].map((s) => s.id),
                charactersByLanguage: ALL_LANGS.reduce((m, lang) => {
                    m[lang] = content[tour].reduce((sum, s) => sum + countChars(pick(s.text, lang)), 0);
                    return m;
                }, {})
            };
            return acc;
        }, {}),
        totalUniqueCharactersByLanguage: totals,
        uniqueClipCount: clips.length,
        clips: clips.map((clip) => ({
            id: clip.id,
            tours: clip.tours,
            screen: clip.url,
            focus: clip.selector,
            performsAction: clip.hasCue,
            savesARecord: clip.isSubmit,
            chapter: clip.chapter,
            title: clip.title,
            narration: clip.text,
            characters: ALL_LANGS.reduce((m, lang) => {
                m[lang] = countChars(clip.text[lang]);
                return m;
            }, {}),
            audio: ALL_LANGS.reduce((m, lang) => {
                m[lang] = '_build/assets/tour/audio/' + lang + '/' + clip.id + '.mp3';
                return m;
            }, {})
        }))
    };

    ensureDir(OUT_DIR);
    fs.writeFileSync(path.join(OUT_DIR, 'manifest.json'), JSON.stringify(manifest, null, 2) + '\n', 'utf8');
}

// ---------------------------------------------------------------------
// Main
// ---------------------------------------------------------------------

function main() {
    const content = loadContent();
    const clips = buildClips(content);
    const gaps = findGaps(clips);

    const totals = {};
    for (const lang of ALL_LANGS) {
        totals[lang] = clips.reduce((sum, c) => sum + countChars(c.text[lang]), 0);
    }

    const batchPlans = {};
    for (const lang of LANGS) {
        writeClipFiles(clips, lang);
        batchPlans[lang] = { all: planBatches(clips, lang, BUDGET) };
        for (const tour of TOURS) {
            writeTourScript(content, clips, lang, tour);
            batchPlans[lang][tour] = planBatches(clipsForTour(content, clips, tour), lang, BUDGET);
        }
    }

    writeManifest(content, clips, totals);
    writeBudget(content, clips, totals, batchPlans, gaps);
    writeReadme(clips, totals);

    // ---- console report ---------------------------------------------
    console.log('');
    console.log('MI-BTrack voice pack exported to  tools/voice_pack/');
    console.log('');
    console.log('  unique clips per language : ' + clips.length);
    for (const tour of TOURS) {
        console.log('  ' + tour.padEnd(5) + ' tour steps          : ' + content[tour].length);
    }
    console.log('');
    console.log('  Language   Characters   Approx. speech   Batches @ ' + BUDGET);
    for (const lang of LANGS) {
        console.log('  ' + LANG_NAME[lang].padEnd(10) +
            String(totals[lang]).padStart(10) +
            mmss(estimateSeconds(totals[lang])).padStart(17) +
            String(batchPlans[lang].all.length).padStart(12));
    }
    console.log('');
    for (const tour of TOURS) {
        const c = content[tour].reduce((s, st) => s + countChars(pick(st.text, 'mr')), 0);
        console.log('  Marathi ' + tour.padEnd(5) + ' tour: ' + String(c).padStart(6) +
            ' characters, about ' + mmss(estimateSeconds(c)) + ' spoken' +
            (c <= BUDGET ? '   [fits selected budget]' : '   [needs more than one batch]'));
    }
    console.log('');

    if (gaps.length) {
        console.log('  ' + gaps.length + ' translation issue(s) listed in BUDGET.md:');
        gaps.slice(0, 8).forEach((g) => console.log('    - ' + g));
        if (gaps.length > 8) { console.log('    ... and ' + (gaps.length - 8) + ' more'); }
        console.log('');
    } else {
        console.log('  All ' + clips.length + ' clips have Marathi, Hindi and English narration.');
        console.log('');
    }

    console.log('  Read tools/voice_pack/README.md before recording,');
    console.log('  and tools/voice_pack/BUDGET.md for the batch plan and licensing note.');
    console.log('');
}

try {
    main();
} catch (err) {
    console.error('');
    console.error('Export failed: ' + err.message);
    console.error('');
    process.exitCode = 1;
}
