<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PendingBalanceModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getPendingBalanceDetails($searchkeyword, $pagecount, $pagelimits, $customerid, $from_date, $to_date) {
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
        //$this->db->where('order_summary_master.order_summary_date >=', $from_date);
        //$this->db->where('order_summary_master.order_summary_date <=', $to_date);
        $this->db->where('order_summary_master.pending_amount >', '0');
        $this->db->limit($pagelimits, $pagecount);
        $this->db->where('customer_id', $customerid);
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function updatePendingBalance($id, $data) {
        $this->db
                ->where('order_summary_id ', $id)
                ->update('order_summary_master', $data);
        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

}

?>