#!/usr/bin/env node
/* Read-only ElevenLabs account probe. Spends nothing.
 * Reads the key from the ELEVENLABS_API_KEY environment variable only -
 * the key is never written to a file in this project. */
'use strict';

const KEY = process.env.ELEVENLABS_API_KEY;
if (!KEY) {
    console.error('Set ELEVENLABS_API_KEY first.');
    process.exit(1);
}

const H = { 'xi-api-key': KEY };

(async () => {
    try {
        const sub = await fetch('https://api.elevenlabs.io/v1/user/subscription', { headers: H });
        if (!sub.ok) {
            console.error('subscription lookup failed: HTTP ' + sub.status + ' ' + (await sub.text()).slice(0, 300));
            process.exit(1);
        }
        const s = await sub.json();
        const used = s.character_count;
        const limit = s.character_limit;
        console.log('== account ==');
        console.log('  tier            : ' + s.tier);
        console.log('  characters used : ' + used);
        console.log('  character limit : ' + limit);
        console.log('  REMAINING       : ' + (limit - used));
        console.log('  resets          : ' + (s.next_character_count_reset_unix
            ? new Date(s.next_character_count_reset_unix * 1000).toISOString().slice(0, 10) : 'unknown'));
        console.log('  can extend      : ' + s.can_extend_character_limit);

        const models = await fetch('https://api.elevenlabs.io/v1/models', { headers: H });
        if (models.ok) {
            const list = await models.json();
            console.log('');
            console.log('== models that can speak English, Hindi and Marathi ==');
            for (const m of list) {
                const langs = (m.languages || []).map((l) => l.language_id);
                const hasEn = langs.includes('en');
                const hasHi = langs.includes('hi');
                const hasMr = langs.includes('mr');
                const factor = m.model_rates && m.model_rates.character_cost_multiplier;
                console.log('  ' + (m.model_id || '').padEnd(30) +
                    ' en:' + (hasEn ? 'Y' : '-') +
                    ' hi:' + (hasHi ? 'Y' : '-') +
                    ' mr:' + (hasMr ? 'Y' : '-') +
                    '  cost x' + (factor === undefined ? '?' : factor) +
                    (m.can_do_text_to_speech ? '  tts' : '  (no tts)'));
            }
        } else {
            console.log('model list failed: HTTP ' + models.status);
        }

        const voices = await fetch('https://api.elevenlabs.io/v1/voices', { headers: H });
        if (voices.ok) {
            const v = await voices.json();
            console.log('');
            console.log('== voices available (' + v.voices.length + ') ==');
            v.voices.slice(0, 25).forEach((x) => {
                const labels = x.labels || {};
                console.log('  ' + x.voice_id + '  ' + (x.name || '').padEnd(18) +
                    ' ' + [labels.accent, labels.gender, labels.age, labels.use_case]
                        .filter(Boolean).join(', '));
            });
        }
    } catch (err) {
        console.error('probe failed: ' + err.message);
        process.exit(1);
    }
})();
