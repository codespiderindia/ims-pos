<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends CI_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 * 	 
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/
<method_name>
* @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			$uInfo=$this->session->userdata('dealer_session_info');
				//var_dump($uInfo);exit();
				if (isset($uInfo) && !empty($uInfo)) {
				// ensure already signed in 
					if($uInfo['logged_in']==TRUE){redirect('dealer/dashboard');}
				}
			$this->load->library('email');
			$this->load->model('common');
		}
	public function index()
	{
		
		$this->load->model('common');
		
			
		$err_flg=false;
		$data='';
		if($this->input->post()){
			if(!$this->input->post('username')){
			$err_flg=true;
			
			}
			if(!$this->input->post('password')){
			$err_flg=true;
			}
			
			if(!$err_flg){
					$result = $this->common->get_webadmin_login();
					
					
					if(!$result){
					$data['msg'] = '<p>Invalid username and/or password.</p>';
					}
					else{
							
						$uInfo=$this->session->userdata('dealer_session_info');
						
						event_log('Dealer_login',$uInfo['user_ID'],$uInfo['user_role'],'Dealer_login','LOGIN',date("Y-m-d h:i:s"),'Dealer Login successfully.');

						if (isset($uInfo) && !empty($uInfo)) {
							
							redirect('dealer/dashboard');
						}
					}     
			}else{
					$data['msg'] = '<p>You must fill in all of the fields.</p>';
					
			}
		}
		  
		$this->load->view('login_form',$data);
		//$this->load->view('reset_password',$data);
		
	}
	
	
	public function forgotpassword(){
	
	    $this->load->model('common');
		$data='';
		if($this->form_validation->run('forgotpassword')){
			$email=$this->input->get('email');
			$flg=$this->common->check_email($email);
			if($flg){
				$data['success']=1;

				event_log('Dealer_forget_password',$uInfo['user_ID'],$uInfo['user_role'],'Dealer_forget_password','FORGET PASSWORD',date("Y-m-d h:i:s"),'Dealer Forget Password.');

				echo '<div style="text-shadow:none; color:#000;background-color:none;"> An Email has been sent on your registered email address, Please check your Inbox for more detail. </div>';
				//echo  $data['success_msg'];
			}else{
				$data['success']=0;
				echo '<div  style=" text-shadow:none; color:#CE4E4A;background-color:none;"> Sorry, We did not find your email in our Database. Please check & Try Again. </div>';
				//echo $data['success_msg'];
			}
			//$this->load->view('forgotpassword',$data);
		}
		//$this->load->view('login_form',$data);
	}
	
	
	#========= resetpass method for forgetpass ====================== 
	
	
	public function resetpass($key=''){
	    //echo $key;exit;
		if(!isset($key) || empty($key) || !$this->common->validate_key($key)){
			$data['error_flg']= true;
		}
		else{
			$data['keyInfo'] = $this->common->validate_key($key);
			$data['error_flg'] = false;
		}
		if($this->form_validation->run('resetpassword'))
		{ 
			$secretKey=$this->input->post('secretKey');
			
			$new_password=$this->input->post('reset_pass');
			
			$passData=array('secret_key'=>$secretKey,'new_password'=>$new_password);

			if(!$this->common->resetpassword($passData)){
				$data['save_error'] = true;
			}else{
				$data['save_success'] = true;
			}
		}
		  //redirect('webadmin/dashboard/');
		$this->load->view('reset_password',$data);
	}
	
} 