<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class Leads extends MY_Controller
{ // Main Controller

	public function __construct()
	{
		parent::__construct();
		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'dummy'));
		$this->load->library('form_validation');
		// Load pagination library 
		$this->load->library('pagination');
		$this->perPage = MASTERS_PAGE_LIMIT;
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
		}
	}


	private function clearDashboardCompanyCache($companyId)
	{
		$prefixes = [
			'birthday_reminder_list'
		];

		foreach ($prefixes as $prefix) {

			//$pattern = 'ci_dashboard:' . $prefix . ':' . $companyId . ':*';

			//$deleted = $this->cache->redis->deleteByPattern($pattern);
			try {
				$pattern = 'ci_dashboard:' . $prefix . ':' . $companyId . ':*';
				$this->cache->redis->deleteByPattern($pattern);

			} catch (Exception $e) {

				log_message(
					'error',
					'Redis cache clear failed: ' . $e->getMessage()
				);

				// Don't stop execution
			}
		}
	}

	public function team_summary()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Summary";

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_company_id,
			"three" => $this->_user_branch_id
		);

		$result = $this->api->call_v_api('getTeamLeads', $params);
		$data['team_leads'] = $result;
		// print_r($data['team_leads']);
		// exit;

		$this->loadViews(get_module() . '/leads/team_summary', $data);
	}

	// Lead  Master 
	public function lead_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Lead Report";
		$data['priority_list'] = array("High", "Medium", "Low");
		$data['status_list'] = array("Active", "Deactivated", "Approval Requested", "Approved", "Rejected");
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
		$data['product_list'] = $this->getProductMasterDetails();
		$data['reference_list'] = $this->getReferencedBy();
		$data['state_list'] = $this->getStateDetails();
		$data['employee_list'] = $this->getEmployeeDetails();
		

		// $data['lead_month_year'] = $this->input->get('lead_month_year');
    	// $status      = $this->input->get('status');

		// // changes done by anjali dhane 26/06/26

		// $data['selected_emp'] = "";

		// $data['selected_status'] = "";

		// if($this->input->get('emp'))
		// {
		// 	$data['selected_emp'] = base64_decode($this->input->get('emp'));
		// }

		// // if($this->input->get('status'))
		// // {
		// // 	$data['selected_status'] = $this->input->get('status');
		// // }
		$data['selected_emp'] = "";
		$data['selected_transfer_to'] = "";
		$data['selected_status'] = "";
		$data['lead_month_year'] = "";
		// Added by Anjali 29/06/26
		$data['summary_employee_name'] = "";

			// Added by Anjali 29/06/26
			if ($this->input->get('emp')) {
				$data['selected_emp'] = base64_decode($this->input->get('emp'));
			}

			if ($this->input->get('transfer_to')) {
				$data['selected_transfer_to'] = base64_decode($this->input->get('transfer_to'));
			}

			if ($this->input->get('status')) {
				$data['selected_status'] = $this->input->get('status');
			}

			if ($this->input->get('lead_month_year')) {
				$data['lead_month_year'] = $this->input->get('lead_month_year');
			}

			// Added by Anjali 29/06/26
			if ($this->input->get('summary_employee_name')) {
				$data['summary_employee_name'] = trim($this->input->get('summary_employee_name'));
			}


		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);

		$result = $this->api->call_v_api('getDirectReporting', $params);

		$data['roleId'] = $this->_role_id;
		$data['direct_employeee'] = $result;

		//    echo "<pre/>"; print_r($data['roleId']);die;

		//    print_r($data['roleId']);
		//    exit;

		$this->loadViews(get_module() . '/leads/list_lead', $data);
	}

	public function add_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Lead";
		$data['action'] = "Add";

		$data['priority_list'] = array("High", "Medium", "Low");
		$data['status_list'] = array("Active", "Deactivated", "FS");
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
		$data['product_list'] = $this->getProductMasterDetails();
		$data['reference_list'] = $this->getReferencedBy();
		$data['state_list'] = $this->getStateDetails();
		$data['employee_list'] = $this->getEmployeeDetails();

		$this->form_validation->set_rules('lead_name', 'Lead Name', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('lead_desc', 'Enquiry Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('lead_contact_person', 'Contact Person', 'trim|max_length[200]');
		$this->form_validation->set_rules('website', 'Website', 'trim|max_length[100]');
		$this->form_validation->set_rules('pan_no', 'PAN No.', 'trim|max_length[10]');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('pan_no', 'Company Name', 'trim|max_length[10]');
		$this->form_validation->set_rules('lead_contact', 'Mobile No.', 'trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('lead_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');

		$this->form_validation->set_rules('lead_contact_email', 'Email Id.', 'trim|max_length[100]|valid_email');

		$this->form_validation->set_rules('lead_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');
		$this->form_validation->set_rules('lead_landline', 'Landline No.', 'trim|max_length[15]|numeric');
		$this->form_validation->set_rules('lead_addrs', 'Address', 'trim|max_length[300]');
		$this->form_validation->set_rules('lead_refby_address', ' Reference Address', 'trim|max_length[300]');
		$this->form_validation->set_rules('lead_pincode', 'Pincode', 'trim|max_length[6]|min_length[6]|numeric');
		$this->form_validation->set_rules('lead_refby_name', 'Reference Name', 'trim|max_length[200]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/leads/add_edit_lead', $data);
		} else {
			$post_data = $this->input->post(null, true);

			//echo "<pre/>"; print_r($post_data);die;
			$clm_img = null; // A business-card upload is optional.

			if (!empty($_FILES['clm_img']['name'])) {
				$ext = pathinfo($_FILES['clm_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['clm_img']['tmp_name'];
				$clm_img = "LEAD_BUSINESS_CARD_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $clm_img,
					"five" => base64_encode($img_file_content),
					"six" => "Lead"
				);
				// echo "<pre/>";print_r($upload_params);die;
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$clm_ots_id = !empty($post_data['clm_ots_id']) ? $post_data['clm_ots_id'] : Null;
			$clm_amcid = !empty($post_data['clm_amcid']) ? $post_data['clm_amcid'] : Null;
			$clm_productid = !empty($post_data['clm_productid']) ? $post_data['clm_productid'] : Null;

			$lead_priority = !empty($post_data['lead_priority']) ? $post_data['lead_priority'] : Null;
			$lead_contact_person = !empty($post_data['lead_contact_person']) ? $post_data['lead_contact_person'] : Null;
			$pan_no = !empty($post_data['pan_no']) ? $post_data['pan_no'] : Null;
			$lead_productid = !empty($post_data['lead_productid']) ? $post_data['lead_productid'] : Null;
			$lead_desc = !empty($post_data['lead_desc']) ? $post_data['lead_desc'] : Null;
			$website = !empty($post_data['website']) ? $post_data['website'] : Null;
			$company_name = !empty($post_data['company_name']) ? $post_data['company_name'] : Null;
			$lead_contact_email = !empty($post_data['lead_contact_email']) ? $post_data['lead_contact_email'] : Null;
			$lead_contact = !empty($post_data['lead_contact']) ? $post_data['lead_contact'] : Null;
			$lead_landline = !empty($post_data['lead_landline']) ? $post_data['lead_landline'] : Null;
			$lead_addrs = !empty($post_data['lead_addrs']) ? $post_data['lead_addrs'] : Null;
			$lead_arealoc = !empty($post_data['lead_arealoc']) ? $post_data['lead_arealoc'] : Null;
			$lead_pincode = !empty($post_data['lead_pincode']) ? $post_data['lead_pincode'] : Null;
			$lead_stateid = !empty($post_data['lead_stateid']) ? $post_data['lead_stateid'] : Null;
			$lead_distid = !empty($post_data['lead_distid']) ? $post_data['lead_distid'] : Null;
			$lead_cityid = !empty($post_data['lead_cityid']) ? $post_data['lead_cityid'] : Null;

			// Anjali Reference 28-05-2025
			$lead_refby = !empty($post_data['lead_refby']) ? $post_data['lead_refby'] : Null;
			$lead_refby_name = !empty($post_data['lead_refby_name']) ? $post_data['lead_refby_name'] : Null;
			$lead_refby_contact = !empty($post_data['lead_refby_contact']) ? $post_data['lead_refby_contact'] : Null;
			$lead_refby_email = !empty($post_data['lead_refby_email']) ? $post_data['lead_refby_email'] : Null;
			$lead_refby_address = !empty($post_data['lead_refby_address']) ? $post_data['lead_refby_address'] : Null;

			// Anjali End Reference 28-05-2025

			// Anjali Alternate Contact 28-05-2025
			$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;
			$cust_id = !empty($post_data['ref_id']) ? $post_data['ref_id'] : Null;
			$lead_id = !empty($post_data['lead_id']) ? $post_data['lead_id'] : Null;

			$lead_altcontactperson = "";
			$lead_altcontact = "";
			$lead_altemail = "";

			if (!empty($alternate_contact_details)) {
				foreach ($alternate_contact_details as $contact) {
					$contact_person = isset($contact['lead_altcontactperson']) ? trim($contact['lead_altcontactperson']) : "";
					$contact_no = isset($contact['lead_altcontact']) ? trim($contact['lead_altcontact']) : "";
					$contact_email = isset($contact['lead_altemail']) ? trim($contact['lead_altemail']) : "";

					if ($contact_person == "" && $contact_no == "" && $contact_email == "") {
						continue;
					}

					$lead_altcontactperson = $lead_altcontactperson . $contact_person . ",";
					$lead_altcontact = $lead_altcontact . $contact_no . ",";
					$lead_altemail = $lead_altemail . $contact_email . ",";
				}
			}
			$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
			$lead_altcontact = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
			$lead_altemail = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;


			// Anjali End Alternate Contact 28-05-2025


			$lead_dob = !empty($post_data['lead_dob']) ? $post_data['lead_dob'] : Null;

			$lead_dob = !empty($lead_dob)
				? date('d-m-Y', strtotime($lead_dob))
				: NULL;



			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $post_data['lead_name'],
				"five" => $lead_contact,
				"six" => $lead_addrs,
				"seven" => $clm_amcid,
				"eight" => $clm_ots_id,
				"nine" => $clm_productid,
				"ten" => NULL,
				"eleven" => $lead_stateid,
				"twelve" => $lead_distid,
				"thirteen" => $lead_arealoc,
				"fourteen" => $lead_cityid,
				"fifteen" => $lead_pincode,
				"sixteen" => $lead_desc,
				"seventeen" => NULL,
				"eighteen" => NULL,
				"nineteen" => $lead_refby,
				"twenty" => $lead_refby_name,
				"twentyone" => $lead_refby_contact,
				"twentytwo" => $lead_refby_address,
				"twentythree" => $lead_refby_email,
				"twentyfour" => NULL,
				"twentyfive" => NULL,
				"twentysix" => $lead_landline,
				"twentyseven" => $lead_contact_email,
				"twentyeight" => $lead_contact_person,
				"twentynine" => $lead_altcontactperson,
				"thirty" => $lead_altcontact,
				"thirtyone" => $lead_altemail,
				"thirtytwo" => $lead_priority,
				"thirtythree" => $website,
				"thirtyfour" => $pan_no,
				"thirtyfive" => $company_name,
				"thirtysix" => $lead_dob,
				"thirtyseven" => $cust_id,
				"thirtyeight" => $lead_id,
				"thirtynine" => $clm_img,
			);

			// echo "<pre/>";print_r($params);die;
			$response = $this->api->call_v_api('setCustomerLeadMasterDetails', $params);
			//add by ritika
			if (
				isset($response[0]['message']) &&
				$response[0]['message'] == 'MOBILE_EXISTS'
			) {

				$this->session->set_flashdata(
					'mobile_error',
					'Mobile Number Already Exists'
				);

				// redirect(get_module() . '/leads/add_lead');
				// return;

				$data['mobile_error'] = 'Mobile Number Already Exists';

				$this->loadViews(
					get_module() . '/leads/add_edit_lead',
					$data
				);
				return;
			}
			//

			$id = $response[0]['id'];
			$message = isset($response[0]['message']) ? $response[0]['message'] : '';

			if ($response[0]['status'] == "Success") {
				if ($message == "LEAD_CREATED") {
					$this->session->set_flashdata('success', 'New Lead Added Successfully');
				} elseif ($message == "LEAD_REACTIVATED") {
					$this->session->set_flashdata('success', 'Lead Reactivated Successfully');
				} elseif ($message == "LEAD_ALREADY_EXISTS") {
					$this->session->set_flashdata('error', 'Lead Already Exists');
				} else {
					$this->session->set_flashdata('success', 'Lead Processed Successfully');
				}
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/lead_report');
			}
		}
	}

	public function edit_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Update Lead Details";
		$data['action'] = "Edit";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);

		$details = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['details'] = $details[0];

		$data['priority_list'] = array("High", "Medium", "Low");
		$data['status_list'] = array("Active", "Deactivated", "FS");
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
		$data['product_list'] = $this->getProductMasterDetails();
		$data['reference_list'] = $this->getReferencedBy();
		$data['state_list'] = $this->getStateDetails();
		$data['employee_list'] = $this->getEmployeeDetails();


		$clm_stateid = $details[0]['clm_stateid'];
		$clm_distid = $details[0]['clm_distid'];
		$clm_cityid = $details[0]['clm_cityid'];
		$data['dist_list'] = $this->getDistrictStateIdDetails($clm_stateid, "Report");
		$city_list = $this->getCityDistrictIdDetails($clm_stateid, $clm_distid, "Report");
		$data['city_list'] = $city_list['jsArray'];
		$data['area_list'] = $this->getAreaCityIdDetails($clm_stateid, $clm_distid, $clm_cityid);

		$this->form_validation->set_rules('lead_name', 'Lead Name', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('lead_desc', 'Enquiry Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('lead_contact_person', 'Contact Person', 'trim|max_length[200]');
		$this->form_validation->set_rules('website', 'Website', 'trim|max_length[100]');
		$this->form_validation->set_rules('pan_no', 'PAN No.', 'trim|max_length[10]');
		$this->form_validation->set_rules('company_name', 'Company Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('pan_no', 'Company Name', 'trim|max_length[10]');
		$this->form_validation->set_rules('lead_contact', 'Mobile No.', 'trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('lead_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');

		$this->form_validation->set_rules('lead_contact_email', 'Email Id.', 'trim|max_length[100]|valid_email');

		$this->form_validation->set_rules('lead_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');
		$this->form_validation->set_rules('lead_landline', 'Landline No.', 'trim|max_length[15]|numeric');
		$this->form_validation->set_rules('lead_addrs', 'Address', 'trim|max_length[300]');
		$this->form_validation->set_rules('lead_refby_address', ' Reference Address', 'trim|max_length[300]');
		$this->form_validation->set_rules('lead_pincode', 'Pincode', 'trim|max_length[6]|min_length[6]|numeric');
		$this->form_validation->set_rules('lead_refby_name', 'Reference Name', 'trim|max_length[200]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/leads/add_edit_lead', $data);
		} else {

			$post_data = $this->input->post(null, true);
			//echo "<pre/>"; print_r($post_data);die;

			$clm_img = null;

			if (!empty($_FILES['clm_img']['name'])) {

				// NEW IMAGE SELECTED
				// echo "<pre/>";print_r("NEW IMAGE SELECTED called");die;


				$ext = pathinfo($_FILES['clm_img']['name'], PATHINFO_EXTENSION);

				$imageFile = $_FILES['clm_img']['tmp_name'];

				$clm_img = "LEAD_BUSINESS_CARD_" . date("YmdHis") . "." . $ext;

				$img_file_content = file_get_contents($imageFile);

				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $clm_img,
					"five" => base64_encode($img_file_content),
					"six" => "Lead"
				);

				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			} else {

				// NO NEW IMAGE
				// RE-UPLOAD EXISTING IMAGE FROM URL

				if (!empty($details[0]['clm_img'])) {
					// echo "<pre/>";print_r("RE-UPLOAD EXISTING IMAGE FROM URL called");die;


					$existing_image_url = $details[0]['clm_img'];

					// remove accidental quotes if present
					$existing_image_url = trim($existing_image_url, '"');

					// fetch image content from URL
					$img_file_content = @file_get_contents($existing_image_url);

					if ($img_file_content !== false) {

						$ext = pathinfo(parse_url($existing_image_url, PHP_URL_PATH), PATHINFO_EXTENSION);

						$clm_img = "LEAD_BUSINESS_CARD_" . date("YmdHis") . "." . $ext;

						$upload_params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $clm_img,
							"five" => base64_encode($img_file_content),
							"six" => "Lead"
						);

						$response = $this->api->call_v_api('uploadBitmap', $upload_params);
					} else {

						// echo "<pre/>";print_r("Fallback called");die;
						// fallback
						$clm_img = basename(parse_url($existing_image_url, PHP_URL_PATH));
					}
				}
			}

			$clm_ots_id = !empty($post_data['clm_ots_id']) ? $post_data['clm_ots_id'] : Null;
			$clm_amcid = !empty($post_data['clm_amcid']) ? $post_data['clm_amcid'] : Null;
			$clm_productid = !empty($post_data['clm_productid']) ? $post_data['clm_productid'] : Null;

			$lead_priority = !empty($post_data['lead_priority']) ? $post_data['lead_priority'] : Null;
			$lead_contact_person = !empty($post_data['lead_contact_person']) ? $post_data['lead_contact_person'] : Null;
			$pan_no = !empty($post_data['pan_no']) ? $post_data['pan_no'] : Null;
			$lead_productid = !empty($post_data['lead_productid']) ? $post_data['lead_productid'] : Null;
			$lead_desc = !empty($post_data['lead_desc']) ? $post_data['lead_desc'] : Null;
			$website = !empty($post_data['website']) ? $post_data['website'] : Null;
			$company_name = !empty($post_data['company_name']) ? $post_data['company_name'] : Null;
			$lead_contact_email = !empty($post_data['lead_contact_email']) ? $post_data['lead_contact_email'] : Null;
			$lead_contact = !empty($post_data['lead_contact']) ? $post_data['lead_contact'] : Null;
			$lead_landline = !empty($post_data['lead_landline']) ? $post_data['lead_landline'] : Null;
			$lead_addrs = !empty($post_data['lead_addrs']) ? $post_data['lead_addrs'] : Null;
			$lead_arealoc = !empty($post_data['lead_arealoc']) ? $post_data['lead_arealoc'] : Null;
			$lead_pincode = !empty($post_data['lead_pincode']) ? $post_data['lead_pincode'] : Null;
			$lead_stateid = !empty($post_data['lead_stateid']) ? $post_data['lead_stateid'] : Null;
			$lead_distid = !empty($post_data['lead_distid']) ? $post_data['lead_distid'] : Null;
			$lead_cityid = !empty($post_data['lead_cityid']) ? $post_data['lead_cityid'] : Null;

			// Anjali Reference 28-05-2025
			$lead_refby = !empty($post_data['lead_refby']) ? $post_data['lead_refby'] : Null;
			$lead_refby_name = !empty($post_data['lead_refby_name']) ? $post_data['lead_refby_name'] : Null;
			$lead_refby_contact = !empty($post_data['lead_refby_contact']) ? $post_data['lead_refby_contact'] : Null;
			$lead_refby_email = !empty($post_data['lead_refby_email']) ? $post_data['lead_refby_email'] : Null;
			$lead_refby_address = !empty($post_data['lead_refby_address']) ? $post_data['lead_refby_address'] : Null;
			// Anjali End Reference 28-05-2025

			// Anjali Alternate Contact 28-05-2025
			$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;

			$lead_altcontactperson = "";
			$lead_altcontact = "";
			$lead_altemail = "";

			if (!empty($alternate_contact_details)) {
				foreach ($alternate_contact_details as $contact) {
					$contact_person = isset($contact['lead_altcontactperson']) ? trim($contact['lead_altcontactperson']) : "";
					$contact_no = isset($contact['lead_altcontact']) ? trim($contact['lead_altcontact']) : "";
					$contact_email = isset($contact['lead_altemail']) ? trim($contact['lead_altemail']) : "";

					if ($contact_person == "" && $contact_no == "" && $contact_email == "") {
						continue;
					}

					$lead_altcontactperson = $lead_altcontactperson . $contact_person . ",";
					$lead_altcontact = $lead_altcontact . $contact_no . ",";
					$lead_altemail = $lead_altemail . $contact_email . ",";
				}
			}
			$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
			$lead_altcontact = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
			$lead_altemail = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;
			// Anjali End Alternate Contact 28-05-2025


			$lead_dob = !empty($post_data['lead_dob']) ? $post_data['lead_dob'] : Null;
			$lead_dob = !empty($lead_dob)
				? date('d-m-Y', strtotime($lead_dob))
				: NULL;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $post_data['id'],
				"five" => $post_data['lead_name'],
				"six" => $lead_contact,
				"seven" => $lead_addrs,
				"eight" => $clm_ots_id,
				"nine" => $clm_amcid,
				"ten" => $clm_productid,
				"eleven" => NULL,
				"twelve" => $lead_stateid,
				"thirteen" => $lead_distid,
				"fourteen" => $lead_arealoc,
				"fifteen" => $lead_cityid,
				"sixteen" => $lead_pincode,
				"seventeen" => $lead_desc,
				"eighteen" => NULL,
				"nineteen" => NULL,
				"twenty" => $lead_refby,
				"twentyone" => $lead_refby_name,
				"twentytwo" => $lead_refby_contact,
				"twentythree" => $lead_refby_address,
				"twentyfour" => $lead_refby_email,
				"twentyfive" => NULL,
				"twentysix" => NULL,
				"twentyseven" => $lead_landline,
				"twentyeight" => $lead_contact_email,
				"twentynine" => $lead_contact_person,
				"thirty" => $lead_altcontactperson,
				"thirtyone" => $lead_altcontact,
				"thirtytwo" => $lead_altemail,
				"thirtythree" => $lead_priority,
				"thirtyfour" => $website,
				"thirtyfive" => $pan_no,
				"thirtysix" => $company_name,
				"thirtyseven" => $lead_dob,
				"thirtyeight" => $clm_img,
			);
			$response = $this->api->call_v_api('setModifyCustomerLeadMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'Lead Updated successfully !!');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/lead_report');
			}
		}
	}

	// public function view_lead()
	// {
	// 	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
	// 		redirect(get_module() . '/dashboard/access_denied');
	// 	}
	// 	$data['page_title']  = "Lead Master Report";
	// 	$id  = $this->input->get("id");
	// 	if (empty($id)) {
	// 		$this->session->set_flashdata('error', 'Lead Details not found');
	// 		redirect(get_module() . '/leads/lead_report');
	// 	}
	// 	$id = base64_decode($id);
	// 	if (!is_numeric($id)) {
	// 		$this->session->set_flashdata('error', 'Lead Details not found');
	// 		redirect(get_module() . '/leads/lead_report');
	// 	}

	// 	$params = array(
	// 		"one" => $this->_user_id,
	// 		"two" => $this->_user_branch_id,
	// 		"three" => $this->_user_company_id,
	// 		"four" => $id
	// 	);
	// 	$details 		  = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);
	// 	//echo "<pre/>"; print_r($details);die;
	// 	if (empty($details)) {
	// 		$this->session->set_flashdata('error', 'Lead Details not found');
	// 		redirect(get_module() . '/leads/lead_report');
	// 	}
	// 	$data['details']  = $details[0];
	// 	$this->loadViews(get_module() . '/leads/view_lead', $data);
	// }

	public function view_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$data['page_title'] = "Lead Master Report";

		$id = $this->input->get("id");

		if (empty($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}

		$id = base64_decode($id);

		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);

		$details = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}

		$data['details'] = $details[0];

		/* 
		 * Fetch all branches of the logged-in company.
		 * Used in Lead Master Report to display Branch Details
		 * only when the company has more than one branch.
		 */
		$data['quick_br_list'] = $this->getBranchMasterDetails();  //Anjali alternate details 12-06-2026

		$this->loadViews(get_module() . '/leads/view_lead', $data);
	}

	public function view_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "View Follow-Up Details";
		$id = $this->input->get("id");
		/* $cust_id    = $this->input->get("cust_id");	
		$clm_id     = $this->input->get("clm_id");	 */
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Follow-Up Details not found');
			redirect(get_module() . '/customers/followup_report');
		} else {
			$id = base64_decode($id);
			/* $cust_id = base64_decode($cust_id);
		$clm_id = base64_decode($clm_id); */
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Follow-Up Details not found');
				redirect(get_module() . '/customers/followup_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
					"five" => "Followup",
				);
				$details = $this->api->call_v_api('getCustomerLeadTicketMasterDetails', $params);
				if (empty($details)) {
					$this->session->set_flashdata('error', 'Follow-Up Details not found');
					redirect(get_module() . '/customers/followup_report');
				} else {
					$data['details'] = $details;
					$this->load->view(get_module() . '/customers/view_followup', $data);
				}
			}
		}
	}

	public function add_lead_follwoup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Add Lead Follow-Up ";
		$data['id'] = $id;
		$data['action'] = "add_lead_follwoup";
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
		$this->form_validation->set_rules('followup_feedback', 'FollowUp Details', 'required|trim|max_length[240]');
		$this->form_validation->set_rules('followupstatusid', 'FollowUp Status', 'required');
		$this->form_validation->set_rules('followupmedium', 'FollowUp Medium', 'required');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/leads/add_lead_follwoup', $data, true);
			echo $html;
		} else {
			$next_update_date = $this->input->post('next_update_date', true);
			$date = !empty($next_update_date) ? strtoupper(date("d-M-Y", strtotime($next_update_date))) : "";
			$time = !empty($next_update_date) ? date("h:i A", strtotime($next_update_date)) : "";
			$todaydate = strtoupper(date("d-M-Y"));
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "3",
				"eight" => "Followup",
				"twelve" => $this->_user_id,
				"fourteen" => $id,
				"sixteen" => $todaydate,
				"seventeen" => $this->input->post('followupstatusid', true),
				"eighteen" => $this->input->post('followup_feedback', true),
				"nineteen" => $date,
				"twenty" => $time,
				"twentythree" => $this->input->post('followupmedium', true),
				"twentyfour" => $this->input->post('wpnumber', true),
				"twentyfive" => $this->input->post('followupfor', true),
			);
			//	echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);


			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Lead Follow-Up Added successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
			}
		}
	}

	//  public function add_whatsapp_follwoup()
	//     {
	// 		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
	// 			redirect(get_module().'/dashboard/access_denied');
	// 		}
	// 		$id  = $this->input->get("id");	
	// 		if(empty($id))
	// 		{
	// 			$this->session->set_flashdata('error', 'Lead Details not found');
	// 		    redirect(get_module().'/leads/lead_report');
	// 		}
	// 		$id = base64_decode($id);
	// 		if(!is_numeric($id))
	// 		{
	// 			$this->session->set_flashdata('error', 'Lead Details not found');
	// 		     redirect(get_module().'/leads/lead_report');
	// 		}

	// 		$data['page_title']   = "Whats App Follow-Up ";
	// 		$data['id']           = $id;
	// 		$data['action']       = "add_whatsapp_follwoup";
	// 		$this->form_validation->set_rules('msg','FollowUp Details', 'required|trim|max_length[240]');
	// 		if($this->form_validation->run() == FALSE)
	// 		{
	// 			$html = $this->load->view(get_module().'/leads/whatsapp_follwoup', $data,true);				
	// 			echo $html;			

	// 		}
	// 		else 
	// 		{ 

	// 			$params = array("one"=>$this->_user_id,
	// 			"two"=>$this->_user_branch_id,
	// 			"three"=>$this->_user_company_id,
	// 			"four"=>9503586089,
	// 			// "four"=>$this->input->post('wpnumber',true),
	// 			"five"=>$this->input->post('msg',true),	

	// 			);
	// 		//echo "<pre/>"; print_r($params);die;
	// 		$response = $this->api->call_v_api('sendWhatsAppMsg',$params);
	// 		//echo "<pre/>"; print_r($response);die;
	// 		if($response=="Success"){
	// 					$this->session->set_flashdata('success', 'Message Send successfully ');
	// 					redirect(get_module().'/leads/view_lead/?id='.base64_encode($id));

	// 			} else{
	// 				    $this->session->set_flashdata('error', ERROR_MESSAGE);
	// 					redirect(get_module().'/leads/view_lead/?id='.base64_encode($id));
	// 			}
	// 		}
	// 	}

	public function transfer_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$selectedLeads = $this->session->userdata('selected_leads');

		$data['page_title'] = "Lead Transfer";
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Lead Details not found');
				redirect(get_module() . '/leads/lead_report');
			} else {

				$data['action'] = "Transfer";
				$data['id'] = $id;
				$data['employee_list'] = $this->getEmployeeDetails();


				$this->form_validation->set_rules('assign_to', 'Transfer To', 'required', array('required' => 'Select %s'));
				if ($this->form_validation->run() == FALSE) {
					$this->load->view(get_module() . '/leads/transfer_lead', $data);
				} else {
					$post_data = $this->input->post(null, true);
					$params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $id,
						"five" => $post_data['assign_to'],
						"six" => $this->_user_id,
					);
					$response = $this->api->call_v_api('setLeadTransferMasterDetails', $params);
					if ($response == "Success") {
						$this->session->set_flashdata('success', 'Lead Transfered successfully ');
						redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
					} else {
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($id));
					}
				}
			}
		}
	}
	public function revoke_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Lead Transfer";
		$id = $this->input->get("ref_id");
		$lid = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		} else {
			$id = base64_decode($id);
			$lid = base64_decode($lid);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Lead Details not found');
				redirect(get_module() . '/leads/lead_report');
			} else {

				$post_data = $this->input->post(null, true);
				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$response = $this->api->call_v_api('setLeadTransferRevokeMasterDetails', $params);
				if ($response == "Success") {
					$this->session->set_flashdata('success', 'Lead Transfer Revoke successfully ');
					$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
					$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
					redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($lid));
				} else {
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($lid));
				}
			}
		}
	}

	public function confirm_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Confirm Lead ";
		$data['input_title'] = "Lead Confirmation ";
		$data['ref_id'] = $ref_id;
		$data['action'] = "confirm_lead";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/leads/deactivation_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => "FS",
				"seven" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setConfirmCustomerLeadMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Lead Confirmed successfully ');

				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:lead_approval_list:' . $this->_user_company_id . ':*');

				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			}
		}
	}

	public function reject_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Reject Lead ";
		$data['input_title'] = "Lead Rejection ";
		$data['ref_id'] = $ref_id;
		$data['action'] = "reject_lead";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/leads/reject_lead_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => "Rejected",
				"seven" => $this->input->post('reason', true),
			);

			$response = $this->api->call_v_api('setConfirmCustomerLeadMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Lead Rejected successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			}
		}
	}

	public function deactivate_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Deactivate Lead ";
		$data['input_title'] = "Lead Deactivation ";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_lead";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		$this->form_validation->set_rules('future_conversion', 'Future Conversion', 'required');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/leads/deactivation_popup', $data, true);
			echo $html;
		} else {
			$future_conversion = $this->input->post('future_conversion', true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => "Deactivated",
				"seven" => $this->input->post('reason', true),
				"eight" => $future_conversion,
			);
			$response = $this->api->call_v_api('setDeactivateCustomerLeadMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Lead Deactivated successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			}
		}
	}
	public function reactivate_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title'] = "Re-Activate Lead ";
		$data['input_title'] = "Lead Re-Activation ";
		$data['ref_id'] = $ref_id;
		$data['action'] = "reactivate_lead";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/leads/deactivation_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => "Reactivate",
				"seven" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateCustomerLeadMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Lead Re-Activated successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' . $this->_user_company_id . ':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' . $this->_user_company_id . ':*');
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($ref_id));
			}
		}
	}

	public function download_lead_report()
	{

		$post_data = $this->input->post(Null, true);
		$product_id = $this->input->post('product_id');
		$state_id = $this->input->post('state_id');
		$dist_id = $this->input->post('dist_id');
		$city_id = $this->input->post('city_id');
		$ref_id = $this->input->post('ref_id');
		$priority = $this->input->post('priority');
		$followup = $this->input->post('followup');
		$lead_date = $this->input->post('lead_date');
		$lead_month_year = $this->input->post('lead_month_year');
		$em_id = $this->input->post('emp_id');
		$transfer_to = $this->input->post('transfer_to');

		$role_id = $this->_role_id;
		$added_by = $this->input->post('added_by');

		if ($role_id == SALES_ROLE_ID) {


			$added_by = $this->_user_id;
		}

		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		$searchStr_contact = $this->input->post('searchStr_contact');
		$searchStr_name = addslashes($searchStr_name);
		$searchStr_contact = addslashes($searchStr_contact);
		$this->session->set_userdata('lead_post_data', $post_data);

		$lead_date = !empty($lead_date) ? strtoupper(date("d-M-Y", strtotime($lead_date))) : "";
		$lead_month = Null;
		$lead_year = Null;
		if (!empty($lead_month_year)) {
			$lead_month_year = explode("-", $lead_month_year);
			$lead_month = $lead_month_year[0];
			$lead_year = $lead_month_year[1];
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"six" => $searchStr_name,
			"seven" => $searchStr_contact,
			"eight" => $product_id,
			"nine" => $state_id,
			"ten" => $dist_id,
			"eleven" => $city_id,
			"twelve" => $ref_id,
			"thirteen" => $priority,
			"fourteen" => $lead_date,
			"fifteen" => $lead_month,
			"sixteen" => $lead_year,
			"seventeen" => $added_by,
			"twentytwo" => $followup,
			"twentythree" => "",
			"twentyfour" => $em_id,
			"twentyfive" => $transfer_to
		);
		$lead_details = $this->api->call_v_api('downloadLeadMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Lead_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($lead_details);
	}


	public function download_team_lead_report()
	{



		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_company_id,
			"three" => $this->_user_branch_id
		);
		$lead_details = $this->api->call_v_api('downloadLeadTeamDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Team_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($lead_details);
	}

	/* public function download_lead_report()
	{

		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>"Active",
		"five"=>"",
		"six"=>"",
		);
		$lead_details = $this->api->call_v_api('getDownloadExelLeadDetail',$params);
		$this->load->library('excel');
		$fileName = 'Lead_Report_'.Date("Y-M-d-h-i-s").'.xlsx';  
		$objPHPExcel  = new PHPExcel();
		$sheet = $objPHPExcel->setActiveSheetIndex();
		  // set Header
		   $sheet->setCellValue('A1', 'Lead Name');
		$sheet->setCellValue('B1', 'Lead Address');
		$sheet->setCellValue('C1', 'Lead Area');
		$sheet->setCellValue('D1', 'Lead Contact');
		$sheet->setCellValue('E1', 'Lead Contact Email');
		$sheet->setCellValue('F1', 'Lead Contact Person');       
		$sheet->setCellValue('G1', 'Branch name');       
		$sheet->setCellValue('H1', 'Lead Pincode');       
		$sheet->setCellValue('I1', 'Lead LandLine');       
		$sheet->setCellValue('J1', 'State');       
		$sheet->setCellValue('K1', 'District');       
		$sheet->setCellValue('L1', 'City');       
		$sheet->setCellValue('M1', 'Lead Added Date');       
		$sheet->setCellValue('N1', 'Lead Added By');       
		$sheet->setCellValue('O1', 'FS Request Approve By');       
		$sheet->setCellValue('P1', 'FS Request Date');       
		$sheet->setCellValue('Q1', 'Lead Description');       
		$sheet->setCellValue('R1', 'Lead Status');       
		$sheet->setCellValue('S1', 'Lead Type Name');       
		$sheet->setCellValue('T1', 'Lead Amount');       
		$sheet->setCellValue('U1', 'Lead Priority Level');       
		$sheet->setCellValue('V1', 'Alternate Email');       
		$sheet->setCellValue('W1', 'Alternate Name');       
		$sheet->setCellValue('X1', 'Alternate Contact');       
		$sheet->setCellValue('Y1', 'Lead Referred By');       
		$sheet->setCellValue('Z1', 'Lead Referred By Name');       
		$sheet->setCellValue('AA1', 'Lead Referred By Address');       
		$sheet->setCellValue('AB1', 'Lead Referred By Email');       
		$sheet->setCellValue('AC1', 'Lead Referred By Contact');

		// set Row		
		$rows = 2;
		foreach ($lead_details as $val){
			$sheet->setCellValue('A' . $rows, $val['clm_name']);
			$sheet->setCellValue('B' . $rows, $val['clm_address']);
			$sheet->setCellValue('C' . $rows, $val['clm_area']);
			$sheet->setCellValue('D' . $rows, $val['clm_contact']);
			$sheet->setCellValue('E' . $rows, $val['clm_contact_emailid']);
			$sheet->setCellValue('F' . $rows, $val['clm_contact_person']);
			$sheet->setCellValue('G' . $rows, $val['branch_name']);
			$sheet->setCellValue('H' . $rows, $val['clm_pincode']);
			$sheet->setCellValue('I' . $rows, $val['clm_landline']);
			$sheet->setCellValue('J' . $rows, $val['state_name']);
			$sheet->setCellValue('K' . $rows, $val['dist_name']);
			$sheet->setCellValue('L' . $rows, $val['city_name']);
			$sheet->setCellValue('M' . $rows, $val['clm_date']);
			$sheet->setCellValue('N' . $rows, $val['clm_addedby']);
			$sheet->setCellValue('O' . $rows, $val['clm_fsrequest_apprv_by']);
			$sheet->setCellValue('P' . $rows, $val['clm_fsa_date']);
			$sheet->setCellValue('Q' . $rows, $val['clm_description']);
			$sheet->setCellValue('R' . $rows, $val['clm_status']);
			$sheet->setCellValue('S' . $rows, $val['clm_type_name']);
			$sheet->setCellValue('T' . $rows, $val['clm_lead_amount']);
			$sheet->setCellValue('U' . $rows, $val['clm_priority_level']);
			$sheet->setCellValue('V' . $rows, '');
			$sheet->setCellValue('W' . $rows, '');
			$sheet->setCellValue('X' . $rows, '');
			$sheet->setCellValue('Y' . $rows, $val['clm_refby']);
			$sheet->setCellValue('Z' . $rows, $val['clm_refby_name']);
			$sheet->setCellValue('AA' . $rows, $val['clm_refby_address']);
			$sheet->setCellValue('AB' . $rows, $val['clm_refby_emailid']);
			$sheet->setCellValue('AC' . $rows, $val['clm_refby_contact']);
			$rows++;
		} 
		/* $objPHPExcel->getActiveSheet()->freezePane('A1');
		$objPHPExcel->getActiveSheet()
			->getStyle('A1:AC1')
			->getFill()
			->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
			->getStartColor()
			->setARGB('1b62bf');


		$objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);		
		$objWriter->save(EXCEL_DOWNLOAD_PATH.$fileName);
	// download file
		header("Content-Type: application/vnd.ms-excel");
		   header('Content-Disposition: attachment; filename="Lead_Report_'.Date("Y-m-d-h-i-s").'.xlsx"');
		header("Content-Type: text/csv"); 
		redirect(EXCEL_DOWNLOAD_PATH.$fileName);    	

	} */


	/************ Functions ***********/

	public function getPermissionMasterDetails($type = NULL, $status = "Active", $permission_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $permission_id
		);
		$response = $this->api->call_v_api('getPermissionMasterDetails', $params);
		return $response;
	}

	public function getStateDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);
		$response = $this->api->call_v_api('getStateDetails', $params);
		return $response;
	}


	public function getProductMasterDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);
		$response1 = $this->api->call_v_api('getProductMasterDetails01', $params);
		$response1 = $response1['jsArray'];
		$response2 = $this->api->call_v_api('getOneTimeServiceMasterDetails01', $params);
		$response2 = $response2['jsArray'];
		$response3 = $this->api->call_v_api('getAMCDetails01', $params);
		$response3 = $response3['jsArray'];
		$response = (array_merge($response1, $response2, $response3));
		return $response;
	}

	public function getProductMasterDetails_bkp()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);
		$response = $this->api->call_v_api('getProductMasterDetails', $params);
		return $response['jsArray'];
	}


	public function getDuartionList()
	{
		$list = array(
			"365" => "1 Year",
			"730" => "2 Years",
			"1095" => "3 Years",
			"1460" => "4 Years",
			"1825" => "5 Years",
			"30" => "Monthly",
			"90" => "3 Months",
			"180" => "6 Months",
		);
		return $list;
	}

	public function getReferencedBy()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
		);
		$response = $this->api->call_v_api('getReferenceByDetails', $params);
		return $response['jsArray'];
	}
	public function getEmployeeDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Active",
		);
		$response = $this->api->call_v_api('getEmployeeReportDetails', $params);
		return $response['jsArray'];
	}
	public function getAreaDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);
		$response = $this->api->call_v_api('getAreaDetails', $params);
		return $response['jsArray'];
	}
	public function getAreaCityIdDetails($state_id = NULL, $dist_id = NULL, $city_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => $dist_id,
			"six" => $city_id,
			"seven" => "Active",
			"eight" => "Report",
		);
		$response = $this->api->call_v_api('getAreaCityIdDetails', $params);
		return $response['jsArray'];
	}

	public function getDistrictStateIdDetails($state_id = NULL, $type = NULL, $status = "Active", $dist_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => $status,
			"six" => $type,
			"seven" => $dist_id
		);
		$response = $this->api->call_v_api('getDistrictStateIdDetails', $params);
		return $response;
	}
	public function getCityDistrictIdDetails($state_id = NULL, $dist_id = NULL, $type = NULL, $status = "Active", $city_id = NULL, $page = NULL, $total_count = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => $dist_id,
			"six" => $status,
			"seven" => $type,
			"eight" => $city_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$response = $this->api->call_v_api('getCityDistrictIdDetails', $params);
		return $response;
	}

	public function check_access($class = Null, $method = Null)
	{
		return true;
	}

	public function download_followup_report()
	{

		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;
		$date = $this->input->post('date');
		$em_id = $this->input->post('emp_id');
		$from_date = $this->input->post('from_date');
		$month_year = $this->input->post('month_year');

		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : strtoupper(date("d-M-Y"));
		$from_date = strtoupper(date("d-M-Y", strtotime($from_date)));
		// printr
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		// $total_count          = ($page==1)?Null:$this->session->userdata('team_flwup_total_count');
		// $post_data['page']    = $page;
		// $this->session->set_userdata('team_followup_post_data',$post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $report_to,
			"five" => $em_id,
			"six" => $from_date,
			"seven" => $date,
			"eight" => $month_year,
			"limit" => 0,
			"offset" => 0,
			"total_count" => 0,

		);

		$result = $this->api->call_v_api('downloadTeamFollowDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Team_Followup_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	//22-01-2025

	public function multi_transfer_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Lead Transfer";
		$data['action'] = "Send";
		$data['employee_list'] = $this->getEmployeeDetails();
		$data['role_id_con'] = $this->_role_id;

		$this->form_validation->set_rules('em_type', 'Send SMS/EMail ', 'required|trim|max_length[15]');
		$em_type = $this->input->post("em_type");
		if ($em_type == "Message") {
			$this->form_validation->set_rules('mobile_nos[]', 'Mobile No.', 'required|trim|max_length[1000]');
			$this->form_validation->set_rules('msg', 'Message', 'required|trim|max_length[500]');
		}
		if ($em_type == "Email") {
			$this->form_validation->set_rules('email_ids[]', 'Email Id', 'required|trim|max_length[5000]');
			$this->form_validation->set_rules('email_msg', 'Message', 'required|trim|max_length[500]');
			$this->form_validation->set_rules('email_sub', 'Subject', 'required|trim|max_length[100]');
		}

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/leads/lead_transfer', $data);
		} else {


			$wp_noti_img = null;


			$post_data = $this->input->post(null, true);







			if ($em_type == "Message") {
				$mobile_nos = $post_data['mobile_nos'];
				$mobile_list = $post_data['group-b'];
				$mobile_str = "";
				if (!empty($mobile_list)) {
					foreach ($mobile_list as $mobile) {
						$mobile_nos[] = $mobile['lead_altcontact'];
					}
				}
				if (is_array($mobile_nos)) {
					$mobile_str = implode(",", $mobile_nos);
				}

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $post_data['em_type'],
					"five" => $mobile_str,
					"six" => $post_data['msg'],
				);
			}

			if ($em_type == "Email") {

				$email_ids = $post_data['email_ids'];
				$email_list = $post_data['group-c'];
				$email_str = "";
				if (!empty($email_list)) {
					foreach ($email_list as $email) {
						$email_ids[] = $email['lead_altemail'];
					}
				}
				if (is_array($email_ids)) {
					$email_str = implode(",", $email_ids);
				}

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $post_data['em_type'],
					"five" => $email_str,
					"six" => $post_data['email_sub'],
					"seven" => $post_data['email_msg'],
				);
			}


			if ($em_type == "WhatsApp") {
				$mobile_nos = $post_data['wpmobile_nos'];
				$mobile_list = $post_data['group-w'];
				$mobile_str = "";
				if (!empty($mobile_list)) {
					foreach ($mobile_list as $mobile) {
						$mobile_nos[] = $mobile['wpcontact'];
					}
				}
				if (is_array($mobile_nos)) {
					$mobile_str = implode(",", $mobile_nos);
				}

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $post_data['em_type'],
					"five" => $mobile_str,
					"six" => $post_data['wpmsg'],
					"seven" => $wp_noti_img,
				);
			}

			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('sendMessage', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', $em_type . 'Sent Successfully !!');
				redirect(get_module() . '/admin/sms_email_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/sms_email_report');
			}
		}
	}

	public function transfer_multiple()
	{
		// Check if the user has access to this page
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		// Check if it's a POST request
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			// Ensure that selected_leads array and assign_to are present in the POST request
			if (isset($_POST['selected_leads']) && is_array($_POST['selected_leads']) && isset($_POST['assign_to'])) {
				$selectedLeads = $_POST['selected_leads']; // Array of selected lead IDs
				$assignTo = $_POST['assign_to']; // Employee ID

				// Convert the array to a comma-separated string
				$selectedLeadsString = implode(',', $selectedLeads);

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $selectedLeadsString,
					"five" => $assignTo,
					"six" => $this->_user_id,
				);

				$response = $this->api->call_v_api('setLeadTransferMasterDetails', $params);

				echo json_encode(['status' => 'success']);
			} else {
				echo json_encode(['error' => 'No leads selected or employee not assigned.']);
			}
		} else {
			echo "Invalid request method.";
		}
	}

	/////////////////////////START///////////////////
	// 19/06/26 added by anjali dhane lead summary report

	public function lead_summary_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$data['page_title'] = "Lead Summary Report";

		$this->loadViews(get_module() . '/leads/lead_summary_report', $data);
	}

	public function get_employee_summary()
	{
		$start_date = $this->input->post('start_date');
		$end_date = $this->input->post('end_date');
		$month_year = $this->input->post('month_year');
		$employee_name = $this->input->post('employee_name');

		echo json_encode($this->build_lead_summary_report($start_date, $end_date, $month_year, $employee_name));
	}

	private function build_lead_summary_report($start_date = '', $end_date = '', $month_year = '', $employee_name = '')
	{
		$employee_filter = strtolower(trim((string) $employee_name));

		// if (empty($month_year)) {
		// 	$month_year = date('m-Y');
		// }

		$report_month_year = !empty($month_year)
			? $month_year
			: date("m-Y");

		$filter_from_date = !empty($start_date)
			? strtoupper(date("d-M-Y", strtotime($start_date)))
			: "";

		$filter_to_date = !empty($end_date)
			? strtoupper(date("d-M-Y", strtotime($end_date)))
			: "";

		if (!empty($filter_from_date) && empty($filter_to_date)) {

			$filter_to_date = strtoupper(date("d-M-Y"));

		}

		if (
			!empty($filter_from_date) && !empty($filter_to_date) &&
			strtotime($filter_to_date) < strtotime($filter_from_date)
		) {

			$filter_to_date = $filter_from_date;
		}

		$has_date_filter =
			(
				!empty($filter_from_date) ||
				!empty($filter_to_date)
			);

		if ($has_date_filter) {

			$api_month_year = '';

		} else {

			$month_date =
				DateTime::createFromFormat(
					'm-Y',
					$report_month_year
				);

			$api_month_year = !empty($month_date)
				? strtoupper($month_date->format('M-Y'))
				: strtoupper(date(
					"M-Y",
					strtotime("1-" . $report_month_year)
				));
		}

		// $params = array(
		// 	"one" => $this->_user_id,
		// 	"two" => $this->_user_branch_id,
		// 	"three" => $this->_user_company_id,
		// 	"four" => $month_year
		// );
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $api_month_year,
			"five" => $filter_from_date,
			"six" => $filter_to_date
		);

		$result = $this->api->call_v_api('getRoiReport', $params);
		$data_obj = array();
		$lead_list = array();
		$employee_roi = array();

		if (!empty($result['jsArray'][0]) && is_array($result['jsArray'][0])) {
			$data_obj = $result['jsArray'][0];
			$lead_list = !empty($data_obj['lead_list']) ? $data_obj['lead_list'] : array();
			$employee_roi = !empty($data_obj['employee_roi']) ? $data_obj['employee_roi'] : array();
		}

		// $total_leads = 0;
		// $approved_leads = 0;
		// $converted_leads = 0;

		$total_leads = 0;
		$active_leads = 0;
		$approved_leads = 0;
		$converted_leads = 0;
		$deactivated_leads = 0;

		$summary = array();
		$from_ts = $this->parse_report_date($start_date, true);
		$to_ts = $this->parse_report_date($end_date, false);
		// Added by Anjali 29/06/26
		$employee_id_by_name = array();
		$employee_designation_by_name = array();
		$employee_designation_by_user_id = array();
		$employee_designation_by_emp_id = array();
		$sales_employees = array();
		$included_employee_ids = array();
		$included_employee_names = array();
		$employee_details = $this->getEmployeeDetails();

		if (!empty($employee_details) && is_array($employee_details)) {
			foreach ($employee_details as $employee) {
				$name = !empty($employee['emp_name'])
					? $employee['emp_name']
					: (!empty($employee['user_person_name']) ? $employee['user_person_name'] : '');
				$user_id = !empty($employee['user_id']) ? $employee['user_id'] : '';
				$emp_id = !empty($employee['emp_id']) ? $employee['emp_id'] : '';
				$designation = !empty($employee['permission_name'])
					? $employee['permission_name']
					: (!empty($employee['designation_name']) ? $employee['designation_name'] : '');

				if ($name !== '') {
					$name_key = strtolower(trim(preg_replace('/\s+/', ' ', $name)));

					if ($user_id !== '') {
						$employee_id_by_name[$name_key] = $user_id;
					}

					$employee_designation_by_name[$name_key] = $designation;
				}

				if ($user_id !== '') {
					$employee_designation_by_user_id[(string) $user_id] = $designation;
				}

				if ($emp_id !== '') {
					$employee_designation_by_emp_id[(string) $emp_id] = $designation;
				}

				if (strtolower(trim($designation)) === 'sales' && $name !== '') {
					$sales_employees[] = array(
						'user_id' => $user_id,
						'emp_id' => $emp_id,
						'employee_name' => $name,
					);
				}
			}
		}


		foreach ($employee_roi as $emp) {
			$emp_name = !empty($emp['emp_name'])
				? $emp['emp_name']
				: (!empty($emp['employee_name']) ? $emp['employee_name'] : '');

			$row_active = !empty($emp['active_leads'])
				? (int) $emp['active_leads']
				: 0;

			$row_deactivated = !empty($emp['deactivated_leads'])
				? (int) $emp['deactivated_leads']
				: 0;

			if (!empty($employee_filter) && strpos(strtolower($emp_name), $employee_filter) === false) {
				continue;
			}

			$row_total = !empty($emp['total_leads']) ? (int) $emp['total_leads'] : 0;
			$row_approved = !empty($emp['approved_leads']) ? (int) $emp['approved_leads'] : 0;
			$row_converted = !empty($emp['converted_customers'])
				? (int) $emp['converted_customers']
				: (!empty($emp['converted_leads']) ? (int) $emp['converted_leads'] : 0);
			$employee_name_key = strtolower(trim(preg_replace('/\s+/', ' ', $emp_name)));
			$employee_designation = !empty($emp['permission_name'])
				? $emp['permission_name']
				: (!empty($emp['designation_name']) ? $emp['designation_name'] : '');

			if ($employee_designation === '' && !empty($emp['user_id']) &&
				isset($employee_designation_by_user_id[(string) $emp['user_id']])) {
				$employee_designation = $employee_designation_by_user_id[(string) $emp['user_id']];
			}

			foreach (array('employee_id', 'emp_id') as $employee_id_key) {
				if ($employee_designation !== '' || empty($emp[$employee_id_key])) {
					continue;
				}

				$report_employee_id = (string) $emp[$employee_id_key];
				if (isset($employee_designation_by_emp_id[$report_employee_id])) {
					$employee_designation = $employee_designation_by_emp_id[$report_employee_id];
				} elseif (isset($employee_designation_by_user_id[$report_employee_id])) {
					$employee_designation = $employee_designation_by_user_id[$report_employee_id];
				}
			}

			if ($employee_designation === '' && isset($employee_designation_by_name[$employee_name_key])) {
				$employee_designation = $employee_designation_by_name[$employee_name_key];
			}

			// 30/06/26 Added by Anjali - For zero lead count, display only Sales employees.
			$is_sales_employee = in_array(strtolower(trim($employee_designation)), array('sales'), true);
			if ($row_total === 0 && !$is_sales_employee) {
				continue;
			}

			$total_leads += $row_total;
			$active_leads += $row_active;
			$approved_leads += $row_approved;
			$converted_leads += $row_converted;
			$deactivated_leads += $row_deactivated;

			// Added by Anjali 29/06/26
			// The lead report filters by user_id. ROI employee_id/emp_id values can
			$employee_id = isset($employee_id_by_name[$employee_name_key])
				? $employee_id_by_name[$employee_name_key]
				: (!empty($emp['user_id'])
					? $emp['user_id']
					: (!empty($emp['employee_id'])
						? $emp['employee_id']
						: (!empty($emp['emp_id']) ? $emp['emp_id'] : '')));

			$summary[] = array(
				'employee_id' => $employee_id,
				'employee_name' => $emp_name,
				'total_leads' => $row_total,
				'active_leads' => $row_active,
				'approved_leads' => $row_approved,
				'converted_leads' => $row_converted,
				'deactivated_leads' => $row_deactivated,
			);

			$included_employee_names[$employee_name_key] = true;
			foreach (array('user_id', 'employee_id', 'emp_id') as $employee_id_key) {
				if (!empty($emp[$employee_id_key])) {
					$included_employee_ids[(string) $emp[$employee_id_key]] = true;
				}
			}
			if ($employee_id !== '') {
				$included_employee_ids[(string) $employee_id] = true;
			}
		}

		// 30/06/26 Added by Anjali - Add Sales employees omitted by ROI with zero lead counts.
		foreach ($sales_employees as $sales_employee) {
			$sales_employee_name = $sales_employee['employee_name'];
			$sales_employee_name_key = strtolower(trim(preg_replace('/\s+/', ' ', $sales_employee_name)));
			$user_id_key = (string) $sales_employee['user_id'];
			$emp_id_key = (string) $sales_employee['emp_id'];

			$is_already_included = isset($included_employee_names[$sales_employee_name_key]) ||
				($user_id_key !== '' && isset($included_employee_ids[$user_id_key])) ||
				($emp_id_key !== '' && isset($included_employee_ids[$emp_id_key]));

			if ($is_already_included ||
				(!empty($employee_filter) && strpos(strtolower($sales_employee_name), $employee_filter) === false)) {
				continue;
			}

			$summary[] = array(
				'employee_id' => $sales_employee['user_id'],
				'employee_name' => $sales_employee_name,
				'total_leads' => 0,
				'active_leads' => 0,
				'approved_leads' => 0,
				'converted_leads' => 0,
				'deactivated_leads' => 0,
			);
		}

		// if (empty($employee_filter) && !empty($lead_list)) {
		// 	$total_leads = count($lead_list);
		// }

		usort($summary, function ($a, $b) {
			return $b['total_leads'] - $a['total_leads'];
		});

		$performance = $this->build_lead_performance_rows($summary);

		return array(
			// 'kpi' => array(
			// 	'total_leads' => $total_leads,
			// 	'approved_leads' => $approved_leads,
			// 	'converted_leads' => $converted_leads,
			// 	'conversion_rate' => ($total_leads > 0) ? round(($converted_leads * 100) / $total_leads, 2) : 0,
			// ),
			'kpi' => array(
				'total_leads' => $total_leads,
				'active_leads' => $active_leads,
				'approved_leads' => $approved_leads,
				'converted_leads' => $converted_leads,
				'deactivated_leads' => $deactivated_leads,
				'conversion_rate' => ($total_leads > 0)
					? round(($converted_leads * 100) / $total_leads, 2)
					: 0,
			),
			'performance' => $performance,
			'summary' => $summary,
		);
	}

	private function build_lead_performance_rows($summary)
	{
		$max_leads = 1;
		foreach ($summary as $row) {
			if ($row['total_leads'] > $max_leads) {
				$max_leads = $row['total_leads'];
			}
		}

		$performance = array();
		foreach ($summary as $row) {
			$row['percentage'] = round(($row['total_leads'] * 100) / $max_leads);
			$performance[] = $row;
		}

		return $performance;
	}

	private function get_lead_summary_rows()
	{
		$em_id = $this->_user_id;
		$transfer_to = "";
		$added_by = $this->_user_id;

		if ($this->_role_id == SUPER_ADMIN_ROLE_ID || $this->_role_id == ADMIN_ROLE_ID) {
			$em_id = "";
			$added_by = "";
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "",
			"six" => "",
			"seven" => "",
			"eight" => "",
			"nine" => "",
			"ten" => "",
			"eleven" => "",
			"twelve" => "",
			"thirteen" => "",
			"fourteen" => "",
			"fifteen" => Null,
			"sixteen" => Null,
			"seventeen" => $added_by,
			"twentytwo" => "",
			"twentythree" => "",
			"twentyfour" => $em_id,
			"twentyfive" => $transfer_to,
			"limit" => 5000,
			"offset" => 1,
			"total_count" => Null,
		);

		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);

		if (!empty($result['jsArray']) && is_array($result['jsArray'])) {
			return $result['jsArray'];
		}

		return array();
	}

	private function first_non_empty($row, $keys)
	{
		foreach ($keys as $key) {
			if (isset($row[$key]) && $row[$key] !== '') {
				return $row[$key];
			}
		}

		return '';
	}

	private function get_lead_row_timestamp($row)
	{
		$date_value = $this->first_non_empty($row, array('clm_date', 'lead_date', 'created_date', 'created_on', 'clm_addeddate'));

		return $this->parse_report_date($date_value, true);
	}

	private function parse_report_date($date_value, $start_of_day = true)
	{
		if (empty($date_value)) {
			return null;
		}

		$date_value = trim((string) $date_value);
		$formats = array('d-m-Y', 'd-M-Y', 'Y-m-d', 'd/m/Y', 'm/d/Y');

		foreach ($formats as $format) {
			$date = DateTime::createFromFormat($format, $date_value);
			if (!empty($date)) {
				$date->setTime($start_of_day ? 0 : 23, $start_of_day ? 0 : 59, $start_of_day ? 0 : 59);
				return $date->getTimestamp();
			}
		}

		$timestamp = strtotime($date_value);
		if ($timestamp !== false) {
			$date = new DateTime();
			$date->setTimestamp($timestamp);
			$date->setTime($start_of_day ? 0 : 23, $start_of_day ? 0 : 59, $start_of_day ? 0 : 59);
			return $date->getTimestamp();
		}

		return null;
	}


	// 19/06/26 end added by anjali dhane lead summary report

}
