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



   if(isset($data['product_name']) && isset($data['product_cost']) && isset($data['product_image']) 
    && isset($data['product_stock_kg']) 
    && isset($data['product_code'])){

     $product_name = $data['product_name'];
   $product_cost = $data['product_cost'];    
   $product_image = $data['product_image'];
   $product_stock_kg = $data['product_stock_kg'];
   $product_code = $data['product_code'];


   if(empty($product_name)){
    $response_array = array(
     'code' => HTTP_201,
     'isSuccess' => false,
     'message' => "Enter Productname",
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
     'message' => "Enter Product Cost",
   );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  // else if(empty($product_image)){
  //   $response_array = array(
  //    'code' => HTTP_201,
  //    'isSuccess' => false,
  //    'message' => "Enter Product Image",
  //  );
  //   $this->output
  //   ->set_content_type('application/json')
  //   ->set_status_header(HTTP_201)
  //   ->set_output(json_encode($response_array));
  // }

  else if(empty($product_stock_kg)){
    $response_array = array(
      'code' => HTTP_201,
      'isSuccess' => false,
      'message' => "Enter Product Stock",
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
      'message' => "Enter Product Code",
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
  else{

    $image_url_path="";

    if($product_image != ""){
      $total_product_count=$this->AdminAddProductModel->getProductCount();
      if($total_product_count){
       $product_id_for_image=$total_product_count[0]['product_id']+1;
     }else{
      $product_id_for_image=1;
    }
    $image_url_path = "uploads/product/".$product_id_for_image.".png";
  }



  $product_array = array(
    'product_name' => $product_name,
    'product_cost' => $product_cost,
    'product_image' => $image_url_path,
    'product_stock_kg' => $product_stock_kg,
    'product_code' => $product_code
  );

  $result_query = $this->AdminAddProductModel->addProductModel($product_array);
  if($result_query)
  {

   if($product_image != ""){
    $path = "uploads/product/".$product_id_for_image.".png";
    $product_image = preg_replace('#data:image/[^;]+;base64,#', '', $product_image);
    $status = file_put_contents($path,base64_decode($product_image));
  }


  $response_array = array(
   'code' => HTTP_200,
   'isSuccess' => true,
   'message' => "New Product Added Successfully"
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
   'message' => "Something Wrong in Add Product",
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
    'message' => "Please give all request params",
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


 if(isset($data['product_name']) && isset($data['product_cost']) && isset($data['product_image']) 
  && isset($data['product_stock_kg']) 
  && isset($data['product_code'])){

   $product_id = $data['product_id'];
 $product_name = $data['product_name'];
 $product_cost = $data['product_cost'];
 $product_image = $data['product_image'];
 $product_stock_kg = $data['product_stock_kg'];
 $product_code = $data['product_code'];


 if(empty($product_id)){
  $response_array = array(
   'code' => HTTP_201,
   'isSuccess' => false,
   'message' => "Product Id Missing.Unable to update product datas",
 );
  $this->output
  ->set_content_type('application/json')
  ->set_status_header(HTTP_201)
  ->set_output(json_encode($response_array));
}else{
  $product_array = array('product_id' => $product_id);
  $result_query = $this->AdminAddProductModel->getProductDetails($product_array);
  $db_product_name = $result_query[0]['product_name'];
  $db_product_cost = $result_query[0]['product_cost'];
  $db_product_image = $result_query[0]['product_image'];
  $db_product_stock_kg = $result_query[0]['product_stock_kg'];
  $db_product_code = $result_query[0]['product_code'];


  if(empty($product_name)){
    $product_name = $db_product_name;
  } if(empty($product_cost)){
    $product_cost=$db_product_cost;
  }if(empty($product_stock_kg)){
    $product_stock_kg=$db_product_stock_kg;
  } if(empty($product_code)){
    $product_code=$db_product_code;
  } 

  $image_url_path = "uploads/product/".$product_id.".png";

  $product_data = array(
    'product_name' => $product_name,
    'product_cost' => $product_cost,
    'product_image' => $image_url_path,
    'product_stock_kg' => $product_stock_kg,
    'product_code' => $product_code
  );
  $result_query = $this->AdminAddProductModel->updateProductDatas($product_id,$product_data);
  if($result_query)
  {
    if(!empty($product_image)){
      $path = "uploads/product/".$product_id.".png";
      $product_image = preg_replace('#data:image/[^;]+;base64,#', '', $product_image);
      $status = file_put_contents($path,base64_decode($product_image));
    }

    $response_array = array(
      'code' => HTTP_200,
      'isSuccess' => true,
      'message' => "Product Details Updated Successfully",
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
      'message' => "Something Wrong, while updating Datas",
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
    'message' => "Please give all request params",
  );
  $this->output
  ->set_content_type('application/json')
  ->set_status_header(HTTP_201)
  ->set_output(json_encode($response_array));
}

}



public function adminDeleteProduct(){
  $this->load->model('AdminAddProductModel');
  $json_request_body = file_get_contents('php://input');
  $data = json_decode($json_request_body, true);

  if(isset($data['product_id'])){

    $product_id=$data['product_id'];

    if(empty($product_id)){
      $response_array = array(
        'code' => HTTP_201,
        'isSuccess' => false,
        'message' => "Product id missing",
      );
      $this->output
      ->set_content_type('application/json')
      ->set_status_header(HTTP_201)
      ->set_output(json_encode($response_array));
    }
    else{
      $result_query = $this->AdminAddProductModel->deleteProductModel($product_id);
      if($result_query)
      {
        $response_array = array(
          'code' => HTTP_200,
          'isSuccess' => true,
          'message' => "Product Deleted Successfully"
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
          'message' => "Failed to delete product."
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
      'message' => "Please give all request params"
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_201)
    ->set_output(json_encode($response_array));
  }
}


public function confirmAndCloseOrder(){
  $this->load->model('AdminAddProductModel');
  $json_request_body = file_get_contents('php://input');
  $data = json_decode($json_request_body, true);

  if(isset($data['order_id']) && isset($data['order_status'])){
    $order_id = $data['order_id'];
    $order_status = $data['order_status'];
    if(empty($order_id)){
      $response_array = array(
        'status_code' => "0",
        'status' => HTTP_400,
        'message' => "Order Id Missing.Unable to update user datas",
      );
      $this->output
      ->set_content_type('application/json')
      ->set_status_header(HTTP_400)
      ->set_output(json_encode($response_array));
    }
    else if(empty($order_status)){
      $response_array = array(
        'status_code' => "0",
        'status' => HTTP_400,
        'message' => "Order Status Missing.Unable to update user datas",
      );
      $this->output
      ->set_content_type('application/json')
      ->set_status_header(HTTP_400)
      ->set_output(json_encode($response_array));
    }else{
      $order_data = array(
        'order_status' => $order_status
      );
      $result_query = $this->AdminAddProductModel->adminUpdateOrderStatus($order_id,$order_data);
      if($result_query)
      {
        $response_array = array(
          'status_code' => "1",
          'status' => HTTP_200,
          'message' => "Order Status Updated Successfully",
        );
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(HTTP_200)
        ->set_output(json_encode($response_array));
      }
      else{
        $response_array = array(
          'status_code' => "0",
          'status' => HTTP_400,
          'message' => "Something Wrong, while update Order Status",
        );
        $this->output
        ->set_content_type('application/json')
        ->set_status_header(HTTP_400)
        ->set_output(json_encode($response_array));
      }


    }
  }else{
    $response_array = array(
      'status_code' => "0",
      'status' => HTTP_400,
      'message' => "Please give all request params"
    );
    $this->output
    ->set_content_type('application/json')
    ->set_status_header(HTTP_400)
    ->set_output(json_encode($response_array));
  }


}





}



?>
