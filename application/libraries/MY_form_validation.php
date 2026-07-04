<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class MY_form_validation extends CI_form_validation {

    function valid_url($str){

           $pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
            if (!preg_match($pattern, $str))
            {
                return FALSE;
            }

            return TRUE;
    }
	/*
		USES:
			 ON ADD:
			 $this->form_validation->set_rules('username', 'User', 'is_unique[t_users.username]');  
			 ON EDIT:
			 $this->form_validation->set_rules('username', 'User', 'is_unique[t_users.username.id.'.$id.']');  
	*/
	
	function is_unique($str, $field){
		if (substr_count($field, '.')==3)
		{
		list($table,$field,$id_field,$id_val) = explode('.', $field);
		$query = $this->CI->db->limit(1)->where($field,$str)->where($id_field.' != ',$id_val)->get($table);
		} else {
		list($table, $field)=explode('.', $field);
		$query = $this->CI->db->limit(1)->get_where($table, array($field => $str));
		}
		
		return $query->num_rows() === 0;
	}

}  