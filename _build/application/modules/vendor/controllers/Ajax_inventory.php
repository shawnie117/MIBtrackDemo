<?php 
(defined('BASEPATH')) OR exit('No direct script access allowed'); 
class Ajax_Inventory extends MY_Controller { // Main Controller
	
	public function __construct()
    {
        parent::__construct();
	
		// Load pagination library 
        $this->load->library('pagination'); 
		 // Per page limit 
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
		if (!$this->input->is_ajax_request()) {
			redirect(get_module().'/login');
		}			
	}
		
		public function get_shelf_subshelf()
	   {
		    $area_id = $this->input->post("area_id");
			$shelf_id = $this->input->post("shelf_id");
		    $params = array("one"=>$this->_user_id,
							"two"=>$this->_user_branch_id,
							"three"=>$this->_user_company_id,
							"four"=>"Active",
							"six"=>"",
							"seven"=>$area_id,
							"eight"=>$shelf_id);
	       $result = $this->api->call_i_api('getInvItemSubShelfReportDetails',$params);
		   $response = $result['jsArray'];
		   $html_data = '<option value="">Select Sub Shelf</option>';
		    if(!empty($response)){ 
              foreach($response as $item){
				$html_data .= '<option value="'.$item['subshelf_id'].'" >'.$item['subshelf_name'].'</option>';
			 }
			}
		   echo json_encode($html_data);   
	   } 
   
		public function get_area_shelf()
	   {
		   $area_id = $this->input->post("area_id");
		   $params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"four"=>"Active",
						"seven"=>$area_id);
	       $result    = $this->api->call_i_api('getInvItemShelfReportDetails',$params);
		   $response  = $result['jsArray'];
		   $html_data = '<option value="">Select Shelf</option>';
		    if(!empty($response)){ 
              foreach($response as $item){
				$html_data .= '<option value="'.$item['shelf_id'].'" >'.$item['shelf_name'].'</option>';
			 }
			}
		   echo json_encode($html_data);  
	   } 
	   
	//    added 14/03/2024
	   public function get_supplier_invoice()
	   {
		   $area_id = $this->input->post("area_id");
		   $params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id,
						"ten"=>$area_id);
	       $result    = $this->api->call_i_api('getInvOrderReportDetails',$params);
		   $response  = $result['jsArray'];
		   $html_data = '<option value="">Select Shelf</option>';
		    if(!empty($response)){ 
              foreach($response as $item){
				$html_data .= '<option value="'.$item['order_id'].'" >'.$item['order_id'].'</option>';
			 }
			}
		   echo json_encode($html_data);  
	   } 


	   public function get_supplier_invoice_detail()
	   {
		

		$reference_details = array();
		$area_id = $this->input->post("area_id");
		$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"twelve"=>$area_id);

			$result = $this->api->call_i_api('getInvSuppLiaReportDetails',$params);
			
			if(!empty($result['jsArray'])){
			$reference_details = $result['jsArray'][0];
			}
			echo json_encode($reference_details);   

	   } 
	   

	   public function get_cat_subcat()
	   {
		    $cat_id = $this->input->post("cat_id");
		    $params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>"Active",
			"seven"=>$cat_id,
			);
	       $result = $this->api->call_i_api('getInvItemSubCategoryReportDetails',$params);
		   $response  = $result['jsArray'];
		   $html_data = '<option value="">Select Sub Category</option>';
		    if(!empty($response)){ 
              foreach($response as $item){
				$html_data .= '<option value="'.$item['inv_subcat_id'].'" >'.$item['inv_subcat_name'].'</option>';
			 }
			}
		   echo json_encode($html_data);  
	   } 
	  public function get_state_list($type = "Report", $status = "Active",$state_id = NULL)
	   {
		   $params = array("one"=>$this->_user_id,
				"two"=>$this->_user_branch_id,
				"three"=>$this->_user_company_id,
				"four"=>$status,
				"five"=>$type,
				"six"=>$state_id
				);
		   $response  = $this->api->call_v_api('getStateDetails',$params);
		  echo json_encode($response);     
	   }
		
		public function get_state_districts($state_id = NULL)
		   {
			   $params = array("one"=>$this->_user_id,
					"two"=>$this->_user_branch_id,
					"three"=>$this->_user_company_id,
					"four"=>$state_id,
					"five"=>"Active",
					"six"=>"Report",
					);
			   $response  = $this->api->call_v_api('getDistrictStateIdDetails',$params);
			  echo json_encode($response);   
		   } 
		   
		 public function get_district_cities()
		   {
			   $dist_id = $this->input->post("dist_id");
			   $state_id = $this->input->post("state_id");
			   $params = array("one"=>$this->_user_id,
					"two"=>$this->_user_branch_id,
					"three"=>$this->_user_company_id,
					"four"=>$state_id,
					"five"=>$dist_id,
					"six"=>"Active",
					"seven"=>"Report",
					);
			   $response  = $this->api->call_v_api('getCityDistrictIdDetails',$params);
			  echo json_encode($response['jsArray']);   
		   }   
		   public function get_city_area()
		   {
			   $dist_id = $this->input->post("dist_id");
			   $state_id = $this->input->post("state_id");
			   $city_id = $this->input->post("city_id");
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
			  echo json_encode($response['jsArray']);   
		   }   
		   
		   public function get_customers()
		   {
			   	$params = array("one"=>$this->_user_id,
								"two"=>$this->_user_branch_id,
								"three"=>$this->_user_company_id,
								"four"=>"Active");

	           $result = $this->api->call_v_api('getCustomerMasterReportDetails',$params);
			   $customer_list = $result['jsArray'];
			   $html = "<option></option>";
			   if(!empty($customer_list)){
				 foreach($customer_list  as $customer){
					 $html .= "<option value='".$customer['customer_id']."'>".$customer['customer_name']." - ".$customer['customer_contact']."</option>";
				 }
			   }
			  echo json_encode($html);   
		   }     
		  
		  
		 
	
		   
		 
	
 // Brand  Report 
	public function tbl_brand_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('brand_post_data',$post_data);	
		$status               = $this->input->post('status');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('brand_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemBrandReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('brand_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_brand_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['inv_brand_id'];
					$name        = $item['inv_brand_name'];
					$status      = $item['inv_brand_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_brand/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_brand/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_brand/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
   // Category  Report 
	public function tbl_category_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('cat_post_data',$post_data);	
		$status               = $this->input->post('status');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('cat_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemCategoryReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('cat_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_category_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['inv_cat_id'];
					$name        = $item['inv_cat_name'];
					$status      = $item['inv_cat_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_category/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_category/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_category/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
    // Area  Report 
	public function tbl_area_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('area_post_data',$post_data);	
		$status               = $this->input->post('status');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('area_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemAreaReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('area_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_area_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['area_id'];
					$name        = $item['area_name'];
					$status      = $item['area_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_area/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_area/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_area/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	
	
	}
	
	// Unit  Report 
	public function tbl_unit_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('unit_post_data',$post_data);	
		$status               = $this->input->post('status');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('unit_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemUnitReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('unit_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_unit_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['inv_unit_id'];
					$name        = $item['inv_unit_name'];
					$status      = $item['inv_unit_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_unit/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_unit/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_unit/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='4' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Unit  Report 
	public function tbl_sub_category_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('sub_cat_post_data',$post_data);	
		$status               = $this->input->post('status');
		$cat_id               = $this->input->post('cat_id');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('sub_cat_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"seven"=>$cat_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemSubCategoryReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('sub_cat_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_sub_category_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['inv_subcat_id'];
					$name        = $item['inv_subcat_name'];
					$status      = $item['inv_subcat_status'];
					$cat_name    = $item['inv_cat_name'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_sub_category/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_sub_category/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_sub_category/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td>'.$cat_name.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='7' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Shelf  Report 
	public function tbl_shelf_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('shelf_post_data',$post_data);	
		$status               = $this->input->post('status');
		$area_id              = $this->input->post('area_id');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('shelf_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"seven"=>$area_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemShelfReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('shelf_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_shelf_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['shelf_id'];
					$name        = $item['shelf_name'];
					$status      = $item['shelf_status'];
					$area_name    = $item['area_name'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_shelf/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_shelf/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_shelf/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td>'.$area_name.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Sub Shelf  Report 
	public function tbl_sub_shelf_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('shelf_post_data',$post_data);	
		$status               = $this->input->post('status');
		$area_id              = $this->input->post('area_id');
		$shelf_id             = $this->input->post('shelf_id');
		$area_id              = $area_id?$area_id:Null;		
		$shelf_id             = $shelf_id?$shelf_id:Null;		
		$status               = $status?$status:"";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('shelf_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"seven"=>$area_id,
			"eight"=>$shelf_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemSubShelfReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('shelf_total_count',$total_count); 
		
		//echo "<pre/>"; print_r(json_encode($params));die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_sub_shelf_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['subshelf_id'];
					$name        = $item['subshelf_name'];
					$status      = $item['subshelf_status'];
					$shelf_name    = $item['shelf_name'];
					$area_name    = $item['area_name'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_sub_shelf/?ref_id='.$id.'" title="View Details" data-toggle="modal" data-target="#form_modal">'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_sub_shelf/?ref_id='.$id.'" title="Edit" data-toggle="modal" data-target="#form_modal"><i class="fa fa-edit"></i>Edit</a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_sub_shelf/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i>Deactivate</a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td>'.$area_name.'</td><td>'.$shelf_name.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Supplier  Report 
	public function tbl_supplier_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('supplier_post_data',$post_data);	
		$status               = $this->input->post('status');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('supplier_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvSupplierReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
		$this->session->set_userdata('supplier_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_supplier_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['supp_id'];
					$supp_det_id = $item['supp_det_id'];
					$name        = $item['supp_name'];
//changes 28-02-24 Dhanraj Kakade 
					$supp_det_contact = $item['supp_det_contact'];

					$status      = $item['supp_status'];
					$supp_det_mob1      = $item['supp_det_mob1'];
					$supp_det_address   = $item['supp_det_address'];
					$supp_det_id = base64_encode($supp_det_id);
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_supplier/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					if ($status == "Active") {
						$status_txt = "<span class='label label-success'>Active</span>";
					
						$action_txt = '<a class="btn btn-primary btn-xs" href="'.get_module_path() . 'inventory/edit_supplier/?ref_id=' . $id . '" title="Edit"><i class="fa fa-edit"></i></a>';
					
						$action_txt .= '&nbsp;<a class="btn btn-danger btn-xs" data-href="' . get_module_path() . 'inventory/deactivate_supplier/?ref_id=' . $id . '&det_id=' . $supp_det_id . '" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
						
						// Additional line added here
						$action_txt .= '&nbsp;<a class="btn btn-success btn-xs" href="' . get_module_path() . 'inventory/view_customer_subscriptions/' . $str . '" title="View Details" data-toggle="modal" data-target="#form_modal_lg"><i class="fa fa-eye"></i></a>';
					}
					
									
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td>'.$supp_det_contact.'</td><td style=word-break:break-all;">' .$supp_det_mob1.'</td><td>'.$supp_det_address.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='5' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Item  Report 
	public function tbl_item_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('item_post_data',$post_data);	
		$status               = $this->input->post('status');
		$brand_id             = $this->input->post('brand_id');
		$cat_id               = $this->input->post('p_catid');
		$sub_cat_id           = $this->input->post('p_subcatid');
		$area_id              = $this->input->post('p_areaid');
		$shelf_id             = $this->input->post('p_shielfid');
		$subshelf_id          = $this->input->post('p_subshielfid');
		$unit_id              = $this->input->post('p_unit');
		$supplier_id          = $this->input->post('p_suplid');
		$status               = $status?$status:"";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('item_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"five"=>$searchStr,
			"six"=>$status,
			"seven"=>$brand_id,
			"eight"=>$cat_id,
			"nine"=>$sub_cat_id,
			"ten"=>$area_id,
			"eleven"=>$shelf_id,
			"twelve"=>$subshelf_id,
			"thirteen"=>$unit_id,
			"fourteen"=>$supplier_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemMasterReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('item_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_item_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['item_id'];
					$name        = $item['item_name'];
					$item_price  = $item['item_price'];
					$item_price2 = $item['item_price2'];
					$status      = $item['item_status'];
					$inv_brand_name = $item['inv_brand_name'];
					$item_gst = $item['item_gst'];
					$item_qty = $item['item_qty'];
					$item_unitid = $item['item_unitid'];
					$item_bufferline = $item['item_bufferline'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_item/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_item/?ref_id='.$id.'" title="Edit" ><i class="fa fa-edit"></i></a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_item/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td>' .$item_price.'</td><td>' .$inv_brand_name.'</td><td>' .$item_gst.'</td><td>' .$item_unitid.'</td><td>' .$item_qty.'</td><td>' .$item_bufferline.'</td><td>' .$item_price2. '</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	








	// Supplier Liability  Report 
	public function tbl_supplier_liability_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('li_post_data',$post_data);	
		$status               = $this->input->post('status');
		$from_date            = $this->input->post('from_date');
		$to_date              = $this->input->post('to_date');
		$month_year           = $this->input->post('month_year');
		
		$from_date = !empty($from_date)?strtoupper(date("d-M-Y",strtotime($from_date))):Null;
		$to_date = !empty($to_date)?strtoupper(date("d-M-Y",strtotime($to_date))):Null;
		
		$supplier_id          = $this->input->post('p_suplid');
		$status               = $status?$status:"";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('li_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"seven"=>$searchStr,
			"eight"=>$from_date,
			"nine"=>$to_date,
			"ten"=>$month_year,
			"eleven"=>$supplier_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvSuppLiaReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('li_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_supplier_liability_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['supp_lia_id'];
					$name        = $item['supp_name'];
					$supp_lia_totalamt      = $item['supp_lia_totalamt'];
					$supp_lia_recvd_amt     = $item['supp_lia_recvd_amt'];
					$status                 = $item['supp_lia_status'];
					$supp_lia_gst_amt       = $item['supp_lia_gst_amt'];
					$supp_lia_grand_totamt  = $item['supp_lia_grand_totamt'];
					$supp_lia_bal_amt       = $item['supp_lia_bal_amt'];
					$supp_lia_orderid       = $item['supp_lia_orderid'];
					$supp_lia_sdate_n       = $item['supp_lia_sdate_n'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_supplier_liability/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td>'.$supp_lia_orderid.'</td><td>'.$supp_lia_totalamt.'</td><td>'.$supp_lia_grand_totamt.'</td><td>'.$supp_lia_recvd_amt.'</td><td>'.$supp_lia_bal_amt.'</td><td>'.$supp_lia_sdate_n.'</td><td style="text-align:center">'.$status_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Supplier Payment  Report 
	public function tbl_payment_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('pay_post_data',$post_data);	
		$status               = $this->input->post('status');
		$from_date            = $this->input->post('from_date');
		$to_date              = $this->input->post('to_date');
		$month_year           = $this->input->post('month_year');
		$order_id             = $this->input->post('order_id');
		
		$from_date = !empty($from_date)?strtoupper(date("d-M-Y",strtotime($from_date))):Null;
		$to_date = !empty($to_date)?strtoupper(date("d-M-Y",strtotime($to_date))):Null;
		
		$supplier_id          = $this->input->post('p_suplid');
		$status               = $status?$status:"";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('pay_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"seven"=>$searchStr,
			"eight"=>$from_date,
			"nine"=>$to_date,
			"ten"=>$month_year,
			"eleven"=>$supplier_id,
			"twelve"=>$order_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvSuppPayReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('pay_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_payment_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['supp_pay_id'];
					$name        = $item['supp_name'];
					$supp_pay_orderid       = $item['supp_pay_orderid'];
					$supp_pay_paiddate_n    = $item['supp_pay_paiddate_n'];
					$supp_pay_type          = $item['supp_pay_type'];
					$supp_pay_amt           = $item['supp_pay_amt'];
					$status                 = $item['supp_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_payment/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td>'.$supp_pay_orderid.'</td><td>'.$supp_pay_amt.'</td><td>'.$supp_pay_type.'</td><td>'.$supp_pay_paiddate_n.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	
	// Order  Report 
	public function tbl_order_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('order_post_data',$post_data);	
		$status               = $this->input->post('status');
		$from_date            = $this->input->post('from_date');
		$to_date              = $this->input->post('to_date');
		$month_year           = $this->input->post('month_year');
		
		$from_date = !empty($from_date)?strtoupper(date("d-M-Y",strtotime($from_date))):Null;
		$to_date = !empty($to_date)?strtoupper(date("d-M-Y",strtotime($to_date))):Null;
		
		$supplier_id          = $this->input->post('p_suplid');
		$status               = $status?$status:"";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('order_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"six"=>$searchStr,
			"seven"=>$from_date,
			"eight"=>$to_date,
			"nine"=>$month_year,
			"ten"=>$supplier_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvOrderReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('order_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_order_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['order_id'];
					$name        = $item['order_id'];
					$order_sdate_n  = $item['order_sdate_n'];
					$order_remarks  = $item['order_remarks'];
					$order_totamnt  = $item['order_totamnt'];
					$status         = $item['order_status'];
					$id          = base64_encode($id);
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$name_txt    =  '<a href="'.get_module_path().'inventory/view_order/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					  if($status == "Active"){
						   $status_txt = "<span class='label label-success'>Active</span>";
						   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_order/?ref_id='.$id.'" title="Edit" ><i class="fa fa-edit"></i></a>';
						   
						   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_order/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
						  						  
					   }	
					  					
					   if($status == "Deactivated" ){
						    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					   }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name_txt.'</td><td title="'.$order_remarks.'">'.$order_remarks.'</td><td>'.$order_totamnt.'</td><td>'.$order_sdate_n.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}

		// Inward Item  Report 
	public function tbl_inward_item_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('iitem_post_data',$post_data);	
		$status               = $this->input->post('status');
		$supplier_id          = $this->input->post('p_suplid');
		$status               = $status?$status:"Active";		
		$searchStr            = $this->input->post('searchStr');
		$total_count          = ($page==1)?Null:$this->session->userdata('iitem_total_count');
        $searchStr            = addslashes($searchStr);	
		$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"six"=>"Active",
			"fourteen"=>$supplier_id,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getInvItemMasterReportDetails',$params);
		 
	    $list = $result['jsArray'];
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('iitem_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_inward_item_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['item_id'];
					$name        = $item['item_name'];
					$item_price  = $item['item_price'];
					$item_price2 = $item['item_price2'];
					$status      = $item['item_status'];
					//$id          = base64_encode($id);
					$action_txt  = "";
					  
					   
				//$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$name.'</td><td>'.$item_price.'</td><td>'.$item_price2.'</td><td style="text-align:center">'.$status_txt.'</td><td style="text-align:center">'.$action_txt.'</td></tr>';
				
				$html .= '<tr><td><input type="checkbox" class="ckbox" name="item_id[]" value="'.$id.'" data-pp_id="'.$id.'" onchange="show_text_box(this);" /> &nbsp;'.$sr_no.'<br/><span class="text-danger chk_err"></span></td><td>'.$name.'</td><td>'.$item_price.'</td><td>'.$item_price2.'</td><td><input type="number" id="'.$id.'" class="form-control"  min="1" name="qty[]" value="1" placeholder="Qty" disabled /><td><input type="number" name="price[]" class="form-control '.$id.'" value="'.$item_price.'" disabled /> </td>></td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}

	public function tbl_counter_billing_list($page = 1)
    {
		$post_data            = $this->input->post(Null,true);
		$post_data['page']    = $page;
		$this->session->set_userdata('item_post_data',$post_data);	
		$status               = $this->input->post('status');
		$searchStr            = $this->input->post('searchStr');
		$month_year				=$this->input->post('month_year');
		$year				=$this->input->post('year');
		$date				=$this->input->post('date');
		$status               = $status?$status:"";		

		$total_count          = ($page==1)?Null:$this->session->userdata('item_total_count');
        $searchStr            = addslashes($searchStr);	
			$params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"five"=>$searchStr,
			"seven"=>$date,
			"eight"=>$month_year,
			"nine"=>$year,
			"limit"=>$this->perPage,
			"offset"=>$page,
			"total_count"=>$total_count,
			);
	       $result = $this->api->call_i_api('getCounterCustomerReportDetails',$params);
		 
	    $list = $result['jsArray'];
		
		$total_count       = $result['total_count'];	
			
		$this->session->set_userdata('item_total_count',$total_count); 
		
		//echo "<pre/>"; print_r($result);die;
		// Pagination configuration 		 
		$config['base_url']    = get_module_path().'ajax_inventory/tbl_counter_billing_list'; 
		$config['reuse_query_string'] = true;
		$config['total_rows']  = $total_count; 
		$config['per_page']    = $this->perPage; 
		$config['use_page_numbers'] = true;
		// Initialize pagination library 
		$this->pagination->initialize($config); 
		
		// Form Table
			$html = "";			
			if(!empty($list)){
				foreach($list as $key=>$item){
					$sr_no       = (($page-1)*$this->perPage)+($key+1);
					$id          = $item['cc_id'];
					$id          = base64_encode($id);
					$date        = $item['cc_sdate_n'];

					foreach ($item['payList'] as $payment) {
						$ccp_amount = $payment['ccp_amount'];
						$billno = $payment['ccp_billno'];
						
					}

					foreach ($item['billMaster']['billDetailList'] as $detail) {
						$ccbd_qty = $detail['ccbd_qty'];
						
					}

					$cc_name     = $item['cc_name'];
					$item_name =$item['item_list'];
					
					$cc_contact  = $item['cc_contact'];

					
					$action_txt  = "";
					$status_txt  = "<span class='label label-warning'>".$status."</span>";
					$billno    =  '<a href="'.get_module_path().'inventory/view_counter_bill/?ref_id='.$id.'" title="View Details" >'.$billno.'</a>';

					// $name_txt    =  '<a href="'.get_module_path().'inventory/view_supplier/?ref_id='.$id.'" title="View Details" >'.$name.'</a>';
					
					//   if($status == "Active"){
					// 	   $status_txt = "<span class='label label-success'>Active</span>";
					// 	   $action_txt =  '<a  class="btn btn-primary btn-xs"  href="'.get_module_path().'inventory/edit_item/?ref_id='.$id.'" title="Edit" ><i class="fa fa-edit"></i></a>';
						   
					// 	   $action_txt .= '&nbsp;<a  class="btn btn-danger btn-xs"  data-href="'.get_module_path().'inventory/deactivate_item/?ref_id='.$id.'" title="Deactivate" data-toggle="modal" data-target="#confirm-deactivate"><i class="fa fa-ban"></i></a>';
						  						  
					//    }	
					  					
					//    if($status == "Deactivated" ){
					// 	    $status_txt = "<span class='label label-danger'>Deactivated</span>";
					//    }
					   
				$html .= '<tr><td style="text-align:center;">'.$sr_no.'</td><td style="word-break:break-all;">'.$date.'</td><td>' .$billno.'</td><td>' .$ccp_amount.'</td><td>' .$cc_name.'</td><td>' .$cc_contact.'</td><td>' .$item_name.'</td><td>' .$ccbd_qty.'</td></tr>';
					
				   }
					
				}else { $html = "<tr><td valign='top' colspan='6' class='dataTables_empty'>No data available in table</td></tr>";	}
				
				$data['list']       = $html;	
				$data['pagination'] = $this->pagination->create_links();
				$data['total_count'] = $total_count;
				echo json_encode($data); 	

		 			
	}
	

		
	
	
	
}
