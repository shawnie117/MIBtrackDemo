/* Compare click methods, and test whether backdrop-filter is the culprit. */
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');
const CHROME = [process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'].find((p) => p && fs.existsSync(p));
const BASE = 'http://127.0.0.1:8765';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

async function attempt(headless, method, killBlur) {
    const browser = await puppeteer.launch({
        executablePath: CHROME, headless,
        defaultViewport: { width: 1440, height: 900 },
        args: ['--mute-audio', '--autoplay-policy=no-user-gesture-required', '--no-sandbox']
    });
    const page = await browser.newPage();
    await page.goto(BASE + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
        page.click('button[type="submit"], input[type="submit"]')]);
    await page.goto(BASE + '/vendor/dashboard/tour?tour=amc&lang=en', { waitUntil: 'domcontentloaded' });
    await page.waitForSelector('#tour-start-btn');
    await sleep(1200);

    if (killBlur) {
        await page.evaluate(() => { document.getElementById('tour-start').style.backdropFilter = 'none'; });
        await sleep(200);
    }

    let note = '';
    try {
        if (method === 'page.click') {
            await page.click('#tour-start-btn');
        } else if (method === 'mouse.click') {
            const box = await (await page.$('#tour-start-btn')).boundingBox();
            await page.mouse.click(box.x + box.width / 2, box.y + box.height / 2);
        } else if (method === 'el.click') {
            await page.evaluate(() => document.getElementById('tour-start-btn').click());
        }
    } catch (e) { note = ' (threw: ' + e.message.slice(0, 60) + ')'; }

    await sleep(3000);
    const phase = await page.evaluate(() => window.MIB_TOUR.phase);
    await browser.close();

    const worked = phase !== 'idle';
    console.log('  headless=' + String(headless).padEnd(6) +
        ' blur=' + (killBlur ? 'off' : 'on ') +
        ' method=' + method.padEnd(12) +
        ' -> phase=' + phase.padEnd(11) + (worked ? 'WORKED' : 'no effect') + note);
    return worked;
}

(async () => {
    console.log('\nStart button click matrix\n');
    await attempt(true, 'page.click', false);
    await attempt(true, 'mouse.click', false);
    await attempt(true, 'el.click', false);
    await attempt(true, 'page.click', true);
    await attempt(true, 'mouse.click', true);
    console.log('');
    console.log('  headful (a real browser window, closest to a real user):');
    await attempt(false, 'page.click', false);
    await attempt(false, 'mouse.click', false);
    console.log('');
})();
