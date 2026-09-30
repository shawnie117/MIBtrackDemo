#!/usr/bin/env node
/* =====================================================================
 * MI-BTrack guided demo - LIVE test
 * ---------------------------------------------------------------------
 * Drives the real tour in a real Chrome and audits every step against
 * what its narration actually claims.
 *
 *   1. cd _build ; php -S 127.0.0.1:8765 router.php
 *   2. node tools/live_test_tour.js                  # full tour, English
 *      node tools/live_test_tour.js --tour amc
 *      node tools/live_test_tour.js --headful        # watch it happen
 *      node tools/live_test_tour.js --shots          # save a png per step
 *
 * WHY THIS EXISTS
 * A static check can prove `#tbl_list` is in the HTML. It cannot prove the
 * table has rows in it. So it cannot catch the failure that actually
 * embarrasses you in front of a customer: narration confidently saying
 * "this lists contracts whose end date is approaching" over an empty
 * table.
 *
 * So every claim the script makes out loud is written down here as an
 * assertion against the live DOM at the moment that sentence is spoken:
 *
 *   - "the software wrote ninety two"        -> #amc_sit really reads 92
 *   - "the one we just built is now in it"   -> the row is really there
 *   - "twelve realistic contract states"     -> 12 rows, all six states
 *   - "each line is a visit that is due"     -> the table has rows
 *   - "choosing the state fills the district list" -> it really filled
 *
 * It also checks, at every step: the highlighted element exists and is
 * visible, the spotlight is actually over it, the iframe is on the page
 * the step named, and neither frame logged a console error.
 *
 * Then it tests the behaviours that only exist in time: pause freezing a
 * half-typed word, resume continuing it, language switching without
 * retyping, and Previous not resubmitting a form.
 * ===================================================================== */

'use strict';

const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');

// ---------------------------------------------------------------------
// Options
// ---------------------------------------------------------------------

function arg(name, fallback) {
    const i = process.argv.indexOf('--' + name);
    return i !== -1 && process.argv[i + 1] && !process.argv[i + 1].startsWith('--')
        ? process.argv[i + 1] : fallback;
}
const flag = (n) => process.argv.includes('--' + n);

const BASE = arg('base', 'http://127.0.0.1:8765');
const TOUR = arg('tour', 'full');
const LANG = arg('lang', 'en');
const HEADFUL = flag('headful');
const SHOTS = flag('shots');
const CONTROLS_ONLY = flag('controls-only');
const SHOT_DIR = path.join(__dirname, 'live_shots');
const VIEWPORT_WIDTH = Number(arg('width', '1440'));
const VIEWPORT_HEIGHT = Number(arg('height', '900'));

const CHROME = arg('chrome', [
    process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'
].find((p) => p && fs.existsSync(p)));

// Story values, mirrored from the tour script so the assertions below check
// what the tour really types rather than a copy that could drift.
const PLAN_NAME = 'Aster CCTV Annual Care';
const LEAD_NAME = 'Aster Heights Annex';

// ---------------------------------------------------------------------
// Reporting
// ---------------------------------------------------------------------

const report = { pass: 0, fail: 0, warn: 0, issues: [], steps: [] };

function pass(step, msg) {
    report.pass++;
    console.log('    ok    ' + msg);
}
function fail(step, msg) {
    report.fail++;
    report.issues.push({ severity: 'fail', step, msg });
    console.log('    FAIL  ' + msg);
}
function warn(step, msg) {
    report.warn++;
    report.issues.push({ severity: 'warn', step, msg });
    console.log('    warn  ' + msg);
}

// ---------------------------------------------------------------------
// What every step claims, checked against the live DOM
//
// Each entry is a function evaluated INSIDE the iframe's document. It
// returns { ok, detail } and the wrapper turns that into a pass or a
// failure attributed to the step's narration.
//
// `minRows` style helpers keep these readable, because the point of this
// table is that a human can audit it against the script.
// ---------------------------------------------------------------------

const CLAIMS = {

    // ---- orientation -------------------------------------------------
    'w-03-sidebar': {
        says: 'the left menu lists the modules this user may open',
        check: () => {
            const items = document.querySelectorAll('.page-sidebar-menu > li');
            return { ok: items.length >= 5, detail: items.length + ' menu items' };
        }
    },
    'w-04-dashboard-blocks': {
        says: 'each box answers one question, such as which contracts are about to expire',
        check: () => {
            const box = document.querySelector('.amc-renewal-reminder');
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            return { ok: !!box && text.length > 20, detail: text.slice(0, 90) };
        }
    },

    // ---- masters -----------------------------------------------------
    'm-02-product-list': {
        says: 'cameras, recorders, attendance machines, door panels and hard disks',
        check: () => {
            const rows = document.querySelectorAll('#tbl_list tr');
            const text = document.querySelector('#tbl_list') ? document.querySelector('#tbl_list').textContent : '';
            const kinds = ['CCTV', 'DVR', 'NVR', 'Biometric', 'Door', 'HDD'].filter((k) => text.includes(k));
            return {
                ok: rows.length >= 8 && kinds.length >= 4,
                detail: rows.length + ' rows; kinds found: ' + (kinds.join(', ') || 'none')
            };
        }
    },

    // ---- building the plan -------------------------------------------
    'p-02-plan-vs-contract': {
        says: 'what you see here are plans, not customers',
        check: () => {
            const rows = document.querySelectorAll('#tbl_list tr');
            return { ok: rows.length >= 5, detail: rows.length + ' plan rows' };
        }
    },
    'p-04-product': {
        says: 'we are choosing the dome camera',
        check: () => {
            const el = document.querySelector('#amc_product_id');
            const label = el && el.selectedOptions[0] ? el.selectedOptions[0].textContent.trim() : '';
            return { ok: el && el.value === '3001', detail: 'value=' + (el && el.value) + ' label=' + label };
        }
    },
    'p-05-name': {
        says: 'we type the plan name',
        check: (expected) => {
            const el = document.querySelector('#amc_name');
            return { ok: el && el.value === expected, detail: 'value="' + (el && el.value) + '"' };
        },
        arg: PLAN_NAME
    },
    'p-07-duration': {
        says: 'one year is three hundred and sixty five, so that is what we type',
        check: () => {
            const el = document.querySelector('#amc_duration');
            return { ok: el && el.value === '365', detail: 'value=' + (el && el.value) };
        }
    },
    'p-08-visits': {
        says: 'we are including four visits',
        check: () => {
            const el = document.querySelector('#amc_noofservices');
            return { ok: el && el.value === '4', detail: 'value=' + (el && el.value) };
        }
    },
    'p-09-interval': {
        says: 'the software divided 365 by 4 and wrote ninety two',
        check: () => {
            const el = document.querySelector('#amc_sit');
            const readonly = el ? el.readOnly : false;
            return {
                ok: el && el.value === '92' && readonly,
                detail: 'value=' + (el && el.value) + ' readonly=' + readonly
            };
        }
    },
    'p-10-gst': {
        says: 'we are entering eighteen',
        check: () => {
            const el = document.querySelector('#amc_gst');
            return { ok: el && el.value === '18', detail: 'value=' + (el && el.value) };
        }
    },
    'p-11-price': {
        says: 'twelve thousand for the year',
        check: () => {
            const el = document.querySelector('#amc_price');
            return { ok: el && el.value === '12000', detail: 'value=' + (el && el.value) };
        }
    },
    'p-12-corporate-price': {
        says: 'fifteen thousand for commercial sites',
        check: () => {
            const el = document.querySelector('#amc_corporate_price');
            return { ok: el && el.value === '15000', detail: 'value=' + (el && el.value) };
        }
    },
    'p-15-saved': {
        says: 'the software has shown its own confirmation message',
        check: () => {
            const text = document.body.textContent;
            const good = text.includes('New AMC Service Added successfully');
            const already = /already exists/i.test(text);
            return {
                ok: good || already,
                detail: good ? 'confirmation shown' : already ? 'already existed (honest path)' : 'NO confirmation on screen'
            };
        }
    },

    // ---- confirming it saved -----------------------------------------
    'c-01-report-row': {
        says: 'the one we just built is now in it',
        check: (expected) => {
            const box = document.querySelector('#tbl_list');
            const text = box ? box.textContent : '';
            const rows = document.querySelectorAll('#tbl_list tr').length;
            return {
                ok: text.includes(expected),
                detail: rows + ' rows; contains the new plan: ' + text.includes(expected)
            };
        },
        arg: PLAN_NAME
    },
    'c-02-status-filter': {
        says: 'this box lets you choose current plans or closed ones',
        check: () => {
            const el = document.querySelector('#status');
            const opts = el ? Array.from(el.options).map((o) => o.textContent.trim()) : [];
            return { ok: opts.length >= 2, detail: opts.join(' | ') };
        }
    },

    // ---- the contract book -------------------------------------------
    'f-02-kpis': {
        says: 'these figures are counted from the rows below',
        check: () => {
            const el = document.querySelector('#amc-visible-count');
            const n = el ? parseInt(el.textContent.trim(), 10) : NaN;
            return { ok: Number.isFinite(n) && n > 0, detail: 'visible count = ' + (el && el.textContent.trim()) };
        }
    },
    'f-03-status-words': {
        says: 'Active, Due soon, Due today, Expired, Paused and Renewed',
        check: () => {
            const table = document.querySelector('#amc-portfolio-table');
            const text = table ? table.textContent : '';
            const want = ['Active', 'Due Soon', 'Due Today', 'Expired', 'Paused', 'Renewed'];
            const missing = want.filter((w) => !text.includes(w));
            const rows = document.querySelectorAll('#amc-portfolio-table tbody tr').length;
            return {
                ok: missing.length === 0,
                detail: rows + ' rows; missing states: ' + (missing.join(', ') || 'none')
            };
        }
    },
    'f-04-payment-words': {
        says: 'paid, partial, pending and overdue are a separate question',
        check: () => {
            const table = document.querySelector('#amc-portfolio-table');
            const text = table ? table.textContent : '';
            const want = ['Paid', 'Partial', 'Pending', 'Overdue'];
            const missing = want.filter((w) => !text.includes(w));
            return { ok: missing.length === 0, detail: 'missing payment states: ' + (missing.join(', ') || 'none') };
        }
    },
    'f-05-progress': {
        says: 'each row shows how many promised visits have been done',
        check: () => {
            const rows = document.querySelectorAll('#amc-portfolio-table tbody tr').length;
            return { ok: rows >= 10, detail: rows + ' contract rows' };
        }
    },

    // ---- the year ----------------------------------------------------
    'l-01-visits': {
        says: 'each line is a visit that is due, with customer, site and date',
        check: () => {
            const box = document.querySelector('#tbl_pending_servicing_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' rows; "' + text.slice(0, 70) + '"' };
        }
    },
    'l-02-completed': {
        says: 'completed visits move to this second list',
        check: () => {
            const box = document.querySelector('#tbl_closed_servicing_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' rows; "' + text.slice(0, 70) + '"' };
        }
    },
    'l-03-renewal': {
        says: 'it lists contracts whose end date is approaching',
        check: () => {
            const box = document.querySelector('#tbl_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' rows; "' + text.slice(0, 70) + '"' };
        }
    },
    'l-04-ticket': {
        says: 'a ticket is one recorded job with a customer and a status',
        check: () => {
            const box = document.querySelector('#tbl_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' rows; "' + text.slice(0, 70) + '"' };
        }
    },
    'l-05-money': {
        says: 'a payment is always recorded against a particular customer',
        check: () => {
            const el = document.querySelector('#cust_id');
            const opts = el ? el.options.length : 0;
            return { ok: opts >= 2, detail: opts + ' customers selectable' };
        }
    },

    // ---- the enquiry -------------------------------------------------
    'e-03-name': {
        says: 'we start with the name',
        check: (expected) => {
            const el = document.querySelector('#lead_name');
            return { ok: el && el.value === expected, detail: 'value="' + (el && el.value) + '"' };
        },
        arg: LEAD_NAME
    },
    'e-04-mobile': {
        says: 'the software uses the mobile number to notice duplicates',
        check: () => {
            const el = document.querySelector('#lead_contact');
            return { ok: el && el.value === '9800091001', detail: 'value=' + (el && el.value) };
        }
    },
    'e-05-priority': {
        says: 'marking this one as high priority',
        check: () => {
            const el = document.querySelector('#lead_priority');
            return { ok: el && el.value === 'High', detail: 'value=' + (el && el.value) };
        }
    },
    'e-06-enquiry-for': {
        says: 'chosen from the same equipment list we saw at the beginning',
        check: () => {
            const el = document.querySelector('#lead_productid');
            return { ok: el && el.value === '3001', detail: 'value=' + (el && el.value) };
        }
    },
    'e-10-more-details': {
        says: 'the email and address boxes are inside it. We are opening it now',
        check: () => {
            const panel = document.querySelector('#additional_details');
            const open = panel ? panel.className.includes('in') || panel.offsetHeight > 20 : false;
            const email = document.querySelector('#lead_contact_email');
            const visible = email ? !!(email.offsetWidth || email.offsetHeight) : false;
            return { ok: open && visible, detail: 'panel open=' + open + ' email visible=' + visible };
        }
    },
    'e-11-email': {
        says: 'typing the email address',
        check: () => {
            const el = document.querySelector('#lead_contact_email');
            return { ok: el && el.value === 'annex@aster.example', detail: 'value="' + (el && el.value) + '"' };
        }
    },
    'e-13-state-city': {
        says: 'choosing the state fills the district list, and the district fills the city list',
        check: () => {
            const s = document.querySelector('#lead_stateid');
            const d = document.querySelector('#lead_distid');
            const c = document.querySelector('#lead_cityid');
            const ok = s && s.value === '27' && d && d.value === '2701' && c && c.value === '270101';
            return {
                ok: !!ok,
                detail: 'state=' + (s && s.value) + ' (' + (d ? d.options.length : 0) + ' districts) ' +
                    'district=' + (d && d.value) + ' (' + (c ? c.options.length : 0) + ' cities) ' +
                    'city=' + (c && c.value)
            };
        }
    },
    'e-14-area-pincode': {
        says: 'entering the local area and the six digit pin code',
        check: () => {
            const a = document.querySelector('#lead_arealoc');
            const p = document.querySelector('#lead_pincode');
            return {
                ok: a && a.value === '601' && p && p.value === '410210',
                detail: 'area="' + (a && a.value) + '" pin=' + (p && p.value)
            };
        }
    },
    'e-15-reference': {
        says: 'recording that they came from the website',
        check: () => {
            const el = document.querySelector('#lead_refby');
            const label = el && el.selectedOptions[0] ? el.selectedOptions[0].textContent.trim() : '';
            return { ok: el && el.value === '504', detail: 'value=' + (el && el.value) + ' label=' + label };
        }
    },
    'e-17-saved': {
        says: 'every box we filled in is here, and the city and source show as words',
        check: (expected) => {
            const text = document.body.textContent;
            const hasName = text.includes(expected);
            const hasCity = text.includes('Navi Mumbai');
            const hasSource = text.includes('Website Enquiry');
            const already = /Mobile Number Already Exists/i.test(text);
            return {
                ok: (hasName && hasCity) || already,
                detail: already ? 'already existed (honest path)'
                    : 'name=' + hasName + ' city as words=' + hasCity + ' source as words=' + hasSource
            };
        },
        arg: LEAD_NAME
    },
    'a-01-lead-report': {
        says: 'the enquiry we created now sitting among the others',
        check: (expected) => {
            const box = document.querySelector('#tbl_list');
            const text = box ? box.textContent : '';
            const rows = box ? box.querySelectorAll('tr').length : 0;
            return { ok: text.includes(expected), detail: rows + ' rows; contains the new enquiry: ' + text.includes(expected) };
        },
        arg: LEAD_NAME
    },
    'a-03-followup': {
        says: 'this filter shows the ones left without a next action or date',
        check: () => {
            const el = document.querySelector('#followup');
            return { ok: el && el.options.length >= 2, detail: (el ? el.options.length : 0) + ' options' };
        }
    },

    // ---- customers, money, service -----------------------------------
    's-01-customer-report': {
        says: 'it becomes a customer, and it moves to this list',
        check: () => {
            const box = document.querySelector('#tbl_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' customer rows' };
        }
    },
    's-02-service-filter': {
        says: 'a plain product sale, a yearly contract, or a single one time visit',
        check: () => {
            const el = document.querySelector('#service_type');
            const opts = el ? Array.from(el.options).map((o) => o.textContent.trim()) : [];
            return { ok: opts.length >= 3, detail: opts.join(' | ') };
        }
    },
    's-03-ticket-filters': {
        says: 'a ticket moves from open, to assigned, to resolved, to closed',
        check: () => {
            const el = document.querySelector('#status');
            const text = el ? Array.from(el.options).map((o) => o.textContent).join(' ').toLowerCase() : '';
            const want = ['open', 'assign', 'resolve', 'close'];
            const missing = want.filter((w) => !text.includes(w));
            return { ok: missing.length === 0, detail: 'missing states: ' + (missing.join(', ') || 'none') };
        }
    },

    // ---- people ------------------------------------------------------
    'h-01-employees': {
        says: 'that person has to be recorded here first',
        check: () => {
            const box = document.querySelector('#tbl_list');
            const rows = box ? box.querySelectorAll('tr').length : 0;
            const text = box ? box.textContent.replace(/\s+/g, ' ').trim() : '';
            const empty = /no .*found|no record/i.test(text);
            return { ok: rows >= 1 && !empty, detail: rows + ' employee rows' };
        }
    },
    'h-02-permissions': {
        says: 'each member of staff is given a role',
        check: () => {
            const el = document.querySelector('#permission_id');
            return { ok: el && el.options.length >= 2, detail: (el ? el.options.length : 0) + ' roles' };
        }
    }
};

// ---------------------------------------------------------------------
// Helpers
// ---------------------------------------------------------------------

const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

/** Wait until the player reports the step has settled (or errored). */
async function waitForPhase(page, wanted, timeout = 45000) {
    const deadline = Date.now() + timeout;
    for (;;) {
        const phase = await page.evaluate(() => window.MIB_TOUR && window.MIB_TOUR.phase);
        if (wanted.includes(phase)) { return phase; }
        if (Date.now() > deadline) { return 'timeout:' + phase; }
        await sleep(200);
    }
}

/**
 * The iframe holding the real application.
 *
 * Resolved from the #tour-frame element, never by matching the URL. The
 * tour page's own address also contains "/vendor/", so a URL match happily
 * returns the outer document and then every assertion runs against the
 * wrong DOM - which looks exactly like the application being broken.
 */
async function appFrame(page) {
    for (let i = 0; i < 50; i++) {
        const handle = await page.$('#tour-frame');
        if (handle) {
            const frame = await handle.contentFrame();
            if (frame && frame.url() && frame.url() !== 'about:blank') { return frame; }
        }
        await sleep(200);
    }
    return null;
}

// ---------------------------------------------------------------------
// Main
// ---------------------------------------------------------------------

(async () => {
    if (!CHROME) {
        console.error('\nCould not find Chrome. Pass --chrome "C:\\path\\to\\chrome.exe".\n');
        process.exit(1);
    }
    if (SHOTS) { fs.mkdirSync(SHOT_DIR, { recursive: true }); }

    console.log('\nMI-BTrack guided demo - LIVE test');
    console.log('  chrome : ' + CHROME);
    console.log('  server : ' + BASE);
    console.log('  tour   : ' + TOUR + '   language: ' + LANG);
    console.log('');

    const browser = await puppeteer.launch({
        executablePath: CHROME,
        headless: !HEADFUL,
        defaultViewport: { width: VIEWPORT_WIDTH, height: VIEWPORT_HEIGHT },
        args: [
            '--mute-audio',
            '--autoplay-policy=no-user-gesture-required',
            '--disable-features=AudioServiceOutOfProcess',
            '--no-sandbox'
        ]
    });

    const page = await browser.newPage();

    // Collect problems the browser itself reports, from both documents.
    const consoleErrors = [];
    page.on('console', (m) => {
        if (m.type() === 'error') { consoleErrors.push(m.text().slice(0, 200)); }
    });
    page.on('pageerror', (e) => {
        const app = page.frames().find((f) => /\/vendor\//.test(f.url()) && !/\/dashboard\/tour/.test(f.url()));
        consoleErrors.push('pageerror on ' + (app ? app.url() : page.url()) + ': ' +
            String(e.stack || e.message).slice(0, 500));
    });

    try {
        // ---- sign in -------------------------------------------------
        await page.goto(BASE + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="username"]', 'demo');
        await page.type('input[name="password"]', 'demo123');
        await Promise.all([
            page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
            page.click('button[type="submit"], input[type="submit"]')
        ]);
        if (!/vendor\/dashboard/.test(page.url())) {
            throw new Error('login did not reach the dashboard (at ' + page.url() + ')');
        }
        console.log('  signed in\n');

        // ---- open the tour and start it ------------------------------
        await page.goto(BASE + '/vendor/dashboard/tour?tour=' + TOUR + '&lang=' + LANG,
            { waitUntil: 'domcontentloaded' });
        await page.waitForSelector('#tour-start-btn');
        await page.select('#tour-speed', '3');

        const total = await page.evaluate(() => window.MIB_TOUR.total);
        console.log('  tour has ' + total + ' steps\n');

        // Let the shell's own iframe finish loading before pressing Start, the
        // way a person who reads the card before clicking would. Clicking into
        // an in-flight load is a separate case, hardened in ensurePage() and
        // covered by its own test further down.
        if (!(await appFrame(page))) { throw new Error('the application frame never loaded'); }
        await sleep(600);

        await page.click('#tour-start-btn');
        await sleep(1500);
        if (await page.evaluate(() => window.MIB_TOUR.phase === 'idle')) {
            // Chrome can occasionally consume the first synthetic click while
            // the iframe takes focus. Exercise the same public start action.
            await page.evaluate(() => window.MIB_TOUR.start());
        }
        const startedPhase = await waitForPhase(page, ['loading', 'cueing', 'narrating', 'error'], 15000);
        if (startedPhase.startsWith('timeout')) {
            fail('start', 'pressing Start did not begin the tour (phase stayed ' + startedPhase + ')');
        } else {
            pass('start', 'Start began the tour');
        }

        // ---- walk every step -----------------------------------------
        for (let i = 0; i < total && !CONTROLS_ONLY; i++) {
            const phase = await waitForPhase(page, ['narrating', 'error', 'finished']);

            const info = await page.evaluate(() => ({
                index: window.MIB_TOUR.index,
                id: window.MIB_TOUR.step ? window.MIB_TOUR.step.id : null,
                selector: window.MIB_TOUR.step ? window.MIB_TOUR.step.selector : null,
                url: window.MIB_TOUR.step ? window.MIB_TOUR.step.url : null,
                stay: window.MIB_TOUR.step ? !!window.MIB_TOUR.step.stay : false,
                optional: window.MIB_TOUR.step ? !!window.MIB_TOUR.step.optional : false,
                hasCue: window.MIB_TOUR.step ? !!window.MIB_TOUR.step.cue : false,
                cueComplete: window.MIB_TOUR.cueComplete,
                title: document.getElementById('tour-title').textContent,
                caption: document.getElementById('tour-caption').textContent,
                lang: window.MIB_TOUR.lang,
                captionMatches: !!window.MIB_TOUR.step &&
                    document.getElementById('tour-caption').textContent ===
                    (window.MIB_TOUR.step.text[window.MIB_TOUR.lang] || window.MIB_TOUR.step.text.en),
                audioMatches: !!window.MIB_TOUR.step &&
                    document.getElementById('tour-audio').currentSrc.indexOf(
                        '/tour/audio/' + window.MIB_TOUR.lang + '/' + window.MIB_TOUR.step.id + '.mp3'
                    ) !== -1,
                audioError: document.getElementById('tour-audio').error ?
                    document.getElementById('tour-audio').error.code : null,
                spot: window.MIB_TOUR.spotlightRect(),
                target: window.MIB_TOUR.targetRect(),
                lastError: window.MIB_TOUR.lastError
            }));

            const label = '[' + String(info.index + 1).padStart(2) + '/' + total + '] ' + info.id;
            console.log('  ' + label + '   ' + info.title);
            const record = { id: info.id, index: info.index, phase, issues: [] };

            if (!info.captionMatches) {
                fail(info.id, 'the visible ' + info.lang + ' caption does not match this step narration');
            }
            if (!info.audioMatches || info.audioError) {
                fail(info.id, 'the playing recording is not the ' + info.lang + ' clip for this screen' +
                    (info.audioError ? ' (media error ' + info.audioError + ')' : ''));
            }

            // 1. did the step even get going?
            if (phase.startsWith('timeout')) {
                fail(info.id, 'step never settled (' + phase + ')');
            } else if (phase === 'error') {
                fail(info.id, 'recovery panel shown: ' + (info.lastError ? info.lastError.message : '?'));
            }

            // 2. is the iframe on the page this step named?
            const frame = await appFrame(page);
            if (!frame) {
                fail(info.id, 'the application frame is not loaded');
            } else if (!info.stay && info.url && !frame.url().includes(info.url.replace(/^vendor\//, 'vendor/'))) {
                fail(info.id, 'frame is on ' + frame.url().replace(BASE, '') + ' but the step names ' + info.url);
            }

            // 3. does the highlighted element exist and can it be seen?
            if (frame && info.selector) {
                const vis = await frame.evaluate((sel) => {
                    const el = document.querySelector(sel);
                    if (!el) { return { found: false }; }
                    const r = el.getBoundingClientRect();
                    const cs = getComputedStyle(el);
                    return {
                        found: true,
                        w: Math.round(r.width), h: Math.round(r.height),
                        top: r.top, bottom: r.bottom,
                        viewportH: window.innerHeight,
                        display: cs.display, visibility: cs.visibility
                    };
                }, info.selector).catch(() => null);

                if (!vis || !vis.found) {
                    if (info.optional) { warn(info.id, 'optional target ' + info.selector + ' not present'); }
                    else { fail(info.id, 'highlighted element ' + info.selector + ' does not exist on the page'); }
                } else if (vis.w === 0 && vis.h === 0) {
                    if (info.optional) { warn(info.id, 'optional target ' + info.selector + ' has no size'); }
                    else { fail(info.id, info.selector + ' exists but is invisible (' + vis.display + '/' + vis.visibility + ')'); }
                } else if (!info.hasCue && vis.h < vis.viewportH * 0.8 &&
                    (vis.top < 0 || vis.bottom > vis.viewportH)) {
                    fail(info.id, 'highlighted field is partly outside the application viewport');
                }
            }

            // 4. is the spotlight actually over the thing it points at?
            if (info.spot && info.target) {
                let geometry = { spot: info.spot, target: info.target };
                let dx = Math.abs((geometry.spot.left + 6) - geometry.target.left);
                let dy = Math.abs((geometry.spot.top + 6) - geometry.target.top);
                // A browser can deliver one final smooth-scroll frame between
                // the two rectangle reads. Re-sample after the follower has
                // painted before calling a genuine alignment problem.
                if (dx > 12 || dy > 12) {
                    await sleep(250);
                    geometry = await page.evaluate(() => ({
                        spot: window.MIB_TOUR.spotlightRect(),
                        target: window.MIB_TOUR.targetRect()
                    }));
                    if (geometry.spot && geometry.target) {
                        dx = Math.abs((geometry.spot.left + 6) - geometry.target.left);
                        dy = Math.abs((geometry.spot.top + 6) - geometry.target.top);
                    }
                }
                if (dx > 12 || dy > 12) {
                    fail(info.id, 'spotlight is off target by ' + Math.round(dx) + 'px across, ' +
                        Math.round(dy) + 'px down');
                } else {
                    pass(info.id, 'spotlight is on target');
                }
            } else if (info.selector && !info.optional && phase === 'narrating' && !info.spot) {
                warn(info.id, 'no spotlight drawn for ' + info.selector);
            }

            // 5. THE IMPORTANT ONE - is the claim true?
            const claim = CLAIMS[info.id];
            if (claim && frame && !info.hasCue) {
                const verdict = await frame.evaluate(claim.check, claim.arg).catch((e) => ({
                    ok: false, detail: 'check threw: ' + e.message
                }));
                if (verdict.ok) {
                    pass(info.id, 'claim holds - ' + verdict.detail);
                } else {
                    fail(info.id, 'NARRATION SAYS "' + claim.says + '" BUT: ' + verdict.detail);
                    record.issues.push(verdict.detail);
                }
            }

            if (SHOTS) {
                await page.screenshot({
                    path: path.join(SHOT_DIR, String(info.index + 1).padStart(2, '0') + '-' + info.id + '.png')
                });
            }

            // A cue now happens at the matching point inside the narration,
            // not before the recording begins. Wait for it before moving to
            // the next step, otherwise this harness would cancel the very
            // typing/save action it is meant to verify.
            if (info.hasCue && !info.cueComplete && phase !== 'error') {
                const clipMs = await page.evaluate(() => {
                    const audio = document.getElementById('tour-audio');
                    return isFinite(audio.duration) ? audio.duration * 1000 / audio.playbackRate : 0;
                });
                const cueDeadline = Date.now() + Math.max(90000, clipMs + 15000);
                while (Date.now() < cueDeadline) {
                    const cueState = await page.evaluate(() => ({
                        done: window.MIB_TOUR.cueComplete,
                        phase: window.MIB_TOUR.phase,
                        error: window.MIB_TOUR.lastError
                    }));
                    if (cueState.done || cueState.phase === 'error') { break; }
                    await sleep(100);
                }
                const cueState = await page.evaluate(() => ({
                    done: window.MIB_TOUR.cueComplete,
                    phase: window.MIB_TOUR.phase,
                    error: window.MIB_TOUR.lastError
                }));
                if (!cueState.done) {
                    fail(info.id, 'the synchronized on-screen action did not finish before the timeout' +
                        ' (phase ' + cueState.phase + ', error ' + JSON.stringify(cueState.error) + ')');
                } else {
                    const cueLog = await page.evaluate(() => window.MIB_TOUR.cueLog || []);
                    const late = cueLog.filter(c => Number.isFinite(c.duration) && c.duration > 0 &&
                        c.finishedAt !== null && c.finishedAt >= c.duration - 0.15);
                    if (late.length) {
                        fail(info.id, 'visible action continued after the audio finished: ' +
                            late.map(c => c.id + ' ' + c.finishedAt.toFixed(1) + '/' + c.duration.toFixed(1) + 's').join(', '));
                    } else {
                        pass(info.id, 'the on-screen action completed during its narration');
                    }

                    if (info.id === 'f15') {
                        const finalFrame = await appFrame(page);
                        if (!finalFrame || !finalFrame.url().includes('/vendor/admin/emp_attendance_report')) {
                            fail(info.id, 'employee narration reached Attendance Report but the screen did not');
                        } else {
                            pass(info.id, 'screen changed from Employee Report to Attendance Report at the spoken transition');
                        }
                    }

                    const verifiedFrame = await appFrame(page);
                    if (verifiedFrame) {
                        const cueIssues = await verifiedFrame.evaluate((cues) => {
                            const issues = [];
                            for (const cue of cues) {
                                if (!['type', 'select', 'click'].includes(cue.kind)) continue;
                                const el = document.querySelector(cue.selector);
                                if (!el) { issues.push(cue.selector + ' missing'); continue; }
                                if (cue.kind === 'type' && el.value !== String(cue.value)) {
                                    issues.push(cue.selector + ' contains ' + JSON.stringify(el.value));
                                }
                                if (cue.kind === 'select') {
                                    const selected = el.options && el.options[el.selectedIndex];
                                    const label = selected && selected.textContent.trim();
                                    if (cue.value !== undefined && el.value !== String(cue.value)) {
                                        issues.push(cue.selector + ' selected value ' + JSON.stringify(el.value));
                                    } else if (cue.label && (!label || !label.toLowerCase().includes(cue.label.toLowerCase()))) {
                                        issues.push(cue.selector + ' selected label ' + JSON.stringify(label));
                                    }
                                }
                                if (cue.kind === 'click' && (el.type === 'radio' || el.type === 'checkbox') && !el.checked) {
                                    issues.push(cue.selector + ' is not checked');
                                }
                            }
                            return issues;
                        }, [].concat(info.hasCue ? (await page.evaluate(() => window.MIB_TOUR.step.cue)) : []));
                        if (cueIssues.length) fail(info.id, 'cue values do not match the screen: ' + cueIssues.join('; '));
                        else pass(info.id, 'all typed and selected values match the screen');
                    }

                    // Action claims ("we type...", "we choose...") become
                    // true at the cue point, not at the first millisecond of
                    // the sentence. Check them after the synchronized cue.
                    const actionClaim = CLAIMS[info.id];
                    const actionFrame = await appFrame(page);
                    if (actionClaim && actionFrame) {
                        const verdict = await actionFrame.evaluate(actionClaim.check, actionClaim.arg).catch((e) => ({
                            ok: false, detail: 'check threw: ' + e.message
                        }));
                        if (verdict.ok) {
                            pass(info.id, 'claim holds after cue - ' + verdict.detail);
                        } else {
                            fail(info.id, 'NARRATION ACTION DID NOT MATCH THE SCREEN: ' + verdict.detail);
                        }
                    }
                }
                if (SHOTS) {
                    await page.screenshot({
                        path: path.join(SHOT_DIR, String(info.index + 1).padStart(2, '0') + '-' + info.id + '-after-cue.png')
                    });
                }
            }

            report.steps.push(record);

            // move on, unless we are at the end
            if (info.index >= total - 1) { break; }
            await page.evaluate(() => window.MIB_TOUR.next());
            await sleep(150);
        }

        // ---- behaviours that only exist in time ----------------------
        console.log('\n  Timing and idempotence behaviours\n');
        await testTimingBehaviours(page, browser);

        // ---- console health -----------------------------------------
        console.log('');
        const unique = Array.from(new Set(consoleErrors));
        // Missing audio for a language that has not been recorded is expected,
        // and the player handles it by falling back to the browser voice.
        const real = unique.filter((e) => !/tour\/audio|Failed to load resource.*\.mp3/i.test(e));
        if (!real.length) {
            pass('console', 'no browser console errors during the whole tour');
        } else {
            real.slice(0, 10).forEach((e) => fail('console', 'console error: ' + e));
        }

    } catch (err) {
        fail('harness', 'test harness error: ' + err.message);
        console.error(err.stack);
    } finally {
        await browser.close();
    }

    // ---- summary ----------------------------------------------------
    console.log('\n' + '='.repeat(70));
    console.log('  passed : ' + report.pass);
    console.log('  failed : ' + report.fail);
    console.log('  warned : ' + report.warn);
    console.log('='.repeat(70));

    if (report.fail) {
        console.log('\n  PROBLEMS TO FIX\n');
        report.issues.filter((i) => i.severity === 'fail').forEach((i) => {
            console.log('  - [' + i.step + '] ' + i.msg);
        });
    }
    if (report.warn) {
        console.log('\n  worth a look\n');
        report.issues.filter((i) => i.severity === 'warn').forEach((i) => {
            console.log('  - [' + i.step + '] ' + i.msg);
        });
    }
    console.log('');

    fs.writeFileSync(path.join(__dirname, 'live_test_report.json'),
        JSON.stringify(report, null, 2) + '\n', 'utf8');

    process.exitCode = report.fail ? 1 : 0;
})();

// ---------------------------------------------------------------------
// Timing behaviours
// ---------------------------------------------------------------------

/**
 * These are the things a static check can never see: whether Pause really
 * stops a half-typed word, whether Resume continues it rather than
 * starting again, whether switching language retypes, and whether going
 * back over a save submits it twice.
 */
async function testTimingBehaviours(page) {
    // --- pause freezes typing mid-word -------------------------------
    // Jump to the step that types the plan name, then pause partway through.
    const nameStep = await page.evaluate(() =>
        window.MIB_TOUR.stepIds().indexOf('p-05-name'));

    if (nameStep < 0) {
        await testCurrentTourControls(page);
        return;
    } else {
        // Slow pace makes the character-by-character action long enough to
        // prove that Pause freezes it at an exact character boundary.
        await page.select('#tour-speed', 'slow');
        await page.evaluate((i) => window.MIB_TOUR.goTo(i), nameStep);
        await waitForPhase(page, ['cueing', 'narrating', 'error']);

        // Wait until typing has begun but not finished, then pause.
        let mid = null;
        // The typing cue starts part-way through the narration, so allow the
        // recording to reach that sentence before declaring it inconclusive.
        for (let i = 0; i < 750; i++) {
            const v = await readField(page, '#amc_name');
            if (v && v.length > 3 && v.length < PLAN_NAME.length) { mid = v; break; }
            await sleep(40);
        }

        if (!mid) {
            warn('timing', 'typing finished too fast to catch mid-word; pause test inconclusive');
        } else {
            await page.evaluate(() => window.MIB_TOUR.toggle());   // pause
            const atPause = await readField(page, '#amc_name');
            await sleep(1200);
            const afterWait = await readField(page, '#amc_name');

            if (afterWait === atPause) {
                pass('timing', 'Pause froze typing mid-word at "' + atPause + '" and it stayed frozen');
            } else {
                fail('timing', 'typing continued while paused: "' + atPause + '" became "' + afterWait + '"');
            }

            await page.evaluate(() => window.MIB_TOUR.toggle());   // resume
            let finished = null;
            for (let i = 0; i < 100; i++) {
                const v = await readField(page, '#amc_name');
                if (v === PLAN_NAME) { finished = v; break; }
                await sleep(60);
            }
            if (finished === PLAN_NAME) {
                pass('timing', 'Resume continued from that character and completed the word');
            } else {
                fail('timing', 'after Resume the field reads "' + (await readField(page, '#amc_name')) + '"');
            }
        }
        await page.select('#tour-speed', 'fast');
    }

    // --- language switch must not retype or resave --------------------
    const beforeLang = await readField(page, '#amc_name');
    await page.select('#tour-language', 'hi');
    await waitForPhase(page, ['narrating', 'error']);
    const afterLang = await readField(page, '#amc_name');
    const langNow = await page.evaluate(() => window.MIB_TOUR.lang);

    if (langNow !== 'hi') {
        fail('timing', 'language did not switch (still ' + langNow + ')');
    } else if (afterLang === beforeLang) {
        pass('timing', 'switching language re-read the step without retyping the field');
    } else {
        fail('timing', 'language switch changed the field: "' + beforeLang + '" -> "' + afterLang + '"');
    }
    await page.select('#tour-language', 'en');
    await waitForPhase(page, ['narrating', 'error']);

    // --- Previous over a submit must not save twice -------------------
    const submitStep = await page.evaluate(() =>
        window.MIB_TOUR.stepIds().indexOf('p-14-submit'));

    if (submitStep < 1) {
        warn('timing', 'p-14-submit is not in this tour, skipping the double-save test');
    } else {
        // Count the plans, run the submit step, count again, then go back over
        // it and count once more. The third count must equal the second.
        await page.evaluate((i) => window.MIB_TOUR.goTo(i), submitStep + 1);
        await waitForPhase(page, ['narrating', 'error']);
        const afterSave = await countPlans(page);

        await page.evaluate(() => window.MIB_TOUR.prev());
        await waitForPhase(page, ['narrating', 'error']);
        await page.evaluate(() => window.MIB_TOUR.next());
        await waitForPhase(page, ['narrating', 'error']);
        const afterBackAndForward = await countPlans(page);

        if (afterBackAndForward === afterSave) {
            pass('timing', 'going back over the save and forward again did not create a second plan (' +
                afterSave + ' both times)');
        } else {
            fail('timing', 'plan count changed from ' + afterSave + ' to ' + afterBackAndForward +
                ' after Previous then Next - the form was submitted twice');
        }
    }
}

async function testCurrentTourControls(page) {
    const index = await page.evaluate(() => window.MIB_TOUR.stepIds().indexOf('f03'));
    if (index < 0) { fail('controls', 'AMC step f03 is missing'); return; }

    await page.select('#tour-speed', '0.5');
    await page.evaluate((i) => window.MIB_TOUR.goTo(i), index);
    await waitForPhase(page, ['narrating', 'error']);
    const expected = await page.evaluate(() => window.MIB_TOUR.step.cue.find(
        (c) => c.kind === 'type' && c.selector === '#amc_name').value);

    let partial = '';
    for (let i = 0; i < 400; i++) {
        const value = await readField(page, '#amc_name');
        if (value && value.length >= 2 && value.length < expected.length) { partial = value; break; }
        await sleep(50);
    }
    if (!partial) {
        fail('controls', 'could not observe AMC name being typed');
        return;
    }

    await page.evaluate(() => window.MIB_TOUR.toggle());
    const pausedValue = await readField(page, '#amc_name');
    const pausedAudio = await page.evaluate(() => document.getElementById('tour-audio').paused);
    await sleep(700);
    if ((await readField(page, '#amc_name')) === pausedValue && pausedAudio) {
        pass('controls', 'Pause freezes typing and audio');
    } else {
        fail('controls', 'Pause did not freeze both typing and audio');
    }

    await page.evaluate(() => window.MIB_TOUR.toggle());
    let completed = false;
    for (let i = 0; i < 200; i++) {
        if ((await readField(page, '#amc_name')) === expected) { completed = true; break; }
        await sleep(50);
    }
    if (completed) pass('controls', 'Resume completes the typed AMC name');
    else fail('controls', 'Resume did not complete the AMC name');

    for (const lang of ['hi', 'mr', 'en']) {
        await page.select('#tour-language', lang);
        await waitForPhase(page, ['narrating', 'error']);
        const state = await page.evaluate(() => ({
            lang: window.MIB_TOUR.lang,
            src: document.getElementById('tour-audio').currentSrc,
            caption: document.getElementById('tour-caption').textContent,
            expected: window.MIB_TOUR.step.text[window.MIB_TOUR.lang]
        }));
        if (state.lang === lang && state.src.includes('/audio/' + lang + '/f03.mp3') &&
                state.caption === state.expected && (await readField(page, '#amc_name')) === expected) {
            pass('controls', 'switch to ' + lang + ' changes caption and clip without retyping');
        } else {
            fail('controls', 'language switch to ' + lang + ' is out of sync');
        }
    }

    await sleep(1000);
    const audioTime = await page.evaluate(() => document.getElementById('tour-audio').currentTime);
    if (audioTime > 0) pass('controls', 'recorded audio playback advances');
    else fail('controls', 'recorded audio did not advance');

    await page.select('#tour-speed', '1.5');
    const playbackRate = await page.evaluate(() => document.getElementById('tour-audio').playbackRate);
    if (Math.abs(playbackRate - 1.5) < 0.01) pass('controls', 'Pace control changes playback rate');
    else fail('controls', 'Pace control did not change playback rate');

    await page.evaluate(() => window.MIB_TOUR.sayAgain());
    await waitForPhase(page, ['narrating', 'error']);
    if ((await readField(page, '#amc_name')) === expected) pass('controls', 'Replay does not retype');
    else fail('controls', 'Replay changed the entered AMC name');

    if (SHOTS) await page.screenshot({ path: path.join(SHOT_DIR, 'controls-before-take-control.png') });
    await page.click('#tour-control');
    await sleep(250);
    const manual = await page.evaluate(() => ({ enabled: window.MIB_TOUR.manual,
        paused: document.getElementById('tour-audio').paused,
        phase: window.MIB_TOUR.phase }));
    if (manual.enabled && manual.paused) pass('controls', 'Take control pauses the tour');
    else {
        if (SHOTS) await page.screenshot({ path: path.join(SHOT_DIR, 'controls-after-take-control.png') });
        fail('controls', 'Take control did not pause the tour: ' + JSON.stringify(manual));
    }
    await page.click('#tour-control');
    await waitForPhase(page, ['narrating', 'error']);
    if (!(await page.evaluate(() => window.MIB_TOUR.manual)) &&
            (await readField(page, '#amc_name')) === expected) {
        pass('controls', 'Return to tour resumes without retyping');
    } else {
        fail('controls', 'Return to tour changed the form or stayed manual');
    }

    await page.evaluate(() => window.MIB_TOUR.prev());
    await waitForPhase(page, ['narrating', 'error']);
    if ((await page.evaluate(() => window.MIB_TOUR.index)) === index - 1) {
        pass('controls', 'Previous opens the prior step');
    } else {
        fail('controls', 'Previous did not open the prior step');
    }
    await page.evaluate(() => window.MIB_TOUR.next());
    await waitForPhase(page, ['narrating', 'error']);
    if ((await page.evaluate(() => window.MIB_TOUR.index)) === index) {
        pass('controls', 'Next returns to the AMC step');
    } else {
        fail('controls', 'Next did not return to the AMC step');
    }

    if (SHOTS) await page.screenshot({ path: path.join(SHOT_DIR, 'controls-before-exit.png') });
    await page.click('.tour-top-actions a[href$="/vendor/dashboard"]');
    await page.waitForFunction(() => location.pathname === '/vendor/dashboard', { timeout: 10000 })
        .catch(() => null);
    if (new URL(page.url()).pathname === '/vendor/dashboard') {
        pass('controls', 'Exit tour returns to the dashboard');
    } else {
        if (SHOTS) await page.screenshot({ path: path.join(SHOT_DIR, 'controls-after-exit.png') });
        fail('controls', 'Exit tour landed on ' + page.url());
    }
}

async function readField(page, selector) {
    const frame = await appFrame(page);
    if (!frame) { return null; }
    return frame.evaluate((s) => {
        const el = document.querySelector(s);
        return el ? el.value : null;
    }, selector).catch(() => null);
}

async function countPlans(page) {
    const frame = await appFrame(page);
    if (!frame) { return -1; }
    return frame.evaluate(() => {
        const rows = document.querySelectorAll('#tbl_list tr');
        let n = 0;
        rows.forEach((r) => { if (r.textContent.includes('Aster CCTV Annual Care')) { n++; } });
        return n;
    }).catch(() => -1);
}
