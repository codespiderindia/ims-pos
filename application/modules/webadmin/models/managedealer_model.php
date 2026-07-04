<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managedealer_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	function addDealer($data){
		$this->db->insert('dealer',$data);
		$user_ID=$this->db->insert_id();
	}
	
	function addDealerBankDetails($data1){
		$this->db->insert('dealer_bank_details',$data1);
		$user_ID=$this->db->insert_id();
	}

  public function getAllDealer($comp_code){
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('dealer');
		$query = $this->db->get();
		return $query->result();
  }
  public function getAllProdcuts($comp_code){
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
  }
  
  
  
  public function getAllDealerAndPayments() {
   $this->db->select('dealer_invoice.*,dealers.*');
    $this->db->from('dealer_invoice');
    $this->db->join('dealer', 'dealer_invoice.dealer_id = dealer.dealer_id', 'left'); 
    $query = $this->db->get();
  
  } 
  
   public function getDealerPayments(){
		$this->db->select('*');
		$this->db->from('dealer_invoice');
		$query = $this->db->get();
		return $query->result();
  }
  
  
  public function getDealerInfoByID($dealerID){
	$query = $this->db->get_where('dealer', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function getDealerInvoice($dealerID)
  {
  $query = $this->db->get_where('dealer_invoice', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
		{
			
		return $query->result();
		} 
		else {
			return FALSE;
  }
  }
  
  public function checkDealerPriceDis($dealerID,$product_id,$batchId)
  {
  $query = $this->db->get_where('dealer_product_price', array('product_id'=>$product_id,'dealer_id' => $dealerID, 'batch_id'=>0));

		if($query->num_rows() > 0)
		{
			return TRUE;
		} 
		else {
			return FALSE;
  		}
  }

  
  
   public function getAllDealerDiscountOnproducts($comp_code){
		$this->db->select('b.master_product_id, b.product_id, b.dealer_id, b.price, b.created_by, b.created_date, a.batch_number');
		$this->db->where(array('b.comp_code'=>$comp_code));
		$this->db->join('product_batch as a', 'a.product_batch_id = b.batch_id');
		$this->db->from('dealer_product_price as b');
		$query = $this->db->get();
		return $query->result();
  }
  
  
  public function getDealerBankInfoByID($dealerID){
	$query = $this->db->order_by('id', 'ASC')->get_where('dealer_bank_details', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
  }
  
  
  
  public function updateDealer($dealerID,$data){
  	$this->db->where('dealer_id',$dealerID);
	$this->db->update('dealer',$data);
  }
  
   public function oldDealerBankDetails($dealerID){
  	$this->db->where('dealer_id', $dealerID);
	$this->db->delete('dealer_bank_details');
  }
 
 public function deleteDealer($dealerID){
	$this->db->where('dealer_id', $dealerID);
	$this->db->delete('dealer');
 }
 
 //Status ChangeFor User Status
 public function changeDealerStatus($dealerID,$data){
 	$this->db->where('dealer_id',$dealerID);
	$this->db->update('dealer',$data);
	//echo $this->db->last_query();
 }
 
 public function changePassword($dealerID)
 {
	
		$this->db->where('dealer_id', $dealerID);
		$this->db->where('password', sha1($this->input->post('password')));
		//$this->db->where('cpassword', $this->input->post('cpassword'));
		$query = $this->db->get('dealer');
		if($query->num_rows() == 1){
			$this->db->where('dealer_id', $dealerID);
			$this->db->update('dealer', array('password' => sha1($this->input->post('npassword')),'cpassword' => $this->input->post('cpassword')));
			return TRUE;
		}else{
			return FALSE;
		}
	
 }
 
 public function checkEmailExist($email)
 {
		$query = $this->db->get_where('dealer', array('email' => $email));
		if($query->num_rows() > 0)
		{
			echo "Email Already Exists";
		}else{
			echo "true";
		}
 }
 
}
