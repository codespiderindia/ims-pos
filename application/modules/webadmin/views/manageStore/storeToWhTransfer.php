<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
		/* .transfermenu{
			margin-top:50px;
		} */
		.transfermenu ul {
          display: inline-block;
          list-style: outside none none;
          margin-left: 0;
          margin-top: 10px;
          width: 100%;
      }
      .transfermenu ul li {
          border: 1px solid #cccccc;
          display: none;
          float: left;
          margin-bottom: 10px;
          margin-right: 10px;
          max-height: 300px;
          overflow: auto;
          padding: 10px;
          position: relative;
          width: calc(100% - 20px);
      }
      .transfermenu ul ul {
          margin-top: 0;
      }
      .transfermenu ul li ul li {
          border: 1px solid #cccccc;
          display: inline-block;
          margin-left: 0;
          margin-right: 0;
          margin-top: 0;
          overflow: inherit;
          padding: 12px;
          width: 30%;
          min-height: 50px;
      }
      /*.transfermenu ul li:hover ul{
         display:block;
      }*/
      .transfermenu ul li ul li label {
          font-size: 13px;
          margin: 0 0 0 22px;
      }
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
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">

            <?php if(isset($_GET['store_id']) && !empty($_GET['store_id'])) {
                $storeId = $_GET['store_id'];
            } else {
                $storeId = 0;
            } ?>
            <input type="hidden" name="store_id" value="<?php echo $storeId; ?>" class="store_id" />

            <div class="control-group <?php if(form_error('store_from') != '') echo 'error'; ?>">
               <label class="control-label" for="store_from">Store From</label>
               <div class="controls">
                  <select name="store_from" class="store_from" id="store_from">
                     <option value="">Select Store</option>
                     <?php  
                        $store_details = store_details($uinfo['comp_code']);
						if(isset($store_details) && !empty($store_details)){
                        	foreach($store_details as $store_details){ 
                        ?>
                     <option value="<?php echo $store_details['store_id'];?>" <?php echo  set_select('store_name', $store_details['store_id'], ( !empty($_GET['store_id']) && $_GET['store_id'] == $store_details['store_id'] ? TRUE : FALSE )); ?>><?php echo $store_details['store_name'];?></option>
                     <?php  } // end foreach
					 	} // end if
					 ?>
                  </select>
				  <span for="name" class="help-inline store_from_error"> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('warehouse_name') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_name">Warehouse To</label>
               <div class="controls">
                  <select name="warehouse_name" class="warehouse_name" id="warehouse_name">
                     <option value="">Select Warehouse</option>
                     <?php  
                        $warehouse_details = warehouse_details($uinfo['comp_code']);
						if(isset($warehouse_details) && !empty($warehouse_details)){
                        	foreach($warehouse_details as $warehouse_details){ 
                        ?>
                     <option value="<?php echo $warehouse_details['warehouse_id'];?>" <?php echo  set_select('warehouse_name', $warehouse_details['warehouse_id'], ( !empty($_GET['warehouse_id']) && $_GET['warehouse_id'] == $warehouse_details['warehouse_id'] ? TRUE : FALSE )); ?>><?php echo $warehouse_details['warehouse_name'];?></option>
                     <?php  } // end foreach
					 	} // end if
					 ?>
                  </select>
				  <span for="name" class="help-inline warehouse_name_error"> </span>
               </div>
            </div>
			
            <div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Product In Warehouse</label>
               <div class="controls product_select">
                  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
                     <?php 				
						if(isset($_GET['store_id'])) { 
							$product = product_in_store_inventory($_GET['store_id'], $uinfo['comp_code']);
						} else {
							$product = array();
						}
              if(!empty($product)){ 
							foreach($product as $product){ 
						?>
					 <option value="<?php echo $product['master_product_id'];?>"><?php echo product_name($product['master_product_id']);?></option>
                    <?php   } // end foreach
					    }else{ ?>
					<option value="">Product not Available</option>
					<?php } ?>
				  </select>
				  <span for="country" class="help-inline product_list_error"> </span>
				  <div class="transfermenu"> 
                     <ul>
                      <span for="country" class="help-inline product_variation_error"> </span>
                        <?php 				
						if(isset($_GET['store_id'])) { 
							$products = product_in_store_inventory($_GET['store_id'], $uinfo['comp_code']);
						}else{
							$products = array();
						}
                        if(!empty($products)) { 
							foreach($products as $product){  
                $pId = $product['master_product_id'];
						?>
						<li id="li_<?php echo $product['master_product_id'];?>">
                <input type="hidden" value="<?php echo $product['master_product_id'];?>" name="product_in_warehouse[]" class="product_in_warehouse" id="product_in_warehouse_<?php echo $product['master_product_id']; ?>">

						   <p class="product_lbl"><?php echo product_name($product['master_product_id']);?></p>


                  <!--<label>Select Batch</label>
                  <select name="batches[<?php echo $pId; ?>]" class="batches" id="batches_<?php echo $pId; ?>" attrPid="<?php echo $pId; ?>">
                    <?php $batchs = getProductBatchsForStoreTransfer($_GET['store_id'], $pId, $uinfo['comp_code']);
                    foreach($batchs as $batch) { ?>
                      <option value="<?php echo $batch['product_batch_id']; ?>"><?php echo $batch['batch_number']; ?></option>
                    <?php } ?>
                  </select>-->


                  <div id ="inventory_sku_<?php echo $pId; ?>">

                  </div>

                  <?php $productVariation=getProductVariation($product['master_product_id']); ?>
						</li>						
						<?php } } ?>
					  </ul>
				  </div>
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
<?php $this->load->view('include/layout_footer'); ?>
<script>
	$(document).ready(function(){

    $('.batches').change(function() {

      var batchId = $(this).val();
      var masterPId = $(this).attr('attrPid');
      var storeId = $('.store_id').val();
      var url="<?php echo site_url();?>webadmin/managestore/getBatchSkuStoreQty";

      $.ajax({
        url: url,  
          type:'POST',
          data:"p_id="+masterPId+"&batch_id="+batchId+"&store_id="+storeId,
          success: function(data){
            $('#inventory_sku_'+masterPId).html(data);
          }
      });
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
   
   	   
   	$(".store_from").change(function(){
   		var store_id = $("#store_from").val();
   		var url      = window.location.href;
   		$check_query_string = window.location.search;
   		if($check_query_string==""){
   			url +='/?store_id='+store_id;
   			window.location.href = url;
   		}
   		else{
   			$check_query_string = "";
   			var url  = window.location.href.split('/?')[0];
   			url += url.split($check_query_string,"") ;
   			url +='/?store_id='+store_id;
   			window.location.href = url;
   		}
   		
   	}); 
   	
   	$(".multiselect-container li a label input").click(function(){
         var product_id= $(this).val();
   		  $(".transfermenu ul #li_"+product_id).toggle(function() {
            if($(".transfermenu ul #li_"+product_id).is(":visible")){

             // var batchId = $('#batches_'+product_id).val();
              var masterPId = product_id;
              var storeId = $('.store_id').val();
              var url="<?php echo site_url();?>webadmin/managestore/getBatchSkuStoreQty";

              $.ajax({
                url: url,  
                  type:'POST',
                  data:"p_id="+masterPId+"&store_id="+storeId,
                  success: function(data){
                    $('#inventory_sku_'+masterPId).html(data);
                  }
              });

               $(this).find('.stock_cls').each(function() {
               var qty = $(this).text();
               if(qty==0) {
                  var variation = $(this).attr('attrval');
                  $('#variationchk_'+variation).attr('disabled','disabled');
                  $('#quantity_keypress_'+variation).attr('disabled','disabled');
               } 
               });
            }
          });

   		/* $("#quantity_keypress_"+product_id).keyup(function(){
   			var qty_val = $("#quantity_keypress_"+product_id).val();
   			var stock_val = $("#stock_"+product_id).text();
   			var url="<?php echo site_url();?>webadmin/managestore/getStockQty";
      			$.ajax({
					url: url,  
					type:'POST',
					data:"qty_val="+qty_val+"&stock_qty="+stock_val,
					success: function(data){
						if(data=="true"){
							$("#exceed_error_"+product_id).empty();
							$(".quantity_val_error_"+product_id).empty();
						}
						if(data=="false"){
							$("#exceed_error_"+product_id).text("This Stock Not Availible.");
							$("#quantity_keypress_"+product_id).val("");
							$(".quantity_val_error_"+product_id).empty();
						}
					}
   				});
   		 }); */
   	});

      $(".quantity_input").keyup(function() {
      var sku = $(this).attr('attrSku');
      var stock_val = $("#stock_"+sku).text();
      //console.log(stock_val);
      var totalStock = $.trim(stock_val); 
      var qty_val = $("#quantity_keypress_"+sku).val();
      var url="<?php echo site_url();?>webadmin/managestore/getStockQty";
            $.ajax({
            url: url,  
            type:'POST',
            data:"qty_val="+qty_val+"&stock_qty="+totalStock,
            success: function(data){
            if(data=="true")
            {
               $("#exceed_error_"+sku).empty();
               $(".quantity_val_error_"+sku).empty();
            }
            if(data=="false"){
               $("#exceed_error_"+sku).text("This Stock Not Availible.");
               //$("#quantity_keypress_"+sku).val("");
               $(".quantity_val_error_"+sku).empty();
            }
            }
         });
   });
   	
   	
   	  //form validation
      $( ".transfer" ).on("click",function() { 
   	    var error_count = 0;		
   	    var store_from =  $('#store_from').val();
   	    if(store_from==""){
   	       //alert("Please enter p name");
   		   $(".store_from_error").text("Please select Store From.");
   		   error_count++;
   	    }else {
   		   //hide message
   		   $(".store_from_error").empty();
   	    }
   		
   		var warehouse_name =  $('#warehouse_name').val();
   		if(warehouse_name==""){
   		   //alert("Please enter p name");
   		   $(".warehouse_name_error").text("Please select Warehouse To.");
   		   error_count++;
   	    }else {
   		   //hide message
   		   $(".warehouse_name_error").empty();
   		}
   		
   		var product_list = $('#product_list').val();
   		if(product_list==null || product_list==""){
   			//alert("Please enter p name");
   			$(".product_list_error").text("Please select Product.");
   			error_count++;
   		}else if(parseInt($('.variationCheckbox:checked').length) <= 0) {
          $(".product_variation_error").text("Please select atleast one product.");
          error_count++;
      }else{ 
   		    //hide message
   		    $(".product_list_error").empty();
   		}

         $('.variationCheckbox:checked').each(function() {
            var skuCheckbox = $(this).val();

            var stock = $('#stock_'+skuCheckbox).text();
            var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
            var trimstock = $.trim(stock);
            if(parseInt(trimstock)<parseInt(quantity_val)) {
              $("#exceed_error_"+skuCheckbox).text("Please Enter Correct Quantity.");
              $("#quantity_keypress_"+skuCheckbox).val('');
              error_count++;
            } else {
              $("#exceed_error_"+skuCheckbox).text("");
            }

            if(quantity_val=="")
            {
                  $(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value");
               $("#exceed_error_"+skuCheckbox).empty();
                  error_count++;
            } else {
                  $(".quantity_val_error_"+skuCheckbox).empty();
            }
         });

   		
   		var product_list = $('#product_list').val();
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
   			}else{
   				// hide message
   				$(".quantity_val_error_"+my_array[i]).empty();
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
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css" rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script type="text/javascript">
   $('#product_list').multiselect();
</script>
<!--multiselect scripts related to this page-->
</body>
</html>