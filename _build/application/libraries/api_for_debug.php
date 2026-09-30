<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * CodeIgniter API Library Used for calling API
 
 */
class Api
{
    private $api_url = "http://localhost:8080/order_now_server/rest/menuService/";	

    public function call_api($method=Null,$param=array(),$type="POST")
    {
		if(empty($method))
		{
			return "Method name should not be blank";
		} else {
		try {
			$param['authApiKey'] = APIKEY;
				
			$curl = curl_init();
			
			 // Check if initialization had gone wrong*    
			if ($curl === false) {
				throw new Exception('failed to initialize');
			}
			curl_setopt($curl, CURLOPT_URL, $this->api_url.$method);
			
			if($type=="POST"){
				curl_setopt($curl, CURLOPT_POST, 1);
				curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
				curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($param));
				
			}
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			
		    // Check the return value of curl_exec(), too
			if ($response === false) {
				throw new Exception(curl_error($curl), curl_errno($curl));
			}
			
			curl_close($curl);
			$response = is_string($response) && is_array(json_decode($response, true)) && (json_last_error() == JSON_ERROR_NONE) ? json_decode($response,true) : $response;		
			return $response;
			
			} catch(Exception $e) {

			trigger_error(sprintf(
					'Curl failed with error #%d: %s',
					$e->getCode(), $e->getMessage()),
					E_USER_ERROR);
			
			
		}
	  }
    } 
	
	public function check_ifsc($ifsc = null)
    {
		    $api_url = "https://ifsc.razorpay.com/".$ifsc;	
			$curl = curl_init($api_url);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($curl);
			curl_close($curl);
			return $response;
    }


}