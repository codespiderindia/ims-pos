<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageOffer extends CI_Controller {

	public function __construct(){	 	
		parent::__construct();
		
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		
		global $uInfo;
		$this->load->library('email');
		$uInfo = $this->session->userdata('webadmin_session_info');
		if (!isset($uInfo) || empty($uInfo)) {
			redirect('webadmin/login');
		}
		$this->load->model('manageoffer_model');
	}
	public function index(){
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$data['getAllOffer'] = $this->manageoffer_model->getAllOffer($compCode);
		
		$data['title'] = 'Offer	| Inventory';
		$data['heading'] = 'Offer List';
		$this->load->view('manageOffer/viewOffer', $data);
	}
	public function addOffer(){
		global $uInfo;
		
		/*if($this->input->post()){
			$percentage_or_fixed = $this->input->post('percentage_or_fixed');
			$offer_discount = $this->input->post('offer_discount');
			if( ($percentage_or_fixed==1) && ($offer_discount <= 0) && ($offer_discount>=100)){
				$this->form_validation->set_message('offer_discount','The %s field must be less than 100' );
				return FALSE;
			}else{
				return TRUE;
			}
		}*/
		if($this->input->post()){
			if($this->input->post('free_product'))
			{
				$free_product = $this->input->post('free_product');
				$date_duration_start = "NULL";
				$date_duration_end = "NULL";
				$start_date_free_product = date("Y-m-d",strtotime($this->input->post('start_date_free_product')));
			}
			else{
				$free_product = "NULL";
				$date_duration_start = date("Y-m-d",strtotime($this->input->post('date_duration_start')));
				$date_duration_end = date("Y-m-d",strtotime($this->input->post('date_duration_end')));
				$start_date_free_product = "NULL";
			}
			$data = array(
							'user_ID'             => $uInfo['user_ID'],
							'user_level'          => $uInfo['user_level'],
							'offer_name'          => $this->input->post('offer_name'),
							'percentage_or_fixed' => $this->input->post('percentage_or_fixed'),
							'offer_discount'      => $this->input->post('offer_discount'),
							'comp_code' => $uInfo['comp_code'],
							'free_product' 		  => $free_product,
							'date_duration_start' => $date_duration_start,
							'date_duration_end'   => $date_duration_end,
							'start_date_free_product' => $start_date_free_product,
							'offer_description'   => $this->input->post('offer_description'),
							'ip_address'          => $this->input->ip_address(),
							'create_date'         => date("Y-m-d h:i:s"),
							'modified_date'       => date("Y-m-d h:i:s")
						 );
			$this->manageoffer_model->offerInsert($data);

			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert', $uInfo['user_ID'], $last_inserted_id, 'offer', 'OFFER', date("Y-m-d h:i:s"), 'Added offer successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Offer Created successfully !!!');
			redirect(base_url().'webadmin/manageoffer/viewOffer');			
		}
		$data['title'] = 'Offer	| Inventory';
		$data['heading'] = 'Add Offer';
		$this->load->view('manageOffer/addOffer', $data);
	}
	public function viewOffer(){
		global $uInfo;
		$data['getAllOffer'] = $this->manageoffer_model->getAllOffer($uInfo['comp_code']);
		
		$data['title'] = 'Offer	| Inventory';
		$data['heading'] = 'Offer List';
		$this->load->view('manageOffer/viewOffer', $data);
	}
	public function editOffer($offer_id){
		global $uInfo;
		$offer_id = base64_decode($offer_id);
		if($this->input->post()){ 
			if($this->input->post('free_product') != 'NULL')
			{ 
				$free_product = $this->input->post('free_product');
				$date_duration_start = "NULL";
				$date_duration_end = "NULL";
				$start_date_free_product = date("Y-m-d",strtotime($this->input->post('start_date_free_product')));
			}
			else{ 
				$free_product = "NULL";
				$date_duration_start = $this->input->post('date_duration_start');
				$date_duration_end = $this->input->post('date_duration_end');
				//$date_duration_start = date("Y-m-d",strtotime($this->input->post('date_duration_start')));
				//$date_duration_end = date("Y-m-d",strtotime($this->input->post('date_duration_start')));
				$start_date_free_product = "NULL";
			}
			$data = array(
							'offer_name'          => $this->input->post('offer_name'),
							'percentage_or_fixed' => $this->input->post('percentage_or_fixed'),
							'offer_discount'      => $this->input->post('offer_discount'),
							'free_product' 		  => $free_product,
							'date_duration_start' => $date_duration_start,
							'date_duration_end'   => $date_duration_end,
							'start_date_free_product' => $start_date_free_product,
							'offer_description'   => $this->input->post('offer_description'),
							'ip_address'          => $this->input->ip_address(),
							'modified_date'       => date("Y-m-d h:i:s")
						 );
			$this->manageoffer_model->updateOffer($data, $offer_id);
			
			// Entry for event logs
			if($this->db->affected_rows()==true){
				event_log('update', $uInfo['user_ID'], $offer_id, 'offer', 'OFFER', date("Y-m-d h:i:s"), 'Update offer successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Offer updated successfully !!!');
			redirect(base_url().'webadmin/manageoffer/viewOffer');			
		}
		
		$data['getIdByOffer'] = $this->manageoffer_model->editOffer($offer_id);
		$data['title'] = 'Offer | Inventory';
		$data['heading'] = 'Edit Offer';
		$this->load->view('manageOffer/editOffer', $data);
	}
	public function deleteOffer($offer_id){
		global $uInfo;
		$offer_id = base64_decode($offer_id);
		$this->manageoffer_model->deleteOffer($offer_id);

		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('delete',$uInfo['user_ID'],$offer_id,'offer','OFFER',date("Y-m-d h:i:s"),'Delete offer successfully.');
		}
		// End Entry for event logs
		
    	$this->session->set_flashdata('success_msg','Offer Deleted Successfully!!!');
		redirect('webadmin/manageoffer/viewOffer');
	}
	public function checkDateFormat($date) {
		if (preg_match("/[0-12]{2}\/[0-31]{2}\/[0-9]{4}/", $date)) {
			if(checkdate(substr($date, 0, 2), substr($date, 3, 2), substr($date, 6, 4))){
				return true;
			}else{
				$this->form_validation->set_message('checkDateFormat', 'Please Enter correct values in mm/dd/yyyy Format.');
				return false;
			}	
		} else {
				//$this->form_validation->set_message('checkDateFormat', 'Please Enter correct values in mm/dd/yyyy Format.');
				return false;
		}
	}
	
	// Change Offer Status
	public function changeOfferStatus(){
		global $uInfo;
		$offerID=$this->input->get('id');
		$status=$this->input->get('status');
		$data = array(
    			'approved_by' => $status,
    			);
		$this->manageoffer_model->changeOfferStatus($offerID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('approved_by',$uInfo['user_ID'],$offerID,'offer','OFFER',date("Y-m-d h:i:s"),'Offer Status Changed');
					}
	}
}