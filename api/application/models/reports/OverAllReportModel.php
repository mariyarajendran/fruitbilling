<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class OverAllReportModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getOverAllOrderReports($searchkeyword, $pagecount, $pagelimits, $customerid, $from_date, $to_date, $event_id) {
        $this->db->select('*');
        $this->db->from('order_summary_master');
        $this->db->group_start();
        $this->db->like('order_id', $searchkeyword, 'both');
        $this->db->or_like('customer_id', $searchkeyword);
        $this->db->or_like('total_amount', $searchkeyword);
        $this->db->or_like('received_amount', $searchkeyword);
        $this->db->or_like('pending_amount', $searchkeyword);
        $this->db->group_end();
        $this->db->order_by("order_summary_date", "DESC");
        $this->db->where('DATE(order_summary_master.order_summary_date) >=', $from_date);
        $this->db->where('DATE(order_summary_master.order_summary_date) <=', $to_date);
        $this->db->limit($pagelimits, $pagecount);
        if ($event_id == 1) {
            $this->db->where('customer_id', $customerid);
        }
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function getOverAllOrderReportsDetails($order_id) {
        $this->db->select('*');
        $this->db->from('purchase_detail_master');
        $this->db->where('order_id', $order_id);
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

}

?>