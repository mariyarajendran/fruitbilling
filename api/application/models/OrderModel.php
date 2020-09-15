<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');
class OrderModel extends CI_Model{

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}



	public function placeOrderModel($orderData,$data,$customer_id){

		$this->db->trans_begin();
		////insert order table
		$this->db->insert('order_master',$orderData);
		//// get order id
		$order_id=$this->db->insert_id();
        //// send orderid return purchase details
		$controllerInstance = & get_instance();
		$controllerGetPurchaseDetails = $controllerInstance->postPurchaseDetailData($order_id,$data,$customer_id);
		//// insert purchase details
		$this->db->insert_batch('purchase_detail_master',$controllerGetPurchaseDetails);
		///// get summary details
		$controllerGetSummaryDetails = $controllerInstance->postOrderSummaryData($order_id,$data,$customer_id);
        //// insert summary details
		$this->db->insert('order_summary_master',$controllerGetSummaryDetails); 
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}
		else
		{
			$this->db->trans_commit();
			return true;
		}

	}




	public function deleteToCartModel($id){
		$this->db
		->where('cart_id', $id)
		->delete('cart_master');
		if ($this->db->affected_rows() >= 0) {
			return true;
		}else{
			return false;
		}
	}	



	public function getAllOrderDatas($data,$pagecount){
		$this->db->select('*');
		$this->db->from('order_master');
		$this->db->join('product_master','order_master.product_id=product_master.product_id');
		$this->db->where('order_master.user_id',$data);
		$this->db->limit(10,$pagecount); 
		$query_result=$this->db->get();
		return $query_result->result_array();
	} 

	public function getAllOrderByDate($data,$from_date,$to_date,$pagecount){
		$this->db->select('*');
		$this->db->from('order_master');
		$this->db->join('product_master','order_master.product_id=product_master.product_id');
		$this->db->where('order_master.order_date >=', $from_date);
		$this->db->where('order_master.order_date <=', $to_date);
		$this->db->where('order_master.user_id',$data);
		$this->db->limit(10,$pagecount); 
		$query_result=$this->db->get();
		return $query_result->result_array();
	} 



}?>