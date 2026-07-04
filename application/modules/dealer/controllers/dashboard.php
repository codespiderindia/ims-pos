<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends CI_Controller {
/**

	 * Index Page for this controller.

	 *

	 * Maps to the following URL

	 * 		http://example.com/index.php/welcome

	 *	- or -  

	 * 		http://example.com/index.php/welcome/index

	 *	- or -

	 * Since this controller is set as the default controller in 

	 * config/routes.php, it's displayed at http://example.com/

	 * 	 

	 * So any other public methods not prefixed with an underscore will

	 * map to /index.php/welcome/<method_name>

	 * @see http://codeigniter.com/user_guide/general/urls.html

	 */	
	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;
			$uInfo=$this->session->userdata('dealer_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			
			if (!($this->session->userdata('dealer_session_info'))) {
				redirect(base_url().'dealer/login');
			}
		}
	
	public function index()
	{
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			$data['creditDealerDetails'] = $this->common->getDealerDetails($uInfo['dealer_id']);
			$data['title'] = 'Dashboard | Inventory';
			$this->load->view('dashboard', $data);
		}
		
	}
	
}

