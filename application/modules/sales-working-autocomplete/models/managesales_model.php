<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managesales_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	

  
 
		public function get_search_suggestions($search, $filters = array('is_deleted' => FALSE, 'search_custom' => FALSE), $unique = FALSE, $limit = 25)
	{
		$suggestions = array();

		$this->db->select('product_id, product_name');
		$this->db->from('product');
		$this->db->like('product_name', $search);
		$this->db->order_by('product_name', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$suggestions[] = array('value' => $row->product_id, 'label' => $row->product_name);
		}

		$this->db->select('product_id, product_barcode_text');
		$this->db->from('product');
		$this->db->like('product_barcode_text', $search);
		$this->db->order_by('product_barcode_text', 'asc');
		foreach($this->db->get()->result() as $row)
		{
			$suggestions[] = array('value' => $row->product_id, 'label' => $row->product_barcode_text);
		}

		


		//only return $limit suggestions
		if(count($suggestions > $limit))
		{
			$suggestions = array_slice($suggestions, 0,$limit);
		}

		return $suggestions;
	}
 
}
