<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageVendor extends CI_Controller {

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
			$this->load->model('managevendor_model');
			
			
		}
	public function index()
	{
		$data['title'] = 'Vendor | Inventory';
		$data['heading'] = 'View Vendor';
		$data['vendors']= $this->managevendor_model->getAllVendor();
		$this->load->view('manageVendor/viewVendor',$data);
	}
	
	// Add Vendor Account
	public function addVendor(){
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
				'city' => $this->input->post('city'),
				'address' => $this->input->post('address'),
				'zipcode' => $this->input->post('zipcode'),
				'contact_number' => implode(",",$contact_number),
				'mobile_number' => implode(",",$mobile_number),
				'firm_name' => $this->input->post('firm_name'),
				'tin_number' => $this->input->post('tin_number'),
				'create_date' => date("Y-m-d h:i:s"),
				'comp_code' => $uInfo['comp_code'],
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managevendor_model->addVendor($data);
			$last_inserted_id = $this->db->insert_id();
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'vendor','VENDOR',date("Y-m-d h:i:s"),'Added Vendor Successfully');
					}
			
			//bank details
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			$account_name = $this->input->post('account_name');
			$bank_name = $this->input->post('bank_name');
			for($i=0;$i<count($account_number);$i++){
			$data1 = array(
    			'vendor_id' => $last_inserted_id,
				'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'account_number' => $account_number[$i],
				'ifsc_code' => $ifsc_code[$i],
				'account_name' => $account_name[$i],
				'bank_name' => $bank_name[$i],
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managevendor_model->addVendorBankDetails($data1);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'vendor_bank_details','VENDOR',date("Y-m-d h:i:s"),'Added Vendor Bank Details Successfully');
					}
			}
    		$this->session->set_flashdata('success_msg','Vendor Created successfully ! ! !');
    		redirect(base_url().'webadmin/managevendor/viewVendor');
    	}
		$data['title'] = 'Vendor | Inventory';
		$data['heading'] = 'Add Vendor';
		$this->load->view('manageVendor/addVendor', $data);
	}
	
	// View Vendor List
	public function viewVendor(){
		global $uInfo;
		
		$data['vendors']= $this->managevendor_model->getAllVendor($uInfo['comp_code']);
		$data['title'] = 'Vendor | Inventory';
		$data['heading'] = 'Vendors';
		$this->load->view('manageVendor/viewVendor', $data);
	}
	
	
	public function addVendorPayment(){
		
		global $uInfo;

		if(isset($_POST['submit'])) {

			$existing_balance = get_vendore_existing_balance($this->input->post('vendor'));

			$paymentFor = $this->input->post('payment_for');
			if(isset($paymentFor) && $paymentFor != 0) {
				$invoiceId = $this->input->post('invoice_id');
			} else {
				$invoiceId = 0;
			}

	    $total_amt = $existing_balance-($this->input->post('amount'));
		
		$vendorAccontData = array(
				'vendor_user_id' => $this->input->post('vendor'),
				'payment_for' => $this->input->post('payment_for'),
				'invoice_id' => $invoiceId,
				'order_id'   => $invoiceId,
				'credit' => 0,
				'debit' => $this->input->post('amount'),
				'amount' => $this->input->post('amount'),
				'total_amount' =>$total_amt,
				'created' => date('Y-m-d'),
				'comp_code' => $uInfo['comp_code'],
				'comments' => $this->input->post('description')
			);
			
		$this->db->insert('vendor_account', $vendorAccontData);	
		
		$bank_balance = get_bank_existing_balance($uInfo['comp_code']);
		$cash_book_balance = get_cash_book_existing_balance($uInfo['comp_code']);
		 	
		$bank_balance_total_amt = $bank_balance-($this->input->post('amount'));
		$cash_book_balance_total_amt = $cash_book_balance-($this->input->post('amount'));
		
		
		if($this->input->post('bank_cash')=='bank') {
		
		$bank_acount_data = array(
			'payment_from_id' => 0,
			'payment_to_id' => $this->input->post('vendor'),
			'dealer_vender_other'   => 2,
			'mode_of_payment' => $this->input->post('mode_of_payment'),
			'transaction_id' => $this->input->post('transaction_id'),
			'amount' => $this->input->post('amount'),
			'debit' => $this->input->post('amount'),
			'credit' => 0,
			'created_date' => date('Y-m-d'),
			'total_balance' => $bank_balance_total_amt >= 0 ? $bank_balance_total_amt : 0,
			'comp_code' => $uInfo['comp_code'],
			'comments' => $this->input->post('description'),
			);
		$this->db->insert('bank_acount', $bank_acount_data);	
		}
		
		if($this->input->post('bank_cash')=='cash') {
		
		$bank_acount_data = array(
			'payment_from_id' => 0,
			'payment_to_id' => $this->input->post('vendor'),
			'dealer_vender_other'   => 2,
			'mode_of_payment' => $this->input->post('mode_of_payment'),
			'transaction_id' => $this->input->post('transaction_id'),
			'amount' => $this->input->post('amount'),
			'debit' => $this->input->post('amount'),
			'credit' => 0,
			'created_date' => date('Y-m-d'),
			'total_balance' => $cash_book_balance_total_amt >= 0 ? $cash_book_balance_total_amt : 0,
			'comments' => $this->input->post('description'),
			'comp_code' => $uInfo['comp_code'],
			);
		$this->db->insert('cash_book', $bank_acount_data);	
		}
			/* Close Insert into bank_balance OR cashbook Balance  */
			$this->session->set_flashdata('success_msg','Add Payment Successfully ! ! !');
			redirect('webadmin/managevendor/addVendorPayment');
		}

		$data['vendor']= $this->managevendor_model->getAllVendor($uInfo['comp_code']);
		$data['title'] = 'Vendor | Inventory';
		$data['heading'] = 'Vendor Payment';
		$this->load->view('manageVendor/addVendorPayment', $data);
	}

	// Update Vendor Info.
	public function editVendor($vendorID){
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
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managevendor_model->updateVendor($vendorID, $data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Updated Vendor Successfully');
					}
					
			$this->managevendor_model->oldVendorBankDetails($vendorID);
			//bank details
			$account_number = $this->input->post('account_number');
			$ifsc_code = $this->input->post('ifsc_code');
			$account_name = $this->input->post('account_name');
			$bank_name = $this->input->post('bank_name');
			for($i=0;$i<count($account_number);$i++){
			$data1 = array(
    			'vendor_id' => $vendorID,
				'user_ID' =>  $user_ID,
				'user_level' => $user_level,
				'account_number' => $account_number[$i],
				'ifsc_code' => $ifsc_code[$i],
				'account_name' => $account_name[$i],
				'bank_name' => $bank_name[$i],
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);
			$this->managevendor_model->addVendorBankDetails($data1);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'vendor_bank_details','VENDOR',date("Y-m-d h:i:s"),'Added Vendor Bank Details Successfully');
					}
			}
			
    		$this->session->set_flashdata('success_msg','Vendor Updated Successfully ! ! !');
    		redirect('webadmin/managevendor/viewVendor');
    	}
		$data['vendorInfo']=$this->managevendor_model->getVendorInfoByID($vendorID);
		$data['vendorBankInfo']=$this->managevendor_model->getVendorBankInfoByID($vendorID);
		$data['title'] = 'Vendor | Inventory';
		$data['heading'] = 'Edit Vendor';
		$this->load->view('manageVendor/editVendor',$data);
	}
	
	// Delete Users Account
	public function deleteVendor($vendorID){
	global $uInfo;
		$this->managevendor_model->deleteVendor($vendorID);
		$this->managevendor_model->oldVendorBankDetails($vendorID);
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Deleted Vendor Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Vendor Deleted Successfully ! ! !');
    	redirect('webadmin/managevendor/viewVendor');
	}
	
	
	// Change User Account Status
	public function changeVendorStatus(){
	global $uInfo;
		$vendorID=$this->input->get('vendor_id');
		$vendor_status=$this->input->get('vendor_status');
		$data = array(
    			'vendor_status' => $vendor_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->managevendor_model->changeVendorStatus($vendorID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_vendor_status',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Vendor Status Changed Successfully');
					}
	}
	
	public function onlyAlphaSpace($str) 
	{
		return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}
	
	// update Vendor Password
	public function changePassword(){
		global $uInfo;
       $vendorID = $this->uri->segment(4);
		
		if($this->form_validation->run('updateVendorPassword') == TRUE){
           
            $flag = $this->managevendor_model->changePassword($vendorID);
			//var_dump($flag);exit;
			if($flag) {
                $this->session->set_flashdata('success_msg','Vendor Password changed successfully ! ! !');
				
				//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_vendor_password',$uInfo['user_ID'],$vendorID,'vendor','VENDOR',date("Y-m-d h:i:s"),'Vendor Password changed');
					}     
                
				$to = $uInfo['user_email'];
				$subject = "Vendor Password changed";
				$txt = "Vendor Password changed successfully ! ! !";
				$headers = "From: ved.infowind@gmail.com" . "\r\n" .
				"CC: somebodyelse@example.com";
 
				mail($to,$subject,$txt,$headers);
				
				
				redirect('webadmin/managevendor/viewVendor');
            }
            else{
                $this->session->set_flashdata('error_msg','Current password is not match ! ! !');
                redirect('webadmin/managevendor/changePassword/'.$vendorID);
            }
        }
		
		$data['vendors']= $this->managevendor_model->getAllVendor($uInfo['comp_code']);
		$data['title'] = 'Vendor | Inventory';  
		$data['heading'] = 'Change Vendor Password';
		$this->load->view('manageVendor/updatePassword', $data);
	}
	
	public function checkEmailExist() 
	{
		$email = $this->input->post('email');
		$this->managevendor_model->checkEmailExist($email);
	}

	public function getInvoicesByVendorId() 
	{
		$vendorId = $this->input->get('vendorId');

		$getVendorInvoice = getSku('vendor_to_wh_invoice', ['vendor_id'=>$vendorId]);
		
		$res = '';
		$res .= '<select><option value="">Select Invoice</option>';
		if(!empty($getVendorInvoice)) {
			foreach($getVendorInvoice as $key=>$getVendorInvoices) {
				$res .= '<option value="'.$getVendorInvoices['invoice_id'].'">'.$getVendorInvoices['invoice_number'].'</option>';
			}
		}
		$res.='</select>';

		echo $res;
	}

	public function checkCashAmtExist() {
		global $uInfo;
		$amount = $this->input->get('amount');
		$cash_book_balance = get_cash_book_existing_balance($uInfo['comp_code']);
		
		if($amount >= $cash_book_balance) {
			echo '1';
		} else {
			echo '0';
		}
	}
	
}