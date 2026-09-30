<?php
 
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
 
/* load the MX_Router class */
require APPPATH . "third_party/MX/Controller.php";
 
/**
 * Description of my_controller
 *
 * @author http://roytuts.com
 */
class MY_Controller extends MX_Controller {
 
	protected $_user_id,$_role_id,$_is_logged_in,$_session_id,$_user_branch_id,$_user_company_id,$_user_emp_id,$_vendor_id,$_admin_id;
    function __construct() {
        parent::__construct();
        if (version_compare(CI_VERSION, '2.1.0', '<')) {
            $this->load->library('security');
        }
		if(!empty($_SESSION['user_id']))
		{
			$this->_admin_id 		= $this->session->userdata('user_id');
			$this->_user_id 		= $this->session->userdata('user_id');
			$this->_role_id 		= $this->session->userdata('user_role_id');
			$this->_is_logged_in 	= $this->session->userdata('is_logged_in');
			$this->_session_id 		= $this->session->userdata('session_id');
			$this->_user_branch_id  =  $this->session->userdata('user_branch_id');
			$this->_user_company_id =  $this->session->userdata('user_company_id');
			$this->_user_emp_id     =  $this->session->userdata('user_emp_id');
			$this->_user_permission_name =  $this->session->userdata('user_person_name');
		}else if(!empty($_SESSION['vendor']))
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
			$this->_user_permission_name =  $vendor['user_person_name'];
		}
						
    }
	
	function isLoggedIn()
     {
		if(!empty($this->_is_logged_in) && !empty($this->_admin_id))
		{
			return true;
		}else{
			return false;
		}
     }
	 
	 function isVendorLoggedIn()
     {
		if(!empty($this->_is_logged_in) && !empty($this->_vendor_id))
		{
			return true;
		}else{
			return false;
		}
     }
	
	public function loadViews($viewName = "", $data = NULL)
	{
		$data['header_menu_list'] = $this->get_menu_details();
		$header = '_parts/header';
		$footer = '_parts/footer';
		
		$this->load->view($header, $data);		
		$this->load->view($viewName, $data);
		$data['quick_br_list'] = $this->getBranchMasterDetails();
		$this->load->view($footer, $data);
			
		
	}
	
	
	public function uniqueID() {		
		
		$arrIp = explode('.', $_SERVER['REMOTE_ADDR']);
		
		list($usec, $sec) = explode(' ', microtime());
		
		$usec = (integer) ($usec * 65536);
		$sec = ((integer) $sec) & 0xFFFF;
		
		list($usec1, $sec1) = explode(' ', microtime());
		$strUid = str_replace(".", "", $sec1.$usec1);
		return $strUid;
	}
	
	public function get_client_ip(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
		   $ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		return $ipaddress;
	}
	
	public function get_client_mac(){
		$MAC = '';
		$MAC = exec('getmac');   
        // Storing 'getmac' value in $MAC 
        $MAC = strtok($MAC, ' '); 
		return $MAC;
	}
	public function get_client_hostname(){
		$hostname = gethostname();
    	return $hostname;
	}
	
	public function isSuperAdmin()
	{  
		if (!empty($this->_role_id) && !empty($this->_admin_id) &&($this->_role_id == SUPER_ADMIN_ROLE_ID)) {
			return true;
		} else {
			return false;
		}
	}   
	public function isVendor()
	{  
		if (!empty($this->_vendor_id)) {
			return true;
		} else {
			return false;
		}
	}   
	public function isVendorSuperAdmin()
	{  
		if (!empty($this->_role_id) && ($this->_role_id == SUPER_ADMIN_ROLE_ID)) {
			return true;
		} else {
			return false;
		}
	}   
	public function get_menu_details()
	{  
		$params = array("one"=>$this->_user_id,
						"two"=>$this->_user_branch_id,
						"three"=>$this->_user_company_id);
	    if(!empty($this->_admin_id)){
		$response = $this->api->call_api('getMenuDashboardWebDetails',$params);
		} 
      else if(!empty($this->_vendor_id)){
			$response = $this->api->call_v_api('getMenuDashboardWebDetails',$params);
		}
		return $response;
			
	}
	
	  public function getBranchMasterDetails($branch_id = NULL, $status = "Active",$searchStr = NULL)
   {
	   $params = array("one"=>$this->_user_id,
			"two"=>$this->_user_branch_id,
			"three"=>$this->_user_company_id,
			"four"=>$status,
			"five"=>$branch_id,
			"six"=>$searchStr
			);
		 if(!empty($this->_admin_id)){
		$response  = $this->api->call_api('getBranchMasterDetails',$params);
		} else if(!empty($this->_vendor_id)) {
			$response  = $this->api->call_v_api('getBranchMasterDetails',$params);
		}	
	   
	  return $response;   
   }
	
	
}
 
/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */