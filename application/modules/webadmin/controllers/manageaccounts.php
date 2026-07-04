<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageAccounts extends CI_Controller {

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
			$this->load->model(['manageaccount_model','manageuserstoretransfer_model']);
			
		}
	public function index()
	{
		global $uInfo;
		$data['title'] = 'User | Inventory';
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$this->load->view('manageAccounts/viewUsers',$data);
	}
	
	// Add Users Account
	public function addUsers(){
		global $uInfo;
		$this->form_validation->set_message('is_unique',"This %s is already in use.");
		
		if ($this->form_validation->run('addUsers') == TRUE){
			$department_id = implode(",",$this->input->post('department'));
    		$role_data  =  explode("|",$this->input->post('role'));
			$user_role  =  $role_data[0];
			$user_level =  $role_data[1];

			$store_manager = $this->input->post('store_manager');
			

			$hr_aproval =  $this->getHrAprovalByRole($user_role); 

			$data = array(
    			'email' => $this->input->post('email'),
				'admin_full_name' => $this->input->post('admin_full_name'),
				'username'  =>  $this->input->post('username'),
				'password'  =>  sha1($this->input->post('password')),
				'user_role' => $user_role,
				'user_level' => $user_level,
				'location' => $this->input->post('location'),
				'department_id' => $department_id,
				'created_by' => $uInfo['user_role'],
				'comp_code' => $uInfo['comp_code'],
				'approved_by_hr' => $hr_aproval,
				'comp_status'=>1
    			);
				
			$this->manageaccount_model->addUsersAccount($data);
			$last_inserted_id = $this->db->insert_id();
			
			/*if(isset($store_manager) && !empty($store_manager)){
				$data = array('store_manager' => '0');
				$where = ['comp_code'=>$uInfo['comp_code'], 'store_id'=>$hdnStoreId, 'user_ID !=' => $last_inserted_id];
				$this->manageaccount_model->userStoreManagerUpdate($data,$where);
			}*/

			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$last_inserted_id,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Added User Successfully');
					}
			
    		$this->session->set_flashdata('success_msg','User Account Created successfuly ! ! !');
    		redirect(base_url().'webadmin/manageaccounts/viewUsers');
    	}
		$data['title'] = 'User | Inventory';
		$this->load->view('manageAccounts/addUsers', $data);
	}
	
	function getHrAprovalByRole($user_role)
	{
	     $query = $this->db->get_where('role', array('role_code' => $user_role));
		 $rows =  $query->result();
		 //echo '<pre>';print_r($rows);
		 if(isset($rows) && !empty($rows)) {
		 	 return $rows[0]->hr_approval_for_special_role; 
		 } else {
		 	return '0';
		 }
	}
	
	// View Users List
	public function viewUsers(){
		global $uInfo;
		
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$data['title'] = 'User | Inventory';
		$this->load->view('manageAccounts/viewUsers', $data);
	}
	
	// Update Users Info.
	public function editUsers($userID){
	global $uInfo;

		if ($this->form_validation->run('editUsers') == TRUE){

    		$role_data = explode("|",$this->input->post('role'));
			$user_role = $role_data[0];
			$user_level = $role_data[1]; 

			$hdnStoreId = $this->input->post('hdnStoreId');

			$store_manager = $this->input->post('store_manager');
			if(isset($store_manager) && !empty($store_manager)){
				$data = array('store_manager' => '0');
				$where = ['comp_code'=>$uInfo['comp_code'], 'store_id'=>$hdnStoreId];
				$this->manageaccount_model->userStoreManagerUpdate($data,$where);
			}
			
			/**** Store edit but hr approved "No(0)" ****/
			$storeId = $this->input->post('store');
		
			$hdnApprovedByHr = $this->input->post('hdnApprovedByHr');
			/* if($storeId==$hdnStoreId){
				$storeVal = $this->input->post('hdnStoreId');
				$ApprovedByHrVal = $this->input->post('hdnApprovedByHr');
			}else{
				$storeVal = $this->input->post('store');
				$ApprovedByHrVal = '0';
				
				//$from = $uInfo['user_email'];
				$from = 'vipinmaru@infowindtech.com';
				$to = $this->input->post('email');
				$subject = "User Store Transferr";
				$message = "User store transferr but hr approve status deactivated.";
				$successMsg = 'User Send Mail...!!!';
				$errorMsg = 'User Not Send Mail...!!!';
				sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
			}
			/**** End ****/
			
			$department_id = implode(",",$this->input->post('department'));
			$fullName = $this->input->post('admin_full_name');
			$pwd = $this->input->post('password');
			$email = $this->input->post('email');
			if($pwd != '') {
				$data = array(
    			'user_email' => $this->input->post('email'),
				'user_full_name' => $this->input->post('admin_full_name'),
				'user_name' => $this->input->post('username'),
				'user_role' => $user_role,
				'user_level' => $user_level,
				'user_last_modified'=>date("Y-m-d h:i:s"),
				'location' => $this->input->post('location'),
				'department_id' => $department_id,
				'approved_by_hr' => $hdnApprovedByHr,
				'store_manager' => $store_manager,
				'user_password' => sha1($this->input->post('password'))
    			);
			} else {
				$data = array(
    			'user_email' => $this->input->post('email'),
				'user_full_name' => $this->input->post('admin_full_name'),
				'user_name' => $this->input->post('username'),
				'user_role' => $user_role,
				'user_level' => $user_level,
				'user_last_modified'=>date("Y-m-d h:i:s"),
				'location' => $this->input->post('location'),
				'department_id' => $department_id,
				'approved_by_hr' => $hdnApprovedByHr,
				'store_manager' => $store_manager
    			);
			}
			
			
    		$this->manageaccount_model->updateAccount($userID, $data);
			

    		if($pwd != '') {
    			/* Send Mail To User */
		        $from = 'vipinmaru@infowindtech.com';
				$to = $email;
				$subject = "Password Changed By Company";
				$message = "Your Password Has Been Change By Company";
				$successMsg = 'Hi '.$fullName.' Your Password Has Been Change By Company. PassWord is '.$pwd.'';
				$errorMsg = 'Hr Not Send Mail...!!!';
				sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
				/* Send Mail To User */
    		}
    		

			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('update',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Updated User Successfully');
			}
			
    		$this->session->set_flashdata('success_msg','Account Updated Successfully ! ! !');
    		redirect('webadmin/manageaccounts/viewUsers');
    	}
		$data['userInfo']=$this->manageaccount_model->getAccountInfoByID($userID);
		/*echo '<pre>';
		print_r($data['userInfo']);
		die;*/
		$data['title'] = 'User | Inventory';
		$this->load->view('manageAccounts/editUsers',$data);
	}
	
	// Delete Users Account
	public function deleteUsers($userID){
	global $uInfo;
		$this->manageaccount_model->deleteUsersAccount($userID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Deleted User Successfully');
					}
		
    	$this->session->set_flashdata('success_msg','Account Deleted Successfully ! ! !');
    	redirect('webadmin/manageaccounts/viewUsers');
	}
	
	
	// Change User Account Status
	public function changeStatus(){
	global $uInfo;
		$userID=$this->input->get('acc_id');
		$status=$this->input->get('status');
		$data = array(
    			'user_account_status' => $status,
				'user_last_modified' => date("Y-m-d h:i:s")
    			);
		$this->manageaccount_model->changeAccountStatus($userID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_status',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Account Status Changed Successfully');
					}
	}
	
	// Change HR Approval Status
	public function changeHrStatus(){
		global $uInfo;
		$userID=$this->input->get('acc_id');
		$status=$this->input->get('status');
		$confirm_result =$this->input->get('confirm_result');
		$data['userInfo']=$this->manageaccount_model->getAccountInfoByID($userID);
		if($status==1 && $confirm_result==true)
		{
			//$from = $uInfo['user_email'];
			$from = 'vipinmaru@infowindtech.com';
			$to = $data['userInfo']->user_email;
			$subject = "Hr Account Actived Notifiaction";
			$message = "Hr Account Actived !!";
			$successMsg = 'Hr Send Mail...!!!';
			$errorMsg = 'Hr Not Send Mail...!!!';
			sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
		}
		if($status==0 && $confirm_result==true)
		{
			//$from = $uInfo['user_email'];
			$from = 'vipinmaru@infowindtech.com';
			$to = $data['userInfo']->user_email;
			$subject = "Hr Account Deactive Notifiaction";
			$message = "Hr Account Deactive !!";
			$successMsg = 'Hr Send Mail...!!!';
			$errorMsg = 'Hr Not Send Mail...!!!';
			sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
		}
		
		$data = array(
    			'approved_by_hr' => $status,
				'user_last_modified' => date("Y-m-d h:i:s")
    			);
		$this->manageaccount_model->changeHrAccountStatus($userID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_hr_status',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Account Approval Status Changed by HR Successfully');
					}
	}
	
	// View Users Account For Warehouse
	public function viewUsersForWarehouse(){
		global $uInfo;
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$data['title'] = 'Warehouse User | Inventory';
		$data['heading'] = 'Add Users For Warehouse';
		$this->load->view('manageAccounts/viewUsersForWarehouse', $data);
	}
	
	// Add Users Account For Warehouse
	public function addUsersForWarehouse($user_ID){
		global $uInfo;
		if ($this->form_validation->run('addUsersForWarehouse') == TRUE){
    		$data = array(
    			'warehouse_id' => $this->input->post('warehouse'),
				'user_last_modified' => date("Y-m-d h:i:s")
    			);
			$this->manageaccount_model->addUsersForWarehouse($user_ID,$data);
			
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('addUsersForWarehouse',$uInfo['user_ID'],$user_ID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Added User For Warehouse Successfully');
					}
			
    		$this->session->set_flashdata('success_msg','User Account For Warehouse Created successfuly ! ! !');
    		redirect(base_url().'webadmin/manageaccounts/viewUsersForWarehouse');
    	} 
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$data['title'] = 'Warehouse Users | Inventory';
		$data['heading'] = 'Add User For Warehouse';
		$this->load->view('manageAccounts/addUsersForWarehouse', $data);
	}
	
	// View Users Account For Store
	public function viewUsersForStore(){
		global $uInfo;
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$data['title'] = 'Store User | Inventory';
		$data['heading'] = 'Add Users For Store';
		$this->load->view('manageAccounts/viewUsersForStore', $data);
	}
	
	// Add Users Account For Store
	public function addUsersForStore($user_ID){
	global $uInfo;
		if ($this->form_validation->run('addUsersForStore') == TRUE){
    		$data = array(
    			'store_id' => $this->input->post('store'),
				'user_last_modified' => date("Y-m-d h:i:s")
    			);
			$this->manageaccount_model->addUsersForStore($user_ID,$data);
			
			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('addUsersForStore',$uInfo['user_ID'],$user_ID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Added User For Store Successfully');
			}
			
    		$this->session->set_flashdata('success_msg','User Account For Store Created successfuly ! ! !');
    	
    		redirect(base_url().'webadmin/manageaccounts/viewUsersForStore');
    	} 
		$data['user_accounts']= $this->manageaccount_model->getAllAccount($uInfo['comp_code']);
		$data['title'] = 'Store Users | Inventory';
		$data['heading'] = 'Add User For Store';
		$this->load->view('manageAccounts/addUsersForStore', $data);
	}
	
	// transfer store user
	public function editUsersForStore($userID){
	global $uInfo;
	$compCode = $uInfo['comp_code'];

		if ($_POST){
		
			$roleHrApproval = $this->input->post('role_hr_approval');
			//if($roleHrApproval == 1) {
				/**** Store edit but hr approved "No(0)" ****/
				$storeId = $this->input->post('store');
				$hdnStoreId = $this->input->post('hdnStoreId');
				$hdnApprovedByHr = $this->input->post('hdnApprovedByHr');

				if($storeId==$hdnStoreId){ 
					$storeVal = $hdnStoreId;
					$ApprovedByHrVal = $hdnApprovedByHr;
				} elseif($hdnStoreId == 0) { 
					$storeVal = $storeId;
					$ApprovedByHrVal = '0';
				} else{
					$storeVal = $this->input->post('store');
					$ApprovedByHrVal = '0';
					
					//$from = $uInfo['user_email'];
					$from = 'vipinmaru@infowindtech.com';
					$to = 	$this->input->post('email');
					$subject = "User Store Transfer";
					$message = "User store transfer but hr approve status deactivated.";
					$successMsg = 'User Send Mail...!!!';
					$errorMsg = 'User Not Send Mail...!!!';
					sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
				}

				//echo '<pre>';print_r($storeVal);
				//echo '<pre>';print_r($ApprovedByHrVal);die;
				/**** End ****/
				
				$data = array(
	    			'store_id' => $storeVal,
					'approved_by_hr' => $ApprovedByHrVal,
					'user_last_modified' => date("Y-m-d h:i:s")
	    			);
	    		$this->manageaccount_model->updateUsersForStore($userID, $data);

	    		$transferData = ['comp_code'=>$uInfo['comp_code'],
    							'store_from'=>$this->input->post('hdnStoreId'),
	    						'store_to'=>$this->input->post('newStoreId'),
	    						'user_id'=>$userID,
	    						'trasfer_by_user_id'=>$uInfo['user_ID'],
	    						'created_date'=>date("Y-m-d h:i:s")
	    						];
	    		$where = ['comp_code'=>$uInfo['comp_code'],'trasfer_by_user_id'=>$uInfo['user_ID'],'user_id'=>$userID];
	    		
	    		$getUserTransfer = $this->manageuserstoretransfer_model->getUserTransfer($where);
	    		if(!empty($getUserTransfer)) {
	    			$updateData = ['store_from'=>$this->input->post('hdnStoreId'),
	    						'store_to'=>$this->input->post('newStoreId'),
	    						'modify_date'=>date("Y-m-d h:i:s")];
	    			$res = $this->manageuserstoretransfer_model->updateUserTransferToStore($updateData,$where);
	    		} else {
	    			$res = $this->manageuserstoretransfer_model->insertUserTransferToStore($transferData);
	    		}
				
				//Entry for event logs
				if($this->db->affected_rows()==true)
				{
					event_log('updateUsersForStore',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Updated User For Store Successfully');
				}

				$storewhere = ['user_id'=>$userID];
				$storeData = ['hr_approval'=>0];
				$this->manageaccount_model->updateStoreToSToreTransfer($storewhere,$storeData);
				
	    		$this->session->set_flashdata('success_msg','Store User Transfer but wait until HR approval. ! ! !');
	    		redirect('webadmin/manageaccounts/viewUsers');
			/*} else {
				$data['roleHrApproval'] = 'Do not have Hr Permission !!';
			}*/
    	}

		$data['userInfo']=$this->manageaccount_model->getAccountInfoByID($userID);
		//$data['userInfo']=$this->manageaccount_model->getUserAccountInfoById($userID,$compCode);
		$data['title'] = 'Store Users | Inventory';
		$data['heading'] = 'Edit User For Store';
		$this->load->view('manageAccounts/editUsersForStore',$data);
	}
	
	// transfer store user
	public function editUsersForWarehouse($userID){
	global $uInfo;
		if ($this->form_validation->run('editUsersForWarehouse') == TRUE){
    		
	    		$roleHrApproval = $this->input->post('role_hr_approval');
	    		//if($roleHrApproval == 1) {
	    			/**** Store edit but hr approved "No(0)" ****/
				$warehouseId = $this->input->post('warehouse');
				$hdnWarehouseId = $this->input->post('hdnWarehouseId');
				$hdnApprovedByHr = $this->input->post('hdnApprovedByHr');
				if($warehouseId==$hdnWarehouseId){
					$warehouseVal = $this->input->post('hdnWarehouseId');
					$ApprovedByHrVal = $this->input->post('hdnApprovedByHr');
				}else{
					$warehouseVal = $this->input->post('warehouse');
					$ApprovedByHrVal = '0';
					//$from = $uInfo['user_email'];
					$from = 'vipinmaru@infowindtech.com';
					$to = $this->input->post('email');
					$subject = "User Warehouse Transfer";
					$message = "User Warehouse transfer but hr approve status deactivated.";
					$successMsg = 'User Send Mail...!!!';
					$errorMsg = 'User Not Send Mail...!!!';
					sendMail($from, $to, $subject, $message, $successMsg, $errorMsg);//helper function 
				}
				/**** End ****/
				
				$data = array(
	    			'warehouse_id' => $warehouseVal,
					'approved_by_hr' => $ApprovedByHrVal,
					'user_last_modified' => date("Y-m-d h:i:s")
	    			);
	    		$this->manageaccount_model->updateUsersForWarehouse($userID, $data);
				
				//Entry for event logs
				if($this->db->affected_rows()==true)
				{
					event_log('updateUsersForWarehouse',$uInfo['user_ID'],$userID,'user_master','ACCOUNTS',date("Y-m-d h:i:s"),'Updated User For Warehouse Successfully');
				}
	    		$this->session->set_flashdata('success_msg','Warehouse User Transfer but wait until HR approval. ! ! !');
	    		redirect('webadmin/manageaccounts/viewUsers');
    		/*} else {
    			$data['roleHrApproval'] = 'Do not have Hr Permission !!';
    		}*/
			
    	}
		$data['userInfo']=$this->manageaccount_model->getAccountInfoByID($userID);
		$data['title'] = 'Warehouse Users | Inventory';
		$data['heading'] = 'Edit User For Warehouse';
		$this->load->view('manageAccounts/editUsersForWarehouse',$data);
	}

	/* User Transfer Store to Store  */
	public function viewUserTransferStore() {
		global $uInfo;
		$data['userInfo'] = $this->manageaccount_model->getUserTransferStore($uInfo['user_ID'],$uInfo['user_role'],$uInfo['comp_code']);
		$data['title'] = 'User | Transfer Store';
		$data['heading'] = 'Get User Transfer Store';
		$this->load->view('manageAccounts/viewUserTransferStore',$data);
	}

	public function updateHrTransferStatus() {
		global $uInfo;
		$storeOfUserId = $this->input->get('userId');
		$where = ['id'=>$this->input->get('transferId')];
		$data = ['hr_user_id'=>$this->input->get('hrId'),
				'hr_approval'=>$this->input->get('status')];
		$res = $this->manageaccount_model->updateHrTransferStatus($where,$data);
		$where1 = ['user_ID'=>$this->input->get('userId')];
		$updateData = ['approved_by_hr'=>$this->input->get('status')];
		$hrApproval = $this->manageaccount_model->updateUserHrApproval($where1,$updateData);
		if($this->db->affected_rows()==true)
		{
			event_log('transfer_store_byhr_approval',$uInfo['user_ID'],$storeOfUserId,'Transfer','STORE',date("Y-m-d h:i:s"),'Successfully Tranfer Store !!');
		}
		//redirect('webadmin/manageaccounts/viewUserTransferStore');
	}


	/* User Transfer Wharehouse to Wharehouse  */
	public function viewUserTransferWharehouse() {
		global $uInfo;
		$data['userInfo'] = $this->manageaccount_model->getUserTransferWarehouse($uInfo['user_ID'],$uInfo['user_role'],$uInfo['comp_code']);
		$data['title'] = 'User | Transfer Warehouse';
		$data['heading'] = 'Get User Transfer Warehouse';
		$this->load->view('manageAccounts/viewUserTransferWarehouse',$data);
	}
}
