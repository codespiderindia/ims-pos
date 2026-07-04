<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageproducts_model extends CI_Model {

	function __construct(){
		parent::__construct();
		
	}

	// Count all record of table "products" in database.
    function record_count($comp_code) {
      $this->db->where('comp_code',$comp_code);
        //$this->db->where('password',$password);
        $this->db->from('product');
        return $count = $this->db->count_all_results();
	  //  $this->db->where('comp_code',$comp_code);
		//return $this->db->count_all("product");
    }

	function getAllProduct($limit, $id,$comp_code)
	{
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
  		$this->db->from('product');
		$this->db->limit($limit,$id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            
            return $data;
        }
        return false;
	}

    // Insert customer details in "customer" table in database.
    function insert_customer($data)
    {
        $this->db->insert('customers', $data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;      
    }
    
    // Insert order date with customer id in "orders" table in database.
    function insert_order($data)
    {
        $this->db->insert('orders', $data);
        $id = $this->db->insert_id();
        return (isset($id)) ? $id : FALSE;
    }
    
    // Insert ordered product detail in "order_detail" table in database.
    function insert_order_detail($data)
    {
        $this->db->insert('order_detail', $data);
    }

    function getOrderInfo($ord_id)
    {
        $this->db->select('*');
        $this->db->from('orders a'); 
        $this->db->join('order_detail c', 'c.order_id=a.order_id', 'left');
        $this->db->where('c.order_id',$ord_id);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            
            return $data;
        }
        return false;
    }
    function updateCreditAmount($tableName, $columnName, $columnValue, $data){
        $this->db->where($columnName, $columnValue);
        $this->db->update($tableName, $data);
    }
    function insert_shipping_address($data){
        $this->db->insert('shipping_address', $data);
    }

	function getProductVariations($productId) {
        $this->db->select('GROUP_CONCAT(attribute_id) as attribute_id, GROUP_CONCAT(Variation_id) as Variation_id');
        $this->db->where(['product_id'=>$productId,'flag'=>1]);
        $this->db->from('product_variations_relations');
        $this->db->group_by('sku');
        $query = $this->db->get();
        return $query->result();
    }

    function getProductByFilter($compCode, $productName, $catId, $startamt, $endamt, $offset=false) {
        //echo $limit.'</br>'.$id.'</br>';
        $this->db->select('*');
        $this->db->where('comp_code',$compCode);

        if($productName != '') {
              $this->db->where("product_name LIKE '%".$productName."%'");
        }

        if($catId != '') {
            $this->db->where('product_category',$catId);
        }

        $this->db->where("product_price BETWEEN $startamt AND $endamt", NULL, FALSE );

        if(isset($offset) && $offset != '') {
            $this->db->limit(6,$offset);
        } else {
            $this->db->limit(6);
        }

        $this->db->order_by('product_id','ASC');

        
        $this->db->from('product');
        $query = $this->db->get();

       
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
            
            return $data;
        }
        return false;
    }
}