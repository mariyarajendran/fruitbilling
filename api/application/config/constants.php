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

define('HTTP_201', 201);
define('HTTP_400', 400);
define('HTTP_404', 404);
define('HTTP_401', 401);

//customer strings
define('HTTP_200', 200);


//////Customer
define('ENTER_CUSTOMER_NAME', 'Enter Customername');
define('ENTER_CUSTOMER_BILLING_NAME', 'Enter Customer billing name');
define('ENTER_CUSTOMER_ADDRESS_NAME', 'Enter Customer address');
define('ENTER_CUSTOMER_MOBILE_NO', 'Enter Customer mobile number');
define('ENTER_CUSTOMER_WHATS_APP_NO', 'Enter Customer whatsapp number');
define('WRONG_FOR_ADD_CUSTOMER', 'Something Wrong in Add Customer');
define('NEW_CUSTOMER_ADDED', 'New Customer Added Successfully');
define('CUSTOMER_UPDATED', 'Customer Updated');


////product
define('ENTER_PRODUCT_CODE', 'Enter Product code');
define('ENTER_PRODUCT_STOCK', 'Enter Product stock');
define('ENTER_PRODUCT_PRICE', 'Enter Product price');
define('ENTER_PRODUCT_NAME', 'Enter Product name');
define('WRONG_FOR_ADD_PRODUCT', 'Something Wrong in Add Product');
define('NEW_PRODUCT_ADDED', 'New Product Added Successfully');
define('PRODUCT_RECEIVED', 'Product Details Received Successfully');
define('CUSTOMER_RECEIVED', 'Customer Details Received Successfully');
define('PRODUCT_UPDATED', 'Product Details Updated Successfully');


define('NEED_ALL_PARAMS', 'Please give all request params');
define('NEED_PAGE_COUNT', 'Page Count must be not empty');
define('NEED_SEARCH_RESULT', 'Searched result not found.');
define('MISSING_CUSTOMER_ID', 'Missing Customer ID.');
define('MISSING_ORDER_ID', 'Missing Order ID.');
define('MISSING_PRODUCT_ID', 'Missing Product ID.');
define('MISSING_ORDER_SUMMARY_ID', 'Missing Order Summary ID.');
define('WRONG_FOR_UPDATE_PRODUCT','Something Wrong, while updating Datas');
define('WRONG_FOR_UPDATE','Something Wrong, while updating Datas');

/////order placed
define('ORDER_PLACED','Order Placed Successfully');
define('ORDER_FAILED','Failed to place order.');
define('BALANCE_RECEIVED', 'Balance Details Received Successfully');
define('PENDING_BALANCE_UPDATED','Pending Balance Updated Successfully.');
define('PENDING_BALANCE_UPDATE_FAILED','Pending Balance Failed to Update.');


////dashboard deatils
define('DASHBOARD_DEATILS_RECEIVED','Dashboard Details Received Successfully');
define('DASHBOARD_DEATILS_RECEIVED_FAILED','Dashboard Details Failed to Received');

////reports
define('OVER_ALL_REPORT', 'Overall Report Received Successfully');
define('ORDER_DETAILS_REPORT', 'Order Details Received Successfully');
define('REPORT_NOT_FOUND', 'Report Details not found');

