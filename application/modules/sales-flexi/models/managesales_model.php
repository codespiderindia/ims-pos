<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesales_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	

  
 
	function get_search_suggestions($search, $filters = array('is_deleted' => FALSE, 'search_custom' => FALSE), $unique = FALSE, $limit = 25)
	{
		$suggestions = array();

		$this->db->select('product_id, product_name, product_barcode_text');
		$this->db->from('product');
		$this->db->like('product_name', $search);
		$this->db->or_like('product_barcode_text', $search);
		$this->db->order_by('product_name', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$prd_name=$row->product_barcode_text." (".$row->product_name.")";
			$suggestions[] = array('value' => $row->product_id, 'label' => $prd_name);
		}

		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}

		return $suggestions;
	}

	function getItemInfoByID($itmID){
		$this->db->select("product_id,product_name,product_tax,product_price,gst_rate");
		$this->db->from('product');
		$this->db->where('product_id',$itmID);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row_array();
		else
			return FALSE;
	}
 
}
