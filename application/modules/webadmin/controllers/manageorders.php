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
			$this->load->library('email');
			$uInfo=$this->session->userdata('webadmin_session_info');
			
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('manageorders_model');
			
		}
	public function index()
	{
		global $uInfo;
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'View Orders';
		$data['orders']= $this->manageorders_model->getAllOrders();
		$this->load->view('manageOrders/viewOrders',$data);
	}

	public function viewOrders()
	{
		global $uInfo;
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'View Orders';
		
		$data['orders']= $this->manageorders_model->getAllOrders($uInfo['comp_code']);

		//$data['shipmentQty']= $this->manageorders_model->gettotalShipmentQty($orderId,$sku);

		$this->load->view('manageOrders/viewOrders',$data);
	}

	public function viewOrdersByOrderId($order_id,$shipment_id)
	{
		global $uInfo;

		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'Orders Details';

		$data['ordersByOrderId'] = $this->manageorders_model->getAllOrdersById($order_id,$shipment_id);
		$data['getCustomerAddress'] = $this->manageorders_model->getCustomerAddressId($order_id);
		$data['getShippingAddress'] = $this->manageorders_model->getShippingAddressById($order_id);
		$data['ordersDetailsByOrderId']= $this->manageorders_model->getAllOrdersDetailsByOrderId($order_id);
		
		$this->load->view('manageOrders/viewOrdersByOrderId',$data);
	}

	public function addShipment($order_id)
	{
		global $uInfo;
		if(isset($_POST['quantity'])) {
			
			
		/* Get Order Shipment */
			$getShipment = getSku('order_shipment', ['order_id'=>$order_id]);
		/* End Of Get Order Shipment */

		$order_shipment = array(
			'order_id' => $order_id,
			'shipment_status' => $this->input->post('shipment_status'),
			'address' => $_POST['address'],
			'lr_number' => $_POST['lr_number'],
			'lr_date' => $_POST['lr_date'], 
			'remark' => $_POST['remark'],
			'date' => date('Y-m-d')
		);
		$this->db->insert('order_shipment',$order_shipment);
		$order_shipment_id = $this->db->insert_id();

		if($order_shipment_id!='') {
		 $centerWareHouseId =  getWarehouseIsCentral($uInfo['comp_code']);
		 $centerWareHouseId = $centerWareHouseId->warehouse_id;

		 $masterProductId = $this->input->post('master_product_id');
		 
			foreach($_POST['quantity'] as $p_id=>$qty) {

				$where = ['product_id'=>$masterProductId[$p_id]];
				$getProductDetail = getSku('product',$where);

				$gstRate = $getProductDetail[0]['gst_rate'];
				$gstInc = $getProductDetail[0]['gst_inc'];
				$productPrice = $getProductDetail[0]['product_price'];

				$itm_igst_amt=0;
				$itm_cgst_amt=0;
				$itm_sgst_amt=0;
				$igp=0;
				$cgp=0;
				$sgp=0;

				if(isset($gstRate) && $gstRate != '') {
					$gp=round(($gstRate/2),2);
					$cgp=$gp;
					$sgp=$gp;
					$itm_cgst_amt=round((($productPrice*$gp)/100),2);
					$itm_sgst_amt=round((($productPrice*$gp)/100),2);
				}

				$shipment_details_data  = array(
				'shipment_id' => $order_shipment_id,
				'order_id' => $order_id,
				'product_id' => $p_id,
				'quantity' => $qty,
				'cgst_per' => $cgp,
				'cgst_amt' => $itm_cgst_amt,
				'sgst_per' => $sgp,
				'sgst_amt' => $itm_sgst_amt,
				'igst_per' => $igp,
				'igst_amt' => $itm_igst_amt,
				'date' => date('Y-m-d'),
				'master_product_id' => $masterProductId[$p_id]
			);
			
			$this->db->insert('order_shipment_detail',$shipment_details_data);
			$this->updateStcokOfCenterWarehouse($p_id,$centerWareHouseId,$qty);
			
			}
		$order_update_data = array('order_status'=>$this->input->post('shipment_status'));
		/*$this->db->where('order_id', $order_id);
        $this->db->update('orders', $order_update_data);*/
		$this->session->set_flashdata('success_msg', 'Order Shipment Added Successfully.');
		redirect('webadmin/manageorders/viewOrders');
		
		} else {
		echo "Something is wrong please try again"; die;
		}
		}
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'Add Shipment';
		$data['orders']= $this->manageorders_model->getAllOrders($uInfo['comp_code']);
		$data['order_id'] = $order_id;
		$shipment_info = $this->manageorders_model->getShipmentQty($order_id);

		if(!empty($shipment_info)) {
			$qty = 0;$qtyDetail=[];
			foreach($shipment_info as $shipment_infos) {
				$sku=$shipment_infos['product_id'];

				$getTotalQty = $this->manageorders_model->getTotalQty($order_id, $sku);
				if(!empty($getTotalQty)) {
					$qtyDetail[$sku] = $getTotalQty->qty;
				}
			}
		}
		if(!empty($qtyDetail)) {
				$data['shipment_qty'] = $qtyDetail;
		}
		
		$this->load->view('manageOrders/addShipment',$data);
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

	public function viewShipmentDetail($shipment_id,$order_id)
	{
		global $uInfo;
		$data['title'] = 'Orders | Inventory | Shipments Detail';
		$data['heading'] = 'View Shipment Detail';
		$data['orders']= $this->manageorders_model->getShipmentsDetails($shipment_id);
		$data['order_id'] = $order_id;
		$this->load->view('manageOrders/viewShipmentDetail',$data);
	}
	
	function orderPdfGenerator($id) { // for pdf generate on view orders page
		global $uInfo;
		$this->load->library('pdf');
		$data['title'] = 'Order Pdf';
		$data['orders']= $this->manageorders_model->getAllOrdersByOrderId($id);
		$dealerId = $data['orders'][0]->dealer_id;
		$data['shipment']= $this->manageorders_model->getShipments($id);
		$whereDealer = ['dealer_id'=>$dealerId];
		$data['dealerInfo']= getSku('dealer',$whereDealer);

		//$shipmentDetail=[];
		foreach($data['shipment'] as $shipments) {
			$shipmentId = $shipments->shipment_id;
			$shipmentDetail[]=$this->manageorders_model->getShipmentsDetails($shipmentId);
		}
		$data['shipmentDetail']=$shipmentDetail;

		$this->pdf->load_view('common/manageorder',$data);
		$this->pdf->render();
		$this->pdf->stream("order.pdf");
	}

	public function shipmentPdfGenerator($shipmentId,$orderid) {
		global $uInfo;
		$this->load->library('pdf');

		$data['title'] = 'Shipment Pdf';
		$data['comp_code'] = $uInfo['comp_code'];
		$companyName=getCompanyDetail($uInfo['comp_code'],'comp_name, comp_address');
		$data['companyname']=$companyName[0]->comp_name;
		$data['companyaddress']=$companyName[0]->comp_address;

		$data['orders']= $this->manageorders_model->getAllOrdersByOrderId($orderid);
		$dealerId = $data['orders'][0]->dealer_id;
		$whereDealer = ['dealer_id'=>$dealerId];
		$data['dealerInfo']= getSku('dealer',$whereDealer);

		$shipmentWhere=['shipment_id'=>$shipmentId];
		$data['shipment']= getSku('order_shipment',$shipmentWhere);

		$shipmentDetail = $this->manageorders_model->getShipmentsDetails($shipmentId);
		$data['shipmentDetail']=$shipmentDetail;

		$whereDealerAccount = ['dealer_user_id'=>$dealerId,'order_id'=>$orderid];
		$data['dealerInvoice'] = getSku('dealer_account',$whereDealerAccount);

		$whereDealerBankDetail = ['dealer_id'=>$dealerId];
		$data['dealerBankDetail'] = getSku('dealer_bank_details',$whereDealerBankDetail);

		$userId = $data['dealerInfo'][0]['user_ID'];

		$data['companyDetails'] = $this->manageorders_model->companyInfoById($uInfo['comp_code'], $userId);

		$data['companyFirmInfo'] = $this->manageorders_model->companyFirmInfoById($uInfo['comp_code'], $userId);

		$this->pdf->load_view('common/manageshipment', $data);
		$this->pdf->render();
		$this->pdf->stream("shipment.pdf");
	}

	public function checkStock()
	{    
	     global $uInfo;
	 	 $product_id = $_POST['product_id'];

	 	 if(isset($_POST['qty'])) {
	 	 	 $qty = $_POST['qty'];
	 	 }

		 if($product_id=='') {
		 echo "Product id is manadory for check stock";
		 } else {
		 $centerWareHouseId =  getWarehouseIsCentral($uInfo['comp_code']);
		 $centerWareHouseId = $centerWareHouseId->warehouse_id;
	     $res =  getStockByProductAndWarehouseId($product_id,$centerWareHouseId,0,$uInfo['comp_code']);
	     if(!empty($res)) {
	     	echo  $avail_stock =  $res->stock_qty;
	     } else {
	     	echo  $avail_stock =  0;
	     }

		} 
	}
	
	public function updateStcokOfCenterWarehouse($p_id,$centerWareHouseId,$qty)
	{
		global $uInfo;
		$getStockQty = getStockByProductAndWarehouseId($p_id,$centerWareHouseId,0,$uInfo['comp_code']);
		$stock = $getStockQty->stock_qty;
		if($stock<=0) {
			$stock=0;
			
		} else {
			$sql = "UPDATE warehouse_inventory SET stock_qty='$stock' - '$qty' WHERE warehouse_id='$centerWareHouseId' and product_id='$p_id'";
    		
    		$this->db->query($sql);
		}
	 	
	} 

	public function orderChangeStatus(){
		$orderId = $this->input->post('orderId');
		$shipmentId = $this->input->post('shipmentId');
		/*$orderStatus = $this->input->post('orderStatus');
		$data = array(
    			'order_status' => $orderStatus
    			);
		$this->manageorders_model->changeOrderStatus($orderId, $data);*/

		$shippingStatus = $this->input->post('shippingStatus');
		$data = array(
    			'shipment_status' => $shippingStatus
    			);
		$this->manageorders_model->changeShippingStatus($orderId, $shipmentId, $data);

		$this->session->set_flashdata('success_msg', 'Order status changed successfuly !!!');
		redirect(base_url().'webadmin/manageorders/viewOrders');
	}

	public function checkShipmentStatus() {
		$orderId = $this->input->post('orderId');
		$getStatus = $this->manageorders_model->checkShipmentStatus($orderId);

		$status = $getStatus->shipment_status;
		$explodeArray = explode(',',$status);

		$vals = array_count_values($explodeArray);

		$where = ['order_id'=>$orderId];
		$getOrderStatus = getSku('orders',$where);

		if(isset($vals['3']) && $getOrderStatus[0]['order_status'] == 3) {
			echo '2_'.$getOrderStatus[0]['order_status'];
		}
		else if(in_array('1',$explodeArray) || in_array('2',$explodeArray))
		{
			echo '1_'.$getOrderStatus[0]['order_status'];
		} else if(isset($vals['3']) && $vals['3'] = count($explodeArray)) {
			echo '3_'.$getOrderStatus[0]['order_status'];
		} else {
			echo '0_'.$getOrderStatus[0]['order_status'];
		}
	}

	public function orderChangeStatusByOrderId(){
		$orderId = $this->input->post('orderId');
		$orderStatus = $this->input->post('orderStatus');
		$data = array(
    			'order_status' => $orderStatus
    			);
		$this->manageorders_model->changeOrderStatus($orderId, $data);

		$this->session->set_flashdata('success_msg', 'Order status changed successfuly !!!');
		redirect(base_url().'webadmin/manageorders/viewOrders');
	}
}