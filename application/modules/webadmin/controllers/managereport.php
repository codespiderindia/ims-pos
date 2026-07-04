<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageReport extends CI_Controller {

	public function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
 			$this->load->helper('csv');
			global $uInfo;
			$this->load->library('email');
			$uInfo=$this->session->userdata('webadmin_session_info');
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model(['managereports_model','manageproduct_model','managestore_model']);

			$this->load->library('Ajax_pagination');
       		$this->perPage = 5;
	}
	public function index()
	{
	/*	global $uInfo;
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'View Orders';
		$data['orders']= $this->manageorders_model->getAllOrders();
		$this->load->view('manageOrders/viewOrders',$data);
		getSubofSubCategory
	*/
	}

	function pdfPrintBankActAll()
	{
		global $uInfo;
		$userid = $uInfo['user_ID'];

		/*$dealerBank = getSku('dealer_bank_details',['user_ID'=>$userid]);
	  	$vendorBank = getSku('vendor_bank_details',['user_ID'=>$userid]);
	  	foreach($dealerBank as $key=>$dealerBanks) {
	  		$dflag = ['flag'=>1];
	  		$vflag = ['flag'=>2];
	  		$dBankDetail[] = array_merge($dealerBanks,$dflag);

	  		$vBankDetail[] = array_merge($vendorBank[$key],$vflag);
	  	}
	  	$commonBankDetail = array_merge($dBankDetail, $vBankDetail);*/

	  	$sql = "SELECT created_date as Date, transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."'";
        
		$query = $this->db->query($sql);

		if($query->num_rows() > 0) {
    		$row = $query->result();
		} else { $row = array(); }

	  	$data['res'] = $row;

		$this->load->library('pdf');

		$data['comp_code'] = $uInfo['comp_code'];
		$this->pdf->load_view('manageReports/pdfBankActAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}


	function  print_bank_acount_filters()
	{
		global $uInfo;
		$userid = $uInfo['user_ID'];

		$data['comp_code'] = $uInfo['comp_code'];

	    $bank_from_date = explode("-",$this->input->get('bank_from_date'));
		$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
		$bank_end_date = explode("-",$this->input->get('bank_end_date'));
		$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0];
		$type = $this->input->get('type');

		if($type == '1') {

			$sql = "SELECT created_date as Date,transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to') AND dealer_vender_other = 1";
		}

		if($type == '2') {

			$sql = "SELECT created_date as Date,transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to') AND dealer_vender_other = 2";
		}


		if($type == 'all' || $type == '') {

			$sql = "SELECT created_date as Date, transaction_id as TransNo, 	mode_of_payment, IF( dealer_vender_other = 1,  'dealer',  'vendor' ), debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to')";

		}

		$query = $this->db->query($sql);

			if($query->num_rows() > 0) {
	    		$row = $query->result();
			} else { $row = array(); }
		
			$this->load->library('pdf');
			$data['res'] = $row;
			$data['fromdate'] = $from;
			$data['todate'] = $to;
		

			$this->pdf->load_view('manageReports/pdfBankActAll',$data);
			$this->pdf->render();
			$this->pdf->stream("welcome.pdf");
	}


	  function create_csv_for_bank_acount_all() 
	  {
	       global $uInfo;
		   $comp_code = $uInfo['comp_code'];
		   $userId = $uInfo['user_ID'];

	        $this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');
	        $delimiter = ",";
	        $newline   = "\r\n";
	        $filename  = "bankAcountAll.csv";	

	        $sql = "SELECT created_date as Date, transaction_id as TransNo, 	mode_of_payment, IF( dealer_vender_other = 1,  'dealer',  'vendor' ), debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."'";

	        $result    = $this->db->query($sql);

			$data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
       }
		
		
		
	function create_csv_for_bank_acount_filters(){
  		global $uInfo;
	  		$this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');

		    $comp_code = $uInfo['comp_code'];
		    $userId = $uInfo['user_ID'];

		    $delimiter = ",";
	        $newline   = "\r\n";

		    $bank_from_date = explode("-",$this->input->get('bank_from_date'));
			$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
			$bank_end_date = explode("-",$this->input->get('bank_end_date'));
			$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 

			$type = $this->input->get('type');
			$filename  = "bankAc_From_".$from."To_".$to.".csv";

			if($type == 1) {

				$sql = "SELECT created_date as Date,transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to') AND dealer_vender_other = 1";
			}

			if($type == 2) {

				$sql = "SELECT created_date as Date,transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to') AND dealer_vender_other = 2";
			}

			if($type == 'all' || $type == '') {

				$sql = "SELECT created_date as Date,transaction_id as TransNo, 	mode_of_payment, dealer_vender_other, debit, credit, total_balance FROM bank_acount WHERE comp_code = '".$uInfo['comp_code']."' AND (created_date BETWEEN '$from' AND '$to')";
			}

			$result    = $this->db->query($sql);

			$data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
		
       }






       public function print_all_cash_book()
		{
			global $uInfo;

			$sql = "SELECT created_date as Date, transaction_id as TransNo, dealer_vender_other, mode_of_payment, debit, credit,amount,total_balance,comments FROM cash_book";
        
		$query = $this->db->query($sql);	
		if($query->num_rows() > 0){
	    $row = $query->result();
			} else { $row = array(); }

			$this->load->library('pdf');
			$data['res'] = $row;
			$data['comp_code'] = $uInfo['comp_code'];
			//echo '<pre>';print_r($data);die;
			$this->pdf->load_view('manageReports/pdfCashBookAll',$data);
			$this->pdf->render();
			$this->pdf->stream("welcome.pdf");
		}

		function print_filters_cash_book()
		{
			global $uInfo;

			$comp_code = $uInfo['comp_code'];
			$userId = $uInfo['user_ID'];

		   	$bank_from_date = explode("-",$this->input->get('bank_from_date'));
			$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
			$bank_end_date = explode("-",$this->input->get('bank_end_date'));
			$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
			$cash_type = $this->input->get('cash_type');


			if(is_numeric($cash_type) && $cash_type != '') {

				 $sql = "SELECT created_date as Date, transaction_id as TransNo, dealer_vender_other, mode_of_payment, debit, credit,amount,total_balance,comments FROM cash_book WHERE (created_date BETWEEN '$from' AND '$to') and comp_code='$comp_code' and dealer_vender_other='$cash_type' ";

			} else {

			 $sql = "SELECT created_date as Date, transaction_id as TransNo, dealer_vender_other, mode_of_payment, debit, credit,amount,total_balance,comments FROM cash_book WHERE (created_date BETWEEN '$from' AND '$to') and comp_code='$comp_code'";
			}
   
			$query = $this->db->query($sql);	
			if($query->num_rows() > 0){
			    $row = $query->result();
			} else { $row = array(); }

   
   			/*$cashBook = $this->managereports_model->saleCashDetailByDate($from,$to,$storeId);*/

			$this->load->library('pdf');
			$data['res'] = $row;
			$data['fromdate'] = $from;
			$data['todate'] = $to;
			$data['comp_code'] = $comp_code;
			$this->pdf->load_view('manageReports/pdfCashBookAll',$data);
			$this->pdf->render();
			$this->pdf->stream("welcome.pdf");
    	}

		function create_csv_for_bank_acount_all_cash_book(){
		
		 	 global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "cashbookAll.csv";	

        $query     = "SELECT created_date as Date, transaction_id as TransNo, 
        IF( dealer_vender_other = 1,  'dealer',  'vendor' ) AS PayBy,	mode_of_payment, debit, credit, total_balance FROM cash_book where comp_code = '$comp_code'";

        $result    = $this->db->query($query);
		$data      = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
	    }
		
		
		function create_csv_for_bank_acount_filters_cash_book(){
	
			global $uInfo;

		    $comp_code = $uInfo['comp_code'];
		    $bank_from_date = explode("-",$this->input->get('bank_from_date'));
			$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
			$bank_end_date = explode("-",$this->input->get('bank_end_date'));
			$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
			$cash_type = $this->input->get('cash_type');
		
	    	$this->load->dbutil();
	        $this->load->helper('file');
	        $this->load->helper('download');
	        $delimiter = ",";
	        $newline   = "\r\n";
	        $filename  = "cashbook_From_".$from."To_".$to.".csv";


	        if(is_numeric($cash_type) && $cash_type != '') {
	        	$query  = "SELECT created_date as Date, transaction_id as TransNo, IF( dealer_vender_other = 1,  'dealer',  'vendor' ) AS FromTo,	mode_of_payment, debit, credit, total_balance FROM cash_book WHERE (created_date BETWEEN '$from' AND '$to') and comp_code='$comp_code' and dealer_vender_other='$cash_type'";
	        } else {
	        	$query  = "SELECT created_date as Date, transaction_id as TransNo,
	        	IF( dealer_vender_other = 1,  'dealer',  'vendor' ) AS FromTo, 	mode_of_payment, debit, credit, total_balance FROM cash_book WHERE (created_date BETWEEN '$from' AND '$to') and comp_code='$comp_code'";
	        }
	        

	        $result    = $this->db->query($query);
			$data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
	        force_download($filename, $data);
       }




		
		
		public function export_all_dealer()
		{
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		$dealer_id = $this->input->get('dealer_id');
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "DealerAcAll.csv";	
        $query     = "SELECT created as DocDate, transaction_id as TransNo, 	mode_of_payment, debit, credit,amount,total_amount as Balance,comments FROM dealer_account where dealer_user_id = '$dealer_id' and comp_code = '$comp_code'";
        $result  = $this->db->query($query);
		$data    = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
		
		}
		
		
		public function print_all_dealer()
		{
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		
		$dealer_id = $this->input->get('dealer_id');
	
        $sql     = "SELECT created as DocDate, transaction_id as TransNo, 	mode_of_payment, invoice_id, debit, credit,amount,total_amount as Balance,comments FROM dealer_account where dealer_user_id = '$dealer_id' and comp_code='$comp_code'";
     
		
	$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['comp_code'] = $comp_code;
		
		$this->pdf->load_view('manageReports/pdfDealerAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
		}
		
	function print_all_dealer_filter()
		{
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		
		$bank_from_date = explode("-",$this->input->get('from_date'));
	$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
	$bank_end_date = explode("-",$this->input->get('to_date'));
	$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
	$dealer_id = $this->input->get('dealer_id');
        $sql     = "SELECT created as DocDate,transaction_id as TransNo, 	mode_of_payment, debit,invoice_id, credit,amount,total_amount as Balance,comments FROM dealer_account WHERE (created  BETWEEN '$from' AND '$to') AND dealer_user_id='$dealer_id' AND comp_code='$comp_code'";
        
		
		$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['fromdate'] = $from;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		
	
		$this->pdf->load_view('manageReports/pdfDealerAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
		
		}
	function export_all_dealer_filter(){
 		global $uInfo;
	    $comp_code = $uInfo['comp_code'];
		
	    $bank_from_date = explode("-",$this->input->get('from_date'));
		$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
		$bank_end_date = explode("-",$this->input->get('to_date'));
		$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
		$dealer_id = $this->input->get('dealer_id');

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "bankAc_From_".$from."To_".$to.".csv";
        $query     = "SELECT created as DocDate, invoice_id, debit, credit, total_amount as Balance FROM dealer_account WHERE (created  BETWEEN '$from' AND '$to') AND dealer_user_id='$dealer_id' AND comp_code='$comp_code'";
        $result = $this->db->query($query);
		$data   = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
       }
		
		
		public function export_all_vendor()
		{
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		
		$vendor_id = $this->input->get('vendor_id');
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "VendorAcAll.csv";	
        $query     = "SELECT created as DocDate, invoice_id as InvoiceNo, debit, credit, total_amount as Balance FROM vendor_account where vendor_user_id = '$vendor_id' AND comp_code='$comp_code'";

        $result    = $this->db->query($query);
		$data      = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
		
		}
		
		
	function print_all_vendor()
	{
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];

	$vendor_id = $this->input->get('vendor_id');
	 $sql     = "SELECT created as DocDate, invoice_id , debit, credit, total_amount as Balance FROM vendor_account where vendor_user_id = '$vendor_id' AND comp_code='$comp_code'";

	$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['comp_code'] = $comp_code;
		
		$this->pdf->load_view('manageReports/pdfVendorAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}


	function export_all_vendor_filter(){
 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		
    $bank_from_date = explode("-",$this->input->get('from_date'));
	$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
	$bank_end_date = explode("-",$this->input->get('to_date'));
	$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
	$vendor_id = $this->input->get('vendor_id');

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "vendor_From_".$from."To_".$to.".csv";
        $query     = "SELECT created as DocDate, invoice_id as InvoiceNo, debit, credit, total_amount as Balance FROM vendor_account WHERE (created  BETWEEN '$from' AND '$to') AND vendor_user_id='$vendor_id' AND comp_code='$comp_code'";
        $result    = $this->db->query($query);
		$data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
       }
		
		
		function print_all_vendor_filter(){
		
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		

    $bank_from_date = explode("-",$this->input->get('from_date'));
	$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
	$bank_end_date = explode("-",$this->input->get('to_date'));
	$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0]; 
	$vendor_id = $this->input->get('vendor_id');
    
        $sql     = "SELECT created as DocDate,invoice_id, debit, credit, total_amount as Balance FROM vendor_account WHERE (created  BETWEEN '$from' AND '$to') AND vendor_user_id='$vendor_id' and comp_code = '$comp_code'";
      $query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['fromdate'] = $from ;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		$this->pdf->load_view('manageReports/pdfVendorAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
		}



	//Generate CSV Product 
	public function export_all_product()
	{
		global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		
		$product_id = $this->input->get('product_id');
		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "ProductAcAll.csv";	
        $attr_name = get_attribute_by_productID($product_id);
        $attrVal = [];
        if(isset($attr_name) && !empty($attr_name)){
		   $count_array = count($attr_name);
		   if(!empty($attr_name)){
			   for($i=0;$i<$count_array;$i++){
					$attrVal[] = $attr_name[$i]; 
			   }
		   }else{
			  $attrVal[] = "Not Set";
		   }
		}

		$query     = "SELECT p.product_id, p.product_name, p.product_sub_category AS SubCategory, p.product_sub_of_sub_category as SubOfSubCategory, p.product_image, p.product_price, p.product_status, pc.cat_name AS Category
					FROM  `product` AS p
					JOIN  `product_category` AS pc ON p.product_category = pc.product_cat_id
					WHERE p.`product_id` ='$product_id' AND p.`comp_code` = '$comp_code'";

        $result    = $this->db->query($query);
       // $merageval = array_push($result,$attrVal);

		$data      = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
	}


	function print_all_product()
	{
		/*$image ='http://infowindtech.com.cp-in-13.webhostbox.net/inventory/uploads/product_image/00dedaa16eea283450470168895582db.jpg';
		echo '<img src="'.$image.'" />';
		die;*/
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];

		$product_id = $this->input->get('product_id');

	$sql = "SELECT p.product_id, p.product_name, pc.cat_name AS Category, p.product_sub_category AS SubCategory, p.product_sub_of_sub_category as SubOfSubCategory, p.product_image, p.product_price, p.product_status
					FROM  `product` AS p
					JOIN  `product_category` AS pc ON p.product_category = pc.product_cat_id
					WHERE p.`product_id` ='$product_id' AND p.`comp_code` = '$comp_code'";
	$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['comp_code'] = $comp_code;
		
		$this->pdf->load_view('manageReports/pdfProductAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}

	function export_all_product_filter(){
 		global $uInfo;
	   $comp_code = $uInfo['comp_code'];
		
    $product_from_date = explode("-",$this->input->get('from_date'));
	$from = $product_from_date[2]."-".$product_from_date[1]."-".$product_from_date[0];
	$product_end_date = explode("-",$this->input->get('to_date'));
	$to = $product_from_date[2]."-".$product_from_date[1]."-".$product_from_date[0]; 
	$product_id = $this->input->get('product_id');

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "product_From_".$from."To_".$to.".csv";
        $query     = "SELECT p.product_id, p.product_name, p.product_sub_category AS SubCategory, p.product_sub_of_sub_category as SubOfSubCategory, p.product_image, p.product_price, p.product_status, pc.cat_name AS Category
					FROM  `product` AS p
					JOIN  `product_category` AS pc ON p.product_category = pc.product_cat_id
					WHERE p.`product_id` ='$product_id' AND p.`comp_code` = '$comp_code'";

        $result    = $this->db->query($query);
		$data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
       }


       function print_all_product_filter(){
		
		 global $uInfo;
	  $comp_code = $uInfo['comp_code'];
		

    $product_from_date = explode("-",$this->input->get('from_date'));
	$from = $product_from_date[2]."-".$product_from_date[1]."-".$product_from_date[0];
	$product_end_date = explode("-",$this->input->get('to_date'));
	$to = $product_end_date[2]."-".$product_end_date[1]."-".$product_end_date[0]; 
	$product_id = $this->input->get('product_id');
    
        $sql     = "SELECT p.product_id, p.product_name, pc.cat_name AS Category, p.product_sub_category AS SubCategory, p.product_sub_of_sub_category as SubOfSubCategory, p.product_image, p.product_price, p.product_status
					FROM  `product` AS p
					JOIN  `product_category` AS pc ON p.product_category = pc.product_cat_id
					WHERE p.`product_id` ='$product_id' AND p.`comp_code` = '$comp_code'";

      $query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }
		$this->load->library('pdf');
		$data['res'] = $row;
		$data['fromdate'] = $from ;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		$this->pdf->load_view('manageReports/pdfProductAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
		}


	public function products()
	{
		global $uInfo;
		$data['title'] = 'Report| Product';
		$data['heading'] = 'Products';
		$data['products']= $this->managereports_model->getAllProducts($uInfo['comp_code']);
		$this->load->view('manageReports/viewProduct',$data);
	}

	public function Dealers()
	{
		global $uInfo;
		$data['title']   = 'Report| Dealer';
		$data['heading'] = 'Dealers';
		$data['dealers'] = $this->managereports_model->getAllDealers($uInfo['comp_code']);
		$this->load->view('manageReports/viewDealers',$data);
	}
	public function Venders()
	{
		global $uInfo;
		$data['title']   = 'Report| Venders';
		$data['heading'] = 'Venders';
		$data['venders'] = $this->managereports_model->getAllVenders($uInfo['comp_code']);
		$this->load->view('manageReports/viewVenders',$data);
	
	}
	
	public function Taxes()
	{
		global $uInfo;
		$data['title']   = 'Report| Taxes';
		$data['heading'] = 'Taxes';
		$data['taxes'] = $this->managereports_model->getAllTaxes($uInfo['comp_code']);
		$this->load->view('manageReports/viewTaxes',$data);
	
	}
	
	public function Offers()
	{
		global $uInfo;
		$data['title']   = 'Report| Offers';
		$data['heading'] = 'Offers';
		$data['offers'] = $this->managereports_model->getAllOffers($uInfo['comp_code'],'','','');
		$this->load->view('manageReports/viewOffers',$data);
	}

	public function viewOfferFilter() {
		global $uInfo;
		$offerName=$this->input->post('offername');
		$startDate=$this->input->post('startdate');
		$endDate=$this->input->post('enddate');
		$data['title']   = 'Report| Offers';
		$data['heading'] = 'Offers';
		$data['offers'] = $this->managereports_model->getAllOffers($uInfo['comp_code'],$offerName,$startDate,$endDate);
		$this->load->view('manageReports/viewOffers_filter',$data);
	}

	public function generalreport()
	{
		global $uInfo;
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$data['users'] = $this->managereports_model->getAllUsers($uInfo['comp_code']);
		$this->load->view('manageReports/mainGeneralReport',$data);
	}
	
	public function transactionreport()
	{
		global $uInfo;
		$userid = $uInfo['user_ID'];
		$compCode = $uInfo['comp_code'];

		$data['title'] = 'Report | Transaction';
		$data['heading'] = 'Transaction Report';
		$data['users'] = $this->managereports_model->getAllDealers($uInfo['comp_code']);
		
	  	/*$dealerBank = getSku('dealer_bank_details',['user_ID'=>$userid]);
	  	$vendorBank = getSku('vendor_bank_details',['user_ID'=>$userid]);
	  	foreach($dealerBank as $key=>$dealerBanks) {
	  		$dflag = ['flag'=>1];
	  		$vflag = ['flag'=>2];
	  		$dBankDetail[] = array_merge($dealerBanks,$dflag);

	  		$vBankDetail[] = array_merge($vendorBank[$key],$vflag);
	  	}

	  	$commonBankDetail = array_merge($dBankDetail, $vBankDetail);

	  	$data['bankAcount'] = $commonBankDetail;*/


		$data['bankAcount'] = $this->managereports_model->bankAcount($uInfo['comp_code']);
		$data['vendor'] = $this->managereports_model->getAllVenders($uInfo['comp_code']);
		$data['product'] = $this->managereports_model->getAllProducts($uInfo['comp_code']);
		$data['store'] = $this->managestore_model->getAllStore($uInfo['comp_code']);

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
		$data['saleUser']=$this->managereports_model->getUserByRoleId($rolecode);

		$this->load->view('manageReports/mainTransactionReport',$data);
	}

	public function salereport()
	{
		global $uInfo;
		$data['title'] = 'Report | Sale';
		$data['heading'] = 'Sale Report';

		$data['locs']=$this->managereports_model->getLocations($uInfo['comp_code']);
        $data['products']=$this->managereports_model->getProductsAll($uInfo['comp_code']);
        $data['store']=$this->managestore_model->getAllStore($uInfo['comp_code']);

		$this->load->view('manageReports/mainSaleReport',$data);
	}

	public function sales_summary() {
		
		global $uInfo;
        $conditions = array();
        $data=array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

  		$conditions['search']['employee_ID'] = $uInfo['user_ID'];
  		$conditions['search']['company_ID'] = $uInfo['comp_code'];
  		//$conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
        $startDate=$this->input->post('start_date');
        $endDate=$this->input->post('end_date');

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($endDate)){
            $conditions['search']['endDate'] = $endDate;
        }
        //total rows count
        $conditions['search']['exp']=false;
       	$totalRec = count($this->managereports_model->getRows($conditions));

        	
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/sales_summary';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

        //get posts data
        $data['sales'] = $this->managereports_model->getRows($conditions);

      // var_dump($data);exit;
        $data['title'] = 'Dashboard | Sales';
        //load the view
       // $this->load->view('managereports/ajax-pagination-data', $data, false);
         $this->load->view('manageReports/sale_summary_report_view', $data, false);
	}



	 // Sales Detail 
    function sales_detail(){
          
            global $uInfo;
            $conditions = array();
            $data=array();
            
            //calc offset number
            $page = $this->input->post('page');
            if(!$page){
                $offset = 0;
            }else{
                $offset = $page;
            }
   
            $conditions['search']['employee_ID'] = $uInfo['user_ID'];
            $conditions['search']['company_ID'] = $uInfo['comp_code'];
           // $conditions['search']['store_ID'] = $uInfo['store'];
            //set conditions for search
            $keywords = $this->input->post('keywords');
            $sortBy = $this->input->post('sortBy');
            $startDate=$this->input->post('start_date');
            $endDate=$this->input->post('end_date');
            $storeId=$this->input->post('storeId');

            if(!empty($keywords)){
                $conditions['search']['keywords'] = $keywords;
            }
            if(!empty($sortBy)){
                $conditions['search']['sortBy'] = $sortBy;
            }
            if(!empty($startDate)){
                $conditions['search']['startDate'] = $startDate;
            }
            if(!empty($endDate)){
                $conditions['search']['endDate'] = $endDate;
            }
            if(!empty($storeId)){
                $conditions['search']['storeId'] = $storeId;
            }
            //total rows count
            $conditions['search']['exp']=false;
            $totalRec = count($this->managereports_model->getSales($conditions));
            
            //pagination configuration
            $config1['target']      = '#postList';
            $config1['base_url']    = base_url().'webadmin/managereport/sales_detail';
            $config1['total_rows']  = $totalRec;
            $config1['per_page']    = $this->perPage;
            $config1['link_func']   = 'searchFilterSaleDetail';
            $this->ajax_pagination->initialize($config1);
            
            //set start and limit
            $conditions['start'] = $offset;
            $conditions['limit'] = $this->perPage;
            //get posts data
            $data['sales'] = $this->managereports_model->getSales($conditions);

          // var_dump($data);exit;
            $data['title'] = 'Dashboard | Sales';
            //load the view
           // $this->load->view('managereports/ajax-pagination-data', $data, false);
            $this->load->view('manageReports/sales_detail_report_view', $data, false);
    }

    /* Delete the Sale billing */
    public function delSaleBilling()
    {
    	$saleId = $this->input->post('saleId');
    	$updateData = ['is_deleted'=>1];
    	$this->db->where('sale_ID',$saleId);
    	$this->db->update('sale', $updateData);

    }
    /* Delete the Sale billing */

    /* Reprint the Invoice */
   /* public function rePrintBilling($saleID)
    {
    	$this->load->model('sales/managesales_model', 'managesales_model');
    	$saleData=array();
		$saleData['sale_ID']= $saleID;
		$saleData['sale_detail']=$this->managesales_model->getSaleDetailByID($saleID);
		$store_ID = $saleData['sale_detail']['store_ID'];
		$saleData['sale_items']=$this->managesales_model->getSaleItemsByID($saleID);

		$saleData['sale_payments']=$this->managesales_model->getSalePaymentsByID($saleID);

		$saleData['sale_store_info']=$this->managesales_model->getStoreInfoByID($store_ID);

		$custID=false;
		$custID=$this->managesales_model->getSaleCustomerByID($saleID);

		if($custID){
		$saleData['sale_customer']=$this->managesales_model->getCustomerInfoByID($custID);
		}
		//echo '<pre>';print_r($saleData);
		echo json_encode(array('htmldata'=>$this->load->view('sales/managesales/print_invoice',$saleData)));
    }*/
    /* Reprint the Invoice */


    public function best_selling()
    {
    	global $uInfo;
        $conditions = array();
        $data=array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
      //  $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords=$this->input->post('keywords');
        $sortBy=$this->input->post('sortBy');
        $startDate=$this->input->post('start_date');
        $endDate=$this->input->post('end_date');
        $storeId=$this->input->post('storeId');

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($endDate)){
            $conditions['search']['endDate'] = $endDate;
        }
        if(!empty($storeId)){
            $conditions['search']['storeId'] = $storeId;
        }

        //total rows count
        $conditions['search']['exp']=false;
        $totalRec = count($this->managereports_model->getBestSellingProducts($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/best_selling';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'bestSellingProduct';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
      
        $data['sales'] = $this->managereports_model->getBestSellingProducts($conditions);
     
        $data['title'] = 'Dashboard | Sales';
       
        $this->load->view('manageReports/best_selling_report_view', $data, false);
    }


    function item_stock(){
           
        global $uInfo;
        $conditions = array();
        $data=array();
        
        //calc offset number
        $page = $this->input->post('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
        
        $conditions['search']['compID'] = $uInfo['comp_code'];
        //set conditions for search
        $keywords=$this->input->post('keywords');
        $sortBy=$this->input->post('sortBy');
        $itemID=$this->input->post('itemID');
        $locID=$this->input->post('locID');
        $storeID=$this->input->post('storeID');

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($itemID)){
            $conditions['search']['itemID'] = $itemID;
        }
        if(!empty($locID)){
            $conditions['search']['locID'] = $locID;
        }
        if(!empty($storeID)){
            $conditions['search']['storeID'] = $storeID;
        }

        //total rows count
        $conditions['search']['exp']=false;
        $totalRec = count($this->managereports_model->getProductStock($conditions));
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/item_stock';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'stockDetail';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
      
        $data['prd_stock'] = $this->managereports_model->getProductStock($conditions);
     
        $data['title'] = 'Dashboard | Sales';
        $data['storeName']=$this->managereports_model->getStoreNameByID($storeID);
       
        $this->load->view('manageReports/paginate_item_stock', $data, false);
    }



	public function cashBookPaginate()
	{
		$this->load->library('pagination');
		$config = array();
		$config["base_url"] = base_url() . "index.php/pagination_controller/contact_info";
		$total_row = 4;
		$config["total_rows"] = $total_row;
		$config["per_page"] = 1;
		$config['use_page_numbers'] = TRUE;
		$config['num_links'] = $total_row;
		$config['cur_tag_open'] = '&nbsp;<a class="current">';
		$config['cur_tag_close'] = '</a>';
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$this->pagination->initialize($config);
		if($this->uri->segment(3)){
		$page = ($this->uri->segment(3)) ;
		}
		else{
		$page = 1;
		}
		$str_links = $this->pagination->create_links();
		$data["links"] = explode('&nbsp;',$str_links );
	}



	
	public function cashBook($offset = false)
	{
		/*$this->load->library('pagination');
		$config = array();
	//	$config["base_url"] = base_url() . "webadmin/managereport/cashBook";
		$total_row = 4;
		$config["total_rows"] = $total_row;
		$config["per_page"] = 1;
		$config['num_links'] = $total_row;
		$config['next_link'] = 'Next';
		$config['prev_link'] = 'Previous';
		$config['page_query_string'] = FALSE;
		$config['anchor_class'] = 'class="number" ';
		$this->pagination->initialize($config);
		
		$str_links = $this->pagination->create_links();
		$link = explode('&nbsp;',$str_links );
		$limit = 1;
		if($offset != '') {
			$start = $offset;
		} else {
			$start = 1;
		}*/

	global $uInfo;
	$getExpense = getSku('expense',['comp_code'=>$uInfo['comp_code']]); 
	if(isset($getExpense) && !empty($getExpense)) {
		$expense = $getExpense[0]['total'];
	} else {
		$expense = '';
	}
	

	$cashBook =  $this->managereports_model->cashBook($uInfo['comp_code']);

	$html = '';
	$html .= '<table id="cashbook-table" class="paginated table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>Date</th>
						<th>Trans No.</th>
                        <th>Mode Of Payment</th>
                        <th>Debit </th>
						<th>Credit</th>
						<th>Pay By</th>
						<th>Balance</th>
					 </tr>
				 </thead>
                  <tbody>';
                   if(!empty($cashBook)) {
						foreach($cashBook as $cashBook) {

							if($cashBook->dealer_vender_other=='1') {
								$from = 'Dealer';
							} else if($cashBook->dealer_vender_other=='2') {
								$from = 'Vendor';
							} else {
								$from = 'Other';
							}

							if($cashBook->total_balance >= 0) {
								$balance = $cashBook->total_balance;
							} else {
								$balance = 0;
							}

							$html .= '<tr>';
							$html .= '<td>'.$cashBook->created_date.'</td>';
							$html .= '<td>'.$cashBook->transaction_id.'</td>';
							$html .= '<td>'.$cashBook->mode_of_payment.'</td>';
							$html .= '<td>'.$cashBook->debit.'</td>';
							$html .= '<td>'.$cashBook->credit.'</td>';
							$html .= '<td>'.$from.'</td>';
							$html .= '<td>'.$balance.'</td>';
						}	
	}
							
   $html .=	'</tbody>
               </table> <script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#cashbook-table").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null,
				        ]
				      });

				    });	

               </script>';
               //<p class="cash_book_links">'.$str_links.'</p>';
			   echo $html;
	}
	
	
	
	public function bankReportByDate()
	{
	global $uInfo;
	$userid = $uInfo['user_ID'];

	$bank_from_date = explode("-",$this->input->get('bank_from_date'));
	$from = $bank_from_date[2]."-".$bank_from_date[1]."-".$bank_from_date[0];
	$bank_end_date = explode("-",$this->input->get('bank_end_date'));
	$to = $bank_end_date[2]."-".$bank_end_date[1]."-".$bank_end_date[0];

	$type = $this->input->get('type');

	$bankAcount =  $this->managereports_model->bankReportByDate($from,$to,$type);
	
	/*if($type == 1) {
		$typeName = 'Dealer';$bankAcount =  $this->managereports_model->dealerReportByDate($from,$to);
	}

	if($type == 2) {
		$typeName = 'Vendor';
		$bankAcount =  $this->managereports_model->vendorReportByDate($from,$to);
	}

	if($type == 'all' || $type == '') {

		$dealerBank =  $this->managereports_model->dealerReportByDate($from,$to);
		$vendorBank =  $this->managereports_model->vendorReportByDate($from,$to);

		$vBankDetail=$dBankDetail=[];

	  	foreach($dealerBank as $key=>$dealerBanks) {
	  		$dflag = ['flag'=>1];
	  		$dBankDetail[] = array_merge($dealerBanks,$dflag);
	  	}

	  	foreach($vendorBank as $vkey=>$vendorBanks) {
	  		$vflag = ['flag'=>2];
	  		$vBankDetail[] = array_merge($vendorBanks,$vflag);
	  	}
	  	$bankAcount = array_merge($dBankDetail, $vBankDetail);
	}*/

	
	$html = '';
	$html.='<table id="bankAccount_filter" class="table table-striped table-borderedss table-hover bankAccount_filter">
                  <thead>
                     <tr>
                      	<th>Date</th>
						<th>Trans No.</th>
                        <th>Mode Of Payment</th>
                        <th>Debit </th>
						<th>Credit</th>
						<th>Pay By</th>
						<th>Balance</th>
					 </tr>
                  </thead>
                  <tbody>';
                    if(!empty($bankAcount)) { 
                    	$i=1;
                    foreach($bankAcount as $bankAcountRow) {

                    	if($bankAcountRow->dealer_vender_other == 1) {
                    		$from = 'Dealer';
                    	} else if($bankAcountRow->dealer_vender_other == 2) {
                    		$from = 'Vendor';
                    	} else {
                    		$from = '';
                    	}

                    	/*if($type == 1) {
                    		$getName = dealer_name($bankAcountRow['dealer_id']);
		             		if(!empty($getName)) {
		             			$userName = $getName[0]->f_name;
		             		} else {
		             			$userName = '';
		             		}
                    	} 

                    	if($type == 2) {
                    		$getName = vendor_name($bankAcountRow['vendor_id']);
                    		$userName = $getName->f_name.' '.$getName->l_name;
                    	}


                    	if($type == 'all' || $type == '') {
                    		if($bankAcountRow['flag'] == 1) {
			             		$typeName = 'Dealer';
			             		$getName = dealer_name($bankAcountRow['dealer_id']);
			             		if(!empty($getName)) {
			             			$userName = $getName[0]->f_name;
			             		} else {
			             			$userName = '';
			             		}
			             		
			             	} elseif($bankAcountRow['flag'] == 2) {
			             		$typeName = 'Vendor';
			             		$getName = vendor_name($bankAcountRow['vendor_id']);
			             		$userName = $getName->f_name.' '.$getName->l_name;
			             	} else {
			             		$typeName = '';
			             	}
                    	}*/
                    	
                    		$html.= '<tr>';
	                   		$html.='<td>'.$bankAcountRow->created_date.'</td>';
	                        $html.='<td>'.$bankAcountRow->transaction_id.'</td>';
	                        $html.='<td>'.$bankAcountRow->mode_of_payment.'</td>'; 
	                        $html.='<td>'.$bankAcountRow->debit.'</td>';
	                        $html.='<td>'.$bankAcountRow->credit.'</td>';
							$html.='<td>'.$from.'</td>';
							$html.='<td>'.$bankAcountRow->total_balance.'</td>
							</tr>';
					    $i++;
                  
				    }
				 
				 } else {
				  $html.= '<tr>
	                        <td>No Records Found.</td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
	                        <td></td>
						</tr>';
			}
				$html.='</tbody>
			               </table>';

			        if(!empty($bankAcount)) { 
			 $html.='<script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#bankAccount_filter").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null, null,
				        ]
				      });
				    });	

               </script>';
           }
		echo  $html;
	
	}
	
	public function cashReportByDate()
	{
		global $uInfo;
		$compCode = $uInfo['comp_code'];

	$cash_from_date = explode("-",$this->input->get('cash_from_date'));
	$from = $cash_from_date[2]."-".$cash_from_date[1]."-".$cash_from_date[0];
	$cash_end_date = explode("-",$this->input->get('cash_end_date'));
	$to = $cash_end_date[2]."-".$cash_end_date[1]."-".$cash_end_date[0];
	$cash_type = $this->input->get('cash_type');

	$getExpense = getSku('expense',['comp_code'=>$compCode]);
	if(!empty($getExpense)) {
		$expense = $getExpense[0]['total'];
	}
	

	$bankAcount =  $this->managereports_model->cashReportByDate($from,$to,$cash_type);
	$html = '';
	$html.='<table id="myTables-cashbook" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>Date</th>
						<th>Trans No.</th>
                        <th>Mode Of Payment</th>
                        <th>Debit </th>
						<th>Credit</th>
						<th>Pay Bay</th>
						<th>Balance</th>
					 </tr>
                  </thead>
                  <tbody>';
                    if(!empty($bankAcount)) { 
                     foreach($bankAcount as $bankAcountRow) { 
                     	if($bankAcountRow->dealer_vender_other=='1') {
						$from = 'Dealer';
						}
						if($bankAcountRow->dealer_vender_other=='2') {
						$from = 'Vendor';
						}
						if($bankAcountRow->dealer_vender_other=='3') {
						$from = 'Other';
						}

						if(isset($expense) && $expense != '') {
							$expense = $expense;
						} else {
							$expense = '';
						}

                   $html.= '<tr>
                        <td>'.$bankAcountRow->created_date.'</td>'; 
						$html.='<td>'.$bankAcountRow->transaction_id.'</td>';
						$html.='<td>'.$bankAcountRow->mode_of_payment.'</td>';  
                        $html.='<td>'.$bankAcountRow->debit.'</td>';
						$html.='<td>'.$bankAcountRow->credit.'</td>';
						$html.='<td>'.$from.'</td>';
						$html.='<td>'.$bankAcountRow->total_balance.'</td>
						</tr>';
				  }
				 
				 } else {
				  $html.= '<tr>   
                        <td colspan="100%">No Records Found.</td>
						</tr>';
				 }
		$html.='</tbody>
				               </table></table><script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#myTables-cashbook").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null, 
				        ]
				      });

				    });	

               </script>';
		echo  $html;
	}

	
	
	public function  getSubCategories() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];

		$select_options = $product_option = '';
		$main_cat_id = $this->input->post('main_cat_id');

		if($main_cat_id != '') {
			$where = ['product_category'=>$main_cat_id, 'comp_code'=>$compCode];
		} else {
			$where = ['comp_code'=>$compCode];
		}
		
		$getProduct = getSku('product',$where);
		

		if(!empty($getProduct)) {
			$product_option .= '<option value="allproduct">All</option>';
			foreach($getProduct as $getProducts) {
				$product_option .= '<option value="'.$getProducts['product_id'].'">'.$getProducts['product_name'].'</option>';
			}
		} else {
			$product_option = '<option value="">No Records Found</option>';
		}


		if(!empty($main_cat_id) && is_numeric($main_cat_id)) { 
			$SubCat = getSubCategory($main_cat_id); 

			if($SubCat) { 
			 	$select_options.= '<option value="">Select</option>';
			    foreach($SubCat as $SubCat) {
			 		$select_options.= '<option value="'.$SubCat["product_cat_id"].'">'.$SubCat["cat_name"].'</option>'; 
			 	}
			} else {
			   $select_options = '<option value="">No Records Found</option>';
			}
		    echo json_encode(['category'=>$select_options,'product'=>$product_option]);

		} else { 
			$select_options.= '<option value="">Select Main Cat</option>';

			echo json_encode(['category'=>$select_options,'product'=>$product_option]);
		}

	}


	
	
	public function  getSubSubCategories() {
	 $select_options = '';
	 $sub_cat_id = $this->input->post('sub_cat_id');
	 $SubCat = getSubofSubCategory($sub_cat_id); 
	 if($SubCat) { 
	 $select_options.= '<option value="">Select</option>';
	 foreach($SubCat as $SubCat) {
	 $select_options.= '<option value="'.$SubCat["product_cat_id"].'">'.$SubCat["cat_name"].'</option>'; 
	 }
	} else {
	 $select_options.= '<option value="">No Records Found</option>';
	}
	echo $select_options;
	}

	
	
	public function  getCityByState() {
	 $select_options = '';
	 $state_id = $this->input->post('state_id');
	 $cities = get_cities_by_state_id($state_id); 
	 if($cities) { 
	 $select_options.= '<option value="">Select</option>';
	 foreach($cities as $cities) {
	 $select_options.= '<option value="'.$cities["id"].'">'.$cities["name"].'</option>'; 
	 }
	} else {
	 $select_options.= '<option value="">No Records Found</option>';
	}
	echo $select_options;
	}
	
	public function  getLocationByCity() {
	 $select_options = '';
	 $city_id = $this->input->post('city_id');
	 $cities = get_location_by_city_id($city_id); 
	 if($cities) { 
	 $select_options.= '<option value="">Select</option>';
	 foreach($cities as $cities) {
	 $select_options.= '<option value="'.$cities["id"].'">'.$cities["location_name"].'</option>'; 
	 }
	} else {
	 $select_options.= '<option value="">No Records Found</option>';
	}
	echo $select_options;
	}
	
	
	
	public function  getStateByCountry() {
	 $select_options = '';
	 $country_id = $this->input->post('user_country');
	 $countries = get_state_by_cont_id($country_id); 
	 if($countries) { 
	 $select_options.= '<option value="">Select</option>';
	 foreach($countries as $countries) {
	 $select_options.= '<option value="'.$countries["id"].'">'.$countries["name"].'</option>'; 
	 }
	} else {
	 $select_options.= '<option value="">No Records Found</option>';
	}
	echo $select_options;
	}
	
public function  getDepartmentStoreWise() {
global $uInfo;
$comp_code = $uInfo['comp_code'];
	 $select_options = '';
	 $store_id = $this->input->post('store_id');
	 $users  = $this->managereports_model->getUsersStoreWise($store_id,$comp_code); 
	 if($users) {
	 foreach($users as $users) {
	 $department[] = $users->department_id;
	 }
	 $department_string = implode( ",", $department );
	 $department_array = explode( ",", $department_string );
	 $department_array_unique = array_unique($department_array);
	 $select_options.= '<option value="">Select</option>';
	 foreach($department_array_unique as $depart) {
	 $department_arr =  get_department_details_by_id($depart);
	 if($department_arr) {
	 $select_options.= '<option value="'.$department_arr[0]["department_id"].'">'.$department_arr[0]["department_name"].'</option>'; } 
	 }
	 
	 } else {
	 echo  $select_options.= '<option value="">No Records Found</option>'; die;
	  
	 }
	echo $select_options;
	}
	
	public function  getStoresByCity() {
	global $uInfo;
	$compCode = $uInfo['comp_code'];
	if(isset($_GET['table'])) {
	 $select_options = '';
	 $city_id = $this->input->post('city_id');
	 $stores  = get_stores_by_city_id($city_id,$compCode); 
	 if(!empty($stores)) { 
	 $select_options .= '<table class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Store Name</th>
						<th>Location</th>
                        <th>City</th>
						<th>State</th>
                     </tr>
                  </thead>
                  <tbody>';
                    
				 foreach($stores as $stores) { 
                        
						$select_options .=  '<tr>
						<td></td>  
						<td class="">';
						$select_options .= $stores['store_name'];
						
						$select_options .='</td>
						<td>';
						$select_options .=  get_location_by_id($stores['store_location_id']	);$select_options .='</td> 
						<td>';
						$select_options .= get_city_by_id($stores['store_city_id']);
						$select_options .='</td>
						<td>';
						$select_options .= get_state_by_id($stores['store_state_id']);
						$select_options .='</td></tr>';

					} // Loop Close
  
	$select_options .='</tbody>
               </table>';
	
	} else {
	 				$select_options.= '<h2>No Records Found</h2>';
	       }
	echo $select_options;
	}
	 else {
	 $select_options = '';
	 $city_id = $this->input->post('city_id');
	 $stores = get_stores_by_city_id($city_id,$compCode); 
	 if($stores) { 
	 $select_options.= '<option value="">Select</option>';
	 foreach($stores as $stores) {
	 $select_options.= '<option value="'.$stores["store_id"].'">'.$stores["store_name"].'</option>'; 
	 }
	} else {
	 $select_options.= '<option value="">No Records Found</option>';
	}
	echo $select_options;
	}
	
	}
	
	
	public function getStoresByLocation()
	{
	
	 $select_options = '';
	 $location_id = $this->input->post('location_id');
	 $stores = get_stores_by_location_id($location_id); 
	 if($stores) { 
	
	$select_options .= '<table id="store-table-filter" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Store Name</th>
						<th>Location</th>
                        <th>City</th>
						<th>State</th>
                     </tr>
                  </thead>
                  <tbody>';
                     $i=1;
				 foreach($stores as $stores) { 
                        
												$select_options .=  '<tr>
												<td>'.$i.'</td>  
												<td class="">';
												$select_options .= $stores['store_name'];
												$select_options .='</td>
												<td>';
												$select_options .=  get_location_by_id($stores['store_location_id']	);$select_options .='</td> 
												<td>';
												$select_options .= get_city_by_id($stores['store_city_id']);
												$select_options .='</td>
												<td>';
												$select_options .=     get_state_by_id($stores['store_state_id']);
												$select_options .='</td></tr>';
                  
   											$i++; } // Loop Close
  $select_options .='</tbody>
               </table>';
	} else {
	 		$select_options.= '<h2>No Records Found</h2>';
	       }
	echo $select_options;
	
	}


	public function getDealerInfoForFilter()
	{
		$select_options = '';
		$dealerName = $this->input->post('dealer_name');
		$dealer_city = $this->input->post('dealer_city');
		$start_price = $this->input->post('start_price');
		$end_price = $this->input->post('end_price');

		$dealerInfo = $this->managereports_model->getDealerInfoForFilter($dealerName,$dealer_city,$start_price,$end_price);

		$select_options .= '<table id="store-table-filter" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Dealer Name</th>
						<th>Email</th>
                        <th>City</th>
						<th>Address</th>
						<th>Mobile</th>
						<th>Credit Limit</th>
						<th>Firm Name</th>
                     </tr>
                  </thead>
                  <tbody>';

                  if(!empty($dealerInfo)) {
                  $i=1;
                  foreach($dealerInfo as $dealerInfos) {
                  	$select_options .= '<tr>
                  				<td>'.$i.'</td>
                  				<td>'.$dealerInfos->f_name.' '. $dealerInfos->l_name .'</td>
                  				<td>'.$dealerInfos->email.'</td>
                  				<td>'.$dealerInfos->city.'</td>
                  				<td>'.$dealerInfos->address.'</td>
                  				<td>'.$dealerInfos->mobile_number.'</td>
                  				<td>'.$dealerInfos->dealer_credit_limits.'</td>
                  				<td>'.$dealerInfos->firm_name.'</td></tr>';
                  $i++; } } else {
	 			$select_options.= '<tr><td colspan="8">No Records Found</td></tr>';
	       }
        $select_options .='</tbody>
               </table>';
           
		echo $select_options;
	}


	public function getVendorInfoForFilter()
	{
		$select_options = '';
		$vendor_name = $this->input->post('vendor_name');
		$vendor_mob_number = $this->input->post('vendor_mob_number');
		$dealer_city = $this->input->post('dealer_city');

		$vendorInfo = $this->managereports_model->getVendorInfoForFilter($vendor_name,$vendor_mob_number,$dealer_city);

		$select_options .= '<table id="store-table-filter" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Vendor Name</th>
						<th>Email</th>
                        <th>City</th>
						<th>Address</th>
						<th>Mobile</th>
						<th>Firm Name</th>
                     </tr>
                  </thead>
                  <tbody>';
                  if(!empty($vendorInfo)) {
                  	 $i=1;
                  	 foreach($vendorInfo as $vendorInfos) {
                  	 	$select_options .= '<tr>
                  				<td>'.$i.'</td>
                  				<td>'.$vendorInfos->f_name.' '. $vendorInfos->l_name .'</td>
                  				<td>'.$vendorInfos->email.'</td>
                  				<td>'.$vendorInfos->city.'</td>
                  				<td>'.$vendorInfos->address.'</td>
                  				<td>'.$vendorInfos->mobile_number.'</td>
                  				<td>'.$vendorInfos->firm_name.'</td></tr>';
                  	 $i++; }
                  }  else {
	 			$select_options.= '<tr><td colspan="8">No Records Found</td></tr>';
	       }
        $select_options .='</tbody>
               </table>';
        echo $select_options;
	}



	public function getDealerPayments()
	{
	global $uInfo;
		
		$dealer_id  = $this->input->get('dealer_id');
		
		$data['title'] = 'Report | Transactional';
		$data['heading'] = 'Transactional Report';
		$html = '';
		$html .= '<table id="dealerPayment-table" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
					    <th>#</th>
                        <th>Date</th>
						<th>Trans. Type</th>
                        <th>Reference ID</th>
						<th>Debit</th>
						<th>Credit</th>
						<th>Balance</th>
					 </tr>
                  </thead>
                  <tbody>';
                    $account = $this->managereports_model->getDealerAcountById($dealer_id);
					if(!empty($account)) {
		
					   $i = 1;
					  foreach($account as $account) { 
                      if($account->credit>0) {
					  	$trans_type = 'PAY';
					  	$invoice_no = 'By Cash';
					  } else  {
					  	$trans_type = 'INV';
					  	$invoice_no = $account->invoice_id;
					  }
					  
					  if($account->mode_of_payment=='1') {
					  $mode_of_payment = 'Yes';
					  } else  { $mode_of_payment = '-'; }
					   if($account->comments!='') {
					  $comments  = $account->comments;
					  } else  { $comments = '-'; }
					  $balnce_text = '';

					  if($account->total_amount==0) {
					  	$balnce_text = ''; 
					  }
					  else if($account->total_amount>0) {
					  	$balnce_text = 'Cr'; 
					  } else {
					  	$balnce_text = 'Dr';
					  }
					  
                      $html .= '<tr>
                        <td>'; 
						$html .= $i;
						$html .='</td>  
						<td>'.$account->created.'</td>	
						<td>'.$trans_type.'</td>
						<td class="">'.$invoice_no.'</td>
                        <td>'.$account->debit.'</td>
						<td>'.$account->credit.'</td>
						<td>'.$account->total_amount.'</td>
						</tr>';
                       $i++; } 
 					} 
$html .='</tbody>
</table><script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#dealerPayment-table").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null, null, 
				        ]
				      });

				    });	

               </script>';

echo $html;
	} 
	
	
	public function dealerReportByDate()
	{
	
	
	global $uInfo;
		
		$dealer_id  = $this->input->get('dealer_id');
		$dealer_from_date = explode("-",$this->input->get('dealer_from_date'));
	$from = $dealer_from_date[2]."-".$dealer_from_date[1]."-".$dealer_from_date[0];
	$dealer_end_date = explode("-",$this->input->get('dealer_end_date'));
	$to = $dealer_end_date[2]."-".$dealer_end_date[1]."-".$dealer_end_date[0];
		$data['title'] = 'Report | Transactional';
		$data['heading'] = 'Transactional Report';
		$html = '';
		$html .= '<table id="dealer_report_filter" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                       
					    <th>#</th>
                        <th>Doc. Date</th>
						<th>Trans. Type</th>
                        <th>Reference Id</th>
						<th>Debit</th>
						<th>Credit</th>
						<th>Balance</th>
					 </tr>
                  </thead>
                  <tbody>';
                      $account = $this->managereports_model->getDealerAcountByIdAndDate($dealer_id,$from,$to);
		if(!empty($account)) {
		
					   $i = 1;
					  foreach($account as $account) { 
                      if($account->credit>0) {
					  $trans_type = 'PAY';
					  } else  {
					  $trans_type = 'INV';
					  }
					  
					  
					  if($account->mode_of_payment=='1') {
					  $mode_of_payment = 'Yes';
					  } else  { $mode_of_payment = '-'; }
					   if($account->comments!='') {
					  $comments  = $account->comments;
					  } else  { $comments = '-'; }
					  $balnce_text = '';
					  if($account->total_amount>0) {
					  $balnce_text = 'Cr'; 
					  } else {
					  $balnce_text = 'Dr';
					  }
					  
                      $html .= '<tr>
                        <td>'; 
						$html .= $i;
						$html .='</td>  
						<td>'.$account->created.'</td>	
						<td>'.$trans_type.'</td>
						<td class="">'.$account->invoice_id.'</td>
                        <td>'.$account->debit.'</td>
						<td>'.$account->credit.'</td>
						<td>'.$account->total_amount.' '.$balnce_text.'</td>
						</tr>';
                       $i++;} 
				} 
				$html .='</tbody>
				</table><script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#dealer_report_filter").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null,
				        ]
				      });

				    });	

               </script>';

			echo $html;
		} 
	
	
	
	public function getVendorPayments()
	{
		global $uInfo;
		
		$vendor_id  = $this->input->get('vendor_id');
		
		$data['title'] = 'Report | Transactional';
		$data['heading'] = 'Transactional Report';
		$html = '';
		$html .= '<table id="vendorPayment-table" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Date</th>
						<th>Trans. Type</th>
                        <th>Refrence ID</th>
                        <th>Debit</th>
                        <th>Credit</th>
						<th>Balance</th>
                     </tr>
                  </thead>
                  <tbody>';
                      $account = $this->managereports_model->getVendorAcountById($vendor_id);
					if(!empty($account)) {
		
					   $i = 1;
					  foreach($account as $account) {
					  	$getInvoice = getSku('vendor_to_wh_invoice', ['invoice_id'=>$account->invoice_id]);
					  	if(!empty($getInvoice)) {
					  		$invoiceNumber = $getInvoice[0]['invoice_number'];
					  	} else {
					  		$invoiceNumber = 0;
					  	}
					  	

                        if($account->credit>0) {
					 		$trans_type = 'INV';
					 		$invoice_no = $invoiceNumber;
					    } else  {
					  		$trans_type = 'PAY';
					  		$invoice_no = 'By Cash';
					    }

                     /* if($account->credit=='1') {
					  $credit = 'Yes';
					  $credit_amt = $account->amount;
					  } else  { $credit = '-'; 
					  $debit_amt = '';
					  }
					  
					  if($account->debit=='1') {
					  $debit = 'Yes';
					  $debit_amt = $account->amount;
					  } else  { $debit = '-'; $credit_amt = ''; }*/


					if($account->debit!='') {
					$debit = 'Yes';
					$debit_amt = $account->debit;
					} else  { $debit_amt = '-'; $credit_amt = '-'; }	

					if($account->credit!='') {
					$credit = 'Yes';
					$credit_amt = $account->credit;
					} else  { $credit_amt = '-'; 
					$debit_amt = '-';
					}
					  
					if($account->total_amount>0) {
						$balnce_text = 'Cr'; 
					} else {
					  	$balnce_text = 'Dr';
					}
					  
					  if($account->mode_of_payment=='1') {
					  $mode_of_payment = 'Yes';
					  } else  { $mode_of_payment = '-'; }
					   if($account->comments!='') {
					  $comments  = $account->comments;
					  } else  { $comments = '-'; }

					  
                      $html .= '<tr>
                        <td>'; 
						$html .= $i;
						$html .='</td> 
						<td>'.$account->created.'</td>	
						<td>'.$trans_type.'</td> 
						<td class="">'.$invoice_no.'</td>
                        <td>'.$debit_amt.'</td>
						<td>'.$credit_amt.'</td>
						<td>'.$account->total_amount.'</td>
						</tr>';
                       $i++;  } 
			 } 
			$html .='</tbody>
			</table><script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#vendorPayment-table").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null,
				        ]
				      });

				    });	

               </script>';

		echo $html;
	
	} 
	
	
	public function vendorReportByDate()
	{
	global $uInfo;
		
		$vendor_id  = $this->input->get('vendor_id');
		
	$vendor_from_date = explode("-",$this->input->get('vendor_from_date'));
	$from = $vendor_from_date[2]."-".$vendor_from_date[1]."-".$vendor_from_date[0];
	$vendor_end_date = explode("-",$this->input->get('vendor_end_date'));
	$to = $vendor_end_date[2]."-".$vendor_end_date[1]."-".$vendor_end_date[0];
		$data['title'] = 'Report | Transactional';
		$data['heading'] = 'Transactional Report';
		$html = '';
		$html .= '<table id="vendor_report_filter"  class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Date</th>
						<th>Trans. Type</th>
                        <th>Reference ID</th>
                        <th>Debit</th>
                        <th>Credit</th>
						<th>Balance</th>
                     </tr>
                  </thead>
                  <tbody>';
                      $account = $this->managereports_model->getVendorAcountByIdAndDate($vendor_id,$from,$to);
		if(!empty($account)) {
		
					   $i = 1;
					  foreach($account as $account) {

                       if($account->credit>0) {
					 	$trans_type = 'PAY';
					 	$invoice_no = 'By Cash';
					  } else  {
					  	$trans_type = 'INV';
					  	$invoice_no = $account->invoice_id;
					
					  }

                     /* if($account->credit=='1') {
					  $credit = 'Yes';
					  $credit_amt = $account->amount;
					  } else  { $credit = '-'; 
					  $debit_amt = '';
					  }
					  
					  if($account->debit=='1') {
					  $debit = 'Yes';
					  $debit_amt = $account->amount;
					  } else  { $debit = '-'; $credit_amt = ''; }*/


					if($account->debit!='') {
					$debit = 'Yes';
					$debit_amt = $account->debit;
					} else  { $debit_amt = '-'; $credit_amt = '-'; }	

					if($account->credit!='') {
					$credit = 'Yes';
					$credit_amt = $account->credit;
					} else  { $credit_amt = '-'; 
					$debit_amt = '-';
					}
					  
					if($account->total_amount>0) {
					  
					  $balnce_text = 'Cr'; 
					  } else {
					  $balnce_text = 'Dr';
					  
					  }
					  
					  if($account->mode_of_payment=='1') {
					  $mode_of_payment = 'Yes';
					  } else  { $mode_of_payment = '-'; }
					   if($account->comments!='') {
					  $comments  = $account->comments;
					  } else  { $comments = '-'; }
                      $html .= '<tr>
                        <td>'; 
						$html .= $i;
						$html .='</td> 
						<td>'.$account->created.'</td>	
						<td>'.$trans_type.'</td>
						<td class="">'.$invoice_no.'</td>
                        <td>'.$credit_amt.'</td>
						<td>'.$debit_amt.'</td>
						<td>'.$account->total_amount.' '.$balnce_text.'</td>
						</tr>';
                       $i++; } 
			 } 
			$html .='</tbody>
			</table> <script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#vendor_report_filter").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null,
				        ]
				      });

				    });	

               </script>';

		echo $html;
	
	} 
	
	
	
	
public function getTaxesByCityState()
	{
	global $uInfo;
		
		
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$html = '';
		$html .= '<table  class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Tax Name</th>
						<th>Rate</th>
                        <th>City</th>
						<th>State</th>
						<th>Country</th>
						<th>Zip code</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>';
                      $taxes  = $this->managereports_model->getTaxesByCityState();
		if(!empty($taxes)) {
		
					   $i = 1;
					             foreach($taxes as $taxes) { 
                      
                      $html .= '<tr>
                        <td>'; 
						$html .= $i;
						$html .='</td>  
						<td class="">'.$taxes->tax_name.'</td>
                        <td>'.$taxes->rate.'%</td>
						<td>'.get_city_by_id($taxes->city_id).'</td>
						<td>'.get_state_by_id($taxes->state_id).'</td>
						<td>'.get_country_by_id($taxes->country_id).'</td>	
                        <td>'.$taxes->zipcode.'</td>
						<td>';
						 if($taxes->tax_status=='1') { 
						 
						 $html .= "active"; } else { $html .= "Inactive"; } $html .='</td></tr>';
                       $i++;} 
 } 
$html .='</tbody>
</table>';

echo $html;
	
	}
	
public function getproductsbycatandprice()
{
	global $uInfo;
		
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$html = '';
		$html .= '<table id="myTable-filter" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Product Name</th>
						 <th>Category</th>
                        <th>Sub Category</th>
                        <th>Sub of Sub Category</th>
						<th>Attributes</th>
						<th>Product Image</th>
					    <th>Product Price</th>
                        <th>Product Status</th>
                     </tr>
                  </thead>
                  <tbody>';
		$products  = $this->managereports_model->getProductsByCatPrice($uInfo['comp_code']);
		if(!empty($products)) {
		foreach($products as $product) {
		$html .=  '<tr><td>';
		$html .= $product->product_id;
						$html .='</td>  
						<td class="">';
						$html .= $product->product_name;
						$html .='</td>
                        <td>';
                           $productCategory = getParentCategory($product->product_category);
						   if(isset($productCategory) && !empty($productCategory)){
                           		$html .= $productCategory->cat_name;
						   }
						   $html .='</td><td>';
						   $productSubCategory = getParentCategory($product->product_sub_category);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		$html .= $productSubCategory->cat_name;
						   }
						    if($product->product_sub_category==0)
						   {
							$html .= 'Not Define';
						   }
                           
						   $html .='</td><td>';
						   $productSubCategory = getParentCategory($product->product_sub_of_sub_category);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		 $html .= $productSubCategory->cat_name;
						   }
						   if($product->product_sub_of_sub_category==0)
						   {
							$html .= 'Not Define';
						   }
                       $html .='</td>	
                        <td>';
                           $attr_name = get_attribute_by_productID($product->product_id);
						   if(isset($attr_name) && !empty($attr_name)){
							   $count_array = count($attr_name);
							   if(!empty($attr_name)){
								   for($i=0;$i<$count_array;$i++){
										$html .= $attr_name[$i]; 
								   }
							   }else{
								  $html .= 'Not Set';
							   }
                           }
						 
                    $p_image =  base_url().'uploads/product_image/'.$product->product_image; 
						$html .='</td>
						<td><img src="'.$p_image.'" width="30px" height="30px"></td>
                        <td>';
						$html .= $product->product_price;
						$html .= '</td>
                        <td>'; if($product->product_status == "1"){ 
						$html .= 'active';}else{ $html .= 'inactive';}
						$html .='</td></tr>'; 
		}
		
		
		}  else {  $html .= '<tr><td colspan="9">No Recods Found.</td></tr>';  }
		$html .= '</table>';
		echo $html;
}
public function getUsersByDepart()
{
		global $uInfo;
		$depart_id = $this->input->post('depart_id');
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$data['ajax_req'] = TRUE;
		$users  = $this->managereports_model->getUsersByDepart($depart_id);
		$html = '';
		if(!empty($users)) { 
		$html .= '<table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Name</th>
						<th>Assigned Store</th>
                        <th>Assigned Warehouse</th>
                        <th>Email</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>';
                     $i=1;
                        foreach($users as $users) { 
                        
                    $html .= '<tr>
                        <td class="center"></td>
                        <td>'.$users->user_full_name.'</td> 
						   <td>';
						   $stores = store_details_by_id($users->store_id);
						  if(!empty($stores)) {
						   foreach($stores as $stores) {
						    $html .= $stores['store_name'].'</br>';
						    } } else  { $html .= 'Not Assigned.'; } 
												$html .=	'</td>
						   <td>';
						   $warehouses = warehouse_details_by_id($users->warehouse_id);
						  if(!empty($warehouses)) {
						   foreach($warehouses as $warehouses) {
						 $html .= $warehouses['warehouse_name']."</br>";
						    } } else  { $html .= "Not Assigned."; } 
							
							$html .='</td>  
                        <td>'.$users->user_email.'</td>
						<td>';
						 if($users->user_account_status=='1')  { $html .= "Active";  } else {  $html .= 'Inactive'; }
						 
						 $html .= '</td>
						</tr>';
  $i++;
  }
  $html .= '</tbody>
               </table>';}  else { $html .= '<h2>No Records Found.</h2>';  }
	
		echo $html;

}
public function getUsersStoreWise()
{
		global $uInfo;
		$store_id = $this->input->post('store_id');
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$data['ajax_req'] = TRUE;
		$users  = $this->managereports_model->getUsersStoreWise($store_id);
		$html = '';
		if(!empty($users)) { 
		$html .= '<table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Name</th>
						<th>Assigned Store</th>
                        <th>Assigned Warehouse</th>
                        <th>Email</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>';
                     
                        foreach($users as $users) { 
                        
                    $html .= '<tr>
                        <td class="center">
                        </td>
                        <td>'.$users->user_full_name.'</td> 
						   <td>';
						   $stores = store_details_by_id($users->store_id);
						  if(!empty($stores)) {
						   foreach($stores as $stores) {
						    $html .= $stores['store_name'].'</br>';
						    } } else  { $html .= 'Not Assigned.'; } 
							$html .= '</td>
						   <td>';
						   $warehouses = warehouse_details_by_id($users->warehouse_id);
						  if(!empty($warehouses)) {
						   foreach($warehouses as $warehouses) {
						 $html .= $warehouses['warehouse_name']."</br>";
						    } } else  { $html .= "Not Assigned."; } 
							
							$html .='</td>  
                        <td>'.$users->user_email.'</td>
						<td>';
						 if($users->user_account_status=='1')  { $html .= "Active";  } else {  $html .= 'Inactive'; }
						 
						 $html .= '</td>
						</tr>';
                  
  
  }
  $html .= '</tbody>
               </table>';}  else { $html .= '<h2>No Records Found.</h2>';  }
	
		echo $html;

}

public function getStoresFilters()
{


global $uInfo;
		$location_id = $this->input->post('location_id');
		$city_id = $this->input->post('city_id');
		$state_id = $this->input->post('state_id');
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$data['ajax_req'] = TRUE;
		$users  = $this->managereports_model->getStoresFilter();
		$html = '';
		if(!empty($users)) { 
		$html .= '<table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Name</th>
						<th>Assigned Store</th>
                        <th>Assigned Warehouse</th>
                        <th>Email</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>';
                     
                    foreach($users as $users) { 
                    $html .= '<tr>
                        <td class="center">
                        </td>
                        <td>'.$users->user_full_name.'</td> 
						   <td>';
						   $stores = store_details_by_id($users->store_id);
						   if(!empty($stores)) {
						   foreach($stores as $stores) {
						    $html .= $stores['store_name'].'</br>';
						    } } else  { $html .= 'Not Assigned.'; } 
												$html .=	'</td>
						   <td>';
						   $warehouses = warehouse_details_by_id($users->warehouse_id);
						  if(!empty($warehouses)) {
						   foreach($warehouses as $warehouses) {
						 $html .= $warehouses['warehouse_name']."</br>";
						    } } else  { $html .= "Not Assigned."; } 
							
						$html .='</td>  
                        <td>'.$users->user_email.'</td>
						<td>';
						 if($users->user_account_status=='1')  { $html .= "Active";  } else {  $html .= 'Inactive'; }
						 
						 $html .= '</td>
						</tr>';
                  
  }
  $html .= '</tbody>
               </table>';}  else { $html .= '<h2>No Records Found.</h2>';  }
		echo $html;

}

public function getUsersWarehouseWise()
{
		global $uInfo;
		$warehouse_id = $this->input->post('warehouse_id');
		$data['title'] = 'Report | General';
		$data['heading'] = 'General Report';
		$data['ajax_req'] = TRUE;
		$users  = $this->managereports_model->getUsersWarehouseWise($warehouse_id);
		$html = '';
		if(!empty($users)) { 
		$html .= '<table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Name</th>
						<th>Assigned Store</th>
                        <th>Assigned Warehouse</th>
                        <th>Email</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>';
                     
                        foreach($users as $users) { 
                        
                    $html .= '<tr>
                        <td class="center">
                        </td>
                        <td>'.$users->user_full_name.'</td> 
						   <td>';
						   $stores = store_details_by_id($users->store_id);
						   if(!empty($stores)) {
						   foreach($stores as $stores) {
						    $html .= $stores['store_name'].'</br>';
						    } } else  { $html .= 'Not Assigned.'; } 
												$html .=	'</td>
						   <td>';
						   $warehouses = warehouse_details_by_id($users->warehouse_id);
						  if(!empty($warehouses)) {
						   foreach($warehouses as $warehouses) {
						 $html .= $warehouses['warehouse_name']."</br>";
						    } } else  { $html .= "Not Assigned."; } 
							
							$html .='</td>  
                        <td>'.$users->user_email.'</td>
						<td>';
						 if($users->user_account_status=='1')  { $html .= "Active";  } else {  $html .= 'Inactive'; }
						 
						 $html .= '</td>
						</tr>';
                  
  
  }
  $html .= '</tbody>
               </table>';}  else { $html .= '<h2>No Records Found.</h2>';  }
	
		echo $html;

}

	public function viewOrdersByOrderId($order_id)
	{
		global $uInfo;
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'Orders Details';
		$data['ordersByOrderId'] = $this->manageorders_model->getAllOrdersById($order_id);
		$data['getCustomerAddress'] = $this->manageorders_model->getCustomerAddressId($order_id);
		$data['getShippingAddress'] = $this->manageorders_model->getShippingAddressById($order_id);
		$data['ordersDetailsByOrderId']= $this->manageorders_model->getAllOrdersDetailsByOrderId($order_id);
		
		$this->load->view('manageOrders/viewOrdersByOrderId',$data);
	}

	public function addShipment($order_id)
	{
		global $uInfo;
		if(isset($_POST['quantity'])) {
		$order_shipment = array(
		'order_id' => $order_id,
		'shipment_status' => $this->input->post('shipment_status'),
		'address' => $_POST['address'],
		'remark' => $_POST['remark'],
		'date' => date('Y-m-d')
		);
		$this->db->insert('order_shipment',$order_shipment);
		$order_shipment_id = $this->db->insert_id();
		if($order_shipment_id!='') {
		 $centerWareHouseId = getWarehouseIsCentral();
		 $centerWareHouseId = $centerWareHouseId->warehouse_id;
		foreach($_POST['quantity'] as $p_id=>$qty) {
		$shipment_details_data  = array(
		'shipment_id' => $order_shipment_id,
		'order_id' => $order_id,
		'product_id' => $p_id,
		'quantity' => $qty,
		'date' => date('Y-m-d')
		);
		$this->db->insert('order_shipment_detail',$shipment_details_data);
		$this->updateStcokOfCenterWarehouse($p_id,$centerWareHouseId,$qty);
		
		}
		$order_update_data = array('order_status'=>$this->input->post('shipment_status'));
		$this->db->where('order_id', $order_id);
        $this->db->update('orders', $order_update_data);
		$this->session->set_flashdata('success_msg', 'Order Shipment Added Successfully.');
		redirect('webadmin/manageorders/viewOrders');
		
		} else {
		echo "Something is wrong please try again"; die;
		}
		}
		$data['title'] = 'Orders | Inventory';
		$data['heading'] = 'Add Shipment';
		$data['orders']= $this->manageorders_model->getAllOrders();
		$data['order_id'] = $order_id;
		$this->load->view('manageOrders/addShipment',$data);
	}
	
	public function viewShipment($order_id)
	{
			
			global $uInfo;
		$data['title'] = 'Orders | Inventory | Shipments';
		$data['heading'] = 'View Shipment';
		$data['orders']= $this->manageorders_model->getShipments($order_id);
		$data['order_id'] = $order_id;
		$this->load->view('manageOrders/viewShipment',$data);
	}
	
	function orderPdfGenerator(){ // for pdf generate on view orders page

		$this->load->library('pdf');
		$this->pdf->load_view('common/manageorder');
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}
	public function checkStock()
	{
	 	 $product_id = $_POST['product_id'];
		 $qty = $_POST['qty'];
		 if($product_id=='') {
		 echo "Product id is manadory for check stock";
		 } else {
		 $centerWareHouseId =  getWarehouseIsCentral();
		 $centerWareHouseId = $centerWareHouseId->warehouse_id;
	     $res =  getStockByProductAndWarehouseId($product_id,$centerWareHouseId);
		echo  $avail_stock =  $res->stock_qty;
		
		 
		 
		 } 
	}
	
	public function updateStcokOfCenterWarehouse($p_id,$centerWareHouseId,$qty)
	{
	 $sql = "UPDATE warehouse_inventory SET stock_qty=stock_qty - '$qty' WHERE warehouse_id='$centerWareHouseId' and product_id='$p_id'";
     $this->db->query($sql);
		
	} 
	public function orderChangeStatus(){
		$orderId = $this->input->post('orderId');
		$orderStatus = $this->input->post('orderStatus');
		$data = array(
    			'order_status' => $orderStatus
    			);
		$this->manageorders_model->changeOrderStatus($orderId, $data);
		$this->session->set_flashdata('success_msg', 'Order status changed successfuly !!!');
		redirect(base_url().'webadmin/manageorders/viewOrders');
	}


	

       

	

	function getProductById() {
		global $uInfo;
		$id = $this->input->get('productId');
		$product = $this->manageproduct_model->getProductById($id);
		$data['title'] = 'Report | Product';
		$data['heading'] = 'Product Report';
		$html = '';
		$html .= '<table id="trans-product-table" class="table table-striped table-borderedss table-hover">
					<thead>
                     <tr>
                     	<th>#</th>
                        <th>Product Name</th>
						<th>Category</th>
					    <th>Sub Category</th>
                        <th>Sub of Sub Category</th>
                        <th>Attributes</th>
                        <th>Product Image</th>
						<th>Product Price</th>
						<th>Product Status</th>
                     </tr>
                     </thead>
                     <tbody>';
                     $i = 0;
                     foreach($product as $key=>$products) {
                     	$productCategory = getParentCategory($products->product_category);
						   if(isset($productCategory) && !empty($productCategory)){
                           		$productCategory = $productCategory->cat_name;
						   }

						$productSubCategory = getParentCategory($products->product_sub_category);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		$productSubCategory = $productSubCategory->cat_name;
						   }
						    if($products->product_sub_category==0)
						   {
							$productSubCategory = "Not Define";
						   }

						$productSubSubCategory = getParentCategory($products->product_sub_of_sub_category);
						   if(isset($productSubSubCategory) && !empty($productSubSubCategory)){
                           		$productSubSubCategory= $productSubCategory->cat_name;
						   }
						   if($products->product_sub_of_sub_category==0)
						   {
							$productSubSubCategory= "Not Define";
						   }

						$attr_name = get_attribute_by_productID($products->product_id);
						   if(isset($attr_name) && !empty($attr_name)){
							   $count_array = count($attr_name);
							   if(!empty($attr_name)){
							   	$attribute = '';
								   for($i=0;$i<$count_array;$i++){
										$attribute .= $attr_name[$i].','; 
								   }
								   $attribute = rtrim($attribute, ',');
							   }else{
								  $attribute = "Not Set";
							   }
                           } else {
                           	$attribute = '-';
                           }
                           $attr_name = get_attribute_by_productID($products->product_id);
                        $imgUrl = base_url().'uploads/product_image/'.$products->product_image;
                        $key = $key+1;
                     	$html .= '<tr>
                     		<td>'.$key.'</td>
                     		<td>'.$products->product_name.'</td>
                     		<td>'.$productCategory.'</td>
                     		<td>'.$productSubCategory.'</td>
                     		<td>'.$productSubSubCategory.'</td>
                     		<td>'.$attribute.'</td>
                     		<td><img src="'.$imgUrl.'" width="30px" height="30px"></td>
                     		<td>'.$products->product_price.'</td>
                     		<td>'.$products->product_status.'</td>
                     	</tr>';
                    $i++; }
                     $html .= '</tbody></table><script type="text/javascript">
               	$(document).ready(function(){

				     var oTable1 = $("#trans-product-table").dataTable({
				   
				      "aoColumns": [
				          { "bSortable": false },
				          null, null,null, null, null,null, null,null,
				        ]
				      });

				    });	

               </script>';
                     echo $html;
	}

	public function salesReport() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$data['title']   = 'Report| Daily Sales';
		$data['heading'] = 'Daily Sales Report';
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
		//$users=get_user_name_by_role_ID($rolecode);
		
		
		if($this->input->post('fromdateval')!='' || $this->input->post('employee_id')!='' || $this->input->post('store_id')!='') {
			$fromdateval=$this->input->post('fromdateval');
			$todateval=$this->input->post('todateval');
			$employeeId=$this->input->post('employee_id');
			$storeId=$this->input->post('store_id');
		} else {
			$fromdateval='';$todateval='';
			$employeeId='';
			$storeId='';
		}

		$dailyReport = $this->managereports_model->dailySaleReport($fromdateval,$todateval,$employeeId,$storeId);
		$id='';
        foreach($dailyReport as $dailyReports) {
            
            $saleId=$dailyReports['sale_ID'];
            if($id==$saleId) {
                if($dailyReports['payment_method']=='cash') {
                    $cash=['cash'=>$dailyReports['payment_amount']];
                } 
                if($dailyReports['payment_method']=='ccard') {
                    $ccredit=['ccredit'=>$dailyReports['payment_amount']];
                }
                if($dailyReports['payment_method']=='dcard') {
                    $dcard=['dcard'=>$dailyReports['payment_amount']];
                }
                if($dailyReports['payment_method']=='check') {
                    $check=['check'=>$dailyReports['payment_amount']];
                }

                $creditNote=$dailyReports['payment_method'];
                $checkCreditNote=substr($dailyReports['payment_method'], 0, 2);
                if($checkCreditNote=='CN') {
                    $creditNoteAry=['creditNote'=>$creditNote];
                }
                $info=['store_id'=>$dailyReports['store_ID'],
                    'total'=>$dailyReports['total'],
                	'remark'=>$dailyReports['remark']];
            } else {
                if($dailyReports['payment_method']=='cash') {
                    $cash=['cash'=>$dailyReports['payment_amount']];
                } else {
                    $cash=['cash'=>''];
                }
                if($dailyReports['payment_method']=='ccard') {
                    $ccredit=['ccredit'=>$dailyReports['payment_amount']];
                } else {
                    $ccredit=['ccredit'=>''];
                }
                if($dailyReports['payment_method']=='dcard') {
                    $dcard=['dcard'=>$dailyReports['payment_amount']];
                }else {
                    $dcard=['dcard'=>''];
                }
                if($dailyReports['payment_method']=='check') {
                    $check=['check'=>$dailyReports['payment_amount']];
                }else {
                    $check=['check'=>''];
                }
                $creditNote=$dailyReports['payment_method'];
                $checkCreditNote=substr($dailyReports['payment_method'], 0, 2);
                if($checkCreditNote=='CN') {
                    $creditNoteAry=['creditNote'=>$creditNote];
                } else {
                    $creditNoteAry=['creditNote'=>''];
                }
                 $info=['store_id'=>$dailyReports['store_ID'],
                    'total'=>$dailyReports['total'],
                	'remark'=>$dailyReports['remark']];
            }

            $data['sale'][$saleId]=array_merge($info,$cash,$ccredit,$dcard,$check,$creditNoteAry);
           $id=$saleId;
        }
      	
      	if($this->input->post('fromdateval')!='' || $this->input->post('employee_id')!='' || $this->input->post('store_id')!='' || $this->input->post('status') == 1) {
      	 	$this->load->view('manageReports/saleReportFilter', $data, false);
        } else {
            $this->load->view('manageReports/viewAllSales', $data, false);
        }
	}

	function getStoresByLoc(){
        global $uInfo;
        $param=array();
        $select_options = '';
        $locID=$this->input->post('locID');
        if(isset($locID) && !empty($locID)){
            
            $param['comp_code']=$uInfo['comp_code'];
            $param['locID']=$locID;
            $stores=$this->managereports_model->getStoresByLocID($param);

            if(isset($stores) && !empty($stores)) { 
             $select_options.= '<option value="">Select</option>';
             foreach($stores as $store) {
             $select_options.= '<option value="'.$store["store_id"].'">'.$store["store_name"].'</option>'; 
             }
            } else {
             $select_options.= '<option value="">No Records Found</option>';
            }
             echo $select_options;

        }else{
            echo  $select_options.= '<option value="">Select Location</option>';
        }

    }


    function generatePdfSaleSummary() {
    	global $uInfo;
		
		//$filterinfo=$this->input->get('filterinfo');
		$this->load->library('pdf');

	  $comp_code = $uInfo['comp_code'];
	  $from = $this->input->get('from_date');
	  $to = $this->input->get('end_date');
	
   
        //$sql  = "SELECT created_date as Date, transaction_id as TransNo, 	mode_of_payment, debit, credit,amount,total_balance,comments FROM cash_book WHERE (created_date BETWEEN '$from' AND '$to') and comp_code='$comp_code'";

         $sql  = "SELECT *, count(sale_ID) as no_of_sale, DATE(date_time_created) as sale_date, SUM(sub_total) as sub_total, SUM(total) as total FROM (`sale`) WHERE (DATE(date_time_created) BETWEEN '$from' AND '$to') and `comp_code` = '$comp_code' GROUP BY DATE(date_time_created) ORDER BY `sale_ID` ASC";
   
   
	   $query = $this->db->query($sql);	
	  
		if($query->num_rows() > 0){
	    	$row = $query->result_array();
		} else {
		 $row = array();
		  }
		
		$this->load->library('pdf');
		$data['sales'] = $row;
		$data['fromdate'] = $from;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		
		$html=$this->pdf->load_view('manageReports/generatePdfForSaleSummary',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


     function generatePdfSaleDetail() {
    	global $uInfo;
		
		//$filterinfo=$this->input->get('filterinfo');
		$this->load->library('pdf');

	  $comp_code = $uInfo['comp_code'];
	  $from = $this->input->get('from_date');
	  $to = $this->input->get('end_date');
	

        $sql  = "SELECT `sl`.*, `um`.`user_full_name` as sold_by, `sitm`.`itm_cnt` as itm_cnt, `sitm`.`cgst_amt` as cgst_amt, `sitm`.`sgst_amt` as sgst_amt, `sitm`.`igst_amt` as igst_amt
			FROM (`sale` as sl)
			LEFT JOIN `user_master` as um ON `um`.`user_ID`=`sl`.`employee_ID`
			LEFT JOIN (select count(`sale_item_ID`) as itm_cnt, sale_ID, cgst_amt, sgst_amt, igst_amt from sale_items GROUP BY sale_ID) as sitm ON `sitm`.`sale_ID`=`sl`.`sale_ID`
			WHERE (DATE(sl.date_time_created) BETWEEN '$from' and '$to')
			AND `sl`.`comp_code` =  '$comp_code'
			ORDER BY `sl`.`sale_ID` ASC";
   
   
	   $query = $this->db->query($sql);	
	
		if($query->num_rows() > 0){
	    	$row = $query->result_array();
		} else {
		 $row = array();
		  }
		
		$this->load->library('pdf');
		$data['sales'] = $row;
		$data['fromdate'] = $from;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		
		$html=$this->pdf->load_view('manageReports/generatePdfForSaleDetail',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


     function generatePdfSellingProduct() {
    	global $uInfo;
		
		//$filterinfo=$this->input->get('filterinfo');
		$this->load->library('pdf');

	  $comp_code = $uInfo['comp_code'];
	  $from = $this->input->get('from_date');
	  $to = $this->input->get('end_date');
	

        $sql  = "SELECT `S`.`sale_ID`, `SI`.`product_ID`, `SI`.`master_product_id`, `SI`.`sale_item_ID`, COUNT(SI.master_product_id) as mprdCnt, COUNT(SI.product_ID) as prdCnt, SUM(SI.quantity) as totQty, `P`.`product_name`, SUM(SI.item_subtotal) as itmTotal, `SI`.`item_cost_price` FROM (`sale` as S) INNER JOIN `sale_items` as SI ON `S`.`sale_ID` = `SI`.`sale_ID` LEFT JOIN `product` as P ON `SI`.`product_Id`=`P`.`product_id` WHERE `S`.`sale_type` = 0 AND (DATE(S.date_time_created) BETWEEN '$from' and '$to') AND `S`.`comp_code` = '$comp_code' GROUP BY `SI`.`product_ID`";
   
   
	   $query = $this->db->query($sql);	
	
		if($query->num_rows() > 0){
	    	$row = $query->result_array();
		} else {
		 $row = array();
		  }
		
		$this->load->library('pdf');
		$data['sales'] = $row;
		$data['fromdate'] = $from;
		$data['todate'] = $to;
		$data['comp_code'] = $comp_code;
		
		$html=$this->pdf->load_view('manageReports/generatePdfForSellingProduct',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }
    

     function generatePdfStockDetail() {
    	global $uInfo;
		
		//$filterinfo=$this->input->get('filterinfo');
		$this->load->library('pdf');

	    $comp_code = $uInfo['comp_code'];
	    $loc_id = $this->input->get('loc_id');
	    $store_id = $this->input->get('store_id');
	    $item_id = $this->input->get('item_id');

	    if($item_id!='') {
	    	 $sql  = "SELECT `P`.`product_name` prdName, `P`.`product_price` prdPrice, `SI`.`stock_qty` stockqty, `SI`.`product_id` sku FROM (`product` as P) LEFT JOIN `store_inventory` as SI ON `P`.`product_id`=`SI`.`master_product_id` WHERE `P`.`comp_code` = '$comp_code' AND `P`.`product_id` = '$item_id' AND `SI`.`store_id`='$store_id' AND `SI`.`stock_qty` != 0";
	    } else {
	    	 $sql  = "SELECT `P`.`product_name` prdName, `P`.`product_price` prdPrice, `SI`.`stock_qty` stockqty, `SI`.`product_id` sku FROM (`product` as P) LEFT JOIN `store_inventory` as SI ON `P`.`product_id`=`SI`.`master_product_id` WHERE `P`.`comp_code` = '$comp_code' AND `SI`.`store_id`='$store_id' AND `SI`.`stock_qty` != 0";
	    }
   
	   $query = $this->db->query($sql);	
		//echo $this->db->last_query();
		if($query->num_rows() > 0){
	    	$row = $query->result_array();
		} else {
		    $row = array();
		}
		
		$this->load->library('pdf');
		$data['prd_stock'] = $row;
		$data['storeName']=$this->managereports_model->getStoreNameByID($store_id);
		$data['comp_code'] = $comp_code;

		$html=$this->pdf->load_view('manageReports/generatePdfForStockProduct',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }

    function generatePdfAllUser() {
    	global $uInfo;

    	$country = $this->input->get('country');
	    $state = $this->input->get('state');
	    $city = $this->input->get('city');
	    $store = $this->input->get('store');
	    $depart = $this->input->get('depart');

	    if($depart!='') { 
	    	$data['users']  = $this->managereports_model->getUsersByDepart($depart);
	    	$data['comp_code'] = $uInfo['comp_code'];
	    } else { 
	    	$data['users'] = $this->managereports_model->getAllUsers($uInfo['comp_code']);
	    	$data['comp_code'] = $uInfo['comp_code'];
	    }

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllUser',$data);

		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


    function generatePdfAllStore() {
    	global $uInfo;

    	$country = $this->input->get('country');
	    $state = $this->input->get('state');
	    $city = $this->input->get('city');
	    $location = $this->input->get('location');

	    if($location!='') { 
	    	$data['allStores']  = get_stores_by_location_id($location);
	    	$data['comp_code'] = $uInfo['comp_code']; 
	    } else { 
	    	$data['allStores'] =  store_details($uInfo['comp_code']); 
	    	$data['comp_code'] = $uInfo['comp_code'];
	    }

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllStore',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


    function generatePdfAllProduct() {
    	global $uInfo;

    	$pcat = $this->input->get('pcat');
	    $psubcat = $this->input->get('psubcat');
	    $psubofsubcat = $this->input->get('psubofsubcat');
	    $pattr = $this->input->get('pattr');
	   
	    $data['allProduct'] = $this->managereports_model->getProductReport($pcat,$psubcat,$psubofsubcat,$pattr);
	    $data['comp_code'] = $uInfo['comp_code'];
	    
	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllProduct',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");

    }


    function generatePdfAllDealer() {
    	global $uInfo;

    	$name = $this->input->get('name');
	    $city = $this->input->get('city');
	    $startamt = $this->input->get('startamt');
	    $endamt = $this->input->get('endamt');

		$data['allDealer'] = $this->managereports_model->getDealerInfoForFilter($name,$city,$startamt,$endamt);
		$data['comp_code'] = $uInfo['comp_code'];

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllDealer',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


     function generatePdfAllVendor() {
    	global $uInfo;

    	$vendorName = $this->input->get('vendorName');
	    $mobNumber = $this->input->get('mobNumber');
	    $city = $this->input->get('city');

		$data['allvendor'] = $this->managereports_model->getVendorInfoForFilter($vendorName,$mobNumber,$city);
		$data['comp_code'] = $uInfo['comp_code'];

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllVendor',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }



    function generatePdfAllTax() {
    	global $uInfo;

    	$country = $this->input->get('tax_country');
	    $state = $this->input->get('tax_state');
	    $city = $this->input->get('tax_city');

		$data['alltax'] = $this->managereports_model->getTaxReport($country,$state,$city);
		$data['comp_code'] = $uInfo['comp_code'];

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllTax',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }


    function generatePdfAllOffer() {
    	global $uInfo;

    	$offername = $this->input->get('offername');
	    $startdate = $this->input->get('startdate');
	    $enddate = $this->input->get('enddate');

		$data['allOffer'] = $this->managereports_model->getAllOffers($uInfo['comp_code'],$offername,$startdate,$enddate);
		$data['comp_code'] = $uInfo['comp_code'];

		//echo '<pre>';print_r($data['allOffer']);die;

	    $this->load->library('pdf');
	    $html=$this->pdf->load_view('manageReports/generatePdfAllOffer',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
    }



    public function getWarehouseInventoryByPId() {
    	global $uInfo;
    	$pId = $this->input->get('productId');
    	$catId = $this->input->get('catId');
    	$subCatId = $this->input->get('subCatId');
    	$subSubCatId = $this->input->get('subSubCatId');
    	$attribute = $this->input->get('attribute');
    	
    	$getWarehouseInventory = $this->managereports_model->getWarehouseInventoryByPId($pId,$catId,$subCatId,$subSubCatId,$attribute);
   	 //	echo '<pre>';print_r($getWarehouseInventory);die;
    	
    	//echo $this->db->last_query();
    	
    	/*die;*/

    	$data['title'] = 'Report | Warehouse Inventory';
		$data['heading'] = 'Warehouse Report';
		$html = '';
		$html .= '<table id="warehouseInventory-table" class="table warehouseInventory-table">
					<thead>
						<tr>
							<th>#</th>
							<th>Product Name</th>
							<th>SKU</th>
							<th>Stock Quantity</th>
							<th>Warehouse Name</th>
						</tr>
					</thead><tbody>';
					if(!empty($getWarehouseInventory)) {

			$count = 1;
			foreach($getWarehouseInventory as $getWarehouseInventorys) {
				$explodeSku = explode(',',$getWarehouseInventorys['sku']);

				$explodeQty = explode(',',$getWarehouseInventorys['sqty']);

				if(strpos($getWarehouseInventorys['warehouseId'],',') === false) {
					$explodeWarehouseId = $getWarehouseInventorys['warehouseId'];
				} else {
					$explodeWarehouseId = explode(',',$getWarehouseInventorys['warehouseId']);
				}

				$warehouseName = getWarehouseName($explodeWarehouseId);


				if(strpos($getWarehouseInventorys['masterPId'],',') === false) {
					if(is_numeric($pId)) {
						$productName = product_name($pId);
						$explodeProductId[] = $productName;
					} else {
						$explodeProductId = array($getWarehouseInventorys['masterPId']);
					}
				} else { 
					$explodeProductId = explode(',',$getWarehouseInventorys['masterPId']);
				}
				
				//echo count($explodeSku).'</br>';

				$preWarehouseId = 0;
				for($i=0; $i<count($explodeSku); $i++) {

					/*if(isset($explodeWarehouseId[$i]) && !empty($explodeWarehouseId[$i])) {
						$exWarehouseId = $explodeWarehouseId[$i];
					} else {
						$exWarehouseId = $explodeWarehouseId;
					}


					if(isset($preWarehouseId) && $preWarehouseId == $exWarehouseId) {
						$warehouseName = ' ';
					} else {
						$warehouseName = getWarehouseName($exWarehouseId);
					}

					$warehouseName = getWarehouseName($exWarehouseId);*/


					if($explodeProductId[$i] != 0 && is_numeric($explodeProductId[$i])) {
						$pName = product_name($explodeProductId[$i]);
					} else if($explodeProductId[$i] != '') {
						$pName = $explodeProductId[$i];
					} else {
						$pName = '--';
					}

					$sku = $explodeSku[$i];
					$qty = $explodeQty[$i];
					
					
					$html .= '<tr>';
					$html .= '<td>'.$count.'</td>';
					$html .= '<td>'.$pName.'</td>';
					$html .= '<td>'.$sku.'</td>';
					$html .= '<td>'.$qty.'</td>';
					$html .= '<td>'.$warehouseName.'</td>';
					$html .= '</tr>';

					//$preWarehouseId = $exWarehouseId;

					$count++;
				}
			}	
		} else {
			$html .= '<tr><td>No Records.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
			</tr>';
		}
		$html .= '</tbody></table>';
    	
		echo $html;
    }



    public function getStoreInventoryByPId() {
    	global $uInfo;
    	$pId = $this->input->get('productId');
    	$catId = $this->input->get('catId');
    	$storeId = $this->input->get('storeId');
    	$attrId = $this->input->get('attrId');

    	$getStoreInventory = $this->managereports_model->getStoreInventoryByPId($pId,$catId,$storeId,$attrId);

    //	$productName = product_name($pId);

    	$data['title'] = 'Report | Store Inventory';
		$data['heading'] = 'Store Report';
		$html = '';
		$html .= '<table id="" class="table store_inventory">
					<thead>
						<tr>
							<th>#</th>
							<th>Product Name</th>
							<th>SKU</th>
							<th>Stock Quantity</th>
							<th>Store Name</th>
						</tr>
					</thead><tbody>';
					if(!empty($getStoreInventory)) {
			$count=1;
			foreach($getStoreInventory as $getStoreInventorys) {
				$explodeSku = explode(',',$getStoreInventorys['sku']);

				$explodeQty = explode(',',$getStoreInventorys['sqty']);
				$explodestoreId = explode(',',$getStoreInventorys['storeId']);

				if(strpos($getStoreInventorys['masterPId'],',') === false) {
				
					if(is_numeric($pId)) { 
						//$productName = product_name($pId);
						$explodeProductId[] = $pId;
					} else {  
						$explodeProductId[] = $getStoreInventorys['masterPId'];
					}
					
				} else {
					$explodeProductId = explode(',',$getStoreInventorys['masterPId']);
				}

			if(!empty($explodeSku)) {
				
					for($i=0; $i<count($explodeSku); $i++) {
						$pName = (($explodeProductId[$i] != 0) ? product_name($explodeProductId[$i]) : '');
						$storeName = getStoreName($explodestoreId[$i]);
						$sku = $explodeSku[$i];
						$qty = $explodeQty[$i];

						$html .= '<tr>';
						$html .= '<td>'.$count.'</td>';
						$html .= '<td>'.$pName.'</td>';
						$html .= '<td>'.$sku.'</td>';
						$html .= '<td>'.$qty.'</td>';
						$html .= '<td>'.$storeName.'</td>';
						$html .= '</tr>';
						$count++;
					}
				}	
			}	
		} else {
			$html .= '<tr><td>No Records.</td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						</tr>';
		}
		$html .= '</tbody></table>';
		echo $html;
    }



	//Generate CSV Product 
	public function export_all_warehouse_inventory()
	{
		global $uInfo;
	   $comp_code = $uInfo['comp_code'];
		
		$product_id = $this->input->get('product_id');
		$cat_id = $this->input->get('cat_id');
		$sub_cat = $this->input->get('sub_cat');
		$sub_sub_cat = $this->input->get('sub_sub_cat');
		$attribute = $this->input->get('attribute');


		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "ProductAcAll.csv";

		$where = $join ="";

		if($cat_id!='' && $sub_cat!='' && $sub_sub_cat!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $cat_id AND b.product_sub_category = $sub_cat AND b.product_sub_of_sub_category = $sub_sub_cat";

			if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id ";
				$where .= " AND c.attribute_id = $attribute";
			}
		} 
		else if($cat_id!='' && $sub_cat!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $cat_id AND b.product_sub_category = $sub_cat";

			if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id ";
				$where .= " AND c.attribute_id = $attribute";
			}

		}
		else if($cat_id!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
		 	$where .= "AND b.product_category = $cat_id";

		 	if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id";
				$where .= " AND c.attribute_id = $attribute";
			}
		} else {
			$join .= "product as b ON b.product_id = a.master_product_id";
			$where .= "";
		}


		$pwhere = '';
		if($product_id!='' && is_numeric($product_id)) {
    		$pwhere .= "a.master_product_id = $product_id";
        } else {
        	$pwhere .= "a.master_product_id != 0";
        }


	   $query = "SELECT b.product_name AS product_name, a.product_id AS SKU, a.stock_qty 	 AS stock_qty, d.`warehouse_name`
	        	FROM  `warehouse_inventory` AS a
	        	$join
	        	JOIN `warehouse` AS d ON a.`warehouse_id` = d.`warehouse_id`
	        	WHERE a.`comp_code` = $comp_code AND $pwhere $where
	        	GROUP BY a.`warehouse_id`";


		/*if($cat_id != '') {
			$query = "SELECT GROUP_CONCAT( a.product_id ) AS SKU, GROUP_CONCAT( a.stock_qty ) AS stock_qty, b.`product_category` , c.`warehouse_name`, a.`master_product_id`, d.`cat_name`, b.'product_name' FROM  `warehouse_inventory` AS a
				JOIN  `product` AS b ON a.`master_product_id` = b.`product_id` 
				JOIN `warehouse` AS c ON a.`warehouse_id` = c.`warehouse_id`
				JOIN `product_category` AS d ON b.`product_category` = d.`product_cat_id`
				WHERE  a.`master_product_id` = $product_id AND b.`product_category` = $cat_id
				GROUP BY a.`warehouse_id`";
		} else {
			$query = "SELECT GROUP_CONCAT( a.product_id ) AS SKU, GROUP_CONCAT( a.stock_qty ) AS stock_qty, b.`product_category` , c.`warehouse_name`, a.`master_product_id`, b.'product_name' FROM  `warehouse_inventory` AS a
				JOIN  `product` AS b ON a.`master_product_id` = b.`product_id` 
				JOIN `warehouse` AS c ON a.`warehouse_id` = c.`warehouse_id`
				WHERE  a.`master_product_id` = $product_id 
				GROUP BY a.`warehouse_id`";
		}*/

        $result    = $this->db->query($query);

		$data      = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
	}


	function print_all_warehouse_inventory()
	{
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
		
		$product_id = $this->input->get('product_id');
		$cat_id = $this->input->get('cat_id');
		$sub_cat = $this->input->get('sub_cat');
		$sub_sub_cat = $this->input->get('sub_sub_cat');
		$attribute = $this->input->get('attribute');

		$where = $join ="";

		if($cat_id!='' && $sub_cat!='' && $sub_sub_cat!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $cat_id AND b.product_sub_category = $sub_cat AND b.product_sub_of_sub_category = $sub_sub_cat";

			if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id ";
				$where .= " AND c.attribute_id = $attribute";
			}
		} 
		else if($cat_id!='' && $sub_cat!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $cat_id AND b.product_sub_category = $sub_cat";

			if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id ";
				$where .= " AND c.attribute_id = $attribute";
			}
		}
		else if($cat_id!='' && is_numeric($cat_id)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
		 	$where .= " AND b.product_category = $cat_id";

		 	if($attribute!='') {
				$join .= "JOIN product_attribute as c ON c.product_id = a.master_product_id";
				$where .= " AND c.attribute_id = $attribute";
			}
		} else {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id";
			$where .= "";
		}


		$pwhere = '';
		if($product_id!='' && is_numeric($product_id)) {
    		$pwhere .= "a.master_product_id = $product_id";
        } else {
        	$pwhere .= "a.master_product_id != 0";
        }

	    $sql = "SELECT GROUP_CONCAT( a.product_id ) AS SKU, GROUP_CONCAT( a.stock_qty ) AS stock_qty, b.`product_category`, d.`warehouse_name`, a.`master_product_id`,a.`warehouse_id`
	        	FROM  `warehouse_inventory` AS a
	        	$join
	        	JOIN `warehouse` AS d ON a.`warehouse_id` = d.`warehouse_id`
	        	WHERE a.`comp_code` = $comp_code AND $pwhere $where
	        	GROUP BY a.`warehouse_id`";
	

	$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
		} else { $row = array(); }


		$this->load->library('pdf');
		$data['res'] = $row;
		$data['comp_code'] = $comp_code;
		
		$this->pdf->load_view('manageReports/pdfWarehouseInventoryAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}



	//Generate CSV Store Inventory Report 
	public function export_all_store_inventory()
	{
		global $uInfo;
	    $comp_code = $uInfo['comp_code'];
		
		$pId = $this->input->get('product_id');
		$catId = $this->input->get('cat_id');
		$store = $this->input->get('store');

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "StoreAcAll.csv";

		$where = $join ="";

		if($catId!='' && $pId!='' && is_numeric($catId) && is_numeric($pId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $catId AND a.master_product_id = $pId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
			}
		} else if($pId!='' && is_numeric($pId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND a.master_product_id = $pId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
        	}
		} else if($catId!='' && is_numeric($catId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $catId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
        	}
		} else {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "";
		}

		$query = "SELECT GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(a.store_id) as storeId, `b`.`product_name`
	        	FROM  (`store_inventory` as a)
	        	$join
			 	WHERE a.`comp_code` = '$comp_code' $where GROUP BY `a`.`store_id`";


        $result    = $this->db->query($query);
       // $merageval = array_push($result,$attrVal);

		$data      = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
	}


	public function print_all_store_inventory() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
		
		$pId = $this->input->get('product_id');
		$catId = $this->input->get('cat_id');
		$store = $this->input->get('store');

		
		$where = $join ="";

		if($catId!='' && $pId!='' && is_numeric($catId) && is_numeric($pId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $catId AND a.master_product_id = $pId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
			}
		} else if($pId!='' && is_numeric($pId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND a.master_product_id = $pId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
        	}
		} else if($catId!='' && is_numeric($catId)) {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "AND b.product_category = $catId";

			if($store!='') {
				$where .= " AND a.store_id = $store";
        	}
		} else {
			$join .= "JOIN product as b ON b.product_id = a.master_product_id ";
			$where .= "";
		}

		$sql = "SELECT GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(a.store_id) as storeId, `b`.`product_name`
	        	FROM  (`store_inventory` as a)
	        	$join
			 	WHERE a.`comp_code` = '$comp_code' $where GROUP BY `a`.`store_id`";


		/*if($cat_id != '') {
			$sql = "SELECT GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(a.store_id) as storeId, `b`.`product_name` FROM (`store_inventory` as a) 
			JOIN `product` as b ON `b`.`product_id` = `a`.`master_product_id`
			 WHERE `a`.`master_product_id` = '$product_id' AND b.`product_category` = $cat_id  AND `a`.`comp_code` = '$comp_code' GROUP BY `a`.`store_id`";
		} else {
			$sql = "SELECT GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(a.store_id) as storeId, `b`.`product_name` FROM (`store_inventory` as a) JOIN `product` as b ON `b`.`product_id` = `a`.`master_product_id` WHERE `a`.`master_product_id` = '$product_id' AND `a`.`comp_code` = '$comp_code' GROUP BY `a`.`store_id`";
		}*/
	

		$query = $this->db->query($sql);	
		if($query->num_rows() > 0){
	    $row = $query->result_array();
			} else { $row = array(); }


			$this->load->library('pdf');
			$data['res'] = $row;
			$data['comp_code'] = $comp_code;
			
			$this->pdf->load_view('manageReports/pdfStoreInventoryAll',$data);
			$this->pdf->render();
			$this->pdf->stream("welcome.pdf");
	}



	// Generate PDF Of Daily Sale Report
	public function export_all_daily_sale() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];

	  	$where = '';

		$dateval=$this->input->get('daily_date');
		$employeeId=$this->input->get('sale_name');
		$storeId=$this->input->get('store_name');

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "SaleAcAll.csv";

		if($dateval != '') {
			$dateinfo = $dateval;
			$where .= 'DATE( a.`date_time_created` ) LIKE "%'.$dateval.'%" AND ';
		} else {
			$todayDate = date('Y-m-d');
			$dateinfo = $todayDate;
			$where .= 'DATE( a.`date_time_created` ) LIKE "%'.$todayDate.'%" AND ';
		}

		if($employeeId != '') {
			$eId = $employeeId;
			$where .=  'a.employee_ID = "'.$employeeId.'" AND ';
		} 

		if($storeId != '') {
			$where .=  'a.store_ID = "'.$storeId.'" AND ';
		} 

		$query = "SELECT a.`sale_ID` AS saleId, a.`store_ID` AS storeId, b.`payment_method` , b.`payment_amount` , a.`sub_total`, c.`store_name`
			FROM (`sale` AS a)
			JOIN  `sale_payments` AS b ON  `b`.`sale_ID` =  `a`.`sale_ID` 
			JOIN  `store` AS c ON  `c`.`store_id` =  `a`.`store_ID` 
			WHERE ".$where." `a`.`comp_code` =  $comp_code";
		
		$result = $this->db->query($query);

		$data = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);

	}


	public function print_all_daily_sale() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];

	  	$dateval=$this->input->get('daily_date');
	  	$dateEndval=$this->input->get('end_date');
		$employeeId=$this->input->get('sale_name');
		$storeId=$this->input->get('store_name');

	  	$this->load->library('pdf');

		$dailyReport = $this->managereports_model->dailySaleReport($dateval,$dateEndval,$employeeId,$storeId);
		$id='';
		if(!empty($dailyReport)) {
        foreach($dailyReport as $dailyReports) {
            
            $saleId=$dailyReports['sale_ID'];
            if($id==$saleId) {
                if($dailyReports['payment_method']=='cash') {
                    $cash=['cash'=>$dailyReports['payment_amount']];
                } 
                if($dailyReports['payment_method']=='ccard') {
                    $ccredit=['ccredit'=>$dailyReports['payment_amount']];
                }
                if($dailyReports['payment_method']=='dcard') {
                    $dcard=['dcard'=>$dailyReports['payment_amount']];
                }
                if($dailyReports['payment_method']=='check') {
                    $check=['check'=>$dailyReports['payment_amount']];
                }

                $creditNote=$dailyReports['payment_method'];
                $checkCreditNote=substr($dailyReports['payment_method'], 0, 2);
                if($checkCreditNote=='CN') {
                    $creditNoteAry=['creditNote'=>$creditNote];
                }
                $info=['store_id'=>$dailyReports['store_ID'],
                    'total'=>$dailyReports['total']];
            } else {
                if($dailyReports['payment_method']=='cash') {
                    $cash=['cash'=>$dailyReports['payment_amount']];
                } else {
                    $cash=['cash'=>''];
                }
                if($dailyReports['payment_method']=='ccard') {
                    $ccredit=['ccredit'=>$dailyReports['payment_amount']];
                } else {
                    $ccredit=['ccredit'=>''];
                }
                if($dailyReports['payment_method']=='dcard') {
                    $dcard=['dcard'=>$dailyReports['payment_amount']];
                }else {
                    $dcard=['dcard'=>''];
                }
                if($dailyReports['payment_method']=='check') {
                    $check=['check'=>$dailyReports['payment_amount']];
                }else {
                    $check=['check'=>''];
                }
                $creditNote=$dailyReports['payment_method'];
                $checkCreditNote=substr($dailyReports['payment_method'], 0, 2);
                if($checkCreditNote=='CN') {
                    $creditNoteAry=['creditNote'=>$creditNote];
                } else {
                    $creditNoteAry=['creditNote'=>''];
                }
                 $info=['store_id'=>$dailyReports['store_ID'],
                    'total'=>$dailyReports['total']];
            }

            $data['sale'][$saleId]=array_merge($info,$cash,$ccredit,$dcard,$check,$creditNoteAry);
            $data['comp_code'] = $comp_code;
           $id=$saleId;
        }
    }

        $this->pdf->load_view('manageReports/pdfDailySaleAll',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}


	public function orderDetailReport() {
		global $uInfo;
        $conditions = array();
        $data=array();
        
        $perPage = 5;
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
      //  $conditions['search']['store_ID'] = $uInfo['store'];

        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');
        $gstInNumber=$this->input->get('gst_number');

        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($endDate)){
            $conditions['search']['endDate'] = $endDate;
        }
        //total rows count
        $conditions['search']['exp']=false;


        $totalRec = count($this->managereports_model->getOrderDetail($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/orderDetailReport';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'orderDetailReport';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
       /* $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;*/

        //$data['orderDetail'] = $this->managereports_model->getOrderDetail($conditions);

        $orderDetail = $this->managereports_model->getOrderProduct($conditions);


        $b=$totalGstPrice=$gst=$dealerDetail=[];
        $res=[];

        if(!empty($orderDetail)) {
        	foreach ($orderDetail as $key => $orderDetails) {
        	$orderId = $orderDetails->order_id;

        	$dealerAccount = getSku('dealer_account',['order_id'=>$orderId]);
        	
        	if(!empty($dealerAccount)) {

        		if($dealerAccount[0]['invoice_id'] != '') {
        	$dealerDetail[$orderId] = ['invoice_id'=>$dealerAccount[0]['invoice_id'],
        							   'dealer_user_id'=>$dealerAccount[0]['dealer_user_id'],
        							  'amount'=>$dealerAccount[0]['amount'],
        							  'payment_for'=>$dealerAccount[0]['payment_for'],
        							  'invoice_date'=>$dealerAccount[0]['created'],
        							  'place_of_supply'=>$orderDetails->cust_ship_address_notes,
        							  'order_status'=>$orderDetails->order_status];

        	$pId = $orderDetails->pId;

        	$orderPId = explode(',',$pId);
        	$price = explode(',',$orderDetails->price);
        	$qty = explode(',',$orderDetails->qty);
        	$sku = explode(',',$orderDetails->sku);

        	$uniquePId = array_unique($orderPId);

        	$productInfo = getDataByOrderAndGroupBy('product','',$uniquePId,'product_id','','','');

        	$cessAmount=[];
        	foreach($productInfo as $productInfos) {
        		$productId = $productInfos['product_id'];
        		$productPrice = $productInfos['product_price'];

        		$grate = $productInfos['gst_rate'];
        		$productTax = $productInfos['product_tax'];

        		$b[$orderId][$productId] = $productInfos['gst_rate'];

        		$gst[$grate][$orderId][] = $productId;
        	}


	        	foreach($orderPId as $keyp=>$orderPIds) {
	        		$skuVal = $sku[$keyp];

	        		$totalGstPrice[$orderId][$orderPIds][$skuVal] = ['pId'=>$orderPIds,
	        									'price'=>$price[$keyp] * $qty[$keyp]];
	        	}
	        } }
	        }


	        foreach($gst as $gstkey=>$gsts) {
	        	
	        	foreach($gsts as $oId=>$gstsval) {
	        		$price=0;$cessOAmount1=0;

	        		$cess = $this->managereports_model->getCessTaxId();
	        		$cessRate =$cess[0]->rate;
	        		$cessTaxId =$cess[0]->tax_id;

	        		foreach($gstsval as $pval=>$gstsvals) {
	        			$tData = $totalGstPrice[$oId][$gstsvals];

	        			/* Cess Amount */
	        			$orderPInfo = getSku('product',['product_id'=>$gstsvals]);
		        		$orderPPrice = $orderPInfo[0]['product_price'];
		        		$productOTax = $orderPInfo[0]['product_tax'];
	        			$explodeOTax = explode(',',$productOTax);


		        		foreach($explodeOTax as $explodeOTaxs) {
		        			$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        			
		        			if(!empty($getOCessTax)) {
		        				$getORate = $getOCessTax[0]->rate;
		        				$cessOAmount1 += (($dealerDetail[$oId]['amount'] * $getORate) / 100);
		        			}
		        		}
		        		/* Cess Amount */


	        			foreach($tData as $tDatas) {
	        				$price += $tDatas['price'];
	        			}

	        		


	        			$res[$oId][$gstkey] = ['total'=>$price,
	        								  'invoice_id'=>$dealerDetail[$oId]['invoice_id'],
	        								  'dealer_user_id'=>$dealerDetail[$oId]['dealer_user_id'],
	        								  'taxable_value'=>$dealerDetail[$oId]['amount'],
	        								  'payment_for'=>$dealerDetail[$oId]['payment_for'],
	        								  'invoice_date'=>$dealerDetail[$oId]['invoice_date'],
	        								  'place_of_supply'=>$dealerDetail[$oId]['place_of_supply'],
	        								  'order_status'=>$dealerDetail[$oId]['order_status'],
	        								  'cess_amount'=>((isset($cessOAmount1) && $cessOAmount1 > 0) ? $cessOAmount1 : '')];
	        		}
	        	}
	        }
        }


        $data['orderDetail'] = $res;

        $data['title'] = 'Dashboard | Sales';
        
       
        $this->load->view('manageReports/order_detail_report_view', $data, false);
	}



	public function saleDetailReport() {
		global $uInfo;
        $conditions = array();
        $data=array();
        
        $perPage = 5;
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
      //  $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');
        $gstInNumber=$this->input->get('gstNumber');


        if(!empty($keywords)){
            $conditions['search']['keywords'] = $keywords;
        }
        if(!empty($sortBy)){
            $conditions['search']['sortBy'] = $sortBy;
        }
        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($endDate)){
            $conditions['search']['endDate'] = $endDate;
        }
        if(!empty($gstNumber)){
            $conditions['search']['gstInNumber'] = $gstInNumber;
        }
        //total rows count
        $conditions['search']['exp']=false;


        $totalRec = count($this->managereports_model->getSalesEmployee($conditions));
       // echo $this->db->last_query();die;
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/saleDetailReport';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $perPage;
        $config['link_func']   = 'saleDetailReport';
        $this->ajax_pagination->initialize($config);

        $saleDetail = $this->managereports_model->getSalesEmployee($conditions);
      
       
        if(isset($saleDetail) && !empty($saleDetail)) {
        

        	foreach($saleDetail as $saleDetails) {
	        	$employeeId = $saleDetails['employeeId'];
	        	$saleId = $saleDetails['saleId'];

	        	$storeId = $saleDetails['store_ID'];

	        	$getSaleProduct = $this->managereports_model->getCessBySale($saleId);

	        	if(!empty($getSaleProduct)) {
	        		$gstRate = $getSaleProduct[0]->gst_rate.'.00';

	        		$productTax = $getSaleProduct[0]->product_tax;
	        		$explodeOTax = explode(',',$productTax);
	        	}

	        	$getLocation = getSku('user_master',['user_ID'=>$employeeId]);
	            $location = $getLocation[0]['location'];

	            if($location != 0) {
	          
		            $getCountry = getSku('locations',['id'=>$location]);
		            $stateId = $getCountry[0]['state_id'];
		            $stateName = get_state_by_id($stateId);

		        	$productTax = $saleDetails['product_tax'];

		        	preg_match_all('!\d+!', $productTax, $matches);
		        	
					$addZero = $matches[0];
					if(empty($addZero)) {
						$tax = '0.00';
					} else {
						$tax = $addZero[0].'.00';
					}

		        	$item[$stateName][$employeeId][$gstRate][] = $saleDetails['item_subtotal'];

		        	$item1[$stateName][$gstRate][] = $saleDetails['item_subtotal'];

		        	$item2[$stateName][$gstRate] = array_sum($item1[$stateName][$gstRate]);

		        	$itemSaleId[$stateName][$gstRate][] = $saleId;

		        /* Get GST By Employee Id */
	        	$getGst = $this->managereports_model->getGstNumberById('','',$stateId);
	        	if(isset($getGst) && !empty($getGst)) {
	        		$gstNumber[$stateName] = $getGst[0]['gst_number'];
	        	}
	        	/* Get GST By Employee Id */


	        	/* Get Cess Amount */
	        	if(isset($explodeOTax) && !empty($explodeOTax)) {
	        		$cessOAmount1=0;
		        	foreach($explodeOTax as $explodeOTaxs) {
		        		$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        		
		        		if(!empty($getOCessTax)) {
		    				$getORate = $getOCessTax[0]->rate;
		    				$cessOAmount1 = (($saleDetails['item_subtotal'] * $getORate) / 100);
		    			}
		    			$totalCessAmount[$stateName][$gstRate][] = $cessOAmount1;
		        	}
	        	}
	        	/* Get Cess Amount */


		        	$stateSum = array_sum($item1[$stateName][$gstRate]);

		        	if($gstInNumber != '' && isset($gstInNumber)) {
		        
		        		$gstState = getSku('gst_number', ['gst_number_id'=>$gstInNumber]);
		        		if(!empty($gstState)) {
		        			$gstStateId = $gstState[0]['state_id'];

		        			if($stateId == $gstStateId) {
		        				$stateName1 = get_state_by_id($gstStateId);

			        			$itemgst[$stateName1][$gstRate][] = $saleDetails['item_subtotal'];
				        		$stateSum1 = array_sum($itemgst[$stateName1][$gstRate]);

				        		if(!empty($gstNumber[$stateName1]) && isset($gstNumber[$stateName1])) {

				        			$res[$stateName1][$gstRate] = [
					        			'store_gst_number'=>(isset($gstNumber[$stateName1]) ? $gstNumber[$stateName1] : ''),
					        			'item_subtotal' => $stateSum1,
					        			'cess_amount'=>(isset($totalCessAmount[$stateName1][$gstRate]) && !empty($totalCessAmount[$stateName1][$gstRate])) ? array_sum($totalCessAmount[$stateName1][$gstRate]) : '' 
					        		];
				        		}
		        			}
			        		
		        		}

		        	} else { 
		        		$res[$stateName][$gstRate] = [
		        		'store_gst_number'=>(isset($gstNumber[$stateName]) ? $gstNumber[$stateName] : ''),
		        		'saleId' => $itemSaleId[$stateName][$gstRate],
		        		'sub_total'=>$saleDetails['sub_total'],
		        		'product_tax'=>$saleDetails['product_tax'],
		        		'employeeId'=>$employeeId,
		        		'item_subtotal'=>$stateSum,
		        		'cess_amount'=>(isset($totalCessAmount[$stateName][$gstRate]) && !empty($totalCessAmount[$stateName][$gstRate])) ? array_sum($totalCessAmount[$stateName][$gstRate]) : '' 
		        		];
		        	}
		        	
	        	}
	        }
        }
        
        
        if(!empty($res) && isset($res)) {
        	$data['saleDetail'] = $res;
        }

        $data['title'] = 'Dashboard | Sales';
       
        $this->load->view('manageReports/sale_detail_report_view', $data, false);
	}



	public function export_all_order_detail() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];

	  	$where = '';

		$startDate=$this->input->get('from_date');
        $endDate=$this->input->get('end_date');

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "B2CAcAll.csv";

        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($endDate)){
            $conditions['search']['endDate'] = $endDate;
        }

        $totalRec = count($this->managereports_model->getOrderDetail($conditions));

        $orderDetail = $this->managereports_model->getOrderProduct($conditions);


        $b=$totalGstPrice=$gst=$dealerDetail=[];
        $res=[];

        if(!empty($orderDetail)) {
        	foreach ($orderDetail as $key => $orderDetails) {
        	$orderId = $orderDetails->order_id;

        	$dealerAccount = getSku('dealer_account',['order_id'=>$orderId]);
        	$dealerDetail[$orderId] = ['invoice_id'=>$dealerAccount[0]['invoice_id'],
        							   'dealer_user_id'=>$dealerAccount[0]['dealer_user_id'],
        							  'amount'=>$dealerAccount[0]['amount'],
        							  'payment_for'=>$dealerAccount[0]['payment_for'],
        							  'invoice_date'=>$dealerAccount[0]['created'],
        							  'place_of_supply'=>$orderDetails->cust_ship_address_notes,
        							  'order_status'=>$orderDetails->order_status];


        	$pId = $orderDetails->pId;

        	$orderPId = explode(',',$pId);
        	$price = explode(',',$orderDetails->price);
        	$qty = explode(',',$orderDetails->qty);
        	$sku = explode(',',$orderDetails->sku);

        	$uniquePId = array_unique($orderPId);

        	$productInfo = getDataByOrderAndGroupBy('product','',$uniquePId,'product_id','','','');

        	$cessAmount=[];
        	foreach($productInfo as $productInfos) {
        		$productId = $productInfos['product_id'];
        		$productPrice = $productInfos['product_price'];

        		$grate = $productInfos['gst_rate'];
        		$productTax = $productInfos['product_tax'];

        		$b[$orderId][$productId] = $productInfos['gst_rate'];

        		$gst[$grate][$orderId][] = $productId;
        	}


	        	foreach($orderPId as $keyp=>$orderPIds) {
	        		$skuVal = $sku[$keyp];

	        		$totalGstPrice[$orderId][$orderPIds][$skuVal] = ['pId'=>$orderPIds,
	        									'price'=>$price[$keyp] * $qty[$keyp]];
	        	}
	        }


	        foreach($gst as $gstkey=>$gsts) {
	        	
	        	foreach($gsts as $oId=>$gstsval) {
	        		 $price=0;$cessOAmount1=0;
	        		foreach($gstsval as $pval=>$gstsvals) {
	        			$tData = $totalGstPrice[$oId][$gstsvals];

	        			/* Cess Amount */
	        			$orderPInfo = getSku('product',['product_id'=>$gstsvals]);
		        		$orderPPrice = $orderPInfo[0]['product_price'];
		        		$productOTax = $orderPInfo[0]['product_tax'];
	        			$explodeOTax = explode(',',$productOTax);
	        			
		        		foreach($explodeOTax as $explodeOTaxs) {
		        			$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        			
		        			if(!empty($getOCessTax)) {
		        				$getORate = $getOCessTax[0]->rate;
		        				$cessOAmount1 += (($dealerDetail[$oId]['amount'] * $getORate) / 100);
		        			}
		        		}
		        		/* Cess Amount */


	        			foreach($tData as $tDatas) {
	        				$price += $tDatas['price'];
	        			}

	        			$getDealerData = getSku('dealer',['dealer_id'=>$dealerDetail[$oId]['dealer_user_id']]);

	        			if($dealerDetail[$oId]['payment_for'] == 1) {
                              $invoiceType = 'Regular';
                           } else {
                              $invoiceType = 'Direct Pay';
                           }


	        			$res[$oId][$gstkey] = [
	        								'dealer_user_id'=>$getDealerData[0]['tin_number'],
	        								'recevier_name'=>$getDealerData[0]['firm_name'],
	        								'invoice_number'=>$dealerDetail[$oId]['invoice_id'],
	        								'invoice_date'=>$dealerDetail[$oId]['invoice_date'],
	        								'invoice_value'=>$price,
	        								'place_of_supply'=>$dealerDetail[$oId]['place_of_supply'],
	        								'reverse_charge'=>'N',
	        								'invoice_type'=>$invoiceType,
	        								'e_commerce_GSTIN'=>'',
	        								'rate'=>$gstkey,
	        								'aaplication_rate_tax'=>'',
	        								'taxable_value'=>$dealerDetail[$oId]['amount'],
	        								'cess_amount'=>((isset($cessOAmount1) && $cessOAmount1 > 0) ? $cessOAmount1 : '')];
	        		}
	        	}
	        }
        }


		/*$query = "SELECT dealer.`tin_number` AS 'GSTIN/UIN_of_Recipient', dealer.`firm_name` AS 'Recevier_name', d.`invoice_id` AS Invoice_Number, a.`date` AS Invoice_Date, d.`amount` AS Invoice_Value, a.`cust_ship_address_notes` AS Place_Of_Supply, IF( d.`payment_for` =1,  'Regular',  '' ) AS Invoice_Type, p.`gst_rate` AS Rate, SUM(b.`price` * b.`quantity`) AS  'Taxable_value', GROUP_CONCAT(DISTINCT b.`master_product_id`) AS 'masterPId'
				FROM (
				 `orders` AS a
				)
				JOIN  `order_detail` AS b ON  `a`.`order_id` =  `b`.`order_id` 
				JOIN  `dealer_account` AS d ON d.`order_id` = b.`order_id` 
				JOIN  `product` AS p ON p.`product_id` = b.`master_product_id` 
				JOIN `dealer` AS dealer ON dealer.`dealer_id` = d.`dealer_user_id`

				WHERE DATE( a.`date` ) 
				BETWEEN  '".$from."'
				AND  '".$to."'
				AND  `a`.`comp_code` =  $comp_code
				GROUP BY d.`invoice_id` , p.`gst_rate`";

		$result = $this->db->query($query);*/
	

		//echo '<pre>';print_r($commonRes);die;

		header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="sample.csv"');

		$fp = fopen('php://output', 'w');

		fputcsv($fp, array('GSTIN/UIN of Recipient', 'Receiver Name', 'Invoice Number', 'Invoice Date', 'Invoice Value','Place Of Supply','Reverse Charge','Invoice Type','E-Commerce GSTIN','Rate','Application % Rate Tax','Taxable Value','Cess Amount'));

		foreach($res as $ress) {
			foreach($ress as $finalres) {
				fputcsv($fp, $finalres);
			}
		}

		fclose($fp);
	}


	function pdfPrintOrderDetail()
	{
		global $uInfo;
    	$conditions = array();
    	$data=array();

    	$this->load->library('pdf');

        $from_date=$this->input->get('from_date');
        $end_date=$this->input->get('end_date');

        if(!empty($from_date)){
            $conditions['search']['startDate'] = $from_date;
        }
        if(!empty($end_date)){
            $conditions['search']['endDate'] = $end_date;
        }

        $orderDetail = $this->managereports_model->getOrderProduct($conditions);
        $b=$totalGstPrice=$gst=$dealerDetail=[];
        $res=[];


        if(!empty($orderDetail)) {
        	foreach ($orderDetail as $key => $orderDetails) {
        	$orderId = $orderDetails->order_id;

        	$dealerAccount = getSku('dealer_account',['order_id'=>$orderId]);
        	$dealerDetail[$orderId] = ['invoice_id'=>$dealerAccount[0]['invoice_id'],
        							   'dealer_user_id'=>$dealerAccount[0]['dealer_user_id'],
        							  'amount'=>$dealerAccount[0]['amount'],
        							  'payment_for'=>$dealerAccount[0]['payment_for'],
        							  'invoice_date'=>$dealerAccount[0]['created'],
        							  'place_of_supply'=>$orderDetails->cust_ship_address_notes,
        							  'order_status'=>$orderDetails->order_status];


        	$pId = $orderDetails->pId;

        	$orderPId = explode(',',$pId);
        	$price = explode(',',$orderDetails->price);
        	$qty = explode(',',$orderDetails->qty);
        	$sku = explode(',',$orderDetails->sku);

        	$uniquePId = array_unique($orderPId);

        	$productInfo = getDataByOrderAndGroupBy('product','',$uniquePId,'product_id','','','');
        	
        	foreach($productInfo as $productInfos) {
        		$productId = $productInfos['product_id'];
        		$grate = $productInfos['gst_rate'];

        		$b[$orderId][$productId] = $productInfos['gst_rate'];

        		$gst[$grate][$orderId][] = $productId;
        	}

	        	foreach($orderPId as $keyp=>$orderPIds) {
	        		$skuVal = $sku[$keyp];
	        		$totalGstPrice[$orderId][$orderPIds][$skuVal] = ['pId'=>$orderPIds,
	        									'price'=>$price[$keyp] * $qty[$keyp]];
	        	}
	        }


	        foreach($gst as $gstkey=>$gsts) {
	        	
	        	foreach($gsts as $oId=>$gstsval) {
	        		 $price=$cessOAmount1=0;
	        		foreach($gstsval as $pval=>$gstsvals) {
	        			$tData = $totalGstPrice[$oId][$gstsvals];

	        				/* Cess Amount */
	        			$orderPInfo = getSku('product',['product_id'=>$gstsvals]);
		        		$orderPPrice = $orderPInfo[0]['product_price'];
		        		$productOTax = $orderPInfo[0]['product_tax'];
	        			$explodeOTax = explode(',',$productOTax);
	        			
		        		foreach($explodeOTax as $explodeOTaxs) {
		        			$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        			
		        			if(!empty($getOCessTax)) {
		        				$getORate = $getOCessTax[0]->rate;
		        				$cessOAmount1 += (($dealerDetail[$oId]['amount'] * $getORate) / 100);
		        			}
		        		}
		        		/* Cess Amount */




	        			foreach($tData as $tDatas) {
	        				$price += $tDatas['price'];
	        			}
	        			$res[$oId][$gstkey] = ['total'=>$price,
	        								  'invoice_id'=>$dealerDetail[$oId]['invoice_id'],
	        								  'dealer_user_id'=>$dealerDetail[$oId]['dealer_user_id'],
	        								  'taxable_value'=>$dealerDetail[$oId]['amount'],
	        								  'payment_for'=>$dealerDetail[$oId]['payment_for'],
	        								  'invoice_date'=>$dealerDetail[$oId]['invoice_date'],
	        								  'place_of_supply'=>$dealerDetail[$oId]['place_of_supply'],
	        								  'order_status'=>$dealerDetail[$oId]['order_status'],
	        								  'cess_amount'=>$cessOAmount1];
	        		}
	        	}
	        }
        }

        $data['orderDetail'] = $res;

       // $data['orderDetail'] = $this->managereports_model->getOrderDetail($conditions);
        $data['comp_code'] = $uInfo['comp_code'];

        $data['title'] = 'Order Detail | Sales';
		//echo '<pre>';print_r($data);die;
		//$data['res'] = $row;
		$this->pdf->load_view('manageReports/pdfPrintOrderDetail',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}


	public function export_all_sale_detail() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

		$from_date=$this->input->get('from_date');
        $end_date=$this->input->get('end_date');
        $gstInNumber=$this->input->get('gst_number');

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "SaleAcAll.csv";


		if(!empty($from_date)){
            $conditions['search']['startDate'] = $from_date;
        }
        if(!empty($end_date)){
            $conditions['search']['endDate'] = $end_date;
        }

        $saleDetail = $this->managereports_model->getSalesEmployee($conditions);
		$cessOAmount1 = 0;
        foreach($saleDetail as $saleDetails) {
        	$employeeId = $saleDetails['employeeId'];

        	$saleId = $saleDetails['saleId'];

        	$getSaleProduct = $this->managereports_model->getCessBySale($saleId);
        	$gstRate = $getSaleProduct[0]->gst_rate.'.00';
        	$productTax = $getSaleProduct[0]->product_tax;
        	$explodeOTax = explode(',',$productTax);

        	foreach($explodeOTax as $explodeOTaxs) {
        		$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);

        		if(!empty($getOCessTax)) {
    				$getORate = $getOCessTax[0]->rate;
    				$cessOAmount1 += (($saleDetails['sub_total'] * $getORate) / 100);
    			}
        	}


        	$getLocation = getSku('user_master',['user_ID'=>$employeeId]);

            $location = $getLocation[0]['location'];

            if($location != 0) {
          
	            $getCountry = getSku('locations',['id'=>$location]);

	            $stateId = $getCountry[0]['state_id'];
	            $stateName = get_state_by_id($stateId);

	             /* Get GST By Employee Id */
	        	$getGst = $this->managereports_model->getGstNumberById('','',$stateId);
	        	if(isset($getGst) && !empty($getGst)) {
	        		$gstNumber[$stateName] = $getGst[0]['gst_number'];
	        	}
	        	/* Get GST By Employee Id */

	        	$productTax = $saleDetails['product_tax'];

	        	preg_match_all('!\d+!', $productTax, $matches);
	        	
				$addZero = $matches[0];
				if(empty($addZero)) {
					$tax = '0.00';
				} else {
					$tax = $addZero[0].'.00';
				}

				 /* Get Cess Amount */
	        	if(isset($explodeOTax) && !empty($explodeOTax)) {
	        		$cessOAmount1=0;
		        	foreach($explodeOTax as $explodeOTaxs) {
		        		$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        		
		        		if(!empty($getOCessTax)) {
		    				$getORate = $getOCessTax[0]->rate;
		    				$cessOAmount1 = (($saleDetails['item_subtotal'] * $getORate) / 100);
		    			}
		    			$totalCessAmount[$stateName][$gstRate][] = $cessOAmount1;
		        	}
	        	}
		       /* Get Cess Amount */


	        	$item[$stateName][$employeeId][$gstRate][] = $saleDetails['item_subtotal'];

	        	$item1[$stateName][$gstRate][] = $saleDetails['item_subtotal'];
	        	$item2[$stateName][$gstRate] = array_sum($item1[$stateName][$gstRate]);


	        	if($gstInNumber != '' && isset($gstInNumber)) {
		        
		        		$gstState = getSku('gst_number', ['gst_number_id'=>$gstInNumber]);
		        		if(!empty($gstState)) {
		        			$gstStateId = $gstState[0]['state_id'];

		        			if($stateId == $gstStateId) {
		        				$stateName1 = get_state_by_id($gstStateId);

			        			$itemgst[$stateName1][$gstRate][] = $saleDetails['item_subtotal'];
				        		$stateSum1 = array_sum($itemgst[$stateName1][$gstRate]);

				        		if(!empty($gstNumber[$stateName1]) && isset($gstNumber[$stateName1])) {

				        			$res[$stateName1][$gstRate] = [
				        				'type'=>'OE',
				        				'place_of_supply'=>$stateName1,
				        				'rate'=>$gstRate,
				        				'item_subtotal' => $stateSum1,
				        				'cess_amount'=>(isset($totalCessAmount[$stateName1][$gstRate]) && !empty($totalCessAmount[$stateName1][$gstRate])) ? array_sum($totalCessAmount[$stateName1][$gstRate]) : '', 
					        			'store_gst_number'=>(isset($gstNumber[$stateName1]) ? $gstNumber[$stateName1] : '')
					        		];
				        		}
		        			}
		        		}
		        	} else {
		        		$res[$stateName][$gstRate] = [
			        		'type'=>'OE',
			        		'place_of_supply'=>$stateName,
			        		'rate'=>$gstRate,
			        		'item_subtotal'=>array_sum($item1[$stateName][$gstRate]),
			        		'cess_amount'=>(isset($totalCessAmount[$stateName][$gstRate]) && !empty($totalCessAmount[$stateName][$gstRate])) ? array_sum($totalCessAmount[$stateName][$gstRate]) : '' ,
			        		'store_gst_number'=>(isset($gstNumber[$stateName]) ? $gstNumber[$stateName] : ''),
			        		];
		        	}
        	}
        }

        header('Content-Type: application/excel');
		header('Content-Disposition: attachment; filename="sample.csv"');

		$fp = fopen('php://output', 'w');

		fputcsv($fp, array('Type', 'Place Of Supply', 'Rate', 'Taxable Value', 'Cess Amount','E-Commerce GSTIN'));

		foreach($res as $ress) {
			foreach($ress as $finalres) {
				fputcsv($fp, $finalres);
			}
		}

		fclose($fp);
	}


	function pdfPrintSaleDetail()
	{
		global $uInfo;
    	$conditions = array();
    	$data=array();

    	$this->load->library('pdf');

        $from_date=$this->input->get('from_date');
        $end_date=$this->input->get('end_date');
        $gstInNumber=$this->input->get('gst_number');

        if(!empty($from_date)){
            $conditions['search']['startDate'] = $from_date;
        }
        if(!empty($end_date)){
            $conditions['search']['endDate'] = $end_date;
        }

        $saleDetail = $this->managereports_model->getSalesEmployee($conditions);

        foreach($saleDetail as $saleDetails) {
        	$employeeId = $saleDetails['employeeId'];

        	$saleId = $saleDetails['saleId'];

        	$getSaleProduct = $this->managereports_model->getCessBySale($saleId);
        	$gstRate = $getSaleProduct[0]->gst_rate.'.00';
        	$productTax = $getSaleProduct[0]->product_tax;
        	$explodeOTax = explode(',',$productTax);

        	/*foreach($explodeOTax as $explodeOTaxs) {
        		$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);

        		if(!empty($getOCessTax)) {
    				$getORate = $getOCessTax[0]->rate;
    				$cessOAmount1 += (($saleDetails['sub_total'] * $getORate) / 100);
    			}
        	}*/


        	$getLocation = getSku('user_master',['user_ID'=>$employeeId]);

            $location = $getLocation[0]['location'];

            if($location != 0) {
          
	            $getCountry = getSku('locations',['id'=>$location]);

	            $stateId = $getCountry[0]['state_id'];
	            $stateName = get_state_by_id($stateId);

	             /* Get GST By Employee Id */
	        	$getGst = $this->managereports_model->getGstNumberById('','',$stateId);
	        	if(isset($getGst) && !empty($getGst)) {
	        		$gstNumber[$stateName] = $getGst[0]['gst_number'];
	        	}
	        	/* Get GST By Employee Id */


	        	$productTax = $saleDetails['product_tax'];

	        	preg_match_all('!\d+!', $productTax, $matches);
	        	
				$addZero = $matches[0];
				if(empty($addZero)) {
					$tax = '0.00';
				} else {
					$tax = $addZero[0].'.00';
				}


	            /* Get Cess Amount */
	        	if(isset($explodeOTax) && !empty($explodeOTax)) {
	        		$cessOAmount1=0;
		        	foreach($explodeOTax as $explodeOTaxs) {
		        		$getOCessTax = $this->managereports_model->getCessTax($explodeOTaxs);
		        		
		        		if(!empty($getOCessTax)) {
		    				$getORate = $getOCessTax[0]->rate;
		    				$cessOAmount1 = (($saleDetails['item_subtotal'] * $getORate) / 100);
		    			}
		    			$totalCessAmount[$stateName][$gstRate][] = $cessOAmount1;
		        	}
	        	}
		       /* Get Cess Amount */


	        	$item[$stateName][$employeeId][$gstRate][] = $saleDetails['item_subtotal'];

	        	$item1[$stateName][$gstRate][] = $saleDetails['item_subtotal'];
	        	$item2[$stateName][$gstRate] = array_sum($item1[$stateName][$gstRate]);


	        	if($gstInNumber != '' && isset($gstInNumber)) {
		        
		        		$gstState = getSku('gst_number', ['gst_number_id'=>$gstInNumber]);
		        		if(!empty($gstState)) {
		        			$gstStateId = $gstState[0]['state_id'];

		        			if($stateId == $gstStateId) {
		        				$stateName1 = get_state_by_id($gstStateId);

			        			$itemgst[$stateName1][$gstRate][] = $saleDetails['item_subtotal'];
				        		$stateSum1 = array_sum($itemgst[$stateName1][$gstRate]);

				        		if(!empty($gstNumber[$stateName1]) && isset($gstNumber[$stateName1])) {

				        			$res[$stateName1][$gstRate] = [
					        			'store_gst_number'=>(isset($gstNumber[$stateName1]) ? $gstNumber[$stateName1] : ''),
					        			'item_subtotal' => $stateSum1,
					        			'cess_amount'=>(isset($totalCessAmount[$stateName1][$gstRate]) && !empty($totalCessAmount[$stateName1][$gstRate])) ? array_sum($totalCessAmount[$stateName1][$gstRate]) : '' 
					        		];
				        		}
		        			}
		        		}
		        	} else {
		        		$res[$stateName][$gstRate] = [
			        		'store_gst_number'=>(isset($gstNumber[$stateName]) ? $gstNumber[$stateName] : ''),
			        		'sub_total'=>$saleDetails['sub_total'],
			        		'product_tax'=>$saleDetails['product_tax'],
			        		'employeeId'=>$employeeId,
			        		'item_subtotal'=>array_sum($item1[$stateName][$gstRate]),
			        		'cess_amount'=>(isset($totalCessAmount[$stateName][$gstRate]) && !empty($totalCessAmount[$stateName][$gstRate])) ? array_sum($totalCessAmount[$stateName][$gstRate]) : '' 
			        	];
		        	}
        	}
        }

        $data['saleDetail'] = $res;

        $data['comp_code'] = $uInfo['comp_code'];
        $data['title'] = 'Order Detail | Sales';
		
		//$data['res'] = $row;
		$this->pdf->load_view('manageReports/pdfPrintSaleDetail',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}




	public function dailyShotReport() {
		global $uInfo;
        $conditions = array();
        $data=array();
        
        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
      //  $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

        $storeID=$this->input->get('storeID');
        $employeeID=$this->input->get('employeeID');

        
        if(!empty($startDate)){
            $conditions['search']['startDate'] = $startDate;
        }
        if(!empty($storeID)){
            $conditions['search']['storeID'] = $storeID;
        }
        if(!empty($employeeID)){
            $conditions['search']['employeeID'] = $employeeID;
        }
        //total rows count
        $conditions['search']['exp']=false;


        $totalRec = count($this->managereports_model->getShotDetail($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'webadmin/managereport/dailyShotReport';
        $config['total_rows']  = $totalRec;
        $config['link_func']   = 'dailyShotReport';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
       /* $conditions['start'] = $offset;
        $conditions['limit'] = $perPage;*/

        $data['shotDetail'] = $this->managereports_model->getShotDetail($conditions);

        $data['title'] = 'Dashboard | Sales';
       
       //echo '<pre>';print_r($data);
        $this->load->view('manageReports/daily_shot_report_view', $data, false);
	}


	public function export_all_daily_shot_detail() {
		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$employee_name=$this->input->get('employee_name');
        $store_name=$this->input->get('store_name');
		$from=$this->input->get('daily_shot_date');

		$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        $filename  = "SaleAcAll.csv";


        if(isset($employee_name) && $employee_name != '') {
        	$where .= 'a.`user_id` = $employee_name AND';
        }

        if(isset($store_name) && $store_name != '') {
        	$where .= 'a.`store_id` = $store_name AND';
        }

        if(isset($from) && $from != '') {
         	//$selectDate = DATE_FORMAT(a.`modify_date`, "%Y-%m-%d");
        	$where .= 'DATE_FORMAT(a.`modify_date`, "%Y-%m-%d") = "'.$from.'" AND';
        }

		$query = "SELECT `a`.`user_id`, `b`.`user_full_name`, `a`.`store_id`, `c`.`store_name`, `a`.`cash`,`a`.`debit_card`,`a`.`credit_card`,`a`.`cheque` FROM (`day_close` as a) JOIN `user_master` as b ON `a`.`user_id` = `b`.`user_ID` JOIN `store` as c ON `c`.`store_id` = `a`.`store_id` WHERE $where `a`.`comp_code` = '3'";
		
		$result = $this->db->query($query);

		$data = $this->dbutil->csv_from_result_bank_acount($result, $delimiter, $newline);
        force_download($filename, $data);
	}


	public function pdfPrintDailyShotDetail() {
		global $uInfo;
    	$conditions = array();
    	$data=array();

    	$this->load->library('pdf');

        $employee_name=$this->input->get('employee_name');
        $store_name=$this->input->get('store_name');
		$from=$this->input->get('daily_shot_date');

        if(!empty($employee_name)){
            $conditions['search']['employee_name'] = $employee_name;
        }
        if(!empty($store_name)){
            $conditions['search']['store_name'] = $store_name;
        }
        if(!empty($from)){
            $conditions['search']['from'] = $from;
        }

        $data['shotDetail'] = $this->managereports_model->getShotDetail($conditions);
        $data['comp_code'] = $uInfo['comp_code'];
        $data['title'] = 'Shot Detail | Sales';
		
		//$data['res'] = $row;
		$this->pdf->load_view('manageReports/pdfPrintShotDetail',$data);
		$this->pdf->render();
		$this->pdf->stream("welcome.pdf");
	}

	public function getCategoryProduct() {
		global $uInfo;
		$compCode = $uInfo['comp_code'];
		$where = ['product_category'=>$catId, 'comp_code'=>$compCode];
		$getProduct = getSku('product',$where);
		if(!empty($getProduct)) {
			return $getProduct;
		}
	}


}