<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageproductcategory_model extends CI_Model {

		function __construct(){
		
			parent::__construct();
			$this->load->library('email');
		}
		
		
		public function addProductCategory($data)
		{
			$this->db->insert('product_category',$data);
			$productcat_ID=$this->db->insert_id();
		}
		
		public function product_update($productID,$data)
		{
			$this->db->where('product_id',$productID);
			$this->db->update('product',$data);
		}
		

	  public function getAllProductCategory($comp_code){
			$this->db->select('*');
			$this->db->where('comp_code',$comp_code);
			$this->db->from('product_category');
			$query = $this->db->get();
			return $query->result();
	  }
	  
	  public function getSubCats($p_id) {
	  	$this->db->select('*');
			$this->db->where('cat_parent_id',$p_id);
			$this->db->from('product_category');
			$query = $this->db->get();
			return $query->result();
	  }
	  
	  public function getProductCategoryInfoByID($productcatID){
		$query = $this->db->get_where('product_category', array('product_cat_id' => $productcatID));
			if($query->num_rows() > 0) 
				return $query->row();
			else
				return FALSE;
	  } 
	  
	  public function updateProductCategory($productcatID,$data){
		$this->db->where('product_cat_id',$productcatID);
		$this->db->update('product_category',$data);
	  }
	 
	 public function deleteProductCategory($productcatID){
		$this->db->where('product_cat_id', $productcatID);
		$this->db->delete('product_category');
	 }
	
	 //Status ChangeFor Product Category Status
	 public function changeProductCategoryStatus($product_catID,$data){
		$this->db->where('product_cat_id',$product_catID);
		$this->db->update('product_category',$data);
		//echo $this->db->last_query();
	 }

	 public function checkCategoryName($str,$compCode) {
 		$this->db->select('*');
		$this->db->where(['comp_code'=>$compCode,'cat_name'=>$str]);
		$this->db->from('product_category');
		$query = $this->db->get();
		if($query->num_rows() > 0) 
			return $query->row();
	 }

	 public function checkProductCategoryOnEditCase($str,$catId,$compCode) {
	 	$this->db->select('*');
		$this->db->from('product_category');
		$this->db->where(['comp_code'=>$compCode,'product_cat_id !='=>$catId,'cat_name'=>$str,'cat_parent_id'=>0]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
	 }

}
