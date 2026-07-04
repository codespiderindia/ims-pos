<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managewarehouse_model extends CI_Model {

	function __construct(){
		parent::__construct();
	}
 	function warehouseInsert($data){
		$this->db->insert('warehouse', $data);
	}
	function getAllWarehouse($comp_code){
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('warehouse');
		$query = $this->db->get();
		
		if($query->num_rows() > 0){
			return $query->result();
		}else{
			return false;
		}
	}
	function getWarehouseId($warehouse_id){
		$this->db->select('*');
		$this->db->from('warehouse');
		$this->db->where(array('warehouse_id' => $warehouse_id));
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}else{
		 	return false;
		}
	}
	function warehouseIsCentralUpdate($data,$comp_code){
		$this->db->where('comp_code',$comp_code);
		$this->db->update('warehouse', $data);
	}
	function warehouseUpdate($warehouse_id, $data){
		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->update('warehouse', $data);
	}
    function deleteWarehouse($warehouse_id){
		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->delete('warehouse',$data);
    }
	
	function getWarehouseInventory($comp_code)
	{
		$this->db->select('product.*,a.product_id as sku, a.warehouse_id, a.stock_qty, a.master_product_id, a.batch_id');
		$this->db->from('warehouse_inventory as a');
		$this->db->where('a.comp_code',$comp_code);
		$this->db->where('a.batch_id',0);
		$this->db->join('product', 'product.product_id = a.master_product_id');
		$this->db->order_by('a.id','desc');
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->result();
		}else{
		 	return false;
		}
	}
	
	function changeStockQty($product_id,$stock_qty,$data){
		$this->db->where('product_id', $product_id);
		$this->db->update('warehouse_inventory', $data);
		if($this->db->affected_rows()==true){
			echo $stock_qty;
		}
	}
	
	
	function warehouseToStoreTransfer($data){
		$this->db->insert('warehouse_to_store_transfer', $data);
	}
	
	function getAllWarehouseToStoreTransfer($invoice_id, $comp_code){
		$this->db->select('a.warehouse_id, a.store_id, a.master_product_id, a.product_id, a.quantity, a.modify_date, b.batch_number');
		$this->db->from('warehouse_to_store_transfer as a');
		$this->db->join('product_batch as b', 'b.product_batch_id = a.batch_id');
		$this->db->where(array('a.invoice_id' => $invoice_id, 'a.comp_code'=>$comp_code));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function update_stock_in_warehouse_inventory($productID,$warehouse_id,$data1,$batch_id,$comp_code)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->where('batch_id', 0);
		$this->db->where('comp_code', $comp_code);
		$this->db->update('warehouse_inventory',$data1);
	}

	function invoiceInsert($data){
		$this->db->insert('vendor_to_wh_invoice', $data);
	}
	
	function invoiceChallanInsert($data1){
		$this->db->insert('vendor_to_wh_invoice_challan_detail', $data1);
	}
	
	function getAllWarehouseInvoice($comp_code){
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('vendor_to_wh_invoice');
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	
	function getWarehouseInvoiceId($invoice_id){
		$this->db->select('*');
		$this->db->from('vendor_to_wh_invoice');
		$this->db->where(array('invoice_id'=>$invoice_id));
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
	function vendorToWarehouseTransfer($data1){
		$this->db->insert('vendor_to_wh_product', $data1);
	}
	function insert_stock_in_warehouse_inventory($data1){
	  $this->db->insert('warehouse_inventory',$data1);
	}	
	
	function getAllVendorToWarehouseProduct($invoice_id){
		$this->db->select('*');
		$this->db->from('vendor_to_wh_product');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function warehouseToWarehouseTransfer($data){
		$this->db->insert('warehouse_to_warehouse_transfer', $data);
	}
	
	function warehouse_to_warehouse_invoiceInsert($data){
		$this->db->insert('warehouse_to_warehouse_invoice', $data);
	}
	
	function wh_from_update_stock_in_warehouse_inventory($productID,$warehouse_from,$data1,$batchId)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('warehouse_id', $warehouse_from);
		$this->db->where('batch_id', 0);
		$this->db->update('warehouse_inventory',$data1);
	}
	
	function checkStockWarehouseToId($productID,$warehouse_to,$batchId)
	{
		$this->db->select('stock_qty');
		$this->db->from('warehouse_inventory');
		$this->db->where(array('warehouse_id'=>$warehouse_to,'product_id'=>$productID, 'batch_id'=>0));
		$query = $this->db->get();
		if($query->num_rows()>0){
			$row = $query->row();
			$stock_qty = $row->stock_qty;
			return $stock_qty;
		}else{
			return 0;
		}
	}
	
	function wh_to_update_stock_in_warehouse_inventory($productID,$warehouse_to,$data2,$batchId)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('warehouse_id', $warehouse_to);
		$this->db->where('batch_id', 0);
		$this->db->update('warehouse_inventory',$data2);
	}
	
	function wh_to_insert_stock_in_warehouse_inventory($data2)
	{
		$this->db->insert('warehouse_inventory',$data2);
	}
	
	
	function warehouse_to_store_invoiceInsert($data){
		$this->db->insert('warehouse_to_store_invoice', $data);
	}
	
	function getAllWareHouseToStoreInvoice($comp_code){
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
	
	
	function checkStockStoreIventory($productID,$store_id,$batchId,$comp_code)
	{
		$this->db->select('stock_qty');
		$this->db->from('store_inventory');
		$this->db->where(array('store_id'=>$store_id,'product_id'=>$productID,'comp_code'=>$comp_code, 'batch_id'=>0));
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			$row = $query->row();
			$stock_qty = $row->stock_qty;
			return $stock_qty;
		}else{
			return 0;
		}
	}

	
	function store_stock_in_warehouse_inventory($productID,$store_id,$batchId,$data1,$comp_code)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('store_id', $store_id);
		$this->db->where('batch_id', 0);
		$this->db->where('comp_code', $comp_code);
		$this->db->update('store_inventory',$data1);
	}
	
	function insert_store_inventory($data1)
	{
		$this->db->insert('store_inventory',$data1);
	}
	
	function getAllWareHouseToWarehouseInvoice($comp_code){
		$this->db->select('*');
		$this->db->where(array('comp_code'=>$comp_code));
		$this->db->from('warehouse_to_warehouse_invoice');
		$query = $this->db->get();
		
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getAllWarehouseToWarehouseTransfer($invoice_id, $compCode){
		
		$this->db->select('a.warehouse_from, a.warehouse_to, a.master_product_id, a.product_id, a.quantity, a.modify_date, b.batch_number');
		$this->db->from('warehouse_to_warehouse_transfer as a');
		$this->db->join('product_batch as b', 'b.product_batch_id = a.batch_id');
		$this->db->where(array('a.invoice_id' => $invoice_id, 'a.comp_code' => $compCode));
		$query = $this->db->get();

		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getWarehouseToWarehouseReceiveInfo($invoice_id)
	{
		$this->db->select('*');
		$this->db->from('warehouse_to_warehouse_invoice');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function warehouse_to_warehouse_receive($data1,$invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('warehouse_to_warehouse_invoice',$data1);
	}
	
	
	function invoiceUpdate($invoice_id,$data)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->update('vendor_to_wh_invoice',$data);
	}
	
	function oldInvoiceChallan($invoice_id)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->delete('vendor_to_wh_invoice_challan_detail');
	}
	
	
	function getInvoiceInfo($invoice_id)
	{
		$this->db->select('*');
		$this->db->from('vendor_to_wh_invoice');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
	
	function getInvoiceChallnInfo($invoice_id)
	{
		$query = $this->db->order_by('id', 'ASC')->get_where('vendor_to_wh_invoice_challan_detail', array('invoice_id' => $invoice_id));
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	function getInvoiceProductInfo($invoice_id)
	{
		$this->db->select('*');
		$this->db->from('vendor_to_wh_product');
		$this->db->where(array('invoice_id' => $invoice_id));
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
	
	function updateVendorToWarehouseTransfer($data_update,$invoice_id,$product_id,$batch_id,$compCode)
	{
		$this->db->where('invoice_id', $invoice_id);
		$this->db->where('product_id', $product_id);
	   $this->db->where('batch_id', 0);
		$this->db->where('comp_code', $compCode);
		$this->db->update('vendor_to_wh_product',$data_update);
	}
	
	function returnInvoiceInsert($data){
		$this->db->insert('return_policy', $data);
	}
	
	function returnProductInsert($data1){
		$this->db->insert('return_policy_products', $data1);
	}
	
	
	function getAllReturnInvoice($invoice_number)
	{
		$this->db->select('*');
		$this->db->from('return_policy');
		$this->db->where('invoice_number',$invoice_number);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function getAllReturnProducts($return_number)
	{
		$this->db->select('*');
		$this->db->from('return_policy_products');
		$this->db->where('return_number',$return_number);
		$query = $this->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	
	function return_product_n_update_stock_in_warehouse_inventory($productID,$warehouse_id,$data2,$batchId,$compCode)
	{
		$this->db->where('product_id', $productID);
		$this->db->where('warehouse_id', $warehouse_id);
		$this->db->where('batch_id', 0);
		$this->db->where('comp_code', $compCode);
		$this->db->update('warehouse_inventory',$data2);
	}

	function filterWarehouseInventory($compCode, $warehouse, $product, $attribute) {
		$this->db->select('a.*');
		$this->db->from('warehouse_inventory as a');

		if($warehouse != '' && $product != '' && $attribute != '')
		{
			$this->db->select('c.product_id as pId');
			$this->db->join('product_attribute as c', 'c.product_id = a.master_product_id', 'LEFT');
			$this->db->where(['a.comp_code'=>$compCode, 'a.warehouse_id'=>$warehouse, 'a.master_product_id'=>$product, 'c.attribute_id'=>$attribute]);
		} else if($warehouse != '' && $product != '')
		{
			$this->db->where(['a.comp_code'=>$compCode, 'a.warehouse_id'=>$warehouse, 'a.master_product_id'=>$product]);
		}  else if($product != '')
		{
			$this->db->where(['a.comp_code'=>$compCode, 'a.master_product_id'=>$product]);
		} else if($warehouse != '')
		{
			$this->db->where(['a.comp_code'=>$compCode, 'a.warehouse_id'=>$warehouse]);
		} else if($attribute != '')
		{
			$this->db->select('a.*', 'c.product_id as sku');
			$this->db->join('product_attribute as c', 'c.product_id = a.master_product_id', 'LEFT');
			$this->db->where('c.attribute_id',$attribute);
			$this->db->where('a.comp_code',$compCode);
		} else { 
			$this->db->select('a.*', 'product.product_id as pId');
			$this->db->where('a.comp_code',$compCode);
			$this->db->join('product', 'product.product_id = a.master_product_id');
		}

		$this->db->where('a.master_product_id != ',0);
		$this->db->where('a.batch_id = ',0);
		$this->db->group_by('a.product_id');
		$this->db->order_by('a.id','DESC');

		$query = $this->db->get();
		/*echo $this->db->last_query();
		die;*/
		if($query->num_rows() > 0){
			return $query->result();
		}else{
		 	return false;
		}
	}
	
	function checkWarehouseName($str,$compCode) {
		$this->db->select('*');
		$this->db->from('warehouse');
		$this->db->where(['warehouse_name'=>$str,'comp_code'=>$compCode]);
		$query = $this->db->get();
		if($query->num_rows() > 0){
			return $query->row();
		}
	}

	function checkWarehouseNameOnEditCase($str,$warehouseId,$compCode) {
		$this->db->select('*');
		$this->db->from('warehouse');
		$this->db->where(['comp_code'=>$compCode,'warehouse_id !='=>$warehouseId,'warehouse_name'=>$str]);
		$query = $this->db->get();
		if($query->num_rows() > 0)
			return $query->row();
	}

	function batchInventory($pId, $batchId, $warehouseId, $comp_code) {
		$this->db->select('a.product_id as sku, a.stock_qty as qty, a.price as price, b.product_name as product_name, c.warehouse_name as warehouse_name');
		$this->db->from('warehouse_inventory as a');
		$this->db->join('product as b', 'b.product_id = a.master_product_id');
		$this->db->join('warehouse as c', 'c.warehouse_id = a.warehouse_id');
		//$this->db->join('product_batch as d', 'd.product_batch_id = a.batch_id');
		$this->db->where(['a.comp_code'=>$comp_code,'a.warehouse_id'=>$warehouseId, 'a.master_product_id'=>$pId,'a.batch_id'=>0]);

		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}


	function getBatchSkuQtyForAddStock($pId, $warehouseId, $batchId, $compCode) {
		$this->db->select('product_id as sku, stock_qty, price');
		$this->db->from('warehouse_inventory');
		$this->db->where(['warehouse_id'=>$warehouseId, 'comp_code'=>$compCode, 'master_product_id'=>$pId, 'batch_id'=>0]);
		$query = $this->db->get();
		//echo $this->db->last_query();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}


	function getBatchSkuQtyForEditInvoice($pId, $warehouseId, $batchId, $invoiceId, $compCode) {
		$this->db->select('product_id as sku, quantity as qty, price, expiry_date');
		$this->db->from('vendor_to_wh_product');
		$this->db->where(['warehouse_id'=>$warehouseId, 'comp_code'=>$compCode, 'master_product_id'=>$pId, 'batch_id'=>$batchId, 'invoice_id'=>$invoiceId]);
		$query = $this->db->get();
		/*echo $this->db->last_query();
		echo '<pre>';
		print_r($query->result_array());*/

		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}

}