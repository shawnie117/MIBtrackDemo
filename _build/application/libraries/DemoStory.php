<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Private guided-story records. Never writes to seeds or trainee overlays. */
class DemoStory
{
    public static function state()
    {
        $s = isset($_SESSION['demo_story']) ? $_SESSION['demo_story'] : array();
        $t = isset($s['ticket']) ? $s['ticket'] : array();
        $a = isset($s['attendance']) ? $s['attendance'] : array();
        return array('ticket_id'=>isset($t['ticket_id'])?$t['ticket_id']:null,
            'login'=>!empty($a['emp_attd_login']), 'logout'=>!empty($a['emp_attd_logout']),
            'started'=>!empty($t['story_started']), 'startRemark'=>isset($t['story_remark'])?$t['story_remark']:'',
            'status'=>isset($t['ticket_status'])?$t['ticket_status']:'Open',
            'review'=>isset($t['story_review'])?$t['story_review']:'',
            'description'=>isset($t['story_description'])?$t['story_description']:'',
            'workType'=>isset($t['story_work_type'])?$t['story_work_type']:'Service',
            'photo'=>!empty($t['story_photo']), 'signed'=>!empty($t['story_signed']));
    }

    public static function action($action, $data)
    {
        require_once APPPATH.'libraries/MockSeed.php';
        if (!isset($_SESSION['demo_story'])) $_SESSION['demo_story'] = array();
        $s =& $_SESSION['demo_story'];
        if ($action === 'ticket_prepare') {
            $id = isset($s['ticket']['ticket_id']) ? $s['ticket']['ticket_id'] : MockSeed::nextId('tickets','ticket_id');
            $s['ticket'] = array('ticket_id'=>$id,'ticket_seq_id'=>'TOUR-'.$id,
                'ticket_title'=>'Visit for service.','customer_id'=>'6013','customer_name'=>'Adinath Mhaske',
                'customer_contact'=>'4152488895','customer_address'=>'Swastik niwas, khandagale vasti, Mumbai.',
                'clm_id'=>'','clm_name'=>'','ticket_status'=>'Open','ticket_type'=>'Ticket',
                'ticket_assign_to'=>'9005','ticket_assign_to_name'=>'Prajyot',
                'ticket_desc'=>'Provide the GPM service properly.','ticket_priority'=>'High',
                'ticket_date_n'=>date('d-M-Y'),'tkt_sdate_n'=>date('d-M-Y'),
                'ticket_time'=>'10:00 AM','ticket_added_by'=>'9001','ticket_added_byname'=>'Demo Admin',
                'user_id'=>'9001','tkt_reopened_date_n'=>'','ticketReviewList'=>array(),
                'ticket_detailList'=>array(),'subscriptionList'=>array(),'story_owned'=>true);
        } elseif ($action === 'attendance_prepare') {
            $id = isset($s['attendance']['emp_attd_id']) ? $s['attendance']['emp_attd_id'] : MockSeed::nextId('attendance','emp_attd_id');
            $s['attendance'] = array('emp_attd_id'=>$id,'emp_id'=>'5005','emp_name'=>'Prajyot',
                'emp_attd_login'=>'','emp_attd_logout'=>'','emp_attd_status'=>'Active',
                'empIn_address'=>'Demo office, Mumbai','empOut_address'=>'Demo office, Mumbai',
                'emp_attd_login_img'=>'','emp_attd_logout_img'=>'',
                'loglongt'=>'','loglatt'=>'','outlongt'=>'','outlatt'=>'','story_owned'=>true);
        } elseif ($action === 'attendance_login' || $action === 'attendance_logout') {
            if (empty($s['attendance'])) throw new InvalidArgumentException('Start F15 before recording demo attendance.');
            if ($action === 'attendance_logout' && empty($s['attendance']['emp_attd_login'])) throw new InvalidArgumentException('Mark Login attendance first.');
            $prefix = $action === 'attendance_login' ? 'login' : 'logout';
            // Repeat requests are idempotent. These are explicitly illustrative office-day times.
            $s['attendance']['emp_attd_'.$prefix] = date('Y-m-d').($prefix === 'login'?' 09:00:00':' 18:00:00');
            $s['attendance']['emp_attd_'.$prefix.'_img'] = base_url('assets/images/default_user.png');
            if ($prefix === 'logout') $s['attendance']['emp_attd_status']='Deactivated';
        } elseif ($action === 'ticket_start') {
            if (empty($s['ticket'])) throw new InvalidArgumentException('Start F16 or F17 first.');
            $remark = isset($data['remark']) ? trim((string)$data['remark']) : '';
            if ($remark === '' || strlen($remark)>500) throw new InvalidArgumentException('Enter a start remark of at most 500 characters.');
            if (empty($s['ticket']['story_started'])) {
                $s['ticket']['story_started']=true;
                $s['ticket']['story_remark']=$remark;
            }
        } elseif ($action === 'ticket_update') {
            if (empty($s['ticket']['story_started'])) throw new InvalidArgumentException('Start this ticket before updating it.');
            foreach (array('review','description') as $field) {
                if (empty($data[$field]) || !is_string($data[$field]) || strlen($data[$field])>1000) throw new InvalidArgumentException('Review and description are required (maximum 1000 characters).');
            }
            if (!in_array(isset($data['status'])?$data['status']:'',array('Open','Resolved'),true) ||
                !in_array(isset($data['workType'])?$data['workType']:'',array('Service','Repair','Both'),true) || empty($data['signed'])) throw new InvalidArgumentException('Choose a valid status, work type and sample signature.');
            $t =& $s['ticket'];
            $t['ticket_status']=$data['status'];
            $t['story_review']=$data['review'];$t['story_description']=$data['description'];
            $t['story_work_type']=$data['workType'];$t['story_signed']=true;$t['story_photo']=!empty($data['photo']);
            $t['tkt_resolved_by']=$data['status']==='Resolved'?'9005':'';
            $t['tkt_resolved_date_n']=$data['status']==='Resolved'?date('d-M-Y H:i'):'';
            $t['ticketReviewList']=array(array('trm_name'=>html_escape($data['review']),
                'trm_desc'=>html_escape($data['description']),'user_person_name'=>'Prajyot',
                'trm_sdate_n'=>date('d-M-Y H:i'),'trm_status'=>$data['status'],
                'trm_img_path'=>!empty($data['photo'])?base_url('assets/images/default_user.png'):'',
                'trm_sign_img_path'=>'','story_signature'=>true));
        } else throw new InvalidArgumentException('Unknown story action.');
        MockSeed::clearCache();
        return self::state();
    }
}
