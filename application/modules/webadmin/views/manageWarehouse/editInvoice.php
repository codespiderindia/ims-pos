<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>
<style>
   /*.transfermenu{
   margin-top:50px;
   }*/
  .transfermenu ul{
			display: inline-block;
		    list-style: outside none none;
		    margin-left: 0;
		    margin-top: 10px;
		    width: 100%;
			
		}
		.transfermenu ul li {
			border: 1px solid #ccc;
			display: none;
			float: left;
			margin-bottom: 20px !important;
			margin-right: 50px;
			padding: 10px;
			width: 240px;
			position:relative;
			width: calc(100% - 20px);
		}
		.transfermenu ul ul {
		    margin-top: 0;
		}
		.transfermenu ul li ul li{
			 border: 1px solid #cccccc;
		    display: inline-block;
		    margin-left: 0;
		    margin-right: 0;
		    margin-top: 0;
		    overflow: inherit;
		    padding: 20px 12px 12px;
		    width: 30%;
		    min-height: 50px;
		}
		.transfermenu ul li ul li label {
		    font-size: 13px;
		    margin: 0 0 0 22px;
		}
		.transfermenu ul li ul li span {
		    display: block;
		}
		/*.transfermenu ul li:hover ul{
			display:block;
		}*/
		.transfermenu ul li ul li{
			float:none;
		}
		.transfermenu ul ul ul {
		    margin: 5px 0 0;
		}
		.transfermenu ul li ul li ul li {
		    border: medium none;
		    margin: 0;
		    padding: 0;
		    width: auto;
		    display: block;
		}
		.transfermenu .dv-in {
			margin: 0 0 15px;
			position: relative;
		}
		.dv-in .stock-help-inline {
			top: auto;
			left: 0;
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
   left:20%;
   color:red;
   top: 0;
   left: 12px;
   font-size: 11px;
   }
   .help-inline{
   color:red;
   }
   .form-horizontal .controls {
	}
	.controls .help-inline {
		display: block;
		width: auto;
	}
</style>

<?php
//check Key and value pair in multidimensional array
function search($array, $key, $value)
{
    $results = array();

    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }

        foreach ($array as $subarray) {
            $results = array_merge($results, search($subarray, $key, $value));
        }
    }

    return $results;
}
	
?>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
	  
	  <?php //print_r($invoiceProductInfo);
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

         	<input type="hidden" class="warehouseId" id="warehouseId" value="<?php echo $warehouse_is_central_id; ?>" />
         	<span for="warehouse_id" class="help-inline warehouseId_error"> <?php echo form_error('warehouse_id') ?> </span>

         	<input type="hidden" class="invoice_id" name="invoice_id" value="<?php echo $invoice_id; ?>">


         	<?php $code = $invoiceInfo->comp_code; ?>
         	<input type="hidden" name="hidden_sku_cls" class="hidden_sku_cls">
         	<input type="hidden" name="comp_code" value="<?php echo $code; ?>">
			<div class="control-group <?php if(form_error('vendor_name') != '') echo 'error'; ?>">
               <label class="control-label" for="vendor_name">Vendor Name</label>
               <div class="controls">
                  <select name="vendor_name" class="vendor_name" id="vendor_name" value="">
                     <option value="">Select Vendor</option>
					 <?php 
					 $vendor_details = vendor_details($code);

					 if(isset($vendor_details) && !empty($vendor_details)){
					 	foreach($vendor_details as $val){
							if($invoiceInfo->vendor_id!=$val['vendor_id']){
					 ?>
					 <option value="<?php echo $val['vendor_id']; ?>"><?php echo ucfirst($val['f_name']).' '.ucfirst($val['l_name']); ?></option>
					 <?php 
					 	}else{?>
					<option selected value="<?php echo $invoiceInfo->vendor_id; ?>"><?php echo ucfirst($val['f_name']).' '.ucfirst($val['l_name']); ?></option>
					<?php }	}
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

					 $masterProductId=[];
					 foreach($invoiceProductInfo as $invoiceProductInfos) {
					 	$masterProductId[] = $invoiceProductInfos['master_product_id'];
					 }	

					 $productIdName = productIdName($code);

					 if(isset($productIdName) && !empty($productIdName)){
					 
						foreach($productIdName as $productIdName1){ 
					 ?>
					 <!--<option value="<?php //echo $productIdName1->product_id; ?>" <?php //echo search($invoiceProductInfo,'product_id',$productIdName1->product_id) ? 'selected' : '';?>><?php //echo //$productIdName1->product_name; ?>
					 </option>-->

					  <option value="<?php echo $productIdName1->product_id; ?>" <?php echo in_array($productIdName1->product_id, $masterProductId) ? 'selected' : ''; ?>><?php echo $productIdName1->product_name; ?>
					 </option>
					 <?php 
					 	} // end foreach
					 } 
					 else{ ?>
					 <option value="">Product Not Available</option>
					 <?php }?>
				  </select>
				  <a href="<?php echo site_url().'webadmin/manageproduct/vendorToWhAddProduct'; ?>">Add Product</a>
				  <span for="country" class="help-inline product_list_error"> </span>
				 <div class="transfermenu"> 
                     <ul>
						 <?php 				
						 $productIdName = productIdName($code);
						 if(isset($productIdName) && !empty($productIdName)){
							 
							 foreach($productIdName as $key=>$productIdName1){ 
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

						   <?php $productVariation=getProductVariation($productIdName1->product_id); ?>

						    <ul id="quantity_<?php echo $productIdName1->product_id; ?>">
						    <?php 
					   		 	foreach($productVariation as $productVariations) {
					   		 		$sku = $productVariations['sku'];
						   		 	$arrayVariationId=explode(',',$productVariations['variation_ids']);
						   			$variationName=getAllVariationNames($arrayVariationId);
						   			//echo $productVariations['variation_ids'];
						   			$allVariationName=[];
						   			foreach($variationName as $variationNames) {
						   				$allVariationName[]=$variationNames['attribute_value'];
						   			}

						   			$mergeVariationName=implode(', ',$allVariationName); ?>
					   			<li>
					   				<input type="hidden" name="pId[<?php echo $sku; ?>]" class="" value="<?php echo $productIdName1->product_id; ?>" />
					   				
					   				<span class="stock-help-inline" id="variation_error_msg_<?php echo $productVariations['sku']; ?>"></span>
					   				
					   				<input type="checkbox" name="variationCheckbox[]" id="id_checkbox_<?php echo $productVariations['sku']; ?>" attrChecked="<?php if(search($invoiceProductInfo,'product_id',$productVariations['sku'])) { echo '1'; } else { echo '0'; } ?>" class="variationCheckbox skuCheckbox_<?php echo $pId; ?>" value="<?php echo $productVariations['sku']; ?>" attrProductId="<?php echo $productIdName1->product_id; ?>" attrVariationRelation="<?php echo $productVariations['id']; ?>" >

						   			<label>Variation: <?php echo $mergeVariationName; ?></label>
						   			<label>SKU: <?php echo $productVariations['sku']; ?></label>
						   			<ul>
									  <li>
									  	<div class="dv-in">
									  		<span>Quantity</span>
											<span class="qty_keypress">
												<input class="quantity_input quantity_keypress qty_<?php echo $pId; ?>" id="quantity_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="quantity[<?php echo $productVariations['sku']; ?>]" value="" />
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
											<input type="date" class="expiry_date_<?php echo $pId; ?> expiry_<?php echo $productVariations['sku']; ?>"  id="expiry_date_<?php echo $productVariations['sku']; ?>" name="expiry_date[<?php echo $productVariations['sku']; ?>]" value=""/>
											</span> 
											<span for="name" class="stock-help-inline expiry_date_error_<?php echo $productVariations['sku'];?>">  </span>
									  </div>
									  </li>
									</ul>
					   			</li>
					   		<?php
					   			}
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
			
			<div class="control-group <?php if(form_error('invoice_number') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_number">Invoice Number</label>
               <div class="controls">
                  <input type="text" id="invoice_number" name="invoice_number" value="<?php if(isset($invoiceInfo->invoice_number) && !empty($invoiceInfo->invoice_number)) {echo $invoiceInfo->invoice_number;}?>" />
                  <span for="invoice_number" class="help-inline invoice_number"> <?php echo form_error('invoice_number') ?> </span>
               </div>
            </div>

			<div class="field_wrapper3">
			<?php 
			if(isset($invoiceChallnInfo) && !empty($invoiceChallnInfo)){
			$i=0;
			foreach($invoiceChallnInfo as $single){?>
			<div>
			<div class="control-group <?php if(form_error('chalan_number') != '') echo 'error'; ?>">
               <label class="control-label" for="chalan_number">Chalan Number</label>
               <div class="controls">
                  <input type="text" class="chalan_number" id="chalan_number_<?php echo $i;?>" name="chalan_number[]" value="<?php echo $single['challan_number']; ?>" />
                  <span for="chalan_number" class="help-inline chalan_number_error_<?php echo $i;?>"> <?php echo form_error('chalan_number') ?> </span>
               </div>
			</div>
			<div class="control-group <?php if(form_error('chalan_date') != '') echo 'error'; ?>">
               <label class="control-label" for="chalan_date">Chalan Date</label>
               <div class="controls">
                  <input class="chalan_date" type="text" id="chalan_date_<?php echo $i;?>" name="chalan_date[]" value="<?php echo $single['challan_date']; ?>" readonly/>
                  <span for="chalan_number" class="help-inline chalan_date_error_<?php echo $i;?>"> <?php echo form_error('chalan_date') ?> </span>
               </div>
            </div>
			<?php if($i==0 || count($invoiceChallnInfo)==1){ ?>
			<a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			<?php }else{?>
			<a href="javascript:void(0);" class="remove_field" title="Remove field">Remove</a>
			<?php }?>
			<input type="hidden" value="<?php echo count($invoiceChallnInfo); ?>" id="count_of_challan_details"/>
			</div>
			<?php $i++;} }//end foreach loop?>
			</div>
			
			<div class="control-group <?php if(form_error('invoice_date') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_date">Invoice Date</label>
               <div class="controls">
                  <input type="text" id="invoice_date" name="invoice_date" value="<?php if(isset($invoiceInfo->invoice_number) && !empty($invoiceInfo->invoice_number)) {echo $invoiceInfo->invoice_date;}?>" readonly/>
                  <span for="invoice_date" class="help-inline invoice_date"> <?php echo form_error('invoice_date') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('status') != '') echo 'error'; ?>">
               <label class="control-label" for="status">Status</label>
               <div class="controls">
                  <select name="status" class="status" id="status">
                     <option value="1" <?php if(isset($invoiceInfo->status) && !empty($invoiceInfo->status)) {echo "selected";}?>>Complete</option>
					 <option value="2" <?php if(isset($invoiceInfo->status) && !empty($invoiceInfo->status)) {echo "selected";}?>>Incomplete</option>
                  </select>
                  <span for="warehouse_country" class="help-inline"> <?php echo form_error('warehouse_country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('comments') != '') echo 'error'; ?>">
               <label class="control-label" for="comments">Comments</label>
               <div class="controls">
                  <textarea id="comments" name="comments"><?php if(isset($invoiceInfo->comments) && !empty($invoiceInfo->comments)) {echo $invoiceInfo->comments;}?></textarea>
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
			var checkedAttr = $(this).attr('attrchecked');
		 	if(this.checked) {
		 		$('.expiry_'+skuVal).removeAttr('disabled');
		 		//$('.expiry_'+skuVal).removeAttr('disabled').datepicker();
		 	} else {
		 		if(checkedAttr==1) {
		 			$('#id_checkbox_'+skuVal).attr('checked',false);
		 			checkSkuExitsInBatch(skuVal);
		 		} else {
		 			$('#quantity_keypress_'+skuVal).val('');
			 		//$('.expiry_'+skuVal).val('');
			 		$('.expiry_'+skuVal).val('').attr('readonly',true);
		 		}
		 	}
		//});
	});


   $(document).ready(function(){

   	function checkSkuExitsInBatch(skuVal) {
   		$.ajax({
			url:'<?php echo site_url();?>webadmin/managewarehouse/checkProductTransferInStore',
	 		type:'GET',
	 		data:"sku="+skuVal,
   			success: function(data){
   				if(data==1) {
   					$('#variation_error_msg_'+skuVal).show().text('Already used in store.');
   					$('#id_checkbox_'+skuVal).prop('checked',true).on("click", false);
   					$('#quantity_keypress_'+skuVal).attr('readonly',true);
   					$('#expiry_date_'+skuVal).attr('readonly',true);
   				} else {
   					$('#variation_error_msg_'+skuVal).hide();
   				}
   			}
		});
   	}

   	function batchData(pId,batchId,warehouseId,invoice_id) {
   		$.ajax({
		 		url:'<?php echo site_url();?>webadmin/managewarehouse/getInfoBySkuBatchWarehouseId',
		 		type:'POST',
		 		data:"product_id="+pId+"&batchId="+batchId+"&warehouseId="+warehouseId+'&invoice_id='+invoice_id,
	   			success: function(data){
	   				$('.qty_'+pId).val('').removeAttr('readonly');
	   				$('.price_'+pId).val('').removeAttr('readonly');
	   				$('.skuCheckbox_'+pId).prop('checked',false);
	   				$('.qty_'+pId).val('').removeAttr('readonly');
	   				$('.expiry_date_'+pId).val('').removeAttr('readonly');

	   				if(data != '') {
	   					var obj = JSON.parse(data);
	   			
		   				$.each(obj, function(i,v) {

		   					if(v.checkStoreStatus == 1) {
		   						$('#variation_error_msg_'+i).show().text('Already used in store.');
		   						$('#id_checkbox_'+i).prop('checked',true).on("click", false);
		   						$('#price_keypress_'+i).val(v.price).attr('readonly',true);
		   						$('#quantity_keypress_'+i).val(v.qty).attr('readonly',true);
		   						$('#expiry_date_'+i).val(v.expiry_date).attr('readonly',true);
		   					} else {
		   						$('#id_checkbox_'+i).prop('checked',true);
			   					$('#price_keypress_'+i).val(v.price);
			   					$('#quantity_keypress_'+i).val(v.qty);
			   					$('#expiry_date_'+i).val(v.expiry_date);
		   					}
		   				});
	   				} else {
	   					$('.stock-help-inline').hide();
	   					$(".qty_"+pId+", .price_"+pId+", .expiry_date_"+pId+", .skuCheckbox_"+pId).removeAttr('readonly');
	   				}
	   			}
		 	})
   	}

	$('.batches').change(function() {
		//var product_list =  $('#product_list').val();
		var pId = $(this).attr('attrPid');
		var batchId = $('#batches_'+pId).val();
		var warehouseId = $('#warehouseId').val();
		var invoice_id = $('.invoice_id').val();

		//batchData(pId,batchId,warehouseId,invoice_id);
		
	});



   	

  		//called when key is pressed in textbox
   	    $(".qty_keypress").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   //display error message
			   alert("Digits Only");
			   return false;
			 }
   		});
   
		//$('input:checkbox:checked').each(function(){
		$('input:checkbox:checked').each(function(){
			var productID = $(this).val();

			if ($('.dropdown-menu li').hasClass('active')) {
   		
					$(".transfermenu ul #li_"+productID).show();
					
		   			//var batchId = $('#batches_'+productID).val();
		   			var warehouseId = $('#warehouseId').val();
		   			var invoice_id = $('.invoice_id').val();

		   			//batchData(productID,batchId,warehouseId,invoice_id);
		   			
		   			/*var checkVal = $('.skuCheckbox_'+productID).attr('checked').val();
		   			alert('if');
		   			$.each(checkVal, function() {
						alert($(this).val());
						alert('each');
					});
					checkSkuExitsInBatch(productID);*/

					//$('#expiry_date_'+productID).datepicker();
			}
		});



		var skuForEdit=[];
   	$('.variationCheckbox:checked').each(function() {

   		var pId = $(this).attr('attrproductid');
		var skuVal = $(this).val();
		//var batchId = $('#batches_'+pId).val();

		$.ajax({
			url:'<?php echo site_url();?>webadmin/managewarehouse/checkProductTransferInStore',
	 		type:'GET',
	 		data:"sku="+skuVal,
   			success: function(data){
   				if(data==1) {
   					$('#variation_error_msg_'+skuVal).show().text('Already used in store.');
   					$('#id_checkbox_'+skuVal).prop('checked',true).on("click", false);
   					$('#quantity_keypress_'+skuVal).attr('readonly',true);
   					$('#expiry_date_'+skuVal).attr('readonly',true);
   					skuForEdit.push(skuVal);
   					$('.hidden_sku_cls').val(skuForEdit);
   				} else {
   					$('#variation_error_msg_'+skuVal).hide();
   				}
			}
		});
	});
		
		$(".multiselect-container li a label input").click(function(){
			 var product_id= $(this).val();
			 
			$(".transfermenu ul #li_"+product_id).toggle();

				//var batchId = $('#batches_'+product_id).val();
			 	var warehouseId = $('#warehouseId').val();

			 	var pId = product_id;
			 	$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getInfoBySkuBatchWarehouseId',
			 		type:'GET',
			 		data:"product_id="+product_id+'&warehouseId='+warehouseId,
			 		success: function(data){
			 			$('.qty_'+pId).val('').removeAttr('readonly');
		   				$('.price_'+pId).val('').removeAttr('readonly');
		   				$('.skuCheckbox_'+pId).prop('checked',false);

		   				var obj = JSON.parse(data);
		   				//console.log(obj);
		   				$.each(obj, function(i,v) {
		   					$('#id_checkbox_'+i).prop('checked',true);
		   					$('#price_keypress_'+i).val(v.price).attr('readonly','readonly');
		   					$('#quantity_keypress_'+i).val(v.qty).attr('readonly','readonly');
		   				});
			 		}
			 	});	
			
			 
			//$('#expiry_date_'+product_id).datepicker();
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
			}else{
				// hide message
				$(".product_list_error").empty();
			}

			$('.variationCheckbox:checked').each(function() {
				var skuCheckbox = $(this).val();
				var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
				var price = $('#price_keypress_'+skuCheckbox).val();
				if(quantity_val==""){
					$(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value.");
					$("#exceed_error_"+skuCheckbox).empty();
					error_count++;
				} else if(price=="") {
					$(".quantity_val_error_"+skuCheckbox).empty();
					$(".price_val_error_"+skuCheckbox).text("Please Enter Price value.");
					error_count++;
				} else {
					// hide message
					$(".quantity_val_error_"+skuCheckbox).empty();
				}

				/*var exp_date = $('#expiry_date_'+skuCheckbox).val();
				if(exp_date==""){
					//alert("Please enter p name");
					$(".expiry_date_error_"+skuCheckbox).text("Please Enter Expiry Date");
					error_count++;
				}else {
					// hide message
					$(".expiry_date_error_"+skuCheckbox).empty();
				}*/
			});
			
			var product_list =  $('#product_list').val();
			/*var str = ""+product_list+"";
			var my_array = str.split(',');
			for (var i = 0; i < my_array.length; i++) {
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
	   $('#invoice_date').datepicker();
	   <?php 
	   $j=0;
	   foreach($invoiceChallnInfo as $single){?>
	   var challan_count = "<?php echo $j;?>";
	   $('#chalan_date_'+challan_count).datepicker();
	   <?php $j++;}?>
	});
</script>


<script>
$(document).ready(function() {
    //add more for Challan Number and Date
	var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".field_wrapper3"); //Fields wrapper
    var add_button      = $(".add_button"); //Add button ID
    var count_of_chalan_number = $("#count_of_challan_details").val();
	var x = count_of_chalan_number; //Initial field counter is 1
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