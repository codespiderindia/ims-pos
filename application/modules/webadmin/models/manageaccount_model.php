<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageaccount_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
	}

 	function addUsersAccount($data){
		$admin_data=array(
				'user_full_name' =>$data['admin_full_name'],
				'user_email' => $data['email'],
				'user_name' => $data['username'],
				'user_password' => $data['password'],
				'user_role' => $data['user_role'],
				'user_level' => $data['user_level'],
				'location' => $data['location'],
				'department_id' => $data['department_id'],
				'user_account_status' => 1,
				'approved_by_hr' => $data['approved_by_hr'],
				'user_created' => date("Y-m-d h:i:s"),
				'user_last_modified'=>date("Y-m-d h:i:s"),
				'comp_code' => $data['comp_code'],
				'created_by' => $data['created_by'],
				'comp_status'=> $data['comp_status']
				);
				
		$this->db->insert('user_master',$admin_data);
		$user_ID=$this->db->insert_id();
	}

	  public function getAllAccount($comp_code){
	  		$roleId = array(1);
			$this->db->select('*');
			$this->db->where(array('comp_code'=>$comp_code));
			$this->db->where_not_in('user_role', $roleId);
			$this->db->from('user_master');
			$query = $this->db->get();
			
			return $query->result();
	  }
	  public function getAccountInfoByID($id){
		$query = $this->db->get_where('user_master', array('user_ID' => $id));
			if($query->num_rows() > 0)
				return $query->row();
			else
				return FALSE;
	  }
	  
	  
	  public function updateAccount($userID,$data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
	  }
	 
	 public function deleteUsersAccount($userID){
		$this->db->where('user_ID', $userID);
		$this->db->delete('user_master');
	 }
	 
	 //Status ChangeFor User Status
	 public function changeAccountStatus($userID,$data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
		//echo $this->db->last_query();
	 }
	 
	 //Status ChangeFor HR approval
	 public function changeHrAccountStatus($userID,$data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
		//echo $this->db->last_query();
	 }
	 

	 
	 public function getPaymethodForHotel($hotelID){
		
		$query = $this->db->query("SELECT pm.paymethod_ID,pm.paymethod_name,if(hpc.status is null,0,hpc.status) as paymethod_status FROM `paymethod_master` AS pm LEFT JOIN (SELECT * FROM hotel_paymethod_config WHERE hotel_id =$hotelID)hpc ON hpc.paymethod_id = pm.paymethod_ID WHERE pm.paymethod_status=1");
		if($query->num_rows() > 0){
		//echo $this->db->last_query();exit;
				return $query->result();}
			else{
				return FALSE;
				}
	 }
	 public function configurePaymethod($data){
		$query = $this->db->get_where('hotel_paymethod_config', array('hotel_id' =>$data['hotel_id'],'paymethod_id'=>$data['paymethod_id']));
			if($query->num_rows() > 0){
				$id=$query->row()->hpc_ID;
				$this->db->where('hpc_ID',$id);
				$this->db->update('hotel_paymethod_config',$data);
			}
			else{
				$this->db->insert('hotel_paymethod_config',$data);
			}
	 }
 
	public function addUsersForWarehouse($user_ID,$data)
	{
		$this->db->where('user_ID',$user_ID);
		$this->db->update('user_master',$data);
	}
	
	public function addUsersForStore($user_ID,$data)
	{
		$this->db->where('user_ID',$user_ID);
		$this->db->update('user_master',$data);
	}
	
	public function updateUsersForStore($userID, $data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
	}
	
	
	public function updateUsersForWarehouse($userID, $data){
		$this->db->where('user_ID',$userID);
		$this->db->update('user_master',$data);
	}
	
	public function getUserAccountInfoById($userId, $compCode) {
		$this->db->select('*');
		$this->db->where(['user_master.comp_code'=>$compCode,
						 'user_master.user_ID'=>$userId]);
		$this->db->from('user_master');
		$this->db->join('role','role.comp_code = user_master.comp_code');
		$query = $this->db->get();
		return $query->result();
	}

	public function getUserTransferStore($userId,$userRole,$compCode) {
		$this->db->select('*');
		$this->db->from('store_to_store_user_transfer');
		$this->db->where(['comp_code'=>$compCode,
						 'hr_approval'=>0]);
		$query = $this->db->get();
		return $query->result();
	}

	public function updateHrTransferStatus($where,$data) {
		$this->db->where($where);
		$this->db->update('store_to_store_user_transfer',$data);
	}

	public function updateUserHrApproval($where,$data) {
		$this->db->where($where);
		$this->db->update('user_master',$data);
	}

	 public function updateStoreToSToreTransfer($where,$data){
		$this->db->where($where);
		$this->db->update('store_to_store_user_transfer',$data);
	  }

	  public function userStoreManagerUpdate($data,$where){
		$this->db->where($where);
		$this->db->update('user_master', $data);
	}

	public function userStoreManagerUpdateExceptId($data,$where,$whereNot) {

	}
}
