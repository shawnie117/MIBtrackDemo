# Connected mobile/desktop demo story

## Implemented

F15–F18 now share session-only records through `Dashboard::story` and `DemoStory`. This fixes the specific disconnected data boundary found in `FULL_DEMO_RECHECK.md`; it does not certify the unrelated invoice/quotation workflows or voice pronunciation.

- F15 prepares a tour-owned attendance slot. Mobile Login/Logout save it, and the desktop attendance report reads it. The matching built-in seed example is hidden to avoid a duplicate employee/day; trainee-created attendance is preserved.
- F16 saves the prescribed ticket example to the private session at its final save cue. This is a dedicated tour save, not submission of the general desktop form.
- F17 prepares the same ticket ID for a fresh demonstration, saves the start remark, then persists review, description, work type, Open/Resolved status and sample photo/signature flags.
- F18 resolves the session's ticket ID through `dashboard/story_ticket`. It no longer substitutes pre-resolved ticket 9108. The review, resolved status and labelled demo signature appear in the normal desktop detail view and the report reads the same ticket row.

## Isolation and replay

`$_SESSION['demo_story']` holds owned rows separately from `demo_overlay`. `MockSeed::table()` exposes those rows to the existing desktop mock API. No production API or real database is used.

Identifiers are allocated after existing seed and manual IDs. Preparing/replaying a chapter reuses the tour's ID, replaces only its owned row, and does not clear manually created records. Repeated submit requests update one row/review rather than appending duplicates. Attendance preparation and ticket preparation are independent.

The pre-existing **Clear demo records** button still deliberately clears all private session changes after confirmation. That broad reset is not used by Replay.

## Safety and failures

- Existing vendor login is required by the server controller.
- GET returns session state and a random session token; POST requires that token.
- Server validates action ordering, required text, status and work type.
- IDs and employee/customer ownership are chosen by the server, not accepted from mobile input.
- Mobile waits for a successful save before showing the completed state. Request failures surface in the scene; the tour waits for pending mobile requests and reports errors.
- Requests have a 10-second timeout. Saves remain synthetic; no SMS, camera capture, actual signature, call or production write occurs.
- The tour uses `connected=1`. Opening the plain mobile preview without it remains an isolated practice mode that resets on reload.

## Tests

Completed: F15–F18 passed in Marathi, Hindi and English; PHP store tests, connected desktop/mobile browser tests, standalone mobile tests and playback-control regression tests passed. Desktop screenshots were visually inspected. This is verification of the affected flow, not a fresh certification of every chapter or audio pronunciation.

```powershell
php tools/test_demo_story.php
node tools/test_connected_story.js
node tools/test_mobile_demo.js
node tools/audit_full_tour.js mr f15 f16 f17 f18
node tools/audit_full_tour.js en f15 f16 f17 f18
node tools/audit_full_tour.js hi f15 f16 f17 f18
```

The PHP test covers ID collisions, duplicate saves, replay, preservation of a manually created ticket, attendance ordering and cross-session isolation. The connected browser test checks mobile writes in actual desktop pages, matching ticket ID/review/status/signature, state after reload, separate authenticated browser sessions, token rejection and action ordering. Screenshots are in `tools/live_shots/connected-story/`.

## Remaining qualifications

The Start/Update/OTP/selfie/signature screens remain labelled recreations. Attendance times are illustrative 09:00/18:00 values, and images/signatures are placeholders. F16 saves the approved example rather than arbitrary presenter edits. The normal practice Add New Ticket mobile form is still non-persisting. Other previously noted invoice, quotation and narrated-but-unsubmitted form gaps remain outside this connection fix. Audio cue ratios are unchanged; exact word-level alignment and pronunciation have not been independently certified.
