<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageProduct extends CI_Controller {

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
			$this->load->model(['manageproduct_model','managereports_model','managestore_model']);
		}
	public function index()
	{
		$data['product']= $this->manageproduct_model->getAllProduct();
		$data['title'] = 'Product | Inventory';
		$data['heading'] = "View Product";
		$this->load->view('manageProduct/viewProduct',$data);
	}

	function factorial($n) {
		$num = $n;
		$factorial = 1;
		for ($x=$num; $x>=1; $x--) 
		{
		  $factorial = $factorial * $x;
		}
		return $factorial;
		//echo "Factorial of $num is $factorial";
	}

	function combination($n,$r) {
		$nval = $this->factorial($n);
		$rval = $this->factorial($r);
		$subtract = $n-$r;
		$subval = $this->factorial($subtract);
		$formula = ($nval/($subval*$rval));
		return $formula;
	}

	function permutations($set)
	{
	$solutions=array();
	$n=count($set);
	$p=array_keys($set);
	$i=1;
 
	while ($i<$n)
		{
		if ($p[$i]>0)
			{
			$p[$i]--;
			$j=0;
			if ($i%2==1)
				$j=$p[$i];
			//swap
			$tmp=$set[$j];
			$set[$j]=$set[$i];
			$set[$i]=$tmp;
			$i=1;
			$solutions[]=$set;
			}
		elseif ($p[$i]==0)
			{
			$p[$i]=$i;
			$i++;
			}
		}
	return $solutions;
	}

	function generate_combinations(array $data, array &$all = array(), array $group = array(), $value = null, $i = 0)
	{
			
	    $keys = array_keys($data);
	    if (isset($value) === true) {
	        array_push($group, $value);
	    }

	    if ($i >= count($data)) {
	        array_push($all, $group);
	    } else {
	        $currentKey     = $keys[$i];
	        $currentElement = $data[$currentKey];
	        foreach ($currentElement as $val) {
	            $this->generate_combinations($data, $all, $group, $val, $i + 1);
	        }
	    }

	    return $all;
	}



function recursive($array, $level = 1){
    foreach($array as $key => $value){
        //If $value is an array.
        if(is_array($value)){
            //We need to loop through it.
            recursive($value, $level + 1);
        } else{
            //It is not an array, so print it out.
            echo str_repeat("-", $level), $value, '<br>';
        }
    }
}
	
	// Add Product
	public function addProduct(){
		global $uInfo;
		
		$this->load->library('form_validation');

		$tax_val = $this->input->post('product_tax');
		if(isset($tax_val) && !empty($tax_val)){
		$product_tax = implode(",",$tax_val);
		}else{$product_tax = 0;}
		 
		$config['upload_path']   = './uploads/product_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	     = '10000';
		$config['max_width']     = '102400';
		$config['max_height']    = '76800';
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);

		
		if(($this->input->post('product_submit')) && ($this->input->post('product_submit')=="product_form")){
			
			/*$this->form_validation->set_rules('product_code', 'Product Code', 'required|is_unique[product.product_code]');

			if ($this->form_validation->run() == FALSE) {
				$data['title'] = 'Product | Inventory';
				$data['heading'] = "Add Product";
				$this->load->view('manageProduct/addProduct',$data);
			} else {*/
			$product_image='';
			if ($this->upload->do_upload('product_image')) {

				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => './uploads/product_image/'.$upload_data['file_name'], 
							'new_image' => './uploads/product_image/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$product_image = $upload_data['file_name'];
			
			}

			$data = array( 
				'product_name'         => $this->input->post('product_name'),
				'product_code'        => $this->input->post('product_code'),
				'product_category'     => $this->input->post('product_category'),
				'product_sub_category' => $this->input->post('product_sub_category'),
				'product_sub_of_sub_category' => $this->input->post('product_sub_of_sub_category'),
				'product_description'  => $this->input->post('product_description'),
				'product_tax'          => $product_tax,
				'offer_id'             => $this->input->post('offer_name'),
				'loyalty_points'       => $this->input->post('loyalty_points'),
				'specification'        => $this->input->post('specification'),
				'remarks'              => $this->input->post('remarks'),
				'product_image'        => $product_image,
				'product_price'        => $this->input->post('product_price'),
				'markup_per'        => $this->input->post('markup_per'),
				'markup_amt'        => $this->input->post('markup_amt'),
				'product_mrp'        => $this->input->post('product_mrp'),
				'product_barcode_radio' => $this->input->post('product_barcode_radio'),
				'product_barcode_text' => $this->input->post('product_barcode_text'),
				'min_stock_qty'        => $this->input->post('min_stock_qty'),
				'created_by'           => $uInfo['user_ID'],
				'user_level'           => $uInfo['user_level'],
				'create_date'          => date("Y-m-d h:i:s"),
				'comp_code'			   => $uInfo['comp_code'],	
				'gst_rate'			   => $this->input->post('gst_rate'),
				'gst_inc'			   => $this->input->post('gst_inc'),
				'modify_date'          => date("Y-m-d h:i:s")
				);
			$this->manageproduct_model->product_Insert($data);


			
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			$productId = $last_inserted_id;
			if($this->db->affected_rows()==true){
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'product','PRODUCT',date("Y-m-d h:i:s"),'Added product successfully.');
			// Insert for GST rate Log 
			$gst_data = array(
			'product_id' =>$last_inserted_id,
			'comp_code' =>$uInfo['comp_code'],
			'rate'     =>  $this->input->post('gst_rate'),
			'updated'     =>  date('Y-m-d'),
			'updated_by'     =>  $uInfo['user_ID']
			
			);
			$this->db->insert('gst_rate',$gst_data);
			
			}
			// End Entry for event logs
			
			$getWarehouseIsCentral = $this->manageproduct_model->getWarehouseIsCentral();
			if(!empty($getWarehouseIsCentral)) {
				$warehouse_id = $getWarehouseIsCentral->warehouse_id;
				$this->manageproduct_model->warehouseInventory_Insert($last_inserted_id, $warehouse_id);
			}
			
			
			
			// Insert First and Default Sku
			$pData = getSku('product',['product_id'=>$last_inserted_id]); //Product Data
			$productCode = $this->input->post('product_code');
			$productBarcode = $this->input->post('product_barcode_text');
			if(isset($productBarcode) && !empty($productBarcode))
			{
				$skuPrefix = $productBarcode;
			} else {
				$skuPrefix = $productCode;
			}
			$skuData = ['product_id'=>$productId,
						'sku'=>$productCode.'-'.$productId,
						'flag'=>1,
						'create_date'=>date('Y-m-d H:i:s')];
			commonInsert('product_variations_relations', $skuData);

		/*if($this->input->post('attribute_id') && $this->input->post('attr_value') && $this->input->post('attr_value')!="") {
		   
		$attr_value_array = $this->input->post('attr_value');
		$json_attr_value_array = json_encode($attr_value_array);
		$count_array = count($attr_value_array);
		$array_key = array_keys($attr_value_array);
		
		for($i=0;$i<$count_array;$i++)
			{
				$key  = $array_key[$i];
				$inner_count = count($attr_value_array[$key]);
				
				$myarray = array();
				for($j=0;$j<$inner_count;$j++)
				{
					 $myarray[] = $attr_value_array[$key][$j];	
				}
				$attr_value = (implode(",",$myarray));
				$data = array(
					'product_id' => $last_inserted_id,
					'attribute_id' => $key,
					'attribute_value' => $attr_value,
					'json_attribute_value' => $json_attr_value_array,
					'create_date' => date("Y-m-d h:i:s"),
					'modify_date' => date("Y-m-d h:i:s")
					);
					$this->manageproduct_model->add_productAttr($data);
			}
			
			// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('insert',$uInfo['user_ID'],$last_inserted_id,'product_attribute','PRODUCT',date("Y-m-d h:i:s"),'Added product attributes successfully.');
				} 
				// End Entry for event logs

				
		/********  Product Attributes Variations Here ***********/
			/*$data=$this->input->post('attr_value');
			$generate = $this->generate_combinations($data);
			
			//$sum=1;
			for($i=0; $i<count($generate); $i++) {
				$ivalCount=count($generate[$i]);
				for($j=0; $j<$ivalCount; $j++) {
					$getAttributeValue = getAttributIdVariationId($generate[$i][$j]);
					$attrId = $getAttributeValue[0]['attribute_id'];
					//$sum +=$i;
					$sum =$i+1;
					$num_padded = sprintf("%03d", $sum);
					//$sku='sku_'.$productId.$generate[$i][$j].'_'.$attrId.'_'.$sum;
					//$sku='sku_'.$productId.'_'.$generate[$i][$j].'_'.$attrId.'_'.$sum;
					$sku=$productId.'-'.$num_padded;
					$combinationResult[]=['relation_common_id'=>$i+1,
							'product_id'=>$productId,
							'sku'=>$sku,
							'attribute_id'=>$attrId,
							'variation_id'=>$generate[$i][$j],
							];
							
					//$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($res);
				}
			}
			
		

			foreach($combinationResult as $combinationResults) {
				$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
			}*/

		/********  Product Attributes Variations Here ***********/	

		/*}  
		else
		{
		
			
		}*/		
			$this->session->set_flashdata('success_msg', 'Product Created successfuly ! ! !');
			redirect(base_url().'webadmin/manageproduct/viewProduct');
			//}
		} 
		
		$data['title'] = 'Product | Inventory';
		$data['heading'] = "Add Product";
		$this->load->view('manageProduct/addProduct',$data);
		
		
	}
	
	// vendor To WareHouse Add Product
	public function vendorToWhAddProduct(){
		global $uInfo;
		$tax_val = $this->input->post('product_tax');
		if(isset($tax_val) && !empty($tax_val)){
		$product_tax = implode(",",$tax_val);
		}else{$product_tax = 0;}
		 
		$config['upload_path']   = './uploads/product_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	     = '10000';
		$config['max_width']     = '102400';
		$config['max_height']    = '76800';
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);
		 
		if(($this->input->post('product_submit')) && ($this->input->post('product_submit')=="product_form")){
		

			if ($this->upload->do_upload('product_image')) {
				 
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => 'uploads/product_image/'.$upload_data['file_name'], 
							'new_image' => 'uploads/product_image/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$product_image = $upload_data['file_name'];
			
			
			$data = array(
				
				'product_name'         => $this->input->post('product_name'),
				'product_category'     => $this->input->post('product_category'),
				'product_sub_category' => $this->input->post('product_sub_category'),
				'product_sub_of_sub_category' => $this->input->post('product_sub_of_sub_category'),
				'product_description'  => $this->input->post('product_description'),
				'product_tax'          => $product_tax,
				'offer_id'             => $this->input->post('offer_name'),
				'loyalty_points'       => $this->input->post('loyalty_points'),
				'specification'        => $this->input->post('specification'),
				'remarks'              => $this->input->post('remarks'),
				'product_image'        => $product_image,
				'product_price'        => $this->input->post('product_price'),
				'markup_per'        => $this->input->post('markup_per'),
				'markup_amt'        => $this->input->post('markup_amt'),
				'product_mrp'        => $this->input->post('product_mrp'),
				'product_barcode_radio' => $this->input->post('product_barcode_radio'),
				'product_barcode_text' => $this->input->post('product_barcode_text'),
				'created_by'           => $uInfo['user_ID'],
				'user_level'           => $uInfo['user_level'],
				'create_date'          => date("Y-m-d h:i:s"),
				'modify_date'          => date("Y-m-d h:i:s")
				);
			$this->manageproduct_model->product_Insert($data);
			}
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert',$uInfo['user_ID'],$last_inserted_id,'product','PRODUCT',date("Y-m-d h:i:s"),'Added product successfully.');
			}
			// End Entry for event logs
			
			$getWarehouseIsCentral = $this->manageproduct_model->getWarehouseIsCentral();
			if(!empty($getWarehouseIsCentral)) {
				$warehouse_id = $getWarehouseIsCentral->warehouse_id;
			}
			
			$this->manageproduct_model->warehouseInventory_Insert($last_inserted_id, $warehouse_id);
			
			
		if($this->input->post('attribute_id') && $this->input->post('attr_value') && $this->input->post('attr_value')!="") {
		   
		$attr_value_array = $this->input->post('attr_value');
		$json_attr_value_array = json_encode($attr_value_array);
		$count_array = count($attr_value_array);
		$array_key = array_keys($attr_value_array);
		
		for($i=0;$i<$count_array;$i++)
			{
				$key  = $array_key[$i];
				$inner_count = count($attr_value_array[$key]);
				
				$myarray = array();
				for($j=0;$j<$inner_count;$j++)
				{
					 $myarray[] = $attr_value_array[$key][$j];	
				}
				$attr_value = (implode(",",$myarray));
				$data = array(
					'product_id' => $last_inserted_id,
					'attribute_id' => $key,
					'attribute_value' => $attr_value,
					'json_attribute_value' => $json_attr_value_array,
					'create_date' => date("Y-m-d h:i:s"),
					'modify_date' => date("Y-m-d h:i:s")
					);
					$this->manageproduct_model->add_productAttr($data);
				
			}
			
			// Entry for event logs
				$last_inserted_id = $this->db->insert_id();
				if($this->db->affected_rows()==true){
					event_log('insert',$uInfo['user_ID'],$last_inserted_id,'product_attribute','PRODUCT',date("Y-m-d h:i:s"),'Added product attributes successfully.');
				} 
				// End Entry for event logs

				/********  Product Attributes Variations Here ***********/
				$data=$this->input->post('attr_value');
				$generate = $this->generate_combinations($data);
				
				//$sum=1;
				for($i=0; $i<count($generate); $i++) {
					$ivalCount=count($generate[$i]);
					for($j=0; $j<$ivalCount; $j++) {
						$getAttributeValue = getAttributIdVariationId($generate[$i][$j]);
						$attrId = $getAttributeValue[0]['attribute_id'];
						//$sum +=$i;
						$sum =$i+1;
						$num_padded = sprintf("%03d", $sum);
						//$sku='sku_'.$productId.$generate[$i][$j].'_'.$attrId.'_'.$sum;
						//$sku='sku_'.$productId.'_'.$generate[$i][$j].'_'.$attrId.'_'.$sum;
						$sku=$productId.'-'.$num_padded;
						$combinationResult[]=['relation_common_id'=>$i+1,
								'product_id'=>$productId,
								'sku'=>$sku,
								'attribute_id'=>$attrId,
								'variation_id'=>$generate[$i][$j],
								];
								
						//$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($res);
					}
				}

				foreach($combinationResult as $combinationResults) {
					$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
				}

			/********  Product Attributes Variations Here ***********/	
		   
		}  
		else
		{
		
			
		}			
			$this->session->set_flashdata('success_msg', 'Product Created successfuly ! ! !');
			redirect(base_url().'webadmin/managewarehouse/vendorToWarehouseTransfer');
		
		} 
		
		$data['title'] = 'Product | Inventory';
		$data['heading'] = "Add Product";
		$this->load->view('manageProduct/addProduct',$data);
		
		
	}

	
	// View Product List
	public function viewProduct(){
		global $uInfo;
		
		$data['product']= $this->manageproduct_model->getAllProduct($uInfo['comp_code']);
		$data['title'] = 'Product | Inventory';
		$data['heading'] = "View Product";
		$this->load->view('manageProduct/viewProduct',$data);
	}
	
	// Update Users Info.
	public function editProduct($productID){
	global $uInfo;

		
		$tax_val = $this->input->post('product_tax');
		if(isset($tax_val) && !empty($tax_val)){
		$product_tax = implode(",",$tax_val);
		}else{$product_tax = "Not Added";}
		
		$config['upload_path']   = './uploads/product_image/';
		$config['allowed_types'] = 'gif|jpg|png|jpeg';
		$config['max_size']	     = '10000';
		$config['max_width']     = '102400';
		$config['max_height']    = '76800';
		$config['encrypt_name']  = TRUE;
		$this->load->library('upload', $config);

		 
		if(($this->input->post('product_submit')) && ($this->input->post('product_submit')=="product_form")){

			if (!$this->upload->do_upload('product_image')) {
				$product_image = $this->input->post('hdn_product_image');
			}
			else{
				$upload_data = $this->upload->data();
				$config2 = array(
							'source_image' => 'uploads/product_image/'.$upload_data['file_name'], 
							'new_image' => 'uploads/product_image/thumbs/'.$upload_data['file_name'], 
							'maintain_ratio' => true,
							'width' => 262,
							'height' => 197
						  );
				$this->load->library('image_lib', $config2);
				$this->image_lib->initialize($config2);
				$this->image_lib->resize();
				$product_image = $upload_data['file_name'];
			
			}
			updateGstLog($productID,$uInfo['comp_code'],$this->input->post('gst_rate'),$uInfo['user_ID']);
			
			$data = array(
				
				'product_name'         => $this->input->post('product_name'),
				'product_category'     => $this->input->post('product_category'),
				'product_sub_category' => $this->input->post('product_sub_category'),
				'product_sub_of_sub_category' => $this->input->post('product_sub_of_sub_category'),
				'product_description'  => $this->input->post('product_description'),
				'product_tax'          => $product_tax,
				'offer_id'             => $this->input->post('offer_name'),
				'loyalty_points'       => $this->input->post('loyalty_points'),
				'specification'        => $this->input->post('specification'),
				'min_stock_qty'        => $this->input->post('min_stock_qty'),
				'remarks'              => $this->input->post('remarks'),
				'product_image'        => $product_image,
				'product_price'        => $this->input->post('product_price'),
				'product_mrp'          => $this->input->post('product_mrp'),
				'product_barcode_radio' => $this->input->post('product_barcode_radio'),
				'product_barcode_text' => $this->input->post('product_barcode_text'),
				'gst_rate'        => $this->input->post('gst_rate'),
				'gst_inc'			   => $this->input->post('gst_inc'),
				'modify_date'          => date("Y-m-d h:i:s")
				);
			$this->manageproduct_model->product_update($productID,$data);
			
			// Entry for event logs
			
			if($this->db->affected_rows()==true){
				event_log('update',$uInfo['user_ID'],$productID,'product','PRODUCT',date("Y-m-d h:i:s"),'Updated product successfully.');
			}
			// End Entry for event logs
			
		/*if($this->input->post('attribute_id') && $this->input->post('attr_value') && $this->input->post('attr_value')!="") {
		   
		$attr_value_array = $this->input->post('attr_value');
		$json_attr_value_array = json_encode($attr_value_array);
		$count_array = count($attr_value_array);
		$array_key = array_keys($attr_value_array);
		
		$this->manageproduct_model->delete_exist_productAttr($productID);
		
		for($i=0;$i<$count_array;$i++)
			{
				$key  = $array_key[$i];
				$inner_count = count($attr_value_array[$key]);
				
				$myarray = array();
				for($j=0;$j<$inner_count;$j++)
				{
					 $myarray[] = $attr_value_array[$key][$j];	
				}
				
				$attr_value = (implode(",",$myarray));
				
				
				$data = array(
					'product_id' => $productID,
					'attribute_id' => $key,
					'attribute_value' => $attr_value,
					'json_attribute_value' => $json_attr_value_array,
					'modify_date' => date("Y-m-d h:i:s")
					);
				//print_r($data);	
					
					$this->manageproduct_model->add_productAttr($data);
			}


			/********  Product Attributes Variations Here ***********/
				/*$data=$this->input->post('attr_value');
				$generate = $this->generate_combinations($data);
				
				for($i=0; $i<count($generate); $i++) {
					$ivalCount=count($generate[$i]);
					for($j=0; $j<$ivalCount; $j++) {
						$getAttributeValue = getAttributIdVariationId($generate[$i][$j]);
						$attrId = $getAttributeValue[0]['attribute_id'];
						//$sum +=$i;
						$sum = $i+1;
						$num_padded = sprintf("%03d", $sum);
						//$sku='sku_'.$productId.$generate[$i][$j].'_'.$attrId.'_'.$sum;
						//$sku='sku_'.$productID.'_'.$generate[$i][$j].'_'.$attrId.'_'.$sum;
						$sku=$productID.'-'.$num_padded;
						$combinationResult[]=['relation_common_id'=>$i+1,
								'product_id'=>$productID,
								'sku'=>$sku,
								'attribute_id'=>$attrId,
								'variation_id'=>$generate[$i][$j],
								];	
					}
				}

				$getAllVariation = $this->manageproduct_model->getAttrVariation($productID);
				if(!empty($getAllVariation)) {
					$delVariation = $this->manageproduct_model->delProductVariation($productID);
					foreach($combinationResult as $combinationResults) {
						$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
					}
				} else {
					foreach($combinationResult as $combinationResults) {
						$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
					}
				}*/
			/********  Product Attributes Variations Here ***********/	


			
			// Entry for event logs
				
				/*if($this->db->affected_rows()==true){
					event_log('update',$uInfo['user_ID'],$productID,'product_attribute','PRODUCT',date("Y-m-d h:i:s"),'Update product attributes successfully.');
				} 
				// End Entry for event logs
		   
		}  
		else
		{
		
			
		}*/
		$this->session->set_flashdata('success_msg','Product Updated Successfully ! ! !');
		redirect(base_url().'webadmin/manageproduct/viewProduct');
	}
		
		$data['productInfo']=$this->manageproduct_model->getProductInfoByID($productID);
		$data['productAttrInfo']=$this->manageproduct_model->getProductAttrInfoByID($productID);
		$data['title'] = 'Product | Inventory';
		$data['heading'] = "Edit Product"; 
		$this->load->view('manageProduct/editProduct',$data);
	}    
	
	// Delete Product
	public function deleteProduct($productID){
	global $uInfo;
		$this->manageproduct_model->deleteProduct($productID);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('delete',$uInfo['user_ID'],$productID,'product','PRODUCT',date("Y-m-d h:i:s"),'Deleted Product Successfully.');
					}
		
		$this->manageproduct_model->deleteProductAttr($productID);
    	$this->session->set_flashdata('success_msg','Product Deleted Successfully ! ! !');
    	redirect('webadmin/manageproduct/viewProduct');
	}
	
	
	// Change Product Status
	public function changeProductStatus(){
	global $uInfo;
		$productID=$this->input->get('product_id');
		$product_status=$this->input->get('product_status');
		$data = array(
    			'product_status' => $product_status,
				'modify_date' => date("Y-m-d h:i:s")
    			);
		$this->manageproduct_model->changeProductStatus($productID,$data);
		
		//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('change_product_status',$uInfo['user_ID'],$productID,'product','PRODUCT',date("Y-m-d h:i:s"),'Product Status Changed');
					}
	}
	
	//Add Attribute Terms values
	public function addAttrValue(){
	
		$attributeID = $this->input->post('attribute_id');
		$attribute_value = $this->input->post('attribute_value');
		$selected_value = $this->input->post('selected_value');
		
		
		$data = array(
    			'product_id' => $this->input->post('prodcut_id'),
				'attribute_id' => $this->input->post('attribute_id'),
				'attribute_value' => trim($this->input->post('attribute_value')),
				'create_date' => date("Y-m-d h:i:s"),
				'modify_date' => date("Y-m-d h:i:s")
    			);


		//$this->manageproduct_model->deleteExistAttrValue($attributeID,$attribute_value);
		$this->manageproduct_model->addAttrValue($attributeID,$selected_value,$data,$attribute_value);		
	}
	
	public function lettersOnly_check($str) {
		if (! preg_match("/^([a-zA-Z ])+$/i", $str)) {
			$this->form_validation->set_message('lettersOnly_check', 'The %s field can only be letters only please.');
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	
	public function get_subcategory()
	{
		$product_cat_id = $this->input->post("product_cat_id");
		$sub_cat = getSubCategory($product_cat_id);
		$count = count($sub_cat);	
			if($count>0 && $product_cat_id!="")
			{
				echo '<option value="">Select Sub Category</option>';
				foreach($sub_cat as $sub_cat){
					echo '<option value='.$sub_cat["product_cat_id"].'>'.$sub_cat["cat_name"].'</option>';
				}
			}
			else{
				echo '<option value="">Select Sub Category</option>';
				
			}
	}
	
	
	public function get_sub_of_sub_category()
	{
		$product_cat_id = $this->input->post("product_cat_id");
		$sub_cat = getSubofSubCategory($product_cat_id);
		//print_r($sub_cat);
		$count = count($sub_cat);	
			if($count>0 && $product_cat_id!="")
			{
				echo '<option value="">Select Sub Category</option>';
				foreach($sub_cat as $sub_cat){
					echo '<option value='.$sub_cat["product_cat_id"].'>'.$sub_cat["cat_name"].'</option>';
				}
			}
			else{
				echo '<option value="">Select Sub of Sub Category</option>';
			}
	}
	

	public function generateProductBarcode() {
		global $uInfo;

		if(($this->input->post('productbarcode_submit')) && ($this->input->post('productbarcode_submit')=="product_form")){
		
			$productId=$this->input->post('product_name');
			$productDetail=getProductDetail($productId, 'product_barcode_text');
			$quantity=$this->input->post('quantity');

			// Single batch of each product without array
			//$batch_val=$this->input->post('batch_'.$productId);

			$variationCheckbox = $this->input->post('variationCheckbox');
			$result=[];
			for($i=0;$i<count($variationCheckbox);$i++) {
				$sku=$variationCheckbox[$i];
				//$batchId=$batch_val;

				/*$where = ['product_batch_id'=>$batchId, 'comp_code'=>$uInfo['comp_code']];
				$batchData=getSku('product_batch', $where);
				$batchNumber=$batchData[0]['batch_number'];*/

				$replace1=str_replace('-','',$sku);
				$replace=str_replace('_','',$replace1);

				$arrayVariation=explode('-',$variationCheckbox[$i]);
				$result[$sku]=['label'=>$quantity[$sku],
							//'batch_number'=>$batchNumber,
							'barcode'=>$replace,
							'convert_barcode'=>$sku];
			}

			$data['response']=$result;
			//$data['productLabel']=$this->input->post('product_qty');
			$data['barcode']=$productDetail->product_barcode_text;
			$data['productId']=$productId;

			$this->load->view('manageProduct/print_product_barcode',$data);
		} else {
			$data['title'] = 'Product | Barcode';
			$data['heading'] = "Generate Product Barcode"; 
			$this->load->view('manageProduct/generateProductBarcode',$data);
		}
	}


	public function change_format() {
		$uInfo=$this->session->userdata('sales_session_info');

		$frmt=$this->input->post('format_opt');
		$skuData=$this->input->post('sku');
		$labelData=$this->input->post('product_qty');
		$barcode=$this->input->post('barcode');
		$batchNumber=$this->input->post('batch_number');

		$sku=explode(',',$skuData);
		$data['sku']=$sku;

		$label=explode(',',$labelData);
		$data['label']=$label;

		$barcode=explode(',',$barcode);
		$data['barcode']=$barcode;

		$batchNumber=explode(',',$batchNumber);
		$data['batch_number']=$batchNumber;

		/*$productId=$this->input->post('productId');
			
		$productDetail=getProductDetail($productId, 'product_barcode_text');

		$data['productLabel']=$this->input->post('product_qty');
		$data['barcode']=$productDetail->product_barcode_text;*/

		switch ($frmt) {
			case 'A4':
				$this->load->view('manageProduct/print_product_barcode_A4',$data);
				break;
			case 'A5':
				$this->load->view('manageProduct/print_product_barcode_A5',$data);
				break;
			case 'THRML':
				$this->load->view('manageProduct/print_product_barcode_thermal',$data);
				break;	
			default:
				echo "print in A4";
				break;
		}
	}


	public function generateProductSku() {

		if($this->input->post('productSku_submit')) {

			$productID=$this->input->post('product_id');
		
			$where=['product_id'=>$productID];
			$getProductCode=getSku('product',$where);
			
			$productCode=$getProductCode[0]['product_code'];


			$attr_value_array = $this->input->post('attr_value');
			

			if(isset($attr_value_array) && !empty($attr_value_array)) {

				$json_attr_value_array = json_encode($attr_value_array);
				$count_array = count($attr_value_array);
				$array_key = array_keys($attr_value_array);
				
			//	$this->manageproduct_model->delete_exist_productAttr($productID);
				
				for($i=0;$i<$count_array;$i++)
					{
						$key  = trim($array_key[$i]);
						$inner_count = count($attr_value_array[$key]);
						
						$myarray = array();
						for($j=0;$j<$inner_count;$j++)
						{
							$myarray[] = $attr_value_array[$key][$j];	
						}
						
						$attr_value = (implode(",",$myarray));
						
						
						$data = array(
							'product_id' => $productID,
							'attribute_id' => $key,
							'attribute_value' => trim($attr_value),
							'json_attribute_value' => $json_attr_value_array,
							'create_date' => date("Y-m-d h:i:s")
							);	
							
							$this->manageproduct_model->add_productAttr($data);
					}


				/********  Product Attributes Variations Here ***********/
					//$data=$this->input->post('attr_value');
					$generate = $this->generate_combinations($attr_value_array);
					
					$update=['flag'=>0];
					$where=['product_id'=>$productID];
					$updateFlag=updateData('product_variations_relations',$update,$where);

					for($i=0; $i<count($generate); $i++) {
						$ivalCount=count($generate[$i]);
						$firstThree='';

						$getAllAttribute = getAllVariationNames($generate[$i]);
						
						$attrVal='';
						foreach($getAllAttribute as $getAllAttributes) {
							$getAttrVal=trim($getAllAttributes['attribute_value']);
							
							$attrVal.=substr($getAttrVal, 0, 3).'_';
						}

						$sku = $productCode.'-'.rtrim($attrVal, '_');
						$random=rand();

						/* Ramdomly Generated*/
						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
						$string = '';
						$max = strlen($characters) - 1;
						 for ($k = 0; $k < strlen($characters); $k++) {
						      $string .= $characters[mt_rand(0, $max)];
						 }
						/* Ramdomly Generated*/

						for($j=0; $j<$ivalCount; $j++) {
							$getAttributeValue = getAttributIdVariationId($generate[$i][$j]);
							
							
							$attrId = $getAttributeValue[0]['attribute_id'];
							$sum = $i+1;
							$num_padded = sprintf("%02d", $sum);
							/*$sku=$productID.'-'.$num_padded;*/
							$likearray=['sku'=>$sku];	
							$whereArray=['product_id'=>$productID];	
						//	$getcombinationResult=getSku('product_variations_relations',$likearray);

							$getcombinationResult=$this->manageproduct_model->existsSku($likearray,$whereArray);


							if(!empty($getcombinationResult)) {
								$relationID=$getcombinationResult[0]->id;
								$updatedata=['flag'=>0];
								$where=['id'=>$relationID];
								$updateFlag=updateData('product_variations_relations',$updatedata,$where);

								$result[] = ['relation_common_id'=>$i+1,
										'product_id'=>$productID,
										'sku'=>$sku.'_'.substr($string, 0, 3),
										'attribute_id'=>$attrId,
										'variation_id'=>$generate[$i][$j],
										'flag'=>1,
										'create_date'=>date('Y-m-d H:i:s'),
										];	
							} else {
								//echo 'else';
								$result[] = ['relation_common_id'=>$i+1,
									'product_id'=>$productID,
									'sku'=>$sku,
									'attribute_id'=>$attrId,
									'variation_id'=>$generate[$i][$j],
									'flag'=>1,
									'create_date'=>date('Y-m-d H:i:s'),
									];	
							}
						}
					}

					/*echo '<pre>';
					print_r($result);
					die;*/
					foreach($result as $combinationResults) {
						$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
					}


					$data['title'] = 'Product | SKU';
					$data['heading'] = "Generate Product Sku"; 
					$data['success_msg'] = 'Product SKU Created successfuly ! ! !';
					$this->load->view('manageProduct/generateProductSku',$data);
					

				/*	$getAllVariation = $this->manageproduct_model->getAttrVariation($productID);
					if(!empty($getAllVariation)) {
						$delVariation = $this->manageproduct_model->delProductVariation($productID);
						foreach($combinationResult as $combinationResults) {
							$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
						}
					} else {
						foreach($combinationResult as $combinationResults) {
							$insertAttrVariation = $this->manageproduct_model->insertAttrVariation($combinationResults);
						}
					}*/
				/********  Product Attributes Variations Here ***********/

			}
			
		} else {
			$data['title'] = 'Product | SKU';
			$data['heading'] = "Generate Product Sku"; 
			$this->load->view('manageProduct/generateProductSku',$data);
		}
	}

	public function getAttrValue() {
		$productId=$this->input->post('product_id');
		$data['productAttrInfo']=$this->manageproduct_model->getProductAttrInfoByID($productId);
		if(!empty($data['productAttrInfo'])) {
			$this->load->view('manageProduct/getAttrValue',$data);
		}
		
	}

	public function checkCode() {
		$code=$this->input->post('code');
		$checkCode=$this->manageproduct_model->checkCode($code);
		if(!empty($checkCode)) {
			echo '1';
		} else {
			echo '0';
		}
	}


	public function productAgeing() {
		global $uInfo;

		/* Used Only For Search */
		$pId = $this->input->post('product_id');
		$type = $this->input->post('type');
		$startQty = $this->input->post('startQty');
		$endQty = $this->input->post('endQty');
		/* Used Only For Search */

		$storeId = $uInfo['store_id'];
		$userId = $uInfo['user_ID'];

		$warehouseWhere = ['user_ID'=>$userId, 'is_central'=>1];

		$getWId = getSku('warehouse',$warehouseWhere);
		if(isset($getWId) && !empty($getWId)) {
			$warehouseId = $getWId[0]['warehouse_id'];
		} else {
			$warehouseId = 0;
		}
		

		if($pId != '' && is_numeric($pId)) {

			$storeId = $this->input->post('store_id');

			if($startQty != '' && $endQty != '') {
				$getWarehouseProduct = getSku('warehouse_inventory', ['warehouse_id'=>$warehouseId,'comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'stock_qty >='=>$startQty, 'stock_qty <='=>$endQty, 'batch_id'=>0]);

				if($storeId != '' && is_numeric($storeId)) {
					$storeWhere = ['store_id'=>$storeId,'comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'stock_qty >='=>$startQty, 'stock_qty <='=>$endQty, 'batch_id'=>0];
				} else {
					$storeWhere = ['comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'stock_qty >='=>$startQty, 'stock_qty <='=>$endQty, 'batch_id'=>0];
				}
				
			} else {
				$getWarehouseProduct = getSku('warehouse_inventory', ['warehouse_id'=>$warehouseId,'comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'batch_id'=>0]);

				if($storeId != '' && is_numeric($storeId)) {
					$storeWhere = ['store_id'=>$storeId, 'comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'batch_id'=>0];
				} else {
					$storeWhere = ['comp_code'=>$uInfo['comp_code'], 'master_product_id'=>$pId, 'batch_id'=>0];
				}
				
			}

		} else {

			$getWarehouseProduct = getSku('warehouse_inventory', ['warehouse_id'=>$warehouseId,'comp_code'=>$uInfo['comp_code'], 'master_product_id !='=>0, 'batch_id'=>0]);

			$storeWhere = ['comp_code'=>$uInfo['comp_code'], 'master_product_id !='=>0, 'batch_id'=>0];
		}

		$data['getWarehouseProductInfo'] = multidimensionArraySort($getWarehouseProduct, 'id', SORT_DESC);
		
		$getStoreProduct = getSku('store_inventory',$storeWhere);

		$data['getStoreProductinfo'] = multidimensionArraySort($getStoreProduct, 'id', SORT_DESC);
	
		$data['product'] = $this->managereports_model->getAllProducts($uInfo['comp_code']);
		$data['store'] = $this->managestore_model->getAllStore($uInfo['comp_code']);

		$data['title'] = 'Product | Ageing';
		$data['heading'] = "View Product Ageing";

		if($pId != '') {

			if($type == 'store') {
				$this->load->view('manageProduct/storePAgeingFilter',$data);
			} 
			if($type == 'warehouse') {
				$this->load->view('manageProduct/warehousePAgeingFilter',$data);
			}
			
		} else {
			$this->load->view('manageProduct/productAgeing',$data);
		}
	}

	/* Product Batches */
		public function viewProductBatch() {
			global $uInfo;
			$data['title'] = 'Product | Batch';
			$data['heading'] = "View Product Batch";

			$data['batchs'] = $this->manageproduct_model->getProductBatch($uInfo['comp_code']);
			$this->load->view('manageProduct/viewProductBatch',$data);
		}

		public function addNewBatch() {
			global $uInfo;
			$data['title'] = 'Product | New Batch';
			$data['heading'] = "Add New Product Batch";

			$productwhere = ['comp_code'=>$uInfo['comp_code']];
			$data['products'] = getValue('product','product_id,product_name',$productwhere);

			if($this->input->post('product_name')) {
				$data = ['product_id'=>$this->input->post('product_name'),
						 'batch_number'=>$this->input->post('batch_number'),
						 'mfg_date'=>$this->input->post('mfg_date'),
						'exp_date'=>$this->input->post('exp_date'),
						'comp_code'=>$uInfo['comp_code']];

				$insert = commonInsert('product_batch',$data);
				if($insert) {
					$this->session->set_flashdata('success_msg', 'Batch Created successfuly ! ! !');
					redirect(base_url().'webadmin/manageproduct/addNewBatch');
				}
			} else {
				$this->load->view('manageProduct/addNewBatch',$data);
			}
			
		}

		public function checkBatchNumber() {
			global $uInfo;
			$batchNumber = $this->input->post('batch_number');
			$productId = $this->input->post('product_id');

			$getBatch = getSku('product_batch', ['product_id'=>$productId, 'batch_number'=>$batchNumber, 'comp_code'=>$uInfo['comp_code']]);
			if(!empty($getBatch)) {
				echo '1';
			} else {
				echo '0';
			}
		}
	/* Product Batches */
}