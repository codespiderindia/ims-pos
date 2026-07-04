<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

<style>
   /*.transfermenu{
   margin-top:50px;
   }*/
   .transfermenu ul{
	   list-style:none;
	   margin-left:0px!important;
	   margin-top: 10px;
	   width: 100%;
	   display: inline-block;
   }
   .transfermenu ul ul {
   		margin-top: 0;
   }
   .transfermenu ul ul ul {
   		margin: 5px 0 0;
   }
   .transfermenu ul li {
	   border: 1px solid #ccc;
	   display: none;
	   float: left;
	   margin-bottom: 10px;
	   margin-right: 10px;
	   padding: 10px;
	   width: calc(100% - 20px);
	   position:relative;
	   max-height: 300px;
	   overflow: auto;
   }
   .transfermenu ul li ul li {
		border: 1px solid #cccccc;
		display: inline-block;
		margin-left: 0;
		margin-right: 0;
		margin-top: 0;
		padding: 12px;
		width: 30%;
		overflow: inherit;
		vertical-align: top;
		min-height: 160px;
	}
	.transfermenu ul li ul li span input {
	    width: calc(100% - 15px);
	    font-size: 12px;
	}
	.transfermenu ul li ul li ul li {
		width: auto;
		padding: 0;
		border: none;
		margin: 0;
		display: block;
	}
	.transfermenu ul li ul li label {
		font-size: 13px;
    	margin: 0 0 0 22px;
	}
   /*.transfermenu ul li:hover ul{
   display:block;
   }*/
   .transfermenu ul li ul li{
   float:none;
   }
   .transfermenu input{
   opacity:1;
   }
   .product_in_warehouse{
   height:25px!important;
   width:15px!important;
   }
   .product_list .checkbox >input{
   opacity:1!important;
   }
   .product_lbl{
   font-weight:bold;
   font-size: 16px;
   }
   .quantity_input{
   width:auto;
   }
   .stock-help-inline{
   position:absolute;
   /*left:20%;*/
   color:red;
   line-height: normal;
   }
   .help-inline{
   color:red;
   }
   .form-horizontal .controls {
    display: inline-block;
    margin-left: 20px;
    width: calc(100% - 200px);
	}
	.controls .help-inline {
		display: block;
		width: auto;
	}
	.transfermenu ul li ul li ul li div.dv-in {
	    display: block;
	    /*width: 49%;*/
	    margin: 0 0 18px;
	    font-size: 12px;
	    vertical-align: top;
	    position: relative;
	}
	.transfermenu ul li ul li ul li .pr-ba {
		margin: 5px 0 0;
		display: inline-block;
	}
</style>


<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
	  
	  <?php
         if ($this->session->flashdata('error_msg')):
         ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php
            echo $this->session->flashdata('error_msg');
            ?> <br />
      </div>
      <?php
         endif;
         ?>
      <?php
         if ($this->session->flashdata('success_msg')):
         ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php
            echo $this->session->flashdata('success_msg');
            ?> </p>
      </div>
      <?php
         endif;
         ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post">
         	<?php 
         		$getWarehouseIsCentral = getWarehouseIsCentral($uinfo['comp_code']); 
         		if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
					$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
				} else {
					$warehouse_is_central_id = 0;
				}
         	?>
         	<input type="hidden" name="warehouseId" class="warehouseId" id="warehouseId" value="<?php echo $warehouse_is_central_id; ?>" />
         	<span for="warehouse_id" class="help-inline warehouseId_error"> <?php echo form_error('warehouse_id') ?> </span>


			<div class="control-group <?php if(form_error('vendor_name') != '') echo 'error'; ?>">
               <label class="control-label" for="vendor_name">Vendor Name</label>
               <div class="controls">
                  <select name="vendor_name" class="vendor_name" id="vendor_name">
                     <option value="">Select Vendor</option>
					 <?php 
					 $vendor_details = vendor_details($uinfo['comp_code']);
					 if(isset($vendor_details) && !empty($vendor_details)){
					 	foreach($vendor_details as $val){
					 ?>
					 <option value="<?php echo $val['vendor_id']; ?>"><?php echo ucfirst($val['f_name']).' '.ucfirst($val['l_name']); ?></option>
					 <?php 
					 	}
					 }
					 ?>
                  </select>
                  <span for="vendor_name" class="help-inline vendor_name_error"> <?php echo form_error('vendor_name') ?> </span>
               </div>
            </div>
			
			<div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
			   <label class="control-label" for="role">Product Has Vendor</label>
			   <div class="controls product_select">
				  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
					 <?php 				
					 $productIdName = productIdName($uinfo['comp_code']);
					 if(isset($productIdName) && !empty($productIdName)){
						 foreach($productIdName as $productIdName1){ 
					 ?>
					 <option value="<?php echo $productIdName1->product_id; ?>"><?php echo $productIdName1->product_name; ?></option>
					 <?php 
					 	} // end foreach
					 } else{ ?>
					 <option value="">Product Not Available</option>
					 <?php }?>
				  </select>
				  <a href="<?php echo site_url().'webadmin/manageproduct/vendorToWhAddProduct'; ?>">Add Product</a>
				  <span for="country" class="help-inline product_list_error"> </span>
				<div class="transfermenu"> 
                     <ul>
                     	<span for="product_variation" class="help-inline product_variation_error"> </span>
						 <?php 				
						 $productIdName = productIdName($uinfo['comp_code']);
						 if(isset($productIdName) && !empty($productIdName)){
							 foreach($productIdName as $productIdName1){ 
							 	$pId = $productIdName1->product_id;
						 ?>
						<li id="li_<?php echo $productIdName1->product_id; ?>">
                           <input type="hidden" value="<?php echo $productIdName1->product_id;?>" name="product_in_warehouse[]" class="product_in_warehouse" id="product_in_warehouse_<?php echo $productIdName1->product_id; ?>">
						   <p class="product_lbl"><?php echo $productIdName1->product_name;?></p>
						    <!--<label>Select Batch</label>
						    <select name="batches[<?php echo $pId; ?>]" class="batches" id="batches_<?php echo $pId; ?>" attrPid="<?php echo $pId; ?>">
						    	<?php $batchs = getProductBatchs($productIdName1->product_id, $uinfo['comp_code']);
						    	foreach($batchs as $batch) { ?>
						    		<option value="<?php echo $batch['product_batch_id']; ?>"><?php echo $batch['batch_number']; ?></option>
						    	<?php } ?>
						    </select>-->
						   <?php $productVariation=getProductVariation($productIdName1->product_id);   ?>

								<ul id="quantity_<?php echo $productIdName1->product_id; ?>">
								   		<?php 
								   		 foreach($productVariation as $productVariations) {
								   		 	$arrayVariationId=explode(',',$productVariations['variation_ids']);
								   			$variationName=getAllVariationNames($arrayVariationId);
								   			//echo $productVariations['variation_ids'];
								   			$allVariationName=[];
								   			foreach($variationName as $variationNames) {
								   				$allVariationName[]=$variationNames['attribute_value'];
								   			}

								   			$mergeVariationName=implode(', ',$allVariationName); 
								   		 ?>
								   		<li>
								   			<input type="checkbox" name="variationCheckbox[]" class="variationCheckbox" value="<?php echo $productVariations['sku']; ?>" attrProductId="<?php echo $productIdName1->product_id; ?>" attrVariationRelation="<?php echo $productVariations['id']; ?>">


								   			<input type="hidden" name="pid_attr[<?php echo $productVariations['sku']; ?>]" value="<?php echo $productIdName1->product_id; ?>" />


								   			<label>Variation: <?php echo $mergeVariationName; ?></label>
								   			<label>SKU: <?php echo $productVariations['sku']; ?></label>
								   	<ul>
									  <li>
									  	<div class="dv-in">
										<span>Quantity</span>
										<span class="qty_keypress">
										<input class="quantity_input quantity_keypress" id="quantity_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="quantity[<?php echo $productVariations['sku']; ?>]" value="" />
										</span>
										<span for="name" class="stock-help-inline quantity_val_error_<?php echo $productVariations['sku'];?>">  </span>
										</div>


										<div class="dv-in">
										<span>Price</span>
										<span class="price_keypress">
										<input class="price_input price_keypress price_<?php echo $pId; ?>" id="price_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="price[<?php echo $productVariations['sku']; ?>]" value="" />
										</span>
										<span for="name" class="stock-help-inline price_val_error_<?php echo $productVariations['sku'];?>">  </span>
										</div>


										<div class="dv-in">
										<span>Expiry Date</span>
										<span class="expiry_date">
										<input class="quantity_input expiry_<?php echo $productVariations['sku']; ?>" type="date" id="expiry_date_<?php echo $productVariations['sku']; ?>" name="expiry_date[<?php echo $productVariations['sku']; ?>]" value="" />
										</span> 
										<span for="name" class="stock-help-inline expiry_date_error_<?php echo $productVariations['sku'];?>">  </span>
									  </div>
									  <span class="pr-ba"> 
					<?php  $code =  "P ".$productVariations['sku']."45784";?>
									  <a href="<?php echo base_url(); ?>barcode/sample-gd.php?code=<?php echo base64_encode($code); ?>" target="_blank">Print Barcode</a> </span>
									  </li>
									  
								    </ul>
						   		</li>
						   		<?php }
						   		?>
						   </ul>
						  
						</li>						
						<?php } // end foreach
						 } // end if condition 
						?>
					</ul>
				  </div>
			   </div>
			</div>
			<div class="control-group <?php if(form_error('invoice_total_amount') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_total_amount">Invoice Total Amount</label>
               <div class="controls">
                  <input type="number" required="required" id="invoice_total_amount" name="invoice_total_amount" value="<?php echo set_value('invoice_total_amount') ?>" />
                  <span for="invoice_total_amount" class="help-inline invoice_total_amount"> <?php echo form_error('invoice_total_amount') ?> </span>
               </div>
            </div>			<div class="control-group <?php if(form_error('invoice_number') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_number">Invoice Number</label>
               <div class="controls">
                  <input type="text" id="invoice_number" name="invoice_number" value="<?php echo set_value('invoice_number') ?>" />
                  <span for="invoice_number" class="help-inline invoice_number"> <?php echo form_error('invoice_number') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('invoice_date') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_date">Invoice Date</label>
               <div class="controls">
                  <input type="text" id="invoice_date" name="invoice_date" value="<?php echo set_value('invoice_date') ?>" readonly/>
                  <span for="invoice_date" class="help-inline invoice_date"> <?php echo form_error('invoice_date') ?> </span>
               </div>
            </div>

			<div class="field_wrapper3">
			<div>
			<div class="control-group <?php if(form_error('chalan_number') != '') echo 'error'; ?>">
               <label class="control-label" for="chalan_number">Chalan Number</label>
               <div class="controls">
                  <input type="text" class="chalan_number" id="chalan_number_1" name="chalan_number[]" value="<?php echo set_value('chalan_number') ?>" />
                  <span for="chalan_number" class="help-inline chalan_number_error_1"> <?php echo form_error('chalan_number') ?> </span>
               </div>
			</div>
			<div class="control-group <?php if(form_error('chalan_date') != '') echo 'error'; ?>">
               <label class="control-label" for="chalan_date">Chalan Date</label>
               <div class="controls">
                  <input class="chalan_date" type="text" id="chalan_date_1" name="chalan_date[]" value="<?php echo set_value('chalan_date') ?>" readonly/>
                  <span for="chalan_number" class="help-inline chalan_date_error_1"> <?php echo form_error('chalan_date') ?> </span>
               </div>
            </div>
			<a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			</div>
			</div>
			
			<div class="control-group <?php if(form_error('status') != '') echo 'error'; ?>">
               <label class="control-label" for="status">Status</label>
               <div class="controls">
                  <select name="status" class="status" id="status">
                     <option value="1">Complete</option>
					 <option value="2">Incomplete</option>
                  </select>
                  <span for="warehouse_country" class="help-inline"> <?php echo form_error('warehouse_country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('comments') != '') echo 'error'; ?>">
               <label class="control-label" for="comments">Comments</label>
               <div class="controls">
                  <textarea id="comments" name="comments"><?php echo set_value('comments'); ?></textarea>
                  <span for="comments" class="help-inline"> <?php echo form_error('comments') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor transfer" type="submit">
               <i class="icon-ok bigger-110"></i>
               Transfer
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
<!--inline scripts related to this page-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>-->

<script>
	$(document).on('click','.variationCheckbox',function() {
   			//$('.variationCheckbox').each(function(index,el){
   				var skuVal = $(this).val();
   			 	if(this.checked) {
   			 		//alert('.expiry_'+skuVal);
   			 		$('#expiry_date_'+skuVal).removeAttr('disabled');

   			 	} else {
   			 		$('#quantity_keypress_'+skuVal).val('');
   			 		//$('.expiry_'+skuVal).val('');
   			 		$('#expiry_date_'+skuVal).val('').attr('disabled','disabled');
   			 	}
   			//});
   		});

   $(document).ready(function(){
   	//called when check checkbox of product variation
        	

  		//called when key is pressed in textbox
   	    $(".qty_keypress").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   //display error message
			   alert("Digits Only");
			   return false;
			 }
   		});


   		/*$('.batches').change(function() {

   			var pId = $(this).attr('attrPid');
   			var batchId = $('#batches_'+pId).val();
   			var warehouseId = $('#warehouseId').val();
				
				$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getProductSkuByBatch',
			 		type:'GET',
			 		data:"product_id="+pId+"&batch_id="+batchId+"&warehouse_id="+warehouseId,
		   			success: function(data){
		   				$('.price_'+pId).val('');
		   				$('.price_'+pId).removeAttr('readonly');

		   				var obj = JSON.parse(data);
		   				//console.log(obj);
		   				$.each(obj, function(i,v) {
		   					$('#price_keypress_'+i).val(v);
		   					$('#price_keypress_'+i).attr('readonly','readonly');
		   				});
		   			}
			 	})

   		});*/


   
		$(".multiselect-container li a label input").click(function(){
			 var product_id= $(this).val();
			 $(".transfermenu ul #li_"+product_id).toggle(function() {
			 //	var batchId = $('#batches_'+product_id).val();
			 	var warehouseId = $('#warehouseId').val();

			 	var pId = product_id;
			 	$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getProductSkuByBatch',
			 		type:'GET',
			 		data:"product_id="+pId+"&warehouse_id="+warehouseId,
		   			success: function(data){
		   				$('.price_'+pId).val('');
		   				$('.price_'+pId).removeAttr('readonly');

		   				var obj = JSON.parse(data);
		   				//console.log(obj);
		   				$.each(obj, function(i,v) {
		   					$('#price_keypress_'+i).val(v);
		   					$('#price_keypress_'+i).attr('readonly','readonly');
		   				});
		   			}
			 	})


			 	/*$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getProductSkuByBatch',
			 		type:'GET',
			 		data:"product_id="+product_id+"&batch_id="+batchId,
		   			success: function(data){
		   				//alert(data);
		   			}
			 	})*/

			 });
			 
			 $('#expiry_date_'+product_id).datepicker();
		});
   	
   	    //form validation
        $( ".transfer" ).on("click",function() { 
			var error_count = 0;		

			var warehouseID = $('#warehouseId').val();
			if(warehouseID=="" || warehouseID==0) {
				$(".warehouseId_error").text("Please assign central atleast one warehouse.");
				error_count++;
			} else {
				 $(".warehouseId_error").empty();
			}
	
			var vendor_name =  $('#vendor_name').val();
			if(vendor_name==""){
				//alert("Please enter p name");
				$(".vendor_name_error").text("Please select Vendor Name.");
				error_count++;
			}else {
				 // hide message
				 $(".vendor_name_error").empty();
			}
			
			var product_list =  $('#product_list').val();
			if(product_list==null || product_list==""){
				//alert("Please enter p name");
				$(".product_list_error").text("Please select Product.");
				error_count++;
			}else if(parseInt($('.variationCheckbox:checked').length) <= 0) {
	          $(".product_variation_error").text("Please select atleast one product.");
	          error_count++;
	     	 }else{
				// hide message
				$(".product_variation_error").empty();
				$(".product_list_error").empty();
			}


			$('.variationCheckbox:checked').each(function() {
				var skuCheckbox = $(this).val();
				var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
				if(quantity_val==""){
					$(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value");
					$("#exceed_error_"+skuCheckbox).empty();
					error_count++;
				}else {
					// hide message
					$(".quantity_val_error_"+skuCheckbox).empty();
				}

				var price_val = $('#price_keypress_'+skuCheckbox).val();
				if(price_val=="") {
					$(".price_val_error_"+skuCheckbox).text("Please Enter Price");
				} else {
					$(".price_val_error_"+skuCheckbox).empty();
				}

				/*var exp_date = $('#expiry_date_'+skuCheckbox).val();
				if(exp_date==""){
					$(".expiry_date_error_"+skuCheckbox).text("Please Enter Expiry Date");
					error_count++;
				} else {
					$(".expiry_date_error_"+skuCheckbox).empty();
				}*/
			});
			
			var product_list =  $('#product_list').val();


			var str = ""+product_list+"";
			var my_array = str.split(',');
			/*for (var i = 0; i < my_array.length; i++) {
				//alert(my_array[i])
				var quantity_val = $('#quantity_keypress_'+my_array[i]).val();
				if(quantity_val==""){
					//alert("Please enter p name");
					$(".quantity_val_error_"+my_array[i]).text("Please Enter Quantity value");
					$("#exceed_error_"+my_array[i]).empty();
					error_count++;
				}else {
					// hide message
					$(".quantity_val_error_"+my_array[i]).empty();
				}
				
				
				var exp_date = $('#expiry_date_'+my_array[i]).val();
				
				if(exp_date==""){
					//alert("Please enter p name");
					$(".expiry_date_error_"+my_array[i]).text("Please Enter Expiry Date");
					error_count++;
				}else {
					// hide message
					$(".expiry_date_error_"+my_array[i]).empty();
				}
			}*/

			var invoiceTotalAmount = $('#invoice_total_amount').val();
			if(invoiceTotalAmount == "") {
				$('.invoice_total_amount').text('Please Enter Invoice Total Amount.');
				error_count++;
			} else {
				$('.invoice_total_amount').empty();
			}
			


			var invoiceNumber = $('#invoice_number').val();
			if(invoiceNumber == "") {
				$('.invoice_number').text('Please Enter Invoice Number.');
				error_count++;
			} else {
				$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/chkInvoiceNumberExits',
			 		type:'GET',
			 		dataType:'html',
			 		data:"invoiceNumber="+invoiceNumber,
		   			success: function(res){
		   				if(res == '1') {
		   					$('.invoice_number').text('Invoice Number Already Exits.');
							error_count++;
		   				} else {
		   					$('.invoice_number').empty();
		   				}
		   			}
			 	});
				
			}

			var invoiceDate = $('#invoice_date').val();
			if(invoiceDate == "") {
				$('.invoice_date').text('Please Enter Invoice Date.');
				error_count++;
			} else {
				$('.invoice_date').empty();
			}


			$('.chalan_number').each(function(){
				var chalan_number =  $(this).attr('id').replace('chalan_number_',"");
				var chalan_number_val = $('#chalan_number_'+chalan_number).val();
				if(chalan_number_val==""){
					$(".chalan_number_error_"+chalan_number).text("Please select Challan Number.");
					error_count++;
				}else {
					 // hide message
					 $(".chalan_number_error_"+chalan_number).empty();
				}
				
			})
			
			$('.chalan_date').each(function(){
				var chalan_date =  $(this).attr('id').replace('chalan_date_',"");
				var chalan_date_val = $('#chalan_date_'+chalan_date).val();
				if(chalan_date_val==""){
					$(".chalan_date_error_"+chalan_date).text("Please select Challan Date.");
					error_count++;
				}else {
					 // hide message
					 $(".chalan_date_error_"+chalan_date).empty();
				}
				
			})
			
			
			if(error_count>0){  
				//alert("Please Fill All Required Fields");
				return false;  
   	  		}
        });
   });				   
</script>
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#product_list').multiselect();
</script>
<!--multiselect scripts related to this page-->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
	   $('#invoice_date').datepicker({
	   		maxDate: new Date()
	    });
	   
	   $('#chalan_date_1').datepicker({
	   		maxDate: new Date()
	   });
	});
</script>

<script>
$(document).ready(function() {
    //add more for Challan Number and Date
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".field_wrapper3"); //Fields wrapper
    var add_button      = $(".add_button"); //Add button ID
    
    var x = 2; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            
            $(wrapper).append('<div><div class="control-group <?php if(form_error('chalan_number') != '') echo 'error'; ?>"><label class="control-label" for="chalan_number">Chalan Number</label><div class="controls"><input type="text" id="chalan_number_'+x+'" class="chalan_number" name="chalan_number[]" value="<?php echo set_value('chalan_number') ?>"/><span for="chalan_number" class="help-inline chalan_number_error_'+x+'"> <?php echo form_error('chalan_number') ?> </span></div></div><div class="control-group <?php if(form_error('chalan_date') != '') echo 'error'; ?>"><label class="control-label" for="chalan_date">Chalan Date</label><div class="controls"><input class="chalan_date" type="text" id="chalan_date_'+x+'" name="chalan_date[]" value="<?php echo set_value('chalan_date') ?>" readonly/><span for="chalan_date" class="help-inline chalan_date_error_'+x+'"> <?php echo form_error('chalan_date') ?> </span></div></div><a href="#" class="remove_field">Remove</a></div>'); //add input box
		
		$('#chalan_date_'+x).datepicker();
		x++; //text box increment       
	   }
    });
    
    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
	
});
</script>
</body>
</html>