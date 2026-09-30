# MI-BTrack Guided Demo — Tour and Voice Pack

**Updated:** 8 September 2026
**Status:** Runtime rebuilt, narration written in three languages, audio generated.

This document describes the guided tour as it now stands. It replaces the
earlier concept version, which described an intended design rather than a
working one.

---

## 1. What the tour is

Not a screen recording and not a redrawn copy. The real vendor pages load,
unmodified, inside an iframe, and the tour drives that page's own controls:
it types into the real fields, fires the page's own change handlers so
dependent drop-downs load, presses the real Submit button, and waits for
the page's own confirmation message before it says anything was saved.

Three stories, sharing one narration set:

| Tour | Steps | What it covers |
|---|---:|---|
| **AMC** | 39 | Orientation, why master lists come first, building a service plan field by field, confirming the save, the whole contract book, a contract through its year |
| **Sales** | 30 | Orientation, recording an enquiry field by field, what happens after it saves, customers, money and service |
| **Full** | 64 | Everything above plus people and permissions |

Launch from the dashboard, or directly:

```text
vendor/dashboard/tour?tour=amc&lang=en
vendor/dashboard/tour?tour=core&lang=hi
vendor/dashboard/tour?tour=full&lang=mr
```

Both query parameters are whitelisted in `Dashboard::tour()`. An unknown
value falls back to `core` / `en` rather than producing a page the player
cannot serve.

---

## 2. Who it is written for

The listener may never have used a CRM, and may not be comfortable with
online forms at all. Every step answers four questions:

1. **Where are we?** — "This screen holds a master list."
2. **Why does it exist?** — "A master list is a list you type once and then
   choose from again and again."
3. **What are we entering?** — the label, whether it is required, and an
   example.
4. **What happens next?** — which record becomes available, and where it
   will appear.

Writing rules the script follows:

- Short sentences, everyday words, no contractions (clearer for text to
  speech and for non-native listeners).
- Every term defined on first use: lead, AMC, master, ticket, reference,
  priority, renewal.
- Never "just click". Never assumes an icon is recognised.
- Always says whether a box is required, optional, calculated, or chosen
  from earlier setup.
- Explains *why* a drop-down is empty and which screen fills it.
- Never announces success before the real confirmation appears on screen.

Two examples of the tone, taken verbatim from the script:

> Please listen carefully to this one, because it is the mistake people make
> most often. This box is measured in days, not months. If you type twelve
> here, thinking twelve months, you will have created a plan that expires in
> twelve days. One year is three hundred and sixty five, so that is what we
> type.

> Look at this box. Nobody typed in it. The software divided three hundred
> and sixty five days by four visits and wrote ninety two, which is the gap
> in days between one visit and the next. It is greyed out on purpose so it
> can never disagree with the two numbers above it.

---

## 3. Original UI is untouched

The tour adds nothing to the vendor pages. Verified by MD5 against
`MIBtrackShawn`:

| File | Status |
|---|---|
| `masters/add_edit_amc.php` | identical |
| `masters/list_amc.php` | identical |
| `masters/view_amc.php` | identical |
| `leads/add_edit_lead.php` | identical |
| `admin/add_edit_employee.php` | identical |
| `customers/add_edit_ticket.php` | identical |

Only three files differ from the original, all for demo-only reasons:
`dashboard.php` (tour launcher panel), `_parts/header.php` and
`_parts/footer.php` (jQuery ordering and the workflow-guidance script).

All tour styling lives in `assets/css/demo-tour.css`, which styles the shell
around the iframe and never anything inside it.

---

## 4. Story data

Both records are created by filling in and submitting the real forms. Every
other record the tour shows is part of the demo's seeded sample data, and
the narration says so.

**AMC plan** — created on `masters/add_amc`

| Field | Value |
|---|---|
| Product | CCTV Dome Camera 2MP (`3001`) |
| AMC name | Aster CCTV Annual Care |
| Duration | 365 days |
| Number of services | 4 |
| Service interval | 92 (calculated by the page) |
| GST | 18 |
| Regular / Commercial | 12,000 / 15,000 |

**Enquiry** — created on `leads/add_lead`

| Field | Value |
|---|---|
| Name | Aster Heights Annex |
| Mobile | 9800091001 |
| Priority | High |
| Enquiry for | CCTV Dome Camera 2MP |
| Company | Aster Heights Annex Co-op Society |
| Contact person | Mr. Deshpande |
| Email | annex@aster.example |
| Address | Plot 14, Sector 21, Kharghar |
| State / District / City | Maharashtra / Raigad / Navi Mumbai |
| Area / Pin | Kharghar / 410210 |
| Source | Website Enquiry |

All of it synthetic.

---

## 5. How the runtime works

`_build/assets/js/demo-tour.js`. Six rules it is built on:

1. **Honesty.** Never claims a save until the page shows its own
   confirmation. Steps that only explain a screen say so.
2. **One epoch, one step.** Every transition bumps an epoch counter, and
   every asynchronous continuation checks it before touching the DOM.
   Nothing from an abandoned step can survive.
3. **Everything is disposable.** Timers, intervals, animation frames, audio
   handlers, speech handlers and iframe load handlers are all registered for
   teardown and disposed on every transition.
4. **Pause means pause.** A pause gate is awaited between every
   micro-operation, including between two typed characters. Pause freezes a
   half-typed word; Resume continues from that character.
5. **Save once.** Real submits are recorded in `sessionStorage` against a
   checkpoint key. Previous, language switch and replay can never resubmit.
6. **No invisible writes.** The runtime performs no background data
   mutation at all.

### Cue kinds

| Kind | What it does |
|---|---|
| `note` | explains only, changes nothing |
| `type` | types character by character, firing `keydown` / `input` / `keyup` per character and `change` + `blur` at the end |
| `select` | sets a real option and fires `change`, so dependent lists load; waits for them if asked |
| `click` | presses a real control |
| `expand` | opens a collapsed section and waits for its contents |
| `submit` | presses the real Submit button, then verifies the real confirmation text |

The event sequence in `type` is not decoration. The AMC form recalculates
its service interval from an inline `onchange`, and its name box shows an
"already exists" helper on `keyup`. Setting `.value` alone would leave the
page looking filled in but internally untouched.

### What was wrong before, and what fixed it

| Old behaviour | Now |
|---|---|
| Hidden `tour_action` writes, re-fired by Previous and by language change | No hidden writes at all. Real forms, or seeded data honestly described |
| Typing used an uncancellable `setInterval` | Typing awaits the pause gate per character and is disposed on transition |
| Spotlight added the iframe viewport offset on top of stage coordinates, landing ~58px low | Coordinates converted as `(frameRect − stageRect) + elementRect`, then followed per animation frame |
| Fixed 350 ms wait before measuring, so long scrolls were measured mid-flight | Waits for three consecutive stable frames |
| Missing mp3 fired both `onerror` and a rejected `play()`, double-advancing | Single `settled` flag guarantees one outcome per step |
| `speechSynthesis.cancel()` fired `onend`, advancing the tour | `cancelling` flag makes the cancel event ignorable |
| Speech failure could stall the tour forever | Watchdog timer resolves the step |
| Resume restarted narration from the beginning | Resume continues; a separate **Say again** button replays deliberately |
| Missing selector ignored in silence | Stops with a plain-language recovery panel and a link to the screen that fixes it |
| Reset promised to clear only tour changes, actually cleared everything | Renamed **Clear demo records**, and says plainly what it clears |
| Autoplay blocked, so step one was silent | Explicit **Start the tour** button provides the user gesture browsers require |

### Controls

Previous · Pause/Resume · Next · Say again · Take control · Language ·
Pace (slow/normal/fast) · Clear demo records · Exit.

Previous, language switch, Say again and returning from Take control all
replay narration with cues skipped, so none of them can retype or resave.

---

## 6. Backend work this required

The tour submits real forms, so the forms had to actually work. Added to
`_build/application/libraries/MockData.php`:

- `setCustomerLeadMasterDetails` — creates a lead, refuses a duplicate
  mobile with `MOBILE_EXISTS`, returns the envelope `Leads::add_lead()`
  expects
- `setModifyCustomerLeadMasterDetails` — edit path
- `getCustomerLeadMasterDetails` — lead detail for `leads/view_lead`
- `leadRow()` / `hydrateLead()` — resolve state, district, city, reference
  and product names, and fill every key the detail view reads

Before this, `setCustomerLeadMasterDetails` was unimplemented and the
enquiry form failed silently into the missing-mock log.

---

## 7. Audio

### Layout

```text
_build/assets/tour/audio/en/<step-id>.mp3
_build/assets/tour/audio/hi/<step-id>.mp3
_build/assets/tour/audio/mr/<step-id>.mp3
```

Flat, keyed on step id alone. One recording serves the AMC, sales and full
tours. Per-tour folders would have tripled the bill for no benefit.

A missing clip is spoken by the browser voice, so a partial pack is fully
demonstrable and nothing breaks.

### Generation

| Setting | Value | Why |
|---|---|---|
| Model | `eleven_v3_conversational` | the only model on these accounts covering English, Hindi **and** Marathi, and it bills at a **0.5×** character multiplier |
| Voice | `hpp4J3VqNfWAUOO0d1Us` (Bella) | professional, bright, warm; tagged for informative and educational use |
| Format | `mp3_44100_128` | |
| Stability | 0.55 | keeps 66 clips sounding like one session |
| Style | 0.0 | no dramatisation over a live screen |
| Speed | 0.96 | slightly unhurried |

Measured cost, confirmed against the account history: **280 characters
billed 140 credits.** The 0.5× multiplier is real, and it is what makes the
complete trilingual pack fit inside free monthly allowances.

| Language | Clips | Characters | Credits at 0.5× |
|---|---:|---:|---:|
| English | 66 | 18,357 | 9,195 |
| Hindi | 66 | 15,870 | 7,949 |
| Marathi | 66 | 15,673 | 7,851 |
| **Total** | **198** | **49,900** | **24,995** |

### Tooling

```bash
# regenerate the scripts, manifest and budget after any wording change
node tools/export_tour_voice_pack.js

# see the plan and cost without spending anything
node tools/generate_tour_audio.js --lang all

# generate
$env:ELEVENLABS_API_KEYS = 'sk_one,sk_two,sk_three'
node tools/generate_tour_audio.js --go --lang all
```

The generator is a dry run by default. It pools multiple keys and fails
over when one is exhausted, holds a reserve back on each, skips clips
already on disk so an interruption never pays twice, and writes
`tools/voice_pack/generated.json` after every clip. Spend is **measured**
from the account before and after, not estimated.

Spending priority is the AMC tour first, then what the sales tour adds,
then what only the full tour adds. If a budget runs out, what exists is a
complete presentable tour rather than three half-finished ones.

Keys are read from the environment only. Nothing in this project stores a
key; the ledger records only the last four characters so runs can be told
apart.

### Licensing — read before using this commercially

Free-plan ElevenLabs output carries **no commercial rights**, requires
attribution if published, and upgrading later does **not** retroactively
license audio generated while on the free plan.

So the current pack is fine for internal review and rehearsal. Regenerate
it under a paid plan before showing it to a customer. Verify current terms
yourself:

- <https://elevenlabs.io/pricing>
- <https://help.elevenlabs.io/hc/en-us/articles/13313564601361-Can-I-publish-the-content-I-generate-on-the-platform>
- <https://elevenlabs.io/docs/overview/models>

_Terms summarised from those pages; they may have changed._

---

## 8. Verification

`node tools/verify_tour.js` (with the demo server running) checks:

- **A** content integrity — every step has an id, url and three languages;
  every cue kind is one the runtime implements; every submit has a
  checkpoint and an expected confirmation
- **B** the runtime and the shell agree on all 28 element ids, the spotlight
  is positioned correctly, and the runtime performs no hidden writes
- **C** every page the tour opens returns HTTP 200 with no PHP error
- **D** every step and cue selector is really present in that page's HTML
- **E** both real forms save and print the exact sentence the tour waits
  for, and the duplicate guard fires

Result at the time of writing: **34 passed, 0 failed, 0 unconfirmed.**

### Still needs a human with a browser

The checks above are static and HTTP-level. These cannot be automated
without a headless browser, and should be walked through before a customer
demo:

```text
[ ] Start the tour and confirm audio plays on the first step
[ ] Pause mid-typing: the word freezes, nothing else moves
[ ] Resume: typing continues from that character, narration does not restart
[ ] The spotlight sits exactly over its target while the page scrolls
[ ] Switch language mid-tour: it re-reads, and does not retype or resave
[ ] Previous over the AMC submit step: no second plan is created
[ ] Take control, navigate by hand, then Return: the tour recovers
[ ] Point a step at a deliberately wrong selector: the recovery panel appears
[ ] Clear demo records, then replay: the forms submit again cleanly
[ ] Each clip finishes before the tour advances
```

---

## 9. Presenting it

1. Start the demo server and sign in as `demo` / `demo123`.
2. Open the dashboard and pick a tour.
3. Choose the language before pressing Start.
4. Press **Start the tour**. Audio needs that click; browsers block sound
   that did not follow a user gesture.
5. Use **Pace** if the room needs it slower.
6. **Take control** to answer a question on the live screen, then return.
7. **Clear demo records** between audiences for a clean run.

Never point this at the live `mibtrack.co.in` session. The tour and its
session-only writes exist in `MIBtrackDemo` alone.
