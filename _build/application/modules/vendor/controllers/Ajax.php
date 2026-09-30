<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class Ajax extends MY_Controller
{ // Main Controller

	public function __construct()
	{
		parent::__construct();


		// Load pagination library 
		$this->load->library('pagination');
		// Per page limit 
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
		if (!$this->input->is_ajax_request()) {
			redirect(get_module() . '/login');
		}
	}

	public function get_sub_dept_list($dept_id = NULL, $sub_dept_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $dept_id,
			"five" => "Active",
			"six" => "Report",
			"seven" => $sub_dept_id
		);
		$response = $this->api->call_v_api('getSubdepartmentDeptIdDetails', $params);
		$html_data = '<option value="">Select Sub Department</option>';
		if (!empty($response)) {
			foreach ($response as $sub_dept) {
				$html_data .= '<option value="' . $sub_dept['sub_dept_id'] . '" >' . $sub_dept['sub_dept_name'] . '</option>';
			}
		}
		echo json_encode($html_data);
	}
	public function get_dept_list($type = "Report", $status = "Active", $dept_id = NULL)
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
		echo json_encode($response);
	}
	public function get_state_list($type = "Report", $status = "Active", $state_id = NULL)
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
		echo json_encode($response);
	}

	public function get_state_districts($state_id = NULL)
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => "Active",
			"six" => "Report",
		);
		$response = $this->api->call_v_api('getDistrictStateIdDetails', $params);
		echo json_encode($response);
	}

	public function get_district_cities()
	{
		$dist_id = $this->input->post("dist_id");
		$state_id = $this->input->post("state_id");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => $dist_id,
			"six" => "Active",
			"seven" => "Report",
		);
		$response = $this->api->call_v_api('getCityDistrictIdDetails', $params);
		echo json_encode($response['jsArray']);
	}
	public function get_city_area()
	{
		$dist_id = $this->input->post("dist_id");
		$state_id = $this->input->post("state_id");
		$city_id = $this->input->post("city_id");
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
		echo json_encode($response['jsArray']);
	}

	public function get_customers()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		$customer_list = $result['jsArray'];
		$html = "<option>Select Customer</option>";
		if (!empty($customer_list)) {
			foreach ($customer_list as $customer) {
				$html .= "<option value='" . $customer['customer_id'] . "'>" . $customer['customer_name'] . " - " . $customer['customer_contact'] . "</option>";
			}
		}
		echo json_encode($html);
	}

	public function get_customers_for_leads()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"thirteen" => "1"
		);

		$result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		$customer_list = $result['jsArray'];
		$html = "<option value=''>Select Customer</option>";
		if (!empty($customer_list)) {
			foreach ($customer_list as $customer) {
				$html .= "<option value='" . $customer['customer_id'] . "'>" . $customer['customer_name'] . " - " . $customer['customer_contact'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_footer_details()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"six" => "Report",
			"seven" => "Footer",
		);

		$result = $this->api->call_v_api('getInvoiceTermsConditionDetails', $params);
		$data = array();
		if (!empty($result)) {
			$data['footer1'] = $result[0]['invoice_tc_footer1'];
			$data['footer2'] = $result[0]['invoice_tc_footer2'];
			$data['footer3'] = $result[0]['invoice_tc_footer3'];
		}
		echo json_encode($data);
	}

	public function get_reference_details()
	{
		$reference_details = array();
		$ref_id = $this->input->post("ref_id");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $ref_id
		);

		$result = $this->api->call_v_api('getReferenceByDetails', $params);
		if (!empty($result['jsArray'])) {
			$reference_details = $result['jsArray'][0];
		}
		echo json_encode($reference_details);
	}
	// Anjali End Reference Details 28-05-2025

	// Anjali Reference 28-05-2025
	public function add_reference_inline()
	{
		$ref_name = trim($this->input->post('ref_name', true));
		$ref_contact_per = trim($this->input->post('ref_contact_per', true));
		$ref_mobile_no = trim($this->input->post('ref_mobile_no', true));
		$ref_email = trim($this->input->post('ref_email', true));
		$ref_addr = trim($this->input->post('ref_addr', true));
		$ref_details = trim($this->input->post('ref_details', true));

		if ($ref_name == '') {
			echo json_encode(array('status' => 'error', 'message' => 'Please enter reference name'));
			return;
		}

		if ($ref_contact_per == '') {
			echo json_encode(array('status' => 'error', 'message' => 'Please enter contact person'));
			return;
		}

		if ($ref_mobile_no != '' && (!is_numeric($ref_mobile_no) || strlen($ref_mobile_no) != 10)) {
			echo json_encode(array('status' => 'error', 'message' => 'Mobile no. should be 10 digits'));
			return;
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"five" => $ref_name,
			"six" => $ref_contact_per,
			"seven" => $ref_mobile_no,
			"eight" => $ref_email,
			"nine" => $ref_addr,
			"ten" => $ref_details,


		);

		$response = $this->api->call_v_api('setReferenceByDetails', $params);

		if ($response != "Success") {
			echo json_encode(array('status' => 'error', 'message' => ERROR_MESSAGE));
			return;
		}

		$list_params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
		);
		$reference_result = $this->api->call_v_api('getReferenceByDetails', $list_params);
		$reference_list = !empty($reference_result['jsArray']) ? $reference_result['jsArray'] : array();
		$selected_reference = array();

		foreach ($reference_list as $reference) {
			$is_same_reference = isset($reference['ref_name']) && $reference['ref_name'] == $ref_name;

			if ($ref_mobile_no != '') {
				$is_same_reference = $is_same_reference && isset($reference['ref_mobile']) && $reference['ref_mobile'] == $ref_mobile_no;
			}

			if ($ref_email != '') {
				$is_same_reference = $is_same_reference && isset($reference['ref_email']) && $reference['ref_email'] == $ref_email;
			}

			if ($is_same_reference) {
				$selected_reference = $reference;
			}
		}

		if (empty($selected_reference) && !empty($reference_list)) {
			$selected_reference = $reference_list[0];
		}

		echo json_encode(array(
			'status' => 'success',
			'ref_id' => isset($selected_reference['ref_id']) ? $selected_reference['ref_id'] : '',
			'ref_person_name' => isset($selected_reference['ref_person_name']) ? $selected_reference['ref_person_name'] : $ref_contact_per,
			'ref_mobile' => isset($selected_reference['ref_mobile']) ? $selected_reference['ref_mobile'] : $ref_mobile_no,
			'ref_email' => isset($selected_reference['ref_email']) ? $selected_reference['ref_email'] : $ref_email,
			'ref_address' => isset($selected_reference['ref_address']) ? $selected_reference['ref_address'] : $ref_addr,
			'reference_list' => $reference_list,
		));
	}
	// Anjali End Reference 28-05-2025

	public function get_supplier_details()
	{
		$sup_ref_detail = array();
		$ref_id = $this->input->post("ref_id");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $ref_id
		);

		$result = $this->api->call_v_api('getInvSupplierReportDetails', $params);
		if (!empty($result['jsArray'])) {
			$sup_ref_detail = $result['jsArray'][0];
		}
		echo json_encode($sup_ref_details);
	}


	public function get_leads()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$lead_list = $result['jsArray'];
		$html = "<option>Select Lead</option>";
		if (!empty($lead_list)) {
			foreach ($lead_list as $lead_) {
				$html .= "<option value='" . $lead_['clm_id'] . "'>" . $lead_['clm_name'] . " - " . $lead_['clm_contact'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_leads_mobile()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$lead_list = $result['jsArray'];
		$html = "";
		if (!empty($lead_list)) {
			foreach ($lead_list as $lead_) {
				$html .= "<option value='" . $lead_['clm_contact'] . "'>" . $lead_['clm_name'] . " - " . $lead_['clm_contact'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_customers_mobile()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		$customer_list = $result['jsArray'];
		$html = "";
		if (!empty($customer_list)) {
			foreach ($customer_list as $customer) {
				$html .= "<option value='" . $customer['customer_contact'] . "'>" . $customer['customer_name'] . " - " . $customer['customer_contact'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_leads_email()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$lead_list = $result['jsArray'];
		$html = "<option>Select Lead</option>";
		if (!empty($lead_list)) {
			foreach ($lead_list as $lead_) {
				$html .= "<option value='" . $lead_['clm_contact_emailid'] . "'>" . $lead_['clm_name'] . " - " . $lead_['clm_contact_emailid'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_customers_email()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active"
		);

		$result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		$customer_list = $result['jsArray'];
		$html = "<option>Select Customer</option>";
		if (!empty($customer_list)) {
			foreach ($customer_list as $customer) {
				$html .= "<option value='" . $customer['customer_contact_email'] . "'>" . $customer['customer_name'] . " - " . $customer['customer_contact_email'] . "</option>";
			}
		}
		echo json_encode($html);
	}
	public function get_customer_details()
	{
		$customer_id = $this->input->post("customer_id");

		$html = '<div class="col-md-6">
							<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">Customer Basic Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>';

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $customer_id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		$details = $details[0];
		$html .= '<table class="table table-bordered table-hover">
							<tbody>
								<tr><th width="40%">Client ID</th><td>' . $details['customer_uniqueid'] . '</td></tr>
								<tr><th>Customer Name </th><td>' . $details['customer_name'] . '</td></tr>
								<tr><th>Customer Contact</th><td>' . $details['customer_contact'] . '</td></tr>
								<tr><th>Customer GST No</th><td>' . $details['customer_gstno'] . '</td></tr>
								<tr><th>Customer Address</th><td>' . $details['customer_address'] . '</td></tr>
								</tbody></table></div>';

		$subscriptionList = $details['subscriptionList'];
		$subscriptionServiceList = $details['subscriptionServiceList'];

		if (!empty($subscriptionList)) {
			$html .= '<div class="col-md-6">
							<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-layers"></i>
								  <span class="caption-subject font-red-mint sbold">Product / AMC Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>         			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th >Product/AMC </th><th>Amount</th></tr>';

			foreach ($subscriptionList as $key => $subserv) {
				$sr_no = $key + 1;
				$html .= '<tr><td>' . $sr_no . '</td>
								<td>' . $subserv['cust_subs_type_name'] . ' </td>
								<td>' . $subserv['cust_subs_price'] . '</td>';
				$html .= '</td></tr>';
			}
			$html .= '</tbody></table>';
		}

		if (!empty($subscriptionServiceList)) {
			$html .= '<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-wrench"></i>
								  <span class="caption-subject font-red-mint sbold">Servicing Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>         			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th >Service Dates</th><th>	Status</th><th >Done On</th></tr>';
			foreach ($subscriptionServiceList as $key => $subscription) {
				if (!empty($subscription['serviceList'])) {
					$serv = $subscription['serviceList'][0];
					$srno = $key + 1;
					$html .= '<tbody>
								<tr><td>' . $srno . '</td>
								<td>' . $serv['cust_serv_date_n'] . '</td>
								<td>';

					if ($serv['cust_serv_status'] == "Active") {
						$html .= "<span class='label label-success'>Active</span>";
					} else if ($serv['cust_serv_status'] == "Deactivated") {
						$html .= "<span class='label label-danger'>" . $serv['cust_serv_status'] . "</span>";
					} else {
						$html .= "<span class='label label-warning'>" . $serv['cust_serv_status'] . "</span>";
					}

					$html .= '<td>' . $serv['cust_serv_doneondate_n'] . '</td>								
								</tr>';
				}
			}
			$html .= '</tbody></table></div>';
		}

		$billPaymentList = $details['billPaymentList'];
		if (!empty($billPaymentList)) {
			$billPaymentList = !empty($billPaymentList) ? $billPaymentList[0] : "";
			$cbpm_id = isset($billPaymentList['cbpm_id']) ? $billPaymentList['cbpm_id'] : "";
			$cbpm_amount = isset($billPaymentList['cbpm_amount']) ? $billPaymentList['cbpm_amount'] : "";
			$cbpm_total_amnt = isset($billPaymentList['cbpm_total_amnt']) ? $billPaymentList['cbpm_total_amnt'] : "";
			$cbpm_received_amnt = isset($billPaymentList['cbpm_received_amnt']) ? $billPaymentList['cbpm_received_amnt'] : "";
			$cbpm_balance_amnt = isset($billPaymentList['cbpm_balance_amnt']) ? $billPaymentList['cbpm_balance_amnt'] : "";
			$cbpm_save_price = isset($billPaymentList['cbpm_save_price']) ? $billPaymentList['cbpm_save_price'] : "";
			$cbpm_billno = isset($billPaymentList['cbpm_billno']) ? $billPaymentList['cbpm_billno'] : "";
			$cbpm_gst = isset($billPaymentList['cbpm_gst']) ? $billPaymentList['cbpm_gst'] : "";



			$html .= '<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Bill Payment Details </span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>		
						   <div class="tbl-container" >
					 <table class="table table-condensed table-hover" >
							<tbody>
								<tr >
								<th> Package Amount  </th>
								<td>' . $cbpm_amount . '</td>
								<th> Total Amount  </th>
								<td>' . $cbpm_total_amnt . '</td>
								<th> GST Amount  </th><td>' . $cbpm_gst . '</td>
								</tr>
								<tr>						
								<th> Received Payment  </th>								
								<td>' . $cbpm_received_amnt . '</td>
								<th> Balance Payment  </th>
								<td>' . $cbpm_balance_amnt . '</td>								
								<th> Discount   </th>
								<td>' . $cbpm_save_price . '</td>								
								</tr>					
							</tbody> 
							  </table>
							  </div></div>';
			if (!empty($billPaymentList['paymentList'])) {
				$html .= '<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold"> Received Payments Details</span>
							   </div>
							    <hr style="margin:3px;"/>
									<div class="tbl-container" >
						<table class="table table-striped table-bordered table-advance table-hover" id="Srtable">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Receipt No (S/W)</th><th>Bill Book No</th><th>Paid Date</th><th>Paid Amt</th><th>Pay Mode</th><th>Chq/Card No</th><th>Bank Details</th><th>Status</th></tr>';

				foreach ($billPaymentList['paymentList'] as $key => $pyment) {
					$sr_no = $key + 1;
					$html .= '<tr><td>' . $sr_no . '</td>
								<td>' . $pyment['cp_receiptno'] . '</td>
								<td>' . $pyment['cp_uibillno'] . '</td>
								<td>' . $pyment['cp_udate_n'] . '</td>				
								<td>' . $pyment['cp_amount'] . '</td>
								<td>' . $pyment['cp_paytype'] . '</td>
								<td>' . $pyment['cp_chq_no'] . '</td>
								<td>' . $pyment['cp_bank_details'] . '</td>
								<td>';

					if ($pyment['cp_status'] == "Paid") {
						$html .= "<span class='label label-success'>Paid</span>";
					} else if ($pyment['cp_status'] == "Closed" || $pyment['cp_status'] == "Cancel") {
						$html .= "<span class='label label-danger'>" . $pyment['cp_status'] . "</span>";
					} else {
						$html .= "<span class='label label-warning'>" . $pyment['cp_status'] . "</span>";
					}
					$html .= '</td></tr>';
				}
				$html .= '</tbody>
                        </table>';
			}
			$html .= '</div></div>';
		}
		echo json_encode($html);
	}


	public function get_ref_details()
	{
		$ref_id = $this->input->post("ref_id");
		$cust_type = $this->input->post("cust_type");
		$html = '<div class="portlet-title">
							   <div class="caption">
								  <i class="font-red-mint icon-user"></i>
								  <span class="caption-subject font-red-mint sbold">' . $cust_type . ' Details</span>
							   </div>
							   <hr style="margin:3px;"/>
						   </div>';

		if ($cust_type == "Leads") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id
			);
			$details = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);
			$details = $details[0];
			$html .= '<table class="table table-bordered table-hover">
							<tbody>
								<tr ><th width="20%"> Name  </th><td>' . $details['clm_name'] . '</td></tr>	<tr ><th> Contact  </th><td>' . $details['clm_contact'] . '</td></tr>
								<tr ><th> Address  </th><td>' . $details['clm_address'] . '</td></tr>';
		}
		if ($cust_type == "Customers") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id
			);
			$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
			$details = $details[0];
			$html .= '<table class="table table-bordered table-hover">
							<tbody>
								<tr ><th width="20%"> Name  </th><td>' . $details['customer_name'] . '</td></tr><tr ><th> Contact  </th><td>' . $details['customer_contact'] . '</td></tr>
								<tr ><th> Address  </th><td>' . $details['customer_address'] . '</td></tr>';
		}


		echo json_encode($html);
	}



	public function get_customer_invoice_details()
	{
		$cust_id = $this->input->post("cust_id");

		$cbpm_id = $this->input->post("cbpm_id"); // Selected invoice

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
			"six" => "Active"
		);
		$pdetails = $this->api->call_v_api('getClientBillPaymentDetails', $params);
		if (!empty($pdetails)) {
			// $cbpm_billno = $pdetails[0]['cbpm_billno'];

			if ($cbpm_id != "") {
				// Selected invoice
				$cbpm_billno = $cbpm_id;
			} else {
				// Default first invoice
				// $cbpm_billno = $pdetails[0]['cbpm_billno'];
				$cbpm_billno = null;
			}

			$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
			$details = $details[0];
			$data['html_data'] = $details;

			$html = "";
			$data = array();
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $cust_id,
				"five" => $cbpm_billno,
			);

			$invoice_details = $this->api->call_v_api('getCustomerInvoiceDetails', $params);
			$invoice_html = "";

			$invoice_html = "<option value=''> Select Invoice </option>";
			if (!empty($invoice_details)) {
				foreach ($invoice_details as $invoice) {
					$invoice_html .= "<option value='" . $invoice['cbpm_id'] . "'>" . $invoice['cbpm_billno'] . "</option>";
				}

				$data['invoice_details'] = $invoice_html;
			}


			if (!empty($invoice_details) && $cbpm_id != "") {
				// foreach($invoice_details as $invoice){
				// 	$invoice_html .= "<option value='".$invoice['cbpm_id']."'>".$invoice['cbpm_id']."</option>";
				//  }

				// $data['invoice_details'] =   $invoice_html; 
				$html = "";
				foreach ($invoice_details as $invoice) {

					$cbpm_id = isset($invoice['cbpm_id']) ? $invoice['cbpm_id'] : "";
					$cbpm_amount = isset($invoice['cbpm_amount']) ? $invoice['cbpm_amount'] : "";
					$cbpm_total_amnt = isset($invoice['cbpm_total_amnt']) ? $invoice['cbpm_total_amnt'] : "";
					$cbpm_received_amnt = isset($invoice['cbpm_received_amnt']) ? $invoice['cbpm_received_amnt'] : "";
					$cbpm_balance_amnt = isset($invoice['cbpm_balance_amnt']) ? $invoice['cbpm_balance_amnt'] : "";
					$cbpm_save_price = isset($invoice['cbpm_save_price']) ? $invoice['cbpm_save_price'] : "";
					$cbpm_billno = isset($invoice['cbpm_billno']) ? $invoice['cbpm_billno'] : "";
					$cbpm_id_billno = isset($invoice['cbpm_id']) ? $invoice['cbpm_id'] : "";
					$cbpm_gst = isset($invoice['cbpm_gst']) ? $invoice['cbpm_gst'] : "";


					$html .= '<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold">Bill Payment Details </span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>				   
					  <input type="hidden" name="billno" value="' . $cbpm_billno . '"/>						   
					  <input type="hidden" name="cbpm_id_billno" value="' . $cbpm_id_billno . '"/>						   
			          <input type="hidden" name="discount" value="' . $cbpm_save_price . '"/>	
                      <input type="hidden" name="cbpm_balance_amnt" id ="cbpm_balance_amnt" value="' . $cbpm_balance_amnt . '"/>					  
 <div class="tbl-container" >
					 <table class="table table-condensed table-hover">
							<tbody>
								<tr ><th width="20%"> Customer Name  </th><td>' . $invoice['clientList'][0]['customer_name'] . '</td>
								<th> Customer Contact   </th>
								<td>' . $invoice['clientList'][0]['customer_contact'] . '</td>
								<th> Invoice No  </th>
								<td>' . $cbpm_billno . '</td>
								</tr>
								<tr >
								<th> Package Amount  
								</th>
								<td>' . $cbpm_amount . '</td>
								<th> Total Amount  </th>
								<td>' . $cbpm_total_amnt . '</td>
								<th> GST Amount  </th><td>' . $cbpm_gst . '</td>
								</tr>
								<tr>						
								<th> Received Payment  </th>								
								<td>' . $cbpm_received_amnt . '</td>
								<th> Balance Payment  </th>
								<td>' . $cbpm_balance_amnt . '</td>								
								<th> Discount   </th>
								<td>' . $cbpm_save_price . '</td>								
								</tr>
                                <tr>						
								<th > Customer Address  </th>								
								<td colspan="5">' . $invoice['clientList'][0]['customer_address
								
								
								'] . '</td>
								</tr>											
							</tbody> 
							  </table></div>';
					$data['cbpm_balance_amnt'] = $cbpm_balance_amnt;
					$data['payment_details'] = $html;
					$html = "";
					if (!empty($invoice['paymentList'])) {
						$html .= '<div class="col-md-12">
						 <div class="portlet-title">
						 <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-wallet"></i>
								  <span class="caption-subject font-red-mint sbold"> Received Payments Details</span>
							   </div>
							    <hr style="margin:3px;"/>
								<div class="tbl-container"  >
						   <table class="table table-striped table-bordered table-advance table-hover" id="Srtable">
							<tbody>
							<tr class="success"><th>Sr. No.</th><th>Receipt No (S/W)</th><th >Bill Book No</th><th>Paid Date</th><th>Paid Amt</th><th>Pay Mode</th><th>Chq/Card No</th><th>Bank Details</th><th>Status</th></tr>';

						foreach ($invoice['paymentList'] as $key => $pyment) {
							$sr_no = $key + 1;
							$html .= '<tr><td>' . $sr_no . '</td>
								<td>' . $pyment['cp_receiptno'] . '</td>
								<td>' . $pyment['cp_uibillno'] . '</td>
								<td>' . $pyment['cp_udate_n'] . '</td>				
								<td>' . $pyment['cp_amount'] . '</td>
								<td>' . $pyment['cp_paytype'] . '</td>
								<td>' . $pyment['cp_chq_no'] . '</td>
								<td>' . $pyment['cp_bank_details'] . '</td>
								<td>';

							if ($pyment['cp_status'] == "Paid") {
								$html .= "<span class='label label-success'>Paid</span>";
							} else if ($pyment['cp_status'] == "Closed" || $pyment['cp_status'] == "Cancel") {
								$html .= "<span class='label label-danger'>" . $pyment['cp_status'] . "</span>";
							} else {
								$html .= "<span class='label label-warning'>" . $pyment['cp_status'] . "</span>";
							}
							$html .= '</td></tr>';
						}
						$html .= '</tbody>
                        </table>';
					}
					$html .= '</div></div>';

					$data['payment_list'] = $html;
					$html = "";
					if (!empty($invoice['detailList'])) {
						$html .= '<div class="col-md-12">
						 <div class="portlet-title">
						        <br/>
							   <div class="caption">
								  <i class="font-red-mint icon-check"></i>
								  <span class="caption-subject font-red-mint sbold">All Service Details</span>
							   </div>
							    <hr style="margin:3px;"/>
						   </div>                     			   
					     <table class="table table-striped table-bordered table-advance table-hover">
							<tbody>
							<tr class="success"><th >Sr. No.</th><th>One Time/ AMC/ Sales Product</th><th>Qty</th><th>Amount</th></tr>';

						foreach ($invoice['detailList'] as $key => $subserv) {
							$sr_no = $key + 1;
							$html .= '<tr><td>' . $sr_no . '</td>
								<td>' . $subserv['cbpd_product_type_name'] . ' </td>
								<td>' . $subserv['cbpd_qty'] . ' </td>
								<td>' . $subserv['cbpd_saleprice'] . '</td>';
							$html .= '</td></tr>';
						}
						$html .= '</tbody></table></div>';
					}
					$data['service_list'] = $html;
					$data['paying_amt'] = $invoice['cbpm_balance_amnt'];
					$data['paying_ui_date'] = date('d-M-Y');
				}
			}
		} else {
			$data['service_list'] = "";
			$data['payment_list'] = "";
			$data['payment_details'] = "";
			$data['invoice_details'] = "";
			$data['cbpm_balance_amnt'] = "";
		}
		echo json_encode($data);
	}




	public function get_service_list()
	{
		$service_type = $this->input->post("service_type");
		$html = "";
		if ($service_type == "AMC") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getAMCDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					//    if($key%2 == 0){
					//    $html .= "<tr>";
					//   }
					//    $html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='".$item['amc_id']."' onchange='get_amc_details(this);' /> &nbsp;".$item['amc_name']."</label></td>";
					//    $html .= "<td><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange='get_amc_details(this);' /> &nbsp;" . $item['amc_name'] . " (Duration: " . $item['amc_duration'] . " months, Price: $" . $item['amc_price'] . " rs, Desc: $" . $item['amc_desc'] .")</label></td>";

					$html .= "<tr>";

					// $html .= "<td><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange='get_amc_details(this);' /> &nbsp;" . " AMC : ". $item['amc_name'] . " - (Duration: " . $item['amc_duration'] . " months, Price: $" . $item['amc_price'] . " rs, Desc: " . substr($item['amc_desc'], 0, 20) .")</label></td>";

					$html .= "<td style='width: 350px !important; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange='get_amc_details(this);' /> &nbsp;" . " AMC : " . $item['amc_name'] . "</label></td>";
					$html .= "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'><label>Duration: " . $item['amc_duration'] . " days, Price: ₹" . $item['amc_price'] . " rs, Desc: " . $item['amc_desc'] . "</label></td>";


					$html .= "</tr></br>";
					//    if($key%2 == 1){
					// 	   $html .= "</tr>";
					// 	  }
				}
			}
		}
		if ($service_type == "One Time Service") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					if ($key % 2 == 0) {
						$html .= "<tr>";
					}
					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['ots_id'] . "' onchange='get_ots_details(this);' /> &nbsp;" . $item['ots_name'] . "</label></td>";

					if ($key % 2 == 1) {
						$html .= "</tr>";
					}
				}
			}
		}
		if ($service_type == "Sales") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getProductMasterDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					if ($key % 2 == 0) {
						$html .= "<tr>";
					}

					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['pm_id'] . "' onchange='get_product_details(this);' /> &nbsp;" . $item['pm_name'] . "</label></td>";

					if ($key % 2 == 1) {
						$html .= "</tr>";
					}
				}
			}
		}
		echo json_encode($html);
	}

	public function get_service_list_selectbox()
	{
		$service_type = $this->input->post("service_type");
		$html = "";
		if ($service_type == "AMC") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getAMCDetails', $params);
			$list = $result['jsArray'];
			$html .= "<option value=''> Select AMC</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['amc_id'] . "' data-name='" . $item['amc_name'] . "' data-amount='" . $item['amc_corporate_price'] . "'>" . $item['amc_name'] . "</option>";
				}
			}
		}
		if ($service_type == "One Time Service") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
			$list = $result['jsArray'];
			$html .= "<option value=''> Select One Time Service</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['ots_id'] . "' data-name='" . $item['ots_name'] . "' data-amount='" . $item['ots_commerial'] . "'>" . $item['ots_name'] . "</option>";
				}
			}
		}
		if ($service_type == "Sales") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getProductMasterDetails', $params);
			$list = $result['jsArray'];
			$html .= "<option value=''> Select Product</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['pm_id'] . "' data-name='" . $item['pm_name'] . "' data-amount='" . $item['pm_commercial_price'] . "'>" . $item['pm_name'] . "</option>";
				}
			}
		}


		echo json_encode($html);
	}
	public function get_amc_details()
	{
		$amc_id = $this->input->post("amc_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type = $this->input->post("cust_type");
		$cust_ui_date = $this->input->post("cust_ui_date"); // Retrieve the date from input
		//    $date = date('d-M-Y', strtotime($cust_ui_date)); // Ensure the date format is consistent

		if (empty($cust_ui_date)) {
			$date1 = date('d-M-Y'); // Default to today's date if no date is provided
		} else {
			$date1 = date('d-M-Y', strtotime($cust_ui_date)); // Convert the provided date to the desired format
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $amc_id
		);
		$result = $this->api->call_v_api('getAMCDetails', $params);
		$details = $result['jsArray'][0];

		$product_details = $details['amcDetailDetails'];
		$product_id = $product_details['product_id'];




		$html = "<tr id='table_row_id_" . $amc_id . "'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_" . $amc_id . "'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='" . $details['amc_id'] . "' /> 
					<table><tr><th colspan='2'>" . $details['amc_name'] . " </th><tr/>
					<tr><th >Quantity &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_qty'  type='number' min='1' maxlength='4' data-id='" . $amc_id . "' id='cust_pdt_qty_" . $amc_id . "' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);' style='margin: 10px 0px;'/></td></tr>
					<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";

		if ($cust_type == "Commercial") {
			$price = $details['amc_corporate_price'];
		} else {
			$price = $details['amc_price'];
		}

		$html .= "<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='" . $amc_id . "'   id='cust_pdt_price_" . $amc_id . "' name='cust_pdt_price[]' value='" . $price . "' onchange='calculate_total(this);' /></td></tr>";
		if ($cust_gst_type == "GST Applicable" || $cust_gst_type == "IGST Applicable") {

			if ($cust_type == "Commercial") {
				$amc_gst = $details['amc_gst'];
				$amc_price_gst = $details['amc_corporate_price_gst'];
			} else {
				$amc_gst = $details['amc_gst'];
				$amc_price_gst = $details['amc_price_gst'];
			}
		} else {

			if ($cust_type == "Commercial") {
				$amc_gst = "0";
				$amc_price_gst = $details['amc_corporate_price'];
			} else {
				$amc_gst = "0";
				$amc_price_gst = $details['amc_price'];
			}
		}
		$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='" . $amc_id . "'   id='cust_pdt_gst_price_" . $amc_id . "' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='" . $amc_price_gst . "' readonly   style='margin: 10px 0;'  /><input id='cust_pdt_gst_" . $amc_id . "' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='" . $amc_id . "'  value='" . $amc_gst . "'  style='margin: 10px 0px;'  /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' cols='50' rows='4' name='cust_deliver_address[]'  data-id='" . $amc_id . "'  placeholder='Enter Address' ></textarea></td>";

		$html .= '<td><table class="bordered" id="table_' . $amc_id . '" ><tr><th>Service Interval Date </th><td><a href="javascript:;" class="btn btn-info btn-xs" onclick="add_row(this);" data-id="' . $amc_id . '" style="margin: 0px 5px;" ><i class="fa fa-plus"></i> </a></td></tr>';


		$amc_noofservices = $details['amc_noofservices'];
		$amc_noofservices = !empty($amc_noofservices) ? $amc_noofservices : 0;
		$amc_duration = $details['amc_duration'];
		$amc_duration = !empty($amc_duration) ? $amc_duration : 0;

		if (!empty($amc_noofservices) && !empty($amc_duration)) {
			$interval = round($amc_duration / $amc_noofservices);
			for ($i = 0; $i < $amc_noofservices; $i++) {
				$date = date('d-M-Y', strtotime($date1 . ' + ' . ($i * $interval) . ' days'));
				$html .= '<tr id ="row_id_' . $i . "_" . $amc_id . '" data-id="' . $i . "_" . $amc_id . '"><td><input type="text" name="cust_service_dates_' . $amc_id . '[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value="' . $date . '" style="margin: 5px 0px;"> </td>
							<td><a style="margin: 5px;" href="javascript:;" onclick="delete_row(this);" data-id="' . $i . "_" . $amc_id . '" class="btn btn-danger btn-xs"><i class="fa fa-close "></i></a></td></tr>';
			}
		}
		$html .= '</table></td></tr>';


		echo json_encode($html);
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
		$response = $this->api->call_v_api('getProductMasterDetails', $params);
		return $response['jsArray'];
	}

	public function get_product_details()
	{
		$pm_id = $this->input->post("pm_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type = $this->input->post("cust_type");

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $pm_id
		);
		$result = $this->api->call_v_api('getProductMasterDetails', $params);
		$details = $result['jsArray'][0];

		$html = "<tr id='table_row_id_" . $pm_id . "'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_" . $pm_id . "'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='" . $details['pm_id'] . "' /> 
					<table><tr><td colspan='2'><b>" . $details['pm_name'] . "</b><br/> Warrenty Period - " . $details['pm_warranty_period'] . " Model No :  " . $details['pm_model_name'] . " <br/></td><tr/>
					<tr><th>Quantity &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_qty'   type='number' min='1' maxlength='4' data-id='" . $pm_id . "' id='cust_pdt_qty_" . $pm_id . "' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);'  style='margin: 10px 0px; '/></td></tr>
					<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";

		if ($cust_type == "Commercial") {
			$price = $details['pm_commercial_price'];
		} else {
			$price = $details['pm_regular_price'];
		}

		$html .= "<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='" . $pm_id . "'   id='cust_pdt_price_" . $pm_id . "' name='cust_pdt_price[]' value='" . $price . "' onchange='calculate_total(this);' /></td></tr>";

		if ($cust_gst_type == "GST Applicable" || $cust_gst_type == "IGST Applicable") {
			if ($cust_type == "Commercial") {
				$pm_gst = $details['pm_gst'];
				$pm_price_gst = $details['pm_commercial_price_gst'];
			} else {
				$pm_gst = $details['pm_gst'];
				$pm_price_gst = $details['pm_regular_price_gst'];
			}
		} else {

			if ($cust_type == "Commercial") {
				$pm_gst = "0";
				$pm_price_gst = $details['pm_commercial_price'];
			} else {
				$pm_gst = "0";
				$pm_price_gst = $details['pm_regular_price'];
			}
		}
		$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='" . $pm_id . "'   id='cust_pdt_gst_price_" . $pm_id . "' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='" . $pm_price_gst . "' readonly   style='margin: 10px 0;' /><input id='cust_pdt_gst_" . $pm_id . "' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='" . $pm_id . "'  value='" . $pm_gst . "'  /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' col='50' rows='4' name='cust_deliver_address[]'  data-id='" . $pm_id . "'  placeholder='Enter Address' ></textarea></td>";

		$html .= '<td><table class="bordered" id="table_' . $pm_id . '" ><tr><th>Service Interval Date</th><td><a href="javascript:;"  class="btn btn-info btn-xs" onclick="add_row(this);" data-id="' . $pm_id . '" ><i class="fa fa-plus"></i> </a></td></tr>';


		$pm_noofservices = $details['pm_noofserv'];
		$pm_sit = $details['pm_sit'];
		$interval = round($pm_sit / $pm_noofservices);
		for ($i = 0; $i < $pm_noofservices; $i++) {
			$date = date('d-M-Y', strtotime(' + ' . $i * $interval . ' days'));
			$html .= '<tr id ="row_id_' . $i . "_" . $pm_id . '" data-id="' . $i . "_" . $pm_id . '"><td><input type="text" name="cust_service_dates_' . $pm_id . '[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value="' . $date . '" style="5px 0px;"> </td>
						<td><a href="javascript:;" onclick="delete_row(this);" data-id="' . $i . "_" . $pm_id . '" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>';
		}
		$html .= '</table></td></tr>';


		echo json_encode($html);
	}

	public function get_ots_details()
	{
		$ots_id = $this->input->post("ots_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type = $this->input->post("cust_type");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ots_id
		);
		$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
		$details = $result['jsArray'][0];

		$html = "<tr id='table_row_id_" . $ots_id . "'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_" . $ots_id . "'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='" . $details['ots_id'] . "' /> 
					<table><tr><th colspan='2'>" . $details['ots_name'] . " </th><tr/>
					<tr><th>Quantity &nbsp; : &nbsp;</th><td ><input class='form-control cust_pdt_qty'  type='number' min='1' maxlength='4' data-id='" . $ots_id . "' id='cust_pdt_qty_" . $ots_id . "' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);'    margin: 10px 0px;/></td></tr>
					<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";

		if ($cust_type == "Commercial") {
			$price = $details['ots_commerial'];
		} else {
			$price = $details['ots_regular'];
		}
		$html .= "<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='" . $ots_id . "'   id='cust_pdt_price_" . $ots_id . "' name='cust_pdt_price[]' value='" . $price . "' onchange='calculate_total(this);' /></td></tr>";

		if ($cust_gst_type == "GST Applicable" || $cust_gst_type == "IGST Applicable") {

			if ($cust_type == "Commercial") {
				$ots_gst = $details['ots_gst'];
				$ots_price_gst = $details['ots_commerial_gst'];
			} else {
				$ots_gst = $details['ots_gst'];
				$ots_price_gst = $details['ots_regular_gst'];
			}
		} else {

			$ots_gst = "0";
			if ($cust_type == "Commercial") {
				$ots_price_gst = $details['ots_commerial'];
			} else {
				$ots_price_gst = $details['ots_regular'];
			}
		}
		$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='" . $ots_id . "'   id='cust_pdt_gst_price_" . $ots_id . "' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='" . $ots_price_gst . "' readonly   style='margin: 10px 0;' /><input id='cust_pdt_gst_" . $ots_id . "' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='" . $ots_id . "'  value='" . $ots_gst . "'  style='margin: 10px 0px;' /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' col='50' rows='4' name='cust_deliver_address[]'  data-id='" . $ots_id . "'  placeholder='Enter Address' ></textarea></td>";

		$html .= '</tr>';


		echo json_encode($html);
	}

	// Ajax For Quotation
	public function get_ref_details_quot()
	{
		$ref_id = $this->input->post("ref_id");
		$cust_type = $this->input->post("cust_type");
		$data = array();
		if ($cust_type == "Leads") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id
			);
			$details = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);
			$details = $details[0];
			$data['name'] = $details['clm_name'];
			$data['contact'] = $details['clm_contact'];
			$data['address'] = $details['clm_address'];
			$data['landline'] = $details['clm_landline'];
			$data['emailid'] = $details['clm_contact_emailid'];
			$data['contact_person'] = $details['clm_contact_person'];
			$data['dist_id'] = $details['clm_distid'];
			$data['state_id'] = $details['clm_stateid'];
			$data['pincode'] = $details['clm_pincode'];
		}
		if ($cust_type == "Customers") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id
			);
			$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
			$details = $details[0];
			$data['name'] = $details['customer_name'];
			$data['contact'] = $details['customer_contact'];
			$data['address'] = $details['customer_address'];
			$data['landline'] = $details['cust_landline'];
			$data['emailid'] = $details['customer_contact_email'];
			$data['contact_person'] = $details['customer_contact_person'];
			$data['dist_id'] = $details['customer_dist_id'];
			$data['state_id'] = $details['customer_state_id'];
			$data['pincode'] = $details['customer_pin'];
		}


		echo json_encode($data);
	}
	public function get_service_list_quotation()
	{
		$service_type = $this->input->post("service_type");
		$html = "";
		if ($service_type == "AMC") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getAMCDetails', $params);
			$list = $result['jsArray'];
			$html .= "<tr id='tr_cls_1' data-id='1'><td><select class='form-control' name='service_id[]' onchange='get_amc_details(this);'> <option value=''> Select AMC</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['amc_id'] . "' data-name='" . $item['amc_name'] . "'>" . $item['amc_name'] . "</option>";
				}
			}
		}
		if ($service_type == "One Time Service") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
			$list = $result['jsArray'];
			$html .= "<tr id='tr_cls_1' data-id='1'><td><select class='form-control' name='service_id[]' onchange='get_ots_details(this);'> <option value=''> Select One Time Service</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['ots_id'] . "' data-name='" . $item['ots_name'] . "'>" . $item['ots_name'] . "</option>";
				}
			}
		}
		if ($service_type == "Sales") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getProductMasterDetails', $params);
			$list = $result['jsArray'];
			$html .= "<tr id='tr_cls_1' data-id='1'><td><select class='form-control' name='service_id[]' onchange='get_product_details(this);'> <option value=''> Select Product</option>";
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					$html .= "<option value='" . $item['pm_id'] . "' data-name='" . $item['pm_name'] . "'>" . $item['pm_name'] . "</option>";
				}
			}
		}

		$html .= "</select></td>
					
					<td><input type='number' class='form-control qty' name='qty[]' Placeholder='Qty' onchange='calculate_total(this);' maxlength='4' /></td>
					<td><input type='text' class='form-control nos' name='nos[]' Placeholder='nos' maxlength='4' /></td>
					<td><input type='number' class='form-control price' name='price[]' Placeholder='Price' onchange='calculate_total(this);' maxlength='8' /></td>
					<td><input type='text' class='form-control total_price' name='total_price[]' readonly  maxlength='8' /></td>
					<td><input type='number' maxlength='2' class='form-control discount_per'name='discount_per[]'placeholder='%'onchange='calculate_total(this);'></td>

<td>
    <input type='text'
           class='form-control discount_amt'
           name='discount_amt[]'
           readonly value='0'>
</td>
					<!--td><input type='text' class='form-control gst_amnt' name='gst_amnt[]' readonly  maxlength='8' /></td-->
					<td><input type='text' class='form-control total_final_price' name='total_final_price[]' readonly  maxlength='8' /></td>
					<td><input type='text' class='form-control' name='desc1[]'  Placeholder='Description1' maxlength='100' /></td>
					<!--<td><input type='text' class='form-control' name='desc2[]'  Placeholder='Description2' maxlength='100' /></td>-->

					
					
					<td><a href='javascript:;'  class='btn btn-info btn-xs' onclick='add_row(this);' ><i class='fa fa-plus'></i> </a></td>
					<td><a href='javascript:;'  class='btn btn-danger btn-xs' onclick='delete_row(this);' data-id='1' ><i class='fa fa-close'></i> </a></td>
					
					</tr>";
		echo json_encode($html);
	}


	public function get_amc_details_quote()
	{
		$amc_id = $this->input->post("amc_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type = $this->input->post("cust_type");

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $amc_id
		);
		$result = $this->api->call_v_api('getAMCDetails', $params);
		$details = $result['jsArray'][0];

		$data['cust_pdt_price'] = $details['amc_price'];
		$data['cust_pdt_gst'] = $details['amc_gst'];
		$data['cust_pdt_gst_price'] = $details['amc_price_gst'];
		$data['cust_no_services'] = $details['amc_noofservices'];
		$gst_amnt = ($details['amc_price'] * $details['amc_gst']) / 100;
		$data['gst_amnt'] = round($gst_amnt, 2);

		echo json_encode($data);
	}

	public function get_product_details_quote()
	{
		$pm_id = $this->input->post("pm_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type = $this->input->post("cust_type");

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $pm_id
		);
		$result = $this->api->call_v_api('getProductMasterDetails', $params);
		$details = $result['jsArray'][0];

		$data['cust_pdt_price'] = $details['pm_regular_price'];
		$data['cust_pdt_gst'] = $details['pm_gst'];
		$data['cust_pdt_gst_price'] = $details['pm_regular_price_gst'];
		$data['cust_no_services'] = $details['pm_noofserv'];
		$gst_amnt = ($details['pm_regular_price'] * $details['pm_gst']) / 100;
		$data['gst_amnt'] = round($gst_amnt, 2);
		echo json_encode($data);
	}

	public function get_ots_details_quote()
	{
		$ots_id = $this->input->post("ots_id");
		$data = array();
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Detail",
			"six" => $ots_id
		);
		$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
		$details = $result['jsArray'][0];
		$data['cust_pdt_price'] = $details['ots_regular'];
		$data['cust_pdt_gst'] = $details['ots_gst'];
		$data['cust_pdt_gst_price'] = $details['ots_regular_gst'];
		$data['cust_pdt_gst_price'] = $details['ots_regular_gst'];
		$gst_amnt = ($details['ots_regular'] * $details['ots_gst']) / 100;
		$data['gst_amnt'] = round($gst_amnt, 2);
		echo json_encode($data);
	}



	//Ajax Based Pagination	


	// Reference By Report
	public function tbl_reference_list($page = 1)
	{

		$post_data = $this->input->post(Null, true);
		$this->session->set_userdata('ref_post_data', $post_data);

		$status = $post_data['status'];
		$status = $status ? $status : "Active";
		$searchStr = $post_data['searchStr'];
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$total_count = ($page == 1) ? Null : $this->session->userdata('ref_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getReferenceByDetails', $params);

		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$this->session->set_userdata('ref_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_reference_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['ref_id'];
				$name = $item['ref_name'];
				$ref_person_name = $item['ref_person_name'];
				$ref_mobile = $item['ref_mobile'];
				$ref_email = $item['ref_email'];
				$status = $item['ref_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_reference/?ref_id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_reference/?ref_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_reference/?ref_id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate">
						   <i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td>' . $ref_person_name . '</td><td>' . $ref_mobile . '</td><td>' . $ref_email . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}
	// Terms And Conditions Report
	public function tbl_terms_n_conditions_list($page = 1)
	{

		$post_data = $this->input->post(Null, true);
		$this->session->set_userdata('tc_post_data', $post_data);

		$status = $post_data['status'];
		$status = $status ? $status : "Active";
		$searchStr = $post_data['searchStr'];
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$total_count = ($page == 1) ? Null : $this->session->userdata('tc_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getTermsAndConditionDetails', $params);
		$total_count = count($result);
		$list = $result;
		/* $total_count = $result['total_count'];	
			$list        = $result['jsArray']; */
		$this->session->set_userdata('tc_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_terms_n_conditions_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['tc_id'];
				$name = $item['tc_header'];
				$desc = $item['tc_desc'];
				$status = $item['tc_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_terms_n_conditions/?ref_id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_terms_n_conditions/?ref_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '<a  class="btn btn-danger btn-xs"  href="' . get_module_path() . 'masters/deactivate_terms_n_conditions/?ref_id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#form_modal">
						   <i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td>' . $desc . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Invoice Terms And Conditions Report
	public function tbl_invoice_tc_list($page = 1)
	{

		$post_data = $this->input->post(Null, true);
		$this->session->set_userdata('intc_post_data', $post_data);

		$status = $post_data['status'];
		$status = $status ? $status : "Active";
		$searchStr = $post_data['searchStr'];
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$total_count = ($page == 1) ? Null : $this->session->userdata('intc_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			/* "five"=>$type, */
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getInvoiceTermsConditionDetails', $params);
		$total_count = count($result);
		$list = $result;
		/* $total_count = $result['total_count'];	
			 $list        = $result['jsArray']; */
		$this->session->set_userdata('intc_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_invoice_tc_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['invoice_tc_id'];
				$name = $item['invoice_tc_header'];
				$status = $item['invoice_tc_status'];
				$id = base64_encode($id);
				$invoice_tc_desc = $item['invoice_tc_desc'];
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_invoice_tc/?ref_id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_invoice_tc/?ref_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '<a  class="btn btn-danger btn-xs"  href="' . get_module_path() . 'masters/deactivate_invoice_tc/?ref_id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#form_modal">
							<i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td style="text-align:center">' . $invoice_tc_desc . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// City Report
	public function tbl_city_list($page = 1)
	{

		$post_data = $this->input->post(Null, true);
		$state_id = $post_data['state_id'];
		$post_data['dist_list'] = array();
		if (!empty($state_id)) {
			$post_data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		}
		$this->session->set_userdata('city_post_data', $post_data);

		$dist_id = $post_data['dist_id'];
		$status = $post_data['status'];
		$status = $status ? $status : "Active";
		$searchStr = $post_data['searchStr'];
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$total_count = ($page == 1) ? Null : $this->session->userdata('city_total_count');


		if ($dist_id) {
			$result = $this->getCityDistrictIdDetails($state_id, $dist_id, $type, $status, $srch, $page, $total_count);
		} else {
			$result = $this->getCityDetails($type, $status, $srch, $page, $total_count);
		}

		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$this->session->set_userdata('city_total_count', $total_count);

		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_city_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['city_id'];
				$name = $item['city_name'];
				$city_state_name = $item['city_state_name'];
				$city_dist_name = $item['city_dist_name'];


				$status = $item['city_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_city/?city_id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_city/?city_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i>Edit</a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $city_state_name . '</td><td>' . $city_dist_name . '</td><td>' . $name_txt . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Area Report
	public function tbl_area_list($page = 1)
	{

		$post_data = $this->input->post(Null, true);
		$state_id = isset($post_data['state_id']) ? $post_data['state_id'] : Null;
		$dist_id = isset($post_data['dist_id']) ? $post_data['dist_id'] : Null;
		$post_data['dist_list'] = array();
		$post_data['city_list'] = array();
		if (!empty($state_id)) {
			$post_data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		}
		if (!empty($dist_id)) {
			$city_list = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
			$post_data['city_list'] = $city_list['jsArray'];
		}
		$this->session->set_userdata('area_post_data', $post_data);

		$city_id = isset($post_data['city_id']) ? $post_data['city_id'] : Null;
		$status = $post_data['status'];
		$status = $status ? $status : "Active";
		$searchStr = $post_data['searchStr'];
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$total_count = ($page == 1) ? Null : $this->session->userdata('area_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $state_id,
			"five" => $dist_id,
			"six" => $city_id,
			"seven" => $status,
			"eight" => $type,
			"nine" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getAreaCityIdDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$this->session->set_userdata('area_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_area_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['area_id'];
				$city_name = $item['city_name'];
				$state_name = $item['state_name'];
				$name = $item['area_name'];
				$dist_name = $item['dist_name'];
				$status = $item['area_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_area/?area_id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_area/?area_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_area/?area_id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $state_name . '</td><td>' . $dist_name . '</td><td>' . $city_name . '</td><td>' . $name_txt . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}



	// Notification  Report 
	public function tbl_notification_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$permission_id = $this->input->post('permission_id');
		$from_date = $this->input->post('noti_from');
		$to_date = $this->input->post('noti_to');
		$status = $this->input->post('status');
		$noti_type = $this->input->post('noti_type');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('noti_total_count');
		$searchStr = addslashes($searchStr);

		$this->session->set_userdata('noti_post_data', $post_data);
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
			$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $status,
				"six" => $permission_id,
				"eight" => $searchStr,
				"nine" => $from_date,
				"ten" => $to_date,
				"eleven" => $noti_type,
				"limit" => $this->perPage,
				"offset" => $page,
				"total_count" => $total_count,
			);
			$result = $this->api->call_v_api('getNotificationReportDetails', $params);
		}

		if ($role_id == TECHNICIAN_ROLE_ID || $role_id == SALES_ROLE_ID || $role_id == CUSTOMER_ROLE_ID) {
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
				"seven" => $noti_type,
				"eight" => $date,
				"limit" => $this->perPage,
				"offset" => $page,
				"total_count" => $total_count,

			);
			$result = $this->api->call_v_api('getNotificationDetails', $params);
		}
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('noti_total_count', $total_count);
		//echo "<pre/>"; print_r($list);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_notification_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['noti_id'];
				$name = $item['noti_title'];
				$noti_desc = $item['noti_desc'];
				$noti_img = $item['noti_img'];
				$image1 = str_replace("getAuthApiKey", APIKEY, $noti_img);
				$noti_title = $item['noti_title'];
				$noti_disp_fromdate_n = $item['noti_disp_fromdate_n'];
				$noti_disp_todate_n = $item['noti_disp_todate_n'];

				$status = $item['noti_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_notification/?noti_id=' . $id . '" title="View Details">' . $name . '</a>';
				$image_txt = '<a href="' . get_module_path() . 'masters/view_notification/?noti_id=' . $id . '" title="View Details"><img class="img-responsive" src="' . $image1 . '" alt="' . $name . '"></a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_notification/?noti_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_notification/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $image_txt . '</td><td>' . $name_txt . '</td><td>' . $noti_desc . '</td><td>' . $noti_disp_fromdate_n . '</td><td>' . $noti_disp_todate_n . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// SMS/WP Report 
	// SMS/WP Report 
	public function sms_wp_notification_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$permission_id = $this->input->post('permission_id');
		$from_date = $this->input->post('noti_from');
		$to_date = $this->input->post('noti_to');
		$wp_type = $this->input->post('noti_type');
		//  $highlight_id         = $this->input->post('highlight_id');
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('wp_total_count');
		$searchStr = addslashes($searchStr);

		$this->session->set_userdata('wp_post_data', $post_data);
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {


			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $permission_id,
				"five" => $searchStr,
				"six" => $from_date,
				"seven" => $to_date,
				"eight" => $wp_type,
				"limit" => $this->perPage,
				"offset" => $page,
				"total_count" => $total_count,
			);
			$result = $this->api->call_v_api('getWPEmailReportDetails', $params);
		}
		//   echo "<pre/>"; print_r($result);die;

		$list = $result['jsArray'];
		//$list = $result;
		//$list = isset($result['jsArray']) ? $result['jsArray'] : $result;

		$total_count = $result['total_count'];
		$this->session->set_userdata('wp_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/sms_wp_notification_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				//  $id            = $item['wp_id'];
				//  $wp_name          = $item['wp_title'];
				$cust_type = $item['customer_type'];
				$mob_no = $item['mobile_no'];
				$date_time = $item['sys_clock'];
				$wp_msg = $item['wp_messg'];
				$wp_img = $item['wp_image'];
				$image1 = str_replace("getAuthApiKey", APIKEY, $wp_img);
				//  $timestamp = date('Y-m-d H:i:s'); // System-generated date and time
				$id = base64_encode($id);
				$action_txt = "";
				$highlight_class = ($highlight_id == $id) ? "bg-grey-salt" : "";
				//  $wp_name_txt    =  '<a href="'.get_module_path().'admin/sms_email_report/?wp_id='.$id.'" title="View Details">'.$wp_name.'</a>';
				$image_txt = '<a href="' . get_module_path() . 'admin/sms_email_report/?wp_id=' . $id . '" title="View Details"><img class="img-responsive" src="' . $image1 . '" ></a>';
				//alt="'.$wp_name.'"

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $cust_type . '</td><td>' . $mob_no . '</td><td>' . $date_time . '</td><td>' . $wp_msg . '</td><td>' . $image_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='9' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}



	// One Time Service  Report 
	public function tbl_ots_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$post_data['page'] = $page;
		$this->session->set_userdata('ots_post_data', $post_data);
		//  kept by Anjali on 01/07/26.
		// $status = $this->input->post('status');
		// $status = $status ? $status : "Active";
		$selected_status = $this->input->post('status');      
		$status = $selected_status ? $selected_status : "Active";

		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('ots_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$highlight_id = $this->input->post('highlight_id');
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$display_total_count = $total_count;

		// Added by Anjali on 01/07/26: Select Status total includes Active and Deactivated one-time services.
		if (empty($selected_status)) {
			$deactivated_params = $params;
			$deactivated_params['four'] = "Deactivated";
			$deactivated_params['offset'] = 1;
			$deactivated_params['total_count'] = Null;
			$deactivated_result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $deactivated_params);
			$display_total_count += isset($deactivated_result['total_count']) ? (int) $deactivated_result['total_count'] : 0;
		}
		$this->session->set_userdata('ots_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_ots_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['ots_id'];
				$id1 = $item['ots_id'];
				$name = $item['ots_name'];
				$ots_desc = $item['ots_desc'];
				$ots_regular = $item['ots_regular'];
				$ots_commerial = $item['ots_commerial'];
				$ots_type = $item['ots_type'];
				$product_name = $item['product_name'];
				$ots_name = $item['ots_name'];


				$status = $item['ots_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_one_time_service/?id=' . $id . '" title="View Details">' . $name . '</a>';

				// if ($status == "Active") {
				// 	$status_txt = "<span class='label label-success'>Active</span>";
				// 	$action_txt = '<a  class="btn btn-primary btn-xs"  
				// 	href="' . get_module_path() . 'masters/edit_one_time_service/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

				// 	$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_one_time_service/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				// }

				// if ($status == "Deactivated") {
				// 	$status_txt = "<span class='label label-danger'>Deactivated</span>";
				// }

				//   added by anjali reactivate OTS POP-UP 
				if ($status == "Active") {

					$status_txt = "<span class='label label-success'>Active</span>";

			$action_txt = '<a class="btn btn-primary btn-xs"
				href="' . get_module_path() . 'masters/edit_one_time_service/?id=' . $id . '"
				title="Edit">
				<i class="fa fa-edit"></i>
			</a>';

			$action_txt .= '&nbsp;<a class="btn btn-danger btn-xs"
				data-href="' . get_module_path() . 'masters/deactivate_one_time_service/?id=' . $id . '"
				title="Deactivate"
				data-toggle="modal"
				data-target="#confirm-deactivate">
				<i class="fa fa-ban"></i>
			</a>';
				}

				if ($status == "Deactivated") {

					$status_txt = "<span class='label label-danger'>Deactivated</span>";

			$action_txt = '<a class="btn btn-success btn-xs"
				href="javascript:void(0)"
				data-href="' . get_module_path() . 'masters/reactivate_one_time_service/?id=' . $id . '"
				title="Reactivate"
				data-toggle="modal"
				data-target="#confirm-reactivate">
				<i class="fa fa-refresh"></i>
			</a>';
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '">
					<td>' . $sr_no . '</td>
					<td style="word-break:break-all;">' . $id1 . '</td>
					<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $name_txt . '</td>
					<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $ots_desc . '</td>
					<td>' . $ots_regular . '</td>
					<td>' . $ots_commerial . '</td>
					<td style="text-align:center">' . $action_txt . '</td>
				</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='9' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		// $data['total_count'] = $total_count; // Previous code kept by Anjali on 01/07/26.
		$data['total_count'] = $display_total_count;
		echo json_encode($data);
	}


	// AMC Service  Report 
	public function tbl_amc_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$post_data['page'] = $page;
		$this->session->set_userdata('amc_post_data', $post_data);
		$selected_status = $this->input->post('status');
		$status = $selected_status;
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('amc_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$highlight_id = $this->input->post('highlight_id');
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
			"order_by" => 'created_at DESC',
		);
		
		$result = $this->api->call_v_api('getAMCDetails', $params);
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$display_total_count = $total_count;

		// Added by Anjali on 01/07/26: Select Status total includes both Active and Deactivated AMC services.
		if (empty($selected_status)) {
			$deactivated_params = $params;
			$deactivated_params['four'] = "Deactivated";
			$deactivated_params['offset'] = 1;
			$deactivated_params['total_count'] = Null;
			$deactivated_result = $this->api->call_v_api('getAMCDetails', $deactivated_params);
			$display_total_count += isset($deactivated_result['total_count']) ? (int) $deactivated_result['total_count'] : 0;
		}
		
		$this->session->set_userdata('amc_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;

		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_amc_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['amc_id'];
				$id1 = $item['amc_id'];
				$name = $item['amc_name'];
				$ots_regular = $item['amc_price'];
				$ots_commerial = $item['amc_corporate_price'];

				$status = $item['amc_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_amc/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_amc/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_amc/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}
// changes done by anjali dhane 22/06/2026 AMC reactivate funtionality

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";

					$action_txt = '<a class="btn btn-success btn-xs"
						href="javascript:void(0)"
						data-href="' . get_module_path() . 'masters/reactivate_amc/?id=' . $id . '"
						title="Reactivate"
						data-toggle="modal"
						data-target="#confirm-reactivate">
						<i class="fa fa-refresh"></i>
					</a>';
				}


				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '">
					<td>' . $sr_no . '</td>
					<td style="word-break:break-all;">' . $id1 . '</td>
					<td style="max-width: 200px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">' . $name_txt . '</td>
					<td>' . $ots_regular . '</td>
					<td>' . $ots_commerial . '</td>
					<td style="text-align:center">' . $action_txt . '</td>
				</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $display_total_count;
		echo json_encode($data);
	}


	// Brand  Report 
	public function tbl_brand_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$post_data['page'] = $page;
		$this->session->set_userdata('brand_post_data', $post_data);
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('brand_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$highlight_id = $this->input->post('highlight_id');
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			// "five"=>$type,
			"five" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		//echo "<pre/>"; print_r($params);die;
		$result = $this->api->call_v_api('getBrandDetails1', $params);
		//  echo "<pre/>"; print_r($result);die;
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('brand_total_count', $total_count);


		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_brand_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['pdt_brnd_id'];
				$id1 = $item['pdt_brnd_id'];
				$name = $item['pdt_brnd_name'];
				// $ots_regular   = $item['amc_price'];
				// $ots_commerial = $item['amc_corporate_price'];
				$status = $item['pdt_brnd_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_amc/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_amc/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '"><td>' . $sr_no . '</td><td style="word-break:break-all;">' . $id1 . '</td><td>' . $name . '</td><td>' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Product Service  Report 
	public function tbl_product_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$post_data['page'] = $page;
		$this->session->set_userdata('product_post_data', $post_data);
		// changes by Anjali on 01/07/26.
		// $status = $this->input->post('status');
		// $status = $status ? $status : "Active";
		$selected_status = $this->input->post('status');
		$status = $selected_status ? $selected_status : "Active";

		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('product_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$highlight_id = $this->input->post('highlight_id');
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getProductMasterDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$display_total_count = $total_count;

		// Added by Anjali on 01/07/26: Select Status total includes Active and Deactivated sale products.
		if (empty($selected_status)) {
			$deactivated_params = $params;
			$deactivated_params['four'] = "Deactivated";
			$deactivated_params['offset'] = 1;
			$deactivated_params['total_count'] = Null;
			$deactivated_result = $this->api->call_v_api('getProductMasterDetails', $deactivated_params);
			$display_total_count += isset($deactivated_result['total_count']) ? (int) $deactivated_result['total_count'] : 0;
		}
		$this->session->set_userdata('product_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_product_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['pm_id'];
				$id1 = $item['pm_id'];
				$name = $item['pm_name'];
				$ots_regular = $item['pm_regular_price'];
				$ots_commerial = $item['pm_commercial_price'];
				$pm_model_name = $item['pm_model_name'];
				$pdt_brnd_name = $item['pdt_brnd_name'];

				$status = $item['pm_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_sale_product/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_sale_product/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_sale_product/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}
 //added by anjali reactivate Product funtionality
				// if ($status == "Deactivated") {
				// 	$status_txt = "<span class='label label-danger'>Deactivated</span>";
				// }

				if ($status == "Deactivated") {

					$status_txt = "<span class='label label-danger'>Deactivated</span>";

					$action_txt = '<a class="btn btn-success btn-xs"
						href="javascript:void(0)"
						data-href="' . get_module_path() . 'masters/reactivate_sale_product/?id=' . $id . '"
						title="Reactivate"
						data-toggle="modal"
						data-target="#confirm-reactivate">
						<i class="fa fa-refresh"></i>
					</a>';
				}
				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '">
					<td>' . $sr_no . '</td>
					<td style="word-break:break-all;">' . $id1 . '</td>
					<td style="max-width:100px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $name_txt . '</td>
					<td>' . $pm_model_name . '</td>
					<td>' . $pdt_brnd_name . '</td>
					<td>' . $ots_regular . '</td>
					<td>' . $ots_commerial . '</td>
					<td style="text-align:center">' . $status_txt . '</td>
					<td style="text-align:center">' . $action_txt . '</td>
				  </tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		// $data['total_count'] = $total_count; // Previous code kept by Anjali on 01/07/26.
		$data['total_count'] = $display_total_count;
		echo json_encode($data);
	}

	// Invoice Pattern  Report 
	public function tbl_invoice_pattern_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$this->session->set_userdata('i_patt_post_data', $post_data);
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('i_patt_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $type,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getMauliInvoicePatternMasterDetails', $params);

		$list = $result;
		$total_count = count($result);
		$this->session->set_userdata('i_patt_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_invoice_pattern_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['invoice_id'];
				$name = $item['invoice_pattern'];
				$status = $item['invoice_status'];
				$id = base64_encode($id);

				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_invoice_pattern/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_invoice_pattern/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_invoice_pattern/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td style="word-break:break-all;">' . $name_txt . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Invoice Pattern  Report 
	public function tbl_company_type_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$this->session->set_userdata('i_patt_post_data', $post_data);
		$status = $this->input->post('status');
		$status = $status ? $status : "Active";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('c_type_total_count');
		$type = isset($searchStr) ? "Search" : "Report";
		$searchStr = addslashes($searchStr);
		$srch = ($type == "Search") ? $searchStr : Null;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"six" => $searchStr,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getCompanyTypeReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('c_type_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_company_type_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['ctm_id'];
				$name = $item['ctm_type'];
				$ctm_name = $item['ctm_name'];
				$ctm_total_amt = $item['ctm_total_amt'];
				$status = $item['ctm_status'];
				$id = base64_encode($id);

				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'masters/view_company_type/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'masters/edit_company_type/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="' . get_module_path() . 'masters/deactivate_company_type/?id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td style="word-break:break-all;">' . $name_txt . '</td><td>' . $ctm_name . '</td><td>' . $ctm_total_amt . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Employee  Report 
	public function tbl_employee_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$permission_id = $this->input->post('permission_id');
		$department_id = $this->input->post('department_id');
		$sub_dept_id = $this->input->post('sub_dept_id');
		$status = $this->input->post('status');
		$post_data['sub_dept_list'] = array();
		if (!empty($department_id)) {
			$post_data['sub_dept_list'] = $this->getSubdepartmentDeptIdDetails($department_id, "Report");
		}
		$this->session->set_userdata('emp_post_data', $post_data);

		$status = $status ? $status : "";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('emp_total_count');
		$searchStr = addslashes($searchStr);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"six" => $searchStr,
			"seven" => $permission_id,
			"eight" => $department_id,
			"ten" => $sub_dept_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getEmployeeReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('emp_total_count', $total_count);

		//echo "<pre/>"; print_r($list);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_employee_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['emp_id'];
				$name = $item['emp_name'];
				//add by ritika on 22 june
				$display_name = (strlen($name) > 15) ? substr($name, 0, 15) . '...' : $name;

				$emp_mob1 = $item['emp_mob1'];
				$emp_mob2 = $item['emp_mob2'];
				$user_name = $item['user_name'];
				$permission_name = $item['permission_name'];

				$status = $item['emp_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				// $name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?id=' . $id . '" title="View Details">' . $name . '</a>';
				// add by ritika 25 may
				// $name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?id=' . $id . '&history=back&page=' . $page . '" title="View Details">' . $name . '</a>';
				$name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?id=' . $id . '&history=back&page=' . $page . '" title="' . $name . '">' . $display_name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					// $action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'admin/edit_employee/?id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';
					//add by ritika 
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'admin/edit_employee/?id=' . $id . '&page=' . $page . '&history=back" title="Edit"><i class="fa fa-edit"></i></a>';


					$action_txt .= '&nbsp;<a  data-toggle="modal" data-target="#form_modal" class="btn btn-danger btn-xs" href="' . get_module_path() . 'admin/deactivate_employee/?ref_id=' . $id . '" title="Deactivate" ><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
					$action_txt .= '&nbsp;<a  data-toggle="modal" data-target="#form_modal" class="btn btn-success btn-xs" href="' . get_module_path() . 'admin/reactivate_employee/?ref_id=' . $id . '" title="Re-Activate" ><i class="fa fa-check"></i></a>';
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $user_name . '</td><td>' . $name_txt . '</td><td>' . $permission_name . '</td><td>' . $emp_mob1 . '</td><td>' . $emp_mob2 . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Employee Location  Report 


	public function tbl_employee_location_list($page = 1)
	{
		$post_data = $this->input->post(null, true);
		$emp_id = $this->input->post('emp_id');
		$date = $this->input->post('date');
		$from_date = $this->input->post('from_date');

		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : Null;
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : "";


		$this->session->set_userdata('emp_loc_post_data', $post_data);

		$total_count = ($page == 1) ? null : $this->session->userdata('emp_loc_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $from_date,
			"six" => $date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getEmployeeLocationDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('emp_loc_total_count', $total_count);

		// Pagination configuration         
		$config['base_url'] = get_module_path() . 'ajax/tbl_employee_location_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['emp_id'];
				$mobile_date = $item['mobile_date'];
				$mobile_time = $item['mobile_time'];
				$address = $item['address'];
				$longt = $item['longt'];
				$latt = $item['latt'];
				// Create the Google Map URL
				$google_map_url = "https://maps.google.com/?q=" . $latt . "," . $longt;

				// Create the Google Map iframe
				$map_iframe = '<iframe width="350" height="200" src="https://maps.google.com/maps?q=' . $latt . ',' . $longt . '&hl=en&z=14&amp;output=embed" frameborder="0" style="border: 1px;" allowfullscreen></iframe>';



				$id = base64_encode($id);

				// Link the address to Google Maps
				$name_txt = '<a href="' . $google_map_url . '" target="_blank" title="View Location">' . $address . '</a>';


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $mobile_date . '</td><td>' . $mobile_time . '</td><td>' . $name_txt . '</td><td>' . $map_iframe . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;

		echo json_encode($data);
	}


	// Employee Attendance  Report 
	public function tbl_employee_attendance_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);

		$emp_id = $this->input->post('emp_id');
		$date = $this->input->post('date');

		$status_filter = $this->input->post('attendance_status');

		$month_year = $this->input->post('month_year');
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : strtoupper(date("d-M-Y"));

		if (!empty($month_year)) {
			$date = null;
		}

		$this->session->set_userdata('emp_loc_post_data1', $post_data);

		$total_count = ($page == 1) ? Null : $this->session->userdata('emp_loc_total_count');
		$present_count = ($page == 1) ? Null : $this->session->userdata('attendance_present_count');
		$absent_count = ($page == 1) ? Null : $this->session->userdata('attendance_absent_count');

		if (!empty($month_year) && !empty($emp_id)) {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $emp_id,
				"five" => $date,
				"six" => $month_year,
				// "seven" => $status_filter,
				"limit" => 31,

				"total_count" => $total_count,
				"present_count" => $present_count,
				"absent_count" => $absent_count,
			);
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $emp_id,
				"five" => $date,
				"six" => $month_year,
				"seven" => $status_filter,
				"limit" => $this->perPage,
				"offset" => $page,
				"total_count" => $total_count,
				"present_count" => $present_count,
				"absent_count" => $absent_count,
			);
		}

		$result = $this->api->call_v_api('getEmployeeAttendanceDetails01', $params);

		$this->session->set_userdata('attendance_present_count', $result['present_count']);
		$this->session->set_userdata('attendance_absent_count', $result['absent_count']);

		$present_count = $result['present_count'];
		$absent_count = $result['absent_count'];

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('emp_loc_total_count', $total_count);
		//echo "<pre/>"; print_r($list);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_employee_attendance_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			if (!empty($month_year) && !empty($emp_id)) {

				$attendance_dates = array();

				foreach ($list as $item) {

					if (!empty($item['emp_attd_login'])) {

						$attendance_dates[
							date('Y-m-d', strtotime($item['emp_attd_login']))
						] = $item;
					}
				}

				$month = substr($month_year, 0, 2);
				$year = substr($month_year, 3, 4);

				$total_days = cal_days_in_month(
					CAL_GREGORIAN,
					$month,
					$year
				);
				$count = 1;
				for ($i = 1; $i <= $total_days; $i++) {

					$current_date = sprintf(
						'%04d-%02d-%02d',
						$year,
						$month,
						$i
					);
					$today = date('Y-m-d');


					if ($current_date > $today) {
						continue;
					}

					if (isset($attendance_dates[$current_date])) {

						if ($status_filter == "ABSENT") {
							continue;
						}

						$item = $attendance_dates[$current_date];
						$item = $attendance_dates[$current_date];

						$emp_name = $item['emp_name'];

						$login_address = $item['empIn_address'];
						$logout_address = $item['empOut_address'];

						$Inname_txt = $login_address;
						$Outname_txt = $logout_address;

						$Inlongt = $item['loglongt'];
						$Inlatt = $item['loglatt'];
						$Outlongt = $item['outlongt'];
						$Outlatt = $item['outlatt'];
						$google_map_urlin = "https://maps.google.com/?q=" . $Inlatt . "," . $Inlongt;

						//create google map url for logout
						$google_map_urlout = "https://maps.google.com/?q=" . $Outlatt . "," . $Outlongt;


						//change by kiran dhaije 090125
						$Inname_txt = '<a href="' . $google_map_urlin . '" target="_blank" title="' . htmlspecialchars($login_address) . '">' . $login_address . '</a>';

						$Outname_txt = '<a href="' . $google_map_urlout . '" target="_blank" title="' . htmlspecialchars($logout_address) . '">' . $logout_address . '</a>';

						$image_txt1 = '<img class="img-responsive" style="height:100px; width:100px" src="' .
							str_replace("getAuthApiKey", APIKEY, $item['emp_attd_login_img']) . '">';

						$image_txt2 = '<img class="img-responsive" style="height:100px; width:100px" src="' .
							str_replace("getAuthApiKey", APIKEY, $item['emp_attd_logout_img']) . '">';

						$attendance_status =
							'<span class="label label-success">Present</span>';

						$mobile_date = $item['emp_attd_login'];
						$mobile_time = $item['emp_attd_logout'];

						$mobile_date = !empty($item['emp_attd_login'])
							? date('d-M-Y h:i A', strtotime($item['emp_attd_login']))
							: '';

						$mobile_time = !empty($item['emp_attd_logout'])
							? date('d-M-Y h:i A', strtotime($item['emp_attd_logout']))
							: '';

						$mobile_date1 = $item['emp_attd_login'];

						$mobile_time1 = $item['emp_attd_logout'];

						$attendance_status = '';
						if (!empty($mobile_date1) && !empty($mobile_time1)) {
							$attendance_status = "<span class='label label-warning'>Logged Out</span>";
						} elseif (!empty($mobile_date1)) {
							$attendance_status = '<span class="label label-success">Present</span>';
						} else {
							$attendance_status = '<span class="label label-danger">Absent</span>';
						}

						$present_count++;


					} else {

						if ($status_filter == "PRESENT") {
							continue;
						}

						$emp_name = $list[0]['emp_name'];

						$image_txt1 = '-';
						$image_txt2 = '-';

						$Inname_txt = '-';
						$Outname_txt = '-';

						$attendance_status =
							'<span class="label label-danger">Absent</span>';

						$mobile_date = date(
							'd-M-Y',
							strtotime($current_date)
						);

						$mobile_time = '-';
						$absent_count++;
					}

					// generate row
					$html .= '<tr>
						<td>' . $count++ . '</td>
						<td>' . $emp_name . '</td>
						<td>' . $image_txt1 . '</td>
						<td>' . $mobile_date . '</td>

						<td>
							<div style="
								height:100px;
								overflow:hidden;
								line-height:20px;
								word-break:break-word;
								display:-webkit-box;
								-webkit-line-clamp:5;
								-webkit-box-orient:vertical;
							">
								' . $Inname_txt . '
							</div>
						</td>

						<td>' . $image_txt2 . '</td>
						<td>' . $mobile_time . '</td>

						<td>
							<div style="
								height:100px;
								overflow:hidden;
								line-height:20px;
								word-break:break-word;
								display:-webkit-box;
								-webkit-line-clamp:5;
								-webkit-box-orient:vertical;
							">
								' . $Outname_txt . '
							</div>
						</td>
						<td>' . $attendance_status . '</td>
					</tr>';
				}
				$total_count = $present_count + $absent_count;

			} else {
				foreach ($list as $key => $item) {
					$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
					$emp_name = $item['emp_name'];
					$mobile_date1 = $item['emp_attd_login'];
					$mobile_date = !empty($item['emp_attd_login'])
						? date('d-M-Y h:i A', strtotime($item['emp_attd_login']))
						: '';
					$mobile_time1 = $item['emp_attd_logout'];
					$mobile_time = !empty($item['emp_attd_logout'])
						? date('d-M-Y h:i A', strtotime($item['emp_attd_logout']))
						: '';
					$status = $item['emp_attd_status'];
					$id = $item['emp_attd_id'];
					$name = "image";
					//change by kiran dhaije 090125
					$login_address = $item['empIn_address'];
					$logout_address = $item['empOut_address'];

					$emp_login_img = $item['emp_attd_login_img'];
					$emp_logout_img = $item['emp_attd_logout_img'];
					$Inlongt = $item['loglongt'];
					$Inlatt = $item['loglatt'];
					$Outlongt = $item['outlongt'];
					$Outlatt = $item['outlatt'];
					//create google map url for login
					$google_map_urlin = "https://maps.google.com/?q=" . $Inlatt . "," . $Inlongt;

					//create google map url for logout
					$google_map_urlout = "https://maps.google.com/?q=" . $Outlatt . "," . $Outlongt;

					$image1 = str_replace("getAuthApiKey", APIKEY, $emp_login_img);
					//change by kiran dhaije 090125
					$Inname_txt = '<a href="' . $google_map_urlin . '" target="_blank" title="' . htmlspecialchars($login_address) . '">' . $login_address . '</a>';

					$Outname_txt = '<a href="' . $google_map_urlout . '" target="_blank" title="' . htmlspecialchars($logout_address) . '">' . $logout_address . '</a>';

					$image2 = str_replace("getAuthApiKey", APIKEY, $emp_logout_img);


					$image_txt1 = '<img class="img-responsive" style="height:100px; width:100px" src="' . $image1 . '" alt="' . $name . '">';

					$image_txt2 = '<img class="img-responsive" style="height:100px; width:100px" src="' . $image2 . '" alt="' . $name . '">';



					if ($status == 'Active') {
						$login_status = '<span class="btn btn-success" style="color: white;  ">Logged In</span>';
					} else {
						$login_status = '<span class="btn btn-secondary" style="color: gray;">Logged Out</span>';
					}

					// $Inname_txt = '<a href="' . $google_map_urlin . '" target="_blank" title="View Location">' . $login_address . '</a>';

					// $Outname_txt = '<a href="' . $google_map_urlout . '" target="_blank" title="View Location">' . $logout_address . '</a>';

					$attendance_status = '';
					if (!empty($mobile_date1) && !empty($mobile_time1)) {
						$attendance_status = "<span class='label label-warning'>Logged Out</span>";
					} elseif (!empty($mobile_date1)) {
						$attendance_status = '<span class="label label-success">Present</span>';
					} else {
						$attendance_status = '<span class="label label-danger">Absent</span>';
					}

					//change by kiran dhaije 090125
					$html .= '<tr>
								<td>' . $sr_no . '</td>
								<td>' . $emp_name . '</td>
								<td>' . $image_txt1 . '</td>
								<td>' . $mobile_date . '</td>
								<td style="width:180px; max-width:180px;">
									<div style="
										height:100px;
										overflow:hidden;
										line-height:20px;
										word-break:break-word;
										display:-webkit-box;
										-webkit-line-clamp:5;
										-webkit-box-orient:vertical;
									">
										' . $Inname_txt . '
									</div>
								</td>

								<td>' . $image_txt2 . '</td>
								<td>' . $mobile_time . '</td>

								<td style="width:180px; max-width:180px;">
									<div style="
										height:100px;
										overflow:hidden;
										line-height:20px;
										word-break:break-word;
										display:-webkit-box;
										-webkit-line-clamp:5;
										-webkit-box-orient:vertical;
									">
										' . $Outname_txt . '
									</div>
								</td>
								<td>' . $attendance_status . '</td>
							</tr>';
					//	$html .= '<tr><td>'.$sr_no.'</td><td>'.$emp_name .'</td><td>'.$Inname_txt.'</td><td>'.$Outname_txt.'</td><td>'.$mobile_date.'</td><td>'.$image_txt1.'</td><td>'.$mobile_time.'</td><td>'.$image_txt2.'</td><td>'.$login_status.'</td></tr>';

				}
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		$data['present_count'] = $present_count;
		$data['absent_count'] = $absent_count;
		echo json_encode($data);
	}

	// Employee  Report for manual attendance (kaushik.pachore 18-05-2026)
	public function tbl_employee_list_1($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$permission_id = $this->input->post('permission_id');
		$department_id = $this->input->post('department_id');
		$sub_dept_id = $this->input->post('sub_dept_id');
		$status = $this->input->post('status');
		$post_data['sub_dept_list'] = array();
		if (!empty($department_id)) {
			$post_data['sub_dept_list'] = $this->getSubdepartmentDeptIdDetails($department_id, "Report");
		}
		$this->session->set_userdata('emp_post_data', $post_data);

		$status = $status ? $status : "";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('emp_total_count');
		$searchStr = addslashes($searchStr);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"six" => $searchStr,
			"seven" => $permission_id,
			"eight" => $department_id,
			"ten" => $sub_dept_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		// $result = $this->api->call_v_api('getEmployeeReportDetails',$params);
		$result = $this->api->call_v_api('getEmployeeReportDetails01', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('emp_total_count', $total_count);

		//echo "<pre/>"; print_r($list);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_employee_list_1';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				// $id          = $item['emp_id'];
				$id = $item['user_id'];
				// $name        = $item['emp_name'];
				$name = $item['user_person_name'];
				// $emp_mob1    = $item['emp_mob1'];
				$emp_mob1 = $item['user_mob'];
				$emp_mob2 = $item['emp_mob2'];
				$user_name = $item['user_name'];
				// $permission_name    = $item['permission_name'];
				$permission_name = !empty($item['permission_name']) ? $item['permission_name'] : 'Reliever';


				$status = $item['user_status'];
				$user_id = $item['user_id'];
				$id = base64_encode($user_id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if (strlen($name) > 25) {
					$name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?id=' . $id . '" title="View Details">' . substr($name, 0, 25) . '...</a>';
				}


				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";

					// Login button logic
					$action_txt = '<a data-toggle="modal" data-target="#form_modal" class="btn btn-primary btn-xs" href="' . get_module_path() . 'admin/login_popup/?id=' . $id . '" title="Login">
							<i class="fa fa-sign-in"></i>&nbspLogin</a>';

					// Logout button logic 
					$action_txt .= '&nbsp;<a data-toggle="modal" data-target="#form_modal_one" class="btn btn-danger btn-xs" href="' . get_module_path() . 'admin/logout_popup/?id=' . $id . '" title="Logout">
							Logout&nbsp<i class="fa fa-sign-out"></i></a>';
				}


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $user_name . '</td><td>' . $name_txt . '</td><td>' . $permission_name . '</td><td>' . $emp_mob1 . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $action_txt . '</td></tr>';

			}

		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);


	}

	// Lead  Report 
	public function tbl_lead_list($page = 1)
	{

		$perPage = 25;
		$post_data = $this->input->post(Null, true);
		$product_id = $this->input->post('product_id');
		$state_id = $this->input->post('state_id');
		$dist_id = $this->input->post('dist_id');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		$ref_id = $this->input->post('ref_id');
		$priority = $this->input->post('priority');
		$followup = $this->input->post('followup');
		$highlight_id = $this->input->post('highlight_id');
		$em_id = $this->input->post('emp_id');
		$transfer_to = $this->input->post('transfer_to');

		$post_data['dist_list'] = array();
		$post_data['city_list'] = array();
		$post_data['area_list'] = array();

		if (!empty($state_id)) {
			$post_data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		}

		if (!empty($dist_id)) {
			$city_list = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
			$post_data['city_list'] = $city_list['jsArray'];
		}
		if (!empty($city_id)) {
			$post_data['area_list'] = $this->getAreaCityIdDetails($state_id, $dist_id, $city_id);
		}

		$lead_date = $this->input->post('lead_date');
		$lead_month_year = $this->input->post('lead_month_year');

		$role_id = $this->_role_id;

		$em_id = $this->_user_id;
		// $transfer_to =$this->_user_id;;

		// if (empty($transfer_to)) {
		// 	$transfer_to = $this->_user_id;
		// }


		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('added_by');
			//   $transfer_to = null;
			$transfer_to = $this->input->post('transfer_to');
			$em_id = $this->input->post('emp_id');
		}

		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		$searchStr_contact = $this->input->post('searchStr_contact');
		$searchStr_name = addslashes($searchStr_name);
		$searchStr_contact = addslashes($searchStr_contact);

		$total_count = ($page == 1) ? Null : $this->session->userdata('lead_total_count');
		$post_data['page'] = $page;
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
			"twentythree" => $area_id,
			"twentyfour" => $em_id,
			"twentyfive" => $transfer_to,

			"limit" => $perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('lead_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_lead_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table

		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $perPage) + ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$owner = $item['user_person_name'];
				$lead_id = $id;
				// Changes by Shawn Arakal - 14-08-2026: reference name for the new Reference column
				$ref_name = isset($item['ref_name']) ? $item['ref_name'] : "";

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '">
					<td>' . $sr_no . '</td>
					<td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 250px; display: inline-block;">' . $name_txt . '</span></td>
					<td>' . $clm_contact . '</td>
					<td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 450px; display: inline-block;">' . $clm_address . '</span></td>
					<!-- Changes by Shawn Arakal - 14-08-2026: Reference column added to show the lead source reference (e.g. Facebook Lead API) -->
				    <td>' . $ref_name . '</td>
				    <td style="display:none;">
                    <input type="checkbox" class="lead-checkbox" data-id="' . $lead_id . '" />
                	</td>
					<td style="display:none;">
						' . $owner . '
                	</td>
					</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}




	//22-01-2025
	public function tbl_trf_lead_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$product_id = $this->input->post('product_id');
		$state_id = $this->input->post('state_id');
		$dist_id = $this->input->post('dist_id');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		$ref_id = $this->input->post('ref_id');
		$priority = $this->input->post('priority');
		$followup = $this->input->post('followup');
		$highlight_id = $this->input->post('highlight_id');
		$em_id = $this->input->post('emp_id');

		$post_data['dist_list'] = array();
		$post_data['city_list'] = array();
		$post_data['area_list'] = array();

		if (!empty($state_id)) {
			$post_data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		}

		if (!empty($dist_id)) {
			$city_list = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
			$post_data['city_list'] = $city_list['jsArray'];
		}
		if (!empty($city_id)) {
			$post_data['area_list'] = $this->getAreaCityIdDetails($state_id, $dist_id, $city_id);
		}

		$lead_date = $this->input->post('lead_date');
		$lead_month_year = $this->input->post('lead_month_year');

		$role_id = $this->_role_id;

		$added_by = $this->_user_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('added_by');
		}

		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		$searchStr_contact = $this->input->post('searchStr_contact');
		$searchStr_name = addslashes($searchStr_name);
		$searchStr_contact = addslashes($searchStr_contact);

		$total_count = ($page == 1) ? Null : $this->session->userdata('lead_total_count');
		$post_data['page'] = $page;
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
			"twentythree" => $area_id,
			"twentyfour" => $em_id,

			// "limit"=>$this->perPage,
			// "offset"=>$page,
			// "total_count"=>$total_count,
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('lead_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_lead_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?id=' . $id . '" title="View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '"><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td>' . $clm_contact . '</td><td>' . $clm_address . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Vihas added this on 30/01/2026
	public function tbl_lead_list_new($page = 1)
	{

		$perPage = 25;
		$post_data = $this->input->post(Null, true);
		$product_id = $this->input->post('product_id');
		$state_id = $this->input->post('state_id');
		$dist_id = $this->input->post('dist_id');
		$city_id = $this->input->post('city_id');
		$area_id = $this->input->post('area_id');
		$ref_id = $this->input->post('ref_id');
		$priority = $this->input->post('priority');
		$followup = $this->input->post('followup');
		$highlight_id = $this->input->post('highlight_id');
		$em_id = $this->input->post('emp_id');
		$transfer_to = $this->input->post('transfer_to');
		// Added by Anjali 29/06/26
		$summary_employee_name = trim((string) $this->input->post('summary_employee_name'));

		$post_data['dist_list'] = array();
		$post_data['city_list'] = array();
		$post_data['area_list'] = array();

		if (!empty($state_id)) {
			$post_data['dist_list'] = $this->getDistrictStateIdDetails($state_id, "Report");
		}

		if (!empty($dist_id)) {
			$city_list = $this->getCityDistrictIdDetails($state_id, $dist_id, "Report");
			$post_data['city_list'] = $city_list['jsArray'];
		}
		if (!empty($city_id)) {
			$post_data['area_list'] = $this->getAreaCityIdDetails($state_id, $dist_id, $city_id);
		}

		$lead_date = $this->input->post('lead_date');
		$lead_month_year = $this->input->post('lead_month_year');

		$role_id = $this->_role_id;

		// Added by Anjali 29/06/26
		if (empty($em_id)) {
		$em_id = $this->_user_id;
		}
		// $transfer_to =$this->_user_id;;

		// if (empty($transfer_to)) {
		// 	$transfer_to = $this->_user_id;
		// }


		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('added_by');
			//   $transfer_to = null;
			$transfer_to = $this->input->post('transfer_to');
			$em_id = $this->input->post('emp_id');
		}

		$status = $this->input->post('status');
		$status = $status ? $status : "";

		if ($status == 'Approval Requested') {
			$status = 'FS';
		}

		$searchStr_name = $this->input->post('searchStr_name');
		$searchStr_contact = $this->input->post('searchStr_contact');
		$searchStr_name = addslashes($searchStr_name);
		$searchStr_contact = addslashes($searchStr_contact);

		$total_count = ($page == 1) ? Null : $this->session->userdata('lead_total_count');
		$post_data['page'] = $page;
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
			"twentythree" => $area_id,
			"twentyfour" => $em_id,
			"twentyfive" => $transfer_to,

			"limit" => $perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];

		// Added by Anjali 29/06/26
		// Some ROI summary employees do not resolve through the API's emp_id
		// filter. For summary links only, retry without that filter and match the
		// owner name returned with each lead. The visible Employee filter remains
		// selected and normal report requests continue using the standard API path.
		if ($summary_employee_name !== '' && empty($list)) {
			$fallback_params = $params;
			$fallback_params['twentyfour'] = '';
			$fallback_params['limit'] = 5000;
			$fallback_params['offset'] = 1;
			$fallback_params['total_count'] = Null;

			$fallback_result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $fallback_params);
			$fallback_list = !empty($fallback_result['jsArray']) && is_array($fallback_result['jsArray'])
				? $fallback_result['jsArray']
				: array();
			$employee_name_key = strtolower(trim(preg_replace('/\s+/', ' ', $summary_employee_name)));
			$employee_leads = array();

			foreach ($fallback_list as $lead) {
				$owner_name = isset($lead['user_person_name']) ? $lead['user_person_name'] : '';
				$owner_name_key = strtolower(trim(preg_replace('/\s+/', ' ', $owner_name)));

				if ($owner_name_key === $employee_name_key) {
					$employee_leads[] = $lead;
				}
			}

			$total_count = count($employee_leads);
			$list = array_slice($employee_leads, ($page - 1) * $perPage, $perPage);
		}
		$this->session->set_userdata('lead_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_lead_list_new';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table

		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $perPage) + ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_contact_person = $item['clm_contact_person'];
				$clm_company_name = $item['clm_company_name'];
				$status = $item['clm_status'];
				$owner = $item['user_person_name'];
				$lead_id = $id;

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?id=' . $id . '" title="Click here to View Details">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '">
					<td>' . $sr_no . '</td>
					<td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 250px; display: inline-block;">' . $name_txt . '</span></td>
					<td>' . $clm_contact_person . '</td>
					<td>' . $clm_company_name . '</td>
					<td>' . $clm_contact . '</td>
					<td class="action-col" style="display:none;">
                    <input type="checkbox" class="lead-checkbox" data-id="' . $lead_id . '" />
                	</td>
					<td style="display:none;" class="owner-col">
						' . $owner . '
                	</td>
					</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}





	// Customer  Report 
	public function tbl_customer_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$service_type = $this->input->post('service_type');
		//add by ritika
		$service_name = $this->input->post('service_name');

		$highlight_id = $this->input->post('highlight_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		//$searchStr_contact    = $this->input->post('searchStr_contact');		
		$searchStr_cust_id = $this->input->post('searchStr_cust_id');

		$searchStr_name = addslashes($searchStr_name);
		// $searchStr_contact    = addslashes($searchStr_contact);	
		$searchStr_cust_id = addslashes($searchStr_cust_id);

		$gst = $this->input->post('gst');

		$total_count = ($page == 1) ? Null : $this->session->userdata('cust_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('cust_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"six" => $searchStr_name,
			/* "seven"=>$searchStr_contact, */
			"eight" => $searchStr_cust_id,
			"nine" => $service_type,
			// add by ritika
			"fourteen" => $service_name,
			// 
			"twelve" => $gst,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		//    $result = $this->api->call_v_api('getCustomerMasterReportDetails',$params);
		// print_r($params);
		// die;

		$result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('cust_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_customer_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['customer_id'];
				$name = $item['customer_name'];
				$cust_landline = $item['cust_landline'];
				$cust_company_name = $item['cust_company_name'];
				$customer_contact = $item['customer_contact'];
				$customer_address = $item['customer_address'];
				$customer_contact_email = $item['customer_contact_email'];
				$customer_gstno = $item['customer_gstno'];
				$status = $item['cust_status'];
				$customer_contact_person = $item['customer_contact_person'];


				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?id=' . $id . '" title="' . $name . '">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}
				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '">
				<td>' . $sr_no . '</td>
				<td style="width:120px; max-width:120px;">
					<span style="
						display:block;
						overflow:hidden;
						text-overflow:ellipsis;
						white-space:nowrap;
					">' . $name_txt . '</span>
				</td>
				<td style="width:120px; max-width:120px;">
					<span style="
						display:block;
						overflow:hidden;
						text-overflow:ellipsis;
						white-space:nowrap;
					">' . $cust_company_name . '</span>
				</td>
				<td style="width:120px; max-width:120px;">
					<span style="
						display:block;
						overflow:hidden;
						text-overflow:ellipsis;
						white-space:nowrap;
					">' . $customer_contact_person . '</span>
				</td>
				<td>' . $customer_contact . '</td>
				<td title="' . $customer_address . '" style="width:120px; max-width:120px;">
					<span style="
						display:block;
						overflow:hidden;
						text-overflow:ellipsis;
						white-space:nowrap;
					">' . $customer_address . '</span>
				</td>
			
			</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}






	// public function get_service_name_list()
	// {
	// 	echo '<option value="1">TEST AMC</option>';
	// }
	//add by ritika 17 june 26
	public function get_service_name_list()
	{
		$service_type = $this->input->post('service_type');

		$html = '<option value="">Select Service Name</option>';

		if ($service_type == 'AMC') {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$response = $this->api->call_v_api('getAMCDetails', $params);

			if (!empty($response['jsArray'])) {
				// foreach ($response['jsArray'] as $row) {
				// 	$html .= '<option value="' . $row['amc_id'] . '">' . $row['amc_name'] . '</option>';
				// }

				foreach ($response['jsArray'] as $row) {

					$name = $row['amc_name'];

					$display_name = (strlen($name) > 25)
						? substr($name, 0, 25) . '...'
						: $name;

					$html .= '<option value="' . $row['amc_id'] . '" title="' . $name . '">' . $display_name . '</option>';
				}
			}
		} elseif ($service_type == 'One Time Service') {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$response = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);

			if (!empty($response['jsArray'])) {
				// foreach ($response['jsArray'] as $row) {
				// 	$html .= '<option value="' . $row['ots_id'] . '">' . $row['ots_name'] . '</option>';
				// }

				foreach ($response['jsArray'] as $row) {

					$name = $row['ots_name'];

					$display_name = (strlen($name) > 25)
						? substr($name, 0, 25) . '...'
						: $name;

					$html .= '<option value="' . $row['ots_id'] . '" title="' . $name . '">' . $display_name . '</option>';
				}
			}
		} elseif ($service_type == 'Sales') {

			$response = $this->getProductMasterDetails();

			if (!empty($response)) {
				// foreach ($response as $row) {
				// 	$html .= '<option value="' . $row['pm_id'] . '">' . $row['pm_name'] . '</option>';
				// }

				foreach ($response as $row) {

					$name = $row['pm_name'];

					$display_name = (strlen($name) > 25)
						? substr($name, 0, 25) . '...'
						: $name;

					$html .= '<option value="' . $row['pm_id'] . '" title="' . $name . '">' . $display_name . '</option>';
				}
			}
		}

		echo $html;
	}



	// Payment  Report 
	public function tbl_payment_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$service_type = $this->input->post('service_type');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr_name = $this->input->post('searchStr_name');
		$payment_date = $this->input->post('payment_date');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$highlight_id = $this->input->post('highlight_id');

		$searchStr_name = addslashes($searchStr_name);
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";
		$payment_date = !empty($payment_date) ? strtoupper(date("d-M-Y", strtotime($payment_date))) : "";

		$total_count = ($page == 1) ? Null : $this->session->userdata('payment_total_count');
		$total_amount = ($page == 1) ? $result['total_amount'] : $this->session->userdata('received_total_count');
		$this->session->set_userdata('received_total_count', $total_amount);


		$post_data['page'] = $page;
		$this->session->set_userdata('payment_post_data', $post_data);

		$role_id = $this->_role_id;
		// $user_id = $this->_user_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
			$user_id = Null;
		}
		// $user_id = Null;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $user_id,
			// "five"=>$service_type,
			"six" => $payment_date,
			"seven" => $from_date,
			"eight" => $to_date,
			"nine" => $searchStr_name,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
			"total_amount" => $total_amount,
		);
		$result = $this->api->call_v_api('getCollectionDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$total_amount = $result['total_amount'];
		$this->session->set_userdata('payment_total_count', $total_count);
		$this->session->set_userdata('received_total_count', $total_amount);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_payment_list';
		$config['reuse_query_string'] = false;
		$config['total_rows'] = $total_count;
		// $config['total_rows']  = $total_amount; 
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {

			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['cbpm_custid'];
				//$id          	    = $item['cp_id'];
				$name = $item['customer_name'];
				// $cbpd_product_type  = $item['cbpd_product_type'];
				$cbpm_amount = $item['cbpm_amount'];
				$cp_receiptno = $item['cp_receiptno'];
				$cbpm_billno = $item['cbpm_billno'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$status = $item['cp_status'];
				$cp_udate_n = $item['cp_udate_n'];
				$customer_contact = $item['customer_contact'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];
				$cp_amnt = $item['cp_amount'];
				$CBPM_RECEIVED_AMNT = $item['cbpm_balance_amnt'];
				$cbpm_balance_amnt1 = $cbpm_amount - $cbpm_balance_amnt;
				$cp_balance_amnt = $item['cp_balance_amnt'];

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				// $name_txt    =  '<a href="'.get_module_path().'customers/view_payment/?id='.$id.'&billno='.base64_encode($cbpm_billno).'" title="'.$cp_udate_n.'">'.$name.'</a>';
				$name_txt = '<a href="' . get_module_path() . 'customers/view_payment/?id=' . $id . '" title="' . $cp_udate_n . '">' . $name . '</a>';

				if ($status == "Paid") {
					$status_txt = "<span class='label label-success'>Paid</span>";
				}

				if ($status == "Closed" || $status == "Cancel") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}
				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '"><td>' . $sr_no . '</td><td>' . $cp_udate_n . '</td><td>' . $name_txt . '</td><td>' . $customer_contact . '</td><td>' . $cp_receiptno . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cp_amnt . '</td><td>' . $cp_balance_amnt . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		$data['total_amount'] = $total_amount;
		echo json_encode($data);
	}



	// Followup  Report 
	public function tbl_followup_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$ticket_assign_to = $this->input->post('ticket_assign_to');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr_name = $this->input->post('searchStr_name');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$highlight_id = $this->input->post('highlight_id');

		$searchStr_name = addslashes($searchStr_name);
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$ticket_assign_to = $this->_user_id;
		$role_id = $this->_role_id;

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$ticket_assign_to = $this->input->post('ticket_assign_to');
		}
		$total_count = ($page == 1) ? Null : $this->session->userdata('followup_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('followup_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"eight" => $ticket_assign_to,
			"nine" => "Followup",
			"ten" => $searchStr_name,
			"eleven" => $from_date,
			"twelve" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getFollowupMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('followup_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_followup_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$status = $item['followup_status'];
				$customer_contact = $item['customer_contact'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$followup_id = base64_encode($followup_id);
				$ref_id = base64_encode($ref_id);

				$name_txt = "";
				$view_txt = "";
				if (!empty($item['customer_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'customers/view_followup/?id=' . $customer_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				}
				if (!empty($item['clm_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'leads/view_followup/?id=' . $clm_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				}
				$str = '?id=' . $id . '&cust_id=' . $customer_id . '&clm_id=' . $clm_id;

				$action_txt = "";
				$assign_txt = "";

				$status_txt = "<span class='label label-warning'>" . $status . "</span>";


				$add_txt = '<a  class="btn btn-success btn-xs" href="' . get_module_path() . 'customers/add_followup/' . $str . '" title="Add Followup" data-toggle="modal" data-target="#form_modal"><i class="fa fa-commenting-o"></i></a>';
				if ($status == "Following") {
					$status_txt = "<span class='label label-success'>Following</span>";
					if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
						$assign_txt = '<a class="btn btn-danger btn-xs" href="' . get_module_path() . 'customers/assign_followup/' . $str . '" title="Assign Followup" data-toggle="modal" data-target="#form_modal"><i class="fa fa-user-plus"></i></a>';
					}
				}

				if ($status == "Closed") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $ref_id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr><td class="' . $highlight_class . '">' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $contact . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $view_txt . ' &nbsp;' . $add_txt . '&nbsp;' . $assign_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	public function tbl_my_followup_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$ticket_assign_to = NULL;
		$assigned_to = $this->input->post('assigned_to');
		$ticket_assign_to = $this->input->post('ticket_assign_to');
		$from_date = $this->input->post('from_date');
		$priority = $this->input->post('priority');
		$type_filter = $this->input->post('type_filter');
		$highlight_id = base64_decode($this->input->post('highlight_id'));


		if ($from_date == "MY") {
			$from_date = strtoupper(date("d-M-Y"));
			$ticket_assign_to = $this->_user_id;
			$role_id = $this->_role_id;
			if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
				$ticket_assign_to = $this->input->post('ticket_assign_to');
			}
		}
		if ($assigned_to == "MY") {
			$ticket_assign_to = $this->_user_id;
			$from_date = $from_date = strtoupper(date("d-M-Y"));
		}

		$role_id = $this->_role_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('my_followup_total_count');
		$post_data['page'] = $page;

		$this->session->set_userdata('my_followup_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $ticket_assign_to,
			"seven" => $from_date,
			"twelve" => $priority,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		$list = $result['jsArray'];

		// Apply type filter without changing API
		// Vihas added on 30/01/2026
		if (!empty($type_filter)) {

			if ($type_filter == "quotation") {
				$list = array_filter($list, function ($item) {
					return !empty($item['quotation_id']);
				});
			}

			if ($type_filter == "customer") {
				$list = array_filter($list, function ($item) {
					return !empty($item['customer_id']);
				});
			}

			if ($type_filter == "lead") {
				$list = array_filter($list, function ($item) {
					return !empty($item['clm_id']);
				});
			}

			// Reindex array after filter
			$list = array_values($list);
		}

		$total_count = $result['total_count'];
		$this->session->set_userdata('my_followup_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_my_followup_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$status = $item['followup_status'];
				$customer_contact = $item['customer_contact'];
				$quotation_id = $item['quotation_id'];

				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$followup_id = base64_encode($followup_id);
				$quotation_id = base64_encode($quotation_id);

				$priority = $item['clm_priority_level'] ?? '';
				$name_txt = "";
				$view_txt = "";

				// Vihas added on 20/03/2026
				if (!empty($item['quotation_id'])) {
					if ($assigned_to == "MY") {
						$name_txt = '<a href="' . get_module_path() . 'reports/view_quotation/?from=followup&assigned_to=MY&history=back&id=' . $quotation_id . '" title="' . $name . '">' . $name . '</a>';
					} else {
						$name_txt = '<a href="' . get_module_path() . 'reports/view_quotation/?from=followup&history=back&id=' . $quotation_id . '" title="' . $name . '">' . $name . '</a>';
					}
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'reports/view_followup/?id=' . $quotation_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				} elseif (!empty($item['customer_id'])) {
					if ($assigned_to == "MY") {
						$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?from=followup&assigned_to=MY&history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';
					} else {
						$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?from=followup&history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';
					}
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'customers/view_followup/?id=' . $customer_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				} elseif (!empty($item['clm_id'])) {
					if ($assigned_to == "MY") {
						$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?from=followup&history=back&assigned_to=MY&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';
					} else {
						$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?from=followup&history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';
					}
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'leads/view_followup/?id=' . $clm_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				}


				if (!empty($item['quotation_id'])) {
					if (!empty($item['customer_id'])) {
						$str = '?type=Customer&id=' . $quotation_id . '&cust_id=' . $customer_id;
					} else {
						$str = '?type=Lead&id=' . $quotation_id . '&cust_id=' . $clm_id;
					}
				} else {
					$str = '?id=' . $id . '&cust_id=' . $customer_id . '&clm_id=' . $clm_id;
				}
				$action_txt = "";
				$assign_txt = "";
				$add_txt = "";
				$str1 = '?id=' . $id . '&cust_id=' . $customer_id . '&clm_id=' . $clm_id;

				if (!empty($item['quotation_id'])) {
					$add_txt = '<a  class="btn btn-success btn-xs" href="' . get_module_path() . 'reports/add_follwoup/' . $str . '" title="Add Followup" data-toggle="modal" data-target="#form_modal"><i class="fa fa-commenting-o"></i></a>';
				} else {
					$add_txt = '<a  class="btn btn-success btn-xs" href="' . get_module_path() . 'customers/add_followup/' . $str . '" title="Add Followup" data-toggle="modal" data-target="#form_modal"><i class="fa fa-commenting-o"></i></a>';
				}

				if ($status == "Following") {
					$status_txt = "<span class='label label-success'>Following</span>";
					if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
						$assign_txt = '<a class="btn btn-danger btn-xs" href="' . get_module_path() . 'customers/assign_followup/' . $str1 . '" title="Assign Followup" data-toggle="modal" data-target="#form_modal"><i class="fa fa-user-plus"></i></a>';
					}
				}
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";

				if ($status == "Closed") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				//Vihas added on 29/01/2026
				$priority_txt = "<span class='label label-default'>" . $priority . "</span>";

				if ($priority == "High") {
					$priority_txt = "<span class='label label-danger'>High</span>";
				} elseif ($priority == "Medium") {
					$priority_txt = "<span class='label label-warning'>Medium</span>";
				} elseif ($priority == "Low") {
					$priority_txt = "<span class='label label-info'>Low</span>";
				}


				$highlight_class = ($highlight_id == $ref_id) ? 'bg-grey-salt' : '';

				$html .= '<tr class="' . $highlight_class . '" data-id="' . $ref_id . '"><td>' . $sr_no . '</td><td title="' . $name . '"><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 300px; display: inline-block;">' . $name_txt . '</span></td><td>' . $contact . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td style="text-align:center">' . $priority_txt . '</td><td style="text-align:center">' . $status_txt . '</td><td style="text-align:center">' . $view_txt . ' &nbsp;' . $add_txt . '&nbsp;' . $assign_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		$data['data1'] = $list;
		echo json_encode($data);
	}

	// Payment Defaulter Report 
	public function tbl_payment_defaulter_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$from_date = $this->input->post('from_date');
		$searchStr_name = $this->input->post('searchStr_name');
		$searchStr_name = addslashes($searchStr_name);

		$total_count = ($page == 1) ? Null : $this->session->userdata('pay_defau_total_count');
		$Balanced_Amount = ($page == 1) ? $result['balanced_Amount'] : $this->session->userdata('total_balanced_count');
		$this->session->set_userdata('total_balanced_count', $Balanced_Amount);

		$post_data['page'] = $page;
		$this->session->set_userdata('pay_defau_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"nine" => "B",
			"ten" => $searchStr_name,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
			"balanced_Amount" => $Balanced_Amount,
		);
		//echo "<pre/>"; print_r($params);die;
		$result = $this->api->call_v_api('getSaleBalanceDetails', $params);

		$list = $result['jsArray'];


		$total_count = $result['total_count'];
		$Balanced_Amount = $result['balanced_Amount'];
		$this->session->set_userdata('pay_defau_total_count', $total_count);
		$this->session->set_userdata('total_balanced_count', $Balanced_Amount);



		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_payment_defaulter_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		// $config['total_rows']  = $Balanced_Amount; 
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$cbpm_id = $item['cbpm_id'];
				$customer_id = $item['cbpm_custid'];
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_sdate_n = $item['cbpm_sdate_n'];
				$cbpm_billno = $item['cbpm_billno'];
				$customer_id = base64_encode($customer_id);

				$name_txt = "";
				$view_txt = "";
				$name_txt = '<a href="' . get_module_path() . 'customers/view_payment/?history=back&id=' . $customer_id . '&billno=' . base64_encode($cbpm_billno) . '" title="' . $name . '">' . $name . '</a>';

				$action_txt = "";
				$assign_txt = "";
				$add_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $customer_contact . '</td><td>' . $cbpm_billno . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cbpm_balance_amnt . '</td><td>' . $cbpm_received_amnt . '</td><td>' . $cbpm_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		$data['Balanced_Amount'] = $Balanced_Amount;
		echo json_encode($data);
	}
	// Ticket  Report 
	public function tbl_ticket_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$ticket_type = $this->input->post('ticket_type');
		$ticket_assign_to = $this->input->post('ticket_assign_to');
		$customer_id = $this->input->post('customer_id');
		$clm_id = $this->input->post('clm_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr_name = $this->input->post('searchStr_name');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$highlight_id = $this->input->post('highlight_id');
		$priority = $this->input->post('priority');

		$searchStr_name = addslashes($searchStr_name);
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$total_count = ($page == 1) ? Null : $this->session->userdata('ticket_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('ticket_post_data', $post_data);

		$ticket_assign_to = $this->_user_id;
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$ticket_assign_to = $this->input->post('ticket_assign_to');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"six" => $customer_id,
			"seven" => $clm_id,
			"eight" => $ticket_assign_to,
			"nine" => $ticket_type,
			"ten" => $searchStr_name,
			"eleven" => $from_date,
			"twelve" => $to_date,
			"fourteen" => $priority,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getTicketMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('ticket_total_count', $total_count);
		///echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_ticket_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$ticket_id = $item['ticket_id'];
				$ticket_id1 = $item['ticket_seq_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['ticket_date_n'];
				$status = $item['ticket_status'];

				$name = !empty($name) ? $name : $item['clm_name'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>" . $status . "</span>";
				$name_txt = $ticket_id;

				$name_txt = '<a href="' . get_module_path() . 'customers/view_ticket/?id=' . $id . '" title="' . $ticket_id . '">' . $ticket_id1 . '</a>';


				if ($status == "Open") {
					$status_txt = "<span class='label label-success' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>Open</span>";
				}
				if ($status == "Reopened") {
					$status_txt = "<span class='label label-success' style='display:inline-block;  background:#7986cb; min-width:66px; text-align:center; padding:5px 0;'>Re-Opened</span>";
				}

				if ($status == "Closed" || $status == "Deactivated") {
					$status_txt = "<span class='label label-danger' style='display:inline-block; min-width:66px; text-align:center; padding:5px 0;'>" . $status . "</span>";

					if ($role_id == TECHNICIAN_ROLE_ID) {
						$name_txt = $ticket_id;
					}
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '">
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $sr_no . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align:center;">' . $name_txt . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $ticket_title . '">' . $ticket_title . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $name . '">' . $name . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $tkt_sdate_n . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align:center;">' . $status_txt . '</td>
					<td class="action-col" style="display:none;">
        				<input type="checkbox" class="ticket-checkbox" data-id="' . $ticket_id . '">
    				</td>
				</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Complaint  Report 
	public function tbl_complaint_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$ticket_assign_to = $this->input->post('ticket_assign_to');
		$customer_id = $this->input->post('customer_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr_name = $this->input->post('searchStr_name');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$highlight_id = $this->input->post('highlight_id');

		$searchStr_name = addslashes($searchStr_name);
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$total_count = ($page == 1) ? Null : $this->session->userdata('complaint_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('complaint_post_data', $post_data);

		// $ticket_assign_to   = $this->_user_id;
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$ticket_assign_to = $this->input->post('ticket_assign_to');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"six" => $customer_id,
			"eight" => $ticket_assign_to,
			"nine" => "Complaint",
			"ten" => $searchStr_name,
			"eleven" => $from_date,
			"twelve" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getTicketMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('complaint_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_complaint_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$ticket_id = $item['ticket_id'];
				$ticket_id1 = $item['ticket_seq_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];

				$name = !empty($name) ? $name : $item['clm_name'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'customers/view_complaint/?id=' . $id . '" title="View Details">' . $ticket_id1 . '</a>';

				if ($status == "Open") {
					$status_txt = "<span class='label label-success'>Open</span>";
				}

				if ($status == "Closed" || $status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}

				$html .= '<tr class="' . $highlight_class . '">
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $sr_no . '</td>
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $name_txt . '</td>
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $name . '">' . $name . '</td>
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $ticket_title . '">' . $ticket_title . '</td>
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $tkt_sdate_n . '</td>
    <td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align:center;">' . $status_txt . '</td>
</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Complaint  Report 
	public function tbl_servicing_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$ticket_assign_to = $this->input->post('ticket_assign_to');
		$customer_id = $this->input->post('customer_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";
		$searchStr_name = $this->input->post('searchStr_name');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');

		$searchStr_name = addslashes($searchStr_name);
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$total_count = ($page == 1) ? Null : $this->session->userdata('complaint_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('serv_ticket_post_data', $post_data);

		$ticket_assign_to = $this->_user_id;
		$role_id = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$ticket_assign_to = $this->input->post('ticket_assign_to');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $status,
			"six" => $customer_id,
			"eight" => $ticket_assign_to,
			"nine" => "Servicing",
			"ten" => $searchStr_name,
			"eleven" => $from_date,
			"twelve" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getTicketMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('complaint_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_servicing_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];

				$name = !empty($name) ? $name : $item['clm_name'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'customers/view_service_ticket/?id=' . $id . '" title="' . $ticket_id . '">' . $ticket_id . '</a>';

				if ($status == "Open") {
					$status_txt = "<span class='label label-success'>Open</span>";
				}

				if ($status == "Closed" || $status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td title="' . $name . '">' . $name . '</td><td title="' . $ticket_title . '">' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Upcoming Services  Report 
	public function tbl_upcoming_services_list($page = 1)
	{
		$post_data = $this->input->post(null, true);
		$searchStr_name = $this->input->post('searchStr_name');
		$sdate = $this->input->post('sdate');
		$pdate = $this->input->post('pdate');
		$udate = $this->input->post('udate');
		$month_year = $this->input->post('month_year');
		$one_year = $this->input->post('one_year');
		$cust_serv_type = $this->input->post('cust_serv_type');  // Fetch the selected service type

		$pending_upcoming = $this->input->post('pending_upcoming'); // Fetch the selected value


		$searchStr_name = addslashes($searchStr_name);

		$sdate = !empty($sdate) ? strtoupper(date("d-M-Y", strtotime($sdate))) : strtoupper(date("d-M-Y"));

		if ($pdate == "Yes") {
			$pdate = $sdate;
			$sdate = null;
		} else {
			$pdate = null;
		}
		if (!empty($month_year)) {
			$sdate = null;
		}
		if (!empty($one_year)) {
			$sdate = null;
		}

		$total_count = ($page == 1) ? null : $this->session->userdata('upserv_total_count');
		$this->session->set_userdata('upserv_post_data', $post_data);

		// Include service_type in params to filter the results
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $searchStr_name,
			"six" => $pdate,
			"seven" => $sdate,
			"eight" => $month_year,
			"nine" => $one_year,
			"ten" => $cust_serv_type,  // Pass the selected service type
			"eleven" => $pending_upcoming,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getServicePendingAnalysisDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('upserv_total_count', $total_count);

		// Pagination configuration 
		$config['base_url'] = get_module_path() . 'ajax/tbl_upcoming_services_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['customer_id'];
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cust_serv_type_name = $item['cust_serv_type_name'];
				$cust_serv_sdate_n = $item['cust_serv_date_n'];
				$cust_subs_startdate_n = $item['cust_subs_startdate_n'];
				$cust_subs_enddate_n = $item['cust_subs_enddate_n'];

				$id = base64_encode($id);

				$action_txt = '<a class="btn btn-success btn-xs" href="' . get_module_path() . 'customers/send_usr_whatsapp/?customer_contact=' . base64_encode($customer_contact) . '&cust_serv_sdate_n=' . base64_encode($cust_serv_sdate_n) . '&name=' . base64_encode($name) . '" title="Edit"><i class="fa fa-whatsapp"></i></a>';
				$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?id=' . $id . '&history=back" title="' . $name . '">' . $name . '</a>';

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name_txt . '</td><td>' . $customer_contact . '</td><td title="' . $cust_serv_type_name . '">' . $cust_serv_type_name . '</td><td>' . $cust_serv_sdate_n . '</td><td>' . $cust_subs_startdate_n . '</td><td>' . $cust_subs_enddate_n . '</td><td class="text-center">' . $action_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	public function tbl_birthday_reminder_list($page = 1)
	{
		$post_data = $this->input->post(null, true);

		$searchStr_name = $this->input->post('searchStr_name');
		$birthday_type = $this->input->post('birthday_type');
		$person_type = $this->input->post('person_type');
		$selected_date = $this->input->post('selected_date');

		$searchStr_name = addslashes($searchStr_name);

		$selected_month = $this->input->post('selected_month');

		$selected_date = !empty($selected_date)
			? strtoupper(date("d-M-Y", strtotime($selected_date)))
			: strtoupper(date("d-M-Y"));

		$total_count = ($page == 1)
			? null
			: $this->session->userdata('birthday_total_count');

		$selected_month = !empty($selected_month)
			? strtoupper(
				date(
					"M",
					strtotime("01-" . $selected_month)
				)
			)
			: "";

		/* IF MONTH SELECTED
		THEN CLEAR DATE FILTER */

		if (!empty($selected_month)) {

			$selected_date = "";
		}
		$this->session->set_userdata(
			'birthday_post_data',
			$post_data
		);

		/* WEB SERVICE PARAMS */

		$params = array(

			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,

			// "four" => $birthday_type, // Today / Tomorrow

			"five" => $person_type,   // Employee / Customer / Lead

			"six" => $selected_date,

			"seven" => $searchStr_name,

			"eight" => $selected_month,

			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count
		);

		$result = $this->api->call_v_api(
			'getBirthdayReminderReport',
			$params
		);

		$list = $result['jsArray'];

		$total_count = $result['total_count'];

		$this->session->set_userdata(
			'birthday_total_count',
			$total_count
		);

		/* PAGINATION */

		$config['base_url'] =
			get_module_path() .
			'ajax/tbl_birthday_reminder_list';

		$config['reuse_query_string'] = true;

		$config['total_rows'] = $total_count;

		$config['per_page'] = $this->perPage;

		$config['use_page_numbers'] = true;

		$this->pagination->initialize($config);

		/* TABLE HTML */

		$html = "";

		if (!empty($list)) {

			foreach ($list as $key => $item) {

				$sr_no =
					(($page - 1) * $this->perPage)
					+ ($key + 1);

				$ref_id = $item['ref_id'];
				$person_name = $item['name'];
				$contact_no = $item['contact'];
				$dob = $item['dob'];
				$birthday_type = $item['birthday_type'];
				$person_type = $item['person_type'];

				/* VIEW URL */

				$url = "javascript:;";

				if ($person_type == "Employee") {

					$url =
						get_module_path()
						. "admin/view_employee/?id="
						. base64_encode($ref_id)
						. "&history=back";
				} else if ($person_type == "Customer") {

					$url =
						get_module_path()
						. "customers/view_customer/?id="
						. base64_encode($ref_id)
						. "&history=back";
				} else if ($person_type == "Lead") {

					$url =
						get_module_path()
						. "leads/view_lead/?id="
						. base64_encode($ref_id)
						. "&history=back";
				}

				$name_txt =
					'<a href="' . $url . '"
						title="' . $person_name . '">'
					. $person_name .
					'</a>';

				$html .= '

				<tr>

					<td>' . $sr_no . '</td>

					<td>' . $name_txt . '</td>

					<td>' . $person_type . '</td>

					<td>' . $contact_no . '</td>

					<td>' . $dob . '</td>

					

				</tr>';
			}
		} else {

			$html = "

			<tr>

				<td valign='top'
					colspan='6'
					class='dataTables_empty'>

					No data available in table

				</td>

			</tr>";
		}

		$data['list'] = $html;

		$data['pagination'] =
			$this->pagination->create_links();

		$data['total_count'] = $total_count;

		echo json_encode($data);
	}


	// Quotation  Report 
	public function tbl_quotation_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$total_count = ($page == 1) ? Null : $this->session->userdata('quot_total_count');
		$post_data['page'] = $page;
		$priorty = $this->input->post('priority');
		$type_filter = $this->input->post('type_filter');
		$status = $this->input->post('status');

		if ($status == "Approved") {
			$status = "Confirmed";
		}

		$this->session->set_userdata('quot_post_data', $post_data);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $priorty,
			"five" => $status,
			"six" => $type_filter,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getQuotationReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('quot_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_quotation_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['quote_id'];
				$customer_name = $item['customer_name'];
				$clm_id = $item['clm_id'];
				$customer_id = $item['customer_id'];
				$clm_name = $item['clm_name'];
				$clm_contact = $item['clm_contact'];
				$customer_contact = $item['customer_contact'];
				$quote_cur_ver = $item['quote_cur_ver'];
				$quote_id = $item['quote_id'];
				$name = !empty($clm_name) ? $clm_name : $customer_name;
				$contact = !empty($clm_contact) ? $clm_contact : $customer_contact;
				$type = !empty($clm_id) ? "Lead" : "Customer";
				$priority = $item['quote_priority'];
				$feedback = $item['quote_remark'];
				$quote_status = $item['quote_status'];

				$quote_date_n = $item['quote_date_n'];

				$id = base64_encode($id);

				$quote_txt = "";
				$priority_txt = "<span class='label label-default'>" . $priority . "</span>";

				if ($quote_status == "Active" || $quote_status == "") {
					$quote_txt = "<span class='label label-info'>Active</span>";
				} elseif ($quote_status == "Deactivated") {
					$quote_txt = "<span class='label label-danger'>" . $quote_status . "</span>";
				} elseif ($quote_status == "Confirmed") {
					$quote_txt = "<span class='label label-success'>Approved</span>";
				}

				if ($priority == "High") {
					$priority_txt = "<span class='label label-danger'>High</span>";
				} elseif ($priority == "Medium") {
					$priority_txt = "<span class='label label-warning'>Medium</span>";
				} elseif ($priority == "Low") {
					$priority_txt = "<span class='label label-info'>Low</span>";
				}

				$name_txt = '<a href="' . get_module_path() . 'reports/view_quotation/?id=' . $id . '" title="' . $quote_cur_ver . '">' . $quote_id . '</a>';
				$name = '<a href="' . get_module_path() . 'reports/view_quotation/?id=' . $id . '" title="' . $name . '">' . $name . '</a>';

				// $html .= '<tr><td>' . $sr_no . '</td><td>' . $quote_id . '</td><td>' . $name . '</td><td>' . $type . '</td><td>'. $priority_txt . '</td><td>' . $contact . '</td><td>' . $quote_date_n . '</td></tr>';
				$html .= '<tr><td>' . $sr_no . '</td><td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 300px; display: inline-block;">' . $name . '</sapn></td><td>' . $type . '</td><td>' . $quote_txt . '</td><td>' . $priority_txt . '</td><td>' . $contact . '</td><td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; max-width: 100px; display: inline-block;">' . $feedback . '</span></td><td>' . $quote_date_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['result'] = $list;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}



	// Password Change  Report 
	public function tbl_pwd_changed_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$total_count = ($page == 1) ? Null : $this->session->userdata('pwd_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('quot_post_data', $post_data);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_v_api('getPasswordTrackReport', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('pwd_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_pwd_changed_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$upt_user_name = $item['upt_user_name'];
				$upt_addedbyname = $item['upt_addedbyname'];
				$upt_sdate_n = $item['upt_sdate_n'];
				$upt_new_pswd = $item['upt_new_pswd'];
				$upt_old_pswd = $item['upt_old_pswd'];
				$html .= '<tr><td>' . $sr_no . '</td><td>' . $upt_user_name . '</td><td>' . $upt_old_pswd . '</td><td>' . $upt_addedbyname . '</td><td>' . $upt_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// All Sales  Report 
	/* public function tbl_all_sales_list($page = 1)
	{
		$post_data          = $this->input->post(Null,true);
		$user_id            = $this->input->post('user_id');
		$month_year         = $this->input->post('month_year');
		$bill_no            = $this->input->post('bill_no');
		$post_data['page']  = $page;
		$this->session->set_userdata('all_sale_post_data',$post_data);
		$total_count          = ($page==1)?Null:$this->session->userdata('all_sale_total_count');
		if(!empty($month_year)){ 
		$month_year  = strtoupper(date("M-Y",strtotime("1-".$month_year)));
		}else{
			$month_year  = strtoupper(date("M-Y"));
		}			

		$user_id         = $this->_user_id;
		$role_id         = $this->_role_id;		
		if($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID){	

		  $user_id  = $this->input->post('user_id');
		}

			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$user_id,
			"five"=>$bill_no,
			"six"=>$month_year,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
		$result = $this->api->call_v_api('getSaleDetails',$params);
		$total_count       = $result['total_count'];	
		$list              = $result['jsArray'];	
		$received_Amount   = $result['received_Amount'];	
		$total_amount      = $result['total_amount'];	
		$balanced_Amount   = $result['balanced_Amount'];	
		$this->session->set_userdata('all_sale_total_count',$total_count); 
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax/tbl_all_sales_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 

		// Form Table
			$html = "";			
			if(!empty($list)){
				$total_count       = count($list);	
				foreach($list as $key=>$item){
					$sr_no        		= ($key+1);
					$customer_name      = $item['customer_name'];
					$customer_contact   = $item['customer_contact'];
					$cbpd_product_type  = $item['cbpd_product_type'];
					$cbpm_total_amnt    = $item['cbpm_total_amnt'];
					$cbpm_received_amnt = $item['cbpm_received_amnt'];
					$cbpm_balance_amnt  = $item['cbpm_balance_amnt'];


				$html .= '<tr><td>'.$sr_no.'</td><td>'.$customer_name.'</td><td>'.$customer_contact.'</td><td>'.$cbpd_product_type.'</td><td>'.$cbpm_total_amnt.'</td><td>'.$cbpm_received_amnt.'</td><td>'.$cbpm_balance_amnt.'</td></tr>';

				   }

				}else { $html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";	}

				$data['list']            = $html;	
				$data['total_count']     = $total_count;
				$data['pagination']      = $this->pagination->create_links();
				$data['received_Amount'] = $received_Amount;
				$data['total_amount']    = $total_amount;
				$data['balanced_Amount'] = $balanced_Amount;
				echo json_encode($data); 	


	} */

	// Sales Analysis  Report 
	// public function tbl_sales_analysis_list($page = 1)
	// {
	// 	$post_data = $this->input->post(Null, true);
	// 	$service_type = $this->input->post('service_type');
	// 	$user_id = $this->input->post('user_id');
	// 	$month_year = $this->input->post('month_year');
	// 	if (!empty($month_year)) {
	// 		$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
	// 	} else {
	// 		$month_year = strtoupper(date("M-Y"));
	// 	}

	// 	$user_id = $this->_user_id;
	// 	$role_id = $this->_role_id;
	// 	if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

	// 		$user_id = $this->input->post('user_id');
	// 	}

	// 	$params = array(
	// 		"one" => $this->_user_id,
	// 		"two" => $this->_user_branch_id,
	// 		"three" => $this->_user_company_id,
	// 		"four" => $user_id,
	// 		"five" => $service_type,
	// 		"seven" => $month_year,
	// 		"offset" => "1",
	// 	);
	// 	$result = $this->api->call_v_api('getSaleBalanceDetails', $params);
	// 	$total_count = $result['total_count'];
	// 	$list = $result['jsArray'];
	// 	$received_Amount = $result['received_Amount'];
	// 	$total_amount = $result['total_amount'];
	// 	$balanced_Amount = $result['balanced_Amount'];


	// 	// Form Table
	// 	$html = "";
	// 	if (!empty($list)) {
	// 		$total_count = count($list);
	// 		foreach ($list as $key => $item) {
	// 			$sr_no = ($key + 1);
	// 			$customer_name = $item['customer_name'];
	// 			$customer_contact = $item['customer_contact'];
	// 			$cbpd_product_type = $item['cbpd_product_type'];
	// 			$cbpm_total_amnt = $item['cbpm_total_amnt'];
	// 			$cbpm_received_amnt = $item['cbpm_received_amnt'];
	// 			$cbpm_balance_amnt = $item['cbpm_balance_amnt'];


	// 			$html .= '<tr><td>' . $sr_no . '</td><td>' . $customer_name . '</td><td>' . $customer_contact . '</td><td>' . $cbpd_product_type . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cbpm_received_amnt . '</td><td>' . $cbpm_balance_amnt . '</td></tr>';
	// 		}
	// 	} else {
	// 		$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
	// 	}

	// 	$data['list'] = $html;
	// 	$data['total_count'] = $total_count;
	// 	$data['received_Amount'] = $received_Amount;
	// 	$data['total_amount'] = $total_amount;
	// 	$data['balanced_Amount'] = $balanced_Amount;
	// 	echo json_encode($data);
	// }
	public function tbl_sales_analysis_list($page = 1)
	{
		$post_data = $this->input->post(null, true);
		$service_type = $this->input->post('service_type');
		$user_id = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}

		$from_month = $this->input->post('from_month');
		$to_month = $this->input->post('to_month');

		if (!empty($from_month)) {
			$from_month = strtoupper(date("M-Y", strtotime("1-" . $from_month)));
		} else {
			$from_month = strtoupper(date("M-Y"));
		}

		/*
		|--------------------------------------------------------------------------
		| If To Month is empty, use From Month
		|--------------------------------------------------------------------------
		*/
		if (empty($to_month)) {
			$to_month = $from_month;
		} else {
			$to_month = strtoupper(date("M-Y", strtotime("1-" . $to_month)));
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
			"five" => $service_type,
			"seven" => $from_month,
			"eight" => $to_month,
			"offset" => "1",
		);

		$result = $this->api->call_v_api('getSaleBalanceDetails', $params);

		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$received_Amount = $result['received_Amount'];
		$total_amount = $result['total_amount'];
		$balanced_Amount = $result['balanced_Amount'];

		$html = "";
		// Added by Ankit on 20/02/2026 
		if (!empty($list)) {

			$total_count = count($list);

			foreach ($list as $key => $item) {

				$sr_no = ($key + 1);
				$customer_name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];

				$customer_id_raw = !empty($item['cbpm_custid']) ? $item['cbpm_custid'] : "";
				$billno = !empty($item['cbpm_billno']) ? $item['cbpm_billno'] : "";
				$billno1 = !empty($item['cbpm_id']) ? $item['cbpm_id'] : "";
				$billno1 = base64_encode($billno1);
				$invoice_no = !empty($billno) ? $billno : '-';
				$invoice_btn = "";

				if (!empty($customer_id_raw) && !empty($billno)) {

					$customer_id = base64_encode($customer_id_raw);

					$invoice_btn = "
					<a class='btn btn-primary btn-xs single-download'
						href='" . get_module_path() . "customers/download_invoice/?ref_id=" . $customer_id . "&billno=" . $billno1 . "'
						title='Download Invoice'>
						<i class='fa fa-download'></i>
					</a>

					<input type='checkbox'
						class='invoice-checkbox'
						data-customer='" . $customer_id_raw . "'
						data-billno='" . $billno . "'
						style='display:none; margin-left:5px;'>
				";
				}

				$html .= '<tr>
						<td class="sr-col">' . $sr_no . '</td>
						<td>' . $customer_name . '</td>
						<td>' . $customer_contact . '</td>
						<td>' . $cbpd_product_type . '</td>
						<td>' . $cbpm_total_amnt . '</td>
						<td>' . $cbpm_received_amnt . '</td>
						<td>' . $cbpm_balance_amnt . '</td>
						<td>' . $invoice_no . '</td>
						<td>' . $invoice_btn . '</td>
					</tr>';
			}
		} else {

			$html = "<tr>
						<td colspan='8' class='dataTables_empty'>
							No data available in table
						</td>
					</tr>";
		}

		$data['list'] = $html;
		$data['total_count'] = $total_count;
		$data['received_Amount'] = $received_Amount;
		$data['total_amount'] = $total_amount;
		$data['balanced_Amount'] = $balanced_Amount;

		echo json_encode($data);
	}

	// Payment Analysis  Report 
	public function tbl_payment_analysis_list()
	{
		$post_data = $this->input->post(Null, true);
		$service_type = $this->input->post('service_type');
		$user_id = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');
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
			"five" => $service_type,
			"seven" => $month_year,
			"nine" => "Yes",
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getSaleBalanceDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		//echo "<pre/>"; print_r($list);die;


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$customer_name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $customer_name . '</td><td>' . $customer_contact . '</td><td>' . $cbpd_product_type . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cbpm_received_amnt . '</td><td>' . $cbpm_balance_amnt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Lead Analysis  Report 
	public function tbl_lead_analysis_list()
	{
		$added_by = $this->input->post('user_id');
		$lead_month_year = $this->input->post('lead_month_year');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;

		if (!empty($lead_month_year)) {
			$lead_month_year = explode("-", $lead_month_year);
			$lead_month = $lead_month_year[0];
			$lead_year = $lead_month_year[1];
		} else {
			$lead_month = date("m");
			$lead_year = date("Y");
		}
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		// For All Leads
		$status = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"fifteen" => $lead_month,
			"sixteen" => $lead_year,
			"seventeen" => $added_by,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}


				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td  title="' . $clm_address . '">' . $clm_address . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_leads_list'] = $html;
		$data['count_all_leads_list'] = $total_count;


		// Confirm Leads	
		$params['four'] = "Approved";
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td title="' . $clm_address . '">' . $clm_address . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_confirm_leads_list'] = $html;
		$data['count_confirm_leads_list'] = $total_count;



		// Pending Leads	
		$params['four'] = "Active";
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td title="' . $clm_address . '">' . $clm_address . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_pending_leads_list'] = $html;
		$data['count_pending_leads_list'] = $total_count;


		// Waiting For Approval Leads	
		$params['four'] = "FS";
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td title="' . $clm_address . '">' . $clm_address . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_waiting_leads_list'] = $html;
		$data['count_waiting_leads_list'] = $total_count;


		echo json_encode($data);
	}


	// Complaint Analysis  Report 
	public function tbl_complaint_analysis_list()
	{
		$added_by = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		// For All Complaints
		$status = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			"five" => $status,
			"ten" => $month_year,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getComplaintAnalysisDetails', $params);
		//echo "<pre/>"; print_r($result);die;
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['complaint_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['complaint_assign_to_name'];
				$complaint_resolved_on_n = $item['complaint_resolved_on_n'];

				$action_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $complaint_resolved_on_n . '</td><td>' . $complaint_resolved_on_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_complaint_list'] = $html;
		$data['count_all_complaint_list'] = $total_count;




		// Pending Complaints	
		$params['five'] = "Open";
		$result = $this->api->call_v_api('getComplaintAnalysisDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['complaint_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['complaint_assign_to_name'];
				$complaint_resolved_on_n = $item['complaint_resolved_on_n'];

				$action_txt = "";

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $complaint_resolved_on_n . '</td><td>' . $complaint_resolved_on_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_pending_complaint_list'] = $html;
		$data['count_pending_complaint_list'] = $total_count;


		echo json_encode($data);
	}

	// Ticket Analysis  Report 
	public function tbl_ticket_analysis_list()
	{
		$added_by = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		// For All Tickets
		$status = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			"five" => $status,
			"ten" => $month_year,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getTicketAnalysisDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['ticket_assign_to'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_tickets_list'] = $html;
		$data['count_all_tickets_list'] = $total_count;


		// Pending Tickets
		$params['five'] = "Open";
		$result = $this->api->call_v_api('getTicketAnalysisDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['ticket_assign_to'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_pending_tickets_list'] = $html;
		$data['count_pending_tickets_list'] = $total_count;



		// Resolved Tickets	
		$params['five'] = "Resolved";
		$result = $this->api->call_v_api('getTicketAnalysisDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['ticket_assign_to'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_resoved_tickets_list'] = $html;
		$data['count_resoved_tickets_list'] = $total_count;


		echo json_encode($data);
	}


	// Collection  Report 
	public function tbl_collection_report_list()
	{
		$service_type = $this->input->post('service_type');
		$month_year = $this->input->post('month_year');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}

		$from_month = $this->input->post('from_month');
		$to_month = $this->input->post('to_month');

		if (!empty($from_month)) {
			$from_month = strtoupper(date("M-Y", strtotime("1-" . $from_month)));
		} else {
			$from_month = strtoupper(date("M-Y"));
		}

		/*
		|--------------------------------------------------------------------------
		| If To Month is empty, use From Month
		|--------------------------------------------------------------------------
		*/
		if (empty($to_month)) {
			$to_month = $from_month;
		} else {
			$to_month = strtoupper(date("M-Y", strtotime("1-" . $to_month)));
		}

		$role_id = $this->_role_id;
		$user_id = $this->_user_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
			$user_id = Null;
		}
		// For All Collection
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $user_id,
			"five" => $service_type,
			"seven" => $from_month,
			"eight" => $to_month,
			"offset" => "1",
		);

		$result = $this->api->call_v_api('getCollectionDetails1', $params);
		//echo "<pre/>"; print_r($result);die;

		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$total_amount = $result['total_amount'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$name = $item['customer_name'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_amount = $item['cbpm_amount'];
				$cbpm_billno = $item['cbpm_billno'];
				$cbpm_received_amnt1 = $item['cp_amount'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$status = $item['cp_status'];
				$cp_udate_n = $item['cp_udate_n'];
				$customer_contact = $item['customer_contact'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cp_receiptno = $item['cp_receiptno'];
				$cp_paytype = $item['cp_paytype'];
				$emp_name = $item['emp_name'];
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $cbpm_billno . '</td><td>' . $cp_receiptno . '</td><td>' . $cbpm_received_amnt1 . '</td><td>' . $cp_paytype . '</td><td>' . $cbpd_product_type . '</td><td>' . $emp_name . '</td><td>' . $cp_udate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_collection_list'] = $html;
		$data['count_collection_list'] = $total_count;
		$data['total_amount'] = $total_amount;

		echo json_encode($data);
	}



	// Service Analysis  Report 
	public function tbl_service_analysis_report_list()
	{
		$added_by = $this->input->post('user_id');
		$month_year = $this->input->post('month_year');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;

		if (!empty($month_year)) {
			$month_year = strtoupper(date("M-Y", strtotime("1-" . $month_year)));
		} else {
			$month_year = strtoupper(date("M-Y"));
		}
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$added_by = $this->input->post('user_id');
		}

		// For All Servicing
		$status = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			"nine" => $month_year,
			"offset" => "1"
		);

		$result = $this->api->call_v_api('getServiceAnalysisDetails', $params);
		//echo "<pre/>"; print_r($result);die;
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['tkt_sdate_n'];
				$status = $item['ticket_status'];
				$ticket_assign_to = $item['ticket_assign_to'];
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $tkt_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td><td>' . $ticket_assign_to . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_servicing_list'] = $html;
		$data['count_all_servicing_list'] = $total_count;


		// Pending Services
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			"ten" => $month_year,
			"offset" => "1"
		);
		$result = $this->api->call_v_api('getServicePendingAnalysisDetails', $params);
		//echo "<pre/>"; print_r($result);die;
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['cust_serv_id'];
				$id = $item['cust_serv_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['cust_serv_type_name'];
				$cust_serv_type = $item['cust_serv_type'];
				$customer_id = $item['customer_id'];
				$cust_serv_sdate_n = $item['cust_serv_sdate_n'];
				$customer_contact = $item['customer_contact'];

				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $name . '">' . $name . '</td><td>' . $customer_contact . '</td><td title="' . $ticket_title . '" >' . $ticket_title . '</td><td>' . $cust_serv_type . '</td><td>' . $cust_serv_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_pending_servicing_list'] = $html;
		$data['count_pending_servicing_list'] = $total_count;

		// Closed Services	 	
		$params['eleven'] = 'Completed';
		$result = $this->api->call_v_api('getServicePendingAnalysisDetails', $params);
		//echo "<pre/>"; print_r($result);die;
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$ticket_id = $item['cust_serv_id'];
				$id = $item['cust_serv_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['cust_serv_type_name'];
				$cust_serv_type = $item['cust_serv_type'];
				$customer_id = $item['customer_id'];
				$cust_serv_sdate_n = $item['cust_serv_sdate_n'];
				$customer_contact = $item['customer_contact'];
				$assigned_to = isset($item['cust_serv_assigned_to']) ? $item['cust_serv_assigned_to'] : 'Demo Technician';
				$assigned_on = isset($item['cust_serv_assigned_on']) ? $item['cust_serv_assigned_on'] : $cust_serv_sdate_n;
				$resolved_on = isset($item['cust_serv_resolved_on']) ? $item['cust_serv_resolved_on'] : $cust_serv_sdate_n;

				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $ticket_id . '</td><td title="' . $ticket_title . '">' . $ticket_title . '</td><td>' . $cust_serv_sdate_n . '</td><td title="' . $name . '">' . $name . '</td><td>' . $assigned_to . '</td><td>' . $assigned_on . '</td><td>' . $resolved_on . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_closed_servicing_list'] = $html;
		$data['count_closed_servicing_list'] = $total_count;

		echo json_encode($data);
	}

	// Daily Analysis  Report 
	public function tbl_daily_analysis_list()
	{
		$added_by = $this->input->post('user_id');
		$date = $this->input->post('date');
		$added_by = $this->_user_id;
		$role_id = $this->_role_id;
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

		// For Today All Leads
		$status = "FS";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			// "four"=>$status,
			// "fourteen" => $date,
			"seventeen" => $added_by,
			"twentysix" => $from_date,
			"twentyseven" => $to_date,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td width:30px;>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td  title="' . $clm_address . '">' . $clm_address . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_today_leads_list'] = $html;
		$data['count_today_leads_list'] = $total_count;

		// For Pending Approval Leads
		$status = "FS";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			// "eighteen'" => $date,
			"seventeen" => $added_by,

			"twentynine" => $to_date,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$id = $item['clm_id'];
				$name = $item['clm_name'];
				$clm_landline = $item['clm_landline'];
				$clm_contact = $item['clm_contact'];
				$clm_address = $item['clm_address'];
				$status = $item['clm_status'];
				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td width:30px;>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $clm_contact . '</td><td>' . $clm_landline . '</td><td  title="' . $clm_address . '">' . $clm_address . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_leads_list'] = $html;
		$data['count_all_leads_list'] = $total_count;


		// Sales Report
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			// "six" => $date,
			"twelve" => $from_date,
			"thirteen" => $to_date,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getSaleBalanceDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$received_Amount = $result['received_Amount'];
		$total_amount = $result['total_amount'];
		$balanced_Amount = $result['balanced_Amount'];
		//echo "<pre/>"; print_r($result);die;


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$customer_name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $customer_name . '</td><td>' . $customer_contact . '</td><td>' . $cbpd_product_type . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cbpm_received_amnt . '</td><td>' . $cbpm_balance_amnt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_sales_list'] = $html;
		$data['count_all_sales_list'] = $total_count;
		$data['sales_balance'] = $balanced_Amount;
		$data['sales_total'] = $total_amount;
		$data['sales_rcvd'] = $received_Amount;

		$role_id = $this->_role_id;
		$user_id = $this->_user_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {
			$user_id = Null;
		}

		// For All Collection
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $user_id,
			// "six" => $date,
			"seven" => $from_date,
			"eight" => $to_date,
			"offset" => "1",
		);


		$result = $this->api->call_v_api('getCollectionDetails', $params);
		//echo "<pre/>"; print_r($params);die;
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$total_amount = $result['total_amount'];
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$name = $item['customer_name'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_amount = $item['cbpm_amount'];
				$cbpm_billno = $item['cbpm_billno'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$status = $item['cp_status'];
				$cp_udate_n = $item['cp_udate_n'];
				$customer_contact = $item['customer_contact'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cp_receiptno = $item['cp_receiptno'];
				$cp_paytype = $item['cp_paytype'];
				$emp_name = $item['emp_name'];
				$cp_amnt = $item['cp_amount'];
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				//$name_txt    =  '<a href="'.get_module_path().'leads/view_lead/?id='.$id.'" title="View Details">'.$name.'</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $cbpm_billno . '</td><td>' . $cp_receiptno . '</td><td>' . $cp_amnt . '</td><td>' . $cp_paytype . '</td><td>' . $cbpd_product_type . '</td><td>' . $emp_name . '</td><td>' . $cp_udate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='8' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_collection_list'] = $html;
		$data['count_collection_list'] = $total_count;
		$data['collection_total'] = $total_amount;


		// Payment Balance		
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			// "six" => $date,
			"nine" => "Yes",
			// "twelve" => $from_date,
			"thirteen" => $to_date,
			"offset" => "1",
		);
		$result = $this->api->call_v_api('getSaleBalanceDetails', $params);
		$total_count = $result['total_count'];
		$list = $result['jsArray'];
		$received_Amount = $result['received_Amount'];
		$total_amount = $result['total_amount'];
		$balanced_Amount = $result['balanced_Amount'];
		//echo "<pre/>"; print_r($list);


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$customer_name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cbpd_product_type = $item['cbpd_product_type'];
				$cbpm_total_amnt = $item['cbpm_total_amnt'];
				$cbpm_received_amnt = $item['cbpm_received_amnt'];
				$cbpm_balance_amnt = $item['cbpm_balance_amnt'];
				$cbpm_sdate_n = $item['cbpm_sdate_n'];

				$html .= '<tr><td>' . $sr_no . '</td><td>' . $customer_name . '</td><td>' . $customer_contact . '</td><td>' . $cbpd_product_type . '</td><td>' . $cbpm_total_amnt . '</td><td>' . $cbpm_received_amnt . '</td><td>' . $cbpm_balance_amnt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_pay_list'] = $html;
		$data['count_all_pay_list'] = $total_count;
		$data['pay_balance'] = $balanced_Amount;
		$data['pay_total'] = $total_amount;
		$data['pay_rcvd'] = $received_Amount;


		// Today Followup Done
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			// "eleven" => $date,
			"thirteen" => $from_date,
			"fourteen" => $to_date,
			"offset" => "1"
		);
		$result = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		//echo "<pre/>"; print_r($result);die;


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$name = $item['customer_name'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$status = $item['followup_status'];
				$customer_contact = $item['customer_contact'];
				$ticket_added_byname = $item['ticket_added_byname'];
				$followup_nxt_folldate_n = $item['followup_nxt_folldate_n'];
				$followup_nxt_folltime = $item['followup_nxt_folltime'];
				$followup_sdate_n = $item['followup_sdate_n'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];


				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $contact . '</td><td title="' . $ticket_added_byname . '">' . $ticket_added_byname . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td>' . $followup_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_today_followup_list'] = $html;
		$data['count_today_followup_list'] = $total_count;

		// Followup Planned		
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			// "five" => $date,
			"fifteen" => $from_date,
			"sixteen" => $to_date,
			"offset" => "1"
		);
		$result = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		//echo "<pre/>"; print_r($result);die;


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$name = $item['customer_name'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$status = $item['followup_status'];
				$customer_contact = $item['customer_contact'];
				$ticket_added_byname = $item['ticket_added_byname'];
				$followup_nxt_folldate_n = $item['followup_nxt_folldate_n'];
				$followup_nxt_folltime = $item['followup_nxt_folltime'];
				$followup_sdate_n = $item['followup_sdate_n'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];


				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $contact . '</td><td title="' . $ticket_added_byname . '">' . $ticket_added_byname . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td>' . $followup_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_planned_followup_list'] = $html;
		$data['count_planned_followup_list'] = $total_count;


		// Followup Pending		
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $added_by,
			"seven" => $to_date,
			"offset" => "1"
		);
		$result = $this->api->call_v_api('getFollowupAnalysisDetails', $params);
		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		//echo "<pre/>"; print_r($result);die;


		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = ($key + 1);
				$name = $item['customer_name'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$status = $item['followup_status'];
				$customer_contact = $item['customer_contact'];
				$ticket_added_byname = $item['ticket_added_byname'];
				$followup_nxt_folldate_n = $item['followup_nxt_folldate_n'];
				$followup_nxt_folltime = $item['followup_nxt_folltime'];
				$followup_sdate_n = $item['followup_sdate_n'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];


				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name . '</td><td>' . $contact . '</td><td title="' . $ticket_added_byname . '">' . $ticket_added_byname . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td>' . $followup_sdate_n . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_pending_followup_list'] = $html;
		$data['count_pending_followup_list'] = $total_count;

		//Vihas added on 01/04/2026
		// Resolved ticket list
		$params1 = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Resolved",
			"eight" => $added_by,
			"nine" => "Ticket,Servicing",
			"eleven" => $from_date,
			"twelve" => $to_date,
			"offset" => 1
		);
		$result = $this->api->call_v_api('getTicketMasterReportDetails', $params1);
		$list = $result['jsArray'];
		$total_count = $result['total_count'];

		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = $key + 1;
				$ticket_id = $item['ticket_id'];
				$id = $item['ticket_id'];
				$name = $item['customer_name'];
				$ticket_title = $item['ticket_title'];
				$customer_id = $item['customer_id'];
				$clm_id = $item['clm_id'];
				$tkt_sdate_n = $item['ticket_date_n'];
				$status = $item['ticket_status'];

				$name = !empty($name) ? $name : $item['clm_name'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$id = base64_encode($id);
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);

				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Open") {
					$status_txt = "<span class='label label-success'>Open</span>";
				}

				if ($status == "Closed" || $status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}


				$html .= '<tr>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $sr_no . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $ticket_title . '">' . $ticket_title . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;" title="' . $name . '">' . $name . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">' . $tkt_sdate_n . '</td>
					<td style="max-width: 150px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; text-align:center;">' . $status_txt . '</td>
				</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['tbl_all_ticket_list'] = $html;
		$data['count_all_ticket_list'] = $total_count;

		echo json_encode($data);
	}

	// Team Followup  Report 
	public function tbl_team_followup_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;
		$date = $this->input->post('date');
		$em_id = $this->input->post('emp_id');

		$from_date = $this->input->post('from_date');
		$date = $this->input->post('date');

		$month_year = $this->input->post('month_year');

		if (!empty($month_year)) {
			// Try to create a DateTime object and format it to MM-YYYY
			$dateObj = DateTime::createFromFormat('m-Y', $month_year);
			if ($dateObj) {
				// Correctly formatted date
				$month_year = $dateObj->format('m-Y'); // Ensure it's in MM-YYYY
			} else {
				// Handle invalid input
				// For example, if the format is wrong, set a default value or handle the error
				$month_year = null; // or set a default like '01-2025'
			}
		}
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : strtoupper(date("d-M-Y"));
		$from_date = strtoupper(date("d-M-Y", strtotime($from_date)));

		if (!empty($month_year)) {
			$date = null;
			$from_date = null;
		}

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('team_flwup_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followup_post_data', $post_data);
		// print_r($month_year);
		// exit;

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $report_to,
			"five" => $em_id,
			"six" => $from_date,
			"seven" => $date,
			"eight" => $month_year,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);

		$result = $this->api->call_v_api('getTeamFollowup', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_flwup_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_followup_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$followup_assignto_name = $item['followup_assignto'];
				$followup_assignto = $item['followup_assignto'];
				$status = $item['followup_status'];
				$followup_assignto_name = !empty($followup_assignto_name) ? $followup_assignto_name : $followup_assignto;
				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$followup_id = base64_encode($followup_id);
				$ref_id = base64_encode($ref_id);
				$followup_assignto = base64_encode($followup_assignto);

				$desc = $item['followup_feedback'];

				$name_txt = "";
				$assigned_to_txt = '<a href="' . get_module_path() . 'reports/view_team_followup/?id=' . $followup_assignto . '" title="View Details">' . $followup_assignto_name . '</a>';

				if (!empty($item['customer_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';
				}
				if (!empty($item['clm_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';
				}

				// var_dump($name_txt);

				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Following") {
					$status_txt = "<span class='label label-success'>Following</span>";
				}

				if ($status == "Closed") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr>
					   <td>' . $sr_no . '</td>
					   <td title="' . $name . '" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 365px; width: 365px; display: inline-block;">' . $name_txt . '</td>
					   <td>' . $contact . '</td>
					   <td title="' . $desc . '" style="white-space: nowrap; overflow: hidden; text-overflow: ellipsis; max-width: 400px; width: 400px; display: inline-block;">' . $desc . '</td>
				   </tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Followup Details  Report 
	public function tbl_team_followup_details_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$emp_id = $this->input->post('emp_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";
		$emp_id = !empty($emp_id) ? $emp_id : $this->_user_emp_id;

		$total_count = ($page == 1) ? Null : $this->session->userdata('team_flwup_total_d_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followupd_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $from_date,
			"six" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getFollowUpTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_flwup_total_d_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_followup_details_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$followup_assignto_name = $item['followup_assignto_name'];
				$followup_assignto = $item['followup_assignto'];
				$status = $item['followup_status'];
				$followup_feedback = $item['followup_feedback'];
				$followup_assignto_name = !empty($followup_assignto_name) ? $followup_assignto_name : $followup_assignto;

				$ticket_id = $item['ticket_id'];
				$customer_id = $item['customer_id'];
				$followup_id = $item['followup_id'];
				$clm_id = $item['clm_id'];
				$ticket_id = $item['ticket_id'];
				$name = !empty($name) ? $name : $item['clm_name'];
				$contact = !empty($customer_contact) ? $customer_contact : $item['clm_contact'];

				$ref_id = !empty($customer_id) ? $customer_id : $clm_id;
				$customer_id = base64_encode($customer_id);
				$clm_id = base64_encode($clm_id);
				$followup_id = base64_encode($followup_id);
				$ref_id = base64_encode($ref_id);
				$followup_assignto = base64_encode($followup_assignto);

				$name_txt = "";
				$assigned_to_txt = '<a href="' . get_module_path() . 'customers/view_team_followup/?history=back&id=' . $followup_assignto . '" title="View Details">' . $followup_assignto_name . '</a>';

				$view_txt = "";

				if (!empty($item['customer_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'customers/view_followup/?id=' . $customer_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				}
				if (!empty($item['clm_id'])) {
					$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';
					$view_txt = '<a class="btn btn-primary btn-xs" href="' . get_module_path() . 'leads/view_followup/?id=' . $clm_id . '" title="View Details" data-toggle="modal" data-target="#form_modal1"  ><i class="fa fa-eye"></i></a>';
				}

				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Following") {
					$status_txt = "<span class='label label-success'>Following</span>";
				}

				if ($status == "Closed") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $contact . '</td><td title="' . $followup_assignto_name . '">' . $followup_assignto_name . '</td><td>' . $status_txt . '</td><td>' . $view_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Team Lead  Report 
	public function tbl_team_lead_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('team_lead_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_lead_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getAllLeadTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_lead_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_lead_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['clm_name'];
				$clm_contact = $item['clm_contact'];
				$clm_addedbyname = $item['clm_addedbyname'];
				$clm_addedby = $item['clm_addedby'];
				$status = $item['clm_status'];
				$clm_addedbyname = !empty($clm_addedbyname) ? $clm_addedbyname : $clm_addedby;

				$clm_id = $item['clm_id'];
				$clm_id = base64_encode($clm_id);
				$clm_addedby = base64_encode($clm_addedby);

				$name_txt = "";
				$assigned_to_txt = '<a href="' . get_module_path() . 'reports/view_team_lead/?id=' . $clm_addedby . '" title="View Details">' . $clm_addedbyname . '</a>';

				$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $clm_contact . '</td><td>' . $clm_addedbyname . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Followup Details  Report 
	public function tbl_team_lead_details_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$emp_id = $this->input->post('emp_id');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";
		$emp_id = !empty($emp_id) ? $emp_id : $this->_user_emp_id;

		$total_count = ($page == 1) ? Null : $this->session->userdata('team_lead_total_d_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followupd_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $from_date,
			"six" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getLeadTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		/* $list = $result['jsArray'];
		$total_count       = $result['total_count'];	 */
		$this->session->set_userdata('team_lead_total_d_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_lead_details_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['clm_name'];
				$clm_contact = $item['clm_contact'];
				$clm_addedbyname = $item['clm_addedbyname'];
				$clm_addedby = $item['clm_addedby'];
				$status = $item['clm_status'];
				$clm_addedbyname = !empty($clm_addedbyname) ? $clm_addedbyname : $clm_addedby;

				$clm_id = $item['clm_id'];
				$clm_id = base64_encode($clm_id);
				$clm_addedby = base64_encode($clm_addedby);

				$name_txt = "";

				$name_txt = '<a href="' . get_module_path() . 'leads/view_lead/?history=back&id=' . $clm_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Rejected") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $clm_contact . '</td><td title="' . $clm_addedbyname . '">' . $clm_addedbyname . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}
	// Team Customer  Report 
	public function tbl_team_customer_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('team_cust_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_cust_total_count', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getAllCustomerTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_cust_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_customer_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cust_addedbyname = $item['cust_addedbyname'];
				$cust_addedby = $item['cust_addedby'];
				$cust_addedbyname = !empty($cust_addedbyname) ? $cust_addedbyname : $cust_addedby;
				$status = $item['cust_status'];
				$customer_id = $item['customer_id'];

				$customer_id = base64_encode($customer_id);
				$cust_addedby = base64_encode($cust_addedby);

				$name_txt = "";
				$assigned_to_txt = '<a href="' . get_module_path() . 'reports/view_team_customer/?id=' . $cust_addedby . '" title="View Details">' . $cust_addedbyname . '</a>';


				$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $customer_contact . '</td><td>' . $cust_addedbyname . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Customer Details  Report 
	public function tbl_team_customer_details_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$emp_id = $this->input->post('emp_id');
		$status = $this->input->post('status');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";
		$emp_id = !empty($emp_id) ? $emp_id : $this->_user_emp_id;

		$total_count = ($page == 1) ? Null : $this->session->userdata('team_cust_d_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followupd_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $status,
			"six" => $from_date,
			"seven" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getCustomerTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		/* $list = $result['jsArray'];
		$total_count       = $result['total_count'];	 */
		$this->session->set_userdata('team_cust_d_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_customer_details_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['customer_name'];
				$customer_contact = $item['customer_contact'];
				$cust_addedbyname = $item['cust_addedbyname'];
				$cust_addedby = $item['cust_addedby'];
				$cust_addedbyname = !empty($cust_addedbyname) ? $cust_addedbyname : $cust_addedby;
				$status = $item['cust_status'];
				$customer_id = base64_encode($customer_id);
				$cust_addedby = base64_encode($cust_addedby);
				$name_txt = "";

				$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?history=back&id=' . $customer_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $customer_contact . '</td><td title="' . $cust_addedbyname . '">' . $cust_addedbyname . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Ticket  Report 
	public function tbl_team_ticket_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('team_ticket_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_cust_total_count', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getAllTicketTeamReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_ticket_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_ticket_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['ticket_title'];
				$ticket_date_n = $item['ticket_date_n'];
				$ticket_added_byname = $item['tkt_closed_by_name'];
				$ticket_added_by = $item['tkt_closed_by'];
				$ticket_added_byname = !empty($ticket_added_byname) ? $ticket_added_byname : $ticket_added_by;
				$status = $item['ticket_status'];
				$ticket_id = $item['ticket_id'];

				$ticket_id = base64_encode($ticket_id);
				$ticket_added_by = base64_encode($ticket_added_by);

				$name_txt = "";
				$assigned_to_txt = '<a href="' . get_module_path() . 'reports/view_team_ticket/?id=' . $ticket_added_by . '" title="View Details">' . $ticket_added_byname . '</a>';


				$name_txt = '<a href="' . get_module_path() . 'customers/view_ticket/?history=back&id=' . $ticket_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated" || $status == "Closed") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}




				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $ticket_date_n . '</td><td title="' . $ticket_added_byname . '">' . $assigned_to_txt . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Ticket Details  Report 
	public function tbl_team_ticket_details_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$emp_id = $this->input->post('emp_id');
		$status = $this->input->post('status');
		$from_date = $this->input->post('from_date');
		$to_date = $this->input->post('to_date');
		$to_date = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";
		$emp_id = !empty($emp_id) ? $emp_id : $this->_user_emp_id;

		$total_count = ($page == 1) ? Null : $this->session->userdata('team_cust_d_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followupd_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $status,
			"six" => $from_date,
			"seven" => $to_date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getTicketTeamEmpReportDetails', $params);
		$list = $result;
		$total_count = count($list);

		/* $list = $result['jsArray'];
		$total_count       = $result['total_count'];	 */
		$this->session->set_userdata('team_cust_d_total_count', $total_count);
		//echo "<pre/>"; print_r($params);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_ticket_details_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['ticket_title'];
				$ticket_date_n = $item['ticket_date_n'];
				$ticket_added_byname = $item['tkt_closed_by_name'];
				$ticket_added_by = $item['tkt_closed_by'];
				$ticket_added_byname = !empty($ticket_added_byname) ? $ticket_added_byname : $ticket_added_by;
				$status = $item['ticket_status'];
				$ticket_id = $item['ticket_id'];

				$ticket_id = base64_encode($ticket_id);

				$name_txt = '<a href="' . get_module_path() . 'customers/view_ticket/?history=back&id=' . $ticket_id . '" title="' . $name . '">' . $name . '</a>';


				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>" . $status . "</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $ticket_date_n . '</td><td title="' . $ticket_added_byname . '">' . $assigned_to_txt . '</td><td>' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// Team Employee  Report 
	public function tbl_team_emp_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$report_to = $this->input->post('report_to');
		$report_to = $this->_user_id;
		$role_id = $this->_role_id;

		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$report_to = $this->input->post('report_to');
		}
		$report_to = !empty($report_to) ? $report_to : $this->_user_id;
		$total_count = ($page == 1) ? Null : $this->session->userdata('team_emp_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('team_followup_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_emp_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,

		);
		$result = $this->api->call_v_api('getEmployeeReportedToDetails', $params);
		$list = $result;
		$total_count = count($list);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('team_emp_total_count', $total_count);
		//echo "<pre/>"; print_r($result);
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_team_emp_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['emp_id'];
				$name = $item['emp_name'];
				$emp_mob1 = $item['emp_mob1'];
				$dept_name = $item['dept_name'];
				$id = base64_encode($id);
				$name_txt = "";

				// $name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?history=back&id=' . $id . '" title="' . $name . '">' . $name . '</a>';
				$name_txt = '<a href="' . get_module_path() . 'admin/view_employee/?history=back&id=' . $id . '&page=' . $page . '" title="' . $name . '">' . $name . '</a>';


				$html .= '<tr><td>' . $sr_no . '</td><td title="' . $name . '">' . $name_txt . '</td><td>' . $emp_mob1 . '</td><td title="' . $dept_name . '">' . $dept_name . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}
	public function tbl_two_step_verification_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$total_count = ($page == 1) ? Null : $this->session->userdata('2step_total_count');
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->call_v_api('getLoginAuthenticationDetails', $params);

		$list = $result;
		$total_count = count($list);
		$this->session->set_userdata('2step_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_two_step_verification_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$name = $item['lad_auth'];
				$lad_mob = $item['lad_mob'];
				$lad_sdate = $item['lad_sdate'];

				$status = $item['lad_status'];

				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";


				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Inactive") {
					$status_txt = "<span class='label label-danger'>Inactive</span>";
				}

				$html .= '<tr><td>' . $sr_no . '</td><td style="word-break:break-all;">' . $name . '</td><td>' . $lad_mob . '</td><td>' . $lad_sdate . '</td><td style="text-align:center">' . $status_txt . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Functions //

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


	// Added by dhanraj.kakade 	21/03/2023

	public function tbl_stock_report_list($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$post_data['page'] = $page;
		$this->session->set_userdata('item_post_data', $post_data);
		$status = $this->input->post('status');
		$brand_id = $this->input->post('brand_id');
		$cat_id = $this->input->post('p_catid');
		$sub_cat_id = $this->input->post('p_subcatid');
		$area_id = $this->input->post('p_areaid');
		$shelf_id = $this->input->post('p_shielfid');
		$subshelf_id = $this->input->post('p_subshielfid');
		$unit_id = $this->input->post('p_unit');
		$supplier_id = $this->input->post('p_suplid');
		$status = $status ? $status : "";
		$searchStr = $this->input->post('searchStr');
		$total_count = ($page == 1) ? Null : $this->session->userdata('item_total_count');
		$searchStr = addslashes($searchStr);
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => $searchStr,
			"six" => $status,
			"seven" => $brand_id,
			"eight" => $cat_id,
			"nine" => $sub_cat_id,
			"ten" => $area_id,
			"eleven" => $shelf_id,
			"twelve" => $subshelf_id,
			"thirteen" => $unit_id,
			"fourteen" => $supplier_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		$result = $this->api->call_i_api('getInvItemMasterReportDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];

		$this->session->set_userdata('item_total_count', $total_count);

		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax_inventory/tbl_item_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['item_id'];
				$name = $item['item_name'];
				$code = $item['item_code'];
				$item_price = $item['item_price'];
				$item_price2 = $item['item_price2'];
				$status = $item['item_status'];
				$inv_brand_name = $item['inv_brand_name'];
				$item_gst = $item['item_gst'];
				$item_qty = $item['item_qty'];
				$item_unitid = $item['item_unitid'];
				$item_bufferline = $item['item_bufferline'];

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'inventory/view_item/?ref_id=' . $id . '" title="View Details" >' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
					$action_txt = '<a  class="btn btn-primary btn-xs"  href="' . get_module_path() . 'inventory/edit_item/?ref_id=' . $id . '" title="Edit" ><i class="fa fa-edit"></i></a>';

					$action_txt .= '&nbsp;<a  class="btn btn-danger  btn-xs"  data-href="' . get_module_path() . 'inventory/deactivate_item/?ref_id=' . $id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}

				$html .= '<tr><td style="text-align:center;">' . $sr_no . '</td><td style="word-break:break-all;">' . $name_txt . '</td><td>' . $code . '</td><td>' . $item_price . '</td><td>' . $item_price2 . '</td><td>' . $item_price2 . '</td><td></td><td>' . $item_qty . '</td><td>' . $item_bufferline . '</td><td>' . $status_txt . '</td><td></td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='11' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}

	// public function tbl_amc_renewal_reminder($page = 1)
	// {
	// 	$post_data = $this->input->post(Null, true);
	// 	$service_type = $this->input->post('service_type');
	// 	$highlight_id = $this->input->post('highlight_id');
	// 	$status = $this->input->post('status');
	// 	$status = $status ? $status : "";

	// 	$searchStr_name = $this->input->post('searchStr_name');
	// 	//$searchStr_contact    = $this->input->post('searchStr_contact');      
	// 	$searchStr_cust_id = $this->input->post('searchStr_cust_id');

	// 	$searchStr_name = addslashes($searchStr_name);
	// 	// $searchStr_contact    = addslashes($searchStr_contact);   
	// 	$searchStr_cust_id = addslashes($searchStr_cust_id);

	// 	$gst = $this->input->post('gst');

	// 	$total_count = ($page == 1) ? Null : $this->session->userdata('cust_total_count');
	// 	$post_data['page'] = $page;
	// 	$this->session->set_userdata('cust_post_data', $post_data);

	// 	$params = array(
	// 		"one" => $this->_user_company_id,
	// 		"two" => $this->_user_branch_id,
	// 		"limit" => $this->perPage,
	// 		"offset" => $page,
	// 		"total_count" => $total_count
	// 	);
	// 	$result = $this->api->call_v_api('getAMCReminderDetails', $params);

	// 	$list = $result['jsArray'];
	// 	$total_count = $result['total_count'];
	// 	$this->session->set_userdata('cust_total_count', $total_count);
	// 	//echo "<pre/>"; print_r($result);die;
	// 	// Pagination configuration          
	// 	$config['base_url'] = get_module_path() . 'ajax/tbl_amc_renewal_reminder';
	// 	$config['reuse_query_string'] = true;
	// 	$config['total_rows'] = $total_count;
	// 	$config['per_page'] = $this->perPage;
	// 	$config['use_page_numbers'] = true;
	// 	// Initialize pagination library 
	// 	$this->pagination->initialize($config);

	// 	// Form Table
	// 	$html = "";
	// 	if (!empty($list)) {
	// 		foreach ($list as $key => $item) {
	// 			$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
	// 			$customer_id = $item['customer_id'];
	// 			$customer_name = $item['customer_name'];
	// 			$amc_name = $item['amc_name'];
	// 			$cust_subs_startdate = $item['cust_subs_startdate'];
	// 			$cust_subs_startdate = date('d-m-Y', strtotime($cust_subs_startdate));
	// 			$cust_subs_enddate = $item['cust_subs_enddate'];
	// 			$cust_subs_enddate = date('d-m-Y', strtotime($cust_subs_enddate));


	// 			$html .= '<tr class="' . $highlight_class . '">
	// 			<td>' . $sr_no . '</td>
	// 			<td>' . $customer_name . '</td>
	// 			<td>' . $amc_name . '</td>
	// 			<td>' . $cust_subs_startdate . '</td>
	// 			<td>' . $cust_subs_enddate . '</td>
			
	// 		</tr>';
	// 		}
	// 	} else {
	// 		$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
	// 	}

	// 	$data['list'] = $html;
	// 	$data['pagination'] = $this->pagination->create_links();
	// 	$data['total_count'] = $total_count;
	// 	echo json_encode($data);
	// }

	// update by ritika 26 june
	public function tbl_amc_renewal_reminder($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$service_type = $this->input->post('service_type');
		$highlight_id = $this->input->post('highlight_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		//$searchStr_contact    = $this->input->post('searchStr_contact');      
		$searchStr_cust_id = $this->input->post('searchStr_cust_id');

		$searchStr_name = addslashes($searchStr_name);
		// $searchStr_contact    = addslashes($searchStr_contact);   
		$searchStr_cust_id = addslashes($searchStr_cust_id);

		$gst = $this->input->post('gst');

		$total_count = ($page == 1) ? Null : $this->session->userdata('cust_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('cust_post_data', $post_data);

		$params = array(
			"one" => $this->_user_company_id,
			"two" => $this->_user_branch_id,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count
		);
		$result = $this->api->call_v_api('getAMCReminderDetails', $params);
		// echo "<pre>";
		// print_r($result['jsArray']);
		// die;

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('cust_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration          
		$config['base_url'] = get_module_path() . 'ajax/tbl_amc_renewal_reminder';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				//$customer_id = $item['customer_id'];
				$customer_id = base64_encode($item['customer_id']);
				//
				$customer_name = $item['customer_name'];
				//add by ritika
				// Highlight selected customer
				$highlight_class = "";
				if ($highlight_id == $customer_id) {
					$highlight_class = "bg-grey-salt";
				}

				$customer_mobile = !empty($item['customer_contact']) ? $item['customer_contact'] : "-";
				// 
				$amc_name = $item['amc_name'];
				$cust_subs_startdate = $item['cust_subs_startdate'];
				$cust_subs_startdate = date('d-m-Y', strtotime($cust_subs_startdate));
				$cust_subs_enddate = $item['cust_subs_enddate'];
				$cust_subs_enddate = date('d-m-Y', strtotime($cust_subs_enddate));
				// <td><a href="' . get_module_path() . 'customers/view_customer/?id=' . base64_encode($customer_id) . '&history=amc">' . $customer_name . '</a></td>


				$html .= '<tr class="' . $highlight_class . '">
				<td>' . $sr_no . '</td>
				<td><a href="' . get_module_path() . 'customers/view_customer/?id=' . $customer_id . '&history=amc">' . $customer_name . '</a></td>
				
				<td>' . $amc_name . '</td>
					<td>' . $customer_mobile . '</td>
				<td>' . $cust_subs_startdate . '</td>
				<td>' . $cust_subs_enddate . '</td>

			
			
			</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;
		echo json_encode($data);
	}


	// Vihas added on 09/03/2026
	// ROI Report AJAX
	public function get_roi_report($page = 1)
	{

		$month_year = $this->input->post('month_year');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $month_year
		);

		$result = $this->api->call_v_api('getRoiReport', $params);

		$dataObj = $result['jsArray'][0];
		$lead_list = $dataObj['lead_list'];
		$employee_roi = $dataObj['employee_roi'];
		$reference_roi = $dataObj['reference_roi'];

		$html = "";

		if (!empty($lead_list)) {

			$sr_no = 1;
			foreach ($lead_list as $item) {


				$emp_name = $item['emp_name'];
				$lead_name = $item['lead_name'];
				$lead_ref = $item['lead_reference_name'];
				$lead_status = $item['lead_status'];
				$reference_name = $item['reference_name'];
				$lead_date = date("d M Y", strtotime($item['lead_date']));

				// Status Badge
				if ($lead_status == "Approved") {
					$status_badge = '<span class="label label-success">Approved</span>';
				} else {
					$status_badge = '<span class="label label-info">Active</span>';
				}

				if (!empty($lead_ref)) {
					$reference_name = $lead_ref;
				} else {
					$reference_name = !empty($reference_name) ? $reference_name : "-";
				}


				$html .= '<tr>
                        <td style="padding-left:25px;">' . $sr_no . '</td>
                        <td><strong>' . $emp_name . '</strong></td>
                        <td><span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; width: 400px; display: inline-block;">' . $lead_name . '</span></td>
                        <td>' . $status_badge . '</td>
                        <td>' . $reference_name . '</td>
                        <td>' . $lead_date . '</td>
                    </tr>';

				$sr_no = $sr_no + 1;
			}
		} else {

			$html = "<tr>
                    <td colspan='9' class='dataTables_empty text-center'>
                    	No market activity recorded for this month
                    </td>
                </tr>";
		}

		/* ---------------- EMPLOYEE ROI TABLE ---------------- */

		$emp_html = "";

		if (!empty($employee_roi)) {

			$sr_no = 1;

			foreach ($employee_roi as $emp) {

				$emp_html .= '<tr>

            <!-- SR NO -->
            <td style="padding-left:25px;
                
            ">
                ' . ($sr_no) . '
            </td>

            <!-- EMPLOYEE NAME -->
			
            <td style="
                padding:6px 8px;
                text-align:left;
                width:300px;
            ">
                <span style="
                    width:200px;
                    display:inline-block;
                    white-space:nowrap;
                    overflow:hidden;
                    text-overflow:ellipsis;
                ">
                    ' . $emp['emp_name'] . '
                </span>
            </td>

            <!-- LEADS -->
            <td style="text-align:center; width:50px;">
                ' . $emp['total_leads'] . '
            </td>

            <!-- APPROVED -->
            <td style="text-align:center; width:60px;">
                ' . $emp['approved_leads'] . '
            </td>

            <!-- CONVERTED -->
            <td style="text-align:center; width:70px;">
                ' . $emp['converted_customers'] . '
            </td>

            </tr>';

				$sr_no = $sr_no + 1;
			}
		} else {

			$emp_html = "
    <tr>
        <td colspan='5' class='text-center'>
            No market activity recorded for this month
        </td>
    </tr>";
		}
		/* ---------------- REFERENCE ROI TABLE ---------------- */

		$ref_html = "";

		if (!empty($reference_roi)) {

			$sr_no = 1;

			foreach ($reference_roi as $ref) {

				$ref_html .= '<tr>

            <!-- SR NO -->
            <td style="padding-left:25px;
                
            ">
                ' . ($sr_no) . '
            </td>

            <!-- REFERENCE NAME -->
            <td style="
                padding:6px 8px;
                text-align:left;
                width:150px;
            ">
                <span style="
                    overflow:hidden;
                    text-overflow:ellipsis;
                    white-space:nowrap;
                    width:200px;
                    display:inline-block;
                ">
                    ' . $ref['reference_name'] . '
                </span>
            </td>

            <!-- TOTAL LEADS -->
            <td style="
                text-align:center;
                width:50px;
            ">
                ' . $ref['total_leads'] . '
            </td>

            <!-- APPROVED -->
            <td style="
                text-align:center;
                width:60px;
            ">
                ' . $ref['approved_leads'] . '
            </td>

            <!-- CONVERTED -->
            <td style="
                text-align:center;
                width:70px;
            ">
                ' . $ref['converted_customers'] . '
            </td>

            </tr>';

				$sr_no = $sr_no + 1;
			}
		} else {

			$ref_html = "
    <tr>
        <td colspan='5' class='text-center'>
            No data
        </td>
    </tr>";
		}
		$data['list'] = $html;
		$data['employee_roi'] = $emp_html;
		$data['reference_roi'] = $ref_html;
		$data['result'] = $result;

		echo json_encode($data);
	}


	public function tbl_customer_gst_report($page = 1)
	{
		$post_data = $this->input->post(Null, true);
		$service_type = $this->input->post('service_type');
		$highlight_id = $this->input->post('highlight_id');
		$status = $this->input->post('status');
		$status = $status ? $status : "";

		$searchStr_name = $this->input->post('searchStr_name');
		//$searchStr_contact    = $this->input->post('searchStr_contact');		
		$searchStr_cust_id = $this->input->post('searchStr_cust_id');
		$month_year = $this->input->post('month_year');
		//Added by Ankit on 17/03/3036
		$searchStr_name = addslashes($searchStr_name);
		// $searchStr_contact    = addslashes($searchStr_contact);	
		$searchStr_cust_id = addslashes($searchStr_cust_id);

		$gst = $this->input->post('gst');

		$total_count = ($page == 1) ? Null : $this->session->userdata('cust_total_count');
		$post_data['page'] = $page;
		$this->session->set_userdata('cust_post_data', $post_data);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"six" => $searchStr_name,
			/* "seven"=>$searchStr_contact, */
			"eight" => $searchStr_cust_id,
			"nine" => $service_type,
			"twelve" => $gst,
			"thirteen" => $month_year,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);
		//    $result = $this->api->call_v_api('getCustomerMasterReportDetails',$params);
		// $result = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		$result = $this->api->call_v_api('getCustomerGSTReport', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('cust_total_count', $total_count);
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url'] = get_module_path() . 'ajax/tbl_customer_gst_report';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";



		$filtered_count = 0;
		if (!empty($list)) {
			foreach ($list as $key => $item) {


				if ($item['customer_id'] == "TOTAL_ROW") {
					$data['sum_without_gst'] = number_format($item['amount_nogst'], 2);
					$data['sum_gst'] = number_format($item['gst_amount'], 2);
					$data['sum_total'] = number_format($item['total_amount'], 2);
					continue;
				}

				$bill_date = $item['bill_date'];


				$filtered_count++;
				$sr_no = $filtered_count;  // â† uses the filtered counter instead of $key
				$id = $item['customer_id'];
				$name = $item['customer_name'];
				$cust_landline = $item['cust_landline'];
				$cust_company_name = $item['cust_company_name'];
				$amount_nogst = $item['amount_nogst'];
				$gst_amount = $item['gst_amount'];
				$total_amount = $item['total_amount'];


				$customer_contact = $item['customer_contact'];
				$customer_address = $item['customer_address'];
				$customer_contact_email = $item['customer_contact_email'];
				$customer_gstno = $item['customer_gstno'];
				$status = $item['cust_status'];

				$id = base64_encode($id);
				$action_txt = "";
				$status_txt = "<span class='label label-warning'>" . $status . "</span>";
				$name_txt = '<a href="' . get_module_path() . 'customers/view_customer/?id=' . $id . '" title="' . $name . '">' . $name . '</a>';

				if ($status == "Active") {
					$status_txt = "<span class='label label-success'>Active</span>";
				}

				if ($status == "Deactivated") {
					$status_txt = "<span class='label label-danger'>Deactivated</span>";
				}
				$highlight_class = "";
				if ($highlight_id == $id) {
					$highlight_class = "bg-grey-salt";
				}
				$html .= '<tr class="' . $highlight_class . '">

				<td>' . $sr_no . '</td>

				<td>
				<span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:300px;display:inline-block;">
				' . $name_txt . '
				</span>
				</td>

				<td>' . $cust_company_name . '</td>

				<td>' . $customer_gstno . '</td>

				<td style="text-align:right;">' . number_format($amount_nogst, 2) . '</td>

				<td style="text-align:right;">' . number_format($gst_amount, 2) . '</td>

				<td style="text-align:right;font-weight:bold;">' . number_format($total_amount, 2) . '</td>

				</tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='10' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		// REPLACE total_count with filtered_count when month is selected

		$data['total_count'] = $total_count;

		echo json_encode($data);
	}

	public function get_service_list_new()
	{
		$service_type = $this->input->post("service_type");
		$html = "";
		if ($service_type == "AMC") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getAMCDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					//    if($key%2 == 0){
					//    $html .= "<tr>";
					//   }
					//    $html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='".$item['amc_id']."' onchange='get_amc_details(this);' /> &nbsp;".$item['amc_name']."</label></td>";
					//    $html .= "<td><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange='get_amc_details(this);' /> &nbsp;" . $item['amc_name'] . " (Duration: " . $item['amc_duration'] . " months, Price: $" . $item['amc_price'] . " rs, Desc: $" . $item['amc_desc'] .")</label></td>";

					$html .= "<tr>";

					// $html .= "<td><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange='get_amc_details(this);' /> &nbsp;" . " AMC : ". $item['amc_name'] . " - (Duration: " . $item['amc_duration'] . " months, Price: $" . $item['amc_price'] . " rs, Desc: " . substr($item['amc_desc'], 0, 20) .")</label></td>";

					$html .= "<td style='width: 350px !important; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;'><label><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['amc_id'] . "' onchange=\"handleServiceClick(this,'" . $item['amc_id'] . "','AMC')\" /> &nbsp;" . " AMC : " . $item['amc_name'] . "</label></td>";
					$html .= "<td style='white-space: nowrap; overflow: hidden; text-overflow: ellipsis;'><label>Duration: " . $item['amc_duration'] . " days, Price: $" . $item['amc_price'] . " rs, Desc: " . $item['amc_desc'] . "</label></td>";


					$html .= "</tr></br>";
					//    if($key%2 == 1){
					// 	   $html .= "</tr>";
					// 	  }
				}
			}
		}
		if ($service_type == "One Time Service") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getOneTimeServiceMasterDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					if ($key % 2 == 0) {
						$html .= "<tr>";
					}
					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['ots_id'] . "' onchange=\"handleServiceClick(this,'" . $item['ots_id'] . "','OTS')\" /> &nbsp;" . $item['ots_name'] . "</label></td>";

					if ($key % 2 == 1) {
						$html .= "</tr>";
					}
				}
			}
		}
		if ($service_type == "Sales") {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => "Active",
				"five" => "Report"
			);

			$result = $this->api->call_v_api('getProductMasterDetails', $params);
			$list = $result['jsArray'];
			if (!empty($list)) {
				foreach ($list as $key => $item) {
					if ($key % 2 == 0) {
						$html .= "<tr>";
					}

					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='" . $item['pm_id'] . "' onchange=\"handleServiceClick(this,'" . $item['pm_id'] . "','PRODUCT')\" /> &nbsp;" . $item['pm_name'] . "</label></td>";

					if ($key % 2 == 1) {
						$html .= "</tr>";
					}
				}
			}
		}
		echo json_encode($html);
	}

	public function get_customers_details01()
	{
		$ref_id = $this->input->post("ref_id");
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $ref_id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (!empty($details) && isset($details[0])) {
			$details = $details[0];
		} else {
			echo json_encode([]);
			return;
		}
		$data['name'] = $details['customer_name'];
		$data['contact'] = $details['customer_contact'];
		$data['address'] = $details['customer_address'];
		$data['emailid'] = $details['customer_contact_email'];
		$data['contact_person'] = $details['customer_contact_person'];
		$data['dist_id'] = $details['customer_dist_id'];
		$data['state_id'] = $details['customer_state_id'];
		$data['pincode'] = $details['customer_pin'];
		$data['dob'] = $details['cust_dob'];
		$data['company_name'] = $details['cust_company_name'];
		$data['lead_id'] = $details['cust_lead_id'];

		echo json_encode($data);
	}

	// Vihas added for ots name search
	public function search_ots_name()
	{
		$keyword = trim($this->input->post('keyword'));

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);

		$response = $this->api->call_v_api('getOneTimeServiceMasterDetails01', $params);

		$response = isset($response['jsArray']) ? $response['jsArray'] : array();

		$html = "";

		if (!empty($response)) {

			foreach ($response as $row) {

				$ots_name = $row['ots_name'];

				if (stripos($ots_name, $keyword) !== false) {

					$html .= '
                <div style="padding: 10px 12px; color: #444; border-bottom: 1px solid #f1f1f1; font-size: 13px; display: flex; align-items: center;">
                                <i class="fa fa-info-circle font-blue" style="margin-right: 8px; font-size: 14px;"></i> ' . $ots_name . '
                             </div>';
				}
			}
		}

		echo $html;
	}

	// Vihas added for pdt name search
	public function search_pdt_name()
	{
		$keyword = trim($this->input->post('keyword'));

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
			"five" => "Report",
		);

		$response = $this->api->call_v_api('getProductMasterDetails01', $params);

		$response = isset($response['jsArray']) ? $response['jsArray'] : array();

		$html = "";

		if (!empty($response)) {

			foreach ($response as $row) {

				$pdt_name = $row['pm_name'];

				if (stripos($pdt_name, $keyword) !== false) {

					$html .= '
                <div style="padding: 10px 12px; color: #444; border-bottom: 1px solid #f1f1f1; font-size: 13px; display: flex; align-items: center;">
                                <i class="fa fa-info-circle font-blue" style="margin-right: 8px; font-size: 14px;"></i> ' . $pdt_name . '
                             </div>';
				}
			}
		}

		echo $html;
	}

	// Vihas added for getting the location list
	public function get_employee_route()
	{

		$emp_id = $this->input->post('emp_id');
		$date = $this->input->post('date');
		$from_date = $this->input->post('date');

		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : "";
		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$emp_id = base64_decode($emp_id);

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $emp_id,
			"five" => $from_date,
			"six" => $date
		);

		// echo "<pre>";print_r($params);die;
		$result = $this->api->call_v_api('getEmployeeLocationDetails', $params);

		$list = $result['jsArray'];

		echo json_encode($list);
	}

	public function tbl_employee_current_location_list($page = 1)
	{

		$post_data = $this->input->post(null, true);
		$date = $this->input->post('date');
		$from_date = $this->input->post('date');

		$from_date = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : Null;
		$date = !empty($date) ? strtoupper(date("d-M-Y", strtotime($date))) : "";


		$this->session->set_userdata('emp_loc_post_data', $post_data);

		$total_count = ($page == 1) ? null : $this->session->userdata('emp_current_loc_total_count');

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $from_date,
			"five" => $date,
			"limit" => $this->perPage,
			"offset" => $page,
			"total_count" => $total_count,
		);

		$result = $this->api->call_v_api('getEmployeeCurrentLocationDetails', $params);

		$list = $result['jsArray'];
		$total_count = $result['total_count'];
		$this->session->set_userdata('emp_current_loc_total_count', $total_count);

		// Pagination configuration         
		$config['base_url'] = get_module_path() . 'ajax/tbl_employee_current_location_list';
		$config['reuse_query_string'] = true;
		$config['total_rows'] = $total_count;
		$config['per_page'] = $this->perPage;
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config);

		// Form Table
		$html = "";
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$sr_no = (($page - 1) * $this->perPage) + ($key + 1);
				$id = $item['emp_id'];
				$name = $item['emp_name'];
				$mobile_date = $item['mobile_date'];
				$mobile_time = $item['mobile_time'];

				$address = $item['address'];
				$longt = $item['longt'];
				$latt = $item['latt'];
				// Create the Google Map URL
				$google_map_url = "https://maps.google.com/?q=" . $latt . "," . $longt;

				// Create the Google Map iframe
				$map_iframe = '<iframe width="350" height="200" src="https://maps.google.com/maps?q=' . $latt . ',' . $longt . '&hl=en&z=14&amp;output=embed" frameborder="0" style="border: 1px;" allowfullscreen></iframe>';



				$id = base64_encode($id);
				$route_btn = '
					<button
						type="button"
						class="btn btn-primary btn-xs"
						onclick="view_route(\'' . $id . '\', \'' . addslashes($name) . '\')">
						<i class="fa fa-map-marker"></i> View Route
					</button>';

				// Link the address to Google Maps
				$name_txt = '<a href="' . $google_map_url . '" target="_blank" title="View Location">' . $address . '</a>';


				$html .= '<tr><td>' . $sr_no . '</td><td>' . $name . '</td><td>' . $mobile_date . ' ' . $mobile_time . '</td><td>' . $name_txt . '</td><td>' . $map_iframe . '</td><td>' . $route_btn . '</td></tr>';
			}
		} else {
			$html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";
		}

		$data['list'] = $html;
		$data['pagination'] = $this->pagination->create_links();
		$data['total_count'] = $total_count;

		echo json_encode($data);
	}
}
