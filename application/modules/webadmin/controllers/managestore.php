<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageStore extends CI_Controller {
	
	public function __construct(){		
		parent::__construct();
		
		header("cache-Control: no-store, no-cache, must-revalidate");
		header("cache-Control: post-check=0, pre-check=0", false);
		header("Pragma: no-cache");
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		
		global $uInfo;
		$this->load->library('email');
		$this->load->helper('file'); 
		$uInfo = $this->session->userdata('webadmin_session_info');
		
		if (!isset($uInfo) || empty($uInfo)) {
			redirect('webadmin/login');
		}
		$this->load->model('managestore_model');
	}
	public function index(){
		global $uInfo;
		$data['storeAllRecords'] = $this->managestore_model->getAllStore($uInfo['comp_code']);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Stores List';
		$this->load->view('manageStore/viewStores', $data);
	}
	// Add Store
	public function addStores(){
		global $uInfo;
		
		$config['upload_path']   = './uploads/store_logo/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	     = '10000';
		$config['max_width']     = '102400';
		$config['max_height']    = '76800';
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		
		if ($this->form_validation->run('addStores') == TRUE){

			
			if ( ! $this->upload->do_upload('store_logo')) {
				$data['error'] = $this->upload->display_errors();
				$store_logo = '';
			}else { 
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => 'uploads/store_logo/'.$upload_data['file_name'], 
							'new_image' => 'uploads/store_logo/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$store_logo = $upload_data['file_name'];
			}

			$getGstNumber = getSku('gst_number',['user_id'=>$uInfo['user_ID'],'state_id'=>$this->input->post('stateid')]);
			if(!empty($getGstNumber)) {
				$gstNumber = $getGstNumber[0]['gst_number_id'];
			} else {
				$gstNumber = '';
			}
			
			
			$data = array(
				'user_ID'           => $uInfo['user_ID'],
				'user_level'        => $uInfo['user_level'],
				'store_name'        => $this->input->post('store_name'),
				'store_code'        => $this->input->post('store_code'),
				'store_country_id' => $this->input->post('countryid'),
				'store_state_id'   => $this->input->post('stateid'),
				'store_city_id'    => $this->input->post('cityid'),
				'store_location_id' => $this->input->post('location'),
				'store_logo'        => $store_logo,
				'store_gst_number'  =>$gstNumber,
 				'store_status'      => '0',
				'create_date'       => date("Y-m-d h:i:s"),
				'comp_code' => $uInfo['comp_code'],
				'modified_date'     => date("Y-m-d h:i:s")
				);
			$this->managestore_model->storeInsert($data);
			
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'store','STORE',date("Y-m-d h:i:s"),'Added store successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Store Created successfuly ! ! !');
			redirect(base_url().'webadmin/managestore/viewStores');
		}		
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Add Store';
		$this->load->view('manageStore/addStores', $data);
	}
	public function viewStores(){
		global $uInfo;
		$comp_code = $uInfo['comp_code'];
		$data['storeAllRecords']= $this->managestore_model->getAllStore($comp_code);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Stores List';
		$this->load->view('manageStore/viewStores', $data);
	}
	// Change Store Status
	public function changeStatus(){
		global $uInfo;
		$store_id = $this->input->get('store_id');
		$store_status = $this->input->get('store_status');
		$data = array(
    			'store_status' => $store_status,
				'modified_date' => date("Y-m-d h:i:s")
    			);
		$this->managestore_model->changeStoreStatus($store_id, $data);
		
		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('change_status',$uInfo['user_ID'],$store_id,'store','STORE',date("Y-m-d h:i:s"),'Store status changed successfully.');
		}
		// End Entry for event logs
	}
	// Change HR Approval Status
	public function changeHrStatus(){
		global $uInfo;
		
		$store_id = $this->input->get('store_id');
		$approved_by_hr = $this->input->get('approved_by_hr');
		
		$confirm_result =$this->input->get('confirm_result');
		$getStoreId = $this->managestore_model->getStoreId($store_id);
		$user_ID = $getStoreId->user_ID;
		$getStoreId = $this->managestore_model->getUserMasterByUserId($user_ID);
		$user_email = $getStoreId->user_email;
		
		if($approved_by_hr==1 && $confirm_result==true){
			//$from = $uInfo['user_email'];
			$from = 'vipinmaru@infowindtech.com';
			$to = $user_email;
			$subject = "Hr Account Actived Notifiaction";
			$message = "Hr Account Actived !!";
			$successMsg = 'Hr Send Mail...!!!';
			$errorMsg = 'Hr Not Send Mail...!!!';
			sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
		}
		if($approved_by_hr==0 && $confirm_result==true){
			//$from = $uInfo['user_email'];
			$from = 'vipinmaru@infowindtech.com';
			$to = $user_email;
			$subject = "Hr Account Deactive Notifiaction";
			$message = "Hr Account Deactive !!";
			$successMsg = 'Hr Send Mail...!!!';
			$errorMsg = 'Hr Not Send Mail...!!!';
			sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
		}
		
		$data = array(
    			'approved_by_hr' => $approved_by_hr,
				'modified_date' => date("Y-m-d h:i:s")
    			);
		$this->managestore_model->changeHrStoreStatus($store_id, $data);
		
		
		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('change_hr_status',$uInfo['user_ID'],$store_id,'store','STORE',date("Y-m-d h:i:s"),'Store hr status changed successfully.');
		}
		// End Entry for event logs
	}
	// Delete Store
	public function deleteStore($store_id){
		global $uInfo;
		$res = $this->checkAssignStore($store_id);
		if($res){
		$this->session->set_flashdata('error_msg','Store can\'t delete because its assign to users.');
		redirect('webadmin/managestore/viewStores');
		}
		$this->managestore_model->deleteStore($store_id);
    	$this->session->set_flashdata('success_msg','Store Deleted Successfully ! ! !');
		redirect('webadmin/managestore/viewStores');
		
		// Entry for event logs
		if($this->db->affected_rows()==true){
			event_log('delete',$uInfo['user_ID'],$store_id,'store','STORE',date("Y-m-d h:i:s"),'Delete store successfully.');
		}
		// End Entry for event logs
	}
	
	function checkAssignStore($storeID)
	{
	  
	$query = $this->db->get_where('user_master', array('store_id' => $storeID));
		if($query->num_rows() > 0)
			return true;
		else
			return FALSE;
	}
	
	// Edit Store
	public function editStore($store_id){
		global $uInfo;
		$userId = $uInfo['user_ID'];
		
		$config['upload_path']   = './uploads/store_logo/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	     = '10000';
		$config['max_width']     = '102400';
		$config['max_height']    = '76800';
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		
		if ($this->form_validation->run('editStore') == TRUE){
			
			if ( ! $this->upload->do_upload('store_logo')) {
				$data['error'] = $this->upload->display_errors();
				$store_logo = $this->input->post('hdn_store_logo');
			}else { 
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => 'uploads/store_logo/'.$upload_data['file_name'], 
							'new_image' => 'uploads/store_logo/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$store_logo = $upload_data['file_name'];
			}


			$getGstNumber = getSku('gst_number',['user_id'=>$uInfo['user_ID'],'state_id'=>$this->input->post('stateid')]);
			$gstNumber = $getGstNumber[0]['gst_number_id'];

			
			//global $uInfo;
			$data = array(
				'store_name'        => $this->input->post('store_name'),
				'store_country_id' => $this->input->post('countryid'),
				'store_state_id'   => $this->input->post('stateid'),
				'store_city_id'    => $this->input->post('cityid'),
				'store_location_id' => $this->input->post('location'),
				'store_logo'        => $store_logo,
				'store_gst_number'  => (isset($gstNumber) ? $gstNumber : ''),
				'store_status'      => $this->input->post('store_status'),
				'modified_date'     => date("Y-m-d h:i:s")
				);
			$this->managestore_model->storeUpdate($store_id, $data);
			
			if($this->input->post('is_central') != '') {
				$dataupdate = ['store_id'=>$store_id];
				$userWhere = ['user_ID'=>$userId];
				updateData('user_master', $dataupdate, $userWhere);

				$uInfo = $this->session->userdata('webadmin_session_info');


				$data = array(
					'user_ID' => $uInfo['user_ID'],
					'user_role' => $uInfo['user_role'],
					'user_level' => $uInfo['user_level'],
					'user_full_name' => $uInfo['user_full_name'],
					'user_email' => $uInfo['user_email'],
					'store_id' => $store_id,
					'warehouse_id' => $uInfo['warehouse_id'],
					'user_last_login' => $uInfo['user_last_login'],
					'user_last_login_IP' => $uInfo['user_last_login_IP'],
					'store_manager' => $uInfo['store_manager'],
					'comp_code' => $uInfo['comp_code'],
					'created_by' => $uInfo['created_by'],
					'logged_in' => TRUE); 
					//print_r($data);exit;
				$this->session->set_userdata('webadmin_session_info', $data);
			}
			
			// Entry for event logs
			if($this->db->affected_rows()==true){
				event_log('update',$uInfo['user_ID'],$store_id,'store','STORE',date("Y-m-d h:i:s"),'Update store successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Store Updated successfuly ! ! !');
			redirect(base_url().'webadmin/managestore/viewStores');
		}		
		$data['storeInfo'] = $this->managestore_model->getStoreId($store_id);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Edit Store';
		$this->load->view('manageStore/editStore', $data);
	}
	// View Users List
	public function viewUserStores($store_id){
		$data['storeAllRecordsByUser'] = $this->managestore_model->getAllStoreByUser($store_id);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Stores User List';
		$this->load->view('manageStore/viewUserStores', $data);
	}
	// View Users List
	public function viewLocationStores($store_location_id){
		$data['storeAllRecordsByLocation'] = $this->managestore_model->getAllStoreByLocation($store_location_id);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Stores Location List';
		$this->load->view('manageStore/viewLocationStores', $data);
	}
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters atleast.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	public function getLocationByCity()
	{
		global $uInfo;
		$country_val = $this->input->post('country_val');
		$state_val = $this->input->post('state_val');
		$city_val = $this->input->post('city_val');
		$result = $this->managestore_model->getLocationByCity($country_val,$state_val,$city_val);
		return $result;
	}
	
	public function viewStoreToStoreInvoice(){
		$data['storeToStoreInvoiceAllRecords'] = $this->managestore_model->getAllStoreToStoreInvoice();
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List of Store To Store Invoice';
		$this->load->view('manageStore/viewStoreToStoreInvoice', $data);
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
	
	public function storeToStoreTransfer()
	{
		global $uInfo;
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			/* Start store to store invoice */
			$data = array(
							'user_ID'       => $uInfo['user_ID'],
							'user_level'    => $uInfo['user_level'],
							'store_from'    => $this->input->post('store_from'),
							'store_to'    	=> $this->input->post('store_to'),
							'status'        => $this->input->post('status'),
							'comments'      => $this->input->post('comments'),
							'ip_address'    => $this->input->ip_address(),
							'create_date'   => date("Y-m-d h:i:s"),
							'modified_date' => date("Y-m-d h:i:s")
						);
			$this->managestore_model->store_to_store_invoiceInsert($data);			
		
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('store_to_store_invoice_insert',$uInfo['user_ID'],$last_inserted_id,'store_to_store_invoice','STORE',date("Y-m-d h:i:s"),'Added store to store invoice successfully.');
			}
			// End Entry for event logs
			
			/* End Sotre to store invoice  */
			
			/* Start Store to store transfer */
			$quantity_val = $this->input->post('quantity');
			$quantity = array_filter($quantity_val);
			$stock_val = $this->input->post('stock_val');
			$product_id = $this->input->post('product_list');
			for($i=0;$i<count($product_id);$i++){
			$productID = $product_id[$i];
			$store_from_total_stock = $stock_val[$product_id[$i]];
			$transfer_quantity = $quantity[$product_id[$i]];
				$data1 = array(
					'invoice_id'  => $last_inserted_id,
					'store_from'  => $this->input->post('store_from'),
					'store_to'    => $this->input->post('store_to'),
					'product_id'  => $product_id[$i],
					'quantity' 	  => $quantity[$product_id[$i]],
					'modify_date' => date("Y-m-d h:i:s")
				);
				
				$this->managestore_model->storeToStoreTransfer($data1); 
				// Entry for event logs
				
				if($this->db->affected_rows()==true){
					event_log('store_to_store_transfer_product',$uInfo['user_ID'],$last_inserted_id,'store_to_store_transfer','STORE',date("Y-m-d h:i:s"),'Transfer Products from store to store successfully.');
				}
				// End Entry for event logs
				
			/* End Store to store transfer */
			
			/* Start Manage Store Inventory */
				$store_from    = $this->input->post('store_from');
				$store_to    = $this->input->post('store_to');
				
				//store_from ID and stock update in store Inventory 
				$store_from_update_stock_qty = $store_from_total_stock-$transfer_quantity;
				$data2 = array(
					'stock_qty'  => $store_from_update_stock_qty
				);
				$this->managestore_model->store_from_update_stock_in_store_inventory($productID,$store_from,$data2);
				
				/* Start store to central warehouse and central warehoue to Store */
				
				$getCentralWarehouseName = $this->managestore_model->getCentralWarehouseName();
				$centralWarehouseName = $getCentralWarehouseName->warehouse_name;
				
				$getStoreFromName = $this->managestore_model->getStoreNameByID($store_from);
				$StoreFromName = $getStoreFromName->store_name;
				
				$getStoreToName = $this->managestore_model->getStoreNameByID($store_to);
				$StoreToName = $getStoreToName->store_name;
				
				$getProductName = $this->managestore_model->getProductNameByID($productID);
				$productName = $getProductName->product_name;
				
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('store_to_central_wh_transfer_product',$uInfo['user_ID'],$store_from,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Transfer '.$transfer_quantity.' Qauntity of Product which name is '.$productName.' from '.$StoreFromName.' store to '.$centralWarehouseName.' central warehouse successfully.');
					}
					// End Entry for event logs
				
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('central_wh_to_store_transfer_product',$uInfo['user_ID'],$store_to,'warehouse_inventory','WAREHOUSE',date("Y-m-d h:i:s"),'Transfer '.$transfer_quantity.' Qauntity of Product which name is '.$productName.' from '.$centralWarehouseName.' central warehouse to '.$StoreToName.' store successfully.');
					}
					// End Entry for event logs
				
				/* End store to central warehouse and central warehoue to Store */
				
				//store_to ID and stock update in store Inventory 
				$store_to_total_stock = $this->managestore_model->checkStockStoreToId($productID,$store_to);
				if($store_to_total_stock!=0)
				{
					$store_to_update_stock_qty = $store_to_total_stock+$transfer_quantity;
					$data3 = array(
						'stock_qty'  => $store_to_update_stock_qty
					);
					$this->managestore_model->store_to_update_stock_in_store_inventory($productID,$store_to,$data3);
						// Entry for event logs
						if($this->db->affected_rows()==true){
							event_log('update_store_inventory',$uInfo['user_ID'],$productID,'store_inventory','STORE',date("Y-m-d h:i:s"),'Updated stock in store inventory successfully.');
						}
						// End Entry for event logs
				}
				else{
					$store_to_update_stock_qty = $transfer_quantity;
					$data3 = array( 
							'product_id'  => $productID,
							'store_id' 	  => $store_to,
							'stock_qty'   => $store_to_update_stock_qty,
							'modify_date' => date("Y-m-d h:i:s")
						);
					$this->managestore_model->store_to_insert_stock_in_store_inventory($data3);
					// Entry for event logs
						$last_inserted_id = $this->db->insert_id();
						if($this->db->affected_rows()==true){
							event_log('insert_store_inventory',$uInfo['user_ID'],$last_inserted_id,'store_inventory','STORE',date("Y-m-d h:i:s"),'Added stock in store inventory successfully.');
						}
						// End Entry for event logs
				}
			/* End Manage Store Inventory */
		}	
			$this->session->set_flashdata('success_msg', 'Transfer Products from Store to Store successfully !!!');
			redirect(base_url().'webadmin/managestore/viewStoreToStoreInvoice');
		}
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Store To Store Transfer';
		$this->load->view('manageStore/storeToStoreTransfer', $data);
	}
	
	public function viewStoreToStoreTransfer($invoice_id){
		$invoice_id = base64_decode($invoice_id);
		
		$data['storeToStoreTransferAllRecords'] = $this->managestore_model->getAllStoreToStoreTransfer($invoice_id);
		$data['title'] = 'Invoice | Inventory';
		$data['heading'] = 'List Store To Store Transfer';
		
		$this->load->view('manageStore/viewStoreToStoreTransfer', $data);
	}
	
	public function storeInventory(){
		global $uInfo;
		$data['storeInventoryInfo'] = $this->managestore_model->getstoreInventory($uInfo['comp_code']);
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Store Inventory';
		$this->load->view('manageStore/storeInventory', $data);
	}

	public function viewWarehouseToStoreReceive()
	{
		global $uInfo;
		$data['wareHouseToStoreInvoiceAllRecords'] = $this->managestore_model->getAllWareHouseToStoreInvoice($uInfo['comp_code']);
		
		$data['title'] = 'Receive | Inventory';
		$data['heading'] = 'List Warehouse To Store Receive';
		$this->load->view('manageStore/viewWarehouseToStoreReceive', $data);
	}
	
	public function storeToWhTransfer(){
		global $uInfo;
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST')
		{
			/* Start store to warehouse invoice */
			$data = array(
							'user_ID'       => $uInfo['user_ID'],
							'user_level'    => $uInfo['user_level'],
							'store_from'    => $this->input->post('store_from'),
							'warehouse_to' 	=> $this->input->post('warehouse_name'),
							'status'        => $this->input->post('status'),
							'comments'      => $this->input->post('comments'),
							'ip_address'    => $this->input->ip_address(),
							'create_date'   => date("Y-m-d h:i:s"),
							'modified_date' => date("Y-m-d h:i:s"),
							'comp_code' => $uInfo['comp_code']
						);
			$this->managestore_model->storeToWhInvoiceInsert($data);			
		
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('store_to_warehouse_invoice',$uInfo['user_ID'],$last_inserted_id,'store_to_warehouse_invoice','STORE',date("Y-m-d h:i:s"),'Added store to warehouse invoice successfully.');
			}
			// End Entry for event logs
			
			/* End Store to warehouse invoice  */
			
			/* Start Store to warehouse transfer */
			$quantity_val = $this->input->post('quantity');
			//$quantity = array_filter($quantity_val);
			$stock_val = $this->input->post('stock_val');
			$product_id = $this->input->post('product_list');
			$variationCheckbox = $this->input->post('variationCheckbox');
			$hidCheckVId = $this->input->post('hid_chk_pID');
			$price_val = $this->input->post('price');
			//$batches = $this->input->post('batches');

			for($i=0;$i<count($variationCheckbox);$i++) {
				$sku=$variationCheckbox[$i];
				$productId = $hidCheckVId[$sku];

				//$batchId = $batches[$productId];
				$price = $price_val[$sku];

				$arrayVariation=explode('-',$sku);

				$store_from_total_stock = $stock_val[$sku];
			    $transfer_quantity = $quantity_val[$sku];


				$data1 = ['invoice_id' => $last_inserted_id,
						  'store_from' => $this->input->post('store_from'),
						  'warehouse_to' => $this->input->post('warehouse_name'),
						  'product_id' => $sku,
						  'quantity' => $quantity_val[$sku],
						  'price' => $price,
						  'ip_address'    => $this->input->ip_address(),
						   'create_date'   => date("Y-m-d h:i:s"),
					 	  'modified_date' => date("Y-m-d h:i:s"),
					 	  'master_product_id' =>$productId,
					 	  'comp_code'=>$uInfo['comp_code']
					 	  //'batch_id'=>$batchId
					 	];

				$this->managestore_model->storeToWhTransferInsert($data1); 

				// Entry for event logs
				if($this->db->affected_rows()==true){
					event_log('store_to_warehouse_transfer',$uInfo['user_ID'],$last_inserted_id,'store_to_warehouse_transfer','STORE',date("Y-m-d h:i:s"),'Transfer Products from store to warehouse successfully.');
				}

				// End Entry for event logs

				/* End Store to warehouse transfer */

				/* Start Manage Store Inventory */
				$store_from   = $this->input->post('store_from');
				$warehouse_to = $this->input->post('warehouse_name');
				//echo $store_from_total_stock.'==>'.$transfer_quantity.'</br>';

				//store_from ID and stock update in store Inventory 
				$store_from_update_stock_qty = $store_from_total_stock-$transfer_quantity;

				$data2 = array(
					'stock_qty'  => ($store_from_update_stock_qty > 0) ? $store_from_update_stock_qty : 0,
					'price' => $price,
					'modify_date'  => date("Y-m-d h:i:s")
				);


				$this->managestore_model->store_from_update_stock_in_store_inventory($sku,$store_from,$data2,'',$uInfo['comp_code']);

				//warehouse_to ID and stock update in store Inventory 
				$warehouse_to_total_stock = $this->managestore_model->checkStockWareHouseToId($sku,$warehouse_to,'',$uInfo['comp_code']);

				if($warehouse_to_total_stock!=0){
					$warehouse_to_update_stock_qty = $warehouse_to_total_stock+$transfer_quantity;
					$data3 = array(
						'stock_qty'  => $warehouse_to_update_stock_qty,
						'price' => $price,
						'modify_date'  => date("Y-m-d h:i:s")
					);


					$this->managestore_model->warehouse_to_update_stock_in_warehouse_inventory($sku,$warehouse_to,$data3,'',$uInfo['comp_code']);
					// Entry for event logs
					if($this->db->affected_rows()==true){
						event_log('update_warehouse_inventory',$uInfo['user_ID'],$sku,'warehouse_inventory','STORE',date("Y-m-d h:i:s"),'Updated stock in warehouse inventory successfully.');
					}
					// End Entry for event logs
				} else {
					$warehouse_to_update_stock_qty = $transfer_quantity;
					$data3 = array( 
							'product_id'   => $sku,
							'warehouse_id' => $warehouse_to,
							'stock_qty'    => $warehouse_to_update_stock_qty,
							'price' => $price,
							'modify_date'  => date("Y-m-d h:i:s"),
							'master_product_id' =>$productId,
							'comp_code' => $uInfo['comp_code'],
							//'batch_id' => $batchId
						);

					$this->managestore_model->warehouse_to_insert_stock_in_warehouse_inventory($data3);
					// Entry for event logs
					$last_inserted_id = $this->db->insert_id();
					if($this->db->affected_rows()==true){
						event_log('insert_warehouse_inventory',$uInfo['user_ID'],$last_inserted_id,'warehouse_inventory','STORE',date("Y-m-d h:i:s"),'Added stock in warehouse inventory successfully.');
					}
					// End Entry for event logs
				}
			}

		
			$this->session->set_flashdata('success_msg', 'Transfer Products from Store to Warehouse successfully !!!');
			redirect(base_url().'webadmin/managestore/viewStoreToWhInvoice');
		}
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'Store To WareHouse Transfer';
		$this->load->view('manageStore/storeToWhTransfer', $data);
	}
	public function viewStoreToWhInvoice(){
		global $uInfo;
		$data['storeToWhInvoiceAllRecords'] = $this->managestore_model->getAllStoreToWhInvoice($uInfo['comp_code']);

		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'List Store To Warehouse Invoice';
		$this->load->view('manageStore/viewStoreToWhInvoice', $data);
	}
	public function viewStoreToWhTransfer($invoice_id){
		$invoice_id = base64_decode($invoice_id);
		
		$data['storeToWhTransferAllRecords'] = $this->managestore_model->getAllStoreToWhTransfer($invoice_id);
		
		$data['title'] = 'Store | Inventory';
		$data['heading'] = 'List Store To Warehouse Transfer';
		$this->load->view('manageStore/viewStoreToWhTransfer', $data);
	}
	
	
	public function warehouseToStoreReceive($invoice_id){
		global $uInfo;
		$invoice_id = base64_decode($invoice_id);
		if($this->form_validation->run('warehouseToStoreReceive')==TRUE)
		{
			$data1 = array(
							
							'status'        => $this->input->post('status'),
							'comments'      => $this->input->post('comments'),
							'modified_date' => date("Y-m-d h:i:s")
						);
						
			$this->managestore_model->warehouse_to_store_receive($data1,$invoice_id);			
		
			// Entry for event logs
			if($this->db->affected_rows()==true){
				event_log('warehouse_to_store_invoice_insert',$uInfo['user_ID'],$invoice_id,'warehouse_to_store_invoice','STORE',date("Y-m-d h:i:s"),'Added status and comment warehouse to store Receive successfully.');
			}
			// End Entry for event logs
			
			$this->session->set_flashdata('success_msg', 'Receive Products Entry made successfully !!!');
			redirect(base_url().'webadmin/managestore/viewWarehouseToStoreReceive');
		}
		$data['warehouseToStoreReceiveInfo'] = $this->managestore_model->getWarehouseToStoreReceiveInfo($invoice_id);
		$data['title'] = 'Store Receive | Inventory';
		$data['heading'] = 'WareHouse To Store Receive';
		$this->load->view('manageStore/warehouseToStoreReceive', $data);
	}

	public function checkUniqueStore($str) {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$result = $this->managestore_model->checkUniqueStore($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('checkUniqueStore', 'Already Store Name Created1.');
			return FALSE;
		} else {
			return TRUE;
		}	
	}


	public function checkStoreNameOnEditCase($str) {
		global $uInfo;
		$storeId = $this->uri->segment(4);
		$checkCurrent = $this->managestore_model->checkStoreNameOnEditCase($str,$storeId,$uInfo['comp_code']);
		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkStoreNameOnEditCase', 'Already Store Name Created2.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function checkStoreCode() {
		$code = $this->input->post('code');

		$checkCode=$this->managestore_model->checkStoreCode($code);
		if(!empty($checkCode)) {
			echo '1';
		} else {
			echo '0';
		}
	}


	public function getBatchSkuStoreQty() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$pId = $this->input->post('p_id');
		//$batchId = $this->input->post('batch_id');
		$storeId = $this->input->post('store_id');

		$skuQty = $this->managestore_model->batchStoreInventory($pId, '', $storeId, $compCode);


		$html = '';
		if(isset($skuQty) && !empty($skuQty)) {
			$html .= '<ul id="ul_sku_'.$pId.'">';
				foreach($skuQty as $skuQtys) {
					$sku = $skuQtys['sku'];
					$qty = $skuQtys['qty'];
					$price = $skuQtys['price'];
					$productName = $skuQtys['product_name'];
					$warehouseName = $skuQtys['store_name'];
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
		}  else {
			$html .= '<ul id="ul_sku_'.$pId.'">No Variation</ul>';
		}

		echo $html;
	}
	
}