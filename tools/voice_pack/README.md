# MI-BTrack demo narration - recording pack

Everything in this folder is generated. Do not edit it by hand.
The wording lives in `_build/assets/js/demo-tour-content.js`; change it
there and run the exporter again:

```bash
node tools/export_tour_voice_pack.js
```

## What is here

```text
BUDGET.md              character counts and a batch plan
manifest.json          every clip, machine readable
<lang>/script-full.txt  read-through script for the 23-step Full Demo
<lang>/script-short.txt read-through script for the 12-step Short Demo
<lang>/clips/<id>.txt  one file per clip, narration only
```

`23` unique clips per language.

## Recording settings

The listener may be new to computers, so clarity matters more than
personality.

| Setting | Value | Why |
|---|---|---|
| Format | MP3, 44.1 kHz or better | what the player expects |
| Voice | warm, clear female guide | easy for first-time users to follow |
| Speed | 0.95 to 1.0 | unhurried, easy to follow |
| Stability | medium-high | keeps 60+ clips sounding alike |
| Leading silence | under 250 ms | the clip starts as the step starts |
| Trailing silence | under 400 ms | the player advances on clip end |
| Music or effects | none | they would fight the live screen |

Say these as separate letters, not as words: **M-I-B-Track**, **A-M-C**,
**C-C-T-V**, **G-S-T**. Keep these in English in all three languages so
the product never sounds like two different things: `MI-BTrack`, `AMC`, `CCTV`, `GST`, `Aster Heights Annex`, `Aster CCTV Annual Care`.

Use a model that explicitly supports the language being generated. The
replacement pack uses Eleven v4 Turbo for Marathi, Hindi and English, with
the Bella premade voice. The free-tier API cannot render Voice Library voices,
so a paid plan or an approved recording would be needed for a native Marathi
speaker. Do not regenerate Marathi with an English-only v2 model.

## Where to put the finished files

```text
_build/assets/tour/audio/en/<step-id>.mp3
_build/assets/tour/audio/hi/<step-id>.mp3
_build/assets/tour/audio/mr/<step-id>.mp3
```

The path is flat on purpose. The player looks a clip up by step id alone,
so one file serves both the Full and Short Demo. Do not create per-tour
sub-folders because that would duplicate recordings and spend credits twice.

## Testing a partial pack

You do not have to finish the pack to test it. Drop in whatever clips you
have; any step without a recording is spoken by the browser voice instead.
Recommended first test: start the Full Demo, then switch Marathi → Hindi
→ English on the same step and confirm the caption and clip both change.

Check these while it plays:

- The clip stops before the tour moves on, with no overlap.
- Typing on screen is still going when the sentence describing it is read.
- Pause silences the audio immediately; Resume continues sensibly.
- Switching language mid-tour re-reads the current step and does not
  re-type or re-save anything.

## If you re-word a step

Re-record only that clip. Because the file name is the step id, dropping
the new mp3 over the old one is the whole update - there is no timing file
to keep in step.

Never rename a step id after recording. That orphans the clip, and the
player will silently fall back to the browser voice for that step.
