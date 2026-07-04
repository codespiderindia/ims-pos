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
		min-height: 120px;
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
	.batch_number_label {
		width: 15%;
    	float: left;
	}
	/*.new_batch {
		display: none;
	}*/
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
         <form class="form-horizontal" name="add_stock" action="" method="post">
         	<?php 
         		$getWarehouseIsCentral = getWarehouseIsCentral($uinfo['comp_code']); 
         		if(isset($getWarehouseIsCentral) && !empty($getWarehouseIsCentral)) {
					$warehouse_is_central_id = $getWarehouseIsCentral->warehouse_id;
				} else {
					$warehouse_is_central_id = 0;
				}
         	?>
         	<input type="hidden" class="warehouseId" name="warehouseId" id="warehouseId" value="<?php echo $warehouse_is_central_id; ?>" />
         	<span for="warehouse_id" class="help-inline warehouseId_error"> <?php echo form_error('warehouse_id') ?> </span>

			
			<div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
			   <label class="control-label" for="role">Product Has Vendor</label>
			   <div class="controls product_select">
				  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
					 <?php 				
					 $productIdName = productIdName($uinfo['comp_code']);

					 if(isset($productIdName) && !empty($productIdName)){
						 foreach($productIdName as $productIdName1){ 

						 	$pMasterids = $productIdName1->product_id;

						 	$whereVendorewarehouse1 = ['master_product_id'=>$pMasterids, 'warehouse_id'=>$warehouse_is_central_id, 'comp_code'=>$uinfo['comp_code']];

						   	$productVariation1 = getSku('warehouse_inventory', $whereVendorewarehouse1);
						   //	if(isset($productVariation1) && !empty($productVariation1)) {
					 ?>
					 <option value="<?php echo $productIdName1->product_id; ?>"><?php echo $productIdName1->product_name; ?></option>
					 <?php 
					  		//} 
					  	} // end foreach
					 } else{ ?>
					 <option value="">Product Not Available</option>
					 <?php }?>
				  </select>
				  <span for="country" class="help-inline product_list_error"> </span>
					
				<div class="transfermenu">
			  	 	<span for="country" class="help-inline product_variation_error"> </span>
                    <ul>
                    	<?php 				
						 $productIdName = productIdName($uinfo['comp_code']);
						 if(isset($productIdName) && !empty($productIdName)){
							foreach($productIdName as $productIdName1) { 
							 	$pId = $productIdName1->product_id;

							 	//$batches = getProductBatchs($pId, $uinfo['comp_code']);
							 	
							 	 ?>
							 	<li id="li_<?php echo $productIdName1->product_id; ?>">
							 		<input type="hidden" value="<?php echo $productIdName1->product_id;?>" name="product_in_stock[]" class="product_in_stock" id="product_in_stock_<?php echo $productIdName1->product_id; ?>">
							 		<p class="product_lbl"><?php echo $productIdName1->product_name;?></p>


						<!--<label>Select Batch</label>
					    <select name="batches[<?php echo $pId; ?>]" class="batches" id="batches_<?php echo $pId; ?>" attrPid="<?php echo $pId; ?>">
					    	<?php $batchs = getProductBatchs($pId, $uinfo['comp_code']);
					    	foreach($batchs as $batch) { ?>
					    		<option value="<?php echo $batch['product_batch_id']; ?>"><?php echo $batch['batch_number']; ?></option>
					    	<?php } ?>
					    </select>-->


					    <div id ="inventory_sku_<?php echo $pId; ?>">

						</div>
							 		<?php
							 		 $productVariation=getProductVariation($productIdName1->product_id);
							 		  ?>

							 		<ul id="quantity_<?php echo $productIdName1->product_id; ?>">
							 			<?php if(isset($productVariation) && !empty($productVariation)) {
							 			foreach($productVariation as $productVariations) {

							 				$masterPId = $productIdName1->product_id;

						   					//if(isset($productVariation2) && !empty($productVariation2)) {

							 				$arrayVariationId=explode(',',$productVariations['variation_ids']);
								   			$variationName=getAllVariationNames($arrayVariationId);

								   			$allVariationName=[];
								   			foreach($variationName as $variationNames) {
								   				$allVariationName[]=$variationNames['attribute_value'];
								   			}

								   			$mergeVariationName=implode(', ',$allVariationName);  ?>
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
														<input class="quantity_input quantity_keypress" id="quantity_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="quantity[<?php echo $productVariations['sku']; ?>]" value="" />  <span class="add_sr_no" p_id = "quantity_keypress_<?php echo $productVariations['sku']; ?>">Add Sr No.</span>
														</span>
														<span for="name" class="stock-help-inline quantity_val_error_<?php echo $productVariations['sku'];?>">  </span>
														</div>

	<div class="dv-in">
	<span>Price</span>
	<span class="price_keypress" id="price_span_<?php echo $productVariations['sku']; ?>">
		<input class="price_input price_keypress_<?php echo $pId; ?>" id="price_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="price[<?php echo $productVariations['sku']; ?>]" value="" />
	</span>
	<span for="name" class="stock-help-inline price_val_error_<?php echo $productVariations['sku'];?>">  </span>
	</div>
								   					</li>
								   				</ul>
								   			</li>
							 			<?php } } else {
							 				echo 'no Variation';
							 			}  /*}*/ ?>
							 		</ul>

							 	</li>
							<?php
							}
						}
					 ?>
                    </ul>
            	</div>
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
               Add Stock
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

<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#product_list').multiselect();
</script>
<!--multiselect scripts related to this page-->

<script>
	

   $(document).ready(function(){


   /*	$('.batches').change(function() {

		var batchId = $(this).val();
		var masterPId = $(this).attr('attrPid');
		var warehouseId = $('#warehouseId').val();
		var url="<?php echo site_url();?>webadmin/managewarehouse/getBatchSkuQtyForAddStock";

		$.ajax({
			url: url,  
   			type:'POST',
   			data:"p_id="+masterPId+"&batch_id="+batchId+"&warehouse_id="+warehouseId,
   			success: function(data){
   					$('.price_keypress_'+masterPId).val('');
   					$('.price_keypress_'+masterPId).removeAttr('readonly');
   				if(data != '') {
   					var res = JSON.parse(data);
   					$.each(res, function(i,v) {
						$('#price_keypress_'+i).val(v);
						$('#price_keypress_'+i).attr('readonly', 'readonly');
   					});
   				}
   				//$('#inventory_sku_'+masterPId).html(data);
   			}
		});
	});*/



   		/*$('body').on('change', '.select_batch', function() {
   			var pId = $(this).attr('attrpid');

   			var selectedBatch = $('#select_batch_'+pId).val();

			$('#batch_number_'+pId).val(selectedBatch).attr('attrexits',1);
   		});*/


   		$('body').on('click', '.variationCheckbox', function() {
   		
   			/*if(this.checked == true) {

   				var pId = $(this).attr('attrproductid');
   				var sku = $(this).val();
   				var batchNumber = $('#batch_number_'+pId).val();

   				$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getSkuDataByBatchNumber',
			 		type:'GET',
			 		dataType:'html',
			 		data:"batchNumber="+batchNumber+"&productId="+pId+"&sku="+sku,
		   			success: function(res){
		   				if(res != 0) {
		   					var data = JSON.parse(res);
		   					$('#quantity_keypress_'+sku).val(data.quantity);
		   				}
		   			}
			 	});
   			}*/
   		})


  		//called when key is pressed in textbox
   	    $(".qty_keypress").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   //display error message
			   alert("Digits Only");
			   return false;
			 } else {
			 	//$('.add_sr_no').click();
			 }
   		});
   			
   		$('.add_sr_no').click(function(){ 
		var p_id = ($(this).attr('p_id'));
		var qt = parseInt($("#"+p_id).val());
		$('.sr_no_dynamic').remove();
		for (var i = 1; i <= qt; i++) {
			//document.getElementById(p_id).after('<input type="text" style ="margin-top:20px"  name="sr_no[]" >');

			$(this).before('<input type="text" class="sr_no_dynamic" style ="margin-top:20px"  name="sr_no[]" >');
		}

   		});	
		$(".multiselect-container li a label input").click(function(){
			 var product_id= $(this).val();
			 $(".transfermenu ul #li_"+product_id).toggle(function() {

			 //	var batchId = $('#batches_'+product_id).val();
				var masterPId = product_id;
				var warehouseId = $('#warehouseId').val();
				var url="<?php echo site_url();?>webadmin/managewarehouse/getBatchSkuQtyForAddStock";

				$.ajax({
					url: url,  
		   			type:'POST',
		   			data:"p_id="+masterPId+"&warehouse_id="+warehouseId,
		   			success: function(data){
		   					$('.price_keypress_'+masterPId).val('');
   							$('.price_keypress_'+masterPId).removeAttr('readonly');
		   				if(data != '') {
		   					var res = JSON.parse(data);
		   					$.each(res, function(i,v) {
		   						$('#price_keypress_'+i).val(v);
		   						$('#price_keypress_'+i).attr('readonly', 'readonly');
		   					});
		   				} 
		   				//$('#inventory_sku_'+masterPId).html(data);
		   			}
				});



			 	$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/getProductVariation',
			 		type:'GET',
			 		data:"product_id="+product_id,
		   			success: function(data){
		   				//alert(data);
		   			}
			 	})
			 });
			 
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
			
			
			var product_list =  $('#product_list').val();
			
			/*var productListCount = product_list.length;

			if(productListCount > 0) {
				for(var i=0; i<productListCount; i++) {
					
					var selectPid = product_list[i];
					var selectedBatch = $('#select_batch_'+selectPid).val();

					if(selectedBatch != '') {
						$('#batch_number_'+selectPid).val(selectedBatch).attr('attrexits',1);
					}
				}
			}*/
			

			if(product_list==null || product_list==""){
				//alert("Please enter p name");
				$(".product_list_error").text("Please select Product.");
				error_count++;
			} else if(parseInt($('.variationCheckbox:checked').length) <= 0) {
	          	$(".product_variation_error").text("Please select atleast one product variation.");
	          	$(".product_list_error").empty();
	          error_count++;
	     	 }else{
				// hide message
				$(".product_variation_error").empty();
			}


			$('.variationCheckbox:checked').each(function() {
				var skuCheckbox = $(this).val();
				var pId = $(this).attr('attrproductid');

				/*var batch_number = $('#batch_number_'+pId).val();
				var batchNumberExits = $('#batch_number_'+pId).attr('attrexits');
				
				var checkBatchNumber = $('.batch_number_error_'+pId).attr('checkres');

				if(batch_number=="") {
					$(".batch_number_error_"+pId).text("Please Select Batch Number");
					error_count++;
				} else if(checkBatchNumber == 1 && batchNumberExits == 0) {
					$('.batch_number_error_'+pId).text('Batch Number Already Exits.');
					error_count++;
				} else {
					$(".batch_number_error_"+pId).empty();
				}*/


				var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
				
				if(quantity_val=="" || quantity_val == 'undefined'){
					$(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value");
					$("#exceed_error_"+skuCheckbox).empty();
					error_count++;
				} /*else if($.isNumeric(quantity_val)) {

					$.ajax({
						url:'<?php echo site_url();?>webadmin/managewarehouse/chkSkuExitsForStock',
						type:'GET',
			 			data:"product_id="+pId+"&sku="+skuCheckbox+"&warehouse_id="+warehouseID,
			 			success: myCallback
					});

				}*/ else {
					// hide message
					$(".quantity_val_error_"+skuCheckbox).empty();
				}

				var price_val = $('#price_keypress_'+skuCheckbox).val();
				if(price_val=="" || price_val== 'undefined') {
					$(".price_val_error_"+skuCheckbox).text("Please Enter Price.");
					error_count++;
				} else {
					$(".price_val_error_"+skuCheckbox).empty();
				}
 
				/*function myCallback(result) {

					if(result == 0) {
						$(".quantity_val_error_"+skuCheckbox).text("Please This product purchase to vendor.");
						error_count++;
					} else {
						$(".quantity_val_error_"+skuCheckbox).empty();
					}
				}*/

			});
			
			var product_list =  $('#product_list').val();


			var str = ""+product_list+"";
			var my_array = str.split(',');


			/*var batchNumber = $('#batch_number').val();
			if(batchNumber == "") {
				$('.batch_number').text('Please Enter Batch Number.');
				error_count++;
			} else {
				$.ajax({
			 		url:'<?php echo site_url();?>webadmin/managewarehouse/chkBatchNumberExits',
			 		type:'GET',
			 		dataType:'html',
			 		data:"batchNumber="+batchNumber,
		   			success: function(res){
		   				if(res == '1') {
		   					$('.batch_number').text('Batch Number Already Exits.');
							error_count++;
		   				} else {
		   					$('.batch_number').empty();
		   				}
		   			}
			 	});
			}*/
		
			if(error_count>0){  
				//alert("Please Fill All Required Fields");
				return false;  
   	  		} 
        });
   });				   
</script>




<!-- inline scripts related to this page -->
<script type="text/javascript">
	/*jQuery(function($) {
	   $('#invoice_date').datepicker({
	   		maxDate: new Date()
	    });
	   
	   $('#chalan_date_1').datepicker({
	   		maxDate: new Date()
	   });
	});*/
</script>

<script>
/*$(document).ready(function() {
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
	
});*/
</script>
</body>
</html>