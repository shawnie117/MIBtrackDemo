# Full Demo review — 30 September 2026

> Follow-up: Android screenshot references were subsequently supplied. F15 and F17 now use a labelled local mobile simulation. See [ANDROID_DEMO_MAPPING.md](ANDROID_DEMO_MAPPING.md) for current coverage and test results. The original findings below are retained as the pre-mobile audit; backend persistence and exact word-level alignment limitations still apply.

## Result and scope

The Full Demo player was reviewed and repaired locally. **This is not a certification that every spoken claim has a matching working workflow.** Playback checks and business-workflow checks are separate below.

Vendor styling and layout were preserved. Short Demo content was preserved separately when rebuilding Full Demo. Existing audio and approved narration were not regenerated or rewritten. Tests used separate browser sessions, not the presenter's logged-in session. Tests do not submit the practice forms or send WhatsApp messages.

## Repairs

- Replay, Previous, language switching, Retry and Return to tour now replay Full Demo screen actions alongside the recording. Previously several controls restarted only the audio.
- Full Demo reloads each chapter's initial page. F07 rebuilds its own lead name instead of depending on the previous chapter's leftover form.
- Removed double application of playback speed to typing and click delays.
- Errors cancel the active scene and stop narration. Missing/blocked audio now raises an actionable error instead of silently using a different browser voice or running without speech.
- Chapter completion respects Pause.
- Only the current highlighted element owns the spotlight tracking loop. Earlier fields no longer keep competing to reposition it. Resizing uses the current target.
- Full Demo no longer manufactures a dropdown option when a required record is missing.
- Routine is now a real customer-follow-up option in the demo forms, matching the approved narration.
- F09 highlights today's follow-ups and opens the lead enquiry field.
- F10 now selects General Pest Management, opens its service-detail modal, shows the calculated total, selects Cash and enters 1000. It also enters today's customer date. The regular-price/GST example calculates 2360.
- F13 enters the follow-up date/time; F16 enters the ticket date/time. These use today's date, not an expired hard-coded date.
- F21 highlights the employee selector, lead/follow-up/ticket/payment tables and date filter.
- F22 highlights conversion metrics, employee performance, activity log and ROI tables.
- F23 opens the report groups in narration order instead of leaving every group collapsed.
- Employee KYC/photo defaults and ticket reopened-date defaults no longer emit missing-array-key PHP warnings.

## What was checked

Completed results: 23/23 chapters passed the automated playback run in Marathi, Hindi and English. Changed customer/date scenes were rerun separately in all three languages. Playback-control and missing-target recovery tests passed. JavaScript syntax checks and PHP lint checks passed; the final inspected PHP log tail contained no new warnings/errors.

Automated browser runs exercise the real recorded clips at the supported 3× speed. Each chapter checks its caption, matching language/chapter audio URL, positive audio duration, completion of configured cues, JavaScript errors, HTTP failures and absence of fabricated dropdown values. Screenshots and JSON evidence are saved under `tools/live_shots/full-audit-*`.

Separate control tests cover Replay, Previous, Pause/Resume, three language changes, Take control/Return, missing recording recovery, missing target recovery, Retry and Skip. They use the actual visible controls.

All 69 source voice-script text files match the approved Marathi text and Hindi/English translations. This proves text consistency **only**: it does not transcribe or independently verify the MP3 speech.

Additional F10 assertions check a populated date, nonzero computed price and payment amount 1000. F13 checks Routine, Visit and date/time. F16 checks its date/time.

The ticket summary fallback was inspected: it shows eight seeded tickets, six open, one resolved and one closed, with employee totals. Missing optional ranking APIs in the log do not mean that this entire screen is empty.

## Chapter coverage and remaining workflow gaps

| Chapter | Current on-screen coverage | Remaining qualification |
| --- | --- | --- |
| F01 | Dashboard and recorded introduction | No business action |
| F02–F05 | Master setup pages and example names | Not every setup field is filled; no save/report round trip |
| F06–F07 | Dashboard → lead creation → reference and alternate contact | Practice form; not a completed saved lead |
| F08 | Styled lead follow-up modal and typed discussion | Not submitted |
| F09 | Dashboard follow-ups → lead enquiry field | Explanation, not a conversion transaction |
| F10 | Customer, AMC selection, schedule modal, calculated price and cash payment | Practice form; not submitted; sample GST placeholder is not a valid real GST number |
| F11 | Customer service controls → reminders → payment controls | Highlights cancel/schedule/payment rather than performing those transactions |
| F12 | Customer invoice/download control | PDF output and WhatsApp delivery are not demonstrated or validated; invoice mock API is missing |
| F13 | Follow-up discussion/status/purpose/Visit/date | Not saved back to the dashboard |
| F14 | Employee details and setup fields | Submit is highlighted, not executed |
| F15 | Desktop employee credentials and attendance report | **Android download/login/OTP/selfie screens are absent from this project** |
| F16 | Ticket fields, assignment and date | Submit is highlighted, not executed |
| F17 | Desktop ticket detail and resolve control | **Narration describes Android My Tickets, Start Ticket, Update Ticket, photo and signature; these mobile screens are absent** |
| F18 | Seeded resolved ticket/review → ticket summary | Uses a separate resolved example, not a demonstrated state change of the F16/F17 ticket; no real photo/signature evidence |
| F19 | Quotation fields, AMC and description | Not submitted; terms API is not implemented |
| F20 | Quotation report | Edit/follow-up/next-call actions are narrated but not driven; quotation detail mock API is missing |
| F21 | Daily analysis sections and date filter | Does not change and verify every filter combination |
| F22 | Market analysis metrics and tables | Seeded analytics, not proof of newly created records flowing through reports |
| F23 | Report groups expand in narration order | Does not test every linked report |

## Before calling the demo presentation-ready

1. Obtain the actual Android app screens/recording for F15 and F17, or approve a clearly labelled simulation. Do not present desktop pages as the Android app.
2. Complete the remaining local mock workflows, particularly invoice output and quotation detail/follow-up. Exercise save → report → detail round trips using session-owned sample records and replay-safe checkpoints.
3. Demonstrate one ticket through creation, work start, update and resolution instead of jumping between two separate examples.
4. Have a fluent Marathi speaker review the actual recordings for accent/pronunciation and sentence-to-screen timing. Current cue positions are approximate fractions of clip duration, not word-alignment timestamps. They follow the recording clock, but exact spoken-word synchronisation is not certified.
5. Run a final real-time 1× presentation review after those content/workflow gaps are closed. Current automated full runs use 3×; controls are also checked at 1×.

## Repeatable checks

From the project root with the local PHP server running:

```powershell
node tools/build_full_demo_content.js
node tools/audit_full_tour.js mr
node tools/audit_full_tour.js hi
node tools/audit_full_tour.js en
node tools/test_full_playback_controls.js
node tools/test_full_error_recovery.js
```

Targeted example: `node tools/audit_full_tour.js mr f10 f13 f16`.

The scripts use the project's existing Puppeteer dependency and installed Chrome. Screenshots and reports remain available for inspection; repeating the same run replaces that run's evidence. An automated PASS means the configured scene played successfully; it does not erase the qualifications above.
