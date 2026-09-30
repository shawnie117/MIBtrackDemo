/* Android UI simulation. Optional session-only demo API; never production. */
'use strict';
(() => {
  const screen = document.getElementById('screen'), header = document.getElementById('header');
  const connected = new URLSearchParams(location.search).get('connected') === '1';
  const endpoint = new URL('../../vendor/dashboard/story', location.href).href;
  let token='', pending=false, lastError='';
  async function sync(action, payload={}) {
    if(!connected)return;
    const controller=new AbortController();
    const timeout=setTimeout(()=>controller.abort(),10000);
    const options={credentials:'same-origin',cache:'no-store',signal:controller.signal};
    if(action){options.method='POST';options.body=new URLSearchParams({action,token,...payload});}
    try {
    const response=await fetch(endpoint,options);
    if(response.redirected)throw new Error('Your demo login expired. Sign in again in the desktop tab.');
    const result=await response.json();
    if(!response.ok||!result.ok)throw new Error(result.message||'Could not save the demo record. Retry.');
    token=result.token;Object.assign(state,result.state);
    } finally {clearTimeout(timeout);}
  }
  const state = {view:'login', login:false, logout:false, started:false, status:'Open', review:'', description:'', workType:'Service', photo:false, signed:false, pendingStatus:'Open', tab:'pending'};
  const esc = text => String(text).replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
  const date = new Date().toLocaleDateString('en-GB',{day:'2-digit',month:'short',year:'numeric'});
  const button = (id,text,action,cls='') => {
    const icons={notification:'bell-o',complaint:'file-text-o',ticket:'ticket',lead:'users',customer:'user-o',product:'cube',ots:'hand-paper-o',amc:'gear',leads:'users',attendance:'user-circle-o'};
    if(cls==='tile') text=text.replace(/<span class="icon">.*?<\/span>/,`<span aria-hidden="true" class="icon fa fa-${icons[id.slice(5)]}"></span>`);
    const labels={'ticket-menu':'Ticket options','add-ticket':'Add New Ticket','show-password':'Show or hide password','mobile-back':action==='menu'?'Open menu':'Dashboard'};
    return `<button type="button" id="${id}" data-action="${action}" class="${cls}"${labels[id]?` aria-label="${labels[id]}"`:''}>${text}</button>`;
  };
  const pair = (key,value) => `<div class="pair"><strong>${key}</strong><span>${esc(key==='Start Remark :'&&state.started?state.startRemark:value)}</span></div>`;
  const input = (id,label,type='text',value='') => `<label for="${id}">${label}</label><input id="${id}" type="${type}" value="${esc(value)}" autocomplete="off">`;
  const select = (id,label,options) => `<label for="${id}">${label}</label><select id="${id}">${options.map(x=>`<option>${esc(x)}</option>`).join('')}</select>`;
  const note = text => `<p class="hint">${text}</p>`;
  function render(view) {
    state.view=view; screen.className='';
    const titles={login:'',otp:'Verify OTP',home:'MIBtrack',menu:'MIBtrack',attendance:'Daily Attendance',capture:'Selfie Attendance',tickets:'My Ticket',detail:'Ticket Detail Report',start:'Start Ticket',update:'Update Ticket',signature:'Client Signature',add:'Add New Ticket'};
    header.hidden=view==='login';
    header.innerHTML=button('mobile-back',view==='home'?'☰':'←',view==='home'?'menu':'home')+`<h1>${titles[view]||'MIBtrack'}</h1>`+(view==='home'?'<span>P.</span>':view==='detail'?button('ticket-menu','⋮','ticket-menu'):view==='tickets'?button('add-ticket','⊕','add'):'');
    if(view==='login') {
      screen.className='login';
      screen.innerHTML=`<div class="card"><h2>LOGIN</h2>${input('mobile-user','User Id *:')}
        <label for="mobile-password">Password *:</label><div class="password-row"><input id="mobile-password" type="password" autocomplete="off">${button('show-password','◉','show-password')}</div>
        <div class="secondary">${button('login-browse','BROWSE','browse-help','white-button')}</div><div class="forgot">${button('forgot-password','Forgot Password?','forgot-help','white-button')}</div>
        ${button('mobile-login','LOGIN','login','wide white-button')}<div class="message" id="message" role="status"></div></div>${note('Use sample user 8546951251 and password demo123. Do not enter real credentials.')}`;
    } else if(view==='otp') {
      screen.innerHTML=`<div class="card">${note('Simulated OTP screen — layout not supplied. No SMS is sent. Demo code: 123456.')}${input('mobile-otp','Enter demo OTP','text')}${button('verify-otp','VERIFY','verify','wide')}<p id="message" role="status"></p></div>`;
    } else if(view==='home') {
      screen.className='home';
      screen.innerHTML=`<div class="banner"><h2>A Field Service Management Software</h2><strong>MI-BTRACK<br>Improve Your Service Business</strong><p>Lead · Follow-Up · Customer · Ticket · AMC</p></div><div class="tiles">${[['Notification','♧','help'],['Complaint','▤','help'],['Ticket','◇','tickets'],['Lead','♙','help'],['Customer','♙','help'],['Product','▱','help'],['OTS','◷','help'],['AMC','⚙','help'],['Leads','♙','help'],['Attendance','♙','attendance']].map(([name,icon,act])=>button('tile-'+name.toLowerCase(),`<span class="icon">${icon}</span>${name}`,act,'tile')).join('')}</div><p id="message" class="message" role="status"></p>`;
    } else if(view==='menu') {
      screen.innerHTML=`<div class="card menu">${note('Demo menu — only the mapped workflows are interactive.')}${button('employee-attendance','Employee Attendance','attendance')}${button('my-tickets','My Tickets','tickets')}${button('dashboard','Dashboard','home')}</div>`;
    } else if(view==='attendance') {
      screen.innerHTML=`<div class="card" id="attendance-card"><div class="selfie-row"><div id="login-photo" class="photo ${state.login?'sample':''}">${state.login?'Demo selfie<br>Prajyot':'No image<br>available'}</div>${button('attendance-login','LOGIN','capture-login')}</div><div class="selfie-row"><div id="logout-photo" class="photo ${state.logout?'sample':''}">${state.logout?'Demo selfie<br>Prajyot':'No image<br>available'}</div>${button('attendance-logout','LOGOUT','capture-logout')}</div><p class="timing">Login Timing ${state.login?'09:00 AM':''}</p><p class="timing">Logout Timing ${state.logout?'06:00 PM':''}</p><div class="month-title">Month’s Attendance Report</div><div class="month-filter">Select Month: <select aria-label="Month"><option>${new Date().toLocaleString('en',{month:'long'})}</option></select><select aria-label="Year"><option>${new Date().getFullYear()}</option></select></div><table id="attendance-table"><tr><th>Date</th><th>Login</th><th>Logout</th></tr><tr><td>${date}</td><td>${state.login?'09:00 am':'—'}</td><td>${state.logout?'06:00 pm':'—'}</td></tr></table>${note('Synthetic attendance. Times illustrate an office day; no real attendance is recorded.')}<p id="message" role="status"></p></div>`;
    } else if(view==='capture') {
      screen.innerHTML=`<div class="card">${note('Simulated selfie screen — layout not supplied. Camera is not accessed.')}<span class="sample-person">♙</span><div class="photo sample wide">Demo selfie · Prajyot</div>${button('submit-selfie','SUBMIT ATTENDANCE','submit-selfie','wide')}</div>`;
    } else if(view==='tickets') {
      screen.innerHTML=`<div class="tabs">${['pending','resolved','closed'].map(tab=>button('tab-'+tab,tab.toUpperCase(),'tab-'+tab,state.tab===tab?'active':'')).join('')}</div><div id="ticket-list">${ticketList()}</div>`;
    } else if(view==='detail') {
      screen.innerHTML=`<div id="ticket-actions" hidden class="actions-menu">${button('start-ticket-option','Start Ticket','start')}${button('update-ticket-option','Update Ticket','update')}</div><section class="detail" id="customer-details"><h2>Customer Details</h2>${pair('Customer Name :','Adinath Mhaske')}${pair('Contact Number :','Demo contact (not dialable)')}${pair('Landline :','—')}${pair('Address :','Swastik niwas, khandagale vasti, Mumbai.')}${pair('City :','Mumbai')}${pair('District :','Mumbai')}${pair('State :','Maharashtra')}${pair('Reference By :','Google')}</section><section class="detail" id="ticket-details"><h2>Ticket Details</h2>${pair('Ticket Title:','Visit for service.')}${pair('Ticket Description :','Provide the GPM service properly.')}${pair('Ticket Status :',state.status)}${pair('Assigned On :',date)}${pair('Start Date & Time :',state.started?date+' 10:00 AM':'—')}${pair('Start Remark :',state.started?'Starting Work':'—')}${pair('Started By :',state.started?'Prajyot':'—')}${state.review?pair('Review :',state.review)+pair('Description :',state.description)+pair('Work Type :',state.workType):''}${state.photo?pair('Work Photo :','Synthetic demo placeholder'):''}${state.signed?pair('Signature :','Demo signature (not a real signature)'):''}</section><p class="message" id="message" role="status"></p>`;
    } else if(view==='start') {
      screen.innerHTML=`<div class="card">${note('Simulated Start Ticket form — layout not supplied.')}${input('start-remark','Start Ticket Remark')}${button('start-ticket-submit','START TICKET','start-submit','wide')}<p id="message" role="status"></p></div>`;
    } else if(view==='update') {
      screen.innerHTML=`<div class="card">${note('Simulated Update Ticket form — layout not supplied.')}${input('ticket-review','Review')}<label for="ticket-description">Description</label><textarea id="ticket-description"></textarea>${select('ticket-work-type','Work Type',['Service','Repair','Both'])}${select('ticket-status','Status',['Open','Resolved'])}<label>Work-related Image</label>${button('work-photo','BROWSE','work-photo')}<p id="photo-result" role="status"></p>${button('update-submit','UPDATE','update-submit','wide')}<p id="message" role="status"></p></div>`;
    } else if(view==='signature') {
      screen.innerHTML=`<div class="card">${note('Simulated signature screen — no real signature is requested or stored.')}<div id="signature-preview" class="signature">Demo customer signature</div>${button('add-signature','ADD SAMPLE SIGNATURE','add-signature','wide')}${button('submit-ticket','SUBMIT','submit-ticket','wide')}<p id="message" role="status"></p></div>`;
    } else if(view==='add') {
      screen.innerHTML=`<div class="card"><label>Customer Type<span class="required">*</span>:</label><div class="radios"><label><input type="radio" name="customer-type" value="customer" checked> Customer</label><label><input type="radio" name="customer-type" value="lead"> Lead</label></div>${select('new-customer','Lead/Customer*',['Select Customer','Adinath Mhaske'])}${input('new-title','Ticket Title*')}${input('new-description','Ticket Description:')}${select('new-priority','Ticket Priority*',['Select Priority','High','Medium','Low'])}${select('new-employee','Ticket Assigned To:',['Select Employee','Prajyot'])}${input('new-date','Ticket Date*','date')}${button('new-submit','SUBMIT','new-submit','wide')}<p id="message" role="status"></p>${note('Practice form only. The guided story uses its built-in sample ticket.')}</div>`;
    }
    window.scrollTo(0,0);
  }
  function ticketList(){
    const visible=(state.tab==='pending'&&state.status==='Open')||(state.tab==='resolved'&&state.status==='Resolved');
    return `<div class="count">Total Ticket : ${visible?1:0}</div>`+(visible?button('sample-ticket',pair('Title','Visit for service.')+pair('Date',date)+pair('Status',state.status),'detail','ticket-card'):'<div class="card">No demo tickets in this tab.</div>');
  }
  const value = id => document.getElementById(id).value.trim();
  function message(text){const el=document.getElementById('message');if(el){el.textContent=text;el.className='message';}}
  document.addEventListener('click', async e => {
    const b=e.target.closest('[data-action]'); if(!b)return;
    const action=b.dataset.action;
    if(pending)return;
    pending=true;lastError='';
    try {
    if(['home','menu','attendance','tickets','detail','add'].includes(action)){render(action);return;}
    if(action==='login'){if(value('mobile-user')!=='8546951251'||value('mobile-password')!=='demo123'){message('Use the sample credentials shown below.');return;}render('otp');}
    else if(action==='show-password'){const el=document.getElementById('mobile-password');el.type=el.type==='password'?'text':'password';}
    else if(action==='verify'){if(value('mobile-otp')!=='123456'){message('Demo OTP is 123456.');return;}render('home');}
    else if(action==='capture-login'||action==='capture-logout'){if(action==='capture-logout'&&!state.login){message('Mark demo Login attendance first.');return;}state.capture=action;render('capture');}
    else if(action==='submit-selfie'){await sync(state.capture==='capture-login'?'attendance_login':'attendance_logout');state[state.capture==='capture-login'?'login':'logout']=true;render('attendance');}
    else if(action.startsWith('tab-')){state.tab=action.slice(4);render('tickets');}
    else if(action==='ticket-menu'){const menu=document.getElementById('ticket-actions');menu.hidden=!menu.hidden;}
    else if(action==='start'){if(state.started){message('This demo ticket has already started. Choose Update Ticket.');return;}render('start');}
    else if(action==='start-submit'){if(!value('start-remark')){message('Enter a start remark first.');return;}const remark=value('start-remark');await sync('ticket_start',{remark});state.startRemark=remark;state.started=true;render('detail');}
    else if(action==='update'){if(!state.started){message('Select Start Ticket and enter a remark first.');return;}render('update');}
    else if(action==='work-photo'){state.photo=true;document.getElementById('photo-result').textContent='Sample work photo added (synthetic placeholder).';}
    else if(action==='update-submit'){if(!value('ticket-review')||!value('ticket-description')){message('Enter Review and Description first.');return;}state.review=value('ticket-review');state.description=value('ticket-description');state.workType=value('ticket-work-type');state.pendingStatus=value('ticket-status');render('signature');}
    else if(action==='add-signature'){state.signed=true;const el=document.getElementById('signature-preview');el.textContent='Demo signature';el.classList.add('signed');}
    else if(action==='submit-ticket'){if(!state.signed){message('Add the sample signature first.');return;}await sync('ticket_update',{review:state.review,description:state.description,workType:state.workType,status:state.pendingStatus,photo:state.photo?'1':'0',signed:'1'});state.status=state.pendingStatus;render('detail');message(connected?'Saved to your private desktop demo session.':'Demo ticket updated. No live record was changed.');}
    else if(action==='new-submit'){message('Practice only: use the built-in “Visit for service.” ticket from My Tickets. No record was saved.');}
    else if(action==='help'){message('This module is covered in the desktop tour. Only Attendance and Ticket are interactive here.');}
    else if(action==='browse-help'){message('Login Browse is shown for visual reference. File selection is disabled in this demo.');}
    else if(action==='forgot-help'){message('No reset message is sent. Use demo123.');}
    } catch(error){lastError=error.message;message(lastError);} finally {pending=false;}
  });
  document.addEventListener('change',e=>{if(e.target.name==='customer-type'){document.getElementById('new-customer').innerHTML=e.target.value==='lead'?'<option>Select Lead</option><option>Ambar Patil</option>':'<option>Select Customer</option><option>Adinath Mhaske</option>';}});
  const initial = new URLSearchParams(location.search).get('screen');
  const open=()=>render(['login','home','attendance','tickets','detail','add'].includes(initial)?initial:'login');
  window.MIB_MOBILE_DEMO={get state(){return {...state};},get pending(){return pending;},get error(){return lastError;}};
  if(connected){
    document.querySelector('.demo-notice').textContent='ANDROID UI DEMO · Private demo session · No production connection';
    pending=true;screen.textContent='Loading your demo session…';
    sync().then(open).catch(error=>{lastError=error.message;screen.textContent=lastError;}).finally(()=>{pending=false;});
  }else open();
})();
