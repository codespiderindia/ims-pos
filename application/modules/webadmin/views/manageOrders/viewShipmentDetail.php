<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
.lineheight_cls {
       line-height: 2;
}
.status_label {
   width: 10%;
   float: left;
}
</style>
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
                   ?>
               <div class="table-header tableThemeColor"> Results for "Shipments of Order" </div>
                <div class="order_detail_container">
                  <?php
                      $where=['order_id'=>$order_id];
                     $getOrderStatus=getSku('orders',$where);

                        if($getOrderStatus[0]['order_status'] == '3') {
                              $status = 'Completed';
                           } else if($getOrderStatus[0]['order_status'] == '2') {
                               $status = 'Processing';
                           } else {
                               $status = 'Pending';
                           }
                      ?>
                     <label class="control-label status_label">Order Status :</label>
                     <div class="order_status_content">
                        <h5>
                           <p id="static_order_statusId"><?php echo $status; ?></p>
                        </h5>

                        <div class="control-group" id="select_order_statusId">
                           <div class="controls">
                              <select name="orderstatus" id="orderstatus">
                                 <option value="3">Completed</option>
                              </select>
                              <button class="orderstatus btn btn-info buttonThemeColor">Update Status</button>
                           </div>
                        </div>
                     </div>
                     
                </div>

               <div class="shipment_detail_conatainer">
                  <?php
                  $qty=[];$qtyval=[];
                     foreach($orders as $orderss) {
                        $sku=$orderss->product_id;
                        $qty[$sku][]=$orderss->quantity;
                  } 
                  ?>
               </div>
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
                        // $dealer_name = dealer_name($single->dealer_id);
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $single->order_id;?></td>
                        <td><a href="<?php echo base_url();?>webadmin/manageorders/viewOrdersByOrderId/<?php echo $single->order_id; ?>/<?php echo $single->shipment_id; ?>"><?php echo $single->shipment_id;?></a></td>
                      
                        <td><?php echo product_name($single->master_product_id);?>
                        </td>

                        <td><span class="lineheight_cls"><?php echo trim($single->product_id).'</span></br>'; ?></td>

                        <td><?php echo trim($single->quantity).'</span></br>'; ?></td>

                        <td><?php echo $single->date; ?></td>
						      <td><?php echo $single->address; ?></td>
						      <td><?php echo $status; ?></td>
                     </tr>
                     <?php $ctr++; } ?>
                  </tbody>
               </table>
               <?php  }	 ?>
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
      $('#select_order_statusId').hide();
      var url="<?php echo base_url();?>webadmin/manageorders/checkShipmentStatus";

      $.ajax({
         type: 'post',
         url: url, 
         data: "orderId="+<?php echo $order_id; ?>,
         success: function (result) {
            var splitresult = result.split('_');

            if(splitresult[0] == '3') {
               $('#static_order_statusId').hide();
               $('#select_order_statusId').show();
            } else if(splitresult[0] == '2' || splitresult[0] == '1') {
               $('#static_order_statusId').show();
               $('#select_order_statusId').hide();
            } else {
               $('#static_order_statusId').show();
               $('#select_order_statusId').hide();
            }
         }
      })


	      $( "#start_date" ).datepicker();
		      $( "#end_date" ).datepicker();
	   //$('#start_date').datepicker();

      $('.orderstatus').on('click', function() {
         var status = $('#orderstatus').val();
         var statusUrl="<?php echo base_url();?>webadmin/manageorders/orderChangeStatusByOrderId";
            $.ajax({
            type: 'post',
            url: statusUrl, 
            data: {'orderId':<?php echo $order_id; ?>,
                   'orderStatus':status},
            success: function (result) {
              // var redirect = '<?php echo base_url();?>webadmin/manageorders/viewOrders';
              window.location.href = '<?php echo base_url();?>webadmin/manageorders/viewOrders';
            }
         })

      });
	   
	});
	</script>
<script>
   $(function(){
   		
         var oTable1 = $('#sample-table-2').dataTable( {
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,null,null,null,
         ] } );
   
   });
</script>
</body>
</html>