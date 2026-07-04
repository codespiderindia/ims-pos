<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
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
                  $ctr=1;
                  if(isset($orders) && !empty($orders)){
				  //print_r($orders);
				   
                   ?>
               <div class="table-header tableThemeColor"> Results for "Shipments of Order" </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Order Id</th>
                        <th>Shipment Id</th>
      						<th>Product Name</th>
                        <th>SKU</th>
      						<th>Qty</th>
                        <th>Date</th>
						      <th>Shipment Adrress</th>
                        <th>Shipment Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        foreach($orders as $single){
                            if($single->shipment_status == 3) {
                              $status = 'shipped';
                           } elseif($single->shipment_status == 2) {
                               $status = 'processing';
                           } else {
                               $status = 'pending';
                           }
//                        $dealer_name = dealer_name($single->dealer_id);
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><a href="<?php echo base_url();?>dealer/manageorders/viewOrdersByOrderId/<?php echo $single->order_id;?>"><?php echo $single->order_id;?></a></td>
                        <td><?php echo $single->shipment_id; ?></td>
                        <td><?php echo product_name($single->master_product_id);?></td>
                        <th><?php echo $single->product_id;?></th>
                        <td><?php echo $single->quantity;?></td>
                        <td><?php echo $single->date; ?></td>
      						<td><?php echo $single->address; ?></td>
      						<td><?php echo $status; ?></td>
                     </tr>
                     <?php $ctr++; }?>
                  </tbody>
               </table>
               <?php
                  }	else { 
                     echo ' <div class="table-header tableThemeColor">No Results for "Shipments of Order" </div>';
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
	      $( "#start_date" ).datepicker();
		      $( "#end_date" ).datepicker();
	   //$('#start_date').datepicker();
	   
	});
	</script>
<script>
   $(function(){
   		
   	<!--jQuery Table//Start-->
         var oTable1 = $('#sample-table-2').dataTable( {
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,
           { "bSortable": false }
         ] } );
      <!--jQuery Table//End-->
   
   });
</script>
</body>
</html>