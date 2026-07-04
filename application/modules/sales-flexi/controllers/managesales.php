<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageSales extends CI_Controller {

	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;

			$this->flexi = new stdClass;
			$this->load->library('flexi_cart');

			$uInfo=$this->session->userdata('sales_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			$this->load->model('managesales_model');
			if (!($this->session->userdata('sales_session_info'))) {
				redirect(base_url().'sales/login');
			}
		}
	
	public function index()
	{
		
		global $uInfo;



		if (isset($uInfo) && !empty($uInfo)) {
			
			$data['title'] = 'Dashboard | Sales';
			// Get required data on cart items, discounts and surcharges to display in the cart.
		$data['cart_items'] = $this->flexi_cart->cart_items(); 
		$data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
		$data['discounts'] = $this->flexi_cart->summary_discount_data();
		$data['surcharges'] = $this->flexi_cart->surcharge_data();
			//$this->load->view('manageorder', $data);	
		$this->load->view('managesales/addOrder', $data);
		}
		
	}


	public function addorder(){
		//var_dump($this->input->post());

		//echo "manoj"; exit;

		global $uInfo;

		
			
			$data['title'] = 'Dashboard | Inventory';
			//$this->load->view('manageorder', $data);	

		$this->form_validation->set_rules('item_bcode', 'item_bcode', 'required');
		$this->form_validation->set_rules('item_code', 'item_code', 'required');
		if ($this->form_validation->run() == FALSE) {
    
    		$errors = array();

    		if(form_error('item_bcode')){
    			$errors['item_bcode']=1;

    		}
    		if(form_error('item_bcode')){
    			$errors['item_code']=1;

    		}
    		//'item_bcode' => if(isset() && !empty()),
            echo json_encode($errors);
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
function delete_item($row_id = FALSE) 
	{
		// The 'delete_items()' function can accept an array of row_ids to delete more than one row at a time.
		// However, this example only uses the 1 row_id that was supplied via the url link.
		$this->flexi_cart->delete_items($row_id);
		
		// Set a message to the CI flashdata so that it is available after the page redirect.
		$this->session->set_flashdata('message', $this->flexi_cart->get_messages());

		redirect('sales/managesales');		
	}
	
	function add_item(){
		$item_data = array(
'id' => 101,
'name' => 'Example Item Name #1',
'quantity' => 3,
'price' => 10.99
);


$this->flexi_cart->insert_items($item_data);
	}
	function view_cart() 
	{
		

		###+++++++++++++++++++++++++++++++++###
		
		// Get required data on cart items, discounts and surcharges to display in the cart.
		$this->data['cart_items'] = $this->flexi_cart->cart_items(); 
		$this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
		$this->data['discounts'] = $this->flexi_cart->summary_discount_data();
		$this->data['surcharges'] = $this->flexi_cart->surcharge_data();

		###+++++++++++++++++++++++++++++++++###

		// This example shows how to lookup countries, states and post codes that can be used to calculate shipping rates.
		$sql_select = array($this->flexi_cart->db_column('locations', 'id'), $this->flexi_cart->db_column('locations', 'name')); 	
		$this->data['countries'] = $this->flexi_cart->get_shipping_location_array($sql_select, 0);
		$this->data['states'] = $this->flexi_cart->get_shipping_location_array($sql_select, 1);
		$this->data['postal_codes'] = $this->flexi_cart->get_shipping_location_array($sql_select, 2);
		$this->data['shipping_options'] = $this->flexi_cart->get_shipping_options(); 
		
		// Uncomment the lines below to use the manual shipping example. Read more below.
		# $this->load->model('demo_cart_model');
		# $this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options(); 
		
		/**
		 * By default, this demo is setup to show how to implement shipping rates with a database.
		 * In the 2 steps below is an example showing how to manually set and define shipping options and rates.
		 *
		 * To use this example follow these steps:
		 * #1: Replace the four "$this->data" arrays set above with "$this->data['shipping_options'] = $this->demo_cart_model->demo_manual_shipping_options();".
		 * #2: Set "$config['database']['shipping_options']['table']" and "$config['database']['shipping_rates']['table']" to FALSE via the config file.
		*/
		
		###+++++++++++++++++++++++++++++++++###
		
		// Get any status message that may have been set.
		$this->data['message'] = $this->session->flashdata('message');	

		$this->load->view('manageOrders/view_cart', $this->data);
	}




public function itemAutoSuggest()
	{
		$this->load->model('managesales_model');
		$suggestions = array();
		$search = $this->input->get('term') != '' ? $this->input->get('term') : NULL;

		
		
		

		$sg = $this->managesales_model->get_search_suggestions($search, array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);

		$suggestions=$sg;
		echo json_encode($suggestions);

	}


function addItemToCart(){



	$itemID=$this->input->post('item');
	$itemArr= $this->managesales_model->getItemInfoByID($itemID);
	$item_data = array(
	'id' => $itemArr['product_id'],
	'name' => $itemArr['product_name'],
	'quantity' => 1,
	'price' => $itemArr['product_price'],
	);

/*$item_data = array(
	'id' => 101,
	'item_name' => 'Example Item Name #1',
	'item_qty' => 3,
	'item_unit' => 10.99,
	'item_rate' => 10.99,
	'item_disc_per' => 10.99,
	'item_disc_amt' => 10.99,
	'item_tax_per' => 10.99,
	'item_tax_amt' => 10.99
	'item_tot_amt' => 10.99
	);*/


	$this->flexi_cart->insert_items($item_data);

	$this->data['cart_items'] = $this->flexi_cart->cart_items(); 
	$this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
	$this->data['discounts'] = $this->flexi_cart->summary_discount_data();
	$this->data['surcharges'] = $this->flexi_cart->surcharge_data();
	$this->load->view('managesales/cart_view', $this->data);
	
}

function editable(){
	$this->load->view('managesales/editable');
}

function edit_cart_item(){
	//var_dump($this->input->post());exit;

	$item_data = array(
'rowid' => $this->input->post('pk'),
 $this->input->post('name') => $this->input->post('value')
);

$this->flexi_cart->update_cart($item_data);

	$this->data['cart_items'] = $this->flexi_cart->cart_items(); 
	$this->data['reward_vouchers'] = $this->flexi_cart->reward_voucher_data();
	$this->data['discounts'] = $this->flexi_cart->summary_discount_data();
	$this->data['surcharges'] = $this->flexi_cart->surcharge_data();
	$this->load->view('managesales/cart_view', $this->data);
}

}

