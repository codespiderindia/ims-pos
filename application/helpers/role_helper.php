<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


///source
//https://github.com/EllisLab/CodeIgniter/wiki/helper-dropdown-country-code

if( ! function_exists('role_name')){
	//selected country would be retrieved from a database or as post data
function role_name($role_id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM role where role_code=".$role_id; 
	$query = $ci->db->query($sql);
	

	if($query->num_rows()>0){
			$row = $query->row();
			return $row->role_name;	
		}else{
			return 'Undefined';
		}
	}
}

if( ! function_exists('checkPermitionByUserRole')){

	//selected country would be retrieved from a database or as post data
function  checkPermissionByUserRole($role_id,$module_code){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM role_rights where rolecode = '$role_id' and modulecode='$module_code'"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
    return $row;
	
	}
}

if(!function_exists('updateGstLog')) {
function  updateGstLog($product_id,$comp_code,$gst_rate,$user_id='') {
$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM gst_rate where comp_code = '$comp_code' AND product_id = '$product_id'"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
	if($row[0]['rate']!=$gst_rate) {
	
	$gst_data = array(
			'product_id' =>$product_id,
			'comp_code' =>$comp_code,
			'rate'     => $gst_rate,
			'updated'     =>  date('Y-m-d'),
			'updated_by'     =>  $user_id
			
			);
			$ci->db->insert('gst_rate',$gst_data);
			
	} 
}
}
if( ! function_exists('role_id')){
	//selected country would be retrieved from a database or as post data
function  role_id($comp_code){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM role where comp_code = '$comp_code'"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
	//print_r($row);die();
	return $row;
	}
}

if( ! function_exists('get_dealer_existing_balance')){
	//selected country would be retrieved from a database or as post data
function  get_dealer_existing_balance($dealer_id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT total_amount FROM `dealer_account` WHERE id=(SELECT MAX(id) FROM `dealer_account`) AND dealer_user_id = '$dealer_id'"; 
	$query = $ci->db->query($sql);
	if($query->num_rows()>0){ 
	$row = $query->result_array();
	return $row[0]['total_amount'];
	} else {
	return 0;
	}
	}
}

if( ! function_exists('get_bank_existing_balance')){
	//selected country would be retrieved from a database or as post data
function  get_bank_existing_balance($comp_code){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT total_balance FROM `bank_acount` WHERE id=(SELECT MAX(id) FROM `bank_acount`) AND comp_code = '$comp_code'"; 
	$query = $ci->db->query($sql);
	if($query->num_rows()>0){ 
	$row = $query->result_array();
	return $row[0]['total_balance'];
	} else {
	return 0;
	}
	}
}


if( ! function_exists('get_cash_book_existing_balance')){
	//selected country would be retrieved from a database or as post data
function  get_cash_book_existing_balance($comp_code){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT total_balance FROM `cash_book` WHERE id=(SELECT MAX(id) FROM `cash_book`) AND comp_code='$comp_code'"; 
	$query = $ci->db->query($sql);
	if($query->num_rows()>0){ 
	$row = $query->result_array();
	return $row[0]['total_balance'];
	} else {
	return 0;
	}
	}
}


if( ! function_exists('get_vendore_existing_balance')){
	//selected country would be retrieved from a database or as post data
function  get_vendore_existing_balance($vendor_id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	 $sql = "SELECT total_amount FROM `vendor_account` WHERE id=(SELECT MAX(id) FROM `vendor_account`) AND vendor_user_id = '$vendor_id'"; 

	$query = $ci->db->query($sql);
	if($query->num_rows()>0){ 
	$row = $query->result_array();
	
	return $row[0]['total_amount'];
	} else {
	return 0;
	}
	}
}


if( ! function_exists('get_user_role')){
	//selected country would be retrieved from a database or as post data
function  get_user_role($role_id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM role where role_code=".$role_id; 
	$query = $ci->db->query($sql);
	$row = $query->row();
	//print_r($row);die();
	return $row->role_name;
	}
}

if( ! function_exists('module_name')){
function  module_name(){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM module ORDER BY mod_moduleid ASC"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
	//print_r($row);die();
	return $row;
	}
}

if( ! function_exists('get_modulename')){
function get_modulename($module_id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT mod_modulecode FROM module where mod_moduleid=".$module_id;
	$query = $ci->db->query($sql);
	$row = $query->row();
	//print_r($row);die();
	return $row->mod_modulecode;
	}
}

if( ! function_exists('user_level')){
	function user_level(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM user_level"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}


if( ! function_exists('get_user_level_name')){ 
	function get_user_level_name($user_level_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM user_level where user_level_id=".$user_level_id; 	
	$query = $ci->db->query($sql);	
	$row = $query->row();	
	//print_r($row);die();	
	return $row->level_name;	
	}
}


if( ! function_exists('location')){ 
	function location($comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM locations where comp_code='$comp_code' AND location_status=1"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}


if( ! function_exists('get_locations')){ 
	function get_locations(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM locations"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}

if( ! function_exists('get_cities')){ 
	function get_cities(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM cities"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}

if( ! function_exists('get_states')){ 
	function get_states(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM states"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}

if( ! function_exists('get_state_by_cont_id')){ 
	function get_state_by_cont_id($count_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM states where country_id='$count_id'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}



if( ! function_exists('get_countries')){ 
	function get_countries(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM countries"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();	
	//print_r($row);die();	
	return $row;	
	}
}

if( ! function_exists('get_location_by_id')){ 
	function get_location_by_id($location_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM locations where id=".$location_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->row();
		return $row->location_name;	
	}else{
		return 'Undefined';
	}
	}
}

if( ! function_exists('get_city_by_id')){ 
	function get_city_by_id($city_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM cities where id=".$city_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->row();
		return $row->name;	
	}else{
		return 'Undefined';
	}
	
	}
}


if( ! function_exists('get_country_by_id')){ 
	function get_country_by_id($c_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM countries where id=".$c_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->row();
		return $row->name;	
	}else{
		return 'Undefined';
	}
	
	}
}


if( !function_exists('get_cities_by_state_id')){ 
	function get_cities_by_state_id($state_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM cities where state_id=".$state_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row;	
	}else{
		return false;
	}
	}
}

if( !function_exists('get_location_by_city_id')){ 
	function get_location_by_city_id($city_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM locations where city_id=".$city_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row;	
	}else{
		return false;
	}
	}
}

if( !function_exists('discounted_price_by_dealer_product_id')){ 
	function discounted_price_by_dealer_product_id($dealer_id,$product_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM dealer_product_price where dealer_id=".$dealer_id." AND product_id='".$product_id."'"; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row[0]['price'];	
	}else{
		return false;
	}
	}
}


if( !function_exists('getVariations')){ 
	function getVariations($sku,$product_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM product_variations_relations where sku='".$sku."' AND product_id='".$product_id."'"; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->row();
		return $row->variation_price;	
	}else{
		return false;
	}
	}
}



if( ! function_exists('get_stores_by_city_id')){ 
	function get_stores_by_city_id($city_id,$comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where comp_code = '$comp_code' and store_city_id=".$city_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row;	
	}else{
		return false;
	}
	}
}

if( ! function_exists('get_stores_by_location_id')){ 
	function get_stores_by_location_id($location_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where store_location_id=".$location_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->result_array();
		return $row;	
	}else{
		return false;
	}
	}
}


if( ! function_exists('get_state_by_id')){ 
	function get_state_by_id($state_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM states where id=".$state_id; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows()>0){
		$row = $query->row();
		return $row->name;	
	}else{
		return 'Undefined';
	}
	}
}

if( !function_exists('get_user_name_by_user_ID')){ 
	function get_user_name_by_user_ID($user_ID){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT user_full_name FROM user_master where user_ID=".$user_ID; 	
	$query = $ci->db->query($sql);	
	

if($query->num_rows()>0){
		$row = $query->row();
		return $row->user_full_name;	
	}else{
		return 'Undefined';
	}

	
	}
}

if( !function_exists('get_dealer_name_by_ID')){ 
	function get_dealer_name_by_ID($id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT f_name, l_name FROM dealer where dealer_id=".$id; 	
	$query = $ci->db->query($sql);	
	

if($query->num_rows()>0){
		$row = $query->row();
		return $row->f_name." ".$row->l_name;	
	}else{
		return 'Undefined';
	}

	
	}
}


if( !function_exists('get_product_name_by_ID')){ 
	function get_product_name_by_ID($id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT product_name FROM product where product_id=".$id; 	
	$query = $ci->db->query($sql);	
	

	if($query->num_rows()>0){
		$row = $query->row();
		return $row->product_name;	
	}else{
		return 'Undefined';
	}
	
	}
}

if( ! function_exists('department_details')){ 
	function department_details($comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM department where comp_code='$comp_code' AND department_status=1"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('get_department_details_by_id')){ 
	function get_department_details_by_id($department_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	
	$sql = "SELECT * FROM department where '$department_id' IN(department_id)"; 	
	$query = $ci->db->query($sql);	
	if($query->num_rows() > 0){
   $row = $query->result_array();
  return $row;
  }else{
   return false;
  }
	
	}
}

if( ! function_exists('store_details')){ 
	function store_details($comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where comp_code='$comp_code' AND store_status=1"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}



if( ! function_exists('warehouse_details_by_id')){ 
	function warehouse_details_by_id($warehouse_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM warehouse where warehouse_id= '$warehouse_id'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('store_details_by_id')){ 
	function store_details_by_id($store_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where store_id= '$store_id'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('getStores')){ 
	function getStores($user_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where user_ID = '$user_id'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


if( ! function_exists('getWarehouses')){ 
	function getWarehouses($user_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM warehouse where user_ID = '$user_id'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('getWarehousesOfCompCode')){ 
	function getWarehousesOfCompCode($comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM warehouse where comp_code = '$comp_code'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


if( ! function_exists('get_store_details_by_id')){ 
	function get_store_details_by_id($store_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM store where store_id=".$store_id; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('get_attributes')){ 
	function get_attributes(){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM attributes"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


if( ! function_exists('get_attribute_values')){ 
	function get_attribute_values($attribute_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM attribute_value where attribute_id=".$attribute_id; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('get_attribute_by_productID')){ 
	function get_attribute_by_productID($product_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT attribute_id,attribute_value FROM product_attribute where product_id=".$product_id; 
	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();


	$count =  count($row);
	$attrArray = array();
	if($count>0) {
		for($i=0;$i<$count;$i++)
		{ 
			$sql1 = "SELECT attribute_id,attribute_name FROM attributes where attribute_id=".$row[$i]['attribute_id']; 	 	
			$query1 = $ci->db->query($sql1);	
			$row1 = $query1->row();

			$explodeArry = explode(',',$row[$i]['attribute_value']);
			
		
			$attrVal='';
			foreach($explodeArry as $explodeArrys) {
				if(is_numeric($explodeArrys)) {
					$sql2 = "SELECT attribute_value FROM attribute_value where attribute_value_id=".$explodeArrys; 
					$query = $ci->db->query($sql2);	
					$row2 = $query->result_array();
					if(!empty($row2)) {
						$attrVal .= $row2[0]['attribute_value'].',';
					} else {
						$attrVal .= $explodeArrys;
					}
				} else {
					$attrVal .= $explodeArrys.',';
				}
			}
			if(!empty($row1)) {
				$attrArray[] = "<p style='color:red' class='product_attribute_name' attrId='".$row1->attribute_id."'>".$row1->attribute_name."=></p>".rtrim($attrVal, ',')."<br>";
			}
		}
		return $attrArray;	
	} else {
		return false;
	}
	
	}
}



//for theme color setting
if( ! function_exists('userSelectThemeColor')){ 
function userSelectThemeColor($user_ID, $user_level){
  $ci =& get_instance();	
  $ci->load->database();	
  $whereArr = array('user_ID' => $user_ID, 'user_level' => $user_level); // AND Operator 
  $ci->db->select('*');
  $ci->db->from('themes_setting');
  $ci->db->where($whereArr);   
  $query = $ci->db->get();
  if($query->num_rows() > 0){
   return $query->row();
  }else{
   return false;
  }
 }
}

//for get product category where parent cat id =0
if( ! function_exists('getProductCategoryParentNull')){ 
function getProductCategoryParentNull($comp_code){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('product_category');
  $ci->db->where(array('cat_parent_id' => 0,'comp_code'=>$comp_code));  
  $query = $ci->db->get();
  return $query->result_array();
 }
}


//for get product category
if( ! function_exists('getProductCategory')){ 
function getProductCategory($comp_code){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where('comp_code',$comp_code);
  $ci->db->from('product_category');
  //$ci->db->where(array('cat_parent_id' => 0));  
  $query = $ci->db->get();
  return $query->result_array();
 }
}

//for get product sub category
if( ! function_exists('getSubCategory')){ 
function getSubCategory($cat_parent_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('product_category');
  $ci->db->where(array('cat_parent_id' => $cat_parent_id));  
  $query = $ci->db->get();
  return $query->result_array();
 }
}

//for get Parent category
if( ! function_exists('getParentCategory')){ 
function getParentCategory($product_cat_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('product_category');
  $ci->db->where(array('product_cat_id' => $product_cat_id));      
  $query = $ci->db->get();
  $row = $query->row();
  if($row){
   return $row; 
  }else{
   return false;
  }
 }
}

//for get product subcategory
if( ! function_exists('getSubofSubCategory')){ 
function getSubofSubCategory($cat_parent_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('product_category');
  $ci->db->where(array('cat_parent_id' => $cat_parent_id));  
  $query = $ci->db->get();
  return $query->result_array();
 }
}


//for get product in warehouse Inventory
if( ! function_exists('product_in_warehouse')){ 
function product_in_warehouse($warehouse_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('warehouse_id' => $warehouse_id));
  $ci->db->from('warehouse_inventory');
  $ci->db->group_by('master_product_id'); 
  $query = $ci->db->get();
  return $query->result_array();
 }
}


//for get all product in warehouse
if( ! function_exists('all_product_in_warehouse')){ 
function all_product_in_warehouse(){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('warehouse_inventory');
  $query = $ci->db->get();
  return $query->result_array();
 }
}

//for get product name
if( ! function_exists('product_name')){ 
function product_name($product_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('product_name');
  $ci->db->from('product');
  $ci->db->where(array('product_id' => $product_id));  
  $query = $ci->db->get();
  $row = $query->row();
  return $row->product_name;
 }
}

//for get warehouses
if( ! function_exists('warehouse_details')){ 
	function warehouse_details($comp_code){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM warehouse where comp_code='$comp_code'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

//for get all taxes
if( ! function_exists('tax_details')){
	//selected country would be retrieved from a database or as post data
function  tax_details($id){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM tax where comp_code='$id' AND tax_status=1"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
	//print_r($row);die();
	return $row;
	}
}

if( ! function_exists('vendor_details')){
	function vendor_details($comp_code){
		$ci =& get_instance();
		$ci->load->database();
		$sql = "SELECT vendor_id, f_name, l_name FROM vendor where comp_code='$comp_code'";
		$query = $ci->db->query($sql);	
		$row = $query->result_array();
		return $row;	
	}
}

//for get vendor name
if( ! function_exists('vendor_name')){ 
	function vendor_name($vendor_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('f_name, l_name');
		$ci->db->from('vendor');
		$ci->db->where(array('vendor_id' => $vendor_id));  
		$query = $ci->db->get();
		$row = $query->row();
		return $row;
		
		//$row = $query->result_array();
		//return $row;	
	}
}

//for get product name
if( ! function_exists('productIdName')){ 
	function productIdName($comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('product_id, product_name');
		$ci->db->where(array('comp_code'=>$comp_code));
		$ci->db->from('product');
		$query = $ci->db->get();
		$result = $query->result();
		return $result;
	}
}

if( ! function_exists('getWarehouseIsCentral')){ 
	function getWarehouseIsCentral($comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('warehouse_id');
		$ci->db->where(array('comp_code'=>$comp_code));
		$ci->db->from('warehouse');
		$ci->db->where(array('is_central' => '1'));  
		$query = $ci->db->get();
		 $row = $query->row();
		
		return $row;
	}
}

if( ! function_exists('getStockByProductAndWarehouseId')){ 
	function getStockByProductAndWarehouseId($product_id, $warehouse_is_central_id, $batch_id=0, $comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('stock_qty');
		$ci->db->from('warehouse_inventory');
		$ci->db->where(array('product_id' => $product_id, 'warehouse_id' => $warehouse_is_central_id, 'comp_code' => $comp_code, 'batch_id'=>0));  
		$query = $ci->db->get();
		$row = $query->row();
		return $row;
	}
}

//get warehouse name
if( ! function_exists('getWarehouseName')){ 
	function getWarehouseName($warehouse_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$ci->db->select('*');
	$ci->db->from('warehouse');
	$ci->db->where(array('warehouse_id' => $warehouse_id));  	
	$query = $ci->db->get();	
	$row = $query->row();
	return $row->warehouse_name;	
	}
}

//for get product in Store Inventory
if( ! function_exists('product_in_store_inventory')){ 
function product_in_store_inventory($store_id,$comp_code=false){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('store_id' => $store_id, 'comp_code' => $comp_code, 'master_product_id !=' => 0, 'batch_id' => 0));
  $ci->db->from('store_inventory');
  $ci->db->group_by('master_product_id');
  $query = $ci->db->get();
  return $query->result_array();
 }
}

if( ! function_exists('getWarehouseIdByWarehouseName')){ 
	function getWarehouseIdByWarehouseName($warehouse_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('warehouse_name');
		$ci->db->from('warehouse');
		$ci->db->where(array('warehouse_id' => $warehouse_id));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
}

if( !function_exists('offerDetails')){
	function offerDetails(){
		$ci =& get_instance();
		$ci->load->database();
		
		$ci->db->select('*');
		$ci->db->from('offer');
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
}



/* Get Offer Of Company Code */
if( !function_exists('getofferByCompCode')){
	function getofferByCompCode($compCode){
		$ci =& get_instance();
		$ci->load->database();

		$ci->db->select('*');
		$ci->db->from('offer');
		$ci->db->where(array('comp_code' => $compCode));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
}



if( ! function_exists('getOfferIdByOffer')){ 
	function getOfferIdByOffer($offer_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('offer');
		$ci->db->where(array('offer_id' => $offer_id));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
}

if( ! function_exists('taxNameByProductTax')){
	function taxNameByProductTax($product_id){
		$ci =& get_instance();
		$ci->load->database();
		
		/*$sql = "SELECT GROUP_CONCAT(tax.tax_name) AS productTaxName
				FROM product,tax
				WHERE FIND_IN_SET(tax.tax_id , product.product_tax) 
				AND product.product_id=".$product_id."
				GROUP BY product.product_tax";
		$query = $ci->db->query($sql);*/
		
		$ci->db->select('GROUP_CONCAT(tax.tax_name) AS productTaxName');
		$ci->db->from(array('product','tax'));
		$ci->db->where('FIND_IN_SET(tax.tax_id , product.product_tax)');
		$ci->db->where('product.product_id', $product_id);
		$ci->db->group_by('product.product_tax');
		$query = $ci->db->get();
		 
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
}

//get vendor bank details by vendor id
if( ! function_exists('getBankDetailsById')){ 
	function getBankDetailsById($vendor_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('vendor_bank_details');
		$ci->db->where(array('vendor_id' => $vendor_id));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}


if( ! function_exists('getVendorToWarehouseTransfer')){ 
	function getVendorToWarehouseTransfer($invoice_id,$product_id,$batchId){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('vendor_to_wh_product');
		$ci->db->where(array('product_id' => $product_id, 'invoice_id' => $invoice_id, 'master_product_id !=' => 0, 'batch_id' => 0));  
		$query = $ci->db->get();
		$row = $query->row();
		return $row;
	}
}

//Get Challan Details
if( ! function_exists('getChallanDetails')){ 
	function getChallanDetails($invoice_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('challan_number,challan_date');
		$ci->db->from('vendor_to_wh_invoice_challan_detail');
		$ci->db->where(array('invoice_id' => $invoice_id));
		$ci->db->order_by("id", "asc");		
		$query = $ci->db->get();
		$row = $query->result();
		return $row;
	}
}

//Get vendor Invoice Details
if( ! function_exists('invoice_details')){ 
	function invoice_details($compCode){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('invoice_number');
		$ci->db->where(array('comp_code'=>$compCode));
		$ci->db->from('vendor_to_wh_invoice');
		$query = $ci->db->get();
		$row = $query->result();
		return $row;
	}
}


//for get product Has Vendor Inventory
if( ! function_exists('product_has_vendor')){ 
function product_has_vendor($invoice_number){
  $ci =& get_instance();	
  $ci->load->database();
  $ci->db->select('*');
  $ci->db->from('vendor_to_wh_invoice');
  $ci->db->join('vendor_to_wh_product', 'vendor_to_wh_invoice.invoice_id = vendor_to_wh_product.invoice_id');
  $ci->db->where(array('vendor_to_wh_invoice.invoice_number' => $invoice_number, 'vendor_to_wh_product.master_product_id !=' => 0));
  $query = $ci->db->get();
  return $query->result_array();
	
 }
}


//for get vendor by invoice number

if( ! function_exists('get_vendor_by_invoice_number')){ 
function get_vendor_by_invoice_number($invoice_number){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('invoice_number' => $invoice_number));
  $ci->db->from('vendor_to_wh_invoice');
  $query = $ci->db->get();
  return $query->result_array();
 }
} 


//for get Return Invoices Count

if( ! function_exists('getReturnInvoicesCount')){ 
function getReturnInvoicesCount($invoice_number){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('invoice_number' => $invoice_number));
  $ci->db->from('return_policy');
  $query = $ci->db->get();
  if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
 }
} 


//get Dealer bank details by dealer id
if( ! function_exists('getDealerBankDetailsById')){ 
	function getDealerBankDetailsById($dealer_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('dealer_bank_details');
		$ci->db->where(array('dealer_id' => $dealer_id));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->result_array();
		}else{
			return false;
		}
	}
}

//get customer details by customer id
if( ! function_exists('getCustomerDetailsById')){ 
	function getCustomerDetailsById($customer_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('customers');
		$ci->db->where(array('customer_id' => $customer_id));  
		$query = $ci->db->get();
		if($query->num_rows()>0){
			return $query->row();
		}else{
			return false;
		}
	}
}

//for get Dealer name
if( ! function_exists('dealer_id')){ 
function dealer_name($dealer_id){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('dealer');
  $ci->db->where(array('dealer_id' => $dealer_id));  
  $query = $ci->db->get();
  return $query->result();
 }
}

//for get orders by order Id
if( ! function_exists('getOrderByOrderId')){ 
	function getOrderByOrderId($order_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('order_detail');
		$ci->db->where(array('order_id' => $order_id)); 
		$query = $ci->db->get();
		$result = $query->result();
		return $result;
	}
}

//get_cust_notes
if( ! function_exists('get_cust_notes')){ 
	function get_cust_notes($order_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('orders');
		$ci->db->where(array('order_id' => $order_id)); 
		$query = $ci->db->get();
		$result = $query->result();
		return $result[0]->cust_ship_address_notes;
	}
}

//get_cust_notes
if( ! function_exists('get_shipping_notes')){ 
	function get_shipping_notes($order_id){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('shipping_address');
		$ci->db->where(array('order_id' => $order_id)); 
		$query = $ci->db->get();
		$result = $query->result();
		return $result;
		//return $result[0]->cust_ship_address_notes;
	}
}


//Get Company Detail
if( ! function_exists('getCompanyDetail')){ 
	function getCompanyDetail($companyId, $select){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select($select);
		$ci->db->from('companies');
		$ci->db->where(array('comp_id' => $companyId)); 
		$query = $ci->db->get();
		$result = $query->result();
		return $result;
	}
}

/* 01/12/2017 */
//Get Product Detail
if( ! function_exists('getProductDetail')){ 
	function getProductDetail($productId, $select){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select($select);
		$ci->db->from('product');
		$ci->db->where(array('product_id' => $productId)); 
		$query = $ci->db->get();
		$result = $query->row();
		return $result;
	}
}

/* 02/12/2017 */
//Get Attribute By Comp Code
if( ! function_exists('getAttributesByCompCode')){ 
	function getAttributesByCompCode($id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM attributes where comp_code=".$id; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('getAllWarehouseIsCentral')){ 
	function getAllWarehouseIsCentral($comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->where(array('comp_code'=>$comp_code));
		$ci->db->from('warehouse');
		$ci->db->where(array('is_central' => '1'));  
		$query = $ci->db->get();
		 $row = $query->result_array();
		
		return $row;
	}
}

if( ! function_exists('getAllWarehouseIsNotCentral')){ 
	function getAllWarehouseIsNotCentral($comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->where(array('comp_code'=>$comp_code));
		$ci->db->from('warehouse');
		$ci->db->where(array('is_central' => '0'));  
		$query = $ci->db->get();
		 $row = $query->result_array();
		
		return $row;
	}
}


if( ! function_exists('getRoleInfoById')){ 
	function getRoleInfoById($id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM role where role_code=".$id; 	
	$query = $ci->db->query($sql);	
	$row = $query->row();
	return $row;	
	}
}

if( ! function_exists('checkHrRoleOfUser')) {
	function checkHrRoleOfUser($userRole,$compCode) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('role');
		$ci->db->where(['role_code'=>$userRole, 'hr_approval_for_special_role'=>1]);
		$query = $ci->db->get();
		$row = $query->result_array();
		return $row;
	}
}

if( ! function_exists('checkPermissionOfSaleRole')){

	//selected country would be retrieved from a database or as post data
function  checkPermissionOfSaleRole($module_code){
	// You may want to pull this from an array within the helper
	$ci =& get_instance();
	$ci->load->database();
	$sql = "SELECT * FROM role_rights where modulecode='$module_code'"; 
	$query = $ci->db->query($sql);
	$row = $query->result_array();
    return $row;
	
	}
}

if( ! function_exists('getAttributIdValues')){ 
	function getAttributIdValues($attribute_value){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM attribute_value where attribute_value='".$attribute_value."'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

if( ! function_exists('getAttributIdVariationId')){ 
	function getAttributIdVariationId($attribute_value_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM attribute_value where attribute_value_id='".$attribute_value_id."'"; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}

/*if( !function_exists('get_user_name_by_role_ID')){ 
	function get_user_name_by_role_ID($rolecode){	// You may want to pull this from an array within the helper
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT * FROM user_master where user_role IN "$rolecode; 	
	echo $ci->db->last_query();
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
    return $row;
	}
}*/


if( ! function_exists('getProductVariation')){ 
	function getProductVariation($product_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT id,relation_common_id,variation_price,sku,GROUP_CONCAT(variation_id) as variation_ids,GROUP_CONCAT(attribute_id) as attribute_ids FROM product_variations_relations where product_id='".$product_id."' AND flag=1 GROUP BY sku ORDER BY id asc"; 
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


//for get  product attributes name using multiple Attribute_value_id
if( ! function_exists('getAllVariationNames')){ 
function getAllVariationNames($ids){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from('attribute_value');
  $ci->db->where_in('attribute_value_id',$ids);  
  $query = $ci->db->get();
  return $query->result_array();
 }
}

//for get  product attributes name using multiple Attribute_value_id
if( ! function_exists('getVariationPriceBySku')){ 
function getVariationPriceBySku($sku,$productId,$productPrice){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('variation_price');
  $ci->db->from('product_variations_relations');
  $ci->db->where(array('sku'=> $sku,'product_id'=> $productId));  
  $query = $ci->db->get();
  $res =$query->row();
  if(!empty($res->variation_price) && isset($res->variation_price))
  {
	return $res->variation_price;
  }
  else{
  	return $productPrice;
  }
 }
}

//Get Sku By Master_product_id && Comon function for All table 
if( ! function_exists('getSku')){ 
function getSku($table,$where){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->from($table);
  $ci->db->where($where);  
  $query = $ci->db->get();
  return $query->result_array();
 }
}


// Get Dat Using Group By
if( ! function_exists('getDataUsingGroupBy')){ 
	function getDataUsingGroupBy($table, $select, $where, $groupBy){
		$ci =& get_instance();	
		$ci->load->database();
		$ci->db->select($select);
		$ci->db->from($table);
		$ci->db->where($where); 
		$ci->db->group_by($groupBy); 
		$query = $ci->db->get();
		return $query->result_array();
	}
}


//for get product in warehouse Inventory
if( ! function_exists('allProductInWarehouse')){ 
function allProductInWarehouse($warehouse_id,$comp_code=false){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('warehouse_id' => $warehouse_id, 'comp_code'=>$comp_code, 'master_product_id'=>0));
  $ci->db->from('warehouse_inventory');
  //$ci->db->group_by('master_product_id'); 
 // $ci->db->join('warehouse_inventory as b','b.product_id = a.master_product_id');
  //$ci->db->group_by('master_product_id'); 
  $query = $ci->db->get();
  return $query->result_array();
 }
}



//for get product in warehouse Inventory By Batch
if( ! function_exists('allProductInWarehouseTransfer')){ 
function allProductInWarehouseTransfer($warehouse_id,$comp_code=false){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(array('warehouse_id' => $warehouse_id, 'comp_code'=>$comp_code, 'master_product_id != '=>0));
  $ci->db->from('warehouse_inventory');
  $ci->db->group_by('master_product_id'); 
 // $ci->db->join('warehouse_inventory as b','b.product_id = a.master_product_id');
  //$ci->db->group_by('master_product_id'); 
  $query = $ci->db->get();
  return $query->result_array();
 }
}



//for get product in warehouse Inventory(wharehouse to store)
if( ! function_exists('allProductInWarehouseToStore')){ 
	function allProductInWarehouseToStore($warehouse_id,$comp_code=false){
	  $ci =& get_instance();	
	  $ci->load->database();	
	  $ci->db->select('*');
	  $ci->db->where(array('a.warehouse_id' => $warehouse_id, 'b.flag' => 1, 'a.comp_code' => $comp_code, 'a.master_product_id !=' => 0));
	  $ci->db->from('warehouse_inventory as a');
	  //$ci->db->join('warehouse_inventory as b','b.product_id = a.master_product_id');
	  $ci->db->join('product_variations_relations as b','b.sku = a.product_id');
	  $ci->db->group_by('a.master_product_id'); 
	  $query = $ci->db->get();
	  //echo $ci->db->last_query();
	  return $query->result_array();
	 }
}


// Common function for update Specific Table of data
if( ! function_exists('updateData')){ 
	function updateData($table,$data,$where) {
		$ci =& get_instance();	
  		$ci->load->database();
  		$ci->db->where($where);
		$ci->db->update($table, $data); 
	}
}


// Get Sku Status
if( ! function_exists('getStatus')){ 
	function getStatus($table,$select,$where) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from($table);
		$ci->db->where($where);
		$query = $ci->db->get();
  		if($query->num_rows() > 0){
			return $query->row();
		}else{
		 	return false;
		}
	}
}


//For Get  product attributes name using multiple Attribute_value_id Group_by
if( ! function_exists('getAllVariationNamesOfGroup')){ 
function getAllVariationNamesOfGroup($ids){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('GROUP_CONCAT(attribute_value) as attribute_value');
  $ci->db->from('attribute_value');
  $ci->db->where_in('attribute_value_id',$ids);  
  $query = $ci->db->get();
  return $query->result_array();
 }
}

//Common Function for insert value
if( ! function_exists('commonInsert')) {
	function commonInsert($table,$data) {
		$ci =& get_instance();	
		$ci->load->database();
		$ci->db->insert($table,$data);
		return $ci->db->insert_id();
	}
}


//get product category by Loyalty Points
if( ! function_exists('getCategoryForLoyaltyPoint')){ 
function getCategoryForLoyaltyPoint($comp_code){
  $ci =& get_instance();	
  $ci->load->database();	
  $ci->db->select('*');
  $ci->db->where(['comp_code'=>$comp_code, 'cat_status'=>1, 'cat_parent_id'=>0]);
  $ci->db->from('product_category');
  //$ci->db->where(array('cat_parent_id' => 0));  
  $query = $ci->db->get();
  return $query->result_array();
 }
}



if( ! function_exists('getDealerBalance')){
	//selected country would be retrieved from a database or as post data
	function  getDealerBalance($comp_code,$dealerId){
	// You may want to pull this from an array within the helper
		$ci =& get_instance();
		$ci->load->database();
		$ci->db->select('dealer_credit_limits');
		$ci->db->where(['comp_code'=>$comp_code, 'dealer_id'=>$dealerId]);
		$ci->db->from('dealer');
		
		if($query->num_rows()>0){ 
			$row = $query->result_array();
			return $row[0]['dealer_credit_limits'];
		} else {
			return 0;
		}
	}
}



if( ! function_exists('getSelectedProductVariation')){ 
	function getSelectedProductVariation($sku){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT id,relation_common_id,sku,GROUP_CONCAT(variation_id) as variation_ids,GROUP_CONCAT(attribute_id) as attribute_ids FROM product_variations_relations where sku='".$sku."' AND flag=1"; 
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}



//get store name
if( ! function_exists('getStoreName')){ 
	function getStoreName($store_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$ci->db->select('*');
	$ci->db->from('store');
	$ci->db->where(array('store_id' => $store_id));  	
	$query = $ci->db->get();	
	$row = $query->row();
	return $row->store_name;	
	}
}


 // get minimum amount of product By each dealer
if( ! function_exists('getDataByOrderAndGroupBy')) {
	function getDataByOrderAndGroupBy($table,$where=array(),$whereIn=array(),$whereinColName,$orderField,$orderBy,$groupBy) {
		
		$ci =& get_instance();	
		$ci->load->database();
		$ci->db->select('*');
		$ci->db->from($table);
		if($where != '') {
			$ci->db->where($where); 
		}

		if(!empty($whereIn)) { 
			$ci->db->where_in($whereinColName,$whereIn); 
		}

		if($orderBy != '') {
			$ci->db->order_by($orderField, $orderBy); 
		}

		if($groupBy != '') {
			$ci->db->group_by($groupBy); 
		}


		$query = $ci->db->get();	
		$row = $query->result_array();
		return $row;
	}
}


// Get days duration between two dates to today date(DateFormat:- y-m-d h:i:s)
if( ! function_exists('getDaysByDateDiff')) {
	function getDaysByDateDiff($modifyDate,$todayDate) {

		$diff = abs(strtotime($todayDate) - strtotime($modifyDate));
		
		$year = floor($diff / (365*60*60*24));

		$month = floor(($diff - $year*65*60*60*24) / (30*60*60*24));
		$day = floor(($diff - $year*365*60*60*24 - $month*30*60*60*24)/ (60*60*24));

		$hours   = str_pad(floor(($diff - $year*365*60*60*24 - $month*30*60*60*24 - $day*60*60*24)/ (60*60)), 2, '0', STR_PAD_LEFT); 

		$minuts  = str_pad(floor(($diff - $year*365*60*60*24 - $month*30*60*60*24 - $day*60*60*24 - $hours*60*60)/ 60), 2, '0', STR_PAD_LEFT); 

		$seconds = str_pad(floor(($diff - $year*365*60*60*24 - $month*30*60*60*24 - $day*60*60*24 - $hours*60*60 - $minuts*60)), 2, '0', STR_PAD_LEFT); 

		/*$datetime1 = new DateTime($todayDate);
        $datetime2 = new DateTime($modifyDate);
        $interval = $datetime1->diff($datetime2);

        $year = $interval->format('%y');
        $month = $interval->format('%m');
        $day = $interval->format('%a');
        $hours = str_pad($interval->format('%h'), 2, '0', STR_PAD_LEFT);
        $minuts = str_pad($interval->format('%i'), 2, '0', STR_PAD_LEFT);
        $seconds = $interval->format('%s');*/

        if($year != 0) {
          $wDateDifference = $year.'year '.$month.'month '.$day.'day '.$hours.':'.$minuts.':'.'00';
        } elseif($year == 0 && $month != 0) {
          $wDateDifference = $month.'month '.$day.'day '.$hours.':'.$minuts.':'.'00';
        } elseif($year == 0 && $month == 0 && $day != 0) {
          $wDateDifference = $day.'day '.$hours.':'.$minuts.':'.'00';
        } elseif($year == 0 && $month == 0 && $day == 0) {
          $wDateDifference = $hours.':'.$minuts.':'.'00';
        } else {
          $wDateDifference = $minuts.'m:'.$seconds.'s';
        }

        return $wDateDifference;
	}
}


// Multidimension Array Sort
function multidimensionArraySort($array, $on, $order=SORT_ASC){

    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {

        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}



if( ! function_exists('get_Allattribute_values')){ 
	function get_Allattribute_values($attribute_id){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT attribute_value_id,attribute_value FROM attribute_value where attribute_id=".$attribute_id; 	
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


if( ! function_exists('all_attributeof_product')){ 
	function all_attributeof_product($product_id){	// You may want to pull this from an array within the helper	
		$ci =& get_instance();	
		$ci->load->database();

		//$sql1 = "SELECT attribute_id,GROUP_CONCAT(DISTINCT variation_id) as vId FROM product_variations_relations where product_id=76 AND flag = 1 GROUP BY attribute_id";

		$sql1 = "SELECT attribute_id,GROUP_CONCAT(DISTINCT variation_id) as vId FROM product_variations_relations where product_id=".$product_id." AND flag = 1 GROUP BY attribute_id";

		$query1 = $ci->db->query($sql1);	
		$rows = $query1->result_array();

		$attrArray=[];
		foreach($rows as $row) {

			$vIds = explode(',',$row['vId']);

			if(isset($row['attribute_id']) && $row['attribute_id'] != '') {
				$attributeName = $ci->db->query("SELECT attribute_name FROM attributes WHERE attribute_id=".$row['attribute_id']);
				
				$attrName = $attributeName->result_array();
			}


			if(isset($vIds) && is_array($vIds) && !empty($vIds)) {
				$attributeValues = $ci->db->query('SELECT GROUP_CONCAT(attribute_value) AS attrValues FROM attribute_value WHERE attribute_value_id IN ("' . implode('", "', $vIds) . '") GROUP BY attribute_id');

				$attrVal = $attributeValues->result_array();
			}


			if(!empty($attrVal) && !empty($attrName)) {

				$attrArray[] = "<p style='color:red' class='product_attribute_name' attrId='".$row['attribute_id']."'>".$attrName[0]['attribute_name']."=></p>".$attrVal[0]['attrValues']."<br>";
			}

		}
		return $attrArray;
	}
}




if( ! function_exists('getProductVariationForStock')){ 
	function getProductVariationForStock($product_id, $compCode, $warehouseCentral){	// You may want to pull this from an array within the helper	
	$ci =& get_instance();	
	$ci->load->database();	
	$sql = "SELECT id,warehouse_id,master_product_id as product_id,product_id as sku FROM warehouse_inventory where master_product_id='".$product_id."' AND comp_code='".$compCode."' AND warehouse_id='".$warehouseCentral."'"; 
	echo $sql;
	$query = $ci->db->query($sql);	
	$row = $query->result_array();
	return $row;	
	}
}


// Get Sku Status
if( ! function_exists('getValue')){ 
	function getValue($table,$select,$where) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select($select);
		$ci->db->from($table);
		$ci->db->where($where);
		$query = $ci->db->get();
		$result = $query->result_array();
		return $result;
	}
}


if( ! function_exists('getProductBatchs')){ 
	function getProductBatchs($product_id, $comp_code) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('product_batch_id, batch_number');
		$ci->db->from('product_batch');
		$ci->db->where(['product_id'=>$product_id, 'comp_code'=>$comp_code]);
		$ci->db->order_by('exp_date','asc');
		$query = $ci->db->get();
		$result = $query->result_array();
		return $result;
	}
}


if( ! function_exists('getStockByPidWidBid')){ 
	function getStockByPidWidBid($product_id, $warehouse_is_central_id, $batch_id, $comp_code){
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('stock_qty');
		$ci->db->from('warehouse_inventory');
		$ci->db->where(array('product_id' => $product_id, 'warehouse_id' => $warehouse_is_central_id, 'comp_code'=>$comp_code, 'batch_id'=>0));  
		$query = $ci->db->get();
		$row = $query->row();
		return $row;
	}
}

if( ! function_exists('getProductBatchsForWarehouseTransfer')){ 
	function getProductBatchsForWarehouseTransfer($warehouse_id, $product_id, $comp_code) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('a.product_batch_id, a.batch_number');
		$ci->db->from('product_batch as a');
		$ci->db->join('warehouse_inventory as b', 'b.batch_id = a.product_batch_id');
		$ci->db->where(['b.warehouse_id'=>$warehouse_id, 'a.product_id'=>$product_id, 'a.comp_code'=>$comp_code, 'b.stock_qty >'=>0]);
		$ci->db->order_by('a.exp_date','asc');
		$ci->db->group_by('batch_id');
		$query = $ci->db->get();
		$result = $query->result_array();
		return $result;
	}
}



if( ! function_exists('getBatchsForStoreToWhTransfer')){ 
	function getBatchsForStoreToWhTransfer($store_id, $product_id, $comp_code) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('*');
		$ci->db->from('product_batch as a');
		$ci->db->join('store_inventory as b', 'b.batch_id = a.product_batch_id');
		$ci->db->where(['b.store_id'=>$warehouse_id, 'a.product_id'=>$product_id, 'a.comp_code'=>$comp_code, 'b.stock_qty >'=>0]);
		$ci->db->order_by('a.exp_date','asc');
		$ci->db->group_by('batch_id');
		$query = $ci->db->get();
		$result = $query->result_array();
		return $result;
	}
}



if( ! function_exists('getProductBatchsForStoreTransfer')){ 
	function getProductBatchsForStoreTransfer($store_id, $product_id, $comp_code) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('a.product_batch_id, a.batch_number');
		$ci->db->from('product_batch as a');
		$ci->db->join('store_inventory as b', 'b.batch_id = a.product_batch_id');
		$ci->db->where(['b.store_id'=>$store_id, 'a.product_id'=>$product_id, 'a.comp_code'=>$comp_code, 'b.stock_qty >'=>0]);
		$ci->db->order_by('a.exp_date','asc');
		$ci->db->group_by('batch_id');
		$query = $ci->db->get();
		$result = $query->result_array();
		return $result;
	}
}


if( ! function_exists('getBatchProduct')) {
	function getBatchProduct($compCode) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('a.product_id, b.product_name');
		$ci->db->from('product_batch as a');
		$ci->db->join('product as b', 'b.product_id = a.product_id');
		$ci->db->where('a.comp_code',$compCode);
		$ci->db->group_by('product_id');
		$query = $ci->db->get();
		$result = $query->result();
		return $result;
	}
}


if( ! function_exists('batchNameByBatchId')) {
	function batchNameByBatchId($batchId) {
		$ci =& get_instance();	
		$ci->load->database();	
		$ci->db->select('batch_number');
		$ci->db->from('product_batch');
		$ci->db->where(array('product_batch_id' => $batchId));  
		$query = $ci->db->get();
  		$row = $query->row();
		return $row->batch_number;
	}
}