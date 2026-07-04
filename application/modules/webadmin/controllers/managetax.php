<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageTax extends CI_Controller {

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
			$this->load->model('managetax_model');
			
		}

	public function index()
	{
		$data['tax']= $this->managetax_model->getAllAccount();
		$data['title'] = 'Tax | Inventory';
		$this->load->view('manageTax/viewTax',$data);
	}
	
	// Add Users Account
	public function addTax(){
		global $uInfo;
		$this->form_validation->set_message('is_unique',"This %s is already in use.");
		if ($this->form_validation->run('addTax') == TRUE){
    		$data = array(
    			'user_level' => $uInfo['user_level'],
				'country_id' => $this->input->post('countryid'),
				'state_id' => $this->input->post('stateid'),
				//'city_id' => $this->input->post('cityid'),
				//'zipcode' => $this->input->post('zipcode'),
				'tax_name' => $this->input->post('tax_name'),
				'rate' => $this->input->post('rate'),
				'created_by' => $uInfo['user_role'],
				'create_date' => date("Y-m-d h:i:s"),
				'comp_code' => $uInfo['comp_code'],
				'modify_date' => date("Y-m-d h:i:s"),
    			);

			$this->managetax_model->addTax($data);
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'tax','TAX',date("Y-m-d h:i:s"),'Added Tax Successfully');
					}
			
    		$this->session->set_flashdata('success_msg','Tax Created successfuly ! ! !');
    		redirect(base_url().'webadmin/managetax/viewTax'); 
    	}
		$data['title'] = 'Tax | Inventory';
		$this->load->view('manageTax/addTax', $data);
	}
	
	// View Users List
	public function viewTax(){
		global $uInfo;
		
		$data['tax']= $this->managetax_model->getAllTax($uInfo['comp_code']);
		$data['title'] = 'Tax | Inventory';
		$this->load->view('manageTax/viewTax',$data);
	}
	
	// Update Users Info.
	public function editTax($taxID){
	global $uInfo;
			$post =$this->input->post();
			$tax_name_val = $post['tax_name'];
			$hidden_tax_name_val = $post['hidden_tax_name'];
			
			$original_value = $this->input->post('hidden_tax_name');
			if($tax_name_val != $original_value) {
			   $is_unique =  '|is_unique[tax.tax_name]';
			} else {
			   $is_unique =  '';
			}
		/*$this->form_validation->set_rules('tax_name', 'Tax Name', 'required|callback_lettersOnly_check'.$is_unique);*/
		
		if($this->form_validation->run('editTax') == TRUE){
			
			$data = array(
    			'country_id' => $this->input->post('countryid'),
				'state_id' => $this->input->post('stateid'),
				//'city_id' => $this->input->post('cityid'),
				//'zipcode' => $this->input->post('zipcode'),
				'tax_name' => $tax_name_val,
				'rate' => $this->input->post('rate'),
				'modify_date' => date("Y-m-d h:i:s"),
    			);
				//print_r($data);exit;
    		$this->managetax_model->updateTax($taxID, $data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$taxID,'tax','TAX',date("Y-m-d h:i:s"),'Updated Tax Successfully');
					}
			
    		$this->session->set_flashdata('success_msg','Tax Updated Successfully ! ! !');
    		redirect('webadmin/managetax/viewTax');
    	}
		$data['taxInfo']=$this->managetax_model->getTaxInfoByID($taxID);
		$data['title'] = 'Tax | Inventory';
		$this->load->view('manageTax/editTax',$data);
	}
	
	// Delete Users Account
	public function deleteTax($taxID){
	global $uInfo;
		$this->managetax_model->deleteTax($taxID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$taxID,'tax','TAX',date("Y-m-d h:i:s"),'Deleted Tax Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Tax Deleted Successfully ! ! !');
    	redirect('webadmin/managetax/viewTax');
	}
	
	
	// Change User Account Status
	public function changeTaxStatus(){
		global $uInfo;
		$userID=$this->input->get('acc_id');
		$status=$this->input->get('status');
		$data = array(
    			'tax_status' => $status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->managetax_model->changeStatus($userID,$data);
		
		//Entry for event logs
		if($this->db->affected_rows()==true)
		{
			event_log('change_status',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Tax Status Changed Successfully');
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

	public function checkTaxName($str) {
		global $uInfo;
		$country = $this->input->post('country');
		$state = $this->input->post('state');

		$result = $this->managetax_model->checkTaxName($str,$uInfo['comp_code'],$country,$state);
		if(!empty($result)) {
			$this->form_validation->set_message('checkTaxName', 'Already Tax Name Created.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}


	public function getCessTaxName() {
		$taxname = $this->input->get('taxname');
		$result = $this->managetax_model->checkCessTax($taxname);
		if(!empty($result)) {
			echo '0';
		} else {
			echo '1';
		}

	}
	
}