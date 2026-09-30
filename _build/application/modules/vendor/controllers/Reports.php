<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class Reports extends MY_Controller
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


	public function getInvoice_tc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			/* "five"=>$type, */
			"seven" => "T&C",

		);

		$result = $this->api->call_v_api('getInvoiceTermsConditionDetails', $params);


		return $result;
	}

	public function getTerm_n_cond()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			/* "five"=>$type, */
			"five" => "Report",

		);

		$result = $this->api->call_v_api('getTermsAndConditionDetails', $params);


		return $result;
	}

	// Quotation Report
	public function quotation_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Quotation Report";
		$data['status_list'] = array("Active", "Approved", "Deactivated");
		$data['priority_list'] = array("High", "Medium", "Low");
		$this->loadViews(get_module() . '/reports/list_quotation', $data);
	}
	public function add_quotation()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Add Quotation";
		$data['action'] = "Add";
		$data['service_list'] = $this->getServiceType();
		$data['invoice_tc'] = $this->getTerm_n_cond();
		// $data['invoice_tc']    = $this->getInvoice_tc();
		$data['priority_list'] = array("High", "Medium", "Low");

		// echo "<pre/>"; print_r($data);die;


		$this->form_validation->set_rules('cust_type', 'Lead / Customer Type', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('ref_id', 'Lead / Customer', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('p_quote_priorty', 'Quotation Priority', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('p_quote_name', 'Customer/Lead Name', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('p_quote_address', 'Customer/Lead Address', 'required|trim|max_length[500]');


		$this->form_validation->set_rules('p_quote_contact', 'Customer/Lead Contact No.', 'required|trim|max_length[10]|min_length[10]|numeric');

		$this->form_validation->set_rules('p_quote_subject', 'Quotation Subject', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_quote_desc', 'Quotation Description', 'required|trim|max_length[1000]');
		/* 
		$this->form_validation->set_rules('cust_service_type','Product Details', 'required',array('required' => 'Select %s')); */

		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'required|max_length[8]|numeric');

		$this->form_validation->set_rules('p_quote_ack_by', 'Thank You', 'required|max_length[100]');
		/* $this->form_validation->set_rules('service_id[]','Product', 'required',array('required' => 'Select %s')); */
		$this->form_validation->set_rules('qty[]', 'Product Quantity', 'max_length[4]|numeric');
		$this->form_validation->set_rules('price[]', 'Product Price', 'max_length[8]|numeric');
		$this->form_validation->set_rules('total_price[]', 'Product Total Price', 'max_length[8]|numeric');
		$this->form_validation->set_rules('desc1[]', 'Description1', 'max_length[100]');
		$this->form_validation->set_rules('desc2[]', 'Description2', 'max_length[100]');
		$this->form_validation->set_rules('desc2[]', 'Description2', 'max_length[100]');
		$this->form_validation->set_rules('p_qf_desc[]', 'Description', 'max_length[500]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/reports/add_edit_quotation', $data);
		} else {
			$post_data = $this->input->post(null, true);


			$p_quote_date = $post_data['p_quote_date'];
			$p_quote_date = !empty($p_quote_date) ? strtoupper($p_quote_date) : "";

			$p_quote_priorty = !empty($post_data['p_quote_priorty']) ? $post_data['p_quote_priorty'] : Null;
			$p_quote_name = !empty($post_data['p_quote_name']) ? $post_data['p_quote_name'] : Null;
			$p_quote_address = !empty($post_data['p_quote_address']) ? $post_data['p_quote_address'] : Null;
			$p_quote_landline = !empty($post_data['p_quote_landline']) ? $post_data['p_quote_landline'] : Null;
			$p_quote_email = !empty($post_data['p_quote_email']) ? $post_data['p_quote_email'] : Null;
			$p_quote_contact_person = !empty($post_data['p_quote_contact_person']) ? $post_data['p_quote_contact_person'] : Null;
			$p_quote_dist_id = !empty($post_data['p_quote_dist_id']) ? $post_data['p_quote_dist_id'] : Null;
			$p_quote_state_id = !empty($post_data['p_quote_state_id']) ? $post_data['p_quote_state_id'] : Null;
			$p_quote_pin_code = !empty($post_data['p_quote_pin_code']) ? $post_data['p_quote_pin_code'] : Null;
			$p_quote_contact = !empty($post_data['p_quote_contact']) ? $post_data['p_quote_contact'] : Null;
			$p_quote_subject = !empty($post_data['p_quote_subject']) ? $post_data['p_quote_subject'] : Null;
			$p_quote_desc = !empty($post_data['p_quote_desc']) ? $post_data['p_quote_desc'] : Null;

			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;

			$service_id = !empty($post_data['service_id']) ? implode(",", $post_data['service_id']) : Null;
			$qty = !empty($post_data['qty']) ? implode(",", $post_data['qty']) : Null;

			$nos = !empty($post_data['nos']) ? implode(",", $post_data['nos']) : Null;
			$discount_per = !empty($post_data['discount_per']) ? implode(",", $post_data['discount_per']) : Null;
			$discount_amt = !empty($post_data['discount_amt']) ? implode(",", $post_data['discount_amt']) : Null;
			$total_final_price = !empty($post_data['total_final_price']) ? implode(",", $post_data['total_final_price']) : Null;

			$p_total_final_price = Null;
			if (!empty($post_data['price'])) {
				$p_total_final_price = array_sum($post_data['total_final_price']);
			}

			$p_quote_amount = Null;
			if (!empty($post_data['price'])) {
				$p_quote_amount = array_sum($post_data['price']);
			}
			$price = !empty($post_data['price']) ? implode(",", $post_data['price']) : Null;

			$total_price = !empty($post_data['total_price']) ? implode(",", $post_data['total_price']) : Null;
			$desc1 = !empty($post_data['desc1']) ? implode(",", $post_data['desc1']) : Null;
			$desc2 = !empty($post_data['desc2']) ? implode(",", $post_data['desc2']) : Null;
			$gst = !empty($post_data['gst']) ? implode(",", $post_data['gst']) : Null;
			$unit_price = !empty($post_data['unit_price']) ? implode(",", $post_data['unit_price']) : Null;
			$gst_price = !empty($post_data['gst_price']) ? implode(",", $post_data['gst_price']) : Null;
			$p_product_name = !empty($post_data['p_product_name']) ? $post_data['p_product_name'] : Null;
			$p_qf_desc = !empty($post_data['p_qf_desc']) ? $post_data['p_qf_desc'] : Null;
			$gst_applicable = !empty($post_data['gst_applicable']) ? $post_data['gst_applicable'] : 'yes';

			if (!empty($p_qf_desc)) {
				$p_qf_desc = array_filter($p_qf_desc); // Remove empty values
				$p_qf_desc = implode("|", $p_qf_desc); // Use '|' as the separator
			}

			if (!empty($p_product_name)) {
				$p_product_name = array_filter($p_product_name); // Remove empty values
				$p_product_name = implode("|", $p_product_name); // Use '|' as the separator
			}

			$cust_total_amount = !empty($post_data['cust_total_amount']) ? $post_data['cust_total_amount'] : Null;
			$p_quote_ack_by = !empty($post_data['p_quote_ack_by']) ? $post_data['p_quote_ack_by'] : Null;

			$p_product_id = Null;
			$p_ots_id = Null;
			$p_amc_id = Null;

			if ($cust_service_type == "One Time Service") {
				$p_ots_id = $service_id;
			}
			if ($cust_service_type == "AMC") {
				$p_amc_id = $service_id;
			}

			if ($cust_service_type == "Sales") {
				$p_product_id = $service_id;
			}


			$ref_id = $post_data['ref_id'];
			$cust_type = $post_data['cust_type'];

			$cust_id = $cust_type == "Customers" ? $ref_id : Null;
			$clm_id = $cust_type == "Leads" ? $ref_id : Null;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $clm_id,
				"seven" => $p_quote_amount,
				"eight" => $cust_total_amount,
				"nine" => $p_quote_name,
				"ten" => $p_quote_address,
				"eleven" => $p_quote_contact,
				"twelve" => $p_quote_date,
				"thirteen" => $p_quote_landline,
				"fourteen" => $p_quote_email,
				"fifteen" => $p_quote_contact_person,
				"sixteen" => $p_quote_priorty,
				"seventeen" => $p_quote_subject,
				"eighteen" => $p_quote_desc,
				"nineteen" => $p_quote_ack_by,
				"twenty" => Null,
				"twentyone" => $p_quote_dist_id,
				"twentytwo" => $p_quote_state_id,
				"twentythree" => Null,
				"twentyfour" => $p_quote_pin_code,
				"twentyfive" => $p_product_id,
				"twentysix" => $price,
				"twentyseven" => $total_price,
				"twentyeight" => $p_ots_id,
				"twentynine" => $p_amc_id,
				"thirty" => $p_product_name,
				"thirtyone" => $qty,
				"thirtytwo" => $desc1,
				"thirtythree" => $desc2,
				"thirtyfour" => Null,
				"thirtyfive" => Null,
				"thirtysix" => Null,
				"thirtyseven" => $p_qf_desc,
				"thirtyeight" => $nos,
				"thirtynine" => $discount_per,
				"fourty" => $discount_amt,
				"fourtyone" => $total_final_price,
				"fourtytwo" => $p_total_final_price,
				"fourtythree" => $gst_applicable
			);

			// log_message("error",json_encode($params));
			// echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setQuotationMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Quotation Added successfully !!');
				redirect(get_module() . '/reports/quotation_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/reports/quotation_report');
			}
		}
	}

	public function edit_quotation()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Edit Quotation Details";
		$id = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getQuotationMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$data['details'] = $details[0];

		$data['id'] = $id;
		$data['action'] = "Edit";
		$data['service_list'] = $this->getServiceType();
		$data['priority_list'] = array("High", "Medium", "Low");


		$this->form_validation->set_rules('cust_type', 'Lead / Customer Type', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('ref_id', 'Lead / Customer', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('p_quote_priorty', 'Quotation Priority', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('p_quote_name', 'Customer/Lead Name', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('p_quote_address', 'Customer/Lead Address', 'required|trim|max_length[500]');


		$this->form_validation->set_rules('p_quote_contact', 'Customer/Lead Contact No.', 'required|trim|max_length[10]|min_length[10]|numeric');

		$this->form_validation->set_rules('p_quote_subject', 'Quotation Subject', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_quote_desc', 'Quotation Description', 'required|trim|max_length[1000]');

		/* 	$this->form_validation->set_rules('cust_service_type','Product Details', 'required',array('required' => 'Select %s')); */

		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'required|max_length[8]|numeric');

		$this->form_validation->set_rules('p_quote_ack_by', 'Thank You', 'required|max_length[100]');
		/* $this->form_validation->set_rules('service_id[]','Product', 'required',array('required' => 'Select %s')); */
		$this->form_validation->set_rules('qty[]', 'Product Quantity', 'max_length[4]|numeric');
		$this->form_validation->set_rules('price[]', 'Product Price', 'max_length[8]|numeric');
		$this->form_validation->set_rules('total_price[]', 'Product Total Price', 'max_length[8]|numeric');
		$this->form_validation->set_rules('desc1[]', 'Description1', 'max_length[100]');
		$this->form_validation->set_rules('desc2[]', 'Description2', 'max_length[100]');
		$this->form_validation->set_rules('desc2[]', 'Description2', 'max_length[100]');
		$this->form_validation->set_rules('p_qf_desc[]', 'Description', 'max_length[500]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/reports/add_edit_quotation', $data);
		} else {
			$post_data = $this->input->post(null, false);


			$p_quote_date = $post_data['p_quote_date'];
			$p_quote_date = !empty($p_quote_date) ? strtoupper($p_quote_date) : "";

			$p_quote_priorty = !empty($post_data['p_quote_priorty']) ? $post_data['p_quote_priorty'] : Null;
			$p_quote_name = !empty($post_data['p_quote_name']) ? $post_data['p_quote_name'] : Null;
			$p_quote_address = !empty($post_data['p_quote_address']) ? $post_data['p_quote_address'] : Null;
			$p_quote_landline = !empty($post_data['p_quote_landline']) ? $post_data['p_quote_landline'] : Null;
			$p_quote_email = !empty($post_data['p_quote_email']) ? $post_data['p_quote_email'] : Null;
			$p_quote_contact_person = !empty($post_data['p_quote_contact_person']) ? $post_data['p_quote_contact_person'] : Null;
			$p_quote_dist_id = !empty($post_data['p_quote_dist_id']) ? $post_data['p_quote_dist_id'] : Null;
			$p_quote_state_id = !empty($post_data['p_quote_state_id']) ? $post_data['p_quote_state_id'] : Null;
			$p_quote_pin_code = !empty($post_data['p_quote_pin_code']) ? $post_data['p_quote_pin_code'] : Null;
			$p_quote_contact = !empty($post_data['p_quote_contact']) ? $post_data['p_quote_contact'] : Null;
			$p_quote_subject = !empty($post_data['p_quote_subject']) ? $post_data['p_quote_subject'] : Null;
			$p_quote_desc = !empty($post_data['p_quote_desc']) ? $post_data['p_quote_desc'] : Null;
			$gst_applicable = !empty($post_data['gst_applicable']) ? $post_data['gst_applicable'] : 'yes';
			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;

			$service_id = !empty($post_data['service_id']) ? implode(",", $post_data['service_id']) : Null;
			$qty = !empty($post_data['qty']) ? implode(",", $post_data['qty']) : Null;

			$nos = !empty($post_data['nos']) ? implode(",", $post_data['nos']) : Null;
			$discount_per = !empty($post_data['discount_per']) ? implode(",", $post_data['discount_per']) : Null;
			$discount_amt = !empty($post_data['discount_amt']) ? implode(",", $post_data['discount_amt']) : Null;
			$total_final_price = !empty($post_data['total_final_price']) ? implode(",", $post_data['total_final_price']) : Null;

			$p_total_final_price = Null;
			if (!empty($post_data['price'])) {
				$p_total_final_price = array_sum($post_data['total_final_price']);
			}

			$p_quote_amount = Null;
			if (!empty($post_data['price'])) {
				$p_quote_amount = array_sum($post_data['price']);
			}
			$price = !empty($post_data['price']) ? implode(",", $post_data['price']) : Null;

			$total_price = !empty($post_data['total_price']) ? implode(",", $post_data['total_price']) : Null;
			$desc1 = !empty($post_data['desc1']) ? implode(",", $post_data['desc1']) : Null;
			$desc2 = !empty($post_data['desc2']) ? implode(",", $post_data['desc2']) : Null;
			$gst = !empty($post_data['gst']) ? implode(",", $post_data['gst']) : Null;
			$unit_price = !empty($post_data['unit_price']) ? implode(",", $post_data['unit_price']) : Null;
			$gst_price = !empty($post_data['gst_price']) ? implode(",", $post_data['gst_price']) : Null;
			$p_product_name = !empty($post_data['p_product_name']) ? $post_data['p_product_name'] : Null;
			$p_qf_desc = !empty($post_data['p_qf_desc']) ? $post_data['p_qf_desc'] : Null;

			if (!empty($p_qf_desc)) {
				$p_qf_desc = array_filter($p_qf_desc); // Remove empty values
				$p_qf_desc = implode("|", $p_qf_desc); // Use '|' as the separator
			}

			if (!empty($p_product_name)) {
				$p_product_name = array_filter($p_product_name); // Remove empty values
				$p_product_name = implode("|", $p_product_name); // Use '|' as the separator
			}

			$cust_total_amount = !empty($post_data['cust_total_amount']) ? $post_data['cust_total_amount'] : Null;
			$p_quote_ack_by = !empty($post_data['p_quote_ack_by']) ? $post_data['p_quote_ack_by'] : Null;

			$p_product_id = Null;
			$p_ots_id = Null;
			$p_amc_id = Null;

			if ($cust_service_type == "One Time Service") {
				$p_ots_id = $service_id;
			}
			if ($cust_service_type == "AMC") {
				$p_amc_id = $service_id;
			}

			if ($cust_service_type == "Sales") {
				$p_product_id = $service_id;
			}


			$ref_id = $post_data['ref_id'];
			$cust_type = $post_data['cust_type'];

			$cust_id = $cust_type == "Customers" ? $ref_id : Null;
			$clm_id = $cust_type == "Leads" ? $ref_id : Null;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $id,
				"six" => $cust_id,
				"seven" => $clm_id,
				"eight" => $p_quote_amount,
				"nine" => $cust_total_amount,
				"ten" => $p_quote_name,
				"eleven" => $p_quote_address,
				"twelve" => $p_quote_contact,
				"thirteen" => $p_quote_date,
				"fourteen" => $p_quote_landline,
				"fifteen" => $p_quote_email,
				"sixteen" => $p_quote_contact_person,
				"seventeen" => $p_quote_priorty,
				"eighteen" => $p_quote_subject,
				"nineteen" => $p_quote_desc,
				"twenty" => $p_quote_ack_by,
				"twentyone" => Null,
				"twentytwo" => $p_quote_dist_id,
				"twentythree" => $p_quote_state_id,
				"twentyfour" => Null,
				"twentyfive" => $p_quote_pin_code,
				"twentysix" => $p_product_id,
				"twentyseven" => $price,
				"twentyeight" => $total_price,
				"twentynine" => $p_ots_id,
				"thirty" => $p_amc_id,
				"thirtyone" => $p_product_name,
				"thirtytwo" => $qty,
				"thirtythree" => $desc1,
				"thirtyfour" => $desc2,
				"thirtyfive" => Null,
				"thirtysix" => Null,
				"thirtyseven" => Null,
				"thirtyeight" => $p_qf_desc,
				"thirtynine" => $nos,
				"fourty" => $discount_per,
				"fourtyone" => $discount_amt,
				"fourtytwo" => $total_final_price,
				"fourtythree" => $p_total_final_price,
				"fourtyfour" => $gst_applicable
			);

			// echo "<pre/>"; print_r($params);die;
			//log_message("error",json_encode($params));
			$response = $this->api->call_v_api('setModifyQuotationMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Quotation Details Updated successfully !!');
				redirect(get_module() . '/reports/quotation_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/reports/quotation_report');
			}
		}
	}

	public function view_quotation()
	{

		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Quotation Master Report";
		$id = $this->input->get("id");
		$det_id = $this->input->get("det_id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$id = base64_decode($id);
		$det_id = base64_decode($det_id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $det_id,
		);
		$details = $this->api->call_v_api('getQuotationMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
		);
		$quoDetaillist = $this->api->call_v_api('getQuotationDetailDetails', $params);
		$params1 = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $this->_user_mobile
		);
		// echo "<pre>";print_r($params1);die;
		$whatsAppCount = $this->api->call_v_api('getWhatsAppCount', $params1);
		$has_whatsapp_account = false;
		$creditCount = 0;

		if (!empty($whatsAppCount)) {
			$has_whatsapp_account = true;

			if (isset($whatsAppCount[0]['user_wp_credit_count'])) {
				$creditCount = (int)$whatsAppCount[0]['user_wp_credit_count'];
			}
		}

		$data['whapp_count'] = $creditCount;
		$data['has_whatsapp_account'] = $has_whatsapp_account;

		$params2 = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => "Followup",
		);
		$result = $this->api->call_v_api('getQuotationTicketMasterDetails', $params2);


		$data['details'] = $details[0];
		$data['v_details'] = $quoDetaillist;
		
		$data['followup'] = $result;
		$this->loadViews(get_module() . '/reports/view_quotation', $data);
	}
	public function download_quotation_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $this->_user_branch_id
		);

		$result = $this->api->call_v_api('downloadQuatationMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Quotation_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}
	public function download_all_sales_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$user_id = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');
		$bill_no = $this->input->post('bill_no');

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}

		$user_id = $this->_user_id;
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$user_id = $this->input->post('user_id');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $user_id,
			"five" => $bill_no,
			"six" => $month_year
		);

		$result = $this->api->call_v_api('getDownloadExelSaleDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="All_Sales_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	// public function download_quotation()
	// {
	// 	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
	// 		redirect(get_module() . '/dashboard/access_denied');
	// 	}
	// 	$quot_id = $this->input->get('quot_id');
	// 	$det_id = $this->input->get('det_id');
	// 	$customer_name = $this->input->get('customer_name');
	// 	$det_id = base64_decode($det_id);
	// 	$quot_id = base64_decode($quot_id);
	// 	$customer_name = base64_decode($customer_name);
	// 	$params = array(
	// 		"one" => $this->_user_id,
	// 		"two" => $this->_user_branch_id,
	// 		"three" => $this->_user_company_id,
	// 		"four" => $quot_id,
	// 		"five" => $det_id
	// 	);

	// 	$result = $this->api->call_v_api('downloadQuotationMasterDetails', $params);
	// 	// download file
	// 	header('Content-Disposition: attachment; filename="Quotation_' . Date("Y-m-d-h-i-s") . '.pdf"');
	// 	header('Content-Type: application/pdf');
	// 	echo ($result);
	// }

	public function download_quotation()
{
	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
		redirect(get_module() . '/dashboard/access_denied');
	}

	$quot_id = $this->input->get('quot_id');
	$det_id = $this->input->get('det_id');
	$customer_name = $this->input->get('customer_name');

	$det_id = base64_decode($det_id);
	$quot_id = base64_decode($quot_id);
	$customer_name = base64_decode($customer_name);

	$customer_name = preg_replace('/[^A-Za-z0-9]/', '_', $customer_name);

	$params = array(
		"one" => $this->_user_id,
		"two" => $this->_user_branch_id,
		"three" => $this->_user_company_id,
		"four" => $quot_id,
		"five" => $det_id
	);

	$result = $this->api->call_v_api('downloadQuotationMasterDetails', $params);

	$file_name = 'Quot_' . $customer_name . '_' . Date("Y-m-d-h-i-s") . '.pdf';

	header('Content-Disposition: attachment; filename="' . $file_name . '"');
	header('Content-Type: application/pdf');

	echo ($result);
}


	public function send_wp_msg()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$quot_id = $this->input->get('quot_id');
		$det_id = $this->input->get('det_id');
		$det_id = base64_decode($det_id);
		$quot_id = base64_decode($quot_id);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $quot_id,
			"five" => $det_id
		);


		$result = $this->api->call_v_api('sendQuotationMasterDetails', $params);
		// echo "<pre/>"; print_r($result);die;
		// download file
		if ($result == "Success") {
			$this->session->set_flashdata('success', 'Sent on WhatsApp successfully !!');
			redirect(get_module() . '/reports/view_quotation?id=' . base64_encode($quot_id));
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/reports/view_quotation?id=' . base64_encode($quot_id));
		}
	}

	// All Sales Report
	public function all_sales_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Sales Report";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_all_sales', $data);
	}

	// Total Sales Analysis Report
	public function sales_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Total Sales Analysis Report";
		$data['service_list'] = $this->getServiceType();
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_sales_analysis', $data);
	}
	// Payment Balance Report
	public function payment_balance_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Payment Balance Report";
		$data['service_list'] = $this->getServiceType();
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_payment_analysis', $data);
	}

	// Lead Analysis Report
	public function lead_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Lead Analysis Report";
		$data['employee_list'] = $this->getEmployeeDetails();

		$this->loadViews(get_module() . '/reports/list_lead_analysis', $data);
	}
	// Complaint Analysis Report
	public function complaint_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Complaint Analysis Report";
		$data['employee_list'] = $this->getEmployeeDetails();
		// echo "<pre/>"; print_r($data['employee_list'] );die;
		$this->loadViews(get_module() . '/reports/list_complaint_analysis', $data);
	}

	// Service Analysis Report
	public function service_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Service Analysis Report";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_service_analysis', $data);
	}

	// Ticket Analysis Report
	public function ticket_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Ticket Analysis Report";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_ticket_analysis', $data);
	}

	// Collection Report
	public function collection_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Collection Report";
		$data['service_list'] = $this->getServiceType();
		$this->loadViews(get_module() . '/reports/list_collection_report', $data);
	}
	// Payment Defaulter Report
	public function payment_defaulter_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Payment Defaulter Report";
		$this->loadViews(get_module() . '/reports/list_payment_defaulter', $data);
	}
	// Followup Analysis Report
	public function my_followup_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "My Followup Report";
		$data['employee_list'] = $this->getEmployeeDetails();
		$data['priority_list'] = array("High", "Medium", "Low");
		$this->loadViews(get_module() . '/reports/list_my_followup', $data);
	}

	// Employee Availability Report
	public function employee_availability_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Employee Availability Report";
		$month_year = $this->input->get('month_year');
		$status = $this->input->get('status');
		$status = !empty($status) ? $status : "Active";
		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $month_year,
		);
		$result = $this->api->call_v_api('getEmployeeAvailabilityReportDetails', $params);
		// echo"<pre>"; print_r($result); exit;
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$data['list'] = $list;
		$data['month_year'] = $this->input->get('month_year');
		$this->loadViews(get_module() . '/reports/list_employee_availability', $data);
	}

	// Daily Analysis Report
	public function daily_analysis_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Daily Analysis Report ";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_daily_analysis', $data);
	}

	// Download Daily Analysis Report

	public function download_daily_analysis_report()
	{
		$user_id = $this->input->post('user_id');
		$date = $this->input->post('date');
		//  $date                 = $date?$date:"";	
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : strtoupper(date("d-M-Y"));

		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : strtoupper(date("d-M-Y"));

		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : $from_date;

		/*
		|--------------------------------------------------------------------------
		| If To Date is before From Date
		|--------------------------------------------------------------------------
		*/
		if (strtotime($to_date) < strtotime($from_date)) {

			$to_date = $from_date;
		}

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		$status = "FS";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $user_id,
			"five" => $date,
			"six" => $status,
			"seven" => $added_by,
			"eight" => "Yes",
			"nine" => $from_date,
			"ten" => $to_date,
			/* "six"=>$searchStr_name,
						 "seven"=>$searchStr_contact, 
						 "eight"=>$searchStr_cust_id,
						 "nine"=>$service_type, */
		);

		$daily_analysis_details = $this->api->call_v_api('downloadDailyAnalysisReportDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Daily_Analysis_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($daily_analysis_details);
	}


	// Password Change Track Report
	public function pwd_change_track_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Password Changed Track Report";
		$this->loadViews(get_module() . '/reports/pwd_change_track_report', $data);
	}

	// All Report
	public function all_reports()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "All Reports";
		$this->loadViews(get_module() . '/reports/list_all_report', $data);
	}

	// Team Followup Details
	public function team_followup_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Followup Report ";
		$data['employee_list'] = $this->getEmployeeDetails();

		$params = array("one" => $this->_user_id);

		$result = $this->api->call_v_api('getDirectReporting', $params);

		$data['roleId'] = $this->_role_id;
		$data['direct_employeee'] = $result;



		$this->loadViews(get_module() . '/reports/list_team_followup', $data);
	}

	public function view_team_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "View Team Followup Details Report ";
		$data['status_list'] = array("Open" => "Following", "Closed" => "Closed");
		$emp_rpt_to = $this->input->get("id");
		$emp_rpt_to = base64_decode($emp_rpt_to);
		$data['employee_list'] = $this->getEmployeeReportedToDetails($emp_rpt_to);
		$this->loadViews(get_module() . '/reports/list_view_team_followup', $data);
	}
	// Team Customer Details
	public function team_customer_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Customer Report ";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_team_customer', $data);
	}
	public function view_team_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "View Team Customer Details Report ";
		$data['status_list'] = array("Active", "Pending", "Deactivated");
		$emp_rpt_to = $this->input->get("id");
		$emp_rpt_to = base64_decode($emp_rpt_to);
		$data['employee_list'] = $this->getEmployeeReportedToDetails($emp_rpt_to);
		$this->loadViews(get_module() . '/reports/list_view_team_customer', $data);
	}

	// Team Lead Details
	public function team_lead_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Lead Report ";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_team_lead', $data);
	}
	public function view_team_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "View Team Lead Details Report ";
		$data['status_list'] = array("Active", "Deactivated", "FS", "Reject");
		$emp_rpt_to = $this->input->get("id");
		$emp_rpt_to = base64_decode($emp_rpt_to);
		$data['employee_list'] = $this->getEmployeeReportedToDetails($emp_rpt_to);
		$this->loadViews(get_module() . '/reports/list_view_team_lead', $data);
	}

	// Team Employee Details
	public function team_employee_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Employee Report ";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_team_employee', $data);
	}

	// Team Ticket Details
	public function team_ticket_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Team Ticket Report ";
		$data['employee_list'] = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/reports/list_team_ticket', $data);
	}
	public function view_team_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "View Team Ticket Details Report ";
		$emp_rpt_to = $this->input->get("id");
		$emp_rpt_to = base64_decode($emp_rpt_to);
		$data['employee_list'] = $this->getEmployeeReportedToDetails($emp_rpt_to);
		$this->loadViews(get_module() . '/reports/list_view_team_ticket', $data);
	}

	// Lead Analysis Graph
	public function lead_analysis_graph()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Lead Analysis Graph";
		$month_year = $this->input->get("month_year");
		$year = $this->input->get("year");
		$month_year = !empty($month_year) ? $month_year : date("m-Y");
		$year = !empty($year) ? $year : date("Y");
		$month_graph_data = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $month_year
		);
		$month_graph_data = $this->api->call_v_api('getLeadGraphMonthDetails', $params);

		$params["four"] = $year;
		$year_graph_data = $this->api->call_v_api('getLeadGraphYearDetails', $params);

		$data['year_graph_data'] = json_encode($year_graph_data);
		$data['month_graph_data'] = json_encode($month_graph_data);
		$data['month_year'] = $month_year;
		$data['month_year_n'] = date("M-Y", strtotime("1-" . $month_year));
		$data['year'] = $year;
		//print_r($data);die;
		$this->loadViews(get_module() . '/reports/lead_analysis_graph', $data);
	}
	// Payment Analysis Graph
	public function payment_analysis_graph()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Payment Analysis Graph";
		$month_year = $this->input->get("month_year");
		$year = $this->input->get("year");
		$month_year = !empty($month_year) ? $month_year : date("m-Y");
		$year = !empty($year) ? $year : date("Y");
		$month_graph_data = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $month_year
		);
		$month_graph_data = $this->api->call_v_api('getPaymentGraphMonthDetails', $params);

		$params["four"] = $year;
		$year_graph_data = $this->api->call_v_api('getPaymentGraphYearDetails', $params);

		$data['year_graph_data'] = json_encode($year_graph_data);
		$data['month_graph_data'] = json_encode($month_graph_data);
		$data['month_year'] = $month_year;
		$data['month_year_n'] = date("M-Y", strtotime("1-" . $month_year));
		$data['year'] = $year;
		//print_r($data);die;
		$this->loadViews(get_module() . '/reports/payment_analysis_graph', $data);
	}

	// Customer Analysis Graph
	public function customer_analysis_graph()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Customer Analysis Graph";
		$month_year = $this->input->get("month_year");
		$year = $this->input->get("year");
		$month_year = !empty($month_year) ? $month_year : date("m-Y");
		$year = !empty($year) ? $year : date("Y");
		$month_graph_data = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $month_year
		);
		$month_graph_data = $this->api->call_v_api('getCustomerGraphMonthDetails', $params);

		$params["four"] = $year;
		$year_graph_data = $this->api->call_v_api('getCustomerGraphYearDetails', $params);

		$data['year_graph_data'] = json_encode($year_graph_data);
		$data['month_graph_data'] = json_encode($month_graph_data);
		$data['month_year'] = $month_year;
		$data['month_year_n'] = date("M-Y", strtotime("1-" . $month_year));
		$data['year'] = $year;
		//print_r($data);die;
		$this->loadViews(get_module() . '/reports/customer_analysis_graph', $data);
	}

	// Analysis Graph
	public function analysis_graph()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Analysis Graph";
		$data['employee_list'] = $this->getEmployeeDetails();
		$graph_data = "";
		for ($i = 1; $i <= 12; $i++) {

			$gdata["category"] = date("M", strtotime("1-" . $i . "-" . date("Y")));
			$gdata["first"] = 10 + $i;
			$gdata["second"] = 15 + $i;
			$gdata["third"] = 14 + $i;

			$graph_data = $graph_data . json_encode($gdata) . ",";
		}

		$data['graph_data'] = !empty($graph_data) ? substr($graph_data, 0, -1) : Null;
		$this->loadViews(get_module() . '/reports/analysis_graph', $data);
	}
	// Pie Chart
	public function analysis_piechart()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "Analysis Graph";
		$data['employee_list'] = $this->getEmployeeDetails();
		$graph_data = "";
		for ($i = 1; $i <= 6; $i++) {

			$gdata["category"] = date("M", strtotime("1-" . $i . "-" . date("Y")));
			$gdata["first"] = 10 + $i;
			$gdata["second"] = 15 + $i;
			$gdata["third"] = 14 + $i;

			$graph_data = $graph_data . json_encode($gdata) . ",";
		}

		$data['graph_data'] = !empty($graph_data) ? substr($graph_data, 0, -1) : Null;
		$this->loadViews(get_module() . '/reports/analysis_piechart', $data);
	}


	public function getServiceType()
	{
		$list = array(
			"AMC" => "AMC",
			"One Time Service" => "One Time Service",
			"Sales" => "Sales",
		);
		return $list;
	}
	public function getEmployeeDetails($emp_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => "Active",
		);
		$response = $this->api->call_v_api('getEmployeeReportDetails', $params);
		return $response['jsArray'];
	}


	public function getEmployeeReportedToDetails($emp_rpt_to = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_rpt_to,
		);
		$response = $this->api->call_v_api('getEmployeeReportedToDetails', $params);
		return $response;
	}

	public function check_access($class = Null, $method = Null)
	{
		return true;
	}

	public function amc_renewal_reminder()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title'] = "AMC Renewal Reminder";

		$this->loadViews(get_module() . '/reports/amc_renewal_reminder', $data);
	}

	public function roi_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$data['page_title']  = "Market Analysis Report";

		$this->loadViews(get_module() . '/reports/list_roi_report', $data);
	}

	// Vihas added on 09/03/2026
	public function add_follwoup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$type = $this->input->get("type");
		$id  = $this->input->get("id");
		$cust_id = $this->input->get("cust_id");

		if (empty($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}

		if (empty($cust_id)) {
			$this->session->set_flashdata('error', 'Customer or Lead id not available');
			redirect(get_module() . '/reports/quotation_report');
		}

		$id = base64_decode($id);
		$cust_id = base64_decode($cust_id);

		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report/');
		}



		$data['page_title']   = "Add Quotation Follow-Up ";
		$data['id']           = $id;
		$data['type']         = $type;
		$data['cust_id']	  = $cust_id;
		$data['action']       = "add_quotation_follwoup";
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");

		$this->form_validation->set_rules('followup_feedback', 'FollowUp Details', 'required|trim|max_length[250]');

		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/reports/add_quotation_follwoup', $data, true);
			echo $html;
		} else {
			$next_update_date = $this->input->post('next_update_date', true);
			$date = !empty($next_update_date) ? strtoupper(date("d-M-Y", strtotime($next_update_date))) : "";
			$time = !empty($next_update_date) ? date("h:i A", strtotime($next_update_date)) : "";
			$todaydate = strtoupper(date("d-M-Y"));

			$clmid = "";
			$custid = "";

			if ($type == "Lead") {
				$clmid = $cust_id;
			} else {
				$custid = $cust_id;
			}
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "3",
				"eight" => "Followup",
				"twelve" => $this->_user_id,
				"thirteen" => $custid,
				"fourteen" => $clmid,
				"sixteen" => $todaydate,
				"seventeen" => $this->input->post('followupstatusid', true),
				"eighteen" => $this->input->post('followup_feedback', true),
				"nineteen" => $date,
				"twenty" => $time,
				"twentythree" => $this->input->post('followupmedium', true),
				"twentyfour" => $this->input->post('wpnumber', true),
				"twentyfive" => "Quotation",
				"twentysix" => $id
			);
			// echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Follow-Up Added successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/followup_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/followup_report');
			}
		}
	}

	// Vihas added on 04/03/2026
	public function add_quotation_follwoup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$type = $this->input->get("type");
		$id  = $this->input->get("id");
		$cust_id = $this->input->get("cust_id");

		if (empty($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}

		if (empty($cust_id)) {
			$this->session->set_flashdata('error', 'Customer or Lead id not available');
			redirect(get_module() . '/reports/quotation_report');
		}

		$id = base64_decode($id);
		$cust_id = base64_decode($cust_id);

		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Quotation Details not found');
			redirect(get_module() . '/reports/quotation_report/');
		}



		$data['page_title']   = "Add Quotation Follow-Up ";
		$data['id']           = $id;
		$data['type']         = $type;
		$data['cust_id']	  = $cust_id;
		$data['action']       = "add_quotation_follwoup";
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");

		$this->form_validation->set_rules('followup_feedback', 'FollowUp Details', 'required|trim|max_length[250]');

		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/reports/add_quotation_follwoup', $data, true);
			echo $html;
		} else {
			$next_update_date = $this->input->post('next_update_date', true);
			$date = !empty($next_update_date) ? strtoupper(date("d-M-Y", strtotime($next_update_date))) : "";
			$time = !empty($next_update_date) ? date("h:i A", strtotime($next_update_date)) : "";
			$todaydate = strtoupper(date("d-M-Y"));

			$clmid = "";
			$custid = "";

			if ($type == "Lead") {
				$clmid = $cust_id;
			} else {
				$custid = $cust_id;
			}
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "3",
				"eight" => "Followup",
				"twelve" => $this->_user_id,
				"thirteen" => $custid,
				"fourteen" => $clmid,
				"sixteen" => $todaydate,
				"seventeen" => $this->input->post('followupstatusid', true),
				"eighteen" => $this->input->post('followup_feedback', true),
				"nineteen" => $date,
				"twenty" => $time,
				"twentythree" => $this->input->post('followupmedium', true),
				"twentyfour" => $this->input->post('wpnumber', true),
				"twentyfive" => "Quotation",
				"twentysix" => $id
			);
			// echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);

			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Follow-Up Added successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($id));
			}
		}
	}

	public function view_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Follow-Up Details";
		$id    = $this->input->get("id");

		if (empty($id)) {
			$this->session->set_flashdata('error', 'Follow-Up Details not found');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Follow-Up Details not found');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
					"five" => "Followup",
				);
				$details = $this->api->call_v_api('getQuotationTicketMasterDetails', $params);
				if (empty($details)) {
					$this->session->set_flashdata('error', 'Follow-Up Details not found');
					redirect(get_module() . '/customers/followup_report');
				} else {
					$data['details']  = $details;
					$this->load->view(get_module() . '/customers/view_followup', $data);
				}
			}
		}
	}

	public function deactivate_quotation()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$data['page_title']   = "Deactivate Quotation ";
		$data['input_title']  = "Quotation Deactivation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "deactivate_quotation";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/reports/deactivation_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id,
				"five" => "Deactivated",
				"six" => $this->input->post('reason', true),
			);
			// echo "<pre>";print_r($params);die;
			$response = $this->api->call_v_api('setDeactivateQuotationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Quotation Deactivated');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($ref_id));
			}
		}
	}


	public function confirm_quotation()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/reports/quotation_report');
		}
		$data['page_title']   = "Approve Quotation ";
		$data['input_title']  = "Quotation Approval ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "confirm_quotation";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/reports/deactivation_popup', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id,
				"five" => "Confirm",
				"six" => $this->input->post('reason', true),
			);
			// echo "<pre>";print_r($params);die;
			$response = $this->api->call_v_api('setDeactivateQuotationDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Quotation Approved');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/reports/view_quotation/?id=' . base64_encode($ref_id));
			}
		}
	}
}
