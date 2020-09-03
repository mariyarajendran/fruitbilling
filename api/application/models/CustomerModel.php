<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class CustomerModel extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}





	public function getProductDetails($data){
		$this->db->select('*');
		$this->db->from('customer_master');
		$this->db->where($data);
		$query_result=$this->db->get();
		return $query_result->result_array();
	} 

	public function getProductCount(){
		$this->db->select('*');
		$this->db->from('customer_master');
		$this->db->limit(1);
		$this->db->order_by('customer_id',"DESC");
		$query_result=$this->db->get();
		return $query_result->result_array();
	} 


	public function deleteProductModel($id){
		$this->db
		->where('customer_id', $id)
		->delete('customer_master');
		if ($this->db->affected_rows() >= 0) {
			return true;
		}else{
			return false;
		}
	}


	public function updateProductDatas($id,$data){
		$this->db
		->where('product_id', $id)
		->update('product_master', $data);
		if ($this->db->affected_rows() >= 0) {
			return true;
		}else{
			return false;
		}
	}

	public function adminUpdateOrderStatus($id,$data){
		$this->db
		->where('order_id',$id)
		->update('customer_master',$data);
		if ($this->db->affected_rows() >= 0) {
			return true;
		}else{
			return false;
		}
	}


	public function addCustomer($data){
		$insert = $this->db->insert('customer_master',$data);
		if($insert){
			return $this->db->insert_id();
		}
		else{
			return false;
		}
	}


	public function getAllCustomerData($data,$pagecount,$pagelimits){
		$this->db->select('*');
		$this->db->from('customer_master');
		$this->db->like('customer_name',$data, 'after');
		$this->db->limit($pagelimits,$pagecount); 
		$query_result=$this->db->get();
		return $query_result->result_array();
	} 



}?>