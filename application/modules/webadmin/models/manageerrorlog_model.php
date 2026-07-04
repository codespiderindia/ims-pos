<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageerrorlog_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
		global $uInfo;
		$uInfo=$this->session->userdata('webadmin_session_info');
	}

	public function getAllEventLogs() {
		global $uInfo;
		$userId = $uInfo['user_ID'];

		$this->db->where(['userid_by'=>$userId,'flag'=>0]);
		$this->db->where_not_in('affected_table', array('Dealer_login','Dealer_logout','Sales_logout','Sales_login'));
		$this->db->from('event_logs');
		$query = $this->db->get();
		return $query->result_array();
	}

	public function getModuleName() 
	{
		global $uInfo;
		$userId = $uInfo['user_ID'];

		$this->db->where(['userid_by'=>$userId,'flag'=>0]);
		$this->db->where_not_in('affected_table', array('Dealer_login','Dealer_logout','Sales_logout','Sales_login'));
		$this->db->from('event_logs');
		$this->db->group_by('affected_table');
		$query = $this->db->get();
		return $query->result_array();
	}


	public function getLogByModuleNmDate($module_name,$selectDate)
  	{
  		global $uInfo;
  		$userId = $uInfo['user_ID'];

  		if($module_name != '' && $selectDate != '') {
  			$this->db->where(['DATE_FORMAT(`event_modified`, "%Y-%m-%d") =' =>$selectDate,
  								'affected_table'=>$module_name,
  								'userid_by'=>$userId]);
  		}
  		$this->db->where('flag',0);

  		$this->db->from('event_logs');
		$query = $this->db->get();
		return $query->result_array();
  	}

}