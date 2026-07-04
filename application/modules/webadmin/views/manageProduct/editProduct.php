<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?> 
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <?php //print_r($productInfo);
            ?>
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('product_name') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Product Name</label>
               <div class="controls">
                  <input type="text" id="product_name" name="product_name" value="<?php if(isset($productInfo->product_name) && !empty($productInfo->product_name)){echo $productInfo->product_name;}?>" />
                  <span for="product_name" class="product_help-inline product_name"> </span>
               </div>
            </div>
            <div class="control-group">
               <label class="control-label" for="product_name">Product Code</label>
               <div class="controls">
                  <label><?php if(isset($productInfo->product_code) && !empty($productInfo->product_code)) { echo $productInfo->product_code; } ?></label>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_category">Product Category</label>
               <div class="controls">
                  <select id="product_category" name="product_category" class="form-control">
					<option value="">Select Category</option>
					<?php 
					$getProductCategory = getProductCategoryParentNull($uinfo['comp_code']);
					foreach($getProductCategory as $singlecat)
						{
							$getParentCategory = getParentCategory($productInfo->product_category);
							if($singlecat["product_cat_id"]==$productInfo->product_category){
							echo '<option selected value='.$productInfo->product_category.'>'.$singlecat['cat_name'].'</option>';
							}
							else{
								echo '<option value='.$singlecat["product_cat_id"].'>'.$singlecat["cat_name"].'</option>';
							}
						}
					?>
				  </select>
                  <span for="product_category" class="product_help-inline product_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_sub_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_category">Sub Category</label>
               <div class="controls">
                  <select id="product_sub_category" name="product_sub_category" class="form-control">
					<option value="">Select Sub Category</option>
					<?php
					$getSubCategory = getSubCategory($productInfo->product_category);
					foreach($getSubCategory as $singlesubcat){
					$getParentCategory = getParentCategory($productInfo->product_sub_category);
					if($productInfo->product_sub_category==$singlesubcat["product_cat_id"]){
							echo '<option selected value='.$productInfo->product_sub_category.'>'.$getParentCategory->cat_name.'</option>';
							}
					else{
							echo '<option value='.$singlesubcat["product_cat_id"].'>'.$singlesubcat["cat_name"].'</option>';
						}
					}
					?>
				  </select>
                  <span for="product_sub_category" class="product_help-inline product_sub_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_sub_of_sub_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_sub_of_sub_category">Sub of Sub Category</label>
               <div class="controls">
                  <select id="product_sub_of_sub_category" name="product_sub_of_sub_category" class="form-control">
					<option value="">Select Sub of Sub Category</option>
					<?php
					$getSubCategory = getSubCategory($productInfo->product_sub_category);
					//print_r($getSubCategory);
					foreach($getSubCategory as $singlesubcat){
					$getParentCategory = getParentCategory($productInfo->product_sub_of_sub_category);
					if($productInfo->product_sub_of_sub_category==$singlesubcat["product_cat_id"]){
							echo '<option selected value='.$productInfo->product_sub_category.'>'.$getParentCategory->cat_name.'</option>';
							}
					else{ 
							echo '<option value='.$singlesubcat["product_cat_id"].'>'.$singlesubcat["cat_name"].'</option>';
						}
					}
					?>
				  </select>
                  <span for="product_sub_category" class="product_help-inline product_sub_of_sub_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
            <!--<div class="control-group <?php if(form_error('attr_value') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Attribute</label>
               <div class="controls productMenu">
                  <?php $attributs = getAttributesByCompCode($uinfo['comp_code']);?>
                  <ul>
                     <?php 
                        if(isset($productAttrInfo) && !empty($productAttrInfo)){
						$count_productAttrInfo = count($productAttrInfo);
                        $attr_ids_array = array();
                        foreach($productAttrInfo as $vals) {
                        
                        array_push($attr_ids_array,$vals['attribute_id']);
                        }
                       
						
                        $attribute_id_val_array =  json_decode($productAttrInfo[0]['json_attribute_value']);
						// print_r($attribute_id_val_array);
						}
						
                        foreach($attributs as $attributs){
                        
                        ?>
                     <li id="attribute_enter_<?php echo $attributs['attribute_id']; ?>">
                        <input type="checkbox" class="attribute_id" id="attribute_id_<?php echo $attributs['attribute_id']; ?>" name="attribute_id" value="<?php echo $attributs['attribute_id']?>" <?php 
                           if(isset($attr_ids_array) && !empty($attr_ids_array)){
						   if( in_array( $attributs['attribute_id'],$attr_ids_array)) {
                           echo "checked"; 
                           
                           }
						}
						   ?>  
                           />
                        <span class="lbl labelname__<?php echo $attributs['attribute_id']; ?>"><?php echo $attributs['attribute_name']?></span>
                        <div style="<?php 
						
						if( isset($attr_ids_array) && !empty($attr_ids_array) && in_array( $attributs['attribute_id'],$attr_ids_array)) {  echo "display:block";  } else { echo "display:none"; } 
						?>"  id="attribute_add_div_<?php echo $attributs['attribute_id'];?>">
                           <select id="text_<?php echo $attributs['attribute_id']; ?>" class="multipleSelect" multiple name="attr_value[<?php echo $attributs['attribute_id']; ?>][]">
                              <?php 
                                 $get_attribute_values = get_attribute_values($attributs['attribute_id']);
                                 $attr_id = $attributs['attribute_id'];
                                 foreach($get_attribute_values as $attributes){
								 
								 if(isset($attribute_id_val_array) && !empty($attribute_id_val_array) && in_array( $attributes['attribute_value_id'],$attribute_id_val_array->$attr_id)) {
								 ?>
                              <option selected label="<?php echo $attributes['attribute_value'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
                              <?php }
							  else{
							  ?>
							  <option label="<?php echo $attributes['attribute_value'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
							  <?php }
							  }
							  ?>
                           </select>
                           <button type="button" id="<?php echo $attributs['attribute_id']; ?>" class="addnew btn btn-info buttonThemeColor">Add new</button>
                           <span id="error_<?php echo $attributs['attribute_id']; ?>" for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
                        </div>
                     </li>
                     <?php 
                        }?>
                  </ul>
                  <span for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
               </div>
            </div>-->
            <div class="control-group <?php if(form_error('product_price') != '') echo 'error'; ?>">
               <label class="control-label" for="product_price">Product Price</label>
               <div class="controls">
                  <input type="text" id="product_price" name="product_price" value="<?php if(isset($productInfo->product_price) && !empty($productInfo->product_price)){echo $productInfo->product_price;}?>" /> &#8360;
                  <span for="product_price" class="product_help-inline product_price"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('product_mrp') != '') echo 'error'; ?>">
               <label class="control-label" for="product_mrp">Product MRP</label>
               <div class="controls">
                  <input type="text" id="product_mrp" name="product_mrp" value="<?php if(isset($productInfo->product_mrp) && !empty($productInfo->product_mrp)) { echo $productInfo->product_mrp; } ?>" />
                  <span for="product_mrp" class="product_help-inline product_mrp"></span>
               </div>
            </div>

            <div class="control-group">
               <label class="control-label" for="product_barcode">Product Barcode</label>
               <div class="controls">
                  <select name="product_barcode_radio" id="product_barcode_radio">
                     <option value="">-Select-</option>
                <option value="1" <?php if($productInfo->product_barcode_radio=='1') { echo "selected='selected'"; } ?>>System Barcode</option>
                <option value="2" <?php if($productInfo->product_barcode_radio=='2') { echo "selected='selected'"; } ?>>Product Barcode</option>
                 </select>
              <div id="productBarcodeDiv" style="<?php if($productInfo->product_barcode_radio=='0') {echo 'display:none';}?>">
                     <input type="text" name="product_barcode_text" id="product_barcode_text" value="<?php if(isset($productInfo->product_barcode_text) && !empty($productInfo->product_barcode_text)) { echo $productInfo->product_barcode_text; } ?>" /> 
              </div>
              
              <span for="product_barcode" class="product_help-inline product_barcode"></span>
               </div>
            </div>


            <!--<div class="control-group <?php if(form_error('product_mrp') != '') echo 'error'; ?>">
               <label class="control-label" for="product_mrp">Product Mrp</label>
               <div class="controls">
                  <input type="text" id="product_mrp" name="product_mrp" value="<?php if(isset($productInfo->product_mrp) && !empty($productInfo->product_mrp)){echo $productInfo->product_mrp;}?>" /> &#8360;
                  <span for="product_price" class="product_help-inline product_mrp"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>-->


            <div class="control-group <?php if(form_error('product_image') != '') echo 'error'; ?>">
               <label class="control-label" for="product_image">Product Image</label>
               <div class="controls">
                  <?php 
                     if(isset($productInfo->product_image) && !empty($productInfo->product_image)){
                     ?>
                  <img width="100" height="100" src="<?php echo base_url().'uploads/product_image/thumbs/'.$productInfo->product_image; ?>">
                  <?php 
                     }  
                     ?>
                  <input type="file" id="product_image" name="product_image" value="<?php if(isset($productInfo->product_image) && !empty($productInfo->product_image)){echo $productInfo->product_image;}?>" />
                  <input type="hidden" id="hdn_product_image" name="hdn_product_image" value="<?php if(isset($productInfo->product_image) && !empty($productInfo->product_image)){echo $productInfo->product_image;}?>" />
                  <span for="name" class="product_help-inline product_image">
                  <?php // echo form_error('product_image') ?>
                  </span>
                  <div class="phoneNumberClass">	
                     <span style="font-size: 10px;">(e.q. gif, jpg, png, jpeg)</span>
                  </div>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_description') != '') echo 'error'; ?>">
               <label class="control-label" for="product_description">Product Description</label>
               <div class="controls">
                  <textarea id="product_description" name="product_description"><?php if(isset($productInfo->product_description) && !empty($productInfo->product_description)){echo $productInfo->product_description;}?></textarea>
                  <span for="product_description" class="product_help-inline product_description"> </span>
               </div>
            </div>
			<div class="control-group weekly_of_checkbox <?php if(form_error('add_tax') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Add Taxes</label>
               <?php 
                  $arr_course=explode(",",$productInfo->product_tax);
                  ?>
			   <div class="controls">
                  <select name="product_tax[]" class="add_tax" id="add_tax" multiple>
                     
					<?php 
					$tax = tax_details($uinfo['comp_code']);
					foreach($tax as $tax){ 
					?>
					 <option value="<?php echo $tax['tax_id'];?>" <?php if(isset($productInfo->product_tax) and in_array($tax['tax_id'],$arr_course)) echo "selected='selected'";?>><?php echo $tax['tax_name'];?></option>
                    <?php }?>
                  </select>
                  <span for="add_tax" class="help-inline"> <?php echo form_error('add_tax') ?> </span>
               </div>
            </div>
			
			
			<div class="control-group ">
               <label class="control-label" for="role">Add GST Rate</label>
               <div class="controls">
                  <select name="gst_rate" class="gst_rate" id="gst_rate">
                     
					 <option value=''>Select GST Rate</option>
					 <option value='0' <?php if($productInfo->gst_rate=='0') { echo "selected='selected'"; } ?>>0%</option>
					 <option value='5' <?php if($productInfo->gst_rate=='5') { echo "selected='selected'"; } ?>>5%</option>
					 <option value='12' <?php if($productInfo->gst_rate=='12') { echo "selected='selected'"; } ?>>12%</option>
					 <option value='18' <?php if($productInfo->gst_rate=='18') { echo "selected='selected'"; } ?>>18%</option>
                 <option value='28' <?php if($productInfo->gst_rate=='28') { echo "selected='selected'"; } ?>>28%</option>
                    
                  </select>
                  
               </div>
            </div>

            <div class="control-group ">
               <label class="control-label" for="role">GST Included</label>
               <div class="controls">
                  <select name="gst_inc" class="gst_inc" id="gst_inc">
                     
                
                <option value='1' <?php if($productInfo->gst_inc=='1') { echo "selected='selected'"; } ?>>Yes</option>
                <option value='0' <?php if($productInfo->gst_inc=='0') { echo "selected='selected'"; } ?>>No</option>
                
                    
                  </select>
                  <span for="add_tax" class="help-inline"> <?php echo form_error('gst_inc') ?> </span>
               </div>
            </div>
			
			
			<div class="control-group <?php if(form_error('offer_name') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_name">Offer Name</label>
               <div class="controls">
                  <select name="offer_name" id="offer_name">
                     <option value="" >-Select-</option>
					 <?php /*$aa = getofferByCompCode($uinfo['comp_code']);
                echo '<pre>';print_r($aa);*/

					 //$offerDetails = offerDetails();
                $offerDetails = getofferByCompCode($uinfo['comp_code']);
					 if(isset($offerDetails) && !empty($offerDetails)){
						foreach($offerDetails as $offer){
							$currentDate = date('Y-m-d');
							$startDate = $offer->date_duration_start;
							$endDate = $offer->date_duration_end;
                     $freeProductName = $offer->free_product;
							
							if((($startDate<=$currentDate && $currentDate<=$endDate) && ($endDate != '')) || ($freeProductName != 'NULL')){
					 ?>
					 <option value="<?php echo $offer->offer_id; ?>" <?php if($productInfo->offer_id==$offer->offer_id){ echo 'selected=selected'; } ?>><?php echo $offer->offer_name; ?></option>
					 <?php  } //end if
						} // end foreach
					 } // end if
					 ?>
				  </select>
                  <span for="offer_name" class="help-inline"> <?php echo form_error('offer_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('loyalty_points') != '') echo 'error'; ?>">
               <label class="control-label" for="loyalty_points">Loyalty Points</label>
               <div class="controls">
                  <input type="text" id="loyalty_points" name="loyalty_points" value="<?php if(isset($productInfo->loyalty_points) && !empty($productInfo->loyalty_points)){echo $productInfo->loyalty_points;}?>" />
                  <span for="loyalty_points" class="loyalty_points_help-inline loyalty_points">  </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('specification') != '') echo 'error'; ?>">
               <label class="control-label" for="specification">Specification</label>
               <div class="controls">
                  <textarea id="specification" name="specification"><?php if(isset($productInfo->specification) && !empty($productInfo->specification)){echo $productInfo->specification;}?></textarea>
                  <span for="specification" class="specification_help-inline specification">  </span>
               </div>
            </div>


         <div class="control-group <?php if(form_error('min_stock_qty') != '') echo 'error'; ?>">
            <label class="control-label" for="min_stock_qty">Min Stock Quantity</label>
            <div class="controls">
               <input type="number" id="min_stock_qty" min="10" name="min_stock_qty" value="<?php if(isset($productInfo->min_stock_qty) && !empty($productInfo->min_stock_qty)){echo $productInfo->min_stock_qty;}?>" />
               <span for="min_stock_qty" class="min_stock_help-inline min_stock_qty"> <?php //echo form_error('product_name') ?> </span>
            </div>
         </div>


			<div class="control-group <?php if(form_error('remarks') != '') echo 'error'; ?>">
               <label class="control-label" for="remarks">Remarks</label>
               <div class="controls">
                  <textarea id="remarks" name="remarks"><?php if(isset($productInfo->remarks) && !empty($productInfo->remarks)){echo $productInfo->remarks;}?></textarea>
                  <span for="remarks" class="remarks_help-inline remarks">  </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit_btn" name="product_submit" value="product_form" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update Product
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#add_tax').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
<!--multiselect scripts related to this page-->
<!--autocomplete scripts related to this page-->
<script src="<?php echo base_url();?>/assets/js/fastselect.standalone.js"></script>
<script>
   $('.multipleSelect').fastselect();
</script>
<!--autocomplete scripts related to this page-->
<script>
   $(document).ready(function(){
   
   	/*$( ".attribute_id" ).on('click',function() { 
   	  var h3_id = $(this).attr("id").split('attribute_id_');
   	  //alert(h3_id[1]);
   	  $( "#attribute_add_div_"+h3_id[1] ).toggle();
   	  $( "#error_"+h3_id[1] ).empty();
   	});
   	
   	function uniqId() {
   	  return Math.round(new Date().getTime() + (Math.random() * 100));
   	}
   	
   	$( ".addnew" ).click(function() {
   		var attrValue = prompt("Enter a name for the new attribute value:", "");
   		
   		var attr_id = $(this).attr("id");
   		if (attrValue != null && attrValue.length>0) {
   			//$("#text_"+attr_id).val(person);
   			var url="<?php echo site_url();?>webadmin/manageproduct/addAttrValue";
   				$.ajax({
   				url: url,
   				type:'POST',
   				data:"attribute_value="+attrValue+"&attribute_id="+attr_id+"&prodcut_id="+uniqId(),
   				success: function(data){
   				
   					//alert(data);
   					
   					$('#attribute_add_div_'+attr_id).html(data); 
   				}
   				});
   				
   		}
   		else{
   			alert("Please enter value");
   		}
   		
   	});*/
   	
   });
   
   $( "#product_category" ).change(function(){
		var product_cat_id = $( "#product_category option:selected" ).val();
		var url="<?php echo site_url();?>webadmin/manageproduct/get_subcategory";
   				if(product_cat_id){
					$.ajax({
					url: url,
					type:'POST',
					async:false,
					data:"product_cat_id="+product_cat_id,
					success: function(data){
						$('#product_sub_category').html(data);
						$('#product_sub_of_sub_category').html("<option value=''>Select Sub of Sub Category</option>");
						}					
						
					});
				}
				else{
					$('#product_sub_category').html("<option value=''>Select Sub Category</option>");
					$('#product_sub_of_sub_category').html("<option value=''>Select Sub of Sub Category</option>");
				}
   });
   
   $( "#product_sub_category" ).change(function(){   
		var product_cat_id = $( "#product_sub_category option:selected" ).val();
		var url="<?php echo site_url();?>webadmin/manageproduct/get_sub_of_sub_category";
   				$.ajax({
   				url: url,
   				type:'POST',
   				data:"product_cat_id="+product_cat_id,
   				success: function(data){
					$('#product_sub_of_sub_category').html(data);
					if(product_cat_id=="")
						{
							$('#product_sub_of_sub_category').html("<option value=''>Select Sub of Sub Category</option>");
						}
					}
   				});
   });


   $("#product_barcode_radio").change(function(){
         var productBarcodeRadio = $( "#product_barcode_radio option:selected" ).val();

         var selectedBarcodeRadio = '<?php if(($productInfo->product_barcode_radio != 0) && ($productInfo->product_barcode_radio==1)) { echo "sytemcode"; }else{echo "productcode";} ?>';
         
      if(productBarcodeRadio==1){
         $("#productBarcodeDiv").show();
         if(selectedBarcodeRadio == "productcode")
         {
            $("#product_barcode_text").val(barCodeUniqueNumber());
         }
         else{
            $("#product_barcode_text").val('<?php if(isset($productInfo->product_barcode_text) && !empty($productInfo->product_barcode_text)) { echo $productInfo->product_barcode_text; } ?>');
         }
      }else if(productBarcodeRadio==2){
         $("#productBarcodeDiv").show();
         $("#product_barcode_text").val('<?php if(($productInfo->product_barcode_radio == 2) && !empty($productInfo->product_barcode_text)) { echo $productInfo->product_barcode_text; } ?>');
      }else{
         $("#productBarcodeDiv").hide();
         $("#product_barcode_text").val("");
      }
   });

   function barCodeUniqueNumber(){
       return Math.floor(new Date().valueOf() * Math.random());
   }
   
   
   
   //form validation
   $( ".submit_btn" ).on("click",function() { 
   var error_count = 0;		
   
   var product_name =  $('#product_name').val();
   if(product_name=="")
   {
   	//alert("Please enter p name");
   	$(".product_name").text("Please Enter Product Name.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".product_name").empty();
   	}
   
   var product_description =  $("#product_description").val();
   if(product_description=="")
   {
   	//alert("Please enter p description");
   	$(".product_description").text("Please Enter Product description.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".product_description").empty();
   	}
   
   /*$(".productMenu input[type=checkbox]").each(function () {
           if (this.checked) {
                attribute_id =  $(this).val();
   	attribute_value =  $(".labelname__"+attribute_id).text();
   	//console.log($(this).val());
                if ($("#attribute_add_div_"+attribute_id+" select :selected").length === 0) 
   	{ 
   	//alert(attribute_id);
   	$( "#error_"+attribute_id ).text( "Please Enter "+attribute_value+" Value." );
   	error_count++;
   	// show message 
   	}  
   	else {
   	 // hide message
   	 $( "#error_"+attribute_id ).empty();
   	}
   
           }
     
    
   });*/
   
   var image_name =   $("#hdn_product_image").val();
 
 /*Commented by Manoj*/ 
/*
   if(image_name=='') {  // show message 
   //alert("Please enter p image_name");
   $(".product_image").text("Please Enter Product Image.");
   error_count++;
   }    
   else {   
   	// hide message
   	$(".product_image").empty();
   	
   }
*/
   var price =   $("#product_price").val();
   var pattern_price = /^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
   if(price=='') {  // show message 
   //alert("Please enter p image_name");
   $(".product_price").text("Please Enter Product Price.");
   error_count++;
   }
   else if(!pattern_price.test(price)){
      $(".product_price").text("Currency is not in valid format.");
      error_count++;

   }    
   else {   
      // hide message
      $(".product_price").empty();
      
   }
   
   	
   if(error_count>0) 
   {  
   	//alert("Please Fill All Required Fields");
   	return false;  
   }
   
   });
   	
   
   
</script>
</body>
</html>