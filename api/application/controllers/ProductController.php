<?php
defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH.'libraries/API_Controller.php');

class ProductController extends API_Controller{


	public function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));

		
		// $this->_APIConfig([
		// 	'methods'                              => ['POST','GET'],
		// 	'requireAuthorization'                 => true,
		// 	'limit' => [100, 'ip', 'everyday'] ,
		// 	'data' => [ 'status_code' => HTTP_401 ],
		// ]);
	}


	public function index()
	{
		$this->load->view('demo');
		$this->load->library('database');
	}



	public function getAllProducts(){
		$this->load->model('ProductModel');
		$json_request_body = file_get_contents('php://input');
		$data = json_decode($json_request_body, true);

		if(isset($data['search_keyword']) && isset($data['page_count'])){
			$search_keyword = $data['search_keyword'];
			$page_count = $data['page_count'];

			if($page_count==''){
				$response_array = array(
					'code' => HTTP_201,
					'isSuccess' => false,
					'message' => "Page Count must be not empty",
				);
				$this->output
				->set_content_type('application/json')
				->set_status_header(HTTP_201)
				->set_output(json_encode($response_array));
			}
			else{
				$page_count = ($page_count * 10);
				$result_query = $this->ProductModel->getAllProductDetails($search_keyword,$page_count);
			//print_r($result_query);
				$resultSet = Array();
				if($result_query)
				{
					foreach ($result_query as $product_result) 
					{ 
						$resultSet[] = array(
							"product_id" =>  $product_result['product_id'],
							"product_name" =>  $product_result['product_name'],
							"product_cost" =>  (int) $product_result['product_cost'],
							"product_image" =>  $product_result['product_image'],
							"product_stock_kg" =>  (int) $product_result['product_stock_kg'],
							"product_code" =>  $product_result['product_code']
						);
					} 

					$response_array = array(
						'code' => HTTP_200,
						'isSuccess' => false,
						'message' => "Product Details Received Successfully",
						'product_details' => $resultSet
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
						'message' => "Searched product result not found.",
						'product_details' => $resultSet
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
				'message' => NEED_ALL_PARAMS
			);
			$this->output
			->set_content_type('application/json')
			->set_status_header(HTTP_201)
			->set_output(json_encode($response_array));
		}

	}






}



?>
