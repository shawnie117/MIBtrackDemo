/* Build the browser-ready Full Demo from the approved Markdown plan.
 * The parser only copies blockquoted source wording; it never rewrites it.
 */
'use strict';

const fs = require('fs');
const path = require('path');

const root = path.resolve(__dirname, '..');
const source = path.join(root, 'DEMO_FULL_SHORT_TEXT_PLAN.md');
const translationSource = path.join(root, 'tools', 'demo-tour-translations.json');
const output = path.join(root, '_build', 'assets', 'js', 'demo-tour-content.js');
const translations = JSON.parse(fs.readFileSync(translationSource, 'utf8'));
// Full Demo updates must not silently rewrite the separately scoped Short Demo.
const previous = { window: {} };
require('vm').runInNewContext(fs.readFileSync(output, 'utf8'), previous);
const shortSteps = previous.window.MIB_TOUR_CONTENT.short;

const screens = {
  F01: ['vendor/dashboard', '.page-content'],
  F02: ['vendor/masters/add_sale_product', '#pdt_name'],
  F03: ['vendor/masters/add_amc', '#amc_name'],
  F04: ['vendor/masters/add_one_time_service', '#ots_name'],
  F05: ['vendor/masters/add_reference', '#ref_name'],
  F06: ['vendor/dashboard', '.page-content'],
  F07: ['vendor/leads/add_lead', '[data-target="#reference_section"]'],
  F08: ['vendor/leads/view_lead?id=NzAwOA%3D%3D', 'a[title="Add Follow-up"]'],
  F09: ['vendor/dashboard', '.page-content'],
  F10: ['vendor/customers/add_customer', '#cust_name'],
  F11: ['vendor/customers/view_customer?id=NjAxMw%3D%3D', '.followuptbl:has(a[title="Click To Schedule"])'],
  F12: ['vendor/customers/view_customer?id=NjAxMw%3D%3D', '[title*="Download Invoice"]'],
  F13: ['vendor/customers/view_customer?id=NjAxMw%3D%3D', 'a[title="Add Follow-up"]'],
  F14: ['vendor/admin/add_employee', '#emp_name'],
  F15: ['vendor/admin/employee_report', '.portlet.light.bordered'],
  F16: ['vendor/customers/add_ticket', '#tkt_title'],
  F17: ['assets/demo-mobile/index.html?screen=tickets&connected=1', '#ticket-list'],
  F18: ['vendor/customers/ticket_report', '.portlet.light.bordered'],
  F19: ['vendor/reports/add_quotation', '#p_quote_name'],
  F20: ['vendor/reports/quotation_report', '.portlet.light.bordered'],
  F21: ['vendor/reports/daily_analysis_report', '.portlet.light.bordered'],
  F22: ['vendor/reports/roi_report', '.roi-dashboard'],
  F23: ['vendor/reports/all_reports', '.portlet.light.bordered']
};

const cues = {
  F02: [
    ['type', '#pdt_name', 'Rat Repellent']
  ],
  F03: [
    ['type', '#amc_name', 'General Pest Management']
  ],
  F04: [
    ['type', '#ots_name', 'General OTS']
  ],
  F05: [
    ['type', '#ref_name', 'Google']
  ],
  F06: [
    ['navigate', 'vendor/leads/add_lead', null, null, '#lead_name'],
    ['type', '#lead_name', 'Ambar Patil']
  ],
  F07: [
    ['type', '#lead_name', 'Ambar Patil'],
    ['expand', '[data-target="#additional_details"]', null, null, '#additional_details'],
    ['expand', '[data-target="#reference_section"]', null, null, '#reference_section'],
    ['select', '#lead_refby', null, 'Google'],
    ['expand', '[data-target="#alt_contact_section"]', null, null, '#alt_contact_section'],
    ['type', '.lead_altcontact', '4578325451']
  ],
  F08: [
    ['click', 'a[title="Add Follow-up"]'],
    ['type', '#followup_feedback', 'Need Followup']
  ],
  F09: [
    ['focus', '.todays-my-followups'],
    ['navigate', 'vendor/leads/add_lead', null, null, '#lead_productid']
  ],
  F10: [
    ['select', '#cust_service_type', null, 'AMC'],
    ['select', '#cust_gst_type', null, 'With GST'],
    ['type', '#cust_gstno', 'XXXXXXXX1234'],
    ['type', '#cust_name', 'Adinath Mhaske'],
    ['type', '#cust_contact', '4152488895'],
    ['type', '#cust_contact_email', 'aadinath@gmail.com'],
    ['type', '#cust_address', 'Swastik niwas, khandagale vasti, Mumbai.'],
    ['date', '#cust_ui_date'],
    ['type', '#amcSearch', 'General Pest Management'],
    ['click', '#tbl_service_id input[type="checkbox"][value="4009"]'],
    ['click', '.btn-show-services'],
    ['focus', '#serviceModal1 #tbl_service_details tr'],
    ['click', '#serviceModal1 button.close'],
    ['focus', '#cust_total_amount'],
    ['select', '#full_payment_section #company_pay_type', null, 'Cash'],
    ['type', '#full_payment_section #cust_paid_amount', '1000'],
    ['select', '#cust_refbyid', null, 'Google'],
    ['type', '#alt_cust_contact', '2254632584']
  ],
  F11: [
    ['focus', 'button[onclick^="openCompleteServiceModal"]'],
    ['focus', 'a[title="Click To Schedule"]'],
    ['navigate', 'vendor/dashboard', null, null, '.pending-services-reminder'],
    ['navigate', 'vendor/customers/view_customer?id=NjAxMw%3D%3D', null, null, 'a[title="Add Follow-up"]'],
    ['focus', 'a[title="Make Payment"]'],
    ['navigate', 'vendor/dashboard', null, null, '.payment-defaulter-reminder']
  ],
  F13: [
    ['click', 'a[title="Add Follow-up"]'],
    ['type', '#followup_feedback', 'service pending'],
    ['select', '#followupstatusid', null, 'Pending'],
    ['select', '#followupfor', null, 'Routine'],
    ['click', '#visitRadio'],
    ['dateTime', '#next_update_date']
  ],
  F14: [
    ['type', '#emp_name', 'Prajyot'],
    ['type', '#emp_mob1', '8546951251'],
    ['focus', '#emp_rpt_to'],
    ['select', '#permission_id', null, 'Employee'],
    ['select', '#department_id', null, 'Servicing'],
    ['select', '#location_tracking', 'Yes'],
    ['type', '#emp_joining_date', '12/12/2012'],
    ['type', '#emp_address', 'kiran apartment, Shambhu nagar, Mumbai.'],
    ['focus', '#emp_bank_account_name'],
    ['focus', '#mybutton']
  ],
  F15: [
    ['navigate', 'vendor/admin/view_employee?id=NTAwNQ%3D%3D', null, null, '.portlet.light.bordered'],
    ['focus', '.page-content table tr:has(th):nth-child(4)'],
    ['navigate', 'assets/demo-mobile/index.html?screen=login&connected=1', null, null, '#mobile-user'],
    ['type', '#mobile-user', '8546951251'],
    ['type', '#mobile-password', 'demo123'],
    ['click', '#mobile-login'],
    ['type', '#mobile-otp', '123456'],
    ['click', '#verify-otp'],
    ['click', '#mobile-back'],
    ['click', '#employee-attendance'],
    ['click', '#attendance-login'],
    ['click', '#submit-selfie'],
    ['click', '#attendance-logout'],
    ['click', '#submit-selfie'],
    ['navigate', 'vendor/admin/emp_attendance_report', null, null, '.portlet.light.bordered']
  ],
  F16: [
    ['click', 'input[name="cust_type"][value="Customers"]'],
    ['select', '#ref_id', null, 'Adinath Mhaske'],
    ['type', '#tkt_title', 'Visit for service.'],
    ['select', '#ticket_priority', null, 'High'],
    ['type', '#ticket_desc', 'Provide the GPM service properly.'],
    ['select', '#ticket_assign_to', null, 'Prajyot'],
    ['dateTime', '#ticket_date'],
    ['storySave', '#add_edit_form_btn', 'ticket_prepare']
  ],
  F17: [
    ['click', '#sample-ticket'],
    ['focus', '#customer-details'],
    ['focus', '#ticket-details'],
    ['click', '#ticket-menu'],
    ['click', '#start-ticket-option'],
    ['type', '#start-remark', 'Starting Work'],
    ['click', '#start-ticket-submit'],
    ['click', '#ticket-menu'],
    ['click', '#update-ticket-option'],
    ['type', '#ticket-review', 'Service done'],
    ['type', '#ticket-description', 'General pest management service completed.'],
    ['select', '#ticket-work-type', 'Service'],
    ['select', '#ticket-status', 'Resolved'],
    ['click', '#work-photo'],
    ['click', '#update-submit'],
    ['click', '#add-signature'],
    ['click', '#submit-ticket']
  ],
  F18: [
    ['navigate', 'vendor/dashboard/story_ticket', null, null, '.page-content table'],
    ['focus', 'table:has(th:nth-child(7))'],
    ['navigate', 'vendor/customers/ticket_summary_report', null, null, '.ticket-summary-page'],
    ['focus', '#employee_ticket_summary tr:last-child']
  ],
  F19: [
    ['click', 'input[name="cust_type"][value="Customers"]'],
    ['select', '#ref_id', null, 'Adinath Mhaske'],
    ['select', '#p_quote_priorty', null, 'High'],
    ['select', '#gst_applicable', null, 'GST Applicable'],
    ['focus', '#p_quote_date'],
    ['type', '#p_quote_name', 'Adinath Mhaske'],
    ['type', '#p_quote_address', 'Swastik niwas, khandagale vasti, Mumbai'],
    ['type', '#p_quote_contact', '4152488895'],
    ['type', '#p_quote_subject', 'Quotation for general pest management service'],
    ['type', '#p_quote_desc', 'Test description'],
    ['select', '#cust_service_type', null, 'AMC'],
    ['select', '#tbl_service_details select[name="service_id[]"]', null, 'General Pest Management'],
    ['type', '#tbl_service_details input[name="desc1[]"]', 'In this AMC, we are providing six services.'],
    ['focus', '#tbl_desc_details']
  ],
  F21: [
    ['focus', '#user_id'],
    ['focus', '#tbl_today_leads_list'],
    ['focus', '#tbl_today_followup_list'],
    ['focus', '#tbl_pending_followup_list'],
    ['focus', '#tbl_all_ticket_list'],
    ['focus', '#tbl_collection_list'],
    ['focus', '#from_date']
  ],
  F22: [
    ['focus', '#total_leads'],
    ['focus', '#conversion_rate'],
    ['focus', '#emp_bars'],
    ['focus', '#roi_table_body'],
    ['focus', '#reference_roi_table'],
    ['focus', '#employee_roi_table']
  ],
  F23: [
    ['expand', 'a[href="#task-1-2"]', null, null, '#task-1-2'],
    ['expand', 'a[href="#task-4-1"]', null, null, '#task-4-1'],
    ['expand', 'a[href="#task-2-2"]', null, null, '#task-2-2'],
    ['expand', 'a[href="#task-4-2"]', null, null, '#task-4-2'],
    ['expand', 'a[href="#task-3-2"]', null, null, '#task-3-2'],
    ['expand', 'a[href="#task-8-2"]', null, null, '#task-8-2'],
    ['expand', 'a[href="#task-6-9"]', null, null, '#task-6-9'],
    ['expand', 'a[href="#task-5-2"]', null, null, '#task-5-2'],
    ['expand', 'a[href="#task-2-3"]', null, null, '#task-2-3'],
    ['expand', 'a[href="#task-6-2"]', null, null, '#task-6-2'],
    ['expand', 'a[href="#task-2-4"]', null, null, '#task-2-4']
  ]
};

// The clip is the clock. These positions follow the subject's first mention
// in the approved spoken script, rather than starting all actions together.
const cueAt = {
  F02: [.78], F03: [.27], F04: [.78], F05: [.80], F06: [.86, .93],
  F07: [0, .01, .03, .11, .27, .34], F08: [.05, .44],
  F09: [.37, .80],
  F10: [.13, .17, .22, .27, .30, .33, .38, .43, .46, .49, .51, .53, .62, .65, .70, .74, .82, .88],
  F11: [.13, .28, .42, .64, .72, .91],
  F13: [.05, .28, .42, .52, .58, .75],
  F14: [.18, .24, .30, .34, .62, .70, .77, .81, .86, .94],
  F15: [.04, .11, .26, .30, .32, .34, .37, .40, .45, .48, .53, .57, .64, .68, .76],
  F16: [.13, .24, .34, .44, .57, .74, .84, .95],
  F17: [.06, .16, .23, .30, .34, .38, .43, .49, .51, .56, .62, .72, .78, .86, .90, .93, .95],
  F18: [.13, .36, .56, .72],
  F19: [.13, .21, .27, .34, .39, .42, .46, .49, .57, .65, .76, .80, .84, .91],
  F21: [.25, .37, .44, .51, .58, .65, .85],
  F22: [.21, .29, .35, .48, .65, .79],
  F23: [.09, .21, .27, .33, .40, .57, .62, .68, .80, .86, .94]
};

function cueObject(row, index, id) {
  const [kind, selector, value, label, target] = row;
  const at = cueAt[id] && cueAt[id][index];
  if (at === undefined) throw new Error(`${id} cue ${index} has no narration time`);
  const item = { id: `${kind}-${index}`, kind, selector, at };
  if (value !== null && value !== undefined) item.value = value;
  if (label) item.label = label;
  if (target) item.target = target;
  return item;
}

const markdown = fs.readFileSync(source, 'utf8').replace(/\r\n/g, '\n');
const matches = [...markdown.matchAll(/^### (F\d{2}) ([^\n]+)\n([\s\S]*?)(?=^### F\d{2} |^## 4\.|\z)/gm)];
if (matches.length !== 23) throw new Error(`Expected 23 Full Demo sections, found ${matches.length}`);

const steps = matches.map((match) => {
  const id = match[1];
  const body = match[3];
  const quotes = body.split('\n').filter(line => line.startsWith('>')).map(line => line.replace(/^> ?/, ''));
  const paragraphs = [];
  let current = [];
  for (const line of quotes) {
    if (!line.trim()) { if (current.length) paragraphs.push(current.join(' ')); current = []; }
    else current.push(line.trim());
  }
  if (current.length) paragraphs.push(current.join(' '));
  const [url, selector] = screens[id];
  const sourceText = paragraphs.join('\n\n');
  const translated = translations[id.toLowerCase()];
  if (!translated || translated.mr !== sourceText || !translated.hi || !translated.en) {
    throw new Error(`${id} translations are missing or the approved Marathi source has drifted`);
  }
  const step = {
    id: id.toLowerCase(),
    chapter: { mr: id, hi: id, en: id },
    url,
    selector,
    title: { mr: match[2].trim(), hi: match[2].trim(), en: match[2].trim() },
    text: { mr: translated.mr, hi: translated.hi, en: translated.en }
  };
  if (cues[id]) step.cue = cues[id].map((row, index) => cueObject(row, index, id));
  if (id === 'F15') step.prepare = 'attendance_prepare';
  if (id === 'F17') step.prepare = 'ticket_prepare';
  return step;
});

const banner = `/* AUTO-GENERATED from DEMO_FULL_SHORT_TEXT_PLAN.md and tools/demo-tour-translations.json.\n * Run: node tools/build_full_demo_content.js\n * Marathi narration is copied exactly from the approved document plan; Hindi and English are aligned translations.\n */\n`;
const browser = `${banner}(function (w) {\n  'use strict';\n  var full = ${JSON.stringify(steps, null, 2)};\n  w.MIB_TOUR_CONTENT = {\n    full: full,\n    short: ${JSON.stringify(shortSteps, null, 2)}\n  };\n})(window);\n`;
fs.writeFileSync(output, browser, 'utf8');
console.log(`Wrote ${steps.length} Full Demo steps to ${output}`);
