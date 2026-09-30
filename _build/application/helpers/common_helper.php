<?php defined('BASEPATH') OR exit('No direct script access allowed');

/********************************
Common Helper  :

/******* Generate Random Key of Specific Legnth *********/

	function getRandomKey($length) 
	{
       
	   if($length==8)
	   {
		  $keyset = "abcdefghijklm0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ@_"; 
	   }
	   else{
		   $keyset = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	   }
       $randkey = "";
       for ($i = 0; $i < $length; $i++)
           $randkey .= substr($keyset, rand(0, strlen($keyset) - 1), 1);
       return $randkey;
    }
	
/**********  generate Unique ID based on timestamp ***********/
	function uniqueID() {		
		
		$arrIp = explode('.', $_SERVER['REMOTE_ADDR']);
		
		list($usec, $sec) = explode(' ', microtime());
		
		$usec = (integer) ($usec * 65536);
		$sec = ((integer) $sec) & 0xFFFF;
		
		list($usec1, $sec1) = explode(' ', microtime());
		$strUid = str_replace(".", "", $sec1.$usec1);
		return $strUid;
	}
	
	
/**** Get IP Address Of Client Machin *********/
	function get_client_ip(){
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
	
	function ordinal($number) {
		$ends = array('th','st','nd','rd','th','th','th','th','th','th');
		if ((($number % 100) >= 11) && (($number % 100) <= 13))
			return $number. 'th';
		else
			return $number. $ends[$number % 10];
	}

	
if ( ! function_exists('check_file_exist'))
{
	
	function check_file_exist($path)
	{
	 	if(isset($path)){
			
			if(file_exists($path))
				return true;
			else
				return false;
			}
		
	}	
}	
	
function time_elapsed_string($datetime, $full = false) {
    $now = new DateTime;
    $ago = new DateTime($datetime);
    $diff = $now->diff($ago);

    $diff->w = floor($diff->d / 7);
    $diff->d -= $diff->w * 7;

    $string = array(
        'y' => 'year',
        'm' => 'month',
        'w' => 'week',
        'd' => 'day',
        'h' => 'hour',
        'i' => 'minute',
        's' => 'second',
    );
    foreach ($string as $k => &$v) {
        if ($diff->$k) {
            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
        } else {
            unset($string[$k]);
        }
    }

    if (!$full) $string = array_slice($string, 0, 1);
    return $string ? implode(', ', $string) . ' ago' : 'just now';
}
// This Function is for Xampp
function format_number($number=NULL)
{

    	if (($number < 0) || ($number > 999999999)) {
			throw new Exception("Number is out of range");
		}
		$Lk = floor($number / 100000);
		/* Millions (giga) */
		$number -= $Lk * 100000;
		$res = "";
		if ($Lk) {
			if($number ==0 ){
				$res .= $Lk.","."00,000";
			} 
			else if(strlen($number)==1)
			{
				$res .= $Lk.","."00,00".$number;
			}
			else if(strlen($number)==2)
			{
				$res .= $Lk.","."00,0".$number;
			}
			else if(strlen($number)==3)
			{
				$res .= $Lk.","."00,".$number;
			}
			else
			{
				$res .= $Lk.",".number_format($number);
			}
		} else 
		{ 
			$res .= number_format($number);
		}
		return $res;
}
// This Function is for Linux
function format_number1($number=NULL)
{

    	setlocale(LC_MONETARY, 'en_IN');
		$number = money_format('%!.0n', $number);
		return $number;
}


?>