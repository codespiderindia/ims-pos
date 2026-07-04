<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managelocations_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

 	function addLocation($data){
		$this->db->insert('locations',$data);
	}

  public function getLocations($comp_code){
	
		$query = $this->db->get_where('locations',array('comp_code'=>$comp_code));
		
		 if($query->num_rows() > 0)
                return $query->result();
            else
               return FALSE;
  }
 public function getLocationInfoByID($id){
	$query = $this->db->get_where('locations', array('id' => $id));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
 public function updateLocation($LocationID,$data){
  	$this->db->where('id',$LocationID);
	$this->db->update('locations',$data);
  }
 
 public function deleteLocation($LocationID){
	$this->db->delete('locations',array('id'=>$LocationID));
 }
 
 public function changeStatus($LocationID,$data){
 	$this->db->where('id',$LocationID);
	$this->db->update('locations',$data);
	//echo $this->db->last_query();
 }

 public function addOtherCountry($data,$country_name,$sortname){
	$query = $this->db->get_where('countries', array('sortname' => $sortname,'name'=>$country_name));
		if($query->num_rows() > 0)
			return 'Already Exist';
		else
			//return true;
			$this->db->insert('countries',$data);
  }

  public function addOtherState($data,$state_name,$country_id){
	$where = "name = '$state_name' AND country_id= '$country_id'";
	$this->db->select('*');
	//$this->db->from('states');
	$this->db->where($where);
	$query = $this->db->get('states');

		if($query->num_rows() > 0)
			return 'Already Exist';
		else
			//return true;
			$this->db->insert('states',$data);
  }

  public function addOtherCity($data,$city_name,$state_id){
	$where = "name = '$city_name' AND state_id= '$state_id'";
	$this->db->select('*');
	//$this->db->from('states');
	$this->db->where($where);
	$query = $this->db->get('cities');

		if($query->num_rows() > 0)
			return 'Already Exist';
		else
			//return true;
			$this->db->insert('cities',$data);
  }
 

 
}
