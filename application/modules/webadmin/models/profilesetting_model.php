<?php if(!defined('BASEPATH')) exit('No direct script access allowed');
#=============================================================
# created By : Vedgupt Saraf
# Created Date : 24/08/2016
# purpose : This controller is create for Manage change password
# Database name: in_management
#=============================================================

class Profilesetting_model extends CI_Model{
 function __construct(){
  parent::__construct();
 }
 
 function change_password(){
 $uInfo=$this->session->userdata('webadmin_session_info');
		$this->db->where('user_ID', $uInfo['user_ID']);
		$this->db->where('user_password', sha1($this->input->post('password')));
		$query = $this->db->get('user_master');
		if($query->num_rows() == 1){
			$this->db->where('user_ID', $uInfo['user_ID']);
			$this->db->update('user_master', array('user_password' => sha1($this->input->post('npassword')), 'comp_password' => $this->input->post('npassword')));
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	function updateProfile($data)
	{
	  	$uInfo=$this->session->userdata('webadmin_session_info');
	  	$this->db->where('user_master.user_ID',$uInfo['user_ID']);
	  	$this->db->update('user_master',$data);
	}
	function addFirm($data){
		$uInfo=$this->session->userdata('webadmin_session_info');
	  	$this->db->insert('firm_details',$data);
	 }
	function updateFirm($data){
		$uInfo=$this->session->userdata('webadmin_session_info');
	  	$this->db->where('firm_details.updated_by',$uInfo['user_ID']);
	  	$this->db->update('firm_details',$data);
	}
	function getFirm(){
	    $uInfo=$this->session->userdata('webadmin_session_info');
		$this->db->select('firm_name,firm_logo,firm_address,firm_teen_num');
		$this->db->from('firm_details');
		$where_array=array('updated_by'=>$uInfo['user_ID']);
		$this->db->where($where_array);
		$query= $this->db->get();
	    return $query->row();
	}
 	function getUser()
	{
		$uInfo=$this->session->userdata('webadmin_session_info');
		$this->db->select('user_full_name,user_email,user_name,user_account_status');
		$this->db->from('user_master');
		$where_array=array('user_ID'=>$uInfo['user_ID'],'user_role'=>$uInfo['user_role']);
		$this->db->where($where_array);
		$query= $this->db->get();
	    return $query->row();
	}
 
}//end of Generalsetting_model Class
?>