<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managepaymethod_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

 	function addPaymethod($data){
		$this->db->insert('paymethod_master',$data);
	}

  public function getPaymethods(){
		$query = $this->db->get('paymethod_master');
		 if($query->num_rows() > 0)
                return $query->result();
            else
               return FALSE;
  }
 public function getPaymethodByID($id){
	$query = $this->db->get_where('paymethod_master', array('paymethod_ID' => $id));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
 public function updatePaymethod($pmID,$data){
  	$this->db->where('paymethod_ID',$pmID);
	$this->db->update('paymethod_master',$data);
  }
 
 public function deletePaymethod($pmID){
	$this->db->delete('paymethod_master',array('paymethod_ID'=>$pmID));
 }
 
 public function changeStatus($pmID,$data){
 	$this->db->where('paymethod_ID',$pmID);
	$this->db->update('paymethod_master',$data);
	//echo $this->db->last_query();
 }
 

 
}
