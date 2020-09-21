<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/API_Controller.php');

class DashboardController extends API_Controller {

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

    public function getDashboardDetails() {
        $this->load->model('dashboard/DashboardModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $result_dashboard = Array("customer_count" => 0, "product_count" => 0, "pending_income" => 0, "overall_amount" => 0);

        if (isset($data['from_date']) && isset($data['to_date'])) {
            $from_date = $data['from_date'];
            $to_date = $data['to_date'];

            $result_query = $this->DashboardModel->getCustomerCount();

            if ($result_query) {

                $product_count = $this->DashboardModel->getProductCount();
                $customer_count = $this->DashboardModel->getCustomerCount();
                $total_income = (int) $this->DashboardModel->getTotalIncome($from_date, $to_date);
                $pending_income = (int) $this->DashboardModel->getPendingBalance($from_date, $to_date);
                $overall_amount = (int) $this->DashboardModel->getOverAllAmount($from_date, $to_date);

                $result_dashboard = array(
                    "customer_count" => $customer_count,
                    "product_count" => $product_count,
                    "total_income" => $total_income,
                    "pending_income" => $pending_income,
                    "overall_amount" => $overall_amount
                );


                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => true,
                    'message' => DASHBOARD_DEATILS_RECEIVED,
                    'dashboard_details' => $result_dashboard
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => DASHBOARD_DEATILS_RECEIVED_FAILED,
                    'dashboard_details' => $result_dashboard
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            }
        } else {
            $response_array = array(
                'code' => HTTP_200,
                'isSuccess' => false,
                'message' => NEED_ALL_PARAMS,
                'dashboard_details' => $result_dashboard
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

}

?>
