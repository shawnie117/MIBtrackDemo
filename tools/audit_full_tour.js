'use strict';
const fs = require('fs');
const path = require('path');
const puppeteer = require('puppeteer-core');
const base = process.env.DEMO_BASE_URL || 'http://127.0.0.1:8765';
const lang = process.argv[2] || 'mr';
const ids = process.argv.slice(3);
const output = path.join(__dirname, 'live_shots', 'full-audit-' + lang + (ids.length ? '-' + ids.join('-') : ''));
fs.mkdirSync(output, { recursive: true });
const chrome = ['C:/Program Files/Google/Chrome/Application/chrome.exe', 'C:/Program Files (x86)/Google/Chrome/Application/chrome.exe'].find(fs.existsSync);
const wait = ms => new Promise(r => setTimeout(r, ms));
(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true,
    defaultViewport: { width: 1440, height: 900 },
    args: ['--mute-audio', '--autoplay-policy=no-user-gesture-required'] });
  const page = await browser.newPage();
  const report = { language: lang, steps: [], errors: [], missing: [] };
  page.on('pageerror', e => report.errors.push(e.message));
  page.on('response', r => { if (r.status() >= 400 && !r.url().includes('favicon')) report.missing.push({ status: r.status(), url: r.url() }); });
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('[name="username"]', 'demo');
    await page.type('[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation(), page.click('button[type="submit"]')]);
    await page.goto(base + '/vendor/dashboard/tour?tour=full&lang=' + lang);
    await page.select('#tour-speed', '3');
    await page.click('#tour-start-btn');
    if (ids.length) await page.evaluate(id => MIB_TOUR.goTo(MIB_TOUR.stepIds().indexOf(id)), ids[0]);
    let current = '', stepStarted = Date.now(), captured = '', selection = 0;
    while (true) {
      const s = await page.evaluate(() => {
        const t = MIB_TOUR, a = document.querySelector('#tour-audio'), d = document.querySelector('#tour-frame').contentDocument;
        return { id: t.step.id, phase: t.phase, error: t.lastError, complete: t.cueComplete,
          audio: a.currentSrc, duration: a.duration, time: a.currentTime,
          captionMatches: document.querySelector('#tour-caption').textContent === t.step.text[t.lang],
          url: d.location.href, title: d.title, cues: t.cueLog,
          fields: [...d.querySelectorAll('input:not([type="hidden"]):not([type="password"]), select, textarea')]
            .filter(e => e.offsetWidth || e.offsetHeight).map(e => ({ id: e.id, name: e.name, value: e.value, checked: e.checked })),
          fakeOptions: d.querySelectorAll('[data-tour-demo-option]').length,
          body: d.body ? d.body.innerText.slice(-1400) : '' };
      });
      if (s.id !== current) { current = s.id; stepStarted = Date.now(); console.log('START ' + current); }
      if (ids.length && current !== ids[selection]) throw new Error('Chapter advanced before its evidence was captured: expected '+ids[selection]+', got '+current);
      if (s.error) throw new Error(JSON.stringify(s));
      if (Date.now() - stepStarted > 180000) throw new Error('Stalled at ' + current);
      if (s.phase === 'narrating' && s.duration > 0 && s.complete && captured !== s.id) {
        if (!s.captionMatches || !s.audio.includes('/' + lang + '/' + s.id + '.mp3')) throw new Error('Wrong caption/recording: ' + s.id);
        if (s.fakeOptions) throw new Error('Fabricated dropdown choice: ' + s.id);
        const value = id => s.fields.find(f => f.id === id)?.value;
        if (s.id === 'f10' && (!value('cust_ui_date') || Number(value('cust_total_amount')) <= 0 || value('cust_paid_amount') !== '1000')) throw new Error('AMC/date/payment not populated');
        if (s.id === 'f13' && (value('followupfor') !== 'Routine' || !value('next_update_date') || !s.fields.find(f => f.id === 'visitRadio')?.checked)) throw new Error('Follow-up incomplete');
        if (s.id === 'f16' && !value('ticket_date')) throw new Error('Ticket date missing');
        report.steps.push(s);
        await page.screenshot({ path: path.join(output, s.id + '.png') });
        captured = s.id;
        console.log('PASS ' + s.id + ' ' + s.title + ' cues=' + s.cues.length);
        if (ids.length) {
          selection++;
          if (selection === ids.length) break;
          await page.evaluate(id => MIB_TOUR.goTo(MIB_TOUR.stepIds().indexOf(id)), ids[selection]);
        }
      }
      if (s.phase === 'finished') break;
      await wait(100);
    }
    if (!ids.length && report.steps.length !== 23) throw new Error('Only ' + report.steps.length + '/23 chapters completed');
    if (report.errors.length || report.missing.length) throw new Error(JSON.stringify({ errors: report.errors, missing: report.missing }));
    console.log('PASS full audit: ' + report.steps.length + ' chapters');
  } catch (e) { report.failure = e.message; console.error('FAIL ' + e.message); process.exitCode = 1; }
  finally { fs.writeFileSync(path.join(output, 'report.json'), JSON.stringify(report, null, 2)); await browser.close(); }
})().catch(e => { console.error(e); process.exitCode = 1; });
