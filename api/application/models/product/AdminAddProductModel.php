<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class AdminAddProductModel extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function getProductDetails($data) {
        $this->db->select('*');
        $this->db->from('product_master');
        $this->db->where($data);
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function getProductCount() {
        $this->db->select('*');
        $this->db->from('product_master');
        $this->db->limit(1);
        $this->db->order_by('product_id', "DESC");
        $query_result = $this->db->get();
        return $query_result->result_array();
    }

    public function deleteProductModel($id, $data) {
        $this->db->set($data);
        $this->db->where('product_id', $id);
        $this->db->update('product_master');
        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function updateProductDatas($id, $data) {
        $this->db->set($data);
        $this->db->where('product_id', $id);
        $this->db->update('product_master');
        if ($this->db->affected_rows() >= 0) {
            $this->db->select('*');
            $this->db->from('product_master');
            $this->db->where('product_id', $id);
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
                ->update('order_master', $data);
        if ($this->db->affected_rows() >= 0) {
            return true;
        } else {
            return false;
        }
    }

    public function addProductModel($data) {
        $insert = $this->db->insert('product_master', $data);
        if ($insert) {
            $id = $this->db->insert_id();
            $this->db->select('*');
            $this->db->from('product_master');
            $this->db->where('product_id', $id);
            $query_result = $this->db->get();
            return $query_result->result_array();
        } else {
            return false;
        }
    }

}

?>