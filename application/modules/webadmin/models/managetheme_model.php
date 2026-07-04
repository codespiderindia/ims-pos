<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managetheme_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
 	function insertThemeColor($data){
		$this->db->insert('themes_setting', $data);
	}
	function selectThemeColor($user_ID, $user_level){
		$whereArr = array('user_ID' => $user_ID, 'user_level' => $user_level); // AND Operator 
		$this->db->select('*');
		$this->db->from('themes_setting');
		$this->db->where($whereArr); 		
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	function updateThemeColor($user_ID, $user_level, $data){
		$whereArr = array('user_ID' => $user_ID, 'user_level' => $user_level); // AND Operator 
		$this->db->where($whereArr); 		
		$this->db->update('themes_setting', $data);
	}
}
