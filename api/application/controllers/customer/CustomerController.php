<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require_once(APPPATH . 'libraries/API_Controller.php');

class CustomerController extends API_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper(array('form', 'url'));



        // $this->_APIConfig([
        //   'methods'                              => ['POST','GET'],
        //   'requireAuthorization'                 => true,
        //   'limit' => [100, 'ip', 'everyday'] ,
        //   'data' => [ 'status' => HTTP_401 ],
        // ]);
    }

    public function index() {
        $this->load->view('demo');
        $this->load->library('database');
        $this->load->library('Authorization_Token');
    }

    public function addCustomerData() {

        $this->load->model('customer/CustomerModel');

        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $customer_details = array('customer_id' => "",
            'customer_name' => "",
            'customer_billing_name' => "",
            'customer_address' => "",
            'customer_mobile_no' => "",
            'customer_whatsapp_no' => "",
            'customer_status' => false);


        if (isset($data['customer_name']) && isset($data['customer_billing_name']) && isset($data['customer_address']) && isset($data['customer_mobile_no']) && isset($data['customer_whatsapp_no'])) {

            $customer_name = $data['customer_name'];
            $customer_billing_name = $data['customer_billing_name'];
            $customer_address = $data['customer_address'];
            $customer_mobile_no = $data['customer_mobile_no'];
            $customer_whatsapp_no = $data['customer_whatsapp_no'];



            if (empty($customer_name)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => ENTER_CUSTOMER_NAME,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else if (empty($customer_billing_name)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => ENTER_CUSTOMER_BILLING_NAME,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else if (empty($customer_address)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => ENTER_CUSTOMER_ADDRESS_NAME,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else if (empty($customer_mobile_no)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => ENTER_CUSTOMER_MOBILE_NO,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else if (empty($customer_whatsapp_no)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => ENTER_CUSTOMER_WHATS_APP_NO,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {

                $customer_array = array(
                    'customer_name' => $customer_name,
                    'customer_billing_name' => $customer_billing_name,
                    'customer_address' => $customer_address,
                    'customer_mobile_no' => $customer_mobile_no,
                    'customer_whatsapp_no' => $customer_whatsapp_no,
                    'customer_status' => "true"
                );

                $result_query = $this->CustomerModel->addCustomer($customer_array);
                if ($result_query) {


                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => NEW_CUSTOMER_ADDED,
                        'customer_details' => array('customer_id ' => $result_query[0]['customer_id'],
                            'customer_name' => $result_query[0]['customer_name'],
                            'customer_billing_name' => $result_query[0]['customer_billing_name'],
                            'customer_address' => $result_query[0]['customer_address'],
                            'customer_mobile_no' => $result_query[0]['customer_mobile_no'],
                            'customer_whatsapp_no' => $result_query[0]['customer_whatsapp_no'],
                            'customer_status' => $result_query[0]['customer_status'] == 'true' ? true : false),
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => WRONG_FOR_ADD_CUSTOMER,
                        'customer_details' => $customer_details
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
                'customer_details' => $customer_details
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

    public function updateCustomerDetails() {
        $this->load->model('customer/CustomerModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $customer_details = array('customer_id' => "",
            'customer_name' => "",
            'customer_billing_name' => "",
            'customer_address' => "",
            'customer_mobile_no' => "",
            'customer_whatsapp_no' => "",
            'customer_status' => false);

        if (isset($data['customer_id']) && isset($data['customer_name']) && isset($data['customer_billing_name']) && isset($data['customer_address']) && isset($data['customer_mobile_no']) && isset($data['customer_whatsapp_no']) && isset($data['customer_status'])) {

            $customer_id = $data['customer_id'];
            $customer_name = $data['customer_name'];
            $customer_billing_name = $data['customer_billing_name'];
            $customer_address = $data['customer_address'];
            $customer_mobile_no = $data['customer_mobile_no'];
            $customer_whatsapp_no = $data['customer_whatsapp_no'];
            $customer_status = $data['customer_status'];


            if (empty($customer_id)) {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => MISSING_CUSTOMER_ID,
                    'customer_details' => $customer_details
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {

                $customer_data = array(
                    'customer_name' => $customer_name,
                    'customer_billing_name' => $customer_billing_name,
                    'customer_address' => $customer_address,
                    'customer_mobile_no' => $customer_mobile_no,
                    'customer_whatsapp_no' => $customer_whatsapp_no,
                    'customer_status' => $customer_status
                );

                $result_query = $this->CustomerModel->updateCustomerDatas($customer_id, array_filter($customer_data));
                if ($result_query) {

                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => CUSTOMER_UPDATED,
                        'customer_details' => array('customer_id ' => $result_query[0]['customer_id'],
                            'customer_name' => $result_query[0]['customer_name'],
                            'customer_billing_name' => $result_query[0]['customer_billing_name'],
                            'customer_address' => $result_query[0]['customer_address'],
                            'customer_mobile_no' => $result_query[0]['customer_mobile_no'],
                            'customer_whatsapp_no' => $result_query[0]['customer_whatsapp_no'],
                            'customer_status' => $result_query[0]['customer_status'] == 'true' ? true : false),
                    );
                    $this->output
                            ->set_content_type('application/json')
                            ->set_status_header(HTTP_200)
                            ->set_output(json_encode($response_array));
                } else {
                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => false,
                        'message' => WRONG_FOR_UPDATE,
                        'customer_details' => $customer_details
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
                'customer_details' => $customer_details
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

    public function getAllCustomerData() {
        $this->load->model('customer/CustomerModel');
        $json_request_body = file_get_contents('php://input');
        $data = json_decode($json_request_body, true);
        $resultSet = Array();

        if (isset($data['search_keyword']) && isset($data['page_count']) && isset($data['page_limits'])) {
            $search_keyword = $data['search_keyword'];
            $page_count = $data['page_count'];
            $page_limits = $data['page_limits'];

            if ($page_count == '') {
                $response_array = array(
                    'code' => HTTP_200,
                    'isSuccess' => false,
                    'message' => NEED_PAGE_COUNT,
                    'customer_details' => $resultSet
                );
                $this->output
                        ->set_content_type('application/json')
                        ->set_status_header(HTTP_200)
                        ->set_output(json_encode($response_array));
            } else {
                $page_count = ($page_count * $page_limits);
                $result_query = $this->CustomerModel->getAllCustomerData($search_keyword, $page_count, $page_limits);
                //print_r($result_query);

                if ($result_query) {
                    foreach ($result_query as $customer_result) {
                        $resultSet[] = array(
                            "customer_id" => $customer_result['customer_id'],
                            "customer_name" => $customer_result['customer_name'],
                            "customer_billing_name" => $customer_result['customer_billing_name'],
                            "customer_address" => $customer_result['customer_address'],
                            "customer_mobile_no" => $customer_result['customer_mobile_no'],
                            "customer_whatsapp_no" => $customer_result['customer_whatsapp_no'],
                            "customer_status" => $customer_result['customer_status'],
                            "customer_date" => $customer_result['customer_date']
                        );
                    }

                    $response_array = array(
                        'code' => HTTP_200,
                        'isSuccess' => true,
                        'message' => CUSTOMER_RECEIVED,
                        'customer_details' => $resultSet
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
                        'customer_details' => $resultSet
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
                'customer_details' => $resultSet
            );
            $this->output
                    ->set_content_type('application/json')
                    ->set_status_header(HTTP_200)
                    ->set_output(json_encode($response_array));
        }
    }

}

?>
