<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
		/* .transfermenu{
			margin-top:50px;
		} */
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
            <div class="control-group <?php if(form_error('store_from') != '') echo 'error'; ?>">
               <label class="control-label" for="store_from">Store From</label>
               <div class="controls">
                  <select name="store_from" class="store_from" id="store_from">
                     <option value="">Select Store</option>
                     <?php  
                        $store_details = store_details();
                        foreach($store_details as $store_details){ 
                        ?>
                     <option value="<?php echo $store_details['store_id'];?>" <?php echo  set_select('store_name', $store_details['store_id'], ( !empty($_GET['store_id']) && $_GET['store_id'] == $store_details['store_id'] ? TRUE : FALSE )); ?>><?php echo $store_details['store_name'];?></option>
                     <?php }	?>
                  </select>
				  <span for="name" class="help-inline store_from_error"> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('store_to') != '') echo 'error'; ?>">
               <label class="control-label" for="store_name">Store To</label>
               <div class="controls">
                  <select name="store_to" class="store_to" id="store_to">
                     <option value="">Select Store</option>
                     <?php 
                        $store_details = store_details();
                        foreach($store_details as $store_details){
							if($store_details['store_id']!=$_GET['store_id']){						
                        ?>
                     <option value="<?php echo $store_details['store_id'];?>"><?php echo $store_details['store_name'];?></option>
                     <?php }  }	?>
                  </select>
				  <span for="name" class="help-inline store_to_error"> </span>
               </div>
            </div>
            <div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Product In Warehouse</label>
               <div class="controls product_select">
                  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
                     <?php 				
						if(isset($_GET['store_id'])) { 
                        
						$product = product_in_store_inventory($_GET['store_id']);
						} else {
						$product = array();
						}
                        if(!empty($product)) { 
						foreach($product as $product){ 
						?>
					 <option value="<?php echo $product['product_id'];?>"><?php echo product_name($product['product_id']);?></option>
                    <?php }}
					else{?>
					
					<option value="">Product not Available</option>
					<?php }?>
				  </select>
				  <span for="country" class="help-inline product_list_error"> </span>
				  <div class="transfermenu"> 
                     <ul>
                        <?php 				
						if(isset($_GET['store_id'])) { 
                        
						$product = product_in_store_inventory($_GET['store_id']);
						} else {
						$product = array();
						}
                        if(!empty($product)) { 
						foreach($product as $product){  
						?>
						<li id="li_<?php echo $product['product_id'];?>">
                           <input type="hidden" value="<?php echo $product['product_id'];?>" name="product_in_warehouse[]" class="product_in_warehouse" id="product_in_warehouse_<?php echo $product['product_id']; ?>">
						   <p class="product_lbl"><?php echo product_name($product['product_id']);?></p>
									
									<span>Stock</span> :   
									<span id="stock_<?php echo $product['product_id']; ?>" style="color:red"> <?php echo $product['stock_qty'];?></span>
									 <input value="<?php echo $product['stock_qty'];?>" type="hidden" id="stock_val" name="stock_val[<?php echo $product['product_id']; ?>]" />
						   <ul id="quantity_<?php echo $product['product_id'];?>">
								<li>
								<span>Quantity</span>
								<span class="qty_keypress"><input class="quantity_input" id="quantity_keypress_<?php echo $product['product_id'];?>" type="text" class="quantity_keypress" name="quantity[<?php echo $product['product_id'];?>]" value="" /></span> 
									   <br>
									  <span class="stock-help-inline" id="exceed_error_<?php echo $product['product_id'];?>"></span>
									   
									  <span for="name" class="stock-help-inline quantity_val_error_<?php echo $product['product_id'];?>">  </span>
								</li>
						   </ul>
						   
						</li>						
						<?php } } 	?>
						
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
<?php $this->load->view('include/layout_footer');?>
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
		 $(".transfermenu ul #li_"+product_id).toggle();
		 $("#quantity_keypress_"+product_id).keyup(function(){
			var qty_val = $("#quantity_keypress_"+product_id).val();
			var stock_val = $("#stock_"+product_id).text();
			var url="<?php echo site_url();?>webadmin/managestore/getStockQty";
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
					$("#exceed_error_"+product_id).text("This Stock Not Availible.");
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
	   var store_from =  $('#store_from').val();
	   if(store_from=="")
	   {
		//alert("Please enter p name");
		$(".store_from_error").text("Please select Store From.");
		error_count++;
	   }
	   else {
		 // hide message
		 $(".store_from_error").empty();
		}
		
		var store_to =  $('#store_to').val();
		if(store_to=="")
	   {
		//alert("Please enter p name");
		$(".store_to_error").text("Please select Store To.");
		error_count++;
	   }
	   else {
		 // hide message
		 $(".store_to_error").empty();
		}
		
		var product_list =  $('#product_list').val();
		if(product_list==null || product_list=="")
		   {
			//alert("Please enter p name");
			$(".product_list_error").text("Please select Product.");
			error_count++;
		   }
	   else { 
		 // hide message
		 $(".product_list_error").empty();
		}
		
		var product_list =  $('#product_list').val();
		var str = ""+product_list+"";
		var my_array = str.split(',');
		for (var i = 0; i < my_array.length; i++) {
			//alert(my_array[i])
				var quantity_val = $('#quantity_keypress_'+my_array[i]).val();
				if(quantity_val=="")
				   {
					//alert("Please enter p name");
					$(".quantity_val_error_"+my_array[i]).text("Please Enter Quantity value");
					$("#exceed_error_"+my_array[i]).empty();
					error_count++;
				   }
			   else {
				 // hide message
				 $(".quantity_val_error_"+my_array[i]).empty();
				}
			}
		
		
		
		if(error_count>0) 
	   {  
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