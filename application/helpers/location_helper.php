<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');





///source

//https://github.com/EllisLab/CodeIgniter/wiki/helper-dropdown-country-code



if( ! function_exists('getCountryName')){

	//selected country would be retrieved from a database or as post data

function  getCountryName($country_id){

	// You may want to pull this from an array within the helper

	$ci =& get_instance();

	$ci->load->database();

	$sql = "SELECT name FROM countries where id=".$country_id; 

	$query = $ci->db->query($sql);

	$row = $query->row();

	return $row->name;

	}

}



if( ! function_exists('getStateName')){

	//selected country would be retrieved from a database or as post data

function  getStateName($state_id){

	// You may want to pull this from an array within the helper

	$ci =& get_instance();

	$ci->load->database();

	$sql = "SELECT name FROM states where id=".$state_id; 

	$query = $ci->db->query($sql);

	$row = $query->row();

	return $row->name;

	}

}

if( ! function_exists('getAllStateName')){
	//selected country would be retrieved from a database or as post data
function getAllStateName($countryId){

	// You may want to pull this from an array within the helper

	$ci =& get_instance();

	$ci->load->database();

	$sql = "SELECT * FROM states where country_id=".$countryId; 

	$query = $ci->db->query($sql);

	$result = $query->result();

	return $result;
	}
}

if( ! function_exists('getCityName')){

	//selected country would be retrieved from a database or as post data

function  getCityName($city_id){

	// You may want to pull this from an array within the helper

	$ci =& get_instance();

	$ci->load->database();

	$sql = "SELECT name FROM cities where id=".$city_id; 

	$query = $ci->db->query($sql);

	$row = $query->row();

	return $row->name;

	}

}


if( ! function_exists('getAllCityName')){

	//selected country would be retrieved from a database or as post data
	
function getAllCityName($stateId){

	// You may want to pull this from an array within the helper

	$ci =& get_instance();

	$ci->load->database();

	$sql = "SELECT * FROM cities where state_id=".$stateId; 

	$query = $ci->db->query($sql);

	$result = $query->result();

	return $result;
	
	}
	
}