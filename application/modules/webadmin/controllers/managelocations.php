<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managelocations extends CI_Controller {
	
public function __construct() 
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			global $uInfo;
			$uInfo=$this->session->userdata('webadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('managelocations_model');
		}
	public function index()
	{
		$data['locations']= $this->managelocations_model->getLocations();
		$data['title'] = 'Location | Inventory';
		$this->load->view('manageLocation/viewlocations',$data);
	}
	
	// Add Location
	public function addlocation(){
		global $uInfo;
		if ($this->form_validation->run('addLocation') == TRUE){
    		$data = array(
    			'location_name' => $this->input->post('location_name'),
    			'country_id'    => $this->input->post('countryid'),
				'state_id'      => $this->input->post('stateid'),
				'city_id'       => $this->input->post('cityid'),
				'address'       => $this->input->post('address'),
				'location_status'=>1,
				'comp_code' =>$uInfo['comp_code'],
				'last_updated' => date('Y-m-d h:i:s')
    			);
				//print_r($data);exit;
    		$this->managelocations_model->addLocation($data);
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'locations','LOCATION',date("Y-m-d h:i:s"),'Added Location');
					}
			
    		$this->session->set_flashdata('success_msg','Location added successfuly ! ! !');
    		redirect(base_url().'webadmin/managelocations/viewLocations');
    	}
		//var_dump($this->input->post());
		$data['title'] = 'Location | Inventory';
		$this->load->view('manageLocation/addLocation', $data);
	
	}
	
	// View Location List
	public function viewLocations(){
	global $uInfo;
		$data['locations']= $this->managelocations_model->getLocations($uInfo['comp_code']);
		$data['title'] = 'Location | Inventory';
		$this->load->view('manageLocation/viewLocations',$data);
	}
	
	// View Location country state city Info
	public function viewLocationsInfoById(){
		$data['locations_info']= $this->managelocations_model->getLocationInfoByID();
		$data['title'] = 'Location | Inventory';
		$this->load->view('manageLocation/viewLocations',$data);
	}
	
	// Update Location Info.
	public function editLocation($LocationID){
		global $uInfo;
			
		if ($this->form_validation->run('updateLocation') == TRUE){
		
    		$data = array(
    			'location_name' => $this->input->post('location_name'),
    			'country_id' 	=> $this->input->post('countryid'),
				'state_id' 		=> $this->input->post('stateid'),
				'city_id' 		=> $this->input->post('cityid'),
				'address'		=> $this->input->post('address'),
				'last_updated' 	=> date("Y-m-d h:i:s")
    			);
    		$this->managelocations_model->updateLocation($LocationID, $data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$LocationID,'locations','LOCATION',date("Y-m-d h:i:s"),'Updated Location');
					}
			
    		$this->session->set_flashdata('success_msg','Location Information Updated Successfully ! ! !');
    		redirect('webadmin/managelocations/viewLocations');
    	}
		$data['locationInfo']=$this->managelocations_model->getLocationInfoByID($LocationID);
		$data['title'] = 'Location | Inventory';
		$this->load->view('manageLocation/editLocation',$data);
	}
	
	// Delete Location
	public function deleteLocation($LocationID){
	$res = $this->checkAssignLocation($LocationID);
	if($res) {
		$this->session->set_flashdata('error_msg','Location can\'t delete because its assign to store ! ! !');
    	redirect('webadmin/managelocations/viewLocations');
	}
		 $this->managelocations_model->deleteLocation($LocationID);
		 //Entry for event logs
		 if($this->db->affected_rows()==true)
		{
		event_log('delete',$uInfo['user_ID'],$LocationID,'locations','LOCATION',date("Y-m-d h:i:s"),'Deleted Location');
		$this->session->set_flashdata('success_msg','Location Deleted Successfully ! ! !');
    	redirect('webadmin/managelocations/viewLocations');
	}
	}
	
	function checkAssignLocation($locationID)
	{
	  
	    $query = $this->db->get_where('user_master', array('location' => $locationID));
		if($query->num_rows() > 0)
			return true;
		else
			return FALSE;
	}
	
	
	
	
	// Change Location Status
	 function changeStatus(){
		global $uInfo;
		$LocationID=$this->input->get('id');
		$status=$this->input->get('status');
		$data = array(
    			'location_status' => $status,
    			);
		$this->managelocations_model->changeStatus($LocationID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_status',$uInfo['user_ID'],$LocationID,'locations','LOCATION',date("Y-m-d h:i:s"),'Location Status Changed');
					}
	}


	// Add Other Country
	 function otherCountry(){
		global $uInfo;
		if ($this->form_validation->run('otherCountry') == TRUE){
    		$country_name = ucwords($this->input->post('name'));
    		$sortname	= $this->input->post('sortname');
    		$data = array(
    			'sortname' => $sortname,
				'name' 	   => $country_name,
    			);
				//print_r($data);exit;
    		$res = $this->managelocations_model->addOtherCountry($data,$country_name,$sortname);
			
			if($res!="Already Exist"){
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'locations','LOCATION',date("Y-m-d h:i:s"),'Added Other Country');
					}
	  		$this->session->set_flashdata('success_msg','Other Country added successfuly ! ! !');
    		redirect(base_url().'webadmin/managelocations/viewLocations');
    		}
    		else{
				$this->session->set_flashdata('error_msg','Already Exist ! ! !');
				redirect(base_url().'webadmin/managelocations/otherCountry');
    		}
    	}
		//var_dump($this->input->post());
		$data['title'] = 'Location | Inventory';
		$data['heading'] = 'Add Other Country';
		$this->load->view('manageLocation/otherCountry', $data);
	
	}

	// callback function
	 function customAlpha($str) 
	{
	    if ( !preg_match('/^[a-z .,\-]+$/i',$str) )
	    {
	        // custom error message
			$this->form_validation->set_message('customAlpha', 'Only Allow Alphabates and space');
	        return false;
	    }
	    else {
			return TRUE;
		}
	}

	// Add Other State
	 function otherState(){
		global $uInfo;
		if ($this->form_validation->run('otherState') == TRUE){
    		$state_name = ucwords($this->input->post('state_name'));
    		$country_id	= $this->input->post('countryid');
    		$data = array(
    			'country_id' => $country_id,
				'name' 	   => $state_name,
    			);
				//print_r($data);exit;
    		$res = $this->managelocations_model->addOtherState($data,$state_name,$country_id);
			
			if($res!="Already Exist"){
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'locations','LOCATION',date("Y-m-d h:i:s"),'Added Other State');
					}
			$this->session->set_flashdata('success_msg','Other State added successfuly ! ! !');
    		redirect(base_url().'webadmin/managelocations/viewLocations');
    		}
    		else{
				$this->session->set_flashdata('error_msg','Already Exist ! ! !');
				redirect(base_url().'webadmin/managelocations/otherState');
    		}
    	}
		//var_dump($this->input->post());
		$data['title'] = 'Location | Inventory';
		$data['heading'] = 'Add Other State';
		$this->load->view('manageLocation/otherState', $data);
	
	}

	// Add Other City
	 function otherCity(){
		global $uInfo;
		if ($this->form_validation->run('otherCity') == TRUE){
    		$city_name = ucwords($this->input->post('city_name'));
    		$state_id	= $this->input->post('stateid');
    		$data = array(
    			'state_id' => $state_id,
				'name' 	   => $city_name,
    			);
				//print_r($data);exit;
    		$res = $this->managelocations_model->addOtherCity($data,$city_name,$state_id);
			
			if($res!="Already Exist"){
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'locations','LOCATION',date("Y-m-d h:i:s"),'Added Other City');
					}
			
    		$this->session->set_flashdata('success_msg','Other City added successfuly ! ! !');
    		redirect(base_url().'webadmin/managelocations/viewLocations');
    		}
    		else{
				$this->session->set_flashdata('error_msg','Already Exist ! ! !');
				redirect(base_url().'webadmin/managelocations/otherCity');
    		}
    	}
		//var_dump($this->input->post());
		$data['title'] = 'Location | Inventory';
		$data['heading'] = 'Add Other City';
		$this->load->view('manageLocation/otherCity', $data);
	
	}
	

	
	}