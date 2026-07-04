<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ChmsHotel extends CI_Controller {

	
	public function __construct(){
        parent::__construct(); 
		     
      $this->load->model('chmshotel_model');
    }
 
  	public function index()
	{
	 $data['hotel']= $this->chmshotel_model->getHotelList();
	 //var_dump($data['hotel']);exit;
     $this->load->view('hotelList',$data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */