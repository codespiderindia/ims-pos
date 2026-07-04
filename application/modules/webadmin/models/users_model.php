<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

   function getAllhoteladminUsers()
   {
    $this->db->select('user_full_name,user_email,uhr_status,user_created,hotel_ID,user_master.user_ID,user_master.user_role');
	$this->db->from('user_master');
	$this->db->join('user_hotel_role','user_hotel_role.user_ID=user_master.user_ID');
	$this->db->where('user_role',2);
	$query= $this->db->get();
	if($query->num_rows() > 0)
	return $query->result();
	else
	return false;
   }
   
   
   function getAllfrontadminUsers()
   {
    $this->db->select('user_full_name,user_email,user_name,uhr_status,user_created,hotel_ID,user_master.user_ID,user_master.user_role');
	$this->db->from('user_master');
	$this->db->join('user_hotel_role','user_hotel_role.user_ID=user_master.user_ID');
	$this->db->where('user_role',3);
	$query= $this->db->get();
	if($query->num_rows() > 0)
	return $query->result();
	else
	return false;
   }
 
 
 function hotelchange_password($id){
 
		$this->db->where('user_ID', $id);
		$this->db->where('user_password', sha1($this->input->post('password')));
		$query = $this->db->get('user_master');
		if($query->num_rows() == 1){
			$this->db->where('user_ID', $id);
			$this->db->update('user_master', array('user_password' => sha1($this->input->post('npassword'))));
			return TRUE;
		}else{
			return FALSE;
		}
	}
	
	
	function frontchange_password($id){
 
		$this->db->where('user_ID', $id);
		$this->db->where('user_password', sha1($this->input->post('password')));
		$query = $this->db->get('user_master');
		if($query->num_rows() == 1){
			$this->db->where('user_ID', $id);
			$this->db->update('user_master', array('user_password' => sha1($this->input->post('npassword'))));
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
