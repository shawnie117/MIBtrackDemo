# Guided tour narration

Generated audio. One MP3 per tour step, per language.

```text
en/<step-id>.mp3     English
hi/<step-id>.mp3     Hindi
mr/<step-id>.mp3     Marathi
```

**23 clips per language, 69 files.** Replaced on 29 September 2026 with
Eleven v4 Turbo and the Bella guide voice. Full and Short Demo share clips.

## Why the layout is flat

The player resolves a clip from the step id alone, so one recording serves
the AMC, sales and full tours. Per-tour sub-folders would triple the
recording cost for no benefit. Do not add them.

## If a clip is missing

The player falls back to the browser's own speech engine, so the step is
still explained out loud. A partial pack is fully demonstrable.

## Do not rename a step id

The file name *is* the step id. Renaming a step in
`_build/assets/js/demo-tour-content.js` orphans its recording, and that
step silently drops to the browser voice. `node tools/verify_tour.js`
reports orphaned clips if it happens.

## Regenerating

Wording lives in `demo-tour-content.js` — the single source of truth. After
changing it:

```bash
node tools/export_tour_voice_pack.js          # refresh scripts and manifest
node tools/generate_tour_audio.js --lang all  # see the cost, spend nothing
```

Then delete only the clips whose wording changed and re-run with `--go`.
Existing files are skipped, so you pay for the changed sentences alone.

## How these were made

| | |
|---|---|
| Model | `eleven_v3_conversational` (English, Hindi and Marathi at a 0.5x character multiplier) |
| Voice | `hpp4J3VqNfWAUOO0d1Us` — Bella, professional and warm, tagged for educational use |
| Format | MP3 44.1 kHz 128 kbps |
| Stability / Style / Speed | 0.55 / 0.0 / 0.96 |
| Measured cost | 20,395 credits for 198 clips |

Ledger of every clip and run: `tools/voice_pack/generated.json`.

## Licensing

These were generated on ElevenLabs **free** plans, which carry **no
commercial rights**. Fine for internal review and rehearsal. Regenerate
under a paid plan before showing this to a customer — upgrading does not
retroactively license audio made while on the free plan.

See `DEMO_TOUR_VOICE_PACK.md` section 7 for the full note and sources.
