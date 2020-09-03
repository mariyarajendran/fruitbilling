<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/API_Controller.php');

class CustomerController extends API_Controller{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));



    // $this->_APIConfig([
    //   'methods'                              => ['POST','GET'],
    //   'requireAuthorization'                 => true,
    //   'limit' => [100, 'ip', 'everyday'] ,
    //   'data' => [ 'status' => HTTP_401 ],
    // ]);
  }



  public function index()
  {
    $this->load->view('demo');
    $this->load->library('database');
    $this->load->library('Authorization_Token');


  }


  public function addCustomerData(){

    $this->load->model('CustomerModel');

    $json_request_body = file_get_contents('php://input');
    $data = json_decode($json_request_body, true);



    if(isset($data['customer_name']) && isset($data['customer_billing_name']) && isset($data['customer_address']) 
      && isset($data['customer_mobile_no']) 
      && isset($data['customer_whatsapp_no'])){

     $customer_name = $data['customer_name'];
   $customer_billing_name = $data['customer_billing_name'];    
   $customer_address = $data['customer_address'];
   $customer_mobile_no = $data['customer_mobile_no'];
   $customer_whatsapp_no = $data['customer_whatsapp_no'];


   if(empty($customer_name)){
    $response_array = array(
     'code' => HTTP_201,
     'isSuccess' => false,
     'message' => ENTER_CUSTOMER_NAME,
   );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else if(empty($customer_billing_name)){
    $response_array = array(
     'code' => HTTP_201,
     'isSuccess' => false,
     'message' => ENTER_CUSTOMER_BILLING_NAME,
   );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }


  else if(empty($customer_address)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => ENTER_CUSTOMER_ADDRESS_NAME,
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else if(empty($customer_mobile_no)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => ENTER_CUSTOMER_MOBILE_NO,
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else if(empty($customer_whatsapp_no)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => ENTER_CUSTOMER_WHATS_APP_NO,
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else{

    $customer_array = array(
      'customer_name' => $customer_name,
      'customer_billing_name' => $customer_billing_name,
      'customer_address' => $customer_address,
      'customer_mobile_no' => $customer_mobile_no,
      'customer_whatsapp_no' => $customer_whatsapp_no
    );

    $result_query = $this->CustomerModel->addCustomer($customer_array);
    if($result_query)
    {


      $response_array = array(
       'code' => HTTP_200,
       'isSuccess' => true,
       'message' => NEW_CUSTOMER_ADDED
     );
      $this->output
      ->set_content_type('application/json')
      ->set_status_header(HTTP_200)
      ->set_output(json_encode($response_array));
    }
    else{
      $response_array = array(
       'code' => HTTP_201,
       'isSuccess' => false,
       'message' => WRONG_FOR_ADD_CUSTOMER,
     );
      $this->output
      ->set_content_type('application/json')
      ->set_status_header(HTTP_201)
      ->set_output(json_encode($response_array));
    }

  }
}
else{
  $response_array = array(
    'code' => HTTP_201,
    'isSuccess' => false,
    'message' => NEED_ALL_PARAMS,
  );
  $this->output
  ->set_content_type('application/json')
  ->set_status_header(HTTP_201)
  ->set_output(json_encode($response_array));
}
}














}



?>
