<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed'); 
class Inventory extends MY_Controller { // Main Controller
	
	public function __construct()
    {
        parent::__construct();
		$this->load->library('form_validation');
		// Load pagination library 
        $this->load->library('pagination'); 
		$this->perPage = MASTERS_PAGE_LIMIT; 
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
		}
    }	
	
	// Brand  Master 
	public function brand_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']   = "All Available Brand Report";
		$data['status_list']= array("Active","Deactivated");
		$this->loadViews(get_module().'/inventory/list_brand',$data); 
		
	}
	
	public function add_brand()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Brand";				
		$data['action']  	 = "Add";		
		$data['url']  	     = $url;		
		$this->form_validation->set_rules('brand_name','Brand Name', 'required|trim|max_length[100]');
					
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_brand', $data);				
				
		}
		else 
		{  	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('brand_name',true),
							);
			$response = $this->api->call_i_api('setInvItemBrandMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Brand Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/brand_report');
					}
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/brand_report');
					}
			}
	    }
	  
	}
	
	public function view_brand()
    {
		
		$data['page_title']  = "Brand Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemBrandMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_brand',$data); 
	 
	}
	
	public function edit_brand()
    {	
	   
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
			$data['page_title']  = "Update Brand Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemBrandMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Brand Details not found');
				redirect(get_module().'/inventory/brand_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('brand_name','Brand Name', 'required|trim|max_length[100]');
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_brand', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('brand_name',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemBrandMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Brand Details Updated successfully !!');
						redirect(get_module().'/inventory/brand_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/brand_report');
				}
			}

	}

	public function deactivate_brand()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Brand Details not found');
		    redirect(get_module().'/inventory/brand_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemBrandMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Brand Deactivated successfully ');
					redirect(get_module().'/inventory/brand_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/brand_report');
			}
	 

	}
	
	// Category  Master 
	public function category_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']   = "All Available Category Report";
		$data['status_list']= array("Active","Deactivated");
		$this->loadViews(get_module().'/inventory/list_category',$data); 
		
	}
	
	public function add_category()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Category";				
		$data['action']  	 = "Add";		
		$data['url']  	     = $url;		
		$this->form_validation->set_rules('cat_name','Category Name', 'required|trim|max_length[100]');
					
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_category', $data);				
				
		}
		else 
		{  	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('cat_name',true),
							);
			$response = $this->api->call_i_api('setInvItemCategoryMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Category Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/category_report');
					}
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/category_report');
					}
			}
	    }
	  
	}
	
	public function view_category()
    {
		
		$data['page_title']  = "Category Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemCategoryMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_category',$data); 
	 
	}
	
	public function edit_category()
    {	
	  
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
			$data['page_title']  = "Update Category Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemCategoryMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Category Details not found');
				redirect(get_module().'/inventory/category_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('cat_name','Category Name', 'required|trim|max_length[100]');
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_category', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('cat_name',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemCategoryMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Category Details Updated successfully !!');
						redirect(get_module().'/inventory/category_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/category_report');
				}
			}

	}

	public function deactivate_category()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Category Details not found');
		    redirect(get_module().'/inventory/category_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemCategoryMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Category Deactivated successfully ');
					redirect(get_module().'/inventory/category_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/category_report');
			}
	 

	}
	
	// Area  Master 
	public function area_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']   = "All Available Area Report";
		$data['status_list']= array("Active","Deactivated");
		$this->loadViews(get_module().'/inventory/list_area',$data); 
		
	}
	
	public function add_area()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Area";				
		$data['action']  	 = "Add";		
		$data['url']  	     = $url;		
		$this->form_validation->set_rules('area_name','Area Name', 'required|trim|max_length[100]');
					
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_area', $data);				
				
		}
		else 
		{  	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('area_name',true),
							);
			$response = $this->api->call_i_api('setInvItemAreaMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Area Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/area_report');
					}
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/area_report');
					}
			}
	    }
	  
	}
	
	public function view_area()
    {
		
		$data['page_title']  = "Area Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemAreaMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_area',$data); 
	 
	}
	
	public function edit_area()
    {	
	   
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
			$data['page_title']  = "Update Area Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemAreaMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Area Details not found');
				redirect(get_module().'/inventory/area_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('area_name','Area Name', 'required|trim|max_length[100]');
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_area', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('area_name',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemAreaMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Area Details Updated successfully !!');
						redirect(get_module().'/inventory/area_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/area_report');
				}
			}

	}

	public function deactivate_area()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Area Details not found');
		    redirect(get_module().'/inventory/area_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemAreaMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Area Deactivated successfully ');
					redirect(get_module().'/inventory/area_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/area_report');
			}
	 
	}
	
	// Unit Master 
	public function unit_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']   = "All Available Unit Report";
		$data['status_list']= array("Active","Deactivated");
		$this->loadViews(get_module().'/inventory/list_unit',$data); 
		
	}
	
	public function add_unit()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Unit";				
		$data['action']  	 = "Add";		
		$data['url']  	     = $url;		
		$this->form_validation->set_rules('unit_name','Unit Name', 'required|trim|max_length[100]');
					
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_unit', $data);				
				
		}
		else 
		{  	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('unit_name',true),
							);
			$response = $this->api->call_i_api('setInvItemUnitMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Unit Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/unit_report');
					}
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/unit_report');
					}
			}
	    }
	  
	}
	
	public function view_unit()
    {
		
		$data['page_title']  = "Unit Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemUnitMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_unit',$data); 
	 
	}
	
	public function edit_unit()
    {	
	   
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
			$data['page_title']  = "Update Unit Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemUnitMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Unit Details not found');
				redirect(get_module().'/inventory/unit_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('unit_name','Unit Name', 'required|trim|max_length[100]');
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_unit', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('unit_name',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemUnitMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Unit Details Updated successfully !!');
						redirect(get_module().'/inventory/unit_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/unit_report');
				}
			}

	}

	public function deactivate_unit()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Unit Details not found');
		    redirect(get_module().'/inventory/unit_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemUnitMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Unit Deactivated successfully ');
					redirect(get_module().'/inventory/unit_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/unit_report');
			}
	 

	}
	
	// Sub Category Master 
	public function sub_category_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Sub Category Report";
    	$data['status_list']   = array("Active","Deactivated");
		$data['category_list'] = $this->getInvItemCategoryReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_sub_category',$data);

	}
	
	public function add_sub_category()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Sub Category";				
		$data['action']  	 = "Add";	
		$data['url']  	     = $url;		
		$data['category_list'] = $this->getInvItemCategoryReportDetails(); 
		
		$this->form_validation->set_rules('cat_id','Category', 'required|trim');
		$this->form_validation->set_rules('subcat_name','Sub Category Name', 'required|trim|max_length[100]');
						
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_sub_category', $data);				
				
		}
		else 
		{ 
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('subcat_name',true),
							"six"=>$this->input->post('cat_id',true),
							);
			$response = $this->api->call_i_api('setInvItemSubCategoryMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Sub Category Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/sub_category_report');
					}
					
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/sub_category_report');
					}
			}
	    }
	  
	}
	
	public function edit_sub_category()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
			$data['page_title']  = "Update Sub Category Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$data['category_list'] = $this->getInvItemCategoryReportDetails();
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemSubCategoryMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Sub Category Details not found');
				redirect(get_module().'/inventory/sub_category_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('cat_id','Category', 'required|trim');
		    $this->form_validation->set_rules('subcat_name','Sub Category Name', 'required|trim|max_length[100]');
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_sub_category', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('subcat_name',true),
								"seven"=>$this->input->post('cat_id',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemSubCategoryMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Sub Category Details Updated successfully !!');
						redirect(get_module().'/inventory/sub_category_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/sub_category_report');
				}
			}
	}
	
	public function view_sub_category()
    {
		
		$data['page_title']  = "Sub Category Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemSubCategoryMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_sub_category',$data); 
	} 
	
	public function deactivate_sub_category()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Category Details not found');
		    redirect(get_module().'/inventory/sub_category_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemSubCategoryMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Sub Category Deactivated successfully ');
					redirect(get_module().'/inventory/sub_category_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/sub_category_report');
			}
	 
	}
	
	
	// Shelf Master 
	public function shelf_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Shelf Report";
    	$data['status_list']   = array("Active","Deactivated");
		$data['area_list']     = $this->getInvItemAreaReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_shelf',$data);

	}
	
	public function add_shelf()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Shelf";				
		$data['action']  	 = "Add";	
		$data['url']  	     = $url;		
		$data['area_list']     = $this->getInvItemAreaReportDetails();  
		
		$this->form_validation->set_rules('area_id','Area', 'required|trim');
		$this->form_validation->set_rules('shelf_name','Shelf Name', 'required|trim|max_length[100]');
						
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_shelf', $data);				
				
		}
		else 
		{ 
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('shelf_name',true),
							"six"=>$this->input->post('area_id',true),
							);
			$response = $this->api->call_i_api('setInvItemShelfMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Shelf Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/shelf_report');
					}
					
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/shelf_report');
					}
			}
	    }
	  
	}
	
	public function edit_shelf()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
			$data['page_title']  = "Update Shelf Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$data['area_list']   = $this->getInvItemAreaReportDetails(); 
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemShelfMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Shelf Details not found');
				redirect(get_module().'/inventory/shelf_report');
			} 
			$data['details']  = $details[0];
			$this->form_validation->set_rules('area_id','Area', 'required|trim');
		    $this->form_validation->set_rules('shelf_name','Shelf Name', 'required|trim|max_length[100]');
			
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_shelf', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('shelf_name',true),
								"seven"=>$this->input->post('area_id',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemShelfMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Shelf Details Updated successfully !!');
						redirect(get_module().'/inventory/shelf_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/shelf_report');
				}
			}
	}
	
	public function view_shelf()
    {
		
		$data['page_title']  = "Sub Category Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemShelfMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_shelf',$data); 
	} 
	
	public function deactivate_shelf()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Shelf Details not found');
		    redirect(get_module().'/inventory/shelf_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemShelfMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Shelf Deactivated successfully ');
					redirect(get_module().'/inventory/shelf_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/shelf_report');
			}
	 
	}
	
	
	
	// Sub Shelf Master 
	public function sub_shelf_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Sub Shelf Report";
    	$data['status_list']   = array("Active","Deactivated");
		$data['area_list']     = $this->getInvItemAreaReportDetails(); 
		$data['shelf_list']    = $this->getInvItemShelfReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_sub_shelf',$data);

	}
	
	public function add_sub_shelf()
    {
		
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Sub Shelf";				
		$data['action']  	 = "Add";	
		$data['url']  	     = $url;		
		$data['area_list']     = $this->getInvItemAreaReportDetails(); 
		//$data['shelf_list']    = $this->getInvItemShelfReportDetails();
		
		$this->form_validation->set_rules('area_id','Area', 'required|trim');
		$this->form_validation->set_rules('shelf_id','Shelf', 'required|trim');
		$this->form_validation->set_rules('sub_shelf_name','Sub Shelf Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('subshelf_disc','Sub Shelf Discount', 'max_length[10]');
						
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_sub_shelf', $data);				
				
		}
		else 
		{ 
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('sub_shelf_name',true),
							"six"=>$this->input->post('subshelf_disc',true),
							"seven"=>$this->input->post('shelf_id',true),
							"eight"=>$this->input->post('area_id',true),
							);
							//print_r($params);die;
			$response = $this->api->call_i_api('setInvItemSubShelfMasterDetails',$params);	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Sub Shelf Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/sub_shelf_report');
					}
					
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/sub_shelf_report');
					}
			}
	    }
	  
	}
	
	public function edit_sub_shelf()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
			$data['page_title']  = "Update Sub Shelf Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			$data['area_list']   = $this->getInvItemAreaReportDetails(); 
		    
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemSubShelfMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Sub Shelf Details not found');
				redirect(get_module().'/inventory/sub_shelf_report');
			} 
			$data['details']  = $details[0];
			$area_id          = $details[0]['area_id'];
			$data['shelf_list']  = $this->get_area_shelf_details($area_id);
			$this->form_validation->set_rules('area_id','Area', 'required|trim');
		    $this->form_validation->set_rules('shelf_id','Shelf', 'required|trim');
		    $this->form_validation->set_rules('sub_shelf_name','Sub Shelf Name', 'required|trim|max_length[100]');
		    $this->form_validation->set_rules('subshelf_disc','Sub Shelf Discount', 'max_length[10]');
			
					
			if($this->form_validation->run() == FALSE)
			{
				$this->load->view(get_module().'/inventory/add_edit_sub_shelf', $data);				
				
			}
			else 
			{ 
		
				$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>$this->_user_emp_id,
								"five"=>$ref_id,
								"six"=>$this->input->post('sub_shelf_name',true),
								"seven"=>$this->input->post('subshelf_disc',true),
								"eight"=>$this->input->post('shelf_id',true),
								"nine"=>$this->input->post('area_id',true),
								);
				$response = $this->api->call_i_api('setModifyInvItemShelfMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Sub Shelf Details Updated successfully !!');
						redirect(get_module().'/inventory/sub_shelf_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/sub_shelf_report');
				}
			}
	}
	
	public function view_sub_shelf()
    {
		
		$data['page_title']  = "Sub Shelf Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemSubShelfMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		} 
		$data['details']  = $details[0];
		$this->load->view(get_module().'/inventory/view_sub_shelf',$data); 
	} 
	
	public function deactivate_sub_shelf()
    {
		
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Sub Shelf Details not found');
		    redirect(get_module().'/inventory/sub_shelf_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemSubShelfMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Sub Shelf Deactivated successfully ');
					redirect(get_module().'/inventory/sub_shelf_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/sub_shelf_report');
			}
	 
	}

	// BARCODE 

	public function barcode_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Barcode Label Printing Details";
    	$data['status_list']   = array("Active","Deactivated");
      	$this->loadViews(get_module().'/inventory/barcode_report',$data);

	}


	public function add_barcode()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Add Barcode";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['item_list'] = $this->getInvItemMasterReportDetails(); 
		$data['brand_list']   = $this->getInvItemBrandReportDetails(); 
	    $data['area_list']     = $this->getInvItemAreaReportDetails(); 
	    $data['category_list'] = $this->getInvItemCategoryReportDetails(); 
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
	    $data['unit_list']     = $this->getInvItemUnitReportDetails(); 
		// echo "<pre/>"; print_r($data['item_list']);die;
		// $itemList = $data['item_list']
      	$this->loadViews(get_module().'/inventory/add_barcode',$data);

	}

	public function getInvItemMasterReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"six"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemMasterReportDetails',$params);
		   $result = $response['jsArray'];
		   return $result;
	}


	public function scan_barcode()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Add Scan Items Barcode";
		$month_year            = $this->input->get("month_year");
		$year                  = $this->input->get("year");
		$month_year            = !empty($month_year)?$month_year:date("m-Y");
		$year                  = !empty($year)?$year:date("Y");		
		$month_graph_data      = "";
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$month_year);		
		$month_graph_data = $this->api->call_v_api('getCustomerGraphMonthDetails',$params);
		
		$params["four"] = $year;		
		$year_graph_data = $this->api->call_v_api('getCustomerGraphYearDetails',$params);
		
		$data['year_graph_data']  =  json_encode($year_graph_data);
		$data['month_graph_data'] =  json_encode($month_graph_data);
		$data['month_year']       =  $month_year;
		$data['month_year_n']     =  date("M-Y",strtotime("1-".$month_year));
		$data['year']             =  $year;
		//print_r($data);die;
       	$this->loadViews(get_module().'/inventory/scan_barcode',$data);

	}

	public function modify_scan_barcode()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Modify Scan Items Barcode";
		$month_year            = $this->input->get("month_year");
		$year                  = $this->input->get("year");
		$month_year            = !empty($month_year)?$month_year:date("m-Y");
		$year                  = !empty($year)?$year:date("Y");		
		$month_graph_data      = "";
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$month_year);		
		$month_graph_data = $this->api->call_v_api('getCustomerGraphMonthDetails',$params);
		
		$params["four"] = $year;		
		$year_graph_data = $this->api->call_v_api('getCustomerGraphYearDetails',$params);
		
		$data['year_graph_data']  =  json_encode($year_graph_data);
		$data['month_graph_data'] =  json_encode($month_graph_data);
		$data['month_year']       =  $month_year;
		$data['month_year_n']     =  date("M-Y",strtotime("1-".$month_year));
		$data['year']             =  $year;
		//print_r($data);die;
       	$this->loadViews(get_module().'/inventory/modify_scan_barcode',$data);

	}

	public function print_lables()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Barcode Label Printing Details";
		$month_year            = $this->input->get("month_year");
		$year                  = $this->input->get("year");
		$month_year            = !empty($month_year)?$month_year:date("m-Y");
		$year                  = !empty($year)?$year:date("Y");		
		$month_graph_data      = "";
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$month_year);		
		$month_graph_data = $this->api->call_v_api('getCustomerGraphMonthDetails',$params);
		
		$params["four"] = $year;		
		$year_graph_data = $this->api->call_v_api('getCustomerGraphYearDetails',$params);
		
		$data['year_graph_data']  =  json_encode($year_graph_data);
		$data['month_graph_data'] =  json_encode($month_graph_data);
		$data['month_year']       =  $month_year;
		$data['month_year_n']     =  date("M-Y",strtotime("1-".$month_year));
		$data['year']             =  $year;
		//print_r($data);die;
       	$this->loadViews(get_module().'/inventory/print_lables',$data);

	}
	
	// Supplier Master 
	public function supplier_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Supplier Report";
    	$data['status_list']   = array("Active","Deactivated");
		
      	$this->loadViews(get_module().'/inventory/list_supplier',$data);

	}
	
	public function add_supplier()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$url = $this->input->get("url");
		$data['page_title']  = "Add New Supplier";				
		$data['action']  	 = "Add";	
		$data['url']  	     = $url;		
	    $data['state_list']       = $this->getStateDetails(); 
		$this->form_validation->set_rules('p_supp_name','Supplier Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_supp_desc','Supplier Description', 'required|trim|max_length[500]');
		$this->form_validation->set_rules('p_supp_det_mob1','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
		
		$this->form_validation->set_rules('p_supp_det_mob2','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('p_supp_det_landline','Landline No.', 'max_length[15]|numeric');
		$this->form_validation->set_rules('p_supp_det_faxno','Fax No.', 'max_length[15]|numeric');
		$this->form_validation->set_rules('p_supp_det_panno','Pan No.', 'required|trim|max_length[10]|min_length[10]');
		$this->form_validation->set_rules('p_supp_det_address','Address', 'required|trim|max_length[500]');		
		$this->form_validation->set_rules('p_supp_det_stateid','State', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_distid','District', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_cityid','City', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_area','Area', 'max_length[100]');
		$this->form_validation->set_rules('p_supp_det_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]|numeric');
		
		$this->form_validation->set_rules('p_supp_det_emailid','Email Id', 'required|trim|valid_email');
		$this->form_validation->set_rules('p_supp_det_gstno','GST No.', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_supp_det_otherdet','Other Details', 'max_length[500]');
		$this->form_validation->set_rules('p_supp_contact_det','Contact Person', 'max_length[500]');

						
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inventory/add_edit_supplier', $data);				
				
		}
		else 
		{ 
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('p_supp_name',true),
							"six"=>$this->input->post('p_supp_desc',true),
							"seven"=>$this->input->post('p_supp_det_mob1',true),
							"eight"=>$this->input->post('p_supp_det_mob2',true),
							"nine"=>$this->input->post('p_supp_det_landline',true),
							"ten"=>$this->input->post('p_supp_det_faxno',true),
							"eleven"=>$this->input->post('p_supp_det_panno',true),
							"twelve"=>$this->input->post('p_supp_det_address',true),
							"thirteen"=>$this->input->post('p_supp_det_stateid',true),
							"fourteen"=>$this->input->post('p_supp_det_distid',true),
							"fifteen"=>$this->input->post('p_supp_det_cityid',true),
							"sixteen"=>$this->input->post('p_supp_det_area',true),
							"seventeen"=>$this->input->post('p_supp_det_pincode',true),
							"eighteen"=>$this->input->post('p_supp_det_emailid',true),
							"nineteen"=>$this->input->post('p_supp_det_gstno',true),
							"twenty"=>$this->input->post('p_supp_det_otherdet',true),
							"twentyone"=>$this->input->post('p_supp_contact_det',true),
							
							);
							//print_r($params);die;
			$response = $this->api->call_i_api('setInvSupplierMasterDetails',$params);	
			//log_message("error",json_encode($params));		
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Supplier Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/supplier_report');
					}
					
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/supplier_report');
					}
			}
	    }
	  
	}




	public function edit_supplier()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
			$data['page_title']  = "Update Supplier Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']      = $ref_id;	
			
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvSupplierMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Supplier Details not found');
				redirect(get_module().'/inventory/supplier_report');
			} 
			$data['details']  = $details[0];
			$data['state_list']  = $this->getStateDetails();
            $supp_det_stateid    = $details[0]['supp_det_stateid'];
			$supp_det_distid     = $details[0]['supp_det_distid'];
			$data['dist_list']   = $this->getDistrictStateIdDetails($supp_det_stateid,"Report"); 
			$data['city_list']   = $this->getCityDistrictIdDetails($supp_det_stateid,$supp_det_distid,"Report");
			
 			
			$this->form_validation->set_rules('p_supp_name','Supplier Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_supp_desc','Supplier Description', 'required|trim|max_length[500]');
			$this->form_validation->set_rules('p_supp_det_mob1','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
			
			$this->form_validation->set_rules('p_supp_det_mob2','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
			$this->form_validation->set_rules('p_supp_det_landline','Landline No.', 'max_length[15]|numeric');
			$this->form_validation->set_rules('p_supp_det_faxno','Fax No.', 'max_length[15]|numeric');
			$this->form_validation->set_rules('p_supp_det_panno','Pan No.', 'required|trim|max_length[10]|min_length[10]');

			$this->form_validation->set_rules('p_supp_det_address','Address', 'required|trim|max_length[500]');		
			$this->form_validation->set_rules('p_supp_det_stateid','State', 'required|trim');
			$this->form_validation->set_rules('p_supp_det_distid','District', 'required|trim');
			$this->form_validation->set_rules('p_supp_det_cityid','City', 'required|trim');
			$this->form_validation->set_rules('p_supp_det_area','Area', 'max_length[100]');
			$this->form_validation->set_rules('p_supp_det_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]|numeric');
			
			$this->form_validation->set_rules('p_supp_det_emailid','Email Id', 'required|trim|valid_email');
			$this->form_validation->set_rules('p_supp_det_gstno','GST No.', 'required|trim|max_length[15]');
			$this->form_validation->set_rules('p_supp_det_otherdet','Other Details', 'max_length[500]');
			$this->form_validation->set_rules('p_supp_contact_det','Contact Person', 'max_length[500]');

			
					
			if($this->form_validation->run() == FALSE)
			{
				$this->loadViews(get_module().'/inventory/add_edit_supplier', $data);				
				
			}
			else 
			{ 
						$params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"four"=>$this->_user_emp_id,
						"five"=>$ref_id,
						"six"=>$this->input->post('supp_det_id',true),
						"seven"=>$this->input->post('p_supp_name',true),
						"eight"=>$this->input->post('p_supp_desc',true),
						"nine"=>$this->input->post('p_supp_det_mob1',true),
						"ten"=>$this->input->post('p_supp_det_mob2',true),
						"eleven"=>$this->input->post('p_supp_det_landline',true),
						"twelve"=>$this->input->post('p_supp_det_faxno',true),
						"thirteen"=>$this->input->post('p_supp_det_panno',true),
						"fourteen"=>$this->input->post('p_supp_det_address',true),
						"fifteen"=>$this->input->post('p_supp_det_stateid',true),
						"sixteen"=>$this->input->post('p_supp_det_distid',true),
						"seventeen"=>$this->input->post('p_supp_det_cityid',true),
						"eighteen"=>$this->input->post('p_supp_det_area',true),
						"nineteen"=>$this->input->post('p_supp_det_pincode',true),
						"twenty"=>$this->input->post('p_supp_det_emailid',true),
						"twentyone"=>$this->input->post('p_supp_det_gstno',true),
						"twentytwo"=>$this->input->post('p_supp_det_otherdet',true),
						"twentythree"=>$this->input->post('p_supp_contact_det',true),

						);

				$response = $this->api->call_i_api('setModifyInvSupplierMasterDetails',$params);	
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Supplier Details Updated successfully !!');
						redirect(get_module().'/inventory/supplier_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/supplier_report');
				}
			}
	}
	
	public function view_supplier()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Supplier Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvSupplierMasterDetails',$params);
		//echo "<pre/>"; print_r($details);die;

		if(empty($details)){
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_supplier',$data); 
	} 
	
	public function deactivate_supplier()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		$det_id  = $this->input->get("det_id");	
		if(empty($ref_id) || empty($det_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
		$ref_id = base64_decode($ref_id);
		$det_id = base64_decode($det_id);
		if(!is_numeric($ref_id) || !is_numeric($det_id))
		{
			$this->session->set_flashdata('error', 'Supplier Details not found');
		    redirect(get_module().'/inventory/supplier_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>$det_id	,	
		"seven"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvSupplierMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Supplier Deactivated successfully ');
					redirect(get_module().'/inventory/supplier_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/supplier_report');
			}
	 
	}


	// public function modify_supplier()
    // {
	// 	if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
	// 		redirect(get_module().'/dashboard/access_denied');
	// 	}
	// 	$ref_id = $this->input->get("ref_id");
	// 	if(empty($ref_id))
	// 	{
	// 		$this->session->set_flashdata('error', 'Item not found');
	// 	    redirect(get_module().'/inventory/supplier_report');
	// 	}
	// 	$ref_id = base64_decode($ref_id);
	// 	if(!is_numeric($ref_id))
	// 	{
	// 		$this->session->set_flashdata('error', 'Item Details not found');
	// 	    redirect(get_module().'/inventory/supplier_report');
	// 	}
	// 	$url = $this->input->get("url");
	// 	$data['page_title']  = "Modify Supplier";				
	// 	$data['action']  	 = "Add";	
	// 	$data['url']  	     = $url;		
	//     $data['state_list']       = $this->getStateDetails(); 
	// 	$this->form_validation->set_rules('p_supp_name','Supplier Name', 'required|trim|max_length[100]');
	// 	$this->form_validation->set_rules('p_supp_desc','Supplier Description', 'required|trim|max_length[500]');
	// 	$this->form_validation->set_rules('p_supp_det_mob1','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
		
	// 	$this->form_validation->set_rules('p_supp_det_mob2','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
	// 	$this->form_validation->set_rules('p_supp_det_landline','Landline No.', 'max_length[15]|numeric');
	// 	$this->form_validation->set_rules('p_supp_det_faxno','Fax No.', 'max_length[15]|numeric');
	// 	$this->form_validation->set_rules('p_supp_det_address','Address', 'required|trim|max_length[500]');		
	// 	$this->form_validation->set_rules('p_supp_det_stateid','State', 'required|trim');
	// 	$this->form_validation->set_rules('p_supp_det_distid','District', 'required|trim');
	// 	$this->form_validation->set_rules('p_supp_det_cityid','City', 'required|trim');
	// 	$this->form_validation->set_rules('p_supp_det_area','Area', 'max_length[100]');
	// 	$this->form_validation->set_rules('p_supp_det_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]|numeric');
		
	// 	$this->form_validation->set_rules('p_supp_det_emailid','Email Id', 'required|trim|valid_email');
	// 	$this->form_validation->set_rules('p_supp_det_gstno','GST No.', 'required|trim|max_length[15]');
	// 	$this->form_validation->set_rules('p_supp_det_otherdet','Other Details', 'max_length[500]');
	// 	$this->form_validation->set_rules('p_supp_contact_det','Contact Person', 'max_length[500]');
						
	// 	if($this->form_validation->run() == FALSE)
	// 	{
	// 		$this->loadViews(get_module().'/inventory/modify_supplier', $data);				
				
	// 	}
	// 	else 
	// 	{ 
	//        	$params = array("one"=>$this->_user_id,
	// 						"two"=>$this->_user_branch_id,
	// 						"three"=>$this->_user_company_id,
	// 						"four"=>$this->_user_emp_id,
	// 						"five"=>$this->input->post('p_supp_name',true),
	// 						"six"=>$this->input->post('p_supp_desc',true),
	// 						"seven"=>$this->input->post('p_supp_det_mob1',true),
	// 						"eight"=>$this->input->post('p_supp_det_mob2',true),
	// 						"nine"=>$this->input->post('p_supp_det_landline',true),
	// 						"ten"=>$this->input->post('p_supp_det_faxno',true),
	// 						"eleven"=>$this->input->post('p_supp_det_address',true),
	// 						"twelve"=>$this->input->post('p_supp_det_stateid',true),
	// 						"thirteen"=>$this->input->post('p_supp_det_distid',true),
	// 						"fourteen"=>$this->input->post('p_supp_det_cityid',true),
	// 						"fifteen"=>$this->input->post('p_supp_det_area',true),
	// 						"sixteen"=>$this->input->post('p_supp_det_pincode',true),
	// 						"seventeen"=>$this->input->post('p_supp_det_emailid',true),
	// 						"eighteen"=>$this->input->post('p_supp_det_gstno',true),
	// 						"nineteen"=>$this->input->post('p_supp_det_otherdet',true),
	// 						"twenty"=>$this->input->post('p_supp_contact_det',true),
	// 						);
	// 						//print_r($params);die;
	// 		$response = $this->api->call_i_api('setInvSupplierMasterDetails',$params);	
	// 		//log_message("error",json_encode($params));		
	// 		if($response=="Success"){
	// 				$this->session->set_flashdata('success', 'Modify Supplier Added successfully !!');
	// 				if(!empty($url))
	// 				{
	// 					redirect(get_module().'/inventory/'.$url);
						
	// 				}else { 
	// 					redirect(get_module().'/inventory/supplier_report');
	// 				}
					
				
	// 		} else{
	// 			    $this->session->set_flashdata('error', ERROR_MESSAGE);
	// 				if(!empty($url))
	// 				{
	// 					redirect(get_module().'/inventory/'.$url);
						
	// 				}else { 
	// 					redirect(get_module().'/inventory/supplier_report');
	// 				}
	// 		}
	//     }
	  
	// }

	//add inward

	public function inward_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Inward Report";
    	$data['status_list']   = array("Active","Deactivated");
		$data['brand_list']   = $this->getInvItemBrandReportDetails(); 
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_inward',$data);

	}

	public function add_inward()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$url = $this->input->get("url");
		$data['page_title']  = "Add Inward";				
		$data['action']  	 = "Add";	
		$data['url']  	     = $url;		
	    $data['state_list']       = $this->getStateDetails();
		$data['brand_list']    = $this->getInvItemBrandReportDetails(); 
		$data['supplier_list'] = $this->getInvSupplierReportDetails();
		$this->form_validation->set_rules('p_supp_name','Supplier Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_supp_desc','Supplier Description', 'required|trim|max_length[500]');
		$this->form_validation->set_rules('p_supp_det_mob1','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');
		
		$this->form_validation->set_rules('p_supp_det_mob2','Alternate Mobile No.', 'max_length[10]|min_length[10]|numeric');
		$this->form_validation->set_rules('p_supp_det_landline','Landline No.', 'max_length[15]|numeric');
		$this->form_validation->set_rules('p_supp_det_faxno','Fax No.', 'max_length[15]|numeric');
		$this->form_validation->set_rules('p_supp_det_address','Address', 'required|trim|max_length[500]');		
		$this->form_validation->set_rules('p_supp_det_stateid','State', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_distid','District', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_cityid','City', 'required|trim');
		$this->form_validation->set_rules('p_supp_det_area','Area', 'max_length[100]');
		$this->form_validation->set_rules('p_supp_det_pincode','Pincode', 'required|trim|max_length[6]|min_length[6]|numeric');
		$this->form_validation->set_rules('p_suplids[]','Supplier', 'required');
		$this->form_validation->set_rules('p_supp_det_emailid','Email Id', 'required|trim|valid_email');
		$this->form_validation->set_rules('p_supp_det_gstno','GST No.', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_supp_det_otherdet','Other Details', 'max_length[500]');

						
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inventory/add_inward', $data);				
				
		}
		else 
		{ 
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('p_supp_name',true),
							"six"=>$this->input->post('p_supp_desc',true),
							"seven"=>$this->input->post('p_supp_det_mob1',true),
							"eight"=>$this->input->post('p_supp_det_mob2',true),
							"nine"=>$this->input->post('p_supp_det_landline',true),
							"ten"=>$this->input->post('p_supp_det_faxno',true),
							"eleven"=>$this->input->post('p_supp_det_address',true),
							"twelve"=>$this->input->post('p_supp_det_stateid',true),
							"thirteen"=>$this->input->post('p_supp_det_distid',true),
							"fourteen"=>$this->input->post('p_supp_det_cityid',true),
							"fifteen"=>$this->input->post('p_supp_det_area',true),
							"sixteen"=>$this->input->post('p_supp_det_pincode',true),
							"seventeen"=>$this->input->post('p_supp_det_emailid',true),
							"eighteen"=>$this->input->post('p_supp_det_gstno',true),
							"nineteen"=>$this->input->post('p_supp_det_otherdet',true),
							);
							//print_r($params);die;
			$response = $this->api->call_i_api('setInvSupplierMasterDetails',$params);	
			//log_message("error",json_encode($params));	
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Inward Added successfully !!');
					if(!empty($url))
					{
						redirect(get_module().'/inventory/list_nward'.$url);
			
					}else { 
						redirect(get_module().'/inventory/list_inward');
					}
					
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					if(!empty($url))
					{
						redirect(get_module().'/inventory/'.$url);
						
					}else { 
						redirect(get_module().'/inventory/inward_report');
					}
			}
	    }
	  
	}
	
	
	
	// Supplier Liability Master 
	public function supplier_liability_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Supplier Liability Report";
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
    	$data['status_list']   = array("Active","Deactivated");
      	$this->loadViews(get_module().'/inventory/list_supplier_liabilities',$data);

	}
	public function view_supplier_liability()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Supplier Liability Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvSuppLiaMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_supplier_liability',$data); 
	} 


	// Item Master 
	public function item_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Item Report";
		$data['brand_list']   = $this->getInvItemBrandReportDetails(); 
	    $data['area_list']     = $this->getInvItemAreaReportDetails(); 
	    $data['category_list'] = $this->getInvItemCategoryReportDetails(); 
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
	    $data['unit_list']     = $this->getInvItemUnitReportDetails(); 
    	$data['status_list']   = array("Active","Deactivated");
      	$this->loadViews(get_module().'/inventory/list_item',$data);

	}
	
	public function add_item()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$url = $this->input->get("url");
		$data['page_title']    = "Add New Item";				
		$data['action']  	   = "Add";	
		$data['url']  	       = $url;		
	    $data['brand_list']    = $this->getInvItemBrandReportDetails(); 
	    $data['area_list']     = $this->getInvItemAreaReportDetails(); 
	    $data['category_list'] = $this->getInvItemCategoryReportDetails(); 
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
	    $data['unit_list']     = $this->getInvItemUnitReportDetails(); 
		
		$this->form_validation->set_rules('p_name','Item Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_desc','Item Description', 'required|trim|max_length[500]');
		$this->form_validation->set_rules('p_price','Purchase Price', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('p_price2','Sale Price', 'required|trim|max_length[8]');
		
		$this->form_validation->set_rules('p_bufferline','Bufferline', 'max_length[5]|numeric');
		$this->form_validation->set_rules('p_gst','GST %', 'max_length[5]');
		$this->form_validation->set_rules('p_no','Item No.', 'max_length[10]|numeric');
		$this->form_validation->set_rules('p_quantity','Quantity', 'max_length[5]|numeric');
		$this->form_validation->set_rules('p_unit','Unit', 'required|trim');
		$this->form_validation->set_rules('p_code','Item Code', 'required|trim|max_length[5]');
		$this->form_validation->set_rules('p_hsncode','HSN Code', 'max_length[8]');
		$this->form_validation->set_rules('p_capacity','Capacity', 'max_length[8]');
		$this->form_validation->set_rules('p_itempack','Pieces', 'required|trim|max_length[5]|numeric');	
		$this->form_validation->set_rules('p_suplids[]','Supplier', 'required');
		$this->form_validation->set_rules('p_barcode','Barcode', 'max_length[50]');
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inventory/add_edit_item', $data);				
				
		}
		else 
		{ 
		 
		    //print_r($this->input->post());die;
			$p_suplids = $this->input->post("p_suplids");
			$p_suplids = !empty($p_suplids)?implode(",",$p_suplids):"";
			
		    // Image Upload
			$p_image 	   = null;
			$p_multi_image = null;
			if (!empty($_FILES['p_multi_image']['name'][0]))
			{
				foreach($_FILES["p_multi_image"]["tmp_name"] as $key=>$tmp_name) 
				{
				$file_name  = $_FILES["p_multi_image"]["name"][$key];
				$file_tmp   = $_FILES["p_multi_image"]["tmp_name"][$key];
					
				$ext = pathinfo($file_name, PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile     = $file_tmp;
				$p_img = "INV_IMAGES_".$key.date("YmdHis").".".$ext;
				$p_multi_image = $p_multi_image.",".$p_img;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$p_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"Inv_Item"
										);
			    $response = $this->api->call_i_api('uploadBitmap',$upload_params);
				
				}
			}
			if (!empty($_FILES['p_image']['name']))
			{
				$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile     = $_FILES['p_image']['tmp_name'];
				$p_image = "INV_IMAGE_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$p_image,
										"five"=>base64_encode($img_file_content),
										"six"=>"Inv_Item"
										);
			  $response = $this->api->call_i_api('uploadBitmap',$upload_params);
			}
					
		
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('p_name',true),
							"six"=>$this->input->post('p_desc',true),
							"seven"=>$this->input->post('p_price',true),
							"eight"=>$this->input->post('p_price2',true),
							"nine"=>$this->input->post('p_bufferline',true),
							"ten"=>$this->input->post('p_areaid',true),
							"eleven"=>$this->input->post('p_shielfid',true),
							"twelve"=>$this->input->post('p_subshielfid',true),
							"thirteen"=>$this->input->post('p_catid',true),
							"fourteen"=>$this->input->post('p_subcatid',true),
							"fifteen"=>$this->input->post('p_gst',true),
							"sixteen"=>$this->input->post('p_no',true),
							"seventeen"=>$this->input->post('p_quantity',true),
							"eighteen"=>$this->input->post('p_unit',true),
							"nineteen"=>$this->input->post('p_brandid',true),
							"twenty"=>$this->input->post('p_code',true),
							"twentyone"=>$this->input->post('p_hsncode',true),
							"twentytwo"=>$this->input->post('p_capacity',true),
							"twentythree"=>NULL,
							"twentyfour"=>$this->input->post('p_itempack',true),
							"twentyfive"=>$p_suplids,
							"twentysix"=>$this->input->post('p_barcode',true),
							"twentyseven"=>$p_image,
							"twentyeight"=>$p_multi_image,
							);
							//print_r($params);die;
			$response = $this->api->call_i_api('setInvItemMasterDetails',$params);
			//log_message("error",json_encode($params));			
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Item Added successfully !!');
					
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					
			}
		   redirect(get_module().'/inventory/item_report');
	    }
	  
	}
	
	public function edit_item()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Item not found');
		    redirect(get_module().'/inventory/item_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		}
			$data['page_title']  = "Update Item Details";
			$data['action']  	 = "Edit";	
			$data['ref_id']        = $ref_id;	
			$data['brand_list']    = $this->getInvItemBrandReportDetails(); 
			$data['area_list']     = $this->getInvItemAreaReportDetails(); 
			$data['category_list'] = $this->getInvItemCategoryReportDetails(); 
			$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
			$data['unit_list']     = $this->getInvItemUnitReportDetails(); 
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvItemMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Item Details not found');
				redirect(get_module().'/inventory/item_report');
			} 
			$data['details']     = $details[0];       
			$cat_id              = $details[0]['inv_cat_id'];
			$area_id             = $details[0]['area_id'];
			$shelf_id            = $details[0]['shelf_id'];
			$data['sub_cat_list']    = $this->get_cat_subcat_details($cat_id);
			$data['shelf_list']      = $this->get_area_shelf_details($area_id);
			$data['sub_shelf_list']  = $this->get_shelf_subshelf_details($area_id,$shelf_id);
			
			$this->form_validation->set_rules('p_name','Item Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_desc','Item Description', 'required|trim|max_length[500]');
			$this->form_validation->set_rules('p_price','Purchase Price', 'required|trim|max_length[8]');
			$this->form_validation->set_rules('p_price2','Sale Price', 'required|trim|max_length[8]');
			
			$this->form_validation->set_rules('p_bufferline','Bufferline', 'max_length[5]|numeric');
			$this->form_validation->set_rules('p_gst','GST %', 'max_length[5]');
			$this->form_validation->set_rules('p_no','Item No.', 'max_length[10]|numeric');
			$this->form_validation->set_rules('p_quantity','Quantity', 'max_length[5]|numeric');
			$this->form_validation->set_rules('p_unit','Unit', 'required|trim');
			$this->form_validation->set_rules('p_code','Item Code', 'required|trim|max_length[5]');
			$this->form_validation->set_rules('p_hsncode','HSN Code', 'max_length[8]');
			$this->form_validation->set_rules('p_capacity','Capacity', 'max_length[8]');
			$this->form_validation->set_rules('p_itempack','Pieces', 'required|trim|max_length[5]|numeric');	
			$this->form_validation->set_rules('p_suplids[]','Supplier', 'required');
			$this->form_validation->set_rules('p_barcode','Barcode', 'max_length[50]');
			
					
			if($this->form_validation->run() == FALSE)
			{
				$this->loadViews(get_module().'/inventory/add_edit_item', $data);				
				
			}
			else 
			{ 
			
			// Old Images
				$im_image       = $details[0]['item_image'];		
	            $im_image  	    = explode("/",$im_image);
	            $im_image       = $im_image[count($im_image)-1];
						    
							
			//print_r($this->input->post());die;
			$p_suplids = $this->input->post("p_suplids");
			$p_suplids = !empty($p_suplids)?implode(",",$p_suplids):"";
				
		     // Image Upload
			$p_image 	          = $im_image;
			$str_image_list 	  = "";
				
		    $old_imgs  = $this->input->post('old_imgs');
			if(!empty($old_imgs))
			{
				$str_image_list = implode(",",$old_imgs);
				
			}
			
			$p_multi_image = $str_image_list;			
			
			if (!empty($_FILES['p_multi_image']['name'][0]))
			{
				foreach($_FILES["p_multi_image"]["tmp_name"] as $key=>$tmp_name) 
				{
				$file_name  = $_FILES["p_multi_image"]["name"][$key];
				$file_tmp   = $_FILES["p_multi_image"]["tmp_name"][$key];
					
				$ext = pathinfo($file_name, PATHINFO_EXTENSION);
				$upload_params = array();
				$imageFile     = $file_tmp;
				$p_img         = "INV_IMAGES_".$key.date("YmdHis").".".$ext;
				$p_multi_image = $p_multi_image.",".$p_img;
				$img_file_content = file_get_contents($imageFile);
				$upload_params = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$p_img,
										"five"=>base64_encode($img_file_content),
										"six"=>"AMC"
										);
			    $response = $this->api->call_i_api('uploadBitmap',$upload_params);
				
				}
			}
				if (!empty($_FILES['p_image']['name']))
				{
					$ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
					$upload_params = array();
					$imageFile     = $_FILES['p_image']['tmp_name'];
					$p_image = "INV_IMAGE_".date("YmdHis").".".$ext;
					$img_file_content = file_get_contents($imageFile);
					$upload_params = array("one"=>$this->_user_id,
											"two"=>$this->_user_branch_id,
											"three"=>$this->_user_company_id,
											"four"=>$p_image,
											"five"=>base64_encode($img_file_content),
											"six"=>"AMC"
											);
				  $response = $this->api->call_i_api('uploadBitmap',$upload_params);
				}
			      
					 	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$ref_id,
							"six"=>$this->input->post('p_name',true),
							"seven"=>$this->input->post('p_desc',true),
							"eight"=>$this->input->post('p_price',true),
							"nine"=>$this->input->post('p_price2',true),
							"ten"=>$this->input->post('p_bufferline',true),
							"eleven"=>$this->input->post('p_areaid',true),
							"twelve"=>$this->input->post('p_shielfid',true),
							"thirteen"=>$this->input->post('p_subshielfid',true),
							"fourteen"=>$this->input->post('p_catid',true),
							"fifteen"=>$this->input->post('p_subcatid',true),
							"sixteen"=>$this->input->post('p_gst',true),
							"seventeen"=>$this->input->post('p_no',true),
							"eighteen"=>$this->input->post('p_quantity',true),
							"nineteen"=>$this->input->post('p_unit',true),
							"twenty"=>$this->input->post('p_brandid',true),
							"twentyone"=>$this->input->post('p_code',true),
							"twentytwo"=>$this->input->post('p_hsncode',true),
							"twentythree"=>$this->input->post('p_capacity',true),
							"twentyfour"=>NULL,
							"twentyfive"=>$this->input->post('p_itempack',true),
							"twentysix"=>$p_suplids,
							"twentyseven"=>$this->input->post('p_barcode',true),
							"twentyeight"=>$p_image,
							"twentynine"=>$p_multi_image,
							);
				$response = $this->api->call_i_api('setModifyInvItemMasterDetails',$params);
				//log_message("error",json_encode($params));					
				//log_message("error",json_encode($response));					
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Item Details Updated successfully !!');
						redirect(get_module().'/inventory/item_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/item_report');
				}
			}
	}
	
	public function view_item()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Item Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvItemMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_item',$data); 
	} 
	
	public function deactivate_item()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Item Details not found');
		    redirect(get_module().'/inventory/item_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvItemMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Item Deactivated successfully ');
					redirect(get_module().'/inventory/item_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/item_report');
			}
	 
	}

	public function detail_item_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Item Report";
		$data['brand_list']   = $this->getInvItemBrandReportDetails(); 
	    $data['area_list']     = $this->getInvItemAreaReportDetails(); 
	    $data['category_list'] = $this->getInvItemCategoryReportDetails(); 
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
	    $data['unit_list']     = $this->getInvItemUnitReportDetails(); 
    	$data['status_list']   = array("Active","Deactivated");
      	$this->loadViews(get_module().'/inventory/detail_item_report',$data);

	}


	// Order Report 
	public function order_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Order Report";
		$data['status_list']   = array("Active","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_order',$data);

	}
	public function add_order()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}

		$data['page_title']    = "Add Order";				
		$data['action']        = "Add";				
	    $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
        $data['payment_mode_list']  = $this->getPaymentModes(); 
		
		$this->form_validation->set_rules('supplier_id','Supplier', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('det_id','Supplier', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('remark','Remark', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('order_date','Order Date', 'required|trim|max_length[15]');
		
		$this->form_validation->set_rules('item_id[]','Item', 'required');
		$this->form_validation->set_rules('price[]','Price', 'required');
		$this->form_validation->set_rules('qty[]','Qty', 'required');
		
		$this->form_validation->set_rules('p_receiptno','Receipt No.', 'trim|max_length[100]');
		$this->form_validation->set_rules('p_paiddate','Payment Date', 'trim|max_length[15]');
		$this->form_validation->set_rules('p_type','Payment Type', 'trim|max_length[15]');
		$this->form_validation->set_rules('p_amt','Paying Amount', 'trim|max_length[8]');
		$this->form_validation->set_rules('payment_remark','Payment Remark', 'trim|max_length[100]');
		
	    $p_type = $this->input->post("p_type");
		
		if($p_type == "Cheque") {
			$this->form_validation->set_rules('p_chqno','Cheque No.', 'required|trim|max_length[6]|min_length[6]|numeric');
			$this->form_validation->set_rules('p_chq_det','Cheque Details', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_chqdate','Cheque Date', 'required|trim|max_length[15]');
		}
		if($p_type == "Online") {
		$this->form_validation->set_rules('p_payid','Payment Id', 'required|trim|max_length[100]');
		}
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inventory/add_edit_order', $data);				
				
		}
		else 
		{ 
		 
		   // print_r($this->input->post());die;
			$order_date = $this->input->post("order_date");
			$order_date = !empty($order_date)?strtoupper(date("d-M-Y",strtotime($order_date))):strtoupper(date("d-M-Y"));
			
			$item_id = $this->input->post("item_id");
			$item_id = !empty($item_id)?implode(",",$item_id):"";
			
			$qty = $this->input->post("qty");
			$qty = !empty($qty)?implode(",",$qty):"";
			
			$price = $this->input->post("price");
			$price = !empty($price)?implode(",",$price):"";
			
		  	$p_chqdate = $this->input->post("p_chqdate");
			$p_chqdate = !empty($p_chqdate)?strtoupper(date("d-M-Y",strtotime($p_chqdate))):NULL;
			
			
			$p_paiddate = $this->input->post("p_paiddate");
			$p_paiddate = !empty($p_paiddate)?strtoupper(date("d-M-Y",strtotime($p_paiddate))):NULL;
		
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$order_date,
							"five"=>$this->input->post('remark',true),
							"six"=>$this->input->post('supplier_id',true),
							"seven"=>$this->input->post('det_id',true),
							"eight"=>$item_id,
							"nine"=>$qty,
							"ten"=>$price,
							"eleven"=>$p_paiddate,
							"twelve"=>Null,
							"thirteen"=>$this->input->post('p_receiptno',true),
							"fourteen"=>$this->input->post('p_amt',true),
							"fifteen"=>$this->input->post('p_type',true),
							"sixteen"=>$this->input->post('p_payid',true),
							"seventeen"=>NULL,
							"eighteen"=>NULL,
							"nineteen"=>NULL,
							"twenty"=>$p_chqdate,
							"twentyone"=>$this->input->post('p_chqno',true),
							"twentytwo"=>$this->input->post('p_chq_det',true),
							"twentythree"=>$this->input->post('payment_remark',true),				
							);
							
			$response = $this->api->call_i_api('setInvOrderMasterDetails',$params);
			//log_message("error",json_encode($params));			
			//log_message("error",json_encode($response));			
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Order Added successfully !!');
					
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					
			}
		   redirect(get_module().'/inventory/order_report');
	    }
	  
	}
	

	public function edit_order()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
			$data['page_title']  = "Update Order Details";
			$data['action']  	   = "Edit";	
			$data['ref_id']        = $ref_id;	
			$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
			$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		    $details = $this->api->call_i_api('getInvOrderMasterDetails',$params);
			if(empty($details)){
				$this->session->set_flashdata('error', 'Order Details not found');
				redirect(get_module().'/inventory/order_report');
			} 
			$data['details']     = $details[0];       
			$data['payment_mode_list']  = $this->getPaymentModes(); 			
		   $this->form_validation->set_rules('supplier_id','Supplier', 'required|trim|max_length[15]');
		   $this->form_validation->set_rules('det_id','Supplier', 'required|trim|max_length[15]');
		   $this->form_validation->set_rules('remark','Remark', 'required|trim|max_length[100]');
		   $this->form_validation->set_rules('order_date','Order Date', 'required|trim|max_length[15]');
		
		   $this->form_validation->set_rules('item_id[]','Item', 'required');
		   $this->form_validation->set_rules('price[]','Price', 'required');
			$this->form_validation->set_rules('qty[]','Qty', 'required');
	    $this->form_validation->set_rules('p_receiptno','Receipt No.', 'trim|max_length[100]');
		$this->form_validation->set_rules('p_paiddate','Payment Date', 'trim|max_length[15]');
		$this->form_validation->set_rules('p_type','Payment Type', 'trim|max_length[15]');
		$this->form_validation->set_rules('p_amt','Paying Amount', 'trim|max_length[8]');
		$this->form_validation->set_rules('payment_remark','Payment Remark', 'trim|max_length[100]');
		
	    $p_type = $this->input->post("p_type");
		
		if($p_type == "Cheque") {
			$this->form_validation->set_rules('p_chqno','Cheque No.', 'required|trim|max_length[6]|min_length[6]|numeric');
			$this->form_validation->set_rules('p_chq_det','Cheque Details', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_chqdate','Cheque Date', 'required|trim|max_length[15]');
		}
		if($p_type == "Online") {
		$this->form_validation->set_rules('p_payid','Payment Id', 'required|trim|max_length[100]');
		}
					
			if($this->form_validation->run() == FALSE)
			{
				$this->loadViews(get_module().'/inventory/add_edit_order', $data);				
				
			}
			else 
			{ 
					
			
			$order_date = $this->input->post("order_date");
			$order_date = !empty($order_date)?strtoupper(date("d-M-Y",strtotime($order_date))):strtoupper(date("d-M-Y"));
			
			$item_id = $this->input->post("item_id");
			$item_id = !empty($item_id)?implode(",",$item_id):"";
			
			$qty = $this->input->post("qty");
			$qty = !empty($qty)?implode(",",$qty):"";
			
			$price = $this->input->post("price");
			$price = !empty($price)?implode(",",$price):"";
			
		  	
		
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							"five"=>$order_date,
							"six"=>$this->input->post('remark',true),
							"seven"=>$this->input->post('supplier_id',true),
							"eight"=>$this->input->post('det_id',true),
							"nine"=>$item_id,
							"ten"=>$qty,
							"eleven"=>$price,
							"twelve"=>$p_paiddate,
							"thirteen"=>Null,
							"fourteen"=>$this->input->post('p_receiptno',true),
							"fifteen"=>$this->input->post('p_amt',true),
							"sixteen"=>$this->input->post('p_type',true),
							"seventeen"=>$this->input->post('p_payid',true),
							"eighteen"=>NULL,
							"nineteen"=>NULL,
							"twenty"=>NULL,
							"twentyone"=>$p_chqdate,
							"twentytwo"=>$this->input->post('p_chqno',true),
							"twentythree"=>$this->input->post('p_chq_det',true),
							"twentyfour"=>$this->input->post('payment_remark',true),
							);
							
				$response = $this->api->call_i_api('setModifyInvOrderMasterDetails',$params);		
				//log_message("error",json_encode($params));					
				//log_message("error",json_encode($response));					
				if($response=="Success"){
						$this->session->set_flashdata('success', 'Order Details Updated successfully !!');
						redirect(get_module().'/inventory/order_report');
					
				} else{
						$this->session->set_flashdata('error', ERROR_MESSAGE);
						redirect(get_module().'/inventory/order_report');
				}
			}
	}
	
	public function view_order()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Order Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvOrderMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_order',$data); 
	} 
	public function deactivate_order()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found');
		    redirect(get_module().'/inventory/order_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Deactivated",	
		);
		$response = $this->api->call_i_api('setDeactivateInvOrderMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Order Deactivated successfully ');
					redirect(get_module().'/inventory/order_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/order_report');
			}
	 
	}
	public function deactivate_order_item()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$order_id  = $this->input->get("order_id");	
		$det_id    = $this->input->get("det_id");	
		if(empty($order_id) || empty($det_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found1');
		    redirect(get_module().'/inventory/order_report');
		}
		$order_id = base64_decode($order_id);
		$det_id   = base64_decode($det_id);
		if(!is_numeric($order_id) || !is_numeric($det_id))
		{
			$this->session->set_flashdata('error', 'Order Details not found2');
		    redirect(get_module().'/inventory/order_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$order_id	,	
		"six"=>$det_id	,	
		"seven"=>"Deactivated",	
		);
		
		$response = $this->api->call_i_api('setDeactivateInvOrderDetailDetails',$params);
		//log_message("error",json_encode($params));
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Order Deactivated successfully ');
					redirect(get_module().'/inventory/order_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/order_report');
			}
	 
	}


// Supplier Payment 

public function supplier_payment()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Add Payment";
		$data['action']        = "Edit";	
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
		$data['payment_mode_list']  = $this->getPaymentModes(); 
		
      	// $this->loadViews(get_module().'/inventory/supplier_payment',$data);


		//   $this->form_validation->set_rules('p_supp_total_price','Amount', 'required');
		//   $this->form_validation->set_rules('p_supp_paying_amt','Amount', 'required');
		//   $this->form_validation->set_rules('p_supp_paid_ammount','Amount', 'required');
		//   $this->form_validation->set_rules('p_supp_balance_amt','Amount', 'required');


		//     $this->form_validation->set_rules('p_supp_rct','Reciept ID', 'required');
		//     $this->form_validation->set_rules('p_suplid','Supplier ID', 'required');
		  //   $this->form_validation->set_rules('p_suppdetid','Supplier Detail ID', 'required');

		  	$this->form_validation->set_rules('p_supp_rct', 'Receipt No.', 'required|trim');
			$this->form_validation->set_rules('p_suplid', 'Supplier ID', 'required|trim');
			$this->form_validation->set_rules('p_supp_inv', 'Supplier Invoice', 'required|trim');
			$this->form_validation->set_rules('p_supp_total_price', 'Total Price', 'required|trim|numeric');
			$this->form_validation->set_rules('p_supp_paid_ammount', 'Paid Amount', 'required|trim|numeric');
			$this->form_validation->set_rules('p_supp_paying_amt', 'Paying Amount', 'required|trim|numeric');

	
		  if($this->form_validation->run() == FALSE)
		  {
			$this->loadViews(get_module().'/inventory/supplier_payment',$data);			
				  
		  }
		  else 
		  {



			

				$p_supp_rct = !empty($post_data['p_supp_rct']) ? $post_data['p_supp_rct'] : null;
				$p_suplid = !empty($post_data['p_suplid']) ? $post_data['p_suplid'] : null;
				$p_supp_inv = !empty($post_data['p_supp_inv']) ? $post_data['p_supp_inv'] : null;
				$p_supp_total_price = !empty($post_data['p_supp_total_price']) ? $post_data['p_supp_total_price'] : null;
				$p_supp_paid_ammount = !empty($post_data['p_supp_paid_ammount']) ? $post_data['p_supp_paid_ammount'] : null;
				$p_supp_paying_amt = !empty($post_data['p_supp_paying_amt']) ? $post_data['p_supp_paying_amt'] : null;
				$pay_mode = !empty($post_data['pay_mode'])?$post_data['pay_mode']:Null;

		

				$params = array(
					"one" => $this->_user_id,
					"two" => $this->_user_branch_id,
					"three" => $this->_user_company_id,
					"four" => $this->_user_emp_id,
					"five" => $p_supp_rct,
					"six" => $p_suplid,
					"seven" => $p_supp_inv,
					"eight" => $p_supp_total_price,
					"nine" => $p_supp_paid_ammount,
					"ten" => $p_supp_paying_amt,
					"eleven" => $paying_amt,
					"twelve" => $discount,
					"p_supp_rct" => $p_supp_rct,
					"p_suplid" => $p_suplid,
					"p_supp_inv" => $p_supp_inv,
					"p_supp_total_price" => $p_supp_total_price,
					"p_supp_paid_ammount" => $p_supp_paid_ammount,
					"p_supp_paying_amt" => $p_supp_paying_amt,
					// Add other parameters here if needed
				);

			$this->loadViews(get_module().'/inventory/supplier_pay_det',$data);
		  }

	}

	public function supplier_pay_det()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Add Supplier Payment Details";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
		$data['state_list']       = $this->getStateDetails(); 
      	$this->loadViews(get_module().'/inventory/supplier_pay_det',$data);

	}

	// Payment Report 
	public function payment_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Payment Report";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
      	$this->loadViews(get_module().'/inventory/list_payment',$data);

	}
	
	public function add_payment()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
       $ref_id  = $this->input->get("ref_id");	
       $url     = $this->input->get("url");	
	  
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvSuppLiaMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Supplier Liability Details not found');
		    redirect(get_module().'/inventory/supplier_liability_report');
		} 
		$data['page_title']    = "Add Payment";				
		$data['action']        = "Add";				
		$data['url']           = $url;				
		$data['ref_id']        = $ref_id;				
	    $data['details']       = $details[0]; 
        $data['payment_mode_list']  = $this->getPaymentModes(); 
		
		$this->form_validation->set_rules('p_orderid','Order ID', 'required');
		$this->form_validation->set_rules('p_supp_lia_id','Liability ID', 'required');
		$this->form_validation->set_rules('p_suppid','Supplier ID', 'required');
		$this->form_validation->set_rules('p_suppdetid','Supplier Detail ID', 'required');

		$this->form_validation->set_rules('p_receiptno','Receipt No.', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_paiddate','Payment Date', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_type','Payment Type', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_amt','Paying Amount', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('payment_remark','Payment Remark', 'required|trim|max_length[100]');
		
		$p_type = $this->input->post("p_type");
		
		if($p_type == "Cheque") {
			$this->form_validation->set_rules('p_chqno','Cheque No.', 'required|trim|max_length[6]|min_length[6]|numeric');
			$this->form_validation->set_rules('p_chq_det','Cheque Details', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_chqdate','Cheque Date', 'required|trim|max_length[15]');
		}
		if($p_type == "Online") {
		$this->form_validation->set_rules('p_payid','Payment Id', 'required|trim|max_length[100]');
		}
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_edit_payment', $data);				
				
		}
		else 
		{ 
		 
		    //print_r($this->input->post());die;
			$p_chqdate = $this->input->post("p_chqdate");
			$p_chqdate = !empty($p_chqdate)?strtoupper(date("d-M-Y",strtotime($p_chqdate))):NULL;
			
			
			$p_paiddate = $this->input->post("p_paiddate");
			$p_paiddate = !empty($p_paiddate)?strtoupper(date("d-M-Y",strtotime($p_paiddate))):strtoupper(date("d-M-Y"));
			
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$this->input->post('p_orderid',true),
							"six"=>$this->input->post('p_supp_lia_id',true),
							"seven"=>$this->input->post('p_suppid',true),
							"eight"=>$this->input->post('p_suppdetid',true),
							"nine"=>$this->input->post('p_receiptno',true),
							"ten"=>$p_paiddate,
							"eleven"=>$this->input->post('p_amt',true),
							"twelve"=>$this->input->post('p_type',true),
							"thirteen"=>$this->input->post('p_payid',true),
							"fourteen"=>NULL,
							"fifteen"=>NULL,
							"sixteen"=>NULL,
							"seventeen"=>$p_chqdate,
							"eighteen"=>$this->input->post('p_chqno',true),
							"nineteen"=>$this->input->post('p_chq_det',true),
							"twenty"=>Null,
							"twentyone"=>$this->input->post('payment_remark',true),
							);
							
			$response = $this->api->call_i_api('setInvSuppPayMasterDetails',$params);
			//log_message("error",json_encode($params));			
			//log_message("error",json_encode($response));			
			if($response=="Success"){
					$this->session->set_flashdata('success', 'New Payment Added successfully !!');
					
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					
			}
			if(!empty($url))
			{
				 redirect(get_module()."/".$url);
			} else { 
		          redirect(get_module().'/inventory/supplier_liability_report');
			}
	    }
	  
	}
	public function view_payment()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Payment Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getInvSuppPayMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_payment',$data); 
	} 
	/* public function deactivate_payment()
    {
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$params = array("one"=>$this->_user_id,
		"two"=>$this->_user_branch_id,
		"three"=>$this->_user_company_id,
		"four"=>$this->_user_emp_id,
		"five"=>$ref_id	,	
		"six"=>"Cancel",	
		);
		log_message("error",json_encode($params));
		$response = $this->api->call_i_api('setDeactivateInvSuppPayMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Payment Cancelled successfully ');
					redirect(get_module().'/inventory/payment_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/payment_report');
			}
	 
	} */
	public function deactivate_payment()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Payment Details not found');
		    redirect(get_module().'/inventory/payment_report');
		}
		$data['page_title']  = "Cancel Payment";
		$data['ref_id']      = $ref_id;
		$data['action']  = "deactivate_payment";
		$this->form_validation->set_rules('reason','Reason', 'required|trim|max_length[500]');
		if($this->form_validation->run() == FALSE)
		{
			$html = $this->load->view(get_module().'/inventory/deactivation_popup', $data,true);				
			echo $html;			
			
		}
		else 
		{ 
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$this->_user_emp_id,
			"five"=>$ref_id	,	
			"six"=>"Cancel",	
			"seven"=>$this->input->post('reason',true),	
			);
		//log_message("error",json_encode($params));
		$response = $this->api->call_i_api('setDeactivateInvSuppPayMasterDetails',$params);
		if($response=="Success"){
					$this->session->set_flashdata('success', 'Payment Cancelled successfully ');
					redirect(get_module().'/inventory/payment_report');
				
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					redirect(get_module().'/inventory/payment_report');
			}
		}
	}

	// Stock Report 
	
	public function stock_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Item Stock Report";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
      	$this->loadViews(get_module().'/inventory/stock_report',$data);

	}
	public function inv_dashboard()
{
    if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
        redirect(get_module().'/dashboard/access_denied');
    }
    $data = array(); // Initialize $data
    $data['page_title']    = "Inv Dashboard";
    // $data['status_list']   = array("Active","Cancel","Deactivated");
    // $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
    $this->loadViews(get_module().'/inventory/inv_dashboard',$data);
}


	// Counter Billing
	public function counter_billing_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Counter Billing Report";
		$data['status_list']   = array("Active","Cancel","Deactivated");

	// 	$params = array("one"=>$this->_user_id,
	// 	"two"=>$this->_user_branch_id,
	// 	"three"=>$this->_user_company_id,
	// 	"four"=>"Active",

	// 	"limit"=>$this->perPage,
	// 	"offset"=>$page,
	// 	"total_count"=>$total_count,
	// 	);
	//    $result = $this->api->call_i_api('getCounterCustomerReportDetails',$params);
	 
	// $list = $result['jsArray'];
	// $total_count       = $result['total_count'];

	
	// 	echo "<pre/>"; print_r($list);die;

		$this->loadViews(get_module().'/inventory/list_counter_billing',$data);

	}

	

	// Sale Report 
	
	public function sale_report()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Sale Report";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 

		

      	$this->loadViews(get_module().'/inventory/sale_report',$data);

	}
	
		
	public function counter_billing()
    {
        if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "Counter Billing";				
		$data['action']        = "Add";				
	    $data['supplier_list']      = $this->getInvSupplierReportDetails(); 
        $data['payment_mode_list']  = $this->getPaymentModesForCounter(); 
		$data['brand_list']         = $this->getInvItemBrandReportDetails(); 
	    $data['area_list']          = $this->getInvItemAreaReportDetails(); 
	    $data['category_list']      = $this->getInvItemCategoryReportDetails(); 
	    $data['supplier_list']      = $this->getInvSupplierReportDetails(); 
	    $data['unit_list']          = $this->getInvItemUnitReportDetails(); 
	    
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"six"=>"Active",			
			);
	    $result = $this->api->call_i_api('getInvItemMasterReportDetails',$params);		 
	    $list = $result['jsArray'];
        $data['item_list']          = json_encode($list);


		$this->form_validation->set_rules('cust_name','Customer Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');			
		$this->form_validation->set_rules('cust_address','Address', 'required|trim|max_length[500]');
        $this->form_validation->set_rules('p_type','Payment Type', 'required|trim|max_length[15]');	
		$this->form_validation->set_rules('item_id[]','Item', 'required|trim|max_length[20]');
		$this->form_validation->set_rules('gst_price[]','GST Price', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('gst[]','GST %', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('qty[]','Qty', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('only_gst_price[]','Only GST Price', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('price[]','Price', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('total_price[]','Total Price', 'required|trim|max_length[10]');
		
		$this->form_validation->set_rules('paying_total','Payning Total', 'required|trim|max_length[10]');
		$this->form_validation->set_rules('grand_total','Grand Total', 'required|trim|max_length[10]');
		
	    $p_type = $this->input->post("p_type");
		
		
		if($p_type == "Balance") {
		     $this->form_validation->set_rules('cust_contact','Mobile No.', 'required|trim|max_length[10]|min_length[10]|numeric');	
		}
		if($this->form_validation->run() == FALSE)
		{
			$this->loadViews(get_module().'/inventory/counter_billing', $data);				
				
		}
		else 
		{ 
		 
		    //echo "<pre/>" ; print_r($this->input->post());die;
			$order_date = $this->input->post("order_date");
			$order_date = !empty($order_date)?strtoupper(date("d-M-Y",strtotime($order_date))):strtoupper(date("d-M-Y"));
			
			$item_id = $this->input->post("item_id");
			$item_id = !empty($item_id)?implode(",",$item_id):"";
			
			$qty = $this->input->post("qty");
			$qty = !empty($qty)?implode(",",$qty):"";
			
			$price = $this->input->post("price");
			$price = !empty($price)?implode(",",$price):"";
			
			$gst_price = $this->input->post("gst_price");
			$gst_price = !empty($gst_price)?implode(",",$gst_price):"";
			
			
			$p_paiddate = $this->input->post("p_paiddate");
			$p_paiddate = !empty($p_paiddate)?strtoupper(date("d-M-Y",strtotime($p_paiddate))):NULL;
		
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>NUll,
							"six"=>$this->input->post('cust_name',true),
							"seven"=>$this->input->post('cust_contact',true),
							"eight"=>NULL,
							"nine"=>$this->input->post('cust_address',true),
							"ten"=>Null,
							"eleven"=>Null,
							"twelve"=>Null,
							"thirteen"=>Null,
							"fourteen"=>$this->input->post('cust_gstno',true),
							"fifteen"=>NULL,
							"sixteen"=>NULL,
							"seventeen"=>NULL,
							"eighteen"=>NULL,
							"nineteen"=>NULL,
							"twenty"=>NULL,
							"twentyone"=>NULL,
							"twentytwo"=>NULL,
							"twentythree"=>"INV",				
							"twentyfour"=>$item_id,				
							"twentyfive"=>Null,				
							"twentysix"=>$qty,				
							"twentyseven"=>$gst_price,				
							"twentyeight"=>NULL,				
							"twentynine"=>$this->input->post('grand_total',true),				
							"thirty"=>NULL,				
							"thirtyone"=>$this->input->post('paying_total',true),				
							"thirtytwo"=>NULL,				
							"thirtythree"=>NULL,				
							"thirtyfour"=>NULL,				
							"thirtyfive"=>NULL,				
							"thirtysix"=>NULL,				
							"thirtyseven"=>NULL,				
							"thirtyeight"=>NULL,				
							"thirtynine"=>NULL,				
							"fourty"=>$this->input->post('p_type',true),		
							"fourtyone"=>$this->input->post('paying_total',true),				
							"fourtytwo"=>NULL,				
							"fourtythree"=>NULL,				
							"fourtyfour"=>NULL,				
							"fourtyfive"=>NULL,				
							"fourtysix"=>NULL,				
							"fourtyseven"=>NULL,				
							"fourtyeight"=>NULL,				
							"fourtynine"=>NULL,				
							"fifty"=>NULL,				
							"fiftyone"=>NULL,				
							"fiftytwo"=>NULL,				
							"fiftythree"=>NULL,				
							"fiftyfour"=>NULL,				
							"fiftyfive"=>NULL,				
							"fiftysix"=>NULL,				
							"fiftyseven"=>NULL,				
							"fiftyeight"=>NULL,				
							"fiftynine"=>NULL,				
							);
							
			$response = $this->api->call_i_api('setCounterCustomerMasterDetails',$params);
			//log_message("error",json_encode($params));			
			//log_message("error",json_encode($response));			
			if($response[0]['status']=="Success"){
					$this->session->set_flashdata('success', 'New Billing Added successfully !!');
                    $id = $response[0]['id'];
                    $params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$id,
							);
		            $response = $this->api->call_i_api('downloadCounterCustomerInvoiceDetails',$params);
					header('Content-Disposition: inline; filename="Bill_Invoice_'.Date("Y-m-d-h-i-s").'.pdf"');
					header('Content-Type: application/pdf'); 
					echo ($response);
					
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
                    redirect(get_module().'/inventory/counter_billing_report');
					
			}
		   
	    }
	  
	}
	public function view_counter_bill()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']  = "Counter Billing Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getCounterCustomerMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		} 
		$data['details']  = $details[0];
		$this->loadViews(get_module().'/inventory/view_counter_billing',$data); 
	} 
	public function print_bill()
    {
		
		$data['page_title']  = "Counter Billing Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$response = $this->api->call_i_api('downloadCounterCustomerInvoiceDetails',$params);
		header('Content-Disposition: inline; filename="Bill_Invoice_'.Date("Y-m-d-h-i-s").'.pdf"');
		header('Content-Type: application/pdf'); 
		echo ($response);
	}
    public function download_bill()
    {
		$data['page_title']  = "Counter Billing Master Report";	
		$ref_id  = $this->input->get("ref_id");	
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Billing Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$response = $this->api->call_i_api('downloadCounterCustomerInvoiceDetails',$params);
		header('Content-Disposition: attachment; filename="Bill_Invoice_'.Date("Y-m-d-h-i-s").'.pdf"');
		header('Content-Type: application/pdf'); 
		echo ($response);
	} 
	public function add_bill_payment()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
       $ref_id  = $this->input->get("ref_id");	
  
		if(empty($ref_id))
		{
			$this->session->set_flashdata('error', 'Bill Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$ref_id = base64_decode($ref_id);
		if(!is_numeric($ref_id))
		{
			$this->session->set_flashdata('error', 'Bill Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		}
		$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$ref_id,
							);
		$details = $this->api->call_i_api('getCounterCustomerMasterDetails',$params);
		if(empty($details)){
			$this->session->set_flashdata('error', 'Bill Details not found');
		    redirect(get_module().'/inventory/counter_billing_report');
		} 
		$data['page_title']    = "Add Bill Payment";				
		$data['action']        = "Add";				
		$data['ref_id']        = $ref_id;				
	    $data['details']       = $details[0]; 
        $data['payment_mode_list']  = $this->getBillPaymentModes(); 
		
		
		$this->form_validation->set_rules('ccbm_id','Payment Id', 'required');

		$this->form_validation->set_rules('p_receiptno','Receipt No.', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_bill_no','Bill No.', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('p_ui_bill_no','Bill Book No.', 'max_length[100]');
		$this->form_validation->set_rules('p_paiddate','Payment Date', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_type','Payment Type', 'required|trim|max_length[15]');
		$this->form_validation->set_rules('p_amt','Paying Amount', 'required|trim|max_length[8]');
		$this->form_validation->set_rules('payment_remark','Payment Remark', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('payment_terms','Payment Terms', 'max_length[100]');
		
		$p_type = $this->input->post("p_type");
		
		if($p_type == "Cheque") {
			$this->form_validation->set_rules('p_chqno','Cheque No.', 'required|trim|max_length[6]|min_length[6]|numeric');
			$this->form_validation->set_rules('p_chq_bank_name','Cheque Bank Name', 'required|trim|max_length[100]');
			$this->form_validation->set_rules('p_chqdate','Cheque Date', 'required|trim|max_length[15]');
			$this->form_validation->set_rules('p_chq_bounce_charges','Cheque Bounce Charges', 'max_length[8]');
            if (empty($_FILES['p_chequeimg']['name']))
			{
				$this->form_validation->set_rules('p_chequeimg', 'Cheque Image', 'required|trim');
			}
		}
		if($p_type == "Online") {
		$this->form_validation->set_rules('p_payid','Payment Id', 'required|trim|max_length[100]');
		}
       if($p_type == "Card") {
		$this->form_validation->set_rules('bank_name','Bank Name', 'required|trim|max_length[100]');
		$this->form_validation->set_rules('bank_details','Bank Details', 'required|trim|max_length[100]');
		}
		
		if($this->form_validation->run() == FALSE)
		{
			$this->load->view(get_module().'/inventory/add_bill_payment', $data);				
				
		}
		else 
		{ 
		 
		    //echo "<pre/>" ;print_r($this->input->post());die;
			$p_chqdate = $this->input->post("p_chqdate");
			$p_chqdate = !empty($p_chqdate)?strtoupper(date("d-M-Y",strtotime($p_chqdate))):NULL;

            $p_chequeimg = Null;
			if (!empty($_FILES['p_chequeimg']['name']))
			{
				$ext = pathinfo($_FILES['p_chequeimg']['name'], PATHINFO_EXTENSION);
				$upload_params    = array();
				$imageFile        = $_FILES['p_chequeimg']['tmp_name'];
				$p_chequeimg  = "Cheque_Img_".date("YmdHis").".".$ext;
				$img_file_content = file_get_contents($imageFile);
				$upload_params    = array("one"=>$this->_user_id,
										"two"=>$this->_user_branch_id,
										"three"=>$this->_user_company_id,
										"four"=>$p_chequeimg,
										"five"=>base64_encode($img_file_content),
										"six"=>"PAY_Cheque"
										);
			  $response = $this->api->call_i_api('uploadBitmap',$upload_params);
			}
			
			$p_paiddate = $this->input->post("p_paiddate");
			$p_paiddate = !empty($p_paiddate)?strtoupper(date("d-M-Y",strtotime($p_paiddate))):strtoupper(date("d-M-Y"));
			
	       	$params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>$this->_user_emp_id,
							"five"=>$ref_id,
							"six"=>$this->input->post('ccbm_id',true),
							"seven"=>$this->input->post('p_bill_no',true),
							"eight"=>$this->input->post('p_receiptno',true),
							"nine"=>$this->input->post('p_ui_bill_no',true),
							"ten"=>$this->input->post('p_type',true),
							"eleven"=>$this->input->post('p_amt',true),
							"twelve"=>$this->input->post('p_discount',true),
							"thirteen"=>$p_paiddate,
							"fourteen"=>$this->input->post('bank_details',true),
							"fifteen"=>$this->input->post('bank_name',true),
							"sixteen"=>$this->input->post('payment_remark',true),
							"seventeen"=>$this->input->post('payment_terms',true),
							"eighteen"=>$this->input->post('payment_remark',true),
							"nineteen"=>$this->input->post('p_chq_bank_name',true),
							"twenty"=>$this->input->post('p_chqno',true),
							"twentyone"=>$p_chequeimg,
							"twentytwo"=>$p_chqdate,
							"twentythree"=>$this->input->post('p_chq_bounce_charges',true),
							);
							
			$response = $this->api->call_i_api('setCounterCustomerPaymentDetails',$params);
			//log_message("error",json_encode($params));			
			//log_message("error",json_encode($response));			
			if($response[0]['status']=="Success"){
					$this->session->set_flashdata('success', 'New Bill Payment Added successfully !!');
					
			} else{
				    $this->session->set_flashdata('error', ERROR_MESSAGE);
					
			}
			redirect(get_module().'/inventory/view_counter_bill/?ref_id='.base64_encode($ref_id));
	    }
	  
	}
	
	
	public function download_billing_report()
    {
		$status               = $this->input->post('status');
		$date                 = $this->input->post('date');
		$month_year           = $this->input->post('month_year');
		$year                 = $this->input->post('year');
        $searchStr            = $this->input->post('searchStr');
		$searchStr            = addslashes($searchStr);	
		$date = !empty($date)?strtoupper(date("d-M-Y",strtotime($date))):Null;
		$month_year = !empty($month_year)?strtoupper(date("M-Y",strtotime("1-".$month_year))):Null;
		
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"seven"=>$date, 
			"eight"=>$month_year,
			"nine"=>$year, 
			);	
		
		  $response = $this->api->call_i_api('downloadCounterCustomerReportDetails',$params);
		// download file
        header('Content-Disposition: attachment; filename="Billing_Report_'.Date("Y-m-d-h-i-s").'.xlsx"');
		header("Content-Type: text/csv");		
		echo ($response);
		
	}

	// Payment Report 
	public function inv_item_util()
    {
		if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
			redirect(get_module().'/dashboard/access_denied');
		}
		$data['page_title']    = "All Available Payment Report";
		$data['status_list']   = array("Active","Cancel","Deactivated");
		$data['supplier_list'] = $this->getInvSupplierReportDetails(); 
      	$this->loadViews(get_module().'/inventory/inv_item_util',$data);

	}	


	public function getInvItemCategoryReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemCategoryReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function getInvItemAreaReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemAreaReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function getInvItemShelfReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemShelfReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function get_cat_subcat_details($cat_id = Null)
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"seven"=>$cat_id,
			);
	       $response = $this->api->call_i_api('getInvItemSubCategoryReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function get_area_shelf_details($area_id = Null)
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"seven"=>$area_id,
			);
	       $response = $this->api->call_i_api('getInvItemShelfReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function get_shelf_subshelf_details($area_id = Null,$shelf_id = Null)
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"seven"=>$area_id,
			"eight"=>$shelf_id,
			);
	       $response = $this->api->call_i_api('getInvItemSubShelfReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function getInvItemBrandReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemBrandReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function getInvSupplierReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvSupplierReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	public function getInvItemUnitReportDetails($status = "Active")
    {
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			);
	       $response = $this->api->call_i_api('getInvItemUnitReportDetails',$params);
		   $response = $response['jsArray'];
		   return $response;
	}
	
	
	public function getStateDetails()
   {
	   $params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>"Active",
			"five"=>"Report",
			);
	   $response  = $this->api->call_v_api('getStateDetails',$params);
	  return $response;   
   }
    public function getAreaCityIdDetails($state_id = NULL,$dist_id = NULL,$city_id = NULL)
		{
    		   $params = array("one"=>$this->_user_id,
					"two"=>$this->_user_branch_id,
					"three"=>$this->_user_company_id,
					"four"=>$state_id,
					"five"=>$dist_id,
					"six"=>$city_id,
					"seven"=>"Active",
					"eight"=>"Report",
					);
			   $response  = $this->api->call_v_api('getAreaCityIdDetails',$params);
			   return $response['jsArray'];    
		}  
		   
   public function getDistrictStateIdDetails($state_id = NULL,$type = NULL, $status = "Active",$dist_id = NULL)
   {
	   $params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$state_id,
			"five"=>$status,
			"six"=>$type,
			"seven"=>$dist_id
			);
	   $response  = $this->api->call_v_api('getDistrictStateIdDetails',$params);
	  return $response;   
   } 
   public function getCityDistrictIdDetails($state_id = NULL,$dist_id = NULL,$type = NULL, $status = "Active",$city_id = NULL,$page = NULL,$total_count = NULL)
   {
	   $params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$state_id,
			"five"=>$dist_id,
			"six"=>$status,
			"seven"=>$type,
			"eight"=>$city_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	   $response  = $this->api->call_v_api('getCityDistrictIdDetails',$params);
	  return $response['jsArray'];   
   }  
    public function getPaymentModes()
   {
	  $list = array("Cash"=>"Cash",
					 "Cheque"=>"Cheque",
			         "Online"=>"Online",
			        );
	  return $list;   
   }    
   public function getBillPaymentModes()
   {
	  $list = array("Cash"=>"Cash",
					 "Cheque"=>"Cheque",
                     "Card"=>"Card",
			         "Online"=>"Online",
			        );
	  return $list;   
   }    
   public function getPaymentModesForCounter()
   {
	  $list = array( "Cash"=>"Cash",
					 "Card"=>"Card",
			         "Online"=>"Online",
			         "Balance"=>"Balance",
			        );
	  return $list;   
   }
  public function check_access($class =Null, $method = Null){ 
	return true;
	   
   }	 	


public function supplier_detail_report()
   {
	   if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		   redirect(get_module().'/dashboard/access_denied');
	   }
	   $data['page_title']    = "Supplier Detail Report";
	   $data['status_list']   = array("Active","Cancel","Deactivated");
	   $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
		 $this->loadViews(get_module().'/inventory/supplier_detail_report',$data);

   }

   public function barcode_dt_report()
   {
	   if(!($this->check_access($this->router->fetch_class(),$this->router->fetch_method()))){
		   redirect(get_module().'/dashboard/access_denied');
	   }
	   $data['page_title']    = "Barcode Detail Report";
	   $data['status_list']   = array("Active","Cancel","Deactivated");
	   $data['supplier_list'] = $this->getInvSupplierReportDetails(); 
		 $this->loadViews(get_module().'/inventory/barcode_dt_report',$data);

   }

   //TESTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTTT





}


