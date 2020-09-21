<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/API_Controller.php');

class OverAllReportController extends API_Controller {

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

    public function getOverAllOrderReports() {
        $this->load->model('reports/OverAllReportModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $resultSet = Array();

        if (isset($data['search_keyword']) && isset($data['page_count']) && isset($data['page_limits']) && isset($data['customer_id']) && isset($data['from_date']) && isset($data['to_date']) && isset($data['event_id'])) {
            $search_keyword = $data['search_keyword'];
            $page_count = $data['page_count'];
            $page_limits = $data['page_limits'];
            $customer_id = $data['customer_id'];
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];
            $event_id = $data['event_id'];

            if ($page_count == '') {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => NEED_PAGE_COUNT,
                    'overall_reports' => $resultSet
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $page_count = ($page_count * $page_limits);
                $result_query = $this->OverAllReportModel->getOverAllOrderReports($search_keyword, $page_count, $page_limits, $customer_id, $from_date, $to_date, $event_id);
                //print_r($result_query);

                if ($result_query) {
                    foreach ($result_query as $order_result) {
                        $resultSet[] = array(
                            "order_summary_id" => $order_result['order_summary_id'],
                            "order_id" => $order_result['order_id'],
                            "customer_id" => $order_result['customer_id'],
                            "total_amount" => (int) $order_result['total_amount'],
                            "received_amount" => $order_result['received_amount'],
                            "pending_amount" => (int) $order_result['pending_amount'],
                            "order_summary_date" => $order_result['order_summary_date']
                        );
                    }

                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => OVER_ALL_REPORT,
                        'overall_reports' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => REPORT_NOT_FOUND,
                        'overall_reports' => $resultSet
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
                'overall_reports' => $resultSet
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

    public function getOverAllOrderDetailedReports() {
        $this->load->model('reports/OverAllReportModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $resultSet = Array();

        if (isset($data['order_id'])) {
            $order_id = $data['order_id'];
            if ($order_id == '') {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => MISSING_ORDER_ID,
                    'overall_reports_details' => $resultSet
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $result_query = $this->OverAllReportModel->getOverAllOrderReportsDetails($order_id);
                if ($result_query) {
                    foreach ($result_query as $order_result) {
                        $resultSet[] = array(
                            "purchase_detail_id" => $order_result['purchase_detail_id'],
                            "order_id" => $order_result['order_id'],
                            "customer_id" => $order_result['customer_id'],
                            "product_id" => $order_result['product_id'],
                            "product_name" => $order_result['product_name'],
                            "product_cost" => $order_result['product_cost'],
                            "product_stock_kg" => $order_result['product_stock_kg'],
                            "product_code" => $order_result['product_code'],
                            "product_date" => $order_result['product_date'],
                            "purchase_detail_date" => $order_result['purchase_detail_date']
                        );
                    }

                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => ORDER_DETAILS_REPORT,
                        'overall_reports_details' => $resultSet
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => REPORT_NOT_FOUND,
                        'overall_reports_details' => $resultSet
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
                'overall_reports_details' => $resultSet
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

}

?>
