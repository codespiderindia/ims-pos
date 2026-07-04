<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageAttributes extends CI_Controller {

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
			$this->load->model('manageattributes_model');
		}

	public function index()
	{
		$data['tax']= $this->manageattributes_model->getAllAttributes();
		$data['title'] = 'Attribute | Inventory';
		$this->load->view('manageAttributes/viewAttributes',$data);
	}
	
	// Add Users Account
	public function addAttributes(){
		global $uInfo;
		
		$compCode = $uInfo['comp_code'];
		$this->form_validation->set_message('is_unique',"This %s is already in use.");
		if ($this->form_validation->run('addAttributes') == TRUE){ 
    		$data = array(
    			'attribute_name' => $this->input->post('attribute_name'),
    			'comp_code'=>$compCode,
				'created_by' => $uInfo['user_role'],
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s"),
    			);

			$this->manageattributes_model->addAttributes($data);
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'attributes','ATTRIBUTES',date("Y-m-d h:i:s"),'Added Attribute Successfully');
			}
			
    		$this->session->set_flashdata('success_msg','Attributes Created successfuly ! ! !');
    		redirect(base_url().'webadmin/manageattributes/viewAttributes'); 
    	}
		$data['title'] = 'Attribute | Inventory';
		$this->load->view('manageAttributes/addAttributes', $data);
	}
	
	// View Users List
	public function viewAttributes(){
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$data['attributes']= $this->manageattributes_model->getAllAttributes($compCode);
		$data['title'] = 'Attribute | Inventory';
		$this->load->view('manageAttributes/viewAttributes',$data);
	}
	
	// Update Users Info.
	public function editAttributes($attributesID){
	global $uInfo;
	$compCode = $uInfo['comp_code'];
		if ($this->form_validation->run('editAttributes') == TRUE){
    		$post =$this->input->post();
			$attribute_name_val = $post['attribute_name'];
			$hidden_attribute_name_val = $post['hidden_attribute_name'];
			if(strcmp($attribute_name_val,$hidden_attribute_name_val)==0)
			{
				$attribute_name = $hidden_attribute_name_val;
			}
			else
			{
				$attribute_name = $attribute_name_val;
			}
			
			$data = array(
    			'attribute_name' => $attribute_name,
				'modify_date' => date("Y-m-d h:i:s"),
    			);
    		$this->manageattributes_model->updateAttributes($attributesID, $data);
			
			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('update',$uInfo['user_ID'],$attributesID,'attributes','ATTRIBUTES',date("Y-m-d h:i:s"),'Updated Attributes Successfully');
			}
			
    		$this->session->set_flashdata('success_msg','Attributes Updated Successfully ! ! !');
    		redirect('webadmin/manageattributes/viewAttributes');
    	}
		$data['attributesInfo']=$this->manageattributes_model->getAttributesInfoByID($attributesID);
		$data['title'] = 'Attribute | Inventory';
		$this->load->view('manageAttributes/editAttributes',$data);
	}
	
	// Delete Users Account
	public function deleteAttributes($attributesID){
	global $uInfo;
		$this->manageattributes_model->deleteAttributes($attributesID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$attributesID,'attributes','ATTRIBUTES',date("Y-m-d h:i:s"),'Deleted attributes Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Attributes Deleted Successfully ! ! !');
    	redirect('webadmin/manageattributes/viewAttributes');
	}
	
	
	// Change User Account Status
	public function changeAttributesStatus(){
	global $uInfo;
		$attributesID=$this->input->get('attributes_id');
		$attributes_status=$this->input->get('attributes_status');
		$data = array(
    			'attribute_status' => $attributes_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->manageattributes_model->changeAttributesStatus($attributesID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_status',$uInfo['user_ID'],$attributesID,'attributes','ATTRIBUTES',date("Y-m-d h:i:s"),'Attribute Status Changed Successfully');
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

	/* Check Attribute Name For Add Attribute Name */
	public function attributeName_check($str) {
		global $uInfo;
		$result = $this->manageattributes_model->checkAttributeName($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('attributeName_check', 'Already Attribute Name Created.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}

	/* Check Attribute Name For Edit Attribute Name */
	public function checkAttributeNameOnEditCase($str) {
		global $uInfo;
		$attributeId = $this->uri->segment(4);
		$checkCurrent = $this->manageattributes_model->checkAttributeNameOnEditCase($str,$attributeId,$uInfo['comp_code']);
		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkAttributeNameOnEditCase', 'Already Attribute Name Used.');
			return FALSE;
		} else {
			return TRUE;
		}
	}


	/*Get attributes value and its view page*/
	public function attributeValues($attributesID)
	{
		$data['attribute_values']= $this->manageattributes_model->getAllAttributeValues($attributesID);
		$data['title'] = 'Attribute Values | Inventory';
		$this->load->view('manageAttributes/viewAttributeValues',$data);
	}

	// Delete Attribute value
	public function deleteAttributeValue($attributesID, $attributesValueID){
	global $uInfo;
		$this->manageattributes_model->deleteAttributeValue($attributesValueID);
		
		//Entry for event logs
		if($this->db->affected_rows()==true)
		{
			event_log('delete',$uInfo['user_ID'],$attributesValueID,'attribute_value','ATTRIBUTE VALUES',date("Y-m-d h:i:s"),'Deleted attribute Value Successfully');
		}
		
    	$this->session->set_flashdata('success_msg','Attribute Value Deleted Successfully ! ! !');
    	redirect('webadmin/manageattributes/attributeValues/'.$attributesID);
	}
	
}

