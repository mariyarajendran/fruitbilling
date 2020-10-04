<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/API_Controller.php');

class PendingBalanceController extends API_Controller {

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

    public function updatePendingBalance() {
        $this->load->model('billing/PendingBalanceModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);


        if (isset($data['received_amount']) && isset($data['pending_amount']) && isset($data['order_summary_id'])) {
            $order_summary_id = $data['order_summary_id'];
            $pending_amount = $data['pending_amount'];
            $received_amount = $data['received_amount'];


            if (empty($order_summary_id)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => MISSING_ORDER_SUMMARY_ID
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $order_summary_array = array(
                    'pending_amount' => $pending_amount,
                    'received_amount' => $received_amount
                );
                $result_query = $this->PendingBalanceModel->updatePendingBalance($order_summary_id, $order_summary_array);

                if ($result_query) {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => PENDING_BALANCE_UPDATED
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => PENDING_BALANCE_UPDATE_FAILED
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                }
            }
        } else {
            $response_array = array(
                'code' => HTTP_200,
                'isSuccess' => false,
                'message' => NEED_ALL_PARAMS
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

    public function getPendingBalance() {
        $this->load->model('billing/PendingBalanceModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $resultSet = Array();

        if (isset($data['search_keyword']) && isset($data['page_count']) && isset($data['page_limits']) && isset($data['customer_id']) && isset($data['from_date']) && isset($data['to_date'])) {
            $search_keyword = $data['search_keyword'];
            $page_count = $data['page_count'];
            $page_limits = $data['page_limits'];
            $customer_id = $data['customer_id'];
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];

            if ($page_count == '') {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => NEED_PAGE_COUNT,
                    'balance_details' => $resultSet
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $page_count = ($page_count * $page_limits);
                $result_query = $this->PendingBalanceModel->getPendingBalanceDetails($search_keyword, $page_count, $page_limits, $customer_id, $from_date, $to_date);
                //print_r($result_query);

                if ($result_query) {
                    foreach ($result_query as $order_result) {
                        $resultSet[] = array(
                            "order_summary_id" => $order_result['order_summary_id'],
                            "order_id" => $order_result['order_id'],
                            "customer_id" => $order_result['customer_id'],
                            "customer_name" => $order_result['customer_name'],
                            "customer_mobile_no" => $order_result['customer_mobile_no'],
                            "total_amount" => (int) $order_result['total_amount'],
                            "received_amount" => $order_result['received_amount'],
                            "pending_amount" => (int) $order_result['pending_amount'],
                            "order_summary_date" => $order_result['order_summary_date']
                        );
                    }

                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => BALANCE_RECEIVED,
                        'balance_details' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => NEED_SEARCH_RESULT,
                        'balance_details' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                }
            }
        } else {
            $response_array = array(
                'code' => HTTP_200,
                'isSuccess' => false,
                'message' => NEED_ALL_PARAMS,
                'balance_details' => $resultSet
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

}

?>
