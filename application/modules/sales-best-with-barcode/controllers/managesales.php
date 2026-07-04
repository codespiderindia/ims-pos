<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageSales extends CI_Controller {

	function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;

			$this->load->library('cart');
			$uInfo=$this->session->userdata('sales_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			$this->load->model('managesales_model');
			if (!($this->session->userdata('sales_session_info'))) {
				redirect(base_url().'sales/login');
			}
		}
	
	 function index()
	{
		
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			$data['title'] = 'Dashboard | Sales';
			$data['cart_items'] = $this->cart->contents(); 
			$this->load->view('managesales/addOrder', $data);
		}
		
	}


	function delete_item($rowid = FALSE) {
		
		$data = array(
            'rowid'   => $rowid,
            'qty'     => 0
        );
        $this->cart->update($data);
		redirect('sales/managesales');
		
	}
	

	function itemAutoSuggest(){
		$this->load->model('managesales_model');
		$suggestions = array();
		$search = $this->input->get('term') != '' ? $this->input->get('term') : NULL;
		$sg = $this->managesales_model->get_search_suggestions($search, array('search_custom' => FALSE, 'is_deleted' => FALSE), TRUE);

		$suggestions=$sg;
		echo json_encode($suggestions);
	}


	function addItemToCart(){
		
		//var_dump($this->input->post());exit;
		$this->load->library('cart');
		$itemID=(int) $this->input->post('item');
		$itemArr= $this->managesales_model->getItemInfoByID($itemID);
		
		//var_dump($itemArr);exit;
		$quantity=1;
		$price=$itemArr['product_price'];
		$discount=5;

		$item_data = array(
			'id' => $itemArr['product_id'],
			'name' => $itemArr['product_name'],
			'qty' => 1,
			'price' => $itemArr['product_price'],
			'discount' => 1,
			'tax' => 3,
		);

		$this->cart->insert($item_data);

		$data['cart_items'] = $this->cart->contents(); 

		$this->load->view('managesales/cart_view', $data);

	}

	function editable(){
		$this->load->view('managesales/editable');
	}

	function edit_cart_item(){
	
		$item_data = array(
		'rowid' => $this->input->post('pk'),
		$this->input->post('name') => $this->input->post('value')
		);

		$this->cart->update($item_data);
		$data['cart_items'] = $this->cart->contents(); 


		$this->load->view('managesales/cart_view', $data);
	}

	function reloadCartTotal(){
		$data=array();
		$this->load->view('managesales/cart_total', $data);
	}

	function add_payment(){
	
		$item_data = array(
		'mode' => $this->input->post('pay_mode'),
		'amount' => $this->input->post('pay_amount'),

		);
		$this->cart->insert_payment($item_data);
	
		$this->reloadCartTotal();
	
	}

	function remove_payment(){

		$pay_id=$this->input->post('pay_id');
		$this->cart->remove_payment($pay_id);
		$this->reloadCartTotal();
	}

	function fetch_pay(){
		$cc=array();
		if ($this->session->userdata('_payment_options_amount') !== FALSE)
		{
			$cc = $this->session->userdata('_payment_options_amount');
		}
		var_dump($cc);
		
	}

	function mypdf(){


		$data=array();
	  	$this->load->view('managesales/pdf',$data);
   }

}

