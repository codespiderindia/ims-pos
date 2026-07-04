<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managedepartment_model extends CI_Model {

		function __construct(){
		
			parent::__construct();
			$this->load->library('email');
		}

		function addDepartment($data){
			$department_data=array(
					'department_name' =>$data['department_name'],
					'weekly_off' => $data['weekly_off'],
					'user_ID' => $data['user_ID'],
					'user_level' => $data['user_level'],
					'department_status' => $data['department_status'],
					'create_date' => $data['create_date'],
					'modify_date' => $data['modify_date'],
					'comp_code' =>$data['comp_code']
					);
			$this->db->insert('department',$department_data);
			$department_ID=$this->db->insert_id();
		}

	  public function getAllDepartment($comp_code){
			$this->db->select('*');
			$this->db->where(array('comp_code'=>$comp_code));
			$this->db->from('department');
			$query = $this->db->get();
			return $query->result();
	  }
	  public function getDepartmentInfoByID($departmentID){
		$query = $this->db->get_where('department', array('department_id' => $departmentID));
			if($query->num_rows() > 0)
				return $query->row();
			else
				return FALSE;
	  }
	  
	  public function updateDepartment($departmentID,$data){
		$this->db->where('department_id',$departmentID);
		$this->db->update('department',$data);
	  }
	 
	 public function deleteDepartment($departmentID){
		$this->db->where('department_id', $departmentID);
		$this->db->delete('department');
	 }
	 
	 //Status ChangeFor User Status
	 public function changeDepartentStatus($departmentID,$data){
		$this->db->where('department_id',$departmentID);
		$this->db->update('department',$data);
		//echo $this->db->last_query();
	 }
	 
	 //Status ChangeFor HR approval
	 public function changeHrAccountStatus($userID,$data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
		//echo $this->db->last_query();
	 }

	 public function checkDepartmentName($str,$compCode){
	 	$this->db->select('*');
		$this->db->from('department');
		$this->db->where(['comp_code'=>$compCode,
						 'department_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
	 }

	 public function checkDepartmentOnEditCase($str,$departmentId,$compCode) {
	 	$this->db->select('*');
		$this->db->from('department');
		$this->db->where(['comp_code'=>$compCode,'department_id !='=>$departmentId,'department_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
	 }

}
