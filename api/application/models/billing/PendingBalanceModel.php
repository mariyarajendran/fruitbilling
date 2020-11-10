<?php


if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class PendingBalanceModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getPendingBalanceDetails($searchkeyword, $from_date, $to_date) {
        $this->db->select('*');
        $this->db->from('order_summary_master');
        $this->db->join('customer_master', 'customer_master.customer_id = order_summary_master.customer_id');
        $this->db->group_start();
        $this->db->like('order_id', $searchkeyword, 'both');
        $this->db->or_like('order_summary_master.customer_id', $searchkeyword);
        $this->db->or_like('total_amount', $searchkeyword);
        $this->db->or_like('received_amount', $searchkeyword);
        $this->db->or_like('pending_amount', $searchkeyword);
        $this->db->group_end();
        $this->db->where('DATE(order_summary_master.order_summary_date) >=', $from_date);
        $this->db->where('DATE(order_summary_master.order_summary_date) <=', $to_date);
        $this->db->where('order_summary_master.pending_amount >', '0');
        $this->db->order_by("DATE(order_summary_date)", "DESC");
        //$this->db->limit($pagelimits, $pagecount);
        //$this->db->where('order_summary_master.customer_id', $customerid);
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function getPendingBalanceHistory($order_summary_id) {
        $this->db->select('*');
        $this->db->from('order_pending_history_master');
        $this->db->join('order_summary_master', 'order_summary_master.order_summary_id = order_pending_history_master.order_summary_id');
        $this->db->where('order_pending_history_master.order_summary_id', $order_summary_id);
        $this->db->order_by("DATE(order_pending_history_date)", "DESC");
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function updatePendingBalance($id, $order_summary_data, $order_pending_history_data) {
        $this->db->trans_begin();
        $this->db->insert('order_pending_history_master', $order_pending_history_data);
        $this->db
                ->where('order_summary_id ', $id)
                ->update('order_summary_master', $order_summary_data);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}

?>