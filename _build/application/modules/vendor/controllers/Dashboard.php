<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
class Dashboard extends MY_Controller
{ // Main Controller

	public function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));

		$this->load->library('form_validation');

		// Load pagination library 
		$this->load->library('pagination');
		// Per page limit 
		$this->perPage = 10;

		if (!$this->isVendorLoggedIn()) {
			redirect(get_module() . "/login");
		}
		if ($this->isVendorLoggedIn()) {
			$vendor = $this->session->userdata('vendor');
			$this->_vendor_id = $vendor['user_id'];
			$this->_user_id = $vendor['user_id'];
			$this->_role_id = $vendor['user_role_id'];
			$this->_is_logged_in = $vendor['is_logged_in'];
			$this->_session_id = $vendor['session_id'];
			$this->_user_branch_id = $vendor['user_branch_id'];
			$this->_user_company_id = $vendor['user_company_id'];
			$this->_user_emp_id = $vendor['user_emp_id'];
			$this->_user_cust_id = $vendor['user_cust_id'];
			$this->_user_type = $vendor['user_type'];
			$this->_user_permission_name = $vendor['user_person_name'];
			$this->_user_mobile = $vendor['user_mob'];
		}

	}

	public function index()
	{
		$this->load->helper('common');
		$data['page_title'] = "Dashboard";
		
		$data['todays_followup_list'] = $this->get_todays_followup();
		$data['my_followup_list'] = $this->get_my_followup();
		$data['lead_approval_list'] = $this->get_lead_approval_list();
		$data['raised_complaint_list'] = $this->getComplaintAnalysisDetails();

		$data['amc_reminder'] = $this->getAmcReminder();
		$data['open_ticket_reminder'] = $this->getOpenTicketReminder();      
		$data['pending_services'] = $this->getServicePendingAnalysisDetails();
		$data['birthday_reminder_list'] = $this->getBirthdayReminder();

		$data['cheque_reminder_list'] = $this->getChequeReminderDetails();
		$data['balance_list'] = $this->getSaleBalanceDetails();
		
		$data['pending_cust_list'] = $this->getPendingCustomersDetails();
		
		$data['notification_list'] = $this->get_notification_list();
		$data['whatsappdeatils'] = $this->get_whatsapp_count();
		

		// print_r($data['pending_services']);
		// die;
		// echo "<pre/>";
		// print_r($data);
		// die;
		$branch_list = $this->getBranchMasterDetails();
		if (!empty($branch_list) && count($branch_list) > 1) {
			$data['branch_list'] = $branch_list;
		}
		//  echo "<pre/>"; print_r($_role_id);die;


		// ===== Subscription Expiry Popup Logic ===== // Added by Ankit on 12/02/2026



		$data['show_subscription_popup'] = false;
		$data['remaining_days'] = 0;
		$data['popup_message'] = "";

		if ($this->_role_id == SUPER_ADMIN_ROLE_ID) {

			// 24 hour popup control
			$last_popup_time = $this->session->userdata('subscription_popup_time');
			$current_time = time();
			$show_popup_allowed = true;

			if (!empty($last_popup_time)) {
				if (($current_time - $last_popup_time) < 86400) { // 24 hours
					$show_popup_allowed = false;
				}
			}

			$params = array(
				"one" => "1",
				"two" => "1",
				"three" => "1",
				"four" => $this->_user_company_id,
			);

			$com_details = $this->api->call_api('getCustomerMasterDetails', $params);

			if (!empty($com_details[0]['subscriptionList'][0])) {

				$subscription = $com_details[0]['subscriptionList'][0];

				// Using _n values to avoid time mismatch
				$start = DateTime::createFromFormat('d-M-Y', $subscription['cust_subs_startdate_n']);
				$end = DateTime::createFromFormat('d-M-Y', $subscription['cust_subs_enddate_n']);
				$today = new DateTime(date('d-M-Y'));

				if ($start && $end && $today <= $end && $show_popup_allowed) {

					$total_days = $start->diff($end)->days;
					$remaining_days = $today->diff($end)->days;

					if ($remaining_days > 0) {

						// TRIAL (7 days)
						if ($total_days <= 7 && $remaining_days <= 3) {

							$data['show_subscription_popup'] = true;
							$data['popup_message'] = "Your trial period is about to end in " . $remaining_days . " day(s) Please subscribe.";

							// Save popup time
							$this->session->set_userdata('subscription_popup_time', time());
						}

						// PAID
						elseif ($total_days > 7 && $remaining_days <= 5) {

							$data['show_subscription_popup'] = true;
							$data['remaining_days'] = $remaining_days;
							$data['popup_message'] = "Your subscription is about to end in " . $remaining_days . " day(s).";

							// Save popup time
							$this->session->set_userdata('subscription_popup_time', time());
						}
					}
				}
			}
		}
		$this->loadViews(get_module() . '/dashboard', $data);
	}
	public function set_branch_dashboard()
	{
		$vendor = $this->session->userdata('vendor');
		$role_id = $vendor['user_role_id'];
		if (in_array($role_id, explode(",", CHANGE_BRANCH_ACCESS))) {
			$branch_id = $this->input->post("p_branch");
			$vendor['user_branch_id'] = $branch_id;
			$this->session->set_userdata('vendor', $vendor);
			redirect(get_module() . "/dashboard");
		}

	}

	public function access_denied()
	{
		$data['page_title'] = "Access Denied";
		$this->loadViews(get_module() . '/dashboard/access_denied', $data);
	}
	public function my_profile()
	{
		// DEMO BUILD RIG: the maintained profile page lives under Admin.
		redirect(get_module() . '/admin/my_account');
	}

	/**
	 * Standalone, persistent shell for the guided demo.
	 *
	 * Both query parameters are whitelisted. Previously any value was passed
	 * straight through: an unknown tour silently fell back to the core steps
	 * client-side, and an unknown language was interpolated into the audio
	 * path, producing a folder that could never exist. Rejecting unknown
	 * values here means the player always receives something it can serve.
	 */
	public function tour()
	{
		$this->load->helper('url');

		$tours = array('full', 'short');

		$tour = (string) $this->input->get('tour', true);
		$data['tour_id']   = in_array($tour, $tours, TRUE) ? $tour : 'full';
		$lang = (string) $this->input->get('lang', true);
		$data['tour_lang'] = in_array($lang, array('mr', 'hi', 'en'), TRUE) ? $lang : 'mr';

		$this->load->view(get_module() . '/dashboard/tour', $data);
	}

	/** Demo-only management view that makes the full AMC book presentation-ready. */
	public function amc_portfolio()
	{
		require_once APPPATH . 'libraries/MockSeed.php';
		$data['page_title'] = 'AMC Portfolio';
		$data['contracts'] = MockSeed::table('amc_subscriptions');
		$data['plans'] = MockSeed::table('amc_services');
		$this->loadViews(get_module() . '/dashboard/amc_portfolio', $data);
	}

	/**
	 * Session-only writes used by the narrated tour. They use the same overlay
	 * as normal demo forms, never the production API or another user's session.
	 */
	public function story()
	{
		require_once APPPATH.'libraries/DemoStory.php';
		$this->output->set_content_type('application/json')->set_header('Cache-Control: no-store');
		if (empty($_SESSION['demo_story_csrf'])) $_SESSION['demo_story_csrf']=bin2hex(random_bytes(24));
		try {
			if (strtoupper($this->input->method()) === 'GET') $state=DemoStory::state();
			elseif (strtoupper($this->input->method()) === 'POST') {
				$token=(string)$this->input->post('token');
				if (!hash_equals($_SESSION['demo_story_csrf'],$token)) {
					$this->output->set_status_header(403)->set_output(json_encode(array('ok'=>false,'message'=>'Session token expired. Reload the tour.')));return;
				}
				$state=DemoStory::action((string)$this->input->post('action'),$this->input->post(NULL,true));
			} else { $this->output->set_status_header(405)->set_output(json_encode(array('ok'=>false)));return; }
			$this->output->set_output(json_encode(array('ok'=>true,'state'=>$state,'token'=>$_SESSION['demo_story_csrf'])));
		} catch (InvalidArgumentException $e) {
			$this->output->set_status_header(422)->set_output(json_encode(array('ok'=>false,'message'=>$e->getMessage())));
		}
	}

	public function story_ticket()
	{
		$id=isset($_SESSION['demo_story']['ticket']['ticket_id'])?$_SESSION['demo_story']['ticket']['ticket_id']:null;
		if (!$id) { $this->output->set_status_header(409)->set_output('Complete F17 first to view the same demo ticket.');return; }
		redirect('vendor/customers/view_ticket?id='.rawurlencode(base64_encode($id)));
	}

	public function tour_action()
	{
		$this->output->set_content_type('application/json');
		if (strtoupper($this->input->method()) !== 'POST') {
			$this->output->set_status_header(405)->set_output(json_encode(array('ok'=>false,'message'=>'POST required')));
			return;
		}
		require_once APPPATH . 'libraries/MockSeed.php';
		$action = $this->input->post('action', true);
		if ($action === 'reset') {
			MockSeed::reset();
			$this->output->set_output(json_encode(array('ok'=>true,'message'=>'Private demo session reset')));
			return;
		}

		$this->output->set_status_header(400)->set_output(json_encode(array('ok'=>false,'message'=>'Unknown tour action')));
	}



	public function change_password()
	{
		// DEMO BUILD RIG: use the maintained vendor password page.
		redirect(get_module() . '/admin/change_my_password');
	}

	public function get_notification_list()
	{
		$cacheKey = 'ci_dashboard:notification_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$date = strtoupper(date("d-M-Y"));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_role_id,
			"eight" => $date,
		);
		// echo "<pre/>"; print_r($params);die
		$response = $this->api->call_v_api('getNotificationDetails', $params);

		// Cache the rows, not the API envelope. This used to save $response
		// but return $response['jsArray'], so the cache-hit path handed the
		// view {jsArray, total_count} instead of a row list. dashboard.php
		// then iterated total_count as if it were a row and died with
		// "Cannot access offset of type string on string". Storing and
		// returning the same shape keeps hit and miss paths identical.
		$list = !empty($response['jsArray']) ? $response['jsArray'] : array();
		$this->cache->save($cacheKey, $list, 3600);
		return $list;

	}


	public function get_whatsapp_count()
	{
		$date = strtoupper(date("d-M-Y"));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $this->_user_mobile
		);
		$response = $this->api->call_v_api('getWhatsAppCount', $params);
		//echo "<pre/>"; print_r($response);die;
		return $response;

	}


	// FAQ 
	public function faq()
	{

		$data['page_title'] = "FAQ";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => "Active",
			"five" => "Report"
		);
		$data['faq_module_list'] = $this->api->call_api('getFaqModuleUserDetails', $params);
		$this->loadViews('dashboard/faq', html_escape($data));
	}
	public function logout()
	{

		$hostname = $this->get_client_hostname();
		$ip = $this->get_client_ip();
		$mac = $this->get_client_mac();

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $mac,
			"five" => $hostname,
			"six" => $ip,
			"eight" => "Logout"
		);

		$result = $this->api->call_v_api('setLoginSessionDetails', $params);

		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout successfully !!');
		redirect(get_module() . "/login");
	}

	/**********Dashbard Functions**********/
	public function get_todays_followup()
	{
		$date = strtoupper(date("d-M-Y"));

		$cacheKey = 'ci_dashboard:todays_followup_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"seven" => $date,
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null,
		);
		$response = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		
		$this->cache->save($cacheKey, $response, 300);

		return $response;
	}

	public function get_my_followup()
	{
		$date = strtoupper(date("d-M-Y"));

		$cacheKey = 'ci_dashboard:my_followup_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);

        if ($cached !== FALSE) {
            return $cached;
        }
		
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_id,
			"seven" => $date,
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null,
		);

		$response = $this->api->call_v_api('getFollowupAnalysisDetails', $params);

		$this->cache->save($cacheKey, $response, 300);

		return $response;
	}

	public function get_lead_approval_list()
	{

		$cacheKey = 'ci_dashboard:lead_approval_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "FS",
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null,
		);
		$response = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);

		$this->cache->save($cacheKey, $response, 300);

		return $response;
	}

	public function getChequeReminderDetails()
	{
		$cacheKey = 'ci_dashboard:cheque_reminder_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }


		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,

		);
		$response = $this->api->call_v_api('getChequeReminderDetails', $params);
		$this->cache->save($cacheKey, $response, 300);
		return $response;
	}
	public function getPendingCustomersDetails()
	{
		// $cacheKey = 'ci_dashboard:pending_cust_list:'
        //     . $this->_user_company_id . ":"
        //     . $this->_user_branch_id . ":"
        //     . $this->_user_id;

        // $cached = $this->cache->get($cacheKey);
        // if ($cached !== FALSE) {
        //     return $cached;
        // }

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Pending"
		);
		$response = $this->api->call_v_api('getCustomerMasterReportDetails', $params);

		// $this->cache->save($cacheKey, $response, 300);

		return $response;
	}
	public function getComplaintAnalysisDetails()
	{
		$date = strtoupper(date("d-M-Y"));

		$cacheKey = 'ci_dashboard:raised_complaint_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			/* "four"=>$this->_user_id, */
			"five" => "Open",
			"eight" => $date,
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null,
		);
		$response = $this->api->call_v_api('getComplaintAnalysisDetails', $params);

		$this->cache->save($cacheKey, $response, 300);

		return $response;
	}

	public function getMonthSchedulerDataDetails()
	{

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Complaint",
			"five" => $this->_user_emp_id
		);
		$response = $this->api->call_v_api('getMonthSchedulerDataDetails', $params);
		return $response;
	}

	public function getSaleBalanceDetails()
	{

		$cacheKey = 'ci_dashboard:balance_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"nine" => "B",
			"eleven" => "T",
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null,
		);
		$response = $this->api->call_v_api('getSaleBalanceDetails', $params);
		$this->cache->save($cacheKey, $response, 600);
		return $response;
	}

	public function getAmcReminder()
	{
		$cacheKey = 'ci_dashboard:amc_reminder:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one" => $this->_user_company_id,
			"two" => $this->_user_branch_id,
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null
		);
		$response = $this->api->call_v_api('getAMCReminderDetails', $params);
		$this->cache->save($cacheKey, $response, 1800);
		return $response;
	}



// public function getOpenTicketReminder()
// {
//     $ticket_assign_to = "";

//     if (
//         $this->_role_id != SUPER_ADMIN_ROLE_ID
//         && $this->_role_id != ADMIN_ROLE_ID
//     ) {
//         $ticket_assign_to = $this->_user_id;
//     }

//     $params = array(
//         "one" => $this->_user_id,
//         "two" => $this->_user_branch_id,
//         "three" => $this->_user_company_id,
//         "five" => "Open",
//         "eight" => $ticket_assign_to,
//         "nine" => "Ticket,Servicing",
//         "limit" => 10,
//         "offset" => 1,
//         "total_count" => Null
//     );

//     $response = $this->api->call_v_api(
//         'getTicketMasterReportDetails',
//         $params
//     );

   

//     return $response;
// }

public function getOpenTicketReminder()
{
    $cacheKey = 'ci_dashboard:open_ticket_reminder:'
        . $this->_user_company_id . ':'
        . $this->_user_branch_id . ':'
        . $this->_user_id;

    // Check Redis Cache
    $cached = $this->cache->get($cacheKey);
    if ($cached !== FALSE) {
        return $cached;
    }

    $ticket_assign_to = "";

    // Employee -> own tickets only
    if (
        $this->_role_id != SUPER_ADMIN_ROLE_ID
        && $this->_role_id != ADMIN_ROLE_ID
    ) {
        $ticket_assign_to = $this->_user_id;
    }

    $params = array(
        "one" => $this->_user_id,
        "two" => $this->_user_branch_id,
        "three" => $this->_user_company_id,
        "five" => "Open",
        "eight" => $ticket_assign_to,
        "nine" => "Ticket,Servicing",
        "limit" => 10,
        "offset" => 1,
        "total_count" => Null
    );

    $response = $this->api->call_v_api(
        'getTicketMasterReportDetails',
        $params
    );

    // Save in Redis for 5 minutes
    $this->cache->save($cacheKey, $response, 300);

    return $response;
	
}

	public function getServicePendingAnalysisDetails()
	{
		// Dashboard should show *all pending services* with default filters.
		// So no POST values are used here.

		$cacheKey = 'ci_dashboard:pending_services:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }


		$searchStr_name = null;
		$pdate = null;
		$sdate = strtoupper(date("d-M-Y")); // same as other modules
		$month_year = null;
		$one_year = null;
		$cust_serv_type = null;
		$pending_upcoming = "pending_services";   // or whatever value your API expects

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $searchStr_name,
			"six" => $pdate,
			"seven" => $sdate,
			"eight" => $month_year,
			"nine" => $one_year,
			"ten" => $cust_serv_type,
			"eleven" => $pending_upcoming,
			"limit" => 10,      // ci_dashboard: no pagination
			"offset" => 1,
			"total_count" => null
		);

		$response = $this->api->call_v_api('getServicePendingAnalysisDetails', $params);
		$this->cache->save($cacheKey, $response, 300);
		return $response;
	}


	public function getBirthdayReminder01()
	{
		

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Active",
			"six" => "",
			"seven" => "",
			"eight" => "",
			"ten" => date('d-M-Y'),
			"limit" => 10,
			"offset" => "1",
			"total_count" => Null
		);

		$response = $this->api->call_v_api('getEmployeeReportDetails', $params);

		$list = array();

		if (!empty($response['jsArray'])) {

			foreach ($response['jsArray'] as $emp) {

				if (!empty($emp['emp_dob'])) {

					$dob_day_month = date('m-d', strtotime($emp['emp_dob']));
					$today = date('m-d');
					$tomorrow = date('m-d', strtotime('+1 day'));

					if ($dob_day_month == $today || $dob_day_month == $tomorrow) {

						$emp['birthday_type'] =
							($dob_day_month == $today)
							? "Today"
							: "Tomorrow";

						$list[] = $emp;
					}
				}
			}
		}

		$result = array(
			'jsArray' => $list,
			'total_count' => count($list)
		);

		return $result;
	}

	public function getBirthdayReminder()
	{
		$cacheKey = 'ci_dashboard:birthday_reminder_list:'
            . $this->_user_company_id . ":"
            . $this->_user_branch_id . ":"
            . $this->_user_id;

        $cached = $this->cache->get($cacheKey);
        if ($cached !== FALSE) {
            return $cached;
        }

		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"six"  => date('d-M-Y'),
			"limit" => 10,      // ci_dashboard: no pagination
			"offset" => 1,
			"total_count" => null
		);

		$response = $this->api->call_v_api(
			'getBirthdayReminderReport',
			$params
		);

		$list = array();

		if (!empty($response['jsArray'])) {

			foreach ($response['jsArray'] as $row) {

				$list[] = array(
					'ref_id'         => $row['ref_id'],
					'name'           => $row['name'],
					'contact'        => $row['contact'],
					'dob'            => $row['dob'],
					'birthday_type'  => $row['birthday_type'],
					'person_type'    => $row['person_type']
				);
			}
		}

		$result = array(
			'jsArray'     => $list,
			'total_count' => count($list)
		);

		$this->cache->save($cacheKey, $result, 3600);

		return $result;
	}

}
