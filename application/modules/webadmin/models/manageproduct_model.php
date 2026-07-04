<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Manageproduct_model extends CI_Model {

		function __construct(){
		
			parent::__construct();
			$this->load->library('email');
			global $uInfo;
			$uInfo=$this->session->userdata('webadmin_session_info');
		}
		
		
		public function add_productAttr($data)
		{
			$this->db->insert('product_attribute',$data);
			$product_ID=$this->db->insert_id();
		}
		
		public function delete_exist_productAttr($productID)
		{
			$this->db->where('product_id',$productID);
			$this->db->delete('product_attribute');
		}
		
		public function product_Insert($data)
		{
			$this->db->insert('product',$data);
			$product_ID=$this->db->insert_id();
		}
		
		public function getWarehouseIsCentral(){
			global $uInfo;

			$this->db->select('warehouse_id');
			$this->db->from('warehouse');
			$this->db->where(array('is_central' => '1','comp_code'=>$uInfo['comp_code']));
			$query = $this->db->get();
			if($query->num_rows() > 0){
				return $query->row();
			}else{
				return false;
			}
		}
		
		public function warehouseInventory_Insert($last_inserted_id, $warehouse_id)
		{
			global $uInfo;
			$data = array(
				'product_id' => $last_inserted_id,
				'warehouse_id' => $warehouse_id,
				'stock_qty' => '0',
				'modify_date' => date("Y-m-d h:i:s"),
				'comp_code' => $uInfo['comp_code']
			);
			$this->db->insert('warehouse_inventory',$data);
		}
		
		public function product_update($productID,$data)
		{
			$this->db->where('product_id',$productID);
			$this->db->update('product',$data);
		}

	  public function getAllProduct($comp_code){
			$this->db->select('*');
			$this->db->where(array('comp_code'=>$comp_code));
			$this->db->from('product');
			$query = $this->db->get();
			return $query->result();
	  }
	  public function getProductInfoByID($productID){
		$query = $this->db->get_where('product', array('product_id' => $productID));
			if($query->num_rows() > 0)
				return $query->row();
			else
				return FALSE;
	  }
	  
	  public function getProductAttrInfoByID($productID){
		$query = $this->db->get_where('product_attribute', array('product_id' => $productID));
			if($query->num_rows() > 0) 
				return $query->result_array();
			else
				return FALSE;
	  } 
	  
	  public function updateDepartment($productID,$data){
		$this->db->where('product_id',$productID);
		$this->db->update('product',$data);
	  }
	 
	 public function deleteProduct($productID){
		$this->db->where('product_id', $productID);
		$this->db->delete('product');
	 }
	 public function deleteProductAttr($productID)
	 {
		$query = $this->db->get_where('product_attribute', array('product_id' => $productID));
			if($query->num_rows() > 0)
				{
				$this->db->where('product_id', $productID);
				$this->db->delete('product_attribute');
				}
			else
				return FALSE;
		
		$this->db->where('product_id', $productID);
		$this->db->delete('product');
	 }
	 
	 //Status ChangeFor User Status
	 public function changeProductStatus($productID,$data){
		$this->db->where('product_id',$productID);
		$this->db->update('product',$data);
		//echo $this->db->last_query();
	 }
	 
	 public function deleteExistAttrValue($attributeID,$attribute_value){
		$this->db->where('attribute_id', $attributeID);
		$this->db->where('attribute_value', $attribute_value);
		$this->db->delete('attribute_value');
	 }



	public function addAttributeValue($attributeID, $data) {
		$this->db->insert('attribute_value',$data);
		$attribute_value_ID=$this->db->insert_id();
		return $attribute_value_ID;
	}


	 
	 //Add attribute values
	 public function addAttrValue($attributeID,$selected_value,$data,$attribute_value){
	 	$checkexits = ['attribute_id'=>$attributeID, 'attribute_value'=>trim($attribute_value)];
	 	$getAttribute = getSku('attribute_value', $checkexits);
	 	if(empty($getAttribute)) {
	 		$this->db->insert('attribute_value',$data);
			$attribute_value_ID=$this->db->insert_id();
	 	} else {
	 		$attribute_value_ID = $getAttribute[0]['attribute_value_id'];
	 	}
		

		$a = getSku('attribute_value', ['attribute_value_id'=>$attribute_value_ID]);
		$val = $a[0]['attribute_value'];


		if($selected_value != '') {
			$selected_value = rtrim($selected_value, ',');
			$already_selected_text = explode(",",$selected_value);
			array_push($already_selected_text, $val);
		} else {
			$already_selected_text[] = $val;
		}


		$already_selected_text = array_unique($already_selected_text);
		

		$count_already_selected_text = count($already_selected_text);
		

		$i=0;
		$get_attribute_values = get_Allattribute_values($attributeID);

		$attrValues=[];
		foreach($get_attribute_values as $attributes){
			$attrId = $attributes['attribute_value_id'];
			$attrValues[$attrId]=trim($attributes['attribute_value']);
		}
		
		$results=array_diff($attrValues,$already_selected_text);



		$response = '<select id="text_'.$attributeID.'" class="multipleSelect1" multiple name="attr_value['.$attributeID.'][]">';

		if(!empty($get_attribute_values) && isset($get_attribute_values)) {

				for($j=0; $j<count($already_selected_text);$j++) {

					if(in_array($already_selected_text[$j],$attrValues)) {

						$key = array_search($already_selected_text[$j], $attrValues);

						$response .= '<option selected="selected"  value="'.$key.'">'.$already_selected_text[$j].'</option>';
					}
				}


				foreach($results as $attrId=>$result) {
					$response .= '<option value="'.$attrId.'">'.$result.'</option>';	 
				}
				
		
				/*foreach($get_attribute_values as $attributes){

					if(!empty($attributes) && isset($attributes)) {

						echo $count_already_selected_text[$i] .'=='. $attributes['attribute_value'].'</br>';

						if($attribute_value_ID == $attributes['attribute_value_id']) {
								
								echo 'if1'.'</br>';
							if($i<$count_already_selected_text) {
								$response .= '<option selected="selected"  value="'.$attributes['attribute_value'].'">'.$attributes['attribute_value'].'</option>';
								$i++;
							}
							

						} elseif($count_already_selected_text[$i] == $attributes['attribute_value']) {

							echo 'if2'.'</br>';
							$response .= '<option selected="selected"  value="'.$attributes['attribute_value'].'">'.$attributes['attribute_value'].'</option>';
						} else {
							
							echo 'else'.'</br>';
							$response .= '<option  value="'.$attributes['attribute_value'].'">'.$attributes['attribute_value'].'</option>';	 
						}
			}
		}*/

	}
		$response .=	'</select>
						<button type="button" id="'.$attributeID.'" class="addnew1 btn btn-info buttonThemeColor">Add new</button>
						<span id="error_'.$attributeID.'" for="attr_value" class="help-inline attribute_value"></span>
			<script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>
			<script src="'.base_url().'/assets/js/fastselect.standalone.js"></script>
			
			<script>
				$("#attribute_enter_'.$attributeID.' .multipleSelect1").fastselect();
				
				function uniqId() {
				  return Math.round(new Date().getTime() + (Math.random() * 100));
				}
				
				
				$( ".addnew1" ).click(function() {
					var attrValue = prompt("Enter a name for the new attribute value:", "");
					var attr_id = $(this).attr("id");
					
					var current = "";
					$( "#text_"+attr_id+" option:selected" ).each(function() {
					  current += $( this ).text() + ",";
					});

					
					var current = current+attrValue;

					if (attrValue != null && attrValue.length>0) {

						
						var url="'.site_url().'webadmin/manageproduct/addAttrValue";
							$.ajax({
							url: url,
							type:"POST",
							data:"attribute_value="+attrValue+"&attribute_id="+attr_id+"&prodcut_id="+uniqId()+"&selected_value="+current,
							success: function(data){
									
								
								$("#attribute_add_div_"+attr_id).html(data);
							}
							});
					}
					else{
						alert("Please enter value");
					}
					
				});
				
				
				//form validation
				$( ".submit_btn" ).on("click",function() { 
				var error_count = 0;	

				
				$("input[type=checkbox]").each(function () {
				   if (this.checked) {
						attribute_id =  $(this).val();
						attribute_value =  $(".labelname__"+attribute_id).text();
						
						if ($("#attribute_add_div_"+attribute_id+" option:selected").length === 0) 
						{ 
						
						$( "#error_"+attribute_id ).text( "Please Enter "+attribute_value+" Value." );
						error_count++;
						
						}  
						else {
						 
						 $( "#error_"+attribute_id ).empty();
						}

				   }
				   
				  
				});
				
				
					
			});
						
			
			</script>';
		echo $response;
	 }

	public function getProductById($productID) {
		$this->db->select('*');
		$this->db->where(array('product_id'=>$productID));
		$this->db->from('product');
		$query = $this->db->get();
		return $query->result();
	}

	public function insertAttrVariation($res) {
		$this->db->insert('product_variations_relations',$res);
		$product_ID=$this->db->insert_id();

		/*$this->db->insert_batch('product_variations_relations', $res);
		$product_ID=$this->db->insert_id();*/
	}

	public function getAttrVariation($productID) {
		$this->db->select('*');
		$this->db->where(array('product_id'=>$productID));
		$this->db->from('product_variations_relations');
		$query = $this->db->get();
		return $query->result();
	}

	public function delProductVariation($productID) {
		$this->db->delete('product_variations_relations', array('product_id' => $productID));
	}

	public function existsSku($likearray,$wherearray) {
		$this->db->select('*');
		$this->db->from('product_variations_relations');
		$this->db->where($wherearray);
		$this->db->like($likearray);
		$query = $this->db->get();
		return $query->result();
	}

	public function checkCode($code) {
		$this->db->select('*');
		$this->db->from('product');
		//$this->db->where('product_code',$code);
		$this->db->like('product_code',$code);
		$query = $this->db->get();
		//echo $this->db->last_query();
		return $query->result();
	}


	public function checkAttributeValue($attributeID, $attributeValue) {
		$this->db->select('attribute_value_id');
		$this->db->from('attribute_value');
		$this->db->where('attribute_id',$attributeID);
		$this->db->like('attribute_value',$attributeValue);
		$query = $this->db->get();
		return $query->result();
	}


	public function getProductBatch($compCode) {
		$this->db->select('a.batch_number, a.mfg_date, a.exp_date, b.product_name');
		$this->db->from('product_batch as a');
		$this->db->join('product as b', 'b.product_id = a.product_id');
		$this->db->where('a.comp_code',$compCode);
		$query = $this->db->get();
		return $query->result();
	}


	public function getProductSkuByBatch($productID,$batchID,$warehouseId,$compCode) {
		$this->db->select('price, product_id as sku');
		/*$this->db->where(array('master_product_id'=>$productID, 'batch_id'=>$batchID, 'comp_code'=>$compCode));
		$this->db->from('vendor_to_wh_product');*/
		$this->db->where(array('master_product_id'=>$productID, 'warehouse_id'=>$warehouseId,'batch_id'=>$batchID, 'comp_code'=>$compCode));
		$this->db->from('warehouse_inventory');
		$query = $this->db->get();
		return $query->result();
	}

}