<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageOrders extends CI_Controller {

	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;
			$uInfo=$this->session->userdata('sales_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			
			if (!($this->session->userdata('sales_session_info'))) {
				redirect(base_url().'sales/login');
			}
		}
	
	public function index()
	{
		
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			
			$data['title'] = 'Dashboard | Inventory';
			//$this->load->view('manageorder', $data);	
		$this->load->view('manageOrders/addOrder', $data);
		}
		
	}

	public function addorder(){
		//var_dump($this->input->post());

		//echo "manoj"; exit;

		global $uInfo;

		
			
			$data['title'] = 'Dashboard | Inventory';
			//$this->load->view('manageorder', $data);	
		
		

		//echo "sdfsd";



		//$this->form_validation->set_message('is_unique',"This %s is already in use.");
		$this->form_validation->set_rules('item_bcode', 'item_bcode', 'required');
		if ($this->form_validation->run() == FALSE) {
    
    $data = array(
                'item_bcode' => form_error('item_bcode'),
            );

            echo json_encode($data);
}
		else{

			echo "Success";
    		/*$data = array(
    			'hotel_name' => $this->input->post('hotel_name'),
    			'hotel_address' => $this->input->post('hotel_address'),
				'room_capacity' => $this->input->post('room_capacity'),
    			'hotel_country' => $this->input->post('hotel_country'),
    			'hotel_state' => $this->input->post('hotel_state'),
    			'hotel_city' => $this->input->post('hotel_city'),
    			'hotel_zip' => $this->input->post('hotel_zip'),
    			'hotel_phone' => $this->input->post('hotel_phone'),
    			'hotel_fax' => $this->input->post('hotel_fax'),
    			'hotel_website' => $this->input->post('hotel_website'),
				'hotel_email' => $this->input->post('hotel_email'),
				'admin_full_name' => $this->input->post('admin_full_name'),
				'username' => $this->input->post('username'),
				'password' => sha1($this->input->post('password'))
    			);

    		$this->manageaccount_model->addHotelAccount($data);
    		$this->session->set_flashdata('success_msg','Hotel Account Created successfuly ! ! !');
    		redirect(base_url().'webadmin/manageAccounts/viewHotels');
    	}*/
		
		
	}
	//$this->load->view('manageOrders/addOrder', $data);
}
}

