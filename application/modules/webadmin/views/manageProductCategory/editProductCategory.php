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
         <?php //print_r($productCatInfo);
            ?>
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('parent_category') != '') echo 'error'; ?>">
               <label class="control-label" for="parent_category">Parent Category</label>
               <div class="controls">
                  <select name="cat_parent_id" class="cat_parent_id" id="cat_parent_id">
                    <option value="">Select Parent Category</option>
					<?php 
					$parent_cat_name = getParentCategory($productCatInfo->cat_parent_id);
				    $getProductCategory = getProductCategory($uinfo['comp_code']);
					
				    foreach($getProductCategory as $singlecat){
				
				      if($singlecat["cat_parent_id"]==0){ 
					?>
						<option class="optionGroup" value="<?php echo $singlecat["product_cat_id"]; ?>" <?php if(isset($parent_cat_name) && !empty($parent_cat_name)){ if( ($singlecat["product_cat_id"]==$parent_cat_name->product_cat_id) ){ echo 'selected="selected"'; } } ?>><?php echo $singlecat["cat_name"]; ?></option>  
					<?php
						 $getSubCategory = getSubCategory($singlecat["product_cat_id"]);
						 foreach($getSubCategory as $singleSubcat){
						 ?>
					 		<option class="optionChild" value="<?php echo $singleSubcat["product_cat_id"]; ?>" <?php if(isset($parent_cat_name) && !empty($parent_cat_name)){ if( ($singleSubcat["product_cat_id"]==$parent_cat_name->product_cat_id) && ($singleSubcat["cat_parent_id"]==$parent_cat_name->cat_parent_id) ){ echo 'selected="selected"'; } } ?>><?php echo $singleSubcat["cat_name"]; ?></option> 
					   <?php 
					     } // end foreach
				       } // end if
				    } // end foreach
					?> 
                  </select>
                  <span for="parent_category" class="help-inline"> <?php echo form_error('parent_category') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('cat_name') != '') echo 'error'; ?>">
               <label class="control-label" for="cat_name">Category Name</label>
               <div class="controls">
                  <input type="text" id="cat_name" name="cat_name" value="<?php if(isset($productCatInfo->cat_name) && !empty($productCatInfo->cat_name)){echo $productCatInfo->cat_name;}?>" />
				  <input type="hidden" id="hdn_cat_name" name="hdn_cat_name" value="<?php if(isset($productCatInfo->cat_name) && !empty($productCatInfo->cat_name)){echo $productCatInfo->cat_name;}?>" />
             <span for="cat_name" class="help-inline"> <?php echo form_error('cat_name') ?> </span>
               </div>
            </div>
			
			
			 <div class="control-group royalty_point" >
               <label class="control-label" for="royalty_point">1 Point Price </label>
               <div class="controls">
                  <input type="text" id="royalty_point" name="royalty_point" value="<?php if(isset($productCatInfo->royalty_point_price) && !empty($productCatInfo->royalty_point_price)){echo $productCatInfo->royalty_point_price;}?>" />
				  <br /><span for="category_name" class="help-inline"> <?php echo form_error('category_name') ?> Example: 1 point = 500Rs on product of this category.</span>
                  
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
<!--autocomplete scripts related to this page-->
<script src="<?php echo base_url();?>/assets/js/fastselect.standalone.js"></script>
<script>
   $('.multipleSelect').fastselect();
</script>
<!--autocomplete scripts related to this page-->
<script>
   $(document).ready(function(){
   
   	$( ".attribute_id" ).on('click',function() { 
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
   		
   	});
   	
   });
   
   
   
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
   
   $("input[type=checkbox]").each(function () {
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
     
    
   });
   
   var image_name =   $("#hdn_product_image").val();
   if(image_name=='') {  // show message 
   //alert("Please enter p image_name");
   $(".product_image").text("Please Enter Product Image.");
   error_count++;
   }    
   else {   
   	// hide message
   	$(".product_image").empty();
   	
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