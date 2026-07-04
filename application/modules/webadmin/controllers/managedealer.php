<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageDealer extends CI_Controller {

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
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'View Dealer';
		$data['dealers']= $this->managedealer_model->getAllDealer();
		$this->load->view('manageDealer/viewDealer',$data);
	}
	
	// Add Dealer Account
	public function addDealer(){
		global $uInfo;
		$this->form_validation->set_message('onlyAlphaSpace', 'Only letters and spaces allow.');
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    		
			$user_ID = $uInfo['user_ID'];
			$user_level = $uInfo['user_level'];
			$contact_number = $this->input->post('contact_number');
			$mobile_number = $this->input->post('mobile_number');
			
			$data = array(
    			'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'f_name' => $this->input->post('f_name'),
				'l_name' => $this->input->post('l_name'), 				
				'email' => $this->input->post('email'),
				'username' => $this->input->post('username'),
				'password' => sha1($this->input->post('password')),
				'cpassword' => $this->input->post('cpassword'),
				'country' => $this->input->post('countryid'),
				'state' => $this->input->post('stateid'),

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
				'comp_code' => $uInfo['comp_code'],
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
		$data['dealers']= $this->managedealer_model->getAllDealer($uInfo['comp_code']);
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
			'comp_code' => $uInfo['comp_code'],
			'date' => $this->input->post('date')
		);
		
		$this->db->insert('dealer_invoice',$data_array);
		
		$existing_balance = get_dealer_existing_balance($this->input->post('dealer'));
		$bank_balance = get_bank_existing_balance($uInfo['comp_code']);
		$cash_book_balance = get_cash_book_existing_balance($uInfo['comp_code']);
		 	
		$credit_amt = $this->input->post('amount');
		if($existing_balance != "" && ($credit_amt < $existing_balance)) 
		{
			$total_amt  =  $existing_balance - $credit_amt;
		}
		else if($existing_balance != "" && ($credit_amt > $existing_balance)) 
		{
			$total_amt  =  $existing_balance - $credit_amt;
		}
		else if($existing_balance != "" && ($credit_amt == $existing_balance)) 
		{
			$total_amt  =  $existing_balance - $credit_amt;
		}
		else{
			$total_amt  =  $existing_balance;
		}


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
			'comp_code' => $uInfo['comp_code'],
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
				'debit' => 0,
				'credit' => $this->input->post('amount'),
				'created_date' => date('Y-m-d'),
				'total_balance' => $bank_balance_total_amt >= 0 ? $bank_balance_total_amt : 0,
				'comments' => $this->input->post('description'),
				'comp_code' => $uInfo['comp_code'],
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
				'debit' => 0,
				'credit' => $this->input->post('amount'),
				'created_date' => date('Y-m-d'),
				'total_balance' => $cash_book_balance_total_amt >= 0 ? $cash_book_balance_total_amt : 0,
				'comments' => $this->input->post('description'),
				'comp_code' => $uInfo['comp_code'],
				);
			$this->db->insert('cash_book', $bank_acount_data);	
		}
		
		/* close  Insert into bank_balance OR cashbook Balance  */	
			
		$this->db->insert('dealer_account', $DealerAccontData);	
		$this->session->set_flashdata('success_msg','Add Payment Successfully ! ! !');
		redirect('webadmin/managedealer/addDealerPayment');
		}
		$data['dealers']= $this->managedealer_model->getAllDealer($uInfo['comp_code']);
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'Dealer Payment';
		$this->load->view('manageDealer/addDealerPayment', $data);
	}
	
	// View Dealer List
	public function viewDealer(){
		global $uInfo;
		$data['dealers'] = $this->managedealer_model->getAllDealer($uInfo['comp_code']);
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'View Dealer';
		$this->load->view('manageDealer/viewDealer', $data);
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
				'country' => $this->input->post('countryid'),
				'state' => $this->input->post('stateid'),

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


	public function addExpenses() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$checkExpenseExits = getSku('expense',['comp_code'=>$compCode]);

		if ($_SERVER['REQUEST_METHOD'] == 'POST'){

			$amount = $this->input->post('expense_amount');
			$bankCash = $this->input->post('bank_cash');
			$cheque_number = $this->input->post('cheque_number');

			if($bankCash == 1) { // For Bank
				$getTotalBalance = getSku('bank_acount',['comp_code'=>$compCode]);
				$lastArray = end($getTotalBalance);
			}

			// For Cash And Cheque Number
			if($bankCash == 2 || $this->input->post('cheque_number') != '') { 
				$getTotalBalance = getSku('cash_book',['comp_code'=>$compCode]);
				$lastArray = end($getTotalBalance);
			}

			$totalBalance = $lastArray['total_balance'] - $amount;

			if(empty($checkExpenseExits)) {

				$expenseData = [
					'payment_for'=>$this->input->post('payment_for'),
					'bank_cash'=>(isset($cheque_number) && $cheque_number != '') ? 0 : $bankCash,
					'cheque_number'=>$this->input->post('cheque_number'),
					'mode_of_payment'=>$this->input->post('mode_of_payment'),
					'credit'=>1,
					'amount'=>$this->input->post('expense_amount'),
					'total'=>$totalBalance,
					'date'=>$this->input->post('date'),
					'description'=>$this->input->post('description'),
					'comp_code'=>$compCode,
					'created_date'=>date('Y-m-d H:i:s')
				];

				$this->db->insert('expense', $expenseData);

				$this->session->set_flashdata('success_msg','Add Expense Amount Successfully ! ! !');
				redirect('webadmin/managedealer/addExpenses');

			} else {
				$updateData = [
					'payment_for'=>$this->input->post('payment_for'),
					'bank_cash'=>(isset($cheque_number) && $cheque_number != '') ? 0 : $bankCash,
					'cheque_number'=>$this->input->post('cheque_number'),
					'mode_of_payment'=>$this->input->post('mode_of_payment'),
					'credit'=>1,
					'amount'=>$this->input->post('expense_amount'),
					'total'=>$totalBalance,
					'date'=>$this->input->post('date'),
					'description'=>$this->input->post('description'),
					'modify_date'=>date('Y-m-d H:i:s')
				];

				$where = ['comp_code'=>$compCode];

				$updateExpense = updateData('expense',$updateData,$where);

				$this->session->set_flashdata('success_msg','Update Expense Amount Successfully ! ! !');
				redirect('webadmin/managedealer/addExpenses');
			}

		}

		if(!empty($checkExpenseExits)) {
			$expenseExits = $checkExpenseExits[0]['amount'];
		} else {
			$expenseExits = 0;
		}
		

		$data['expenses'] = $expenseExits;
		$data['dealers']= $this->managedealer_model->getAllDealer($uInfo['comp_code']);
		$data['title'] = 'Dealer | Inventory';
		$data['heading'] = 'Add Expenses';
		$this->load->view('manageDealer/addExpense',$data);
	}
		
}