<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
#=============================================================
#created By : Vedgupt Saraf
# Created Date : 24/08/2016
# purpose : This controller is create for Manage change password
# Database name: in_management
#=============================================================

class Profilesetting extends MX_Controller
{
  function __construct(){
   parent::__construct();
   
	header("cache-Control: no-store, no-cache, must-revalidate");
	header("cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
	
   global $uInfo;
   $uInfo=$this->session->userdata('webadmin_session_info');
	if (!isset($uInfo) || empty($uInfo)) 
	{
	redirect('webadmin/login');
	}
	$this->load->model('profilesetting_model');
	
  }

  public function index()
	{
		redirect('webadmin/dashboard');
	}
	
  public function change_password(){
		global $uInfo;
        if($this->form_validation->run('updatePassword') == TRUE){
           
            $flag = $this->profilesetting_model->change_password();
			if($flag) {
                $this->session->set_flashdata('success_msg','Password changed successfully ! ! !');
				
				//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_password',$uInfo['user_ID'],$uInfo['user_ID'],'user_master','Profilesetting',date("Y-m-d h:i:s"),'Password changed');
					}     
                
				$to = $uInfo['user_email'];
				$subject = "Password changed";
				$txt = "Password changed successfully ! ! !";
				$headers = "From: ved.infowind@gmail.com" . "\r\n" .
				"CC: somebodyelse@example.com";
 
				mail($to,$subject,$txt,$headers);
				
				redirect('webadmin/dashboard');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/profilesetting/change_password');
            }
        }
	   $data['title'] = 'Change Password | Inventory';
       $this->load->view('updatePassword', $data);
       
    }
	
	
	
	public function editFirm(){
		
	global $uInfo;
		//if($this->input->post()){
			if ($this->form_validation->run('updateFirm') == TRUE){
    		$data = array(
    			'firm_name' => $this->input->post('firm_name'),
    			'firm_logo' => $this->input->post('firm_logo'),
				'firm_address' => $this->input->post('firm_address'),
    			'lastupdated' => date('Y-m-d'),
				'updated_by' => $uInfo['user_ID'],
    			);
    		$this->profilesetting_model->updateProfile($data);
			
			//Entry for event logs
				/*	if($this->db->affected_rows()==true)
					{
						event_log('update_profile',$uInfo['user_ID'],$uInfo['user_ID'],'user_master','Profilesetting',date("Y-m-d h:i:s"),'Profile Updated');
					}  
			*/
    		$this->session->set_flashdata('success_msg','Profile Updated Successfully ! ! !');
    		redirect('webadmin/dashboard');
    	}
		//}
		$data['userInfo']=$this->profilesetting_model->getUser();
	   //print_r($data['userInfo']);
		$data['title'] = 'Edit Profile | Inventory';
		$this->load->view('editfirm',$data);
	}
	
	public function editProfile(){
	global $uInfo;	
		//if($this->input->post()){
			if ($this->form_validation->run('updateProfile') == TRUE){
    		$data = array(
    			'user_full_name' => $this->input->post('userfullName'),
    			'user_email' => $this->input->post('user_email'),
				'user_name' => $this->input->post('user_name'),
    			'user_account_status' => $this->input->post('status'),
    			);
    		$this->profilesetting_model->updateProfile($data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update_profile',$uInfo['user_ID'],$uInfo['user_ID'],'user_master','Profilesetting',date("Y-m-d h:i:s"),'Profile Updated');
					}  
			
    		$this->session->set_flashdata('success_msg','Profile Updated Successfully ! ! !');
    		redirect('webadmin/dashboard');
    	}
		//}
		$data['userInfo']=$this->profilesetting_model->getUser();
	   //print_r($data['userInfo']);
		$data['title'] = 'Edit Profile | Inventory';
		$this->load->view('editprofile',$data);
	}
	

}
?>