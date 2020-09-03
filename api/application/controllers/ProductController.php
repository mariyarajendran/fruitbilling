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
		$resultSet = Array();

		if(isset($data['search_keyword']) && isset($data['page_count']) && isset($data['page_limits'])){
			$search_keyword = $data['search_keyword'];
			$page_count = $data['page_count'];
			$page_limits = $data['page_limits'];

			if($page_count==''){
				$response_array = array(
					'code' => HTTP_201,
					'isSuccess' => false,
					'message' => NEED_PAGE_COUNT,
					'customer_details' => $resultSet
				);
				$this->output
				->set_content_type('application/json')
				->set_status_header(HTTP_201)
				->set_output(json_encode($response_array));
			}
			else{
				$page_count = ($page_count * $page_limits);
				$result_query = $this->ProductModel->getAllProductDetails($search_keyword,$page_count,$page_limits);
			//print_r($result_query);
				
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
						'isSuccess' => true,
						'message' => PRODUCT_RECEIVED,
						'customer_details' => $resultSet
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
						'message' => NEED_SEARCH_RESULT,
						'customer_details' => $resultSet
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
				'customer_details' => $resultSet
			);
			$this->output
			->set_content_type('application/json')
			->set_status_header(HTTP_201)
			->set_output(json_encode($response_array));
		}

	}






}



?>
