<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageReports extends CI_Controller {

	function __construct()
		{		
			parent::__construct();
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			global $uInfo;

			$this->load->library('cart');
			$uInfo=$this->session->userdata('sales_session_info');
			$this->load->helper('url');
			$this->load->model('common');
			$this->load->model('managereports_model');
            $this->load->model(['managesales_model']);
			if (!($this->session->userdata('sales_session_info'))) {
				redirect(base_url().'sales/login');
			}

			$this->load->library('Ajax_pagination');
        $this->perPage = 3;
		}
	
	function index(){
		global $uInfo;

		if (isset($uInfo) && !empty($uInfo)) {
			$data['title'] = 'Dashboard | Sales';
			$data['cart_items'] = $this->cart->contents(); 
		    $this->load->view('managesales/addOrder', $data);
		}
	}


    function sales_summary(){
    	$data = array();
        //load the view
        $data['title'] = 'Manage Report | Sales Summary';
        $this->load->view('managereports/sales_summary_report', $data);
    }

    function sales_detail(){
    	$data = array();
        //load the view
        $data['title'] = 'Manage Report | Sales Detail';
        $this->load->view('managereports/sales_detail_report', $data);
    }

    function sales_report_main(){
        global $uInfo;
        $data = array();
        $data['title'] = 'Manage Report | Sale Reports';
        $data['cats']=$this->managereports_model->getCatsAll($uInfo['comp_code']);
        $this->load->view('managereports/sales_main_report', $data);

    }

    function rpt_best_selling(){
        $data = array();
        //load the view
        $data['title'] = 'Manage Report | Best Selling Items';
        $this->load->view('managereports/sales_best_selling_products', $data);

        
    }

    function rpt_emp_wise_sells(){
        $data = array();
        //load the view
        /*-------------------*/

         /*Dates between range*/

        $begin = new DateTime('2017-09-01');
        $end = new DateTime('2017-09-13');
        $daterange = new DatePeriod($begin, new DateInterval('P1D'), $end);
        $dtArr=array();
        foreach($daterange as $date){
        //echo $date->format("Y-m-d") . "<br>";
        $dtArr[]=$date->format("Y-m-d");

        }
        echo $arrMax=count($dtArr);
        echo $not=ceil($arrMax/7);


        foreach ($dtArr as $key => $value) {
            echo $key;
            # code...
        }
        die;
//echo "<pre>";
//print_r($dtArr);
//die();

/* Date Difference

$datetime1 = new DateTime("2017-09-20");

$datetime2 = new DateTime("2017-10-10");

$difference = $datetime1->diff($datetime2);

echo 'Difference: '.$difference->y.' years, ' 
.$difference->m.' months, ' 
.$difference->d.' days';

print_r($difference);die;

    */        
       /* Days In Month


        $time = time();
        $today         = date("Y/n/j", $time);
        $current_month = date("n", $time);
        $current_year  = date("Y", $time);
        
       
        
        $year =$current_year;
        $monthNames = $current_month;


            $time = time();
            $today         = date("Y/n/j", $time);
            $current_month = date("n", $time);
            $current_year  = date("Y", $time);
            $cMonth        = 1;
            $cYear         = $year;
            $month=$monthNames;
            
            $timestamp = mktime(0, 0, 0, $month, 1, $cYear);
            $maxday    = date("t",$timestamp);
            $thismonth = getdate ($timestamp);
            $startday  = $thismonth['wday'];
            $no_of_td  = $maxday+$startday;
            //YYYY-MM-DD date format
            $date_form = "$cYear-$month-";

           var_dump($thismonth);die;

           */
        /*-------------------*/


        $data['title'] = 'Manage Report  | Employee Wise Sales Comparison';
        $this->load->view('managereports/sales_best_selling_products', $data);
    }

    function rpt_sales_profit(){
        $data = array();
        //load the view
        $data['title'] = 'Manage Report  | Sales & Profit';
        $this->load->view('managereports/sales_summary_report', $data);
    }

    function rpt_stock_detail(){
        global $uInfo;
        $data = array();
        //load the view
        $data['title'] = 'Manage Report  | Stock Detail';
        $data['locs']=$this->managereports_model->getLocations($uInfo['comp_code']);
        $data['products']=$this->managereports_model->getProductsAll($uInfo['comp_code']);
        $this->load->view('managereports/sales_stock_report', $data);
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


    function getSubCatsByCat(){
        $select_options = '';
        $catID=$this->input->post('catID');
        if(isset($catID) && !empty($catID)){
            $subCats=$this->managereports_model->getSubCatsByCatID($catID);

            if(isset($subCats) && !empty($subCats)) { 
             $select_options.= '<option value="">Select</option>';
             foreach($subCats as $cat) {
             $select_options.= '<option value="'.$cat["product_cat_id"].'">'.$cat["cat_name"].'</option>'; 
             }
            } else {
             $select_options.= '<option value="">No Records Found</option>';
            }
             echo $select_options;

        }else{
            echo  $select_options.= '<option value="">Select Main Cat</option>';
        }
    }

    function getSubCatsBySubCat(){
        $select_options = '';
        $catID=$this->input->post('catID');
        if(isset($catID) && !empty($catID)){
            $subCats=$this->managereports_model->getSubCatsBySubCatID($catID);

            if(isset($subCats) && !empty($subCats)) { 
             $select_options.= '<option value="">Select</option>';
             foreach($subCats as $cat) {
             $select_options.= '<option value="'.$cat["product_cat_id"].'">'.$cat["cat_name"].'</option>'; 
             }
            } else {
             $select_options.= '<option value="">No Records Found</option>';
            }
             echo $select_options;

        }else{
            echo  $select_options.= '<option value="">Select Main Cat</option>';
        }

    }

    function getProductsByCat(){
        global $uInfo;
        $select_options = '';
       // $catID=$this->input->post('catID');
        //if(isset($catID) && !empty($catID)){
            $products=$this->managereports_model->getProductsByCatID($uInfo['comp_code']);

            if(isset($products) && !empty($products)) { 
             $select_options.= '<option value="">Select</option>';
             foreach($products as $prd) {
             $select_options.= '<option value="'.$prd["product_id"].'">'.$prd["product_name"].'</option>'; 
             }
            } else {
             $select_options.= '<option value="">No Records Found</option>';
            }
             echo $select_options;

        //}

        //else{
         //   echo  $select_options.= '<option value="">Select Main Cat</option>';
        //}

    }

    /**
    * Get Dealers
    * Start
    **/
    function getProductVendors(){
        global $uInfo;
        $select_options = '';
       // $catID=$this->input->post('catID');
        //if(isset($catID) && !empty($catID)){
            $products=$this->managereports_model->getProductVendors($uInfo['comp_code']);

            if(isset($products) && !empty($products)) { 
             $select_options.= '<option value="">Select</option>';
             foreach($products as $prd) {
             $select_options.= '<option value="'.$prd["product_id"].'">'.$prd["product_name"].'</option>'; 
             }
            } else {
             $select_options.= '<option value="">No Records Found</option>';
            }
             echo $select_options;

        //}

        //else{
         //   echo  $select_options.= '<option value="">Select Main Cat</option>';
        //}
    }

    function export_sales_summary(){
        global $uInfo;
        $conditions = array();
        $data=array();
            
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

    		$conditions['search']['employee_ID'] = $uInfo['user_ID'];
    		$conditions['search']['company_ID'] = $uInfo['comp_code'];
    		$conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

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
       	//$totalRec = count($this->managereports_model->getRows($conditions));
        
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;

    	$this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        //$filename  = "bankAc_From_".$from."To_".$to.".csv";
        $filename="sales_summary_".$startDate."_".$endDate.".csv";
     
        $conditions['search']['exp']=true;

        $result    = $this->managereports_model->getRows($conditions);

        $data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
     
    }
    function print_sales_summary(){

        global $uInfo;
        $conditions = array();
        $data=array();
            
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
    
        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
        $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

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
        //$totalRec = count($this->managereports_model->getRows($conditions));
        
        
        //set start and limit
       // $conditions['start'] = $offset;
       // $conditions['limit'] = $this->perPage;
        
        $conditions['search']['exp']=false;
        $data['frmDate']=$startDate;
        $data['toDate']=$endDate;
        $data['sales'] = $this->managereports_model->getRows($conditions);

        $this->load->library('pdf');
        $this->pdf->load_view('managereports/rpt_sales_summary',$data);
        $this->pdf->render();
        $fname="sales_summary_".$startDate."_".$endDate;
        $this->pdf->stream($fname);
        //$this->load->view('managereports/rpt_sales_summary',$data);
    }

   // function ajaxPaginationData(){

    function paginate_sales_summary(){
           
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
  		$conditions['search']['store_ID'] = $uInfo['store'];
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
        $config['base_url']    = base_url().'sale/managereports/paginate_sales_summary';
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
         $this->load->view('managereports/sale_summary_report_view', $data, false);
    }

    // Sales Detail 
    function paginate_sales_detail() {
           
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
            $conditions['search']['store_ID'] = $uInfo['store'];
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
            $totalRec = count($this->managereports_model->getSales($conditions));
            
            //pagination configuration
            $config['target']      = '#postList';
            $config['base_url']    = base_url().'sale/managereports/paginate_sales_detail';
            $config['total_rows']  = $totalRec;
            $config['per_page']    = $this->perPage;
            $config['link_func']   = 'searchFilter';
            $this->ajax_pagination->initialize($config);
            
            //set start and limit
            $conditions['start'] = $offset;
            $conditions['limit'] = $this->perPage;
            

            //get posts data
            $data['sales'] = $this->managereports_model->getSales($conditions);

          // var_dump($data);exit;
            $data['title'] = 'Dashboard | Sales';
            //load the view
           // $this->load->view('managereports/ajax-pagination-data', $data, false);
            $this->load->view('managereports/sales_detail_report_view', $data, false);
    }

   
    /***
    /*Export Sale Detail Report
    /*Start
    ***/
    function export_sales_detail(){
         global $uInfo;
            $conditions = array();
            $data=array();
            
            //calc offset number
            $page = $this->input->get('page');
            if(!$page){
                $offset = 0;
            }else{
                $offset = $page;
            }
   
            $conditions['search']['employee_ID'] = $uInfo['user_ID'];
            $conditions['search']['company_ID'] = $uInfo['comp_code'];
            $conditions['search']['store_ID'] = $uInfo['store'];
            //set conditions for search
            $keywords = $this->input->get('keywords');
            $sortBy = $this->input->get('sortBy');
            $startDate=$this->input->get('start_date');
            $endDate=$this->input->get('end_date');

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
           
            
            //set start and limit
            $conditions['start'] = $offset;
            $conditions['limit'] = $this->perPage;
            

            

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        
        $filename="sales_detail_".$startDate."_".$endDate.".csv";
     
        $conditions['search']['exp']=true;

        $result    = $this->managereports_model->getSalesToExport($conditions);

        $data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
     
    }
    /***
    /*Export Sale Detail Report
    /*End
    ***/

    /***
    /*Print Sale Detail Report
    /*Start
    ***/
    function print_sales_detail(){

        global $uInfo;
        $conditions = array();
        $data=array();
            
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
    
        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
        $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

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
        //$totalRec = count($this->managereports_model->getRows($conditions));
        
        
        //set start and limit
       // $conditions['start'] = $offset;
       // $conditions['limit'] = $this->perPage;
        
        $conditions['search']['exp']=false;
        $data['frmDate']=$startDate;
        $data['toDate']=$endDate;
        $data['sales'] = $this->managereports_model->getSales($conditions);

        $this->load->library('pdf');
        $this->pdf->load_view('managereports/rpt_sales_detail',$data);
        $this->pdf->render();
        $fname="sales_detail_".$startDate."_".$endDate;
        $this->pdf->stream($fname);
        //$this->load->view('managereports/rpt_sales_summary',$data);
    }
    /***
    /*Print Sale Detail Report
    /*End
    ***/

    /**
    * Best Selling Products
    * Start
    **/
    function export_best_selling(){
        global $uInfo;
        $conditions = array();
        $data=array();
            
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }

            $conditions['search']['employee_ID'] = $uInfo['user_ID'];
            $conditions['search']['company_ID'] = $uInfo['comp_code'];
            $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

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
        //$totalRec = count($this->managereports_model->getRows($conditions));
        
        
        //set start and limit
       /* $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;*/

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        //$filename  = "bankAc_From_".$from."To_".$to.".csv";
        $filename="sales_summary_".$startDate."_".$endDate.".csv";
     
        $conditions['search']['exp']=true;

        $result    = $this->managereports_model->exportBestSellingProducts($conditions);

        $data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
     
    }
    function print_best_selling(){

        global $uInfo;
        $conditions = array();
        $data=array();
            
        //calc offset number
        $page = $this->input->get('page');
        if(!$page){
            $offset = 0;
        }else{
            $offset = $page;
        }
    
        $conditions['search']['employee_ID'] = $uInfo['user_ID'];
        $conditions['search']['company_ID'] = $uInfo['comp_code'];
        $conditions['search']['store_ID'] = $uInfo['store'];
        //set conditions for search
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $startDate=$this->input->get('start_date');
        $endDate=$this->input->get('end_date');

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
        //$totalRec = count($this->managereports_model->getRows($conditions));
        
        
        //set start and limit
       // $conditions['start'] = $offset;
       // $conditions['limit'] = $this->perPage;
        
        $conditions['search']['exp']=false;
        $data['frmDate']=$startDate;
        $data['toDate']=$endDate;
        $data['sales'] = $this->managereports_model->getBestSellingProducts($conditions);

        $this->load->library('pdf');
        $this->pdf->load_view('managereports/prnt_best_selling',$data);
        $this->pdf->render();
        $fname="sales_summary_".$startDate."_".$endDate;
        $this->pdf->stream($fname);
        //$this->load->view('managereports/rpt_sales_summary',$data);
    }

   

    function paginate_best_selling(){
           
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
        $conditions['search']['store_ID'] = $uInfo['store'];
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
        $totalRec = count($this->managereports_model->getBestSellingProducts($conditions));
        
        //pagination configuration
        $config['target']      = '#postList';
        $config['base_url']    = base_url().'sale/managereports/paginate_best_selling';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        

      
        $data['sales'] = $this->managereports_model->getBestSellingProducts($conditions);
     
        $data['title'] = 'Dashboard | Sales';
       
        $this->load->view('managereports/best_selling_report_view', $data, false);
    }

    function export_item_stock(){

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
        
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $itemID=$this->input->get('itemID');
        $locID=$this->input->get('locID');
        $storeID=$this->input->get('storeID');

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

        $this->load->dbutil();
        $this->load->helper('file');
        $this->load->helper('download');
        $delimiter = ",";
        $newline   = "\r\n";
        //$filename  = "bankAc_From_".$from."To_".$to.".csv";
        $filename="item_stock_".date('d/m/Y').".csv";
     
        $conditions['search']['exp']=true;

        $result    = $this->managereports_model->getProductStock($conditions);

        $data      = $this->dbutil->csv_from_result($result, $delimiter, $newline);
        force_download($filename, $data);
     
    }

    function print_item_stock(){

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
        
        $keywords = $this->input->get('keywords');
        $sortBy = $this->input->get('sortBy');
        $itemID=$this->input->get('itemID');
        $locID=$this->input->get('locID');
        $storeID=$this->input->get('storeID');

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

        
        $conditions['search']['exp']=false;
        
        $data['storeName']=$this->managereports_model->getStoreNameByID($storeID);
        $data['prd_stock'] = $this->managereports_model->getProductStock($conditions);

        $this->load->library('pdf');
        $this->pdf->load_view('managereports/prnt_item_stock',$data);
        $this->pdf->render();
        $fname="item_stock_".date('d/m/Y');
        $this->pdf->stream($fname);
        
    }

    function paginate_item_stock(){
           
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
        $keywords = $this->input->post('keywords');
        $sortBy = $this->input->post('sortBy');
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
        $config['base_url']    = base_url().'sale/managereports/paginate_item_stock';
        $config['total_rows']  = $totalRec;
        $config['per_page']    = $this->perPage;
        $config['link_func']   = 'searchFilter';
        $this->ajax_pagination->initialize($config);
        
        //set start and limit
        $conditions['start'] = $offset;
        $conditions['limit'] = $this->perPage;
        
      
        $data['prd_stock'] = $this->managereports_model->getProductStock($conditions);
     
        $data['title'] = 'Dashboard | Sales';
        $data['storeName']=$this->managereports_model->getStoreNameByID($storeID);
       
        $this->load->view('managereports/paginate_item_stock', $data, false);
    }

    // Daily Sales Report
    public function dailySaleReport() {
        global $uInfo;

        $date=$this->input->get('date');
        $storeId=$this->input->get('store_id');
        $data['title'] = 'Dashboard | Sales Report';
        $dailyReport=$this->managereports_model->dailySaleReport($date,$storeId);
        

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

       
            $data['report'][$saleId]=array_merge($info,$cash,$ccredit,$dcard,$check,$creditNoteAry);

           $id=$saleId;
        }

       if($date==''&&$storeId=='') {
            $this->load->view('managereports/daily_sales_report', $data, false);
       } elseif($storeId=='No Stores') {
            $this->load->view('managereports/daily_sale_report_filter', $data, false);
       }else {
            $this->load->view('managereports/daily_sale_report_filter', $data, false);
       }
        
    }

    public function sales_invoice($saleID) {
        $uInfo=$this->session->userdata('sales_session_info');
        $saleData=array();
        $saleData['sale_ID']= $saleID;
        $saleData['sale_detail']=$this->managesales_model->getSaleDetailByID($saleID);
        $saleData['sale_items']=$this->managesales_model->getSaleItemsByID($saleID);
        $saleData['sale_payments']=$this->managesales_model->getSalePaymentsByID($saleID);

        $saleData['sale_store_info']=$this->managesales_model->getStoreInfoByID($uInfo['store']);

        $custID=false;
        $custID=$this->managesales_model->getSaleCustomerByID($saleID);

        if($custID){
        $saleData['sale_customer']=$this->managesales_model->getCustomerInfoByID($custID);
        }

        $companyId = (isset($saleData['sale_store_info']['comp_code']) && ($saleData['sale_store_info']['comp_code'] != '')) ? $saleData['sale_store_info']['comp_code'] : $uInfo['comp_code'];
        $companyUserId = (isset($saleData['sale_store_info']['user_ID']) && ($saleData['sale_store_info']['user_ID'] != '')) ? $saleData['sale_store_info']['user_ID'] : $uInfo['user_ID'];

        $saleData['companyDetails'] = $this->managesales_model->companyInfoById($companyId, $companyUserId);
        $saleData['companyID'] = $companyId;

        $saleData['companyFirmInfo'] = $this->managesales_model->companyFirmInfoById($companyId, $companyUserId);

        $this->load->view('managesales/print_invoice',$saleData);
    }
}