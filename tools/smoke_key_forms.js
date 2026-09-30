#!/usr/bin/env node
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const base = process.argv[2] || 'http://127.0.0.1:8765';
const chrome = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe', process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe', process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find(p => p && fs.existsSync(p));
const sleep = ms => new Promise(r => setTimeout(r, ms));
const cases = [
  { index: 7, id: 'F08', fields: { '#followup_feedback': 'Need Followup', '#followupstatusid': '2', '#followupfor': 'Routine' }, checked: '#visitRadio' },
  { index: 9, id: 'F10', fields: { '#cust_name': 'Adinath Mhaske', '#cust_contact': '4152488895', '#cust_contact_email': 'aadinath@gmail.com', '.lead_altemail': 'amol@gmail.com' } },
  { index: 12, id: 'F13', fields: { '#followup_feedback': 'service pending', '#followupstatusid': '2', '#followupfor': '__demo__Routine' }, checked: '#visitRadio' },
  { index: 13, id: 'F14', fields: { '#emp_name': 'Prajyot', '#emp_mob1': '8546951251', '#emp_joining_date': '12/12/2012' } },
  { index: 15, id: 'F16', fields: { '#tkt_title': 'Visit for service.', '#ticket_desc': 'Provide the GPM service properly.' } },
  { index: 18, id: 'F19', fields: { '#p_quote_name': 'Adinath Mhaske', '#p_quote_contact': '4152488895', '#p_quote_subject': 'Quotation for general pest management service' } }
];

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true, args: ['--no-sandbox', '--mute-audio'] });
  const page = await browser.newPage();
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo'); await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(base + '/vendor/dashboard/tour?tour=full', { waitUntil: 'domcontentloaded' });
    await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
    await page.select('#tour-speed', '3');

    for (const test of cases) {
      await page.evaluate(index => window.MIB_TOUR.goTo(index), test.index);
      const deadline = Date.now() + 30000;
      let state;
      while (Date.now() < deadline) {
        state = await page.evaluate(() => ({ index: window.MIB_TOUR.index, done: window.MIB_TOUR.cueComplete, error: window.MIB_TOUR.lastError }));
        if (state.error) throw new Error(`${test.id} failed: ${JSON.stringify(state.error)}`);
        if (state.index === test.index && state.done) break;
        if (state.index > test.index) throw new Error(`${test.id} advanced before its fields could be checked`);
        await sleep(100);
      }
      if (!state || !state.done) throw new Error(`${test.id} cues did not finish`);
      const actual = await page.evaluate(selectors => {
        const doc = document.querySelector('#tour-frame').contentDocument;
        const out = {};
        selectors.forEach(selector => { const el = doc.querySelector(selector); out[selector] = el && el.value; });
        return out;
      }, Object.keys(test.fields));
      for (const [selector, expected] of Object.entries(test.fields)) {
        if (actual[selector] !== expected) throw new Error(`${test.id} ${selector}: expected "${expected}", got "${actual[selector]}"`);
      }
      if (test.checked) {
        const checked = await page.evaluate(selector => document.querySelector('#tour-frame').contentDocument.querySelector(selector).checked, test.checked);
        if (!checked) throw new Error(`${test.id} ${test.checked} was not selected`);
      }
      console.log(`PASS ${test.id} autotyping`);
    }
  } finally { await browser.close(); }
})().catch(err => { console.error('FAIL ' + (err.stack || err)); process.exit(1); });
