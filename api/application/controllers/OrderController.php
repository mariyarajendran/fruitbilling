<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/API_Controller.php');

class OrderController extends API_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));


        // $this->_APIConfig([
        // 	'methods'                              => ['POST','GET'],
        // 	'requireAuthorization'                 => true,
        // 	'limit' => [100, 'ip', 'everyday'] ,
        // 	'data' => [ 'status_code' => HTTP_401 ],
        // ]);
    }

    public function index() {
        $this->load->view('demo');
        $this->load->library('database');
    }

    public function postPurchaseDetailData($order_id, $data, $customer_id) {
        $product_list_data = Array();
        foreach ($data['product_list_data'] as $product_result) {
            $product_list_data[] = array(
                "product_id" => $product_result['product_id'],
                "customer_id" => $customer_id,
                "order_id" => $order_id,
                "product_name" => $product_result['product_name'],
                "product_cost" => $product_result['product_cost'],
                "product_date" => $product_result['product_date'],
                "product_stock_kg" => $product_result['product_stock_kg'],
                "product_total_cost" => $product_result['product_total_cost'],
                "product_code" => $product_result['product_code']
            );
        }
        return $product_list_data;
    }

    public function postOrderSummaryData($order_id, $data, $customer_id) {
        $order_summary_array = array(
            'order_id' => $order_id,
            'customer_id' => $customer_id,
            'total_amount' => $data['total_amount'],
            'received_amount' => $data['received_amount'],
            'pending_amount' => $data['pending_amount']
        );
        return $order_summary_array;
    }

    public function placeOrder() {
        $this->load->model('OrderModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $product_list_data = Array();

        if (isset($data['customer_id']) && isset($data['product_list_data']) && isset($data['total_amount']) && isset($data['received_amount']) && isset($data['pending_amount'])) {
            $customer_id = $data['customer_id'];

            if (empty($customer_id)) {
                $response_array = array(
                    'code' => HTTP_201,
                    'isSuccess' => false,
                    'message' => MISSING_CUSTOMER_ID,
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_201)
                        ->set_output(json_encode($response_array));
            } else {

                $order_array = array(
                    'customer_id' => $customer_id
                );

                $result_query = $this->OrderModel->placeOrderModel($order_array, $data, $customer_id);
                if ($result_query) {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => ORDER_PLACED,
                    );

                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_201,
                        'isSuccess' => false,
                        'message' => ORDER_FAILED,
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_201)
                            ->set_output(json_encode($response_array));
                }
            }
        } else {
            $response_array = array(
                'code' => HTTP_201,
                'isSuccess' => false,
                'message' => ORDER_FAILED,
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_201)
                    ->set_output(json_encode($response_array));
        }
    }

    public function orderHistoryDetails() {
        $this->load->model('OrderModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);

        if (isset($data['user_id']) && isset($data['from_date']) && isset($data['to_date']) && isset($data['page_count'])) {
            $user_id = $data['user_id'];
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];
            $page_count = $data['page_count'];

            if ($page_count == '') {
                $response_array = array(
                    'status_code' => "0",
                    'status' => HTTP_400,
                    'message' => "Page Count must be not empty",
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_400)
                        ->set_output(json_encode($response_array));
            } else {
                $page_count = ($page_count * 10);
                if (empty($from_date) && empty($to_date)) {
                    $result_query = $this->OrderModel->getAllOrderDatas($user_id, $page_count);
                } else {
                    $result_query = $this->OrderModel->getAllOrderByDate($user_id, $from_date, $to_date, $page_count);
                }

                //print_r($to_date);
                $resultSet = Array();
                if ($result_query) {
                    foreach ($result_query as $product_result) {
                        $resultSet[] = array(
                            "product_id" => $product_result['product_id'],
                            "user_id" => $product_result['user_id'],
                            "order_id" => $product_result['order_id'],
                            "product_name" => $product_result['product_name'],
                            "product_cost" => $product_result['product_cost'],
                            "product_image" => $product_result['product_image'],
                            "product_short_descr" => $product_result['product_short_descr'],
                            "product_long_descr" => $product_result['product_long_descr'],
                            "product_offers" => $product_result['product_offers'],
                            "order_date" => $product_result['order_date'],
                            "order_status" => $product_result['order_status'],
                        );
                    }

                    $response_array = array(
                        'status_code' => "1",
                        'status' => HTTP_200,
                        'message' => "Order History Received Successfully",
                        'product_details' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'status_code' => "0",
                        'status' => HTTP_400,
                        'message' => "Order History result not found.",
                        'product_details' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_400)
                            ->set_output(json_encode($response_array));
                }
            }
        } else {
            $response_array = array(
                'status_code' => "0",
                'status' => HTTP_400,
                'message' => "Please give all request params",
                'user_details' => array(
                    'user_id' => "",
                    'user_register_status' => "",
                    'user_mobile_number' => "",
                    'user_otp' => "",
                    'user_access_token' => ""
                ),
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_400)
                    ->set_output(json_encode($response_array));
        }
    }

}

?>
