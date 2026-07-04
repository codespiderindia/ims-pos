<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Common extends CI_Model {

	function __construct(){
		parent::__construct();
		$this->load->library(['email','cart']);
		
	}

	// Get Webadmin Logged In
	function get_webadmin_login(){
	    $username = $this->input->post('username');
		$this->db->select('*');
		$this->db->from('dealer');
		$this->db->where(array('password' =>sha1($this->input->post('password'))));
		$this->db->where("(email='".$username."' OR username='".$username."')");
		$this->db->where("dealer_status",1);
		$query = $this->db->get();
		if($query->num_rows() == 1){
			$this->cart->destroy();
			$this->session->unset_userdata('_product_offer_');
			$this->session->unset_userdata('_product_tax_');
			$query = $query->row();
			$data = array(
					'user_ID' => $query->user_ID,
					'user_level' => $query->user_level,
					'user_role' => $query->user_role,
					'dealer_id' => $query->dealer_id,
					'f_name' => $query->f_name,
					'l_name' => $query->l_name,
					'email' => $query->email,
					'username' => $query->username,
					'country' => $query->country,
					'state' => $query->state,
					'city' => $query->city,
					'address' => $query->address,
					'zipcode' => $query->zipcode,
					'mobile_number' => $query->mobile_number,
					'dealer_status' => $query->dealer_status,
					'dealer_last_login' => $query->dealer_last_login,
					'comp_code' => $query->comp_code,
					'dealer_last_login_IP' => $query->dealer_last_login_IP,
					'logged_in' => TRUE); 
					//print_r($data);exit;
			$this->session->set_userdata('dealer_session_info', $data);
			$this->session->set_userdata('row_count', 10);
			$this->db->where('dealer_id',$query->dealer_id);
			$this->db->update('dealer', array('dealer_last_login' => date('Y-m-d h:i:s') , 'dealer_last_login_IP' => $this->input->ip_address()));
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
