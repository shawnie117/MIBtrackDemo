#!/usr/bin/env node
'use strict';

const puppeteer = require('puppeteer-core');
const chrome = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const base = 'http://127.0.0.1:8765';
const path = process.argv[2] || '/vendor/reports/daily_analysis_report';

(async () => {
    const browser = await puppeteer.launch({ executablePath: chrome, headless: true,
        args: ['--no-sandbox'], defaultViewport: { width: 1440, height: 900 } });
    try {
        const page = await browser.newPage();
        page.on('pageerror', (e) => console.log('PAGEERROR', e.stack || e.message));
        page.on('console', (m) => { if (m.type() === 'error') console.log('CONSOLE', m.text()); });
        await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="username"]', 'demo');
        await page.type('input[name="password"]', 'demo123');
        await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
            page.click('button[type="submit"], input[type="submit"]')]);
        await page.goto(base + path, { waitUntil: 'networkidle2' });
        console.log('PAGE', page.url(), await page.title());
        console.log('TEXT', (await page.$eval('body', b => b.innerText)).replace(/\s+/g, ' ').slice(0, 320));
        const tables = await page.evaluate(() => [...document.querySelectorAll('table')].map((t, i) => ({
            index: i, id: t.id, className: t.className,
            tbodyId: t.tBodies[0] ? t.tBodies[0].id : '',
            firstRow: t.tBodies[0] && t.tBodies[0].rows[0] ? t.tBodies[0].rows[0].innerText.slice(0, 80) : '',
            summary: t.tBodies[0] && t.tBodies[0].id === 'employee_ticket_summary' ? t.tBodies[0].innerText.replace(/\s+/g, ' ').slice(0, 500) : '',
            firstRowHtml: t.tBodies[0] && t.tBodies[0].rows[0] ? t.tBodies[0].rows[0].outerHTML.slice(0, 220) : '',
            headings: t.querySelectorAll('thead tr:last-child th').length,
            rows: [...t.querySelectorAll('tbody tr')].map((r) => r.children.length).slice(0, 5)
        })));
        console.log(JSON.stringify(tables, null, 2));
    } finally { await browser.close(); }
})().catch((err) => { console.error(err); process.exitCode = 1; });
