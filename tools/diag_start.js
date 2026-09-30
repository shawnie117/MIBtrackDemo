/* Why does the tour not start on the first click? Focused diagnosis. */
'use strict';
const fs = require('fs');
const puppeteer = require('puppeteer-core');

const CHROME = [
    process.env.ProgramFiles + '\\Google\\Chrome\\Application\\chrome.exe',
    process.env.LOCALAPPDATA + '\\Google\\Chrome\\Application\\chrome.exe'
].find((p) => p && fs.existsSync(p));

const BASE = 'http://127.0.0.1:8765';
const sleep = (ms) => new Promise((r) => setTimeout(r, ms));

(async () => {
    const browser = await puppeteer.launch({
        executablePath: CHROME,
        headless: true,
        defaultViewport: { width: 1440, height: 900 },
        args: ['--mute-audio', '--autoplay-policy=no-user-gesture-required', '--no-sandbox']
    });
    const page = await browser.newPage();
    page.on('console', (m) => console.log('  [console.' + m.type() + '] ' + m.text().slice(0, 180)));
    page.on('pageerror', (e) => console.log('  [pageerror] ' + e.message.slice(0, 200)));
    page.on('requestfailed', (r) => console.log('  [reqfail] ' + r.url().replace(BASE, '') + ' ' +
        (r.failure() ? r.failure().errorText : '')));

    await page.goto(BASE + '/login', { waitUntil: 'domcontentloaded' });
    await page.type('input[name="username"]', 'demo');
    await page.type('input[name="password"]', 'demo123');
    await Promise.all([
        page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
        page.click('button[type="submit"], input[type="submit"]')
    ]);
    console.log('after login: ' + page.url());

    await page.goto(BASE + '/vendor/dashboard/tour?tour=amc&lang=en', { waitUntil: 'domcontentloaded' });
    await page.waitForSelector('#tour-start-btn');

    console.log('\nbefore click:');
    console.log(await page.evaluate(() => JSON.stringify({
        hasTour: !!window.MIB_TOUR,
        phase: window.MIB_TOUR && window.MIB_TOUR.phase,
        total: window.MIB_TOUR && window.MIB_TOUR.total,
        overlayDisplay: getComputedStyle(document.getElementById('tour-start')).display,
        btnBound: typeof document.getElementById('tour-start-btn').onclick,
        frameSrc: document.getElementById('tour-frame').getAttribute('src')
    })));

    await page.click('#tour-start-btn');
    console.log('\nclicked start; polling phase for 30s:');
    for (let i = 0; i < 15; i++) {
        await sleep(2000);
        const s = await page.evaluate(() => {
            const f = document.getElementById('tour-frame');
            let inner = 'n/a';
            try { inner = f.contentWindow.location.href; } catch (e) { inner = 'BLOCKED: ' + e.message; }
            let ready = 'n/a';
            try { ready = f.contentDocument ? f.contentDocument.readyState : 'no contentDocument'; } catch (e) { ready = 'BLOCKED'; }
            return JSON.stringify({
                phase: window.MIB_TOUR.phase,
                index: window.MIB_TOUR.index,
                started: document.getElementById('tour-start').style.display,
                title: document.getElementById('tour-title').textContent.slice(0, 40),
                cue: document.getElementById('tour-cue').textContent.slice(0, 50),
                status: document.getElementById('tour-status').textContent.slice(0, 60),
                err: window.MIB_TOUR.lastError,
                innerUrl: inner,
                innerReady: ready
            });
        });
        console.log('  t+' + ((i + 1) * 2) + 's  ' + s);
        const phase = await page.evaluate(() => window.MIB_TOUR.phase);
        if (phase === 'narrating' || phase === 'error') { break; }
    }

    // What does the iframe actually contain?
    const handle = await page.$('#tour-frame');
    const frame = handle ? await handle.contentFrame() : null;
    if (frame) {
        console.log('\niframe resolved via element handle:');
        console.log('  url: ' + frame.url());
        const probe = await frame.evaluate(() => ({
            title: document.title,
            ready: document.readyState,
            hasPageContent: !!document.querySelector('.page-content'),
            hasSidebar: !!document.querySelector('.page-sidebar-menu'),
            sidebarItems: document.querySelectorAll('.page-sidebar-menu > li').length,
            hasAmcBox: !!document.querySelector('.amc-renewal-reminder'),
            hasLauncher: !!document.querySelector('.demo-tour-launcher'),
            hasPageHeader: !!document.querySelector('.page-header'),
            bodyLen: document.body.innerHTML.length
        })).catch((e) => 'evaluate failed: ' + e.message);
        console.log('  ' + JSON.stringify(probe, null, 2).replace(/\n/g, '\n  '));
    } else {
        console.log('\ncould not resolve the iframe from #tour-frame');
    }

    await browser.close();
})();
