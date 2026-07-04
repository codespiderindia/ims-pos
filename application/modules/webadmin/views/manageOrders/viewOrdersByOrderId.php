<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <a href="<?php echo base_url();?>webadmin/manageorders/viewOrders">
     <button style="float:right;margin:15px 0 6px;" type="submit" class="btn btn-info buttonThemeColor">
      Back
     </button>
     </a>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_mail')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_mail'); ?> </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('error_mail')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_mail'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
                  if(isset($ordersByOrderId) && !empty($ordersByOrderId)){ 
                   ?>
				   
               <div class="table-header tableThemeColor"> Results for "Order Details" </div>
			  
				<form class="form-horizontal" action="<?php echo base_url() . 'webadmin/manageorders/orderChangeStatus';?>" method="post" enctype="multipart/form-data">
				 	
					<input type="hidden" name="orderId" id="orderId" value="<?php echo $ordersByOrderId->order_id;?>" />
					<input type="hidden" name="shipmentId" id="shipmentId" value="<?php echo $ordersByOrderId->shipment_id;?>" />
				 	
				    <?php 
					if(isset($ordersByOrderId) && !empty($ordersByOrderId)){
						$dealer_name = dealer_name($ordersByOrderId->dealer_id);
					?>
					<table class="table table-bordered table-striped">
						<tr>
							<th>Order Id</th>
							<td><?php echo $ordersByOrderId->order_id;?></td>
						</tr>
						<tr>
							<th>Dealer Name</th>
							<td><?php echo $dealer_name[0]->f_name.$dealer_name[0]->l_name;?></td>
						</tr>
					<?php } ?>
					<?php
					if(isset($ordersDetailsByOrderId) && !empty($ordersDetailsByOrderId)){
					?>	
						<tr>
							<th>Product Name</th>
							<td><?php echo product_name($ordersDetailsByOrderId[0]->master_product_id);  ?></td>
						</tr>
						<tr>
							<th>SKU</th>
							<td><?php 
								  $productIdArr = array();
								  foreach($ordersDetailsByOrderId as $single){
									$productIdArr[] = $single->product_id;
								  }
								  echo implode(', ',$productIdArr);
								  ?>
							</td>
						</tr>
						<tr>
							<th>Quantity</th>
							<td><?php 
								  $quantityArr = array();
								  foreach($ordersDetailsByOrderId as $single){
									$quantityArr[] = $single->quantity;
								  }
								  echo implode(', ',$quantityArr);
								  ?>
							</td>
						</tr>
						<tr>
							<th>Price</th>
							<td>
								<?php 
								  $priceArr = array();
								  foreach($ordersDetailsByOrderId as $single){
									$priceArr[] = $single->price;
								  }
								  echo implode(', ',$priceArr);
								?>
							</td>
						</tr>
						<tr>
							<th>Date</th>
							<td><?php echo $ordersByOrderId->date; ?></td>
						</tr>
					</table>
					<?php } ?>
					 <div class="table-header tableThemeColor"> Results for "Order Shipping Address" </div>
					<?php if(isset($getShippingAddress) && !empty($getShippingAddress)){ 
					//echo '<pre>';
					//print_r($getShippingAddress);
					?>
					
					<div class="control-group">
					   <label class="control-label">Shipping Address</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_address; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping City</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_city; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping State</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_state; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping Country</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_country; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping Zipcode</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_zipcode; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping Mobile Number</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_mobile_number; ?>
					   </div>
					</div>
					<div class="control-group">
					   <label class="control-label">Shipping Notes</label>
					   <div class="controls">
						  <?php echo $getShippingAddress->shipping_notes; ?>
					   </div>
					</div>
					
					<?php }else{ ?> 

					<?php if(isset($getCustomerAddress)){ ?>

						<div class="control-group">
						   <label class="control-label">Shipping Address</label>
						   <div class="controls">
							  <?php echo $getCustomerAddress->address; ?>
						   </div>
						</div>
						<div class="control-group">
						   <label class="control-label">Shipping City</label>
						   <div class="controls">
							  <?php echo $getCustomerAddress->city; ?>
						   </div>
						</div>
						<div class="control-group">
						   <label class="control-label">Shipping Zipcode</label>
						   <div class="controls">
							  <?php echo $getCustomerAddress->zipcode; ?>
						   </div>
						</div>
						<div class="control-group">
						   <label class="control-label">Shipping Mobile Number</label>
						   <div class="controls">
							  <?php echo $getCustomerAddress->mobile_number; ?>
						   </div>
						</div>
					<?php } ?>
					<?php } ?>

					
					<!--<div class="control-group">
					   <label class="control-label">Order Status</label>
					   <div class="controls">
						  <select name="orderStatus" class="orderStatus" id="orderStatus">
							 <option value="Pending" <?php  if($ordersByOrderId->order_status=='pending'){ echo 'selected="selected"'; }?>>Pending</option>
							 <option value="Complete" <?php if($ordersByOrderId->order_status=='complete'){ echo 'selected="selected"'; } ?>>Complete</option>
							 <option value="Shipped" <?php if($ordersByOrderId->order_status=='shipped'){ echo 'selected="selected"'; }?>>Shipped</option>
							  <option value="Shipped" <?php if($ordersByOrderId->order_status=='processing'){ echo 'selected="selected"'; }?>>processing</option>

						  </select>
					   </div>
					</div>-->
					
					<?php if($ordersByOrderId->shipment_status=='3') { ?>

					<div class="control-group">
					   <label class="control-label">Shipment Status</label>
					   <div class="controls">
						  <select name="shippingStatus" class="orderStatus" id="orderStatus">
							 <option value="3" <?php if($ordersByOrderId->shipment_status=='3'){ echo 'selected="selected"'; }?>>Shipped</option>
						  </select>
					   </div>
					</div>
					<?php } else { ?>
					
					<div class="control-group">
					   <label class="control-label">Shipment Status</label>
					   <div class="controls">
						  <select name="shippingStatus" class="orderStatus" id="orderStatus">
							 <option value="1" <?php  if($ordersByOrderId->shipment_status=='1'){ echo 'selected="selected"'; }?>>Pending</option>
							 <option value="2" <?php if($ordersByOrderId->shipment_status=='2'){ echo 'selected="selected"'; }?>>Processing</option>
							 <option value="3" <?php if($ordersByOrderId->shipment_status=='3'){ echo 'selected="selected"'; }?>>Shipped</option>
						  </select>
					   </div>
					</div>
					<?php } ?>



					
					<div class="form-actions">
					   <button class="btn btn-info buttonThemeColor" type="submit">
					   <i class="icon-ok bigger-110"></i>
					   Change Status
					   </button>
					   &nbsp; &nbsp; &nbsp;
					   <!--<button class="btn" type="reset">
						  <i class="icon-undo bigger-110"></i>
						  Reset
						  </button>-->
					</div>
				 </form>
			   
               <?php
                  }	
                   ?>
            </div>
            <!--/span-->
         </div>
         <!--/row-->
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
<script>
   $(function(){
   		
   	<!--jQuery Table//Start-->
         var oTable1 = $('#sample-table-2').dataTable( {
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,null,
           { "bSortable": false }
         ] } );
      <!--jQuery Table//End-->
   
   });
</script>
</body>
</html>