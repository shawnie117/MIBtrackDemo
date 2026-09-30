<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed'); 
class Login extends MY_Controller {
	
    public function __construct()
    {
        parent::__construct();    		
    }

	public function index(){
		//$this->session->unset_userdata("cust_login_data");
		$this->session->unset_userdata("reset_pwd_mobile");
		$this->session->unset_userdata("reset_pwd");
		if($this->isVendorLoggedIn())
		{
			redirect(get_module()."/dashboard");
			
		}else {	
		
			$data['page_title'] = "Login";	
			$data['login']      = "Login";					
			$this->load->library('form_validation');						
								
			$this->form_validation->set_rules('username', 'Username', 'required|trim|max_length[100]');
	    	$this->form_validation->set_rules('password', 'Password', 'required|trim|max_length[100]');
															
			if($this->form_validation->run() == FALSE)
			{
				$data['reason'] = $this->input->get('reason');
				 $this->load->view("login",$data);		 
			}
			else
			{
				$username = $this->input->post("username",true);
				$password = $this->input->post("password",true);
				$hostname = $this->get_client_hostname();
				$ip       = $this->get_client_ip();
				$mac      = $this->get_client_mac();
				$params = array("one"=>$username,"two"=>$password,"three"=>$mac,"four"=>$hostname,"five"=>$ip);
				$result = $this->api->call_v_api('getLoginDetails',$params);
			    // echo "<pre/>" ;print_r($result);die;  
				if(empty($result)){
					$this->session->set_flashdata("error","Invalid Username-Password");
					redirect("/login");
					

				} else if ($result[0]['login_result'] == "Failed" && $result[0]['customer_subscription_status'] == "Expired"){					
						$this->session->set_userdata('renew_login_data',$result[0]);
						redirect("/login"); 
						
				}else if ($result[0]['login_result'] == "Failed" && $result[0]['customer_subscription_status'] == "NotSubscribed"){					
						$this->session->set_userdata('cust_login_data',$result[0]);
						redirect("/login"); 
						
				}if($result[0]['login_result'] == "Failed" && $result[0]['two_step_verify_status']=="NotVerified"){		
					$result[0]['input_username'] = $username;
					$result[0]['input_pwd']      = $password;
					$result[0]['input_cli_name'] = $hostname;
					$result[0]['input_cli_ip']   = $ip;
					$result[0]['input_cli_mac']  = $mac;
					$this->session->set_userdata('my_login_data',$result[0]);
					$params = array("one"=>$result[0]['user_branch_id'],"two"=>$result[0]['user_company_id'], "three"=> $result[0]['user_mob']);
				    $result_otp = $this->api->call_v_api('getOTPForAuthentication',$params);			
					redirect(get_module()."/login/validate_otp");
			
				}else if ($result[0]['login_result'] == "Success"){
					
					    $this->session->unset_userdata('login_data');
						$vendor_data = $result[0];
						$vendor_data['user_role_id'] = $result[0]['user_permission_id'];
						$vendor_data['is_logged_in'] = true;
						$vendor_data['session_id']   = session_id();						
						$this->session->set_userdata('vendor',$vendor_data);
						redirect(get_module()."/dashboard");
					
					
				}else {
					$this->session->set_flashdata("error",$result[0]['login_msg']);
					redirect("/login");
				}
				
			}
		

		}

	}
	// public function landing_page(){
	// 	// $this->session->set_flashdata("rn_successs","Registered Successfully ");
	// 	// $this->load->view(get_module()."/vendor/login"); 

	// 	$this->load->view("login",$data);

	// }

	public function landing_page() {
		// $this->load->view('index');


		// $externalSiteUrl = 'http://192.168.0.139/MibtrackPage/';

        // // Redirect users to the external website
        // redirect($externalSiteUrl, 'refresh');

		$this->load->view('index');
		
	}
	

    public function cancel_registration_completion(){ 
	  $this->session->unset_userdata("cust_login_data");
	  redirect("/login");
	}

	public function cancel_renew(){ 
	  $this->session->unset_userdata("renew_login_data");
	  redirect("/login");
	}
	
	public function complete_registration(){
		$cust_login_data = $this->session->userdata('cust_login_data');
		$id  = $cust_login_data['user_company_id'];
		
		if(empty($id))
		{   
		    $this->session->unset_userdata("cust_login_data");
			$this->session->set_flashdata('error', 'Invalid Customer Details');
		    redirect('/login');
		}
		   $this->load->library('form_validation');
			$data['page_title']  = "Complete Registration";
							
			$data['id'] = $id;	
			$params = array("one"=>"1",
							"two"=>"1",
							"three"=>"1",
							"four"=>$id);
			
			$details = $this->api->call_api('getCustomerMasterDetails',$params);	
			
			if(empty($details)){
				$this->session->unset_userdata("cust_login_data");
				$this->session->set_flashdata('error', 'Invalid Customer Details');
		         redirect('/login');
			} 
			$data['details']            = $details[0];			
		    $data['company_type_list']  = $this->getCompanyType(); 
		    $data['invoice_type_list']  = $this->getInvoiceType(); 
		    $data['gst_type_list']      = $this->getGSTType(); 
		    $data['reference_list']     = $this->getReferencedBy(); 
		    $data['state_list']         = $this->getStateDetails(); 
			
			$clm_stateid       = $details[0]['customer_state_id'];
			$clm_distid 	   = $details[0]['customer_dist_id'];
			$clm_cityid 	   = $details[0]['customer_city_id'];
			$data['dist_list'] = $this->getDistrictStateIdDetails($clm_stateid,"Report"); 
			$city_list         = $this->getCityDistrictIdDetails($clm_stateid,$clm_distid,"Report");
			$data['city_list'] = $city_list['jsArray'];
			$data['area_list'] = $this->getAreaCityIdDetails($clm_stateid,$clm_distid,$clm_cityid);  
			
		$this->form_validation->set_rules('company_type_id','Company Type', 'required|trim');
		$this->form_validation->set_rules('invoice_pattern_id','Invoice Type', 'required|trim');
		$this->form_validation->set_rules('cust_stateid','State', 'required|trim');
		/* $this->form_validation->set_rules('cust_distid','District', 'required|trim');
		$this->form_validation->set_rules('cust_cityid','City', 'required|trim'); */
		
		$this->form_validation->set_rules('bank_acc_name','Bank Account Name', 'trim|max_length[100]');
		$this->form_validation->set_rules('bank_acc_number','Bank Account Number', 'trim|max_length[20]');
		$this->form_validation->set_rules('bank_branch_address','Bank Branch Address', 'trim|max_length[250]');
		$this->form_validation->set_rules('bank_ifsc','Bank IFSC', 'trim|max_length[15]');
		$this->form_validation->set_rules('bank_micr','Bank MICR', 'trim|max_length[9]|numeric');
		$this->form_validation->set_rules('bank_name','Bank Name', 'trim|max_length[100]');
		
		$this->form_validation->set_rules('cust_gstno','GST No.', 'trim|max_length[15]');
		$this->form_validation->set_rules('cust_name','Customer Name ', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_comp_name','Company Name ', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_contact_person','Contact Person', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');	
		$this->form_validation->set_rules('alt_cust_contact','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');			
		$this->form_validation->set_rules('cust_landline','Landline No.', 'trim|max_length[15]|numeric');	
		$this->form_validation->set_rules('cust_contact_email','Email Id.', 'required|trim|max_length[100]|valid_email');		
		$this->form_validation->set_rules('cust_address','Address', 'required|trim|max_length[1500]');
		$this->form_validation->set_rules('cust_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]|numeric');			
		$this->form_validation->set_rules('cust_refbyname','Reference Name', 'max_length[200]');
		$this->form_validation->set_rules('cust_total_amount','Total Amount', 'max_length[8]|numeric');

		$this->form_validation->set_rules('cust_refby_email','Reference Email Id.', 'max_length[100]|valid_email');

        $this->form_validation->set_rules('cust_panno', 'PAN No', 'trim|max_length[10]|min_length[10]');			
		$this->form_validation->set_rules('cust_id_num', 'Id Proof No.', 'trim|max_length[50]');
		$this->form_validation->set_rules('cust_website','Website', 'trim|max_length[100]');
		
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/complete_registration', $data);				
				
			}
			else 
			{ 
	
			$post_data      = $this->input->post(null,true);
			
			// Image Upload
				$cust_pan_img = null;					
				$cust_id_img  = null;					
				$cust_img     = null;
			
                // Old Images
				$cust_pan_img       = $details[0]['cust_pan_img'];		
	            $cust_pan_img  	    = explode("/",$cust_pan_img);
	            $cust_pan_img       = $cust_pan_img[count($cust_pan_img)-1];
				
				$cust_id_img       = $details[0]['cust_id_img'];		
	            $cust_id_img  	   = explode("/",$cust_id_img);
	            $cust_id_img       = $cust_id_img[count($cust_id_img)-1];
				
				
				$cust_img       = $details[0]['cust_img_path'];		
	            $cust_img  	    = explode("/",$cust_img);
	            $cust_img       = $cust_img[count($cust_img)-1];
				
				if (!empty($_FILES['cust_id_img']['name']))
				{
					$ext = pathinfo($_FILES['cust_id_img']['name'], PATHINFO_EXTENSION);
					$upload_params    = array();
					$imageFile        = $_FILES['cust_id_img']['tmp_name'];
					$cust_id_img      = "CUST_ID_PROOF_".date("YmdHis").".".$ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params    = array("one"=>"1",
											"two"=>"1",
											"three"=>"1",
											"four"=>$cust_id_img,
											"five"=>base64_encode($img_file_content),
											"six"=>"CustomersKYC"
											);
				  $response = $this->api->call_api('uploadBitmap',$upload_params);
				}
				
			   if (!empty($_FILES['cust_pan_img']['name']))
				{
					$ext = pathinfo($_FILES['cust_pan_img']['name'], PATHINFO_EXTENSION);
					$upload_params    = array();
					$imageFile        = $_FILES['cust_pan_img']['tmp_name'];
					$cust_pan_img     = "PAN_IMG_".date("YmdHis").".".$ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params    = array("one"=>"1",
											"two"=>"1",
											"three"=>"1",
											"four"=>$cust_pan_img,
											"five"=>base64_encode($img_file_content),
											"six"=>"CustomersKYC"
											);
				  $response = $this->api->call_api('uploadBitmap',$upload_params);
				} 
				
				if (!empty($_FILES['cust_img']['name']))
				{
					$ext = pathinfo($_FILES['cust_img']['name'], PATHINFO_EXTENSION);
					$upload_params    = array();
					$imageFile        = $_FILES['cust_img']['tmp_name'];
					$cust_img         = "CUST_IMG_".date("YmdHis").".".$ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params    = array("one"=>"1",
											"two"=>"1",
											"three"=>"1",
											"four"=>$cust_img,
											"five"=>base64_encode($img_file_content),
											"six"=>"Customers"
											);
				  $response = $this->api->call_api('uploadBitmap',$upload_params);
				}
			
			
			$cust_gstno    = !empty($post_data['cust_gstno'])?$post_data['cust_gstno']:Null;
			$cust_id_num     = !empty($post_data['cust_id_num'])?$post_data['cust_id_num']:Null;
			$cust_panno     = !empty($post_data['cust_panno'])?$post_data['cust_panno']:Null;
			$cust_name     = !empty($post_data['cust_name'])?$post_data['cust_name']:Null;
			$cust_comp_name     = !empty($post_data['cust_comp_name'])?$post_data['cust_comp_name']:Null;
			$cust_website  = !empty($post_data['cust_website'])?$post_data['cust_website']:Null;
			$alt_cust_contact  = !empty($post_data['alt_cust_contact'])?$post_data['alt_cust_contact']:Null;
			$cust_total_amount  = !empty($post_data['cust_total_amount'])?$post_data['cust_total_amount']:0;
			
			$bank_name              = !empty($post_data['bank_name'])?$post_data['bank_name']:Null;
			$bank_acc_name          = !empty($post_data['bank_acc_name'])?$post_data['bank_acc_name']:Null;
			$bank_acc_number        = !empty($post_data['bank_acc_number'])?$post_data['bank_acc_number']:Null;
			$bank_branch_address    = !empty($post_data['bank_branch_address'])?$post_data['bank_branch_address']:Null;
			$bank_ifsc     = !empty($post_data['bank_ifsc'])?$post_data['bank_ifsc']:Null;
			$bank_micr     = !empty($post_data['bank_micr'])?$post_data['bank_micr']:Null;
			
			
			$company_type_id     = !empty($post_data['company_type_id'])?$post_data['company_type_id']:Null;
			
			$invoice_pattern_id     = !empty($post_data['invoice_pattern_id'])?$post_data['invoice_pattern_id']:Null;
			$cust_paid_amount     = !empty($post_data['cust_paid_amount'])?$post_data['cust_paid_amount']:0;
			$payment_gateway     = !empty($post_data['payment_gateway'])?$post_data['payment_gateway']:Null;	
			
			$cust_contact_person = !empty($post_data['cust_contact_person'])?$post_data['cust_contact_person']:Null;
			$cust_contact    = !empty($post_data['cust_contact'])?$post_data['cust_contact']:Null;
			$cust_landline 	 = !empty($post_data['cust_landline'])?$post_data['cust_landline']:Null;
			$cust_contact_email 	 = !empty($post_data['cust_contact_email'])?$post_data['cust_contact_email']:Null;
			$cust_address 	 = !empty($post_data['cust_address'])?$post_data['cust_address']:Null;
			$cust_stateid 	 = !empty($post_data['cust_stateid'])?$post_data['cust_stateid']:Null;
			$cust_distid 	 = !empty($post_data['cust_distid'])?$post_data['cust_distid']:Null;
			$cust_cityid 	 = !empty($post_data['cust_cityid'])?$post_data['cust_cityid']:Null;
			$cust_area 	 = !empty($post_data['cust_area'])?$post_data['cust_area']:Null;
			$cust_pincode 	 = !empty($post_data['cust_pincode'])?$post_data['cust_pincode']:Null;
			$cust_unit_no  = !empty($post_data['cust_unit_no'])?$post_data['cust_unit_no']:Null;
			$cust_form_no  = !empty($post_data['cust_form_no'])?$post_data['cust_form_no']:Null;
			$cust_ui_date  = !empty($post_data['cust_ui_date'])?strtoupper(date("d-M-Y",strtotime($post_data['cust_ui_date']))):strtoupper(date("d-M-Y"));
			$cust_refbyid  = !empty($post_data['cust_refbyid'])?$post_data['cust_refbyid']:Null;
			$cust_refbyname  = !empty($post_data['cust_refbyname'])?$post_data['cust_refbyname']:Null;
			$cust_refby_contact  = !empty($post_data['cust_refby_contact'])?$post_data['cust_refby_contact']:Null;
			$cust_refby_email  = !empty($post_data['cust_refby_email'])?$post_data['cust_refby_email']:Null;
			
			$alternate_contact_details = !empty($post_data['group-b'])?$post_data['group-b']:Null;
			
			$lead_altcontactperson  = "";
			$lead_altcontact 		= "";
			$lead_altemail 			= "";
					
			if(!empty($alternate_contact_details))
			{
				foreach($alternate_contact_details as $contact){
					$lead_altcontactperson = $lead_altcontactperson.$contact['lead_altcontactperson'].",";
					$lead_altcontact = $lead_altcontact.$contact['lead_altcontact'].",";
					$lead_altemail = $lead_altemail.$contact['lead_altemail'].",";
				}
				
			}
			        $lead_altcontactperson = !empty($lead_altcontactperson)?substr($lead_altcontactperson,0,-1):Null;
					$lead_altcontact  = !empty($lead_altcontact)?substr($lead_altcontact,0,-1):Null;
					$lead_altemail    = !empty($lead_altemail)?substr($lead_altemail,0,-1):Null;
		
						
	       	$params = array("one"=>"1",
							"two"=>"1",
							"three"=>"1",
							"four"=>$id,
							"five"=>$cust_name,
							"six"=>$cust_comp_name,
							"seven"=>$cust_contact,
							"eight"=>$alt_cust_contact,
							"nine"=>$lead_altcontactperson,
							"ten"=>$lead_altcontact,
							"eleven"=>$lead_altemail,
							"twelve"=>$cust_address,
							"thirteen"=>$cust_website,
							"fourteen"=>$cust_stateid,
							"fifteen"=>$cust_distid,
							"sixteen"=>$cust_cityid,
							"seventeen"=>$cust_area,
							"eighteen"=>$cust_gstno,
							"nineteen"=>$cust_panno,
							"twenty"=>$cust_pincode,
							"twentyone"=>$cust_img,
							"twentytwo"=>$cust_refbyid,
							"twentythree"=>$cust_refbyname,
							"twentyfour"=>$cust_refby_contact,
							"twentyfive"=>$cust_refby_email,
							"twentysix"=>NULL,
							"twentyseven"=>NULL,
							"twentyeight"=>$cust_landline,
							"twentynine"=>$cust_total_amount,
							"thirty"=>$cust_total_amount,
							"thirtyone"=>$cust_unit_no,
							"thirtytwo"=>$cust_form_no,
							"thirtythree"=>$cust_ui_date,
							"thirtyfour"=>$cust_contact_person,
							"thirtyfive"=>$cust_contact_email,
							"thirtysix"=>"Online",
							"thirtyseven"=>$company_type_id,
							"thirtyeight"=>$invoice_pattern_id,
							"thirtynine"=>NULL,
							"fourty"=>NULL,
							"fourtyone"=>NULL,
							"fourtytwo"=>NULL,
							"fourtythree"=>$cust_pan_img,
							"fourtyfour"=>$cust_id_num,
							"fourtyfive"=>$cust_id_img,
							"fourtysix"=>Null,
							"fourtyseven"=>Null,
							"fourtyeight"=>$bank_name,
							"fourtynine"=>$bank_acc_name,
							"fifty"=>$bank_acc_number,
							"fiftyone"=>$bank_branch_address,
							"fiftytwo"=>$bank_ifsc,
							"fiftythree"=>$bank_micr,
							);

					
					$response = $this->api->call_api('setCustomerMandatoryDetails',$params);
					// echo "<pre>";
					// print_r($this->form_validation->run()); exit;
				 //log_message("error",json_encode($response));
				 //log_message("error",json_encode($params));
						if($response[0]['status']=="Success")
						{							 
							 $this->session->set_flashdata('success', "Registration Completed Successfully..");
							 
						}else 
						{
							 $this->session->set_flashdata('success', ERROR_MESSAGE);
						}
						$this->session->unset_userdata('cust_login_data');
						redirect(get_module()."/login");
			
		 
	    }
	
	}
	  
	public function renew_subscription()
	{
		
		$cust_login_data = $this->session->userdata('renew_login_data');
		$id  = $cust_login_data['user_company_id'];	
		
		if(empty($id))
		{   
		    $this->session->unset_userdata("renew_login_data");
			$this->session->set_flashdata('error', 'Invalid Customer Details');
		    redirect('/login');
		}
		$data['page_title']  = "Renew Subscription";
						
		$data['id'] = $id;	
		$params = array("one"=>"1",
						"two"=>"1",
						"three"=>"1",
						"four"=>$id);
		$details = $this->api->call_api('getCustomerMasterDetails',$params);
		
		if(empty($details))
		{
			$this->session->unset_userdata("renew_login_data");
			$this->session->set_flashdata('error', 'Invalid Customer Details');
			redirect('/login');
		}
		$renew_details      = $this->api->call_api('getSubscriptionRenewDetails',$params);
		// echo "<pre/>"; print_r(($renew_details));die;	
		
		if(empty($renew_details))
		{
			$this->session->unset_userdata("renew_login_data");
			$this->session->set_flashdata('error', 'Invalid Subscription Details');
		}
		$renew_details      = $renew_details[0];
		$cust_total_amount  = $renew_details['cust_subs_type_price'];
		$cust_subs_type_id  = $renew_details['cust_subs_type_id'];
		$cust_subs_type     = $renew_details['cust_subs_type'];
		$cust_gst           = $renew_details['cust_subs_type_gst'];
		$exclude_gst        = $renew_details['cust_subs_type_exclude_gst_price'];
		$cust_name          = $renew_details['customer_name'];
		$cust_contact_email = $renew_details['customer_contact_email'];
		$cust_contact       = $renew_details['customer_contact'];				 
		$params = array("one"=>"1",
				"two"=>"1",
				"three"=>"1",
				"four"=>$id,
				"five"=>Null,						
				"six"=>$cust_subs_type_id,						
				"seven"=>$cust_subs_type,						
				);
	
		$post_data   = $renew_details;
		$this->session->set_userdata("renew_params",$params);
		$charges_det = $this->getRazorPayOrderId($cust_total_amount,$id,$cust_contact);
		$charges     = $charges_det['raz_charges'];
		$order_id    = $charges_det['raz_id'];
		
		$post_data['order_id']     = $order_id;
		$post_data['charges']      = $charges;
		$post_data['cust_gst']     = $cust_gst;
		$post_data['exclude_gst']  = $exclude_gst;
		$total_amount              = $charges + $cust_total_amount;
		$post_data['total_amount'] = $total_amount;
		$post_data['comp_amount'] = $cust_total_amount;
		
		$this->session->set_userdata("renew_post_data",$post_data);            					
		$data['page_title']         ='Pay Now';  
		$data['return_url']         = site_url().'vendor/login/callback2';
		$data['surl']               = base_url().'vendor/login/success2';;
		$data['furl']               = base_url().'vendor/login/failed2';;
		$data['currency_code']      = 'INR';
		$data['productinfo']        = "Customer Subscription Info";
		$data['card_holder_name']   = $cust_name;
		$data['email']              = $cust_contact_email;
		$data['phone']              = $cust_contact;
		$data['charges']            = $charges;			
		$data['cust_gst']           = $cust_gst;			
		$data['order_id']           = $order_id;			
		$data['exclude_gst']        = $exclude_gst;			
		$data['total_amount']       = $total_amount;			
		$data['comp_amount']        = $cust_total_amount ;
		$this->load->view("pay_now",$data);
	}

	// callback method for Renew Customer Subscription
    public function callback2() {
		if (!empty($this->input->post('razorpay_payment_id'))) {
			$razorpay_payment_id  = $this->input->post('razorpay_payment_id');
			$razorpay_signature   = $this->input->post('razorpay_signature');
			$post_data            = $this->session->userdata('renew_post_data');
			$currency_code  	  = 'INR';
			//$total_amount       = $post_data['ctm_total_amt']+$post_data['charges'];
			// $total_amount 		  = $post_data['total_amount'];
			// $amount 		 	  = $total_amount*100;
			 // NEW: use only company amount (subscription amount)
			$comp_amount = $post_data['comp_amount'];        // NEW
			$amount      = $comp_amount * 100;               // NEW
			$success 			  = false;
			$error                = '';
					
			$success = true;

			
			if ($success === true) {
				
				$this->session->set_userdata('payment_success',"success");			
				
				// Add Params Details
				$params = 	$this->session->userdata('renew_params');			
				// $params['eight']    = $total_amount;
				$params['eight']    = $comp_amount;
				$params['nine']     = $razorpay_payment_id;
				$params['ten']      = $razorpay_payment_id;
				$params['eleven']   = $post_data['order_id'];
				$params['twelve']   = $razorpay_signature;

							// echo "<pre/>"; print_r(($params));die;					

			
				$response = $this->api->call_api('setRenewCustomerMandatoryDetails',$params);
				//log_message("error",json_encode($response));
				// log_message("error",json_encode($params));
				if($response=="Success")
				{
						$this->session->unset_userdata('renew_post_data');
						$this->session->unset_userdata('renew_login_data');
						$this->session->unset_userdata('renew_params');
						$this->session->set_flashdata('success', "Payment Successful..Subscription Renewed Successfully..");
						redirect(get_module()."/login");
					
				}else {
						$this->session->unset_userdata('renew_post_data');
						$this->session->unset_userdata('renew_login_data');
						$this->session->unset_userdata('renew_params');
						$this->session->set_flashdata('error', "Error : Payment Successful,But Not able to Renew Subscription .Please Contact Admin.");
						redirect(get_module()."/login");
						
				}
					
			} else {
				$this->session->set_flashdata('error', "Error : Payment Failed .Not able to Renew Subscription.");
				redirect(get_module()."/login");
			}
        } else {
            redirect("/404");	
        }
	
    } 

    public function success2() {
       $this->session->unset_userdata('renew_post_data');
	   $this->session->unset_userdata('renew_login_data');
	   $this->session->unset_userdata('renew_params');
       $this->session->set_flashdata('success', "Payment Successful..Subscription Renewed SuSuccessfully..");
	   redirect(get_module()."/login");
		
		
    }

    public function failed2() {
        $this->session->unset_userdata('renew_post_data');
		$this->session->unset_userdata('renew_login_data');
		$this->session->unset_userdata('renew_params');
		$this->session->set_flashdata("error","Error : Payment Failed .Not able to Renew Subscription");
		redirect(get_module()."/login");
	}
	  
	public function download_apk(){ 
		$this->load->helper('download') ;
		$file     = V_APK_URL;
		$fileName =  "MIBTrack.apk";
		$data = file_get_contents ( $file );
		force_download ( $fileName, $data );
	}
	
	public function get_branch_dashboard(){ 
		$branch_id = $this->input->post("p_branch");
		$branch_id = base64_decode($branch_id);
		
		$session_data = $this->session->userdata['login_data'];
		$role_id      =  $session_data['user_permission_id'];
		if(in_array($role_id,explode(",",CHANGE_BRANCH_ACCESS))){	  
			$this->session->set_userdata($session_data);
			$this->session->set_userdata('user_branch_id',$branch_id);
			$this->session->set_userdata('user_role_id', $session_data['user_permission_id']);
			$this->session->set_userdata('is_logged_in',true);
			$this->session->set_userdata('session_id',session_id());
			$params = array("one"=>$session_data['user_id'],
							"two"=>$session_data['user_branch_id'],
							"three"=>$session_data['user_company_id'],
							"four"=>"Active",
							"five"=>$branch_id);
							
			$details  = $this->api->call_api('getBranchMasterDetails',$params);
			$this->session->set_userdata('user_branch_name',$details[0]['branch_name']);
			$this->session->unset_userdata('login_data');
			redirect("dashboard");
		}
	}

	public function forgot_password(){
		$data['page_title']      = "Forgot Password";							
		$data['forgot_password'] = "forgot_password";							
		$this->load->library('form_validation');						
		// print_r(11111111111111); exit;				
		$this->form_validation->set_rules('mobile_no', 'Mobile No', 'required|trim|max_length[10]|min_length[10]|numeric');
																	
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module()."/login",$data); 
		}
		else
		{
			$mobile_no = $this->input->post("mobile_no",true);
			$params = array("one"=>"","two"=>"","three"=>"","four"=>$mobile_no,"five"=>"");
			$response = $this->api->call_v_api('getOTPForRegistered',$params);	
			
			//print_r($params);				
			///print_r($response);	die;			
			if($response == "Success"){
				$data['otp_sent'] = "otp_sent";	
				$this->session->set_userdata("reset_pwd_mobile",$mobile_no);
				$this->session->set_userdata("reset_pwd",$mobile_no);
				redirect(get_module()."/login/reset_password");
				
			} else{
				$this->session->set_flashdata("fp_error",$response);
				$this->session->set_flashdata("fp_mobile",$mobile_no);
				redirect(get_module()."/login/forgot_password");
			}
			
		}
	}
	public function validate_otp(){
		$login_data = $this->session->userdata("my_login_data");
		if(isset($login_data) && !empty($login_data)){
			
			$data['page_title']      = "Two Step Verification";							
			$data['validate_otp']    = "validate_otp";							
			$this->load->library('form_validation');		
								
			$this->form_validation->set_rules('otp', 'OTP', 'required|trim|max_length[10]');
																	
			if($this->form_validation->run() == FALSE)
			{
					$this->load->view(get_module()."/login",$data); 
			}
			else
			{
				$otp         = $this->input->post("otp",true);
				$remember    = $this->input->post("remember",true);
				$params = array("one"=>$login_data['input_username'],
								"two"=>$login_data['input_pwd'],
								"three"=>$login_data['input_cli_mac'],
								"four"=>$login_data['input_cli_name'],
								"five"=>$login_data['input_cli_ip'],
								"six"=>NULL,
								"seven"=>$login_data['user_mob'],
								"eight"=>$otp,
								"nine"=>$remember,
								"ten"=>$login_data['user_branch_id'],
								"eleven"=>$login_data['user_company_id'],
								);				
				$result = $this->api->call_v_api('getLoginVerifyDetails',$params);
				//echo "<pre/>"; print_r(json_encode($params));					
				//echo "<pre/>"; print_r($result);die;					
				if($result[0]['login_result'] == "Failed"){
					
					$this->session->set_flashdata("vo_error",$result[0]['login_msg']);
					redirect(get_module()."/login/validate_otp");
					
				} else if($result[0]['login_result'] == "Success"){
					$this->session->set_userdata('login_data',$result[0]);						
					if($result[0]['two_step_verify_status']=="Verified"){
					$role_id = $result[0]['user_permission_id'];					
							$this->session->unset_userdata('login_data');
							$vendor_data = $result[0];
							$vendor_data['user_role_id'] = $result[0]['user_permission_id'];
							$vendor_data['is_logged_in'] = true;
							$vendor_data['session_id']   = session_id();
							$this->session->set_userdata('vendor',$vendor_data);	
							redirect(get_module()."/dashboard");
						
					} else {
						
						$this->session->set_flashdata("vo_error",$result[0]['login_msg']);
						redirect(get_module()."/login/validate_otp");
					}
					
				
				} else {
					$this->session->set_flashdata("vo_error","Invalid Username-Password");
					redirect(get_module()."/login/validate_otp");
				}
			}

		} else {
				$this->session->set_flashdata("error",ERROR_MESSAGE);
				redirect(get_module()."/login");
		}
	}
	
	public function reset_password(){ 
	    $reset_pwd_mobile = $this->session->userdata("reset_pwd_mobile");
	    $reset_pwd = $this->session->userdata("reset_pwd");
		if(isset($reset_pwd) && isset($reset_pwd_mobile) && !empty($reset_pwd) && !empty($reset_pwd_mobile)){		   
			$data['page_title']        = "Reset Password";
			$data['reset_password']    = "reset_password";	
			$this->load->library('form_validation');
			
			$this->form_validation->set_rules('otp', 'OTP', 'required|trim|max_length[10]');
			$this->form_validation->set_rules('new_password', 'New Password', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('confirm_password', 'Confirm Password', 'required|trim|max_length[100]|matches[new_password]');
			
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module()."/login",$data); 
				
			}
			else 
			{ 
				$params = array("eight"=>$reset_pwd_mobile,
								"ten"=>$this->input->post("new_password",true),
								"eleven"=>$this->input->post("otp",true),						
								"twelve"=>"ForgotPassword",
								); 	
						
				$response = $this->api->call_v_api('resetLoginDetails',$params);			
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Password Changed successfully ');
						redirect(get_module()."/login");	
					
				} else if ($response=="Failed"){
						$this->session->set_flashdata('rp_error', ERROR_MESSAGE);
						redirect(get_module()."/login/reset_password");
				}else{
						$this->session->set_flashdata('rp_error', $response);
						redirect(get_module()."/login/reset_password");
				}
			}
		} else {
			$this->session->set_flashdata("error","Oops !..Something went wrong !!");
			redirect(get_module()."/login");
		}
	}
	
	public function register_now(){
		// print_r($this->input->post()); exit;
		$data['page_title']      = "Register Now";							
		$data['register_now']    = "register_now";							
		$this->load->library('form_validation');						
							
		$this->form_validation->set_rules('cust_name', 'Owner Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_website', 'Company Website', 'max_length[100]');
		$this->form_validation->set_rules('cust_comp_name', 'Company Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_contact_person', 'Contact Person', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_address', 'Customer Address', 'trim|max_length[500]');
		$this->form_validation->set_rules('cust_contact_email', 'Email ID', 'required|trim|max_length[100]|valid_email');
		$this->form_validation->set_rules('cust_contact', 'Contact No', 'required|trim|max_length[10]|min_length[10]|numeric');			
		$this->form_validation->set_rules('cust_panno', 'PAN No', 'trim|max_length[10]|min_length[10]');			
		$this->form_validation->set_rules('cust_id_num', 'GST No.', 'trim|max_length[50]');		    			
				
		if($this->form_validation->run() == FALSE)
		{
				$this->load->view("register",$data); 
		}
		else
		{
			$post_data = $this->input->post(null,true);
			// $pan_upload_error = $this->get_upload_error_message('cust_pan_img', 'PAN Image');
			// $id_upload_error = $this->get_upload_error_message('cust_id_img', 'Id Proof Image');

			if (!empty($pan_upload_error) || !empty($id_upload_error))
			{
				$this->session->set_flashdata("rn_error", trim($pan_upload_error.' '.$id_upload_error));
				redirect("/register-now");
			}
			
				// Image Upload
			$cust_pan_img = null;					
			$cust_id_img  = null;					
			if (!empty($_FILES['cust_id_img']['name']))
			{
				$ext = pathinfo($_FILES['cust_id_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['cust_id_img']['tmp_name'];
				$cust_id_img      = "CUST_ID_PROOF_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array("one"=>"1",
										"two"=>"1",
										"three"=>"1",
										"four"=>$cust_id_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"CustomersKYC"
										);
				$response = $this->api->call_api('uploadBitmap',$upload_params);
			}
			
			if (!empty($_FILES['cust_pan_img']['name']))
			{
				$ext = pathinfo($_FILES['cust_pan_img']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['cust_pan_img']['tmp_name'];
				$cust_pan_img     = "PAN_IMG_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array("one"=>"1",
										"two"=>"1",
										"three"=>"1",
										"four"=>$cust_pan_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"CustomersKYC"
										);
				$response = $this->api->call_api('uploadBitmap',$upload_params);
			}
		
			$params = array(
				"one"=>"1",
				"two"=>"1",
				"three"=>"1",
				"four"=>$post_data['cust_name'],
				"five"=>$post_data['cust_comp_name'],
				"six"=>$post_data['cust_contact'],
				"seven"=>$post_data['cust_contact_person'],
				"eight"=>$post_data['cust_contact_email'],
				"nine"=>!empty($post_data['cust_address']) ? $post_data['cust_address'] : Null,
				"ten"=>!empty($post_data['cust_website']) ? $post_data['cust_website'] : Null,
				"eleven"=>Null,
				"twelve"=>!empty($post_data['cust_panno']) ? $post_data['cust_panno'] : Null,
				"thirteen"=>$cust_pan_img,
				"fourteen"=>!empty($post_data['cust_id_num']) ? $post_data['cust_id_num'] : Null,
				"fifteen"=>$cust_id_img,
			);
			//log_message("error",json_encode($params));
			$response = $this->api->call_api('setCustomerBasicMasterDetails',$params);
			if($response == "Success"){
				$this->session->set_flashdata("rn_successs","Registered Successfully ");
				redirect("/login");
				
			} else{
				$this->session->set_flashdata("rn_error",ERROR_MESSAGE);
				redirect("/register-now");
			}		
		}
	}

	private function get_upload_error_message($field_name, $label)
	{
		if (empty($_FILES[$field_name]) || $_FILES[$field_name]['error'] == UPLOAD_ERR_OK)
		{
			return '';
		}

		if ($_FILES[$field_name]['error'] == UPLOAD_ERR_INI_SIZE || $_FILES[$field_name]['error'] == UPLOAD_ERR_FORM_SIZE)
		{
			return $label.' upload failed. Server upload limit is '.ini_get('upload_max_filesize').'.';
		}

		return $label.' upload failed. Please select the file again.';
	}
	
	/*********** Ajax Call*************/
	public function getBranchMasterDetails($branch_id = NULL, $status = "Active",$searchStr = NULL){ 
		$session_data = $this->session->userdata['login_data'];
		$params = array(
			"one"=>$session_data['user_id'],
			"two"=>$session_data['user_branch_id'],
			"three"=>$session_data['user_company_id'],
			"four"=>"Active"
		);
		$response = $this->api->call_api('getBranchMasterDetails',$params);
		return $response;
	}

	public function getCompanyType(){
		$params = array(
			"one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>"Active"
		);
		$response = $this->api->call_api('getCompanyTypeReportDetails',$params);
		return $response['jsArray'];
	} 

	public function getRazorPayOrderId($amount = NULL,$id = NULL,$cust_contact = NULL){
		$params = array(
			"one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>$amount,
			"five"=>$id,
			"six"=>$cust_contact,
		);
		$response = $this->api->call_api('getRazorPayOrderId',$params);
		return $response[0];
	}   
   
	public function getInvoiceType(){
		$params = array(
			"one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>"Active"
		);
		$response = $this->api->call_api('getMauliInvoicePatternMasterDetails',$params);
		return $response;
	} 

	public function getGSTType(){
		$list = array(
			"GST Applicable"=>"With GST",
			"GST Not Applicable"=>"No GST",
		);
		return $list;   
	} 

    public function getReferencedBy(){
		$params = array("one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>"Active",
		);
		$response  = $this->api->call_api('getReferenceByDetails',$params);
		return $response['jsArray'];   
   	} 

	public function getStateDetails(){
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>"Active",
			"five"=>"Report",
		);
		$response  = $this->api->call_api('getStateDetails',$params);
		return $response;   
	}

	public function getAreaCityIdDetails($state_id = NULL,$dist_id = NULL,$city_id = NULL){
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$state_id,
			"five"=>$dist_id,
			"six"=>$city_id,
			"seven"=>"Active",
			"eight"=>"Report",
			);
		$response  = $this->api->call_api('getAreaCityIdDetails',$params);
		return $response['jsArray'];    
	}  
	
	public function getDistrictStateIdDetails($state_id = NULL,$type = NULL, $status = "Active",$dist_id = NULL){
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$state_id,
			"five"=>$status,
			"six"=>$type,
			"seven"=>$dist_id
		);
		$response  = $this->api->call_api('getDistrictStateIdDetails',$params);
		return $response;   
	}

   	public function getCityDistrictIdDetails($state_id = NULL,$dist_id = NULL,$type = NULL, $status = "Active",$city_id = NULL,$page = NULL,$total_count = NULL){
	   	$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$state_id,
			"five"=>$dist_id,
			"six"=>$status,
			"seven"=>$type,
			"eight"=>$city_id,
			"offset"=>$page,
			"total_count"=>$total_count,
		);
	   	$response  = $this->api->call_api('getCityDistrictIdDetails',$params);
	  	return $response;   
   	}  
   
   	// Ajax Call To Registration Page
    public function checkIFSCExists(){
		$ifsc_code  = $this->input->post('emp_bank_ifsc_code');
		$ifsc_details = $this->api->check_ifsc($ifsc_code);
		$ifsc_details = json_decode($ifsc_details);
		if($ifsc_details=="Not Found")
		{
			echo json_encode(false);
		} else {
			echo json_encode(true);
		}

	}

	public function get_reference_details(){
		$reference_details = array();
		$ref_id = $this->input->post("ref_id");
		$params = array("one"=>"1",
						"two"=>"1",
						"three"=>"1",
						"five"=>$ref_id);

		$result = $this->api->call_api('getReferenceByDetails',$params);
		if(!empty($result['jsArray'])){
		$reference_details = $result['jsArray'][0];
		}
		echo json_encode($reference_details);   
	}  
	
	public function getIFSC(){
		$ifsc_code  = $this->input->post('ifsc_code');
		$ifsc_details = $this->api->check_ifsc($ifsc_code);
	    echo $ifsc_details;
	}

	public function get_state_list($type = "Report", $status = "Active",$state_id = NULL){
		$params = array("one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>$status,
			"five"=>$type,
			"six"=>$state_id
		);
		$response  = $this->api->call_api('getStateDetails',$params);
		echo json_encode($response);     
	}
		
	public function get_state_districts($state_id = NULL){
		$params = array("one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>$state_id,
			"five"=>"Active",
			"six"=>"Report",
		);
		$response  = $this->api->call_api('getDistrictStateIdDetails',$params);
		echo json_encode($response);   
	} 
		
	public function get_district_cities(){
		$dist_id = $this->input->post("dist_id");
		$state_id = $this->input->post("state_id");
		$params = array("one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>$state_id,
			"five"=>$dist_id,
			"six"=>"Active",
			"seven"=>"Report",
			);
		$response  = $this->api->call_api('getCityDistrictIdDetails',$params);
		echo json_encode($response['jsArray']);   
	} 

	public function get_city_area(){
		$dist_id = $this->input->post("dist_id");
		$state_id = $this->input->post("state_id");
		$city_id = $this->input->post("city_id");
		$params = array("one"=>"1",
			"two"=>"1",
			"three"=>"1",
			"four"=>$state_id,
			"five"=>$dist_id,
			"six"=>$city_id,
			"seven"=>"Active",
			"eight"=>"Report",
			);
		$response  = $this->api->call_api('getAreaCityIdDetails',$params);
		echo json_encode($response['jsArray']);   
	} 
		
	public function get_service_list(){
		$service_type = $this->input->post("service_type");
		$html = "";
		if($service_type == "AMC"){
			$params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"four"=>"Active",
						"five"=>"Report");
						
			$result = $this->api->call_api('getAMCDetails',$params);
			$list = $result['jsArray'];
			if(!empty($list)){
				foreach($list as $key=>$item)
				{
					if($key%2 == 0){
						$html .= "<tr>";
					}
					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='".$item['amc_id']."' onchange='get_amc_details(this);' /> &nbsp;".$item['amc_name']."</label></td>";
					
					if($key%2 == 1){
						$html .= "</tr>";
					}
				}					  
			}					  
		}
		if($service_type == "One Time Service"){
			$params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"four"=>"Active",
						"five"=>"Report");
						
			$result = $this->api->call_api('getOneTimeServiceMasterDetails',$params);
			$list = $result['jsArray'];
			if(!empty($list)){				  
				foreach($list as $key=>$item)
				{
					if($key%2 == 0){
					$html .= "<tr>";
					}
					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='".$item['ots_id']."' onchange='get_ots_details(this);' /> &nbsp;".$item['ots_name']."</label></td>";
					
					if($key%2 == 1){
					$html .= "</tr>";
					}
				}					  
			}					  
		}
		if($service_type == "Sales"){
			$params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"four"=>"Active",
						"five"=>"Report");
						
			$result = $this->api->call_api('getProductMasterDetails',$params);
			$list = $result['jsArray']; 
			if(!empty($list)){
				foreach($list as $key=>$item)
				{
					if($key%2 == 0){
					$html .= "<tr>";
					}
					
					$html .= "<td><lable><input type='checkbox' name='service_id[]' class='minimal' value='".$item['pm_id']."' onchange='get_product_details(this);' /> &nbsp;".$item['pm_name']."</label></td>";
					
					if($key%2 == 1){
					$html .= "</tr>";
					}
				}					  				  
			}					  				  
		}
		echo json_encode($html);   
	}  
	
    public function get_amc_details(){
		$amc_id        = $this->input->post("amc_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type     = $this->input->post("cust_type");
		
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"five"=>"Detail",
			"six"=>$amc_id);
		$result = $this->api->call_api('getAMCDetails',$params);
		$details = $result['jsArray'][0];

		$html = "<tr id='table_row_id_".$amc_id."'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_".$amc_id."'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='".$details['amc_id'] ."' /> 
		<table><tr><th colspan='2'>".$details['amc_name'] ." </th><tr/>
		<tr><th>Qunatity &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_qty'  type='number' min='1' maxlength='4' data-id='".$amc_id."' id='cust_pdt_qty_".$amc_id."' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);' /></td></tr>
		<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";
		
		if($cust_type == "Commercial"){						
			$price = $details['amc_corporate_price'];
			
		} else {						
			$price = $details['amc_price'];						
		}
		
		$html .= "<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='".$amc_id."'   id='cust_pdt_price_".$amc_id."' name='cust_pdt_price[]' value='".$price."' onchange='calculate_total(this);' /></td></tr>";
		if($cust_gst_type == "GST Applicable"){	
		
			if($cust_type == "Commercial"){						
				$amc_gst       = $details['amc_gst'];
				$amc_price_gst = $details['amc_corporate_price_gst'];
				
			} else {						
				$amc_gst       = $details['amc_gst'];
				$amc_price_gst = $details['amc_price_gst'];				
			}
			
		}else{
			
			if($cust_type == "Commercial"){						
				$amc_gst       = "0";
				$amc_price_gst = $details['amc_corporate_price'];
				
			} else {						
				$amc_gst       = "0";
				$amc_price_gst = $details['amc_price'];			
			}
			
			
			
		}
			$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='".$amc_id."'   id='cust_pdt_gst_price_".$amc_id."' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='".$amc_price_gst ."' readonly /><input id='cust_pdt_gst_".$amc_id."' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='".$amc_id."'  value='".$amc_gst ."'  /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' cols='12' rows='4' name='cust_deliver_address[]'  data-id='".$amc_id."'  placeholder='Enter Address' ></textarea></td>";
		
		$html .= '<td><table class="bordered" id="table_'.$amc_id.'" ><tr><th>Service Interval Date</th><td><a href="javascript:;"  class="btn btn-info btn-xs" onclick="add_row(this);" data-id="'.$amc_id.'" ><i class="fa fa-plus"></i> </a></td></tr>';

					
		$amc_noofservices = $details['amc_noofservices'];
		$amc_noofservices = !empty($amc_noofservices)?$amc_noofservices:0;
		$amc_duration = $details['amc_duration'];
		$amc_duration = !empty($amc_duration)?$amc_duration:0;
		
		if(!empty($amc_noofservices) && !empty($amc_duration)){
			$interval  = round($amc_duration/$amc_noofservices);
			for($i=0;$i<$amc_noofservices;$i++)
			{
				$date  = date('d-M-Y', strtotime(' + '.$i*$interval.' days')); 
				$html .= '<tr id ="row_id_'.$i."_".$amc_id.'" data-id="'.$i."_".$amc_id.'"><td><input type="text" name="cust_service_dates_'.$amc_id.'[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value="'.$date.'"> </td>
				<td><a href="javascript:;" onclick="delete_row(this);" data-id="'.$i."_".$amc_id.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>'	;
					
			}
		}
		$html .= '</table></td></tr>';
		echo json_encode($html);
	}
		   
	public function get_product_details(){
		$pm_id         = $this->input->post("pm_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type     = $this->input->post("cust_type");
		
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"five"=>"Detail",
			"six"=>$pm_id);
		$result = $this->api->call_api('getProductMasterDetails',$params);
		$details = $result['jsArray'][0];
		
		$html = "<tr id='table_row_id_".$pm_id."'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_".$pm_id."'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='".$details['pm_id'] ."' /> 
		<table><tr><td colspan='2'><b>".$details['pm_name'] ."</b><br/> Warrenty Period - ".$details['pm_warranty_period'] . " Model No :  ".$details['pm_model_name'] . " <br/></td><tr/>
		<tr><th>Qunatity &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_qty'  type='number' min='1' maxlength='4' data-id='".$pm_id."' id='cust_pdt_qty_".$pm_id."' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);' /></td></tr>
		<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";
		
		if($cust_type == "Commercial"){						
			$price = $details['pm_commercial_price'];
			
		} else {						
			$price = $details['pm_regular_price'];						
		}
		
		$html .= "<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='".$pm_id."'   id='cust_pdt_price_".$pm_id."' name='cust_pdt_price[]' value='".$price ."' onchange='calculate_total(this);' /></td></tr>";
		
		if($cust_gst_type == "GST Applicable"){					
			if($cust_type == "Commercial"){					
				$pm_gst       = $details['pm_gst'];
				$pm_price_gst = $details['pm_commercial_price_gst'];
			
			} else {						
				$pm_gst       = $details['pm_gst'];
				$pm_price_gst = $details['pm_regular_price_gst'];					
			}
			
		}else{
			
			if($cust_type == "Commercial"){					
				$pm_gst       = "0";
				$pm_price_gst = $details['pm_commercial_price'];
			
			} else {						
				$pm_gst       = "0";
				$pm_price_gst = $details['pm_regular_price'];					
			}
			
		}
			$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='".$pm_id."'   id='cust_pdt_gst_price_".$pm_id."' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='".$pm_price_gst ."' readonly /><input id='cust_pdt_gst_".$pm_id."' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='".$pm_id."'  value='".$pm_gst ."'  /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' cols='12' rows='4' name='cust_deliver_address[]'  data-id='".$pm_id."'  placeholder='Enter Address' ></textarea></td>";
		
		$html .= '<td><table class="bordered" id="table_'.$pm_id.'" ><tr><th>Service Interval Date</th><td><a href="javascript:;"  class="btn btn-info btn-xs" onclick="add_row(this);" data-id="'.$pm_id.'" ><i class="fa fa-plus"></i> </a></td></tr>';

					
		$pm_noofservices = $details['pm_noofserv'];
		$pm_sit          = $details['pm_sit'];
		$interval        = round($pm_sit/$pm_noofservices);
		for($i=0;$i<$pm_noofservices;$i++)
		{
			$date  = date('d-M-Y', strtotime(' + '.$i*$interval.' days')); 
			$html .= '<tr id ="row_id_'.$i."_".$pm_id.'" data-id="'.$i."_".$pm_id.'"><td><input type="text" name="cust_service_dates_'.$pm_id.'[]" placeholder="Service Date" class="form-control datepicker" maxlength="100" value="'.$date.'"> </td>
			<td><a href="javascript:;" onclick="delete_row(this);" data-id="'.$i."_".$pm_id.'" class="btn btn-danger btn-xs"><i class="fa fa-close"></i></a></td></tr>'	;
				
		}
		$html .= '</table></td></tr>';
		
		echo json_encode($html);
	}
		   
 	public function get_ots_details(){
		$ots_id        = $this->input->post("ots_id");
		$cust_gst_type = $this->input->post("cust_gst_type");
		$cust_type    = $this->input->post("cust_type");
		$params = array("one"=>$this->_user_id,
				"two"=>$this->_user_branch_id,
				"three"=>$this->_user_company_id,
				"five"=>"Detail",
				"six"=>$ots_id);
		$result = $this->api->call_api('getOneTimeServiceMasterDetails',$params);
		$details = $result['jsArray'][0];
		
		$html = "<tr id='table_row_id_".$ots_id."'><td  class='sr_no' style='vertical-align: middle;' id='srno_id_".$ots_id."'></td>";
		$html .= "<td style='vertical-align: top;'><input type='hidden' name='cust_service_id[]' value='".$details['ots_id'] ."' /> 
		<table><tr><th colspan='2'>".$details['ots_name'] ." </th><tr/>
		<tr><th>Qunatity &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_qty'  type='number' min='1' maxlength='4' data-id='".$ots_id."' id='cust_pdt_qty_".$ots_id."' name='cust_pdt_qty[]' value='1' onchange='calculate_total(this);' /></td></tr>
		<tr><th>Amt(For 1) &nbsp;: &nbsp;</th>";
		
		if($cust_type == "Commercial"){						
			$price = $details['ots_commerial'];
			
		} else {						
			$price = $details['ots_regular'];						
		}
		$html .="<td><input class='form-control cust_pdt_price' type='number' min='1'  maxlength='8' data-id='".$ots_id."'   id='cust_pdt_price_".$ots_id."' name='cust_pdt_price[]' value='".$price ."' onchange='calculate_total(this);' /></td></tr>";
		
		if($cust_gst_type == "GST Applicable"){			
		
			if($cust_type == "Commercial"){						
			$ots_gst       = $details['ots_gst'];
			$ots_price_gst = $details['ots_commerial_gst'];
			
			} else {						
				$ots_gst       = $details['ots_gst'];
				$ots_price_gst = $details['ots_regular_gst'];						
			}
			
		}else{
			
			$ots_gst       = "0";					
				if($cust_type == "Commercial"){						
				$ots_price_gst = $details['ots_commerial'];
			
			} else {						
				$ots_price_gst = $details['ots_regular'];						
			}
			
		}
			$html .= "<tr><th>Including GST &nbsp; : &nbsp;</th><td><input class='form-control cust_pdt_gst_price' data-id='".$ots_id."'   id='cust_pdt_gst_price_".$ots_id."' type='number' min='1' maxlength='8' name='cust_pdt_gst_price[]' value='".$ots_price_gst ."' readonly /><input id='cust_pdt_gst_".$ots_id."' class='cust_pdt_gst' type='hidden' name='cust_pdt_gst[]'  data-id='".$ots_id."'  value='".$ots_gst ."'  /></td></tr>";
		$html .= "</table></td>";
		$html .= "<td><textarea class='form-control' cols='12' rows='4' name='cust_deliver_address[]'  data-id='".$ots_id."'  placeholder='Enter Address' ></textarea></td>";
		
		$html .= '</tr>';
		
		echo json_encode($html);	
	} 

	public function get_OTP_for_registration(){ 
		if ($this->input->is_ajax_request()) {
			$mobile_no = $this->input->post('mobile_no');
			$email_id = $this->input->post('email_id');
		}
		$params = array("one"=>$mobile_no,"two"=>$email_id
		);
		$otp = $this->api->call_api('getOTPForUnregistered',$params);
		if($otp == "Success")
		{
			$this->session->set_userdata("verify_mobile",$mobile_no);
			$this->session->set_userdata("verify_email",$email_id);
		}
		if ($this->input->is_ajax_request()) {
			  echo json_encode($otp);
			  
		}else {
			return $otp;
		}
	}
	
	public function validate_reg_OTP(){ 
		if ($this->input->is_ajax_request()) {
			$otp 	   = $this->input->post('otp');
		}
		$mobile_no = $this->session->userdata("verify_mobile");
		$email_id  = $this->session->userdata("verify_email");
		
		$params = array("one"=>$mobile_no,"two"=>$otp);
		$otp_vldt = $this->api->call_api('getOTPValidations',$params);
		if($otp_vldt == "Success")
		{
			$this->session->unset_userdata("verify_mobile",$mobile_no);
			$this->session->unset_userdata("verify_email",$email_id);
		}
		if ($this->input->is_ajax_request()) {
			  echo json_encode($otp_vldt);
			  
		}else {
			return $otp_vldt;
		}
	}
}
