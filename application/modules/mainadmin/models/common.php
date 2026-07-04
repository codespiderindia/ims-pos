<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library('email');
		
	}

	// Get Webadmin Logged In
	function get_webadmin_login(){
	    $username = $this->input->post('username');
		$this->db->select('*');
		$this->db->from('mainadmin');
		$this->db->where(array('password' =>$this->input->post('password')));
		//$this->db->where("(email='".$username."' OR username='".$username."')");
		$this->db->where(array('username' =>$this->input->post('username')));
		$this->db->where("status",1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$query = $query->row();
			$data = array(
					'user_ID' => $query->id,
					'user_level' => 1,
					'username' => $query->username,
					'logged_in' => TRUE); 
					//print_r($data);exit;
			$this->session->set_userdata('mainadmin_session_info', $data);
	//		$this->db->where('dealer_id',$query->dealer_id);
		//	$this->db->update('dealer', array('dealer_last_login' => date('Y-m-d h:i:s') , 'dealer_last_login_IP' => $this->input->ip_address()));
			return TRUE;
		}else{
			return FALSE;
		}
	
	}
	
	
	#====== method is created for forgetpassword===================
	
	
	public function check_email($email)
	{
	    
		$data = array('email' => $email);
		$this->db->limit(1);
		$query = $this->db->get_where('dealer', $data);
		//echo var_dump($query);exit;
		if($query->num_rows() > 0){
		
				$i = $query->row_array();
				$random = time()-1327203000;
				$secret_key = sha1($random);
				$data = array('secret_key' => $secret_key);
				$this->db->where('dealer_id',$i['dealer_id']);
				$res=$this->db->update('dealer', $data);
				$send_url = base_url().'dealer/login/resetpass/'.$secret_key;
				// SEND EMAIL HERE #####################################
				$this->email->from('codespiderindia@gmail.com', 'Dealer');
				$this->email->to($i['email']);
				$this->email->subject('Dealer Password Recovery');
				$this->email->message('Dear User, /r/n Please click link to change password  \r\n \r\n  '.$send_url);
				$this->email->send();
			return true;
		}else{
		
			return false;
		}
		
		
	}
	
	
#======================  for forgetpass model method =======================

	
	public function validate_key($key)
	 {
		$data = array('secret_key' => $key);
		$this->db->limit(1);
		$query = $this->db->get_where('dealer', $data);
		//var_dump( $query); exit;
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	
	}
	
	public function resetpassword($passData)
	{
		//$clientID=$passData['clientID'];
		$secretKey=$passData['secret_key'];
		$new_password=$passData['new_password'];
	
			$this->db->where('secret_key',$secretKey);
			$data = array('password' => sha1($new_password),'secret_key' => '');
			$this->db->update('dealer', $data);
			if ($this->db->affected_rows() == 1){
				return true;
			}
			else{
				return false;
			}	
			
	}
	public function getDealerDetails($dealer_id){
		$this->db->select('*');
		$this->db->from('dealer');
		$this->db->where('dealer_id', $dealer_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
	
  
}
