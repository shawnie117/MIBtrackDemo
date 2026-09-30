<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class Admin extends MY_Controller
{ // Main Controller

	public function __construct()
	{
		parent::__construct();
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
			$this->_user_mobile = isset($vendor['user_mob']) ? $vendor['user_mob'] : '';
		}
	}
	public function index()
	{
		redirect(get_module() . "/dashboard");
	}

	public function demo()
	{
		// DEMO BUILD RIG: this legacy route referenced a removed view.
		redirect(get_module() . "/dashboard");
	}


	// public function set_branch_dashboard()
	// { 
	//   $branch_id = $this->input->get("p_branch");
	//   $branch_id = base64_decode($branch_id);
	//   $this->session->set_userdata('user_branch_id',$branch_id);
	//   $details = $this->getBranchMasterDetails($branch_id,NULL);
	//   $this->session->set_userdata('user_branch_name',$details[0]['branch_name']);
	//   redirect(get_module()."/dashboard");	 
	// }

	public function set_branch_dashboard()
	{
		$branch_id = $this->input->get("p_branch");
		$branch_id = base64_decode($branch_id);

		$vendor = $this->session->userdata('vendor');

		// Update branch ID in session array
		$vendor['user_branch_id'] = $branch_id;


		//   $this->session->set_userdata('user_branch_id',$branch_id);
		$details = $this->getBranchMasterDetails($branch_id, NULL);
		//   $this->session->set_userdata('branch_name',$details[0]['branch_name']);
		$vendor['branch_name'] = $details[0]['branch_name'];
		$this->session->set_userdata('vendor', $vendor);
		$vendor = $this->session->userdata('vendor');

		//   echo "<pre/>"; print_r($vendor);die;
		redirect(get_module() . "/dashboard");
	}

	public function access_denied()
	{
		$data['page_title'] = "Access Denied";
		$this->loadViews(get_module() . '/dashboard/access_denied', $data);
	}
	public function my_account()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "My Account";
		$role_id = $this->_role_id;

		/* if($role_id == CUSTOMER_ROLE_ID){
			$cust_id = $this->_user_cust_id; 
			$data['my_details']  = $this->getCustomerMasterDetails($cust_id);


		}  */
		if ($role_id == SUPER_ADMIN_ROLE_ID) {

			$params = array(
				"one" => "1",
				"two" => "1",
				"three" => "1",
				"four" => $this->_user_company_id,
			);
			$response =
				$com_details = $this->api->call_api('getCustomerMasterDetails', $params);
			$wts_details = $this->get_whatsapp_count();
			$data['wts_details'] = $wts_details;
			$data['com_details'] = $com_details[0];
			$data['my_details'] = $this->getCompanyMasterDetails();
		} else {
			$data['my_details'] = $this->getEmployeeDetails();
		}


		$this->loadViews(get_module() . '/admin/my_account', $data);
	}

	// Branch  Master 
	public function branch_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Branch Report";
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');

		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$searchStr = addslashes($searchStr);
		$data['status_list'] = array("Active", "Deactivated");
		$data['branch_list'] = $this->getBranchMasterDetails(NULL, $status, $searchStr);
		$this->loadViews(get_module() . '/admin/list_branch', $data);
	}

	public function add_branch()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$data['page_title'] = "Add Branch";
		$data['action'] = "Add";

		$this->form_validation->set_rules('p_branch_name', 'Branch Name', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('p_branch_contact', 'Contact Number', 'required|trim|max_length[10]');

		$this->form_validation->set_rules('p_branch_contact1', 'Other Contact Number', 'trim|max_length[10]');

		$this->form_validation->set_rules('p_branch_contact_person', 'Contact Person', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('p_branch_details', 'Branch Details', 'required|trim|max_length[250]');

		$this->form_validation->set_rules('p_branch_address', 'Branch Address', 'required|trim|max_length[250]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/add_edit_branch', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['p_branch_name'],
				"six" => $post_data['p_branch_details'],
				"seven" => $post_data['p_branch_contact'],
				"eight" => $post_data['p_branch_contact1'],
				"nine" => $post_data['p_branch_contact_person'],
				"ten" => $post_data['p_branch_address'],
			);
			$response = $this->api->call_v_api('setBranchMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Branch Added successfully !!');
				redirect(get_module() . '/admin/branch_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/branch_report');
			}
		}
	}

	public function edit_branch()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$branch_id = $this->input->get("branch_id");
		if (empty($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$branch_id = base64_decode($branch_id);
		if (!is_numeric($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$data['page_title'] = "Update Branch Details";
		$data['action'] = "Edit";

		$data['branch_id'] = $branch_id;
		$details = $this->getBranchMasterDetails($branch_id, NULL);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$data['branch_details'] = $details[0];

		$this->form_validation->set_rules('p_branch_name', 'Branch Name', 'required|trim|max_length[50]');
		$this->form_validation->set_rules('p_branch_contact', 'Contact Number', 'required|trim|max_length[10]');

		$this->form_validation->set_rules('p_branch_contact1', 'Other Contact Number', 'trim|max_length[10]');

		$this->form_validation->set_rules('p_branch_contact_person', 'Contact Person', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('p_branch_details', 'Branch Details', 'required|trim|max_length[250]');

		$this->form_validation->set_rules('p_branch_address', 'Branch Address', 'required|trim|max_length[250]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/add_edit_branch', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['branch_id'],
				"six" => $post_data['p_branch_name'],
				"seven" => $post_data['p_branch_details'],
				"eight" => $post_data['p_branch_contact'],
				"nine" => $post_data['p_branch_contact1'],
				"ten" => $post_data['p_branch_contact_person'],
				"eleven" => $post_data['p_branch_address']
			);
			$response = $this->api->call_v_api('setModifyBranchMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Branch Details Updated successfully !!');
				redirect(get_module() . '/admin/branch_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/branch_report');
			}
		}
	}

	public function view_branch()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Branch Master Report";
		$branch_id = $this->input->get("branch_id");
		if (empty($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$branch_id = base64_decode($branch_id);
		if (!is_numeric($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}

		$details = $this->getBranchMasterDetails($branch_id, NULL);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$data['branch_details'] = $details[0];
		$this->loadViews(get_module() . '/admin/view_branch', $data);
	}

	public function deactivate_branch()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$branch_id = $this->input->get("branch_id");
		if (empty($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$branch_id = base64_decode($branch_id);
		if (!is_numeric($branch_id)) {
			$this->session->set_flashdata('error', 'Branch Details not found');
			redirect(get_module() . '/admin/branch_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $branch_id,
			"six" => "Deactivated",
		);
		$response = $this->api->call_v_api('setDeactivateBranchMasterDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Branch Deactivated successfully ');
			redirect(get_module() . '/admin/branch_report');
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/admin/branch_report');
		}
	}

	public function assign_block()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Assign Block Permission";
		$data['block_details'] = $this->getDashboardPermissionAssignDetails();

		$this->form_validation->set_rules('0_permission_ids[]', 'Permission', 'required', array('required' => 'Select Atleast one %s'));

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/assign_block', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$block_ids = $post_data['block_ids'];
			$block_id_str = "";
			$permission_id_str = "";
			foreach ($block_ids as $key => $block) {
				$per_mission = $key . "_permission_ids";
				if (isset($post_data[$per_mission])) {
					foreach ($post_data[$per_mission] as $per) {
						$block_id_str = $block_id_str . "," . $block;
						$permission_id_str = $permission_id_str . "," . $per;
					}
				}
			}
			$permission_id_str = ltrim($permission_id_str, ',');
			$block_id_str = ltrim($block_id_str, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $permission_id_str,
				"seven" => $block_id_str,
				"eight" => "Block",
			);
			$response = $this->api->call_v_api('setPermissionLevelDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Block Assigned successfully !!');
				redirect(get_module() . '/admin/assign_block');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/assign_block');
			}
			redirect(get_module() . '/admin/assign_block');
		}
	}
	public function assign_reminder()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Assign Reminder Permission";
		$data['block_details'] = $this->getDashboardPermissionAssignDetails("Reminder");

		$this->form_validation->set_rules('0_permission_ids[]', 'Permission', 'required', array('required' => 'Select Atleast one %s'));

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/assign_reminder', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$block_ids = $post_data['block_ids'];
			$block_id_str = "";
			$permission_id_str = "";
			foreach ($block_ids as $key => $block) {
				$per_mission = $key . "_permission_ids";
				if (isset($post_data[$per_mission])) {
					foreach ($post_data[$per_mission] as $per) {
						$block_id_str = $block_id_str . "," . $block;
						$permission_id_str = $permission_id_str . "," . $per;
					}
				}
			}
			$permission_id_str = ltrim($permission_id_str, ',');
			$block_id_str = ltrim($block_id_str, ',');

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $permission_id_str,
				"seven" => $block_id_str,
				"eight" => "Reminder",
			);
			$response = $this->api->call_v_api('setPermissionLevelDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Reminder Assigned successfully !!');
				redirect(get_module() . '/admin/assign_reminder');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/assign_reminder');
			}
			redirect(get_module() . '/admin/assign_reminder');
		}
	}

	public function assign_menu()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Assign Menu Permission";
		$data['menu_list'] = $this->getMenuPermissionAssignDetails();

		$this->form_validation->set_rules('0_0_permission_ids[]', 'Permission', 'required', array('required' => 'Select Atleast one %s'));

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/assign_menu', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$menu_no = $post_data['menu_no'];
			$permission_id_str = "";
			$sub_menu_no_str = "";

			foreach ($menu_no as $key => $menu) {
				$sub_menu = $key . "_sub_menu_no";
				if (isset($post_data[$sub_menu])) {
					foreach ($post_data[$sub_menu] as $key1 => $sb_menu) {
						$perm = $key . "_" . $key1 . "_permission_ids";
						if (isset($post_data[$perm])) {
							foreach ($post_data[$perm] as $per) {
								$sub_menu_no_str = $sub_menu_no_str . "," . $sb_menu;
								$permission_id_str = $permission_id_str . "," . $per;
							}
						}
					}
				}
			}
			$permission_id_str = ltrim($permission_id_str, ',');
			$sub_menu_no_str = ltrim($sub_menu_no_str, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $permission_id_str,
				"six" => $sub_menu_no_str,
				"eight" => "Menu",
			);
			$response = $this->api->call_v_api('setPermissionLevelDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Menu Assigned successfully !!');
				redirect(get_module() . '/admin/assign_menu');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/assign_menu');
			}
			redirect(get_module() . '/admin/assign_menu');
		}
	}

	public function change_my_password()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Change My Password";


		$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|max_length[100]|matches[new_password]');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/change_password', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_type,
				"five" => $this->_user_emp_id,
				"seven" => $this->_user_id,
				"nine" => $post_data['old_password'],
				"ten" => $post_data['new_password'],
				"twelve" => "ResetPassword",
			);
			$response = $this->api->call_v_api('resetLoginDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Password Changed successfully ');
				redirect(get_module() . '/admin/change_my_password');
			} else if ($response == "Failed") {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/change_my_password');
			} else {
				$this->session->set_flashdata('error', $response);
				redirect(get_module() . '/admin/change_my_password');
			}
		}
	}

	public function change_emp_password()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Change Employee Password";
		$data['employee_list'] = $this->getEmployeeReportDetails();

		$this->form_validation->set_rules('user_id', 'Employee', 'required|trim');
		//$this->form_validation->set_rules('old_password', 'Old Password', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|max_length[100]|matches[new_password]');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/change_password', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_type,
				"five" => $this->_user_emp_id,
				"seven" => $post_data['user_id'],
				"ten" => $post_data['new_password'],
				"twelve" => "ResetPassword",
			);
			//echo "<pre/>"; print_r($params);die;		
			$response = $this->api->call_v_api('resetLoginDetails', $params);

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Password Changed successfully ');
				redirect(get_module() . '/admin/change_emp_password');
			} else if ($response == "Failed") {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/change_emp_password');
			} else {
				$this->session->set_flashdata('error', $response);
				redirect(get_module() . '/admin/change_emp_password');
			}
		}
	}
	// Employee  Master 
	public function employee_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Employee Report";
		$data['status_list'] = array("Active", "Deactivated");
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$this->loadViews(get_module() . '/admin/list_employees', $data);
	}
	// public function add_employee()
	// {
	// 	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
	// 		redirect(get_module() . '/dashboard/access_denied');
	// 	}
	// 	$data['page_title'] = "Add New Employee";
	// 	$data['action'] = "Add";
	// 	$data['permission_list'] = $this->getPermissionMasterDetails("Report");
	// 	$data['department_list'] = $this->getDepartmentMasterDetails("Report");
	// 	$data['employee_list'] = $this->getEmployeeReportDetails();
	// 	$data['education_list'] = $this->getEducationDetails("Report");
	// 	// $data['state_list']       = $this->getStateDetails("Report"); 		
	// 	$data['proof_list'] = $this->get_proof_list();

	// 	$this->form_validation->set_rules('emp_name', 'Employee Name', 'required|trim|max_length[100]');
	// 	$this->form_validation->set_rules('emp_mob1', 'Mobile No', 'required|trim|max_length[10]|min_length[10]');
	// 	// $this->form_validation->set_rules('emp_mob2','Mobile No2', 'max_length[10]|min_length[10]');
	// 	// $this->form_validation->set_rules('emp_emailid','Email Id', 'required|trim|max_length[100]|valid_email');

	// 	$this->form_validation->set_rules('emp_rpt_to', 'Reporting To', 'required|trim', array('required' => 'Select %s'));
	// 	$this->form_validation->set_rules('permission_id', 'Designation', 'required|trim', array('required' => 'Select %s'));
	// 	$this->form_validation->set_rules('department_id', 'Department', 'required|trim', array('required' => 'Select %s'));
	// 	//$this->form_validation->set_rules('sub_dept_id','Sub Department', 'required|trim');
	// 	// $this->form_validation->set_rules('emp_hst_edu_id','Education', 'required|trim', array('required' => 'Select %s'));
	// 	// $this->form_validation->set_rules('emp_edu_other_details','Education Other Details', 'required|trim|max_length[100]');
	// 	// $this->form_validation->set_rules('emp_bank_account_name','Bank Account Name', 'required|trim|max_length[100]');
	// 	// $this->form_validation->set_rules('emp_bank_accno','Enter Account No.', 'required|trim|max_length[20]');
	// 	// $this->form_validation->set_rules('emp_bank_name','Bank Name', 'required|trim|max_length[100]');
	// 	// $this->form_validation->set_rules('emp_bank_branch_addrs','Branch Address', 'required|trim|max_length[250]');
	// 	// $this->form_validation->set_rules('emp_bank_ifsc_code','IFSC Code', 'required|trim|max_length[15]|min_length[11]');

	// 	// $this->form_validation->set_rules('emp_address','Current Address', 'required|trim|max_length[300]');
	// 	// $this->form_validation->set_rules('emp_landmark','LandMark', 'max_length[50]');
	// 	// $this->form_validation->set_rules('emp_areaname','Area', 'max_length[50]');
	// 	// $this->form_validation->set_rules('emp_stateid','State', 'required|trim', array('required' => 'Select %s'));
	// 	// $this->form_validation->set_rules('emp_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');

	// 	// $this->form_validation->set_rules('emp_permaddress','Permanant Address', 'required|trim|max_length[300]');
	// 	// $this->form_validation->set_rules('emp_perm_landmark','LandMark', 'max_length[50]');
	// 	// $this->form_validation->set_rules('emp_perm_areaname','Area', 'max_length[50]');
	// 	// $this->form_validation->set_rules('emp_perm_stateid','State', 'required|trim', array('required' => 'Select %s'));
	// 	// $this->form_validation->set_rules('emp_perm_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');	

	// 	// $this->form_validation->set_rules('emp_kyc_type1','Id Proof Type', 'required|trim');
	// 	// $this->form_validation->set_rules('emp_kyc_idnum1','Id Proof No.', 'required|trim|max_length[50]');
	// 	// $this->form_validation->set_rules('emp_addrs_prf_no','Address Proof No.', 'required|trim|max_length[50]');
	// 	// $this->form_validation->set_rules('emp_addrs_prf_type','Address Proof Type', 'required|trim');

	// 	// if (empty($_FILES['emp_kyc_photo1']['name']))
	// 	// {
	// 	// 	$this->form_validation->set_rules('emp_kyc_photo1', 'Id Proof Image', 'required|trim');
	// 	// }	
	// 	// if (empty($_FILES['emp_addrs_prf_img']['name']))
	// 	// {
	// 	// 	$this->form_validation->set_rules('emp_addrs_prf_img', 'Address Proof Image', 'required|trim');
	// 	// }	
	// 	// if (empty($_FILES['emp_image']['name']))
	// 	// {
	// 	// 	$this->form_validation->set_rules('emp_image', 'Employee Image', 'required|trim');
	// 	// }					
	// 	if ($this->form_validation->run() == FALSE) {
	// 		$this->loadViews(get_module() . '/admin/add_edit_employee', $data);

	// 	} else {
	// 		// echo "<pre>";print_r("HII"); exit;	

	// 		$post_data = $this->input->post(null, true);

	// 		// Image Upload
	// 		$emp_doc_img = null;
	// 		$emp_kyc_photo1 = null;
	// 		if (!empty($_FILES['emp_kyc_photo1']['name'])) {
	// 			$ext = pathinfo($_FILES['emp_kyc_photo1']['name'], PATHINFO_EXTENSION);
	// 			$upload_params = array();
	// 			$imageFile = $_FILES['emp_kyc_photo1']['tmp_name'];
	// 			$emp_kyc_photo1 = "EMP_ID_PROOF_" . date("YmdHis") . "." . $ext;
	// 			$img_file_content = file_get_contents($imageFile);
	// 			$upload_params = array(
	// 				"one" => $this->_user_id,
	// 				"two" => $this->_user_branch_id,
	// 				"three" => $this->_user_company_id,
	// 				"four" => $emp_kyc_photo1,
	// 				"five" => base64_encode($img_file_content),
	// 				"six" => "EmployeeKYC"
	// 			);
	// 			$response = $this->api->call_v_api('uploadBitmap', $upload_params);
	// 		}

	// 		$emp_addrs_prf_img = null;
	// 		if (!empty($_FILES['emp_addrs_prf_img']['name'])) {
	// 			$ext = pathinfo($_FILES['emp_addrs_prf_img']['name'], PATHINFO_EXTENSION);
	// 			$upload_params = array();
	// 			$imageFile = $_FILES['emp_addrs_prf_img']['tmp_name'];
	// 			$emp_addrs_prf_img = "EMP_ADDRESS_PROOF_" . date("YmdHis") . "." . $ext;
	// 			$img_file_content = file_get_contents($imageFile);
	// 			$upload_params = array(
	// 				"one" => $this->_user_id,
	// 				"two" => $this->_user_branch_id,
	// 				"three" => $this->_user_company_id,
	// 				"four" => $emp_addrs_prf_img,
	// 				"five" => base64_encode($img_file_content),
	// 				"six" => "EmployeeKYC"
	// 			);
	// 			$response = $this->api->call_v_api('uploadBitmap', $upload_params);
	// 		}

	// 		$emp_image = null;
	// 		if (!empty($_FILES['emp_image']['name'])) {
	// 			$ext = pathinfo($_FILES['emp_image']['name'], PATHINFO_EXTENSION);
	// 			$upload_params = array();
	// 			$imageFile = $_FILES['emp_image']['tmp_name'];
	// 			$emp_image = "EMP_IMAGE_" . date("YmdHis") . "." . $ext;
	// 			$img_file_content = file_get_contents($imageFile);
	// 			$upload_params = array(
	// 				"one" => $this->_user_id,
	// 				"two" => $this->_user_branch_id,
	// 				"three" => $this->_user_company_id,
	// 				"four" => $emp_image,
	// 				"five" => base64_encode($img_file_content),
	// 				"six" => "Employee"
	// 			);
	// 			$response = $this->api->call_v_api('uploadBitmap', $upload_params);
	// 		}

	// 		$params = array(
	// 			"one" => $this->_user_id,
	// 			"two" => $this->_user_branch_id,
	// 			"three" => $this->_user_company_id,
	// 			"four" => $this->_user_emp_id,
	// 			"five" => $post_data['emp_name'],
	// 			"six" => $post_data['emp_mob1'],
	// 			"seven" => $post_data['emp_mob2'],
	// 			"eight" => $post_data['emp_emailid'],
	// 			"nine" => $post_data['emp_address'],
	// 			"ten" => $post_data['emp_stateid'],
	// 			"eleven" => $post_data['emp_distid'],
	// 			"twelve" => $post_data['emp_cityid'],
	// 			"thirteen" => $post_data['emp_areaname'],
	// 			"fourteen" => $post_data['emp_landmark'],
	// 			"fifteen" => $post_data['emp_pincode'],
	// 			"sixteen" => $post_data['emp_permaddress'],
	// 			"seventeen" => $post_data['emp_perm_stateid'],
	// 			"eighteen" => $post_data['emp_perm_distid'],
	// 			"nineteen" => $post_data['emp_perm_cityid'],
	// 			"twenty" => $post_data['emp_perm_areaname'],
	// 			"twentyone" => $post_data['emp_perm_landmark'],
	// 			"twentytwo" => $post_data['emp_perm_pincode'],
	// 			"twentythree" => $emp_image,
	// 			"twentyfour" => $emp_doc_img,
	// 			"twentyfive" => $post_data['emp_hst_edu_id'],
	// 			"twentysix" => $post_data['emp_edu_other_details'],
	// 			"twentyseven" => $post_data['emp_kyc_type1'],
	// 			"twentyeight" => $post_data['emp_kyc_idnum1'],
	// 			"twentynine" => $emp_kyc_photo1,
	// 			"thirty" => Null,//$post_data['emp_kyc_type2'],
	// 			"thirtyone" => Null,//$post_data['emp_kyc_idnum2'],
	// 			"thirtytwo" => $emp_addrs_prf_img,
	// 			"thirtythree" => $post_data['emp_addrs_prf_type'],
	// 			"thirtyfour" => $post_data['emp_addrs_prf_no'],
	// 			"thirtyfive" => $emp_addrs_prf_img,
	// 			"thirtysix" => $post_data['emp_bank_account_name'],
	// 			"thirtyseven" => $post_data['emp_bank_name'],
	// 			"thirtyeight" => $post_data['emp_bank_branch_addrs'],
	// 			"thirtynine" => Null,//$post_data['emp_bank_chq_micr_code'],
	// 			"fourty" => $post_data['emp_bank_accno'],
	// 			"fourtyone" => $post_data['emp_bank_ifsc_code'],
	// 			"fourtytwo" => $post_data['permission_id'],
	// 			"fourtythree" => $post_data['department_id'],
	// 			"fourtyfour" => $post_data['sub_dept_id'],
	// 			"fourtyfive" => Null,//$post_data['emp_perm_type'],
	// 			"fourtysix" => $post_data['emp_rpt_to'],
	// 			"fourtyseven" => Null,//$post_data['emp_recruit_by'],
	// 			"fourtyeight" => Null,//$post_data['emp_serviceid'],
	// 			"fourtynine" => $post_data['emp_state'],
	// 			"fifty" => $post_data['emp_dist'],
	// 			"fiftyone" => $post_data['emp_city'],
	// 			"fiftytwo" => $post_data['emp_perm_state'],
	// 			"fiftythree" => $post_data['emp_perm_dist'],
	// 			"fiftyfour" => $post_data['emp_perm_city'],
	// 		);

	// 		//echo "<pre>";print_r($params); exit;	
	// 		//echo "<pre>"; print_r($post_data); exit;


	// 		//log_message('debug', 'Calling setEmployeeDetails API...');
	// 		$response = $this->api->call_v_api('setEmployeeDetails', $params);
	// 		//log_message('debug', 'API Response: ' . print_r($response, true));

	// 		if ($response == "Success") {
	// 			$this->session->set_flashdata('success', 'New Employee Added successfully !!');
	// 			redirect(get_module() . '/admin/employee_report');

	// 		} else {
	// 			$this->session->set_flashdata('error', ERROR_MESSAGE);
	// 			redirect(get_module() . '/admin/employee_report');
	// 		}
	// 	}

	// }
	public function add_employee()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Employee";
		$data['action'] = "Add";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$data['employee_list'] = $this->getEmployeeReportDetails();
		$data['education_list'] = $this->getEducationDetails("Report");
		// $data['state_list']       = $this->getStateDetails("Report"); 		
		$data['proof_list'] = $this->get_proof_list();
		//add by ritika
		$old_input = $this->session->flashdata('old_input');

		if (!empty($old_input)) {
			$data['details'] = $old_input;
		}

		$this->form_validation->set_rules('emp_name', 'Employee Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('emp_mob1', 'Mobile No', 'required|trim|max_length[10]|min_length[10]');
		// $this->form_validation->set_rules('emp_mob2','Mobile No2', 'max_length[10]|min_length[10]');

		//$this->form_validation->set_rules('emp_emailid','Email Id', 'required|trim|max_length[100]|valid_email');
		//$this->form_validation->set_rules('emp_emailid','Email Id', 'required|trim|max_length[100]|valid_email');
		$this->form_validation->set_rules(
			'emp_emailid',
			'Email Id',
			'trim|valid_email|max_length[100]',
			array(
				'valid_email' => 'Please enter valid Email Id.'
			)
		);


		$this->form_validation->set_rules('location_tracking', 'Location Tracking', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('emp_rpt_to', 'Reporting To', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('permission_id', 'Designation', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('department_id', 'Department', 'required|trim', array('required' => 'Select %s'));
		//$this->form_validation->set_rules('sub_dept_id','Sub Department', 'required|trim');
		// $this->form_validation->set_rules('emp_hst_edu_id','Education', 'required|trim', array('required' => 'Select %s'));
		// $this->form_validation->set_rules('emp_edu_other_details','Education Other Details', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('emp_bank_account_name','Bank Account Name', 'required|trim|max_length[100]');
		//	 $this->form_validation->set_rules('emp_bank_accno','Enter Account No.', 'required|trim|max_length[20]');
		$this->form_validation->set_rules(
			'emp_bank_accno',
			'Account Number',
			'trim|numeric|min_length[9]|max_length[18]',
			array(
				'numeric' => 'Account Number must contain only numbers.',
				'min_length' => 'Account Number must be minimum 9 digits.',
				'max_length' => 'Account Number cannot exceed 18 digits.'
			)
		);
		// $this->form_validation->set_rules('emp_bank_name','Bank Name', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('emp_bank_branch_addrs','Branch Address', 'required|trim|max_length[250]');
		// $this->form_validation->set_rules('emp_bank_ifsc_code','IFSC Code', 'required|trim|max_length[15]|min_length[11]');

		// $this->form_validation->set_rules('emp_address','Current Address', 'required|trim|max_length[300]');
		// $this->form_validation->set_rules('emp_landmark','LandMark', 'max_length[50]');
		// $this->form_validation->set_rules('emp_areaname','Area', 'max_length[50]');
		// $this->form_validation->set_rules('emp_stateid','State', 'required|trim', array('required' => 'Select %s'));
		// $this->form_validation->set_rules('emp_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');
		$this->form_validation->set_rules(
			'emp_pincode',
			'Pincode',
			'trim|numeric|exact_length[6]',
			array(
				'numeric' => 'Pincode must contain only numbers.',
				'exact_length' => 'Pincode must be exactly 6 digits.'
			)
		);
		// $this->form_validation->set_rules('emp_permaddress','Permanant Address', 'required|trim|max_length[300]');
		// $this->form_validation->set_rules('emp_perm_landmark','LandMark', 'max_length[50]');
		// $this->form_validation->set_rules('emp_perm_areaname','Area', 'max_length[50]');
		// $this->form_validation->set_rules('emp_perm_stateid','State', 'required|trim', array('required' => 'Select %s'));
		// $this->form_validation->set_rules('emp_perm_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');	

		// $this->form_validation->set_rules('emp_kyc_type1','Id Proof Type', 'required|trim');
		// $this->form_validation->set_rules('emp_kyc_idnum1','Id Proof No.', 'required|trim|max_length[50]');
		// $this->form_validation->set_rules('emp_addrs_prf_no','Address Proof No.', 'required|trim|max_length[50]');
		// $this->form_validation->set_rules('emp_addrs_prf_type','Address Proof Type', 'required|trim');

		// if (empty($_FILES['emp_kyc_photo1']['name']))
		// {
		// 	$this->form_validation->set_rules('emp_kyc_photo1', 'Id Proof Image', 'required|trim');
		// }	
		// if (empty($_FILES['emp_addrs_prf_img']['name']))
		// {
		// 	$this->form_validation->set_rules('emp_addrs_prf_img', 'Address Proof Image', 'required|trim');
		// }	
		// if (empty($_FILES['emp_image']['name']))
		// {
		// 	$this->form_validation->set_rules('emp_image', 'Employee Image', 'required|trim');
		// }					
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/add_edit_employee', $data);
		} else {
			// echo "<pre>";print_r("HII"); exit;	

			$post_data = $this->input->post(null, true);
			// The current employee form no longer posts the legacy state/district/city
			// dropdown IDs and most profile sections are optional. Keep the demo flow
			// compatible with both versions of the form without emitting undefined-key
			// warnings when those optional values are omitted.
			$post_value = function ($key, $default = '') use ($post_data) {
				return isset($post_data[$key]) ? $post_data[$key] : $default;
			};
			// ritika added this for multiline emp name 
			$post_data['emp_name'] = preg_replace('/[\r\n]+/', ' ', trim($post_data['emp_name']));

			// Image Upload
			$emp_doc_img = null;
			$emp_kyc_photo1 = null;
			if (!empty($_FILES['emp_kyc_photo1']['name'])) {
				$ext = pathinfo($_FILES['emp_kyc_photo1']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_kyc_photo1']['tmp_name'];
				$emp_kyc_photo1 = "EMP_ID_PROOF_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_kyc_photo1,
					"five" => base64_encode($img_file_content),
					"six" => "EmployeeKYC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$emp_addrs_prf_img = null;
			if (!empty($_FILES['emp_addrs_prf_img']['name'])) {
				$ext = pathinfo($_FILES['emp_addrs_prf_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_addrs_prf_img']['tmp_name'];
				$emp_addrs_prf_img = "EMP_ADDRESS_PROOF_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_addrs_prf_img,
					"five" => base64_encode($img_file_content),
					"six" => "EmployeeKYC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$emp_image = null;
			if (!empty($_FILES['emp_image']['name'])) {
				$ext = pathinfo($_FILES['emp_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_image']['tmp_name'];
				$emp_image = "EMP_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_image,
					"five" => base64_encode($img_file_content),
					"six" => "Employee"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$emp_dob = $this->input->post('emp_dob');
			$emp_joining_date = $this->input->post('emp_joining_date');

			$emp_dob = !empty($emp_dob)
				? date('d-m-Y', strtotime($emp_dob))
				: NULL;

			$emp_joining_date = !empty($emp_joining_date)
				? date('d-m-Y', strtotime($emp_joining_date))
				: NULL;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['emp_name'],
				"six" => $post_data['emp_mob1'],
				"seven" => $post_value('emp_mob2'),
				"eight" => $post_value('emp_emailid'),
				"nine" => $post_value('emp_address'),
				"ten" => $post_value('emp_stateid'),
				"eleven" => $post_value('emp_distid'),
				"twelve" => $post_value('emp_cityid'),
				"thirteen" => $post_value('emp_areaname'),
				"fourteen" => $post_value('emp_landmark'),
				"fifteen" => $post_value('emp_pincode'),
				"sixteen" => $post_value('emp_permaddress'),
				"seventeen" => $post_value('emp_perm_stateid'),
				"eighteen" => $post_value('emp_perm_distid'),
				"nineteen" => $post_value('emp_perm_cityid'),
				"twenty" => $post_value('emp_perm_areaname'),
				"twentyone" => $post_value('emp_perm_landmark'),
				"twentytwo" => $post_value('emp_perm_pincode'),
				"twentythree" => $emp_image,
				"twentyfour" => $emp_doc_img,
				"twentyfive" => $post_value('emp_hst_edu_id'),
				"twentysix" => $post_value('emp_edu_other_details'),
				"twentyseven" => $post_value('emp_kyc_type1'),
				"twentyeight" => $post_value('emp_kyc_idnum1'),
				"twentynine" => $emp_kyc_photo1,
				"thirty" => Null, //$post_data['emp_kyc_type2'],
				"thirtyone" => Null, //$post_data['emp_kyc_idnum2'],
				"thirtytwo" => $emp_addrs_prf_img,
				"thirtythree" => $post_value('emp_addrs_prf_type'),
				"thirtyfour" => $post_value('emp_addrs_prf_no'),
				"thirtyfive" => $emp_addrs_prf_img,
				"thirtysix" => $post_value('emp_bank_account_name'),
				"thirtyseven" => $post_value('emp_bank_name'),
				"thirtyeight" => $post_value('emp_bank_branch_addrs'),
				"thirtynine" => Null, //$post_data['emp_bank_chq_micr_code'],
				"fourty" => $post_value('emp_bank_accno'),
				"fourtyone" => $post_value('emp_bank_ifsc_code'),
				"fourtytwo" => $post_data['permission_id'],
				"fourtythree" => $post_data['department_id'],
				"fourtyfour" => $post_value('sub_dept_id'),
				"fourtyfive" => Null, //$post_data['emp_perm_type'],
				"fourtysix" => $post_data['emp_rpt_to'],
				"fourtyseven" => Null, //$post_data['emp_recruit_by'],
				"fourtyeight" => Null, //$post_data['emp_serviceid'],
				"fourtynine" => $post_value('emp_state'),
				"fifty" => $post_value('emp_dist'),
				"fiftyone" => $post_value('emp_city'),
				"fiftytwo" => $post_value('emp_perm_state'),
				"fiftythree" => $post_value('emp_perm_dist'),
				"fiftyfour" => $post_value('emp_perm_city'),
				"fiftyfive" => $post_data['location_tracking'],
				"fiftysix" => $emp_joining_date,
				"fiftyseven" => $emp_dob
			);

			// echo "<pre>";print_r($params); exit;	
			//echo "<pre>"; print_r($post_data); exit;


			//log_message('debug', 'Calling setEmployeeDetails API...');

			//add by ritika 18 june 

			// $response = $this->api->call_v_api('setEmployeeDetails', $params);
			$response = trim($this->api->call_v_api('setEmployeeDetails', $params));
			// 			echo "<pre>";
			// var_dump($response);
			// exit;
			// echo $response;
			// die();

			// if ($response == "MOBILE_EXISTS") {
			// 	// $this->session->set_flashdata('error', 'Mobile Number Already Exists');
			// 	$this->session->set_flashdata('mobile_error', 'Mobile Number Already Exists');
			// 	redirect(get_module() . '/admin/add_employee');
			// 	return;
			// }
			// 		$this->session->set_flashdata(
			// 	'old_input',
			// 	$this->input->post()
			// );

			if ($response == "MOBILE_EXISTS") {

				$this->session->set_flashdata(
					'old_input',
					$this->input->post()
				);

				$this->session->set_flashdata(
					'mobile_error',
					'Mobile Number Already Exists'
				);

				redirect(get_module() . '/admin/add_employee');
				return;
			}

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Employee Added successfully !!');
				redirect(get_module() . '/admin/employee_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/employee_report');
			}
		}
	}

	//add by ritika

	public function check_employee_mobile()
	{
		$params = array();
		$params['one'] = $this->input->post('mobile');

		echo trim(
			$this->api->call_v_api(
				'checkEmployeeMobile',
				$params
			)
		);
	}
	public function edit_employee()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['page_title'] = "Update Employee Details";
		$data['action'] = "Edit";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$data['employee_list'] = $this->getEmployeeReportDetails();
		$data['education_list'] = $this->getEducationDetails("Report");
		$data['state_list'] = $this->getStateDetails("Report");
		$data['proof_list'] = $this->get_proof_list();
		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getEmployeeDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['details'] = $details[0];
		$dept_id = $details[0]['emp_departmentid'];
		$state_id = $details[0]['state_id'];
		$city_id = $details[0]['city_id'];
		$dist_id = $details[0]['dist_id'];
		$emp_perm_stateid = $details[0]['emp_perm_stateid'];
		$emp_perm_distid = $details[0]['emp_perm_distid'];
		$emp_perm_cityid = $details[0]['emp_perm_cityid'];

		$data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		if (!empty($dist_id)) {
			$data['city_list'] = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
		}

		$data['per_dist_list'] = $this->getDistrictStateIdDetails($emp_perm_stateid, "Report");
		if (!empty($emp_perm_distid)) {
			$data['per_city_list'] = $this->getCityDistrictIdDetails($emp_perm_stateid, $emp_perm_distid, "Report");
		}
		$data['sub_department_list'] = $this->getSubdepartmentDeptIdDetails($dept_id, "Report");


		$this->form_validation->set_rules('emp_name', 'Employee Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('emp_mob1', 'Mobile No', 'required|trim|max_length[10]|min_length[10]');
		// $this->form_validation->set_rules('emp_mob2','Mobile No2', 'max_length[10]|min_length[10]');
		// $this->form_validation->set_rules('emp_emailid','Email Id', 'required|trim|max_length[100]|valid_email');

		$this->form_validation->set_rules(
			'emp_emailid',
			'Email Id',
			'trim|valid_email|max_length[100]',
			array(
				'valid_email' => 'Please enter valid Email Id.'
			)
		);
		$this->form_validation->set_rules('emp_rpt_to', 'Reporting To', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('permission_id', 'Designation', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('department_id', 'Department', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('location_tracking', 'Location Tracking', 'required|trim', array('required' => 'Select %s'));
		//$this->form_validation->set_rules('sub_dept_id','Sub Department', 'required|trim');
		// $this->form_validation->set_rules('emp_hst_edu_id','Education', 'required|trim', array('required' => 'Select %s'));
		// $this->form_validation->set_rules('emp_edu_other_details','Education Other Details', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('emp_bank_account_name','Bank Account Name', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('emp_bank_accno','Enter Account No.', 'required|trim|max_length[20]');
		$this->form_validation->set_rules(
			'emp_bank_accno',
			'Account Number',
			'trim|numeric|min_length[9]|max_length[18]',
			array(
				'numeric' => 'Account Number must contain only numbers.',
				'min_length' => 'Account Number must be minimum 9 digits.',
				'max_length' => 'Account Number cannot exceed 18 digits.'
			)
		);		// $this->form_validation->set_rules('emp_bank_name','Bank Name', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('emp_bank_branch_addrs','Branch Address', 'required|trim|max_length[250]');
		// $this->form_validation->set_rules('emp_bank_ifsc_code','IFSC Code', 'required|trim|max_length[15]|min_length[11]');

		// $this->form_validation->set_rules('emp_address','Current Address', 'required|trim|max_length[300]');
		// $this->form_validation->set_rules('emp_landmark','LandMark', 'max_length[50]');
		// $this->form_validation->set_rules('emp_areaname','Area', 'max_length[50]');
		// $this->form_validation->set_rules('emp_stateid','State', 'required|trim');
		//$this->form_validation->set_rules('emp_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');

		$this->form_validation->set_rules(
			'emp_pincode',
			'Pincode',
			'trim|numeric|exact_length[6]',
			array(
				'numeric' => 'Pincode must contain only numbers.',
				'exact_length' => 'Pincode must be exactly 6 digits.'
			)
		);

		// $this->form_validation->set_rules('emp_permaddress','Permanant Address', 'required|trim|max_length[300]');
		// $this->form_validation->set_rules('emp_perm_landmark','LandMark', 'max_length[50]');
		// $this->form_validation->set_rules('emp_perm_areaname','Area', 'max_length[50]');
		// $this->form_validation->set_rules('emp_perm_stateid','State', 'required|trim');
		// $this->form_validation->set_rules('emp_perm_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]');	

		// $this->form_validation->set_rules('emp_kyc_type1','Id Proof Type', 'required|trim');
		// $this->form_validation->set_rules('emp_kyc_idnum1','Id Proof No.', 'required|trim|max_length[50]');
		// $this->form_validation->set_rules('emp_addrs_prf_no','Address Proof No.', 'required|trim|max_length[50]');
		// $this->form_validation->set_rules('emp_addrs_prf_type','Address Proof Type', 'required|trim');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/add_edit_employee', $data);
		} else {
			$post_data = $this->input->post(null, true);
			// ritika added this for multiline emp name 
			$post_data['emp_name'] = preg_replace('/[\r\n]+/', ' ', trim($post_data['emp_name']));

			// Image Upload
			$emp_doc_img = null;

			$old_emp_kyc_photo1 = $data['details']['empKycList'][0]['emp_kyc_photo1'];
			$old_emp_kyc_photo1 = explode("/", $old_emp_kyc_photo1);
			$emp_kyc_photo1 = $old_emp_kyc_photo1[count($old_emp_kyc_photo1) - 1];

			if (!empty($_FILES['emp_kyc_photo1']['name'])) {
				$ext = pathinfo($_FILES['emp_kyc_photo1']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_kyc_photo1']['tmp_name'];
				$emp_kyc_photo1 = "EMP_ID_PROOF_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_kyc_photo1,
					"five" => base64_encode($img_file_content),
					"six" => "EmployeeKYC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$old_emp_addrs_prf_img = $data['details']['empKycList'][0]['emp_addrs_prf_img'];
			$old_emp_addrs_prf_img = explode("/", $old_emp_addrs_prf_img);
			$emp_addrs_prf_img = $old_emp_addrs_prf_img[count($old_emp_addrs_prf_img) - 1];
			if (!empty($_FILES['emp_addrs_prf_img']['name'])) {
				$ext = pathinfo($_FILES['emp_addrs_prf_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_addrs_prf_img']['tmp_name'];
				$emp_addrs_prf_img = "EMP_ADDRESS_PROOF_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_addrs_prf_img,
					"five" => base64_encode($img_file_content),
					"six" => "EmployeeKYC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$old_emp_image = $data['details']['emp_image_path'];
			$old_emp_image = explode("/", $old_emp_image);
			$emp_image = $old_emp_image[count($old_emp_image) - 1];

			if (!empty($_FILES['emp_image']['name'])) {
				$ext = pathinfo($_FILES['emp_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['emp_image']['tmp_name'];
				$emp_image = "EMP_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $emp_image,
					"five" => base64_encode($img_file_content),
					"six" => "Employee"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$emp_dob = $this->input->post('emp_dob');
			$emp_joining_date = $this->input->post('emp_joining_date');

			$emp_dob = !empty($emp_dob)
				? date('d-m-Y', strtotime($emp_dob))
				: NULL;

			$emp_joining_date = !empty($emp_joining_date)
				? date('d-m-Y', strtotime($emp_joining_date))
				: NULL;


			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['id'],
				"six" => $post_data['emp_name'],
				"seven" => $post_data['emp_mob1'],
				"eight" => $post_data['emp_mob2'],
				"nine" => $post_data['emp_emailid'],
				"ten" => $post_data['emp_address'],
				"eleven" => $post_data['emp_stateid'],
				"twelve" => $post_data['emp_distid'],
				"thirteen" => $post_data['emp_cityid'],
				"fourteen" => $post_data['emp_areaname'],
				"fifteen" => $post_data['emp_landmark'],
				"sixteen" => $post_data['emp_pincode'],
				"seventeen" => $post_data['emp_permaddress'],
				"eighteen" => $post_data['emp_perm_stateid'],
				"nineteen" => $post_data['emp_perm_distid'],
				"twenty" => $post_data['emp_perm_cityid'],
				"twentyone" => $post_data['emp_perm_areaname'],
				"twentytwo" => $post_data['emp_perm_landmark'],
				"twentythree" => $post_data['emp_perm_pincode'],
				"twentyfour" => $emp_image,
				"twentyfive" => $emp_doc_img,
				"twentysix" => $post_data['emp_hst_edu_id'],
				"twentyseven" => $post_data['emp_edu_other_details'],
				"twentyeight" => $post_data['emp_kyc_type1'],
				"twentynine" => $post_data['emp_kyc_idnum1'],
				"thirty" => $emp_kyc_photo1,
				"thirtyone" => Null, //$post_data['emp_kyc_type2'],
				"thirtytwo" => Null, //$post_data['emp_kyc_idnum2'],
				"thirtythree" => $emp_addrs_prf_img,
				"thirtyfour" => $post_data['emp_addrs_prf_type'],
				"thirtyfive" => $post_data['emp_addrs_prf_no'],
				"thirtysix" => $emp_addrs_prf_img,
				"thirtyseven" => $post_data['emp_bank_account_name'],
				"thirtyeight" => $post_data['emp_bank_name'],
				"thirtynine" => $post_data['emp_bank_branch_addrs'],
				"fourty" => Null, //$post_data['emp_bank_chq_micr_code'],
				"fourtyone" => $post_data['emp_bank_accno'],
				"fourtytwo" => $post_data['emp_bank_ifsc_code'],
				"fourtythree" => $post_data['permission_id'],
				"fourtyfour" => $post_data['department_id'],
				"fourtyfive" => $post_data['sub_dept_id'],
				"fourtysix" => Null, //$post_data['emp_perm_type'],
				"fourtyseven" => $post_data['emp_rpt_to'],
				"fourtyeight" => Null, //$post_data['emp_recruit_by'],
				"fourtynine" => Null, //$post_data['emp_serviceid'],
				"fifty" => $post_data['location_tracking'],
				"fiftyone" => $emp_joining_date,
				"fiftytwo" => $emp_dob
			);
			//add by ritika on 20 june 26 
			$checkParams = array(
				"one" => $post_data['emp_mob1'], // mobile
				"two" => $id,                 // employee id
				"three" => $this->_user_company_id, // companyId
				"four" => $this->_user_branch_id  // branchId
			);

			$mobileCheck = trim(
				$this->api->call_v_api(
					'checkEmployeeMobileForEdit',
					$checkParams
				)
			);

			if ($mobileCheck == "MOBILE_EXISTS") {

				$this->session->set_flashdata(
					'mobile_error',
					'Mobile Number Already Exists'
				);

				redirect(
					get_module() . '/admin/edit_employee/?id=' .
					base64_encode($id)
				);

				return;
			}
			// echo "<pre>";

			// echo "EMP ID = " . $emp_id . "<br>";
			// echo "MOBILE = " . $emp_mob1 . "<br>";

			// echo "<pre>"; print_r($params); exit;
			$response = $this->api->call_v_api('setModifyEmployeeDetails', $params);
			//log_message("error",json_encode($response));
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Employee Details Updated successfully !!');
				redirect(get_module() . '/admin/employee_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/employee_report');
			}
		}
	}

	public function view_employee()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['page_title'] = "View Employee Details";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getEmployeeDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['details'] = $details[0];
		$this->loadViews(get_module() . '/admin/view_employee', $data);
	}

	public function deactivate_employee()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['page_title'] = "Deactivate Employee";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_employee";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('admin/deactivation_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => "Deactivated",
				"seven" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateEmployeeDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Employee Deactivated successfully ');
				redirect(get_module() . '/admin/employee_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/employee_report');
			}
		}
	}

	public function reactivate_employee()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Employee Details not found');
			redirect(get_module() . '/admin/employee_report');
		}
		$data['page_title'] = "Re-Activate Employee";
		$data['ref_id'] = $ref_id;
		$data['action'] = "reactivate_employee";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('admin/activation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateEmployeeDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Employee Re-Activated successfully ');
				redirect(get_module() . '/admin/employee_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/employee_report');
			}
		}
	}

	public function download_file($file = Null, $fileName = Null)
	{
		$this->load->helper('download');
		$file = APK_URL;
		$data = file_get_contents($file);
		force_download($fileName, $data);
	}

	public function download_emp_report()
	{
		$permission_id = $this->input->post('permission_id');
		$department_id = $this->input->post('department_id');
		$sub_dept_id = $this->input->post('sub_dept_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr = $this->input->post('searchStr');
		$searchStr = addslashes($searchStr);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"eight" => $department_id,
			"nine" => $sub_dept_id,
		);
		$result = $this->api->call_v_api('downloadEmployeeMasterDetails', $params);

		// download file
		header('Content-Disposition: attachment; filename="Employee_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}
	// Employee Location  Master 
	public function emp_location_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Employee Location Report";
		$data['employee_list'] = $this->getEmployeeReportDetails();
		//   echo "<pre>";print_r($data); exit;
		$this->loadViews(get_module() . '/admin/list_employee_locations', $data);
	}

	// Employee Attendence Report

	public function emp_attendance_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Employee Attendance Report";

		$data['employee_list'] = $this->getEmployeeReportDetails();
		$this->loadViews(get_module() . '/admin/list_employee_attendance', $data);
	}

	public function employee_attendance()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Mark Employee Report";
		$data['status_list'] = array("Active", "Deactivated");
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		$this->loadViews(get_module() . '/admin/mark_employee_attendance', $data);

	}
	// Login popup functionality 
	public function login_popup()
	{
		// if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		// 	redirect(get_module().'/dashboard/access_denied');
		// }

		$data['id'] = $this->input->get("id");

		// echo "<pre/>"; print_r($id);die;

		$this->load->view(get_module() . '/admin/login_popup', $data);

	}

	// Login popup functionality 
	public function save_login_entry()
	{
		// if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		// 	redirect(get_module().'/dashboard/access_denied');
		// }
		$id = $this->input->get("id");
		$id = base64_decode($id);


		$post_data = $this->input->post(null, true);


		$login_date = !empty($post_data['login_date']) ? $post_data['login_date'] : Null;
		$login_time = !empty($post_data['login_time']) ? $post_data['login_time'] : Null;


		$from_date = null;
		if ($login_date && $login_time) {
			// $from_date = $login_date . ' ' . $login_time; // e.g., "2025-04-11 18:20"
			$from_date = $login_date . ' ' . $login_time . ':00'; // e.g., "2025-04-11 18:20:00"
			// $from_date = $datetime->format('Y-m-d H:i:s');
		}
		// echo "<pre/>"; print_r($from_date);die;
		$params = array(
			"one" => $id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"six" => $from_date

		);
		// echo "<pre/>"; print_r($id);
		// echo "<pre/>"; print_r($login_date);
		// echo "<pre/>"; print_r($login_time);
		// echo "<pre/>"; print_r($from_date);die;
		$result = $this->api->call_v_api('setAttendanceDetailsManually', $params);

		// echo "<pre/>"; print_r($result);die;
		if ($result == "Success") {
			$this->session->set_flashdata('success', 'Attendance Added successfully !!');
			// $this->load(get_module().'/admin/mark_employee_attendance',$data);
			redirect(get_module() . '/admin/employee_attendance');

		} else if($result == "ALREADY_LOGGED_IN"){
			$this->session->set_flashdata('error', 'Already Attendance Added !!');
			// $this->load(get_module().'/admin/mark_employee_attendance',$data);
			redirect(get_module() . '/admin/employee_attendance');

		}else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			// $this->load(get_module().'/admin/mark_employee_attendance',$data);
			redirect(get_module() . '/admin/employee_attendance');
		}
	}

	// Login popup functionality 
	public function logout_popup()
	{
		// if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		// 	redirect(get_module().'/dashboard/access_denied');
		// }

		$data['id'] = $this->input->get("id");

		$this->load->view(get_module() . '/admin/logout_popup', $data);

	}

	// Login popup functionality 
	public function save_logout_entry()
	{
		// if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		// 	redirect(get_module().'/dashboard/access_denied');
		// }
		$id = $this->input->get("id");
		$id = base64_decode($id);


		$post_data = $this->input->post(null, true);


		$login_date = !empty($post_data['logout_date']) ? $post_data['logout_date'] : Null;
		$login_time = !empty($post_data['logout_time']) ? $post_data['logout_time'] : Null;


		$from_date = null;
		if ($login_date && $login_time) {
			// $from_date = $login_date . ' ' . $login_time; // e.g., "2025-04-11 18:20"
			$from_date = $login_date . ' ' . $login_time . ':00'; // e.g., "2025-04-11 18:20:00"
			// $from_date = $datetime->format('Y-m-d H:i:s');
		}
		// echo "<pre/>"; print_r($from_date);die;
		$params = array(
			"one" => $id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"six" => $from_date

		);
		// echo "<pre/>"; print_r($id);
		// echo "<pre/>"; print_r($login_date);
		// echo "<pre/>"; print_r($login_time);
		// echo "<pre/>"; print_r($from_date);die;
		$result = $this->api->call_v_api('updateAttendanceDetails', $params);

		// echo "<pre/>"; print_r($result);die;

		if ($result == "Success") {
			$this->session->set_flashdata('success', 'Attendance Added successfully !!');
			// $this->load(get_module().'/admin/mark_employee_attendance',$data);
			redirect(get_module() . '/admin/employee_attendance');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			// $this->load(get_module().'/admin/mark_employee_attendance',$data);
			redirect(get_module() . '/admin/employee_attendance');
		}

	}

	// public function download_emp_attendance_report()
	// {	
	// 	$emp_id  			= $this->input->post('emp_id');
	// 	$date        		= $this->input->post('date');
	// 	$month_year        	= $this->input->post('month_year');
	// 	$sub_dept_id          = $this->input->post('sub_dept_id');
	// 	$status               = $this->input->post('status');
	// 	$status               = $status?$status:"";		
	// 	$searchStr            = $this->input->post('searchStr');
	// 	$searchStr            = addslashes($searchStr);	

	// 	$date          = !empty($date)?strtoupper(date("d-M-Y",strtotime($date))):strtoupper(date("d-M-Y"));


	// 		   if (!empty($month_year)) {
	// 			$date = null;
	// 			}

	// 			$params = array("one"=>$this->_user_id,
	// 			"two"=>$this->_user_branch_id,
	// 			"three"=>$this->_user_company_id,
	// 			"four"=>$emp_id,
	// 			"five"=>$date,
	// 			"six"=>$month_year,
	// 			);
	// 	$result = $this->api->call_v_api('DownloadExcelAttendanceDetails',$params);

	// 	// download file
	// 	header('Content-Disposition: attachment; filename="Employee_Attendance_Report_'.Date("Y-m-d-h-i-s").'.xlsx"');
	// 	header("Content-Type: text/csv");		
	// 	echo ($result);

	// }

	public function download_emp_attendance_report()
	{
		$emp_id = $this->input->post('emp_id');
		$date = $this->input->post('date');
		$month_year = $this->input->post('month_year');
		$sub_dept_id = $this->input->post('sub_dept_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr = $this->input->post('searchStr');
		$searchStr = addslashes($searchStr);

		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : strtoupper(date("d-M-Y"));

		if (!empty($month_year)) {
			$date = null;
		}

		if (!empty($month_year) && !empty($emp_id)) {
			$date = null;
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $emp_id,
				"five" => $date,
				"six" => $month_year,
			);
			$result = $this->api->call_v_api('DownloadExcelAttendanceDetailsMonthly', $params);
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $emp_id,
				"five" => $date,
				"six" => $month_year,
			);
			$result = $this->api->call_v_api('DownloadExcelAttendanceDetails', $params);
		}


		// download file
		header('Content-Disposition: attachment; filename="Employee_Attendance_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}


	// 2 Step Verification  Master 
	public function two_step_verification_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Two Step Verification Report";
		$this->loadViews(get_module() . '/admin/list_two_step_verification', $data);
	}

	public function add_two_step_verification()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add Two Step Verification";
		$data['action'] = "Add";
		$this->form_validation->set_rules('lad_auth', 'Two Step Verification', 'required|trim|max_length[5]');
		$this->form_validation->set_rules('mobile_no', 'Contact Number', 'max_length[10]|min_length[10]|numeric');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/admin/add_two_step_verification', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $post_data['lad_auth'],
				"five" => $post_data['mobile_no'],
			);
			$response = $this->api->call_v_api('setLoginAuthenticationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Two Step Verification Details Added successfully !!');
				redirect(get_module() . '/admin/two_step_verification_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/two_step_verification_report');
			}
		}
	}
	//WP/SMS Report

	public function sms_email_report($page = 1)
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Email / WhatsApp Report";
		$searchStr = $this->input->get('searchStr');
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$this->loadViews(get_module() . '/admin/list_whatsapp_report', $data);
	}

	public function send_sms_email()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Send SMS Or Email";
		$data['action'] = "Send";
		//ritika added here on 16 june

		//	$data['service_type_list'] = $this->getServiceList();

		$this->form_validation->set_rules('em_type', 'Send SMS/EMail ', 'required|trim|max_length[15]');
		$em_type = $this->input->post("em_type");
		// ritika added
		// if ($em_type == "WhatsApp") {
		// 	$this->form_validation->set_rules('wpmsg','WhatsApp Message','required|trim|max_length[1000]');
		// }

		if ($em_type == "WhatsApp") {

			if (empty($this->input->post('wpmobile_nos'))) {
				$data['lead_customer_error'] = 'Please select at least one Lead/Customer.';
			}

			$this->form_validation->set_rules(
				'wpmsg',
				'WhatsApp Message',
				'required|trim|max_length[1000]'
			);
		}


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
			$this->loadViews(get_module() . '/admin/send_sms_email', $data);
		} else {


			$wp_noti_img = null;


			$post_data = $this->input->post(null, true);


			if (!empty($_FILES['wp_noti_img']['name'])) {
				$ext = pathinfo($_FILES['wp_noti_img']['name'], PATHINFO_EXTENSION);
				$imageFile = $_FILES['wp_noti_img']['tmp_name'];
				$wp_noti_img = "WP_NOTI_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $wp_noti_img,
					"five" => base64_encode($img_file_content),
					"six" => "WhatsAppImg"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}


			// echo "<pre/>"; ;
			// echo "<pre/>";
			// print_r($imageFile);
			// echo "HELLOOO";
			// die;


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

	public function edit_my_account()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->_user_company_id;

		if ($this->_role_id == SUPER_ADMIN_ROLE_ID) {

			if (empty($id)) {
				$this->session->set_flashdata('error', 'Your Details not found');
				redirect(get_module() . '/admin/my_account');
			}

			$data['page_title'] = "Edit My Account";
			$data['action'] = "Edit";

			$data['id'] = $id;
			$params = array(
				"one" => "1",
				"two" => "1",
				"three" => "1",
				"four" => $id
			);
			$details = $this->api->call_api('getCustomerMasterDetails', $params);
			// echo "<pre/>"; print_r($details);die;
			if (empty($details)) {
				$this->session->set_flashdata('error', 'Your Details not found');
				redirect(get_module() . '/admin/my_account');
			}
			$data['details'] = $details[0];
			$data['reference_list'] = $this->getReferencedBy_M();
			$data['state_list'] = $this->getStateDetails_M();
			$data['invoice_type_list'] = $this->getInvoiceType_M();

			$clm_stateid = $details[0]['customer_state_id'];
			$clm_distid = $details[0]['customer_dist_id'];
			$clm_cityid = $details[0]['customer_city_id'];
			$data['dist_list'] = $this->getDistrictStateIdDetails_M($clm_stateid, "Report");
			$city_list = $this->getCityDistrictIdDetails_M($clm_stateid, $clm_distid, "Report");
			$data['city_list'] = $city_list['jsArray'];
			$data['area_list'] = $this->getAreaCityIdDetails_M($clm_stateid, $clm_distid, $clm_cityid);

			$this->form_validation->set_rules('cust_gstno', 'GST No.', 'trim|max_length[15]');
			// $this->form_validation->set_rules('cust_name', 'Customer Name ', 'required|trim|max_length[100]');
			$this->form_validation->set_rules(
				'cust_company_name',
				'Company Name',
				'required|min_length[2]|max_length[100]|regex_match[/^[a-zA-Z0-9 .&()\-]+$/]'
			);
			$this->form_validation->set_rules('cust_contact_person', 'Contact Person', 'trim|max_length[100]');
			// $this->form_validation->set_rules('cust_contact', 'Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
			$this->form_validation->set_rules('alt_cust_contact', 'Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
			$this->form_validation->set_rules('cust_landline', 'Landline No.', 'trim|max_length[15]|numeric');
			$this->form_validation->set_rules('cust_contact_email', 'Email Id.', 'required|trim|max_length[100]|valid_email');

			$this->form_validation->set_rules('invoice_pattern_id', 'Invoice Pattern', 'required');
			$this->form_validation->set_rules('cust_address', 'Address', 'trim|max_length[1500]');
			$this->form_validation->set_rules('cust_pincode', 'Pincode', 'trim|max_length[6]|min_length[6]|numeric');

			$this->form_validation->set_rules('cust_unit_no', 'Unit No', 'trim|max_length[50]');
			$this->form_validation->set_rules('cust_form_no', 'Form No', 'trim|max_length[50]');
			$this->form_validation->set_rules('cust_refbyname', 'Reference Name', 'trim|max_length[200]');
			$this->form_validation->set_rules('cust_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');
			$this->form_validation->set_rules('company_chq_bounce_chrg', 'Bounce Charges', 'trim|max_length[8]|numeric');
			$this->form_validation->set_rules('sms_api', 'SMS API', 'trim|max_length[200]');
			$this->form_validation->set_rules('from_email', 'Email From', 'trim|max_length[100]|valid_email');
			$this->form_validation->set_rules('from_email_pwd', 'Email Password', 'trim|max_length[100]');

			$this->form_validation->set_rules('cust_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');

			$this->form_validation->set_rules('bank_acc_name', 'Bank Account Name', 'trim|max_length[100]');
			$this->form_validation->set_rules('bank_acc_number', 'Bank Account Number', 'trim|max_length[20]');
			$this->form_validation->set_rules('bank_branch_address', 'Bank Branch Address', 'trim|max_length[250]');
			$this->form_validation->set_rules('bank_ifsc', 'Bank IFSC', 'trim|max_length[15]');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'trim|max_length[100]');
			$this->form_validation->set_rules('bank_micr', 'Bank MICR', 'trim|max_length[9]|numeric');

			$this->form_validation->set_rules('cust_id_num', 'Id Proof No.', 'max_length[50]');
			if ($this->form_validation->run() == FALSE) {
				$this->loadViews(get_module() . '/admin/edit_my_account', $data);
			} else {

				$post_data = $this->input->post(null, true);

				// Image Upload
				$cust_pan_img = null;
				$cust_id_img = null;
				$cust_img = null;
				// Old Images
				$cust_pan_img = $details[0]['cust_pan_img'];
				$cust_pan_img = explode("/", $cust_pan_img);
				$cust_pan_img = $cust_pan_img[count($cust_pan_img) - 1];

				$cust_id_img = $details[0]['cust_id_img'];
				$cust_id_img = explode("/", $cust_id_img);
				$cust_id_img = $cust_id_img[count($cust_id_img) - 1];


				$cust_img = $details[0]['cust_img_path'];
				$cust_img = explode("/", $cust_img);
				$cust_img = $cust_img[count($cust_img) - 1];

				$cust_qr = $details[0]['cust_qr_path'];
				$cust_qr = explode("/", $cust_qr);
				$cust_qr = $cust_qr[count($cust_qr) - 1];


				// if (!empty($_FILES['cust_img']['name'])) {
				// 	$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
				// 	$upload_params = array();
				// 	$imageFile = $_FILES['cust_img']['tmp_name'];
				// 	$cust_img = "CUST_IMG_" . date("YmdHis") . "." . $ext;
				// 	$img_file_content = file_get_contents($imageFile);
				// 	$upload_params = array(
				// 		"one" => "1",
				// 		"two" => "1",
				// 		"three" => "1",
				// 		"four" => $cust_img,
				// 		"five" => base64_encode($img_file_content),
				// 		"six" => "Customers"
				// 	);
				// 	$response = $this->api->call_api('uploadBitmap', $upload_params);
				// }

				if (!empty($_FILES['cust_img']['name'])) {
					$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
					$imageFile = $_FILES['cust_img']['tmp_name'];
					$cust_img = "CUST_IMG_" . date("YmdHis") . "." . $ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => "1",
						"two" => "1",
						"three" => "1",
						"four" => $cust_img,
						"five" => base64_encode($img_file_content),
						"six" => "Customers"
					);

					$response = $this->api->call_api('uploadBitmap', $upload_params);
				} else {
					if (!empty($details[0]['cust_img_path'])) {
						$existing_image_url = $details[0]['cust_img_path'];
						$existing_image_url = trim($existing_image_url, '"');
						$img_file_content = @file_get_contents($existing_image_url);

						if ($img_file_content !== false) {
							$ext = pathinfo(parse_url($existing_image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
							$cust_img = "CUST_IMG_" . date("YmdHis") . "." . $ext;
							$upload_params = array(
								"one" => "1",
								"two" => "1",
								"three" => "1",
								"four" => $cust_img,
								"five" => base64_encode($img_file_content),
								"six" => "Customers"
							);
							$response = $this->api->call_api('uploadBitmap', $upload_params);
						} else {
							$cust_img = basename(parse_url($existing_image_url, PHP_URL_PATH));
						}
					}
				}

				// if (!empty($_FILES['cust_qr']['name'])) {
				// 	$ext = pathinfo($_FILES['cust_qr']['name'], PATHINFO_EXTENSION);
				// 	$upload_params = array();
				// 	$imageFile = $_FILES['cust_qr']['tmp_name'];
				// 	$cust_qr = "CUST_QR_" . date("YmdHis") . "." . $ext;
				// 	$img_file_content = file_get_contents($imageFile);
				// 	$upload_params = array(
				// 		"one" => "1",
				// 		"two" => "1",
				// 		"three" => "1",
				// 		"four" => $cust_qr,
				// 		"five" => base64_encode($img_file_content),
				// 		"six" => "Customers"
				// 	);
				// 	$response = $this->api->call_api('uploadBitmap', $upload_params);
				// }

				if (!empty($_FILES['cust_qr']['name'])) {
					$ext = pathinfo($_FILES['cust_qr']['name'], PATHINFO_EXTENSION);
					$imageFile = $_FILES['cust_qr']['tmp_name'];
					$cust_qr = "CUST_QR_" . date("YmdHis") . "." . $ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => "1",
						"two" => "1",
						"three" => "1",
						"four" => $cust_qr,
						"five" => base64_encode($img_file_content),
						"six" => "Customers"
					);

					$response = $this->api->call_api('uploadBitmap', $upload_params);
				} else {
					if (!empty($details[0]['cust_qr_path'])) {
						$existing_image_url = $details[0]['cust_qr_path'];
						$existing_image_url = trim($existing_image_url, '"');
						$img_file_content = @file_get_contents($existing_image_url);

						if ($img_file_content !== false) {
							$ext = pathinfo(parse_url($existing_image_url, PHP_URL_PATH), PATHINFO_EXTENSION);
							$cust_qr = "CUST_QR_" . date("YmdHis") . "." . $ext;
							$upload_params = array(
								"one" => "1",
								"two" => "1",
								"three" => "1",
								"four" => $cust_qr,
								"five" => base64_encode($img_file_content),
								"six" => "Customers"
							);
							$response = $this->api->call_api('uploadBitmap', $upload_params);
						} else {
							$cust_qr = basename(parse_url($existing_image_url, PHP_URL_PATH));
						}
					}
				}

				$cust_gstno = !empty($post_data['cust_gstno']) ? $post_data['cust_gstno'] : Null;
				$cust_name = !empty($post_data['cust_name']) ? $post_data['cust_name'] : Null;
				$cust_website = !empty($post_data['cust_website']) ? $post_data['cust_website'] : Null;
				$company_chq_bounce_chrg = !empty($post_data['company_chq_bounce_chrg']) ? $post_data['company_chq_bounce_chrg'] : 0;
				$sms_api = !empty($post_data['sms_api']) ? $post_data['sms_api'] : Null;
				$from_email = !empty($post_data['from_email']) ? $post_data['from_email'] : Null;
				$from_email_pwd = !empty($post_data['from_email_pwd']) ? $post_data['from_email_pwd'] : Null;
				$invoice_pattern_id = !empty($post_data['invoice_pattern_id']) ? $post_data['invoice_pattern_id'] : Null;
				$alt_cust_contact = !empty($post_data['alt_cust_contact']) ? $post_data['alt_cust_contact'] : Null;


				$company_type_id = !empty($post_data['company_type_id']) ? $post_data['company_type_id'] : Null;

				$invoice_pattern_id = !empty($post_data['invoice_pattern_id']) ? $post_data['invoice_pattern_id'] : Null;
				$cust_paid_amount = !empty($post_data['cust_paid_amount']) ? $post_data['cust_paid_amount'] : 0;
				$payment_gateway = !empty($post_data['payment_gateway']) ? $post_data['payment_gateway'] : Null;

				$bank_name = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
				$bank_acc_name = !empty($post_data['bank_acc_name']) ? $post_data['bank_acc_name'] : Null;
				$bank_acc_number = !empty($post_data['bank_acc_number']) ? $post_data['bank_acc_number'] : Null;
				$bank_branch_address = !empty($post_data['bank_branch_address']) ? $post_data['bank_branch_address'] : Null;
				$bank_ifsc = !empty($post_data['bank_ifsc']) ? $post_data['bank_ifsc'] : Null;
				$bank_micr = !empty($post_data['bank_micr']) ? $post_data['bank_micr'] : Null;

				// For Non-GST
				$bank_name1 = !empty($post_data['bank_name1']) ? $post_data['bank_name1'] : Null;
				$bank_acc_name1 = !empty($post_data['bank_acc_name1']) ? $post_data['bank_acc_name1'] : Null;
				$bank_acc_number1 = !empty($post_data['bank_acc_number1']) ? $post_data['bank_acc_number1'] : Null;
				$bank_branch_address1 = !empty($post_data['bank_branch_address1']) ? $post_data['bank_branch_address1'] : Null;
				$bank_ifsc1 = !empty($post_data['bank_ifsc1']) ? $post_data['bank_ifsc1'] : Null;
				$bank_micr1 = !empty($post_data['bank_micr1']) ? $post_data['bank_micr1'] : Null;


				// echo "<pre/>"; print_r(json_encode($bank_name1));
				// echo "<pre/>"; print_r(json_encode($bank_acc_name1));
				// echo "<pre/>"; print_r(json_encode($bank_acc_number1));
				// echo "<pre/>"; print_r(json_encode($bank_branch_address1));
				// echo "<pre/>"; print_r(json_encode($bank_ifsc1));
				// echo "<pre/>"; print_r(json_encode($bank_micr1));
				// die;

				$cust_id_num = !empty($post_data['cust_id_num']) ? $post_data['cust_id_num'] : Null;
				$cust_panno = !empty($post_data['cust_panno']) ? $post_data['cust_panno'] : Null;
				$p_company_portal = !empty($post_data['p_company_portal']) ? $post_data['p_company_portal'] : "NO";
				$cust_company_name = !empty($post_data['cust_company_name']) ? $post_data['cust_company_name'] : "";

				$cust_contact_person = !empty($post_data['cust_contact_person']) ? $post_data['cust_contact_person'] : Null;
				$cust_contact = !empty($post_data['cust_contact']) ? $post_data['cust_contact'] : Null;
				$cust_landline = !empty($post_data['cust_landline']) ? $post_data['cust_landline'] : Null;
				$cust_contact_email = !empty($post_data['cust_contact_email']) ? $post_data['cust_contact_email'] : Null;
				$cust_address = !empty($post_data['cust_address']) ? $post_data['cust_address'] : Null;
				$cust_stateid = !empty($post_data['cust_stateid']) ? $post_data['cust_stateid'] : Null;
				$cust_distid = !empty($post_data['cust_distid']) ? $post_data['cust_distid'] : Null;
				$cust_cityid = !empty($post_data['cust_cityid']) ? $post_data['cust_cityid'] : Null;
				$cust_area = !empty($post_data['cust_area']) ? $post_data['cust_area'] : Null;
				$cust_pincode = !empty($post_data['cust_pincode']) ? $post_data['cust_pincode'] : Null;
				$cust_service_det = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;

				$cust_type = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;
				$cust_unit_no = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
				$cust_form_no = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;
				$cust_ui_date = !empty($post_data['cust_ui_date']) ? strtoupper(date("d-M-Y", strtotime($post_data['cust_ui_date']))) : strtoupper(date("d-M-Y"));

				$cust_refbyid = !empty($post_data['cust_refbyid']) ? $post_data['cust_refbyid'] : Null;
				$cust_refbyname = !empty($post_data['cust_refbyname']) ? $post_data['cust_refbyname'] : Null;
				$cust_refby_contact = !empty($post_data['cust_refby_contact']) ? $post_data['cust_refby_contact'] : Null;
				$cust_refby_email = !empty($post_data['cust_refby_email']) ? $post_data['cust_refby_email'] : Null;

				$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;

				$lead_altcontactperson = "";
				$lead_altcontact = "";
				$lead_altemail = "";

				if (!empty($alternate_contact_details)) {
					foreach ($alternate_contact_details as $contact) {
						$lead_altcontactperson = $lead_altcontactperson . $contact['lead_altcontactperson'] . ",";
						$lead_altcontact = $lead_altcontact . $contact['lead_altcontact'] . ",";
						$lead_altemail = $lead_altemail . $contact['lead_altemail'] . ",";
					}
				}
				$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
				$lead_altcontact = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
				$lead_altemail = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;


				$params = array(
					"one" => "1",
					"two" => "1",
					"three" => "1",
					"four" => "1",
					"five" => $id,
					"six" => $cust_name,
					// "seven" => $cust_contact,
					"seven" => $details[0]['customer_contact'],
					"eight" => $alt_cust_contact,
					"nine" => $lead_altcontactperson,
					"ten" => $lead_altcontact,
					"eleven" => $lead_altemail,
					"twelve" => $cust_address,
					"thirteen" => $cust_stateid,
					"fourteen" => $cust_distid,
					"fifteen" => $cust_cityid,
					"sixteen" => $cust_area,
					"seventeen" => $cust_gstno,
					"eighteen" => $cust_pincode,
					"nineteen" => $cust_img,
					"twenty" => $cust_refbyid,
					"twentyone" => $cust_refbyname,
					"twentytwo" => $cust_refby_contact,
					"twentythree" => $cust_refby_email,
					"twentyfour" => NULL,
					"twentyfive" => NULL,
					"twentysix" => $cust_landline,
					"twentyseven" => $cust_type,
					"twentyeight" => $cust_service_det,
					"twentynine" => $cust_unit_no,
					"thirty" => $cust_form_no,
					"thirtyone" => $cust_ui_date,
					"thirtytwo" => $cust_contact_person,
					"thirtythree" => $cust_contact_email,
					"thirtyfour" => Null,
					"thirtyfive" => $invoice_pattern_id,
					"thirtysix" => Null,

					"thirtyseven" => $bank_name,
					"thirtyeight" => $bank_acc_name,
					"thirtynine" => $bank_acc_number,
					"fourty" => $bank_branch_address,
					"fourtyone" => $bank_ifsc,
					"fourtytwo" => $bank_micr,

					"fourtythree" => $sms_api,
					"fourtyfour" => $from_email,
					"fourtyfive" => $from_email_pwd,
					"fourtysix" => Null,
					"fourtyseven" => Null,
					"fourtyeight" => Null,
					"fourtynine" => Null,
					"fifty" => $company_chq_bounce_chrg,
					"fiftyone" => $cust_website,
					"fiftytwo" => $cust_panno,
					"fiftythree" => $cust_company_name,
					"fiftyfour" => $cust_pan_img,
					"fiftyfive" => $cust_id_num,
					"fiftysix" => $cust_id_img,
					"fiftyseven" => $p_company_portal,
					"fiftyeight" => $cust_qr,

					"fiftynine" => $bank_name1,
					"sixty" => $bank_acc_name1,
					"sixtyone" => $bank_acc_number1,
					"sixtytwo" => $bank_branch_address1,
					"sixtythree" => $bank_ifsc1,
					"sixtyfour" => $bank_micr1,
					"sixtyfive" => $details[0]['subscriptionList'][0]['cust_subs_enddate_n'],
					"sixtysix" => $details[0]['subscriptionList'][0]['cust_subs_startdate_n']
				);
				// echo "<pre/>"; print_r($params);die;	
				//log_message("error",json_encode($params));
				$response = $this->api->call_api('setModifyCustomerMasterDetails', $params);
				if ($response[0]['status'] == "Success") {
					$this->session->set_flashdata('success', 'Customer Updated successfully !!');
					redirect(get_module() . '/admin/my_account');
				} else {
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module() . '/admin/my_account');
				}
			}
		} else {
			$this->session->set_flashdata('error', 'You Are Not Authorized To Access This Page');
			redirect(get_module() . '/admin/my_account');
		}
	}

	public function download_invoice()
	{
		$id = $this->input->get("ref_id");
		$billno = $this->input->get("billno");
		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/admin/my_account');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/admin/my_account');
		}
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => $id
		);
		$details = $this->api->call_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/admin/my_account');
		}
		$details = $details[0];
		$customer_name = $details['customer_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => $id,
			"five" => $billno,
		);

		$response = $this->api->call_api('downloadCustomerInvoiceDetails', $params);
		/* echo "<pre/>";print_r($response);
		echo "<pre/>";print_r($params);
		die; */
		// download file
		header('Content-Disposition: attachment; filename="' . $customer_name . '_Invoice_' . Date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}
	public function logout()
	{
		session_regenerate_id();
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout successfully !!');
		redirect(get_module() . "/login");
	}

	/**********Dashbard Functions**********/
	public function get_todays_followup()
	{
		$date = date("d") . strtoupper(date("M")) . date("Y");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"seven" => $date
		);
		$response = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		return $response;
	}
	public function get_my_followup()
	{

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_id
		);
		$response = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		return $response;
	}

	public function get_lead_approval_list()
	{

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "FS"
		);
		$response = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		return $response;
	}

	public function getChequeReminderDetails()
	{

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$response = $this->api->call_v_api('getChequeReminderDetails', $params);
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

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id
		);
		$response = $this->api->call_v_api('getSaleBalanceDetails', $params);
		return $response;
	}

	public function getMenuPermissionAssignDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id
		);
		$response = $this->api->call_v_api('getMenuPermissionAssignDetails', $params);
		return $response;
	}


	public function getBranchMasterDetails($branch_id = NULL, $status = "Active", $searchStr = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $branch_id,
			"six" => $searchStr
		);
		$response = $this->api->call_v_api('getBranchMasterDetails', $params);
		return $response;
	}

	public function getDashboardPermissionAssignDetails($type = "Block")
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $type,
		);
		$response = $this->api->call_v_api('getDashboardPermissionAssignDetails', $params);
		return $response;
	}
	public function getEmployeeReportDetails($emp_id = NULL, $status = "Active", $name = NULL, $permission_id = NULL, $dept_id = NULL, $subdept_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $status,
			"six" => $name,
			"seven" => $permission_id,
			"eight" => $dept_id,
			"nine" => $subdept_id,
		);
		$response = $this->api->call_v_api('getEmployeeReportDetails', $params);
		return $response['jsArray'];
	}

	public function getEmployeeDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
		);
		$response = $this->api->call_v_api('getEmployeeDetails', $params);
		return $response;
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









	public function getCompanyMasterDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$response = $this->api->call_v_api('getCompanyMasterDetails', $params);
		return $response;
	}

	public function getCustomerMasterDetails($cust_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
		);
		$response = $this->api->call_v_api('getCustomerMasterDetails', $params);
		return $response;
	}
	public function check_menu_permision($menu_name = Null)
	{
		/*  $permission_id  = $this->session->userdata("user_permission_id");
		 $permission_grant = $this->session->userdata("user_permission_id");
		 $params = array("one"=>$this->_user_id,
							  "two"=>$this->_user_branch_id,
							  "three"=>$this->_user_company_id);
		  $menu_list = $this->api->call_v_api('getMenuPermissionAssignDetails',$params);
		  foreach($menu_list as $key1=>$menu){
							  $submenuList   = $menu['submenuList'];
							  if(!empty($submenuList))
							  {
								  foreach($submenuList as $key=>$submenu){

									  $sub_menu_filename  = $submenu['sub_menu_filename'];
									  $permissionList 	= $submenu['permissionList'];
									  if($sub_menu_filename == $menu_name){
										   if (!empty($permissionList)){
										   foreach($permissionList as $permission){
												if($permission_id == $permission['permission_id'] && $permission['status']=="Yes")
												{
													return true;
												}


											  }
										   }
									  }
								  }
							  } else { return false;}

			} */

		return true;
	}

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
	public function getDepartmentMasterDetails($type = NULL, $status = "Active", $dept_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $dept_id
		);
		$response = $this->api->call_v_api('getDepartmentMasterDetails', $params);
		return $response;
	}
	public function getEducationDetails($type = NULL, $status = "Active", $edu_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $edu_id
		);
		$response = $this->api->call_v_api('getEducationDetails', $params);
		return $response;
	}
	public function checkIFSCExists()
	{
		$ifsc_code = $this->input->post('emp_bank_ifsc_code');
		$ifsc_details = $this->api->check_ifsc($ifsc_code);
		$ifsc_details = json_decode($ifsc_details);
		if ($ifsc_details == "Not Found") {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}
	public function getIFSC()
	{
		$ifsc_code = $this->input->post('ifsc_code');
		$ifsc_details = $this->api->check_ifsc($ifsc_code);
		echo $ifsc_details;
	}

	//PINCODE

	public function checkPINExists()
	{
		$pin_code = $this->input->post('emp_pincode');
		$pin_details = $this->api->check_pin($pin_code);
		$pin_details = json_decode($pin_details);
		if ($pin_details == "Not Found") {
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}
	}
	public function getPIN()
	{
		$pin_code = $this->input->post('pin_code');
		$pin_details = $this->api->check_pin($pin_code);
		echo $pin_details;
	}

	public function getStateDetails($type = NULL, $status = "Active", $state_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $state_id
		);
		$response = $this->api->call_v_api('getStateDetails', $params);
		return $response;
	}
	public function get_proof_list()
	{
		$list = array("Adhar Card", "Voting Card", "Driving Licence", "PAN Card");
		return $list;
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
		return $response['jsArray'];
	}
	public function getSubdepartmentDeptIdDetails($dept_id = NULL, $type = NULL, $status = "Active", $sub_dept_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $dept_id,
			"five" => $status,
			"six" => $type,
			"seven" => $sub_dept_id
		);
		$response = $this->api->call_v_api('getSubdepartmentDeptIdDetails', $params);
		return $response;
	}


	// For My Edit My Account

	public function getReferencedBy_M()
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => "Active",
		);
		$response = $this->api->call_api('getReferenceByDetails', $params);
		return $response['jsArray'];
	}
	public function getStateDetails_M()
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => "Active",
			"five" => "Report",
		);
		$response = $this->api->call_api('getStateDetails', $params);
		return $response;
	}
	public function getAreaCityIdDetails_M($state_id = NULL, $dist_id = NULL, $city_id = NULL)
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => $state_id,
			"five" => $dist_id,
			"six" => $city_id,
			"seven" => "Active",
			"eight" => "Report",
		);
		$response = $this->api->call_api('getAreaCityIdDetails', $params);
		return $response['jsArray'];
	}

	public function getDistrictStateIdDetails_M($state_id = NULL, $type = NULL, $status = "Active", $dist_id = NULL)
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => $state_id,
			"five" => $status,
			"six" => $type,
			"seven" => $dist_id
		);
		$response = $this->api->call_api('getDistrictStateIdDetails', $params);
		return $response;
	}
	public function getCityDistrictIdDetails_M($state_id = NULL, $dist_id = NULL, $type = NULL, $status = "Active", $city_id = NULL, $page = NULL, $total_count = NULL)
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => $state_id,
			"five" => $dist_id,
			"six" => $status,
			"seven" => $type,
			"eight" => $city_id,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$response = $this->api->call_api('getCityDistrictIdDetails', $params);
		return $response;
	}
	public function getInvoiceType_M()
	{
		$params = array(
			"one" => "1",
			"two" => "1",
			"three" => "1",
			"four" => "Active"
		);
		$response = $this->api->call_api('getMauliInvoicePatternMasterDetails', $params);
		return $response;
	}
	public function check_access($class = Null, $method = Null)
	{
		return true;
	}

	// public function getBirthdayReminder()
	// {
	// 	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
	// 		redirect(get_module() . '/dashboard/access_denied');
	// 	}
	// 	$data['pen_up'] = array("Pending Services", "Upcoming Services");
	// 	$data['page_title']        = "Birthday Report";
	// 	$this->loadViews(get_module() . '/admin/list_birthday', $data);
	// }
	public function getBirthdayReminder()
	{
		if (
			!($this->check_access(
				$this->router->fetch_class(),
				$this->router->fetch_method()
			)
			)
		) {

			redirect(
				get_module() .
				'/dashboard/access_denied'
			);
		}

		$data['page_title'] = "Birthday Report";

		/* OPTIONAL FILTERS */

		$data['birthday_type_list'] = array(
			"Today",
			"Tomorrow"
		);

		$data['person_type_list'] = array(
			"Employee",
			"Customer",
			"Lead"
		);

		$this->loadViews(get_module() . '/admin/list_birthday', $data);
	}
	public function emp_location_current_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Employee Location Report";
		$data['employee_list'] = $this->getEmployeeReportDetails();
		$data['key'] = GOOGLE_MAP_API_KEY;
		//   echo "<pre>";print_r($data); exit;
		$this->loadViews(get_module() . '/admin/list_employee_current_locations', $data);
	}

	// Changes by Shawn Arakal - 10-08-2026 12:02:46 IST
	public function integrations()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		// Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: page title renamed Integrations -> Lead API's
		$data['page_title'] = "Lead API's";
		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id
		);
		$data['integration_list'] = $this->api->call_v_api('getIntegrationDetails', $params);
		$meta_status = $this->api->call_meta_api('status', array(
			'vendorId'  => $this->_user_id,
			'branchId'  => $this->_user_branch_id,
			'companyId' => $this->_user_company_id
		), 'GET');
		$data['meta_status'] = is_array($meta_status) ? $meta_status : array();
		$this->loadViews(get_module() . '/admin/integrations', $data);
	}

	public function configure_integration()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$integration_key = $this->input->get('key', true);
		if (empty($integration_key)) {
			// Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: error message renamed Integration -> Lead API
			$this->session->set_flashdata('error', 'Lead API details not found');
			redirect(get_module() . '/admin/integrations');
		}

		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id
		);
		$integration_list = $this->api->call_v_api('getIntegrationDetails', $params);
		$integration = array();
		if (!empty($integration_list)) {
			foreach ($integration_list as $row) {
				if (isset($row['integration_key']) && strcasecmp($row['integration_key'], $integration_key) == 0) {
					$integration = $row;
					break;
				}
			}
		}
		if (empty($integration)) {
			// Changes by Shawn Arakal - 10-08-2026 16:00:45 IST: error message renamed Integration -> Lead API
			$this->session->set_flashdata('error', 'Lead API details not found');
			redirect(get_module() . '/admin/integrations');
		}

		$field_list = array();
		$integration_fields = isset($integration['integration_fields']) ? $integration['integration_fields'] : '';
		if (!empty($integration_fields)) {
			$decoded = json_decode($integration_fields, true);
			if (is_array($decoded)) {
				$field_list = $decoded;
			}
		}

		$saved_config = array();
		if (!empty($integration['config_value'])) {
			$saved = json_decode($integration['config_value'], true);
			if (is_array($saved)) {
				$saved_config = $saved;
			}
		}

		$data['page_title']  = "Configure " . $integration['integration_name'];
		$data['integration'] = $integration;
		$data['field_list']  = $field_list;
		$data['saved_config'] = $saved_config;

		if ($this->input->post()) {
			if (empty($field_list)) {
				$this->session->set_flashdata('error', 'No configuration fields are defined for this integration yet.');
				redirect(get_module() . '/admin/configure_integration?key=' . urlencode($integration_key));
			}
			$config_json = array();
			foreach ($field_list as $field) {
				$field_key   = isset($field['key']) ? $field['key'] : '';
				$field_label = isset($field['label']) ? $field['label'] : 'Value';
				if (empty($field_key)) {
					continue;
				}
				$this->form_validation->set_rules($field_key, $field_label, 'required|trim|max_length[500]');
				$config_json[$field_key] = $this->input->post($field_key, true);
			}
			if ($this->form_validation->run() == FALSE) {
				$this->loadViews(get_module() . '/admin/configure_integration', $data);
				return;
			}
			$set_params = array(
				"one"   => $this->_user_id,
				"two"   => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four"  => $this->_user_emp_id,
				"five"  => $integration['integration_id'],
				"six"   => $integration['integration_key'],
				"seven" => json_encode($config_json)
			);
			$response = $this->api->call_v_api('setIntegrationDetails', $set_params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', $integration['integration_name'] . ' configuration saved successfully !!');
				redirect(get_module() . '/admin/integrations');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/admin/configure_integration?key=' . urlencode($integration_key));
			}
		}

		$this->loadViews(get_module() . '/admin/configure_integration', $data);
	}

	public function meta_connect()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$response = $this->api->call_meta_api('connect', array(
			'vendorId'  => $this->_user_id,
			'branchId'  => $this->_user_branch_id,
			'companyId' => $this->_user_company_id
		), 'GET');
		$auth_url = is_string($response) ? trim($response) : '';
		if (empty($auth_url)) {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/admin/integrations');
		}
		redirect($auth_url);
	}

	public function meta_test_connection()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		if ($_SERVER['REQUEST_METHOD'] != 'POST') {
			redirect(get_module() . '/admin/integrations');
		}
		$response = $this->api->call_meta_api('testConnection', array(
			'vendorId'  => $this->_user_id,
			'branchId'  => $this->_user_branch_id,
			'companyId' => $this->_user_company_id
		), 'GET');
		$this->output->set_content_type('application/json');
		echo json_encode(array('status' => $response));
		return;
	}
}
