<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managetax_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	function addTax($data){
		$this->db->insert('tax',$data);
		$tax_ID=$this->db->insert_id();
	}

  public function getAllTax($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('tax');
		$query = $this->db->get();
		return $query->result();
  }
  public function getTaxInfoByID($taxID){
	$query = $this->db->get_where('tax', array('tax_id' => $taxID));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function updateTax($taxID,$data){
  	$this->db->where('tax_id',$taxID);
	$this->db->update('tax',$data);
  }
 
 public function deleteTax($taxID){
	$this->db->where('tax_id', $taxID);
	$this->db->delete('tax');
 }
 
 //Status ChangeFor User Status
 public function changeTaxStatus($userID,$data){
 	$this->db->where('user_ID',$userID);
	$this->db->update('user_master',$data);
	//echo $this->db->last_query();
 }


 //Change The Tax Status
 public function changeStatus($taxID,$data) {
 	$this->db->where('tax_id',$taxID);
	$this->db->update('tax',$data);
 }

 public function checkTaxName($str,$compCode,$country,$state) {
	$this->db->select('*');
	$this->db->where(['comp_code'=>$compCode, 'tax_name'=>$str, 
					'country_id'=>$country, 'state_id'=>$state]);
	$this->db->from('tax');
	$query = $this->db->get();
	if($query->num_rows() > 0)
		return $query->row();
 }

 public function checkCessTax($taxname) {
 	$this->db->select('*');
 	$this->db->like('tax_name',$taxname,'both');

 	$this->db->from('tax');
	$query = $this->db->get();
	
	if($query->num_rows() > 0) {
		return $query->result();
	} 
 }
 
}
