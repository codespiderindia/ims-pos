<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <a href="<?php echo base_url();?>dealer/manageorders/viewOrders">
     <button style="float:right;margin:15px 0 6px;" type="submit" class="btn btn-info buttonThemeColor">
      Back
     </button>
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
                  if(isset($ordersByOrderId) && !empty($ordersByOrderId)){ 
                   ?>
               <div class="table-header tableThemeColor"> Results for "Orders Details" </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Order Id</th>
                        <th>Dealer Name</th>
                        <th>Product Name</th>
                        <th>SKU</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Order Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        foreach($ordersByOrderId as $single){
                            if($single->order_status == 3) {
                              $status = 'completed';
                           } elseif($single->order_status == 2) {
                               $status = 'processing';
                           } else {
                               $status = 'pending';
                           }

                        $dealer_name = dealer_name($single->dealer_id);
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><a href="javascript:void(0)"><?php echo $single->order_id;?></a></td>
                        <td><?php echo $dealer_name[0]->f_name.$dealer_name[0]->l_name;?></td>
                        <td><?php echo product_name($single->master_product_id);?></td>
                        <td><?php echo $single->product_id?></td>
                        <td><?php echo $single->quantity?></td>
                        <td><?php echo $single->price?></td>
                        <td><?php echo $single->date?></td>
                        <td><?php echo $status;?></td>
                     </tr>
                     <?php $ctr++; }?>
                  </tbody>
               </table>
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