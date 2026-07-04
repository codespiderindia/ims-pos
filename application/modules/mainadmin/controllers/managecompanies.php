<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managecompanies extends CI_Controller {

	public function __construct()
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			global $uInfo;
			$this->load->library('email');
			$uInfo=$this->session->userdata('mainadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('mainadmin/login');
			}
			$this->load->model('managecompanies_model');
			
			
		}
	public function index()
	{
		$data['title'] = 'Company | Inventory';
		$data['heading'] = 'View Company';
		$data['vendors']= $this->managecompanies_model->getAllCompany();
		$this->load->view('manageCompnies/viewCompanies',$data);
	}
	
	// Add company Account
	public function addCompanies(){
		global $uInfo;
	
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){	
		
    		if ($this->form_validation->run('addCompany') == TRUE){

			//$user_ID = $uInfo['user_ID'];

    		$config['upload_path']   = './uploads/company_image/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	     = '10000';
			$config['max_width']     = '102400';
			$config['max_height']    = '76800';
			$config['encrypt_name']  = TRUE;
			$this->load->library('upload', $config);

    		$company_image='';
			if ($this->upload->do_upload('company_image')) {
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => './uploads/company_image/'.$upload_data['file_name'], 
							'new_image' => './uploads/company_image/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$company_image = $upload_data['file_name'];
			}

			$data = array(
    			'comp_name'     =>  $this->input->post('comp_name'),
				'comp_address'  =>  $this->input->post('comp_address'),
				'comp_username' =>  $this->input->post('comp_username'),
				'comp_email'    => $this->input->post('comp_email'),
				'comp_password' =>  $this->input->post('password'),	
				'comp_image'    => $company_image,		
				'comp_status'   =>  1,
				'comp_created'  =>  date('Y-m-d')
    			);
		
			$this->managecompanies_model->addCompany($data);
			$last_inserted_id = $this->db->insert_id();
			
			$data_for_user_table = array(
			'user_full_name' => $this->input->post('comp_name'),
			'user_email' => $this->input->post('comp_email'),
			'comp_password' => $this->input->post('password'),
			'user_password' => sha1($this->input->post('password')),
			'user_name' => $this->input->post('comp_username'),
			'user_role'=> 1,
			'user_level'=> 1,
			'location'=> 0,
			'department_id'=> 0,
			'store_id'=> 0,
			'warehouse_id'=> 0,
			'user_account_status'=> 1,
			'user_created'=>date('Y-m-d'),
			'approved_by_hr'=>1,
			'comp_code'=>$last_inserted_id,
			'comp_status'=>1
			);
			
			$this->db->insert('user_master',$data_for_user_table);
					
    		$this->session->set_flashdata('success_msg','Company Created successfuly ! ! !');
    		redirect(base_url().'mainadmin/managecompanies/viewCompanies');
    	}
		}
		$data['title'] = 'Company | Add';
		$data['heading'] = 'Add Company';
		$this->load->view('manageCompnies/addCompany', $data);
	}
	
	// View Company List
	public function viewCompanies(){
		global $uInfo;
		$data['title'] = 'Company | Inventory';
		$data['heading'] = 'View Company';
		$data['companies']= $this->managecompanies_model->getAllCompany();
		$this->load->view('manageCompnies/viewCompanies',$data);
	}
	
	
	// Update Company Info.
	public function editCompany($comp_id){
	global $uInfo;
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    		
    		$config['upload_path']   = './uploads/company_image/';
			$config['allowed_types'] = 'gif|jpg|png|jpeg';
			$config['max_size']	     = '10000';
			$config['max_width']     = '102400';
			$config['max_height']    = '76800';
			$config['encrypt_name']  = TRUE;
			$this->load->library('upload', $config);

    		if (!$this->upload->do_upload('company_image')) {
				$company_image = $this->input->post('hdn_company_image');
			}
			else{
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => 'uploads/company_image/'.$upload_data['file_name'], 
							'new_image' => 'uploads/company_image/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$company_image = $upload_data['file_name'];
			}
			

			if ($this->form_validation->run('editCompany') == TRUE){
				$UserID = $uInfo['user_ID'];
				$data = array(
	    			'comp_name'     =>  $this->input->post('comp_name'),
					'comp_address'  =>  $this->input->post('comp_address'),
					'comp_image'    => $company_image
					);
				$this->managecompanies_model->updateCompany($comp_id, $data);

				$newpwd = $this->input->post('new_pwd');
				/*$updateData = ['comp_password'=>$this->input->post('new_pwd'),
								'user_password'=>sha1($this->input->post('new_pwd')
							];*/
				$this->managecompanies_model->updateInUser($comp_id, $newpwd);


				$this->session->set_flashdata('success_msg','Company Updated Successfully ! ! !');
	    		redirect(base_url().'mainadmin/managecompanies/viewCompanies');
			}
			
    	}
		$data['compInfo']=$this->managecompanies_model->getCompInfoByID($comp_id);
		
		$data['title'] = 'Company | Edit';
		$data['heading'] = 'Edit company';
		$this->load->view('manageCompnies/editCompany',$data);
	}
	
	// Delete Users Account
	public function deleteVendor($vendorID){
	global $uInfo;
		$this->managevendor_model->deleteVendor($vendorID);
		$this->managevendor_model->oldVendorBankDetails($vendorID);
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Deleted Vendor Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Vendor Deleted Successfully ! ! !');
    	redirect('webadmin/managevendor/viewVendor');
	}
	
	
	// Change User Account Status
	public function changeCompanyStatus(){
	global $uInfo;
		$vendorID=$this->input->get('vendor_id');
		$vendor_status=$this->input->get('company_status');
		$data = array(
    			'comp_status' => $vendor_status,
			
    			);
		$this->managecompanies_model->changeCompanyStatus($vendorID,$data);
		$this->managecompanies_model->changeUserComapnyStatus($vendorID,$data);
		
		
	}
	
	public function onlyAlphaSpace($str) 
	{
		return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}
	
	// update Vendor Password
	public function changePassword(){
		global $uInfo;
       $vendorID = $this->uri->segment(4);
		
		if($this->form_validation->run('updateVendorPassword') == TRUE){
           
            $flag = $this->managevendor_model->changePassword($vendorID);
			//var_dump($flag);exit;
			if($flag) {
                $this->session->set_flashdata('success_msg','Vendor Password changed successfully ! ! !');
				
				//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_vendor_password',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Vendor Password changed');
					}     
                
				$to = $uInfo['user_email'];
				$subject = "Vendor Password changed";
				$txt = "Vendor Password changed successfully ! ! !";
				$headers = "From: ved.infowind@gmail.com" . "\r\n" .
				"CC: somebodyelse@example.com";
 
				mail($to,$subject,$txt,$headers);
				
				
				redirect('webadmin/managevendor/viewVendor');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/managevendor/changePassword/'.$vendorID);
            }
        }
		
		$data['vendors']= $this->managevendor_model->getAllVendor();
		$data['title'] = 'Vendor | Inventory';  
		$data['heading'] = 'Change Vendor Password';
		$this->load->view('manageVendor/updatePassword', $data);
	}
	
	public function checkEmailExist() 
	{
		$email = $this->input->post('email');
		$this->managevendor_model->checkEmailExist($email);
	}
	
	
}

