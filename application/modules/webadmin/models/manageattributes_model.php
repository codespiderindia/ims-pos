<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageattributes_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	function addAttributes($data){
		$this->db->insert('attributes',$data);
		$attribute_ID=$this->db->insert_id();
	}

  public function getAllAttributes($compCode){
		$this->db->select('*');
		$this->db->from('attributes');
		$this->db->where('comp_code',$compCode);
		$query = $this->db->get();
		return $query->result();
  }
  public function getAttributesInfoByID($attributesID){
	$query = $this->db->get_where('attributes', array('attribute_id' => $attributesID));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function updateAttributes($attributesID,$data){
  	//$this->db->where('comp_code',$compCode);
  	$this->db->where('attribute_id',$attributesID);
	$this->db->update('attributes',$data);
  }
 
 public function deleteAttributes($attributesID){
	$this->db->where('attribute_id', $attributesID);
	$this->db->delete('attributes');
 }
 
 //Status ChangeFor User Status
 public function changeAttributesStatus($attributesID,$data){
 	$this->db->where('attribute_id',$attributesID);
	$this->db->update('attributes',$data);
	//echo $this->db->last_query();
 }
 
 public function checkAttributeName($str,$compCode) {
 		$this->db->select('*');
		$this->db->from('attributes');
		$this->db->where(['comp_code'=>$compCode,
						 'attribute_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
 }

 function checkAttributeNameOnEditCase($str,$attributeId,$compCode) {
	 	$this->db->select('*');
		$this->db->from('attributes');
		$this->db->where(['comp_code'=>$compCode,
						'attribute_id !='=>$attributeId,
						'attribute_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
 	}

 	public function getAllAttributevalues($attributesID){
		$this->db->select('a.*,b.attribute_name');
		$this->db->from('attribute_value a');
		$this->db->join('attributes b', 'b.attribute_id = a.attribute_id', 'left');
		$this->db->where('a.attribute_id',$attributesID);
		$query = $this->db->get();
		return $query->result();
    }

    public function deleteAttributeValue($attributesValueID){
	$this->db->where('attribute_value_id', $attributesValueID);
	$this->db->delete('attribute_value');
 }

}
