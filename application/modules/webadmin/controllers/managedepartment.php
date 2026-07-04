<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageDepartment extends CI_Controller {

	public function __construct()
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			global $uInfo;
			$this->load->library('email');
			$uInfo=$this->session->userdata('webadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('managedepartment_model');
			
			
		}
	public function index()
	{
		$data['user_accounts']= $this->managedepartment->getAllAccount();
		$data['title'] = 'Department | Inventory';
		$this->load->view('manageDepartment/viewDepartment',$data);
	}
	
	// Add Users Account
	public function addDepartment(){
		global $uInfo;
		$this->form_validation->set_message('is_unique',"This %s is already in use.");
		if ($this->form_validation->run('addDepartment') == TRUE){
			
			$weekly_off_val = $this->input->post('weekly_off');
			if(isset($weekly_off_val) && !empty($weekly_off_val)){
				$weekly_off = implode(",",$this->input->post('weekly_off'));
			}
			else{
				$weekly_off = "none";
			}
			$data = array(
    			'department_name' => $this->input->post('department_name'),
				'weekly_off' => $weekly_off,
				'user_ID' => $uInfo['user_ID'],
				'user_level' => $uInfo['user_level'],
				'department_status' =>  '1',
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s"),
				'comp_code' =>$uInfo['comp_code']
    			);
			$this->managedepartment_model->addDepartment($data);
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'department','DEPARTMENT',date("Y-m-d h:i:s"),'Added Department');
					}
			
    		$this->session->set_flashdata('success_msg','Add DEPARTMENT successfuly ! ! !');
    		redirect(base_url().'webadmin/managedepartment/viewDepartment');
    	}
		$data['title'] = 'Department | Inventory';
		$this->load->view('manageDepartment/addDepartment', $data);
	}
	
	// View Users List
	public function viewDepartment(){
		global $uInfo;
		
		$data['department']= $this->managedepartment_model->getAllDepartment($uInfo['comp_code']);
		$data['title'] = 'Department | Inventory';
		$this->load->view('manageDepartment/viewDepartment',$data);
	}
	
	// Update Users Info.
	public function editDepartment($departmentID){
	global $uInfo;
	
			$post =$this->input->post();
			$department_name_val = $post['department_name'];
			$hidden_department_name_val = $post['hidden_department_name'];
			
			$original_value = $this->input->post('hidden_department_name');
			if($department_name_val != $original_value) {
			   $is_unique =  '|is_unique[department.department_name]';
			} else {
			   $is_unique =  '';
			}
			

			$this->form_validation->set_rules('department_name', 'Department Name', 'required|callback_lettersOnly_check|callback_checkDepartmentOnEditCase');
			if ($this->form_validation->run() == TRUE){
	
    		$weekly_off_val = $this->input->post('weekly_off');
			if(isset($weekly_off_val) && !empty($weekly_off_val)){
				$weekly_off = implode(",",$this->input->post('weekly_off'));
			}
			else{
				$weekly_off = "none";
			} 
			$data = array(
    			'department_name' => $department_name_val,
				'weekly_off' => $weekly_off,
				'user_ID' => $uInfo['user_ID'],
				'user_level' => $uInfo['user_level'],
				'modify_date' => date("Y-m-d h:i:s")
    			);
			
    		$this->managedepartment_model->updateDepartment($departmentID, $data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$departmentID,'department','DEPARTMENT',date("Y-m-d h:i:s"),'Updated DEPARTMENT');
					}
			
    		$this->session->set_flashdata('success_msg','Department Updated Successfully ! ! !');
    		redirect('webadmin/managedepartment/viewDepartment');
    	}
		$data['departmentInfo']=$this->managedepartment_model->getDepartmentInfoByID($departmentID);
		$data['title'] = 'Department | Inventory';
		$this->load->view('manageDepartment/editDepartment',$data);
	}
	
	// Delete Department
	public function deleteDepartment($departmentID){
	global $uInfo;
	  $res =  $this->checkAssignDepartment($departmentID);
	if($res) {
	$this->session->set_flashdata('error_msg','Can\'t delete becuase its assigned to user.');
    	redirect('webadmin/managedepartment/viewDepartment');
	}
		$this->managedepartment_model->deleteDepartment($departmentID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$departmentID,'departmentID','DEPARTMENT',date("Y-m-d h:i:s"),'Deleted DepartmentID');
					}
		
    	$this->session->set_flashdata('success_msg','DEPARTMENT Deleted Successfully ! ! !');
    	redirect('webadmin/managedepartment/viewDepartment');
	}
	
	function checkAssignDepartment($departmentID)
	{ 
	$query = $this->db->get_where('user_master', array('department_id' => $departmentID));
		if($query->num_rows() > 0)
			return true;
		else
			return FALSE;
	}
	// Change Department Status
	public function changeStatus(){
	global $uInfo;
		$departmentID=$this->input->get('department_id');
		$status=$this->input->get('status');
		$data = array(
    			'department_status' => $status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->managedepartment_model->changeDepartentStatus($departmentID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_status',$uInfo['user_ID'],$departmentID,'department','DEPARTMENT',date("Y-m-d h:i:s"),'Department Status Changed');
					}
	}
	
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters only please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function checkDepartmentName($str) {
		global $uInfo;
		$result = $this->managedepartment_model->checkDepartmentName($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('checkDepartmentName', 'Department Name Already Used.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}

	public function checkDepartmentOnEditCase($str) {
		global $uInfo;
		$departmentId = $this->uri->segment(4);
		$checkCurrent = $this->managedepartment_model->checkDepartmentOnEditCase($str,$departmentId,$uInfo['comp_code']);
		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkDepartmentOnEditCase', 'This Department already exits.');
			//$this->form_validation->set_message('checkDepartmentOnEditCase', 'The Department Name field must contain a unique value.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

