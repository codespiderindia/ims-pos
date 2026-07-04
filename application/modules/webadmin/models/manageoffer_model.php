<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageoffer_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
	function offerInsert($data){
		$this->db->insert('offer', $data);
	}
	function getAllOffer($compCode){
		$this->db->select('*');
		$this->db->from('offer');
		$this->db->where('comp_code', $compCode);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	function editOffer($offer_id){
		$this->db->select('*');
		$this->db->from('offer');
		$this->db->where('offer_id', $offer_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}	
	}
	function updateOffer($data, $offer_id){
		$this->db->where('offer_id', $offer_id);
		$this->db->update('offer', $data);
	}
	function deleteOffer($offer_id){
		$this->db->where('offer_id', $offer_id);
		$this->db->delete('offer');
	}
	
	function changeOfferStatus($offerID,$data){
 	$this->db->where('offer_id',$offerID);
	$this->db->update('offer',$data);
	//echo $this->db->last_query();
 }
}
