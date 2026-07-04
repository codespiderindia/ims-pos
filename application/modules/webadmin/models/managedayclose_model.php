<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managedayclose_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		global $uInfo;
		$this->load->library('email');
		$uInfo=$this->session->userdata('webadmin_session_info');
	}


	function getCloseInfoForSelectedVal($date,$userId) {
		global $uInfo;
		$this->db->select('*');
		$this->db->from('day_close');
		$this->db->where('comp_code', $uInfo['comp_code']);
		if($date!='') {
			$this->db->where("`created_date` LIKE '%$date%'");
		}
		
		if($userId!='') {
			$this->db->where("user_id", $userId);
		}
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}

	function getDayCloseInfo($date) {
		global $uInfo;
		$this->db->select('*');
		$this->db->from('day_close');
		$this->db->where('comp_code', $uInfo['comp_code']);
		$this->db->where("`created_date` LIKE '%$date%'");
		$this->db->where('store_id', $uInfo['store_id']);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}

}