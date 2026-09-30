<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
defined('SHOW_DEBUG_BACKTRACE') OR define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
defined('FILE_READ_MODE')  OR define('FILE_READ_MODE', 0644);
defined('FILE_WRITE_MODE') OR define('FILE_WRITE_MODE', 0666);
defined('DIR_READ_MODE')   OR define('DIR_READ_MODE', 0755);
defined('DIR_WRITE_MODE')  OR define('DIR_WRITE_MODE', 0755);




/* User Defined Conatsnts */

define ("REQUIRED_STAR", '<span style="color: red">*</span>');
define ("LOGO_PATH", "assets/images/logo2.png");
define ("ACCESS_DENIED_IMAGE_PATH", "assets/images/access_denied.png");
define ("EXCEL_DOWNLOAD_PATH", "assets/downloads/");
define ("SUPER_ADMIN_ROLE_ID", "1");
define ("ADMIN_ROLE_ID", "2");
define ("SALES_ROLE_ID", "3");
define ("TECHNICIAN_ROLE_ID", "4");
define ("CUSTOMER_ROLE_ID", "5");
define ("SUB_ADMIN_ROLE_ID", "7");


define ("MASTERS_PAGE_LIMIT", "10");



define ("USER_TYPE_ADMIN_ACCESS", "1,2,3,");
define ("CHANGE_BRANCH_ACCESS", "1,");
define ("ERROR_MESSAGE", "Error: Please try after some time");

define ("SITE_NAME", "Mauli BTrack");
define ("V_SITE_NAME", "MIBTrack Vendor");

define ("APIKEY", "zpfkenaojjawlwjnbsoej-fhfbs");
// define ("API_URL", "http://midbserver.co.in:8285/auto_user_mauli01/rest/menuService/");
// define ("APK_URL", "http://midbserver.co.in:8285/auto_user_mauli01/rest/menuService/getApk");


define ("API_URL", "http://192.168.0.193:8080/btrack_user_mauli01/rest/menuService/");
define ("APK_URL", "http://192.168.0.193:8080/btrack_user_mauli01/rest/menuService/getApk");

//define ("API_URL", "http://192.168.0.139:8965/btrack_user_mauli01/rest/menuService/");
//define ("APK_URL", "http://192.168.0.139:8965/btrack_user_mauli01/rest/menuService/getApk");

// define ("API_URL", "http://miappserver.co.in:8965/auto_user_mauli01/rest/menuService/");
// define ("APK_URL", "http://miappserver.co.in:8965/auto_user_mauli01/rest/menuService/getApk");


define ("V_APIKEY", "zpfkenaojjawlwjnbsoej-fhfbs");
// define ("V_API_URL", "http://midbserver.co.in:8285/auto_server_cmp01/rest/menuService/");
// define ("V_APK_URL", "http://midbserver.co.in:8285/auto_server_cmp01/rest/menuService/getApk");


define ("V_API_URL", "http://192.168.0.193:8080/btrack_server_cmp01/rest/menuService/");
define ("V_APK_URL", "http://192.168.0.193:8080/btrack_server_cmp01/rest/menuService/getApk");
define ("META_API_URL", "http://192.168.0.193:8080/btrack_server_cmp01/rest/meta/");

//define ("V_API_URL", "http://192.168.0.139:8965/btrack_server_cmp01/rest/menuService/");
//define ("V_APK_URL", "http://192.168.0.139:8965/btrack_server_cmp01/rest/menuService/getApk");

// define ("V_API_URL", "http://miappserver.co.in:8965/auto_server_cmp01/rest/menuService/");
// define ("V_APK_URL", "http://miappserver.co.in:8965/auto_server_cmp01/rest/menuService/getApk");



define ("I_APIKEY", "zpfkenaojjawlwjnbsoej-fhfbs");
// define ("I_API_URL", "http://localhost:8080/auto_server_cmp/rest/menuServiceInv/");
// define ("V_API_URL", "http://192.168.0.119:8080/auto_server_cmp_updated/rest/menuServiceInv/");
// define ("I_API_URL", "http://midbserver.co.in:8285/auto_server_cmp/rest/menuServiceInv/");

//define ("I_API_URL", "http://192.168.0.139:8965/btrack_server_cmp01/rest/menuServiceInv/");
define ("I_API_URL", "http://192.168.0.193:8080/btrack_inv_cmp01/rest/menuServiceInv/");

// define ("I_API_URL", "http://miappserver.co.in:8965/auto_server_cmp01/rest/menuServiceInv/");


define("RUPEE_ICON", '<i class="fa">&#xf156;</i>');
//define('RAZOR_KEY_ID', 'rzp_live_DWyL1z5CVJMaC7');
//define('RAZOR_KEY_SECRET', '4cCt9UKtzlJJH99bdyby1mqt');
define('RAZOR_KEY_ID', 'rzp_test_jHOMb7SZllBIvk');
define('RAZOR_KEY_SECRET', 'RilqVUs4l3d4hSPG3IH2sCRp');
define('CURRENCY_CODE', 'INR');
define('COMPANY_EMAIL', 'support@mauli-infotech.co.in');
define('COMPANY_ADDRESS', 'Office No 409, 4th Floor, Niharika Mirage D Plot No 274, Sector 10,Kharghar - 410210,Maharashtra');
define('GOOGLE_MAP_API_KEY','AIzaSyDD4HK255FtXs2a0qeDBCYqjN9NxYVpMUE');
	

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/
defined('FOPEN_READ')                           OR define('FOPEN_READ', 'rb');
defined('FOPEN_READ_WRITE')                     OR define('FOPEN_READ_WRITE', 'r+b');
defined('FOPEN_WRITE_CREATE_DESTRUCTIVE')       OR define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
defined('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE')  OR define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
defined('FOPEN_WRITE_CREATE')                   OR define('FOPEN_WRITE_CREATE', 'ab');
defined('FOPEN_READ_WRITE_CREATE')              OR define('FOPEN_READ_WRITE_CREATE', 'a+b');
defined('FOPEN_WRITE_CREATE_STRICT')            OR define('FOPEN_WRITE_CREATE_STRICT', 'xb');
defined('FOPEN_READ_WRITE_CREATE_STRICT')       OR define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
defined('EXIT_SUCCESS')        OR define('EXIT_SUCCESS', 0); // no errors
defined('EXIT_ERROR')          OR define('EXIT_ERROR', 1); // generic error
defined('EXIT_CONFIG')         OR define('EXIT_CONFIG', 3); // configuration error
defined('EXIT_UNKNOWN_FILE')   OR define('EXIT_UNKNOWN_FILE', 4); // file not found
defined('EXIT_UNKNOWN_CLASS')  OR define('EXIT_UNKNOWN_CLASS', 5); // unknown class
defined('EXIT_UNKNOWN_METHOD') OR define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
defined('EXIT_USER_INPUT')     OR define('EXIT_USER_INPUT', 7); // invalid user input
defined('EXIT_DATABASE')       OR define('EXIT_DATABASE', 8); // database error
defined('EXIT__AUTO_MIN')      OR define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
defined('EXIT__AUTO_MAX')      OR define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code
define('APP_STORAGE_PATH', '/dbdrive/tomcat7/webapps/ROOT/MI_Applications/MIBtrack/');
