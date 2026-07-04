<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managedealerdiscount extends CI_Controller {

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
			$this->load->model('managedealer_model');
		}
		
	public function index()
	{
		$data['title'] = 'Dealer | Descounts';
		$data['heading'] = 'View Dealer\'s Discount';
		$data['dealers']= $this->managedealer_model->getAllDealerDiscountOnproducts();
		$this->load->view('manageDealerDiscount/viewDealerDiscount',$data);
	}

	public function checkDealerPriceByMasterPId($dealerID,$product_id,$batchID=false)
    {
    	global $uInfo;
    	if($batchID != '') {
    		$where = array('master_product_id'=>$product_id,'dealer_id' => $dealerID, 'comp_code'=>$uInfo['comp_code']);
    	} else {
    		$where = array('master_product_id'=>$product_id,'dealer_id' => $dealerID, 'comp_code'=>$uInfo['comp_code']);
    	}

 		$query = $this->db->get_where('dealer_product_price', $where);

 	
		if($query->num_rows() > 0)
		{ 
			echo json_encode($query->result());
		} 
		else {
			return FALSE;
  		}
    }
	
	// Add Dealer Account
	public function addDiscount()
	{
	global $uInfo;

	if(($this->input->post('submit')) && ($this->input->post('submit')=="discount_form"))
	{
		$user_ID = $uInfo['user_ID'];
		$checkboxVal=$this->input->post('variationCheckbox');
		$dealerId=$this->input->post('dealer');
		$productId=$this->input->post('product');
		$quantity=$this->input->post('quantity');
		$type=$this->input->post('discount_type');
		$priceType=$this->input->post('price_type');
		$attributeFlag=$this->input->post('common_variation_flag');
		$variationPrice=$this->input->post('variation_price');
		//$batchId=$this->input->post('batch_'.$productId);

		$getProductInfo=getSku('product',['product_id'=>$productId]);
		
		//$productPrice=$getProductInfo[0]['product_price'];

		for($i=0;$i<count($checkboxVal);$i++) {

			$key=$checkboxVal[$i];

			$productPrice=$variationPrice[$key];

			$checkDealerDiscount=$this->managedealer_model->checkDealerPriceDis($dealerId, $key, '');

			
			if($priceType[$key]==1) {
				$disPrice = (($quantity[$key]*$productPrice)/100);
				//$priceType = '%';
				if($type[$key]==1) {
					$dealerOriginalPrice=$productPrice-$disPrice; // Orignial price for discount
				}

				if($type[$key]==2) {
					$dealerOriginalPrice=$productPrice+$disPrice; // Original price for add extra price in product price
				}
			}


			if($priceType[$key]==2) {
					$priceType = 'Fixed';
					if($type[$key]==1) {
						$dealerOriginalPrice=$productPrice-$quantity[$key]; // Orignial price for discount
					}

					if($type[$key]==2) {
						$dealerOriginalPrice=$productPrice+$quantity[$key]; // Original price for add extra price in product price
					}
				}

				
			$discount=getSku('dealer_product_price',['dealer_id'=>$dealerId,'master_product_id'=>$productId,'flag'=>0, 'batch_id'=>0]);

			if(!empty($discount)) {
				$updatedata=['flag'=>2];
				$updateWhere=['dealer_id'=>$dealerId,'master_product_id'=>$productId,'batch_id'=>0];
				$updateflag = updateData('dealer_product_price',$updatedata,$updateWhere);
			} 


			if($checkDealerDiscount>0) {
			
				$updateData=['price'=>$quantity[$key],
							'price_type'=>$priceType[$key],
							'type'=>$type[$key],
							'dealer_original_price'=>(isset($dealerOriginalPrice) ? $dealerOriginalPrice : ''),
							'modify_date'=>date('Y-m-d'),
							'flag'=>$attributeFlag];
				$where=['dealer_id'=>$dealerId,
						'product_id'=>$key,
						'comp_code' =>$uInfo['comp_code'],
						'master_product_id'=>$productId,
						'batch_id'=>0];

				$updateData=updateData('dealer_product_price',$updateData,$where);
				
				if($this->db->affected_rows()==true)
				{
				event_log('update',$uInfo['user_ID'],$updateData,'dealerDiscount','DEALER DISCOUNT',date("Y-m-d h:i:s"),'Dealer Discount Updated Successfully');
				}
			} else {
				
				$disData = array(
					'dealer_id'=>$dealerId,
					'product_id'=>$key,
					'price'=>(isset($quantity[$key]) ? $quantity[$key] : ''),
					'price_type'=>((isset($priceType[$key]) && $priceType[$key] == 1) ? $priceType[$key] : 2),
					'type'=>(isset($type[$key]) ? $type[$key] : ''),
					'dealer_original_price'=>(isset($dealerOriginalPrice) ? $dealerOriginalPrice : ''),
					'created_by'=>$user_ID,
					'comp_code' =>$uInfo['comp_code'],
					'created_date'=>date('Y-m-d'),
					'master_product_id'=>$productId,
					'flag'=>$attributeFlag,
					'batch_id'=>0
				);

				
				$this->db->insert('dealer_product_price',$disData);
				$last_inserted_id = $this->db->insert_id();

				if($this->db->affected_rows()==true)
				{
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'dealerDiscount','DEALER DISCOUNT',date("Y-m-d h:i:s"),'Dealer Discount Inerted Successfully');
				}
			}
		}

		$this->session->set_flashdata('success_msg','Update successfuly ! ! !');
		redirect(base_url().'webadmin/managedealerdiscount/viewDiscount');
	}

		$data['title'] = 'Dealer | Descounts';
			$data['heading'] = 'View Dealer\'s Discount';
		$data['dealers'] = $this->managedealer_model->getAllDealer($uInfo['comp_code']);
		$data['prodcuts'] = $this->managedealer_model->getAllProdcuts($uInfo['comp_code']);

		$this->load->view('manageDealerDiscount/addDiscount',$data);
	}

	function checkDisAddToProd()
	{
	global $uInfo;
	$user_ID = $uInfo['user_ID'];
	     $p_id = $this->input->get('p_id');
	     $dealer_id = $this->input->get('dealer_id');
		 $price = $this->input->get('price');
	   
	$res = $this->managedealer_model->checkDealerPriceDis($dealer_id,$p_id);
	if($res) {
		echo 'true';
	} else {
	
	$disData = array(
	'dealer_id'=>$dealer_id,
	'product_id'=>$p_id,
	'price'=>$price,
	'created_by'=>$user_ID,
	'comp_code' =>$uInfo['comp_code'],
	'created_date'=>date('Y-m-d')
	);
	$this->db->insert('dealer_product_price',$disData);
	echo "addedd";
	}
	
	
	}
	public function addDealer(){
		global $uInfo;
		$this->form_validation->set_message('onlyAlphaSpace', 'Only letters and spaces allow.');
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    		
			$user_ID = $uInfo['user_ID'];
			$user_level = $uInfo['user_level'];
			$contact_number = $this->input->post('contact_number');
			$mobile_number  = $this->input->post('mobile_number');
			
			$data = array(
    			'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'), 				
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => sha1($this->input->post('password')),
				'cpassword' => $this->input->post('cpassword'),
				'city' => $this->input->post('city'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
				'contact_number' => implode(",",$contact_number),
				'mobile_number' => implode(",",$mobile_number),
				'firm_name' => $this->input->post('firm_name'),
				'tin_number' => $this->input->post('tin_number'),

				'dealer_credit_limits' => $this->input->post('dealer_credit_limits'),
				'number_of_days' => $this->input->post('number_of_days'),
				'interest_rate' => $this->input->post('interest_rate'),
				'contact_person' => $this->input->post('contact_person'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				'account_close' => date("Y-m-d h:i:s"),
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managedealer_model->addDealer($data);
			$last_inserted_id = $this->db->insert_id();
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
					event_log('insert',$uInfo['user_ID'],$last_inserted_id,'dealer','DEALER',date("Y-m-d h:i:s"),'Added Dealer Successfully');
					}
			
			//bank details
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			$account_name = $this->input->post('account_name');
			$bank_name = $this->input->post('bank_name');
			for($i=0;$i<count($account_number);$i++){
			$data1 = array(
    			'dealer_id' => $last_inserted_id,
				'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'account_number' => $account_number[$i],
				'ifsc_code' => $ifsc_code[$i],
				'account_name' => $account_name[$i],
				'bank_name' => $bank_name[$i],
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managedealer_model->addDealerBankDetails($data1);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'dealer_bank_details','DEALER',date("Y-m-d h:i:s"),'Added Dealer Bank Details Successfully');
					}
			}
    		$this->session->set_flashdata('success_msg','Dealer Created successfuly ! ! !');
    		redirect(base_url().'webadmin/managedealer/viewDealer');
    	}
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'Add Dealer';
		$this->load->view('manageDealer/addDealer', $data);
	}
	
	public function dealerReport()
	{
	// View Dealer List
	
		global $uInfo;
		$data['dealers']= $this->managedealer_model->getAllDealer();
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'View Dealer\'s Payments';
		$this->load->view('manageDealer/dealerReport', $data);
	
	}
	
	public function dealerReportGetInvoice()
	{
	// View Dealer List
	$dealer_id = $_GET['dealer_id'];
	if(!empty($dealer_id)) {
		global $uInfo;
		$data['dealers']= $this->managedealer_model->getDealerInvoice($dealer_id);
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'View Dealer\'s Payments';
		$this->load->view('manageDealer/dealerReportGetInvoice', $data);
	} else {
	echo "Sorry Dealer is not selected correctly.";
	}
	}
	
	public function getInvoicesByDealerId()
	{
	// View Dealer List
	$dealer_id = $_GET['dealer_id'];
	if(!empty($dealer_id)) {
	global $uInfo;
	$invoices = $this->managedealer_model->getDealerInvoice($dealer_id);
	$html = '';
	$html .= '<option value="">Select</option>';
	if(!empty($invoices)) {
	foreach($invoices as $invoices) {
	$html .= '<option value="'.$invoices->id.'">'.$invoices->id.'/'.$invoices->title.'</option>';
		} 
		} else { $html .= '<option value="">No Invoices Found.</option>';  }
	echo $html;
	} else {
	echo "Sorry Dealer is not selected correctly.";
	}
	}
	
	public function viewDealerPayments()
	{
	    $data['dealersPayments']= $this->managedealer_model->getDealerPayments();
		$data['title'] = 'Dealer | Payments';
		$data['heading'] = 'Dealer Payment';
		$this->load->view('manageDealer/viewDealerPayments', $data);
	}
	public function addDealerPayment(){
		
		global $uInfo;
		if(isset($_POST['submit'])) {
		$data_array = array(
		'dealer_id' => $this->input->post('dealer'),
		'title' => $this->input->post('title'),
		'invoice_id' => 0,
		'amount' => $this->input->post('amount'),
		'debit' => 0,
		'credit' => 1,
		'description' => $this->input->post('description'),
		'date' => $this->input->post('date')
		);
		
		$this->db->insert('dealer_invoice',$data_array);
		
		$existing_balance = get_dealer_existing_balance($this->input->post('dealer'));
		$bank_balance = get_bank_existing_balance();
		$cash_book_balance = get_cash_book_existing_balance();
		 	
		$total_amt  =  $existing_balance+($this->input->post('amount'));
		$bank_balance_total_amt  =  $bank_balance+($this->input->post('amount'));
		$cash_book_balance_total_amt  =  $cash_book_balance+($this->input->post('amount'));
		
		
		
		$DealerAccontData = array(
			'dealer_user_id' => $this->input->post('dealer'),
			'invoice_id' => $this->input->post('invoice_id'),
			'order_id'   => $this->input->post('invoice_id'),
			'credit' => $this->input->post('amount'),
			'debit' => 0,
			'amount' => $this->input->post('amount'),
			'created' => date('Y-m-d'),
			'total_amount' =>$total_amt,
			'mode_of_payment' => $this->input->post('mode_of_payment'),
			'transaction_id' => $this->input->post('transaction_id'),
			'comments' => $this->input->post('description'),
			);
			
		/*  Insert into bank_balance OR cashbook Balance  */
		if($this->input->post('bank_cash')=='bank') {
		
		$bank_acount_data = array(
			'payment_from_id' => $this->input->post('dealer'),
			'payment_to_id' => 0,
			'dealer_vender_other'   => 1,
			'mode_of_payment' => $this->input->post('mode_of_payment'),
			'transaction_id' => $this->input->post('transaction_id'),
			'amount' => $this->input->post('amount'),
			'debit' =>0,
			'credit' =>$this->input->post('amount'),
			'created_date' => date('Y-m-d'),
			'total_balance' => $bank_balance_total_amt,
			'comments' => $this->input->post('description'),
			);
		$this->db->insert('bank_acount', $bank_acount_data);	
		}
		
		if($this->input->post('bank_cash')=='cash') {
		
		$bank_acount_data = array(
			'payment_from_id' => $this->input->post('dealer'),
			'payment_to_id' => 0,
			'dealer_vender_other'   => 1,
			'mode_of_payment' => $this->input->post('mode_of_payment'),
			'transaction_id' => $this->input->post('transaction_id'),
			'amount' => $this->input->post('amount'),
			'debit' =>0,
			'credit' =>$this->input->post('amount'),
			'created_date' => date('Y-m-d'),
			'total_balance' => $cash_book_balance_total_amt,
			'comments' => $this->input->post('description'),
			);
		$this->db->insert('cash_book', $bank_acount_data);	
		}
		
		/* close  Insert into bank_balance OR cashbook Balance  */	
			
		$this->db->insert('dealer_account', $DealerAccontData);	
		$this->session->set_flashdata('success_msg','Add Payment Successfully ! ! !');
		redirect('webadmin/managedealer/addDealerPayment');
		}
		$data['dealers']= $this->managedealer_model->getAllDealer();
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'Dealer Payment';
		$this->load->view('manageDealer/addDealerPayment', $data);
	}
	
	// View Dealer List
	public function viewDiscount(){
        global $uInfo;
		$data['title']   = 'Dealer | Discounts';
		$data['heading'] = 'View Dealer\'s Discount';
		$data['dealers'] = $this->managedealer_model->getAllDealerDiscountOnproducts($uInfo['comp_code']);
		
		$this->load->view('manageDealerDiscount/viewDealerDiscount',$data);
	}
	
	// Update Dealer Info.
	public function editDealer($dealerID){
	global $uInfo;
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    		
			$user_ID = $uInfo['user_ID'];
			$user_level = $uInfo['user_level'];
			$contact_number = $this->input->post('contact_number');
			$mobile_number = $this->input->post('mobile_number');
			
			$data = array(
    			'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'), 				
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'city' => $this->input->post('city'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
				'contact_number' => implode(",",$contact_number),
				'mobile_number' => implode(",",$mobile_number),
				'firm_name' => $this->input->post('firm_name'),
				'tin_number' => $this->input->post('tin_number'),
				
				'dealer_credit_limits' => $this->input->post('dealer_credit_limits'),
				'number_of_days' => $this->input->post('number_of_days'),
				'interest_rate' => $this->input->post('interest_rate'),
				'contact_person' => $this->input->post('contact_person'),
				'date_of_birth' => $this->input->post('date_of_birth'),
				
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managedealer_model->updateDealer($dealerID, $data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$dealerID,'dealer','DEALER',date("Y-m-d h:i:s"),'Updated Dealer Successfully');
					}
					
			$this->managedealer_model->oldDealerBankDetails($dealerID);
			//bank details
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			$account_name = $this->input->post('account_name');
			$bank_name = $this->input->post('bank_name');
			for($i=0;$i<count($account_number);$i++){
			$data1 = array(
    			'dealer_id' => $dealerID,
				'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'account_number' => $account_number[$i],
				'ifsc_code' => $ifsc_code[$i],
				'account_name' => $account_name[$i],
				'bank_name' => $bank_name[$i],
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managedealer_model->addDealerBankDetails($data1);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'dealer_bank_details','DEALER',date("Y-m-d h:i:s"),'Added Dealer Bank Details Successfully');
					}
			}
			
    		$this->session->set_flashdata('success_msg','Dealer Updated Successfully ! ! !');
    		redirect('webadmin/managedealer/viewDealer');
    	}
		$data['dealerInfo']=$this->managedealer_model->getDealerInfoByID($dealerID);
		$data['dealerBankInfo']=$this->managedealer_model->getDealerBankInfoByID($dealerID);
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'Edit Dealer';
		$this->load->view('manageDealer/editDealer',$data);
	}
	
	// Delete Users Account
	public function deleteDealer($dealerID){
	global $uInfo;
		$this->managedealer_model->deleteDealer($dealerID);
		$this->managedealer_model->oldDealerBankDetails($dealerID);
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$dealerID,'dealer','DEALER',date("Y-m-d h:i:s"),'Deleted Dealer Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Dealer Deleted Successfully ! ! !');
    	redirect('webadmin/managedealer/viewDealer');
	}
	
	
	// Change User Account Status
	public function changeDealerStatus(){
	global $uInfo;
		$dealerID=$this->input->get('dealer_id');
		$dealer_status=$this->input->get('dealer_status');
		$data = array(
    			'dealer_status' => $dealer_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->managedealer_model->changeDealerStatus($dealerID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_dealer_status',$uInfo['user_ID'],$dealerID,'dealer','DEALER',date("Y-m-d h:i:s"),'Dealer Status Changed Successfully');
					}
	}
	
	public function onlyAlphaSpace($str) 
	{
		return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}
	
	// update Dealer Password
	public function changePassword(){
	   global $uInfo;
       $dealerID = $this->uri->segment(4);
		
		if($this->form_validation->run('updateDealerPassword') == TRUE){
           
            $flag = $this->managedealer_model->changePassword($dealerID);
			//var_dump($flag);exit;
			if($flag) {
               $this->session->set_flashdata('success_msg','Dealer Password changed successfully ! ! !');
				
				//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_dealer_password',$uInfo['user_ID'],$dealerID,'dealer','DEALER',date("Y-m-d h:i:s"),'Dealer Password changed');
					}     
                
				$to = $uInfo['user_email'];
				$subject = "Dealer Password changed";
				$txt = "Dealer Password changed successfully ! ! !";
				$headers = "From: ved.infowind@gmail.com" . "\r\n" .
				"CC: somebodyelse@example.com";
 
				mail($to,$subject,$txt,$headers);
				
				
				redirect('webadmin/managedealer/viewDealer');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/managedealer/changePassword/'.$dealerID);
            }
        }
		
		$data['title'] = 'Dealer | Inventory';  
		$data['heading'] = 'Change Dealer Password';
		$this->load->view('manageDealer/updatePassword', $data);
	}
	
	public function checkEmailExist() 
	{
		$email = $this->input->post('email');
		$this->managedealer_model->checkEmailExist($email);
	}
	
	public function checkDiscountByBatch()
	{
		global $uInfo;
		$batchId = $this->input->post('batchId');
		$productId = $this->input->post('productId');
		$dealerId = $this->input->post('dealerId');

		$whereDiscount = ['batch_id'=>$batchId, 'master_product_id'=>$productId, 'dealer_id'=>$dealerId, 'comp_code'=>$uInfo['comp_code']];
		$select = 'id, product_id, price, price_type, type, dealer_original_price, master_product_id, flag, batch_id';
		$getDiscounts = getValue('dealer_product_price',$select,$whereDiscount);

		if(isset($getDiscounts) && !empty($getDiscounts)) {
			foreach($getDiscounts as $getDiscount) {
				$sku = $getDiscount['product_id'];
				$result[$sku] = ['sku'=>$sku,
								'price'=>$getDiscount['price'],
								'price_type'=>$getDiscount['price_type'],
								'type'=>$getDiscount['type'],
								'batch_id'=>$getDiscount['batch_id']];
			}
			echo json_encode($result);
		} else {
			return false;
		}
	}
}

