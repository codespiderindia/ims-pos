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
		$this->db->from('user_master');
		$this->db->where(array('user_password' =>sha1($this->input->post('password'))));
		$this->db->where("(user_email='".$username."' OR user_name='".$username."')");
		$this->db->where("user_account_status",1);
		$query = $this->db->get();

		if($query->num_rows() == 1){
			$query = $query->row();
			$data = array(
					'user_ID' => $query->user_ID,
					'user_role' => $query->user_role,
					'user_level' => $query->user_level,
					'user_full_name' => $query->user_full_name,
					'user_email' => $query->user_email,
					'store_id' => $query->store_id,
					'warehouse_id' => $query->warehouse_id,
					'user_last_login' => $query->user_last_login,
					'user_last_login_IP' => $query->user_last_login_IP,
					'store_manager' => $query->store_manager,
					'comp_code' => $query->comp_code,
					'created_by' => (isset($query->created_by) ? $query->created_by : ''),
					'logged_in' => TRUE); 
					//print_r($data);exit;
			$this->session->set_userdata('webadmin_session_info', $data);
			$this->session->set_userdata('row_count', 10);
			$this->db->where('user_ID',$query->user_ID);
			$this->db->update('user_master', array('user_last_login' => date('Y-m-d h:i:s') , 'user_last_login_IP' => $this->input->ip_address()));

		
			/*Code for remember me login*/
			if(!empty($_POST["remember"])) {
				setcookie ("member_login",$this->input->post('username'),time()+ (10 * 365 * 24 * 60 * 60));
				setcookie ("member_password",$this->input->post('password'),time()+ (10 * 365 * 24 * 60 * 60));
			} else {
				if(isset($_COOKIE["member_login"])) {
					setcookie ("member_login","");
				}
				if(isset($_COOKIE["member_password"])) {
					setcookie ("member_password","");
				}
			}
			/*Code for remember me login*/
			return true;
		}else{
			return false;
		}
	}


	function check_status($user_ID) {
		$this->db->select('*');
		$this->db->from('user_master');

		$this->db->where(['user_ID'=>$user_ID, 'user_account_status'=>1, 'approved_by_hr'=>1, 
			'comp_status'=>1]);

		$query = $this->db->get();
		
		if($query->num_rows() == 1){
			$query = $query->row();
			return true;
		} else { 
			return false;
		}
	}

	
	function get_webadmin_login_by_status(){

	    $username = $this->input->post('username');

		$this->db->select('*');

		$this->db->from('user_master');

		$this->db->where(array('user_password' =>sha1($this->input->post('password'))));

		$this->db->where("(user_email='".$username."' OR user_name='".$username."')");

		$this->db->where("user_account_status",1);				
		
		$this->db->where("approved_by_hr",1);	
		
		$this->db->where("comp_status",1);	

		$query = $this->db->get();

		if($query->num_rows() == 1){

			$query = $query->row();

			$data = array(

					'user_ID' => $query->user_ID,

					'user_role' => $query->user_role,

					'user_level' => $query->user_level,

					'user_full_name' => $query->user_full_name,

					'user_email' => $query->user_email,
					
					'store_id' => $query->store_id,
					
					'warehouse_id' => $query->warehouse_id,

					'user_last_login' => $query->user_last_login,

					'user_last_login_IP' => $query->user_last_login_IP,
					
					'comp_code' => $query->comp_code,
					'store_manager' => $query->store_manager,

					'logged_in' => TRUE);

			$this->session->set_userdata('webadmin_session_info', $data);

			$this->session->set_userdata('row_count', 10);

			$this->db->where('user_ID',$query->user_ID);

			$this->db->update('user_master', array('user_last_login' => date('Y-m-d h:i:s') , 'user_last_login_IP' => $this->input->ip_address()));

			return TRUE;
			
		}else{
				return FALSE;
			}

	

	}
	
	#====== method is created for forgetpassword===================
	
	
	public function check_email($email)
	{
	    
		$data = array('user_email' => $email);
		$this->db->limit(1);
		$query = $this->db->get_where('user_master', $data);
		//echo var_dump($query);exit;
		if($query->num_rows() > 0){
		
				$i = $query->row_array();
				$random = time()-1327203000;
				$secret_key = sha1($random);
				$data = array('secret_key' => $secret_key);
				$this->db->where('user_ID',$i['user_ID']);
				$res=$this->db->update('user_master', $data);
				$send_url = base_url().'webadmin/login/resetpass/'.$secret_key;
				// SEND EMAIL HERE #####################################
				$this->email->from('codespiderindia@gmail.com', 'CHMS Admin');
				$this->email->to($i['user_email']);
				$this->email->subject('CHMS Password Recovery');
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
		$query = $this->db->get_where('user_master', $data);
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
			$data = array('user_password' => sha1($new_password),'secret_key' => '');
			$this->db->update('user_master', $data);
			if ($this->db->affected_rows() == 1){
				return true;
			}
			else{
				return false;
			}	
			
	}
	
  
}
