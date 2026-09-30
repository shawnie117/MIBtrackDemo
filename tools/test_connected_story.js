'use strict';
const assert=require('assert'),fs=require('fs'),path=require('path'),puppeteer=require('puppeteer-core');
const base='http://127.0.0.1:8765',out=path.join(__dirname,'live_shots','connected-story');fs.mkdirSync(out,{recursive:true});
(async()=>{
 const browser=await puppeteer.launch({executablePath:'C:/Program Files/Google/Chrome/Application/chrome.exe',headless:true,defaultViewport:{width:1440,height:900}});
 const page=await browser.newPage(),errors=[];page.on('pageerror',e=>errors.push(e.message));
 const login=async p=>{await p.goto(base+'/login');await p.type('[name="username"]','demo');await p.type('[name="password"]','demo123');await Promise.all([p.waitForNavigation(),p.click('button[type="submit"]')]);};
 const api=async(action,data={})=>page.evaluate(async({action,data})=>{
   const s=await(await fetch('/vendor/dashboard/story')).json();if(!action)return s;
   const r=await fetch('/vendor/dashboard/story',{method:'POST',body:new URLSearchParams({action,token:s.token,...data})});return {status:r.status,...await r.json()};
 },{action,data});
 const ready=()=>page.waitForFunction(()=>window.MIB_MOBILE_DEMO&&!MIB_MOBILE_DEMO.pending);
 const click=async s=>{await page.click(s);await ready();assert.equal(await page.evaluate(()=>MIB_MOBILE_DEMO.error),'');};
 try{
  await login(page);
  const denied=await api('ticket_prepare',{token:'invalid'});assert.equal(denied.status,403);
  assert.equal((await api('ticket_update')).status,422);
  await api('attendance_prepare');await api('ticket_prepare');const id=(await api()).state.ticket_id;
  await page.goto(base+'/assets/demo-mobile/index.html?screen=attendance&connected=1');await ready();
  await click('#attendance-login');await click('#submit-selfie');await click('#attendance-logout');await click('#submit-selfie');
  await page.goto(base+'/vendor/admin/emp_attendance_report');
  await page.waitForFunction(()=>/09:00\s*AM/i.test(document.body.innerText)&&/06:00\s*PM/i.test(document.body.innerText));
  await page.waitForNetworkIdle();
  await page.screenshot({path:path.join(out,'desktop-attendance.png')});console.log('PASS mobile attendance appears in desktop report');
  await page.goto(base+'/assets/demo-mobile/index.html?screen=tickets&connected=1');await ready();
  await click('#sample-ticket');await click('#ticket-menu');await click('#start-ticket-option');await page.type('#start-remark','Starting Work');await click('#start-ticket-submit');
  await click('#ticket-menu');await click('#update-ticket-option');await page.type('#ticket-review','Service done');await page.type('#ticket-description','General pest management service completed.');await page.select('#ticket-status','Resolved');await click('#work-photo');await click('#update-submit');await click('#add-signature');await click('#submit-ticket');
  assert.equal((await api()).state.status,'Resolved');
  await page.goto(base+'/vendor/dashboard/story_ticket');assert(page.url().includes(encodeURIComponent(Buffer.from(id).toString('base64')))||decodeURIComponent(page.url()).includes(Buffer.from(id).toString('base64')));
  const text=await page.$eval('body',e=>e.innerText);assert(text.includes('Visit for service.')&&text.includes('Service done')&&text.includes('Resolved'));
  assert(/demo signature/i.test(text));
  await page.waitForNetworkIdle();
  await page.screenshot({path:path.join(out,'desktop-ticket.png')});console.log('PASS same ticket ID and mobile review/status/signature appear on desktop');
  await page.goto(base+'/assets/demo-mobile/index.html?screen=tickets&connected=1');await ready();assert.equal(await page.evaluate(()=>MIB_MOBILE_DEMO.state.status),'Resolved');
  const otherContext=await browser.createBrowserContext();const other=await otherContext.newPage();await login(other);
  const clean=await other.evaluate(async()=> (await(await fetch('/vendor/dashboard/story')).json()).state);assert.equal(clean.ticket_id,null);assert.equal(clean.login,false);await otherContext.close();
  await api('ticket_prepare');assert.equal((await api()).state.ticket_id,id);assert.equal((await api()).state.status,'Open');assert.equal((await api()).state.logout,true);
  console.log('PASS reload persists, separate browser isolates, replay reuses ID and retains attendance');
  assert.deepEqual(errors,[]);console.log('PASS token validation, ordering validation, zero browser exceptions');
 }finally{await browser.close();}
})().catch(e=>{console.error(e);process.exitCode=1;});
