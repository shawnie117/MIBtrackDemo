#!/usr/bin/env node
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const base = process.argv[2] || 'http://127.0.0.1:8765';
const chrome = [
  process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'
].find(p => p && fs.existsSync(p));
const sleep = ms => new Promise(resolve => setTimeout(resolve, ms));

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true, args: ['--no-sandbox', '--mute-audio'] });
  const page = await browser.newPage();
  const errors = [];
  page.on('pageerror', e => errors.push(e.stack || e.message));
  page.on('console', m => {
    if (m.type() === 'error' && !/\.mp3/.test(m.text())) {
      const loc = m.location();
      errors.push(m.text() + (loc && loc.url ? ` @ ${loc.url}:${loc.lineNumber}` : ''));
    }
  });
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('button[type="submit"], input[type="submit"]')]);

    const launcherCount = await page.$$eval('.demo-tour-options a', els => els.length);
    if (launcherCount !== 2) throw new Error(`Expected 2 dashboard demo choices, found ${launcherCount}`);

    await page.goto(base + '/vendor/dashboard/tour?tour=full', { waitUntil: 'domcontentloaded' });
    await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
    const shell = await page.evaluate(() => ({
      lang: window.MIB_TOUR.lang,
      languagePicker: !!document.querySelector('#tour-language'),
      languages: Array.from(document.querySelectorAll('#tour-language option')).map(o => o.value),
      speeds: Array.from(document.querySelectorAll('#tour-speed option')).map(o => o.value)
    }));
    if (shell.lang !== 'mr' || !shell.languagePicker || shell.languages.join(',') !== 'mr,hi,en' || shell.speeds.join(',') !== '0.5,1,1.5,2,3') {
      throw new Error('Tour shell configuration is wrong: ' + JSON.stringify(shell));
    }

    await page.select('#tour-speed', '3');
    await page.click('#tour-start-btn');
    const deadline = Date.now() + 55000;
    while (Date.now() < deadline) {
      const state = await page.evaluate(() => ({ index: window.MIB_TOUR.index, phase: window.MIB_TOUR.phase, error: window.MIB_TOUR.lastError, spotlight: window.MIB_TOUR.spotlightRect() }));
      if (state.error || state.phase === 'error') throw new Error('Tour error at step ' + (state.index + 1) + ': ' + JSON.stringify(state.error));
      if (state.index >= 6 && state.spotlight) break;
      await sleep(250);
    }
    const result = await page.evaluate(() => {
      const frame = document.querySelector('#tour-frame').contentDocument;
      const value = id => { const el = frame && frame.querySelector(id); return el && el.value; };
      return {
        index: window.MIB_TOUR.index,
        spotlight: window.MIB_TOUR.spotlightRect(),
        leadName: value('#lead_name'),
        leadMobile: value('#lead_contact'),
        leadDetails: value('#lead_desc'),
        company: value('#company_name'),
        email: value('#lead_contact_email'),
        alternate: value('.lead_altcontact'),
        reference: (() => { const el = frame && frame.querySelector('#lead_refby'); return el && el.selectedOptions[0] && el.selectedOptions[0].textContent.trim(); })()
      };
    });
    if (result.index < 6) throw new Error('Tour did not reach F07 within the smoke-test window.');
    if (!result.spotlight) throw new Error('The focus spotlight was not visible.');
    if (result.leadName !== 'Ambar Patil' || result.leadMobile !== '4515554454' ||
        result.leadDetails !== 'New amc required' || result.company !== 'ABC Industries' ||
        result.email !== 'ambar@gmail.com' || result.alternate !== '4578325451' || result.reference !== 'Google') {
      throw new Error('Autotyping did not persist into F07: ' + JSON.stringify(result));
    }
    if (errors.length) throw new Error('Browser errors: ' + errors.join(' | '));
    console.log('PASS launcher has exactly Full Demo and Short Demo');
    console.log('PASS Marathi/Hindi/English shell and 0.5x-3x speed controls');
    console.log('PASS automatic F01-F06 playback reached F07 without an error');
    console.log('PASS lead form values and focus spotlight remained aligned');
  } finally {
    await browser.close();
  }
})().catch(err => { console.error('FAIL ' + (err.stack || err)); process.exit(1); });
