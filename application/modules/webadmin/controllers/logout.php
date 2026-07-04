<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Logout extends CI_Controller
{
		public function __construct()
		{		
			parent::__construct();	
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			 
		}

	function index()
	{	
		$uInfo = $this->session->userdata('webadmin_session_info'); 
			/*$time=time()-180;
			mysql_query("update tbl_users set last_update='".$time."' where userID=".$this->session->userdata('userID')." ");*/

			event_log('Company_logout',$uInfo['user_ID'],$uInfo['user_role'],'Company_logout','LOGOUT',date("Y-m-d h:i:s"),'Company Logout Successfully.');

			$this->session->unset_userdata('webadmin_session_info');
			//$this->session->sess_destroy();  
			$this->db->cache_delete_all();
			header("location:".site_url()."webadmin");
	}

}
