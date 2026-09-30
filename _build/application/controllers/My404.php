<?php 
/*
 *  
 */
if (!defined('BASEPATH'))
exit('No direct script access allowed');
class My404 extends MY_Controller 
{

    public function __construct() 
	{				
        parent::__construct();
       }
 
    public function index() 
	{
		$data['page_title']      = "Page Not Found";	
		if($this->session->userdata('is_logged_in')){
			$this->output->set_status_header('404');
			$this->load->view('_parts/header',$data);
			$this->load->view('404',$data);
			$this->load->view('_parts/footer',$data);
		} else {
			$this->load->view('404_1',$data);
		}
	   
		
	}
}
?>