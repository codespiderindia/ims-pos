<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Managereports_model extends CI_Model {

	function __construct(){
	
		parent::__construct();
		$this->load->library('email');
        global $uInfo;
        $uInfo=$this->session->userdata('sales_session_info');
	}

 	

  
 

	function getRows($params = array()){


        $this->db->select('*,count(sale_ID) as no_of_sale,DATE(date_time_created) as sale_date, SUM(sub_total) as sub_total, SUM(total) as total');
        $this->db->from('sale');

       
  		$this->db->where('employee_ID',$params['search']['employee_ID']);
  		$this->db->where('company_ID',$params['search']['company_ID']);
  		$this->db->where('store_ID',$params['search']['store_ID']);
        
        $this->db->where('DATE(date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');

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

    // Function to fetch sales
    function getSales($params = array()){


        $this->db->select('sl.*, um.user_full_name as sold_by, sitm.itm_cnt as itm_cnt');
        $this->db->from('sale as sl');
        $this->db->join('user_master as um','um.user_ID=sl.employee_ID','left');
       
       //select count(`sale_item_ID`), sale_ID from sale_items GROUP BY sale_ID
        $this->db->join('(select count(`sale_item_ID`) as itm_cnt, sale_ID from sale_items GROUP BY sale_ID) as sitm','sitm.sale_ID=sl.sale_ID','left');
    
        $this->db->where('sl.employee_ID',$params['search']['employee_ID']);
        $this->db->where('sl.company_ID',$params['search']['company_ID']);
        $this->db->where('sl.store_ID',$params['search']['store_ID']);
        
        $this->db->where('DATE(sl.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');

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

    /**
    *Get Best Selling Products
    *Start
    **/
 
    function getBestSellingProducts($params = array()){

     
        /* SQL 1 */
        /*
            SELECT `product_ID`, COUNT(`product_ID`) as tot_sale FROM `sale_items` WHERE `sale_ID` IN (SELECT sale_ID FROM `sale` WHERE `date_time_created` BETWEEN '2017-07-30 00:00:00.000000' AND '2017-08-05 00:00:00.000000' ORDER BY `sale_ID` DESC ) GROUP BY `product_ID` 
        */

        /* SQL 2 */

        /*
            select s.sale_ID,si.product_ID, COUNT(si.product_ID) as prdCnt from sale as s, sale_items as si where s.sale_ID=si.sale_ID AND s.`date_time_created` BETWEEN '2017-07-30 00:00:00.000000' AND '2017-08-05 00:00:00.000000' GROUP BY si.product_ID ORDER BY si.`product_ID` DESC
        */    
        $this->db->select("S.sale_ID,SI.product_ID, COUNT(SI.product_ID) as prdCnt, SUM(SI.quantity) as totQty,P.product_name,SUM(SI.item_subtotal) as itmTotal, SI.item_cost_price");
        $this->db->from("sale as S");
        $this->db->join('sale_items as SI','S.sale_ID = SI.sale_ID','INNER'); 
        $this->db->join('product as P','SI.product_ID=P.product_id','left');

        $this->db->where('S.employee_ID',$params['search']['employee_ID']);
        $this->db->where('S.company_ID',$params['search']['company_ID']);
        $this->db->where('S.store_ID',$params['search']['store_ID']);
        $this->db->where('S.sale_type',0);
        
        $this->db->where('DATE(S.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
 
        //sort data by ascending or desceding order
       /* if(!empty($params['search']['sortBy'])){
            $this->db->order_by('sale_ID',$params['search']['sortBy']);
        }else{
            $this->db->order_by('sale_ID','desc');
        }*/

        //Sell date between clause
        
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
        
        $this->db->group_by('SI.product_ID');
        
        $query = $this->db->get();
       
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
    /**
    *End
    **/

    /**
    *Export Best Selling Products
    *Start
    **/
 
    function exportBestSellingProducts($params = array()){
   
       $this->db->select("P.product_name as ItemName,SUM(SI.quantity) as Quantity,SI.item_cost_price as MRP,SUM(SI.item_subtotal) as Amount");

        $this->db->from("sale as S");
        $this->db->join('sale_items as SI','S.sale_ID = SI.sale_ID','INNER'); 
        $this->db->join('product as P','SI.product_ID=P.product_id','left');

        $this->db->where('S.employee_ID',$params['search']['employee_ID']);
        $this->db->where('S.company_ID',$params['search']['company_ID']);
        $this->db->where('S.store_ID',$params['search']['store_ID']);
        $this->db->where('S.sale_type',0);
        
        $this->db->where('DATE(S.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');
 
        //sort data by ascending or desceding order
       /* if(!empty($params['search']['sortBy'])){
            $this->db->order_by('sale_ID',$params['search']['sortBy']);
        }else{
            $this->db->order_by('sale_ID','desc');
        }*/

        //Sell date between clause
        
        /*if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }*/
        
        $this->db->group_by('SI.product_ID');
        
        $query = $this->db->get();
       
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
    /**
    *End
    **/



    /***
    /**Get sales for export function
    /**Start
    ***/
    function getSalesToExport($params = array()){


        $this->db->select('sl.date_time_created as Sale_Date, um.user_full_name as sold_by, sitm.itm_cnt as itm_cnt, sl.sub_total Subtotal, sl.total as Total, sl.remark as Comment');
        $this->db->from('sale as sl');
        $this->db->join('user_master as um','um.user_ID=sl.employee_ID','left');
       
       //select count(`sale_item_ID`), sale_ID from sale_items GROUP BY sale_ID
        $this->db->join('(select count(`sale_item_ID`) as itm_cnt, sale_ID from sale_items GROUP BY sale_ID) as sitm','sitm.sale_ID=sl.sale_ID','left');
    
        $this->db->where('sl.employee_ID',$params['search']['employee_ID']);
        $this->db->where('sl.company_ID',$params['search']['company_ID']);
        $this->db->where('sl.store_ID',$params['search']['store_ID']);
        
        $this->db->where('DATE(sl.date_time_created) BETWEEN "'. date('Y-m-d', strtotime($params['search']['startDate'])). '" and "'. date('Y-m-d', strtotime($params['search']['endDate'])).'"');

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
    /***
    /**Get sales for export function
    /**End
    ***/

    /***
    /**Get Payments for Sale
    /**Start
    ***/
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
    /***
    /**Get Payments for Sale
    /**End
    ***/

    function getCatsAll($comp_code){
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where(array('cat_parent_id' => 0,'comp_code'=>$comp_code));  
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;

    }

    function getSubCatsByCatID($catID){
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where(array('cat_parent_id' => $catID));  
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;


    }

    function getSubCatsBySubCatID($catID){
        $this->db->select('*');
        $this->db->from('product_category');
        $this->db->where(array('cat_parent_id' => $catID));  
        $query = $this->db->get();
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;


    }

    function getProductsByCatID($compCode){
        $main_cat = $this->input->post('catID');
        $sub_cat = $this->input->post('subcat1');
        $sub_sub_cat = $this->input->post('subcat2');
   
        if(!empty($main_cat)){
        $this->db->where(array('product_category'=>$main_cat));
        }

        if(!empty($sub_cat)){
        $this->db->where(array('product_sub_category'=>$sub_cat));
        }
        
        if(!empty($sub_sub_cat)){
        $this->db->where(array('product_sub_of_sub_category'=>$sub_sub_cat));
        }
        
       //$this->db->where( "product_price BETWEEN $start_price AND $end_price", NULL, FALSE );
        $this->db->where(array('comp_code'=>$compCode));
        $this->db->from('product');
        $query = $this->db->get();
        //echo  $this->db->last_query();die;
        if($query->num_rows() > 0)
            return $query->result_array();
        else
            return FALSE;

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

    function getProductStock($params = array()){

        /*Working Query*/
        /*
        SELECT * FROM `product` as p left join store_inventory as si on p.product_id=si.product_id and si.store_id=20 WHERE p.`comp_code`=3 
        */
        

        //IF(a.addressid IS NULL,0,1)

        $this->db->select('P.product_name prdName, IF(SI.stock_qty,(SI.stock_qty),(0) ) as prdQty, P.product_price prdPrice ');
        $this->db->from('product as P');
        $this->db->join('store_inventory as SI','P.product_id=SI.product_id AND SI.store_id='.$params['search']['storeID'],'left');
       
        $this->db->where('P.comp_code',$params['search']['compID']);
        
        if(isset($params['search']['itemID']) && !empty($params['search']['itemID'])){
            $this->db->where('P.product_id',$params['search']['itemID']);
        }
       

        //sort data by ascending or desceding order
       /* if(!empty($params['search']['sortBy'])){
            $this->db->order_by('sale_ID',$params['search']['sortBy']);
        }else{
            $this->db->order_by('sale_ID','desc');
        }*/
        
        

        //set start and limit
        if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit'],$params['start']);
        }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
            $this->db->limit($params['limit']);
        }
       //get records
       // $this->db->group_by('DATE(date_time_created)');
        
        $query = $this->db->get();
       
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
    

    
function dailySaleReport($date,$storeId) {
    global $uInfo;
    $userId=$uInfo['user_ID'];

    if($date=='') {
        $getDate=date('Y-m-d');
    } else {
        $getDate=$date;
    }

    $this->db->select('*');
    $this->db->from('sale as a');
    $this->db->join('sale_payments as b','b.sale_ID = a.sale_ID');
    $this->db->where("DATE( a.date_time_created ) LIKE '%".$getDate."%'");
    $this->db->where('a.employee_ID',$userId);
    if($storeId!='') {
        $this->db->where('a.store_ID',$storeId);
    }
    $query = $this->db->get();
    return $query->result_array();

   /* $this->db->select('*')->from('sale')
   ->where("DATE( date_time_created ) LIKE '%".$getDate."%'")->get();*/

    //echo  $this->db->last_query();exit;
       
    }
  	
}
