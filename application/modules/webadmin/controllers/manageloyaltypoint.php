<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class manageLoyaltyPoint extends CI_Controller {

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
			$this->load->model('manageloyaltypoint_model');
		}

	public function index()
	{
		global $uInfo;
		$data['title'] = 'Loyalty Point | Inventory';
		$data['heading'] = 'View Loyalty Points';
		$data['loyaltypoint']= $this->manageloyaltypoint_model->getAllPoints($uInfo['comp_code']);
		$this->load->view('manageLoyaltyPoint/viewPoint',$data);
	}
	
	// Add Vendor Account
	public function addPoints(){
		global $uInfo;
		$this->form_validation->set_message('onlyAlphaSpace', 'Only letters and spaces allow.');
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			$catId=$this->input->post('cat_id');
			$result=$this->manageloyaltypoint_model->getPointsByCatId($catId, $uInfo['comp_code']);
			if($result != '') {
				$where=['category_id'=>$catId,
						'comp_code'=>$uInfo['comp_code']];
				$updateData=['price'=>$this->input->post('price'),
							'loyalty_point'=>$this->input->post('loyalty_point'),
							'status'=>1,
							'modify_date'=>date('y-m-d h:i:s')];

				$this->db->where($where);
				$this->db->update('loyalty_point', $updateData); 

				if($this->db->affected_rows()==true)
				{
					event_log('update',$uInfo['user_ID'],$catId,'Loyalty_point','Points',date("Y-m-d h:i:s"),'Updated Loyalty Point Successfully');
				}
			} else {
				$dataArr = ['category_id'=>$this->input->post('cat_id'),
						'price'=>$this->input->post('price'),
						'loyalty_point'=>$this->input->post('loyalty_point'),
						'status'=>1,
						'comp_code'=>$uInfo['comp_code'],
						'created_date'=>date('y-m-d h:i:s'),
					  ];

				$this->db->insert('loyalty_point',$dataArr);
				$last_inserted_id = $this->db->insert_id();
				
				//Entry for event logs
				if($this->db->affected_rows()==true)
				{
					event_log('insert',$uInfo['user_ID'],$last_inserted_id,'Loyalty_point','LOYALTY POINTS',date("Y-m-d h:i:s"),'Added Loyalty Point Successfully');
				}
			}

    		$this->session->set_flashdata('success_msg','Points Added Successfuly ! ! !');
    		redirect(base_url().'webadmin/manageloyaltypoint/viewPoints');
    	}
		$data['title'] = 'Add Loyalty Point | Inventory';
		$data['heading'] = 'Loyalty Points';
		$this->load->view('manageLoyaltyPoint/addPoint', $data);
	}
	
	// View Vendor List
	public function viewPoints(){
		global $uInfo;
		$data['loyaltypoint']= $this->manageloyaltypoint_model->getAllPoints($uInfo['comp_code']);
		$data['title'] = 'Loyalty Point | Inventory';
		$data['heading'] = 'View Loyalty Points';
		$this->load->view('manageLoyaltyPoint/viewPoint', $data);
	}
	

	public function checkCategoryExist() {
		global $uInfo;
		$catId=$this->input->post('cat_id');
		$result=$this->manageloyaltypoint_model->getPointsByCatId($catId, $uInfo['comp_code']);
		echo json_encode($result);
	}

	public function changePointStatus() {
		global $uInfo;
		$ID=$this->input->get('product_cat_id');
		$product_cat_status=$this->input->get('cat_status');
		$data = array(
    			'status' => $product_cat_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->manageloyaltypoint_model->changePointStatus($ID,$data);
		
		//Entry for event logs
		if($this->db->affected_rows()==true)
		{
			event_log('change_loyalty_point_status',$uInfo['user_ID'],$ID,'loyalty_point','Loyalty Point',date("Y-m-d h:i:s"),'Loyalty Point Status Changed');
		}
	}
	
	
	public function onlyAlphaSpace($str) 
	{
		return ( ! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
	}

}