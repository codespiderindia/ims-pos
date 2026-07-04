<?php $this->load->view('include/layout_header'); ?>

<?php
 $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
   /*.transfermenu{
   margin-top:50px;
   }*/
   .transfermenu ul{
   list-style:none;
   margin-left:0px!important; 
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
   }
   .transfermenu ul li ul li{
   margin-left:0px;
   margin-top: 10px;
   display:block;
   border:none;
   padding:0;
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
   left:20%;
   color:red;
   }
   .help-inline{
   color:red;
   }
   .form-horizontal .controls {
    display: inline-block;
    margin-left: 20px;
	}
	.controls .help-inline {
		display: block;
		width: auto;
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



			<div class="control-group <?php if(form_error('invoice_number') != '') echo 'error'; ?>">
               <label class="control-label" for="invoice_number">Search By Invoice Number</label>
               <div class="controls">
                  <select name="invoice_number" class="invoice_number" id="invoice_number" value="">
                     <option value="">Select Invoice Number</option>
					 <?php 
					 $invoice_details = invoice_details($uinfo['comp_code']);
					 if(isset($invoice_details) && !empty($invoice_details)){
					 	foreach($invoice_details as $val){
					 ?>
					 <option value="<?php echo $val->invoice_number;?>" <?php echo  set_select('invoice_number', $val->invoice_number, ( !empty($_GET['invoice_number']) && $_GET['invoice_number'] == $val->invoice_number ? TRUE : FALSE )); ?>><?php echo ucfirst($val->invoice_number); ?></option> 
					 
					<?php }
					 }
					 ?>
                  </select>
                  <span for="invoice_number" class="help-inline invoice_number invoice_number_error"> <?php echo form_error('invoice_number') ?> </span>
               </div>
            </div>
			
			<hr>
			
			<div class="control-group <?php if(form_error('vendor_name') != '') echo 'error'; ?>">
               <label class="control-label" for="vendor_name">Vendor Name</label>
               <div class="controls">
                  <select name="vendor_name" class="vendor_name" id="vendor_name" value="">
                     <option value="">Select Vendor</option>
					 <?php 				
						if(isset($_GET['invoice_number'])) { 
                        
						$vendor = get_vendor_by_invoice_number($_GET['invoice_number']);
						} else {
						$vendor = array();
						}
                        if(!empty($vendor)) { 
						foreach($vendor as $vendor){ 
						$vendor_name = vendor_name($vendor['vendor_id']);
						?>
					 <option selected value="<?php echo $vendor['vendor_id'];?>"><?php echo $vendor_name->f_name.' '.$vendor_name->l_name;?></option>
                    <?php }}
					else{?>
					
					<option value="">Vendor not Available</option>
					<?php }?>
					
                  </select>
                  <span for="vendor_name" class="help-inline vendor_name_error"> <?php echo form_error('vendor_name') ?> </span>
               </div>
            </div>
			
			<div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Product Has Vendor</label>
               <div class="controls product_select">
                  <input type="hidden" name="invoice_number_val" value="<?php if(isset($_GET['invoice_number']))echo $_GET['invoice_number']; ?>"/>
				  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
                     <?php 				
						if(isset($_GET['invoice_number'])) {

						$product = product_has_vendor($_GET['invoice_number']);
						
						$pMasterid=[];
						foreach($product as $products) {
							$getMasterId = $products['master_product_id'];
							$pMasterid[$getMasterId] = $getMasterId;
						}
						} else {
							$product = array();
						}

                        if(!empty($pMasterid)) { 
						foreach($pMasterid as $pMasterids){ 
							$whereVendorewarehouse1 = ['master_product_id'=>$pMasterids, 'invoice_id'=>$vendor['invoice_id'], 'comp_code'=>$uinfo['comp_code'], 'quantity !='=>0];

						   	$productVariation1 = getSku('vendor_to_wh_product', $whereVendorewarehouse1);
						   	if(isset($productVariation1) && !empty($productVariation1)) {
						?>
					 		<option value="<?php echo $pMasterids;?>"><?php echo product_name($pMasterids);?></option>
                    <?php }} }
					else { ?>
					
					<option value="">Product not Available</option>
					<?php }?>
				  </select>
				  <span for="country" class="help-inline product_list_error"> </span>
				  <div class="transfermenu">
				  	 <span for="country" class="help-inline product_variation_error"> </span>
                    <ul>
						<?php 				
							if(isset($_GET['invoice_number'])) { 
								$product = product_has_vendor($_GET['invoice_number']);

								$pMasterid=[];
								foreach($product as $products) {
									$getMasterId = $products['master_product_id'];
									$pMasterid[$getMasterId] = $getMasterId;
								}
							} else {
								$product = array();
							}


							if(isset($pMasterid) && !empty($pMasterid)) {
								foreach($pMasterid as $pMasterids) { ?>
								<li id="li_<?php echo $pMasterids; ?>">

									<input type="hidden" value="<?php echo $pMasterids;?>" name="product_return_policy[]" class="product_return_policy" id="product_return_policy_<?php echo $pMasterids; ?>">

									<p class="product_lbl">
						   				<?php echo product_name($pMasterids);?>
						   			</p>
						   			<?php
						   			$whereVendorewarehouse = ['master_product_id'=>$pMasterids, 'invoice_id'=>$vendor['invoice_id'], 'quantity !='=>0];

						   			$productVariation = getSku('vendor_to_wh_product', $whereVendorewarehouse);


						   			if(isset($productVariation) && !empty($productVariation)) {
								 ?>

						   			<ul id="quantity_<?php echo $pMasterids; ?>">
						   				<?php
						   					foreach($productVariation as $productVariations) {
						   						$sku = $productVariations['product_id'];

						   				$productQty = getSku('warehouse_inventory', ['product_id'=>$sku, 'warehouse_id'=>$warehouse_is_central_id, 'comp_code'=>$uinfo['comp_code']]);	


						   				$productVariation=getSelectedProductVariation($productVariations['product_id']); 

						   						$arrayVariationId=explode(',',$productVariation[0]['variation_ids']);
								   				$variationName=getAllVariationNames($arrayVariationId);

								   				$allVariationName=[];
									   			foreach($variationName as $variationNames) {
									   				$allVariationName[]=$variationNames['attribute_value'];
									   			}

									   			$mergeVariationName=implode(', ',$allVariationName); 
						   				 ?>
						   				 <li>
						   				 	<input type="checkbox" name="variationCheckbox[]" class="variationCheckbox" value="<?php echo $productVariations['product_id']; ?>" attrProductId="<?php echo $pMasterids; ?>" attrVariationRelation="<?php echo $productVariations['id']; ?>">


						   				 	<input type="hidden" name="pid_attr[<?php echo $productVariations['product_id']; ?>]" value="<?php echo $pMasterids; ?>" />

						   				 	<label>Variation: <?php echo $mergeVariationName; ?></label>
								   			<label>SKU: <?php echo $productVariations['product_id']; ?></label>
								   			<label>Price: <?php echo $productVariations['price']; ?></label>
								   			
								   			<!--<label>Batch Number: <?php echo batchNameByBatchId($productVariations['batch_id']); ?></label>-->

		<!--<input type="hidden" value="<?php echo $productVariations['batch_id']; ?>" class="batch_id" name="batch_id[<?php echo $sku; ?>]" />-->

		<input type="hidden" value="<?php echo $productVariations['price']; ?>" class="price" name="price[<?php echo $sku; ?>]" />

								   			<ul>
								   				<li>
								   					<div class="dv-in">
								   						<span>Stock</span>
								   						<span id="stock_<?php echo $productVariations['product_id']; ?>" style="color:red"> 

								   							<?php 
								   								//echo '<pre>';print_r($productQty);
								   							?>
								   							<?php echo $productVariations['quantity'];?>

								   							<?php //echo $productQty[0]['stock_qty'];?>
								   						</span>
								   						<input value="<?php echo $productVariations['quantity'];?>" type="hidden" id="stock_val" name="stock_val[<?php echo $productVariations['product_id']; ?>]" />
								   					</div>
								   					<div class="dv-in">
													<span>Quantity</span>
													<span class="qty_keypress">
														<input class="quantity_input quantity_keypress" avlStock="<?php echo $productVariations['quantity'];?>" id="quantity_keypress_<?php echo $productVariations['product_id']; ?>" type="text"  name="quantity[<?php echo $productVariations['product_id']; ?>]" value="" />
													</span>
													<span for="name" class="stock-help-inline quantity_val_error_<?php echo $productVariations['product_id'];?>">  </span>
													</div>
								   				</li>
								   			</ul>
						   				 </li>
						   				 <?php } ?>
						   			</ul>
						   			<?php } else {
						   				echo 'No Variations';
						   			} ?>
								</li>
								<?php }
							} else {
								echo 'No Variations';
							}
						?>
					</ul>
					</div>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('reason_for_return') != '') echo 'error'; ?>">
               <label class="control-label" for="reason_for_return">Reason For Return</label>
               <div class="controls">
                  <textarea id="reason_for_return" name="reason_for_return"></textarea>
                  <span for="reason_for_return" class="help-inline reason_for_return_error"> <?php echo form_error('reason_for_return') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor transfer" type="submit">
               <i class="icon-ok bigger-110"></i>
               Return
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
   $(document).ready(function(){
  		//called when key is pressed in textbox
   	    $(".qty_keypress").keypress(function (e) {
			 //if the letter is not digit then display error and don't type anything
			 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			   //display error message
			   alert("Digits Only");
			   return false;
			 }
   		});
		
		$("#invoice_number").change(function(){
		var invoice_number = $("#invoice_number").val();
		var url      = window.location.href;
		$check_query_string = window.location.search;

		if($check_query_string==""){
			url +='/?invoice_number='+invoice_number;
			window.location.href = url;
		}
		else{
			$check_query_string = "";
			var url  = window.location.href.split('/?')[0];
			url += url.split($check_query_string,"") ;
			url +='/?invoice_number='+invoice_number;
			window.location.href = url;
		}
		
	}); 
		
   
		$(".multiselect-container li a label input").click(function(){
         var product_id= $(this).val();
		 $(".transfermenu ul #li_"+product_id).toggle();
		 $("#quantity_keypress_"+product_id).keyup(function(){

			var qty_val = $("#quantity_keypress_"+product_id).val();
			var stock_val = $("#stock_"+product_id).text();
			var url="<?php echo site_url();?>webadmin/managewarehouse/getStockQty";

   			$.ajax({
   			url: url,  
   			type:'POST',
   			data:"qty_val="+qty_val+"&stock_qty="+stock_val,
					success: function(data){
						if(data=="true")
						{
							$("#exceed_error_"+product_id).empty();
							$(".quantity_val_error_"+product_id).empty();
						}
						if(data=="false"){
							$("#exceed_error_"+product_id).text("This is Not Valid.");
							$("#quantity_keypress_"+product_id).val("");
							$(".quantity_val_error_"+product_id).empty();
						}
					}
				});
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

	
			var vendor_name =  $('#vendor_name').val();
			if(vendor_name==""){
				//alert("Please enter p name");
				$(".vendor_name_error").text("Please select Vendor Name.");
				error_count++;
			}else {
				 // hide message
				 $(".vendor_name_error").empty();
			}

			
			var reason_for_return =  $('#reason_for_return').val();
			if(reason_for_return==""){
				$(".reason_for_return_error").text("Please Write Reason For Return.");
				error_count++;
			}else {
				 $(".reason_for_return_error").empty();
			}


			var product_list =  $('#product_list').val();
			if(product_list==null || product_list==""){
				//alert("Please enter p name");
				$(".product_list_error").text("Please select Product.");
				error_count++;
			}else if(parseInt($('.variationCheckbox:checked').length) == 0) {
				$(".product_list_error").empty();
	            $(".product_variation_error").text("Please select atleast one product.");
	            error_count++;
	     	}else{
				// hide message
				$(".product_variation_error").empty();
			}



			$('.variationCheckbox:checked').each(function() {
				var skuCheckbox = $(this).val();
				var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();

				var avlStock = $('#quantity_keypress_'+skuCheckbox).attr('avlstock');
				
				//alert(avlStock+'<=='+quantity_val);

				if(quantity_val==""){
					$(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value");
					error_count++;
				} else if(parseInt(avlStock) < parseInt(quantity_val)) {
					$(".quantity_val_error_"+skuCheckbox).text("Please Enter Correct Quantity.");
					error_count++;
				} else {
					// hide message
					$(".quantity_val_error_"+skuCheckbox).empty();
				}
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


</body>
</html>