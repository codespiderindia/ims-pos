<?php if(!defined('BASEPATH')) exit ('No direct script access allowed');
#=============================================================
# created By : Deepak chouhan
# Created Date : 03/062014
# purpose : This controller is create Users of Hotel admin and front admin
# Database name: chms
#=============================================================

class Users extends MX_Controller
{
  function __construct(){
   parent::__construct();
   
	header("cache-Control: no-store, no-cache, must-revalidate");
	header("cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");
	header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
  
   $uInfo=$this->session->userdata('webadmin_session_info');
	if (!isset($uInfo) || empty($uInfo)) 
	{
	redirect('webadmin/login');
	}
	$this->load->model('users_model');
  }

  
  
           /*
			|	Code For -
			|	get Hotel admins 
			|	Start
			*/
  function hoteladminUsers()
  {
   $data['Users']=$this->users_model->getAllhoteladminUsers();
   $this->load->view('manageUsers/view_hoteladmin',$data);
  
  }
  
            /*
			|	Code For -
			|	get Hotel admins 
			|	end
			*/
			
			/*
			|	Code For -
			|	get Front Admins  
			|	Start
			*/
  
  function frontadminUsers()
  {
   $data['frontUsers']=$this->users_model->getAllfrontadminUsers();
   $this->load->view('manageUsers/view_frontusers',$data);
  
  }
            /*
			|	Code For -
			|	get Front Admins  
			|	end
			*/
			
			/*
			|	Code For -
			|	Hotel Admin Change Password  
			|	start
			*/
  
  public function hotelUser_change_password($id){
    //echo $id; exit;
        if($this->form_validation->run('updatehotelPassword') == TRUE){
           
            $flag = $this->users_model->hotelchange_password($id);
            if($flag) {
                $this->session->set_flashdata('success_msg','Password changed successfully ! ! !');
                redirect('webadmin/users/hoteladminUsers');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/users/hoteladminUsers');
            }
        }
       $this->load->view('manageUsers/updatehotelUsersPassword');
       
    }
	
			/*
			|	Code For -
			|	Hotel Admin Change Password  
			|	end
			*/
			
			/*
			|	Code For -
			|	Front Admin User Change Password  
			|	start
			*/
	public function frontUser_change_password($id){
    //echo $id; exit;
        if($this->form_validation->run('updatefrontPassword') == TRUE){
           
            $flag = $this->users_model->frontchange_password($id);
            if($flag) {
                $this->session->set_flashdata('success_msg','Password changed successfully ! ! !');
                redirect('webadmin/users/frontadminUsers');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/users/frontadminUsers');
            }
        }
       $this->load->view('manageUsers/updatefrontUsersPassword');
       
    }
	
			/*
			|	Code For -
			|	Front Admin User Change Password  
			|	end
			*/
}
?>