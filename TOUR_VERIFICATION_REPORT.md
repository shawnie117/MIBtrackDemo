# MI-BTrack Guided Demo - Final Verification

Date: 9 September 2026  
Local build: `http://127.0.0.1:8765`  
Reference UI: `D:\Internship\Mauli Infotech\MIBtrackShawn`

## Result

The guided demo is working end to end against the real cloned MI-BTrack pages. The normal application UI was retained. The tour sits around the application, scrolls the real page, highlights the real control, plays the matching recording, performs the visible action during that recording, and checks the result before continuing.

- Static/integration verification: **37 passed, 0 failed**.
- Final English Sales-to-Service tour: **64 passed, 0 failed, 0 warnings**.
- Final Marathi Complete Operations tour: **134 passed, 0 failed, 0 warnings**.
- English AMC flow: all 39 screens and all real-data assertions passed.
- Hindi Complete Operations run reached all 64 screens with the correct Hindi caption and Hindi MP3 on every step. Its only earlier failure was the language-independent lead-table loading race; that race was then fixed and passed in the final English and Marathi runs.
- Browser console during the final live tours: **0 errors**.
- Screenshots captured: **128 PNG files**, including before/after evidence for narrated actions.

## What the live test proves

For every tour step, the browser test checks:

1. The iframe opened the page named by the script.
2. The target selector exists and is visible.
3. The cyan spotlight is positioned over the target.
4. The visible caption exactly equals the selected-language narration.
5. The playing file is the selected-language MP3 for that exact step.
6. A typing, selection, expansion, click, or Submit cue finishes during its narration.
7. The real screen contains the data claimed by the narration.
8. The browser has not logged a JavaScript error.

It also proved that Pause freezes typing mid-word, Resume continues from the same character, language switching does not repeat an action, and Previous/Next cannot submit the same record twice.

## Problems found and fixed

- The large dashboard target could produce an oversized/off-screen spotlight. Target rectangles are now clipped to the visible tour stage.
- Actions used to run before their narration. Cues are now scheduled against the real audio playback position and pause with the audio.
- The product master could resolve before its AJAX rows arrived. The tour now waits for the expected CCTV data.
- The AMC Submit narration could continue after the button disappeared. Submit is now shown, narrated, executed, confirmed, and checkpointed in the correct order.
- Service Analysis returned a seven-cell row to an eight-column Closed table, causing DataTables `_DT_CellIndex` errors. All/Pending/Closed rows now match their headers and Completed services are separated correctly.
- Address and Reference are separate collapsed panels in the cloned form. The tour now opens each real panel before using its fields.
- State, district, city, and area selections could be overwritten by a late AJAX response. Dependent options are cleared and awaited before the next selection.
- The Area field is a select, not a text input. The tour now selects Kharghar using its real value.
- `Mr. Deshpande` violated the real letters-and-spaces contact-person rule. The demonstration value is now `Mr Deshpande`.
- The ticket narration named Assigned, but the report filter did not offer it. The real filter now includes Assigned.
- The lead report could be narrated while its AJAX body still said no data. It now waits until `Aster Heights Annex` is present.
- Older demo leads used `Open` while the current report calls the same live state `Active`; the mock report now treats both as active working leads.
- The shared header read an unavailable `$details['emp_name']` on some pages. Its avatar alt text now safely falls back to the signed-in user's name.

## Evidence

- All screenshots: [`tools/live_shots`](tools/live_shots/)
- Saved lead confirmation: [`21-e-16-submit-after-cue.png`](tools/live_shots/21-e-16-submit-after-cue.png)
- Saved lead visible in the report: [`23-a-01-lead-report.png`](tools/live_shots/23-a-01-lead-report.png)
- Saved AMC confirmation: [`22-p-14-submit-after-cue.png`](tools/live_shots/22-p-14-submit-after-cue.png)
- Machine-readable latest live run: [`tools/live_test_report.json`](tools/live_test_report.json)

## Re-run commands

```powershell
node tools/verify_tour.js
node tools/live_test_tour.js --tour amc --lang en --shots
node tools/live_test_tour.js --tour core --lang en --shots
node tools/live_test_tour.js --tour full --lang mr
```

The local PHP server must be running at `127.0.0.1:8765`. The live test logs in with the private demo account, uses session-isolated mock data, and does not log out or modify production data.

