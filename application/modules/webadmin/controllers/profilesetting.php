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

	$file_name = '';
		//if($this->input->post()){
			if ($this->form_validation->run('updateFirm') == TRUE){

				if(isset($_FILES['firm_logo']['name']) && !empty($_FILES['firm_logo']['name'])){
					
					$file_name = $_FILES['firm_logo']['name'];
			      	$file_size =$_FILES['firm_logo']['size'];
			      	$file_tmp =$_FILES['firm_logo']['tmp_name'];
			      	$file_type=$_FILES['firm_logo']['type'];

			      	$file_path = "./uploads/store_logo/";
			      	move_uploaded_file($file_tmp, $file_path.$file_name);

		    		$data = array(
		    			'firm_name' => $this->input->post('firm_name'),
		    			'firm_logo' => $file_name,
						'firm_address' => $this->input->post('firm_address'),
						'firm_teen_num' => $this->input->post("firm_teen_num"),
		    			'lastupdate' => date('Y-m-d'),
						'updated_by' => $uInfo['user_ID'],
						'comp_code' => $uInfo['comp_code']
		    			);
		    		// firm count
		    		$this->db->select('*');
					$this->db->from('firm_details');
					$this->db->where('updated_by', $uInfo['user_ID']);
					$query = $this->db->get();
					if($query->num_rows()>0){
						$this->profilesetting_model->updateFirm($data);
					}else{
						$this->profilesetting_model->addFirm($data);
					}
				}else{

					$image_name = $_POST['image_name'];

					$data = array(
		    			'firm_name' => $this->input->post('firm_name'),
		    			'firm_logo' => $image_name,
						'firm_address' => $this->input->post('firm_address'),
						'firm_teen_num' => $this->input->post("firm_teen_num"),
		    			'lastupdate' => date('Y-m-d'),
						'updated_by' => $uInfo['user_ID'],
						'comp_code' => $uInfo['comp_code']
		    			);
		    		// firm count
		    		$this->db->select('*');
					$this->db->from('firm_details');
					$this->db->where('updated_by', $uInfo['user_ID']);
					$query = $this->db->get();
					if($query->num_rows()>0){
						$this->profilesetting_model->updateFirm($data);
					}else{
						$this->profilesetting_model->addFirm($data);
					}
				}
							
			
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
		$data['userInfo']=$this->profilesetting_model->getFirm();
	   //print_r($data['userInfo']);
		$data['title'] = 'Edit Firm | Inventory';
		$this->load->view('editfirm',$data);
	}
	
	public function editProfile(){
	global $uInfo;	
		//if($this->input->post()){
			if ($this->form_validation->run('updateProfile') == TRUE){
				
				$countryId = $this->input->post('countryid');
				$stateId = $this->input->post('stateid');
				$gstNumber = $this->input->post('gst_number');
			
    		$data = array(
    			'user_full_name' => $this->input->post('userfullName'),
    			'user_email' => $this->input->post('user_email'),
				'user_name' => $this->input->post('user_name'),
    			'user_account_status' => $this->input->post('status'),
    			);
    		$this->profilesetting_model->updateProfile($data);

    		for($i=0; $i<count($countryId); $i++) {
					$gstDetail = ['user_id'=>$uInfo['user_ID'],
							'gst_number'=>(isset($gstNumber[$i])) ? $gstNumber[$i] : 0,
							'country_id'=>(isset($countryId[$i])) ? $countryId[$i] : 0,
							'state_id'=>(isset($stateId[$i])) ? $stateId[$i] : 0,
							'created_date'=>date('Y-m-d H:i:s'),
							'comp_code'=>$uInfo['comp_code']];
				$insertID = commonInsert('gst_number',$gstDetail);
			}

			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update_profile',$uInfo['user_ID'],$uInfo['user_ID'],'user_master','Profilesetting',date("Y-m-d h:i:s"),'Profile Updated');
					}  
			
    		$this->session->set_flashdata('success_msg','Profile Updated Successfully ! ! !');
    		redirect('webadmin/dashboard');
    	}
		//}
		$data['gstNumbers']=getSku('gst_number',['user_id'=>$uInfo['user_ID']]);
		$data['userInfo']=$this->profilesetting_model->getUser();
	   //print_r($data['userInfo']);
		$data['title'] = 'Edit Profile | Inventory';
		$this->load->view('editprofile',$data);
	}

	public function checkStateIdExist() {
		global $uInfo;
		$userId = $uInfo['user_ID'];

		$stateId = $this->input->get('stateId');

		$checkExist = getSku('gst_number',['user_id'=>$userId, 'state_id'=>$stateId, 'comp_code'=>$uInfo['comp_code']]);
		if(!empty($checkExist)) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function updateGstNumber() {
		global $uInfo;

		$id=$this->input->get('id');
		$gstNumber=$this->input->get('gstInput');

		$result = updateData('gst_number',['gst_number'=>$gstNumber],['gst_number_id'=>$id, 'comp_code'=>$uInfo['comp_code']]);
		return $result;
	}


	public function editInvoiceSetting() {
		global $uInfo;	

		if ($this->form_validation->run('updateInvoiceSetting') == TRUE) {

			$data = array('invoice_header'=>$this->input->post('invoice_header'),
						  'invoice_footer'=>$this->input->post('invoice_footer'));

		  	$this->db->where('user_ID',$uInfo['user_ID']);
		  	$this->db->update('user_master',$data);

		  	$this->session->set_flashdata('success_msg','Updated Successfully ! ! !');
	    	redirect('webadmin/dashboard');
		} 

		$this->db->select('invoice_header, invoice_footer');
		$this->db->from('user_master');
		$this->db->where('user_ID',$uInfo['user_ID']);
		$query = $this->db->get()->row();

		$data['invoiceDetails'] = $query;
		$data['title'] = 'Edit Invoice Setting | Inventory';
		$this->load->view('editInvoiceSetting',$data);
	}
	
}
?>