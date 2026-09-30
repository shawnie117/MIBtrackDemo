# Full Demo recheck — 30 September 2026

> Subsequent fix: the disconnected F15–F18 boundary described in this historical audit has now been implemented and tested. See [CONNECTED_DEMO_STORY.md](CONNECTED_DEMO_STORY.md). Other qualifications below still apply.

## Verdict

**Not yet verified as a fully connected, presentation-ready demo.** The mobile screens work as an isolated simulation, but they do not update the desktop demo records. A successful narration/cue playback test must not be described as end-to-end workflow success.

This recheck stopped at that confirmed data boundary, following the full-story verification procedure. It was not a new complete 23-chapter certification. No application code was changed during this recheck. The local PHP server and the user's logged-in browser were left running.

## Story being checked

The presenter starts Full Demo → narration drives desktop and mobile actions → those actions update demo records → the following desktop reports show those same records and outcomes.

## Current evidence

| Boundary | Result | Evidence |
| --- | --- | --- |
| Initial chapter rendering/audio/cues | Passed for F01–F09 in the Marathi and English runs | Both runners printed PASS for those chapters before being stopped |
| Standalone mobile interactions | Passed | `node tools/test_mobile_demo.js` passed sample login/OTP, attendance ordering, ticket start/update/signature, resolved-tab movement and reset |
| Mobile isolation | Passed, intentionally | Mobile test found no external HTTP requests or JavaScript errors; original live ticket titles are absent |
| Replay and Pause/Resume | Passed in this run | Control test printed both PASS messages before the broader recheck was stopped |
| Mobile → demo backend | **Missing** | Mobile handlers change the page-local `state` object only. No API request or persistent shared state is used |
| Desktop report reflects mobile result | **Not connected** | The desktop mock seed keeps “Visit for service.” / 9107 Open. F18 opens the separately seeded resolved ticket 9108 |
| Complete full rerun | Not completed | Marathi/English runners were deliberately stopped; Hindi was not rerun in this recheck |
| Spoken-word timing / Marathi pronunciation | Not certified | Browser checks verify matching clip paths and cue timing against the clip clock, not the actual spoken words or accent |

Previously completed full playback tests remain historical evidence, not a replacement for this missing data-flow check. Existing JSON reports may be from previous runs; the stopped runs must not be inferred to have completed from those files.

## Confirmed blocker: ticket continuity

1. F16 fills the desktop ticket form and highlights Submit; it does not submit it.
2. F17 opens an independent mobile simulation of “Visit for service.”
3. Mobile Submit changes `state.status` to `state.pendingStatus`, then redraws that mobile page.
4. This state disappears when the page reloads. The desktop mock backend is not updated.
5. F18 opens `vendor/customers/view_ticket?id=OTEwOA%3D%3D`, which is ticket 9108, not 9107.
6. Ticket 9108 is pre-seeded as “GPM service completed”, Resolved. Ticket 9107 remains “Visit for service.”, Open.

Therefore, the viewer sees a resolved example, but has not witnessed the same ticket being saved, worked on and resolved across the two interfaces.

Source evidence:

- `_build/assets/demo-mobile/mobile.js`: `submit-ticket` changes local state; `submit-selfie` changes local attendance flags.
- `tools/build_full_demo_content.js`: F16 ends with a focus cue; F18 navigates to the separate resolved record.
- `_build/application/libraries/MockSeed.php`: the separate 9107/Open and 9108/Resolved seed rows.

## Attendance has the same limitation

F15's sample selfies and 09:00 AM / 06:00 PM attendance are local illustrations. The desktop attendance report that follows is independently seeded. It is not reading an attendance event saved by the mobile simulation.

## Other known qualifications still outstanding

These come from the preceding documented audit, not new completed tests during this stopped run:

- Many creation chapters demonstrate fields without submitting and verifying a saved record.
- F11 shows cancellation/scheduling/payment controls without completing those transactions.
- F12 does not verify invoice PDF output or WhatsApp delivery.
- F19 does not save the quotation; terms data is incomplete.
- F20 does not drive quotation editing, follow-up or next-call scheduling.
- OTP, selfie capture, ticket update and signature screens are labelled approximations where native screenshots were not supplied.
- Some mobile dashboard buttons and Add New Ticket are intentionally reference/practice-only controls.

See `FULL_DEMO_QA_2026-09-30.md` for the original chapter-by-chapter qualifications and `ANDROID_DEMO_MAPPING.md` for the mobile recreation's explicit boundaries.

## Recommended correction before the next full certification

1. Introduce a session-scoped local demo store shared by desktop and mobile. Keep it isolated from production and from other visitors.
2. Map the story to stable demo identifiers: employee, customer, attendance event and one ticket.
3. Save mobile attendance and ticket transitions to that store through validated local endpoints.
4. Make the following desktop reports read those same records. Do not substitute a second pre-resolved ticket.
5. Keep replay idempotent: repeat or reset only tour-owned records, without deleting the presenter's manually added demo data.
6. Complete the remaining narrated save/report/download flows, or explicitly label them as explanations.
7. Then rerun all chapters, controls and error cases in all three languages, plus a real-time 1× listening review.

The immediate priority is **shared demo data and record continuity**, not additional visual polish.
