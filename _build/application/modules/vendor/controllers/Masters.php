<?php
(defined('BASEPATH')) OR exit('No direct script access allowed');
class Masters extends MY_Controller
{ // Main Controller

	public function __construct()
	{
		parent::__construct();
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

	// Reference By  Master 
	public function reference_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Reference Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_reference', $data);

	}

	public function add_reference()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Reference";
		$data['action'] = "Add";
		$this->form_validation->set_rules('ref_name', 'Reference Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('ref_email', 'Reference Email', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_contact_per', 'Contact Person', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_addr', 'Address', 'max_length[500]');
		$this->form_validation->set_rules('ref_details', 'Details', 'max_length[500]');
		$this->form_validation->set_rules('ref_mobile_no', 'Mobile No.', 'trim|max_length[10]|min_length[10]|numeric');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_reference', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('ref_name', true),
				"six" => $this->input->post('ref_contact_per', true),
				"seven" => $this->input->post('ref_mobile_no', true),
				"eight" => $this->input->post('ref_email', true),
				"nine" => $this->input->post('ref_addr', true),
				"ten" => $this->input->post('ref_details', true),
			);
			$response = $this->api->call_v_api('setReferenceByDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Reference Added successfully !!');
				redirect(get_module() . '/masters/reference_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/reference_report');
			}
		}

	}
	public function view_reference()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Reference Master Report";
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$details = $this->getReferenceByDetails($ref_id);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$data['details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_reference', $data);

	}

	public function edit_reference()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$data['page_title'] = "Update Reference Details";
		$data['action'] = "Edit";
		$data['ref_id'] = $ref_id;
		$details = $this->getReferenceByDetails($ref_id);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$data['details'] = $details[0];


		$this->form_validation->set_rules('ref_name', 'Reference Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('ref_email', 'Reference Email', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_contact_per', 'Contact Person', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_addr', 'Address', 'max_length[500]');
		$this->form_validation->set_rules('ref_details', 'Details', 'max_length[500]');
		$this->form_validation->set_rules('ref_mobile_no', 'Mobile No.', 'trim|max_length[10]|min_length[10]|numeric');
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_reference', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('ref_id', true),
				"six" => $this->input->post('ref_name', true),
				"seven" => $this->input->post('ref_contact_per', true),
				"eight" => $this->input->post('ref_mobile_no', true),
				"nine" => $this->input->post('ref_email', true),
				"ten" => $this->input->post('ref_addr', true),
				"eleven" => $this->input->post('ref_details', true),
			);
			$response = $this->api->call_v_api('setModifyReferenceByDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Reference Details Updated successfully !!');
				redirect(get_module() . '/masters/reference_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/reference_report');
			}
		}

	}

	public function deactivate_reference()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Reference Details not found');
			redirect(get_module() . '/masters/reference_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $ref_id,
			"six" => "Deactivated",
		);
		$response = $this->api->call_v_api('setDeactivateReferenceByDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Reference Deactivated successfully ');
			redirect(get_module() . '/masters/reference_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/reference_report');
		}


	}
	//18-02-25 by kirandhaije
	public function add_ref()
	{
		$data['page_title'] = "Add New Reference";
		$data['action'] = "Add";

		// Form Validation
		$this->form_validation->set_rules('ref_name', 'Reference Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('ref_email', 'Reference Email', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_contact_per', 'Contact Person', 'trim|max_length[100]');
		$this->form_validation->set_rules('ref_addr', 'Address', 'max_length[500]');
		$this->form_validation->set_rules('ref_details', 'Details', 'max_length[500]');
		$this->form_validation->set_rules('ref_mobile_no', 'Mobile No.', 'trim|max_length[10]|min_length[10]|numeric');

		if ($this->form_validation->run() == FALSE) {
			// Load the form if validation fails
			$this->load->view(get_module() . '/masters/add_ref', $data);
		} else {
			// Prepare the params and call API
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('ref_name', true),
				"six" => $this->input->post('ref_contact_per', true),
				"seven" => $this->input->post('ref_mobile_no', true),
				"eight" => $this->input->post('ref_email', true),
				"nine" => $this->input->post('ref_addr', true),
				"ten" => $this->input->post('ref_details', true),
			);

			// Call API to set reference details
			$response = $this->api->call_v_api('setReferenceByDetails', $params);

			// Redirect based on the response
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Reference Added successfully !!');
				redirect(get_module() . '/customers/add_customer');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/add_customer');
			}
		}
	}

	// Department  Master 
	public function department_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Department Report";
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['department_list'] = $this->getDepartmentMasterDetails($type, $status, $srch);
		$this->loadViews(get_module() . '/masters/list_department', $data);

	}

	public function add_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Department";
		$data['action'] = "Add";
		$this->form_validation->set_rules('dept_name', 'Department Name', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_department', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('dept_name', true)
			);
			$response = $this->api->call_v_api('setDepartmentMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Department Added successfully !!');
				redirect(get_module() . '/masters/department_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/department_report');
			}
		}

	}

	public function setup_whatsapp()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Whats app";
		$data['action'] = "Add";
		$key = APIKEY;
		$this->form_validation->set_rules('whatscontact', 'Whats App Number', 'required|trim|numeric|exact_length[10]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/setup_whatsapp', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('whatscontact', true),
				"authapikey" => $key
			);
			// echo "<pre/>"; print_r( $params);die;	
			$response = $this->api->call_v_api('setWhatsappMasterDetails', $params);
			//echo "<pre/>"; print_r($response);die;

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Whats App Integration Added successfully !!');
				redirect(get_module() . '/masters/setup_whatsapp');

			} elseif ($response == "Already registered") {
				$this->session->set_flashdata('error', 'Whats App Integration is Alraedy Registered for this account');
				redirect(get_module() . '/masters/setup_whatsapp');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/setup_whatsapp');
			}
		}

	}


	public function view_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Department Master Report";
		$dept_id = $this->input->get("dept_id");
		if (empty($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$dept_id = base64_decode($dept_id);
		if (!is_numeric($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $dept_id
		);
		$dept_details = $this->api->call_v_api('getDepartmentMasterDetails', $params);
		if (empty($dept_details)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$data['department_details'] = $dept_details[0];
		$this->loadViews(get_module() . '/masters/view_department', $data);

	}

	public function edit_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$dept_id = $this->input->get("dept_id");
		if (empty($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$dept_id = base64_decode($dept_id);
		if (!is_numeric($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$data['page_title'] = "Update Department Details";
		$data['action'] = "Edit";


		$data['dept_id'] = $dept_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $dept_id
		);
		$dept_details = $this->api->call_v_api('getDepartmentMasterDetails', $params);
		if (empty($dept_details)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$data['department_details'] = $dept_details[0];

		$this->form_validation->set_rules('dept_name', 'Department Name', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_department', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('dept_id', true),
				"six" => $this->input->post('dept_name', true)
			);
			$response = $this->api->call_v_api('setModifyDepartmentMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Department Details Updated successfully !!');
				redirect(get_module() . '/masters/department_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/department_report');
			}
		}

	}

	public function deactivate_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$dept_id = $this->input->get("dept_id");
		if (empty($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$dept_id = base64_decode($dept_id);
		if (!is_numeric($dept_id)) {
			$this->session->set_flashdata('error', 'Department Details not found');
			redirect(get_module() . '/masters/department_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $dept_id
		);
		$response = $this->api->call_v_api('setDeactivateDepartmentMasterDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Department Deactivated successfully ');
			redirect(get_module() . '/masters/department_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/department_report');
		}


	}


	// Sub Department  Master 
	public function sub_department_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Sub Department Report";
		$dept_id = $this->input->get('dept_id');
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$data['dept_id'] = $dept_id;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");
		if ($dept_id) {
			$data['sub_department_list'] = $this->getSubdepartmentDeptIdDetails($dept_id, $type, $status, $srch);
		} else {
			$data['sub_department_list'] = $this->getSubdepartmentDetails($type, $status, $srch);
		}

		$this->loadViews(get_module() . '/masters/list_sub_department', $data);

	}

	public function add_sub_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Sub Department";
		$data['action'] = "Add";
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");

		$this->form_validation->set_rules('sub_dept_name', 'Sub Department Name', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('dept_id', 'Department', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_sub_department', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('dept_id', true),
				"six" => $this->input->post('sub_dept_name', true)
			);
			$response = $this->api->call_v_api('setSubdepartmentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Sub Department Added successfully !!');
				redirect(get_module() . '/masters/sub_department_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/sub_department_report');
			}
		}

	}

	public function view_sub_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Sub Department Master Report";
		$sub_dept_id = $this->input->get("sub_dept_id");
		if (empty($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$sub_dept_id = base64_decode($sub_dept_id);
		if (!is_numeric($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $sub_dept_id
		);
		$dept_details = $this->api->call_v_api('getSubdepartmentDetails', $params);
		if (empty($dept_details)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$data['sub_department_details'] = $dept_details[0];
		$this->loadViews(get_module() . '/masters/view_sub_department', $data);

	}

	public function edit_sub_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$sub_dept_id = $this->input->get("sub_dept_id");
		if (empty($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$sub_dept_id = base64_decode($sub_dept_id);
		if (!is_numeric($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$data['page_title'] = "Update Sub Department Details";
		$data['action'] = "Edit";
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");

		$data['sub_dept_id'] = $sub_dept_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $sub_dept_id
		);
		$dept_details = $this->api->call_v_api('getSubdepartmentDetails', $params);
		if (empty($dept_details)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$data['sub_department_details'] = $dept_details[0];

		$this->form_validation->set_rules('sub_dept_name', 'Sub Department Name', 'required|trim|max_length[200]');
		$this->form_validation->set_rules('dept_id', 'Department', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_sub_department', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('sub_dept_id', true),
				"six" => $this->input->post('dept_id', true),
				"seven" => $this->input->post('sub_dept_name', true)
			);
			$response = $this->api->call_v_api('setModifySubdepartmentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Sub Department Details Updated successfully !!');
				redirect(get_module() . '/masters/sub_department_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/sub_department_report');
			}
		}

	}

	public function deactivate_sub_department()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$sub_dept_id = $this->input->get("sub_dept_id");
		if (empty($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$sub_dept_id = base64_decode($sub_dept_id);
		if (!is_numeric($sub_dept_id)) {
			$this->session->set_flashdata('error', 'Sub Department Details not found');
			redirect(get_module() . '/masters/sub_department_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $sub_dept_id
		);
		$response = $this->api->call_v_api('setDeactivateSubdepartmentDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Sub Department Deactivated successfully ');
			redirect(get_module() . '/masters/sub_department_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/sub_department_report');
		}


	}

	// Permission  Master 
	public function permission_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Permission Report";
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['permission_list'] = $this->getPermissionMasterDetails($type, $status, $srch);
		$this->loadViews(get_module() . '/masters/list_permissions', $data);

	}

	public function add_permission()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Permission";
		$data['action'] = "Add";
		$this->form_validation->set_rules('permission_name', 'Permission Name', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_permission', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('permission_name', true)
			);
			$response = $this->api->call_v_api('setPermissionMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Permission Added successfully !!');
				redirect(get_module() . '/masters/permission_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/permission_report');
			}
		}

	}

	public function view_permission()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Permission Master Report";
		$permission_id = $this->input->get("permission_id");
		if (empty($permission_id)) {
			$this->session->set_flashdata('error', 'Permission Details not found');
			redirect(get_module() . '/masters/permission_report');
		}
		$permission_id = base64_decode($permission_id);
		if (!is_numeric($permission_id)) {
			$this->session->set_flashdata('error', 'Permission Details not found');
			redirect(get_module() . '/masters/permission_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $permission_id
		);
		$permission_details = $this->api->call_v_api('getPermissionMasterDetails', $params);
		if (empty($permission_details)) {
			$this->session->set_flashdata('error', 'Permission Details not found');
			redirect(get_module() . '/masters/permission_report');
		}
		$data['permission_details'] = $permission_details[0];
		$this->loadViews(get_module() . '/masters/view_permission', $data);

	}


	public function deactivate_permission()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Permission Details not found');
			redirect(get_module() . '/masters/permission_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Permission Details not found');
			redirect(get_module() . '/masters/permission_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $id,
		);
		$response = $this->api->call_v_api('setDeactivatePermissionMasterDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Permission Deactivated successfully ');
			redirect(get_module() . '/masters/permission_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/permission_report');
		}


	}

	// FAQ Module  Master 
	public function faq_module_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available FAQ Module Report";
		$permission_id = $this->input->get('permission_id');
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$data['permission_id'] = $permission_id;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$data['faq_module_list'] = $this->getFaqModuleDetails($permission_id, $type, $status, $srch);


		$this->loadViews(get_module() . '/masters/list_faq_module', $data);

	}

	public function add_faq_module()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New FAQ Module";
		$data['action'] = "Add";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$this->form_validation->set_rules('faq_module_name', 'FAQ Module Name', 'required|trim|max_length[1000]');
		$this->form_validation->set_rules('permission_id', 'Modulefor', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_faq_module', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('faq_module_name', true),
				"six" => $this->input->post('permission_id', true)
			);
			$response = $this->api->call_v_api('setFaqModuleDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New FAQ Module Added successfully !!');
				redirect(get_module() . '/masters/faq_module_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_module_report');
			}
		}

	}

	public function edit_faq_module()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$faq_m_id = $this->input->get("faq_m_id");
		if (empty($faq_m_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$faq_m_id = base64_decode($faq_m_id);
		if (!is_numeric($faq_m_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$data['page_title'] = "Update FAQ Module Details";
		$data['action'] = "Edit";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$data['faq_m_id'] = $faq_m_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $faq_m_id
		);
		$details = $this->api->call_v_api('getFaqModuleDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$data['faq_module_details'] = $details[0];

		$this->form_validation->set_rules('faq_module_name', 'FAQ Module Name', 'required|trim|max_length[1000]');
		$this->form_validation->set_rules('permission_id', 'Modulefor', 'required|trim');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_faq_module', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('faq_m_id', true),
				"six" => $this->input->post('faq_module_name', true),
				"seven" => $this->input->post('permission_id', true)
			);
			$response = $this->api->call_v_api('setModifyFaqModuleDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'FAQ Module Details Updated successfully !!');
				redirect(get_module() . '/masters/faq_module_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_module_report');
			}
		}
	}

	public function view_faq_module()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "FAQ Module Master Report";
		$faq_m_id = $this->input->get("faq_m_id");
		if (empty($faq_m_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$faq_m_id = base64_decode($faq_m_id);
		if (!is_numeric($faq_m_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $faq_m_id
		);
		$details = $this->api->call_v_api('getFaqModuleDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$data['faq_module_details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_faq_module', $data);
	}

	public function deactivate_faq_module()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'FAQ Module Details not found');
			redirect(get_module() . '/masters/faq_module_report');
		}
		$data['page_title'] = "Deactivate FAQ Module";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_faq_module";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('masters/deactivation_popup', $data, true);
			echo $html;

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateFaqModuleDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'FAQ Module Deactivated successfully ');
				redirect(get_module() . '/masters/faq_module_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_module_report');
			}
		}
	}


	// FAQ Master 
	// public function faq_report()
	// {
	// 	if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
	// 		redirect(get_module().'/dashboard/access_denied');
	// 	}
	// 	$data['page_title']   = "All Available FAQ Report";
	// 	$faq_m_id       = $this->input->get('faq_m_id');
	// 	$status        = $this->input->get('status');
	// 	$status        = $status?$status:"Active";		
	// 	$searchStr     = $this->input->get('searchStr');
	// 	$data['searchStr']        = $searchStr;
	// 	$data['status']           = $status;	
	// 	$data['faq_m_id']    = $faq_m_id;	
	// 	$type               = isset($searchStr)?"Search":"Report";	
	//     $searchStr          = addslashes($searchStr);	
	//    	$srch               =  ($type=="Search")?$searchStr:Null;	
	// 	$data['status_list']= array("Active","Deactivated");
	// 	$data['faq_module_list'] = $this->getFaqModuleDetails(null,"Report"); 

	// 	$data['faq_list'] = $this->getFaqDetails($faq_m_id,$type,$status,$srch);	       
	// 	$this->loadViews(get_module().'/masters/list_faq',$data);

	// }

	public function faq_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "MI-Btrack CRM FAQ";
		$faq_m_id = $this->input->get('faq_m_id');
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$data['faq_m_id'] = $faq_m_id;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['faq_module_list'] = $this->getFaqModuleDetails(null, "Report");

		$data['faq_list'] = $this->getFaqDetails($faq_m_id, $type, $status, $srch);
		$this->loadViews(get_module() . '/masters/list_faq', $data);

	}

	public function add_faq()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New FAQ";
		$data['action'] = "Add";
		$data['faq_module_list'] = $this->getFaqDetails(null, "Report");

		$this->form_validation->set_rules('faq_m_id', 'FAQ Module', 'required|trim');
		$this->form_validation->set_rules('faq_ques', 'FAQ Question', 'required|trim|max_length[2000]');
		$this->form_validation->set_rules('faq_ans', 'FAQ Answer', 'required|trim|max_length[4000]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_faq', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('faq_m_id', true),
				"six" => $this->input->post('faq_ques', true),
				"seven" => $this->input->post('faq_ans', true)
			);
			$response = $this->api->call_v_api('setFaqDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New FAQ Added successfully !!');
				redirect(get_module() . '/masters/faq_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_report');
			}
		}

	}

	public function edit_faq()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$faq_det_id = $this->input->get("faq_det_id");
		if (empty($faq_det_id)) {
			$this->session->set_flashdata('error', 'FAQ Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$faq_det_id = base64_decode($faq_det_id);
		if (!is_numeric($faq_det_id)) {
			$this->session->set_flashdata('error', 'FAQ Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$data['page_title'] = "Update FAQ Details";
		$data['action'] = "Edit";
		$data['faq_module_list'] = $this->getFaqDetails(null, "Report");
		$data['faq_det_id'] = $faq_det_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"six" => "Detail",
			"seven" => $faq_det_id
		);
		$details = $this->api->call_v_api('getFaqDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'FAQ  Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$data['faq_details'] = $details[0];

		$this->form_validation->set_rules('faq_m_id', 'FAQ Module', 'required|trim');
		$this->form_validation->set_rules('faq_det_id', 'FAQ Id', 'required|trim');
		$this->form_validation->set_rules('faq_ques', 'FAQ Question', 'required|trim|max_length[2000]');
		$this->form_validation->set_rules('faq_ans', 'FAQ Answer', 'required|trim|max_length[4000]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_faq', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('faq_det_id', true),
				"six" => $this->input->post('faq_m_id', true),
				"seven" => $this->input->post('faq_ques', true),
				"eight" => $this->input->post('faq_ans', true)
			);

			$response = $this->api->call_v_api('setModifyFaqDetails', $params);

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'FAQ Details Updated successfully !!');
				redirect(get_module() . '/masters/faq_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_report');
			}
		}
	}

	public function view_faq()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "FAQ Master Report";
		$faq_det_id = $this->input->get("faq_det_id");
		if (empty($faq_det_id)) {
			$this->session->set_flashdata('error', 'FAQ  Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$faq_det_id = base64_decode($faq_det_id);
		if (!is_numeric($faq_det_id)) {
			$this->session->set_flashdata('error', 'FAQ Details not found');
			redirect(get_module() . '/masters/faq_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"six" => "Detail",
			"seven" => $faq_det_id
		);
		$details = $this->api->call_v_api('getFaqDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'FAQ Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$data['faq_details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_faq', $data);
	}

	public function deactivate_faq()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'FAQ  Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'FAQ  Details not found');
			redirect(get_module() . '/masters/faq_report');
		}
		$data['page_title'] = "Deactivate FAQ";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_faq";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('masters/deactivation_popup', $data, true);
			echo $html;

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateFaqDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'FAQ  Deactivated successfully ');
				redirect(get_module() . '/masters/faq_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/faq_report');
			}
		}
	}


	// Education  Master 
	public function education_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Education Report";
		$status = $this->input->get('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->get('searchStr');
		$data['searchStr'] = $searchStr;
		$data['status'] = $status;
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$data['status_list'] = array("Active", "Deactivated");
		$data['education_list'] = $this->getEducationDetails($type, $status, $srch);
		$this->loadViews(get_module() . '/masters/list_education', $data);

	}

	public function add_education()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Education";
		$data['action'] = "Add";
		$this->form_validation->set_rules('edu_name', 'Education', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_education', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('edu_name', true)
			);
			$response = $this->api->call_v_api('setEducationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Education Added successfully !!');
				redirect(get_module() . '/masters/education_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/education_report');
			}
		}

	}

	public function view_education()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Education Master Report";
		$edu_id = $this->input->get("edu_id");
		if (empty($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$edu_id = base64_decode($edu_id);
		if (!is_numeric($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $edu_id
		);
		$details = $this->api->call_v_api('getEducationDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$data['education_details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_education', $data);

	}

	public function edit_education()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$edu_id = $this->input->get("edu_id");
		if (empty($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$edu_id = base64_decode($edu_id);
		if (!is_numeric($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$data['page_title'] = "Update Education Details";
		$data['action'] = "Edit";


		$data['edu_id'] = $edu_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $edu_id
		);
		$details = $this->api->call_v_api('getEducationDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$data['education_details'] = $details[0];

		$this->form_validation->set_rules('edu_name', 'Education', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_education', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('edu_id', true),
				"six" => $this->input->post('edu_name', true)
			);
			$response = $this->api->call_v_api('setModifyEducationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Education Details Updated successfully !!');
				redirect(get_module() . '/masters/education_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/education_report');
			}
		}

	}

	public function deactivate_education()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$edu_id = $this->input->get("edu_id");
		if (empty($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$edu_id = base64_decode($edu_id);
		if (!is_numeric($edu_id)) {
			$this->session->set_flashdata('error', 'Education Details not found');
			redirect(get_module() . '/masters/education_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $edu_id,
			"six" => "Deactivated"
		);
		$response = $this->api->call_v_api('setDeactivateEducationDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Education Deactivated successfully ');
			redirect(get_module() . '/masters/education_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/education_report');
		}


	}

	// City  Master 
	public function city_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All City Report";
		$data['status_list'] = array("Active", "Deactivated");
		$data['state_list'] = $this->getStateDetails("Report");
		$this->loadViews(get_module() . '/masters/list_city', $data);

	}

	public function add_city()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New City";
		$data['action'] = "Add";
		$data['state_list'] = $this->getStateDetails("Report");

		$this->form_validation->set_rules('state_id', 'State', 'required|trim');
		$this->form_validation->set_rules('dist_id', 'District', 'required|trim');
		$this->form_validation->set_rules('city_name', 'City', 'required|trim|max_length[100]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_city', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('state_id', true),
				"six" => $this->input->post('dist_id', true),
				"seven" => $this->input->post('city_name', true),
			);
			$response = $this->api->call_v_api('setCityDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New City Added successfully !!');
				redirect(get_module() . '/masters/city_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/city_report');
			}
		}

	}

	public function view_city()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "City Master Report";
		$city_id = $this->input->get("city_id");
		if (empty($city_id)) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}
		$city_id = base64_decode($city_id);
		if (!is_numeric($city_id)) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $city_id
		);
		$details = $this->api->call_v_api('getCityDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}
		$data['city_details'] = $details['jsArray'][0];
		$this->loadViews(get_module() . '/masters/view_city', $data);

	}

	public function edit_city()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$city_id = $this->input->get("city_id");
		$data['state_list'] = $this->getStateDetails("Report");
		if (empty($city_id)) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}
		$city_id = base64_decode($city_id);
		if (!is_numeric($city_id)) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}
		$data['page_title'] = "Update City Details";
		$data['action'] = "Edit";
		$data['department_list'] = $this->getDepartmentMasterDetails("Report");

		$data['city_id'] = $city_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $city_id
		);
		$details = $this->api->call_v_api('getCityDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'City Details not found');
			redirect(get_module() . '/masters/city_report');
		}
		$data['city_details'] = $details['jsArray'][0];
		$data['dist_list'] = $this->getDistrictStateIdDetails($details['jsArray'][0]['city_state_id'], "Report");
		$this->form_validation->set_rules('state_id', 'State', 'required|trim');
		$this->form_validation->set_rules('dist_id', 'District', 'required|trim');
		$this->form_validation->set_rules('city_name', 'City', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_city', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('state_id', true),
				"six" => $this->input->post('dist_id', true),
				"seven" => $this->input->post('city_id', true),
				"eight" => $this->input->post('city_name', true)
			);
			$response = $this->api->call_v_api('setModifyCityDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'City Details Updated successfully !!');
				redirect(get_module() . '/masters/city_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/city_report');
			}
		}

	}

	// Area  Master 
	public function area_report($page = 1)
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Area Report";
		$data['state_list'] = $this->getStateDetails();
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_area', $data);

	}
	//20-2-25
	public function add_edit_area1()
	{
		// if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		// 	redirect(get_module().'/dashboard/access_denied');
		// }
		$data['page_title'] = "Add New Area";
		$data['action'] = "Add";
		$data['state_list'] = $this->getStateDetails("Report");
		//20-2-25
		$data['area_list'] = $this->getAreaDetails();
		$this->form_validation->set_rules('state_id', 'State', 'required|trim');
		$this->form_validation->set_rules('dist_id', 'District', 'required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'required|trim');
		$this->form_validation->set_rules('area_name', 'Area', 'required|trim|max_length[100]');


		if ($this->form_validation->run() == FALSE) {
			$this->load->view(get_module() . '/masters/add_area', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('state_id', true),
				"six" => $this->input->post('dist_id', true),
				"seven" => $this->input->post('city_id', true),
				"eight" => $this->input->post('area_name', true),
			);
			$response = $this->api->call_v_api('setAreaDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Area Added successfully !!');
				redirect(get_module() . '/customers/add_customer');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/add_customer');
			}
		}

	}

	public function add_area()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Area";
		$data['action'] = "Add";
		$data['state_list'] = $this->getStateDetails("Report");

		$this->form_validation->set_rules('state_id', 'State', 'required|trim');
		$this->form_validation->set_rules('dist_id', 'District', 'required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'required|trim');
		$this->form_validation->set_rules('area_name', 'Area', 'required|trim|max_length[100]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_area', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('state_id', true),
				"six" => $this->input->post('dist_id', true),
				"seven" => $this->input->post('city_id', true),
				"eight" => $this->input->post('area_name', true),
			);
			$response = $this->api->call_v_api('setAreaDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Area Added successfully !!');
				redirect(get_module() . '/masters/area_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/area_report');
			}
		}

	}

	public function view_area()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Area Master Report";
		$area_id = $this->input->get("area_id");
		if (empty($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$area_id = base64_decode($area_id);
		if (!is_numeric($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $area_id
		);
		$details = $this->api->call_v_api('getAreaDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$data['area_details'] = $details['jsArray'][0];
		$this->loadViews(get_module() . '/masters/view_area', $data);

	}

	public function edit_area()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$area_id = $this->input->get("area_id");
		$data['state_list'] = $this->getStateDetails("Report");
		if (empty($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$area_id = base64_decode($area_id);
		if (!is_numeric($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$data['page_title'] = "Update Area Details";
		$data['action'] = "Edit";
		$data['state_list'] = $this->getStateDetails("Report");

		$data['area_id'] = $area_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $area_id
		);
		$details = $this->api->call_v_api('getAreaDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$data['area_details'] = $details['jsArray'][0];
		;
		$state_id = $data['area_details']['area_state_id'];
		$dist_id = $data['area_details']['area_dist_id'];
		$data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		$city_list = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
		$data['city_list'] = $city_list['jsArray'];

		$this->form_validation->set_rules('state_id', 'State', 'required|trim');
		$this->form_validation->set_rules('dist_id', 'District', 'required|trim');
		$this->form_validation->set_rules('city_id', 'City', 'required|trim');
		$this->form_validation->set_rules('area_name', 'Area', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_area', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('state_id', true),
				"six" => $this->input->post('dist_id', true),
				"seven" => $this->input->post('city_id', true),
				"eight" => $this->input->post('area_id', true),
				"nine" => $this->input->post('area_name', true)
			);
			$response = $this->api->call_v_api('setModifyAreaDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Area Details Updated successfully !!');
				redirect(get_module() . '/masters/area_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/area_report');
			}
		}

	}

	public function deactivate_area()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$area_id = $this->input->get("area_id");
		if (empty($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$area_id = base64_decode($area_id);
		if (!is_numeric($area_id)) {
			$this->session->set_flashdata('error', 'Area Details not found');
			redirect(get_module() . '/masters/area_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $area_id,
			"six" => "Deactivated",
		);
		$response = $this->api->call_v_api('setDeactivateAreaDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Area Deactivated successfully ');
			redirect(get_module() . '/masters/area_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/area_report');
		}


	}

	// Notification  Master 

	public function notification_report()
	{
		$data['page_title'] = "All Notification Report";
		$data['status_list'] = array("Active", "Deactivated");
		$data['noti_type_list'] = array("Today" => "Todays", "Past" => "Past", "Future" => "Future");
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");
		$this->loadViews(get_module() . '/masters/list_notifications', $data);

	}

	public function add_notification()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add Notification";
		$data['action'] = "Add";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$this->form_validation->set_rules('noti_title', 'Notification Title', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('noti_desc', 'Notification Description', 'required|trim|max_length[1000]');
		$this->form_validation->set_rules('noti_from', 'Notification From', 'required|trim');
		$this->form_validation->set_rules('noti_to', 'Notification To', 'required|trim');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_notification', $data);

		} else {
			$post_data = $this->input->post(null, true);
			$noti_from = date("d-M-Y", strtotime($post_data['noti_from']));
			$noti_to = date("d-M-Y", strtotime($post_data['noti_to']));
			$noti_to = strtoupper($noti_to);
			$noti_from = strtoupper($noti_from);
			$permission_ids = $post_data['permission_id'];
			$permission_ids = !empty($permission_ids) ? implode(",", $permission_ids) : Null;

			$noti_img = null;

			if (!empty($_FILES['noti_img']['name'])) {
				$ext = pathinfo($_FILES['noti_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['noti_img']['tmp_name'];
				$noti_img = "NOTI_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $noti_img,
					"five" => base64_encode($img_file_content),
					"six" => "NotificationImg"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['noti_title'],
				"six" => $post_data['noti_desc'],
				"seven" => $permission_ids,
				"eight" => $noti_from,
				"nine" => $noti_to,
				"ten" => $noti_img,
			);

			$response = $this->api->call_v_api('setNotificationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Notification Added successfully !!');
				$this->cache->redis->deleteByPattern('ci_dashboard:notification_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/masters/notification_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/notification_report');
			}
		}

	}




	public function edit_notification()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$noti_id = $this->input->get("noti_id");
		if (empty($noti_id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$noti_id = base64_decode($noti_id);
		if (!is_numeric($noti_id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$data['page_title'] = "Update Notification Details";
		$data['action'] = "Edit";
		$data['permission_list'] = $this->getPermissionMasterDetails("Report");

		$data['noti_id'] = $noti_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $noti_id
		);
		$details = $this->api->call_v_api('getNotificationMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$data['notification_details'] = $details[0];

		$this->form_validation->set_rules('noti_title', 'Notification Title', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('noti_desc', 'Notification Description', 'required|trim|max_length[1000]');
		$this->form_validation->set_rules('noti_from', 'Notification From', 'required|trim');
		$this->form_validation->set_rules('noti_to', 'Notification To', 'required|trim');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_notification', $data);

		} else {

			$post_data = $this->input->post(null, true);

			$noti_from = date("d-M-Y", strtotime($post_data['noti_from']));
			$noti_to = date("d-M-Y", strtotime($post_data['noti_to']));
			$noti_to = strtoupper($noti_to);
			$noti_from = strtoupper($noti_from);
			$permission_ids = $post_data['permission_id'];
			$permission_ids = !empty($permission_ids) ? implode(",", $permission_ids) : Null;


			$old_noti_img = $data['notification_details']['noti_img'];
			$old_noti_img = explode("/", $old_noti_img);
			$noti_img = $old_noti_img[count($old_noti_img) - 1];

			if (!empty($_FILES['noti_img']['name'])) {
				$ext = pathinfo($_FILES['noti_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['noti_img']['tmp_name'];
				$noti_img = "NOTI_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $noti_img,
					"five" => base64_encode($img_file_content),
					"six" => "NotificationImg"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['noti_id'],
				"six" => $post_data['noti_title'],
				"seven" => $post_data['noti_desc'],
				"eight" => $permission_ids,
				"nine" => $noti_from,
				"ten" => $noti_to,
				"eleven" => $noti_img,
				"twelve" => "Modify",
			);
			//print_r($params);die;
			$response = $this->api->call_v_api('setModifyNotificationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Notification Details Updated successfully !!');
				$this->cache->redis->deleteByPattern('ci_dashboard:notification_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/masters/notification_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/notification_report');
			}
		}
	}

	public function view_notification()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Notification Master Report";
		$noti_id = $this->input->get("noti_id");
		if (empty($noti_id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$noti_id = base64_decode($noti_id);
		if (!is_numeric($noti_id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $noti_id
		);
		$details = $this->api->call_v_api('getNotificationMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$data['notification_details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_notification', $data);
	}

	public function deactivate_notification()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Notification Details not found');
			redirect(get_module() . '/masters/notification_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $id,
			"twelve" => "Deactivate",
		);
		$response = $this->api->call_v_api('setModifyNotificationDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Notification Deactivated successfully ');
			$this->cache->redis->deleteByPattern('ci_dashboard:notification_list:' .$this->_user_company_id .':*');
			redirect(get_module() . '/masters/notification_report');
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/notification_report');
		}


	}
	// One Time Service  Master 
	public function one_time_service_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All One Time Service Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_one_time_service', $data);
	}


	public function add_one_time_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add One Time Service";
		$data['action'] = "Add";
		$data['product_list'] = $this->getProductMasterDetails("Report");

		$this->form_validation->set_rules('ots_name', 'Service Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('ots_type', 'Service Type', 'max_length[50]');
		$this->form_validation->set_rules('ots_desc', 'Service Description', 'max_length[500]');
		$this->form_validation->set_rules('ots_gst', 'GST%', 'max_length[4]');
		$this->form_validation->set_rules('price_regular', 'Regular Price', 'max_length[10]');
		$this->form_validation->set_rules('price_comm', 'Commercial Price', 'max_length[10]');
		/* if (empty($_FILES['p_image']['name']))
		{
			$this->form_validation->set_rules('p_image', 'Feature Image', 'required|trim');
		}
		if (empty($_FILES['p_multi_image']['name'][0]))
		{
			$this->form_validation->set_rules('p_multi_image', 'Product Images', 'required|trim');
		}				 */
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_one_time_service', $data);

		} else {
			$post_data = $this->input->post(null, true);
			// Image Upload
			$p_image = null;
			$p_multi_image = null;
			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "OTS_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "OTS"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "OTS_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "OTS"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}
			$p_multi_image = ltrim($p_multi_image, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['prod_id'],
				"six" => $post_data['ots_name'],
				"seven" => $post_data['ots_desc'],
				"eight" => $post_data['ots_type'],
				"nine" => $post_data['ots_gst'],
				"ten" => $post_data['price_regular'],
				"eleven" => $post_data['price_comm'],
				"thirteen" => $p_image,
				"fourteen" => $p_multi_image,
			);
			//echo "<pre/>"; print_r(json_encode($params));die;

			$response = $this->api->call_v_api('setOneTimeServiceMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'New One Time Service Added successfully !!');
				redirect(get_module() . '/masters/one_time_service_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/one_time_service_report');
			}
		}

	}


	public function edit_one_time_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$data['page_title'] = "Update One Time Service";
		$data['action'] = "Edit";
		$data['product_list'] = $this->getProductMasterDetails("Report");

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$data['details'] = $details['jsArray'][0];

		$this->form_validation->set_rules('ots_name', 'Service Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('ots_type', 'ServiceType', 'max_length[50]');
		$this->form_validation->set_rules('ots_desc', 'Service Description', 'max_length[500]');
		$this->form_validation->set_rules('ots_gst', 'GST%', 'max_length[4]');
		$this->form_validation->set_rules('price_regular', 'Regular Price', 'max_length[10]');
		$this->form_validation->set_rules('price_comm', 'Commercial Price', 'max_length[10]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_one_time_service', $data);

		} else {

			$post_data = $this->input->post(null, true);
			// Old Images
			$im_image = $details['jsArray'][0]['ots_img'];
			$im_image = explode("/", $im_image);
			$im_image = $im_image[count($im_image) - 1];


			// Image Upload
			$p_image = $im_image;
			$str_image_list = "";

			$old_imgs = $this->input->post('old_imgs');
			if (!empty($old_imgs)) {
				$str_image_list = implode(",", $old_imgs);

			}

			$p_multi_image = $str_image_list;

			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "OTS_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "OTS"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "OTS_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "OTS"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$p_multi_image = ltrim($p_multi_image, ',');

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['id'],
				"six" => $post_data['prod_id'],
				"seven" => $post_data['ots_name'],
				"eight" => $post_data['ots_desc'],
				"nine" => $post_data['ots_type'],
				"ten" => $post_data['ots_gst'],
				"eleven" => $post_data['price_regular'],
				"twelve" => $post_data['price_comm'],
				"fourteen" => $p_image,
				"fifteen" => $p_multi_image,
			);
			$response = $this->api->call_v_api('setModifyOneTimeServiceMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'One Time Service Details Updated successfully !!');
				redirect(get_module() . '/masters/view_one_time_service/?id=' . base64_encode($response[0]['id']));

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/one_time_service_report');
			}
		}
	}

	public function view_one_time_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$data['page_title'] = "View One Time Service";
		$data['product_list'] = $this->getProductMasterDetails("Report");

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$data['details'] = $details['jsArray'][0];
		$this->loadViews(get_module() . '/masters/view_one_time_service', $data);

	}
	public function deactivate_one_time_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'One Time Service Details not found');
			redirect(get_module() . '/masters/one_time_service_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $id
		);
		$response = $this->api->call_v_api('setDeactivateOneTimeServiceMasterDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'One Time Service Deactivated successfully ');
			redirect(get_module() . '/masters/one_time_service_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/one_time_service_report');
		}


	}

	//   added by anjali reactivate OTS POP-UP 
public function reactivate_one_time_service()
{
    $id = base64_decode($this->input->get('id'));

    $params = array(
        "one"   => $id,
        "two"   => $this->_user_id,
        "three" => "Reactivate",
        "four"  => $this->_user_branch_id,
        "five"  => $this->_user_company_id
    );

    $result = $this->api->call_v_api('reactivateOneTimeService', $params);

//    echo "<pre/>"; print_r($result);die;

    if ($result == "Success") {
        $this->session->set_flashdata('success', 'One Time Service Reactivated Successfully');
    } else {
        $this->session->set_flashdata('error', 'Unable to Reactivate One Time Service');
    }

    redirect(get_module().'/masters/one_time_service_report');
	}

	// AMC Services  Master 
	public function amc_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available AMC Services Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_amc', $data);
	}

// changes done by anjali dhane 22/06/2026 AMC reactivate funtionality

public function reactivate_amc()
{
    $id = base64_decode($this->input->get('id'));

    $params = array(
        "one"   => $id,
        "two"   => $this->_user_id,
        "three" => "Reactivate",
        "four"  => $this->_user_branch_id,
        "five"  => $this->_user_company_id
    );

    $result = $this->api->call_v_api('reactivateAMC', $params);
		// 	echo "<pre>";
		// var_dump($result);
		// exit;
		// echo "<pre/>"; print_r($result);die;

    // $result = trim($result);

    if ($result == "Success") {
        $this->session->set_flashdata('success', 'AMC Reactivated Successfully');
    } else {
        $this->session->set_flashdata('error', 'Unable to Reactivate AMC');
    }

    redirect(get_module().'/masters/amc_report');
}


	public function brand_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Brand Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_brand', $data);
	}

	public function upload_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Upload AMC Data";
		$this->loadViews(get_module() . '/masters/upload_amc', $data);
		if (!empty($_FILES['data_file']['name'])) {

			$file_data = $_FILES['data_file']['tmp_name'];
			$csv_file = new CURLFile($file_data, 'text/csv');
			$params = array(
				"user_id" => $this->_user_id,
				"user_branch_id" => $this->_user_branch_id,
				"user_company_id" => $this->_user_company_id,
				"file" => $csv_file,
			);
			//echo "<pre/>"; print_r($_FILES);die;
			$result = $this->api->upload_v_excel('uploadCustomer', $params);
			$_FILES = array();
			if (empty($result)) {
				$this->session->set_flashdata('success', 'AMC Data Uploaded Successfully !!');
				redirect(get_module() . '/masters/upload_amc');
			} else {
				// $this->session->set_flashdata('success', 'AMC Data not Uploaded Successfully !!');
				$this->session->set_flashdata('error', json_encode($result));
				redirect(get_module() . '/masters/upload_amc');
			}

		}
	}

	public function upload_ots()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Upload OTS Data";
		$this->loadViews(get_module() . '/masters/upload_ots', $data);
		if (!empty($_FILES['data_file']['name'])) {

			$file_data = $_FILES['data_file']['tmp_name'];
			$csv_file = new CURLFile($file_data, 'text/csv');
			$params = array(
				"user_id" => $this->_user_id,
				"user_branch_id" => $this->_user_branch_id,
				"user_company_id" => $this->_user_company_id,
				"file" => $csv_file,
			);
			//echo "<pre/>"; print_r($_FILES);die;
			$result = $this->api->upload_v_excel('uploadCustomer', $params);
			$_FILES = array();
			if (empty($result)) {
				$this->session->set_flashdata('success', 'OTS Data Uploaded Successfully !!');
				redirect(get_module() . '/masters/upload_ots');
			} else {
				$this->session->set_flashdata('error', json_encode($result));
				redirect(get_module() . '/masters/upload_ots');
			}

		}
	}

	public function upload_brand()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Upload Brand Data";
		$this->loadViews(get_module() . '/masters/upload_brand', $data);
		if (!empty($_FILES['data_file']['name'])) {

			$file_data = $_FILES['data_file']['tmp_name'];
			$csv_file = new CURLFile($file_data, 'text/csv');
			$params = array(
				"user_id" => $this->_user_id,
				"user_branch_id" => $this->_user_branch_id,
				"user_company_id" => $this->_user_company_id,
				"file" => $csv_file,
			);
			//echo "<pre/>"; print_r($_FILES);die;
			$result = $this->api->upload_v_excel('uploadBrand', $params);
			// echo "<pre/>"; print_r($result);die;
			$_FILES = array();
			if (empty($result)) {
				$this->session->set_flashdata('success', 'Brand Data Uploaded Successfully !!');
				redirect(get_module() . '/masters/upload_brand');
			} else {
				$this->session->set_flashdata('error', json_encode($result));
				redirect(get_module() . '/masters/upload_brand');
			}

		}
	}


	public function upload_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Upload Product Data";
		$this->loadViews(get_module() . '/masters/upload_product', $data);
		if (!empty($_FILES['data_file']['name'])) {

			$file_data = $_FILES['data_file']['tmp_name'];
			$csv_file = new CURLFile($file_data, 'text/csv');
			$params = array(
				"user_id" => $this->_user_id,
				"user_branch_id" => $this->_user_branch_id,
				"user_company_id" => $this->_user_company_id,
				"file" => $csv_file,
			);
			//echo "<pre/>"; print_r($_FILES);die;
			$result = $this->api->upload_v_excel('uploadCustomer', $params);
			$_FILES = array();
			if (empty($result)) {
				$this->session->set_flashdata('success', 'Product Data Uploaded Successfully !!');
				redirect(get_module() . '/masters/upload_product');
			} else {
				$this->session->set_flashdata('error', json_encode($result));
				redirect(get_module() . '/masters/upload_product');
			}

		}
	}


	public function add_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add AMC Service";
		$data['action'] = "Add";
		$data['product_list'] = $this->getProductMasterDetails("Report");
		$data['amc_list'] = $this->getAMCMasterDetails();
		$data['duration_list'] = $this->getDuartionList();

		$this->form_validation->set_rules('amc_name', 'AMC Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('amc_desc', 'AMC Description', 'max_length[1000]');
		$this->form_validation->set_rules('amc_duration', 'AMC Duration', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('amc_sit', 'Service Interval Time', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('amc_noofservices', 'No. of Services', 'required|trim|max_length[3]');
		$this->form_validation->set_rules('amc_price', 'Regular Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('amc_corporate_price', 'Commercial Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('amc_gst', 'GST%', 'max_length[4]');
		/*  if (empty($_FILES['p_image']['name']))
		 {
			 $this->form_validation->set_rules('p_image', 'Feature Image', 'required|trim');
		 }
		 if (empty($_FILES['p_multi_image']['name'][0]))
		 {
			 $this->form_validation->set_rules('p_multi_image', 'Product Images', 'required|trim');
		 } */

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_amc', $data);

		} else {
			$post_data = $this->input->post(null, true);

			// Image Upload
			$p_image = null;
			$p_multi_image = null;
			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "AMC_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "AMC"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "AMC_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "AMC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}



			$amc_product_id = $post_data['amc_product_id'];
			//$amc_product_id = !empty($amc_product_id)?implode(",",$amc_product_id):Null;
			//$p_multi_image  = ltrim($p_multi_image, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['amc_name'],
				"six" => $post_data['amc_duration'],
				"seven" => $post_data['amc_noofservices'],
				"eight" => $post_data['amc_sit'],
				"nine" => $post_data['amc_price'],
				"ten" => $post_data['amc_corporate_price'],
				"eleven" => $post_data['amc_gst'],
				"twelve" => $post_data['amc_desc'],
				"thirteen" => $amc_product_id,
				"fourteen" => $p_image,
				"fifteen" => $p_multi_image,
			);
			// echo "<pre/>"; print_r(json_encode($params));die;

			$response = $this->api->call_v_api('setAMCDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'New AMC Service Added successfully !!');
				redirect(get_module() . '/masters/amc_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/amc_report');
			}
		}

	}
	public function edit_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$data['page_title'] = "Update AMC Service";
		$data['action'] = "Edit";
		$data['product_list'] = $this->getProductMasterDetails("Report");
		$data['amc_list'] = $this->getAMCMasterDetails();
		$data['duration_list'] = $this->getDuartionList();
		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getAMCDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$data['details'] = $details['jsArray'][0];

		$this->form_validation->set_rules('amc_name', 'AMC Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('amc_desc', 'AMC Description', 'max_length[1000]');
		$this->form_validation->set_rules('amc_duration', 'AMC Duration', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('amc_sit', 'Service Interval Time', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('amc_noofservices', 'No. of Services', 'required|trim|max_length[3]');
		$this->form_validation->set_rules('amc_price', 'Regular Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('amc_corporate_price', 'Commercial Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('amc_gst', 'GST%', 'max_length[4]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_amc', $data);

		} else {
			$post_data = $this->input->post(null, true);

			// Old Images
			$im_image = $details['jsArray'][0]['product_image'];
			$im_image = explode("/", $im_image);
			$im_image = $im_image[count($im_image) - 1];


			// Image Upload
			$p_image = $im_image;
			$str_image_list = "";

			$old_imgs = $this->input->post('old_imgs');
			if (!empty($old_imgs)) {
				$str_image_list = implode(",", $old_imgs);

			}

			$p_multi_image = $str_image_list;

			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "AMC_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "AMC"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "AMC_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "AMC"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}


			$amc_product_id = isset($post_data['amc_product_id']) ? $post_data['amc_product_id'] : "";
			// $amc_product_id = !empty($amc_product_id)?implode(",",$amc_product_id):Null;
			//$p_multi_image  = ltrim($p_multi_image, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['id'],
				"six" => $post_data['amc_name'],
				"seven" => $post_data['amc_duration'],
				"eight" => $post_data['amc_noofservices'],
				"nine" => $post_data['amc_sit'],
				"ten" => $post_data['amc_price'],
				"eleven" => $post_data['amc_corporate_price'],
				"twelve" => $post_data['amc_gst'],
				"thirteen" => $post_data['amc_desc'],
				"fourteen" => $amc_product_id,
				"fifteen" => $p_image,
				"sixteen" => $p_multi_image,
			);
			//echo "<pre/>"; print_r(json_encode($params));die;
			$response = $this->api->call_v_api('setModifyAMCDetails', $params);

			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'AMC Service Details Updated successfully !!');
				redirect(get_module() . '/masters/view_amc/?id=' . base64_encode($response[0]['id']));

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/amc_report');
			}
		}
	}

	public function view_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$data['page_title'] = "View AMC Service";

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getAMCDetails', $params);
		if (empty($details['jsArray'])) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$data['details'] = $details['jsArray'][0];
		$this->loadViews(get_module() . '/masters/view_amc', $data);

	}

	public function deactivate_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'AMC Service Details not found');
			redirect(get_module() . '/masters/amc_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $id
		);
		$response = $this->api->call_v_api('setDeactivateAMCDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'AMC Service Deactivated successfully ');
			redirect(get_module() . '/masters/amc_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/amc_report');
		}


	}

	// AMC Services  Master 
	public function sale_product_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Product Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_product', $data);
	}

	public function add_brand()
	{

		$data['page_title'] = "Add New Brand";
		$data['action'] = "Add";
		$data['url'] = $this->input->get("url");

		$this->form_validation->set_rules('brand_name', 'Brand Name', 'required|trim|max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('masters/add_brand', $data, true);
			echo $html;

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('brand_name', true),
			);
			$response = $this->api->call_v_api('setBrandMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Brand Added successfully !!');
				redirect(get_module() . '/masters/' . $data['url']);

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/' . $data['url']);
			}
		}


	}
	public function add_sale_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add Product";
		$data['action'] = "Add";
		$data['brand_list'] = $this->getBrandMasterDetails("Report");
		$data['duration_list'] = $this->getDuartionList();

		$this->form_validation->set_rules('pdt_name', 'Product Name', 'required|trim|max_length[250]');
		$this->form_validation->set_rules('p_model_name', 'Model Name', 'max_length[250]');
		//$this->form_validation->set_rules('p_brand_id','Brand', 'required|trim|max_length[100]');		
		$this->form_validation->set_rules('pdt_desc', 'Product Details', 'max_length[500]');
		$this->form_validation->set_rules('pdt_regular_price', 'Regular Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('pdt_comm_price', 'Commercial Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('pdt_gst', 'GST%', 'max_length[4]');
		$this->form_validation->set_rules('pdt_hsn_code', 'HSN Code', 'max_length[100]');
		$this->form_validation->set_rules('pdt_warranty_period', 'Warrenty Period', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('p_noofservices', 'No. of Free Services', 'required|trim|max_length[3]');
		$this->form_validation->set_rules('p_sit', 'Service Interval Time', 'required|trim|max_length[4]');

		/* if (empty($_FILES['p_image']['name']))
	   {
		   $this->form_validation->set_rules('p_image', 'Feature Image', 'required|trim');
	   }
	   if (empty($_FILES['p_multi_image']['name'][0]))
	   {
		   $this->form_validation->set_rules('p_multi_image', 'Product Images', 'required|trim');
	   } */

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_product', $data);

		} else {
			$post_data = $this->input->post(null, true);
			// Image Upload
			$p_image = null;
			$p_multi_image = null;
			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "PROD_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "Product"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "PROD_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "Product"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}
			$p_multi_image = ltrim($p_multi_image, ',');
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['pdt_name'],
				"six" => $post_data['pdt_desc'],
				"seven" => $post_data['pdt_warranty_period'],
				"eight" => NUll,
				"nine" => $post_data['pdt_gst'],
				"ten" => $post_data['pdt_regular_price'],
				"eleven" => $post_data['pdt_comm_price'],
				"twelve" => $post_data['pdt_hsn_code'],
				"thirteen" => $post_data['p_brand_id'],
				"fourteen" => $post_data['p_model_name'],
				"fifteen" => Null,
				"sixteen" => Null,
				"seventeen" => $post_data['p_sit'],
				"eighteen" => $post_data['p_noofservices'],
				"nineteen" => $p_image,
				"twenty" => $p_multi_image,
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setProductMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'New Product Added successfully !!');
				redirect(get_module() . '/masters/sale_product_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/sale_product_report');
			}
		}

	}
	public function edit_sale_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$data['page_title'] = "Update Product";
		$data['action'] = "Edit";
		$data['brand_list'] = $this->getBrandMasterDetails("Report");
		$data['duration_list'] = $this->getDuartionList();
		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getProductMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$data['details'] = $details['jsArray'][0];

		$this->form_validation->set_rules('pdt_name', 'Product Name', 'required|trim|max_length[250]');
		$this->form_validation->set_rules('p_model_name', 'Model Name', 'max_length[250]');
		//$this->form_validation->set_rules('p_brand_id','Brand', 'required|trim|max_length[100]');		
		$this->form_validation->set_rules('pdt_desc', 'Product Details', 'max_length[500]');
		$this->form_validation->set_rules('pdt_regular_price', 'Regular Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('pdt_comm_price', 'Commercial Price', 'max_length[10]|numeric');
		$this->form_validation->set_rules('pdt_gst', 'GST%', 'max_length[4]');
		$this->form_validation->set_rules('pdt_hsn_code', 'HSN Code', 'max_length[100]');
		$this->form_validation->set_rules('pdt_warranty_period', 'Warrenty Period', 'required|trim|max_length[4]');
		$this->form_validation->set_rules('p_noofservices', 'No. of Free Services', 'required|trim|max_length[3]');
		$this->form_validation->set_rules('p_sit', 'Service Interval Time', 'required|trim|max_length[4]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_product', $data);

		} else {
			$post_data = $this->input->post(null, true);
			// Old Images
			$im_image = $details['jsArray'][0]['pm_img'];
			$im_image = explode("/", $im_image);
			$im_image = $im_image[count($im_image) - 1];


			// Image Upload
			$p_image = $im_image;
			$str_image_list = "";

			$old_imgs = $this->input->post('old_imgs');
			if (!empty($old_imgs)) {
				$str_image_list = implode(",", $old_imgs);

			}

			$p_multi_image = $str_image_list;

			if (!empty($_FILES['p_multi_image']['name'][0])) {
				foreach ($_FILES["p_multi_image"]["tmp_name"] as $key => $tmp_name) {
					$file_name = $_FILES["p_multi_image"]["name"][$key];
					$file_tmp = $_FILES["p_multi_image"]["tmp_name"][$key];

					$ext = pathinfo($file_name, PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile = $file_tmp;
					$p_img = "PROD_IMAGES_" . $key . date("YmdHis") . "." . $ext;
					$p_multi_image = $p_multi_image . "," . $p_img;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array(
						"one" => $this->_user_id,
						"two" => $this->_user_branch_id,
						"three" => $this->_user_company_id,
						"four" => $p_img,
						"five" => base64_encode($img_file_content),
						"six" => "Product"
					);
					$response = $this->api->call_v_api('uploadBitmap', $upload_params);

				}
			}
			if (!empty($_FILES['p_image']['name'])) {
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile = $_FILES['p_image']['tmp_name'];
				$p_image = "PROD_IMAGE_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $p_image,
					"five" => base64_encode($img_file_content),
					"six" => "Product"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$p_multi_image = ltrim($p_multi_image, ',');

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $post_data['id'],
				"six" => $post_data['pdt_name'],
				"seven" => $post_data['pdt_desc'],
				"eight" => $post_data['pdt_warranty_period'],
				"nine" => NUll,
				"ten" => $post_data['pdt_gst'],
				"eleven" => $post_data['pdt_regular_price'],
				"twelve" => $post_data['pdt_comm_price'],
				"thirteen" => $post_data['pdt_hsn_code'],
				"fourteen" => $post_data['p_brand_id'],
				"fifteen" => $post_data['p_model_name'],
				"sixteen" => Null,
				"seventeen" => Null,
				"eighteen" => $post_data['p_sit'],
				"nineteen" => $post_data['p_noofservices'],
				"twenty" => $p_image,
				"twentyone" => $p_multi_image,
			);
			$response = $this->api->call_v_api('setModifyProductMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'Product Details Updated successfully !!');
				redirect(get_module() . '/masters/view_sale_product/?id=' . base64_encode($response[0]['id']));

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/sale_product_report');
			}
		}
	}

	public function view_sale_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$data['page_title'] = "View Product Details";
		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $id
		);
		$details = $this->api->call_v_api('getProductMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$data['details'] = $details['jsArray'][0];
		$this->loadViews(get_module() . '/masters/view_product', $data);

	}
	public function deactivate_sale_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Product Details not found');
			redirect(get_module() . '/masters/sale_product_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $id
		);
		$response = $this->api->call_v_api('setDeactivateProductMasterDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Product Deactivated successfully ');
			redirect(get_module() . '/masters/sale_product_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/sale_product_report');
		}


	}

	 //added by anjali reactivate Product funtionality
			public function reactivate_sale_product()
		{
			if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
				redirect(get_module() . '/dashboard/access_denied');
			}

			$id = $this->input->get("id");

			if (empty($id)) {
				$this->session->set_flashdata('error', 'Product Details not found');
				redirect(get_module() . '/masters/sale_product_report');
			}

			$id = base64_decode($id);

			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Product Details not found');
				redirect(get_module() . '/masters/sale_product_report');
			}

			$params = array(
				"one"   => $id,
				"two"   => $this->_user_id,
				"three" => "Reactivate",
				"four"  => $this->_user_branch_id,
				"five"  => $this->_user_company_id
			);

			$response = $this->api->call_v_api('reactivateSaleProduct', $params);

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Product Reactivated Successfully');
			} else {
				$this->session->set_flashdata('error', 'Unable to Reactivate Product');
			}

			redirect(get_module() . '/masters/sale_product_report');
		}


	public function download_product_report()
	{

		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
		);

		$result = $this->api->call_v_api('downloadProductMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Product_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);

	}

	public function download_amc_report()
	{
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
		);

		$result = $this->api->call_v_api('downloadAMCMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="AMC_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);

	}

	public function download_ots_report()
	{
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
		);

		$result = $this->api->call_v_api('downloadOTSMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="OTS_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);

	}

	/*  // Invoice Pattern  Master 
	public function invoice_pattern_report()
	{
		$data['page_title']       = "Invoice Pattern Report";
		  $data['status_list']      = array("Active","Deactivated");
		 $this->loadViews(get_module().'/masters/list_invoice_pattern',$data);
	}


	public function add_invoice_pattern()
	{
		$data['page_title']  = "Add Invoice Pattern";				
		$data['action']  	 = "Add";	

		$this->form_validation->set_rules('invoice_pattern','Invoice Pattern', 'required|trim|max_length[100]');

		if (empty($_FILES['invoice_pattern_img']['name']))
		{
			$this->form_validation->set_rules('invoice_pattern_img', 'Invoice Pattern Image', 'required|trim');
		}

		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/masters/add_edit_invoice_pattern', $data);				

		}
		else 
		{ 
			$post_data      = $this->input->post(null,true);

			 // Image Upload
			$invoice_pattern_img 	   = null;

			if (!empty($_FILES['invoice_pattern_img']['name']))
			{
				$ext = pathinfo($_FILES['invoice_pattern_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile     = $_FILES['invoice_pattern_img']['tmp_name'];
				$invoice_pattern_img = "INVOICE_IMAGE_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$invoice_pattern_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"Invoice_Pattern"
										);
			  $response = $this->api->call_v_api('uploadBitmap',$upload_params);
			}

			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$post_data['invoice_pattern'],
							"six"=>$invoice_pattern_img);

		   //echo "<pre/>"; print_r(json_encode($params));die;
			   $response = $this->api->call_v_api('setMauliInvoicePatternMasterDetails',$params);
			if($response =="Success"){
					$this->session->set_flashdata('success', 'New Invoice Pattern Added successfully !!');
					redirect(get_module().'/masters/invoice_pattern_report');

			} else{
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/masters/invoice_pattern_report');
			}
		}

	}
	public function edit_invoice_pattern()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
			$data['page_title']  = "Update Invoice_Pattern";
			$data['action']  	 = "Edit";		
			$data['id']          = $id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"five"=>"Detail",
							"six"=>$id);
			$details = $this->api->call_v_api('getMauliInvoicePatternMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
				redirect(get_module().'/masters/invoice_pattern_report');
			} 
			$data['details']  = $details[0];

			$this->form_validation->set_rules('invoice_pattern','Invoice Pattern', 'required|trim|max_length[100]');		

			if($this->form_validation->run() == FALSE)
			{
				$this->loadViews(get_module().'/masters/add_edit_invoice_pattern', $data);				

			}
			else 
			{ 
				$post_data      = $this->input->post(null,true);

				// Old Images
				$invoice_pattern_img       = $details[0]['invoice_pattern_img'];		
				$invoice_pattern_img  	   = explode("/",$invoice_pattern_img);
				$invoice_pattern_img       = $invoice_pattern_img[count($invoice_pattern_img)-1];


				if (!empty($_FILES['invoice_pattern_img']['name']))
			{
				$ext = pathinfo($_FILES['invoice_pattern_img']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile     = $_FILES['invoice_pattern_img']['tmp_name'];
				$invoice_pattern_img = "INVOICE_IMAGE_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$invoice_pattern_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"Invoice_Pattern"
										);
			  $response = $this->api->call_v_api('uploadBitmap',$upload_params);
			}


				 $params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$post_data['id'],
							"six"=>$post_data['invoice_pattern'],
							"seven"=>$invoice_pattern_img);

				//echo "<pre/>"; print_r(json_encode($params));die;
				   $response = $this->api->call_v_api('setModifyMauliInvoicePatternMasterDetails',$params);

				if($response =="Success"){
						$this->session->set_flashdata('success', 'Invoice Pattern Details Updated successfully !!');
						 redirect(get_module().'/masters/invoice_pattern_report');

				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						 redirect(get_module().'/masters/invoice_pattern_report');
				}
			}
	}

	public function view_invoice_pattern()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
			$data['page_title']   = "View Invoice Pattern Details ";

			$data['id'] = $id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"five"=>"Detail",
							"six"=>$id);
			$details = $this->api->call_v_api('getMauliInvoicePatternMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
				redirect(get_module().'/masters/invoice_pattern_report');
			} 
			$data['details']  = $details[0];
			$this->loadViews(get_module().'/masters/view_invoice_pattern', $data);	

	}
	public function deactivate_invoice_pattern()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Invoice Pattern Details not found');
			redirect(get_module().'/masters/invoice_pattern_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$id		
		);
		$response = $this->api->call_v_api('setDeactivateMauliInvoicePatternMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Invoice Pattern Deactivated successfully ');
					redirect(get_module().'/masters/invoice_pattern_report');

			} else{
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/masters/invoice_pattern_report');
			}


	}

	 // Company Type  Master 
	public function company_type_report()
	{
		$data['page_title']       = "Company Type Report";
		  $data['status_list']      = array("Active","Deactivated");
		 $this->loadViews(get_module().'/masters/list_company_type',$data);
	}


	public function add_company_type()
	{
		$data['page_title']  = "Add Company Type";				
		$data['action']  	 = "Add";	
		$data['service_list']  	 = $this->getServiceType();	

		$this->form_validation->set_rules('total_amount','Total Amount', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('cust_service_type','Service Type', 'required|trim');
		$this->form_validation->set_rules('service_id','Service', 'required|trim');
		$this->form_validation->set_rules('name','Company Type', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('desc','Description', 'required|trim|max_length[500]');

		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/masters/add_edit_company_type', $data);				

		}
		else 
		{ 
			$post_data         = $this->input->post(null,true);
			$cust_service_type = $post_data['cust_service_type'];
			$total_amount      = $post_data['total_amount'];
			$service_id = $post_data['service_id'];
			$ots_id     = Null;
			$amc_id     = Null;
			$product_id = Null;
			if($cust_service_type=="AMC"){
				$amc_id = $service_id;
			}
			if($cust_service_type=="One Time Service"){
				$ots_id = $service_id;
			}
			if($cust_service_type=="Sales"){
				$product_id = $service_id;
			}
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$post_data['name'],
							"five"=>$post_data['desc'],
							"six"=>$post_data['cust_service_type'],
							"seven"=>$ots_id,
							"eight"=>$amc_id,
							"nine"=>$product_id,
							"ten"=>$total_amount,
							);

		   //echo "<pre/>"; print_r(json_encode($params));die;
			   $response = $this->api->call_v_api('setCompanyTypeMasterDetails',$params);
			if($response =="Success"){
					$this->session->set_flashdata('success', 'New Company Type Added successfully !!');
					redirect(get_module().'/masters/company_type_report');

			} else{
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/masters/company_type_report');
			}
		}

	}
	public function edit_company_type()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
			$data['page_title']  = "Update Company Type";
			$data['action']  	 = "Edit";
			$data['service_list']= $this->getServiceType();				
			$data['id']          = $id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"five"=>$id,
							);
			$details = $this->api->call_v_api('getCompanyTypeReportDetails',$params);
			if(empty($details['jsArray'])){
				$this->session->set_flashdata('error', 'Company Type Details not found');
				redirect(get_module().'/masters/company_type_report');
			} 
			$data['details']   = $details['jsArray'][0];
			$service_type      = $details['jsArray'][0]['ctm_type'];
			$ctm_amc_id        = $details['jsArray'][0]['ctm_amc_id'];
			$ctm_product_id    = $details['jsArray'][0]['ctm_product_id'];
			$ctm_ots_id        = $details['jsArray'][0]['ctm_ots_id'];

			$html   = "";
			 if($service_type == "AMC"){
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>"Active",
								"five"=>"Report");

				  $result = $this->api->call_v_api('getAMCDetails',$params);
				  $list = $result['jsArray'];
				  $html .= "<option value=''> Select AMC</option>";
				 if(!empty($list)){
				  foreach($list as $key=>$item)
				  {
					   $select = $ctm_amc_id == $item['amc_id']?"selected":"";

					   $html .= "<option value='".$item['amc_id']."' data-name='".$item['amc_name']."' data-amount='".$item['amc_corporate_price']."' ".$select.">".$item['amc_name']."</option>";



				  }					  
				  }

			   }
			   if($service_type == "One Time Service"){
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>"Active",
								"five"=>"Report");

				  $result = $this->api->call_v_api('getOneTimeServiceMasterDetails',$params);
				  $list = $result['jsArray'];
				  $html .= "<option value=''> Select One Time Service</option>";
				 if(!empty($list)){				  
					  foreach($list as $key=>$item)
					  {
						  $select = $ctm_ots_id == $item['ots_id']?"selected":"";
						  $html .= "<option value='".$item['ots_id']."' data-name='".$item['ots_name']."' data-amount='".$item['ots_commerial']."'  ".$select.">".$item['ots_name']."</option>";

					  }					  
				  }					  
			   }
			   if($service_type == "Sales"){
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>"Active",
								"five"=>"Report");

				  $result = $this->api->call_v_api('getProductMasterDetails',$params);
				  $list = $result['jsArray']; 
				  $html .= "<option value=''> Select Product</option>";
				  if(!empty($list)){
					 foreach($list as $key=>$item)
					  {
							$select = $ctm_product_id == $item['pm_id']?"selected":"";
							$html .= "<option value='".$item['pm_id']."' data-name='".$item['pm_name']."' data-amount='".$item['pm_commercial_price']."' ".$select.">".$item['pm_name']."</option>";

					  }					  				  
					 }					  				  
				 }

			$data['service_id_html'] = $html;
			$this->form_validation->set_rules('total_amount','Total Amount', 'required|trim|max_length[8]');
			$this->form_validation->set_rules('cust_service_type','Service Type', 'required|trim');
			$this->form_validation->set_rules('service_id','Service', 'required|trim');
			$this->form_validation->set_rules('name','Company Type', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('desc','Description', 'required|trim|max_length[500]');	

			if($this->form_validation->run() == FALSE)
			{
				$this->loadViews(get_module().'/masters/add_edit_company_type', $data);				

			}
			else 
			{ 
				$post_data      = $this->input->post(null,true);
				$total_amount      = $post_data['total_amount'];
				$cust_service_type = $post_data['cust_service_type'];
				$service_id = $post_data['service_id'];
				$ots_id     = Null;
				$amc_id     = Null;
				$product_id = Null;
				if($cust_service_type=="AMC"){
					$amc_id = $service_id;
				}
				if($cust_service_type=="One Time Service"){
					$ots_id = $service_id;
				}
				if($cust_service_type=="Sales"){
					$product_id = $service_id;
				}


				$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$id,
							"five"=>$post_data['name'],
							"six"=>$post_data['desc'],
							"seven"=>$post_data['cust_service_type'],
							"eight"=>$ots_id,
							"nine"=>$amc_id,
							"ten"=>$product_id,
							"eleven"=>$total_amount,
							);

				//echo "<pre/>"; print_r(json_encode($params));die;
				   $response = $this->api->call_v_api('setModifyCompanyTypeMasterDetails',$params);

				if($response =="Success"){
						$this->session->set_flashdata('success', 'Company Type Details Updated successfully !!');
						 redirect(get_module().'/masters/company_type_report');

				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						 redirect(get_module().'/masters/company_type_report');
				}
			}
	}

	public function view_company_type()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
			$data['page_title']   = "View Invoice Pattern Details ";

			$data['id'] = $id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"five"=>$id,
							);
			$details = $this->api->call_v_api('getCompanyTypeReportDetails',$params);
			if(empty($details['jsArray'])){
				$this->session->set_flashdata('error', 'Company Type Details not found');
				redirect(get_module().'/masters/company_type_report');
			} 
			$data['details']  = $details['jsArray'][0];
			$this->loadViews(get_module().'/masters/view_company_type', $data);	

	}
	public function deactivate_company_type()
	{
		$id  = $this->input->get("id");	
		if(empty($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
		$id = base64_decode($id);
		if(!is_numeric($id))
		{
			$this->session->set_flashdata('error', 'Company Type Details not found');
			redirect(get_module().'/masters/company_type_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$id,
		"five"=>"Deactivated"		
		);
		$response = $this->api->call_v_api('setDeactivateCompanyTypeMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Company Type Deactivated successfully ');
					redirect(get_module().'/masters/company_type_report');

			} else{
					$this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/masters/company_type_report');
			}


	} */
	// Terms And Conditions  Master 
	public function terms_n_conditions_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Terms And Conditions Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_tc', $data);

	}

	public function add_terms_n_conditions()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Terms And Conditions";
		$data['action'] = "Add";
		$this->form_validation->set_rules('terms_hdr', 'Header', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('terms_desc', 'Description', 'required|trim|max_length[500]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_tc', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $this->input->post('terms_hdr', true),
				"six" => $this->input->post('terms_desc', false),
			);

			$response = $this->api->call_v_api('setTermsAndConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Terms And Conditions Added successfully !!');
				redirect(get_module() . '/masters/terms_n_conditions_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/terms_n_conditions_report');
			}
		}

	}

	public function view_terms_n_conditions()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Terms And Conditions Master Report";
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ref_id
		);
		$details = $this->api->call_v_api('getTermsAndConditionDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$data['details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_tc', $data);

	}

	public function edit_terms_n_conditions()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$data['page_title'] = "Update Terms And Conditions Details";
		$data['action'] = "Edit";
		$data['ref_id'] = $ref_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ref_id
		);
		$details = $this->api->call_v_api('getTermsAndConditionDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$data['details'] = $details[0];


		$this->form_validation->set_rules('terms_hdr', 'Header', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('terms_desc', 'Description', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_tc', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => $this->input->post('terms_hdr', true),
				"seven" => $this->input->post('terms_desc', false),
			);
			$response = $this->api->call_v_api('setModifyTermsAndConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Terms And Conditions Details Updated successfully !!');
				redirect(get_module() . '/masters/terms_n_conditions_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/terms_n_conditions_report');
			}
		}

	}

	public function deactivate_terms_n_conditions()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Terms And Conditions Details not found');
			redirect(get_module() . '/masters/terms_n_conditions_report');
		}
		$data['page_title'] = "Deactivate Terms And Conditions";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_terms_n_conditions";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('masters/deactivation_popup', $data, true);
			echo $html;

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateTermsAndConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Terms And Conditions Deactivated successfully ');
				redirect(get_module() . '/masters/terms_n_conditions_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/terms_n_conditions_report');
			}
		}
	}


	// Invoice Terms And Conditions  Master 
	public function invoice_tc_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Available Invoice Terms And Conditions Report";
		$data['status_list'] = array("Active", "Deactivated");
		$this->loadViews(get_module() . '/masters/list_invoice_tc', $data);

	}

	public function add_invoice_tc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add New Invoice Terms And Conditions";
		$data['action'] = "Add";
		$this->form_validation->set_rules('terms_hdr', 'Header', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('terms_desc', 'Description', 'max_length[500]');
		$this->form_validation->set_rules('footer1', 'Footer1', 'max_length[100]');
		$this->form_validation->set_rules('footer2', 'Footer2', 'max_length[100]');
		$this->form_validation->set_rules('footer3', 'Footer3', 'max_length[100]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_invoice_tc', $data);

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => NULL,
				"six" => $this->input->post('terms_hdr', true),
				"seven" => $this->input->post('terms_desc', true),
				"eight" => $this->input->post('footer1', true),
				"nine" => $this->input->post('footer2', true),
				"ten" => $this->input->post('footer3', true),
			);
			//log_message("error",json_encode($params));
			$response = $this->api->call_v_api('setInvoiceTermsConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Invoice Terms And Conditions Added successfully !!');
				redirect(get_module() . '/masters/invoice_tc_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/invoice_tc_report');
			}
		}

	}

	public function view_invoice_tc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Invoice Terms And Conditions Master Report";
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ref_id
		);
		$details = $this->api->call_v_api('getInvoiceTermsConditionDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$data['details'] = $details[0];
		$this->loadViews(get_module() . '/masters/view_invoice_tc', $data);

	}

	public function edit_invoice_tc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$data['page_title'] = "Update Invoice Terms And Conditions Details";
		$data['action'] = "Edit";
		$data['ref_id'] = $ref_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ref_id
		);
		$details = $this->api->call_v_api('getInvoiceTermsConditionDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$data['details'] = $details[0];


		$this->form_validation->set_rules('terms_hdr', 'Header', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('terms_desc', 'Description', 'required|trim|max_length[500]');
		$this->form_validation->set_rules('footer1', 'Footer1', 'max_length[100]');
		$this->form_validation->set_rules('footer2', 'Footer2', 'max_length[100]');
		$this->form_validation->set_rules('footer3', 'Footer3', 'max_length[100]');
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/masters/add_edit_invoice_tc', $data);

		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => NULL,
				"seven" => $this->input->post('terms_hdr', true),
				"eight" => $this->input->post('terms_desc', true),
				"nine" => $this->input->post('footer1', true),
				"ten" => $this->input->post('footer2', true),
				"eleven" => $this->input->post('footer3', true),
			);
			$response = $this->api->call_v_api('setModifyInvoiceTermsConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Invoice Terms And Conditions Details Updated successfully !!');
				redirect(get_module() . '/masters/invoice_tc_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/invoice_tc_report');
			}
		}

	}

	public function deactivate_invoice_tc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Invoice Terms And Conditions Details not found');
			redirect(get_module() . '/masters/invoice_tc_report');
		}
		$data['page_title'] = "Deactivate Invoice Terms & Conditions";
		$data['ref_id'] = $ref_id;
		$data['action'] = "deactivate_invoice_tc";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view('masters/deactivation_popup', $data, true);
			echo $html;

		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $ref_id,
				"six" => $this->input->post('reason', true),
			);
			$response = $this->api->call_v_api('setDeactivateInvoiceTermsConditionDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Invoice Terms And Conditions Deactivated successfully ');
				redirect(get_module() . '/masters/invoice_tc_report');

			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/masters/invoice_tc_report');
			}
		}
	}



	/************ Functions ***********/
	public function getServiceType()
	{
		$list = array(
			"AMC" => "AMC",
			"One Time Service" => "One Time Service",
			"Sales" => "Sales",
		);
		return $list;
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

	public function getReferenceByDetails($ref_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $ref_id,
		);
		$response = $this->api->call_v_api('getReferenceByDetails', $params);
		return $response['jsArray'];
	}

	public function getSubdepartmentDetails($type = NULL, $status = "Active", $sub_dept_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $sub_dept_id
		);
		$response = $this->api->call_v_api('getSubdepartmentDetails', $params);
		return $response;
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

	public function getFaqModuleDetails($permission_id = NULL, $type = NULL, $status = "Active", $faq_module_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $faq_module_id,
			"seven" => $permission_id
		);
		$response = $this->api->call_api('getFaqModuleDetails', $params);
		return $response;
	}

	public function getFaqDetails($faq_m_id = NULL, $type = NULL, $status = "Active", $faq_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $faq_m_id,
			"five" => $status,
			"six" => $type,
			"seven" => $faq_id
		);
		$response = $this->api->call_api('getFaqDetails', $params);
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


	public function getCityDetails($type = NULL, $status = "Active", $city_id = NULL, $page = NULL, $total_count = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $city_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$response = $this->api->call_v_api('getCityDetails', $params);
		return $response;
	}

	public function getAreaDetails($type = NULL, $status = "Active", $area_id = NULL, $page = NULL, $total_count = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $area_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$response = $this->api->call_v_api('getAreaDetails', $params);
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

	public function getNotificationDetails($type = NULL, $date = NULL, $page = NULL, $total_count = NULL)
	{
		$cust_id = NULL;
		$emp_id = NULL;
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : "";
		$role_id = $this->_role_id;
		if ($role_id == CUSTOMER_ROLE_ID) {
			$cust_id = $this->_user_cust_id;
		} else {
			$emp_id = $this->_user_emp_id;

		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $role_id,
			"five" => $emp_id,
			"six" => $cust_id,
			"seven" => $type,
			"eight" => $date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$response = $this->api->call_v_api('getNotificationDetails', $params);
		return $response;
	}

	public function getProductMasterDetails($type = NULL, $status = "Active", $pm_id_name = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $pm_id_name,
		);
		$response = $this->api->call_v_api('getProductMasterDetails01', $params);
		return $response['jsArray'];
	}

	public function getBrandMasterDetails($type = NULL, $status = "Active", $pm_id_name = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $pm_id_name,
		);
		$response = $this->api->call_v_api('getBrandMasterDetails', $params);
		return $response;
	}

	public function getDuartionList()
	{
		$list = array(
			"30" => "Monthly",
			"90" => "3 Months",
			"180" => "6 Months",
			"365" => "1 Year",
			"730" => "2 Years",
			"1095" => "3 Years",
			"1460" => "4 Years",
			"1825" => "5 Years",

		);
		return $list;
	}
	public function check_access($class = Null, $method = Null)
	{
		return true;

	}

	public function getAMCMasterDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);

		$response = $this->api->call_v_api('getAMCDetails01', $params);
		$response = $response['jsArray'];
		return $response;
	}

	public function getOneTimeServiceMasterDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);

		$response = $this->api->call_v_api('getOneTimeServiceMasterDetails01', $params);
		$response = $response['jsArray'];
		return $response;
	}

	
	public function cheque_report()
	{
		$data['page_title'] = "Cheque Report";
		$data['status_list']= array("Active","Deactivated");
		$params = array(
			"one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id
		);

		$data['cheque_list'] = $this->api->call_v_api('getChequeReport',$params);

		$this->loadViews(get_module().'/masters/list_cheque', $data);
	}

		public function add_cheque()
	{
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}

		$data['page_title']  = "Add New Cheque";				
		$data['action']  	 = "Add";		

		// ✅ Validation
		$this->form_validation->set_rules('customer_name','Customer Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('amount','Amount', 'required|trim|max_length[20]');
		$this->form_validation->set_rules('cheque_date','Cheque Date', 'required|trim');
		$this->form_validation->set_rules('bank_name','Bank Name', 'required|trim|max_length[50]');

		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/masters/add_edit_cheque', $data);				
		}
		else 
		{ 
			$cheque_date =  $this->input->post('cheque_date',true);
			
            $date = !empty($cheque_date)?strtoupper(date("d-M-Y",strtotime($cheque_date))):"";

			$params = array(
				"one"   => $this->_user_id,
				"two"   => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four"  => $this->_user_emp_id,
				"five"  => $this->input->post('customer_name',true),
				"six"   => $this->input->post('amount',true),
				"seven" => $date,
				"eight" => $this->input->post('bank_name',true)
			);
			
			$response = $this->api->call_v_api('setChequeDetails',$params);	
			// echo "<pre/>"; print_r( $response);die;
			if($response=="Success"){
				$this->session->set_flashdata('success', 'Cheque Added successfully !!');
				redirect(get_module().'/masters/cheque_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module().'/masters/cheque_report');
			}
		}
	}

	public function print_cheque()
	{
		$id = $this->input->get("cheque_id");

		if(empty($id)) {
			redirect(get_module().'/masters/cheque_report');
		}

		$id = base64_decode($id);

		if(!is_numeric($id)) {
			redirect(get_module().'/masters/cheque_report');
		}

		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four"  => $id
		);
		// echo "<pre/>"; print_r( $params);die;
		$response = $this->api->call_v_api('downloadChequeDetails', $params);

		header('Content-Disposition: inline; filename="Cheque_'.date("Y-m-d-h-i-s").'.pdf"');
		header('Content-Type: application/pdf');

		echo $response;
	}

		public function deactivate_cheque()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$cheque_id = $this->input->get("cheque_id");
		if (empty($cheque_id)) {
			$this->session->set_flashdata('error', 'Cheque Details not found');
			redirect(get_module() . '/masters/cheque_report');
		}
		$cheque_id = base64_decode($cheque_id);
		if (!is_numeric($cheque_id)) {
			$this->session->set_flashdata('error', 'Cheque Details not found');
			redirect(get_module() . '/masters/cheque_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $cheque_id,
			"six" => "Deactivated",
		);
		$response = $this->api->call_v_api('setDeactivateChequeByDetails', $params);
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Cheque Deactivated successfully ');
			redirect(get_module() . '/masters/cheque_report');

		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/masters/cheque_report');
		}


	}
	
}



// Terms & Condtions  Master 
// public function terms_condition_list()
// {
// 	if(!$this->isSuperAdmin())
// 	{
// 		redirect('admin/access_denied');

// 	}  else {
// 		$data['page_title']    = "Terms & Condtions List";	
// 		$searchStr    		   = $this->input->post('searchStr');			
// 		$data['searchStr']     = $searchStr;
// 		$searchStr             = addslashes($searchStr);			
// 		$data['tc_list']       = $this->getTermsConditionsDetails($searchStr);        
// 		$this->loadViews('admin/masters/tc_list',$data); 
// 	}

// }

// public function add_terms_condition()
// {
// 	if(!$this->isSuperAdmin())
// 	{
// 		redirect('admin/access_denied');
// 	}  else {
// 	$data['page_title']  = "Add New Terms & Condtions";				
// 	$data['action']  	 = "Add";	
// 	$this->form_validation->set_rules('tc_header','Header', 'required|trim|max_length[100]');
// 	$this->form_validation->set_rules('tc_desc','Description', 'required|trim|max_length[1000]');					
// 	if($this->form_validation->run() == FALSE)
// 	{
// 		$this->load->view('admin/masters/add_edit_tc', $data);				

// 	}
// 	else 
// 	{ 
// 		   $params = array("one"=>$this->_user_id,
// 						"two"=>$this->_user_branch_id,
// 						"three"=>$this->_user_company_id,
// 						"four"=>$this->_user_emp_id,
// 						"five"=>$this->input->post('tc_header'),
// 						"six"=>$this->input->post('tc_desc')
// 						);
// 		$response = $this->api->call_api('setTermsConditionsDetails',$params);	
// 		if($response=="Success"){
// 				$this->session->set_flashdata('success', 'New Terms & Condtions Added successfully !!');
// 				redirect('admin/masters/terms_condition_list');

// 		} else{
// 				$this->session->set_flashdata('error', 'Error: Please try after some time');
// 				redirect('admin/masters/terms_condition_list');
// 		}
// 	}
// 	}

// }

// public function edit_terms_condition($tc_id = null)
// {
// 	if(!$this->isSuperAdmin())
// 	{
// 		redirect('admin/access_denied');
// 	}  else {
// 	$data['page_title']  = "Edit Terms & Condtions Details";	
// 	$data['action']  	 = "Edit";		

// 	if(empty($tc_id)) {
// 		$this->session->set_flashdata('error', 'Terms & Condtions Not Found ');
// 		redirect('admin/masters/terms_condition_list');
// 	} else {

// 		$data['tc_id'] = $tc_id;	
// 		$params = array("one"=>$this->_user_id,
// 						"two"=>$this->_user_branch_id,
// 						"three"=>$this->_user_company_id,
// 						"five"=>$tc_id
// 						);
// 		$data['tc_details'] = $this->api->call_api('getTermsConditionsDetails',$params);	
// 		if(empty($data['tc_details'])) {

// 		$this->session->set_flashdata('error', 'Terms & Condtions Not Found ');
// 		redirect('admin/masters/terms_condition_list');

// 		} else {
// 		   $this->form_validation->set_rules('tc_header','Header', 'required|trim|max_length[100]');
// 		   $this->form_validation->set_rules('tc_desc','Description', 'required|trim|max_length[1000]');

// 		if($this->form_validation->run() == FALSE)
// 		{
// 			$this->load->view('admin/masters/add_edit_tc', $data);	
// 		}
// 		else 
// 		{ 

// 			$params = array("one"=>$this->_user_id,
// 						"two"=>$this->_user_branch_id,
// 						"three"=>$this->_user_company_id,
// 						"four"=>$this->_user_emp_id,
// 						"five"=>$this->input->post('tc_id'),
// 						"six"=>$this->input->post('tc_header'),
// 						"seven"=>$this->input->post('tc_desc'),
// 						);
// 			$response = $this->api->call_api('setModifyTermsConditionsDetails',$params);	
// 			if($response=="Success"){
// 					$this->session->set_flashdata('success', 'Terms & Condtions Updated successfully !!');
// 					redirect('admin/masters/terms_condition_list');

// 			} else{
// 					$this->session->set_flashdata('error', 'Error: Please try after some time');
// 					redirect('admin/masters/terms_condition_list');
// 			}
// 		}
// 	}
// 	}
// 	}
// }

// public function deactivate_terms_condition($tc_id=null)
// {
// 	if(!$this->isSuperAdmin())
// 	{
// 		redirect('admin/access_denied');
// 	}  else {
// 	if(!empty($tc_id))
// 	{		
// 	$params = array("one"=>$this->_user_id,
// 	"two"=>$this->_user_branch_id,
// 	"three"=>$this->_user_company_id,
// 	"four"=>$this->_user_emp_id,
// 	"five"=>$tc_id,
// 	"six"=>"Deactivated"
// 	);
// 	$response = $this->api->call_api('setDeactivateTermsConditionsDetails',$params);
// 	if($response=="Success"){
// 				$this->session->set_flashdata('success', 'Terms & Condtions Deactivated successfully ');
// 				redirect('admin/masters/terms_condition_list');

// 		} else{
// 				$this->session->set_flashdata('error', 'Error: Please try after some time');
// 				redirect('admin/masters/terms_condition_list');
// 		}
//   } else {

// 	   $this->session->set_flashdata('error', 'Terms & Condtions  not found');
// 	   redirect('admin/masters/terms_condition_list');
//   }
//  }

