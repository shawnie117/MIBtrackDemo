<?php
define('BASEPATH', __DIR__);
define('APPPATH', dirname(__DIR__).'/_build/application/');
function base_url($path='') { return 'http://127.0.0.1:8765/'.$path; }
function html_escape($s) { return htmlspecialchars($s,ENT_QUOTES,'UTF-8'); }
require APPPATH.'libraries/MockSeed.php';
require APPPATH.'libraries/DemoStory.php';
function check($ok,$message) { if (!$ok) throw new Exception($message); echo "PASS $message\n"; }
$_SESSION=array();
MockSeed::upsert('tickets','ticket_id',array('ticket_id'=>'99999','ticket_title'=>'Manual ticket','ticket_status'=>'Open'));
$before=MockSeed::table('tickets');
DemoStory::action('ticket_prepare',array());
$id=DemoStory::state()['ticket_id'];
check($id==='100000','tour uses a free ID after manual records');
try { DemoStory::action('ticket_update',array()); throw new Exception('accepted invalid update'); }
catch (InvalidArgumentException $e) { echo "PASS update requires started ticket\n"; }
DemoStory::action('ticket_start',array('remark'=>'Starting Work'));
$update=array('review'=>'Service done','description'=>'GPM completed','workType'=>'Service','status'=>'Resolved','signed'=>'1','photo'=>'1');
DemoStory::action('ticket_update',$update);DemoStory::action('ticket_update',$update);
$rows=MockSeed::table('tickets');
$owned=array_values(array_filter($rows,function($r)use($id){return $r['ticket_id']===$id;}));
check(count($owned)===1 && $owned[0]['ticket_status']==='Resolved','repeat save yields one resolved desktop record');
check(count($owned[0]['ticketReviewList'])===1,'repeat save does not duplicate review');
DemoStory::action('ticket_prepare',array());
check(DemoStory::state()['ticket_id']===$id && DemoStory::state()['status']==='Open','replay resets only its stable tour ticket');
check(count(MockSeed::table('tickets'))===count($before)+1,'replay does not duplicate tickets');
check($_SESSION['demo_overlay']['tickets']['upsert'][0]['ticket_title']==='Manual ticket','manual overlay preserved');
MockSeed::upsert('attendance','emp_attd_id',array('emp_attd_id'=>'80','emp_id'=>'5005','emp_attd_login'=>date('Y-m-d').' 08:00:00','emp_attd_logout'=>date('Y-m-d').' 17:00:00'));
$manualOverlay=$_SESSION['demo_overlay'];
DemoStory::action('attendance_prepare',array());
$reserved=$_SESSION['demo_story']['attendance']['emp_attd_id'];
check((int)MockSeed::nextId('attendance','emp_attd_id')>(int)$reserved,'unsaved attendance ID reserved');
try { DemoStory::action('attendance_logout',array()); throw new Exception('accepted logout first'); }
catch (InvalidArgumentException $e) { echo "PASS logout requires login\n"; }
DemoStory::action('attendance_login',array());DemoStory::action('attendance_logout',array());
$attendance=MockSeed::table('attendance');
check(count($attendance)===2 && count(array_filter($attendance,function($r){return !empty($r['story_owned'])&&!empty($r['emp_attd_logout']);}))===1,'desktop attendance retains manual event and saved tour event without duplicate seed');
check($_SESSION['demo_overlay']===$manualOverlay,'manual attendance and tickets unchanged');
$saved=$_SESSION;$_SESSION=array();MockSeed::clearCache();
check(DemoStory::state()['ticket_id']===null && count(MockSeed::table('attendance'))===1,'other session cannot see tour writes');
$_SESSION=$saved;MockSeed::clearCache();
check(DemoStory::state()['login'] && DemoStory::state()['logout'],'original session retains attendance');
