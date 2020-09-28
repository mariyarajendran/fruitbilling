<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class DashboardModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getCustomerCount() {
        return $this->db->where(['customer_status' => 'true'])->from("customer_master")->count_all_results();
    }

    public function getProductCount() {
        return $this->db->where(['product_status' => 'true'])->from("product_master")->count_all_results();
    }

    public function getTotalIncome($from_date, $to_date) {
        $this->db->select_sum('received_amount');
        $this->db->from('order_summary_master');
        $this->db->where('DATE(order_summary_master.order_summary_date) >=', $from_date);
        $this->db->where('DATE(order_summary_master.order_summary_date) <=', $to_date);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result->received_amount;
    }

    public function getPendingBalance($from_date, $to_date) {
        $this->db->select_sum('pending_amount');
        $this->db->from('order_summary_master');
        $this->db->where('DATE(order_summary_master.order_summary_date) >=', $from_date);
        $this->db->where('DATE(order_summary_master.order_summary_date) <=', $to_date);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result->pending_amount;
    }

    public function getOverAllAmount($from_date, $to_date) {
        $this->db->select_sum('total_amount');
        $this->db->from('order_summary_master');
        $this->db->where('DATE(order_summary_master.order_summary_date) >=', $from_date);
        $this->db->where('DATE(order_summary_master.order_summary_date) <=', $to_date);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result->total_amount;
    }

}

?>