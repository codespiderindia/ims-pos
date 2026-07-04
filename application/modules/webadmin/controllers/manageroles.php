<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageRoles extends CI_Controller {
	public function __construct()
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			global $uInfo;
			$uInfo = $this->session->userdata('webadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('managerole_model');
		}
	public function index()
	{
		$data['roles']  = $this->managerole_model->getAllRoles();
		$data['title']  = 'Role | Inventory';
		$this->load->view('manageRoles/viewRoles',$data);
	}
	
	// Add Roles
	public function addRoles(){
		
		global $uInfo;

		if($uInfo['user_role']=='1' && $this->input->post('hr_approval') && ($this->input->post('role_name') == 'hr')) {
			$hrAprove = 1;
		} else if($uInfo['user_role']=='1' && $this->input->post('hr_approval')) {
			$hrAprove = $this->input->post('hr_approval');
		} else { 
			$hrAprove = 0;
		}

		if ($this->form_validation->run('addRoles') == TRUE){
    		$data = array(
    			'role_name' => $this->input->post('role_name'),
				'created_by' => $uInfo['user_ID'],
				'created_by_name' => $uInfo['user_full_name'],
				'created_date' => date('Y-m-d'),								
				'user_level' => $this->input->post('user_level'),
				'hr_approval_for_special_role' => $hrAprove,
				'comp_code' =>$uInfo['comp_code']
				);
    		$this->managerole_model->addRole($data);
			
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'role','ROLE',date("Y-m-d h:i:s"),'Added Role');
					}
			
    		$this->session->set_flashdata('success_msg','Role Created successfuly ! ! !');
    		redirect(base_url().'webadmin/manageroles/viewRoles');
    	}
		$data['title'] = 'Role | Inventory';
		$this->load->view('manageRoles/addRoles', $data);
	}
	
	// View Roles List
	public function viewRoles(){
		$data['roles']= $this->managerole_model->getAllRoles();
		$data['title'] = 'Role | Inventory';
		$this->load->view('manageRoles/viewRoles',$data);
	}
	public function deleteRoles($role_code){
		global $uInfo;
		$role_code = base64_decode($role_code);
		$res = $this->checkUserAssign($role_code);
		
		if($res) {
			$this->session->set_flashdata('error_msg','Role Can\'t Deleted because its assign to users!!!');
		redirect('webadmin/manageroles/viewRoles');
		}
		
		$this->managerole_model->deleteRoles($role_code);

		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('delete',$uInfo['user_ID'],$offer_id,'Role','ROLE',date("Y-m-d h:i:s"),'Delete Role successfully.');
		}
		// End Entry for event logs
		
    	$this->session->set_flashdata('success_msg','Role Deleted Successfully!!!');
		redirect('webadmin/manageroles/viewRoles');
	}
	
	function checkUserAssign($role){
	 $query = $this->db->get_where('user_master', array('user_role' => $role));
		if($query->num_rows() > 0)
			return true;
		else
			return FALSE;
	}
	
	// Update Roles Info.
	public function editRoles($roleID){
		global $uInfo;
		
		if($uInfo['user_role']=='1' && $this->input->post('hr_approval')) {
			$hrAprove = $this->input->post('hr_approval');
		} else { 
			$hrAprove = 0;
		}
		

		if ($this->form_validation->run('updateRoles') == TRUE){
    		
			$data = array(
    			'role_name' => $this->input->post('role_name'),
				'created_by' => $uInfo['user_ID'],
				'created_by_name' => $uInfo['user_full_name'],
				'user_level' => $this->input->post('user_level'),
				'hr_approval_for_special_role' => $hrAprove
				);
				
    		$this->managerole_model->updateRoles($roleID, $data);
			
			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('update',$uInfo['user_ID'],$roleID,'role','ROLE',date("Y-m-d h:i:s"),'Updated Role');
			}
			
    		$this->session->set_flashdata('success_msg','Role Updated Successfully ! ! !');
    		redirect('webadmin/manageroles/viewRoles');
    	}
		$data['roleInfo']=$this->managerole_model->getRoleInfoByID($roleID);
		$data['title'] = 'Role | Inventory';
		$this->load->view('manageRoles/editRoles',$data);
	}
	
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters only please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function checkRoleName($str) {
		global $uInfo;
		$result = $this->managerole_model->checkRoleName($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('checkRoleName', 'Already Role Name Created1.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}

	public function checkRoleNameOnEditCase($str) {
		global $uInfo;
		$roleId = $this->uri->segment(4);
		$checkCurrent = $this->managerole_model->checkRoleNameOnEditCase($str,$roleId,$uInfo['comp_code']);
		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkRoleNameOnEditCase', 'This Role already exits.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
}
?>
