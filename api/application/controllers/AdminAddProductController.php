<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/API_Controller.php');

class AdminAddProductController extends API_Controller{


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


  public function adminAddProductDatas(){
   $this->load->model('AdminAddProductModel');
   $json_request_body = file_get_contents('php://input');
   $data = json_decode($json_request_body, true);



   if(isset($data['product_name']) && isset($data['product_cost'])  
    && isset($data['product_stock_kg']) 
    && isset($data['product_code'])){

     $product_name = $data['product_name'];
   $product_cost = $data['product_cost'];    
   $product_stock_kg = $data['product_stock_kg'];
   $product_code = $data['product_code'];


   if(empty($product_name)){
    $response_array = array(
     'code' => HTTP_201,
     'isSuccess' => false,
     'message' => ENTER_PRODUCT_NAME,
   );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else if(empty($product_cost)){
    $response_array = array(
     'code' => HTTP_201,
     'isSuccess' => false,
     'message' => ENTER_PRODUCT_PRICE,
   );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }

  else if(empty($product_stock_kg)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => ENTER_PRODUCT_STOCK,
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else if(empty($product_code)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => ENTER_PRODUCT_CODE,
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else{
    $product_array = array(
      'product_name' => $product_name,
      'product_cost' => $product_cost,
      'product_stock_kg' => $product_stock_kg,
      'product_code' => $product_code,
      'product_status' => "true"
    );

    $result_query = $this->AdminAddProductModel->addProductModel($product_array);
    if($result_query)
    {

      $response_array = array(
       'code' => HTTP_200,
       'isSuccess' => true,
       'message' => NEW_PRODUCT_ADDED
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
       'message' => WRONG_FOR_ADD_PRODUCT,
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

public function updateProductDetails(){
 $this->load->model('AdminAddProductModel');
 $json_request_body = file_get_contents('php://input');
 $data = json_decode($json_request_body, true);
 $product_details=array('product_id ' => "",
  'product_name' => "",
  'product_cost' => "",
  'product_stock_kg' => "",
  'product_date' => "",
  'product_code' => "",
  'product_status' => "");

 if(isset($data['product_id']) && isset($data['product_name']) && isset($data['product_cost']) 
  && isset($data['product_stock_kg']) 
  && isset($data['product_code']) && isset($data['product_status'])){

   $product_id = $data['product_id'];
 $product_name = $data['product_name'];
 $product_cost = $data['product_cost'];
 $product_stock_kg = $data['product_stock_kg'];
 $product_code = $data['product_code'];
 $product_status = $data['product_status'];


 if(empty($product_id)){
  $response_array = array(
   'code' => HTTP_201,
   'isSuccess' => false,
   'message' => MISSING_PRODUCT_ID,
   'product_details' => $product_details
 );
  $this->output
  ->set_content_type('application/json')
  ->set_status_header(HTTP_201)
  ->set_output(json_encode($response_array));
}else{

  $product_data = array(
    'product_name' => $product_name,
    'product_cost' => $product_cost,
    'product_stock_kg' => $product_stock_kg,
    'product_code' => $product_code,
    'product_status' => $product_status
  );

  $result_query = $this->AdminAddProductModel->updateProductDatas($product_id,array_filter($product_data));
  if($result_query)
  {

    $response_array = array(
      'code' => HTTP_200,
      'isSuccess' => true,
      'message' => PRODUCT_UPDATED,
      'product_details' => array('product_id ' => $result_query[0]['product_id'],
        'product_name' => $result_query[0]['product_name'],
        'product_cost' => $result_query[0]['product_cost'],
        'product_stock_kg' => $result_query[0]['product_stock_kg'],
        'product_date' => $result_query[0]['product_date'],
        'product_code' => $result_query[0]['product_code'],
        'product_status' => $result_query[0]['product_status'] == 'true' ? true : false),
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_200)
    ->set_output(json_encode($response_array));
  }
  else{
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' =>false,
      'message' => WRONG_FOR_UPDATE_PRODUCT,
      'product_details' => $product_details
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
}
}else{
  $response_array = array(
    'code' => HTTP_201,
    'isSuccess' => false,
    'message' => NEED_ALL_PARAMS,
    'product_details' => $product_details
  );
  $this->output
  ->set_content_type('application/json')
  ->set_status_header(HTTP_201)
  ->set_output(json_encode($response_array));
}

}


}



?>
