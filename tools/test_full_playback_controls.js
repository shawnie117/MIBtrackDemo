'use strict';
const assert = require('assert');
const puppeteer = require('puppeteer-core');
const wait = ms => new Promise(resolve => setTimeout(resolve, ms));
(async () => {
  const browser = await puppeteer.launch({executablePath: 'C:/Program Files/Google/Chrome/Application/chrome.exe', headless: true,
    args: ['--mute-audio', '--autoplay-policy=no-user-gesture-required']});
  try {
    const page = await browser.newPage();
    await page.goto('http://127.0.0.1:8765/login');
    await page.type('[name="username"]', 'demo');
    await page.type('[name="password"]', 'demo123');
    await Promise.all([page.waitForNavigation(), page.click('button[type="submit"]')]);
    await page.goto('http://127.0.0.1:8765/vendor/dashboard/tour?tour=full&lang=mr');
    await page.click('#tour-start-btn');
    const ready = () => page.waitForFunction(() => MIB_TOUR.phase === 'narrating' && document.querySelector('#tour-audio').readyState >= 2);
    const snapshot = () => page.evaluate(() => ({id:MIB_TOUR.step.id, time:document.querySelector('#tour-audio').currentTime,
      value:document.querySelector('#tour-frame').contentDocument.querySelector('#amc_name')?.value,
      cues:MIB_TOUR.cueLog.length, paused:MIB_TOUR.paused}));
    const finishCue = async () => {
      await ready();
      await page.evaluate(() => { const a=document.querySelector('#tour-audio'); a.currentTime=a.duration*.29; });
      await page.waitForFunction(() => MIB_TOUR.cueComplete);
      assert.equal((await snapshot()).value,'General Pest Management');
    };
    await page.evaluate(() => MIB_TOUR.goTo(2));
    await finishCue();
    await page.click('#tour-replay');
    await ready();
    assert.equal((await snapshot()).value,'');
    await finishCue();
    console.log('PASS Replay resets and repeats the visual cue');
    await page.click('#tour-play');
    const paused=await snapshot();
    await wait(800);
    const frozen=await snapshot();
    assert.equal(frozen.value,paused.value);
    assert(Math.abs(frozen.time-paused.time)<.12);
    await page.click('#tour-play');
    await wait(350);
    assert((await snapshot()).time>frozen.time);
    console.log('PASS Pause freezes recording and form; Resume continues');
    for(const language of ['en','hi','mr']) {
      await page.select('#tour-language',language);
      await ready();
      assert.equal((await snapshot()).value,'');
      await finishCue();
      assert(await page.evaluate(lang => document.querySelector('#tour-audio').currentSrc.includes('/'+lang+'/f03.mp3'), language));
    }
    console.log('PASS language changes replay matching audio and actions');
    await page.click('#tour-next');
    await ready();
    await page.click('#tour-prev');
    await ready();
    assert.equal((await snapshot()).value,'');
    await finishCue();
    console.log('PASS Previous replays the original scene');
    await page.click('#tour-control');
    assert(await page.evaluate(() => MIB_TOUR.manual && MIB_TOUR.paused));
    await page.click('#tour-control');
    await ready();
    await finishCue();
    console.log('PASS Take control and Return restart synchronized playback');
    await page.setRequestInterception(true);
    page.on('request', request => request.url().includes('/f02.mp3') ? request.abort() : request.continue());
    await page.evaluate(() => MIB_TOUR.goTo(1));
    await page.waitForFunction(() => MIB_TOUR.phase === 'error');
    assert(await page.evaluate(() => document.querySelector('#tour-audio').paused && MIB_TOUR.paused));
    console.log('PASS missing recording stops the scene with recovery instead of fallback speech');
  } finally { await browser.close(); }
})().catch(error => {console.error(error);process.exitCode=1;});
