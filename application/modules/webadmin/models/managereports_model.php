<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managereports_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
		global $uInfo;
		$uInfo=$this->session->userdata('webadmin_session_info');
	}

 	function addDealer($data){
		$this->db->insert('dealer',$data);
		$user_ID=$this->db->insert_id();
	}
	
	function addDealerBankDetails($data1){
		$this->db->insert('dealer_bank_details',$data1);
		$user_ID=$this->db->insert_id();
	}

  public function getAllUsers($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('user_master');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function getProductsByCatPrice($comp_code)
  {
        $main_cat = $this->input->post('main_cat');
		$sub_cat = $this->input->post('sub_cat');
		$sub_sub_cat = $this->input->post('sub_sub_cat');
		$start_price = $this->input->post('start_price');
		$end_price = $this->input->post('end_price');
		$p_attr = $this->input->post('product_attribute');
   
  		if(!empty($main_cat))
		{
			$this->db->where(array('product.product_category'=>$main_cat));
		}
		if(!empty($sub_cat))
		{
			$this->db->where(array('product.product_sub_category'=>$sub_cat));
		}
		if(!empty($sub_sub_cat))
		{
			$this->db->where(array('product.product_sub_of_sub_category'=>$sub_sub_cat));
		}

		if(!empty($p_attr)) {
			$this->db->join('product_attribute', 'product_attribute.product_id = product.product_id');
			$this->db->where(array('product_attribute.attribute_id'=>$p_attr));
		}
		
		$this->db->where( "product.product_price BETWEEN $start_price AND $end_price", NULL, FALSE );
		$this->db->where(array('product.comp_code'=>$comp_code));
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
  }


  public function getDealerInfoForFilter($dealerName,$dealer_city,$start_price,$end_price) {
  		global $uInfo;

  		if(!empty($dealerName)) {
  			$this->db->where("f_name LIKE '%".$dealerName."%'");
  			//$this->db->or_where("l_name LIKE '%".$dealerName."%'");
  		}

  		if(!empty($dealer_city)) {
  			$this->db->where(array('city'=>$dealer_city));
  		}

  		if($start_price != 0 && $end_price != '') {
  			$this->db->where('dealer_credit_limits BETWEEN "'. $start_price . '" and "'. $end_price.'"');
  		}
  		
  		$this->db->where('comp_code',$uInfo['comp_code']);

  		$this->db->from('dealer');
		$query = $this->db->get();
		return $query->result();
  }


  public function getVendorInfoForFilter($vendor_name,$vendor_mob_number,$dealer_city) 
  {
  	global $uInfo;
  		if(!empty($vendor_name)) {
  			$this->db->where("f_name LIKE '%".$vendor_name."%'");
  		}

  		if(!empty($vendor_mob_number)) {
  			$this->db->where("mobile_number LIKE '%".$vendor_mob_number."%'");
  		}

  		if(!empty($dealer_city)) {
  			$this->db->where("city LIKE '%".$dealer_city."%'");
  		}
  		$this->db->where('comp_code',$uInfo['comp_code']);
  		$this->db->from('vendor');
		$query = $this->db->get();
		return $query->result();
  }


  
  public function getTaxesByCityState()
  {
  	global $uInfo;
        $city_id = $this->input->post('city_id');
		$tax_country = $this->input->post('tax_country');
		$tax_state = $this->input->post('tax_state');
		
   
  if(!empty($city_id))
		{
		$this->db->where(array('city_id'=>$city_id));
		}
		if(!empty($tax_country))
		{
		$this->db->where(array('country_id'=>$tax_country));
		}
		
		if(!empty($tax_state))
		{
		$this->db->where(array('state_id'=>$tax_state));
		}
		
		$this->db->from('tax');
		$this->db->where('comp_code',$uInfo['comp_code']);
		$query = $this->db->get();
		return $query->result();
  }
  
   public function getAllProducts($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
  }
  public function bankAcount($comp_code)
  {
 		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('bank_acount');
		$query = $this->db->get();
		return $query->result();
  }
  public function dealerReportByDate($from,$to)
  {
	  	global $uInfo;
	  	$compCode = $uInfo['comp_code'];
	  	$userId = $uInfo['user_ID'];

 		$this->db->select('*');
 		$this->db->where(['user_ID'=>$userId]);
		$this->db->where('create_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

		/*if($type != '' && is_numeric($type)) {
			$this->db->where('dealer_vender_other',$type);
		}*/
		
		$this->db->from('dealer_bank_details');
		$query = $this->db->get();
		return $query->result_array();
  }

  public function vendorReportByDate($from,$to)
  {
	  	global $uInfo;
	  	$compCode = $uInfo['comp_code'];
	  	$userId = $uInfo['user_ID'];

 		$this->db->select('*');
 		$this->db->where(['user_ID'=>$userId]);
		$this->db->where('create_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

		/*if($type != '' && is_numeric($type)) {
			$this->db->where('dealer_vender_other',$type);
		}*/
		
		$this->db->from('vendor_bank_details');
		$query = $this->db->get();
		return $query->result_array();
  }
  
   public function cashReportByDate($from,$to,$cashtype)
  {
  		global $uInfo;
	  	$compCode = $uInfo['comp_code'];
	  	$userId = $uInfo['user_ID'];

 		$this->db->select('*');
		$this->db->where('created_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

		if($cashtype != '' && is_numeric($cashtype)) {
			$this->db->where('dealer_vender_other', $cashtype);
		}

		$this->db->where('comp_code',$compCode);
		$this->db->from('cash_book');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function cashBook($comp_code)
  {
 		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('cash_book');
		//$this->db->limit($limit, $start);
		$query = $this->db->get();
		return $query->result();
  }
  
  
  public function getAllDealers($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('dealer');
		$query = $this->db->get();
		return $query->result();
  }
   public function getDealerAcountByIdAndDate($dealer_id,$from,$to){
		$this->db->select('*');
		$this->db->where(array('dealer_user_id'=>$dealer_id));
		$this->db->where('created BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
		$this->db->from('dealer_account');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function getDealerAcountById($dealer_id){
		$this->db->select('*');
		$this->db->where(array('dealer_user_id'=>$dealer_id));
		$this->db->from('dealer_account');
		$query = $this->db->get();
		return $query->result();
  }
  
   public function getVendorAcountById($vendor_id){
		$this->db->select('*');
		$this->db->where(array('vendor_user_id'=>$vendor_id));
		$this->db->from('vendor_account');
		$query = $this->db->get();
		return $query->result();
  }
  
   public function getVendorAcountByIdAndDate($vendor_id,$from,$to){
		$this->db->select('*');
		$this->db->where(array('vendor_user_id'=>$vendor_id));
		$this->db->where('created BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
		$this->db->from('vendor_account');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function getAllVenders($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('vendor');
		
		$query = $this->db->get();
		return $query->result();
  }
  public function getAllTaxes($comp_code){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		$this->db->from('tax');
		
		$query = $this->db->get();
		return $query->result();
  }
  
   public function getAllOffers($comp_code,$offerName,$startDate,$endDate){
		$this->db->select('*');
		$this->db->where('comp_code',$comp_code);
		if($offerName!='') {
			$this->db->where("offer_name LIKE '%".$offerName."%'");
		}
		if($startDate!='') {
			$this->db->where("date_duration_start", $startDate);
		}
		if($endDate!='') {
			$this->db->where("date_duration_end LIKE '%".$endDate."%'");
		}
		$this->db->from('offer');
		$query = $this->db->get();
		return $query->result();
  }
  
   public function getUsersByDepart($depart_id){
		
	$sql = "SELECT * FROM user_master where FIND_IN_SET('$depart_id',department_id)"; 	
	$query = $this->db->query($sql);	
	if($query->num_rows() > 0){
    $row = $query->result();
    return $row;
    }else{
    return false;
  }
  }
   public function getUsersStoreWise($store_id,$comp_code){
		$this->db->select('*');
		$this->db->where(array('store_id'=>$store_id));
		$this->db->where('comp_code',$comp_code);
		$this->db->from('user_master');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function getStoresFilter(){
		$this->db->select('*');
		$location_id = $this->input->post('location_id');
		$city_id = $this->input->post('city_id');
		$state_id = $this->input->post('state_id');
		if(!empty($location_id))
		{
		$this->db->where(array('store_location_id'=>$location_id));
		}
		if(!empty($city_id))
		{
		$this->db->where(array('store_city_id'=>$city_id));
		}
		
		if(!empty($state_id))
		{
		$this->db->where(array('store_state_id'=>$state_id));
		}
		$this->db->from('store');
		$query = $this->db->get();
		return $query->result();
  }
  
  
   public function getUsersWarehouseWise($warehouse_id){
		$this->db->select('*');
		$this->db->where(array('warehouse_id'=>$warehouse_id));
		$this->db->from('user_master');
		$query = $this->db->get();
		return $query->result();
  }
  
  public function getAllDealerAndPayments() {
    $this->db->select('dealer_invoice.*,dealers.*');
    $this->db->from('dealer_invoice');
    $this->db->join('dealer', 'dealer_invoice.dealer_id = dealer.dealer_id', 'left'); 
    $query = $this->db->get();
  
  } 
  
   public function getDealerPayments(){
		$this->db->select('*');
		$this->db->from('dealer_invoice');
		$query = $this->db->get();
		return $query->result();
  }
  
  
  public function getDealerInfoByID($dealerID){
	$query = $this->db->get_where('dealer', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
			return $query->row();
		else
			return FALSE;
  }
  
  public function getDealerInvoice($dealerID)
  {
  $query = $this->db->get_where('dealer_invoice', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
		{
			
		return $query->result();
		} 
		else {
			return FALSE;
  }
  }
  
  public function getDealerBankInfoByID($dealerID){
	$query = $this->db->order_by('id', 'ASC')->get_where('dealer_bank_details', array('dealer_id' => $dealerID));
		if($query->num_rows() > 0)
			return $query->result();
		else
			return FALSE;
  }
  
  public function updateDealer($dealerID,$data){
  	$this->db->where('dealer_id',$dealerID);
	$this->db->update('dealer',$data);
  }
  
   public function oldDealerBankDetails($dealerID){
  	$this->db->where('dealer_id', $dealerID);
	$this->db->delete('dealer_bank_details');
  }
 
 public function deleteDealer($dealerID){
	$this->db->where('dealer_id', $dealerID);
	$this->db->delete('dealer');
 }
 
 //Status ChangeFor User Status
 public function changeDealerStatus($dealerID,$data){
 	$this->db->where('dealer_id',$dealerID);
	$this->db->update('dealer',$data);
	//echo $this->db->last_query();
 }
 
 public function changePassword($dealerID)
 {
	
		$this->db->where('dealer_id', $dealerID);
		$this->db->where('password', sha1($this->input->post('password')));
		//$this->db->where('cpassword', $this->input->post('cpassword'));
		$query = $this->db->get('dealer');
		if($query->num_rows() == 1){
			$this->db->where('dealer_id', $dealerID);
			$this->db->update('dealer', array('password' => sha1($this->input->post('npassword')),'cpassword' => $this->input->post('cpassword')));
			return TRUE;
		}else{
			return FALSE;
		}
	
 }
 
 public function checkEmailExist($email)
 {
		$query = $this->db->get_where('dealer', array('email' => $email));
		if($query->num_rows() > 0)
		{
			echo "Email Already Exists";
		}else{
			echo "true";
		}
 }

 public function getAllSales($userId){
		$this->db->select('*');
		$this->db->where('employee_ID',$userId);
		$this->db->from('sale');
		$query = $this->db->get();
		return $query->result();
  }

  public function getUserByRoleId($rolecode) {
	  	global $uInfo;
	  	$compCode = $uInfo['comp_code'];
		$this->db->select('*');
		$this->db->where_in('user_role',$rolecode);
		$this->db->where('comp_code',$compCode);
		$this->db->from('user_master');
		$query = $this->db->get();
		return $query->result();
  }

  function dailySaleReport($fromdateval,$todateval,$employeeId,$storeId) {

  	global $uInfo;
	$compCode = $uInfo['comp_code'];

    if($fromdateval=='' && $todateval=='') {
       $getDate=date('Y-m-d');
       // $getDate='2017-12-19';
    } 

    $this->db->select('*');
    $this->db->from('sale as a');
    $this->db->join('sale_payments as b','b.sale_ID = a.sale_ID');

    if($fromdateval=='' && $todateval=='') {
    	 $getDate=date('Y-m-d');
	    $this->db->where("DATE( a.date_time_created ) LIKE '%".$getDate."%'");
	} else {
		$this->db->where('DATE(a.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($fromdateval)). '" and "'. date('Y-m-d', strtotime($todateval)).'"');
	}

    $this->db->where("a.comp_code", $compCode);

   	if($employeeId != '') {
   		$this->db->where('a.employee_ID',$employeeId);
   	}
   	if($storeId != '') {
   		$this->db->where('a.store_ID',$storeId);
   	}

    $query = $this->db->get();
    //echo $this->db->last_query();
    return $query->result_array();

   /* $this->db->select('*')->from('sale')
   ->where("DATE( date_time_created ) LIKE '%".$getDate."%'")->get();*/

    //echo  $this->db->last_query();exit;
       
    }


    // Get Sale Summary
    function getRows($params = array()){

    	global $uInfo;
    	$compCode = $uInfo['comp_code'];
        $this->db->select('*,count(sale_ID) as no_of_sale,DATE(date_time_created) as sale_date, SUM(sub_total) as sub_total, SUM(total) as total');
        $this->db->from('sale');

       
  		//$this->db->where('employee_ID',$params['search']['employee_ID']);
  	//	$this->db->where('company_ID',$params['search']['company_ID']);
  	//	$this->db->where('store_ID',$params['search']['store_ID']);
        
        $this->db->where('DATE(date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
        $this->db->where('comp_code',$compCode);

        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('sale_ID',$params['search']['sortBy']);
        }else{
            $this->db->order_by('sale_ID','desc');
        }
        
        //Sell date between clause

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        //get records
        $this->db->group_by('DATE(date_time_created)');
        
        $query = $this->db->get();
    //echo $this->db->last_query();

        if($params['search']['exp']){
        	return $query;
        }

        //echo  $this->db->last_query();
        if($query->num_rows()){
        	return $query->result_array();
        }else{
        	return false;
        }
        
    }



    // Get Sale Details
    function getSales($params = array()){
    	global $uInfo;
    	$compCode = $uInfo['comp_code'];

    	

        $this->db->select('sl.*, um.user_full_name as sold_by, sitm.itm_cnt as itm_cnt, sitm.cgst_amt as cgst_amt, sitm.sgst_amt as sgst_amt, sitm.igst_amt as igst_amt');
        $this->db->from('sale as sl');
        $this->db->join('user_master as um','um.user_ID=sl.employee_ID','left');
       
       //select count(`sale_item_ID`), sale_ID from sale_items GROUP BY sale_ID
        $this->db->join('(select count(`sale_item_ID`) as itm_cnt, sale_ID, cgst_amt, sgst_amt, igst_amt from sale_items GROUP BY sale_ID) as sitm','sitm.sale_ID=sl.sale_ID','left');
    
        //$this->db->where('sl.employee_ID',$params['search']['employee_ID']);
       // $this->db->where('sl.company_ID',$params['search']['company_ID']);
       // $this->db->where('sl.store_ID',$params['search']['store_ID']);
        
        $this->db->where('DATE(sl.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
        $this->db->where('sl.comp_code',$compCode);


        if(isset($params['search']['storeId']) && $params['search']['storeId']!='' && is_numeric($params['search']['storeId'])) {
    		$storeId = $params['search']['storeId'];
    		$this->db->where('sl.store_ID',$storeId);
    	}

        //sort data by ascending or desceding order
        if(!empty($params['search']['sortBy'])){
            $this->db->order_by('sl.sale_ID',$params['search']['sortBy']);
        }else{
            $this->db->order_by('sl.sale_ID','desc');
        }
        
        //Sell date between clause

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
       //get records
        
        $query = $this->db->get();
       //echo $this->db->last_query();//die;
       
        if($params['search']['exp']){
            return $query;
        }

       //echo  $this->db->last_query();
        if($query->num_rows()){
            return $query->result_array();
        }else{
            return false;
        }
    }


    function getPaymentsBySaleID($saleID){
        $this->db->select('payment_method, payment_amount');
        $this->db->from('sale_payments');
        $this->db->where('sale_ID',$saleID);
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;

    }


    /**
    *Get Best Selling Products
    *Start
    **/
 
    function getBestSellingProducts($params = array()){
  		global $uInfo;
    	$compCode = $uInfo['comp_code'];

        $this->db->select("S.sale_ID,SI.product_ID,SI.master_product_id,SI.sale_item_ID,COUNT(SI.master_product_id) as mprdCnt, COUNT(SI.product_ID) as prdCnt, SUM(SI.quantity) as totQty,P.product_name,SUM(SI.item_subtotal) as itmTotal, SI.item_cost_price");

        $this->db->from("sale as S");
        $this->db->join('sale_items as SI','S.sale_ID = SI.sale_ID','INNER'); 
        $this->db->join('product as P','SI.master_product_id=P.product_id','left');

      //  $this->db->where('S.employee_ID',$params['search']['employee_ID']);
       // $this->db->where('S.company_ID',$params['search']['company_ID']);
        //$this->db->where('S.store_ID',$params['search']['store_ID']);
        $this->db->where('S.sale_type',0);
        
        $this->db->where('DATE(S.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
        $this->db->where('S.comp_code',$compCode);
        //Sell date between clause
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

        if(isset($params['search']['storeId']) && $params['search']['storeId']!='' && is_numeric($params['search']['storeId'])) {
    		$storeId = $params['search']['storeId'];
    		$this->db->where('S.store_ID',$storeId);
    	}
        
        $this->db->group_by('SI.product_ID');
        
        $query = $this->db->get();
        // echo $this->db->last_query();
       
        if($params['search']['exp']){
            return $query;
        }

       /// echo  $this->db->last_query();
        if($query->num_rows()){
            return $query->result_array();
        }else{
            return false;
        }
    }

     function getLocations($comp_code){
        $this->db->select('*');
        $this->db->from('locations');
        $this->db->where(array('comp_code'=>$comp_code));  
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;
    }

    function getProductsAll($comp_code){
        $this->db->select('*');
        $this->db->from('product');
        $this->db->where(array('comp_code'=>$comp_code));
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;

    }

    function getStoresByLocID($param = array()){

        $this->db->select('*');
        $this->db->from('store');
        $this->db->where(array('comp_code'=>$param['comp_code'],'store_location_id'=>$param['locID']));  
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;
    }


    function getProductStock($params = array()){
    	
        /*Working Query*/
        /*
        SELECT * FROM `product` as p left join store_inventory as si on p.product_id=si.product_id and si.store_id=20 WHERE p.`comp_code`=3 
        */
        global $uInfo;
    	$compCode = $uInfo['comp_code'];


        $this->db->select('P.product_name prdName, P.product_price prdPrice, SI.stock_qty stockqty, SI.product_id sku');
        $this->db->from('product as P');

        $this->db->join('store_inventory as SI','P.product_id=SI.master_product_id AND SI.store_id='.$params['search']['storeID'],'left');
       
      //  $this->db->where('P.comp_code',$params['search']['compID']);
        $this->db->where(['P.comp_code'=>$compCode, 'SI.stock_qty !='=>'0']);
        
        if(isset($params['search']['itemID']) && !empty($params['search']['itemID']) && is_numeric($params['search']['itemID'])){
            $this->db->where('P.product_id',$params['search']['itemID']);
        }

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }

       //get records
       // $this->db->group_by('DATE(date_time_created)');
        
        $query = $this->db->get();
      //  echo $this->db->last_query();die;
       
        if($params['search']['exp']){
            return $query;
        }

        //echo  $this->db->last_query();die;
        if($query->num_rows()){
            return $query->result_array();
        }else{
            return false;
        }
    }

  	function getStoreNameByID($storeID){
       
        $this->db->select('store_name');
        $this->db->from('store');
        $this->db->where('store_id',$storeID);
        $query = $this->db->get();
        return $query->row()->store_name;
    }


    // Get Warehouse Inventory By Product Id
    function getWarehouseInventoryByPId($pId,$catId,$subCatId,$subSubCatId,$attribute) {
    	global $uInfo;	

    	$this->db->select('GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(DISTINCT a.warehouse_id) as warehouseId, GROUP_CONCAT(a.master_product_id) as masterPId');
        $this->db->from('warehouse_inventory as a');


        if($catId!='' && $subCatId!='' && $subSubCatId!='' && is_numeric($catId)) {
        	$this->db->select('b.product_category');
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}
        	$this->db->where(['b.product_category'=>$catId, 'b.product_sub_category'=>$subCatId, 'product_sub_of_sub_category'=>$subSubCatId]);
        } 
        else if($catId!='' && $subCatId!='' && is_numeric($catId)) {
        	$this->db->select('b.product_category');
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}
        	$this->db->where(['b.product_category'=>$catId, 'b.product_sub_category'=>$subCatId]);
        } 
        else if($catId!='' && is_numeric($catId)) {
        	$this->db->select('b.product_category');
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}
        	$this->db->where(['b.product_category'=>$catId]);
        } else {
        	$this->db->select('b.product_category');
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        }

        if($pId!='' && is_numeric($pId)) {
    		$this->db->where('a.master_product_id',$pId);
        } else {
        	$this->db->where('a.master_product_id !=',0);
        }

      	
        $this->db->where('a.comp_code',$uInfo['comp_code']);
        $this->db->group_by('a.warehouse_id');
        $query = $this->db->get(); 
       // echo $this->db->last_query();
        if($query->num_rows()){
            return $query->result_array();
        }else{
            return false;
        }
    }


    // Get Store Inventory By Product ID
    function getStoreInventoryByPId($pId,$catId,$storeId,$attribute) {
    	global $uInfo;

    	$this->db->select('GROUP_CONCAT(a.product_id) as sku, GROUP_CONCAT(a.stock_qty) as sqty, GROUP_CONCAT(a.store_id) as storeId, b.product_name, GROUP_CONCAT(a.master_product_id) as masterPId, b.product_category');
        $this->db->from('store_inventory as a');
       // $this->db->join('product as b', 'b.product_id = a.master_product_id');


        if($catId!='' && $pId!='' && is_numeric($catId) && is_numeric($pId)) {
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	if($storeId!='') {
        		$this->db->where(['a.store_id'=>$storeId]);
        	}

        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}

        	$this->db->where(['b.product_category'=>$catId, 'a.master_product_id'=>$pId]);
        } 
        else if($pId!='' && is_numeric($pId)) {
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	$this->db->where('a.master_product_id',$pId);
        	if($storeId!='') {
        		$this->db->where(['a.store_id'=>$storeId]);
        	}

        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}
        } 
        else if($catId!='' && is_numeric($catId)) {
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        	if($storeId!='') {
        		$this->db->where(['a.store_id'=>$storeId]);
        	}

        	if($attribute!='') {
        		$this->db->join('product_attribute as c' ,'c.product_id = a.master_product_id');
        		$this->db->where('c.attribute_id',$attribute);
        	}

        	$this->db->where(['b.product_category'=>$catId]);
        } 
        else {
        	$this->db->join('product as b' ,'b.product_id = a.master_product_id');
        }
       
        $this->db->where('a.comp_code',$uInfo['comp_code']);
        $this->db->group_by('a.store_id');
        $query = $this->db->get();
      // echo $this->db->last_query(); 

        if($query->num_rows()){
            return $query->result_array();
        }else{
            return false;
        }
    }



    // Get General Product Report
    function getProductReport($pcat,$psubcat,$psubofsubcat,$pattr) {
    	global $uInfo;
    	$this->db->select('*');

    	if($pcat != '') {
    		$this->db->where('product_category',$pcat);
    	}

    	if($psubcat != '') {
    		$this->db->where('product_sub_category',$psubcat);
    	}

    	if($psubofsubcat != '') {
    		$this->db->where('product_sub_of_sub_category',$psubofsubcat);
    	}

    	if($pattr != '') {
    		//$attr_name = get_attribute_by_productID($product->product_id);
    		$this->db->join('product_attribute','product_attribute.product_id = product.product_id');
    		$this->db->where('product_attribute.attribute_id',$pattr);
    	}

		$this->db->where('comp_code',$uInfo['comp_code']);
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
    }


    // Get Vendor Report
    public function getTaxReport($tax_country,$tax_state,$city_id)
 	{
 		global $uInfo;
 		$this->db->select('*');
  		if(!empty($city_id))
		{
		$this->db->where(array('city_id'=>$city_id));
		}
		if(!empty($tax_country))
		{
		$this->db->where(array('country_id'=>$tax_country));
		}
		
		if(!empty($tax_state))
		{
		$this->db->where(array('state_id'=>$tax_state));
		}
		
		$this->db->from('tax');
		$this->db->where('comp_code',$uInfo['comp_code']);
		$query = $this->db->get();
	//	echo $this->db->last_query();
		return $query->result();
  }


  public function getOrderDetail($params = array()) {
  	global $uInfo;
  	$comp_code = $uInfo['comp_code'];
  	$where = '';

        $this->db->select('a.*, b.product_id, b.price, b.master_product_id, b.quantity, c.invoice_id, c.total_amount, c.dealer_user_id');
        $this->db->from('orders as a');

        $this->db->join('order_detail as b', 'a.order_id = b.order_id');
        $this->db->join('dealer_account as c', 'c.order_id = a.order_id');
      //  $this->db->join('product as d', 'd.product_id = b.master_product_id');

       $this->db->where('DATE(a.date) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
        $this->db->where('a.comp_code',$comp_code);

        /*if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }*/
        
        $query = $this->db->get();
   	   // echo $this->db->last_query();die;
        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
  }


  public function getSaleDetail($params = array()) {
  		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

        $this->db->select('b.gst_amt, b.cgst_amt, b.sgst_amt, b.igst_amt, a.total, a.sub_total, a.total_new, a.invoice_number, a.store_id, a.sale_ID, a.date_time_created, b.product_ID, b.item_cost_price, b.item_unit_price, b.product_mrp');
        $this->db->from('sale as a');

        $this->db->join('sale_items as b', 'a.sale_ID = b.sale_ID');

        $this->db->where('DATE_FORMAT(a.`date_time_created`, "%Y-%m-%d") BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');

        $this->db->where('a.`comp_code`',$comp_code);

        //$this->db->group_by('b.sale_ID');
        $query = $this->db->get();
     // echo $this->db->last_query();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
    }


  	public function getShotDetail($params = array()) {
  		global $uInfo;

	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('*');
        $this->db->from('day_close as a');
        $this->db->where('a.`comp_code`',$comp_code);

        if(isset($params['search']['employeeID']) && $params['search']['employeeID'] != '') {
        	$this->db->where('a.`user_id`',$params['search']['employeeID']);
        }

        if(isset($params['search']['storeID']) && $params['search']['storeID'] != '') {
        	$this->db->where('a.`store_id`',$params['search']['storeID']);
        }

        if(isset($params['search']['startDate']) && $params['search']['startDate'] != '') {
         	//$selectDate = DATE_FORMAT(a.`modify_date`, "%Y-%m-%d");
        	$this->db->where('DATE_FORMAT(a.`modify_date`, "%Y-%m-%d") =',$params['search']['startDate']);
        }


        $query = $this->db->get();
       //echo $this->db->last_query();
 
        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}


 	public function getOrderProduct($params = array()) {
 		global $uInfo;
  		$comp_code = $uInfo['comp_code'];

  		$this->db->select('a.*,GROUP_CONCAT(b.master_product_id) as pId, GROUP_CONCAT(b.price) as price, GROUP_CONCAT(b.quantity) as qty, GROUP_CONCAT(b.product_id) as sku');
        $this->db->from('orders as a');

        $this->db->join('order_detail as b', 'a.order_id = b.order_id');

        $this->db->where('DATE(a.date) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
        $this->db->where('a.comp_code',$comp_code);
        $this->db->group_by('b.order_id');

        $query = $this->db->get();
   	    //echo $this->db->last_query();die;
        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}


 	public function getSalesEmployee($params = array()) {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('a.employee_ID as employeeId, a.sale_ID as saleId, a.store_gst_number, a.store_ID, a.location_ID, b.product_tax, a.sub_total, a.total_new, b.item_subtotal, b.master_product_id');
	  	
	  	$this->db->from('sale as a');
	  	$this->db->join('sale_items as b', 'a.sale_ID = b.sale_ID');

	  	$this->db->where('DATE_FORMAT(a.`date_time_created`, "%Y-%m-%d") BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');

        $this->db->where('a.`comp_code`',$comp_code);

        if(isset($params['search']['gstNumber']) && $params['search']['gstNumber'] != '')  {
        	$this->db->select('gst.gst_number');
        	$this->db->join('locations as lo', 'lo.id = a.location_ID');
        	$this->db->join('gst_number as gst', 'gst.state_id = lo.state_id');
        }
     //   $this->db->group_by('a.`employee_ID`');

        $query = $this->db->get();

       // echo '<pre>';print_r($query->result_array());die;

        if($query->num_rows()){
        	return $query->result_array();
        }else{
        	return false;
        }
 	}


 	public function getSaleLocation($userId) {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('a.location, a.user_ID as userId, b.country_id as countryId, b.state_id as stateId, c.name as statename, d.name as contryname');
	  	$this->db->from('user_master as a');

	  	$this->db->join('locations as b','b.id = a.location');
	  	$this->db->join('states as c','c.id = b.state_id');
	  	$this->db->join('countries as d','d.id = b.country_id');

	  	$this->db->where_in('a.user_ID',$userId);

	  	$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}

 	public function getSaleItemRate($saleID) {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('SUM(tax_per) as taxrate, SUM(product_tax) as pTax');
	  	$this->db->from('sale_items as a');

	  	$this->db->where_in('a.sale_ID',$saleID);
	  	$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}


 	public function saleCashDetail() {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('a.sale_ID, user.user_name, store.store_name, b.invoice_number, b.total, a.payment_amount, a.created_date');
	  	$this->db->from('sale_payments as a');

	  	$this->db->join('sale as b','b.sale_ID = a.sale_ID');
	  	$this->db->join('user_master as user', 'user.user_ID = b.employee_ID');
 		$this->db->join('store as store', 'store.store_id = b.store_ID');

		$this->db->where('b.`comp_code`',$comp_code);
		$this->db->like('payment_method', 'cash', 'both');

	  	$query = $this->db->get();
	  	//echo $this->db->last_query();die;

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}

 	public function saleCashDetailByDate($from,$to,$store_id) {

 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

 		$this->db->select('a.sale_ID, user.user_name, store.store_name, b.invoice_number, b.total, a.payment_amount, a.created_date');
 		$this->db->from('sale_payments as a');

 		$this->db->join('sale as b','b.sale_ID = a.sale_ID');
 		$this->db->join('user_master as user', 'user.user_ID = b.employee_ID');
 		$this->db->join('store as store', 'store.store_id = b.store_ID');

 		$this->db->where('b.`comp_code`',$comp_code);
 		$this->db->like('payment_method', 'cash', 'both');

		$this->db->where('a.created_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');

		if($store_id != '' && is_numeric($store_id)) {
			$this->db->where('b.`store_ID`',$store_id);
		}

		$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}





/* get the tax rate based On "Cess Tax" (Static pass the cess)*/
 	public function getCessTax($taxId) {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

	  	$this->db->select('rate');
	  	$this->db->from('tax');

	  	$this->db->where('tax_id',$taxId);

	  	$this->db->like('tax_name','cess','both');

	  	$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
 	}
/* get the tax rate based On "Cess Tax" (Static pass the cess)*/


	public function getCessBySale($saleId) {
	 	global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

  		$this->db->select('a.master_product_id, b.product_tax, b.gst_rate');
  		$this->db->from('sale_items as a');

  		$this->db->join('product as b','a.master_product_id = b.product_id');
  		$this->db->where('a.sale_ID',$saleId);

  		$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
	}


 	public function getCessTaxId() {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$userid = $uInfo['user_ID'];
	  	
	  	$this->db->select('rate,tax_id');
	  	$this->db->from('tax');

	  	$this->db->like('tax_name','cess','both');

	  	$query = $this->db->get();

        if($query->num_rows()) {
        	return $query->result();
        } else {
        	return false;
        }
 	}


 	public function getGstNumberById($storeId,$employeeId,$stateId) {
 		global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$userid = $uInfo['user_ID'];

	  	if($storeId != '') {
	  		$this->db->select('a.store_gst_number,b.gst_number');
	  		$this->db->from('store as a');

	  		$this->db->join('gst_number as b','b.gst_number_id = a.store_gst_number', 'left');
	  		$this->db->where(['a.store_id'=>$storeId,'b.user_id'=>$userid]);
	  	}

	  	if($employeeId != '') {
	  		$this->db->select('a.store_id,b.store_gst_number,c.gst_number');
	  		$this->db->from('user_master as a');

	  		$this->db->join('store as b','b.store_id = a.store_id', 'left');
	  		$this->db->join('gst_number as c','c.gst_number_id = b.store_gst_number', 'left');

	  		$this->db->where(['a.user_ID'=>$employeeId,'c.user_id'=>$userid]);
	  	}

	  	if($stateId != '') {
	  		$this->db->select('gst_number');
	  		$this->db->from('gst_number');
	  		$this->db->where(['state_id'=>$stateId,'user_id'=>$userid]);
	  	}

  		
  		$query = $this->db->get();

  		 if($query->num_rows()) {
        	return $query->result_array();
        } else {
        	return false;
        }
 	}


 	public function getCessBySaleIds($saleId) {
	 	global $uInfo;
	  	$comp_code = $uInfo['comp_code'];
	  	$where = '';

  		$this->db->select('a.master_product_id, b.product_tax');
  		$this->db->from('sale_items as a');

  		$this->db->join('product as b','a.master_product_id = b.product_id');
  		$this->db->where_in('a.sale_ID',$saleId);

  		$query = $this->db->get();

        if($query->num_rows()){
        	return $query->result();
        }else{
        	return false;
        }
	}


	public function bankReportByDate($from,$to,$type)
	{
 		$this->db->select('*');
		$this->db->where('created_date BETWEEN "'. date('Y-m-d', strtotime($from)). '" and "'. date('Y-m-d', strtotime($to)).'"');
		if($type == 1) {
			$this->db->where('dealer_vender_other',1);
		} 
		if($type == 2) {
			$this->db->where('dealer_vender_other',2);
		} 
		
		$this->db->from('bank_acount');
		$query = $this->db->get();
		return $query->result();
	}
 
}