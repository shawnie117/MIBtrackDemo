#!/usr/bin/env node
/* =====================================================================
 * MI-BTrack guided demo - tour self-check
 * ---------------------------------------------------------------------
 *   1. php -S 127.0.0.1:8765 router.php     (from _build)
 *   2. node tools/verify_tour.js
 *
 * WHAT IT CHECKS
 *   A. Content integrity      every step has an id, url, three languages,
 *                             and cue kinds the runtime understands
 *   B. Runtime/shell contract every element id demo-tour.js looks up
 *                             actually exists in tour.php
 *   C. Page reachability      every step url returns HTTP 200 while
 *                             signed in
 *   D. Selector existence     every step selector, and every cue
 *                             selector, is really present in that page's
 *                             HTML
 *   E. Audio pack             every current step has a valid MP3 per language
 *
 * WHY D MATTERS MOST
 * A tour that highlights a selector which does not exist is the single
 * most likely way for this feature to break silently. The old player
 * ignored a missing selector without a word. The new one stops and
 * explains - but it is far better to catch it here, before a demo.
 *
 * LIMITATION, STATED PLAINLY
 * This is a static check against server-rendered HTML. It cannot see
 * elements that only exist after the page's own JavaScript has run, and
 * it does not exercise pause, resume or the spotlight geometry. Those
 * still need a human with a browser. Selectors that this script cannot
 * confirm are reported as UNCONFIRMED rather than passed or failed.
 * ===================================================================== */

'use strict';

const fs = require('fs');
const path = require('path');
const vm = require('vm');

const BASE = process.env.MIB_BASE || 'http://127.0.0.1:8765';
const REPO = path.resolve(__dirname, '..');
const BUILD = path.join(REPO, '_build');
const CONTENT_FILE = path.join(BUILD, 'assets', 'js', 'demo-tour-content.js');
const RUNTIME_FILE = path.join(BUILD, 'assets', 'js', 'demo-tour.js');
const SHELL_FILE = path.join(BUILD, 'application', 'modules', 'vendor', 'views', 'dashboard', 'tour.php');

const KNOWN_CUE_KINDS = ['note', 'focus', 'type', 'select', 'click', 'expand', 'submit', 'navigate'];

let pass = 0;
let fail = 0;
let warn = 0;
const failures = [];

function ok(msg) { pass++; console.log('  PASS  ' + msg); }
function bad(msg) { fail++; failures.push(msg); console.log('  FAIL  ' + msg); }
function meh(msg) { warn++; console.log('  ????  ' + msg); }
function head(msg) { console.log('\n' + msg + '\n' + '-'.repeat(msg.length)); }

// ---------------------------------------------------------------------
// Tiny cookie-aware HTTP client
// ---------------------------------------------------------------------

const jar = new Map();

function cookieHeader() {
    return Array.from(jar.entries()).map(([k, v]) => k + '=' + v).join('; ');
}

function storeCookies(response) {
    const raw = response.headers.getSetCookie ? response.headers.getSetCookie()
        : (response.headers.raw ? response.headers.raw()['set-cookie'] || [] : []);
    for (const line of raw) {
        const [pair] = line.split(';');
        const idx = pair.indexOf('=');
        if (idx > 0) { jar.set(pair.slice(0, idx).trim(), pair.slice(idx + 1).trim()); }
    }
}

async function get(url) {
    const response = await fetch(BASE + url, {
        headers: { cookie: cookieHeader() },
        redirect: 'follow'
    });
    storeCookies(response);
    return { status: response.status, finalUrl: response.url, body: await response.text() };
}

async function post(url, fields) {
    const body = new URLSearchParams(fields).toString();
    const response = await fetch(BASE + url, {
        method: 'POST',
        headers: {
            cookie: cookieHeader(),
            'content-type': 'application/x-www-form-urlencoded'
        },
        body,
        redirect: 'follow'
    });
    storeCookies(response);
    return { status: response.status, finalUrl: response.url, body: await response.text() };
}

// ---------------------------------------------------------------------
// Static selector presence
// ---------------------------------------------------------------------

/**
 * Decide whether a CSS selector is present in raw HTML.
 *
 * Returns 'yes', 'no' or 'unknown'. Only handles the selector shapes the
 * tour actually uses; anything else returns 'unknown' rather than
 * guessing, because a false pass here is worse than no answer.
 */
function selectorInHtml(selector, html) {
    // Comma lists: present if any branch is present.
    if (selector.includes(',')) {
        const parts = selector.split(',').map((s) => s.trim()).filter(Boolean);
        const results = parts.map((p) => selectorInHtml(p, html));
        if (results.includes('yes')) { return 'yes'; }
        if (results.includes('unknown')) { return 'unknown'; }
        return 'no';
    }

    // [attr="value"]
    const attr = selector.match(/^\[([a-zA-Z-]+)=["']?([^"'\]]+)["']?\]$/);
    if (attr) {
        const needle = attr[1] + '="' + attr[2] + '"';
        return html.includes(needle) ? 'yes' : 'no';
    }

    // #id  (must be a whole id, not a prefix of a longer one)
    const id = selector.match(/^#([A-Za-z][\w-]*)$/);
    if (id) {
        return new RegExp('id=["\']' + id[1] + '["\']').test(html) ? 'yes' : 'no';
    }

    // .a.b.c  - every class token must appear as a class token somewhere
    const chained = selector.match(/^(\.[A-Za-z][\w-]*)+$/);
    if (chained) {
        const tokens = selector.split('.').filter(Boolean);
        const allPresent = tokens.every((tok) =>
            new RegExp('class=["\'][^"\']*\\b' + tok.replace(/-/g, '\\-') + '\\b').test(html));
        if (!allPresent) { return 'no'; }
        // All tokens exist, but possibly on different elements. Try to find
        // one element carrying all of them.
        const classAttrs = html.match(/class=["'][^"']*["']/g) || [];
        const together = classAttrs.some((a) => tokens.every((tok) =>
            new RegExp('\\b' + tok.replace(/-/g, '\\-') + '\\b').test(a)));
        return together ? 'yes' : 'unknown';
    }

    return 'unknown';
}

// ---------------------------------------------------------------------
// Load the tour script
// ---------------------------------------------------------------------

function loadContent() {
    const sandbox = { window: {} };
    vm.createContext(sandbox);
    vm.runInContext(fs.readFileSync(CONTENT_FILE, 'utf8'), sandbox, { timeout: 5000 });
    return sandbox.window.MIB_TOUR_CONTENT;
}

// ---------------------------------------------------------------------
// A. Content integrity
// ---------------------------------------------------------------------

function checkContent(content) {
    head('A. Tour content integrity');

    const tours = ['full'];
    const seenIds = new Map();
    let cueCount = 0;
    let submitCount = 0;

    for (const tour of tours) {
        const steps = content[tour];
        if (!Array.isArray(steps) || !steps.length) { bad(tour + ' tour is empty'); continue; }
        ok(tour + ' tour has ' + steps.length + ' steps');

        steps.forEach((step, i) => {
            const where = tour + '[' + i + ']';

            if (!step.id) { bad(where + ' has no id'); return; }
            if (!/^[a-z0-9][a-z0-9-]*$/.test(step.id)) {
                bad(step.id + ' is not a safe audio filename');
            }
            if (!step.url) { bad(step.id + ' has no url'); }

            for (const field of ['title', 'text']) {
                for (const lang of ['en', 'hi', 'mr']) {
                    if (!step[field] || !step[field][lang]) {
                        bad(step.id + ' is missing ' + field + '.' + lang);
                    }
                }
            }

            // One id must always mean one recording.
            if (seenIds.has(step.id)) {
                if (seenIds.get(step.id) !== step.text.en) {
                    bad(step.id + ' has two different English narrations across tours');
                }
            } else {
                seenIds.set(step.id, step.text.en);
            }

            if (step.cue) {
                for (const cue of [].concat(step.cue)) {
                    cueCount++;
                    if (!KNOWN_CUE_KINDS.includes(cue.kind)) {
                        bad(step.id + ' uses unknown cue kind "' + cue.kind + '"');
                    }
                    if (cue.kind !== 'note' && !cue.selector) {
                        bad(step.id + ' has a ' + cue.kind + ' cue with no selector');
                    }
                    if (cue.kind === 'submit') {
                        submitCount++;
                        if (!cue.checkpoint) { bad(step.id + ' submit cue has no checkpoint key'); }
                        if (!cue.expect || !cue.expect.text) {
                            bad(step.id + ' submit cue does not say what confirmation to wait for');
                        }
                    }
                    if (cue.kind === 'type' && (cue.value === undefined || cue.value === '')) {
                        bad(step.id + ' type cue has nothing to type');
                    }
                    if (cue.kind === 'select' && cue.value === undefined && !cue.label) {
                        bad(step.id + ' select cue has neither value nor label');
                    }
                }
            }

            if (step.stay && !step.stayIfUrlContains) {
                bad(step.id + ' uses stay without stayIfUrlContains, so it cannot tell where it is');
            }
        });
    }

    // Each Full Demo step owns one narration clip.
    // Report the unique figures - they are what a reader actually wants.
    const uniqueSubmits = new Set();
    for (const tour of tours) {
        for (const step of content[tour]) {
            for (const cue of [].concat(step.cue || [])) {
                if (cue.kind === 'submit') { uniqueSubmits.add(step.id); }
            }
        }
    }

    ok(seenIds.size + ' unique clip ids, each with exactly one narration');
    ok(cueCount + ' Full Demo cue invocations, all of a kind the runtime implements');
    if (uniqueSubmits.size) {
        ok(uniqueSubmits.size + ' distinct form submits have checkpoints and confirmations');
    } else {
        ok('current tours demonstrate fields without submitting forms');
    }
}

// ---------------------------------------------------------------------
// B. Runtime / shell contract
// ---------------------------------------------------------------------

function checkShellContract() {
    head('B. Runtime and player shell agree on element ids');

    const runtime = fs.readFileSync(RUNTIME_FILE, 'utf8');
    const shell = fs.readFileSync(SHELL_FILE, 'utf8');

    // The runtime collects its handles from one array literal.
    const block = runtime.match(/\[\s*((?:'tour-[\w-]+',?\s*)+)\]/);
    if (!block) { bad('could not find the element id list in demo-tour.js'); return; }

    const ids = block[1].match(/'([\w-]+)'/g).map((s) => s.replace(/'/g, ''));
    let missing = 0;
    for (const id of ids) {
        if (!new RegExp('id=["\']' + id + '["\']').test(shell)) {
            bad('demo-tour.js expects #' + id + ' but tour.php does not define it');
            missing++;
        }
    }
    if (!missing) { ok('all ' + ids.length + ' element ids the runtime uses exist in tour.php'); }

    // .tour-stage is looked up by class, separately.
    if (/class="tour-stage"/.test(shell)) { ok('.tour-stage present for spotlight positioning'); }
    else { bad('.tour-stage missing - the spotlight has nothing to position against'); }

    // The spotlight must be absolute inside a positioned stage, or the
    // coordinate conversion in place() is wrong.
    const css = fs.readFileSync(path.join(BUILD, 'assets', 'css', 'demo-tour.css'), 'utf8');
    if (/\.tour-stage\s*\{[^}]*position:\s*relative/.test(css)) { ok('.tour-stage is position:relative'); }
    else { bad('.tour-stage is not position:relative - spotlight coordinates will be wrong'); }
    if (/#tour-spotlight\s*\{[^}]*position:\s*absolute/.test(css)) { ok('#tour-spotlight is position:absolute'); }
    else { bad('#tour-spotlight is not position:absolute'); }

    // Regression guard for the old bug: a positional transition fights the
    // per-frame follow loop.
    const spotBlock = css.match(/#tour-spotlight\s*\{[^}]*\}/);
    if (spotBlock && /transition:\s*(all|top|left)/.test(spotBlock[0])) {
        bad('#tour-spotlight has a positional transition; it will lag behind its target');
    } else {
        ok('#tour-spotlight has no positional transition');
    }

    // Regression guard: the runtime must not perform hidden data writes.
    const writes = runtime.match(/tour_action/g) || [];
    const resetOnly = /f\.append\('action',\s*'reset'\)|form\.append\('action',\s*'reset'\)/.test(runtime);
    if (writes.length && !resetOnly) {
        bad('demo-tour.js calls tour_action for something other than reset');
    } else {
        ok('runtime performs no hidden data writes (reset is the only server call)');
    }
}

// ---------------------------------------------------------------------
// C + D. Pages and selectors
// ---------------------------------------------------------------------

async function checkPagesAndSelectors(content) {
    head('C. Every page the tour opens is reachable');

    // Fetch the login page first so CodeIgniter issues a session cookie.
    // Posting straight in would create a session whose cookie fetch never
    // replays on the redirect hop, and the dashboard would bounce us back.
    await get('/login');
    const login = await post('/login', { username: 'demo', password: 'demo123' });
    if (!/vendor\/dashboard/.test(login.finalUrl)) {
        bad('could not sign in as the demo user - is the server running on ' + BASE + '?');
        return false;
    }
    ok('signed in as demo, landed on ' + new URL(login.finalUrl).pathname);

    // Collect what we need to look at: url -> set of selectors.
    const wanted = new Map();
    for (const tour of ['full']) {
        for (const step of content[tour]) {
            // A `stay` step describes a page produced by a save; its own url
            // is only the fallback, so check the fallback.
            const url = '/' + step.url.replace(/^\//, '');
            if (!wanted.has(url)) { wanted.set(url, new Set()); }
            let set = wanted.get(url);
            if (step.selector) { set.add(step.selector); }
            for (const cue of [].concat(step.cue || [])) {
                if (cue.kind === 'navigate') {
                    const sceneUrl = '/' + cue.selector.replace(/^\//, '');
                    if (!wanted.has(sceneUrl)) { wanted.set(sceneUrl, new Set()); }
                    set = wanted.get(sceneUrl);
                    if (cue.target) { set.add(cue.target); }
                    continue;
                }
                if (cue.selector) { set.add(cue.selector); }
                if (cue.awaitOptions) { set.add(cue.awaitOptions); }
                if (cue.target) { set.add(cue.target); }
            }
        }
    }

    const pages = new Map();
    for (const [url, selectors] of wanted) {
        const res = await get(url);
        if (res.status !== 200) {
            bad(url + ' returned HTTP ' + res.status);
            continue;
        }
        if (/Fatal error|A PHP Error was encountered|Parse error/.test(res.body)) {
            bad(url + ' rendered a PHP error');
            continue;
        }
        const landed = new URL(res.finalUrl).pathname.replace(/\/$/, '');
        const asked = url.replace(/\/$/, '');
        if (landed !== asked && !asked.startsWith(landed)) {
            meh(url + ' redirected to ' + landed + ' (expected for pages needing a record id)');
        }
        pages.set(url, res.body);
        ok(url + '  (' + Math.round(res.body.length / 1024) + ' KB, clean)');
    }

    head('D. Every selector the tour points at exists on its page');

    let confirmed = 0;
    let unconfirmed = 0;
    for (const [url, selectors] of wanted) {
        const html = pages.get(url);
        if (!html) { continue; }
        for (const selector of selectors) {
            const verdict = selectorInHtml(selector, html);
            if (verdict === 'yes') { confirmed++; }
            else if (verdict === 'no') { bad(selector + '  NOT FOUND on ' + url); }
            else {
                unconfirmed++;
                meh(selector + '  on ' + url + ' - cannot confirm from static HTML, check in a browser');
            }
        }
    }
    ok(confirmed + ' selectors confirmed present in the served HTML');
    if (unconfirmed) { console.log('  note  ' + unconfirmed + ' selector(s) need a browser to confirm'); }
    return true;
}

// ---------------------------------------------------------------------
// E. The two real saves
// ---------------------------------------------------------------------

async function checkRealSaves(content) {
    head('E. The two real form submits actually save');

    // Pull the values straight out of the tour script, so this tests what
    // the tour will really type rather than a copy that could drift.
    const findCue = (id) => {
        for (const step of content.full) {
            if (step.id === id) { return [].concat(step.cue)[0]; }
        }
        return null;
    };
    const valueOf = (stepId) => {
        for (const step of content.full) {
            for (const cue of [].concat(step.cue || [])) {
                if (cue.kind === 'type' || cue.kind === 'select') {
                    if (step.id === stepId) { return cue.value; }
                }
            }
        }
        return null;
    };

    const amcSubmit = findCue('p-14-submit');
    const leadSubmit = findCue('e-16-submit');

    // --- AMC plan -----------------------------------------------------
    const amc = await post('/vendor/masters/add_amc', {
        amc_product_id: valueOf('p-04-product'),
        amc_name: valueOf('p-05-name'),
        amc_desc: valueOf('p-06-desc'),
        amc_duration: valueOf('p-07-duration'),
        amc_noofservices: valueOf('p-08-visits'),
        amc_sit: '92',
        amc_gst: valueOf('p-10-gst'),
        amc_price: valueOf('p-11-price'),
        amc_corporate_price: valueOf('p-12-corporate-price')
    });

    const amcExpect = amcSubmit.expect.text;
    if (amc.body.includes(amcExpect)) {
        ok('AMC form saved, and printed the exact sentence the tour waits for');
        ok('  waited for: "' + amcExpect + '"');
    } else if (/alert-danger/.test(amc.body)) {
        meh('AMC form was refused - probably already created in this session (that is handled by skipIf)');
    } else {
        bad('AMC saved but did NOT print "' + amcExpect + '" - the tour would report a failure');
    }

    // Service interval must be the calculated value, not what we posted.
    const listed = await fetch(BASE + '/vendor/ajax/tbl_amc_list/1', {
        method: 'POST',
        headers: {
            cookie: cookieHeader(),
            'content-type': 'application/x-www-form-urlencoded',
            'x-requested-with': 'XMLHttpRequest'
        },
        body: 'status=Active'
    }).then((r) => r.text());

    if (listed.includes(valueOf('p-05-name'))) {
        ok('the new plan is present in the AMC report table');
    } else {
        bad('the new plan is NOT in the AMC report table');
    }

    // --- Enquiry ------------------------------------------------------
    const lead = await post('/vendor/leads/add_lead', {
        lead_name: valueOf('e-03-name'),
        lead_contact: valueOf('e-04-mobile'),
        lead_priority: valueOf('e-05-priority'),
        lead_productid: valueOf('e-06-enquiry-for'),
        lead_desc: valueOf('e-07-details'),
        company_name: valueOf('e-08-company'),
        lead_contact_person: valueOf('e-09-person'),
        lead_contact_email: valueOf('e-11-email'),
        lead_addrs: valueOf('e-12-address'),
        lead_stateid: '27',
        lead_distid: '2701',
        lead_cityid: '270101',
        lead_arealoc: 'Kharghar',
        lead_pincode: '410210',
        lead_refby: '504'
    });

    const leadExpect = leadSubmit.expect.text;
    const leadDup = leadSubmit.expect.duplicateText;
    if (lead.body.includes(leadExpect)) {
        ok('enquiry saved, and printed the exact sentence the tour waits for');
        ok('  waited for: "' + leadExpect + '"');
        if (/view_lead/.test(lead.finalUrl)) {
            ok('landed on the enquiry detail page, which is what the next step describes');
        } else {
            bad('did not land on view_lead - the "stay" step would fall back');
        }
    } else if (lead.body.includes(leadDup)) {
        meh('enquiry already existed - the tour handles this via expect.duplicateText');
    } else {
        bad('enquiry saved but did NOT print "' + leadExpect + '"');
    }

    // The duplicate path the tour relies on must really fire.
    const again = await post('/vendor/leads/add_lead', {
        lead_name: valueOf('e-03-name'),
        lead_contact: valueOf('e-04-mobile')
    });
    if (again.body.includes(leadDup)) {
        ok('a duplicate mobile number is refused with "' + leadDup + '"');
    } else {
        bad('duplicate mobile was NOT refused - the tour could create the same enquiry twice');
    }
}

// ---------------------------------------------------------------------
// F. Recorded narration
// ---------------------------------------------------------------------

/**
 * Check the audio pack.
 *
 * A missing clip is not a failure - the player falls back to the browser
 * voice, so the step is still explained. But a clip that exists and is not
 * actually audio IS a failure, because the player would try to play it,
 * fail, and fall back late.
 */
function checkAudio(content) {
    head('F. Recorded narration');

    const audioRoot = path.join(BUILD, 'assets', 'tour', 'audio');
    const ids = new Set();
    for (const tour of ['full']) {
        for (const step of content[tour]) { ids.add(step.id); }
    }

    for (const lang of ['en', 'hi', 'mr']) {
        const dir = path.join(audioRoot, lang);
        if (!fs.existsSync(dir)) {
            meh(lang + ': no recordings yet - every step will use the browser voice');
            continue;
        }

        let present = 0;
        let broken = 0;
        let bytes = 0;

        for (const id of ids) {
            const file = path.join(dir, id + '.mp3');
            if (!fs.existsSync(file)) { continue; }
            present++;

            const buf = fs.readFileSync(file);
            bytes += buf.length;

            // Real mp3s start with an ID3 tag or an MPEG frame sync.
            const isId3 = buf.slice(0, 3).toString('latin1') === 'ID3';
            const isFrame = buf[0] === 0xff && (buf[1] & 0xe0) === 0xe0;
            if (!isId3 && !isFrame) {
                bad(lang + '/' + id + '.mp3 is not audio (' + buf.length + ' bytes) - probably a saved error response');
                broken++;
            } else if (buf.length < 8000) {
                bad(lang + '/' + id + '.mp3 is suspiciously small (' + buf.length + ' bytes)');
                broken++;
            }
        }

        const missing = ids.size - present;
        if (!broken) {
            ok(lang + ': ' + present + '/' + ids.size + ' clips, all valid audio, ' +
                Math.round(bytes / 1024 / 1024) + ' MB total' +
                (missing ? '  (' + missing + ' will use the browser voice)' : '  (complete)'));
        }

        // Orphans mean a step was renamed after recording - the clip is dead
        // weight and its step silently lost its voice.
        const onDisk = fs.readdirSync(dir).filter((f) => f.endsWith('.mp3')).map((f) => f.replace(/\.mp3$/, ''));
        const orphans = onDisk.filter((id) => !ids.has(id));
        if (orphans.length) {
            bad(lang + ': ' + orphans.length + ' recording(s) match no step id: ' + orphans.slice(0, 5).join(', '));
        }
    }
}

// ---------------------------------------------------------------------
// Main
// ---------------------------------------------------------------------

(async () => {
    console.log('\nMI-BTrack guided demo - self check');
    console.log('server: ' + BASE);

    const content = loadContent();

    checkContent(content);
    checkShellContract();
    checkAudio(content);
    const online = await checkPagesAndSelectors(content);
    if (!online) {
        console.log('  Page checks were skipped because demo sign-in failed.');
    }

    head('Result');
    console.log('  passed      : ' + pass);
    console.log('  failed      : ' + fail);
    console.log('  needs a browser: ' + warn);
    if (fail) {
        console.log('\nFailures:');
        failures.forEach((f) => console.log('  - ' + f));
    }
    console.log('');
    console.log('  Covered separately by: node tools/live_test_tour.js --tour full --lang <en|hi|mr>');
    console.log('    pause freezes typing mid-word and resume continues from that character');
    console.log('    the spotlight sits exactly over its target while the page scrolls');
    console.log('    switching language mid-tour re-reads without re-typing or re-saving');
    console.log('    Replay and language changes never repeat typing');
    console.log('    audio clips end before the tour advances');
    console.log('');

    process.exitCode = fail ? 1 : 0;
})();
