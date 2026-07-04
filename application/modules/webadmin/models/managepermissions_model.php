<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ManagePermissions_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

 	function check_exist_module($module_value,$role_code)
	{
		$this->db->select('modulecode');
		$this->db->from('role_rights');
		$this->db->where('modulecode',$module_value);
		$this->db->where('rolecode',$role_code);
		$query = $this->db->get();
		if($query->num_rows() == 1)
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	
	function addPermissions($value){
		$this->db->insert('role_rights',$value);
		$user_ID=$this->db->insert_id();
	}
 
  public function getAllPermissions(){
		$this->db->select('*');
		$this->db->from('role_rights');
		$this->db->order_by("rolecode", "desc");
		$query = $this->db->get();
		return $query->result();
  }
  public function getPermissionsInfoByID($id){
	$query = $this->db->order_by('modulecode','ASC')->get_where('role_rights', array('rolecode' => $id));
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
  }
  
  public function getPermissionsInfoByRoleID($role_id){
	$query = $this->db->order_by('modulecode','ASC')->get_where('role_rights', array('rolecode' => $role_id));
		if($query->num_rows() > 0)
		
			return $query->result_array();
		else
			return FALSE;
  }
  
  public function updatePermissions($id,$value){
	$this->db->where(['id'=>$id]);
	$this->db->update('role_rights',$value);
  }

  public function getAllRoleCode($user_id) {
  		$query = $this->db->get_where('role', array('created_by' => $user_id));
		if($query->num_rows() > 0)
			return $query->result_array();
		else
			return FALSE;
  }

  public function getAllPermissionByRolCode($roleCode) {
  		$this->db->select('*');
		$this->db->from('role_rights');
		$this->db->where_in('rolecode', $roleCode);
		$this->db->order_by("rolecode", "desc");
		$query = $this->db->get();
		return $query->result();
  }
 
}
