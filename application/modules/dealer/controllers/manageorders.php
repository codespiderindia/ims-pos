<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Manageorders extends CI_Controller {
/**

	 * Index Page for this controller.
*/	
	public function __construct()
		{		
			parent::__construct();
header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;
			$uInfo=$this->session->userdata('dealer_session_info');
			
			if (!($this->session->userdata('dealer_session_info'))) {
				redirect(base_url().'dealer/login');
			}
			$this->load->model('manageorders_model');

			
		}
	
	public function index()
	{
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			redirect(base_url().'dealer/manageorders/viewOrders');
		}
		
	}

	public function viewOrders()
	{
		global $uInfo;
		
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'View Orders';
		$data['getAllOrdersInfoByDealerId'] = $this->manageorders_model->getAllOrdersInfoByDealerId($uInfo['dealer_id'], $uInfo['comp_code']);
		
		$this->load->view('manageOrders/viewOrders',$data);
	}
		
	public function orderPdfGenerator(){ // for pdf generate on view orders page

		$this->load->library('pdf');
		$data['firm_data']= $this->manageorders_model->getFirmdata();
		$this->pdf->load_view('common/manageorder',$data);
		
		$this->pdf->render();
		//$data = array();
		
		$this->pdf->stream("welcome.pdf");
		$this->pdf->load_view('welcome', $data);
	}

	public function viewOrdersByOrderId($order_id)
	{
		global $uInfo;
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'Orders Details';
		$data['ordersByOrderId']= $this->manageorders_model->getAllOrdersByOrderId($order_id);
		$this->load->view('manageOrders/viewOrdersByOrderId',$data);
	}

	public function viewShipment($order_id)
	{	
		global $uInfo;
		$data['title'] = 'Orders | Inventory | Shipments';
		$data['heading'] = 'View Shipment';
		$data['orders']= $this->manageorders_model->getShipments($order_id);
		$data['order_id'] = $order_id;
		$this->load->view('manageOrders/viewShipment',$data);
	}	
}