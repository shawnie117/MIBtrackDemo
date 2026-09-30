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

async function waitForClip(page, lang, id) {
  await page.waitForFunction((wantedLang, wantedId) => {
    const audio = document.querySelector('#tour-audio');
    return window.MIB_TOUR && window.MIB_TOUR.lang === wantedLang &&
      window.MIB_TOUR.step && window.MIB_TOUR.step.id === wantedId &&
      audio && audio.currentSrc.includes(`/audio/${wantedLang}/${wantedId}.mp3`) &&
      Number.isFinite(audio.duration) && audio.duration > 0;
  }, { timeout: 20000 }, lang, id);
}

(async () => {
  if (!chrome) throw new Error('Chrome was not found.');
  const browser = await puppeteer.launch({
    executablePath: chrome,
    headless: true,
    args: ['--no-sandbox', '--mute-audio', '--autoplay-policy=no-user-gesture-required']
  });
  const page = await browser.newPage();
  const errors = [];
  page.on('pageerror', error => errors.push(error.message));
  page.on('console', message => { if (message.type() === 'error') errors.push(message.text()); });

  try {
    await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([
      page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
      page.click('button[type="submit"], input[type="submit"]')
    ]);

    for (const lang of ['mr', 'hi', 'en']) {
      await page.goto(`${base}/vendor/dashboard/tour?tour=full&lang=${lang}`, { waitUntil: 'domcontentloaded' });
      await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
      const shell = await page.evaluate(() => ({
        lang: window.MIB_TOUR.lang,
        selected: document.querySelector('#tour-language').value,
        options: Array.from(document.querySelectorAll('#tour-language option')).map(option => option.value),
        complete: window.MIB_TOUR_CONTENT.full.every(step =>
          ['mr', 'hi', 'en'].every(code => typeof step.text[code] === 'string' && step.text[code].trim()))
      }));
      if (shell.lang !== lang || shell.selected !== lang || shell.options.join(',') !== 'mr,hi,en' || !shell.complete) {
        throw new Error(`Invalid ${lang} shell/content: ${JSON.stringify(shell)}`);
      }
      await page.select('#tour-speed', '3');
      await page.click('#tour-start-btn');
      await waitForClip(page, lang, 'f01');
      const playback = await page.evaluate(() => ({
        caption: document.querySelector('#tour-caption').textContent,
        expected: window.MIB_TOUR.step.text[window.MIB_TOUR.lang],
        rate: document.querySelector('#tour-audio').playbackRate
      }));
      if (playback.caption !== playback.expected || playback.rate !== 3) {
        throw new Error(`Caption/audio mismatch for ${lang}: ${JSON.stringify(playback)}`);
      }
      console.log(`PASS ${lang}: selected text and recorded f01 audio are synchronized`);
    }

    // Switching languages must replay only the narration and must not repeat
    // the synchronized form action for the current step.
    await page.goto(`${base}/vendor/dashboard/tour?tour=full&lang=mr`, { waitUntil: 'domcontentloaded' });
    await page.waitForFunction(() => window.MIB_TOUR && window.MIB_TOUR.total === 23);
    await page.select('#tour-speed', '3');
    await page.click('#tour-start-btn');
    await waitForClip(page, 'mr', 'f01');
    await page.click('#tour-next');
    await waitForClip(page, 'mr', 'f02');
    await page.select('#tour-language', 'hi');
    await waitForClip(page, 'hi', 'f02');
    await page.select('#tour-language', 'en');
    await waitForClip(page, 'en', 'f02');
    const switched = await page.evaluate(() => ({
      lang: window.MIB_TOUR.lang,
      caption: document.querySelector('#tour-caption').textContent,
      expected: window.MIB_TOUR.step.text.en,
      index: window.MIB_TOUR.index,
      audio: document.querySelector('#tour-audio').currentSrc
    }));
    if (switched.lang !== 'en' || switched.caption !== switched.expected || switched.index !== 1 || !/\/en\/f02\.mp3$/.test(switched.audio)) {
      throw new Error('Live language switching lost synchronization: ' + JSON.stringify(switched));
    }
    console.log('PASS live Marathi → Hindi → English switching stays on the same step');

    const uniqueErrors = [...new Set(errors)].filter(message => !/favicon/i.test(message));
    if (uniqueErrors.length) throw new Error('Browser errors: ' + uniqueErrors.join(' | '));
    console.log('PASS no browser console or page errors');
  } finally {
    await browser.close();
  }
})().catch(error => {
  console.error('FAIL ' + (error.stack || error));
  process.exit(1);
});
