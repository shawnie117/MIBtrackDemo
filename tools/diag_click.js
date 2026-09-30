/* What is intercepting the Start button? */
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const CHROME = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find((p) => p && fs.existsSync(p));
const BASE = 'http://127.0.0.1:8765';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

(async () => {
    const browser = await puppeteer.launch({
        executablePath: CHROME, headless: true,
        defaultViewport: { width: 1440, height: 900 },
        args: ['--mute-audio', '--autoplay-policy=no-user-gesture-required', '--no-sandbox']
    });
    const page = await browser.newPage();
    page.on('pageerror', (e) => console.log('[pageerror] ' + e.message));
    page.on('console', (m) => { if (m.type() === 'error') console.log('[console.error] ' + m.text().slice(0, 200)); });

    await page.goto(BASE + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
        page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(BASE + '/vendor/dashboard/tour?tour=amc&lang=en', { waitUntil: 'domcontentloaded' });
    await page.waitForSelector('#tour-start-btn');
    await sleep(1500);

    console.log('--- geometry and hit testing ---');
    console.log(await page.evaluate(() => {
        const btn = document.getElementById('tour-start-btn');
        const r = btn.getBoundingClientRect();
        const cx = Math.round(r.left + r.width / 2);
        const cy = Math.round(r.top + r.height / 2);
        const top = document.elementFromPoint(cx, cy);
        const stage = document.querySelector('.tour-stage').getBoundingClientRect();
        return JSON.stringify({
            btnRect: { t: Math.round(r.top), l: Math.round(r.left), w: Math.round(r.width), h: Math.round(r.height) },
            centre: [cx, cy],
            viewport: [innerWidth, innerHeight],
            stageRect: { t: Math.round(stage.top), h: Math.round(stage.height) },
            elementAtCentre: top ? (top.id || top.tagName + '.' + top.className) : 'null',
            isTheButton: top === btn,
            btnDisabled: btn.disabled,
            onclickType: typeof btn.onclick
        }, null, 2);
    }));

    console.log('\n--- direct in-page .click() (bypasses hit testing) ---');
    await page.evaluate(() => document.getElementById('tour-start-btn').click());
    await sleep(2500);
    console.log(await page.evaluate(() => JSON.stringify({
        phase: window.MIB_TOUR.phase,
        overlay: document.getElementById('tour-start').style.display
    })));

    await browser.close();
})();
