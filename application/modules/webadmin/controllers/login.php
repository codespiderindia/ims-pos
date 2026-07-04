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
			
			$uInfo=$this->session->userdata('webadmin_session_info');
				//var_dump($uInfo);exit();
				if (isset($uInfo) && !empty($uInfo)) {
				// ensure already signed in 
					if($uInfo['user_role']==1){redirect('webadmin/dashboard');}
					//if($uInfo['userRole']==2){redirect('property');}
					//if($uInfo['userRole']==0){redirect('property');}
					//$this->load->model('common');
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
			

			$today = date('Y-m-d');
			$post_date = $this->input->post('current_date');
			
			//if ($post_date == $today) {
				if(!$err_flg){
				
						$result = $this->common->get_webadmin_login();
						
					//	$result1 = $this->common->get_webadmin_login_by_status();

							if(!$result){
								$this->session->unset_userdata('webadmin_session_info');
								$data['msg'] = '<p>Invalid username and/or password.</p>';
							}
							/*elseif(!$result1){
								$data['msg'] = '<p>You Account is Inactive untill Approval.</p>';
							}*/
							else{
								$uInfo=$this->session->userdata('webadmin_session_info');

								$getCreatedby=$uInfo['created_by'];

								if($getCreatedby != '') {
									//echo 'if'; die;
									
									$checkStatus = $this->common->check_status($uInfo['user_ID']);
									/*echo '<pre>';print_r($checkStatus);
									die;*/
									//echo $checkStatus; die;

									if($checkStatus == 0) {

										$this->session->unset_userdata('webadmin_session_info');
										$data['msg'] = '<p>You Account is Inactive untill Approval.</p>';

									} else {
										event_log('Company_Login',$uInfo['user_ID'],$uInfo['user_role'],'company_login','LOGIN',date("Y-m-d h:i:s"),'Company login successfully.');
								
										if (isset($uInfo) && !empty($uInfo)) {
											
											if($uInfo['user_role']==$uInfo['user_role'] ){redirect('webadmin/dashboard');}
											//if($uInfo['userRole']==2){redirect('property');}
										}
									}
								} else { //echo 'else'; die;
									event_log('Company_Login',$uInfo['user_ID'],$uInfo['user_role'],'company_login','LOGIN',date("Y-m-d h:i:s"),'Company login successfully.');
								
									if (isset($uInfo) && !empty($uInfo)) {
										
										if($uInfo['user_role']==$uInfo['user_role'] ){redirect('webadmin/dashboard');}
										//if($uInfo['userRole']==2){redirect('property');}
									}
								}

								
							}  
						  
				}else{
						$data['msg'] = '<p>You must fill in all of the fields.</p>';
						
				}
			/*}
			else{
				$data['msg'] = '<p>Sorry system date is not match with current date.</p>';
			} */

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

				event_log('Company_forget_password',$uInfo['user_ID'],$uInfo['user_role'],'Company_forget_password','COMPANY',date("Y-m-d h:i:s"),'Company Forget Password successfully.');

				echo '<div style="text-shadow:none; color:#000;background-color:none;"> An Email has been sent on your registered email address, Please check your Inbox for more detail. </div>';
				//echo  $data['success_msg'];
			}else{
				$data['success']=0;
				echo '
<div  style=" text-shadow:none; color:#CE4E4A;background-color:none;"> Sorry, We did not find your email in our Database. Please check & Try Again. </div>
';
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