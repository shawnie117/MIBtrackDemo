# MI-BTrack Vendor Website: Simple Working Guide

Last reviewed: 8 September 2026

This guide explains how the **vendor side** of MI-BTrack works, what each menu is for, how information moves through the website, and where developers should make changes.

The guide was prepared by:

- Inspecting the authenticated live vendor website at `https://mibtrack.co.in/vendor/dashboard`.
- Reviewing the original project in `D:\Internship\Mauli Infotech\MIBtrackShawn`.
- Reviewing the local demo project in `D:\Internship\Mauli Infotech\MIBtrackDemo`.

No forms were submitted, no records were changed, no branch was switched, and the live account was not logged out during the review.

## 1. What MI-BTrack Is

MI-BTrack is a CRM and service-management system. A vendor uses it to manage the complete journey from a new enquiry to an active customer and their later service work.

The simplest business flow is:

```text
Company setup
    ↓
Employees, roles and permissions
    ↓
Products, AMC, OTS and reference masters
    ↓
Lead captured manually or through an integration
    ↓
Lead follow-up, transfer and approval
    ↓
Lead converted into a customer
    ↓
Service, quotation, invoice and payment management
    ↓
Tickets, complaints and scheduled services
    ↓
Reports and management analysis
```

The application is multi-company and multi-branch. The logged-in user's company, branch, employee and permission IDs control the data and menus they can access.

## 2. Website Layout

Every authenticated vendor page uses the same basic layout:

- The top bar shows the logged-in account and current company.
- The account menu contains My Account, Change Branch, Change Password and Log Out.
- The left sidebar contains the modules allowed for the user's role.
- The center area shows a dashboard, form, report table or record details.
- Most report pages provide filters, an Add New button and row actions such as View, Edit, Transfer, Deactivate or Reactivate.
- Confirmation popups are reused for Submit, Activate and Deactivate operations.

The main sidebar sections seen in the live demo account are:

1. Dashboard
2. Admin
3. Masters
4. Customers
5. Leads
6. Quotation
7. Complaint
8. Tickets
9. Send WhatsApp
10. Notification
11. Reports
12. Inventory
13. FAQ
14. Employee
15. Integrations
16. Terms and Conditions

The exact menu can be different for another employee because menu permissions are assigned by role.

## 3. Login and Session Flow

```text
Login page
    ↓
Username and password sent by Login controller
    ↓
Backend validates account, company, branch and subscription
    ↓
Optional OTP/two-step-verification checks
    ↓
User/company/branch/role values stored in PHP session
    ↓
Dashboard and permitted sidebar menu are loaded
```

Important session values include user ID, employee ID, role/permission ID, company ID and branch ID. Almost every controller sends some of these values to the backend, so they provide tenant and branch context.

Live controller:

- `application/modules/vendor/controllers/Login.php`

Live login view:

- `application/modules/vendor/views/login.php`

Local demo behavior:

- `MockData::getLoginDetails()` replaces the real login API.
- `MockSeed::accounts()` contains synthetic demo accounts.
- The local demo still uses a normal CodeIgniter session.

## 4. Dashboard Flow

The dashboard is the vendor's daily work screen. It collects information from multiple modules instead of storing separate dashboard data.

It shows quick links for:

- New customer
- New ticket
- Follow-up
- Upcoming services
- New complaint
- Month scheduler

It also shows operational reminder blocks such as:

- Lead approval requests
- Today's team follow-ups
- Today's personal follow-ups
- Payment defaulters
- Raised complaints
- AMC renewals
- Pending services
- Open tickets
- Leads received from external integrations

Clicking a dashboard record opens the related lead, customer, ticket, complaint or payment page. Clicking **See All Records** opens the corresponding filtered report.

Code locations:

- Controller: `application/modules/vendor/controllers/Dashboard.php`
- View: `application/modules/vendor/views/dashboard.php`
- Shared page shell: `application/modules/vendor/views/_parts/header.php` and `_parts/footer.php`

The local demo has one dashboard-only correction: notification rows are cached in the same shape on cache misses and cache hits.

## 5. Admin and Permission Setup

The Admin area controls company-level configuration. It includes:

- My Account
- Branch management
- Assign Menu
- Assign Reminder Notification
- Assign Block
- Password-change tracking
- Employee password changes
- Customer-data upload
- Quotation and invoice terms

### Menu permission flow

The Assign Menu screen displays the application modules against roles such as Super Admin, Admin, Sales, Technician, Customer and Employee. Checked permissions decide what each role can see or use.

```text
Admin selects permissions for a role
    ↓
Permission assignment saved in the backend
    ↓
User logs in or refreshes session
    ↓
Sidebar is generated from the allowed menu records
```

Code location:

- Controller: `application/modules/vendor/controllers/Admin.php`
- Main method: `assign_menu()`
- The live menu is database-driven; the local demo menu is returned by `MockData::getMenuDashboardWebDetails()`.

## 6. Masters: Data Needed by Other Modules

Masters are reusable options used by leads, customers, employees, quotations, tickets and inventory. They should normally be configured before daily transaction work starts.

Important masters include:

- Products
- AMC services
- One-Time Services (OTS)
- Lead/customer references
- Departments and sub-departments
- Designations/permissions
- Education
- State, district, city and area
- Notification types
- FAQ
- Terms and conditions
- Invoice settings

### AMC example

The Add AMC page collects product, AMC name, description, duration, number of services, service interval, GST, regular price, commercial price and images.

### Reference example

A reference represents where a lead or customer came from. The form stores reference name, contact person, mobile, email, address and details. Examples can include referrals, campaigns, IndiaMART or Facebook Lead API.

Code locations:

- Controller: `application/modules/vendor/controllers/Masters.php`
- Views: `application/modules/vendor/views/masters/`

When adding a new reusable dropdown option, add it as a master instead of hardcoding it only inside one form.

## 7. Lead Management

Leads are potential customers who have not yet completed the customer-registration process.

### Ways a lead can enter

- Manual Add New Lead form
- An existing customer selected as a new enquiry
- Bulk Excel upload
- IndiaMART integration
- Facebook/Meta Lead Ads integration
- Other campaign/import logic supported by the backend

### Add Lead form

The form captures:

- Lead name and enquiry details
- Priority
- Mobile, email and landline
- Company and contact person
- Product/service enquiry
- Date of birth
- Address and geography
- Reference/source details
- Alternate contacts
- Business-card image

The form can create a reference inline if the required source is not already in the reference master.

### Lead report

The All Lead Report is the main working list. It supports filters for:

- Follow-up status
- Lead status
- Name or contact
- Employee/current owner
- Product/enquiry
- Reference
- Transfer target
- Priority
- Date/month
- State, district, city and area

The report also supports single or multiple lead transfer and links to lead-summary reports.

### Lead lifecycle

```text
Lead created
    ↓
Duplicate mobile check
    ↓
Assigned to an employee/current owner
    ↓
Follow-ups recorded
    ↓
Optional transfer to another employee
    ↓
Approval requested and confirmed/rejected
    ↓
Converted to customer, or deactivated
```

The conversion step should reuse the lead's contact, company, address, reference and enquiry information so it is not entered twice.

Code locations:

- Page controller: `application/modules/vendor/controllers/Leads.php`
- Lead pages: `application/modules/vendor/views/leads/`
- Report/AJAX tables: `application/modules/vendor/controllers/Ajax.php`
- Main methods: `lead_report()`, `add_lead()` and the related view/edit/transfer/follow-up methods

## 8. Customer Management

A customer represents an accepted/converted account receiving products or services.

### Add Customer form

The live form is divided into sections:

1. Basic details
2. Contact details
3. Address details
4. Service details
5. Payment details
6. Cheque details
7. DD details
8. Online transaction details
9. Reference details
10. Alternate contacts

It supports service types, GST choice, individual/company customer types, AMC/OTS/product selection, installments and different payment modes.

### Customer lifecycle

```text
Customer created directly or converted from a lead
    ↓
Products, AMC or OTS services attached
    ↓
Total, GST, received amount and balance calculated
    ↓
Cash, cheque, DD, online or installment payment recorded
    ↓
Invoice/payment records generated
    ↓
Future service dates appear in reminders and scheduler
    ↓
Tickets, complaints and follow-ups link back to the customer
```

The All Customer Report can filter by status, service type/name, GST and name/contact/company.

Code locations:

- Controller: `application/modules/vendor/controllers/Customers.php`
- Customer pages: `application/modules/vendor/views/customers/`
- Large report/AJAX responses: `application/modules/vendor/controllers/Ajax.php`
- Main methods: `customer_report()` and `add_customer()`

## 9. Follow-ups and Scheduling

Follow-ups can belong to a lead or customer and can be assigned to an employee. Their dates feed the dashboard and reports.

The Follow-Up Report shows customer/lead, contact, assignee, status and available actions.

The Month Scheduler is a calendar/list view of scheduled work. Upcoming Services lists the customer, service, service date, start date and end date. These screens are populated from existing customer-service and follow-up records; the application does not use a separate modern background scheduler for them.

Code locations:

- `Customers.php::followup_report()`
- `Customers.php::month_scheduler()`
- `Customers.php::upcoming_service_report()`
- Related customer views and AJAX methods

## 10. Tickets and Complaints

Tickets are assigned service tasks. Complaints record a customer's reported problem. Both are connected to customers and employees.

### Ticket flow

```text
Choose Customer, Lead or Other
    ↓
Enter ticket title, description and priority
    ↓
Assign employee and task date/time
    ↓
Employee works on ticket
    ↓
Ticket can be reassigned, reviewed, resolved and closed
```

The ticket report supports status, customer, type, priority, title, assigned employee and date filters. Multiple tickets can be transferred together.

### Complaint flow

```text
Choose customer
    ↓
Enter complaint title and details
    ↓
Complaint is assigned/processed like service work
    ↓
Review or resolution details are added
    ↓
Complaint is closed or deactivated
```

Code locations:

- Controller: `application/modules/vendor/controllers/Customers.php`
- Views: `application/modules/vendor/views/customers/`
- Main methods: `ticket_report()`, `add_ticket()`, `complaint_report()` and `add_complaint()`

## 11. Quotations

A quotation can be prepared for a lead or an existing customer.

The quotation form captures:

- Customer or lead
- Priority
- GST type
- Date, name, address and contact
- Subject and description
- Product/service lines
- Total price
- Acknowledgement/prepared-by information

The Quotation Report tracks customer/lead, type, status, priority, contact, remarks and date. From there a quotation can be viewed, edited, followed up, downloaded or deactivated according to permissions.

Code locations:

- Controller: `application/modules/vendor/controllers/Reports.php`
- Views: `application/modules/vendor/views/reports/`
- Main methods: `quotation_report()` and `add_quotation()`

## 12. Inventory

Inventory is a separate API channel but is shown inside the same vendor website.

### Inventory setup

Item creation uses:

- Category and sub-category
- Brand
- Supplier
- Unit
- Area, shelf and sub-shelf
- Item code, description and barcode
- Quantity and buffer level
- Purchase price, sale price, GST and HSN
- Images

Most supporting masters can be created inline from the Add Item page.

### Purchase/order flow

```text
Supplier created
    ↓
Inventory item created
    ↓
Order raised for supplier and items
    ↓
Purchase/payment details recorded
    ↓
Stock/inward quantity updated
    ↓
Items consumed, sold or used in counter billing
    ↓
Stock and supplier-liability reports updated
```

The Stock Report filters by search text, category, sub-category, supplier, brand, storage location, unit and status.

Code locations:

- Controller: `application/modules/vendor/controllers/Inventory.php`
- Inventory AJAX: `application/modules/vendor/controllers/Ajax_inventory.php`
- Views: `application/modules/vendor/views/inventory/`
- Inventory dashboard: `application/modules/vendor/controllers/Inv_Dashboard.php`

## 13. Employees

Employees are both user accounts and people to whom leads, tickets and work can be assigned.

The Add Employee form contains:

- Basic identity and contact details
- Reporting manager
- Designation, department and sub-department
- Location-tracking setting
- Education
- Bank details
- Current and permanent addresses
- ID and address proofs
- Employee image

The Employee Report filters by status, permission/designation, department, sub-department and text search. Related pages provide attendance and location reports.

Code location:

- Controller: `application/modules/vendor/controllers/Admin.php`
- Views: `application/modules/vendor/views/admin/`
- Main methods: `employee_report()` and `add_employee()`

## 14. WhatsApp and Notifications

The Send WhatsApp section provides a sending screen and a sent-message report. WhatsApp account/provider setup is available in Masters.

Notifications have a date range, audience/role, image, title, description and active status. The dashboard/header retrieves notifications for the logged-in role and tracks read/unread state.

These operations call external services in the real system. They should be safe no-ops in a public demo so a trainee cannot message real contacts or spend message credits.

Code locations:

- WhatsApp screens: `Admin.php` and corresponding admin views
- Notification screens: `Masters.php` and corresponding master views
- Production message service: Java `MessageServices.java`

## 15. Reports

The All Reports page is a directory of reports grouped into:

- Masters
- Admin
- Customer
- Sales
- Service
- Complaint
- Ticket
- Lead
- Quotation
- Analysis reports
- Analysis graphs
- Team reports

The Daily Analysis Report combines leads generated, follow-ups completed/planned/pending, leads awaiting approval, resolved tickets, sales, collections and balances for a selected period and employee.

The Market Analysis/ROI Report shows lead status distribution, conversion rate, employee performance and reference-source performance.

Code locations:

- Controller: `application/modules/vendor/controllers/Reports.php`
- Views: `application/modules/vendor/views/reports/`
- Main methods: `all_reports()`, `daily_analysis_report()` and `roi_report()`

## 16. External Lead Integrations

The live Integrations page currently shows:

- IndiaMART: configured
- Facebook/Meta Lead Ads: connected to the MI-BTrack CRM Facebook page

The page provides Configure and Test Connection controls. The inspection did not press them because OAuth, token refresh and test calls can affect the connected account.

### Expected integration flow

```text
Vendor opens Integrations
    ↓
Vendor configures IndiaMART key or starts Facebook OAuth
    ↓
Connection is stored against the logged-in vendor/company/branch
    ↓
External service sends or exposes new lead data
    ↓
Backend normalizes the lead fields
    ↓
Lead is stored in Customer Lead Master
    ↓
Reference identifies IndiaMART/Facebook as the source
    ↓
Lead appears in dashboard and All Lead Report
```

PHP integration code:

- Controller methods: `Admin.php::integrations()`, `configure_integration()`, `meta_connect()` and `meta_test_connection()`
- View: `application/modules/vendor/views/admin/integrations.php`
- PHP API wrapper: `application/libraries/Api.php`
- API URLs: `application/config/constants.php`

Original Java integration code:

- `btrack_server_cmp01/src/main/java/com/btrack/src/services/IntegrationService.java`
- `btrack_server_cmp01/src/main/java/com/btrack/src/dao/IntegrationDao.java`
- `btrack_server_cmp01/src/main/java/com/btrack/src/util/MetaApiClient.java`
- Database scripts: `db_migrations/`

For any new lead provider, use the same pattern: provider configuration, company/branch ownership, connection status, test action, normalized lead ingestion, source reference and duplicate protection.

## 17. How the Original Application Is Built

The original project uses this request flow:

```text
Browser request
    ↓
CodeIgniter route
    ↓
Vendor PHP controller
    ↓
Api.php builds a request with auth key and positional fields
    ↓
Java Jersey REST service on Tomcat
    ↓
DAO method
    ↓
Oracle SQL or stored procedure
    ↓
DTO serialized as JSON
    ↓
PHP controller passes data to a view or AJAX table
```

There are three primary PHP API channels:

- `call_api()` for administration/Mauli APIs
- `call_v_api()` for the main vendor CRM API
- `call_i_api()` for inventory APIs

The Java services are thin endpoint layers. Most database and business behavior is inside large DAO classes, SQL constants and Oracle stored procedures.

## 18. How the Local Demo Works

The runnable local demo is currently in `_build/`. The `demo/` folder is empty and appears intended for a future static export.

Its request flow is:

```text
Browser request
    ↓
Original CodeIgniter vendor controller
    ↓
Replacement Api.php
    ↓
MockData method
    ↓
Synthetic rows from MockSeed
    ↓
Original controller and view render the result
```

Important demo files:

- `_build/application/libraries/Api.php`: dispatches API method names to mocks.
- `_build/application/libraries/MockData.php`: shapes responses like the Java API.
- `_build/application/libraries/MockSeed.php`: contains synthetic baseline records.
- `_build/application/config/config.php`: points CodeIgniter to the local demo URL.
- `tools/routes.json`: discovered vendor routes and their classification.
- `tools/smoke.py`: visits all detected page routes and records errors/missing mocks.
- `tools/smoke_report.json`: latest stored smoke-test report.

The demo implements the main sample-data paths plus a growing set of shared lookup APIs. Unknown API methods return an empty array and are written to `_build/mock_missing.log`. This lets many pages render, but it does not mean that every table or action is functional.

Current demo strengths:

- Login and session shell
- Sidebar navigation
- Dashboard reminders
- Synthetic branch, product, service, lead, customer, ticket and reminder data
- Most vendor pages render with their original layout

Current demo limitations:

- Most create/edit/deactivate actions are not mocked.
- File uploads and downloads are placeholders.
- External messages, payments and OAuth must not call real services.
- Some successful pages are empty because their API method is not mocked.
- The latest smoke report has 278 routes: all 278 returned a clean HTTP 200 with no PHP error text in the response.
- The final static exporter/runtime mentioned in comments does not yet exist.

## 19. Where to Make Each Type of Change

| Required change | Main place to change |
|---|---|
| Page wording, fields or layout | `_build/application/modules/vendor/views/<area>/` for demo; mirror intentionally into the original project if it is a production change |
| Request validation or page flow | Vendor controller such as `Leads.php`, `Customers.php`, `Admin.php`, `Masters.php`, `Reports.php` or `Inventory.php` |
| Report table rows and AJAX output | `Ajax.php` or `Ajax_inventory.php` |
| Shared header/sidebar/footer | `views/_parts/header.php` or `views/_parts/footer.php` |
| Demo API response | `_build/application/libraries/MockData.php` |
| Demo sample records | `_build/application/libraries/MockSeed.php` |
| Demo API routing/fallback | `_build/application/libraries/Api.php` |
| Production vendor endpoint | Java `MenuProviderService.java` and the matching DAO method |
| Production inventory endpoint | Java `MenuProviderInventoryService.java` and `MenuListInventoryDao.java` |
| Database query or procedure call | Java `Queries*.java`, DAO code and/or an Oracle migration |
| Meta/IndiaMART integration | PHP integration page/controller plus Java `IntegrationService`, `IntegrationDao` and provider client |
| Menu availability by role | Production permission/menu records; `MockData::getMenuDashboardWebDetails()` for demo |
| API host/base URL | `application/config/constants.php` and CodeIgniter `config.php` |

Do not put secrets, live customer data, production tokens, payment keys or message-provider credentials into the demo.

## 20. Recommended Order for Completing the Demo

1. Keep the original views and controllers wherever possible for visual accuracy.
2. Decide the exact pages that must be interactive, rather than treating every HTTP 200 page as complete.
3. Implement the missing read/list mock APIs for those pages.
4. Implement safe session-only create, edit, transfer, approval and deactivate operations using the existing mock overlay.
5. Make external side effects safe: mock WhatsApp, email, payments, OAuth, uploads and downloads.
6. Add realistic synthetic records without copying live names, phone numbers or addresses.
7. Run route smoke tests, then manually verify the main end-to-end journey:

```text
Demo login
→ Dashboard
→ Add lead
→ Lead report
→ Follow-up/transfer/approve
→ Convert to customer
→ Add service/payment
→ Raise ticket/complaint
→ Check scheduler and reports
```

8. Implement the remaining workflow-critical mock calls listed in `_build/mock_missing.log`.
9. Build the intended standalone/static output in `demo/` only after the `_build/` version is stable.
10. Recheck every external link and endpoint before distributing the demo.

## 21. Quick Developer Rule

When a page is incorrect, trace it in this order:

```text
URL
→ controller method
→ API method name and parameters
→ MockData response for demo OR Java service/DAO for production
→ returned field names
→ AJAX formatter if present
→ PHP view
```

The most common demo problem will be a mock response whose field names or envelope do not exactly match what the original controller/view expects. Preserve the production response shape even when the demo data is synthetic.

## 22. Demo Alignment Status (8 September 2026)

The first workflow-alignment pass is complete. It focused on the shared data needed before the larger lead-to-customer flow can be made fully interactive.

Implemented in the demo:

- Permission/designation, department, sub-department and education lookup data.
- Synthetic employee hierarchy for Demo Admin, Demo Sales and Demo Technician.
- Employee report/detail, reporting-to and duplicate-mobile mock APIs.
- Session-only employee creation. A created employee appears in the AJAX employee report and disappears when the demo session is reset.
- State, district, city, area and reference-source lookup data.
- Customer/company selectors used by other modules.
- Safe demo-only IndiaMART and Meta integration status responses; no real credentials or external calls are used.
- Valid redirects for the three old broken routes: `admin/demo`, `dashboard/my_profile` and `dashboard/change_password`.
- Compatibility between the current add-employee form and its controller: optional fields no longer cause undefined-key failures, and the newer text city/state fields coexist with the old API parameter shape.

Verification results:

- PHP syntax checks passed for all changed files.
- The local login and add-employee form load correctly.
- Department selection dynamically loads its sub-departments.
- A synthetic employee was submitted successfully and found in the employee AJAX report.
- Full smoke test: 278 of 278 vendor page routes returned clean HTTP 200 responses; zero non-200 pages and zero PHP problems were found in response bodies.
- Missing mock/API calls dropped from 44 to 29.

The demo is now aligned at the navigation and employee-foundation level, but it is not yet a complete business simulation. The next planning pass should prioritize the main journey in this order:

```text
Create and assign lead
→ follow-up / transfer / approve
→ convert lead to customer
→ attach service, invoice and payment
→ create and assign ticket or complaint
→ verify dashboard graphs and business reports
```

The remaining 29 missing calls are concentrated in FAQ, inventory reports, customer billing/subscription/ticket details, dashboard graphs, team assignment, permissions and terms. Use `tools/smoke_report.json` and `_build/mock_missing.log` as the live checklist rather than assuming that an HTTP 200 page is fully functional.

## 23. Connected Error and Recovery Flow

The demo now uses a shared workflow-guidance layer instead of leaving empty reports blank or showing only generic errors. It is implemented in:

- `_build/assets/js/demo-workflow-guide.js`
- `_build/assets/css/demo-workflow-guide.css`
- `_build/application/modules/vendor/views/_parts/footer.php`

The layer handles these situations consistently:

| Situation | What the user sees | Recovery action |
|---|---|---|
| A report contains zero records | The missing record type, why it is needed and a three-step recovery procedure | A direct `Add ...` or `Open ...` button |
| A form has no selectable prerequisite | A blocking setup message listing every missing prerequisite | One button for each required master/record |
| A record ID is invalid or no longer exists | The server's error message enhanced with a contextual action | A button to create or return to the relevant record type |
| A report already has records | No workflow warning is displayed | Normal report flow continues |
| A user submits or deactivates a record | Clear confirmation wording describing what will happen | Confirm or cancel without ambiguity |

Connected examples include:

- Employee assignment → designation, department and reporting employee.
- Lead creation → product/service and reference source.
- Ticket, service ticket and complaint → customer and employee assignment.
- Quotation → customer/lead and product/service setup.
- Purchase order → supplier; inward entry → purchase order; supplier payment → supplier liability/bill.
- Inventory item → category, brand, unit and storage location.
- Sub-department → parent department; shelf → parent storage area.
- All principal employee, lead, customer, ticket, complaint, quotation, inventory and master reports → their matching create screen.

Verification performed after implementation:

- Empty FAQ report displayed `No FAQ found`, the explanation and a working `Add FAQ` button.
- Purchase-order form with no suppliers displayed a blocking prerequisite message and a working `Add Supplier` button.
- Populated employee report displayed its records without a false empty-state warning.
- An invalid employee detail URL redirected to the employee report, displayed `Employee Details not found` and added an `Add Employee` button.
- Deactivation confirmation explained that the record becomes unavailable for new transactions while history remains and reactivation is possible.
- jQuery was moved before inline page scripts, removing the `$ is not defined` browser errors exposed during verification.
- A clean browser verification tab reported no console warnings or errors.
- Full regression remained 278 clean HTTP 200 responses, zero non-200 responses and zero PHP problems in response bodies.

When another module is added later, add one route rule and its prerequisite selectors to `demo-workflow-guide.js`. Do not create a separate one-off empty-state implementation unless the page has a genuinely unique recovery procedure.
# Interactive Guided Demo

The local demo Dashboard now launches three persistent narrated tours: **Core**, **AMC**, and **Full operations**. The player uses the actual vendor pages, highlights controls, types story data, and applies lifecycle actions to the current session's mock overlay. It supports English, Hindi, and Marathi captions/narration, pause/resume, previous/next, take-control mode, and private-session reset.

The voice-production handoff, exact data story, file naming rules, and ElevenLabs workflow are documented in `DEMO_TOUR_VOICE_PACK.md`. The synchronized narration strings and step order live in `_build/assets/js/demo-tour-content.js`.
