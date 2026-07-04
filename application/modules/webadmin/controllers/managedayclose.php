<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Managedayclose extends CI_Controller {

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
			$this->load->model(['managedayclose_model','managereports_model']);
		}
		
	public function index()
	{

/*echo(strtotime("08:00 A.M") . "<br>");echo(strtotime("12:00 P.M") . "<br>");
echo(strtotime("01:00 P.M") . "<br>");echo(strtotime("11:00 P.M") . "<br>");
die;*/

		$data['title'] = 'Day Close';
		$data['heading'] = 'View Day Close';
		$todayDate = date('Y-m-d');

		$moduleVal=checkPermissionOfSaleRole(24);
		
		$rolecode=[];
		foreach($moduleVal as $moduleVals) {
			$role=[$moduleVals['create'],
				$moduleVals['edit'],
				$moduleVals['delete'],
				$moduleVals['view']];
			if(in_array('1',$role)) {
				$rolecode[]=$moduleVals['rolecode'];
			}
		}
		$data['users']=$this->managereports_model->getUserByRoleId($rolecode);

		$data['dayCloseInfo']= $this->managedayclose_model->getDayCloseInfo($todayDate);
		$this->load->view('manageDayClose/viewDayClose',$data);
	}

	public function changeStatus()
	{
		$status = $this->input->get('status');
		$acc_id = $this->input->get('acc_id');
		$data=['day_close'=>$status];
		$where=['user_ID'=>$acc_id];
		$updateVal = updateData('user_master',$data,$where);
	}

	public function getCloseDataByDate() {
		$date=$this->input->post('selected_date');
		$userId=$this->input->post('sale_id');
		$data['dayCloseFilterInfo']= $this->managedayclose_model->getCloseInfoForSelectedVal($date,$userId);
		$this->load->view('manageDayClose/closeDataBydateFilter',$data);
	}

	public function editPaymentInfo($id) {
		/*$where=['id'=>$id];
		$getInfo = getSku('day_close',$where);*/

		$data['title'] = 'Edit Payment';
		$data['heading'] = 'View Payment';
		$data['id'] = $id;

		if($this->form_validation->run('editDayClosePayment') == TRUE) {
			$totalCashPayment = $this->input->post('total_cash_payment');
			$shot = $this->input->post('shot');

			$where=['id'=>$id];
			$data=['total_payment'=>$totalCashPayment, 'shot'=>$shot, 'modify_date'=>date('Y-m-d H:i:s')];
			$updateInfo = updateData('day_close',$data,$where);

			$this->session->set_flashdata('success_msg','Added successfuly ! ! !');
    		redirect(base_url().'webadmin/managedayclose');
		}

		$this->load->view('manageDayClose/editDayCloseInfo',$data);
	}

}