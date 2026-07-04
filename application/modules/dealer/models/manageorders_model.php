<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageorders_model extends CI_Model {

	function __construct(){
	parent::__construct();
	}

	 function getAllOrdersInfoByDealerId($dealer_id, $comp_code)
    {
	     $where = '';
 
      if(isset($_GET['days'])) {
      $where.='WHERE date >= DATE_SUB(CURDATE(), INTERVAL '.$_GET['days'].' DAY) AND'; 
      } 
      
      if(isset($_GET['start_date']) && isset($_GET['end_date'])) { 
        $from_date = $_GET['start_date'];
        $to_date = $_GET['end_date'];
        $from_date  = explode('/',$_GET['start_date']);
        $from_date = $from_date[2].'-'.$from_date[0].'-'.$from_date[1];
        $end_date  = explode('/',$_GET['end_date']);
        $end_date = $end_date[2].'-'.$end_date[0].'-'.$end_date[1];
        $where.="WHERE date BETWEEN '" . $from_date . "' AND  '" . $end_date."' AND ";
      }
      
      if($where == '' ) { $where = 'WHERE ' ;  }
    	     $qry = 'select * from orders '.$where.' dealer_id='.$dealer_id AND 'comp_code='.$comp_code;
    	 
    		$query = $this->db->query($qry);
    		
    		return $query->result();
	
       /* $this->db->select('*');
        $this->db->from('orders');
		$this->db->where(array('dealer_id'=>$dealer_id));
        $query = $this->db->get();
        
		
		if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $data[] = $row;
            }
           return $data;
        }
        return false; */
    }

    function getAllOrdersByOrderId($order_id){
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
        $this->db->join('order_shipment_detail', 'order_shipment_detail.shipment_id = order_shipment.shipment_id','left');
        $this->db->where(array('order_shipment.order_id'=>$order_id));
		$query = $this->db->get();
		return $query->result();
  }
public function getFirmdata()
{
        $this->db->select('*');
        $this->db->from('firm_details'); 
 		$query = $this->db->get();
		return $query->result();

}
	
}