<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managestore_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
 	function storeInsert($data){
		$this->db->insert('store', $data);
	}
    function getAllStore($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('store');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }
	//Status ChangeFor Store Status
	function changeStoreStatus($store_id, $data){
		$this->db->where('store_id', $store_id);
		$this->db->update('store',$data);
	}
	//Status ChangeFor HR approval
	function changeHrStoreStatus($store_id, $data){
		$this->db->where('store_id', $store_id);
		$this->db->update('store',$data);
	}
    function deleteStore($store_id){
		$this->db->where('store_id', $store_id);
		$this->db->delete('store',$data);
    }
	function getStoreId($store_id){
		$this->db->select('*');
		$this->db->from('store');
		$this->db->where(array('store_id'=> $store_id));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	function storeUpdate($store_id, $data){
		$this->db->where('store_id',$store_id);
		$this->db->update('store',$data);
	}
	function getUserMasterByUserId($user_ID){
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array('user_ID'=> $user_ID));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
    function getAllStoreByUser($store_id){
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array('store_id'=> $store_id));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }

    function getAllStoreByLocation($store_location_id){
		$this->db->select('*');
		$this->db->from('user_master');
		$this->db->where(array('location'=> $store_location_id));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
    }
	
	function getLocationByCity($country_val,$state_val,$city_val)
	{
		$uInfo = $this->session->userdata('webadmin_session_info');
		$this->db->select('*');
		$this->db->from('locations');
		$this->db->where(array('country_id'=> $country_val,'state_id'=> $state_val,'city_id'=> $city_val,'comp_code'=>$uInfo['comp_code']));
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			$location = $query->result_array();
			echo '<option value="">Select Location</option>';
				foreach($location as $location){
					echo '<option value='.$location["id"].'>'.$location["location_name"].'</option>';
				}
		}else{
			echo "<script>alert('Please First Create Location For this');</script>";
			echo '<option value="">Select Location</option>';
		}
	}
	
	function getAllStoreToStoreInvoice()
	{
		$this->db->select('*');
		$this->db->from('store_to_store_invoice');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function store_to_store_invoiceInsert($data)
	{
		$this->db->insert('store_to_store_invoice', $data);
	}
	
	function storeToStoreTransfer($data1)
	{
		$this->db->insert('store_to_store_transfer', $data1);
	}
	
	function store_from_update_stock_in_store_inventory($productID,$store_from,$data2,$batchID,$compCode)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('store_id', $store_from);
		$this->db->where('batch_id', 0);
		$this->db->where('comp_code', $compCode);
		$this->db->update('store_inventory',$data2);
	}
	
	function checkStockStoreToId($productID,$store_to)
	{
		$this->db->select('stock_qty');
		$this->db->from('store_inventory');
		$this->db->where(array('store_id'=>$store_to,'product_id'=>$productID));
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$row = $query->row();
			$stock_qty = $row->stock_qty;
			return $stock_qty;
		}else{
			return 0;
		}
	}
	
	function store_to_update_stock_in_store_inventory($productID,$store_to,$data3)
	{
		
		$this->db->where('product_id', $productID);
		$this->db->where('store_id', $store_to);
		$this->db->update('store_inventory',$data3);
	}
	
	function store_to_insert_stock_in_store_inventory($data3)
	{
		$this->db->insert('store_inventory',$data3);
	}
	
	
	function getCentralWarehouseName()
	{
		$this->db->select('warehouse_name');
		$this->db->from('warehouse');
		$this->db->where(array('is_central' => '1'));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	function getStoreNameByID($store_id)
	{
		$this->db->select('store_name');
		$this->db->from('store');
		$this->db->where(array('store_id' => $store_id));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	function getProductNameByID($productID)
	{
		$this->db->select('product_name');
		$this->db->from('product');
		$this->db->where(array('product_id' => $productID));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	function getAllStoreToStoreTransfer($invoice_id) {
		$this->db->select('*');
		$this->db->from('store_to_store_transfer');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getStoreInventory($comp_code)
	{
		$this->db->select('product.*, a.product_id as sku, a.store_id, a.stock_qty, a.master_product_id');
		$this->db->from('store_inventory as a');
		$this->db->join('product', 'product.product_id = a.master_product_id');
		//$this->db->join('product_batch as b', 'b.product_batch_id = a.batch_id');
		$this->db->where('a.comp_code', $comp_code);
		$this->db->where('a.batch_id',0);
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
		 	return false;
		}
	}

	function getAllWareHouseToStoreInvoice($comp_code)
	{
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('warehouse_to_store_invoice');
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function storeToWhInvoiceInsert($data){
		$this->db->insert('store_to_warehouse_invoice', $data);
	}
	function storeToWhTransferInsert($data1){
		$this->db->insert('store_to_warehouse_transfer', $data1);
	}
	function checkStockWareHouseToId($productID,$warehouse_to,$batchId,$compCode){
		$this->db->select('stock_qty');
		$this->db->from('warehouse_inventory');
		$this->db->where(array('warehouse_id'=>$warehouse_to,'product_id'=>$productID, 'comp_code'=>$compCode, 'batch_id'=>0));
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$row = $query->row();
			$stock_qty = $row->stock_qty;
			return $stock_qty;
		}else{
			return 0;
		}
	}
	function warehouse_to_update_stock_in_warehouse_inventory($productID,$warehouse_to,$data3,$batchId,$comp_code){
		
		$this->db->where('product_id', $productID);
		$this->db->where('warehouse_id', $warehouse_to);
		$this->db->where('batch_id', 0);
		$this->db->where('comp_code', $comp_code);
		$this->db->update('warehouse_inventory',$data3);

	}
	function warehouse_to_insert_stock_in_warehouse_inventory($data3){
		$this->db->insert('warehouse_inventory',$data3);
	}
	function getAllStoreToWhInvoice($compCode){
		$this->db->select('*');
		$this->db->from('store_to_warehouse_invoice');
		$this->db->where('comp_code', $compCode);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}

	function getAllStoreToWhTransfer($invoice_id){
		$this->db->select('a.store_from, a.warehouse_to, a.master_product_id, a.product_id, a.quantity, a.ip_address, a.create_date, a.modified_date');
		$this->db->from('store_to_warehouse_transfer as a');
		//$this->db->join('product_batch as b', 'b.product_batch_id = a.batch_id');
		$this->db->where('a.invoice_id',$invoice_id);
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	/*function getAllWareHouseToStoreInvoice(){
		$this->db->select('*');
		$this->db->from('warehouse_to_store_invoice');
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}*/
	
	function getWarehouseToStoreReceiveInfo($invoice_id)
	{
		$this->db->select('*');
		$this->db->from('warehouse_to_store_invoice');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function warehouse_to_store_receive($data1,$invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('warehouse_to_store_invoice',$data1);
	}

	public function checkUniqueStore($str,$compCode) {
 		$this->db->select('*');
		$this->db->from('store');
		$this->db->where(['comp_code'=>$compCode,
						 'store_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
 	}

 	function checkStoreNameOnEditCase($str,$storeId,$compCode) {
	 	$this->db->select('*');
		$this->db->from('store');
		$this->db->where(['comp_code'=>$compCode,
						'store_id !='=>$storeId,
						'store_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
 	}

 	public function checkStoreCode($code) {
		$this->db->select('*');
		$this->db->from('store');
		//$this->db->where('product_code',$code);
		$this->db->like('store_code',$code);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}

	public function batchStoreInventory($pId, $batchId, $storeId, $compCode) {
		$this->db->select('a.product_id as sku, a.stock_qty as qty, a.price as price, b.product_name as product_name, c.store_name as store_name');
		$this->db->from('store_inventory as a');
		$this->db->join('product as b', 'b.product_id = a.master_product_id');
		$this->db->join('store as c', 'c.store_id = a.store_id');
		//$this->db->join('product_batch as d', 'd.product_batch_id = a.batch_id');
		$this->db->where(['a.comp_code'=>$compCode,'a.store_id'=>$storeId, 'a.master_product_id'=>$pId]);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}

}