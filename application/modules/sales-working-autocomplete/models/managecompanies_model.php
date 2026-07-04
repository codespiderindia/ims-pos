<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managecompanies_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	function addCompany($data){
		$this->db->insert('companies',$data);
		$user_ID=$this->db->insert_id();
	}
	
	function addVendorBankDetails($data1){
		$this->db->insert('vendor_bank_details',$data1);
		$user_ID=$this->db->insert_id();
	}

  public function getAllCompany(){
		$this->db->select('*');
		$this->db->from('companies');
		$query = $this->db->get();
		return $query->result();
  }
  public function getCompInfoByID($compID){
	$query = $this->db->get_where('companies', array('comp_id' => $compID));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function getVendorBankInfoByID($vendorID){
	$query = $this->db->order_by('id', 'ASC')->get_where('vendor_bank_details', array('vendor_id' => $vendorID));
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
  }
  
  
  
  public function updateCompany($comp_id,$data){
  	$this->db->where('comp_id',$comp_id);
	$this->db->update('companies',$data);
  }
  
   public function oldVendorBankDetails($vendorID){
  	$this->db->where('vendor_id', $vendorID);
	$this->db->delete('vendor_bank_details');
  }
 
 public function deleteVendor($vendorID){
	$this->db->where('vendor_id', $vendorID);
	$this->db->delete('vendor');
 }
 
 //Status ChangeFor User Status
 public function changeCompanyStatus($vendorID,$data){
 	$this->db->where('comp_id',$vendorID);
	$this->db->update('companies',$data);
	//echo $this->db->last_query();
 }
 
 public function changeUserComapnyStatus($vendorID,$data){
 	$this->db->where('comp_code',$vendorID);
	$this->db->update('user_master',$data);
	//echo $this->db->last_query();
 }
 
  
 public function changePassword($vendorID)
 {
	
		$this->db->where('vendor_id', $vendorID);
		$this->db->where('password', sha1($this->input->post('password')));
		//$this->db->where('cpassword', $this->input->post('cpassword'));
		$query = $this->db->get('vendor');
		if($query->num_rows() == 1){
			$this->db->where('vendor_id', $vendorID);
			$this->db->update('vendor', array('password' => sha1($this->input->post('npassword')),'cpassword' => $this->input->post('cpassword')));
			return TRUE;
		}else{
			return FALSE;
		}
	
 }
 
 public function checkEmailExist($email)
 {
		$query = $this->db->get_where('vendor', array('email' => $email));
		if($query->num_rows() > 0)
		{
			echo "Email Already Exists";
		}else{
			echo "true";
		}
 }
 
}
