#!/usr/bin/env node
'use strict';

const fs = require('fs');
const puppeteer = require('puppeteer-core');
const chrome = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find(p => p && fs.existsSync(p));
const base = process.argv[2] || 'http://127.0.0.1:8765';
const id = process.argv[3] || 'f11';
const lang = process.argv[4] || 'en';
const shots = process.argv.includes('--shots');

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true,
    args: ['--no-sandbox', '--autoplay-policy=no-user-gesture-required'],
    defaultViewport: { width: 1366, height: 768 } });
  try {
    const page = await browser.newPage();
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
      page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(base + '/vendor/dashboard/tour?tour=full&lang=' + lang,
      { waitUntil: 'domcontentloaded' });
    await page.select('#tour-speed', '3');
    await page.click('#tour-start-btn');
    await page.evaluate(stepId => window.MIB_TOUR.goTo(window.MIB_TOUR.stepIds().indexOf(stepId)), id);
    const started = Date.now();
    let last = '';
    while (Date.now() - started < 90000) {
      const state = await page.evaluate(() => {
        const t = window.MIB_TOUR;
        const frame = document.querySelector('#tour-frame');
        const a = document.querySelector('#tour-audio');
        return { id: t.step.id, phase: t.phase, url: frame.contentWindow.location.pathname,
          seconds: Number(a.currentTime.toFixed(2)), duration: Number(a.duration.toFixed(2)),
          cues: t.cueLog.map(c => c.id + ':' + (c.finishedAt === null ? 'running' : 'done')),
          error: t.lastError };
      });
      const signature = JSON.stringify([state.id, state.phase, state.url, state.cues, state.error]);
      if (signature !== last) {
        console.log(JSON.stringify(state));
        if (shots && state.phase === 'narrating') {
          const label = state.cues.length + '-' + state.url.split('/').pop();
          await page.screenshot({ path: 'tools/live_shots/sync-' + id + '-' + lang + '-' + label + '.png' });
        }
        last = signature;
      }
      if (state.phase === 'error') {
        console.log('BODY', JSON.stringify(await page.evaluate(() =>
          document.querySelector('#tour-frame').contentDocument.body.innerText.slice(-1200))));
        console.log('LINKS', JSON.stringify(await page.evaluate(() =>
          [...document.querySelector('#tour-frame').contentDocument.querySelectorAll('a')]
            .filter(a => /follow|payment/i.test((a.title || '') + ' ' + a.textContent))
            .map(a => ({ title: a.title, text: a.textContent.trim(), visible: !!a.offsetParent }))
            .slice(0, 25))));
      }
      if (state.id !== id || state.phase === 'error' || state.phase === 'finished') break;
      await new Promise(resolve => setTimeout(resolve, 150));
    }
  } finally { await browser.close(); }
})().catch(e => { console.error(e.stack || e); process.exitCode = 1; });
