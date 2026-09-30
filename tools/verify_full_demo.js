#!/usr/bin/env node
'use strict';
const fs = require('fs');
const path = require('path');
const vm = require('vm');
const puppeteer = require('puppeteer-core');

const base = process.argv[2] || 'http://127.0.0.1:8765';
const mode = process.argv[3] === 'short' ? 'short' : 'full';
const chrome = [
  process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe',
  process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'
].find(p => p && fs.existsSync(p));
if (!chrome) throw new Error('Chrome was not found.');

const contentPath = path.resolve(__dirname, '..', '_build', 'assets', 'js', 'demo-tour-content.js');
const sandbox = { window: {} };
vm.runInNewContext(fs.readFileSync(contentPath, 'utf8'), sandbox);
const steps = sandbox.window.MIB_TOUR_CONTENT[mode];

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true, args: ['--no-sandbox', '--mute-audio'] });
  const page = await browser.newPage();
  const failures = [];
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([
      page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
      page.click('button[type="submit"], input[type="submit"]')
    ]);
    for (const step of steps) {
      const response = await page.goto(base + '/' + step.url, { waitUntil: 'domcontentloaded', timeout: 30000 });
      const status = response ? response.status() : 0;
      const target = await page.$(step.selector);
      const missingCues = [];
      for (const cue of (step.cue || [])) {
        if (!cue.selector) continue;
        if (!(await page.$(cue.selector))) missingCues.push(cue.selector);
      }
      const ok = status < 400 && !!target && !missingCues.length;
      console.log(`${ok ? 'PASS' : 'FAIL'} ${step.id} ${step.url}${missingCues.length ? ' missing ' + missingCues.join(', ') : ''}`);
      if (!ok) failures.push({ id: step.id, status, target: !!target, missingCues });
    }
  } finally {
    await browser.close();
  }
  console.log(`Checked ${mode} demo: ${steps.length} steps; ${failures.length} failed.`);
  if (failures.length) {
    console.log(JSON.stringify(failures, null, 2));
    process.exitCode = 1;
  }
})().catch(err => { console.error(err.stack || err); process.exit(1); });
