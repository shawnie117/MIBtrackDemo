# Android screens mapped into Full Demo

> Update: Full Demo now opens these screens in `connected=1` mode, which persists attendance/ticket events in the same private session as desktop reports. The isolated-memory/no-API limitations below now apply only to standalone practice mode. See [CONNECTED_DEMO_STORY.md](CONNECTED_DEMO_STORY.md) for the current tour behaviour.

## Source and privacy

The six screenshots supplied on 30 September 2026 are visual references only. Their live ticket titles, attendance rows, initials, dates, mobile status bars and banner contact details were not copied into the demo. No original screenshot is served by the app.

The recreation is HTML/CSS/JavaScript, not the native Android app. It preserves the orange/white/gray layout, cards, tabs and principal labels; icons/banner art are simplified. Every screen is labelled “ANDROID UI DEMO · Synthetic records · No live connection”.

## Screenshot mapping

| Reference | Recreated screen | Full Demo mapping |
| --- | --- | --- |
| 1: Login | User ID, masked password, Browse, Forgot Password, Login | F15, after desktop employee credentials |
| 2: Dashboard | Orange toolbar, menu, banner and module grid | F15, after demo OTP verification |
| 3: Daily Attendance | Login/Logout, sample selfie placeholders, times and current-month report | F15, before returning to desktop attendance report |
| 4: My Ticket | Pending/Resolved/Closed tabs and synthetic ticket cards | F17 opening screen |
| 5: Ticket Detail Report | Customer information, service description, status and start details | F17, before and after starting/updating the ticket |
| 6: Add New Ticket | Customer/Lead selector, title, description, priority, employee, date | Accessible from My Ticket’s plus button; F16 remains the existing desktop ticket-creation chapter |

OTP, the expanded side menu, selfie capture, Start Ticket, Update Ticket and client-signature layouts were not supplied. These screens have explicit simulation notices. They follow the approved narration's fields rather than claiming to reproduce unobserved native screens exactly.

## Synthetic story

- Employee: Prajyot, sample user ID `8546951251`, sample password `demo123`.
- Demo OTP: `123456`. No SMS is sent.
- Customer: Adinath Mhaske, using the existing approved demo story. Contact is deliberately non-dialable.
- Ticket: “Visit for service.” Description: “Provide the GPM service properly.”
- Start remark: “Starting Work”. Review: “Service done”. Work type: Service. Final status: Resolved.
- Work photo and signature are clearly labelled synthetic placeholders, not real uploads or signatures.
- Attendance uses today's date and illustrative 09:00 AM / 06:00 PM times, never the live attendance rows.

## Boundaries

- No API requests, file uploads, camera access, location permission, calls, credential storage or OTP delivery.
- State lives only in the mobile page's memory and resets on reload/replay. It is not persisted to the vendor mock backend.
- F15's subsequent desktop attendance report and F18's desktop resolved-ticket example are existing seeded examples, not evidence that the mobile simulation updated those backend records.
- Login Browse/Forgot Password explain the demo limitation. Other dashboard modules point the presenter back to the desktop tour.
- Add New Ticket is a labelled practice form. Its Submit does not claim to save a record; the guided flow uses the built-in ticket.
- Short Demo content and vendor desktop layout are unchanged. Existing recordings and approved scripts are unchanged.

## Validation

- F15: 15 completed cues in Marathi, Hindi and English.
- F17: 17 completed cues in Marathi, Hindi and English.
- Both chapter runs: correct caption/audio clip, no missing targets, no fabricated dropdown values, no JavaScript errors or HTTP failures.
- Direct mobile tests: wrong/empty login rejected; sample OTP succeeds; logout requires login attendance; update requires starting the ticket; signature required before submitting; resolved ticket moves between tabs; reload restores Open state; no external HTTP requests.
- Screenshots inspected for dashboard and ticket detail; all reconstructed/simulated screen captures are in `tools/live_shots/android-demo/`.
- Cue positions follow the recording clock. Word-level audio alignment and accent are not independently certified by these browser tests.

## Files and local preview

- `_build/assets/demo-mobile/index.html`
- `_build/assets/demo-mobile/mobile.css`
- `_build/assets/demo-mobile/mobile.js`
- `tools/build_full_demo_content.js` → generated `_build/assets/js/demo-tour-content.js`
- `tools/test_mobile_demo.js`

Preview: `http://127.0.0.1:8765/assets/demo-mobile/index.html`

Run checks from the project root:

```powershell
node tools/test_mobile_demo.js
node tools/audit_full_tour.js mr f15 f17
node tools/audit_full_tour.js hi f15 f17
node tools/audit_full_tour.js en f15 f17
```
