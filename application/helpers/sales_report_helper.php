<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


if(!function_exists('getStoreNameByID')){
	function getStoreNameByID($id) {
		$CI =& get_instance();
		$CI->load->database();
		$uInfo=$CI->session->userdata('sales_session_info');

		$CI->db->select('store_name');
	    $CI->db->from('store');
	    $CI->db->where('store_id',$id);


	   	 $query = $CI->db->get();
	        if($query->num_rows() > 0)
	            return $query->row()->store_name;
	        else
	            return FALSE;
    

	
	}
}

if(!function_exists('getCompanyNameByID')){
	function getCompanyNameByID($id) {
		$CI =& get_instance();
		$CI->load->database();
		$uInfo=$CI->session->userdata('sales_session_info');

		$CI->db->select('comp_name');
	    $CI->db->from('companies');
	    $CI->db->where('comp_id',$id);


	   	 $query = $CI->db->get();
	        if($query->num_rows() > 0)
	            return $query->row()->comp_name;
	        else
	            return FALSE;
    

	
	}
}




