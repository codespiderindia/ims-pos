<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managepaymethod extends CI_Controller {
	
	public function __construct()
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			$uInfo=$this->session->userdata('webadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('managepaymethod_model');
		}
	public function index()
	{
		$data['paymethods']= $this->managepaymethod_model->getPaymethods();
		$this->load->view('managePaymethod/viewPaymethods',$data);
	}
	
	// Add Channel
	public function addpaymethod(){
		
		
		if ($this->form_validation->run('addpaymethod') == TRUE){
    		$data = array(
    			'paymethod_name' => $this->input->post('paymethod_name'),
    			'paymethod_shortcode' => $this->input->post('paymethod_shortcode')
    			);
    		$this->managepaymethod_model->addPaymethod($data);
    		$this->session->set_flashdata('success_msg','Paymethod added successfuly ! ! !');
    		redirect(base_url().'webadmin/managepaymethod/viewpaymethods');
    	}
		//var_dump($this->input->post());
		$this->load->view('managePaymethod/addPaymethod');
	
	}
	
	// View Channel List
	public function viewpaymethods(){
		$data['paymethods']= $this->managepaymethod_model->getPaymethods();
		$this->load->view('managePaymethod/viewPaymethods',$data);
	}
	
	// Update Channel Info.
	public function editpaymethod($pmID){
		if ($this->form_validation->run('updatepaymethod') == TRUE){
    		$data = array(
    			'paymethod_name' => $this->input->post('paymethod_name'),
    			'paymethod_shortcode' => $this->input->post('paymethod_shortcode')
    			);
    		$this->managepaymethod_model->updatePaymethod($pmID, $data);
    		$this->session->set_flashdata('success_msg','Paymethod Updated Successfully ! ! !');
    		redirect(base_url().'webadmin/managepaymethod/viewpaymethods');
    	}
		$data['paymethod']=$this->managepaymethod_model->getPaymethodByID($pmID);

		$this->load->view('managePaymethod/editPaymethod',$data);
	}
	
	// Delete Channel
	public function deletepaymethod($pmID){
		$this->managepaymethod_model->deletePaymethod($pmID);
    	$this->session->set_flashdata('success_msg','Paymethod Deleted Successfully ! ! !');
    	redirect(base_url().'webadmin/managepaymethod/viewpaymethods');
	}
	
	// Change Channel Status
	public function changeStatus(){
		$pmID=$this->input->get('paymethod_id');
		$status=$this->input->get('status');
		$data = array(
    			'paymethod_status' => $status,
    			);
		$this->managepaymethod_model->changeStatus($pmID,$data);
	}

	
}

