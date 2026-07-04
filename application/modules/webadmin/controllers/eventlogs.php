<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class EventLogs extends CI_Controller {
	
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
		$this->load->model('manageerrorlog_model');
	}

	public function index(){
		global $uInfo;
		$userId = $uInfo['user_ID'];
		/*$where = ['userid_by'=>$userId,'flag'=>0];
		$getLogs = getSku('event_logs',$where);*/

		$getLogs = $this->manageerrorlog_model->getAllEventLogs();
		//$data['modulename'] = getDataByOrderAndGroupBy('event_logs',$where,array(),'','','','affected_table'); 
		//echo $this->db->last_query();

		$data['modulename'] = $this->manageerrorlog_model->getModuleName();

		$data['title'] = 'User | Event Logs';
		$data['heading'] = 'Logs List';
		$data['eventlog'] = $getLogs;
		$this->load->view('eventlogs/viewEventlogs', $data);
	}
	

	public function getLogs() {
		global $uInfo;
		$userId = $uInfo['user_ID'];

		$module_name = $this->input->get('module_name');
		$selectDate = $this->input->get('selectDate');

		$data['title'] = 'User | Event Logs';
		$data['heading'] = 'Logs List';

		$data['getLog'] = $this->manageerrorlog_model->getLogByModuleNmDate($module_name,$selectDate);

		$this->load->view('eventlogs/logFilter', $data, false);
	}

	public function clearLogs() {
		global $uInfo;
		$userId = $uInfo['user_ID'];

		$where = ['userid_by'=>$userId,'flag'=>0];
		$data = ['flag'=>1];
		//$this->db->select('GROUP_CONCAT(event_id)');

  		$this->db->where($where);
  		$this->db->where_not_in('affected_table',['Dealer_login','Dealer_logout','Sales_logout','Sales_login']);
  		//$this->db->from('event_logs');
		$this->db->update('event_logs', $data); 
		/*$query = $this->db->get();
		$aa = $query->result_array();
		echo '<pre>';
		print_r($aa);*/
	}		
}