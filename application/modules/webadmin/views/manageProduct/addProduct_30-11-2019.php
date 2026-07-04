<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style type="text/css">
   .category_cls {
      float: left;
   }
   
   .cut_form_fok_sp .controls {
  display: inline-block;
  margin-left: 16px;
}
.cut_form_fok_sp .control-label {
  display: inline-block;
  float: none;
  vertical-align: middle;
  padding-top: 0;
  margin-bottom: 0;
}
.newcategory {
  color: #438eb9;
  display: inline-block;
  float: none;
  margin-bottom: 0;
  padding-top: 3px;
  text-align: center;
  vertical-align: middle;
  width: 150px;
}
.product_help-inline {
  color: #d16e6c;
  display: inline-block;
  float: right;
}
.phoneNumberClass {
  margin-left: 180px;
}
</style>
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
   <?php //echo validation_errors(); ?>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('product_name') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Product Name</label>
               <div class="controls">
                  <input type="text" id="product_name" name="product_name" value="<?php echo set_value('product_name') ?>" />
                  <span for="product_name" class="product_help-inline product_name"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('product_code') != '') echo 'error'; ?>">
               <label class="control-label" for="product_code">Product Code</label>
               <div class="controls">
                  <input type="text" id="product_code" name="product_code" value="<?php echo set_value('product_code') ?>" />
                  <span for="product_code" class="product_help-inline product_code"> <?php //echo form_error('product_code') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('product_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_category">Product Category</label>
               <div class="controls">
                  <select id="product_category" name="product_category" class="form-control category_cls">
      					<option value="">Select Category</option>
      					<?php 
      					$getProductCategory = getProductCategoryParentNull($uinfo['comp_code']);
      					foreach($getProductCategory as $singlecat)
   						{
   							echo '<option value='.$singlecat["product_cat_id"].'>'.$singlecat["cat_name"].'</option>';
   						}
      					?>
				      </select>
                  <label class="newcategory">Add New Category</label>
                  <span for="product_category" class="product_help-inline product_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_sub_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_category">Sub Category</label>
               <div class="controls">
                  <select id="product_sub_category" name="product_sub_category" class="form-control category_cls">
					<option value="">Select Sub Category</option>
				  </select>
                  
                  <label class="newcategory">Add New Category</label>
                  <span for="product_sub_category" class="product_help-inline product_sub_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
         </div>
			<div class="control-group <?php if(form_error('product_sub_of_sub_category') != '') echo 'error'; ?>">
               <label class="control-label" for="product_sub_of_sub_category">Sub of Sub Category</label>
               <div class="controls">
                  <select id="product_sub_of_sub_category" name="product_sub_of_sub_category" class="form-control category_cls">
					<option value="">Select Sub of Sub Category</option>
				  </select>
                  <label class="newcategory">Add New Category</label>
                  <span for="product_sub_category" class="product_help-inline product_sub_of_sub_category"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
            <!--<div class="control-group <?php if(form_error('attr_value') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Attribute</label>
               <div class="controls productMenu">
                  <?php //$attributs = get_attributes();
                     $attributs = getAttributesByCompCode($uinfo['comp_code']); ?>
                  <ul>
                     <?php foreach($attributs as $attributs){?>
                     <li id="attribute_enter_<?php echo $attributs['attribute_id']; ?>">
                        <input type="checkbox" class="attribute_id" id="attribute_id_<?php echo $attributs['attribute_id']; ?>" name="attribute_id" value="<?php echo $attributs['attribute_id']?>">
                        <span class="lbl labelname__<?php echo $attributs['attribute_id']; ?>"><?php echo $attributs['attribute_name']?></span>
                        
                        <div style="display:none" id="attribute_add_div_<?php echo $attributs['attribute_id']; ?>">
                           <select id="text_<?php echo $attributs['attribute_id']; ?>" class="multipleSelect" multiple name="attr_value[<?php echo $attributs['attribute_id']; ?>][]">
                              <?php 
                                 $get_attribute_values = get_attribute_values($attributs['attribute_id']);
                                 if(!empty($get_attribute_values)) {

                                 foreach($get_attribute_values as $attributes){
                                 ?>
                              <option label="<?php echo $attributes['attribute_value'];?>" data_id="<?php echo $attributes['attribute_value_id'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
                              <?php }  }?>
                           </select>
                           <button type="button" id="<?php echo $attributs['attribute_id']; ?>" class="addnew btn btn-info buttonThemeColor">Add new</button>
                           <span id="error_<?php echo $attributs['attribute_id']; ?>" for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
                        </div>
                     </li>
                     <?php }?>
                  </ul>
                  <span for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
               </div>
            </div>-->
            <div class="control-group <?php if(form_error('product_price') != '') echo 'error'; ?>">
               <label class="control-label" for="product_price">Product Price</label>
               <div class="controls">
                  <input type="text" id="product_price" name="product_price" value="<?php echo set_value('product_price') ?>" /> &#8360;
                  <span for="product_price" class="product_help-inline product_price"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('markup_per') != '') echo 'error'; ?>">
               <label class="control-label" for="markup_per">Markup(%)</label>
               <div class="controls">
                  <input type="text" id="markup_per" name="markup_per" value="<?php echo set_value('markup_per') ?>" />%
                  <span for="markup_per" class="product_help-inline markup_per"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('markup_amt') != '') echo 'error'; ?>">
               <label class="control-label" for="markup_amt">Markup(Amt.)</label>
               <div class="controls">
                  <input type="text" id="markup_amt" name="markup_amt" value="<?php echo set_value('markup_amt') ?>" /> &#8360;
                  <span for="markup_amt" class="product_help-inline markup_amt"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('product_mrp') != '') echo 'error'; ?>">
               <label class="control-label" for="product_mrp">Product MRP</label>
               <div class="controls">
                  <input type="text" id="product_mrp" name="product_mrp" value="<?php echo set_value('product_mrp') ?>" /> &#8360;
                  <span for="product_mrp" class="product_help-inline product_mrp"> <?php //echo form_error('product_name') ?> </span>
               </div>
            </div>

			
            <div class="control-group">
               <label class="control-label" for="product_barcode">Product Barcode</label>
               <div class="controls">
                  <select name="product_barcode_radio" id="product_barcode_radio">
                     <option value="">-Select-</option>
					 <option value="1">System Barcode</option>
					 <option value="2">Product Barcode</option>
			   	  </select>
				  <div id="productBarcodeDiv" style="display:none;">
                  	<input type="text" name="product_barcode_text" id="product_barcode_text" value="" /> 
				  </div>
				  
				  <span for="product_barcode" class="product_help-inline product_barcode"></span>
               </div>
            </div>
			
            <div class="control-group <?php if(form_error('product_image') != '') echo 'error'; ?>">
               <label class="control-label" for="product_image">Product Image</label>
               <div class="controls">
                  <input type="file" id="product_image" name="product_image" value="<?php echo set_value('product_image') ?>" />
                  <span for="name" class="product_help-inline product_image">
                  <?php // echo form_error('product_image') ?>
                  </span>
               </div>
               <div class="phoneNumberClass">   
                     <span style="font-size: 10px;">(e.q. gif, jpg, png, jpeg)</span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('product_description') != '') echo 'error'; ?>">
               <label class="control-label" for="product_description">Product Description</label>
               <div class="controls">
                  <textarea id="product_description" name="product_description"><?php echo set_value('product_description'); ?></textarea>
                  <span for="product_description" class="product_help-inline product_description"> <?php //echo form_error('product_description') ?> </span>
               </div>
            </div>
			<div class="control-group weekly_of_checkbox <?php if(form_error('add_tax') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Add Taxes</label>
               <div class="controls">
                  <select name="product_tax[]" class="add_tax" id="add_tax" multiple>
                     
					<?php 
					$tax = tax_details($uinfo['comp_code']);
					foreach($tax as $tax){ 
					?>
					 <option value="<?php echo $tax['tax_id'];?>"><?php echo $tax['tax_name'];?></option>
                    <?php }?>
                  </select>
                  <span for="add_tax" class="help-inline"> <?php //echo form_error('add_tax') ?> </span>
               </div>
            </div>
			
			
			<div class="control-group ">
               <label class="control-label" for="role">Add GST Rate</label>
               <div class="controls">
                  <select name="gst_rate" class="gst_rate" id="gst_rate">
                     
					 <option value=''>Select GST Rate</option>
                <option value='0'>0%</option>
					 <option value='5'>5%</option>
					 <option value='12'>12%</option>
					 <option value='18'>18%</option>
					 <option value='28'>28%</option>
                    
                  </select>
                  <span for="add_tax" class="help-inline"> <?php echo form_error('add_tax') ?> </span>
               </div>
            </div>
         <div class="control-group ">
               <label class="control-label" for="role">GST Included</label>
               <div class="controls">
                  <select name="gst_inc" class="gst_inc" id="gst_inc">
                     
                
                <option value='1'>Yes</option>
                <option value='0'>No</option>
                
                    
                  </select>
                  <span for="add_tax" class="help-inline"> <?php echo form_error('gst_inc') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('offer_name') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_name">Offer Name</label>
               <div class="controls">
                  <select name="offer_name" id="offer_name">
                     <option value="" >-Select-</option>
					 <?php 
					 $offerDetails = getofferByCompCode($uinfo['comp_code']);
           
					 if(isset($offerDetails) && !empty($offerDetails)){
					 	foreach($offerDetails as $offer){
              
              if(trim($offer->approved_by) !== 0) {
                $currentDate = date('Y-m-d');
                $startDate = $offer->date_duration_start;
                $endDate = $offer->date_duration_end;
                $freeProductName = $offer->free_product;

                $endDate1 = date('Y-m-d', strtotime($endDate));
                $startDate1 = date('Y-m-d', strtotime($currentDate));
                //if((date('Y-m-d', strtotime($endDate))) >= (date('Y-m-d', strtotime($todayDate))))

                if((($endDate1 >= $startDate1) && ($endDate != '')) || ($freeProductName != 'NULL')){

    //if(((date('Y-m-d', strtotime($endDate))) > (date('Y-m-d', strtotime($currentDate)))) || ($endDate == NULL)) {
							//if($startDate<=$currentDate && $currentDate<=$endDate){
					 ?>
					 <option value="<?php echo $offer->offer_id; ?>"><?php echo $offer->offer_name; ?></option>
					 <?php  } }
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
                  <input type="text" id="loyalty_points" name="loyalty_points" value="<?php echo set_value('loyalty_points') ?>" />
                  <span for="loyalty_points" class="loyalty_points_help-inline loyalty_points">  </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('specification') != '') echo 'error'; ?>">
               <label class="control-label" for="specification">Specification</label>
               <div class="controls">
                  <textarea id="specification" name="specification"><?php echo set_value('specification') ?> </textarea>
                  <span for="specification" class="specification_help-inline specification">  </span>
               </div>
            </div>


         <div class="control-group <?php if(form_error('min_stock_qty') != '') echo 'error'; ?>">
            <label class="control-label" for="min_stock_qty">Min Stock Quantity</label>
            <div class="controls">
               <input type="number" id="min_stock_qty" min="10" name="min_stock_qty" value="<?php echo set_value('min_stock_qty') ?>" />
               <span for="min_stock_qty" class="min_stock_help-inline min_stock_qty"> <?php //echo form_error('product_name') ?> </span>
            </div>
         </div>

             
			<div class="control-group <?php if(form_error('remarks') != '') echo 'error'; ?>">
               <label class="control-label" for="remarks">Remarks</label>
               <div class="controls">
                  <textarea id="remarks" name="remarks"><?php echo set_value('specification') ?> </textarea>
                  <span for="remarks" class="remarks_help-inline remarks">  </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit_btn" name="product_submit" value="product_form" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Product
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
   $(document).ready(function(){
   $('#add_tax').multiselect({
   		includeSelectAllOption: true
   	});
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

   $("#product_price").keyup(function(){

      var prd_price =   $("#product_price").val().trim();
      var mamt=0;
      var mrp=0;
      var mper= parseFloat($("#markup_per").val().trim());
      mper=mper ? mper :0;
      var pattern_price = /^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
      if(!pattern_price.test(prd_price)){
         $(".product_price").text("Invalid Product Price.");
         error_count++;
      }    
      else{
         prd_price=parseFloat(prd_price);
         mamt=parseFloat((prd_price*mper)/100);
         mrp=prd_price + mamt;
         $("#product_mrp").val(mrp);
         $("#markup_amt").val(mamt);
         $("#markup_per").val(mper);
         $(".product_price").empty();
      }
            

   });

   $("#markup_per").keyup(function(){

      var mper =   $("#markup_per").val().trim();
      var mamt=0;
      var mrp=0;
      var prd_price= parseFloat($("#product_price").val().trim());
      var pattern_price = /^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;
      if(!pattern_price.test(mper)){
         $(".markup_per").text("Invalid Markup(%).");
         error_count++;
      }    
      else{
         mamt=parseFloat((prd_price*mper)/100);
         mrp=prd_price + mamt;
         $("#product_mrp").val(mrp);
         $("#markup_amt").val(mamt);
         $(".markup_per").empty();
      }
            

   });

   $("#markup_amt").keyup(function(){

      var mamt =   $("#markup_amt").val().trim();
      var mper=0;
      var mrp=0;
      var prd_price= parseFloat($("#product_price").val().trim());

      var pattern_price = /^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;

      if(!pattern_price.test(mamt)){
         $(".markup_amt").text("Invalid Markup(Amt).");
         error_count++;
      }    
      else{   
         mper=parseFloat((100*mamt)/prd_price);
         mrp=prd_price + parseFloat(mamt);
         $("#product_mrp").val(mrp);
         $("#markup_per").val(mper);

         $(".markup_amt").empty();
      }
            

   });

   $("#product_mrp").keyup(function(){

      var mrp =   $("#product_mrp").val().trim();
      var mper=0;
      var mamt=0;
      var prd_price= parseFloat($("#product_price").val().trim());
      var pattern_price = /^(?:0|[1-9]\d*)(?:\.(?!.*000)\d+)?$/;

      if(!pattern_price.test(mrp)){
         $(".product_mrp").text("Invalid Product MRP.");
         error_count++;
      }    
      else{  
         var new_pp=0;
         mrp=parseFloat(mrp); 
         prd_price=parseFloat(prd_price);

         new_pp=mrp-prd_price;
         mper=parseFloat((new_pp/prd_price)*100);
         mamt=mrp-parseFloat(prd_price);
         $("#markup_amt").val(mamt);
         $("#markup_per").val(mper);

         $(".product_mrp").empty();
      }
            

   });
   
   $("#product_barcode_radio").change(function(){
   		var productBarcodeRadio = $( "#product_barcode_radio option:selected" ).val();
		if(productBarcodeRadio==1){
			$("#productBarcodeDiv").show();
			$("#product_barcode_text").val(barCodeUniqueNumber());
		}else if(productBarcodeRadio==2){
			$("#productBarcodeDiv").show();
			$("#product_barcode_text").val("");
		}else{
			$("#productBarcodeDiv").hide();
			$("#product_barcode_text").val("");
		}
   });
   
   function barCodeUniqueNumber(){
       return Math.floor(new Date().valueOf() * Math.random());
   }
   
   
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

   if($("#product_category").val() != '') {
      var url="<?php echo site_url();?>webadmin/manageproduct/get_subcategory";
      var product_cat_id=$("#product_category").val();
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


   if($("#product_sub_category").val() != '') {
      var url="<?php echo site_url();?>webadmin/manageproduct/get_sub_of_sub_category";
      var product_cat_id=$("#product_sub_category").val();
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
   }
   

   
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
   
    /* $("#product_code").keyup(function() {
         var code=$(this).val();
         var url="<?php echo base_url();?>webadmin/manageproduct/checkCode";
         $.ajax({
            type: 'post',
            url: url, 
            data: {'code':code},
            success:function (result) {
               if(result == 1) {
                  $(".product_code").text("Product Code Already Exists.");
                  error_count++;
               } else {
                  $(".product_code").text('');
               }
            }
         })
      });*/

   
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
	

   var product_code = $('#product_code').val();
   var res;

   if(product_code=="") {
      $(".product_code").text("Please Enter Product Code.");
      error_count++;
   } else if(product_code!='') {

      var url="<?php echo base_url();?>webadmin/manageproduct/checkCode";
      $.ajax({
         type: 'post',
         url: url, 
         async:false,
         data: {'code':product_code},
         success:function (result) {
            if(result == 1) {
              $(".product_code").text("Product Code Already Exits.");
              error_count++;
            }
         }
      });
    
   } else {
      $(".product_code").empty();
   }


	
	var product_category =  $('#product_category').val();
   if(product_category=="")
   {
   	//alert("Please enter p name");
   	$(".product_category").text("Please Enter Product Category.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".product_category").empty();
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
   
  /* $(".productMenu input[type=checkbox]").each(function () {
           if (this.checked) {
                attribute_id =  $(this).val();
   	attribute_value =  $(".labelname__"+attribute_id).text();
   	//console.log($(this).val());
                if ($("#attribute_add_div_"+attribute_id+" .fstSelected").length === 0) 
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
   
   var image_name =   $("#product_image").val();
   
/*Commented By :Manoj as discussed with manish ji*/
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
   
   var product_barcode_text = $("#product_barcode_text").val();
  // if(product_barcode_text==""){
   //if (document.getElementById("product_barcode_text").style.display != "none" && document.getElementById("product_barcode_text")!=""){
   if( $('#productBarcodeDiv').is(':visible') ){
   	 if(product_barcode_text==''){	
   		$(".product_barcode").text("Please Enter Barcode.");
   		error_count++;
	 }	
   }else {
   	  if(product_barcode_text==''){	
   	 	$(".product_barcode").empty();
	  }	
   }


   var min_stock_qty = $('#min_stock_qty').val();
   if(min_stock_qty == '') {
      $(".min_stock_qty").text("Please Enter Product description.");
      error_count++;
   } else {
      $(".min_stock_qty").empty();
   }

  
   if(error_count>0) 
   {  
   	//alert("Please Fill All Required Fields");
   	return false;  
   }
   
   });
   	

   $(document).ready(function() {
      $('.newcategory').click(function() {
         var url="<?php echo site_url();?>webadmin/manageproductcategory/addProductCategory?status=1";
         window.location.assign(url);
      });
   });
   
</script>
</body>
</html>