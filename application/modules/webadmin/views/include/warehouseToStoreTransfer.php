<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
.transfermenu{
			margin-top:-15px;
		}
		.transfermenu ul{
			list-style:none;
			margin-left:0px!important;
			
		}
		.transfermenu ul li{
			float:left;
			margin-right: 70px;
			margin-bottom: 70px!important;
			width: 240px;
		}
		.transfermenu ul li ul{
			display:none;
			margin-left:0px;
			 margin-top: 10px;
			 width:66px;
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
            <div class="control-group <?php if(form_error('warehouse_name') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_name">Warehouse Name</label>
               <div class="controls">
                  <select name="warehouse_name" class="warehouse_name" id="warehouse_id">
                     <option value="">Select Warehouse</option>
                     <?php 
                        $warehouse_details = warehouse_details();
                        foreach($warehouse_details as $warehouse_details){ 
                        ?>
                     <option value="<?php echo $warehouse_details['warehouse_id'];?>"><?php echo $warehouse_details['warehouse_name'];?></option>
                     <?php }	?>
                  </select>
				  <span for="name" class="help-inline"> <?php echo form_error('warehouse_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('store_name') != '') echo 'error'; ?>">
               <label class="control-label" for="store_name">Store Name</label>
               <div class="controls">
                  <select name="store_name" class="store_name" id="store_name">
                     <option value="">Select Store</option>
                     <?php 
                        $store_details = store_details();
                        foreach($store_details as $store_details){ 
                        ?>
                     <option value="<?php echo $store_details['store_id'];?>"><?php echo $store_details['store_name'];?></option>
                     <?php }	?>
                  </select>
				  <span for="name" class="help-inline"> <?php echo form_error('store_name') ?> </span>
               </div>
            </div>
            <div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Product In Warehouse</label>
               <div class="controls">
                  <select name="product_list[]" class="role" id="product_list" multiple="multiple">
                     <?php 
                        $product = product_in_warehouse(4);
                        foreach($product as $product){ 
						?>
					 <option value="<?php echo $product['product_id'];?>"><?php echo product_name($product['product_id']);?></option>
                    <?php }?>
				  </select>
				
                  <span for="country" class="help-inline"> <?php echo form_error('weekly_off') ?> </span>
               </div>
            </div>
			
			
			<div class="control-group <?php if(form_error('product_in_warehouse') != '') echo 'error'; ?>">
               <label class="control-label" for="product_in_warehouse"></label>
               <div class="controls">
                  
				  <div class="transfermenu">
                     <ul>
                        <input value="" type="hidden" id="warehouse" name="warehouse" /> 
						 <?php 
						$warehouse_id ="";
						$warehouse_id =$_REQUEST['warehouse_id'];
						if(isset($warehouse_id) && !empty($warehouse_id)) { 
                        echo $warehouse_id;	
						$product = product_in_warehouse(4);
						} else {
						$product = array();
						}
                        if(!empty($product)) { 
						foreach($product as $product){ 
						?>
						<li>
                           <input type="checkbox" value="<?php echo $product['product_id'];?>" name="product_in_warehouse[]" class="product_in_warehouse" id="product_in_warehouse_<?php echo $product['product_id']; ?>">
						   <span class="lbl"><?php echo product_name($product['product_id']);?></span>
									
									
									 <input disabled value="<?php echo $product['stock_qty'];?>" style="width:50px" type="text" id="stock_<?php echo $product['product_id'];?>" name="stock" />	
									 <input value="<?php echo $product['stock_qty'];?>" type="hidden" id="stock_val" name="stock_val" />
						   <ul id="quantity_<?php echo $product['product_id'];?>">
								<li>
								<label>Quantity</label>
								  
									  <input id="quantity_keypress_<?php echo $product['product_id'];?>" type="text" class="quantity_keypress" name="quantity[]" value="" />
									  <br>
									  <span style="color:red" class="help-inline" id="exceed_error_<?php echo $product['product_id'];?>"></span>
									   
									  <span for="name" class="help-inline"> <?php echo form_error('quantity') ?> </span>
								</li>
						   </ul>
						   
						</li>						
						<?php } } 	?>
						
					</ul>
					</div>
                  <span for="name" class="help-inline"> <?php echo form_error('product_in_warehouse') ?> </span>
               </div>
            </div>
            <!--<div class="control-group <?php if(form_error('quantity') != '') echo 'error'; ?>">
               <label class="control-label" for="quantity">Quantity</label>
               <div class="controls">
                  <input type="number" id="quantity" name="quantity" value="<?php echo set_value('quantity') ?>" />
				  <span for="country" class="help-inline"> <?php echo form_error('quantity') ?> </span>
				  &nbsp;
				 Stock &nbsp;
				 <input disabled value="" style="width:100px" type="number" id="stock" name="stock" />	
				 <input value="" type="hidden" id="stock_val" name="stock_val" />	
			   </div>
            </div>-->
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
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
	  $(".quantity_keypress").keypress(function (e) {
		 //if the letter is not digit then display error and don't type anything
		 
		 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			//display error message
		   alert("Digits Only");
				   return false;
		}
		});
});
	   
	$(".warehouse_name").change(function(){
		var warehouse_id = $("#warehouse_id").val();
		
		 var url      = window.location.href;
		 window.location.href = url+'/?warehouse_id='+warehouse_id;
		 
	});
	
	$("#product_list").change(function(){alert($('#product_list').val());
         var product_id= $(this).attr('id').split('product_in_warehouse_');
		 
		 $("#quantity_"+product_id[1]).toggle();
		 $("#quantity_keypress_"+product_id[1]).keyup(function(){
			var qty_val = $("#quantity_keypress_"+product_id[1]).val();
			var stock_val = $("#stock_"+product_id[1]).val();
			var url="<?php echo site_url();?>webadmin/managewarehouse/getStockQty";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"qty_val="+qty_val+"&stock_qty="+stock_val,
   			success: function(data){
				if(data=="true")
				{
					$("#exceed_error_"+product_id[1]).empty();
				}
				if(data=="false"){
					$("#exceed_error_"+product_id[1]).text("This Stock Not Availible.");
					$("#quantity_keypress_"+product_id[1]).val("");
				}
   			}
			});
		 });
	});
			   
</script>
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#product_list').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
</body>
</html>