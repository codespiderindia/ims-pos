<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managerole_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

 	function addRole($data){
	
		$this->db->insert('role',$data);
		$user_ID=$this->db->insert_id();
		
	}
 
  public function getAllRoles(){
  $uInfo = $this->session->userdata('webadmin_session_info');
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$uInfo['comp_code']));
		$this->db->from('role');
		$query = $this->db->get();
		return $query->result();
  }
  public function getRoleInfoByID($id){
	$query = $this->db->get_where('role', array('role_code' => $id));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function updateRoles($roleID,$data){
  	$this->db->where('role_code',$roleID);
	$this->db->update('role',$data);
  }
  
  function deleteRoles($role_code){
		$this->db->where('role_code', $role_code);
		$this->db->delete('role');
	}
	
 public function checkRoleName($str,$compCode) {
 		$this->db->select('*');
		$this->db->from('role');
		$this->db->where(['comp_code'=>$compCode,
						 'role_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
 }

 function checkRoleNameOnEditCase($str,$roleId,$compCode) {
 	$this->db->select('role_name,role_code');
	$this->db->from('role');
	$this->db->where(['comp_code'=>$compCode,'role_code !='=>$roleId,'role_name'=>$str]);
	$query = $this->db->get();
	if($query->num_rows() > 0)
		return $query->row();
 }

 function getAllRoleName() {
 		$uInfo = $this->session->userdata('webadmin_session_info');
		$this->db->select('role_name');
		$this->db->where(array('comp_code'=>$uInfo['comp_code']));
		$this->db->from('role');
		$query = $this->db->get();
		return $query->result();
 }
 
 
}
