<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageWarehouse extends CI_Controller {

	public function __construct(){		
		parent::__construct();
		
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		
		global $uInfo;
		$this->load->library('email');
		$uInfo = $this->session->userdata('webadmin_session_info'); 
		
		if (!isset($uInfo) || empty($uInfo)) {
			redirect('webadmin/login');
		}
		$this->load->model(['managewarehouse_model','manageproduct_model']);
	}
	public function index(){
		$data['wareHouseAllRecords'] = $this->managewarehouse_model->getAllWarehouse();
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'WareHouse List';
		$this->load->view('manageWarehouse/viewWarehouse', $data);
	}
	// Add Store
	public function addWarehouse(){
		global $uInfo;
		
		if($this->form_validation->run('addWarehouse') == TRUE){
			
			$is_central = $this->input->post('is_central');
			if(isset($is_central) && !empty($is_central)){
				$data = array('is_central' => '0');
				$this->managewarehouse_model->warehouseIsCentralUpdate($data,$uInfo['comp_code']);
			}
			
			$data = array(
							'user_ID'           => $uInfo['user_ID'],
							'user_level'        => $uInfo['user_level'],
							'warehouse_name'    => $this->input->post('warehouse_name'),
							'warehouse_country' => $this->input->post('countryid'),
							'warehouse_state'   => $this->input->post('stateid'),
							'warehouse_city'    => $this->input->post('cityid'),
							'warehouse_zipcode' => $this->input->post('warehouse_zipcode'),
							'warehouse_phone'   => $this->input->post('warehouse_phone'),
							'warehouse_address' => $this->input->post('warehouse_address'),
							'is_central'        => $this->input->post('is_central'),
							'warehouse_status'  => '0',
							'comp_code'         => $uInfo['comp_code'],
							'create_date'       => date("Y-m-d h:i:s"),
							'modified_date'     => date("Y-m-d h:i:s")
						  );
			$this->managewarehouse_model->warehouseInsert($data);
			
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert_warehouse',$uInfo['user_ID'],$last_inserted_id,'warehouse','WAREHOUSE',date("Y-m-d h:i:s"),'Added warehouse successfully.');
			}
			// End Entry for event logs
						
			$this->session->set_flashdata('success_msg', 'Warehouse Created successfuly !!!');
			redirect(base_url().'webadmin/managewarehouse/viewWarehouse');
		}		
					  
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'Add WareHouse';
		$this->load->view('manageWarehouse/addWarehouse', $data);
	}
	public function viewWarehouse(){
	global $uInfo;
		$data['wareHouseAllRecords'] = $this->managewarehouse_model->getAllWarehouse($uInfo['comp_code']);
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'WareHouse List';
		$this->load->view('manageWarehouse/viewWarehouse', $data);
	}
	public function deleteWarehouse($warehouse_id){
		global $uInfo;
		$this->managewarehouse_model->deleteWarehouse($warehouse_id);
		
		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('delete_warehouse',$uInfo['user_ID'],$warehouse_id,'warehouse','WAREHOUSE',date("Y-m-d h:i:s"),'Delete warehouse successfully.');
		}
		// End Entry for event logs
		
    	$this->session->set_flashdata('success_msg','Warehouse Deleted Successfully!!!');
		redirect('webadmin/managewarehouse/viewWarehouse');
	}
	public function editWarehouse($warehouse_id){
		global $uInfo;
		
		$original_value = $this->input->post('hdn_warehouse_name');
		if($this->input->post('warehouse_name') != $original_value) {
			$warehouseName = $this->input->post('warehouse_name');
		  // $is_unique =  '|is_unique[warehouse.warehouse_name]';
		   $is_unique = $this->checkWarehouseNameOnEditCase($warehouseName);
		} else {
		   $is_unique =  '';
		}
		
		if($this->form_validation->run('editWarehouse')==TRUE && $this->form_validation->set_rules('warehouse_name', 'Warehouse Name', 'required|callback_lettersOnly_check|'.$is_unique)==TRUE){
			
		
			$is_central = $this->input->post('is_central');
			if(isset($is_central) && !empty($is_central)){
				$data = array('is_central' => '0');
				$this->managewarehouse_model->warehouseIsCentralUpdate($data,$uInfo['comp_code']);
			}
			
			$data = array(
							'warehouse_name'    => $this->input->post('warehouse_name'),
							'warehouse_country' => $this->input->post('countryid'),
							'warehouse_state'   => $this->input->post('stateid'),
							'warehouse_city'    => $this->input->post('cityid'),
							'warehouse_zipcode' => $this->input->post('warehouse_zipcode'),
							'warehouse_phone'   => $this->input->post('warehouse_phone'),
							'warehouse_address' => $this->input->post('warehouse_address'),
							'is_central'        => $this->input->post('is_central'),
							'modified_date'     => date("Y-m-d h:i:s")
						 );
			$this->managewarehouse_model->warehouseUpdate($warehouse_id, $data);
			
			// Entry for event logs
			if($this->db->affected_rows()==true){
				event_log('update_warehouse',$uInfo['user_ID'],$warehouse_id,'warehouse','WAREHOUSE',date("Y-m-d h:i:s"),'Update warehouse successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'WareHouse Updated successfully!!!');
			redirect(base_url().'webadmin/managewarehouse/viewWarehouse');
		}
		$data['warehouseInfo'] = $this->managewarehouse_model->getWarehouseId($warehouse_id);
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'Edit WareHouse';
		$this->load->view('manageWarehouse/editWarehouse', $data);
	}
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters only please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	public function phoneNumber_check($str) {
		if (! preg_match("/^[\+]?[(]?[0-9]{3}[)]?[-\s\.]?[0-9]{3}[-\s\.]?[0-9]{4,6}$/im", $str)) {
			$this->form_validation->set_message('phoneNumber_check', 'The %s field can only be phone number please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function warehouseInventory(){
		global $uInfo;
		$data['warehouseInventoryInfo'] = $this->managewarehouse_model->getWarehouseInventory($uInfo['comp_code']);
	
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'WareHouse Inventory';
		$this->load->view('manageWarehouse/warehouseInventory', $data);
	}	

	public function filterWarehouseInventory() {
		global $uInfo;
		$html = '';
	
			$warehouse = $this->input->post('warehouse');
			$product = $this->input->post('product');
			$attribute = $this->input->post('attribute');
			$warehouseInventoryInfo = $this->managewarehouse_model->filterWarehouseInventory($uInfo['comp_code'], $warehouse, $product, $attribute);

                 
                  $ctr = 1;
                  if (isset($warehouseInventoryInfo) && !empty($warehouseInventoryInfo)) {
                  
               $html .= '<div class="table-header tableThemeColor"> Results for Warehouse Inventory </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Warehouse Name</th>
                        <th>Product Name</th>
                        <th>Product Image</th>
                        <th>Product Description</th>
                        <th>SKU</th>
                        <th>Variation</th>
                        <th>Stock Qty</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody class="inventory_content">';
                        foreach ($warehouseInventoryInfo as $key => $warehouseInventoryInfos) {

                        	/*if(isset($warehouseInventoryInfos->batch_id) && $warehouseInventoryInfos->batch_id != 0) {
                        		$batchId = $warehouseInventoryInfos->batch_id;
                        		$batchNumber = batchNameByBatchId($batchId);
                        	} else {
                        		$batchNumber = '';
                        	}*/


                        	$where=['sku'=>$warehouseInventoryInfos->product_id];

                        	$getVariation=getSku('product_variations_relations',$where);
                            $arrayVariationId='';
                            foreach($getVariation as $getVariations) {
                              $arrayVariationId.=$getVariations['variation_id'].',';
                            }
                           
                            $variationIds = rtrim($arrayVariationId, ',');

                            $arrayVariationId=explode(',',$variationIds);
                            $variationName=getAllVariationNames($arrayVariationId);
                           //echo $productVariations['variation_ids'];
                            $allVariationName=[];
                            foreach($variationName as $variationNames) {
                              $allVariationName[]=$variationNames['attribute_value'];
                            }
                           
                            $mergeVariationName=implode(', ',$allVariationName);


                            $check=getStatus('product_variations_relations','flag',$where); 
                            if($check->flag == 1) {
                              $status ='Active';
                            } else {
                              $status = 'Inactive';
                            }


                        	$productId = $warehouseInventoryInfos->master_product_id;

                        	$getProductDetail = getProductDetail($productId, 'product_name,product_description,product_image');
                          
                          if(isset($getProductDetail) && !empty($getProductDetail)) {
                          	$productImage = $getProductDetail->product_image;
                          	if(isset($productImage)) {
                          		$url = base_url().'uploads/product_image/thumbs/'.$productImage;
                          	}
                          	$productName = $getProductDetail->product_name;
                          	$productDescription = $getProductDetail->product_description;
                          }
                        	
                        	$html .= '<tr>
                        <td class="center">'.$ctr.'</td>
                        <td>'.getWarehouseName($warehouseInventoryInfos->warehouse_id).'</td>
                        <td>'.(isset($productName) ? $productName : '').'</td>
                        <td>
                        <img width="100" height="100" src="'.(isset($url) ? $url : '').'" />
                        </td>
                        <td>'.(isset($productDescription) ? $productDescription : '').'</td>
                        <td>'.$warehouseInventoryInfos->product_id.'</td>
                        <td>'.$mergeVariationName.'</td>
                        <td class="stock_val_'.$warehouseInventoryInfos->product_id.'">
                              <p id="qty_val_'.$warehouseInventoryInfos->product_id.'">'.$warehouseInventoryInfos->stock_qty.'</p>

                           <div style="display:none" id="update_qty_'.$warehouseInventoryInfos->product_id.'">
                              <input id="quantity_'.$warehouseInventoryInfos->product_id.'" type="number" class="input_qty_val_'.$warehouseInventoryInfos->product_id.'"  value=""/>
                              <button class="btn btn-info buttonThemeColor update" id="'.$warehouseInventoryInfos->product_id.'" type="button">Update</button>
                           </div>
                           <div class="hidden-phone visible-desktop btn-group">
                            
                           </div>
                           <div class="hidden-desktop visible-phone">
                              <div class="inline position-relative">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog icon-only bigger-110"></i> </button>
                                 <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li> <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a> </li>
                                 </ul>
                              </div>
                           </div>
                        </td>
                        <td>'.$status.'</td>
                     </tr>';
                      $ctr++;
                        }
                  $html .= '</tbody>
               </table>';
               } else {
               	$html .= '<div class="table-header"><p>No Record Founds..!!!</p></div>';
               }
               echo $html;
		
	}
	
	public function changeStockQty()
	{
		global $uInfo;
		$stock_qty = $this->input->post('stock_qty');
		$product_id = $this->input->post("product_id");
		$data = array(
						'stock_qty' => $this->input->post('stock_qty')
					);
		$this->managewarehouse_model->changeStockQty($product_id,$stock_qty,$data);
				// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){

					event_log('changeStockQtyInWarehouseInventory',$uInfo['user_ID'],$product_id,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Change stock quantity in warehouse inventory successfully.');
				}
				// End Entry for event logs
	}
	
	public function viewWarehouseToStoreInvoice(){
	global $uInfo;
		$data['wareHouseToStoreInvoiceAllRecords'] = $this->managewarehouse_model->getAllWareHouseToStoreInvoice($uInfo['comp_code']);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Warehouse To Store Invoice';
		$this->load->view('manageWarehouse/viewWarehouseToStoreInvoice', $data);
	}
	
	public function warehouseToStoreTransfer(){
		global $uInfo;
		$comp_code = $uInfo['comp_code'];
		
		if($this->form_validation->run('warehouseToStoreTransfer')==TRUE)
		{
    		
			//for warehouse to store Invoice
				$data = array(
							'user_ID'       => $uInfo['user_ID'],
							'user_level'    => $uInfo['user_level'],
							'warehouse_id'     => $this->input->post('warehouse_name'),
							'store_id'    => $this->input->post('store_name'),
							'status'        => $this->input->post('status'),
							'comments'      => $this->input->post('comments'),
							'ip_address'    => $this->input->ip_address(),
							'create_date'   => date("Y-m-d h:i:s"),
							'comp_code'     => $uInfo['comp_code'],
							'modified_date' => date("Y-m-d h:i:s")
						);
				$this->managewarehouse_model->warehouse_to_store_invoiceInsert($data);			
			
				// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('warehouse_to_store_invoice_insert',$uInfo['user_ID'],$last_inserted_id,'warehouse_to_store_invoice','WAREHOUSE',date("Y-m-d h:i:s"),'Added invoice warehouse to store invoice successfully.');
				}
				// End Entry for event logs
				
			/* start store Inventory */
			
			$quantity_val = $this->input->post('quantity');
			
			$quantity = array_filter($quantity_val);
			$stock_val = $this->input->post('stock_val');
			$product_id = $this->input->post('product_list');
			$variationCheckbox = $this->input->post('variationCheckbox');
			$hidCheckVId = $this->input->post('hid_chk_pID');
			//$batches = $this->input->post('batches');
			$price_val = $this->input->post('price');

			for($i=0;$i<count($variationCheckbox);$i++) {
				
				$sku = $variationCheckbox[$i];
				$productId = $hidCheckVId[$sku];
				//$batchId = $batches[$productId];
				$price = $price_val[$sku];

				/*$getPId=explode('__',$sku);
				$productId=$getPId[0];*/

				$total_stock = $stock_val[$sku];
				$transfer_quantity = $quantity_val[$sku];
				$store_id = $this->input->post('store_name');
				$store_total_stock = $this->managewarehouse_model->checkStockStoreIventory($sku,$store_id,'',$comp_code);
				if($store_total_stock!=0)
				{
					$store_update_stock_qty = $store_total_stock+$transfer_quantity;
					$data1 = array(
						'stock_qty'  => $store_update_stock_qty,
						'price' => $price,
						'modify_date' => date("Y-m-d h:i:s")
					);
					$this->managewarehouse_model->store_stock_in_warehouse_inventory($sku,$store_id,'',$data1,$comp_code);

					// Entry for event logs
						if($this->db->affected_rows()==true){
							event_log('update_store_inventory',$uInfo['user_ID'],$sku,'store_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Updated stock in store inventory successfully.');
						}
					// End Entry for event logs
				} else {
					$store_update_stock_qty = $transfer_quantity;
					$data1 = array(
						'product_id' => $sku,
						'store_id' => $this->input->post('store_name'),
						'stock_qty' => (isset($quantity_val[$sku]) ? $quantity_val[$sku] : 0),
						'price' =>$price,
						'comp_code' => $uInfo['comp_code'],
						'modify_date' => date("Y-m-d h:i:s"),
						'master_product_id'=>$productId
						//'batch_id' => $batchId
						);
					$this->managewarehouse_model->insert_store_inventory($data1);
						
					// Entry for event logs
					$last_inserted_id1 = $this->db->insert_id();
					if($this->db->affected_rows()==true){
					event_log('insert_store_inventory',$uInfo['user_ID'],$last_inserted_id1,'store_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Added stock in store inventory successfully.');
					}
				}
					// End Entry for event logs

				//for warehouse to store Transfer
				$data = array(
					'invoice_id'    => $last_inserted_id,
					'warehouse_id'    => $this->input->post('warehouse_name'),
					'store_id'    => $this->input->post('store_name'),
					'product_id'  => $sku,
					'quantity' 	  => $quantity_val[$sku],
					'price' => $price,
					'modify_date' => date("Y-m-d h:i:s"),
					'comp_code' => $uInfo['comp_code'],
					'master_product_id' => $productId
					//'batch_id' => $batchId
				);
				
				$this->managewarehouse_model->warehouseToStoreTransfer($data);
				// Entry for event logs
				
				if($this->db->affected_rows()==true){
					event_log('wh_to_store_transfer_product',$uInfo['user_ID'],$last_inserted_id,'warehouse_to_store_transfer','WAREHOUSE',date("Y-m-d h:i:s"),'Transfer Products from warehouse to store successfully.');
				}
				// End Entry for event logs


				$update_stock_qty = $total_stock-$transfer_quantity;
				$warehouse_id    = $this->input->post('warehouse_name');
				$data1 = array(
					'stock_qty'  => ($update_stock_qty > 0) ? $update_stock_qty : 0,
					'price' => $price
				);
				$this->managewarehouse_model->update_stock_in_warehouse_inventory($sku,$warehouse_id,$data1,'',$comp_code);
				//}
			}

		
			$this->session->set_flashdata('success_msg', 'Transfer Products from WareHouse To Store successfully!!!');
			redirect(base_url().'webadmin/managewarehouse/viewWarehouseToStoreInvoice');
		}
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'WareHouse To Store Transfer';
		$this->load->view('manageWarehouse/warehouseToStoreTransfer', $data);
	}
	
	public function viewWarehouseToStoreTransfer($invoice_id){
		global $uInfo;
		$invoice_id = base64_decode($invoice_id);
		
		$data['warehouseToStoreTransferAllRecords'] = $this->managewarehouse_model->getAllWarehouseToStoreTransfer($invoice_id, $uInfo['comp_code']);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Warehouse To Store Transfer';
		$this->load->view('manageWarehouse/viewWarehouseToStoreTransfer', $data);
	}

	public function getStockQty(){
		$stock_qty = $this->input->post("stock_qty");
		
		$qty_val = $this->input->post("qty_val");
		if($qty_val<=$stock_qty)
		{
			echo "true";
		}
		else{
			echo "false";
		}
		
	}
	public function vendorToWarehouseTransfer(){
		global $uInfo;

			if($this->form_validation->run('vendorToWarehouseTransfer')==TRUE)
			{	

			//if($this->input->post('vendortowarehouse')){

				/*** vendor to warehouse invoice start ***/
				
				$data = array(
					'user_ID'        => $uInfo['user_ID'],
					'user_level'     => $uInfo['user_level'],
					'vendor_id'      => $this->input->post('vendor_name'),
					'invoice_number' => $this->input->post('invoice_number'),
					'invoice_date'   => date("Y-m-d",strtotime($this->input->post('invoice_date'))),
					'status'         => $this->input->post('status'),
					'comments'       => $this->input->post('comments'),
					'ip_address'     => $this->input->ip_address(),
					'create_date'    => date("Y-m-d h:i:s"),
					'modified_date'  => date("Y-m-d h:i:s"),
					'comp_code'      => $uInfo['comp_code'] 
				);
							
				$this->managewarehouse_model->invoiceInsert($data);
				$lastInvoiceId = $this->db->insert_id();

				
				$existing_balance =	get_vendore_existing_balance($this->input->post('vendor_name'));

				$total_amt  =  $existing_balance+($this->input->post('invoice_total_amount'));
				//Insert entry in vender account 
					$VendorAccontData = array(
							'vendor_user_id' => $this->input->post('vendor_name'),
							//'invoice_id' => $this->input->post('invoice_number'),
							'invoice_id' => $lastInvoiceId,
							'order_id'   => $this->input->post('invoice_number'),
							'credit' => $this->input->post('invoice_total_amount'),
							'debit' => 0,
							'amount' => $this->input->post('invoice_total_amount'),
							'total_amount' => $total_amt,
							'created' => date('Y-m-d'),
							'comments' => $this->input->post('comments'),
							'comp_code' => $uInfo['comp_code']
						);
						
				$this->db->insert('vendor_account', $VendorAccontData);
				
				// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('insert_vendor',$uInfo['user_ID'],$last_inserted_id,'warehouse_invoice','WAREHOUSE',date("Y-m-d h:i:s"),'Added warehouse invoice successfully.');
				}
				// End Entry for event logs
				
				/***************Start Challan Details***************************/
				$chalan_number = $this->input->post('chalan_number');
				$chalan_date = $this->input->post('chalan_date');
				for($i=0;$i<count($chalan_number);$i++){
				$data1 = array(
								'invoice_id'      => $lastInvoiceId,
								'challan_number' => $chalan_number[$i],
								'challan_date'   => $chalan_date[$i],
								'create_date'    => date("Y-m-d h:i:s"),
								'modify_date'  => date("Y-m-d h:i:s")
							);
							
				$this->managewarehouse_model->invoiceChallanInsert($data1);
					
				
				// Entry for event logs
				$last_inserted_id1 = $this->db->insert_id();
				
				if($this->db->affected_rows()==true){
					event_log('insert_challan_detail',$uInfo['user_ID'],$last_inserted_id1,'vendor_to_wh_invoice_challan_detail','WAREHOUSE',date("Y-m-d h:i:s"),'Added Challan invoice successfully.');
				}
				// End Entry for event logs
				}
				/**************************End Challan Details**********************************/
				
				/*** vendor to warehouse invoice end ***/
				
				$getWarehouseIsCentral = getWarehouseIsCentral($uInfo['comp_code']);
				if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
					$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
				}
			   
				
				$quantity_val = $this->input->post('quantity');
				$quantity = array_filter($quantity_val);

				$product_id = $this->input->post('product_list');
				$variationCheckbox = $this->input->post('variationCheckbox');

				$pIdAttr = $this->input->post('pid_attr');
				
				$expiry_date_val = $this->input->post('expiry_date');
			//	$batches = $this->input->post('batches');
				$price_val = $this->input->post('price');

				$expiry_date = array_filter($expiry_date_val);

				for($i=0;$i<count($variationCheckbox);$i++) {
					$sku = $variationCheckbox[$i];
					$masterPId = $pIdAttr[$sku];
					//$batchId = $batches[$masterPId];
					$price = $price_val[$sku];

					$getPId=explode('-',$variationCheckbox[$i]);
					$key=$variationCheckbox[$i];
					$insertArray=['invoice_id'=>$lastInvoiceId,
								'warehouse_id'=>$warehouse_is_central_id,
								'product_id'=>$variationCheckbox[$i],
								'quantity'=>$quantity_val[$key],
								'price'=>$price,
								'expiry_date'=>(isset($expiry_date_val[$key]) && $expiry_date_val[$key] != '') ? $expiry_date_val[$key] : '',
								'ip_address'=> $this->input->ip_address(),
								'create_date'   => date("Y-m-d h:i:s"),
								'modified_date' => date("Y-m-d h:i:s"),
								'comp_code'     => $uInfo['comp_code'],
								'master_product_id'=>$pIdAttr[$sku],
								//'batch_id' => $batchId
								];

					$this->managewarehouse_model->vendorToWarehouseTransfer($insertArray);

					// Entry for event logs
					$last_inserted_id1 = $this->db->insert_id();

					if($this->db->affected_rows()==true){
						event_log('vendor_to_wh_transfer_product',$uInfo['user_ID'],$last_inserted_id1,'vendor_to_wh_product','WAREHOUSE',date("Y-m-d h:i:s"),'Transfer Products from vendor to warehouse successfully.');
					}
					/*** vendor to warehouse product transfer end ***/


					/*** update stock in warehouse inventory start ***/
					$getStockByPidWidBid = getStockByPidWidBid($key, $warehouse_is_central_id, '', $uInfo['comp_code']);

					

					if(isset($getStockByPidWidBid) && !empty($getStockByPidWidBid)){
						
						$total_stock = $getStockByPidWidBid->stock_qty;
						
						$update_stock_qty = $total_stock+$quantity_val[$key];
						$data2 = array(
							'stock_qty'  => $update_stock_qty,
							'modify_date' => date("Y-m-d h:i:s")
						);

						$this->managewarehouse_model->update_stock_in_warehouse_inventory($key, $warehouse_is_central_id, $data2, '', $uInfo['comp_code']);
						
						// Entry for event logs
						if($this->db->affected_rows()==true){
							event_log('vendor_to_wh_product_update',$uInfo['user_ID'],$product_id[$i],'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Vendor to warehouse product update successfully.');
						}
						// End Entry for event logs

					} else {

						$data3 = array(
								'product_id'   => $variationCheckbox[$i],
								'warehouse_id' => $warehouse_is_central_id,
								'stock_qty'    => $quantity_val[$key],
								'price'=>$price,
								'modify_date'  => date("Y-m-d h:i:s"),
								'comp_code'    => $uInfo['comp_code'],
								'master_product_id'=> $product_id[0],
								//'batch_id' => $batchId
									);
						$this->managewarehouse_model->insert_stock_in_warehouse_inventory($data3);
						
						// Entry for event logs
						$last_inserted_id3 = $this->db->insert_id();
						if($this->db->affected_rows()==true){
							event_log('vendor_to_wh_product_insert',$uInfo['user_ID'],$last_inserted_id3,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Vendor to warehouse product insert successfully.');
						}
						// End Entry for event logs
					}

				}

				// for loop
				
				$this->session->set_flashdata('success_msg', 'Transfer Products from vendor to warehouse successfully!!!');
				redirect(base_url().'webadmin/managewarehouse/viewInvoice');
			}
		
		
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'Add Invoice';
		$this->load->view('manageWarehouse/vendorToWarehouseTransfer', $data);
	}

	public function viewInvoice(){
	
	global $uInfo;
		$data['wareHouseInvoiceAllRecords'] = $this->managewarehouse_model->getAllWarehouseInvoice($uInfo['comp_code']);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Vendor To Warehouse Invoice';
		$this->load->view('manageWarehouse/viewInvoice', $data);
	}
	
	public function viewVendorToWarehouseProduct($invoice_id){
		$invoice_id = base64_decode($invoice_id);
		
		$data['vendorToWHProductAllRecords'] = $this->managewarehouse_model->getAllVendorToWarehouseProduct($invoice_id);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Vendor To Warehouse Transfer'; 
		$this->load->view('manageWarehouse/vendorToWarehouseProduct', $data);
	}
	
	public function viewWarehouseToWarehouseInvoice(){
		global $uInfo;
		$data['wareHouseToWarehouseInvoiceAllRecords'] = $this->managewarehouse_model->getAllWareHouseToWarehouseInvoice($uInfo['comp_code']);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Warehouse To Warehouse Invoice';
		$this->load->view('manageWarehouse/viewWarehouseToWarehouseInvoice', $data);
	}
	
	public function warehouseToWarehouseTransfer(){
		global $uInfo;
		
		if($this->form_validation->run('warehouseToWarehouseTransfer')==TRUE)
		{
			
			$data = array(
							'user_ID'       => $uInfo['user_ID'],
							'user_level'    => $uInfo['user_level'],
							'warehouse_from'     => $this->input->post('warehouse_name'),
							'warehouse_to'    => $this->input->post('warehouse_to'),
							'comments'      => " ",
							'ip_address'    => $this->input->ip_address(),
							'create_date'   => date("Y-m-d h:i:s"),
							'comp_code'     => $uInfo['comp_code'],
							'modified_date' => date("Y-m-d h:i:s")
						);
			$this->managewarehouse_model->warehouse_to_warehouse_invoiceInsert($data);			
		
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('warehouse_to_warehouse_invoice_insert',$uInfo['user_ID'],$last_inserted_id,'warehouse_to_warehouse_invoice','WAREHOUSE',date("Y-m-d h:i:s"),'Added warehouse to warehouse invoice successfully.');
			}
			// End Entry for event logs
			
			$quantity_val = $this->input->post('quantity');
			$quantity = array_filter($quantity_val);
			$stock_val = $this->input->post('stock_val');
			$product_id = $this->input->post('product_list');
			$checkedVariation = $this->input->post('variationCheckbox');
			$hidChkPID = $this->input->post('hid_chk_pID');
			//$batches = $this->input->post('batches');
			$price_val = $this->input->post('price');

			for($i=0;$i<count($checkedVariation);$i++) {
				$key=$checkedVariation[$i];
				$productId = $hidChkPID[$key];
				//$batchId = $batches[$productId];
				$price = $price_val[$key];

				/*$getPId=explode('__',$checkedVariation[$i]);
				$productId=$getPId[0];*/

				$wh_from_total_stock = $stock_val[$key];
				$transfer_quantity = $quantity_val[$key];

				$data = array(
					'invoice_id' 	=> $last_inserted_id,
					'warehouse_from'    => $this->input->post('warehouse_name'),
					'warehouse_to'    => $this->input->post('warehouse_to'),
					'product_id'  => $key,
					'quantity' 	  => $quantity_val[$key],
					'comp_code'     => $uInfo['comp_code'],
 					'modify_date' => date("Y-m-d h:i:s"),
 					'master_product_id' => $productId
 					//'batch_id' => $batchId
				);
				
				$this->managewarehouse_model->warehouseToWarehouseTransfer($data); 
				// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('wh_to_wh_transfer_product',$uInfo['user_ID'],$last_inserted_id,'warehouse_to_warehouse_transfer','WAREHOUSE',date("Y-m-d h:i:s"),'Transfer Products from warehouse to warehouse successfully.');
				}
				// End Entry for event logs

				$warehouse_from    = $this->input->post('warehouse_name');
				$warehouse_to    = $this->input->post('warehouse_to');

				//warehouse_from ID and stock update in warehouse Inventory 
				$warehouse_from_update_stock_qty = $wh_from_total_stock-$transfer_quantity;
				$data1 = array(
					'stock_qty'  => ($warehouse_from_update_stock_qty > 0) ? $warehouse_from_update_stock_qty : 0,
					'price' => $price,
				);
				$this->managewarehouse_model->wh_from_update_stock_in_warehouse_inventory($key,$warehouse_from,$data1,$batchId);
				
				//warehouse_to ID and stock update in warehouse Inventory 
				$wh_to_total_stock = $this->managewarehouse_model->checkStockWarehouseToId($key,$warehouse_to,'');
				if($wh_to_total_stock!=0)
				{
					$warehouse_to_update_stock_qty = $wh_to_total_stock+$transfer_quantity;
					$data2 = array(
						'stock_qty'  => $warehouse_to_update_stock_qty,
						'price' => $price
					);
					$this->managewarehouse_model->wh_to_update_stock_in_warehouse_inventory($key,$warehouse_to,$data2,'');
					
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('wh_to_wh_product_update',$uInfo['user_ID'],$key,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Updated stock in warehouse inventory successfully.');
					}
					// End Entry for event logs
				} else {
					$warehouse_to_update_stock_qty = $transfer_quantity;
					$data2 = array(
							'product_id' => $key,
							'warehouse_id' => $warehouse_to,
							'stock_qty' => $warehouse_to_update_stock_qty,
							'price' => $price,
							'modify_date' => date("Y-m-d h:i:s"),
							'comp_code'  => $uInfo['comp_code'],
							'master_product_id' => $productId
							//'batch_id' => $batchId
						);
					$this->managewarehouse_model->wh_to_insert_stock_in_warehouse_inventory($data2);
					
					// Entry for event logs
					$last_inserted_id3 = $this->db->insert_id();
					if($this->db->affected_rows()==true){
						event_log('wh_to_wh_product_insert',$uInfo['user_ID'],$last_inserted_id3,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Added stock in warehouse inventory successfully.');
					}
					// End Entry for event logs
				}
			}
		
			$this->session->set_flashdata('success_msg', 'Transfer Products from warehouse to warehouse successfully !!!');
			redirect(base_url().'webadmin/managewarehouse/viewWarehouseToWarehouseInvoice');
		}
		$data['title'] = 'WareHouse | Inventory';
		$data['heading'] = 'WareHouse To WareHouse Transfer';
		$this->load->view('manageWarehouse/warehouseToWarehouseTransfer', $data);
	}
	
	public function viewWarehouseToWarehouseTransfer($invoice_id){
		global $uInfo;
		$invoice_id = base64_decode($invoice_id);
		
		$data['warehouseToWarehouseTransferAllRecords'] = $this->managewarehouse_model->getAllWarehouseToWarehouseTransfer($invoice_id, $uInfo['comp_code']);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Warehouse To Warehouse Transfer';
		$this->load->view('manageWarehouse/viewWarehouseToWarehouseTransfer', $data);
	}
	
	public function viewWarehouseToWarehouseReceive(){
		global $uInfo;
		$data['wareHouseToWarehouseInvoiceAllRecords'] = $this->managewarehouse_model->getAllWareHouseToWarehouseInvoice($uInfo['comp_code']);
		$data['title'] = 'Receive | Inventory';
		$data['heading'] = 'List Warehouse To Warehouse Receive';
		$this->load->view('manageWarehouse/viewWarehouseToWarehouseReceive', $data);
	}
	
	
	public function warehouseToWarehouseReceive($invoice_id){
		global $uInfo;
		$invoice_id = base64_decode($invoice_id);
		if($this->form_validation->run('warehouseToWarehouseReceive')==TRUE)
		{
			$data1 = array(
							'status'        => $this->input->post('status'),
							'comments'      => $this->input->post('comments'),
							'modified_date' => date("Y-m-d h:i:s")
						);
			$this->managewarehouse_model->warehouse_to_warehouse_receive($data1,$invoice_id);			
		
			// Entry for event logs
			if($this->db->affected_rows()==true){
				event_log('warehouse_to_warehouse_invoice_insert',$uInfo['user_ID'],$invoice_id,'warehouse_to_warehouse_invoice','WAREHOUSE',date("Y-m-d h:i:s"),'Added status and comment warehouse to warehouse Receive successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Receive Products Entry made successfully !!!');
			redirect(base_url().'webadmin/managewarehouse/viewWarehouseToWarehouseReceive');
		}
		$data['warehouseToWarehouseReceiveInfo'] = $this->managewarehouse_model->getWarehouseToWarehouseReceiveInfo($invoice_id);
		$data['title'] = 'WareHouse Receive | Inventory';
		$data['heading'] = 'WareHouse To WareHouse Receive';
		$this->load->view('manageWarehouse/warehouseToWarehouseReceive', $data);
	}
	
	
	public function editInvoice($invoice_id){
		global $uInfo;
		
		if($this->form_validation->run('editInvoice')==TRUE){

			
			$compCode = $this->input->post('comp_code');
			/*** vendor to warehouse invoice start ***/
			$data = array(
					'vendor_id'      => $this->input->post('vendor_name'),
					'invoice_number' => $this->input->post('invoice_number'),
					'invoice_date'   => date("Y-m-d",strtotime($this->input->post('invoice_date'))),
					'status'         => $this->input->post('status'),
					'comments'       => $this->input->post('comments'),
					'modified_date'  => date("Y-m-d h:i:s")
				);
						
			$this->managewarehouse_model->invoiceUpdate($invoice_id,$data);
				
			
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('Update_vendor_to_wh_invoice',$uInfo['user_ID'],$invoice_id,'warehouse_invoice','WAREHOUSE',date("Y-m-d h:i:s"),'Added warehouse invoice successfully.');
			}
			// End Entry for event logs
			
			/*** vendor to warehouse invoice end ***/
			
			
			/***************Start Challan Details***************************/
			$this->managewarehouse_model->oldInvoiceChallan($invoice_id);
			$chalan_number = $this->input->post('chalan_number');
			$chalan_date = $this->input->post('chalan_date');
			for($i=0;$i<count($chalan_number);$i++){
			$data_challan = array(
							'invoice_id'      => $invoice_id,
							'challan_number' => $chalan_number[$i],
							'challan_date'   => $chalan_date[$i],
							'create_date'    => date("Y-m-d h:i:s"),
							'modify_date'  => date("Y-m-d h:i:s")
						);
						
			$this->managewarehouse_model->invoiceChallanInsert($data_challan,$invoice_id);
				
			
			// Entry for event logs
			$last_inserted_id_new = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('Update_challan_detail',$uInfo['user_ID'],$last_inserted_id_new,'vendor_to_wh_invoice_challan_detail','WAREHOUSE',date("Y-m-d h:i:s"),'Updated Challan invoice successfully.');
			}
			// End Entry for event logs
			}
			/**************************End Challan Details**********************************/

			
			$getWarehouseIsCentral = getWarehouseIsCentral($compCode);
			if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
				$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
			}
		    
			
			$quantity_val = $this->input->post('quantity');
			$quantity = array_filter($quantity_val);

			$product_id = $this->input->post('product_list');
			
			$expiry_date_val = $this->input->post('expiry_date');
			$expiry_date = array_filter($expiry_date_val);

			$variationCheckbox = $this->input->post('variationCheckbox');
			//$batch_val = $this->input->post('batches');

			$price_val = $this->input->post('price');
			$product_id_val = $this->input->post('pId');

			for($i=0;$i<count($variationCheckbox);$i++) {
				$sku = $variationCheckbox[$i];
				$pIdval = $product_id_val[$sku];
				//$batchId = $batch_val[$pIdval];
				$price = $price_val[$sku];

				$arraySku=explode('-', $sku);
				/*** vendor to warehouse product transfer start ***/
				$data_update = array(
						'warehouse_id'  => $warehouse_is_central_id,
						'product_id'    => $sku,
						'quantity' 	    => $quantity_val[$sku],
						'price' => $price,
						'expiry_date' 	=> $expiry_date_val[$sku],
						'modified_date' => date("Y-m-d h:i:s"),
						'comp_code' => $uInfo['comp_code'],
						'master_product_id' => $pIdval
						//'batch_id' => $batchId
					);
				$getVendorToWarehouseTransfer = getVendorToWarehouseTransfer($invoice_id,$sku, '');

				if(isset($getVendorToWarehouseTransfer) && !empty($getVendorToWarehouseTransfer)){
					$this->managewarehouse_model->updateVendorToWarehouseTransfer($data_update,$invoice_id,$sku,'',$uInfo['comp_code']);
				} else {
					$data1=  array(	'invoice_id'    => $invoice_id,
								'warehouse_id'  => $warehouse_is_central_id,
								'product_id'    => $sku,
								'price' => $price,
								'quantity' 	    => $quantity_val[$sku],
								'expiry_date' 	=> $expiry_date_val[$sku],
								'ip_address'    => $this->input->ip_address(),
								'create_date'   => date("Y-m-d h:i:s"),
								'modified_date' => date("Y-m-d h:i:s"),
								'comp_code' => $uInfo['comp_code'],
								'master_product_id' =>$pIdval
								//'batch_id' => $batchId
								);
					$this->managewarehouse_model->vendorToWarehouseTransfer($data1);
				}

				// Entry for event logs
				$last_inserted_id1 = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('vendor_to_wh_transfer_product',$uInfo['user_ID'],$invoice_id,'vendor_to_wh_product','WAREHOUSE',date("Y-m-d h:i:s"),'Upadte Transfer Products from vendor to warehouse successfully.');
				}
				// End Entry for event logs
				
				/*** vendor to warehouse product transfer end ***/

				/*** update stock in warehouse inventory start ***/
				$getStockByProductAndWarehouseId = getStockByProductAndWarehouseId($sku, $warehouse_is_central_id,'',$uInfo['comp_code']);

				if(isset($getStockByProductAndWarehouseId) && !empty($getStockByProductAndWarehouseId)){
					$total_stock = $getStockByProductAndWarehouseId->stock_qty;
					
					$update_stock_qty = $total_stock+$quantity_val[$sku];
					$data2 = array(
						'stock_qty'  => $update_stock_qty,
						'price' => $price,
						'modify_date' => date("Y-m-d h:i:s"),
						'master_product_id' => $pIdval
						//'batch_id' => $batchId
					);
					$this->managewarehouse_model->update_stock_in_warehouse_inventory($sku, $warehouse_is_central_id, $data2, '', $uInfo['comp_code']);
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('update_stock_in_warehouse_inventory',$uInfo['user_ID'],$sku,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Vendor to warehouse product update successfully.');
					}
					// End Entry for event logs
				} else {
					$data3 = array(
									'product_id'   => $sku,
									'warehouse_id' => $warehouse_is_central_id,
									'stock_qty'    => $quantity_val[$sku],
									'price' => $price,
									'modify_date'  => date("Y-m-d h:i:s"),
									'comp_code' => $uInfo['comp_code'],
									'master_product_id' => $pIdval
									//'batch_id' => $batchId
								);
					$this->managewarehouse_model->insert_stock_in_warehouse_inventory($data3);
					
					// Entry for event logs
					$last_inserted_id3 = $this->db->insert_id();
					if($this->db->affected_rows()==true){
						event_log('insert_stock_in_warehouse_inventory',$uInfo['user_ID'],$last_inserted_id3,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Vendor to warehouse product updated successfully.');
					}
					// End Entry for event logs
				}
			}
				
				/*** update stock in warehouse inventory end ***/
				
			/*}*/ // for loop
			
		$this->session->set_flashdata('success_msg', 'Transfer Products from vendor to warehouse successfully!!!');
			redirect(base_url().'webadmin/managewarehouse/viewInvoice');
		}
		$data['invoice_id'] = $invoice_id;
		$data['invoiceInfo'] = $this->managewarehouse_model->getInvoiceInfo($invoice_id);
		$data['invoiceChallnInfo'] = $this->managewarehouse_model->getInvoiceChallnInfo($invoice_id);
		$data['invoiceProductInfo'] = $this->managewarehouse_model->getInvoiceProductInfo($invoice_id);

		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'Edit Invoice';

		$this->load->view('manageWarehouse/editInvoice', $data);
	}
	
	
	public function returnPolicy(){
		global $uInfo;
		date_default_timezone_set('Asia/Kolkata');

		if($this->input->post()){

			/*** vendor to warehouse invoice start ***/
			
			$return_number =date('dmYHis'); 
			$data = array(
							'return_number'  => $return_number,
							'invoice_number' => $this->input->post('invoice_number_val'),
							'vendor_id'      => $this->input->post('vendor_name'),
							'reason_for_return'  => $this->input->post('reason_for_return'),
							'create_date'    => date("Y-m-d h:i:s"),
							'modify_date'  => date("Y-m-d h:i:s"),
							'comp_code' => $uInfo['comp_code']
						);
						
			$last_inserted_id = $this->managewarehouse_model->returnInvoiceInsert($data);
			//print_r($data);echo $return_number;exit;	
			
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert_return_policy',$uInfo['user_ID'],$last_inserted_id,'return_policy','WAREHOUSE',date("Y-m-d h:i:s"),'Added Return Product invoice successfully.');
			}
			// End Entry for event logs
			
			/*** vendor to warehouse invoice end ***/
			
			$getWarehouseIsCentral = getWarehouseIsCentral($uInfo['comp_code']);
			if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
				$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
			}
		    
			
			$quantity_val = $this->input->post('quantity');
			$quantity = array_filter($quantity_val);

			//$product_id = $this->input->post('product_list');

			$product_id = $this->input->post('variationCheckbox');
			$pIdAttr = $this->input->post('pid_attr');
			$price_val = $this->input->post('price');
			//$batchId_val = $this->input->post('batch_id');
			
			for($i=0;$i<count($product_id);$i++){ 
				$sku = $product_id[$i];
				$price = $price_val[$sku];

				//$batchId = $batchId_val[$sku];

				/*** return policy products start ***/
				$data1 = array(
								'return_number' => $return_number,
								'invoice_number'=> $this->input->post('invoice_number_val'),
								'warehouse_id'  => $warehouse_is_central_id,
								'product_id'    => $product_id[$i],
								'quantity' 	    => $quantity[$product_id[$i]],
								'price' => $price,
								'create_date'   => date("Y-m-d h:i:s"),
								'modify_date' 	=> date("Y-m-d h:i:s"),
								'master_product_id' => $pIdAttr[$product_id[$i]],
								'comp_code' => $uInfo['comp_code']
								//'batch_id' => $batchId
							);
							
				$this->managewarehouse_model->returnProductInsert($data1);

				
				// Entry for event logs
				$last_inserted_id1 = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('return_policy_products',$uInfo['user_ID'],$last_inserted_id1,'return_policy_products','WAREHOUSE',date("Y-m-d h:i:s"),'Return Products from Warehouse Inventory successfully.');
				}
				// End Entry for event logs
				
				/*** return policy products end ***/



				/*** Update quantity by invoice number ***/
				$vendor_id = $this->input->post('vendor_name');
				$invoice_number = $this->input->post('invoice_number_val');
				$sku = $product_id[$i];
				$pId = $pIdAttr[$sku];

				//echo $vendor_id.'=='.$invoice_number.'=='.$sku.'=='.$pId.'</br>';

				$getInvoiceId = getSku('vendor_to_wh_invoice',['vendor_id'=>$vendor_id, 'invoice_number'=>$invoice_number, 'comp_code'=>$uInfo['comp_code']]);

				if(isset($getInvoiceId) && !empty($getInvoiceId)) {

					$invoice_id = $getInvoiceId[0]['invoice_id'];
					$getVendorToWarehouseTransfer = getVendorToWarehouseTransfer($invoice_id,$sku,'');

					if(isset($getVendorToWarehouseTransfer) && !empty($getVendorToWarehouseTransfer)){

						$qty = $getVendorToWarehouseTransfer->quantity;
						$totalQty = $qty-$quantity[$product_id[$i]];

						$data_update = [
							'product_id'    => $sku,
							'quantity' 	    => $totalQty,
							'price' => $price,
							'modified_date' => date("Y-m-d h:i:s"),
							'master_product_id' => $pId
						];

						$this->managewarehouse_model->updateVendorToWarehouseTransfer($data_update,$invoice_id,$sku,'',$uInfo['comp_code']);
					}
				}

				/*** Update quantity by invoice number ***/


				
				/*** update stock in warehouse inventory start ***/
				$getStockByProductAndWarehouseId = getStockByProductAndWarehouseId($product_id[$i], $warehouse_is_central_id, '', $uInfo['comp_code']);

				if(isset($getStockByProductAndWarehouseId) && !empty($getStockByProductAndWarehouseId)){
					$total_stock = $getStockByProductAndWarehouseId->stock_qty;
					
					$update_stock_qty = $total_stock-$quantity[$product_id[$i]];
					$data2 = array(
						'stock_qty'  => ($update_stock_qty > 0) ? $update_stock_qty : 0,
						'price' => $price,
						'modify_date' => date("Y-m-d h:i:s")
					);
					$this->managewarehouse_model->return_product_n_update_stock_in_warehouse_inventory($product_id[$i], $warehouse_is_central_id, $data2, '', $uInfo['comp_code']);
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('return_product_and_update_warehouse_inventory',$uInfo['user_ID'],$product_id[$i],'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Return Product and update warehouse inventory successfully.');
					}
					// End Entry for event logs
				}
				/*** update stock in warehouse inventory end ***/

				
			} // for loop
			
			$this->session->set_flashdata('success_msg', 'Return Products from Warehouse Inventory successfully!!!');
			redirect(base_url().'webadmin/managewarehouse/viewInvoice');
		} 
		
		$data['title'] = 'Return Policy | Inventory';
		$data['heading'] = 'Return Policy';
		$this->load->view('manageWarehouse/returnPolicy', $data);
	}
	
	public function viewReturnPolicy($invoice_number){
		$data['returnInvoicesInfo'] = $this->managewarehouse_model->getAllReturnInvoice($invoice_number);
		$data['title'] = 'Return Policy | Inventory';
		$data['heading'] = 'List of Return Invoices';
		$this->load->view('manageWarehouse/viewReturnPolicy', $data);
	}
	
	public function viewReturnProducts($return_number){
		$data['returnProductsInfo'] = $this->managewarehouse_model->getAllReturnProducts($return_number);
		$data['title'] = 'Return Policy | Inventory';
		$data['heading'] = 'List of Return Products';
		$this->load->view('manageWarehouse/viewReturnProducts', $data);
	}
	

	public function checkWarehouseName($str) {
		global $uInfo;
		$result = $this->managewarehouse_model->checkWarehouseName($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('checkWarehouseName', 'This Warehouse already exits.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}

	public function checkWarehouseNameOnEditCase($str) {
		global $uInfo;
		$warehouseId = $this->uri->segment(4);
		$checkCurrent = $this->managewarehouse_model->checkWarehouseNameOnEditCase($str,$warehouseId,$uInfo['comp_code']);

		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkWarehouseNameOnEditCase', 'This Warehouse already exits.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function getProductVariation() {
		$id=$this->input->get('product_id');
		$getAllVariation = $this->manageproduct_model->getAttrVariation($id);
		
		if(!empty($getAllVariation)) {
			return $getAllVariation;
		} else {
			return TRUE;
		}
	}

	public function checkProductTransferInStore() {
		$sku=$this->input->get('sku');
		$qty=$this->input->get('qty');
		$where=['product_id'=>$sku];
		$getProductTransfer = getSku('warehouse_to_store_transfer',$where);
		if(!empty($getProductTransfer)) {
			echo '1';
		} else {
			echo '0';
		}
	}

	public function chkInvoiceNumberExits() {
		$invoiceNumber=$this->input->get('invoiceNumber');

		$this->db->select('*');
		$this->db->from('vendor_to_wh_invoice');
		$this->db->where('invoice_number',$invoiceNumber);
		$getInvoice = $this->db->get();

		if($getInvoice->num_rows() > 0){
			echo '1';
		}else{
			echo '0';
		}
	}


	public function viewOpeningStock() {
		global $uInfo;
		$data['openingStocks'] = getSku('opening_stock', ['comp_code'=>$uInfo['comp_code']]);
		$data['title'] = 'View Opeing Stock | Inventory';
		$data['heading'] = 'View Opeing Stock';
		$this->load->view('manageWarehouse/viewOpeningStock', $data);
	}


	public function addOpeningStock() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		if($this->input->post('warehouseId')) {

			//$batchNumber = $this->input->post('batch_number');
			//$price = $this->input->post('price');
			$quantity = $this->input->post('quantity');
			$centralWarehouse = $this->input->post('warehouseId');
			//$expiryDate = $this->input->post('expiry_date');
			$productId = $this->input->post('product_list');
			$variationCheckbox = $this->input->post('variationCheckbox');
			$pIdAttribute = $this->input->post('pid_attr');
			//$batches = $this->input->post('batches');
			$priceVal = $this->input->post('price');

			//$expiry_date = $this->input->post('expiry_date');

			for($i=0; $i<count($variationCheckbox);$i++) {

				$sku = $variationCheckbox[$i];

				$materProductId = intval($pIdAttribute[$sku]);
				//$batchId = $batches[$materProductId];
				$price = $priceVal[$sku];
			//	$pBatchNumber = $batchNumber[$materProductId];

				$getWarehouseIsCentral = getWarehouseIsCentral($compCode);
				if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
					$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
				}

				//add variation price in variation table
					$whereVariation = ['product_id'=>$materProductId, 'sku'=>$sku];

					$updatePrice = ['variation_price'=>$price];

					$updateVariationPrice = updateData('product_variations_relations', $updatePrice, $whereVariation);
				//end variation price in variation table

				
				$result = ['sku'=>$variationCheckbox[$i],
						//'batch_number'=>$pBatchNumber,
						'quantity'=>$quantity[$sku],
						'price'=>$price,
						'warehouse_id'=>$this->input->post('warehouseId'),
						'comp_code'=>$compCode,
						'create_date'=>date('Y-m-d H:i:s'),
						'master_product_id'=>$materProductId,
						'comment'=>$this->input->post('comments')
						//'batch_id'=>$batchId
					];

				$this->db->insert('opening_stock', $result);


				$whereWInventory = ['product_id'=>$variationCheckbox[$i], 'master_product_id'=>$materProductId, 'warehouse_id'=>$centralWarehouse, 'comp_code'=>$compCode, 'batch_id'=>0];
				$getInventoryStock = getSku('warehouse_inventory',$whereWInventory);
				
				
				if(isset($getInventoryStock) && !empty($getInventoryStock)) {
					$stockQty = $getInventoryStock[0]['stock_qty'];
					$totalQty = $stockQty+$quantity[$sku];

					$updateqty = ['stock_qty'=>$totalQty];

					$updateStock = updateData('warehouse_inventory', $updateqty, $whereWInventory);
				} else {

					$insertStock = ['product_id'=>$variationCheckbox[$i],
							'warehouse_id'=>$centralWarehouse,
							'stock_qty'=>$quantity[$sku],
							'price'=>$price,
							'modify_date'=>date('Y-m-d H:i:s'),
							'comp_code'=>$compCode,
							'master_product_id'=>$materProductId
							//'batch_id'=>$batchId
						];

					commonInsert('warehouse_inventory',$insertStock);
				} 

			}

			$data['openingStocks'] = getSku('opening_stock', ['comp_code'=>$uInfo['comp_code']]);
			$data['title'] = 'View Opeing Stock | Inventory';
			$data['heading'] = 'View Opeing Stock';
			$this->load->view('manageWarehouse/viewOpeningStock', $data);
		} else {
			$data['title'] = 'Add Opening Stock | Inventory';
			$data['heading'] = 'Add Opening Stock';
			$this->load->view('manageWarehouse/addOpeningStock', $data);
		}
		
	}


	public function chkSkuExitsForStock() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$product_id = $this->input->post('product_id');
		$sku = $this->input->post('sku');
		$warehouse_id = $this->input->post('warehouse_id');

		$whereVendorewarehouse2 = ['master_product_id'=>$product_id, 'warehouse_id'=>$warehouse_id, 'comp_code'=>$compCode, 'product_id'=>$product_id];

		$productVariation2 = getSku('warehouse_inventory', $whereVendorewarehouse2);
		if(isset($productVariation2) && !empty($productVariation2)) {
			echo '1';
		} else {
			echo '0';
		}
	}


	public function getBatchSkuQty() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$pId = $this->input->post('p_id');
		//$batchId = $this->input->post('batch_id');
		$warehouseId = $this->input->post('warehouse_id');

		$skuQty = $this->managewarehouse_model->batchInventory($pId, '', $warehouseId, $compCode);


		$html = '';
		if(isset($skuQty) && !empty($skuQty)) {
			$html .= '<ul id="ul_sku_'.$pId.'">';
					foreach($skuQty as $skuQtys) {
						$sku = $skuQtys['sku'];
						$qty = $skuQtys['qty'];
						$price = $skuQtys['price'];
						$productName = $skuQtys['product_name'];
						$warehouseName = $skuQtys['warehouse_name'];
						//$batchNumber = $skuQtys['batch_number'];

						$html .= '<li>

							<input type="checkbox" id="variationchk_'.$sku.'" name="variationCheckbox[]" class="variationCheckbox" value="'.$sku.'" attrProductId="'.$pId.'" attrVariation="'.$sku.'" attrVariationRelation="">

							<input type="hidden" value="'.$pId.'" name="hid_chk_pID['.$sku.']" />

							<label>Variation: </label>
							<label>SKU: '.$sku.'</label>
							<label>Price: '.$price.'</label>

							<ul>
								<li>
									<div class="dv-in">
										<span>Stock</span>:
										<span id="stock_'.$sku.'" class="stock_cls" attrVal="'.$sku.'" style="color:red">
										'.$qty.'
										</span>
										<input value="'.$qty.'" type="hidden" id="stock_val" name="stock_val['.$sku.']" />

<ul id="quantity_'.$pId.'">
	<li>
		<span>Quantity</span>
			<span class="qty_keypress">

			<input class="quantity_input" id="quantity_keypress_'.$sku.'" type="text" attrSku="'.$sku.'" name="quantity['.$sku.']" value="" />
			<input type="hidden" class="price_hid_'.$sku.'" id="price_'.$sku.'" value="'.$price.'"  name="price['.$sku.']"/>

			</span> 

			<br>

			<span class="stock-help-inline" id="exceed_error_'.$sku.'"></span>
														   
			<span for="name" class="stock-help-inline quantity_val_error_'.$sku.'"> </span>
	</li>
</ul>
									</div>
								</li>
							</ul>
						</li>';
					}
				$html .= '</ul>';
		} else {
			$html .= '<ul id="ul_sku_'.$pId.'">No Variation</ul>';
		}
		echo $html;
	}


	public function getProductSkuByBatch() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$pId=$this->input->get('product_id');
		//$batchId=$this->input->get('batch_id');
		$warehouseId=$this->input->get('warehouse_id');
		//$sku=$this->input->get('sku');
		$getskuPrice = $this->manageproduct_model->getProductSkuByBatch($pId,'',$warehouseId,$compCode);

		if(!empty($getskuPrice)) {
			$res=[];
			foreach($getskuPrice as $getskuPrices) {
				$price = $getskuPrices->price;
				$sku = $getskuPrices->sku;
				$res[$sku] = $price;
			}
			echo json_encode($res);
		} else {
			return false;
		}
	}


	public function getBatchSkuQtyForAddStock() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$pId = $this->input->post('p_id');
		//$batchId = $this->input->post('batch_id');
		$warehouseId = $this->input->post('warehouse_id');
		$compCode = $uInfo['comp_code'];

		$inventoryDatas = $this->managewarehouse_model->getBatchSkuQtyForAddStock($pId, $warehouseId, '', $compCode);
		//echo $this->db->last_query();

		if(!empty($inventoryDatas)) {
			$res=[];
			foreach($inventoryDatas as $inventoryData) {
				$sku = $inventoryData['sku'];
				$res[$sku] = $inventoryData['price'];
			}
		}
		

		if(!empty($res)) {
			echo json_encode($res);
		} else {
			return false;
		}
	}


	public function getInfoBySkuBatchWarehouseId() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$pId = $this->input->post('product_id');
		$batchId = $this->input->post('batchId');
		$warehouseId = $this->input->post('warehouseId');
		$invoiceId = $this->input->post('invoice_id');


		$inventoryDatas = $this->managewarehouse_model->getBatchSkuQtyForEditInvoice($pId, $warehouseId, $batchId, $invoiceId, $compCode);

		if(!empty($inventoryDatas)) {
			$res=[];
			foreach($inventoryDatas as $inventoryData) {
				$sku = $inventoryData['sku'];

				$where=['product_id'=>$sku, 'batch_id'=>$batchId, 'comp_code'=>$compCode];
				$getProductTransfer = getSku('warehouse_to_store_transfer',$where);


				$res[$sku] = ['price'=>$inventoryData['price'],
							'qty'=>$inventoryData['qty'],
							'expiry_date'=>$inventoryData['expiry_date'],
							'checkStoreStatus'=>(isset($getProductTransfer) && !empty($getProductTransfer)) ? 1 : 0];
			}
		}


		if(!empty($res)) {
			echo json_encode($res);
		} else {
			return false;
		}
	}

}