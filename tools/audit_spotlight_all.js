#!/usr/bin/env node
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const base = process.argv[2] || 'http://127.0.0.1:8765';
const chrome = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe', process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe', process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find(p => p && fs.existsSync(p));

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true, defaultViewport: { width: 1440, height: 900 }, args: ['--no-sandbox', '--mute-audio', '--autoplay-policy=no-user-gesture-required'] });
  const page = await browser.newPage();
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo'); await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(base + '/vendor/dashboard/tour?tour=full', { waitUntil: 'domcontentloaded' });
    await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
    // Slow playback keeps short narration clips from auto-advancing while
    // the geometry checker samples the focused target.
    await page.select('#tour-speed', '0.5');

    for (let i = 0; i < 23; i++) {
      await page.evaluate(index => window.MIB_TOUR.goTo(index), i);
      try {
        await page.waitForFunction(index => {
          if (!window.MIB_TOUR || window.MIB_TOUR.index !== index || window.MIB_TOUR.lastError) return false;
          return !!window.MIB_TOUR.spotlightRect() && !!window.MIB_TOUR.targetRect();
        }, { timeout: 20000 }, i);
      } catch (err) {
        const debug = await page.evaluate(() => ({
          index: window.MIB_TOUR && window.MIB_TOUR.index,
          phase: window.MIB_TOUR && window.MIB_TOUR.phase,
          step: window.MIB_TOUR && window.MIB_TOUR.step && window.MIB_TOUR.step.id,
          error: window.MIB_TOUR && window.MIB_TOUR.lastError,
          spotlight: window.MIB_TOUR && window.MIB_TOUR.spotlightRect(),
          target: window.MIB_TOUR && window.MIB_TOUR.targetRect()
        }));
        throw new Error(`F${String(i + 1).padStart(2, '0')} focus wait failed: ${JSON.stringify(debug)}`);
      }
      const check = await page.evaluate(() => {
        const s = window.MIB_TOUR.spotlightRect();
        const t = window.MIB_TOUR.targetRect();
        const right = Math.min(s.left + s.width, t.left + t.width);
        const bottom = Math.min(s.top + s.height, t.top + t.height);
        const overlap = Math.max(0, right - Math.max(s.left, t.left)) * Math.max(0, bottom - Math.max(s.top, t.top));
        const targetArea = Math.max(1, t.width * t.height);
        return { id: window.MIB_TOUR.step.id, overlapRatio: overlap / targetArea, error: window.MIB_TOUR.lastError };
      });
      if (check.error || check.overlapRatio < 0.9) throw new Error(`${check.id} spotlight overlap is ${check.overlapRatio}`);
      console.log(`PASS ${check.id} focus alignment`);
    }
  } finally { await browser.close(); }
})().catch(err => { console.error('FAIL ' + (err.stack || err)); process.exit(1); });
