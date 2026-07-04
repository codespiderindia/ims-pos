<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageloyaltypoint_model extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('email');
	}

	function getAllPoints($compCode) {
		$this->db->select('*');
		$this->db->from('loyalty_point');
		$this->db->where(['comp_code'=>$compCode]);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	function getPointsByCatId($catId, $compCode) {
		$this->db->select('*');
		$this->db->from('loyalty_point');
		$this->db->where(['category_id'=>$catId, 'comp_code'=>$compCode]);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}

	function changePointStatus($id, $data) {
		$where=['id'=>$id];
		$this->db->where($where);
		$this->db->update('loyalty_point', $data); 
	}

}