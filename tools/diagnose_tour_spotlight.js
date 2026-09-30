#!/usr/bin/env node
'use strict';

const puppeteer = require('puppeteer-core');
const chrome = 'C:\\Program Files\\Google\\Chrome\\Application\\chrome.exe';
const base = 'http://127.0.0.1:8765';
const width = Number(process.argv[2] || 1366);
const height = Number(process.argv[3] || 768);
const stepId = process.argv[4] || 'f19';

(async () => {
    const browser = await puppeteer.launch({ executablePath: chrome, headless: true,
        args: ['--no-sandbox', '--mute-audio', '--autoplay-policy=no-user-gesture-required'],
        defaultViewport: { width, height } });
    try {
        const page = await browser.newPage();
        await page.goto(base + '/login', { waitUntil: 'domcontentloaded' });
        await page.type('input[name="username"]', 'demo');
        await page.type('input[name="password"]', 'demo123');
        await Promise.all([page.waitForNavigation({ waitUntil: 'domcontentloaded' }),
            page.click('button[type="submit"], input[type="submit"]')]);
        await page.goto(base + '/vendor/dashboard/tour?tour=full&lang=en', { waitUntil: 'domcontentloaded' });
        await page.click('#tour-start-btn');
        await page.evaluate((id) => window.MIB_TOUR.goTo(window.MIB_TOUR.stepIds().indexOf(id)), stepId);
        await new Promise((resolve) => setTimeout(resolve, 3500));
        const result = await page.evaluate(() => {
            const tour = window.MIB_TOUR;
            const frame = document.getElementById('tour-frame');
            const stage = document.querySelector('.tour-stage');
            const el = frame.contentDocument.querySelector(tour.step.selector);
            const rect = el && el.getBoundingClientRect();
            const ancestors = [];
            for (let node = el; node && ancestors.length < 12; node = node.parentElement) {
                const style = frame.contentWindow.getComputedStyle(node);
                ancestors.push({ tag: node.tagName, id: node.id, className: String(node.className).slice(0, 50),
                    overflowY: style.overflowY, scrollTop: node.scrollTop,
                    clientHeight: node.clientHeight, scrollHeight: node.scrollHeight });
            }
            return { phase: tour.phase, selector: tour.step.selector,
                stageHeight: stage.clientHeight, iframeHeight: frame.clientHeight,
                frameScrollY: frame.contentWindow.scrollY,
                docHeight: frame.contentDocument.documentElement.scrollHeight,
                docClientHeight: frame.contentDocument.documentElement.clientHeight,
                bodyHeight: frame.contentDocument.body.scrollHeight,
                target: rect && { top: rect.top, bottom: rect.bottom, height: rect.height },
                spot: tour.spotlightRect(), ancestors };
        });
        console.log(JSON.stringify(result, null, 2));
        await page.evaluate(() => {
            const frame = document.getElementById('tour-frame');
            frame.contentDocument.querySelector(window.MIB_TOUR.step.selector)
                .scrollIntoView({ behavior: 'instant', block: 'center' });
        });
        await new Promise((resolve) => setTimeout(resolve, 300));
        console.log('after forced scroll', JSON.stringify(await page.evaluate(() => {
            const frame = document.getElementById('tour-frame');
            const rect = frame.contentDocument.querySelector(window.MIB_TOUR.step.selector).getBoundingClientRect();
            return { scrollY: frame.contentWindow.scrollY, top: rect.top, bottom: rect.bottom,
                spot: window.MIB_TOUR.spotlightRect() };
        })));
    } finally { await browser.close(); }
})().catch((err) => { console.error(err); process.exitCode = 1; });
