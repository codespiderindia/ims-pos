<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('event_log')){
	//Inserted user logs into database or as performed any operation
function  event_log($type,$userid,$performed_on_id,$affected_table,$modulename,$modified,$description){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "INSERT INTO event_logs (event_type, userid_by, performed_on_id, affected_table, modulename, event_modified, description) VALUES ('".$type."', '".$userid."', '".$performed_on_id."', '".$affected_table."', '".$modulename."', '".$modified."', '".$description."')"; 
	$query = $ci->db->query($sql);
	return true;
	}
}