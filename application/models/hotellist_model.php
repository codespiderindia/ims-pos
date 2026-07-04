<?php
class HotelList_model extends CI_Model{

	function __construct(){
		parent::__construct();
	}
  

	public function getHotelList()
	{
	  $this->db->select('hotel_master.hotel_ID,hotel_name,	hotel_address,hotel_state,image_ID,image_name');
	  $this->db->from('hotel_master');
	  $this->db->join('images','images.hotel_ID=hotel_master.hotel_ID');
	  $this->db->where('images.image_type',1);
	  $this->db->where('images.flag',1);
	  $query = $this->db->get();
	  return $query->result();
	}
}
?>