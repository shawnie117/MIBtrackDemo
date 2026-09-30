#!/usr/bin/env node
'use strict';

const puppeteer = require('puppeteer-core');
const chrome = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const base = 'http://127.0.0.1:8765';

(async () => {
    const browser = await puppeteer.launch({ executablePath: chrome, headless: true,
        args: ['--no-sandbox', '--mute-audio', '--autoplay-policy=no-user-gesture-required'] });
    try {
        const page = await browser.newPage();
        await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="username"]', 'demo');
        await page.type('input[name="password"]', 'demo123');
        await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
            page.click('button[type="submit"], input[type="submit"]')]);
        await page.goto(base + '/vendor/dashboard/tour?tour=full&lang=en', { waitUntil: 'domcontentloaded' });
        await page.click('#tour-start-btn');

        await page.evaluate(() => {
            window.MIB_TOUR.step.selector = '#intentionally_missing_for_test';
            window.MIB_TOUR.goTo(0);
        });
        await page.waitForFunction(() => window.MIB_TOUR.phase === 'error', { timeout: 22000 });
        const error = await page.evaluate(() => ({
            title: document.getElementById('tour-error-title').textContent,
            visible: getComputedStyle(document.getElementById('tour-error')).display !== 'none',
            retry: !!document.getElementById('tour-retry'),
            skip: !!document.getElementById('tour-skip')
        }));
        if (!error.visible || !error.title || !error.retry || !error.skip) {
            throw new Error('Missing or incomplete recovery panel: ' + JSON.stringify(error));
        }
        console.log('PASS missing target shows an actionable error panel');

        await page.evaluate(() => { window.MIB_TOUR.step.selector = '.page-content'; });
        await page.click('#tour-retry');
        await page.waitForFunction(() => window.MIB_TOUR.phase === 'narrating', { timeout: 22000 });
        console.log('PASS Retry recovers when the target exists');

        await page.evaluate(() => {
            window.MIB_TOUR.step.selector = '#intentionally_missing_for_test';
            window.MIB_TOUR.goTo(0);
        });
        await page.waitForFunction(() => window.MIB_TOUR.phase === 'error', { timeout: 22000 });
        await page.click('#tour-skip');
        await page.waitForFunction(() => window.MIB_TOUR.index === 1 &&
            window.MIB_TOUR.phase === 'narrating', { timeout: 22000 });
        console.log('PASS Skip continues to the next Full Demo step');
    } finally { await browser.close(); }
})().catch((err) => { console.error('FAIL', err.message); process.exitCode = 1; });
