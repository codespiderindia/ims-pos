<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageuserstoretransfer_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('email');
	}

	function insertUserTransferToStore($data) {
		$this->db->insert('store_to_store_user_transfer',$data);
		return $this->db->insert_id();
	}
	function updateUserTransferToStore($data,$where) {
		$this->db->where($where);
		$this->db->update('store_to_store_user_transfer',$data);
	}
	function getUserTransfer($where) {
		$query = $this->db->get_where('store_to_store_user_transfer', $where);
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
	}
}
