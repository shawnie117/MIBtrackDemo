	<?php
(defined('BASEPATH')) or exit('No direct script access allowed');
class Customers extends MY_Controller
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
			$vendor  = $this->session->userdata('vendor');
			$this->_vendor_id 		= $vendor['user_id'];
			$this->_user_id 		= $vendor['user_id'];
			$this->_role_id 		= $vendor['user_role_id'];
			$this->_is_logged_in 	= $vendor['is_logged_in'];
			$this->_session_id 		= $vendor['session_id'];
			$this->_user_branch_id  = $vendor['user_branch_id'];
			$this->_user_company_id = $vendor['user_company_id'];
			$this->_user_emp_id     = $vendor['user_emp_id'];
			$this->_user_cust_id    = $vendor['user_cust_id'];
			$this->_user_type       = $vendor['user_type'];
			$this->_user_permission_name =  $vendor['user_person_name'];
			$this->_user_mobile = isset($vendor['user_mob']) ? $vendor['user_mob'] : '';
		}
	}

	/*
	======================================================
	Changes by Shawn Arakal - 2026-07-27 18:21
	Feature: Employee Ticket Performance Tracking (Issue 7)
	======================================================
	*/
	// Employee Performance Redis cache REMOVED per stakeholder request. The dedicated
	// clearEmployeePerformanceCache() helper and its 5 invalidation calls were removed with it.
	// Other existing project caches (clearDashboardCompanyCache, etc.) are intentionally untouched.

	private function clearDashboardCompanyCache($companyId)
	{
		$prefixes = [
			'pending_services',
			'balance_list',
			'amc_reminder',
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


	// Month Scheduler  Report
	public function month_scheduler()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "Month Scheduler";
		$data['status_list']       = array("Open", "Resolved", "Closed", "Deactivated");
		$this->loadViews(get_module() . '/customers/month_scheduler', $data);
	}

	// Service Ticket  Report
	public function service_ticket_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Service Ticket Report";
		$data['status_list']       = array("Open", "Resolved", "Closed", "Deactivated");
		$data['customer_list']     = $this->getCustomerMasterReportDetails();
		$data['employee_list']     = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/customers/list_service_tickets', $data);
	}

	public function view_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Service Ticket Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Service Ticket Details not found');
				redirect(get_module() . '/customers/service_ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Service Ticket Details not found');
					redirect(get_module() . '/customers/service_ticket_report');
				} else {
					$data['details']  = $details[0];
					$this->loadViews(get_module() . '/customers/view_service_ticket', $data);
				}
			}
		}
	}

	public function schedule_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Service Ticket";

		$id         = $this->input->get("id");
		$serv_id    = $this->input->get("serv_id");
		if (empty($id) || empty($serv_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		} else {
			$id      = base64_decode($id);
			$serv_id = base64_decode($serv_id);
			if (!is_numeric($id) || !is_numeric($serv_id)) {
				$this->session->set_flashdata('error', 'Customer Details not found');
				redirect(get_module() . '/customers/customer_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id
				);
				$details         = $this->api->call_v_api('getCustomerMasterDetails', $params);
				$params['six']  = $serv_id;
				$serv_details    = $this->api->call_v_api('getClientServiceDetails', $params);

				if (empty($details) || empty($serv_details)) {
					$this->session->set_flashdata('error', 'Customer Details not found');
					redirect(get_module() . '/customers/customer_report');
				} else {

					$data['priority_list']   = array("High", "Medium", "Low");
					$data['employee_list']   = $this->getEmployeeDetails();
					$data['action']          = "Schedule";
					$data['details']         = $details[0];
					$data['id']              = $id;
					$data['serv_id']         = $serv_id;
					$data['serv_details']    = $serv_details[0];

					$this->form_validation->set_rules('customer_id', 'Customer ', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));

					$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

					$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');


					if ($this->form_validation->run() == FALSE) {
						$this->loadViews(get_module() . '/customers/add_edit_service_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						//echo "<pre/>"; print_r( $post_data);die;
						$customer_id =  $post_data['customer_id'];
						$ticket_date =  $post_data['ticket_date'];

						$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
						$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $serv_id,
							"seven" => "21",
							"eight" => "Servicing",
							"nine" => $post_data['tkt_title'],
							"ten" => $post_data['ticket_desc'],
							"eleven" => $post_data['ticket_priority'],
							"twelve" => $post_data['ticket_assign_to'],
							"thirteen" => $customer_id,
							"sixteen" => $todaydate,
							"twentyone" => $date,
							"twentytwo" => $time,
						);
						//echo "<pre/>"; print_r($params);die;
						$response = $this->api->call_v_api('setTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'New Service Ticket Added successfully ');
							$this->clearDashboardCompanyCache($this->_user_company_id);
							redirect(get_module() . '/customers/ticket_report?type=Servicing');
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/ticket_report?type=Servicing');
						}
					}
				}
			}
		}
	}

	public function add_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Service Ticket";
		$data['action']          = "Add";
		$data['customer_list']   = $this->getCustomerMasterReportDetails();
		$data['priority_list']   = array("High", "Medium", "Low");
		$data['employee_list']   = $this->getEmployeeDetails();

		$this->form_validation->set_rules('customer_id', 'Customer ', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));

		$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

		$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_service_ticket', $data);
		} else {
			$post_data = $this->input->post(null, true);

			//echo "<pre/>"; print_r( $post_data);die;
			$customer_id =  $post_data['customer_id'];
			$ticket_date =  $post_data['ticket_date'];

			$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
			$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

			$todaydate = strtoupper(date("d-M-Y"));
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "21",
				"eight" => "Servicing",
				"nine" => $post_data['tkt_title'],
				"ten" => $post_data['ticket_desc'],
				"eleven" => $post_data['ticket_priority'],
				"twelve" => $post_data['ticket_assign_to'],
				"thirteen" => $customer_id,
				"sixteen" => $todaydate,
				"twentyone" => $date,
				"twentytwo" => $time,
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Service Ticket Added successfully ');
				redirect(get_module() . '/customers/ticket_report?type=Servicing');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/ticket_report?type=Servicing');
			}
		}
	}


	public function edit_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Edit Service Ticket Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Service Ticket Details not found');
				redirect(get_module() . '/customers/service_ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Service Ticket Details not found');
					redirect(get_module() . '/customers/service_ticket_report');
				} else {
					$data['details']         = $details[0];
					$data['action']          = "Edit";
					$data['id']              = $id;
					$data['customer_list']   = $this->getCustomerMasterReportDetails();
					$data['priority_list']   = array("High", "Medium", "Low");
					$data['employee_list']   = $this->getEmployeeDetails();

					$this->form_validation->set_rules('customer_id', 'Customer ', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));

					$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

					$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');


					if ($this->form_validation->run() == FALSE) {
						$this->loadViews(get_module() . '/customers/add_edit_service_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);
						//echo "<pre/>"; print_r($post_data);die;

						$ticket_date =  $post_data['ticket_date'];

						$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
						$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

						$todaydate = strtoupper(date("d-M-Y"));
						$cust_id = $post_data['customer_id'];

						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => "21",
							"seven" => "Servicing",
							"eight" => $post_data['tkt_title'],
							"nine" => $post_data['ticket_desc'],
							"ten" => $post_data['ticket_priority'],
							"eleven" => $post_data['ticket_assign_to'],
							"twelve" => $cust_id,
							"fifteen" => $todaydate,
							"twenty" => $date,
							"twentyone" => $time,
						);
						//echo "<pre/>"; print_r($params);die;
						$response = $this->api->call_v_api('setModifyTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Service Ticket Details Updated successfully ');
							// Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Employee Performance cache removed; invalidation call deleted.
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}





	public function download_gst_report()
	{
		$service_type      = $this->input->post('service_type');
		$status            = $this->input->post('status');
		$status            = $status ? $status : "";
		$searchStr_name    = $this->input->post('searchStr_name');
		$searchStr_cust_id = $this->input->post('searchStr_cust_id');
		$month_year        = $this->input->post('month_year');
		$gst               = $this->input->post('gst');

		$searchStr_name    = addslashes($searchStr_name);
		$searchStr_cust_id = addslashes($searchStr_cust_id);
		//Added by Ankit on 23-03-2026
		$params = array(
			"one"    => $this->_user_id,
			"two"    => $this->_user_branch_id,
			"three"  => $this->_user_company_id,
			"four"   => $status,
			"five"   => $this->_user_branch_id,
			"six"    => $searchStr_name,
			"eight"  => $searchStr_cust_id,
			"ten"    => $month_year,
			"twelve" => $gst,
		);

		$lead_details = $this->api->call_v_api('downloadCustomerGSTReport', $params);

		if (ob_get_length()) {
			ob_clean();
		}

		header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
		header('Content-Disposition: attachment; filename="GST_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Cache-Control: no-cache, must-revalidate");

		echo $lead_details;
		exit;
	}

	public function assign_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Assign Service Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Service Ticket Details not found');
				redirect(get_module() . '/customers/service_ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getServiceMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Service Ticket Details not found');
					redirect(get_module() . '/customers/service_ticket_report');
				} else {
					$data['details']  = $details[0];

					$data['action']          = "AssignS";
					$data['id']              = $id;
					$data['employee_list']   = $this->getEmployeeDetails();
					$data['priority_list']   = array("High", "Medium", "Low");

					$this->form_validation->set_rules('ticket_assign_to', 'Ticket Assigned To', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('tkt_instruction', 'Ticket Instructions', 'max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/assign_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);
						$todaydate   = strtoupper(date("d-M-Y"));
						$customer_id = $details[0]['customer_id'];
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => "21",
							"seven" => "Servicing",
							"ten" => $post_data['ticket_assign_to'],
							"eleven" => $customer_id,
							"fifteen" => $todaydate,
							"twenty" => $post_data['tkt_instruction'],

						);
						$response = $this->api->call_v_api('setReassignTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Service Ticket Assigned successfully ');
							// Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Employee Performance cache removed; invalidation call deleted.
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}
	public function resolve_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Resolve Service Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Service Ticket Details not found');
				redirect(get_module() . '/customers/service_ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getServiceMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Service Ticket Details not found');
					redirect(get_module() . '/customers/service_ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['action']   = "ResolveS";
					$data['id']       = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Resolved",

						);
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);
						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Service Ticket Resolved successfully ');
							// Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Employee Performance cache removed; invalidation call deleted.
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}
	public function close_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Close Service Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Service Ticket Details not found');
				redirect(get_module() . '/customers/service_ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getServiceMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Service Ticket Details not found');
					redirect(get_module() . '/customers/service_ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "CloseS";
					$data['id']              = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Closed",

						);
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);
						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Service Ticket Closed successfully ');
							// Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Employee Performance cache removed; invalidation call deleted.
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}
	public function deactivate_service_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Service Ticket Details not found');
			redirect(get_module() . '/customers/service_ticket_report');
		}
		$data['page_title']   = "Deactivate Service Ticket ";
		$data['input_title']  = "Service Ticket Deactivation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "deactivate_complaint_ticket";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/deactivation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Service Ticket Deactivated successfully ');
				// Changes by Shawn Arakal - 2026-07-27 18:21: Issue 7 - Employee Performance cache removed; invalidation call deleted.
				redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_service_ticket/?id=' . base64_encode($ref_id));
			}
		}
	}

	// Upcoming Services Report
	public function upcoming_service_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['pen_up'] = array("Pending Services", "Upcoming Services");
		$data['page_title']        = "All Upcoming Services Report";
		$this->loadViews(get_module() . '/customers/list_upcoming_services', $data);
	}

	public function send_usr_whatsapp()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Upcoming Services Report";

		$customer_contact  = $this->input->get("customer_contact");
		$cust_serv_sdate_n  = $this->input->get("cust_serv_sdate_n");
		$name  = $this->input->get("name");


		// $customer_contact     = $this->input->post('customer_contact');
		// $cust_serv_sdate_n    = $this->input->post('cust_serv_sdate_n'); 
		// $name    = $this->input->post('name'); 

		$customer_contact = base64_decode($customer_contact);
		$cust_serv_sdate_n = base64_decode($cust_serv_sdate_n);
		$name = base64_decode($name);


		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$details  = $this->api->call_v_api('getCompanyMasterDetails', $params);

		$company_name = $details[0]['company_name'];

		$em_type = 'WhatsApp';

		$wpmsg = 'Hello ' . $name . ', you have service on date ' . $cust_serv_sdate_n . ".\nThank and regards.\n" . $company_name;

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $em_type,
			"five" => $customer_contact,
			"six" => $wpmsg,
		);


		//echo "<pre/>"; print_r($params);die;
		$response = $this->api->call_v_api('sendMessage', $params);


		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Message Sent successfully ');
			redirect(get_module() . '/customers/upcoming_service_report');
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/customers/upcoming_service_report');
		}
	}


	// Complaints  Report 
	public function complaint_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Complaints Report";
		$data['status_list']       = array("Open", "Resolved", "Closed", "Deactivated");
		$data['customer_list']     = $this->getCustomerMasterReportDetails();
		$data['employee_list']     = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/customers/list_complaints', $data);
	}

	public function add_complaint_admin()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Software Complaint";
		$data['action']          = "Add";
		$data['customer_list']     = $this->getCustomerMasterReportDetails();

		// $this->form_validation->set_rules('customer_id','Customer ', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_complaint_miadmin', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$todaydate = strtoupper(date("d-M-Y"));
			$cust_id  = $post_data['customer_id'];
			$params = array(
				"one" => "1",
				"two" => "1",
				"three" => "1",
				"four" => "1",
				"seven" => "2",
				"eight" => "Complaint",
				"nine" => $post_data['tkt_title'],
				"ten" => $post_data['ticket_desc'],
				"twelve" => "1",
				"thirteen" => $this->_user_company_id,
				"sixteen" => $todaydate,
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_api('setTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Software Complaint Added successfully ');
				redirect(get_module() . '/customers/add_complaint_admin');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/add_complaint_admin');
			}
		}
	}

	public function add_complaint()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Complaint";
		$data['action']          = "Add";
		$data['customer_list']     = $this->getCustomerMasterReportDetails();

		$this->form_validation->set_rules('customer_id', 'Customer ', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_complaint', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$todaydate = strtoupper(date("d-M-Y"));
			$cust_id  = $post_data['customer_id'];
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "2",
				"eight" => "Complaint",
				"nine" => $post_data['tkt_title'],
				"ten" => $post_data['ticket_desc'],
				"thirteen" => $cust_id,
				"sixteen" => $todaydate,
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Complaint Added successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/complaint_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/complaint_report');
			}
		}
	}
	public function view_complaint()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Complaint Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Complaint Details not found');
			redirect(get_module() . '/customers/complaint_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Complaint Details not found');
				redirect(get_module() . '/customers/complaint_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getComplaintMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Complaint Details not found');
					redirect(get_module() . '/customers/complaint_report');
				} else {
					$data['details']  = $details[0];
					$this->loadViews(get_module() . '/customers/view_complaint', $data);
				}
			}
		}
	}

	public function edit_complaint()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Edit Complaint Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Complaint Details not found');
			redirect(get_module() . '/customers/complaint_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Complaint Details not found');
				redirect(get_module() . '/customers/complaint_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getComplaintMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Complaint Details not found');
					redirect(get_module() . '/customers/complaint_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "Edit";
					$data['id']              = $id;
					$data['customer_list']   = $this->getCustomerMasterReportDetails();

					$this->form_validation->set_rules('customer_id', 'Customer ', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

					if ($this->form_validation->run() == FALSE) {
						$this->loadViews(get_module() . '/customers/add_edit_complaint', $data);
					} else {
						$post_data = $this->input->post(null, true);
						//echo "<pre/>"; print_r($post_data);die;

						$cust_id = $post_data['customer_id'];
						$todaydate = strtoupper(date("d-M-Y"));

						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => "2",
							"seven" => "Complaint",
							"eight" => $post_data['tkt_title'],
							"nine" => $post_data['ticket_desc'],
							"twelve" => $cust_id,
							"fifteen" => $todaydate,
						);
						//echo "<pre/>"; print_r($params);die;
						$response = $this->api->call_v_api('setModifyTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Complaint Details Updated successfully ');
							$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function assign_complaint_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Assign Complaint Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
			redirect(get_module() . '/customers/complaint_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
				redirect(get_module() . '/customers/complaint_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getComplaintMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
					redirect(get_module() . '/customers/complaint_report');
				} else {
					$data['details']  = $details[0];

					$data['action']          = "AssignC";
					$data['id']              = $id;
					$data['employee_list']   = $this->getEmployeeDetails();
					$data['priority_list']   = array("High", "Medium", "Low");

					$this->form_validation->set_rules('cust_type', 'Lead / Customer Type', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('ref_id', 'Lead / Customer', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

					$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');


					if ($this->form_validation->run() == FALSE) {
						$this->loadViews(get_module() . '/customers/add_edit_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);
						//echo "<pre/>"; print_r($post_data);die;

						$ticket_date =  $post_data['ticket_date'];

						$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
						$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

						$todaydate = strtoupper(date("d-M-Y"));

						$ref_id  = $post_data['ref_id'];
						$cust_type = $post_data['cust_type'];

						$cust_id = $cust_type == "Customers" ? $ref_id : Null;
						$clm_id  = $cust_type == "Leads" ? $ref_id : Null;

						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"six" => $id,
							"seven" => "1",
							"eight" => "Ticket",
							"nine" => $post_data['tkt_title'],
							"ten" => $post_data['ticket_desc'],
							"eleven" => $post_data['ticket_priority'],
							"twelve" => $post_data['ticket_assign_to'],
							"thirteen" => $cust_id,
							"fourteen" => $clm_id,
							"sixteen" => $todaydate,
							"twentyone" => $date,
							"twentytwo" => $time,
						);
						//echo "<pre/>"; print_r($params);die;
						$response = $this->api->call_v_api('setTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Ticket Assigned Successfully ');
							$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
							redirect(get_module() . '/customers/ticket_report');
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/ticket_report');
						}
					}
				}
			}
		}
	}


	public function deactivate_complaint_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
			redirect(get_module() . '/customers/complaint_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
			redirect(get_module() . '/customers/complaint_report');
		}
		$data['page_title']   = "Deactivate Complaint Ticket ";
		$data['input_title']  = "Complaint Ticket Deactivation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "deactivate_complaint_ticket";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/deactivation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Complaint Ticket Deactivated successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($ref_id));
			}
		}
	}
	public function resolve_complaint_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Resolve Complaint Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
			redirect(get_module() . '/customers/complaint_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
				redirect(get_module() . '/customers/complaint_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getComplaintMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
					redirect(get_module() . '/customers/complaint_report');
				} else {
					$data['details']  = $details[0];
					$data['action']   = "ResolveC";
					$data['id']       = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Resolved",

						);
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);
						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Complaint Ticket Resolved successfully ');
							$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}


	public function close_complaint_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Close Complaint Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
			redirect(get_module() . '/customers/complaint_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
				redirect(get_module() . '/customers/complaint_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getComplaintMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Complaint Ticket Details not found');
					redirect(get_module() . '/customers/complaint_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "CloseC";
					$data['id']              = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Closed",

						);
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);
						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Complaint Ticket Closed successfully ');
							$this->cache->redis->deleteByPattern('ci_dashboard:raised_complaint_list:' .$this->_user_company_id .':*');
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_complaint/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function download_complaint_report()
	{
		$status               = $this->input->post('status');
		$status               = $status ? $status : "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $this->_user_branch_id,
		);

		$result = $this->api->call_v_api('downloadComplaintMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Complaint_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function download_upcoming_service_report()
	{
		$status               = $this->input->post('status');
		$status               = $status ? $status : "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $this->_user_branch_id,
		);

		$result = $this->api->call_v_api('getDownloadExelUpcomingServiceDetails2', $params);
		// download file
		header('Content-Disposition: attachment; filename="Upcoming_Service_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	// anjali added 18/06/26
	public function ticket_summary_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		// $data = array();
		
		$data['page_title'] = "Ticket Summary Report";
// 
		// $this->load->view('_parts/header', $data);
		// $this->load->view('reports/ticket_summary_report', $data);
		// $this->load->view('_parts/footer', $data);
	$this->loadViews(get_module() . '/reports/ticket_summary_report', $data);
		
	}


	public function get_ticket_summary_report()
	{
		if (!($this->check_access('customers', 'ticket_summary_report'))) {
			$this->output->set_status_header(403);
			$this->output->set_content_type('application/json');
			echo json_encode(array(
				'status' => false,
				'message' => 'Access denied'
			));
			exit;
		}

		$month_year = $this->input->post('month_year');
		$from_date_input = $this->input->post('from_date');
		$to_date_input = $this->input->post('to_date');

		$report_month_year = !empty($month_year) ? $month_year : date("m-Y");

		$filter_from_date = !empty($from_date_input)
			? strtoupper(date("d-M-Y", strtotime($from_date_input)))
			: "";

		$filter_to_date = !empty($to_date_input)
			? strtoupper(date("d-M-Y", strtotime($to_date_input)))
			: "";

		// Changes by Shawn Arakal - 28/07/2026 17:27 : Phase 1 - when nothing is selected (no month,
		// no From, no To), default the End Date to today so counts are calculated up to today's date
		// instead of only the current month. Start Date stays empty. Reuses the existing From/To date
		// filtering (getTicketSummaryReport); does NOT affect month selection or explicit date ranges.
		if (empty($month_year) && empty($from_date_input) && empty($to_date_input)) {
			$filter_to_date = strtoupper(date("d-M-Y"));
		}


		if (!empty($filter_from_date) && empty($filter_to_date)) {

			// From Date -> Today
			$filter_to_date = strtoupper(date("d-M-Y"));

		}

		if (!empty($filter_from_date) &&
			!empty($filter_to_date) &&
			strtotime($filter_to_date) < strtotime($filter_from_date)) {

			$filter_to_date = $filter_from_date;
		}

		$has_date_filter =
			(!empty($filter_from_date) || !empty($filter_to_date));

		if ($has_date_filter) {

			// Ignore month when date filter is used
			$report_month_year = "";
			$api_month_year = "";

		} else {

			if (!empty($report_month_year)) {

				$month_date =
					DateTime::createFromFormat('m-Y', $report_month_year);

				$api_month_year = !empty($month_date)
					? strtoupper($month_date->format('M-Y'))
					: strtoupper(date("M-Y",
						strtotime("1-" . $report_month_year)));

			} else {

				$api_month_year = strtoupper(date("M-Y"));
			}
		}

		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four"  => $api_month_year,
			"five"  => $filter_from_date,
			"six"  => $filter_to_date
		);

		$result = array();
		
			$result = $this->api->call_v_api('getTicketSummaryReport', $params);
		

		$ticket_list = array();
		$employee_summary = array();
		$company_employee_map = array();
		$company_employee_name_map = array();
		$dataObj = array();
		$summary_requires_rebuild = false;

		if (!empty($result) && isset($result['jsArray']) && !empty($result['jsArray'])) {
			$dataObj = $result['jsArray'][0];

			if (empty($dataObj['ticket_list']) && (!empty($dataObj['ticket_id']) || !empty($dataObj['ticket_seq_id']))) {
				$dataObj = array(
					'ticket_list' => $result['jsArray']
				);
			}
		} else if (!empty($result) && is_array($result)) {
			$dataObj = $result;
		}

		$ticket_list = !empty($dataObj['ticket_list'])
			? $dataObj['ticket_list']
			: (!empty($dataObj['tickets']) ? $dataObj['tickets'] : array());

		$employee_summary = !empty($dataObj['employee_summary'])
			? $dataObj['employee_summary']
			: (!empty($dataObj['employee_ticket_summary']) ? $dataObj['employee_ticket_summary'] : array());

		$is_team_report_view = in_array($this->_role_id, array(
			SUPER_ADMIN_ROLE_ID,
			ADMIN_ROLE_ID,
			SUB_ADMIN_ROLE_ID
		));

		$company_employee_list = $this->getEmployeeDetails();
		if (!empty($company_employee_list)) {
			foreach ($company_employee_list as $employee) {
				$employee_id = !empty($employee['user_id'])
					? $employee['user_id']
					: (!empty($employee['emp_id']) ? $employee['emp_id'] : "");
				$employee_name = !empty($employee['emp_name'])
					? $employee['emp_name']
					: (!empty($employee['employee_name'])
						? $employee['employee_name']
						: (!empty($employee['user_person_name']) ? $employee['user_person_name'] : ""));

				if (!$is_team_report_view) {
					$match_current_user_id = ((string) $employee_id) === ((string) $this->_user_id);
					$match_current_user_name = !empty($employee_name) && strtolower(trim($employee_name)) === strtolower(trim((string) $this->_user_permission_name));

					if (!$match_current_user_id && !$match_current_user_name) {
						continue;
					}
				}

				$employee_key = !empty($employee_id) ? (string) $employee_id : strtolower(trim($employee_name));

				if (!empty($employee_key) && !empty($employee_name)) {
					$company_employee_map[$employee_key] = array(
						"employee_id" => $employee_id,
						"user_id" => $employee_id,
						"emp_id" => !empty($employee['emp_id']) ? $employee['emp_id'] : "",
						"employee_name" => $employee_name,
						"total_tickets" => 0,
						"open_tickets" => 0,
						"resolved_tickets" => 0,
						"reopened_tickets" => 0,
						"deactivated_tickets" => 0,
						"closed_tickets" => 0,
					);

					$company_employee_name_map[strtolower(trim($employee_name))] = $employee_key;
				}
			}
		}

		if (!$is_team_report_view && !empty($ticket_list)) {
			$current_user_id = (string) $this->_user_id;
			$current_user_name = strtolower(trim((string) $this->_user_permission_name));
			$filtered_ticket_list = array();

			foreach ($ticket_list as $row) {
				$row_user_id = "";
				if (!empty($row['ticket_assign_to'])) {
					$row_user_id = $row['ticket_assign_to'];
				} else if (!empty($row['assigned_to'])) {
					$row_user_id = $row['assigned_to'];
				} else if (!empty($row['ticket_assign_to_id'])) {
					$row_user_id = $row['ticket_assign_to_id'];
				} else if (!empty($row['emp_id'])) {
					$row_user_id = $row['emp_id'];
				}

				$row_user_name = "";
				if (!empty($row['ticket_assign_to_name'])) {
					$row_user_name = $row['ticket_assign_to_name'];
				} else if (!empty($row['assigned_to_name'])) {
					$row_user_name = $row['assigned_to_name'];
				} else if (!empty($row['employee_name'])) {
					$row_user_name = $row['employee_name'];
				} else if (!empty($row['emp_name'])) {
					$row_user_name = $row['emp_name'];
				} else if (!empty($row['user_person_name'])) {
					$row_user_name = $row['user_person_name'];
				}

				$match_user_id = ((string) $row_user_id) === $current_user_id;
				$match_user_name = !empty($row_user_name) && (strtolower(trim($row_user_name)) === $current_user_name);

				if ($match_user_id || $match_user_name) {
					$filtered_ticket_list[] = $row;
				}
			}

			if (!empty($filtered_ticket_list)) {
				$ticket_list = $filtered_ticket_list;
				$summary_requires_rebuild = true;
			}
			$dataObj['ticket_list'] = $ticket_list;
		}

		if (!$is_team_report_view && !empty($employee_summary)) {
			$current_user_id = (string) $this->_user_id;
			$current_user_name = strtolower(trim((string) $this->_user_permission_name));
			$filtered_employee_summary = array();

			foreach ($employee_summary as $emp) {
				$emp_id = "";
				if (!empty($emp['employee_id'])) {
					$emp_id = $emp['employee_id'];
				} else if (!empty($emp['user_id'])) {
					$emp_id = $emp['user_id'];
				} else if (!empty($emp['emp_id'])) {
					$emp_id = $emp['emp_id'];
				}

				$emp_name = "";
				if (!empty($emp['employee_name'])) {
					$emp_name = $emp['employee_name'];
				} else if (!empty($emp['emp_name'])) {
					$emp_name = $emp['emp_name'];
				} else if (!empty($emp['user_person_name'])) {
					$emp_name = $emp['user_person_name'];
				}

				$match_user_id = ((string) $emp_id) === $current_user_id;
				$match_user_name = !empty($emp_name) && (strtolower(trim($emp_name)) === $current_user_name);

				if ($match_user_id || $match_user_name) {
					$filtered_employee_summary[] = $emp;
				}
			}

			if (!empty($filtered_employee_summary)) {
				$employee_summary = $filtered_employee_summary;
				$summary_requires_rebuild = true;
			}
			$dataObj['employee_summary'] = $employee_summary;
		}

		if ( empty($ticket_list)) {
			$from_date = "";
			$to_date = "";

			if ($has_date_filter) {
				$from_date = $filter_from_date;
				$to_date = $filter_to_date;
			} else if (!empty($report_month_year)) {
				$month_date = DateTime::createFromFormat('m-Y', $report_month_year);

				if (!empty($month_date)) {
					$from_date = strtoupper($month_date->format('01-M-Y'));
					$to_date = strtoupper($month_date->format('t-M-Y'));
				}
			}

			$ticket_assign_to = $this->_user_id;
			if ($this->_role_id == SUPER_ADMIN_ROLE_ID || $this->_role_id == ADMIN_ROLE_ID) {
				$ticket_assign_to = "";
			}

			$ticket_params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"five" => "",
				"six" => "",
				"seven" => "",
				"eight" => $ticket_assign_to,
				"nine" => "",
				"ten" => "",
				"eleven" => $from_date,
				"twelve" => $to_date,
				"limit" => 5000,
				"offset" => 1,
				"total_count" => Null,
			);

			$fallback_result = $this->api->call_v_api('getTicketMasterReportDetails', $ticket_params);

			if (!empty($fallback_result['jsArray'])) {
				$ticket_list = $fallback_result['jsArray'];
				$summary_requires_rebuild = true;
			}
		}

		$unique_employee_keys = array();
		foreach ($ticket_list as $ticket_row) {
			$ticket_employee_id = !empty($ticket_row['ticket_assign_to'])
				? $ticket_row['ticket_assign_to']
				: (!empty($ticket_row['assigned_to'])
					? $ticket_row['assigned_to']
					: (!empty($ticket_row['ticket_assign_to_id'])
						? $ticket_row['ticket_assign_to_id']
						: (!empty($ticket_row['emp_id']) ? $ticket_row['emp_id'] : "")));

			$ticket_employee_name = !empty($ticket_row['ticket_assign_to_name'])
				? $ticket_row['ticket_assign_to_name']
				: (!empty($ticket_row['assigned_to_name'])
					? $ticket_row['assigned_to_name']
					: (!empty($ticket_row['employee_name'])
						? $ticket_row['employee_name']
						: (!empty($ticket_row['emp_name'])
							? $ticket_row['emp_name']
							: (!empty($ticket_row['user_person_name'])
								? $ticket_row['user_person_name']
								: (!empty($ticket_row['tkt_closed_by_name'])
									? $ticket_row['tkt_closed_by_name']
									: "")))));

			$employee_key = "";
			if (!empty($ticket_employee_id)) {
				$employee_key = (string) $ticket_employee_id;
			} else if (!empty($ticket_employee_name)) {
				$employee_key = strtolower(trim($ticket_employee_name));
			}

			if (!empty($employee_key)) {
				$unique_employee_keys[$employee_key] = true;
			}
		}

		$employee_summary_is_partial = (
			is_array($employee_summary) &&
			count($employee_summary) > 0 &&
			count($unique_employee_keys) > 0 &&
			count($employee_summary) < count($unique_employee_keys)
		);
		$employee_summary_missing_company_employees = (
			is_array($employee_summary) &&
			count($company_employee_map) > 0 &&
			count($employee_summary) < count($company_employee_map)
		);

		if (!empty($ticket_list) && (
			$summary_requires_rebuild ||
			empty($dataObj['total_tickets']) ||
			empty($dataObj['open_tickets']) ||
			empty($dataObj['resolved_tickets']) ||
			empty($dataObj['closed_tickets']) ||
			empty($employee_summary) ||
			$employee_summary_is_partial ||
			$employee_summary_missing_company_employees
		)) {
			$total_tickets = 0;
			$open_tickets = 0;
			$reopened_tickets = 0;
			$resolved_tickets = 0;
			$closed_tickets = 0;
			$deactivated_tickets = 0;

			$employee_map = $company_employee_map;
			$employee_name_map = $company_employee_name_map;
			$employee_ticket_details = array();

			foreach ($employee_map as $employee_key => $employee_data) {
				$employee_ticket_details[$employee_key] = array(
					"employee_id" => $employee_data['employee_id'],
					"employee_name" => $employee_data['employee_name'],
					"tickets" => array(),
				);
			}

			foreach ($ticket_list as $ticket_row) {
				$total_tickets++;

				$status = !empty($ticket_row['ticket_status'])
					? $ticket_row['ticket_status']
					: (!empty($ticket_row['status']) ? $ticket_row['status'] : "");
				$status_key = strtolower($status);
				// $is_open_status = (strpos($status_key, "open") !== false || $status_key == "active");
				// $is_resolved_status = (strpos($status_key, "resolved") !== false);
				// $is_closed_status = (strpos($status_key, "closed") !== false || strpos($status_key, "deactivated") !== false);

				$is_open_status = ($status_key == "open" || $status_key == "active");
				$is_reopened_status = ($status_key == "reopened");
				$is_resolved_status = ($status_key == "resolved");
				$is_closed_status = ($status_key == "closed");
				$is_deactivated_status = ($status_key == "deactivated");

				// if ($is_open_status) {
				// 	$open_tickets++;
				// } else if ($is_resolved_status) {
				// 	$resolved_tickets++;
				// } else if ($is_closed_status) {
				// 	$closed_tickets++;
				// }

				if ($is_open_status) {
					$open_tickets++;
				} else if ($is_reopened_status) {
					$reopened_tickets++;
				} else if ($is_resolved_status) {
					$resolved_tickets++;
				} else if ($is_closed_status) {
					$closed_tickets++;
				} else if ($is_deactivated_status) {
					$deactivated_tickets++;
}

				$ticket_employee_id = !empty($ticket_row['ticket_assign_to'])
					? $ticket_row['ticket_assign_to']
					: (!empty($ticket_row['assigned_to'])
						? $ticket_row['assigned_to']
						: (!empty($ticket_row['ticket_assign_to_id'])
							? $ticket_row['ticket_assign_to_id']
							: (!empty($ticket_row['emp_id']) ? $ticket_row['emp_id'] : "")));

				$ticket_employee_name = !empty($ticket_row['ticket_assign_to_name'])
					? $ticket_row['ticket_assign_to_name']
					: (!empty($ticket_row['assigned_to_name'])
						? $ticket_row['assigned_to_name']
						: (!empty($ticket_row['employee_name'])
							? $ticket_row['employee_name']
							: (!empty($ticket_row['emp_name'])
								? $ticket_row['emp_name']
								: (!empty($ticket_row['user_person_name'])
									? $ticket_row['user_person_name']
									: (!empty($ticket_row['tkt_closed_by_name'])
										? $ticket_row['tkt_closed_by_name']
										: "")))));

				$employee_key = "";
				if (!empty($ticket_employee_id) && isset($employee_map[(string) $ticket_employee_id])) {
					$employee_key = (string) $ticket_employee_id;
				} else if (!empty($ticket_employee_name)) {
					$ticket_employee_name_key = strtolower(trim($ticket_employee_name));
					$employee_key = !empty($employee_name_map[$ticket_employee_name_key])
						? $employee_name_map[$ticket_employee_name_key]
						: $ticket_employee_name_key;
					$employee_name_map[$ticket_employee_name_key] = $employee_key;
				} else if (!empty($ticket_employee_id) && empty($company_employee_map)) {
					$employee_key = (string) $ticket_employee_id;
				}

				if (empty($employee_key)) {
					continue;
				}

				if (!isset($employee_map[$employee_key])) {
					$employee_map[$employee_key] = array(
						"employee_id" => $ticket_employee_id,
						"user_id" => $ticket_employee_id,
						"emp_id" => "",
						"employee_name" => !empty($ticket_employee_name)
							? $ticket_employee_name
							: (!empty($ticket_employee_id)
								? 'Employee ' . $ticket_employee_id
								: 'Unknown Employee'),
						"total_tickets" => 0,
						"open_tickets" => 0,
						"resolved_tickets" => 0,
						"closed_tickets" => 0,
					);
				}

				if (!isset($employee_ticket_details[$employee_key])) {
					$employee_ticket_details[$employee_key] = array(
						"employee_id" => $employee_map[$employee_key]['employee_id'],
						"employee_name" => $employee_map[$employee_key]['employee_name'],
						"tickets" => array(),
					);
				}

				$employee_map[$employee_key]['total_tickets']++;
				$employee_ticket_details[$employee_key]['tickets'][] = $ticket_row;

				// if ($is_open_status) {
				// 	$employee_map[$employee_key]['open_tickets']++;
				// } else if ($is_resolved_status) {
				// 	$employee_map[$employee_key]['resolved_tickets']++;
				// } else if ($is_closed_status) {
				// 	$employee_map[$employee_key]['closed_tickets']++;
				// }
				if ($is_open_status) {
					$employee_map[$employee_key]['open_tickets']++;
				}
				else if ($is_reopened_status) {
					$employee_map[$employee_key]['reopened_tickets']++;
				}
				else if ($is_resolved_status) {
					$employee_map[$employee_key]['resolved_tickets']++;
				}
				else if ($is_closed_status) {
					$employee_map[$employee_key]['closed_tickets']++;
				}
				else if ($is_deactivated_status) {
					$employee_map[$employee_key]['deactivated_tickets']++;
				}
			}

			if (!empty($employee_map)) {
				$employee_summary = array_values($employee_map);
			}

			$dataObj['ticket_list'] = $ticket_list;
			$dataObj['employee_summary'] = $employee_summary;
			$dataObj['employee_ticket_details'] = array_values($employee_ticket_details);

			$dataObj['total_tickets'] = $total_tickets;
			$dataObj['open_tickets'] = $open_tickets;
			$dataObj['reopened_tickets'] = $reopened_tickets;
			$dataObj['resolved_tickets'] = $resolved_tickets;
			$dataObj['closed_tickets'] = $closed_tickets;
			$dataObj['deactivated_tickets'] = $deactivated_tickets;
		}

		if (empty($ticket_list) && empty($employee_summary) && !empty($company_employee_map)) {
			$employee_ticket_details = array();

			foreach ($company_employee_map as $employee_key => $employee_data) {
				$employee_ticket_details[$employee_key] = array(
					"employee_id" => $employee_data['employee_id'],
					"employee_name" => $employee_data['employee_name'],
					"tickets" => array(),
				);
			}

			$employee_summary = array_values($company_employee_map);
			$dataObj['ticket_list'] = array();
			$dataObj['employee_summary'] = $employee_summary;
			$dataObj['employee_ticket_details'] = array_values($employee_ticket_details);
			$dataObj['total_tickets'] = 0;
			$dataObj['open_tickets'] = 0;
			$dataObj['resolved_tickets'] = 0;
			$dataObj['closed_tickets'] = 0;
		}

		$ticket_html = '';
		$sr = 1;

		if (!empty($ticket_list)) {
			foreach ($ticket_list as $row) {
				$ticket_date = "";
				$ticket_date_value = !empty($row['ticket_date_n'])
					? $row['ticket_date_n']
					: (!empty($row['ticket_date'])
						? $row['ticket_date']
						: (!empty($row['tkt_sdate_n']) ? $row['tkt_sdate_n'] : ""));

				if (!empty($ticket_date_value)) {
					$ticket_date = date("d M Y", strtotime($ticket_date_value));
				}

				$ticket_id = !empty($row['ticket_seq_id']) ? $row['ticket_seq_id'] : (!empty($row['ticket_id']) ? $row['ticket_id'] : "");
				$ticket_title = !empty($row['ticket_title']) ? $row['ticket_title'] : (!empty($row['tkt_title']) ? $row['tkt_title'] : "");
				$customer_name = !empty($row['customer_name']) ? $row['customer_name'] : (!empty($row['clm_name']) ? $row['clm_name'] : "");
				$ticket_status = !empty($row['ticket_status']) ? $row['ticket_status'] : (!empty($row['status']) ? $row['status'] : "");
				$assigned_to = !empty($row['assigned_to'])
					? $row['assigned_to']
					: (!empty($row['ticket_assign_to_name'])
						? $row['ticket_assign_to_name']
						: (!empty($row['ticket_assign_to'])
							? $row['ticket_assign_to']
							: (!empty($row['tkt_closed_by_name']) ? $row['tkt_closed_by_name'] : "")));

				$ticket_html .= '
				<tr>
					<td>' . $sr++ . '</td>
					<td>' . html_escape($ticket_id) . '</td>
					<td>' . html_escape($ticket_title) . '</td>
					<td>' . html_escape($customer_name) . '</td>
					<td>' . html_escape($ticket_status) . '</td>
					<td>' . html_escape($assigned_to) . '</td>
					<td>' . $ticket_date . '</td>
				</tr>';
			}
		} else {
			$ticket_html .= '
			<tr>
				<td colspan="7" class="text-center">
					No Tickets Found
				</td>
			</tr>';
		}

		usort($employee_summary, function ($a, $b) {

			$a_total = !empty($a['open_tickets']) ? (int)$a['open_tickets'] : 0;
			$b_total = !empty($b['open_tickets']) ? (int)$b['open_tickets'] : 0;

			return $b_total - $a_total;
		});
		
		/*
		======================================================
		Changes by Shawn Arakal - 28/07/2026 12:19
		Feature: Employee Performance moved to Java backend
		======================================================
		*/
		// PHP lifetime ticket scanning REMOVED. Employee performance (average/fastest/slowest,
		// completed count) and the best->worst ranking are now computed entirely in the Oracle
		// backend via the new getEmployeePerformanceSummary endpoint (single query, ROW_NUMBER
		// ranking, same final-assignee attribution as the Employee Ticket Summary). The counts
		// still come from getTicketSummaryReport (unchanged); the ranked list only orders the rows.
		// Fetch the backend-ranked employee performance (best -> worst). One row per employee, already ranked.
		// Changes by Shawn Arakal - 28/07/2026 17:27 (Phase 2): pass the SAME period params sent to
		// getTicketSummaryReport (four=month, five=from, six=to) so the ranking follows the selected range.
		$performance_ranking = $this->api->call_v_api('getEmployeePerformanceSummary', array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four"  => $api_month_year,
			"five"  => $filter_from_date,
			"six"   => $filter_to_date
		));

		// The backend returns a plain list; some endpoints wrap it in jsArray. Handle both.
		$perf_rank_by_id = array();
		$perf_rank_by_name = array();
		if (!empty($performance_ranking)) {
			$perf_rows = (is_array($performance_ranking) && isset($performance_ranking['jsArray']))
				? $performance_ranking['jsArray']
				: $performance_ranking;
			if (is_array($perf_rows)) {
				foreach ($perf_rows as $perf_row) {
					if (!is_array($perf_row)) {
						continue;
					}
					$pr_rank = isset($perf_row['rank']) ? (int)$perf_row['rank'] : 0;
					if ($pr_rank <= 0) {
						continue;
					}
					if (!empty($perf_row['emp_id'])) {
						$perf_rank_by_id[(string)$perf_row['emp_id']] = $pr_rank;
					}
					if (!empty($perf_row['emp_name'])) {
						$perf_rank_by_name[strtolower(trim($perf_row['emp_name']))] = $pr_rank;
					}
				}
			}
		}

		// Order the Employee Ticket Summary rows to match the backend ranking (best -> worst).
		// Counts are UNCHANGED (still from getTicketSummaryReport) - only the row ORDER changes.
		// Employees without a backend rank (no completed tickets) are placed last, by name.
		// Matching mirrors the existing attribution: EMP_ID first, then employee name.
		if (!empty($employee_summary) && is_array($employee_summary)) {
			$rank_unranked = 1000000;
			$employee_summary_ranked = array();
			foreach ($employee_summary as $rank_idx => $rank_emp) {
				$rank_emp_id = !empty($rank_emp['emp_id'])
					? (string)$rank_emp['emp_id']
					: (!empty($rank_emp['employee_id']) ? (string)$rank_emp['employee_id'] : "");
				$rank_name = !empty($rank_emp['employee_name'])
					? $rank_emp['employee_name']
					: (!empty($rank_emp['emp_name'])
						? $rank_emp['emp_name']
						: (!empty($rank_emp['user_person_name']) ? $rank_emp['user_person_name'] : ""));
				$rank_name_key = strtolower(trim($rank_name));

				$emp_rank = $rank_unranked;
				if ($rank_emp_id !== "" && isset($perf_rank_by_id[$rank_emp_id])) {
					$emp_rank = $perf_rank_by_id[$rank_emp_id];
				} else if ($rank_name_key !== "" && isset($perf_rank_by_name[$rank_name_key])) {
					$emp_rank = $perf_rank_by_name[$rank_name_key];
				}

				$employee_summary_ranked[] = array(
					"emp"  => $rank_emp,
					"rank" => $emp_rank,
					"name" => $rank_name_key,
					"idx"  => $rank_idx
				);
			}

			usort($employee_summary_ranked, function ($a, $b) {
				// Order strictly by the backend rank; ties (e.g. unranked employees) fall back to
				// employee name, then original position, so the order is stable and consistent.
				if ($a['rank'] !== $b['rank']) {
					return ($a['rank'] < $b['rank']) ? -1 : 1;
				}
				$name_cmp = strcmp($a['name'], $b['name']);
				if ($name_cmp !== 0) {
					return $name_cmp;
				}
				return $a['idx'] - $b['idx'];
			});

			$employee_summary = array();
			foreach ($employee_summary_ranked as $ranked_row) {
				$employee_summary[] = $ranked_row['emp'];
			}
		}

		$emp_html = '';
		$sr = 1;

		if (!empty($employee_summary)) {
			foreach ($employee_summary as $emp) {
				$employee_name = !empty($emp['employee_name']) ? $emp['employee_name'] : (!empty($emp['emp_name']) ? $emp['emp_name'] : "");
				$total_tickets = !empty($emp['total_tickets']) ? $emp['total_tickets'] : (!empty($emp['total_tickets']) ? $emp['total_tickets'] : "0");
				$open_tickets = !empty($emp['open_tickets']) ? $emp['open_tickets'] : (!empty($emp['open_tickets']) ? $emp['open_tickets'] : "0");
				$reopened_tickets = !empty($emp['reopened_tickets']) ? $emp['reopened_tickets'] : (!empty($emp['reopened_tickets']) ? $emp['reopened_tickets'] : "0");
				$resolved_tickets = !empty($emp['resolved_tickets']) ? $emp['resolved_tickets'] : (!empty($emp['resolved_tickets']) ? $emp['resolved_tickets'] : "0");
				$closed_tickets = !empty($emp['closed_tickets']) ? $emp['closed_tickets'] : (!empty($emp['closed_tickets']) ? $emp['closed_tickets'] : "0");
				$deactivated_tickets = !empty($emp['deactivated_tickets']) ? $emp['deactivated_tickets'] : (!empty($emp['deactivated_tickets']) ? $emp['deactivated_tickets'] : "0");
			
				//changes made by anjali 25/06/26 for make count clickable
		// 		$emp_html .= '
		// 		<tr>
		// 			<td>' . $sr++ . '</td>
		// 			<td>' . html_escape($employee_name) . '</td>
		// 			<td>' . html_escape($total_tickets) . '</td>
		// 			<td>' . html_escape($open_tickets) . '</td>
		// 			<td>' . html_escape($reopened_tickets) . '</td>
		// 			<td>' . html_escape($resolved_tickets) . '</td>
		// 			<td>' . html_escape($closed_tickets) . '</td>
		// 			<td>' . html_escape($deactivated_tickets) . '</td>

					
		// 		</tr>';
		// 	}
		// } else {
		
//changes made by anjali 25/06/26 for make count clickable
				$encoded_emp_id = base64_encode($emp['employee_id']);

				/*
				======================================================
				Changes by Shawn Arakal - 28/07/2026 11:02
				Feature: Employee Ticket Performance (final architecture)
				======================================================
				*/
				// Resolution columns removed from the table. The View Stats button loads this
				// employee's performance on demand, so it only needs the employee id (the assignee
				// id used by the existing report API), the display name, and the current rank.
				$row_emp_id_attr = !empty($emp['employee_id'])
					? $emp['employee_id']
					: (!empty($emp['user_id'])
						? $emp['user_id']
						: (!empty($emp['emp_id']) ? $emp['emp_id'] : ""));
				$row_emp_name_attr = !empty($employee_name) ? $employee_name : "";

				$emp_html .= '
				<tr>
					<td>' . $sr++ . '</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'">
							'.html_escape($employee_name).'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'">
							'.$total_tickets.'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'&status=Open">
							'.$open_tickets.'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'&status=Reopened">
							'.$reopened_tickets.'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'&status=Resolved">
							'.$resolved_tickets.'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'&status=Closed">
							'.$closed_tickets.'
						</a>
					</td>

					<td>
						<a href="'.base_url().'vendor/customers/ticket_report?assigned_to='.$encoded_emp_id.'&status=Deactivated">
							'.$deactivated_tickets.'
						</a>
					</td>

					<td>
						<button type="button" class="btn btn-info btn-sm view-stats-btn" data-emp-id="'.html_escape($row_emp_id_attr).'" data-emp-name="'.html_escape($row_emp_name_attr).'" data-rank="'.($sr - 1).'">
							<i class="fa fa-bar-chart"></i> View Stats
						</button>
					</td>
				</tr>';
							}
		} else {
			$emp_html .= '
			<tr>
				<td colspan="6" class="text-center">
					No Data Found
				</td>
			</tr>';
		}

		$response = array();
		$response['ticket_html'] = $ticket_html;
		$response['employee_html'] = $emp_html;
		$response['data'] = $dataObj;
		$response['result'] = $result;

		/*
		======================================================
		Changes by Shawn Arakal - 28/07/2026 11:02
		Feature: Employee Ticket Performance (final architecture)
		======================================================
		*/
		// Performance payload removed from the initial response: the dashboard cards are gone and
		// the table no longer shows resolution columns, so only counts + the ranked employee_html
		// are needed. Detailed per-employee stats load on demand via get_employee_performance_details().

		$this->output->set_content_type('application/json');
		echo json_encode($response);
		exit;
	}

	/*
	======================================================
	Changes by Shawn Arakal - 28/07/2026 11:02
	Feature: Employee Ticket Performance (View Stats - on demand)
	======================================================
	*/
	// Returns the performance detail for a SINGLE employee, loaded only when View Stats is
	// clicked. Reuses the existing getTicketMasterReportDetails API scoped to this employee
	// (five => "Closed,Resolved", eight => employee id) so the initial report stays lightweight
	// and no per-employee history is preloaded. No cache of any kind is used.
	public function get_employee_performance_details()
	{
		if (!($this->check_access('customers', 'ticket_summary_report'))) {
			$this->output->set_status_header(403);
			$this->output->set_content_type('application/json');
			echo json_encode(array('status' => false, 'message' => 'Access denied'));
			exit;
		}

		$emp_id   = $this->input->post('emp_id');
		$emp_name = $this->input->post('emp_name');

		$stats = array(
			"avg_resolution"     => "N/A",
			"fastest_resolution" => "N/A",
			"slowest_resolution" => "N/A",
			"closed_tickets"     => 0,
			"resolved_tickets"   => 0
		);
		$history       = array();
		$measured_rows = array(); // only tickets with a measurable resolution (used for Top 3)

		$res_count   = 0;
		$res_sum     = 0;
		$res_fastest = null;
		$res_slowest = null;

		if (!empty($emp_id)) {
			// Dedicated BACKGROUND batch size for this single-employee scan; intentionally
			// separate from the UI pagination limit (MASTERS_PAGE_LIMIT / $this->perPage).
			$emp_page_size = 500;
			$emp_page      = 1;
			$emp_total     = null;
			$emp_max_pages = 1;

			do {
				$emp_params = array(
					"one"         => $this->_user_id,
					"two"         => $this->_user_branch_id,
					"three"       => $this->_user_company_id,
					"five"        => "Closed,Resolved",
					"six"         => "",
					"seven"       => "",
					"eight"       => $emp_id,
					"nine"        => "",
					"ten"         => "",
					"eleven"      => "",
					"twelve"      => "",
					"limit"       => $emp_page_size,
					"offset"      => $emp_page,
					"total_count" => ($emp_total === null ? Null : $emp_total),
				);

				$emp_result = $this->api->call_v_api('getTicketMasterReportDetails', $emp_params);
				$emp_rows   = !empty($emp_result['jsArray']) ? $emp_result['jsArray'] : array();

				if ($emp_total === null) {
					$emp_total = (isset($emp_result['total_count']) && $emp_result['total_count'] !== null)
						? (int)$emp_result['total_count']
						: count($emp_rows);
					$emp_max_pages = ($emp_page_size > 0 && $emp_total > 0) ? (int)ceil($emp_total / $emp_page_size) : 1;
				}

				foreach ($emp_rows as $t) {
					$assigned = "";
					if (!empty($t['tkt_sdate_n'])) { $assigned = $t['tkt_sdate_n']; }
					else if (!empty($t['ticket_date_n'])) { $assigned = $t['ticket_date_n']; }
					else if (!empty($t['ticket_date'])) { $assigned = $t['ticket_date']; }
					else if (!empty($t['tkt_sdate'])) { $assigned = $t['tkt_sdate']; }

					$closed = "";
					if (!empty($t['tkt_closed_date_n'])) { $closed = $t['tkt_closed_date_n']; }
					else if (!empty($t['tkt_closed_date'])) { $closed = $t['tkt_closed_date']; }
					else if (!empty($t['tkt_resolved_date_n'])) { $closed = $t['tkt_resolved_date_n']; }
					else if (!empty($t['tkt_resolved_date'])) { $closed = $t['tkt_resolved_date']; }

					$status     = !empty($t['ticket_status']) ? $t['ticket_status'] : (!empty($t['status']) ? $t['status'] : "");
					$status_key = strtolower($status);
					if ($status_key == "closed") { $stats['closed_tickets']++; }
					else if ($status_key == "resolved") { $stats['resolved_tickets']++; }

					$ticket_no = !empty($t['ticket_seq_id']) ? $t['ticket_seq_id'] : (!empty($t['ticket_id']) ? $t['ticket_id'] : "");

					// Notes (if available): no dedicated notes column exists in the API, so reuse the
					// ticket description/title when present; otherwise leave blank.
					$notes = !empty($t['ticket_desc']) ? $t['ticket_desc'] : (!empty($t['ticket_title']) ? $t['ticket_title'] : "");

					$res_days = null;
					$a_ts = !empty($assigned) ? strtotime($assigned) : false;
					$c_ts = !empty($closed) ? strtotime($closed) : false;
					if ($a_ts && $c_ts && $c_ts >= $a_ts) {
						$res_days = floor(($c_ts - $a_ts) / 86400);
					}

					if ($res_days !== null) {
						$res_count++;
						$res_sum += $res_days;
						if ($res_fastest === null || $res_days < $res_fastest) { $res_fastest = $res_days; }
						if ($res_slowest === null || $res_days > $res_slowest) { $res_slowest = $res_days; }
					}

					$row = array(
						"ticket_no"     => $ticket_no,
						"assigned_date" => $assigned,
						"closed_date"   => $closed,
						"resolution"    => ($res_days !== null) ? ($res_days . " day" . ($res_days == 1 ? "" : "s")) : "-",
						"res_days"      => $res_days,
						"status"        => $status,
						"notes"         => $notes
					);
					$history[] = $row;
					if ($res_days !== null) {
						$measured_rows[] = $row;
					}
				}

				$emp_page++;
			} while ($emp_page <= $emp_max_pages && !empty($emp_rows));
		}

		if ($res_count > 0) {
			$avg = $res_sum / $res_count;
			$stats['avg_resolution']     = round($avg, 1) . " day" . (round($avg, 1) == 1 ? "" : "s");
			$stats['fastest_resolution'] = $res_fastest . " day" . ($res_fastest == 1 ? "" : "s");
			$stats['slowest_resolution'] = $res_slowest . " day" . ($res_slowest == 1 ? "" : "s");
		}

		// Top 3 slowest (descending) and fastest (ascending) - only tickets with a measurable resolution.
		$slowest_sorted = $measured_rows;
		usort($slowest_sorted, function ($a, $b) {
			if ($a['res_days'] == $b['res_days']) { return 0; }
			return ($a['res_days'] < $b['res_days']) ? 1 : -1;
		});
		$fastest_sorted = $measured_rows;
		usort($fastest_sorted, function ($a, $b) {
			if ($a['res_days'] == $b['res_days']) { return 0; }
			return ($a['res_days'] < $b['res_days']) ? -1 : 1;
		});

		$response = array(
			"status"      => true,
			"employee"    => $emp_name,
			"stats"       => $stats,
			"history"     => $history,
			"top_slowest" => array_slice($slowest_sorted, 0, 3),
			"top_fastest" => array_slice($fastest_sorted, 0, 3)
		);

		$this->output->set_content_type('application/json');
		echo json_encode($response);
		exit;
	}

	// Ticket  Report  
	// public function ticket_report()
	// {
	// 	if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
	// 		redirect(get_module() . '/dashboard/access_denied');
	// 	}
	// 	$data['page_title']        = "All Ticket Report";
	// 	$data['status_list']       = array("Open", "Reopened", "Resolved", "Closed", "Deactivated");
	// 	$data['ticket_type_list']  = array("Ticket" => "One Time Tickets", "Servicing" => "Servicing Tickets");
	// 	$data['customer_list']     = $this->getCustomerMasterReportDetails();
	// 	$data['lead_list']         = $this->getCustomerLeadMasterReportDetails();
	// 	$data['employee_list']     = $this->getEmployeeDetails();
	// 	$this->loadViews(get_module() . '/customers/list_tickets', $data);
	// }
// changes done by anjali 25-6-26

	public function ticket_report()
{
    if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
        redirect(get_module() . '/dashboard/access_denied');
    }

    $assigned_to = $this->input->get('assigned_to');
    $status      = $this->input->get('status');

    $assigned_to = !empty($assigned_to)
        ? base64_decode($assigned_to)
        : '';

    $data['assigned_to'] = $assigned_to;
    $data['status']      = $status;

    $data['page_title']        = "All Ticket Report";
    $data['status_list']       = array("Open", "Assigned", "Reopened", "Resolved", "Closed", "Deactivated");
    $data['ticket_type_list']  = array("Ticket" => "One Time Tickets", "Servicing" => "Servicing Tickets");
    $data['customer_list']     = $this->getCustomerMasterReportDetails();
    $data['lead_list']         = $this->getCustomerLeadMasterReportDetails();
    // $data['employee_list']     = $this->getEmployeeDetails();
	$data['employee_list'] = $this->getTicketEmployeeDetails();

    $this->loadViews(get_module() . '/customers/list_tickets', $data);
}

	public function add_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Ticket";
		$data['action']          = "Add";
		$data['employee_list']   = $this->getEmployeeDetails();
		$data['priority_list']  = array("High", "Medium", "Low");

		$this->form_validation->set_rules('cust_type', 'Lead / Customer Type', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('ref_id', 'Lead / Customer', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

		$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

		$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_ticket', $data);
		} else {
			$post_data = $this->input->post(null, true);
			//echo "<pre/>"; print_r($post_data);die;

			$ticket_date =  $post_data['ticket_date'];

			$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
			$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

			$todaydate = strtoupper(date("d-M-Y"));

			$ref_id  = $post_data['ref_id'];
			$cust_type = $post_data['cust_type'];

			$cust_id = $cust_type == "Customers" ? $ref_id : Null;
			$clm_id  = $cust_type == "Leads" ? $ref_id : Null;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"seven" => "1",
				"eight" => "Ticket",
				"nine" => $post_data['tkt_title'],
				"ten" => $post_data['ticket_desc'],
				"eleven" => $post_data['ticket_priority'],
				"twelve" => $post_data['ticket_assign_to'],
				"thirteen" => $cust_id,
				"fourteen" => $clm_id,
				"sixteen" => $todaydate,
				"twentyone" => $date,
				"twentytwo" => $time,
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Ticket Added successfully ');
				redirect(get_module() . '/customers/ticket_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/ticket_report');
			}
		}
	}

	public function edit_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Edit Ticket Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];
					// echo "<pre/>"; print_r($data['details']);die;
					$data['action']          = "Edit";
					$data['id']              = $id;
					$data['employee_list']   = $this->getEmployeeDetails();
					$data['priority_list']   = array("High", "Medium", "Low");

					// $this->form_validation->set_rules('cust_type', 'Lead / Customer Type', 'required', array('required' => 'Select %s'));
					// $this->form_validation->set_rules('ref_id', 'Lead / Customer', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('tkt_title', 'Ticket Title', 'required|trim|max_length[100]');

					$this->form_validation->set_rules('ticket_desc', 'Ticket Description', 'max_length[500]');

					$this->form_validation->set_rules('ticket_date', 'Ticket Date', 'required');

					if ($this->form_validation->run() == FALSE) {
						$this->loadViews(get_module() . '/customers/add_edit_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);
						//echo "<pre/>"; print_r($post_data);die;

						$ticket_date =  $post_data['ticket_date'];

						$date = !empty($ticket_date) ? strtoupper(date("d-M-Y", strtotime($ticket_date))) : "";
						$time = !empty($ticket_date) ? date("h:i A", strtotime($ticket_date)) : "";

						$todaydate = strtoupper(date("d-M-Y"));

						$ref_id    = $post_data['ref_id'];
						$cust_type = $post_data['cust_type'];

						$ticket_type = $details[0]['tkt_type_name'];
						$ticket_type_id = $details[0]['tkt_type_id'];

						// $cust_id = $cust_type == "Customers" ? $ref_id : Null;
						// $clm_id  = $cust_type == "Leads" ? $ref_id : Null;

						if ($cust_type == "Customers") {
							$cust_id = $ref_id;
							$clm_id = null;
						} elseif ($cust_type == "Leads") {
							$cust_id = null;
							$clm_id = $ref_id;
						} else { // Others
							$cust_id = null;
							$clm_id = null;
						}

						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => $ticket_type_id,
							"seven" => $ticket_type,
							"eight" => $post_data['tkt_title'],
							"nine" => $post_data['ticket_desc'],
							"ten" => $post_data['ticket_priority'],
							"eleven" => $post_data['ticket_assign_to'],
							"twelve" => $cust_id,
							"thirteen" => $clm_id,
							"fifteen" => $todaydate,
							"twenty" => $date,
							"twentyone" => $time,
						);
						//echo "<pre/>"; print_r($params);die;
						$response = $this->api->call_v_api('setModifyTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Ticket Details Updated Successfully ');
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function assign_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Assign Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];

					$data['action']          = "Assign";
					$data['id']              = $id;
					$data['employee_list']   = $this->getEmployeeDetails();
					$data['priority_list']   = array("High", "Medium", "Low");

					$this->form_validation->set_rules('ticket_assign_to', 'Ticket Assigned To', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('ticket_priority', 'Ticket Priority', 'required', array('required' => 'Select %s'));
					$this->form_validation->set_rules('tkt_instruction', 'Ticket Instructions', 'max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/assign_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => "1",
							"seven" => "Ticket",
							"ten" => $post_data['ticket_assign_to'],
							"fourteen" => "Open",
							"fifteen" => $todaydate,
							"twenty" => $post_data['tkt_instruction'],

						);
						$response = $this->api->call_v_api('setReassignTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Ticket Assigned successfully ');
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}



	public function resolve_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Resolve Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "Resolve";
					$data['id']              = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Resolved",

						);

						$response = $this->api->call_v_api('setTicketReviewDetails', $params);

						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Ticket Resolved successfully ');
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function reopen_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Re-Open Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "Reopen";
					$data['id']              = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Reopened",

						);
						// echo "<pre>";print_r($params);die;
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);

						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Ticket Re-Opened successfully ');
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function close_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Close Ticket";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['action']          = "Close";
					$data['id']              = $id;

					$this->form_validation->set_rules('tkt_review', 'Ticket Review', 'required|trim|max_length[100]');
					$this->form_validation->set_rules('tkt_desc', 'Ticket Description', 'required|trim|max_length[500]');


					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/resolve_ticket', $data);
					} else {
						$post_data = $this->input->post(null, true);

						$ticket_image = null;

						if (!empty($_FILES['ticket_image']['name'])) {
							$ext = pathinfo($_FILES['ticket_image']['name'], PATHINFO_EXTENSION);
							$upload_params    = array();
							$imageFile        = $_FILES['ticket_image']['tmp_name'];
							$ticket_image          = "Ticket_Img_" . date("YmdHis") . "." . $ext;
							$img_file_content = file_get_contents($imageFile);
							$upload_params    = array(
								"one" => $this->_user_id,
								"two" => $this->_user_branch_id,
								"three" => $this->_user_company_id,
								"four" => $ticket_image,
								"five" => base64_encode($img_file_content),
								"six" => "Ticket_Review"
							);
							$response = $this->api->call_v_api('uploadBitmap', $upload_params);
						}
						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"seven" => $post_data['tkt_review'],
							"eight" => $post_data['tkt_desc'],
							"nine" => $ticket_image,
							"eleven" => "Closed",

						);
						$response = $this->api->call_v_api('setTicketReviewDetails', $params);
						if ($response[0]['status'] == "Success") {
							$this->session->set_flashdata('success', 'Ticket Closed successfully ');
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($id));
						}
					}
				}
			}
		}
	}

	public function deactivate_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		}
		$data['page_title']   = "Deactivate Ticket ";
		$data['input_title']  = "Ticket Deactivation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "deactivate_ticket";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/deactivation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateTicketMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Ticket Deactivated successfully ');
				redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_ticket/?id=' . base64_encode($ref_id));
			}
		}
	}
	public function download_ticket_report()
	{
		$ticket_type          = $this->input->post('ticket_type');
		$ticket_assign_to     = $this->input->post('ticket_assign_to');
		$customer_id          = $this->input->post('customer_id');
		$clm_id               = $this->input->post('clm_id');
		$status               = $this->input->post('status');
		$status               = $status ? $status : "";
		$searchStr_name       = $this->input->post('searchStr_name');
		$from_date            = $this->input->post('from_date');
		$to_date              = $this->input->post('to_date');
		$highlight_id         = $this->input->post('highlight_id');

		$searchStr_name = addslashes($searchStr_name);
		$to_date        = !empty($to_date) ? strtoupper(date("d-M-Y", strtotime($to_date))) : "";
		$from_date      = !empty($from_date) ? strtoupper(date("d-M-Y", strtotime($from_date))) : "";

		$ticket_assign_to   = $this->_user_id;
		$role_id            = $this->_role_id;
		if ($role_id == SUPER_ADMIN_ROLE_ID || $role_id == ADMIN_ROLE_ID) {

			$ticket_assign_to  = $this->input->post('ticket_assign_to');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $this->_user_branch_id,
		);
		$result = $this->api->call_v_api('downloadTicketMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Ticket_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function view_ticket()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Ticket Details";
		$id    = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Ticket Details not found');
			redirect(get_module() . '/customers/ticket_report');
		} else {
			$id = base64_decode($id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Ticket Details not found');
				redirect(get_module() . '/customers/ticket_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getTicketMasterDetails', $params);

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Ticket Details not found');
					redirect(get_module() . '/customers/ticket_report');
				} else {
					$data['details']  = $details[0];
					$data['roleId'] = $this->_role_id;
					$data['userId'] = $this->_user_id;

					// print_r($data['details']);
					// exit;

					$this->loadViews(get_module() . '/customers/view_ticket', $data);
				}
			}
		}
	}
	// Follow-Up  Report 
	public function followup_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Follow-Up Report";
		$data['status_list']       = array("Open" => "Following", "Closed" => "Closed");
		$data['employee_list']     = $this->getEmployeeDetails();
		$this->loadViews(get_module() . '/customers/list_followups', $data);
	}
	public function view_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Follow-Up Details";
		$id    = $this->input->get("id");
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
				$details = $this->api->call_v_api('getCustomerTicketMasterDetails', $params);
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
	public function assign_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Assign Follow-Up";
		$id         = $this->input->get("id");
		$cust_id    = $this->input->get("cust_id");
		$clm_id     = $this->input->get("clm_id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Follow-Up Details not found');
			redirect(get_module() . '/customers/followup_report');
		} else {
			$id      = base64_decode($id);
			$cust_id = base64_decode($cust_id);
			$clm_id  = base64_decode($clm_id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Follow-Up Details not found');
				redirect(get_module() . '/customers/followup_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
				);
				$details = $this->api->call_v_api('getFollowupMasterDetails', $params);
				if (empty($details)) {
					$this->session->set_flashdata('error', 'Follow-Up Details not found');
					redirect(get_module() . '/customers/followup_report');
				} else {
					$details = $details[0];

					$data['action']      = "assign_followup";
					$data['id']          = $id;
					$data['cust_id']     = $cust_id;
					$data['clm_id']      = $clm_id;
					$data['employee_list'] = $this->getEmployeeDetails();
					$this->form_validation->set_rules('ticket_assign_to', 'Ticket Assign To', 'required|trim|max_length[100]');
					if ($this->form_validation->run() == FALSE) {
						$this->load->view(get_module() . '/customers/assign_followup', $data);
					} else {
						$followupList = $details['followupList'][0];
						$followup_status        = $followupList['followup_status'];
						$followup_date_n        = $followupList['followup_date_n'];
						$followup_status_id     = $followupList['followup_status_id'];
						$followup_feedback      = $followupList['followup_feedback'];
						$followup_nxt_folldate_n   = $followupList['followup_nxt_folldate_n'];
						$followup_nxt_folltime_n   = $followupList['followup_nxt_folltime'];

						$todaydate = strtoupper(date("d-M-Y"));
						$params = array(
							"one" => $this->_user_id,
							"two" => $this->_user_branch_id,
							"three" => $this->_user_company_id,
							"four" => $this->_user_emp_id,
							"five" => $id,
							"six" => "3",
							"seven" => "Followup",
							"ten" => $this->input->post('ticket_assign_to', true),
							"eleven" => $cust_id,
							"twelve" => $clm_id,
							"fourteen" => $followup_status,
							"fifteen" => $followup_date_n,
							"sixteen" => $followup_status_id,
							"seventeen" => $followup_feedback,
							"eighteen" => $followup_nxt_folldate_n,
							"nineteen" => $followup_nxt_folltime_n,
						);
						// echo "<pre>";print_r($params);die;
						$response = $this->api->call_v_api('setReassignTicketMasterDetails', $params);
						if ($response == "Success") {
							$this->session->set_flashdata('success', 'Follow-Up Assigned successfully ');
							$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
							$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
							redirect(get_module() . '/customers/followup_report');
						} else {
							$this->session->set_flashdata('error', ERROR_MESSAGE);
							redirect(get_module() . '/customers/followup_report');
						}
					}
				}
			}
		}
	}

	public function add_followup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Add Follow-Up";
		$id         = $this->input->get("id");
		$cust_id    = $this->input->get("cust_id");
		$clm_id     = $this->input->get("clm_id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Follow-Up Details not found');
			redirect(get_module() . '/customers/followup_report');
		} else {
			$id = base64_decode($id);
			$cust_id = base64_decode($cust_id);
			$clm_id = base64_decode($clm_id);
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Follow-Up Details not found');
				redirect(get_module() . '/customers/followup_report');
			} else {
				$data['id']          = $id;
				$data['cust_id']     = $cust_id;
				$data['clm_id']      = $clm_id;
				$data['page_title']   = "Add Follow-Up ";
				$data['action']       = "add_followup";
				$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
				$this->form_validation->set_rules('followup_feedback', 'FollowUp Details', 'required|trim|max_length[250]');
				if ($this->form_validation->run() == FALSE) {
					$this->load->view(get_module() . '/customers/add_follwoup', $data);
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
						"thirteen" => $cust_id,
						"fourteen" => $clm_id,
						"sixteen" => $todaydate,
						"seventeen" => $this->input->post('followupstatusid', true),
						"eighteen" => $this->input->post('followup_feedback', true),
						"nineteen" => $date,
						"twenty" => $time,
						"twentythree" => $this->input->post('followupmedium', true),
						"twentyfive" => $this->input->post('followupfor', true),
					);
					//echo "<pre/>"; print_r($params);die;
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
		}
	}



	// Customer  Master 
	public function customer_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Customer Report";
		$data['status_list']       = array("Active", "Pending", "Deactivated");
		$data['service_type_list'] = $this->getServiceList();
		$data['payment_type_list'] = $this->getPayOptions();

		$this->loadViews(get_module() . '/customers/list_customer', $data);
	}

	public function add_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Add New Customer";
		$data['action']  	 = "Add";

		$data['service_list']       = $this->getServiceType();
		$data['cust_type_list']     = $this->getCustomerType();
		$data['gst_type_list']     = $this->getGSTType();
		$data['reference_list']   = $this->getReferencedBy();
		$data['state_list']       = $this->getStateDetails();
		$data['payment_mode_list']  = $this->getPaymentModes();
		$data['duration_list'] = $this->getDuartionList();



		$this->form_validation->set_rules('cust_service_type', 'Service Type', 'required|trim', array('required' => 'Select %s'));
		// $this->form_validation->set_rules('cust_gst_type','GST Type', 'required|trim',array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_type', 'Customer Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_gstno', 'GST No.', 'trim|max_length[15]');
		// $this->form_validation->set_rules('cust_name','Customer Name ', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_company_name', 'Company Name ', 'max_length[100]');
		$this->form_validation->set_rules('cust_contact_person', 'Contact Person', 'trim|max_length[100]');
		// $this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');			
		$this->form_validation->set_rules('alt_cust_contact', 'Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('cust_landline', 'Landline No.', 'trim|max_length[15]|numeric');
		// $this->form_validation->set_rules('cust_contact_email','Email Id.', 'max_length[100]|valid_email');		
		// $this->form_validation->set_rules('cust_address','Address', 'trim|max_length[1500]');
		// $this->form_validation->set_rules('cust_pincode','Pincode', 'trim|max_length[6]|min_length[6]|numeric');	

		$this->form_validation->set_rules('cust_service_det', 'Service Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_paid_amount', 'Total Paid Amount', 'trim|max_length[8]|numeric');
		// $this->form_validation->set_rules('cust_unit_no','Unit No', 'trim|max_length[50]');
		// $this->form_validation->set_rules('cust_form_no','Form No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_refbyname', 'Reference Name', 'trim|max_length[200]');
		$this->form_validation->set_rules('cust_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('cust_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');

		$this->form_validation->set_rules('company_cheque_bankname', 'Cheque Bank Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_dd_bank_name', 'DD Bank Name', 'trim|max_length[100]');

		$this->form_validation->set_rules('company_chequeno', 'Cheque Number', 'trim|max_length[6]|numeric');
		$this->form_validation->set_rules('company_dd_no', 'DD Number', 'trim|max_length[6]|numeric');
		$this->form_validation->set_rules('company_online_trxn_id', 'Transaction Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_payment_id', 'Payment Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_order_id', 'Order Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('cust_website', 'Website', 'trim|max_length[100]');
		$this->form_validation->set_rules('cust_remark', 'Remark', 'trim|max_length[1000]');
		/* if (empty($_FILES['cust_img']['name']))
			{
				$this->form_validation->set_rules('cust_img', 'Company Logo', 'required|trim');
			} */


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_customer', $data);
		} else {


			// 			// Validation passed, process the data
			// $installment_dates = $this->input->post('next_installment_date[]');
			// $installment_amounts = $this->input->post('next_installment_amount[]');

			// // Initialize variables to store the formatted data
			// $installment_date_str = '';
			// $installment_amount_str = '';

			// // Check if the installment dates are not empty
			// if (!empty($installment_dates)) {
			//     // Loop through the dates and amounts and prepare the comma-separated string
			//     foreach ($installment_dates as $index => $date) {
			//         // Format the date and append it to the date string
			//         $installment_date_str .= date('d-M-Y', strtotime($date)) . ',';

			//         // Append the corresponding installment amount to the amount string
			//         $installment_amount_str .= $installment_amounts[$index] . ',';
			//     }

			//     // Remove the trailing comma from both strings
			//     $installment_date_str = rtrim($installment_date_str, ',');
			//     $installment_amount_str = rtrim($installment_amount_str, ',');
			// }

			// // Calculate total installment amount by summing up the values from installment_amount_str
			// $installment_amounts_arr = explode(',', $installment_amount_str);
			// $total_installment_amount = array_sum($installment_amounts_arr);

			// // Now, let's retrieve the total price (cust_total_amount) from the UI input
			// $cust_total_amount = $this->input->post('cust_total_amount');  // Assuming you're getting the value from a POST request

			// // Output values for JavaScript use
			// echo '<script type="text/javascript">
			//     var total_installment_amount = ' . $total_installment_amount . ';
			//     var cust_total_amount = ' . $cust_total_amount . ';
			// </script>';
			// Validation passed, process the data
			$installment_dates = $this->input->post('next_installment_date[]');
			$installment_amounts = $this->input->post('next_installment_amount[]');
			$installment_start_dates = $this->input->post('next_installment_start_date[]');
			$installment_end_dates = $this->input->post('next_installment_end_date[]');

			// Initialize variables to store the formatted data
			$installment_date_str = '';
			$installment_amount_str = '';
			$installment_start_date_str = '';
			$installment_end_date_str = '';

			if (!empty($installment_dates)) {


				foreach ($installment_dates as $index => $date) {
					// Check if date is not empty and valid
					if (!empty($date) && strtotime($date) !== false) {
						$installment_date_str .= date('d-M-Y', strtotime($date)) . ',';
						// Append corresponding installment amount only if date is valid
						if (isset($installment_amounts[$index])) {
							$installment_amount_str .= $installment_amounts[$index] . ',';
						}
						if (isset($installment_start_dates[$index])) {
							$installment_start_date_str .= $installment_start_dates[$index] . ',';
						}
						if (isset($installment_end_dates[$index])) {
							$installment_end_date_str .= $installment_end_dates[$index] . ',';
						}
					}
				}

				// Remove trailing commas
				$installment_date_str = rtrim($installment_date_str, ',');
				$installment_amount_str = rtrim($installment_amount_str, ',');
				$installment_start_date_str = rtrim($installment_start_date_str, ',');
				$installment_end_date_str = rtrim($installment_end_date_str, ',');
				// print_r($installment_start_date_str);
				// exit;
			}

			// Calculate total installment amount by summing up the values from installment_amount_str
			$installment_amounts_arr = explode(',', $installment_amount_str);
			$total_installment_amount = array_sum($installment_amounts_arr);

			// Now, let's retrieve the total price (cust_total_amount) from the UI input
			$cust_total_amount = $this->input->post('cust_total_amount');  // Assuming you're getting the value from a POST request

			// Compare the total installment amount with the cust_total_amount
			if ($total_installment_amount != $cust_total_amount) {
				// If the total installment amount is not equal to the total price, show an error message
				echo '<span class="text-danger">Amount should be equal to Total Amount.</span>';
			} else {
				// If the amounts are equal, continue processing
				echo '<span class="text-success">Amounts match, proceeding with the payment.</span>';
			}


			$post_data      = $this->input->post(null, true);

			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;
			$cust_gst_type = !empty($post_data['cust_gst_type']) ? $post_data['cust_gst_type'] : Null;
			$cust_type     = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;
			$cust_gstno    = !empty($post_data['cust_gstno']) ? $post_data['cust_gstno'] : Null;
			$cust_name     = !empty($post_data['cust_name']) ? $post_data['cust_name'] : Null;
			$cust_website  = !empty($post_data['cust_website']) ? $post_data['cust_website'] : Null;
			$cust_id_num     = !empty($post_data['cust_id_num']) ? $post_data['cust_id_num'] : Null;
			$cust_panno     = !empty($post_data['cust_panno']) ? $post_data['cust_panno'] : Null;
			$alt_cust_contact = !empty($post_data['alt_cust_contact']) ? $post_data['alt_cust_contact'] : Null;
			$cust_state    = !empty($post_data['cust_state']) ? $post_data['cust_state'] : Null;
			$cust_dist     = !empty($post_data['cust_dist']) ? $post_data['cust_dist'] : Null;
			$cust_city     = !empty($post_data['cust_city']) ? $post_data['cust_city'] : Null;
			$p_company_portal     = !empty($post_data['p_company_portal']) ? $post_data['p_company_portal'] : "NO";
			$cust_company_name = !empty($post_data['cust_company_name']) ? $post_data['cust_company_name'] : "";
			$company_chequeimg = null;
			// $cust_pay_nxt_amt     = !empty($post_data['cust_pay_nxt_amt'])?$post_data['cust_pay_nxt_amt']:Null;
			// $cust_pay_nxt_dt     = !empty($post_data['cust_pay_nxt_dt'])?$post_data['cust_pay_nxt_dt']:Null;

			if (!empty($_FILES['company_chequeimg']['name'])) {
				$ext = pathinfo($_FILES['company_chequeimg']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['company_chequeimg']['tmp_name'];
				$company_chequeimg  = "Cheque_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $company_chequeimg,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_Cheque"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$company_dd_img = null;

			if (!empty($_FILES['company_dd_img']['name'])) {
				$ext = pathinfo($_FILES['company_dd_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['company_dd_img']['tmp_name'];
				$company_dd_img   = "DD_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $company_dd_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_DD"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}
			// Image Upload

			$cust_img     = null;
			if (!empty($_FILES['cust_img']['name'])) {
				$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['cust_img']['tmp_name'];
				$cust_img         = "CUST_IMG_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $cust_img,
					"five" => base64_encode($img_file_content),
					"six" => "Customers"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$company_pay_type     = !empty($post_data['company_pay_type']) ? $post_data['company_pay_type'] : Null;
			$company_type_id     = !empty($post_data['company_type_id']) ? $post_data['company_type_id'] : Null;

			$invoice_pattern_id     = !empty($post_data['invoice_pattern_id']) ? $post_data['invoice_pattern_id'] : Null;
			$cust_paid_amount     = !empty($post_data['cust_paid_amount']) ? round($post_data['cust_paid_amount']) : 0;
			$payment_gateway     = !empty($post_data['payment_gateway']) ? $post_data['payment_gateway'] : Null;
			$bank_name     = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
			$bank_acc_name     = !empty($post_data['bank_acc_name']) ? $post_data['bank_acc_name'] : Null;
			$bank_acc_number     = !empty($post_data['bank_acc_number']) ? $post_data['bank_acc_number'] : Null;
			$bank_branch_address     = !empty($post_data['bank_branch_address']) ? $post_data['bank_branch_address'] : Null;
			$bank_ifsc     = !empty($post_data['bank_ifsc']) ? $post_data['bank_ifsc'] : Null;
			$bank_micr     = !empty($post_data['bank_micr']) ? $post_data['bank_micr'] : Null;
			$company_chq_bounce_chrg     = !empty($post_data['company_chq_bounce_chrg']) ? $post_data['company_chq_bounce_chrg'] : Null;
			$company_chequeno     = !empty($post_data['company_chequeno']) ? $post_data['company_chequeno'] : Null;
			$company_cheque_bankname     = !empty($post_data['company_cheque_bankname']) ? $post_data['company_cheque_bankname'] : Null;
			$company_cheque_date     = !empty($post_data['company_cheque_date']) ? $post_data['company_cheque_date'] : Null;

			$company_dd_no     = !empty($post_data['company_dd_no']) ? $post_data['company_dd_no'] : Null;
			$company_dd_bank_name     = !empty($post_data['company_dd_bank_name']) ? $post_data['company_dd_bank_name'] : Null;
			$company_dd_date     = !empty($post_data['company_dd_date']) ? $post_data['company_dd_date'] : Null;

			$company_online_trxn_id  = !empty($post_data['company_online_trxn_id']) ? $post_data['company_online_trxn_id'] : Null;
			$company_payment_id    = !empty($post_data['company_payment_id']) ? $post_data['company_payment_id'] : Null;
			$company_order_id     = !empty($post_data['company_order_id']) ? $post_data['company_order_id'] : Null;
			$company_signature    = !empty($post_data['company_signature']) ? $post_data['company_signature'] : Null;

			$cust_contact_person = !empty($post_data['cust_contact_person']) ? $post_data['cust_contact_person'] : Null;

			$cust_contact    = !empty($post_data['cust_contact']) ? $post_data['cust_contact'] : Null;
			$cust_landline 	 = !empty($post_data['cust_landline']) ? $post_data['cust_landline'] : Null;
			$cust_contact_email 	 = !empty($post_data['cust_contact_email']) ? $post_data['cust_contact_email'] : Null;
			$cust_address 	 = !empty($post_data['cust_address']) ? $post_data['cust_address'] : Null;
			$cust_stateid 	 = !empty($post_data['cust_stateid']) ? $post_data['cust_stateid'] : Null;
			$cust_distid 	 = !empty($post_data['cust_distid']) ? $post_data['cust_distid'] : Null;
			$cust_cityid 	 = !empty($post_data['cust_cityid']) ? $post_data['cust_cityid'] : Null;
			$cust_area 	 = !empty($post_data['cust_area']) ? $post_data['cust_area'] : Null;
			$cust_pincode 	 = !empty($post_data['cust_pincode']) ? $post_data['cust_pincode'] : Null;
			$cust_service_det  = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount']) ? round($post_data['cust_total_amount']) : 0;
			$cust_unit_no  = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
			$cust_form_no  = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;
			$cust_ui_date  = !empty($post_data['cust_ui_date']) ? strtoupper(date("d-M-Y", strtotime($post_data['cust_ui_date']))) : strtoupper(date("d-M-Y"));
			$cust_refbyid  = !empty($post_data['cust_refbyid']) ? $post_data['cust_refbyid'] : Null;
			$cust_refbyname  = !empty($post_data['cust_refbyname']) ? $post_data['cust_refbyname'] : Null;
			$cust_refby_contact  = !empty($post_data['cust_refby_contact']) ? $post_data['cust_refby_contact'] : Null;
			$cust_refby_email  = !empty($post_data['cust_refby_email']) ? $post_data['cust_refby_email'] : Null;

			$cust_state  = !empty($post_data['cust_state']) ? $post_data['cust_state'] : Null;
			$cust_dist = !empty($post_data['cust_dist']) ? $post_data['cust_dist'] : Null;
			$cust_city  = !empty($post_data['cust_city']) ? $post_data['cust_city'] : Null;

			$service_id  = !empty($post_data['service_id']) ? $post_data['service_id'] : Null;
			$cust_service_id  = !empty($post_data['cust_service_id']) ? $post_data['cust_service_id'] : Null;
			$cust_pdt_qty  = !empty($post_data['cust_pdt_qty']) ? $post_data['cust_pdt_qty'] : Null;
			$cust_pdt_price  = !empty($post_data['cust_pdt_price']) ? $post_data['cust_pdt_price'] : Null;
			$cust_pdt_gst_price  = !empty($post_data['cust_pdt_gst_price']) ? $post_data['cust_pdt_gst_price'] : Null;
			$cust_pdt_gst  = !empty($post_data['cust_pdt_gst']) ? $post_data['cust_pdt_gst'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;
			$amc_duration  = !empty($post_data['amc_duration']) ? $post_data['amc_duration'] : Null;
			// Set validation rules for each installment input
			$this->form_validation->set_rules('next_installment_date[]', 'Installment Date', 'required|valid_date');
			$this->form_validation->set_rules('next_installment_amount[]', 'Installment Amount', 'required|numeric');
			$this->form_validation->set_rules('next_installment_start_date[]', 'Installment Start Date', 'required|valid_date');
			$this->form_validation->set_rules('next_installment_end_date[]', 'Installment End Date', 'required|valid_date');

			$cust_service_date_count = "";
			$cust_service_dates      = "";
			$service_ids             = "";
			if (!empty($service_id)) {
				foreach ($service_id as $id) {
					$date_var = "cust_service_dates_" . $id;
					if (!empty($post_data[$date_var])) {
						$cust_service_date_count = $cust_service_date_count . count($post_data[$date_var]) . ",";
						foreach ($post_data[$date_var] as $date) {
							$serv_date  = !empty($date) ? date("d-M-Y", strtotime($date)) : Null;
							$cust_service_dates      = $cust_service_dates . $serv_date . ",";
						}
					}
				}
				$service_ids          = implode(",", $service_id);
				$cust_deliver_address = implode(",", $cust_deliver_address);
				$cust_pdt_gst_price   = implode(",", $cust_pdt_gst_price);
				$cust_pdt_price       = implode(",", $cust_pdt_price);
				$cust_pdt_qty         = implode(",", $cust_pdt_qty);

				$cust_service_date_count = !empty($cust_service_date_count) ? substr($cust_service_date_count, 0, -1) : Null;
				$cust_service_dates      = !empty($cust_service_dates) ? substr($cust_service_dates, 0, -1) : Null;
			}

			$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;

			$lead_altcontactperson  = "";
			$lead_altcontact 		= "";
			$lead_altemail 			= "";

			if (!empty($alternate_contact_details)) {
				foreach ($alternate_contact_details as $contact) {
					$lead_altcontactperson = $lead_altcontactperson . $contact['lead_altcontactperson'] . ",";
					$lead_altcontact = $lead_altcontact . $contact['lead_altcontact'] . ",";
					$lead_altemail = $lead_altemail . $contact['lead_altemail'] . ",";
				}
			}
			$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
			$lead_altcontact  = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
			$lead_altemail    = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;

			$cust_dob         = !empty($post_data['cust_dob']) ? $post_data['cust_dob'] : Null;
			$cust_dob = !empty($cust_dob)
				? date('d-m-Y', strtotime($cust_dob))
				: NULL;

			$cust_remark = !empty($post_data['cust_remark']) ? $post_data['cust_remark'] : Null;



			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => NULL,
				"five" => $cust_name,
				"six" => $cust_company_name,
				"seven" => $cust_contact,
				"eight" => $alt_cust_contact,
				"nine" => $lead_altcontactperson,
				"ten" => $lead_altcontact,
				"eleven" => $lead_altemail,
				"twelve" => $cust_address,
				"thirteen" => $cust_website,
				"fourteen" => $cust_stateid,
				"fifteen" => $cust_distid,
				"sixteen" => $cust_cityid,
				"seventeen" => $cust_area,
				"eighteen" => $cust_gstno,
				"nineteen" => $cust_pincode,
				"twenty" => $cust_img,
				"twentyone" => $cust_refbyid,
				"twentytwo" => $cust_refbyname,
				"twentythree" => $cust_refby_contact,
				"twentyfour" => $cust_refby_email,
				"twentyfive" => NULL,
				"twentysix" => NULL,
				"twentyseven" => $cust_landline,
				"twentyeight" => $cust_type,
				"twentynine" => $cust_service_det,
				"thirty" => $cust_service_type,
				"thirtyone" => $service_ids,
				"thirtytwo" => $cust_deliver_address,
				"thirtythree" => $cust_pdt_qty,
				"thirtyfour" => $cust_pdt_gst_price,
				"thirtyfive" => NULL,
				"thirtysix" => $cust_service_dates,
				"thirtyseven" => $cust_service_date_count,
				"thirtyeight" => $cust_total_amount,
				"thirtynine" => $cust_gst_type,
				"fourty" => $cust_paid_amount,
				"fourtyone" => $cust_unit_no,
				"fourtytwo" => $cust_form_no,
				"fourtythree" => $cust_ui_date,
				"fourtyfour" => $cust_contact_person,
				"fourtyfive" => $cust_contact_email,
				"fourtysix" => $company_pay_type,
				"fourtyseven" => $company_chequeno,
				"fourtyeight" => $company_cheque_bankname,
				"fourtynine" => $company_cheque_date,
				"fifty" => $company_chequeimg,
				"fiftyone" => $company_dd_no,
				"fiftytwo" => $company_dd_bank_name,
				"fiftythree" => $company_dd_date,
				"fiftyfour" => $company_dd_img,
				"fiftyfive" => $company_online_trxn_id,
				"fiftysix" => $company_payment_id,
				"fiftyseven" => $company_order_id,
				"fiftyeight" => $company_signature,
				"fiftynine" => $cust_city,
				"sixty" => $cust_state,
				"sixtyone" => $cust_dist,
				"sixtytwo" => $installment_amount_str,
				"sixtythree" => $installment_date_str,
				"sixtyfour" => $installment_start_date_str,
				"sixtyfive" => $installment_end_date_str,
				"sixtysix" => $cust_dob,
				"sixtyseven" => $cust_remark,
				// "installment_amount" => $installment_amount, // Adding the installment data here
			);
			//   echo "<pre/>"; print_r( $params);die;
			$response = $this->api->call_v_api('setCustomerMasterDetails', $params);
			//log_message("error",json_encode($response));
			//log_message("error",json_encode($params));
			//  echo "<pre/>"; print_r( $response);die;
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'New Customer Added successfully !!');
				// redirect(get_module().'/customers/customer_report');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($response[0]['id']));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/customer_report');
			}
		}
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


	public function edit_customer()
	{


		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id  = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']  = "Update Customer Details";
		$data['action']  	 = "Edit";

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);

		// echo "<pre/>"; print_r( $params);die;
		// echo "<pre/>"; print_r($details);die;

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['details']  = $details[0];

		$data['service_list']       = $this->getServiceType();
		$data['cust_type_list']     = $this->getCustomerType();
		$data['gst_type_list']      = $this->getGSTType();
		$data['reference_list']     = $this->getReferencedBy();
		$data['state_list']         = $this->getStateDetails();
		$data['duration_list'] 		= $this->getDuartionList();

		$clm_stateid       = $details[0]['customer_state_id'];
		$clm_distid 	   = $details[0]['customer_dist_id'];
		$clm_cityid 	   = $details[0]['customer_city_id'];
		$data['dist_list'] = $this->getDistrictStateIdDetails($clm_stateid, "Report");
		$city_list         = $this->getCityDistrictIdDetails($clm_stateid, $clm_distid, "Report");
		$data['city_list'] = $city_list['jsArray'];
		$data['area_list'] = $this->getAreaCityIdDetails($clm_stateid, $clm_distid, $clm_cityid);

		// $this->form_validation->set_rules('cust_gstno','GST No.', 'trim|max_length[15]');
		$this->form_validation->set_rules('cust_name', 'Customer Name ', 'required|trim|max_length[100]');
		// $this->form_validation->set_rules('cust_company_name','Company Name ', 'max_length[100]');
		// $this->form_validation->set_rules('cust_contact_person','Contact Person', 'trim|max_length[100]');
		// $this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');	
		// $this->form_validation->set_rules('alt_cust_contact','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');			
		// $this->form_validation->set_rules('cust_landline','Landline No.', 'trim|max_length[15]|numeric');	
		// $this->form_validation->set_rules('cust_contact_email','Email Id.', 'max_length[100]|valid_email');		
		// $this->form_validation->set_rules('cust_address','Address', 'trim|max_length[1500]');
		// $this->form_validation->set_rules('cust_pincode','Pincode', 'trim|max_length[6]|min_length[6]|numeric');			

		// $this->form_validation->set_rules('cust_unit_no','Unit No', 'trim|max_length[50]');
		// $this->form_validation->set_rules('cust_form_no','Form No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_refbyname', 'Reference Name', 'trim|max_length[200]');
		$this->form_validation->set_rules('cust_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('cust_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');
		$this->form_validation->set_rules('cust_remark', 'Remark', 'trim|max_length[1000]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_customer', $data);
		} else {

			$post_data      = $this->input->post(null, true);

			// Image Upload
			$cust_img       = null;
			$cust_img       = $details[0]['cust_img_path'];
			$cust_img  	    = explode("/", $cust_img);
			$cust_img       = $cust_img[count($cust_img) - 1];

			if (!empty($_FILES['cust_img']['name'])) {
				$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['cust_img']['tmp_name'];
				$cust_img         = "CUST_IMG_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $cust_img,
					"five" => base64_encode($img_file_content),
					"six" => "Customers"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$cust_gstno    = !empty($post_data['cust_gstno']) ? $post_data['cust_gstno'] : Null;
			$cust_name     = !empty($post_data['cust_name']) ? $post_data['cust_name'] : Null;
			$cust_website  = !empty($post_data['cust_website']) ? $post_data['cust_website'] : Null;
			$alt_cust_contact = !empty($post_data['alt_cust_contact']) ? $post_data['alt_cust_contact'] : Null;

			$company_type_id     = !empty($post_data['company_type_id']) ? $post_data['company_type_id'] : Null;

			$invoice_pattern_id     = !empty($post_data['invoice_pattern_id']) ? $post_data['invoice_pattern_id'] : Null;
			$cust_paid_amount     = !empty($post_data['cust_paid_amount']) ? round($post_data['cust_paid_amount']) : 0;
			$payment_gateway     = !empty($post_data['payment_gateway']) ? $post_data['payment_gateway'] : Null;
			$bank_name     = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
			$bank_acc_name     = !empty($post_data['bank_acc_name']) ? $post_data['bank_acc_name'] : Null;
			$bank_acc_number     = !empty($post_data['bank_acc_number']) ? $post_data['bank_acc_number'] : Null;
			$bank_branch_address     = !empty($post_data['bank_branch_address']) ? $post_data['bank_branch_address'] : Null;
			$bank_ifsc     = !empty($post_data['bank_ifsc']) ? $post_data['bank_ifsc'] : Null;
			$bank_micr     = !empty($post_data['bank_micr']) ? $post_data['bank_micr'] : Null;

			$cust_id_num     = !empty($post_data['cust_id_num']) ? $post_data['cust_id_num'] : Null;
			$cust_panno      = !empty($post_data['cust_panno']) ? $post_data['cust_panno'] : Null;
			$p_company_portal     = !empty($post_data['p_company_portal']) ? $post_data['p_company_portal'] : "NO";
			$cust_company_name = !empty($post_data['cust_company_name']) ? $post_data['cust_company_name'] : "";

			$cust_contact_person = !empty($post_data['cust_contact_person']) ? $post_data['cust_contact_person'] : Null;
			$cust_contact    = !empty($post_data['cust_contact']) ? $post_data['cust_contact'] : Null;
			$cust_landline 	 = !empty($post_data['cust_landline']) ? $post_data['cust_landline'] : Null;
			$cust_contact_email 	 = !empty($post_data['cust_contact_email']) ? $post_data['cust_contact_email'] : Null;
			$cust_address 	 = !empty($post_data['cust_address']) ? $post_data['cust_address'] : Null;
			$cust_stateid 	 = !empty($post_data['cust_stateid']) ? $post_data['cust_stateid'] : Null;
			$cust_distid 	 = !empty($post_data['cust_distid']) ? $post_data['cust_distid'] : Null;
			$cust_cityid 	 = !empty($post_data['cust_cityid']) ? $post_data['cust_cityid'] : Null;
			$cust_area 	 = !empty($post_data['cust_area']) ? $post_data['cust_area'] : Null;
			$cust_pincode 	 = !empty($post_data['cust_pincode']) ? $post_data['cust_pincode'] : Null;
			$cust_service_det  = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;

			$cust_type     = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;
			$cust_unit_no  = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
			$cust_form_no  = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;
			$cust_ui_date  = !empty($post_data['cust_ui_date']) ? strtoupper(date("d-M-Y", strtotime($post_data['cust_ui_date']))) : strtoupper(date("d-M-Y"));
			$cust_refbyid  = !empty($post_data['cust_refbyid']) ? $post_data['cust_refbyid'] : Null;
			$cust_refbyname  = !empty($post_data['cust_refbyname']) ? $post_data['cust_refbyname'] : Null;
			$cust_refby_contact  = !empty($post_data['cust_refby_contact']) ? $post_data['cust_refby_contact'] : Null;
			$cust_refby_email  = !empty($post_data['cust_refby_email']) ? $post_data['cust_refby_email'] : Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount']) ? round($post_data['cust_total_amount']) : 0;
			$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;
			$cust_subs_startdate_n = !empty($post_data['cust_subs_startdate_n']) ? $post_data['cust_subs_startdate_n'] : Null;
			$cust_subs_enddate_n = !empty($post_data['cust_subs_enddate_n']) ? $post_data['cust_subs_enddate_n'] : Null;


			// =================================================================================================
			$service_id  = !empty($post_data['service_id']) ? $post_data['service_id'] : Null;
			$cust_service_id  = !empty($post_data['cust_service_id']) ? $post_data['cust_service_id'] : Null;

			$cust_service_date_count = "";
			$cust_service_dates      = "";
			$service_ids             = "";
			if (!empty($service_id)) {
				foreach ($service_id as $id1) {
					$date_var = "cust_serv_date_n" . $id1;
					if (!empty($post_data[$date_var])) {
						$cust_service_date_count = $cust_service_date_count . count($post_data[$date_var]) . ",";
						foreach ($post_data[$date_var] as $date) {
							$serv_date  = !empty($date) ? date("d-M-Y", strtotime($date)) : Null;
							$cust_service_dates      = $cust_service_dates . $serv_date . ",";
						}
					}
				}
				$service_ids          = implode(",", $service_id);


				$cust_service_date_count = !empty($cust_service_date_count) ? substr($cust_service_date_count, 0, -1) : Null;
				$cust_service_dates      = !empty($cust_service_dates) ? substr($cust_service_dates, 0, -1) : Null;
			}
			// ================================================================================



			$lead_altcontactperson  = "";
			$lead_altcontact 		= "";
			$lead_altemail 			= "";

			if (!empty($alternate_contact_details)) {
				foreach ($alternate_contact_details as $contact) {
					$lead_altcontactperson = $lead_altcontactperson . $contact['lead_altcontactperson'] . ",";
					$lead_altcontact = $lead_altcontact . $contact['lead_altcontact'] . ",";
					$lead_altemail = $lead_altemail . $contact['lead_altemail'] . ",";
				}
			}
			$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
			$lead_altcontact  = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
			$lead_altemail    = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;



			// $installment_dates = $this->input->post('next_installment_date[]');
			// $installment_amounts = $this->input->post('next_installment_amount[]');
			// $installment_start_dates = $this->input->post('next_installment_start_date[]');
			// $installment_end_dates = $this->input->post('next_installment_end_date[]');


			// // Initialize variables to store the formatted data
			// $installment_date_str = '';
			// $installment_amount_str = '';
			// $installment_start_date_str = '';
			// $installment_end_date_str = '';

			// if (!empty($installment_dates)) {


			// 	foreach ($installment_dates as $index => $date) {
			// 		// Check if date is not empty and valid
			// 		if (!empty($date) && strtotime($date) !== false) {
			// 			$installment_date_str .= date('d-M-Y', strtotime($date)) . ',';
			// 			// Append corresponding installment amount only if date is valid
			// 			if (isset($installment_amounts[$index])) {
			// 				$installment_amount_str .= $installment_amounts[$index] . ',';
			// 			}
			// 			if (isset($installment_start_dates[$index])) {
			// 				$installment_start_date_str .= $installment_start_dates[$index] . ',';
			// 			}
			// 			if (isset($installment_end_dates[$index])) {
			// 				$installment_end_date_str .= $installment_end_dates[$index] . ',';
			// 			}
			// 		}
			// 	}

			// 	// Remove trailing commas
			// 	$installment_date_str = rtrim($installment_date_str, ',');
			// 	$installment_amount_str = rtrim($installment_amount_str, ',');
			// 	$installment_start_date_str = rtrim($installment_start_date_str, ',');
			// 	$installment_end_date_str = rtrim($installment_end_date_str, ',');
			// }
			// // Calculate total installment amount by summing up the values from installment_amount_str
			// $installment_amounts_arr = explode(',', $installment_amount_str);
			// $total_installment_amount = array_sum($installment_amounts_arr);

			// Now, let's retrieve the total price (cust_total_amount) from the UI input
			// $cust_total_amount = $this->input->post('cust_total_amount');  // Assuming you're getting the value from a POST request


			//////////////////////////////	START	//////////////////////////////

			// $installment_ids = $this->input->post('installment_id[]');
			// $installment_dates = $this->input->post('next_installment_date[]');
			// $installment_amounts = $this->input->post('next_installment_amount[]');
			// $installment_start_dates = $this->input->post('next_installment_start_date[]');
			// $installment_end_dates = $this->input->post('next_installment_end_date[]');

			// // Initialize formatted data strings
			// $installment_date_str = '';
			// $installment_amount_str = '';
			// $installment_start_date_str = '';
			// $installment_end_date_str = '';
			// $installment_id_str = '';

			// if (!empty($installment_dates)) {
			// 	foreach ($installment_dates as $index => $date) {
			// 		if (!empty($date) && strtotime($date) !== false) {
			// 			$installment_date_str .= date('d-M-Y', strtotime($date)) . ',';
			// 			$installment_amount_str .= isset($installment_amounts[$index]) ? $installment_amounts[$index] . ',' : '';
			// 			$installment_start_date_str .= isset($installment_start_dates[$index]) ? $installment_start_dates[$index] . ',' : '';
			// 			$installment_end_date_str .= isset($installment_end_dates[$index]) ? $installment_end_dates[$index] . ',' : '';
			// 			$installment_id_str .= isset($installment_ids[$index]) ? $installment_ids[$index] . ',' : '';
			// 		}
			// 	}

			// 	// Remove trailing commas
			// 	$installment_date_str = rtrim($installment_date_str, ',');
			// 	$installment_amount_str = rtrim($installment_amount_str, ',');
			// 	$installment_start_date_str = rtrim($installment_start_date_str, ',');
			// 	$installment_end_date_str = rtrim($installment_end_date_str, ',');
			// 	$installment_id_str = rtrim($installment_id_str, ',');
			// }

			// // Ensure only numeric values are summed
			// $installment_amounts_arr = array_filter(explode(',', $installment_amount_str), 'is_numeric');
			// $total_installment_amount = array_sum($installment_amounts_arr);


			//////////////////////////////	END		/////////////////////////////



			$installment_dates = $this->input->post('next_installment_date[]');
			$installment_amounts = $this->input->post('next_installment_amount[]');
			$installment_start_dates = $this->input->post('next_installment_start_date[]');
			$installment_end_dates = $this->input->post('next_installment_end_date[]');

			// Initialize variables to store the formatted data
			$installment_date_str = '';
			$installment_amount_str = '';
			$installment_start_date_str = '';
			$installment_end_date_str = '';

			if (!empty($installment_dates)) {


				foreach ($installment_dates as $index => $date) {
					// Check if date is not empty and valid
					if (!empty($date) && strtotime($date) !== false) {
						$installment_date_str .= date('d-M-Y', strtotime($date)) . ',';
						// Append corresponding installment amount only if date is valid
						if (isset($installment_amounts[$index])) {
							$installment_amount_str .= $installment_amounts[$index] . ',';
						}
						if (isset($installment_start_dates[$index])) {
							$installment_start_date_str .= $installment_start_dates[$index] . ',';
						}
						if (isset($installment_end_dates[$index])) {
							$installment_end_date_str .= $installment_end_dates[$index] . ',';
						}
					}
				}

				// Remove trailing commas
				$installment_date_str = rtrim($installment_date_str, ',');
				$installment_amount_str = rtrim($installment_amount_str, ',');
				$installment_start_date_str = rtrim($installment_start_date_str, ',');
				$installment_end_date_str = rtrim($installment_end_date_str, ',');

				// echo "<pre/>"; print_r($installment_date_str);
				// echo "<pre/>"; print_r($installment_amount_str);
				// echo "<pre/>"; print_r($installment_start_date_str);
				// echo "<pre/>"; print_r($installment_end_date_str);die;
				// print_r($installment_start_date_str);
				// exit;
			}

			$cust_dob         = !empty($post_data['cust_dob']) ? $post_data['cust_dob'] : Null;
			$cust_dob = !empty($cust_dob)
				? date('d-m-Y', strtotime($cust_dob))
				: Null;


			$cust_remark      = !empty($post_data['cust_remark']) ? $post_data['cust_remark'] : Null;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $id,
				"six" => $cust_name,
				"seven" => $cust_company_name,
				"eight" => $cust_contact,
				"nine" => $alt_cust_contact,
				"ten" => $lead_altcontactperson,
				"eleven" => $lead_altcontact,
				"twelve" => $lead_altemail,
				"thirteen" => $cust_address,
				"fourteen" => $cust_website,
				"fifteen" => $cust_stateid,
				"sixteen" => $cust_distid,
				"seventeen" => $cust_cityid,
				"eighteen" => $cust_area,
				"nineteen" => $cust_gstno,
				"twenty" => $cust_pincode,
				"twentyone" => $cust_img,
				"twentytwo" => $cust_refbyid,
				"twentythree" => $cust_refbyname,
				"twentyfour" => $cust_refby_contact,
				"twentyfive" => $cust_refby_email,
				"twentysix" => NULL,
				"twentyseven" => NULL,
				"twentyeight" => $cust_landline,
				"twentynine" => $cust_type,
				"thirty" => $cust_service_det,
				"thirtyone" => $cust_unit_no,
				"thirtytwo" => $cust_form_no,
				"thirtythree" => $cust_ui_date,
				"thirtyfour" => $cust_contact_person,
				"thirtyfive" => $cust_contact_email,
				"thirtysix" => $service_ids,
				"thirtyseven" => $cust_service_dates,
				"thirtyeight" => $cust_service_date_count,
				"thirtynine" => $cust_subs_startdate_n,
				"fourty" => $cust_subs_enddate_n,
				"fourtyone" => $installment_amount_str,
				"fourtytwo" => $installment_date_str,
				"fourtythree" => $installment_start_date_str,
				"fourtyfour" => $installment_end_date_str,
				// "fourtyfive"=>$installment_id_str,
				"fourtysix" => $cust_dob,
				"fourtyseven" => $cust_remark,

			);

			$response = $this->api->call_v_api('setModifyCustomerMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'Customer Updated successfully !!');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
			}
		}
	}

	public function view_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "Customer Master Report";
		$id  = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		//echo "<pre/>"; print_r( $params);die;
		$details 		     = $this->api->call_v_api('getCustomerMasterDetails', $params);
		//echo "<pre/>"; print_r($details);die;
		$data['billpayment_details'] = $this->api->call_v_api('getClientBillPaymentDetails', $params);
		$data['subscription_details'] = $this->api->call_v_api('getClientSubscriptionDetails', $params);
		$data['subscription_serv_details'] = $this->api->call_v_api('getClientSubscriptionServiceDetails', $params);
		$data['serv_details'] = $this->api->call_v_api('getClientServiceDetails', $params);
		$data['ticket_details'] = $this->api->call_v_api('getCustomerTicketMasterDetails', $params);
		$data['invoice_details'] = $this->api->call_v_api('getCustomerInvoiceDetails', $params);

		$data['whatsappdeatils'] = $this->get_whatsapp_count();



		// print_r($data['serv_details']);
		// exit;

		// echo "<pre/>"; print_r( $details);die;
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['details']  = $details[0];
		$data['installment'] =  $details;
		// echo "<pre/>"; print_r( $data['installment']);die;
		$this->loadViews(get_module() . '/customers/view_customer', $data);
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



	public function view_my_details()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "My Details";
		$id  = $this->_user_company_id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details 		              = $this->api->call_v_api('getCustomerMasterDetails', $params);
		$data['billpayment_details']  = $this->api->call_v_api('getClientBillPaymentDetails', $params);
		$data['subscription_details'] = $this->api->call_v_api('getClientSubscriptionDetails', $params);
		$data['subscription_serv_details'] = $this->api->call_v_api('getClientSubscriptionServiceDetails', $params);
		$data['serv_details'] = $this->api->call_v_api('getClientServiceDetails', $params);
		$data['ticket_details'] = $this->api->call_v_api('getCustomerTicketMasterDetails', $params);
		$data['invoice_details'] = $this->api->call_v_api('getCustomerInvoiceDetails', $params);

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['details']  = $details[0];
		$this->loadViews(get_module() . '/customers/view_my_details', $data);
	}



	public function send_wp_msg()
	{
		$data['page_title']  = "Send Whats App Message";
		$id = $this->input->get("id");
		$key = APIKEY;
		$this->form_validation->set_rules('msg', 'Message', 'required|trim|max_length[50]');
		// $this->form_validation->set_rules('custcreditcount','Credit Count', 'required|trim|max_length[1000]');


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/send_message', $data);
		} else {
			if (!empty($_FILES['wp_image']['name'])) {
				$ext = pathinfo($_FILES['wp_image']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['wp_image']['tmp_name'];
				$wp_image          = "WA_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $wp_image,
					"five" => base64_encode($img_file_content),
					"six" => "WhatsAppImg"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$post_data      = $this->input->post(null, true);
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $post_data['wpnumber'],
				// "four"=>9579361008,
				"five" => $post_data['msg'],
				"six" => $wp_image,

			);
			//echo "<pre/>"; print_r( $params);die;	
			$response = $this->api->call_v_api('sendWhatsAppMsg', $params);
			// echo "<pre/>"; print_r($response);die;
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Message Send successfully !!');
				redirect(get_module() . '/customers/send_wp_msg');
			} elseif ($response == "Credit Null") {
				$this->session->set_flashdata('error', 'Whatsapp Credit Count is empty');
				redirect(get_module() . '/customers/send_wp_msg');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/send_wp_msg');
			}
		}
	}


	private function php_ini_size_to_bytes($value)
	{
		$value = trim((string) $value);
		if ($value === '') {
			return 0;
		}

		$unit = strtolower(substr($value, -1));
		$bytes = (float) $value;
		switch ($unit) {
			case 'g':
				$bytes *= 1024;
			case 'm':
				$bytes *= 1024;
			case 'k':
				$bytes *= 1024;
		}

		return (int) floor($bytes);
	}

	private function get_data_upload_max_size()
	{
		$max_file_size = 4 * 1024 * 1024;
		$php_upload_limit = $this->php_ini_size_to_bytes(ini_get('upload_max_filesize'));
		$php_post_limit = $this->php_ini_size_to_bytes(ini_get('post_max_size'));

		if ($php_upload_limit > 0) {
			$max_file_size = min($max_file_size, $php_upload_limit);
		}
		if ($php_post_limit > 0) {
			// Leave a small allowance for the multipart form boundary and fields.
			$max_file_size = min($max_file_size, max(1, $php_post_limit - (64 * 1024)));
		}

		return max(1, (int) $max_file_size);
	}

	private function format_data_upload_size($bytes)
	{
		if ($bytes >= 1024 * 1024) {
			$megabytes = $bytes / (1024 * 1024);
			return (floor($megabytes) == $megabytes ? (int) $megabytes : number_format($megabytes, 1)) . ' MB';
		}

		return max(1, (int) floor($bytes / 1024)) . ' KB';
	}

	private function get_data_upload_imports()
	{
		$module_path = get_module_path();
		$imports = array(
			'customer' => array(
				'title' => 'Customer Data',
				'description' => 'Import customer profiles, contact details and addresses.',
				'action' => $module_path . 'customers/upload_customer_data',
				'sample' => $module_path . 'customers/download_sample_data',
				'error_key' => 'error1',
				'icon' => 'fa-users',
				// Added by Anjali 14/07/26: Shows the AMC prerequisite and customer-specific checks before a customer import.
				'instructions' => array(
					'Before uploading Customer data, ensure that the corresponding AMC has already been added.',
					'Customer name and contact details should be filled before upload.'
				)
			),
			'lead' => array(
				'title' => 'Lead Data',
				'description' => 'Import new leads and their contact information.',
				'action' => $module_path . 'customers/upload_lead',
				'sample' => $module_path . 'customers/download_lead_data',
				'error_key' => 'error6',
				'icon' => 'fa-user-plus',
				// Added by Anjali 14/07/26: Keeps lead-only validation guidance inside the Lead Data card.
				'instructions' => array(
					'Lead name, contact number and lead source should be valid.'
				)
			),
			'amc' => array(
				'title' => 'AMC Data',
				'description' => 'Import annual maintenance contract records.',
				'action' => $module_path . 'customers/upload_amc',
				'sample' => $module_path . 'customers/download_amc_data',
				'error_key' => 'error2',
				'icon' => 'fa-calendar-check-o',
				// Added by Anjali 14/07/26: Shows the Brand prerequisite and AMC-specific checks before an AMC import.
				'instructions' => array(
					'Before uploading AMC data, ensure that the required Brand has already been added.',
					'Customer, product and contract dates should match existing records.',
					// Added by Anjali 17/07/26
					'Description field is optional. You may leave it blank if no description is available.',
					'Product field is optional. If provided, it must match an existing valid product.',
					'Duration must be entered in days (e.g., 6 months = 180, 1 year = 365, 2 years = 730).',
					'Check start and end dates before upload.'
				)
			),
			'ots' => array(
				'title' => 'OTS Data',
				'description' => 'Import one-time service records in bulk.',
				'action' => $module_path . 'customers/upload_ots',
				'sample' => $module_path . 'customers/download_ots_data',
				'error_key' => 'error3',
				'icon' => 'fa-wrench',
				// Added by Anjali 14/07/26: Shows the Brand prerequisite and service checks before an OTS import.
				'instructions' => array(
					'Before uploading One Time Service (OTS) data, ensure that the required Brand has already been added.',
					'Customer and service details should be available in the file.',
					'Description field is optional. You may leave it blank if no description is available.',
					'Product field is optional. If provided, it must match an existing valid product.',
					// Added by Anjali 17/07/26
				)
			),
			 
			'product' => array(
				'title' => 'Product Data',
				'description' => 'Import products, pricing and related details.',
				'action' => $module_path . 'customers/upload_product',
				'sample' => $module_path . 'customers/download_product_data',
				'error_key' => 'error4',
				'icon' => 'fa-cube',
				// Added by Anjali 14/07/26: Shows the Brand prerequisite and product checks before a Product import.
				'instructions' => array(
					'Before uploading Product data, ensure that the corresponding Brand has already been added.',
					'Product name, brand and pricing fields should be complete.',
					// Added by Anjali 17/07/26
				)
			),
			'brand' => array(
				'title' => 'Brand Data',
				'description' => 'Import product brands for your company catalogue.',
				'action' => $module_path . 'customers/upload_brand',
				'sample' => $module_path . 'customers/download_brand_data',
				'error_key' => 'error5',
				'icon' => 'fa-tags',
				// Added by Anjali 14/07/26: Keeps brand uniqueness guidance inside the Brand Data card.
				'instructions' => array(
					'Brand name should be clear and should not already exist.'
				)
			)
		);

		// Added by Anjali 17/07/26: Displays upload cards in the required dependency sequence.
		$upload_sequence = array('brand', 'product', 'amc', 'ots', 'lead', 'customer');
		$ordered_imports = array();
		foreach ($upload_sequence as $import_key) {
			$ordered_imports[$import_key] = $imports[$import_key];
		}
		$imports = $ordered_imports;

		foreach ($imports as $import_key => &$import) {
			$input_id = 'data_file_' . $import_key;
			$import['key'] = $import_key;
			$import['input_id'] = $input_id;
			$import['help_id'] = $input_id . '_help';
			$import['error_id'] = $input_id . '_error';
			$import['instruction_id'] = 'upload_instructions_' . $import_key;
			$import['form_attributes'] = array(
				'autocomplete' => 'off',
				'class' => 'upload-form',
				'data-import-title' => $import['title']
			);
		}
		unset($import);

		return $imports;
	}

	private function get_common_data_upload_instructions()
	{
		// Added by Anjali 14/07/26: Defines the validation, sample-file, and file-format rules shared by every data upload.
		return array(
			// 'Mobile Number must be exactly 10 digits.',
			// 'Do not include the country code (e.g., +91) in the Mobile Number.',
			// 'Do not enter spaces or special characters in the Mobile Number.',
			'Enter a valid 10-digit Mobile Number (without +91, spaces, or special characters).',
			'Date values must be entered in DD-MM-YYYY format only.',
			'Use the provided sample file and do not modify the column headers.',
			'Remove duplicate records before uploading to avoid import errors.',
			'Ensure that all mandatory fields are filled before uploading the file.',
			'Upload only supported file formats: .CSV, .XLS, or .XLSX.',

		);
	}

	private function normalise_data_upload_errors($raw_errors)
	{
		$decoded_errors = is_string($raw_errors) ? json_decode($raw_errors, true) : $raw_errors;

		if (!is_array($decoded_errors)) {
			return array(
				'rows' => array(),
				'message' => !empty($decoded_errors) ? (string) $decoded_errors : ''
			);
		}

		foreach (array('jsArray', 'errors', 'error', 'data', 'result') as $error_list_key) {
			if (isset($decoded_errors[$error_list_key]) && is_array($decoded_errors[$error_list_key])) {
				$decoded_errors = $decoded_errors[$error_list_key];
				break;
			}
		}

		if (isset($decoded_errors['exception_msg']) || isset($decoded_errors['message']) || isset($decoded_errors['exception_type'])) {
			$decoded_errors = array($decoded_errors);
		}

		$record_fields = array('cust_name', 'lead_name', 'product_name', 'brand_name', 'amc_name', 'ots_name', 'record_name', 'name');
		$rows = array();

		foreach ($decoded_errors as $error_item) {
			if (!is_array($error_item)) {
				$error_item = array('exception_msg' => (string) $error_item);
			}

			$record_name = '-';
			foreach ($record_fields as $record_field) {
				if (isset($error_item[$record_field]) && is_scalar($error_item[$record_field]) && $error_item[$record_field] !== '') {
					$record_name = (string) $error_item[$record_field];
					break;
				}
			}

			$error_type = !empty($error_item['exception_type']) && is_scalar($error_item['exception_type'])
				? (string) $error_item['exception_type']
				: 'Validation';
			$error_text = !empty($error_item['exception_msg']) && is_scalar($error_item['exception_msg'])
				? (string) $error_item['exception_msg']
				: (!empty($error_item['message']) && is_scalar($error_item['message'])
					? (string) $error_item['message']
					: 'This row could not be imported.');
			$line_number = isset($error_item['line_no']) && is_scalar($error_item['line_no']) && $error_item['line_no'] !== ''
				? (string) $error_item['line_no']
				: '-';

			$rows[] = array(
				'number' => count($rows) + 1,
				'record_name' => $record_name,
				'error_type' => $error_type,
				'error_text' => $error_text,
				'line_number' => $line_number
			);
		}

		return array('rows' => $rows, 'message' => '');
	}

	private function get_data_upload_page_messages($imports)
	{
		$success_message = $this->session->flashdata('success');
		$upload_error_message = $this->session->flashdata('upload_error');
		$active_upload = $this->session->flashdata('active_upload');
		$error_import_key = is_scalar($active_upload) && isset($imports[(string) $active_upload])
			? (string) $active_upload
			: '';
		$raw_errors = NULL;

		if ($error_import_key !== '') {
			$raw_errors = $this->session->flashdata($imports[$error_import_key]['error_key']);
		} else {
			foreach ($imports as $import_key => $import) {
				$stored_errors = $this->session->flashdata($import['error_key']);
				if ($stored_errors !== NULL) {
					$error_import_key = $import_key;
					$raw_errors = $stored_errors;
					break;
				}
			}
		}

		$normalised_errors = $this->normalise_data_upload_errors($raw_errors);
		if (!empty($normalised_errors['message']) && empty($upload_error_message)) {
			$upload_error_message = $normalised_errors['message'];
		}

		return array(
			'success_message' => is_scalar($success_message) ? (string) $success_message : '',
			'upload_error_message' => is_scalar($upload_error_message) ? (string) $upload_error_message : '',
			'error_import_key' => $error_import_key,
			'error_import_title' => $error_import_key !== '' ? $imports[$error_import_key]['title'] : '',
			'import_errors' => $normalised_errors['rows']
		);
	}

	private function render_upload_data_page()
	{
		$this->load->helper('form');

		$imports = $this->get_data_upload_imports();
		$data = $this->get_data_upload_page_messages($imports);

		foreach ($imports as &$import) {
			$import['has_error'] = $data['error_import_key'] === $import['key'];
		}
		unset($import);

		$data['page_title'] = 'Upload Data';
		$data['imports'] = $imports;
		// Added by Anjali 14/07/26: Supplies the shared upload instructions to the render-only PHP view.
		$data['common_instructions'] = $this->get_common_data_upload_instructions();
		$data['max_upload_bytes'] = $this->get_data_upload_max_size();
		$data['max_upload_label'] = $this->format_data_upload_size($data['max_upload_bytes']);
		$data['form_hidden'] = array('MAX_FILE_SIZE' => $data['max_upload_bytes']);
		$data['import_error_count'] = count($data['import_errors']);
		$data['page_styles'] = array('css/upload_customer_data.css');
		$data['page_scripts'] = array('js/upload_customer_data.js');

		$this->loadViews(get_module() . '/customers/upload_customer_data', $data);
	}

	private function redirect_upload_error($upload_type, $message)
	{
		$this->session->set_flashdata('active_upload', $upload_type);
		$this->session->set_flashdata('upload_error', $message);
		redirect(get_module() . '/customers/upload_customer_data');
	}

	private function detect_data_upload_mime($file_path)
	{
		$mime_type = '';

		if (function_exists('finfo_open')) {
			$file_info = finfo_open(FILEINFO_MIME_TYPE);
			if ($file_info !== false) {
				$detected_type = finfo_file($file_info, $file_path);
				finfo_close($file_info);
				if (is_string($detected_type)) {
					$mime_type = $detected_type;
				}
			}
		} elseif (function_exists('mime_content_type')) {
			$detected_type = mime_content_type($file_path);
			if (is_string($detected_type)) {
				$mime_type = $detected_type;
			}
		}

		$mime_parts = explode(';', strtolower(trim($mime_type)));
		return trim($mime_parts[0]);
	}

	private function validate_data_upload_structure($file_path, $extension)
	{
		$file_handle = @fopen($file_path, 'rb');
		if ($file_handle === false) {
			return 'The selected file could not be read. Please choose it again.';
		}

		$file_sample = fread($file_handle, 4096);
		fclose($file_handle);

		if ($extension === 'xlsx') {
			if (class_exists('ZipArchive')) {
				$archive = new ZipArchive();
				$open_result = $archive->open($file_path, ZipArchive::CHECKCONS);
				if ($open_result !== true) {
					return 'The XLSX file is damaged or is not a valid Excel workbook.';
				}

				$has_content_types = $archive->locateName('[Content_Types].xml', ZipArchive::FL_NOCASE) !== false;
				$has_workbook = $archive->locateName('xl/workbook.xml', ZipArchive::FL_NOCASE) !== false;
				$uncompressed_size = 0;
				$too_many_entries = $archive->numFiles > 2000;

				for ($file_index = 0; !$too_many_entries && $file_index < $archive->numFiles; $file_index++) {
					$file_details = $archive->statIndex($file_index);
					if (is_array($file_details) && isset($file_details['size'])) {
						$uncompressed_size += (int) $file_details['size'];
						if ($uncompressed_size > 100 * 1024 * 1024) {
							$too_many_entries = true;
						}
					}
				}
				$archive->close();

				if (!$has_content_types || !$has_workbook) {
					return 'The selected XLSX file is not a valid Excel workbook.';
				}
				if ($too_many_entries) {
					return 'The selected XLSX file is too complex to import safely.';
				}
			} elseif (substr($file_sample, 0, 2) !== 'PK') {
				return 'The selected XLSX file is not a valid Excel workbook.';
			}
		}

		if ($extension === 'xls') {
			$excel_signature = pack('H*', 'd0cf11e0a1b11ae1');
			if (substr($file_sample, 0, 8) !== $excel_signature) {
				return 'The selected XLS file is not a valid Excel workbook.';
			}
		}

		if ($extension === 'csv') {
			$binary_signatures = array(
				'MZ',
				"\x7fELF",
				'PK',
				pack('H*', 'd0cf11e0a1b11ae1'),
				'%PDF'
			);
			foreach ($binary_signatures as $binary_signature) {
				if (substr($file_sample, 0, strlen($binary_signature)) === $binary_signature) {
					return 'The selected CSV file contains unsupported binary data.';
				}
			}

			$has_utf16_bom = substr($file_sample, 0, 2) === "\xff\xfe" || substr($file_sample, 0, 2) === "\xfe\xff";
			if (!$has_utf16_bom && strpos($file_sample, "\0") !== false) {
				return 'The selected CSV file contains unsupported binary data.';
			}

			$text_sample = strtolower(ltrim($file_sample, "\xef\xbb\xbf \t\r\n"));
			if (strpos($text_sample, '<?php') === 0 || strpos($text_sample, '<!doctype html') === 0 || strpos($text_sample, '<html') === 0) {
				return 'The selected CSV file does not contain valid spreadsheet data.';
			}
		}

		return '';
	}

	private function validate_data_upload($field_name, &$mime_type)
	{
		$max_file_size = $this->get_data_upload_max_size();
		$max_file_size_label = $this->format_data_upload_size($max_file_size);
		$allowed_extensions = array('csv', 'xls', 'xlsx');
		$allowed_mime_types = array(
			'csv' => array(
				'text/plain',
				'text/csv',
				'text/x-csv',
				'application/csv',
				'application/x-csv',
				'text/comma-separated-values',
				'text/x-comma-separated-values',
				'application/vnd.ms-excel',
				'application/vnd.msexcel',
				'application/excel',
				'application/octet-stream'
			),
			'xls' => array(
				'application/vnd.ms-excel',
				'application/vnd.ms-office',
				'application/vnd.msexcel',
				'application/msexcel',
				'application/x-msexcel',
				'application/x-ms-excel',
				'application/x-excel',
				'application/x-dos_ms_excel',
				'application/xls',
				'application/x-xls',
				'application/excel',
				'application/x-ole-storage',
				'application/x-cdf',
				'application/cdfv2',
				'application/octet-stream'
			),
			'xlsx' => array(
				'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
				'application/vnd.ms-excel',
				'application/msword',
				'application/zip',
				'application/x-zip',
				'application/x-zip-compressed',
				'application/octet-stream'
			)
		);

		$mime_type = '';
		if (empty($_FILES[$field_name]) || !is_array($_FILES[$field_name])) {
			$content_length = (int) $this->input->server('CONTENT_LENGTH');
			$post_limit = $this->php_ini_size_to_bytes(ini_get('post_max_size'));
			if ($content_length > 0 && $post_limit > 0 && $content_length > $post_limit) {
				return 'The selected file is too large. Maximum allowed size is ' . $max_file_size_label . '.';
			}
			return 'Please choose a CSV, XLS or XLSX file to upload.';
		}

		$file = $_FILES[$field_name];
		if (!isset($file['name'], $file['tmp_name']) || is_array($file['name']) || is_array($file['tmp_name'])) {
			return 'Please upload one file at a time.';
		}

		$upload_error = isset($file['error']) ? (int) $file['error'] : UPLOAD_ERR_NO_FILE;
		if ($upload_error !== UPLOAD_ERR_OK) {
			switch ($upload_error) {
				case UPLOAD_ERR_INI_SIZE:
				case UPLOAD_ERR_FORM_SIZE:
					return 'The selected file is too large. Maximum allowed size is ' . $max_file_size_label . '.';
				case UPLOAD_ERR_PARTIAL:
					return 'The file was only partially uploaded. Please select it and try again.';
				case UPLOAD_ERR_NO_FILE:
					return 'Please choose a CSV, XLS or XLSX file to upload.';
				default:
					return 'The server could not receive the file. Please select it and try again.';
			}
		}

		$original_name = isset($file['name']) ? trim($file['name']) : '';
		$temp_path = isset($file['tmp_name']) ? $file['tmp_name'] : '';
		$file_size = isset($file['size']) ? (int) $file['size'] : 0;

		if ($original_name === '' || $temp_path === '' || !is_uploaded_file($temp_path) || !is_readable($temp_path)) {
			return 'The selected file is invalid. Please choose it again.';
		}

		if ($file_size <= 0) {
			return 'The selected file is empty. Please choose a file containing data.';
		}

		if ($file_size > $max_file_size) {
			return 'The selected file is too large. Maximum allowed size is ' . $max_file_size_label . '.';
		}

		$extension = strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
		if (!in_array($extension, $allowed_extensions, true)) {
			return 'Unsupported file type. Please choose a CSV, XLS or XLSX file.';
		}

		$structure_error = $this->validate_data_upload_structure($temp_path, $extension);
		if ($structure_error !== '') {
			return $structure_error;
		}

		$mime_type = $this->detect_data_upload_mime($temp_path);
		if ($mime_type !== '' && !in_array($mime_type, $allowed_mime_types[$extension], true)) {
			return 'The file content does not match its extension. Please use the downloaded sample format.';
		}

		if ($mime_type === '') {
			$mime_type = $extension === 'csv'
				? 'text/csv'
				: ($extension === 'xls'
					? 'application/vnd.ms-excel'
					: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		}

		return '';
	}

	private function process_data_upload($upload_type, $api_method, $error_key, $success_message, $success_redirect, $clear_dashboard_cache = false)
	{
		if ($this->input->method(true) !== 'POST') {
			redirect(get_module() . '/customers/upload_customer_data');
			return;
		}

		$mime_type = '';
		$validation_error = $this->validate_data_upload('data_file', $mime_type);
		if ($validation_error !== '') {
			$this->redirect_upload_error($upload_type, $validation_error);
			return;
		}

		$file = $_FILES['data_file'];
		$original_name = basename(str_replace('\\', '/', $file['name']));
		$safe_name = preg_replace('/[^a-zA-Z0-9._-]/', '_', $original_name);
		if ($safe_name === '' || $safe_name === '.' || $safe_name === '..') {
			$safe_name = 'import_data.' . strtolower(pathinfo($original_name, PATHINFO_EXTENSION));
		}

		$upload_file = new CURLFile($file['tmp_name'], $mime_type, $safe_name);
			$params = array(
			'user_id' => $this->_user_id,
			'user_branch_id' => $this->_user_branch_id,
			'user_company_id' => $this->_user_company_id,
			'file' => $upload_file
		);

		$result = $this->api->upload_v_excel($api_method, $params);
		unset($_FILES['data_file']);

		if ($result === false) {
			log_message('error', 'Data upload transport failed for ' . $api_method . '.');
			$this->redirect_upload_error($upload_type, 'The upload service is currently unavailable. Please try again in a few minutes.');
			return;
		}

		// Preserve the upload service's existing empty-response success contract,
		// after explicitly excluding cURL's boolean false failure above.
		$upload_succeeded = empty($result);
		if ($upload_succeeded) {
			$this->session->set_flashdata('success', $success_message);
			if ($clear_dashboard_cache) {
				$this->clearDashboardCompanyCache($this->_user_company_id);
			}
			redirect($success_redirect);
			return;
		}

		$this->session->set_flashdata('active_upload', $upload_type);
		if (is_array($result)) {
			$encoded_result = json_encode($result);
			if ($encoded_result === false) {
				$this->session->set_flashdata('upload_error', 'The file could not be imported. Verify it against the sample and try again.');
			} else {
				$this->session->set_flashdata($error_key, $encoded_result);
			}
		} else {
			$result_message = trim((string) $result);
			if ($result_message === '' || strlen($result_message) > 500) {
				$result_message = 'The file could not be imported. Verify it against the sample and try again.';
			}
			$this->session->set_flashdata('upload_error', $result_message);
		}
				redirect(get_module() . '/customers/upload_customer_data');
			}

	public function upload_customer_data()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		if ($this->input->method(true) === 'POST') {
			$this->process_data_upload(
				'customer',
				'uploadCustomer',
				'error1',
				'Customer data uploaded successfully.',
				get_module() . '/customers/customer_report',
				true
			);
			return;
		}

		$this->render_upload_data_page();
	}

	public function download_sample_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadCustomer', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="Customer_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function upload_brand()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$this->process_data_upload(
			'brand',
			'uploadBrand',
			'error5',
			'Brand data uploaded successfully.',
			get_module() . '/masters/brand_report'
		);
	}

	public function download_brand_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadBrandSample', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="Brand_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}


	public function upload_amc()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$this->process_data_upload(
			'amc',
			'uploadAMC',
			'error2',
			'AMC data uploaded successfully.',
			get_module() . '/masters/amc_report'
		);
	}

	public function download_amc_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadAMCsample', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="AMC_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function upload_ots()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$this->process_data_upload(
			'ots',
			'uploadOTS',
			'error3',
			'OTS data uploaded successfully.',
			get_module() . '/masters/one_time_service_report'
		);
	}

	public function download_ots_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadOTSsample', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="OTS_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}



	public function upload_product()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$this->process_data_upload(
			'product',
			'uploadProduct',
			'error4',
			'Product data uploaded successfully.',
			get_module() . '/masters/sale_product_report'
		);
	}

	//LEAD UPLOAD DATA		added by dhanraj .kakade 02/06/2024

	public function upload_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$this->process_data_upload(
			'lead',
			'uploadLead',
			'error6',
			'Lead data uploaded successfully.',
			get_module() . '/leads/lead_report'
		);
	}

	public function download_lead_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadLeadSample', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="Lead_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function download_product_data()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
		);
		$result = $this->api->download_v_excel('downloadProductSample', $params, "GET");
		// download file
		header('Content-Disposition: attachment; filename="Product_Sample_Data_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($result);
	}

	public function download_doc()
	{

		$url       = $this->input->get("url");
		$file_name = $this->input->get("file_name");
		$type = explode("/", $url);
		$type = $type[count($type) - 1];
		$extension = explode(".", $type);
		$extension = $extension[count($extension) - 1];
		$filename = $file_name . '_' . Date("Y-m-d-h-i-s") . '.' . $extension;
		$this->load->helper('download');
		$data = file_get_contents($url);
		force_download($filename, $data);
	}
	public function view_customer_subscriptions()
	{
		$data['page_title']  = "View Customer Services Details";
		$cust_id  = $this->input->get("cust_id");
		$sub_id  = $this->input->get("sub_id");
		$status  = $this->input->get("status");
		if (empty($cust_id) || empty($sub_id)) {
			$this->session->set_flashdata('error', 'Service Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$cust_id = base64_decode($cust_id);
		$sub_id = base64_decode($sub_id);
		if (!is_numeric($cust_id) || !is_numeric($sub_id)) {
			$this->session->set_flashdata('error', 'Service Details not found');
			redirect(get_module() . '/customers/customer_report');
		}

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
			"five" => $status,
			"six" => $sub_id,
		);
		$details = $this->api->call_v_api('getClientSubscriptionServiceDetails', $params);

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Service Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['details']  = $details[0];
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
		);
		$details = $this->api->call_v_api('getClientBillPaymentDetails', $params);
		$data['billPaymentList']  = $details[0];
		//echo "<pre/>"; print_r($data);die;
		$this->load->view(get_module() . '/customers/view_customer_subscriptions', $data);
	}

	public function add_customer_follwoup()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id  = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']   = "Add Customer Follow-Up ";
		$data['id']           = $id;
		$data['action']       = "add_customer_follwoup";
		$data['followup_list'] = array("1" => "No Need", "2" => "Pending", "3" => "Closed");
		$this->form_validation->set_rules('followup_feedback', 'FollowUp Details', 'required|trim|max_length[250]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/add_customer_follwoup', $data, true);
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
				"thirteen" => $id,
				"sixteen" => $todaydate,
				"seventeen" => $this->input->post('followupstatusid', true),
				"eighteen" => $this->input->post('followup_feedback', true),
				"nineteen" => $date,
				"twenty" => $time,
				"twentythree" => $this->input->post('followupmedium', true),
				"twentyfour" => $this->input->post('wpnumber', true),
				"twentyfive" => $this->input->post('followupfor', true),
			);
			//echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setTicketMasterDetails', $params);

			if ($response == "Success") {
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				$this->session->set_flashdata('success', 'Follow-Up Added successfully ');
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
			}
		}
	}

	public function confirm_lead()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}
		$data['page_title']   = "Confirm Lead ";
		$data['id']           = $ref_id;
		$data['action']       = "Confirm";
		$data['service_list']       = $this->getServiceType();
		$data['cust_type_list']     = $this->getCustomerType();
		$data['gst_type_list']     = $this->getGSTType();
		$data['reference_list']   = $this->getReferencedBy();
		$data['state_list']       = $this->getStateDetails();
		$data['payment_mode_list']  = $this->getPaymentModes();
		$data['duration_list'] 		= $this->getDuartionList();
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $ref_id
		);

		$details    = $this->api->call_v_api('getCustomerLeadMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Lead Details not found');
			redirect(get_module() . '/leads/lead_report');
		}

		if (!empty($details[0]['clm_custid'])) {

			$approve_params = array(
				"one"   => $details[0]['clm_id'],
				"two"   => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four"  => $this->_user_id
			);

			$approve_response = $this->api->call_v_api('setModifyLeadCustomer', $approve_params);

			if ($approve_response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', $approve_response[0]['message']);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($details[0]['clm_custid']));
			} else {
				$this->session->set_flashdata('error', $approve_response[0]['message']);
				redirect(get_module() . '/leads/view_lead/?id=' . base64_encode($details[0]['clm_id']));
			}
		}
		$newDetails = array();
		$details    = $details[0];
		$newDetails['customer_name'] = $details['clm_name'];
		$newDetails['cust_ref_contact'] = $details['clm_refby_contact'];
		$newDetails['cust_ref_email']   = $details['clm_refby_emailid'];
		$newDetails['cust_ref_id']      = $details['clm_refby'];
		$newDetails['cust_ref_name']    = $details['clm_refby_name'];

		$newDetails['cust_landline']           = $details['clm_landline'];
		$newDetails['customer_contact']        = $details['clm_contact'];
		$newDetails['customer_contact_email']  = $details['clm_contact_emailid'];
		$newDetails['customer_contact_person'] = $details['clm_contact_person'];

		$newDetails['customer_city_id']  = $details['clm_cityid'];
		$newDetails['customer_state_id'] = $details['clm_stateid'];
		$newDetails['customer_dist_id']  = $details['clm_distid'];
		$newDetails['customer_pin']      = $details['clm_pincode'];
		$newDetails['customer_address']  = $details['clm_address'];
		$newDetails['cust_website']      = isset($details['clm_website']) ? $details['clm_website'] : "";
		$newDetails['cust_dob'] 		 = $details['clm_dob'];
		$contactList = array();
		foreach ($details['contactList'] as $key => $contact) {
			$contactList[$key]['cust_contact_emailid'] = $contact['lead_cntct_email'];
			$contactList[$key]['cust_contact_no']      = $contact['lead_cntct_mob'];
			$contactList[$key]['cust_contact_person']  = $contact['lead_cntct_name'];
		}
		$newDetails['contactList']   = $contactList;

		$data['details'] = $newDetails;

		$clm_stateid       = $details['clm_stateid'];
		$clm_distid 	   = $details['clm_distid'];
		$clm_cityid 	   = $details['clm_cityid'];
		$data['dist_list'] = $this->getDistrictStateIdDetails($clm_stateid, "Report");
		$city_list         = $this->getCityDistrictIdDetails($clm_stateid, $clm_distid, "Report");
		$data['city_list'] = $city_list['jsArray'];
		$data['area_list'] = $this->getAreaCityIdDetails($clm_stateid, $clm_distid, $clm_cityid);

		$this->form_validation->set_rules('cust_service_type', 'Service Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_gst_type', 'GST Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_type', 'Customer Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_gstno', 'GST No.', 'trim|max_length[15]');
		$this->form_validation->set_rules('cust_name', 'Customer Name ', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_company_name', 'Company Name ', 'max_length[100]');
		$this->form_validation->set_rules('cust_contact_person', 'Contact Person', 'trim|max_length[100]');
		// $this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('alt_cust_contact', 'Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('cust_landline', 'Landline No.', 'trim|max_length[15]|numeric');
		$this->form_validation->set_rules('cust_contact_email', 'Email Id.', 'max_length[100]|valid_email');
		$this->form_validation->set_rules('cust_address', 'Address', 'trim|max_length[1500]');
		$this->form_validation->set_rules('cust_pincode', 'Pincode', 'trim|max_length[6]|min_length[6]|numeric');
		$this->form_validation->set_rules('cust_service_det', 'Service Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_paid_amount', 'Total Paid Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_unit_no', 'Unit No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_form_no', 'Form No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_refbyname', 'Reference Name', 'trim|max_length[200]');
		$this->form_validation->set_rules('cust_refby_contact', 'Reference Contact No.', 'trim|max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('cust_refby_email', 'Reference Email Id.', 'trim|max_length[100]|valid_email');
		$this->form_validation->set_rules('company_cheque_bankname', 'Cheque Bank Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_dd_bank_name', 'DD Bank Name', 'trim|max_length[100]');

		$this->form_validation->set_rules('company_chequeno', 'Cheque Number', 'trim|max_length[6]|numeric');
		$this->form_validation->set_rules('company_dd_no', 'DD Number', 'trim|max_length[6]|numeric');
		$this->form_validation->set_rules('company_online_trxn_id', 'Transaction Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_payment_id', 'Payment Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('company_order_id', 'Order Id', 'trim|max_length[100]');
		$this->form_validation->set_rules('cust_website', 'Website', 'trim|max_length[100]');

		/* 	if (empty($_FILES['cust_img']['name']))
			{
				$this->form_validation->set_rules('cust_img', 'Company Logo', 'required|trim');
			} */


		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_edit_customer', $data);
		} else {
			$post_data      = $this->input->post(null, true);

			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;
			$cust_gst_type = !empty($post_data['cust_gst_type']) ? $post_data['cust_gst_type'] : Null;
			$cust_type     = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;
			$cust_gstno    = !empty($post_data['cust_gstno']) ? $post_data['cust_gstno'] : Null;
			$cust_name     = !empty($post_data['cust_name']) ? $post_data['cust_name'] : Null;
			$cust_website  = !empty($post_data['cust_website']) ? $post_data['cust_website'] : Null;
			$cust_id_num      = !empty($post_data['cust_id_num']) ? $post_data['cust_id_num'] : Null;
			$cust_panno       = !empty($post_data['cust_panno']) ? $post_data['cust_panno'] : Null;
			$alt_cust_contact = !empty($post_data['alt_cust_contact']) ? $post_data['alt_cust_contact'] : Null;
			$p_company_portal     = !empty($post_data['p_company_portal']) ? $post_data['p_company_portal'] : "NO";
			$cust_company_name = !empty($post_data['cust_company_name']) ? $post_data['cust_company_name'] : "";
			$company_chequeimg = null;

			if (!empty($_FILES['company_chequeimg']['name'])) {
				$ext = pathinfo($_FILES['company_chequeimg']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['company_chequeimg']['tmp_name'];
				$company_chequeimg  = "Cheque_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $company_chequeimg,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_Cheque"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$company_dd_img = null;

			if (!empty($_FILES['company_dd_img']['name'])) {
				$ext = pathinfo($_FILES['company_dd_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['company_dd_img']['tmp_name'];
				$company_dd_img   = "DD_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $company_dd_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_DD"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			// Image Upload		
			$cust_img     = null;
			if (!empty($_FILES['cust_img']['name'])) {
				$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['cust_img']['tmp_name'];
				$cust_img         = "CUST_IMG_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $cust_img,
					"five" => base64_encode($img_file_content),
					"six" => "Customers"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$company_pay_type     = !empty($post_data['company_pay_type']) ? $post_data['company_pay_type'] : Null;
			$company_type_id     = !empty($post_data['company_type_id']) ? $post_data['company_type_id'] : Null;

			$invoice_pattern_id     = !empty($post_data['invoice_pattern_id']) ? $post_data['invoice_pattern_id'] : Null;
			$cust_paid_amount     = !empty($post_data['cust_paid_amount']) ? round($post_data['cust_paid_amount']) : 0;
			$payment_gateway     = !empty($post_data['payment_gateway']) ? $post_data['payment_gateway'] : Null;
			$bank_name     = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
			$bank_acc_name     = !empty($post_data['bank_acc_name']) ? $post_data['bank_acc_name'] : Null;
			$bank_acc_number     = !empty($post_data['bank_acc_number']) ? $post_data['bank_acc_number'] : Null;
			$bank_branch_address     = !empty($post_data['bank_branch_address']) ? $post_data['bank_branch_address'] : Null;
			$bank_ifsc     = !empty($post_data['bank_ifsc']) ? $post_data['bank_ifsc'] : Null;
			$bank_micr     = !empty($post_data['bank_micr']) ? $post_data['bank_micr'] : Null;
			$company_chq_bounce_chrg     = !empty($post_data['company_chq_bounce_chrg']) ? $post_data['company_chq_bounce_chrg'] : Null;
			$company_chequeno     = !empty($post_data['company_chequeno']) ? $post_data['company_chequeno'] : Null;
			$company_cheque_bankname     = !empty($post_data['company_cheque_bankname']) ? $post_data['company_cheque_bankname'] : Null;
			$company_cheque_date     = !empty($post_data['company_cheque_date']) ? $post_data['company_cheque_date'] : Null;

			$company_dd_no     = !empty($post_data['company_dd_no']) ? $post_data['company_dd_no'] : Null;
			$company_dd_bank_name     = !empty($post_data['company_dd_bank_name']) ? $post_data['company_dd_bank_name'] : Null;
			$company_dd_date     = !empty($post_data['company_dd_date']) ? $post_data['company_dd_date'] : Null;

			$company_online_trxn_id  = !empty($post_data['company_online_trxn_id']) ? $post_data['company_online_trxn_id'] : Null;
			$company_payment_id    = !empty($post_data['company_payment_id']) ? $post_data['company_payment_id'] : Null;
			$company_order_id     = !empty($post_data['company_order_id']) ? $post_data['company_order_id'] : Null;
			$company_signature    = !empty($post_data['company_signature']) ? $post_data['company_signature'] : Null;

			$cust_contact_person = !empty($post_data['cust_contact_person']) ? $post_data['cust_contact_person'] : Null;

			$cust_contact    = !empty($post_data['cust_contact']) ? $post_data['cust_contact'] : Null;
			$cust_landline 	 = !empty($post_data['cust_landline']) ? $post_data['cust_landline'] : Null;
			$cust_contact_email 	 = !empty($post_data['cust_contact_email']) ? $post_data['cust_contact_email'] : Null;
			$cust_address 	 = !empty($post_data['cust_address']) ? $post_data['cust_address'] : Null;
			$cust_stateid 	 = !empty($post_data['cust_stateid']) ? $post_data['cust_stateid'] : Null;
			$cust_distid 	 = !empty($post_data['cust_distid']) ? $post_data['cust_distid'] : Null;
			$cust_cityid 	 = !empty($post_data['cust_cityid']) ? $post_data['cust_cityid'] : Null;
			$cust_area 	 = !empty($post_data['cust_area']) ? $post_data['cust_area'] : Null;
			$cust_pincode 	 = !empty($post_data['cust_pincode']) ? $post_data['cust_pincode'] : Null;
			$cust_service_det  = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount']) ? round($post_data['cust_total_amount']) : 0;
			$cust_unit_no  = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
			$cust_form_no  = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;
			//$cust_ui_date  = !empty($post_data['cust_ui_date'])?date("d-M-Y",strtotime($post_data['cust_ui_date'])):Null;
			$cust_ui_date  = !empty($post_data['cust_ui_date']) ? strtoupper(date("d-M-Y", strtotime($post_data['cust_ui_date']))) : strtoupper(date("d-M-Y"));
			$cust_refbyid  = !empty($post_data['cust_refbyid']) ? $post_data['cust_refbyid'] : Null;
			$cust_refbyname  = !empty($post_data['cust_refbyname']) ? $post_data['cust_refbyname'] : Null;
			$cust_refby_contact  = !empty($post_data['cust_refby_contact']) ? $post_data['cust_refby_contact'] : Null;
			$cust_refby_email  = !empty($post_data['cust_refby_email']) ? $post_data['cust_refby_email'] : Null;


			$service_id  = !empty($post_data['service_id']) ? $post_data['service_id'] : Null;
			$cust_service_id  = !empty($post_data['cust_service_id']) ? $post_data['cust_service_id'] : Null;
			$cust_pdt_qty  = !empty($post_data['cust_pdt_qty']) ? $post_data['cust_pdt_qty'] : Null;
			$cust_pdt_price  = !empty($post_data['cust_pdt_price']) ? $post_data['cust_pdt_price'] : Null;
			$cust_pdt_gst_price  = !empty($post_data['cust_pdt_gst_price']) ? $post_data['cust_pdt_gst_price'] : Null;
			$cust_pdt_gst  = !empty($post_data['cust_pdt_gst']) ? $post_data['cust_pdt_gst'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;

			$cust_service_date_count = "";
			$cust_service_dates      = "";
			$service_ids             = "";
			if (!empty($service_id)) {
				foreach ($service_id as $id) {
					$date_var = "cust_service_dates_" . $id;
					if (!empty($post_data[$date_var])) {
						$cust_service_date_count = $cust_service_date_count . count($post_data[$date_var]) . ",";
						foreach ($post_data[$date_var] as $date) {
							$serv_date  = !empty($date) ? date("d-M-Y", strtotime($date)) : Null;
							$cust_service_dates      = $cust_service_dates . $serv_date . ",";
						}
					}
				}
				$service_ids          = implode(",", $service_id);
				$cust_deliver_address = implode(",", $cust_deliver_address);
				$cust_pdt_gst_price   = implode(",", $cust_pdt_gst_price);
				$cust_pdt_price       = implode(",", $cust_pdt_price);
				$cust_pdt_qty         = implode(",", $cust_pdt_qty);

				$cust_service_date_count = !empty($cust_service_date_count) ? substr($cust_service_date_count, 0, -1) : Null;
				$cust_service_dates      = !empty($cust_service_dates) ? substr($cust_service_dates, 0, -1) : Null;
			}

			$alternate_contact_details = !empty($post_data['group-b']) ? $post_data['group-b'] : Null;

			$lead_altcontactperson  = "";
			$lead_altcontact 		= "";
			$lead_altemail 			= "";

			if (!empty($alternate_contact_details)) {
				foreach ($alternate_contact_details as $contact) {
					$lead_altcontactperson = $lead_altcontactperson . $contact['lead_altcontactperson'] . ",";
					$lead_altcontact = $lead_altcontact . $contact['lead_altcontact'] . ",";
					$lead_altemail = $lead_altemail . $contact['lead_altemail'] . ",";
				}
			}
			$lead_altcontactperson = !empty($lead_altcontactperson) ? substr($lead_altcontactperson, 0, -1) : Null;
			$lead_altcontact  = !empty($lead_altcontact) ? substr($lead_altcontact, 0, -1) : Null;
			$lead_altemail    = !empty($lead_altemail) ? substr($lead_altemail, 0, -1) : Null;

			$cust_dob         = !empty($post_data['cust_dob']) ? $post_data['cust_dob'] : Null;
			$cust_dob = !empty($cust_dob)
				? date('d-m-Y', strtotime($cust_dob))
				: Null;

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id,
				"five" => $cust_name,
				"six" => $cust_company_name,
				"seven" => $cust_contact,
				"eight" => $alt_cust_contact,
				"nine" => $lead_altcontactperson,
				"ten" => $lead_altcontact,
				"eleven" => $lead_altemail,
				"twelve" => $cust_address,
				"thirteen" => $cust_website,
				"fourteen" => $cust_stateid,
				"fifteen" => $cust_distid,
				"sixteen" => $cust_cityid,
				"seventeen" => $cust_area,
				"eighteen" => $cust_gstno,
				"nineteen" => $cust_pincode,
				"twenty" => $cust_img,
				"twentyone" => $cust_refbyid,
				"twentytwo" => $cust_refbyname,
				"twentythree" => $cust_refby_contact,
				"twentyfour" => $cust_refby_email,
				"twentyfive" => NULL,
				"twentysix" => NULL,
				"twentyseven" => $cust_landline,
				"twentyeight" => $cust_type,
				"twentynine" => $cust_service_det,
				"thirty" => $cust_service_type,
				"thirtyone" => $service_ids,
				"thirtytwo" => $cust_deliver_address,
				"thirtythree" => $cust_pdt_qty,
				"thirtyfour" => $cust_pdt_gst_price,
				"thirtyfive" => NULL,
				"thirtysix" => $cust_service_dates,
				"thirtyseven" => $cust_service_date_count,
				"thirtyeight" => $cust_total_amount,
				"thirtynine" => $cust_gst_type,
				"fourty" => $cust_paid_amount,
				"fourtyone" => $cust_unit_no,
				"fourtytwo" => $cust_form_no,
				"fourtythree" => $cust_ui_date,
				"fourtyfour" => $cust_contact_person,
				"fourtyfive" => $cust_contact_email,
				"fourtysix" => $company_pay_type,
				"fourtyseven" => $company_chequeno,
				"fourtyeight" => $company_cheque_bankname,
				"fourtynine" => $company_cheque_date,
				"fifty" => $company_chequeimg,
				"fiftyone" => $company_dd_no,
				"fiftytwo" => $company_dd_bank_name,
				"fiftythree" => $company_dd_date,
				"fiftyfour" => $company_dd_img,
				"fiftyfive" => $company_online_trxn_id,
				"fiftysix" => $company_payment_id,
				"fiftyseven" => $company_order_id,
				"fiftyeight" => $company_signature,
				"sixtysix" => $cust_dob,
			);
			//echo "<pre/>"; print_r($params);die;
			//log_message("error",json_encode($params));
			$response = $this->api->call_v_api('setCustomerMasterDetails', $params);
			if ($response[0]['status'] == "Success") {
				$this->session->set_flashdata('success', 'Lead Confirmed successfully !!');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:lead_approval_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/customer_report');
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/customer_report');
			}
		}
	}

	public function approve_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']   = "Approve Customer ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "approve_customer";
		$data['status_list']  = array("Approved", "Rejected");
		$this->form_validation->set_rules('p_status', 'Status', 'required|trim|max_length[100]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/approve_customer', $data, true);
			echo $html;
		} else {
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $ref_id,
				"five" => $this->input->post('p_status', true),
			);
			$response = $this->api->call_v_api('setCustomerConfirmDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Customer Status Updated Successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:lead_approval_list:' .$this->_user_company_id .':*');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			}
		}
	}

	public function deactivate_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']   = "Deactivate Customer ";
		$data['input_title']  = "Customer Deactivation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "deactivate_customer";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/deactivation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateCustomerMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Customer Deactivated successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			}
		}
	}

	public function reactivate_customer()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$ref_id = base64_decode($ref_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']   = "Re-Activate Customer ";
		$data['input_title']  = "Customer Re-Activation ";
		$data['ref_id']       = $ref_id;
		$data['action']       = "reactivate_customer";
		$this->form_validation->set_rules('reason', 'Reason', 'required|trim|max_length[500]');
		if ($this->form_validation->run() == FALSE) {
			$html = $this->load->view(get_module() . '/customers/deactivation_popup', $data, true);
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
			$response = $this->api->call_v_api('setDeactivateCustomerMasterDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Customer Re-Activated successfully ');
				$this->cache->redis->deleteByPattern('ci_dashboard:todays_followup_list:' .$this->_user_company_id .':*');
				$this->cache->redis->deleteByPattern('ci_dashboard:my_followup_list:' .$this->_user_company_id .':*');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($ref_id));
			}
		}
	}

	// Payment  Report 
	public function payment_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Payment Report";
		$data['status_list']       = array("Active", "Deactivated");
		$data['service_type_list'] = $this->getServiceList();
		$this->loadViews(get_module() . '/customers/list_payment', $data);
	}

	public function add_customer_payment()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");
		$pay_id  = $this->input->get("pay_id");
		if (empty($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$ref_id = base64_decode($ref_id);
		$pay_id = base64_decode($pay_id);
		if (!is_numeric($ref_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}

		$data['page_title']      = "Add Payment";
		$data['action']          = "Customer";
		$data['ref_id']          = $ref_id;
		$data['pay_id']			= $pay_id;
		$data['customer_list']      = $this->getCustomerMasterReportDetails();
		$data['payment_mode_list']  = $this->getPaymentModes();
		$data['payment_intallments']		= $this->getPaymentinstallments($ref_id, $pay_id);
		$data['html_data']          = $this->get_customer_invoice_details01($ref_id);
		// $data['html_data']          =$data['html_data']['invoice_details'];

		// if(isset($data['html_data']['invoice_details'])) {
		// 	$data['html_data'] = $data['html_data']['invoice_details'];
		// }


		$data['details01']		= $data['html_data']['details'];

		// $html_data = $data['html_data'];
		// $data['html_data'] = $html_data['invoice_details'];
		// echo "<pre/>"; print_r($data['html_data']);die;
		// echo "<pre/>"; print_r($data['ref_id']);die;

		$this->form_validation->set_rules('cust_id', 'Customer', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cbpm_id', 'Invoice Id', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('pay_mode', 'Payment Mode', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('paying_ui_date', 'Paying Date', 'required');
		$this->form_validation->set_rules('ui_billno', 'Bill Book No', 'max_length[10]');
		$this->form_validation->set_rules('paying_amt', 'Paying Amount', 'required|trim|max_length[8]|numeric');
		$this->form_validation->set_rules('payment_terms', 'Paying Terms', 'max_length[100]');
		$this->form_validation->set_rules('payment_remark', 'Paying Remark', 'max_length[100]');
		$pay_mode = $this->input->post("pay_mode");
		if ($pay_mode == "Cheque") {
			$this->form_validation->set_rules('chq_bankname', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('chq_no', 'Cheque Number', 'required|trim|max_length[6]|numeric');
			$this->form_validation->set_rules('chq_bounce_chrg', 'Cheque Bounce Charges', 'max_length[6]|numeric');
			$this->form_validation->set_rules('chq_clear_status', 'Cheque Cleared Status', 'max_length[50]');
			$this->form_validation->set_rules('chq_date', 'Cheque Date', 'required|max_length[20]');

			if (empty($_FILES['chq_img']['name'])) {
				$this->form_validation->set_rules('chq_img', 'Cheque Image', 'trim');
			}
		}
		if ($pay_mode == "DD") {
			$this->form_validation->set_rules('dd_bankname', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('dd_no', 'DD Number', 'required|trim|max_length[6]|numeric');
			if (empty($_FILES['dd_img']['name'])) {
				$this->form_validation->set_rules('dd_img', 'DD Image', 'trim');
			}
		}
		if ($pay_mode == "Card") {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('bank_details', 'Bank Details', 'required|trim|max_length[100]');
		}
		// if($pay_mode == "Online" || $pay_mode == "Cash" ){
		// 	$this->form_validation->set_rules('remark','Remark', 'required|trim|max_length[100]');

		// }

		// echo "<pre/>"; print_r($data);die;
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_payment', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$chq_img = null;

			if (!empty($_FILES['chq_img']['name'])) {
				$ext = pathinfo($_FILES['chq_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['chq_img']['tmp_name'];
				$chq_img          = "Cheque_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $chq_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_Cheque"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$dd_img = null;

			if (!empty($_FILES['dd_img']['name'])) {
				$ext = pathinfo($_FILES['dd_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['dd_img']['tmp_name'];
				$dd_img   = "DD_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $dd_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_DD"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$cust_id = !empty($post_data['cust_id']) ? $post_data['cust_id'] : Null;
			// $cbpm_id = !empty($post_data['cbpm_id'])?$post_data['cbpm_id']:Null;
			$cbpm_id = !empty($post_data['cbpm_id_billno']) ? $post_data['cbpm_id_billno'] : Null;

			$billno = !empty($post_data['billno']) ? $post_data['billno'] : Null;
			$receiptno = !empty($post_data['receiptno']) ? $post_data['receiptno'] : Null;
			$ui_billno = !empty($post_data['ui_billno']) ? $post_data['ui_billno'] : Null;
			$pay_mode = !empty($post_data['pay_mode']) ? $post_data['pay_mode'] : Null;
			$paying_amt = !empty($post_data['paying_amt']) ? $post_data['paying_amt'] : Null;
			$discount = !empty($post_data['discount']) ? $post_data['discount'] : Null;

			$paying_ui_date = !empty($post_data['paying_ui_date']) ? $post_data['paying_ui_date'] : Null;
			$paying_ui_date  = !empty($paying_ui_date) ? date("d-M-Y", strtotime($paying_ui_date)) : Null;

			$bank_details = !empty($post_data['bank_details']) ? $post_data['bank_details'] : Null;
			$bank_name = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
			$remark = !empty($post_data['remark']) ? $post_data['remark'] : Null;
			$payment_terms = !empty($post_data['payment_terms']) ? $post_data['payment_terms'] : Null;
			$payment_remark = !empty($post_data['payment_remark']) ? $post_data['payment_remark'] : Null;
			$chq_bankname = !empty($post_data['chq_bankname']) ? $post_data['chq_bankname'] : Null;
			$chq_no = !empty($post_data['chq_no']) ? $post_data['chq_no'] : Null;

			$chq_date  = !empty($post_data['chq_date']) ? $post_data['chq_date'] : Null;
			$chq_date  = !empty($chq_date) ? date("d-M-Y", strtotime($chq_date)) : Null;

			$chq_bounce_chrg = !empty($post_data['chq_bounce_chrg']) ? $post_data['chq_bounce_chrg'] : Null;
			$chq_clear_status = !empty($post_data['chq_clear_status']) ? $post_data['chq_clear_status'] : Null;
			$dd_no = !empty($post_data['dd_no']) ? $post_data['dd_no'] : Null;
			$dd_bankname = !empty($post_data['dd_bankname']) ? $post_data['dd_bankname'] : Null;


			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $cbpm_id,
				"seven" => $billno,
				"eight" => $receiptno,
				"nine" => $ui_billno,
				"ten" => $pay_mode,
				"eleven" => $paying_amt,
				"twelve" => $discount,
				"thirteen" => $paying_ui_date,
				"fourteen" => $bank_details,
				"fifteen" => $bank_name,
				"sixteen" => $remark,
				"seventeen" => $payment_terms,
				"eighteen" => $payment_remark,
				"nineteen" => $chq_bankname,
				"twenty" => $chq_no,
				"twentyone" => $chq_img,
				"twentytwo" => $chq_date,
				"twentythree" => $chq_bounce_chrg,
				"twentyfour" => $chq_clear_status,
				"twentyfive" => $dd_no,
				"twentysix" => $dd_bankname,
				"twentyseven" => $dd_img,
				"thirtytwo" => $pay_id,
			);
			// echo "<pre/>"; print_r($params);die;
			$response = $this->api->call_v_api('setCustomerMasterPaymentDetails', $params);
			// log_message("error",json_encode($params));
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Payment Added successfully ');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}


	public function view_payment()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']  = "View Payment Details";
		$id    = $this->input->get("id");
		$billno    = $this->input->get("billno");
		// if(empty($id) || empty($billno) )
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Payment Details not found');
			redirect(get_module() . '/customers/payment_report');
		} else {
			$id     = base64_decode($id);
			// $billno = base64_decode($billno);

			// echo "<pre/>"; print_r( $id);
			// echo "<pre/>"; print_r( $billno);die;

			// if(!is_numeric($id) || !is_numeric($billno))
			// if(!is_numeric($id) || empty($billno))
			if (!is_numeric($id)) {
				$this->session->set_flashdata('error', 'Payment Details not found');
				redirect(get_module() . '/customers/payment_report');
			} else {

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $id,
					// "five"=>$billno,
				);
				$details = $this->api->call_v_api('getCustomerInvoiceDetails', $params);

				// echo "<pre/>"; print_r($details);die;	
				$allDetailList = [];
				$allPaymentList = [];

				foreach ($details as $invoice) {
					if (!empty($invoice['detailList'])) {
						foreach ($invoice['detailList'] as $d) {
							$allDetailList[] = $d;
						}
					}
				}

				foreach ($details as $invoice) {
					if (!empty($invoice['paymentList'])) {
						foreach ($invoice['paymentList'] as $d) {
							$allPaymentList[] = $d;
						}
					}
				}

				$data['details'] = $details;
				$data['allDetailList'] = $allDetailList;
				$data['allPaymentList'] = $allPaymentList;

				$data['ref_id']          = $id;

				// echo "<pre/>"; print_r($data);die;

				if (empty($details)) {
					$this->session->set_flashdata('error', 'Payment Details not found');
					redirect(get_module() . '/customers/payment_report');
				} else {
					// $data['details']           = $details[0];
					$this->loadViews(get_module() . '/customers/view_payment', $data);
				}
			}
		}
	}
	public function add_payment()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']      = "Add Payment";
		$data['action']          = "Add";
		$data['customer_list']   = $this->getCustomerMasterReportDetails();
		$data['payment_mode_list']  = $this->getPaymentModes();
		$this->form_validation->set_rules('cust_id', 'Customer', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cbpm_id', 'Invoice Id', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('pay_mode', 'Payment Mode', 'required', array('required' => 'Select %s'));
		$this->form_validation->set_rules('paying_ui_date', 'Paying Date', 'required');
		$this->form_validation->set_rules('ui_billno', 'Bill Book No', 'max_length[10]');
		$this->form_validation->set_rules('paying_amt', 'Paying Amount', 'required|trim|max_length[8]|numeric');
		$this->form_validation->set_rules('payment_terms', 'Paying Terms', 'max_length[100]');
		$this->form_validation->set_rules('payment_remark', 'Paying Remark', 'max_length[100]');
		$pay_mode = $this->input->post("pay_mode");
		if ($pay_mode == "Cheque") {
			$this->form_validation->set_rules('chq_bankname', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('chq_no', 'Cheque Number', 'required|trim|max_length[6]|numeric');
			$this->form_validation->set_rules('chq_bounce_chrg', 'Cheque Bounce Charges', 'max_length[6]|numeric');
			$this->form_validation->set_rules('chq_clear_status', 'Cheque Cleared Status', 'max_length[50]');
			$this->form_validation->set_rules('chq_date', 'Cheque Date', 'required|max_length[20]');

			if (empty($_FILES['chq_img']['name'])) {
				$this->form_validation->set_rules('chq_img', 'Cheque Image', 'trim');
			}
		}
		if ($pay_mode == "DD") {
			$this->form_validation->set_rules('dd_bankname', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('dd_no', 'DD Number', 'required|trim|max_length[6]|numeric');
			if (empty($_FILES['dd_img']['name'])) {
				$this->form_validation->set_rules('dd_img', 'DD Image', 'trim');
			}
		}
		if ($pay_mode == "Card") {
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('bank_details', 'Bank Details', 'required|trim|max_length[100]');
		}
		// if($pay_mode == "Online" || $pay_mode == "Cash" ){
		// 	$this->form_validation->set_rules('remark','Remark', 'trim|max_length[100]');

		// }
		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/add_payment', $data);
		} else {
			$post_data = $this->input->post(null, true);
			$chq_img = null;

			if (!empty($_FILES['chq_img']['name'])) {
				$ext = pathinfo($_FILES['chq_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['chq_img']['tmp_name'];
				$chq_img          = "Cheque_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $chq_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_Cheque"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$dd_img = null;

			if (!empty($_FILES['dd_img']['name'])) {
				$ext = pathinfo($_FILES['dd_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['dd_img']['tmp_name'];
				$dd_img   = "DD_Img_" . date("YmdHis") . "." . $ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $dd_img,
					"five" => base64_encode($img_file_content),
					"six" => "PAY_DD"
				);
				$response = $this->api->call_v_api('uploadBitmap', $upload_params);
			}

			$cust_id = !empty($post_data['cust_id']) ? $post_data['cust_id'] : Null;
			$cbpm_id = !empty($post_data['cbpm_id_billno']) ? $post_data['cbpm_id_billno'] : Null;
			$billno = !empty($post_data['billno']) ? $post_data['billno'] : Null;
			$receiptno = !empty($post_data['receiptno']) ? $post_data['receiptno'] : Null;
			$ui_billno = !empty($post_data['ui_billno']) ? $post_data['ui_billno'] : Null;
			$pay_mode = !empty($post_data['pay_mode']) ? $post_data['pay_mode'] : Null;
			$paying_amt = !empty($post_data['paying_amt']) ? $post_data['paying_amt'] : Null;
			$discount = !empty($post_data['discount']) ? $post_data['discount'] : Null;

			$paying_ui_date = !empty($post_data['paying_ui_date']) ? $post_data['paying_ui_date'] : Null;
			$paying_ui_date  = !empty($paying_ui_date) ? date("d-M-Y", strtotime($paying_ui_date)) : Null;

			$bank_details = !empty($post_data['bank_details']) ? $post_data['bank_details'] : Null;
			$bank_name = !empty($post_data['bank_name']) ? $post_data['bank_name'] : Null;
			$remark = !empty($post_data['remark']) ? $post_data['remark'] : Null;
			$payment_terms = !empty($post_data['payment_terms']) ? $post_data['payment_terms'] : Null;
			$payment_remark = !empty($post_data['payment_remark']) ? $post_data['payment_remark'] : Null;
			$chq_bankname = !empty($post_data['chq_bankname']) ? $post_data['chq_bankname'] : Null;
			$chq_no = !empty($post_data['chq_no']) ? $post_data['chq_no'] : Null;

			$chq_date  = !empty($post_data['chq_date']) ? $post_data['chq_date'] : Null;
			$chq_date  = !empty($chq_date) ? date("d-M-Y", strtotime($chq_date)) : Null;

			$chq_bounce_chrg = !empty($post_data['chq_bounce_chrg']) ? $post_data['chq_bounce_chrg'] : Null;
			$chq_clear_status = !empty($post_data['chq_clear_status']) ? $post_data['chq_clear_status'] : Null;
			$dd_no = !empty($post_data['dd_no']) ? $post_data['dd_no'] : Null;
			$dd_bankname = !empty($post_data['dd_bankname']) ? $post_data['dd_bankname'] : Null;


			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $cbpm_id,
				"seven" => $billno,
				"eight" => $receiptno,
				"nine" => $ui_billno,
				"ten" => $pay_mode,
				"eleven" => $paying_amt,
				"twelve" => $discount,
				"thirteen" => $paying_ui_date,
				"fourteen" => $bank_details,
				"fifteen" => $bank_name,
				"sixteen" => $remark,
				"seventeen" => $payment_terms,
				"eighteen" => $payment_remark,
				"nineteen" => $chq_bankname,
				"twenty" => $chq_no,
				"twentyone" => $chq_img,
				"twentytwo" => $chq_date,
				"twentythree" => $chq_bounce_chrg,
				"twentyfour" => $chq_clear_status,
				"twentyfive" => $dd_no,
				"twentysix" => $dd_bankname,
				"twentyseven" => $dd_img,
			);
			// echo "<pre/>"; print_r($params);die;		
			$response = $this->api->call_v_api('setCustomerMasterPaymentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Payment Added successfully ');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				$this->cache->redis->deleteByPattern('ci_dashboard:cheque_reminder_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}


	public function clear_cheque()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$cust_id  = $this->input->post("cust_id");
		$cbpm_id  = $this->input->post("cbpm_id");
		$billno  = $this->input->post("billno");
		$receiptno  = $this->input->post("receiptno");
		$cp_id  = $this->input->post("cp_id");
		if (empty($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$cust_id = base64_decode($cust_id);
		if (!is_numeric($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		if (empty($cbpm_id) || empty($billno) || empty($receiptno) || empty($cp_id)) {

			$this->session->set_flashdata('error', "Invalid Form Input");
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $cbpm_id,
				"seven" => $billno,
				"eight" => $receiptno,
				"nine" => $cp_id,
				"ten" => $this->_user_id,
			);
			$response = $this->api->call_v_api('setClearChequeCustomerMasterPaymentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Cheque Cleared successfully ');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				$this->cache->redis->deleteByPattern('ci_dashboard:cheque_reminder_list:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}

	public function clear_online_payment()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$cust_id  = $this->input->post("cust_id");
		$cbpm_id  = $this->input->post("cbpm_id");
		$billno  = $this->input->post("billno");
		$receiptno  = $this->input->post("receiptno");
		$cp_id  = $this->input->post("cp_id");
		if (empty($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$cust_id = base64_decode($cust_id);
		if (!is_numeric($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		if (empty($cbpm_id) || empty($billno) || empty($receiptno) || empty($cp_id)) {

			$this->session->set_flashdata('error', "Invalid Form Input");
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $cbpm_id,
				"seven" => $billno,
				"eight" => $receiptno,
				"nine" => $cp_id,
				"ten" => $this->_user_id,
			);
			$response = $this->api->call_v_api('setClearOnlinePayCustomerMasterPaymentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Payment Cleared successfully ');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}

	public function cancel_payment()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$cust_id  = $this->input->post("cust_id");
		$cbpm_id  = $this->input->post("cbpm_id");
		$billno  = $this->input->post("billno");
		$receiptno  = $this->input->post("receiptno");
		$cp_id  = $this->input->post("cp_id");
		if (empty($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$cust_id = base64_decode($cust_id);
		if (!is_numeric($cust_id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		if (empty($cbpm_id) || empty($billno) || empty($receiptno) || empty($cp_id)) {

			$this->session->set_flashdata('error', "Invalid Form Input");
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
		} else {

			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $this->_user_emp_id,
				"five" => $cust_id,
				"six" => $cbpm_id,
				"seven" => $billno,
				"eight" => $receiptno,
				"nine" => $cp_id,
			);
			$response = $this->api->call_v_api('setCancelCustomerMasterPaymentDetails', $params);
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Payment Cancelled successfully ');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}

	public function download_customer_report()
	{
		$service_type         = $this->input->post('service_type');
		$status               = $this->input->post('status');
		$status               = $status ? $status : "";

		$searchStr_name       = $this->input->post('searchStr_name');
		$searchStr_contact    = $this->input->post('searchStr_contact');
		$searchStr_cust_id    = $this->input->post('searchStr_cust_id');
		$gst    = $this->input->post('gst');

		$searchStr_name       = addslashes($searchStr_name);
		$searchStr_contact    = addslashes($searchStr_contact);
		$searchStr_cust_id    = addslashes($searchStr_cust_id);

		// print_r($gst);
		// exit;

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $status,
			"five" => $this->_user_branch_id,
			"twelve" => $gst
			/* "six"=>$searchStr_name,
			"seven"=>$searchStr_contact, 
			"eight"=>$searchStr_cust_id,
			"nine"=>$service_type, */
		);

		$lead_details = $this->api->call_v_api('downloadCustomerMasterDetails', $params);
		// download file
		header('Content-Disposition: attachment; filename="Customer_Report_' . Date("Y-m-d-h-i-s") . '.xlsx"');
		header("Content-Type: text/csv");
		echo ($lead_details);
	}

	public function download_invoice_installment()
	{

		$cbpi_pay_next_date = $this->input->get('pay_next_date');
		$cbpi_pay_next_amount = $this->input->get('pay_next_amount');

		// You can now use these parameters
		// print_r($cbpi_pay_next_date);
		// print_r($cbpi_pay_next_amount);
		// exit;
		$inst_id = $this->input->get("instId");
		// print_r($inst_id);
		// exit;
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");


		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		$inst_id = base64_decode($inst_id);
		$billno = base64_decode($billno);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$details = $details[0];
		$customer_name = $details['customer_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
			"six" => $cbpi_pay_next_date,
			"seven" => $cbpi_pay_next_amount,
			"eight" => $inst_id
		);

		// echo "<pre/>"; print_r( $params);die;

		$response = $this->api->call_v_api('downloadCustomerInvoiceDetails', $params);
		/* echo "<pre/>";print_r($response);
		echo "<pre/>";print_r($params);
		die; */
		// download file
		header('Content-Disposition: attachment; filename="' . $customer_name . '_Invoice_' . Date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}


	public function create_invoice()
	{

		$cbpi_pay_next_date = $this->input->get('pay_next_date');
		$cbpi_pay_next_amount = $this->input->get('pay_next_amount');

		// You can now use these parameters
		// print_r($cbpi_pay_next_date);
		// print_r($cbpi_pay_next_amount);
		// exit;
		$inst_id = $this->input->get("instId");
		// print_r($inst_id);
		// exit;
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");
		if (empty($id) || empty($inst_id)) {
			$this->session->set_flashdata('error', 'Customer Details.... not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		$inst_id = base64_decode($inst_id);
		if (!is_numeric($id) || !is_numeric($inst_id)) {
			$this->session->set_flashdata('error', 'Customer Details/////// not found');
			redirect(get_module() . '/customers/customer_report');
		}
		// $params = array("one"=>$this->_user_id,
		// 					"two"=>$this->_user_branch_id,
		// 					"three"=>$this->_user_company_id,
		// 					"four"=>$id);
		// 	$details = $this->api->call_v_api('getCustomerMasterDetails',$params);	
		// if(empty($details)){
		// 	$this->session->set_flashdata('error', 'Customer Details not found');
		// 	redirect(get_module().'/customers/customer_report');
		// }
		// $details = $details[0];		
		// $customer_name = $details['customer_name'];	
		// $customer_name = strtolower(str_ireplace(" ","_",$customer_name));		
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
			"six" => $cbpi_pay_next_date,
			"seven" => $cbpi_pay_next_amount,
			"eight" => $inst_id
		);
		// echo "<pre/>"; print_r( $params);die;
		$response = $this->api->call_v_api('setCustomerInstallmentInvoiceDetails', $params);
		/* echo "<pre/>";print_r($response);
		echo "<pre/>";print_r($params);
		die; */
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Invoice Created successfully ');
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
		}
	}



	public function download_invoice()
	{
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");

		// echo "<pre/>"; print_r($id);die;

		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		$billno = base64_decode($billno);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$details = $details[0];
		$customer_name = $details['customer_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
		);

		$response = $this->api->call_v_api('downloadCustomerInvoiceDetails', $params);
		/* echo "<pre/>";print_r($response);
		echo "<pre/>";print_r($params);
		die; */
		// download file
		header('Content-Disposition: attachment; filename="' . $customer_name . '_Invoice_' . Date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}



	/* Added by Ankit on 21/02/2026 */

	public function download_multiple_invoices()
	{
		$invoices_json = $this->input->post('invoices');
		$invoices = json_decode($invoices_json, true);

		if (empty($invoices)) {
			show_error("No invoices selected.");
		}

		$this->load->library('zip');

		foreach ($invoices as $inv) {

			$customer_id = $inv['customer_id'];
			$billno      = $inv['billno'];

			if (empty($customer_id) || empty($billno)) {
				continue;
			}

			// Get customer details
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $customer_id
			);

			$details = $this->api->call_v_api('getCustomerMasterDetails', $params);

			if (empty($details)) {
				continue;
			}

			$customer_name = strtolower(str_ireplace(" ", "_", $details[0]['customer_name']));

			// Get invoice PDF content
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $customer_id,
				"five" => $billno,
			);

			$pdf_content = $this->api->call_v_api('downloadCustomerInvoiceDetails', $params);

			$file_name = $customer_name . '_Invoice_' . $billno . '.pdf';

			$this->zip->add_data($file_name, $pdf_content);
		}

		$this->zip->download('Selected_Invoices_' . date("Y-m-d-H-i-s") . '.zip');
	}

	public function download_contract()
	{
		// $id      = $this->input->get("contract_id");	
		// $billno  = $this->input->get("billno");	
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");

		// Validate input
		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Contract Details not found');
			redirect(get_module() . '/customers/customer_report');
		}

		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Invalid Contract ID');
			redirect(get_module() . '/customers/customer_report');
		}

		// Fetch customer details
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,

		);

		$details = $this->api->call_v_api('getCustomerMasterDetails', $params); // API name may vary
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Contract Details not found');
			redirect(get_module() . '/customers/customer_report');
		}

		$details = $details[0];
		$customer_name = strtolower(str_ireplace(" ", "_", $details['customer_name']));

		// Prepare API call to fetch contract PDF
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
			"nine" => "contract",
		);

		$response = $this->api->call_v_api('downloadCustomerContractDetails', $params); // This should return PDF

		// Output contract PDF
		header('Content-Disposition: attachment; filename="' . $customer_name . '_Contract_' . date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}
	public function send_download_invoice()
	{
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");
		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		$billno = base64_decode($billno);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$details = $details[0];
		$customer_name = $details['customer_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
		);

		$response = $this->api->call_v_api('sendCustomerInvoiceDetails', $params);
		/* echo "<pre/>";print_r($response);
		echo "<pre/>";print_r($params);
		die; */
		// download file
		if ($response == "Success") {
			$this->session->set_flashdata('success', 'Invoice Sent successfully ');
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
		} else {
			$this->session->set_flashdata('error', ERROR_MESSAGE);
			redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($id));
		}
	}

	public function download_invoice_single()
	{
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");
		$cust_subs_cbpmid  = $this->input->get("cust_subs_cbpmid");
		if (empty($id) || empty($billno) || empty($cust_subs_cbpmid)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$details = $details[0];
		$customer_name = $details['cust_company_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
			"six" => $cust_subs_cbpmid,
		);

		$response = $this->api->call_v_api('downloadCustomerInvoiceSingleDetails', $params);
		//echo "<pre/>";print_r($response);die;
		//download file
		header('Content-Disposition: attachment; filename="' . $customer_name . '_' . $cust_subs_cbpmid . '_Invoice_' . Date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}
	public function print_invoice()
	{
		$id      = $this->input->get("ref_id");
		$billno  = $this->input->get("billno");
		if (empty($id) || empty($billno)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);
		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$details = $details[0];
		$customer_name = $details['customer_name'];
		$customer_name = strtolower(str_ireplace(" ", "_", $customer_name));
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id,
			"five" => $billno,
		);

		$response = $this->api->call_v_api('downloadCustomerInvoiceDetails', $params);
		//echo "<pre/>";print_r($response);die;
		// download file
		header('Content-Disposition: inline; filename="' . $customer_name . '_Invoice_' . Date("Y-m-d-h-i-s") . '.pdf"');
		header('Content-Type: application/pdf');
		echo ($response);
	}

	public function renew_customer_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$id  = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']  = "Renew Customer Service";
		$data['action']  	 = "Renew";

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$subscriptionList  = $this->api->call_v_api('getClientSubscriptionDetails', $params);
		$data['details']           = $details[0];
		$data['subscriptionList']  = $subscriptionList;

		// print_r($subscriptionList);
		// exit;

		$data['serv_details'] = $this->api->call_v_api('getClientServiceDetails', $params);

		$data['service_list']       = $this->getServiceType();
		$data['gst_type_list']      = $this->getGSTType();
		$data['duration_list'] = $this->getDuartionList();

		$this->form_validation->set_rules('cust_service_type', 'Service Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_gst_type', 'GST Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_type', 'Customer Type', 'required|trim', array('required' => 'Select %s'));

		$this->form_validation->set_rules('cust_service_det', 'Service Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_paid_amount', 'Total Paid Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_unit_no', 'Unit No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_form_no', 'Form No', 'trim|max_length[50]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/renew_customer', $data);
		} else {

			$installment_dates = $this->input->post('next_installment_date[]');
			$installment_amounts = $this->input->post('next_installment_amount[]');
			$installment_start_dates = $this->input->post('next_installment_start_date[]');
			$installment_end_dates = $this->input->post('next_installment_end_date[]');

			// Initialize variables to store the formatted data
			$installment_date_str = '';
			$installment_amount_str = '';
			$installment_start_date_str = '';
			$installment_end_date_str = '';

			if (!empty($installment_dates)) {


				foreach ($installment_dates as $index => $date) {
					// Check if date is not empty and valid
					if (!empty($date) && strtotime($date) !== false) {
						$installment_date_str .= date('d-M-Y', strtotime($date)) . ',';
						// Append corresponding installment amount only if date is valid
						if (isset($installment_amounts[$index])) {
							$installment_amount_str .= $installment_amounts[$index] . ',';
						}
						if (isset($installment_start_dates[$index])) {
							$installment_start_date_str .= $installment_start_dates[$index] . ',';
						}
						if (isset($installment_end_dates[$index])) {
							$installment_end_date_str .= $installment_end_dates[$index] . ',';
						}
					}
				}

				// Remove trailing commas
				$installment_date_str = rtrim($installment_date_str, ',');
				$installment_amount_str = rtrim($installment_amount_str, ',');
				$installment_start_date_str = rtrim($installment_start_date_str, ',');
				$installment_end_date_str = rtrim($installment_end_date_str, ',');
				// print_r($installment_start_date_str);
				// exit;
			}

			// Calculate total installment amount by summing up the values from installment_amount_str
			$installment_amounts_arr = explode(',', $installment_amount_str);
			$total_installment_amount = array_sum($installment_amounts_arr);

			// Now, let's retrieve the total price (cust_total_amount) from the UI input
			$cust_total_amount = $this->input->post('cust_total_amount');  // Assuming you're getting the value from a POST request

			// Compare the total installment amount with the cust_total_amount
			if ($total_installment_amount != $cust_total_amount) {
				// If the total installment amount is not equal to the total price, show an error message
				echo '<span class="text-danger">Amount should be equal to Total Amount.</span>';
			} else {
				// If the amounts are equal, continue processing
				echo '<span class="text-success">Amounts match, proceeding with the payment.</span>';
			}

			$post_data      = $this->input->post(null, true);

			$selected_subscriptions = $this->input->post('selected_subscriptions');
			$selected_subs_str = !empty($selected_subscriptions) ? implode(",", $selected_subscriptions) : Null;


			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;
			$cust_id        = !empty($post_data['cust_id']) ? $post_data['cust_id'] : Null;
			$cust_gst_type = !empty($post_data['cust_gst_type']) ? $post_data['cust_gst_type'] : Null;
			$cust_type     = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;

			$cust_service_det  = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount']) ? round($post_data['cust_total_amount']) : 0;
			$cust_paid_amount  = !empty($post_data['cust_paid_amount']) ? round($post_data['cust_paid_amount']) : 0;
			$cust_unit_no  = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
			$cust_form_no  = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;

			$service_id  = !empty($post_data['service_id']) ? $post_data['service_id'] : Null;
			$cust_service_id  = !empty($post_data['cust_service_id']) ? $post_data['cust_service_id'] : Null;
			$cust_pdt_qty  = !empty($post_data['cust_pdt_qty']) ? $post_data['cust_pdt_qty'] : Null;
			$cust_pdt_price  = !empty($post_data['cust_pdt_price']) ? $post_data['cust_pdt_price'] : Null;
			$cust_pdt_gst_price  = !empty($post_data['cust_pdt_gst_price']) ? $post_data['cust_pdt_gst_price'] : Null;
			$cust_pdt_gst  = !empty($post_data['cust_pdt_gst']) ? $post_data['cust_pdt_gst'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;

			$cust_service_date_count = "";
			$cust_service_dates      = "";
			$service_ids             = "";
			if (!empty($service_id)) {
				foreach ($service_id as $id) {
					$date_var = "cust_service_dates_" . $id;
					if (!empty($post_data[$date_var])) {
						$cust_service_date_count = $cust_service_date_count . count($post_data[$date_var]) . ",";
						foreach ($post_data[$date_var] as $date) {
							$serv_date  = !empty($date) ? date("d-M-Y", strtotime($date)) : Null;
							$cust_service_dates      = $cust_service_dates . $serv_date . ",";
						}
					}
				}
				$service_ids          = implode(",", $service_id);
				$cust_deliver_address = implode(",", $cust_deliver_address);
				$cust_pdt_gst_price   = implode(",", $cust_pdt_gst_price);
				$cust_pdt_price       = implode(",", $cust_pdt_price);
				$cust_pdt_qty         = implode(",", $cust_pdt_qty);

				$cust_service_date_count = !empty($cust_service_date_count) ? substr($cust_service_date_count, 0, -1) : Null;
				$cust_service_dates      = !empty($cust_service_dates) ? substr($cust_service_dates, 0, -1) : Null;
			}
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $cust_id,
				"five" => $cust_service_type,
				"six" => $service_ids,
				"seven" => $cust_deliver_address,
				"eight" => $cust_pdt_qty,
				"nine" => $cust_pdt_gst_price,
				"ten" => Null,
				"eleven" => $cust_service_dates,
				"twelve" => $cust_service_date_count,
				"thirteen" => $cust_total_amount,
				"fourteen" => $cust_gst_type,
				"fifteen" => $cust_paid_amount,
				"sixteen" => $cust_unit_no,
				"seventeen" => $cust_form_no,
				"eighteen" => $installment_amount_str,
				"nineteen" => $installment_date_str,
				"twenty" => $installment_start_date_str,
				"twentyone" => $installment_end_date_str,
				"twentytwo" => $selected_subs_str
			);
			$response = $this->api->call_v_api('setRenewCustomerMasterDetails', $params);
			//   print_r($selected_subs_str);
			//   exit;
			// log_message("error",json_encode($params));
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'Customer Renewed Successfully !!');
				$this->cache->redis->deleteByPattern('ci_dashboard:amc_reminder:' .$this->_user_company_id .':*');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}

	public function add_customer_service()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}

		$id  = $this->input->get("id");
		if (empty($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$id = base64_decode($id);
		if (!is_numeric($id)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$data['page_title']  = "Add Customer Service";
		$data['action']  	 = "Add";

		$data['id'] = $id;
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $id
		);
		$details = $this->api->call_v_api('getCustomerMasterDetails', $params);

		if (empty($details)) {
			$this->session->set_flashdata('error', 'Customer Details not found');
			redirect(get_module() . '/customers/customer_report');
		}
		$subscriptionList  = $this->api->call_v_api('getClientSubscriptionDetails', $params);
		$data['details']           = $details[0];
		$data['subscriptionList']  = $subscriptionList;

		$data['service_list']       = $this->getServiceType();
		$data['gst_type_list']      = $this->getGSTType();
		$data['duration_list'] 		= $this->getDuartionList();

		$this->form_validation->set_rules('cust_service_type', 'Service Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_gst_type', 'GST Type', 'required|trim', array('required' => 'Select %s'));
		$this->form_validation->set_rules('cust_type', 'Customer Type', 'required|trim', array('required' => 'Select %s'));

		$this->form_validation->set_rules('cust_service_det', 'Service Details', 'trim|max_length[500]');
		$this->form_validation->set_rules('cust_total_amount', 'Total Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_paid_amount', 'Total Paid Amount', 'trim|max_length[8]|numeric');
		$this->form_validation->set_rules('cust_unit_no', 'Unit No', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_form_no', 'Form No', 'trim|max_length[50]');

		if ($this->form_validation->run() == FALSE) {
			$this->loadViews(get_module() . '/customers/renew_customer', $data);
		} else {
			$post_data      = $this->input->post(null, true);


			$cust_service_type = !empty($post_data['cust_service_type']) ? $post_data['cust_service_type'] : Null;
			$cust_id        = !empty($post_data['cust_id']) ? $post_data['cust_id'] : Null;
			$cust_gst_type = !empty($post_data['cust_gst_type']) ? $post_data['cust_gst_type'] : Null;
			$cust_type     = !empty($post_data['cust_type']) ? $post_data['cust_type'] : Null;

			$cust_service_det  = !empty($post_data['cust_service_det']) ? $post_data['cust_service_det'] : Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount']) ? round($post_data['cust_total_amount']) : 0;
			$cust_paid_amount  = !empty($post_data['cust_paid_amount']) ? round($post_data['cust_paid_amount']) : 0;
			$cust_unit_no  = !empty($post_data['cust_unit_no']) ? $post_data['cust_unit_no'] : Null;
			$cust_form_no  = !empty($post_data['cust_form_no']) ? $post_data['cust_form_no'] : Null;

			$service_id  = !empty($post_data['service_id']) ? $post_data['service_id'] : Null;
			$cust_service_id  = !empty($post_data['cust_service_id']) ? $post_data['cust_service_id'] : Null;
			$cust_pdt_qty  = !empty($post_data['cust_pdt_qty']) ? $post_data['cust_pdt_qty'] : Null;
			$cust_pdt_price  = !empty($post_data['cust_pdt_price']) ? $post_data['cust_pdt_price'] : Null;
			$cust_pdt_gst_price  = !empty($post_data['cust_pdt_gst_price']) ? $post_data['cust_pdt_gst_price'] : Null;
			$cust_pdt_gst  = !empty($post_data['cust_pdt_gst']) ? $post_data['cust_pdt_gst'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;
			$cust_deliver_address  = !empty($post_data['cust_deliver_address']) ? $post_data['cust_deliver_address'] : Null;

			$cust_service_date_count = "";
			$cust_service_dates      = "";
			$service_ids             = "";
			if (!empty($service_id)) {
				foreach ($service_id as $id) {
					$date_var = "cust_service_dates_" . $id;
					if (!empty($post_data[$date_var])) {
						$cust_service_date_count = $cust_service_date_count . count($post_data[$date_var]) . ",";
						foreach ($post_data[$date_var] as $date) {
							$serv_date  = !empty($date) ? date("d-M-Y", strtotime($date)) : Null;
							$cust_service_dates      = $cust_service_dates . $serv_date . ",";
						}
					}
				}
				$service_ids          = implode(",", $service_id);
				$cust_deliver_address = implode(",", $cust_deliver_address);
				$cust_pdt_gst_price   = implode(",", $cust_pdt_gst_price);
				$cust_pdt_price       = implode(",", $cust_pdt_price);
				$cust_pdt_qty         = implode(",", $cust_pdt_qty);

				$cust_service_date_count = !empty($cust_service_date_count) ? substr($cust_service_date_count, 0, -1) : Null;
				$cust_service_dates      = !empty($cust_service_dates) ? substr($cust_service_dates, 0, -1) : Null;
			}
			$params = array(
				"one" => $this->_user_id,
				"two" => $this->_user_branch_id,
				"three" => $this->_user_company_id,
				"four" => $cust_id,
				"five" => $cust_service_type,
				"six" => $service_ids,
				"seven" => $cust_deliver_address,
				"eight" => $cust_pdt_qty,
				"nine" => $cust_pdt_gst_price,
				"ten" => Null,
				"eleven" => $cust_service_dates,
				"twelve" => $cust_service_date_count,
				"thirteen" => $cust_total_amount,
				"fourteen" => $cust_gst_type,
				"fifteen" => $cust_paid_amount,
				"sixteen" => $cust_unit_no,
				"seventeen" => $cust_form_no,
			);
			//echo "<pre/>"; print_r( $params);die;
			$response = $this->api->call_v_api('setCustomerNewServiceDetails', $params);
			//log_message("error",json_encode($params));
			//log_message("error",json_encode($params));
			if ($response == "Success") {
				$this->session->set_flashdata('success', 'New Service Added Successfully !!');
				$this->clearDashboardCompanyCache($this->_user_company_id);
				$this->cache->redis->deleteByPattern('ci_dashboard:amc_reminder:' .$this->_user_company_id .':*');
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			} else {
				$this->session->set_flashdata('error', ERROR_MESSAGE);
				redirect(get_module() . '/customers/view_customer/?id=' . base64_encode($cust_id));
			}
		}
	}

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
		$response  = $this->api->call_v_api('getPermissionMasterDetails', $params);
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
		$response  = $this->api->call_v_api('getStateDetails', $params);
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
		$response  = $this->api->call_v_api('getProductMasterDetails', $params);
		return $response['jsArray'];
	}

	public function getServiceList()
	{
		$list = array(
			"One Time Service" => "One Time Service",
			"AMC" => "AMC Service",
			"Sales" => "Products Sale Customers",
		);
		return $list;
	}

	public function getPayOptions()
	{
		$list = array(
			"Commercial" => "Commercial",
			"Regular" => "Regular",
		);
		return $list;
	}

	public function getPaymentModes()
	{
		$list = array(
			"Cash" => "Cash",
			"Cheque" => "Cheque",
			"Card" => "Card",
			"Online" => "Online",
			"DD" => "DD"
		);
		return $list;
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

	public function getCustomerType()
	{
		$list = array(
			"Regular" => "Regular",
			"Commercial" => "Commercial",
		);
		return $list;
	}

	public function getGSTType()
	{
		return array(
			"GST Applicable" => "With GST",
			"IGST Applicable" => "With IGST",
			"GST Not Applicable" => "No GST",
		);
	}
	public function getReferencedBy()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
		);
		$response  = $this->api->call_v_api('getReferenceByDetails', $params);
		return $response['jsArray'];
	}
	public function getEmployeeDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"five" => "Active",
			// "five" => "Active,Deactivated",
		);
		$response  = $this->api->call_v_api('getEmployeeReportDetails', $params);
		return $response['jsArray'];
	}
	// added by rohan 01-07-2026
	public function getTicketEmployeeDetails()
{
    $params = array(
        "one"   => $this->_user_id,
        "two"   => $this->_user_branch_id,
        "three" => $this->_user_company_id,
        "five"  => "Active,Deactivated",
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
		$response  = $this->api->call_v_api('getAreaDetails', $params);
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
		$response  = $this->api->call_v_api('getAreaCityIdDetails', $params);
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
		$response  = $this->api->call_v_api('getDistrictStateIdDetails', $params);
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
		$response  = $this->api->call_v_api('getCityDistrictIdDetails', $params);
		return $response;
	}
	public function getCustomerMasterReportDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
		);
		$response  = $this->api->call_v_api('getCustomerMasterReportDetails01', $params);
		return $response['jsArray'];
	}
	public function getCustomerLeadMasterReportDetails()
	{
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => "Active",
		);
		$response  = $this->api->call_v_api('getCustomerLeadMasterReportDetails', $params);
		return $response['jsArray'];
	}

	// Monthly Schedular  Report 
	public function tbl_month_schedular_list()
	{
		$start          = $this->input->get('start');
		$end            = $this->input->get('end');
		$start          = !empty($start) ? strtoupper(date("M-Y", strtotime($start))) : "";

		//echo  $start;die;	
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"seven" => $start,
		);
		$list = $this->api->call_v_api('getMonthSchedulerDataDetails', $params);
		//echo "<pre/>";print_r($list);
		// Form Table
		$html = "";
		$json_array  = array();
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$id          = $item['id'];
				$id          = base64_encode($id);
				// $url = get_module_path().'customers/view_ticket/?id='.$id."&history=back";
				$json_array[$key]['groupId'] = "999";

				// $json_array[$key]['title'] = $item['customer_name']."( ".$item['name'].") - ".$item['type'];
				$title_type = $item['type'];
				if ($item['type'] == "AMC") {
					$title_type = "Pending Service";
				}

				$json_array[$key]['title'] = $item['customer_name'] . "( " . $item['name'] . ") - " . $title_type;


				$mdate = !empty($item['mdate']) ? date("Y-m-d", strtotime($item['mdate'])) : "";
				//$json_array[$key]['description'] = $item['customer_name']."( ".$item['name']." ) ";
				$json_array[$key]['start']       = $mdate;
				$json_array[$key]['end']         = $mdate;

				// $json_array[$key]['allDay']       = false;
				$backgroundColor = "#1bbc9b";
				if ($item['type'] == "Service") {
					$backgroundColor = "#E7505A";
					// $url = get_module_path().'customers/view_ticket/?id='.$id."&history=back";
				}
				if ($item['type'] == "Sales") {
					$backgroundColor = "#4B77BE";
					// $url = get_module_path().'customers/view_ticket/?id='.$id."&history=back";
					$url = get_module_path() . 'customers/view_customer/?id=' . $id . "&history=back";
					$json_array[$key]['url']         = $url;
				}
				if ($item['type'] == "Ticket") {
					$backgroundColor = "#8E44AD";
					$url = get_module_path() . 'customers/view_ticket/?id=' . $id . "&history=back";
					$json_array[$key]['url']         = $url;
				}
				if ($item['type'] == "Servicing") {
					$backgroundColor = "#E87E04";
					$url = get_module_path() . 'customers/view_ticket/?id=' . $id . "&history=back";
					$json_array[$key]['url']         = $url;
				}
				if ($item['type'] == "Followup") {
					$backgroundColor = "#4B77BE";
					// $url = get_module_path().'customers/view_ticket/?id='.$id."&history=back";
				}
				if ($item['type'] == "AMC") {
					$backgroundColor = "#4B77BE";
					$url = get_module_path() . 'customers/view_customer/?id=' . $id . "&history=back";
					$json_array[$key]['url']         = $url;
				}
				// $json_array[$key]['url']         = $url;

				$json_array[$key]['backgroundColor'] = $backgroundColor;
				$json_array[$key]['className '] = "cal_list";
			}
		}
		echo json_encode($json_array);
	}

	public function tbl_month_schedular_count_new()
	{
		$start  = $this->input->get('start');
		$end    = $this->input->get('end');
		$start  = !empty($start) ? strtoupper(date("M-Y", strtotime($start))) : "";

		$params = array(
			"one"   => $this->_user_id,
			"two"   => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"seven" => $start,
		);

		$list = $this->api->call_v_api('getMonthSchedulerDataDetails', $params);

		// print_r($list);
		// exit;

		// Initialize an array to group events by date and type
		$eventCounts = [];

		if (!empty($list)) {
			foreach ($list as $item) {
				$mdate = !empty($item['mdate']) ? date("Y-m-d", strtotime($item['mdate'])) : "";
				// $type  = !empty($item['type']) ? $item['type'] : "Followup"; // Default to Followup if empty
				$type = !empty($item['type']) ? ($item['type'] === 'AMC' ? 'Pending Service' : $item['type']) : 'Followup';


				if (!isset($eventCounts[$mdate][$type])) {
					$eventCounts[$mdate][$type] = 0;
				}
				$eventCounts[$mdate][$type]++;
			}
		}

		// Generate JSON response in the required format
		$json_array = [];
		foreach ($eventCounts as $date => $types) {
			foreach ($types as $type => $count) {
				$backgroundColor = "#E7505A"; // Default color for Service
				if ($type == "Ticket") {
					$backgroundColor = "#8E44AD";
				} elseif ($type == "Servicing") {
					$backgroundColor = "#E87E04";
				} elseif ($type == "Followup") {
					$backgroundColor = "#4B77BE";
				} elseif ($type == "Pending Service") {
					$backgroundColor = "#1bbc9b";
				} elseif ($type == "Other") {
					$backgroundColor = "#1bbc9b";
				}

				$json_array[] = [
					"groupId"         => "1999",
					"title"           => "$type- ( $count )",
					"start"           => $date,
					"end"             => $date,
					"backgroundColor" => $backgroundColor,
					"className"       => "cal_count",
				];
			}
		}

		echo json_encode($json_array);
	}

	public function tbl_month_schedular_count()
	{
		$start          = $this->input->get('start');
		$end            = $this->input->get('end');
		$start          = !empty($start) ? strtoupper(date("M-Y", strtotime($start))) : "";

		//echo  $start;die;	
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $start,
		);
		$list = $this->api->call_v_api('getMonthSchedulerDataCountDetails', $params);
		//echo "<pre/>";print_r($list);die;
		// Form Table
		$html = "";
		$json_array  = array();
		if (!empty($list)) {
			foreach ($list as $key => $item) {
				$id          = $item['id'];
				$id          = base64_encode($id);
				$url = get_module_path() . 'customers/view_ticket/?id=' . $id . "&history=back";
				$json_array[$key]['groupId'] = "1999";
				$json_array[$key]['title'] = $item['type'] . "- ( " . $item['count1'] . " )";
				$mdate = !empty($item['mdate']) ? date("Y-m-d", strtotime($item['mdate'])) : "";
				$json_array[$key]['start']       = $mdate;
				$json_array[$key]['end']         = $mdate;


				$backgroundColor = "#1bbc9b";
				if ($item['type'] == "Service") {
					$backgroundColor = "#E7505A";
				}
				if ($item['type'] == "Ticket") {
					$backgroundColor = "#8E44AD";
				}
				if ($item['type'] == "Servicing") {
					$backgroundColor = "#E87E04";
				}
				if ($item['type'] == "Followup") {
					$backgroundColor = "#4B77BE";
				}

				$json_array[$key]['backgroundColor'] = $backgroundColor;
				$json_array[$key]['className '] = "cal_count";
			}
		}
		echo json_encode($json_array);
	}


	public function getPaymentinstallments($cust_id = Null, $pay_id = Null)
	{

		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
			"five" => $pay_id,


		);
		$response  = $this->api->call_v_api('getCustomerPaymentInstallment', $params);
		return $response;
	}

	public function get_customer_invoice_details($cust_id = Null)
	{
		if (empty($cust_id)) {
			return array();
		}
		$html    = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
		);


		$params1 = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
			"six" => "Active",
		);


		$details   = $this->api->call_v_api('getCustomerMasterDetails', $params);
		$details   = $details[0];
		$billPaymentList   = $this->api->call_v_api('getClientBillPaymentDetails', $params1);
		$subscriptionList  = $this->api->call_v_api('getClientSubscriptionDetails', $params);


		$invoice_details = $this->api->call_v_api('getCustomerInvoiceDetails', $params);
		$invoice_html = "";

		$invoice_html = "<option value=''> Select Invoice </option>";
		if (!empty($invoice_details)) {
			foreach ($invoice_details as $invoice) {
				$invoice_html .= "<option value='" . $invoice['cbpm_id'] . "'>" . $invoice['cbpm_id'] . "</option>";
			}
		}
		$data['invoice_details'] =   $invoice_html;

		$html = "";

		$billPaymentList = !empty($billPaymentList) ? $billPaymentList[0] : "";
		$cbpm_id         =  isset($billPaymentList['cbpm_id']) ? $billPaymentList['cbpm_id'] : "";
		$cbpm_amount     = isset($billPaymentList['cbpm_amount']) ? $billPaymentList['cbpm_amount'] : "";
		$cbpm_total_amnt = isset($billPaymentList['cbpm_total_amnt']) ? $billPaymentList['cbpm_total_amnt'] : "";
		$cbpm_received_amnt = isset($billPaymentList['cbpm_received_amnt']) ? $billPaymentList['cbpm_received_amnt'] : "";
		$cbpm_balance_amnt =  isset($billPaymentList['cbpm_balance_amnt']) ? $billPaymentList['cbpm_balance_amnt'] : "";
		$cbpm_save_price = isset($billPaymentList['cbpm_save_price']) ? $billPaymentList['cbpm_save_price'] : "";
		$cbpm_billno = isset($billPaymentList['cbpm_billno']) ? $billPaymentList['cbpm_billno'] : "";
		$cbpm_gst = isset($billPaymentList['cbpm_gst']) ? $billPaymentList['cbpm_gst'] : "";
		// $params['five']  = $cbpm_billno;
		// $invoice_details = $this->api->call_v_api('getCustomerInvoiceDetails',$params);
		// $invoice_html = "";
		// if(!empty($invoice_details)){
		// foreach($invoice_details as $invoice){
		// 	$invoice_html .= "<option value='".$invoice['cbpm_id']."'>".$invoice['cbpm_id']."</option>";
		//  }
		// }						
		// $data['invoice_details'] =   $invoice_html;

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
			  <input type="hidden" name="discount" value="' . $cbpm_save_price . '"/>						   
			  <input type="hidden" name="cbpm_balance_amnt" id="cbpm_balance_amnt" value="' . $cbpm_balance_amnt . '"/>						   
			  <div class="tbl-container" style="overflow-x:scroll;">
			 <table class="table table-condensed table-hover">
					<tbody>
						<tr ><th width="20%"> Customer Name  </th><td>' . $details['customer_name'] . '</td>
						<th> Customer Contact   </th>
						<td>' . $details['customer_contact'] . '</td>
						<th> Invoice No  </th>
						<td>' . $cbpm_id . '</td>
						</tr>
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
						<tr>						
						<th > Customer Address  </th>								
						<td colspan="5">' . $details['customer_address'] . '</td>
						</tr>											
					</tbody> 
					  </table>
					  </div>';
		$data['payment_details'] = $html;
		$html = "";
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
				   <table class="table table-striped table-bordered table-advance table-hover">
					<tbody>
					<tr class="success"><th width="2%">Sr. No.</th><th width="5%">Receipt No (S/W)</th><th width="5%">Bill Book No</th><th width="12%">Paid Date</th><th>Paid Amt</th><th>Pay Mode</th><th>Chq/Card No</th><th>Bank Details</th><th>Status</th></tr>';

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
					$html .=  "<span class='label label-success'>Paid</span>";
				} else if ($pyment['cp_status'] == "Closed" || $pyment['cp_status'] == "Cancel") {
					$html .=  "<span class='label label-danger'>" . $pyment['cp_status'] . "</span>";
				} else {
					$html .=  "<span class='label label-warning'>" . $pyment['cp_status'] . "</span>";
				}
				$html .= '</td></tr>';
			}
			$html .= '</tbody>
				</table>';
		}


		$html .= '</div></div>';

		$data['payment_list'] = $html;
		$html = "";
		if (!empty($subscriptionList)) {
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
					<tr class="success"><th >Sr. No.</th><th >One Time/ AMC/ Sales Product</th><th>Price</th></tr>';

			foreach ($subscriptionList as $key => $subserv) {
				$sub_id = $subserv['cust_subs_id'];
				$cust_subs_custid = $subserv['cust_subs_custid'];
				$str = "?cust_id=" . base64_encode($cust_subs_custid) . "&sub_id=" . base64_encode($sub_id);
				$sr_no = $key + 1;

				$html .= '<tr><td>' . $sr_no . '</td>
						<td>' . $subserv['cust_subs_type_name'] . ' </td>
						<td>' . $subserv['cust_subs_price'] . '</td>';
				$html .= '</td></tr>';
			}
			$html .= '</tbody></table></div>';
		}
		$data['service_list'] = $html;
		$data['details'] = $details;

		return $data;
	}

	public function get_customer_invoice_details01($cust_id = Null)
	{
		if (empty($cust_id)) {
			return array();
		}
		$html    = "";
		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
		);


		$params1 = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $cust_id,
			"six" => "Active",
		);


		$details   = $this->api->call_v_api('getCustomerMasterDetails', $params);
		$details   = $details[0];
		$billPaymentList   = $this->api->call_v_api('getClientBillPaymentDetails', $params1);
		$subscriptionList  = $this->api->call_v_api('getClientSubscriptionDetails', $params);


		$invoice_details = $this->api->call_v_api('getCustomerInvoiceDetails', $params);
		$invoice_html = "";

		$invoice_html = "<option value=''> Select Invoice </option>";
		if (!empty($invoice_details)) {
			foreach ($invoice_details as $invoice) {
				$invoice_html .= "<option value='" . $invoice['cbpm_id'] . "'>" . $invoice['cbpm_billno'] . "</option>";
			}
		}
		$data['invoice_details'] =   $invoice_html;

		$data['service_list'] = $html;
		$data['details'] = $details;

		return $data;
	}


	public function check_access($class = Null, $method = Null)
	{
		return true;
	}

	//PINCODE

	public function checkPINExists()
	{
		$pin_code  = $this->input->post('cust_pincode');
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
		$pin_code  = $this->input->post('pin_code');
		$pin_details = $this->api->check_pin($pin_code);
		echo $pin_details;
	}


	public function customer_gst_report()
	{
		if (!($this->check_access($this->router->fetch_class(), $this->router->fetch_method()))) {
			redirect(get_module() . '/dashboard/access_denied');
		}
		$data['page_title']        = "All Customer GST  Report";
		$data['status_list']       = array("Active", "Pending", "Deactivated");		//Added by Ankit on 23-03-2026
		$data['service_type_list'] = $this->getServiceList();
		$data['payment_type_list'] = $this->getPayOptions();

		$this->loadViews(get_module() . '/customers/gst_list_report', $data);
	}
	// Vihas added on 02/04/2026
	// Multiple transfer of ticket
	public function transfer_multiple_tickets()
	{
		$ticket_ids = $this->input->post('ticket_ids');
		$assign_to  = $this->input->post('assign_to');

		if (empty($ticket_ids) || empty($assign_to)) {
			echo json_encode(['status' => 'error']);
			return;
		}

		$todaydate = strtoupper(date("d-M-Y"));


		$params = array(
			"one" => $this->_user_id,
			"two" => $this->_user_branch_id,
			"three" => $this->_user_company_id,
			"four" => $this->_user_id,
			"five" => implode(',', $ticket_ids),
			"six" => "1",
			"seven" => "Ticket",
			"ten" => $assign_to,
			"fourteen" => "Open",
			"fifteen" => $todaydate,
		);
		$response = $this->api->call_v_api('setReassignTicketMasterDetails', $params);

		echo json_encode(['status' => 'success']);
	}


	public function complete_service()
	{
		$cust_serv_id = $this->input->post('cust_serv_id');
		$reason       = $this->input->post('reason');

		$params = array(
			"one"   => $cust_serv_id,
			"two"   => $reason,
			"three" => $this->_user_id,
			"four"  => $this->_user_branch_id,
			"five"  => $this->_user_company_id
		);

		$response = $this->api->call_v_api(
			'completeCustomerService',
			$params
		);

		if (trim($response) == "Success") {

		$this->clearDashboardCompanyCache($this->_user_company_id);
			$this->session->set_flashdata(
				'success',
				'Service Completed Successfully'
			);
		} else {

			$this->session->set_flashdata(
				'error',
				'Failed To Complete Service'
			);
		}

		redirect($_SERVER['HTTP_REFERER']);
	}


}
