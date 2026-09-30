'use strict';
const assert = require('assert');
const fs = require('fs');
const path = require('path');
const vm = require('vm');
const puppeteer = require('puppeteer-core');
const build = path.resolve(__dirname, '../_build');
const sandbox = {window: {}};
vm.runInNewContext(fs.readFileSync(path.join(build, 'assets/js/demo-tour-content.js'), 'utf8'), sandbox);
const runtime = fs.readFileSync(path.join(build, 'assets/js/demo-tour.js'), 'utf8');
const kinds = new Set([...runtime.matchAll(/case '([^']+)':/g)].map(match => match[1]));
for (const mode of ['full', 'short']) {
  const steps = sandbox.window.MIB_TOUR_CONTENT[mode];
  assert(steps.length > 0);
  for (const step of steps) for (const cue of step.cue || []) {
    assert(kinds.has(cue.kind), `${mode}/${step.id}: unsupported cue ${cue.kind}`);
  }
  console.log(`PASS ${mode}: every cue kind is still supported`);
}
(async () => {
  const browser = await puppeteer.launch({executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe', headless: true});
  try {
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8765/login');
    await page.type('[name="username"]', 'demo');
    await page.type('[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation(), page.click('button[type="submit"]')]);
    const result = await page.evaluate(async () => {
      const url = '/vendor/dashboard/tour_action';
      const post = async action => {
        const response = await fetch(url, {method: 'POST', body: new URLSearchParams({action})});
        return {status: response.status, body: await response.json()};
      };
      return {get: (await fetch(url)).status, legacy: await post('capture_lead'), reset: await post('reset')};
    });
    assert.equal(result.get, 405);
    assert.equal(result.legacy.status, 400);
    assert.equal(result.legacy.body.ok, false);
    assert.equal(result.reset.status, 200);
    assert.equal(result.reset.body.ok, true);
    console.log('PASS reset works; GET and retired actions are rejected (isolated test session)');
  } finally { await browser.close(); }
})().catch(error => {console.error(error); process.exitCode = 1;});
