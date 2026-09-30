# MI-BTrack Demo Project Handover

**Prepared:** 8 September 2026  
**Workspace:** `D:\Internship\Mauli Infotech\MIBtrackDemo`  
**Original/reference project:** `D:\Internship\Mauli Infotech\MIBtrackShawn`  
**Current local URL:** `http://127.0.0.1:8765/`  
**Status:** Runnable demo with broad page coverage, workflow guidance, employee creation, synthetic data, an AMC portfolio, and a **rebuilt, verified guided tour with trilingual recorded narration.**

---

## 0. Update — 8 September 2026 (read this before Sections 10 to 13)

The guided tour has been rebuilt and the voice pack has been produced.
**Sections 10, 11, 12 and 13 of this document are superseded.** They
describe the old prototype and its defects, and are kept only as a record
of what was wrong. For the current design, read
`DEMO_TOUR_VOICE_PACK.md`.

### What changed

| Area | Then | Now |
|---|---|---|
| Runtime | 40-line prototype with uncancellable timers | Rebuilt as an epoch-guarded, fully disposable state machine in `_build/assets/js/demo-tour.js` |
| Data writes | Hidden `tour_action` mutations, narrated as if a form had been filled in | **None.** Two real forms are filled in and submitted on screen; everything else is seeded data, honestly described |
| Content | 8 / 10 / 22 steps, not written for a beginner | **39 / 30 / 64 steps** across AMC, sales and full, field by field, in English, Hindi and Marathi |
| Audio | None. The document claimed scripts were ready; no export existed | **198 clips generated** (66 per language) with a measured cost |
| Exporter | `tools/export_tour_voice_pack.js` did not exist | Written, and produces scripts, per-clip text, a manifest and a costed batch plan |
| Verification | Untested | `tools/verify_tour.js` — **34 passed, 0 failed** |

### Defects from Section 10 that are now fixed

Stale screens after hidden writes; narration claiming saves that never
happened; duplicate writes on Previous and on language change; typing
continuing while paused; resume restarting narration; double fallback on
missing audio; speech failure stalling the tour; spotlight offset by the
height of the top bar; silent failure on a missing selector; unchecked
API failures reported as success; reset destroying unrelated records.

Each is listed against its fix in `DEMO_TOUR_VOICE_PACK.md` section 5.

### Priority 2 from Section 16 is also done

`setCustomerLeadMasterDetails` is implemented, along with
`setModifyCustomerLeadMasterDetails`, `getCustomerLeadMasterDetails` and
the row hydration the detail view needs. The enquiry form now saves for
real, redirects to the enquiry's own page, and refuses a duplicate mobile
number. Verified over HTTP.

### New files

```text
tools/export_tour_voice_pack.js    scripts, manifest, costed batch plan
tools/generate_tour_audio.js       multi-key ElevenLabs generator
tools/verify_tour.js               tour self-check
tools/voice_pack/                  generated scripts and manifest
_build/assets/tour/audio/{en,hi,mr}/*.mp3
```

### Still open

- The browser checklist in `DEMO_TOUR_VOICE_PACK.md` section 8 (pause
  behaviour, spotlight tracking, audio timing) needs a human.
- Free-plan audio has no commercial rights. Regenerate under a paid plan
  before showing it to a customer.
- AMC edit, deactivate and reactivate handlers exist but have not been
  driven through the UI.
- Sections 14, 15 and 16 priorities 4 to 6 are unchanged and still open.

---

## 1. Purpose of This Handover

This document gives the next developer the complete working context of the MI-BTrack demo project. It records:

- what the application does;
- how the original system and local demo are structured;
- the business workflows reviewed during this work;
- the user's requirements and decisions from the conversation;
- changes already present in the demo;
- partially completed and unverified changes;
- known defects and missing behavior;
- the intended guided-tour and voice-pack design;
- how to run, test and continue the project safely.

This file is the handover/status document. For the complete vendor-side business explanation, also read `VENDOR_WEBSITE_WORKFLOW.md`.

---

## 2. User's Goal and Conversation History

The user cloned the original MI-BTrack project and wanted a safe, presentable demo version that behaves like the real vendor website without affecting production data.

The work progressed through these requests:

1. Read the whole original project at `MIBtrackShawn` and understand it.
2. Inspect the authenticated vendor website and document how every part works, without logging out or changing live records.
3. Explain workflows such as adding a new employee.
4. Align the local demo with the real workflow and original UI.
5. Improve error handling so empty reports and missing prerequisites explain what is missing and provide a button to the correct setup screen.
6. Open and verify the local demo.
7. Reduce demonstration time by building a guided, video-like tour over real pages. The tour should narrate, highlight controls, type realistic data at the correct time and support multiple languages.
8. Showcase all AMC plans/contracts and explain the complete AMC lifecycle.
9. Fix the initial tour prototype, make it understandable to a person who is unfamiliar with software or online systems, preserve the original UI, and prepare ElevenLabs-ready scripts that work within the Free plan for testing.
10. Create this detailed handover before continuing implementation.

### Standing user preferences

- Preserve the original UI. Use `MIBtrackShawn` as the visual and field-level authority.
- Make explanations simple enough for a first-time computer/software user.
- Explain every visible field and every required dependency.
- Use realistic but synthetic demo data.
- Demonstrate actual typing and normal form behavior where the local backend supports it.
- Error messages should explain the recovery procedure and link directly to the missing setup step.
- Do not log out of the authenticated live website.
- Do not use or modify real customer data while building the demo.

---

## 3. What MI-BTrack Does

MI-BTrack is a multi-company, multi-branch CRM, sales, service and inventory application. The vendor side connects the full operational journey:

```text
Company, branch and permissions
    -> Employees and reusable master data
    -> Lead/enquiry capture
    -> Follow-up, assignment, transfer and approval
    -> Quotation and conversion to customer
    -> Product, AMC or one-time service assignment
    -> Invoice, payment and balance tracking
    -> Scheduled service, tickets and complaints
    -> Renewal reminders, analysis and management reports
    -> Inventory purchase, inward stock and supplier payments
```

The logged-in user's company, branch, employee, role and permissions determine the records and sidebar modules they can access.

### Main vendor modules

- Dashboard
- Admin and permissions
- Masters
- Employees
- Leads
- Customers
- Quotations
- AMC and one-time services
- Payments and balances
- Tickets and complaints
- Reports and analysis
- Inventory and suppliers
- WhatsApp and notifications
- Integrations such as IndiaMART and Meta/Facebook leads

The detailed field lists and workflows for each module are in `VENDOR_WEBSITE_WORKFLOW.md`.

---

## 4. Architecture

### 4.1 Original project

The original application uses CodeIgniter PHP as the web layer and Java/Oracle services as the real backend.

```text
Browser
    -> CodeIgniter vendor route/controller
    -> application/libraries/Api.php
    -> Java Jersey service
    -> DAO/query/stored procedure
    -> Oracle database
    -> JSON response
    -> PHP controller/AJAX formatter
    -> original PHP view
```

Important original locations:

- PHP vendor controllers: `MIBtrackShawn/application/modules/vendor/controllers/`
- PHP vendor views: `MIBtrackShawn/application/modules/vendor/views/`
- Shared API wrapper: `MIBtrackShawn/application/libraries/Api.php`
- Java source: `MIBtrackShawn/btrack_server_cmp01/src/main/java/`
- Database changes: `MIBtrackShawn/db_migrations/`

The original repository currently contains about 270 Java source files in the main Java tree. It is the source of truth for screen structure, route behavior, field IDs, API names and production business logic.

### 4.2 Local demo project

The runnable local application is in `_build/`. It keeps the original CodeIgniter controllers and views wherever practical but replaces remote API calls with session-isolated synthetic data.

```text
Browser
    -> original CodeIgniter route/controller
    -> demo application/libraries/Api.php
    -> MockData method matching the production API method name
    -> MockSeed baseline plus current-session overlay
    -> original controller/view
```

Core demo files:

| File | Responsibility |
|---|---|
| `_build/application/libraries/Api.php` | Routes production-style API method calls to local mock methods. |
| `_build/application/libraries/MockData.php` | Builds response envelopes and field names expected by controllers and views. |
| `_build/application/libraries/MockSeed.php` | Stores immutable synthetic baseline records and session-only changes. |
| `_build/application/modules/vendor/controllers/` | Original vendor request and validation flow, with limited demo compatibility edits. |
| `_build/application/modules/vendor/views/` | Original website UI plus a small number of demo-only views/components. |
| `_build/assets/js/demo-workflow-guide.js` | Connected empty-state, prerequisite and recovery guidance. |
| `_build/assets/css/demo-workflow-guide.css` | Styling for workflow guidance. |
| `_build/assets/js/demo-tour.js` | Current guided-tour runtime prototype. |
| `_build/assets/js/demo-tour-content.js` | Current localized tour steps. |
| `_build/application/modules/vendor/views/dashboard/tour.php` | Persistent tour shell containing the real page iframe and player. |
| `_build/application/modules/vendor/views/dashboard/amc_portfolio.php` | Demo-only view of the complete synthetic AMC book. |
| `tools/routes.json` | Discovered vendor routes. |
| `tools/smoke.py` | Route-level smoke test. |
| `tools/smoke_report.json` | Stored results from the latest full route test. |

The root `demo/` directory is currently empty. Comments refer to a future static export, but no completed exporter/runtime exists. Do not treat `demo/` as the runnable application.

---

## 5. Running the Demo

From PowerShell:

```powershell
Set-Location 'D:\Internship\Mauli Infotech\MIBtrackDemo\_build'
php -S 127.0.0.1:8765 router.php
```

Open:

```text
http://127.0.0.1:8765/
```

The configured base URL is `http://127.0.0.1:8765/` in `_build/application/config/config.php`.

### Synthetic demo accounts

| Role | Username | Password |
|---|---|---|
| Demo Super Admin | `demo` | `demo123` |
| Demo Sales | `sales` | `demo123` |

These credentials are synthetic and come from `MockSeed::accounts()`. Do not put live credentials or production secrets into this project or this document.

### Session behavior

The demo uses a normal CodeIgniter/PHP session. Baseline seed data is intended to remain unchanged; records created or edited by a trainee are placed in a session overlay. A new browser session may therefore see a different state.

---

## 6. Original UI Preservation Rule

The user explicitly asked that the normal website UI remain the same. Apply this rule whenever continuing the demo:

1. Inspect the equivalent page in `MIBtrackShawn` first.
2. Preserve its markup, Bootstrap/Metronic classes, labels, field IDs and controller contract.
3. Put demo behavior in mocks, small compatibility fixes, or an outer tour/guidance layer.
4. Do not redesign normal vendor forms and reports just to simplify the tour.
5. If a visual change is genuinely required, keep it confined to demo-only components such as the tour player or recovery panel.

The current guided tour loads the actual vendor page in an iframe. This is the correct basic direction because it demonstrates the real UI rather than drawing a fake copy.

---

## 7. Implemented Work

### 7.1 Project and workflow documentation

`VENDOR_WEBSITE_WORKFLOW.md` documents the vendor website, application architecture, modules, form flows, integrations, demo design and developer change locations. It was created after reviewing the authenticated site, the original source and the local demo.

The live review was read-only: no forms were submitted, no records were changed, no branch was switched and the account was not logged out.

### 7.2 Broad runnable demo coverage

The local demo can render the login/session shell, dashboard, sidebar navigation and most vendor pages using synthetic data and original views.

The latest stored full smoke report contains:

- 278 discovered vendor page routes;
- 278 clean HTTP 200 responses;
- 0 non-200 results;
- 0 PHP-problem markers in response bodies;
- 24 unique missing API method names in the report metadata.

Important limitation: HTTP 200 only proves that a page rendered. It does not prove that its form, filters, dependent dropdowns, save action or report data are functionally complete.

### 7.3 Employee foundation

The demo includes:

- designation/permission, department, sub-department and education lookups;
- synthetic employee hierarchy;
- employee report and detail responses;
- reporting-manager and duplicate-mobile responses;
- session-only employee creation;
- compatibility handling for optional employee fields and newer text location fields;
- safe synthetic integration-status responses.

Previous browser verification confirmed a synthetic employee could be submitted and found in the employee AJAX report. Department selection also loaded sub-departments.

### 7.4 Connected error and recovery guidance

The shared workflow guidance layer is implemented in:

- `_build/assets/js/demo-workflow-guide.js`
- `_build/assets/css/demo-workflow-guide.css`
- `_build/application/modules/vendor/views/_parts/footer.php`

It detects common empty or blocked states and explains:

- what record or master is missing;
- why the current operation needs it;
- the steps to complete first;
- a direct button to the required Add or Report page.

Covered relationships include employee prerequisites, leads and reference/product masters, ticket/customer/employee dependencies, quotation prerequisites, purchase/supplier/inward flow, inventory master dependencies, and main report-to-create links.

Previously verified examples included an empty FAQ report, a purchase order blocked by missing suppliers, an invalid employee detail redirect, and clearer deactivate confirmation wording.

### 7.5 Dashboard tour launcher and AMC portfolio

The dashboard contains demo-only links for:

- Core tour
- AMC tour
- Full tour
- AMC portfolio

The AMC portfolio presents the synthetic contract book with several lifecycle/payment states for demonstration. It is useful as a read-only presentation view, but it is not proof that every normal AMC transaction screen is fully wired.

### 7.6 Initial guided-tour prototype

The current player supports:

- Core, AMC and Full step lists;
- English, Hindi and Marathi text;
- real vendor pages inside the tour shell;
- highlighting;
- Previous, Next, Pause/Resume and Take control;
- browser speech fallback when an audio file is missing;
- session-only hidden tour actions.

Current content size:

| Tour | Steps |
|---|---:|
| Core | 8 |
| AMC | 10 |
| Full | 22 |

This is a prototype only. Its defects are documented in Section 10 and it should not be presented as the finished beginner tour.

---

## 8. Changes Made Immediately Before This Handover

Two AMC mock files were partially improved immediately before the user requested the handover.

### `_build/application/libraries/MockSeed.php`

- Removed global deduplication that could hide distinct contract IDs.
- Corrected eight AMC plan durations from month-like `12/24` values to day values `365/730`.
- Changed service interval calculation to `ceil(duration days / number of visits)`.
- Linked plans to valid product IDs.
- Added synthetic Fire Alarm Panel and Residential Intercom Unit products.
- Added plan creator/date fields.

### `_build/application/libraries/MockData.php`

- Standardized AMC report/detail wrappers around `jsArray` and `total_count`.
- Filtered Detail requests by the actual AMC ID.
- Hydrated AMC details with the linked product, detail rows, image defaults and GST-inclusive values.
- Added validation and handlers for normal AMC create/edit/deactivate/reactivate calls.
- Added optional pagination support and used it in the AMC response path.

### Verification performed after those edits

- `php -l` passed for `MockSeed.php`.
- `php -l` passed for `MockData.php`.
- `php -l` passed for the changed `Leads.php`, `Dashboard.php` and `tour.php` files.
- `node --check` passed for `demo-tour.js`, `demo-tour-content.js` and `demo-workflow-guide.js`.

No HTTP form submission or browser end-to-end verification was run after the AMC mock edits. Treat them as syntactically valid but functionally unverified.

One small lead-controller compatibility fix is also present: `$clm_img` is initialized to `null` so a business-card upload remains optional.

---

## 9. AMC Business Rules and Intended Demo Story

### Critical field rule

The original Add AMC form stores duration in **days**, not months.

Relevant original field IDs:

- Product: `#amc_product_id`
- AMC name: `#amc_name`
- Description: `#amc_desc`
- Duration in days: `#amc_duration`
- Number of services: `#amc_noofservices`
- Service interval, calculated/read-only: `#amc_sit`
- GST: `#amc_gst`
- Regular price: `#amc_price`
- Corporate price: `#amc_corporate_price`
- Main image: `#p_image`
- Multiple images: `#p_multi_image`
- Submit: `#mybutton`

The original UI calculates:

```text
service interval = ceiling(duration in days / number of services)
```

Example: 365 days / 4 visits = a 92-day interval.

### Planned new walkthrough record

Use the following synthetic record for future real form automation:

- Plan: `Aster CCTV Annual Care`
- Product ID: `3001`
- Duration: `365` days
- Visits: `4`
- Calculated interval: `92` days
- GST: `18`
- Regular price: `12000`
- Corporate price: `15000`

The complete AMC flow the user wants to demonstrate is:

```text
Create products/master prerequisites
    -> Create reusable AMC plan
    -> Add or choose customer
    -> Attach AMC subscription to customer
    -> Confirm start/end date, value and service allowance
    -> Record payment status
    -> Generate/show planned visits
    -> Complete a service visit
    -> Raise an AMC-linked breakdown ticket if needed
    -> Show renewal reminder
    -> Renew while preserving earlier history
    -> Review complete portfolio and reports
```

### Still missing or unverified in AMC

- Reminder results are not yet filtered to contracts actually due.
- Pending-service queues are not yet verified to exclude completed or invalid contracts.
- Customer subscription-detail response compatibility remains unfinished.
- New AMC create/edit/status handlers have not been browser-tested.
- Contract creation, payment, service completion and renewal must use normal forms or clearly labelled instructional previews; hidden mutations should be removed from the final tour.

---

## 10. Guided Tour: Current Defects

The current prototype is not working reliably for the user's intended real-time demonstration. The source audit found the following problems.

### Data and screen synchronization

- The player loads a page and then performs a hidden `tour_action` mutation. The visible report can therefore be stale because it loaded before the data changed.
- The narration may say a record was created or saved even though no visible form was completed.
- Most steps highlight a whole table or portlet instead of explaining and filling individual fields.
- Only a few name values are visibly typed; most lifecycle changes happen invisibly.

### Duplicate and unexpected changes

- Hidden actions can run again when the user presses Previous.
- Changing language re-renders the step and can repeat the hidden action.
- A restart can replay mutations and create confusing state.
- There is no verified save checkpoint that distinguishes narration replay from a real already-completed submit.

### Pause and playback

- Typing uses an uncancelled interval, so it can continue while the tour is paused or after leaving the step.
- Resume can restart narration instead of continuing from the paused location.
- Audio load failure and rejected autoplay can trigger fallback twice.
- Browser speech failure handling is incomplete and can stall the tour.

### Highlighting and page readiness

- Highlight coordinates include viewport offsets even though the spotlight is positioned inside the stage. This can move it away from the target.
- The initial dashboard may not trigger the expected load path when the iframe already has that URL.
- A missing selector is silently ignored.
- The player does not robustly wait for dependent AJAX fields or result content.

### Error truthfulness

- Failed hidden API actions are not properly checked before the player proceeds.
- Some narration claims success in a `.finally` path even when a request could fail.
- The current “Reset private session” clears the entire session overlay, potentially removing trainee changes unrelated to the tour.

### Content quality

- The current 22-step Full tour is much shorter and less detailed than the stated approximate duration.
- It is not yet written for a person with little computer experience.
- The current voice-pack document says scripts are ready, but the promised per-language export files and manifest do not exist.
- Current content has legacy `type` and `action` properties; it does not use the planned cue schema.

---

## 11. Required Final Tour Design

The next implementation should use a deterministic, cancellable state machine rather than adding patches to the existing timing code.

### Required behavior

1. Require a clear Start action so browser audio permission is obtained through a user gesture.
2. Load the actual vendor page and wait for its document and target element.
3. Explain the screen in plain language before filling it.
4. Highlight one field or action at a time.
5. Type/select/click visibly using the original page's own events and dependent AJAX behavior.
6. Use the normal form submit button and validation. Never call `form.submit()` to bypass validation.
7. Wait for the real success message, redirect and expected saved data before narrating success.
8. If a prerequisite or save fails, pause and show a helpful message with Retry, Take control and the relevant setup-page button.
9. Pause must stop narration, cue timing and typing. Resume must continue cleanly.
10. Previous, language switching and replay must never duplicate a completed save.
11. Keep save checkpoints in `sessionStorage` or a session-scoped equivalent, keyed by tour version and step ID.
12. Restart the narration without deleting unrelated trainee records.
13. Cancel every outstanding timer, animation frame, audio handler and speech handler when changing steps.
14. If a field cannot safely be written in the demo, say it is an instructional preview; do not pretend it was saved.

### Planned content schema

```javascript
window.MIB_TOUR_CONTENT = {
  core: [],
  amc: [],
  full: []
};

// Example step
{
  id: 'amc-name',
  chapter: { en: 'Create the plan', hi: '...', mr: '...' },
  url: 'vendor/masters/add_amc',
  selector: '#amc_name',
  title: { en: 'Name the AMC plan', hi: '...', mr: '...' },
  text: { en: 'This name helps the team choose the correct plan later.', hi: '...', mr: '...' },
  cue: {
    kind: 'type',
    selector: '#amc_name',
    value: 'Aster CCTV Annual Care',
    word: { en: 'We will type the plan name now.', hi: '...', mr: '...' }
  },
  expectedText: 'Aster CCTV Annual Care'
}
```

Support either one cue or an array of cues where a short step genuinely needs more than one tightly related action.

### Planned lead story

- Lead name: `Aster Heights Annex`
- Mobile: `9800091001`
- Email: `annex@aster.example`
- Expected success text: `New Lead Added Successfully`

Relevant lead selectors already checked against the original UI:

- `#lead_name`
- `#lead_desc`
- `#lead_priority`
- `#lead_contact`
- `#company_name`
- `#lead_contact_person`
- `#lead_productid`
- `#lead_contact_email`
- `#lead_addrs`
- `#lead_cityid`
- `#lead_stateid`
- `#lead_distid`
- `#lead_arealoc`
- `#lead_pincode`
- `#lead_refby`
- submit `#add_edit_form_btn`

Email and address fields are inside collapsed `#additional_details`; open the `[data-target="#additional_details"]` control before using them.

The backend does **not** currently implement a real `setCustomerLeadMasterDetails` flow. Do not add a real lead-submit tour step until this exists and has been verified.

### Other audited selectors/routes

- Employee form: `#emp_name`, `#emp_mob1`, `#emp_emailid`, `#emp_rpt_to`, `#permission_id`, `#department_id`, `#sub_dept_id`, `#location_tracking`, `#emp_joining_date`.
- Ticket form: `[name="cust_type"][value="Customers"]`, `#ref_id`, `#tkt_title`, `#ticket_priority`, `#ticket_desc`, `#ticket_assign_to`, `#ticket_date`.
- Payment form: `#cust_id`, `#cbpm_id`, `#pay_mode`, `#paying_amt`, `#paying_ui_date`, `#payment_terms`, `#payment_remark`.
- Baseline customer service example: `vendor/customers/add_customer_service?id=NjAwOQ==` for synthetic customer ID `6009`.

---

## 12. Beginner-Friendly Content Standard

The intended audience may not know CRM terms, online forms or why the order of setup matters. Every step should answer four questions:

1. **Where are we?** Example: “This is the AMC master. A master is a reusable template.”
2. **Why do we use it?** Example: “Creating the plan once prevents staff from typing different prices and visit counts for every customer.”
3. **What are we entering?** Explain the label and give a simple example.
4. **What happens next?** Explain what record becomes available and where it will appear.

Writing rules:

- Use short sentences and everyday words.
- Define terms on first use: Lead, AMC, OTS, quotation, reference, assignee and renewal.
- Never say “just click” or assume the user understands icons.
- Say whether a field is required, optional, calculated or selected from earlier setup.
- Explain why an empty dropdown occurs and which master must be created.
- Mention the visible confirmation after Save.
- Avoid announcing success until the saved record is actually visible.
- Keep product names and IDs consistent across the entire story.

The planned content rewrite was approximately 100 small Full-tour steps and about 35 AMC steps, but it was researched only and never written. The current file is still the legacy 8/10/22-step version.

---

## 13. ElevenLabs Voice Pack Handover

### Current status

- `DEMO_TOUR_VOICE_PACK.md` is an early concept document, not a finished export handover.
- No `tools/export_tour_voice_pack.js` exists.
- No per-clip TXT files, language script files, manifest or measured credit budget has been generated.
- No production MP3 pack has been imported.

### Recommended file convention

Use each stable step ID once per language so Core, AMC and Full tours can reuse the same audio instead of paying for duplicate generation:

```text
_build/assets/tour/audio/en/{step-id}.mp3
_build/assets/tour/audio/hi/{step-id}.mp3
_build/assets/tour/audio/mr/{step-id}.mp3
```

Optional exact cue timing can use:

```text
_build/assets/tour/audio/en/{step-id}.json
```

Example sidecar:

```json
{"cueMs": 3150}
```

### Exporter requirements

Create `tools/export_tour_voice_pack.js` that:

- evaluates `window.MIB_TOUR_CONTENT` safely;
- exports exact narration-only text for every stable step ID;
- writes Full/Core/AMC scripts for English, Hindi and Marathi;
- writes per-clip `.txt` files and a JSON manifest;
- counts Unicode characters with `Array.from(text).length`;
- reports language, chapter and total character estimates;
- avoids duplicate credit counting when a clip is reused by multiple tour modes;
- groups test batches conservatively below the Free-plan allowance;
- never changes narration wording during export.

### Free-plan constraint

At the time of research, ElevenLabs' official pricing described 10,000 monthly credits on Free. Official publication guidance says Free-plan output cannot be used commercially, requires attribution when published, and upgrading later does not retroactively grant commercial rights to audio generated on Free. Therefore:

- use Free output only for internal/non-commercial testing;
- regenerate final sales-demo audio under a plan that includes commercial rights;
- do not assume a later upgrade licenses earlier Free recordings;
- use a model supporting all required languages; Eleven v3 documentation includes Marathi.

Official references:

- `https://elevenlabs.io/pricing`
- `https://help.elevenlabs.io/hc/en-us/articles/13313564601361-Can-I-publish-the-content-I-generate-on-the-platform`
- `https://elevenlabs.io/docs/overview/models`

---

## 14. Known Missing API/Feature Areas

`_build/mock_missing.log` is append-only and contains repeated calls. `tools/smoke_report.json` is a better unique checklist. Current missing areas include:

- menu-permission assignment detail;
- customer bill payment detail;
- customer ticket and invoice detail;
- FAQ modules and records;
- inventory category, brand, unit, area and shelf reports;
- customer, lead and payment graphs;
- team leads and employee availability/reporting lookups;
- terms and conditions;
- cheque and brand-master reports.

Other functional gaps may not appear in this list if an API returns a valid empty envelope. Always test the actual screen workflow, not only the missing-call log.

External operations must remain safe no-ops in a public demo:

- WhatsApp/SMS/email sending;
- payment gateways;
- OAuth connection changes;
- live IndiaMART/Meta tests;
- production uploads/downloads;
- any API capable of affecting real customers or credits.

---

## 15. Testing Status

### Previously completed and useful

- Full route smoke report: 278/278 clean HTTP 200.
- Employee form/report journey previously tested successfully.
- Workflow-guidance examples were browser-checked.
- Browser console was previously clean after moving jQuery before inline page scripts.

### Completed for this handover

- PHP syntax check passed on recent AMC mock files and related changed PHP entry points.
- JavaScript syntax check passed on the current tour, content and workflow-guide scripts.
- Tour content was evaluated: Core 8, AMC 10, Full 22.

### Not completed

- No browser test after the latest AMC mock edits.
- No real AMC create/edit/deactivate/reactivate end-to-end test.
- No real lead create flow in the mock backend.
- No reliable tour pause/resume/replay/language/idempotence test.
- No audio import or synchronization test.
- No generated voice scripts or character-budget verification.
- No re-run of the entire 278-route suite after the immediately preceding AMC edits.

Do not state that these untested areas are complete.

---

## 16. Recommended Continuation Order

### Priority 1: Stabilize the partially changed AMC backend

1. Review the latest diffs in `MockSeed.php` and `MockData.php` against their controller callers.
2. Submit `Aster CCTV Annual Care` through the original Add AMC form.
3. Verify validation, dependent product selection, interval `92`, success redirect and report row.
4. Verify edit, deactivate and reactivate.
5. Fix subscription detail, reminder and pending-service response shapes.
6. Re-run focused browser tests and the route smoke suite.

### Priority 2: Implement the real lead save path

1. Trace `Leads.php::add_lead()` and the production `setCustomerLeadMasterDetails` parameter order.
2. Implement the mock response and session overlay using the exact production envelope.
3. Implement lead detail/report visibility for the saved row.
4. Browser-test `Aster Heights Annex` with its mobile and email.
5. Only then include the normal submit in the tour.

### Priority 3: Replace the tour runtime

1. Remove reliance on hidden `Dashboard::tour_action()` mutations.
2. Implement page readiness, cancellable cues and true pause/resume.
3. Add real submit verification and save checkpoints.
4. Correct spotlight positioning relative to `.tour-stage`.
5. Add visible Retry/Take control recovery states.
6. Change Reset into a narration restart that preserves unrelated session records.
7. Add automated tests for timing cancellation, language switching and save idempotence.

### Priority 4: Rewrite beginner narration

1. Build small field-level chapters using the verified original selectors.
2. Cover every AMC field and the complete AMC lifecycle first.
3. Cover core lead-to-customer operations next.
4. Describe unsupported modules honestly instead of simulating success.
5. Review English for simplicity, then review Hindi and Marathi with fluent speakers.

### Priority 5: Generate and import voice assets

1. Build the exporter and generate exact scripts/manifests.
2. Measure characters before using ElevenLabs.
3. Test a compact AMC/English pack within Free for internal evaluation.
4. Add sidecar cue timings where a visible action must match a spoken word.
5. Regenerate approved final audio with commercial rights before using it in a sales presentation.

### Priority 6: Finish remaining business gaps

Work through `tools/smoke_report.json` and real user journeys. Prioritize customer subscription details, billing, tickets, service queues and management graphs before low-value peripheral reports.

---

## 17. Practical Verification Checklist

Before calling the demo ready, verify all of the following in a fresh demo session:

```text
[ ] Login as Demo Admin
[ ] Dashboard loads with no console/PHP errors
[ ] Add employee and find it in Employee Report
[ ] Missing prerequisite guidance links to the correct master
[ ] Add lead and find it in Lead Report
[ ] Create follow-up and show it on the expected report/dashboard
[ ] Convert or otherwise demonstrate customer creation honestly
[ ] Create Aster CCTV Annual Care through the normal AMC form
[ ] Verify 365 days / 4 visits = 92-day interval
[ ] Edit and change AMC status
[ ] Attach an AMC to a synthetic customer
[ ] Record payment without external side effects
[ ] Show scheduled and completed visits correctly
[ ] Show only genuinely due renewals
[ ] Raise and find a linked ticket
[ ] Run Core, AMC and Full tours from a clean session
[ ] Pause freezes typing and narration
[ ] Resume continues once
[ ] Previous and language change never repeat a save
[ ] Missing target produces a recovery message
[ ] Imported audio and text remain synchronized
[ ] Take control lets presenter use the real page
[ ] Restart keeps unrelated trainee data
[ ] Re-run all discovered route smoke tests
[ ] Review browser console and PHP log
```

---

## 18. Safe Development Rules

- Make changes only in `MIBtrackDemo` unless the user explicitly requests a production/source change.
- Treat `MIBtrackShawn` as read-only visual/behavior reference during demo work.
- Do not copy live records, credentials, tokens or customer contact details.
- Keep all sample names, phones, emails, invoices and payments clearly synthetic.
- Never connect demo actions to real messaging, payments, OAuth or production APIs.
- Do not log out of or mutate the authenticated live vendor account during inspection.
- Preserve original controller parameter order and response field names.
- For any broken page, trace: URL -> controller -> API name/parameters -> MockData -> response fields -> AJAX formatter -> view.
- Validate normal forms through their visible buttons and client/server validation.
- Do not count a clean HTTP response as a completed workflow.
- After mock changes, clear or isolate the demo session before testing to avoid stale overlay records.

---

## 19. Key Documents and Entry Points

Read in this order:

1. `PROJECT_HANDOVER.md` — current state, decisions and next steps.
2. `VENDOR_WEBSITE_WORKFLOW.md` — complete business and technical workflow.
3. `DEMO_TOUR_VOICE_PACK.md` — early voice concept; update it after the content rewrite.
4. `_build/application/libraries/MockSeed.php` — synthetic data and session overlay.
5. `_build/application/libraries/MockData.php` — mock API behavior.
6. `_build/assets/js/demo-workflow-guide.js` — connected error/recovery layer.
7. `_build/assets/js/demo-tour.js` — prototype runtime that needs replacement.
8. `_build/assets/js/demo-tour-content.js` — legacy narration that needs expansion.
9. `tools/smoke_report.json` and `_build/mock_missing.log` — coverage checklist.

Reference the matching controller and view in `MIBtrackShawn` before changing a workflow.

---

## 20. Final Handover Summary

The project has a strong foundation for a safe MI-BTrack demonstration: original screens, synthetic session data, broad route rendering, employee creation, connected recovery guidance and an AMC presentation view. The next important work is not a new UI. It is making a small set of real business journeys behave reliably, then driving those journeys with a beginner-friendly, cancellable narrated tour.

The immediate state to remember is:

- the local demo is runnable;
- original UI preservation is mandatory;
- employee and guidance work is the most mature interactive area;
- the AMC backend received recent syntax-valid but unverified changes;
- the current tour is a prototype with serious synchronization/idempotence problems;
- the detailed beginner rewrite and ElevenLabs export pack were planned but not implemented;
- real lead creation is still missing from the mock backend;
- claims of completion must be based on normal browser form submission and visible saved results.
# Final guided-tour verification update (9 September 2026)

The tour implementation and its final browser evidence are documented in [`TOUR_VERIFICATION_REPORT.md`](TOUR_VERIFICATION_REPORT.md). The current verified totals are 30 Sales-to-Service steps, 39 AMC steps, 64 Complete Operations steps, 66 unique narration clips per language, and complete English/Hindi/Marathi MP3 packs. Final live runs have zero browser-console errors and zero failures on the current code. The latest fixes cover audio/action synchronization, clipped spotlight geometry, real form validation, collapsed Address/Reference panels, dependent AJAX selects, genuine idempotent form submissions, loaded-table waits, and correctly shaped Service Analysis tables.

