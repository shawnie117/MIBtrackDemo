/* Investigate: (1) why the product table shows no products,
 *               (2) where the _DT_CellIndex page error comes from. */
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const CHROME = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find((p) => p && fs.existsSync(p));
const BASE = 'http://127.0.0.1:8765';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

const PAGES = [
    'vendor/masters/sale_product_report',
    'vendor/masters/amc_report',
    'vendor/reports/amc_renewal_reminder',
    'vendor/customers/customer_report',
    'vendor/customers/ticket_report',
    'vendor/admin/employee_report',
    'vendor/leads/lead_report'
];

(async () => {
    const browser = await puppeteer.launch({
        executablePath: CHROME, headless: true,
        defaultViewport: { width: 1440, height: 900 },
        args: ['--mute-audio', '--no-sandbox']
    });
    const page = await browser.newPage();

    await page.goto(BASE + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
        page.click('button[type="submit"], input[type="submit"]')]);

    for (const p of PAGES) {
        const errors = [];
        const failedReqs = [];
        const ajaxCalls = [];

        const onErr = (e) => errors.push(String(e.message).slice(0, 160));
        const onCon = (m) => { if (m.type() === 'error') errors.push('console: ' + m.text().slice(0, 160)); };
        const onFail = (r) => failedReqs.push(r.url().replace(BASE, '') + ' ' + (r.failure() ? r.failure().errorText : ''));
        const onResp = async (r) => {
            if (/\/ajax\//.test(r.url())) {
                ajaxCalls.push(r.url().replace(BASE, '') + ' -> ' + r.status());
            }
        };
        page.on('pageerror', onErr);
        page.on('console', onCon);
        page.on('requestfailed', onFail);
        page.on('response', onResp);

        await page.goto(BASE + '/' + p, { waitUntil: 'networkidle2', timeout: 60000 }).catch(() => {});
        await sleep(2500);

        const table = await page.evaluate(() => {
            const box = document.querySelector('#tbl_list');
            if (!box) { return { present: false }; }
            const rows = box.querySelectorAll('tr');
            return {
                present: true,
                tag: box.tagName,
                rowCount: rows.length,
                firstRow: rows[0] ? rows[0].textContent.replace(/\s+/g, ' ').trim().slice(0, 140) : '',
                allText: box.textContent.replace(/\s+/g, ' ').trim().slice(0, 200)
            };
        });

        console.log('\n### ' + p);
        console.log('  #tbl_list: ' + JSON.stringify(table));
        if (ajaxCalls.length) { console.log('  ajax: ' + ajaxCalls.join(' | ')); }
        else { console.log('  ajax: NONE FIRED'); }
        if (failedReqs.length) { console.log('  failed requests: ' + failedReqs.slice(0, 4).join(' | ')); }
        if (errors.length) { console.log('  errors: ' + Array.from(new Set(errors)).slice(0, 4).join(' | ')); }

        page.off('pageerror', onErr);
        page.off('console', onCon);
        page.off('requestfailed', onFail);
        page.off('response', onResp);
    }

    // Direct look at the product AJAX response
    console.log('\n### raw ajax/tbl_product_list response');
    const raw = await page.evaluate(async (base) => {
        const r = await fetch(base + '/vendor/ajax/tbl_product_list/1', {
            method: 'POST',
            headers: { 'X-Requested-With': 'XMLHttpRequest', 'content-type': 'application/x-www-form-urlencoded' },
            body: 'status=Active',
            credentials: 'same-origin'
        });
        const t = await r.text();
        return { status: r.status, length: t.length, head: t.slice(0, 500) };
    }, BASE);
    console.log('  status ' + raw.status + ', ' + raw.length + ' bytes');
    console.log('  ' + raw.head.replace(/\n/g, ' ').slice(0, 460));

    await browser.close();
})();
