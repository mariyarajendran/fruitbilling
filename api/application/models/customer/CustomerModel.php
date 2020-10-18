<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class CustomerModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getProductDetails($data) {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->order_by('customer_name');
        $this->db->where($data);
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function getProductCount() {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->limit(1);
        $this->db->order_by('customer_id', "DESC");
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function deleteProductModel($id) {
        $this->db
                ->where('customer_id', $id)
                ->delete('customer_master');
        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateCustomerDatas($id, $data) {
        $this->db->set($data);
        $this->db->where('customer_id', $id);
        $this->db->update('customer_master');
        if ($this->db->affected_rows() >= 0) {
            $this->db->select('*');
            $this->db->from('customer_master');
            $this->db->where('customer_id', $id);
            $query_result = $this->db->get();
            return $query_result->result_array();
            //return true;
        } else {
            return false;
        }
    }

    public function adminUpdateOrderStatus($id, $data) {
        $this->db
                ->where('order_id', $id)
                ->update('customer_master', $data);
        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addCustomer($data) {
        $insert = $this->db->insert('customer_master', $data);
        if ($insert) {
            $id = $this->db->insert_id();
            $this->db->select('*');
            $this->db->from('customer_master');
            $this->db->where('customer_id', $id);
            $query_result = $this->db->get();
            return $query_result->result_array();
        } else {
            return false;
        }
    }

    public function getAllCustomerData($data, $pagecount, $pagelimits) {
        $this->db->select('*');
        $this->db->from('customer_master');
        $this->db->order_by('customer_name');
        $this->db->like('customer_name', $data, 'after');
        //$this->db->limit($pagelimits, $pagecount);
        $this->db->where('customer_status', 'true');
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function getTotalCustomerPendingBalance($customer_id) {
        $this->db->select_sum('pending_amount');
        $this->db->from('order_summary_master');
        $this->db->where('customer_id', $customer_id);
        $query_result = $this->db->get();
        $result = $query_result->row();
        return $result->pending_amount;
    }

}

?>