<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageorders_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
	}

 	
  public function getAllOrders($comp_code){
  $where = '';
 
  if(isset($_GET['days'])) {
  
    $where.='WHERE date >= DATE_SUB(CURDATE(), INTERVAL '.$_GET['days'].' DAY)'; 
  
  } 
  
  if(isset($_GET['start_date']) && isset($_GET['end_date'])) { 
  $from_date = $_GET['start_date'];
  $to_date = $_GET['end_date'];

  $from_date  = explode('/',$_GET['start_date']);
  $from_date = $from_date[2].'-'.$from_date[0].'-'.$from_date[1];
  $end_date  = explode('/',$_GET['end_date']);
  $end_date = $end_date[2].'-'.$end_date[0].'-'.$end_date[1];

  $where.="WHERE date BETWEEN '" . $from_date . "' AND  '" . $end_date."'";
  
  }
  if($where=='') { $where = 'where'; $and = ''; } else { $and = 'AND'; }
	     $qry = 'select * from orders '.$where.' '.$and.' comp_code='.$comp_code;
	
		$query = $this->db->query($qry);
		
		
	//	$this->db->from('orders'); 	
        
		//$query = $this->db->get();
		return $query->result();
  }
  
   public function getAllOrdersByOrderId($order_id){
		$this->db->select('*');
        $this->db->from('orders'); 
        $this->db->join('order_detail', 'order_detail.order_id = orders.order_id','left');
        $this->db->where(array('orders.order_id'=>$order_id));
  		$query = $this->db->get();
  		return $query->result();
  }
  
  public function getShipments($order_id)
  {
        $this->db->select('*');
        $this->db->from('order_shipment'); 
       // $this->db->join('order_shipment_detail', 'order_shipment_detail.shipment_id = order_shipment.shipment_id');
        $this->db->where(array('order_shipment.order_id'=>$order_id));
    		$query = $this->db->get();
    		return $query->result();
  }

  public function getShipmentsDetails($shipment_id)
  {
        $this->db->select('*');
        $this->db->from('order_shipment'); 
        $this->db->join('order_shipment_detail', 'order_shipment_detail.shipment_id = order_shipment.shipment_id','left');
        $this->db->where(array('order_shipment.shipment_id'=>$shipment_id));
        $query = $this->db->get();
        return $query->result();
  }


   public function getAllOrdersById($order_id,$shipment_id){
		    $this->db->select('*');
        $this->db->from('orders');
        $this->db->join('order_shipment', 'order_shipment.order_id = orders.order_id','left'); 
		    $this->db->where(['orders.order_id'=>$order_id,'order_shipment.shipment_id'=>$shipment_id]);
        $query = $this->db->get();
    		if($query->num_rows()>0){
    			return $query->row();
    		}else{
    			return false;
    		}
  }



   public function getAllOrdersDetailsByOrderId($order_id){
		$this->db->select('*');
        $this->db->from('order_detail'); 
        $this->db->where('order_id',$order_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
  }
  public function changeOrderStatus($orderId, $data){
  		$this->db->where('order_id', $orderId);
  	    $this->db->update('orders', $data);
  }

  public function changeShippingStatus($orderId, $shipmentId,$data){
      $this->db->where(['order_id'=>$orderId, 'shipment_id'=>$shipmentId]);
        $this->db->update('order_shipment', $data);
  }

  public function getShippingAddressById($order_id){
  		$this->db->select('*');
		$this->db->from('shipping_address');
		$this->db->where('order_id', $order_id);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
  }
  public function getCustomerAddressId($order_id){
    $query = $this->db->query("select * from orders inner join customers on orders.customer_id=customers.customer_id where order_id='$order_id'");

    if( $query->num_rows() > 0){
      return $query->row();
    }else{
      return false;
    }
  }
  

  public function getShipmentQty($order_id) {
      $this->db->select('*');
      $this->db->from('order_shipment_detail');
      $this->db->where('order_id', $order_id);
      $query = $this->db->get();
      if($query->num_rows()>0){
        return $query->result_array();
      }else{
        return false;
      }
  }


  public function getTotalQty($order_id, $sku) {
      $this->db->select('SUM(quantity) as qty');
      $this->db->from('order_shipment_detail');
      $this->db->where(['order_id'=>$order_id, 'product_id'=>$sku]);
      $query = $this->db->get();
      if($query->num_rows()>0){
       return $query->row();
      }else{
        return false;
      }
  }

  public function checkShipmentStatus($orderId) {
      $this->db->select('GROUP_CONCAT(shipment_status) as shipment_status');
      $this->db->from('order_shipment');
      $this->db->where(['order_id'=>$orderId]);
      $this->db->group_by('order_id');
      $query = $this->db->get();
      if($query->num_rows()>0){
       return $query->row();
      }else{
        return false;
      }
  }


  public function gettotalShipmentQty($orderId, $sku) {
      $this->db->select('SUM(quantity) as totalquantity');
      $this->db->from('order_shipment_detail');
      $this->db->where(['order_id'=>$orderId, 'product_id'=>$sku]);
      $this->db->group_by('order_id');
      $query = $this->db->get();
      if($query->num_rows()>0){
       return $query->row();
      }else{
        return false;
      }
  }


  /*public function getOrderWithShipment() {
      $this->db->select('*');
      $this->db->from('order');
      $this->db->where(['order_id'=>$orderId]);
      $query = $this->db->get();
       if($query->num_rows()>0){
          return $query->result_array();
       }else{
          return false;
      }
  }*/


  function companyInfoById($compCode, $userId) {
    global $uInfo;
    $this->db->select('invoice_header, invoice_footer');
    $this->db->from('user_master');
    $this->db->where(['comp_code'=>$compCode, 'user_ID'=>$userId]);
    $query = $this->db->get();
    /*echo $this->db->last_query();
    die;*/
    if($query->num_rows()>0){
      return $query->row();
    }else{
      return false;
    }
  }

  public function companyFirmInfoById($compCode, $userId) {
    global $uInfo;
    $this->db->select('firm_name, firm_logo, firm_address, firm_teen_num');
    $this->db->from('firm_details');
    $this->db->where(['updated_by'=>$userId]);
    $query = $this->db->get();

    if($query->num_rows()>0){
      return $query->row();
    } else {
      return false;
    }
  }
 
}