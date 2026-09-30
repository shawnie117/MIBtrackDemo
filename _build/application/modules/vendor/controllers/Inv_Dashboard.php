<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed'); 
class Dashboard extends MY_Controller { // Main Controller
	
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		
		// Load pagination library 
        $this->load->library('pagination'); 
		 // Per page limit 
        $this->perPage = 10; 
		
		if(!$this->isVendorLoggedIn())
		{
			redirect(get_module()."/login");
		}
		if($this->isVendorLoggedIn())
		{
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
			$this->_user_mobile =  $vendor['user_mob'];
		}
		
    }
	public function index()
    {
		$this->load->helper('common');
		$data['page_title']             = "Inv Dashboard";
		$data['todays_followup_list']   = $this->get_todays_followup();
		$data['my_followup_list']       = $this->get_my_followup();
		$data['lead_approval_list']     = $this->get_lead_approval_list();
		$data['cheque_reminder_list']   = $this->getChequeReminderDetails();
		$data['raised_complaint_list']   = $this->getComplaintAnalysisDetails();
		$data['pending_cust_list']  	= $this->getPendingCustomersDetails(); 
		$data['balance_list']  	        = $this->getSaleBalanceDetails(); 
		$data['notification_list']  	= $this->get_notification_list(); 
		$data['whatsappdeatils']  	    = $this->get_whatsapp_count(); 
		//echo "<pre/>"; print_r($data);die;
	    $branch_list                    = $this->getBranchMasterDetails();
		if(!empty($branch_list) && count($branch_list)>1){
			$data['branch_list']        = $branch_list;
		}
	 
		$this->loadViews(get_module().'/inv_dashboard',$data);  
	}
	public function set_branch_dashboard()
    { 
	  $vendor  = $this->session->userdata('vendor');
	  $role_id =  $vendor['user_role_id'];
	  if(in_array($role_id,explode(",",CHANGE_BRANCH_ACCESS))){
	  $branch_id = $this->input->post("p_branch");
	  $vendor['user_branch_id'] = $branch_id;
	  $this->session->set_userdata('vendor',$vendor);
	  redirect(get_module()."/inv_dashboard");
	  }
	 
	}
	
	public function access_denied()
    {
		$data['page_title']  = "Access Denied";	
		$this->loadViews(get_module().'/inv_dashboard/access_denied',$data); 
	}
	public function my_profile()
    {
		$data['page_title']  = "My Profile";	
		$this->loadViews(get_module().'/inv_dashboard/my_profile',$data); 
	}
	
	
	
	public function change_password()
    {
		$data['page_title']  = "Change Password";	
	    
		
		$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|max_length[75]');
		$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|max_length[75]');
					
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inv_dashboard/change_password',$data); 				
			
		}
		else 
		{ 
			$params = array("one"=>$this->_user_id,
							"two"=>$this->input->post('confirm_password')
							);
			$response = $this->api->call_v_api('resetLoginDetailsNew',$params);
			if($response=="Success"){
					$this->session->set_flashdata('success', 'Password Changed successfully ');
					redirect(get_module().'/inv_dashboard/change_password');
				
			} else{
				    $this->session->set_flashdata('error', 'Error : Please try after some time');
					redirect(get_module().'/inv_dashboard/change_password');
			}
		}
		
	}
	 	  
	public function get_notification_list()
	  {
		  $date    = strtoupper(date("d-M-Y"));
	      $params = array("one"=>$this->_user_id,
						  "two"=>$this->_user_branch_id,
						  "three"=>$this->_user_company_id,
						  "four"=>$this->_role_id,
    					  "eight"=>$date,						 
						  );
		   $response = $this->api->call_v_api('getNotificationDetails',$params);
		  
		   return $response['jsArray'];

	  }


	  public function get_whatsapp_count()
	  {
		  $date    = strtoupper(date("d-M-Y"));
	      $params = array("one"=>$this->_user_id,
						  "two"=>$this->_user_branch_id,
						  "three"=>$this->_user_company_id,
						  "four"=>$this->_user_emp_id,
						  "five"=>$this->_user_mobile  					  						 
						  );
		$response = $this->api->call_v_api('getWhatsAppCount',$params);
		//echo "<pre/>"; print_r($response);die;
		return $response;
		 
	  }

  
	// FAQ 
	public function faq()
    {
	
		$data['page_title']   = "FAQ";
    	$searchStr    		  = $this->input->get('searchStr');
		$data['searchStr']    = $searchStr;	
		$params = array("one"=>"1",
							"two"=>"1",
							"three"=>"1",
							"four"=>"Active",
							"five"=>"Report"
							);
		$data['faq_module_list'] = $this->api->call_api('getFaqModuleUserDetails',$params);
		$this->loadViews('inv_dashboard/faq',html_escape($data)); 
	}	  
	public function logout()
    {
		
		$this->session->sess_destroy();
		$this->session->set_flashdata('success', 'Logout successfully !!');
		redirect(get_module()."/login");
	}
	  
     /**********Dashbard Functions**********/
	 public function get_todays_followup()
	 {
		$date = strtoupper(date("d-M-Y"));
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"seven"=>$date
		);
		$response = $this->api->call_v_api('getFollowupAnalysisDetails',$params);
		//echo "<pre/>"; print_r($response);die;
		return $response;
	 }  
	 public function get_my_followup()
	 {
		$date = strtoupper(date("d-M-Y"));
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_id,
		"seven"=>$date
		);
		$response = $this->api->call_v_api('getFollowupAnalysisDetails',$params);
		return $response;
	 } 
	 
	 public function get_lead_approval_list()
	 {
		 
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>"FS"
		);
		$response = $this->api->call_v_api('getCustomerLeadMasterReportDetails',$params);
		return $response;
	 } 
	 
 	 public function getChequeReminderDetails()
	 {
		 
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		
		);
		$response = $this->api->call_v_api('getChequeReminderDetails',$params);
		return $response;
	 } 
      public function getPendingCustomersDetails()
	 {
		 
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>"Pending");
		$response = $this->api->call_v_api('getCustomerMasterReportDetails',$params);
		return $response;
	 }   
	 public function getComplaintAnalysisDetails()
	 {
		$date = strtoupper(date("d-M-Y"));
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			/* "four"=>$this->_user_id, */
			"five"=>"Open",
			"eight"=>$date,
			);
		$response = $this->api->call_v_api('getComplaintAnalysisDetails',$params);
		return $response;
	 }  	 
	 
	 public function getMonthSchedulerDataDetails()
	 {
		 
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>"Complaint",
		"five"=>$this->_user_emp_id
		);
		$response = $this->api->call_v_api('getMonthSchedulerDataDetails',$params);
		return $response;
	 }  
	 
	 public function getSaleBalanceDetails()
	 {
		 
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"nine"=>"B",
		"limit"=>null,
		"offset"=>"1",
		"total_count"=>Null,
		);
		$response = $this->api->call_v_api('getSaleBalanceDetails',$params);
		return $response;
	 } 
 	
	
}
