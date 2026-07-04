<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageProductCategory extends CI_Controller {

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
		$this->load->model('manageproductcategory_model');
	}

	public function index()
	{
		global $uInfo;
		$data['product_category']= $this->manageproductcategory_model->getAllProductCategory($uInfo['comp_code']);
		$data['title'] = 'Product | Inventory';
		$data['heading_title'] = "View Category";
		$this->load->view('manageProductCategory/viewProductCategory',$data);
	}
	
	public function getSubCatByParID()
	{
	  $p_cat_id = $this->input->get('cat_id');
	 $html = "<select name='subcat'>";
	 $sub_category = $this->manageproductcategory_model->getSubCats($p_cat_id);
	
	if(!empty($sub_category)) {
	$html.= "<option value=''>Select Subcat</option>";
	foreach($sub_category as $sub_category) {
			$html.=	"<option value='".$sub_category->product_cat_id."'>".$sub_category->cat_name."</option>";
	        }
	} else {
	$html.= "<option value=''>No Subcats</option>";
	}
	$html.="</select>";
	echo $html;
	}
	
	// Add Product
	public function addProductCategory(){
		global $uInfo;
		if($this->form_validation->run("addProductCategory")==TRUE)
		{
			$catParentId = $this->input->post("cat_parent_id");
			$subCat = $this->input->post("subcat");

			$data = array(
					'cat_name' => $this->input->post("category_name"),
					'cat_parent_id' => (isset($subCat) && $subCat != '') ? $subCat : $catParentId,
					'cat_status' => 1,
					'create_date' => date("Y-m-d h:i:s"),
					'royalty_point_price' => $this->input->post("royalty_point"),
					'comp_code' => $uInfo['comp_code'],
					'modify_date' => date("Y-m-d h:i:s")
				);
				
			$this->manageproductcategory_model->addProductCategory($data);
			$last_inserted_id = $this->db->insert_id();
			
			//Entry for event logs
			if($this->db->affected_rows()==true)
			{
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'product_category','PRODUCT CATEGORY',date("Y-m-d h:i:s"),'Added Product Category Successfully.');
			}
			
    		$this->session->set_flashdata('success_msg','Product Category added successfuly ! ! !');
    		if($this->input->post("addproduct-url")) {
    			redirect(base_url().'webadmin/manageproduct/addProduct');
    		} else {
    			redirect(base_url().'webadmin/manageproductcategory/viewProductCategory');
    		}
		}
		
		if($this->form_validation->run("addProductCategory")==FALSE)
		{
			$data['parentCategory'] = $this->input->post("cat_parent_id");
		}

		$data['title'] = 'Product Category | Inventory';
		$data['heading'] = "Add Product Category";
		$this->load->view('manageProductCategory/addProductCategory',$data);
	}
	
	// View Product List
	public function viewProductCategory(){
		global $uInfo;
		$data['product_category']= $this->manageproductcategory_model->getAllProductCategory($uInfo['comp_code']);
		$data['title'] = 'Product Category | Inventory';
		$data['heading'] = "View Product Category";
		$this->load->view('manageProductCategory/viewProductCategory',$data);
	}
	
	// Update Users Info.
	public function editProductCategory($productcatID){
		global $uInfo;
		
		$original_value = $this->input->post('hdn_cat_name');
		/*if($this->input->post('cat_name') != $original_value) {
		   $is_unique =  '|is_unique[product_category.cat_name]';
		} else {
		   $is_unique =  '';
		}*/
		$this->form_validation->set_rules('cat_name', 'Category Name', 'required|callback_lettersOnly_check|callback_checkProductCategoryOnEditCase');

		if($this->form_validation->run()==TRUE)
		{
			$data = array(
					'cat_name' => $this->input->post("cat_name"),
					'cat_parent_id' => $this->input->post("cat_parent_id"),
					'modify_date' => date("Y-m-d h:i:s")
					
				);
				//print_r($data);exit;
			$this->manageproductcategory_model->updateProductCategory($productcatID,$data);
			
			//Entry for event logs
					if($this->db->affected_rows()==true)
					{
					event_log('update',$uInfo['user_ID'],$productcatID,'product_category','PRODUCT CATEGORY',date("Y-m-d h:i:s"),'Updated Product Category Successfully.');
					}
    		$this->session->set_flashdata('success_msg','Product Category updated successfuly ! ! !');
    		redirect(base_url().'webadmin/manageproductcategory/viewProductCategory');
		}
		$data['productCatInfo'] = $this->manageproductcategory_model->getProductCategoryInfoByID($productcatID);
		$data['title'] = 'Product Category | Inventory';
		$data['heading'] = "Edit Product Category"; 
		$this->load->view('manageProductCategory/editProductCategory',$data);
	}  

	
	// Delete Product
	public function deleteProductCategory($productcatID){
	global $uInfo;
		$this->manageproductcategory_model->deleteProductCategory($productcatID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$productcatID,'product_category','PRODUCT CATEGORY',date("Y-m-d h:i:s"),'Deleted Category Successfully.');
					}
		
    	$this->session->set_flashdata('success_msg','Product Category Deleted Successfully ! ! !');
    	redirect('webadmin/manageproductcategory/viewProductCategory');
	}
	
	
	// Change Product Status
	public function changeProductCategoryStatus(){
	global $uInfo;
		$product_catID=$this->input->get('product_cat_id');
		$product_cat_status=$this->input->get('cat_status');
		$data = array(
    			'cat_status' => $product_cat_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->manageproductcategory_model->changeProductCategoryStatus($product_catID,$data);
		
		//Entry for event logs
		if($this->db->affected_rows()==true)
		{
			event_log('change_product_cat_status',$uInfo['user_ID'],$product_catID,'product_category','PRODUCT CATEGORY',date("Y-m-d h:i:s"),'Product Category Status Changed');
		}
	}

	
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters only please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function categoryNameCheck($str) {
		global $uInfo;
		$result = $this->manageproductcategory_model->checkCategoryName($str, $uInfo['comp_code']);
		if(!empty($result)) {
			$this->form_validation->set_message('categoryNameCheck', 'Already Category Name Created.');
			return FALSE;
		} else {
			return TRUE;
		}
	}

	public function checkProductCategoryOnEditCase($str) {
		global $uInfo;
		$catId = $this->uri->segment(4);
		$checkCurrent = $this->manageproductcategory_model->checkProductCategoryOnEditCase($str,$catId,$uInfo['comp_code']);
		if(!empty($checkCurrent)) {
			$this->form_validation->set_message('checkProductCategoryOnEditCase', 'This Category already exits.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
}

