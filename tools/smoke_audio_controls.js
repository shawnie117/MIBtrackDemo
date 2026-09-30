#!/usr/bin/env node
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const base = process.argv[2] || 'http://127.0.0.1:8765';
const chrome = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe', process.env['ProgramFiles(x86)'] + '\\Google\\Chrome\\Application\\chrome.exe', process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find(p => p && fs.existsSync(p));
const sleep = ms => new Promise(r => setTimeout(r, ms));

(async () => {
  const browser = await puppeteer.launch({ executablePath: chrome, headless: true, args: ['--no-sandbox', '--autoplay-policy=no-user-gesture-required'] });
  const page = await browser.newPage();
  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo'); await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }), page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(base + '/vendor/dashboard/tour?tour=full', { waitUntil: 'domcontentloaded' });
    await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
    await page.select('#tour-speed', '3');
    await page.click('#tour-start-btn');
    await page.waitForFunction(() => {
      const a = document.querySelector('#tour-audio');
      return a && /\/mr\/f01\.mp3/.test(a.currentSrc) && a.duration > 0 && a.currentTime > 0;
    }, { timeout: 15000 });
    let state = await page.evaluate(() => {
      const a = document.querySelector('#tour-audio');
      return { rate: a.playbackRate, duration: a.duration, time: a.currentTime, spot: window.MIB_TOUR.spotlightRect() };
    });
    if (state.rate !== 3 || !state.spot) throw new Error('3x playback or focus spotlight failed: ' + JSON.stringify(state));

    await page.click('#tour-play');
    const pausedAt = await page.$eval('#tour-audio', a => a.currentTime);
    await sleep(900);
    const stillAt = await page.$eval('#tour-audio', a => a.currentTime);
    if (Math.abs(stillAt - pausedAt) > 0.08) throw new Error('Pause did not freeze narration.');

    await page.select('#tour-speed', '2');
    const rateTwo = await page.$eval('#tour-audio', a => a.playbackRate);
    if (rateTwo !== 2) throw new Error('Changing speed while paused did not update playbackRate.');
    await page.click('#tour-play');
    await sleep(700);
    const resumedAt = await page.$eval('#tour-audio', a => a.currentTime);
    if (resumedAt <= stillAt) throw new Error('Resume did not continue narration.');

    await page.click('#tour-next');
    await page.waitForFunction(() => window.MIB_TOUR.index === 1 && /\/mr\/f02\.mp3/.test(document.querySelector('#tour-audio').currentSrc), { timeout: 15000 });
    console.log('PASS recorded Marathi MP3 playback');
    console.log('PASS 3x and live 2x speed changes');
    console.log('PASS pause/resume freezes and continues audio');
    console.log('PASS Next loads the next synchronized clip and screen');
  } finally { await browser.close(); }
})().catch(err => { console.error('FAIL ' + (err.stack || err)); process.exit(1); });
