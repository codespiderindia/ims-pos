<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<style type="text/css">
   .page-content input[value="Go"] {
  padding: 3px 5px;
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
   
   <div> <form action="" >
   Order Created in last <select name="days" id="days" style="margin-top: 10px;">
   <option value="0">Days</option>
   <option value="7" <?php if(isset($_GET['days'])) { if($_GET['days']=='7') { echo "selected='selected'"; } } ?>>7Days</option>
   <option value="30" <?php if(isset($_GET['days'])) { if($_GET['days']=='30') { echo "selected='selected'"; } } ?>>30Days</option>
   <option value="60" <?php if(isset($_GET['days'])) { if($_GET['days']=='60') { echo "selected='selected'"; } } ?>>60Days</option>
   <option value="90" <?php if(isset($_GET['days'])) { if($_GET['days']=='90') { echo "selected='selected'"; } } ?>>90Days</option>
   </select> <input type="submit" value="Go" />
   </form>
   <form action="" >
   Order Between <input type="text" name="start_date" <?php if(isset($_GET['start_date'])) { ?> value="<?php echo $_GET['start_date']; ?>" <?php  } ?> id="start_date" style="margin-top: 10px;" />  and <input type="text" name="end_date" id="end_date" <?php if(isset($_GET['end_date'])) { ?> value="<?php echo $_GET['end_date']; ?>" <?php  } ?> style="margin-top: 10px;"/>
   </select> <input type="submit" class="goByDate" value="Go" />
   </form>
     </div>
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
               //echo '<pre>';print_r($getAllOrdersInfoByDealerId);
                  $ctr=1;
                  if(isset($getAllOrdersInfoByDealerId) && !empty($getAllOrdersInfoByDealerId)){ 
                   ?>
               <div class="table-header tableThemeColor"> Results for "Registered Orders" </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Invoice Number</th>
                        <th>Invoice Date</th>
                        <th>Type</th>
                        <th>Original Amount</th>
                        <th>Lr Number</th>
                        <th>Status</th>
                        <th>Order Id</th>
                        <th>View Shipment</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                     $amount = 0;
                        foreach($getAllOrdersInfoByDealerId as $single){
                            if($single->order_status == 3) {
                              $status = 'Completed';
                           } elseif($single->order_status == 2) {
                               $status = 'processing';
                           } else {
                               $status = 'pending';
                           }

                        $dealer_name = dealer_name($single->dealer_id);

                        // Get Dealer Account Data
                        $where = ['order_id'=>$single->order_id];
                        $dealerAccount = getSku('dealer_account', $where);
                        if(isset($dealerAccount) && !empty($dealerAccount)) {
                            $paymentFor = $dealerAccount[0]['payment_for'];

                           if($paymentFor == 1) {
                              $type = 'Invoice';
                           } else {
                              $type = 'Direct Pay';
                           }

                           $invoiceNumber = $dealerAccount[0]['invoice_id'];
                           $invoiceDate = $dealerAccount[0]['created'];
                           $amount = $dealerAccount[0]['amount'];
                        }


                        // Get Order Shipment Data
                        $orderShipment = getSku('order_shipment', $where);
                        if(isset($orderShipment) && !empty($orderShipment)) {
                           $lrNumber = $orderShipment[0]['lr_number'];
                        }

                        
                        // Get Tax Data
                        $taxVal = getSku('dealer_item', $where);
                        $totalTax = 0;
                        foreach($taxVal as $taxVals) {
                           $totalTax += $taxVals['cgst_amt'] + $taxVals['sgst_amt'] + $taxVals['igst_amt'];
                        }
                        $totalAmount = $amount - $totalTax;
                       
                       if(isset($invoiceNumber) && $invoiceNumber != '') {

                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <!--<td><a href="<?php echo base_url();?>webadmin/manageorders/viewOrdersByOrderId/<?php echo $single->order_id;?>"><?php echo (isset($invoiceNumber) ? $invoiceNumber : ''); ?></a></td>-->
                        <td><?php echo (isset($invoiceNumber) ? $invoiceNumber : ''); ?></td>
                        <td><?php echo (isset($invoiceDate) ? $invoiceDate : ''); ?></td>
                        <td><?php echo (isset($type) ? $type : ''); ?></td>
                        <td>
                           <span><?php echo 'Items  ' .'<b style="float:right;">INR'.$totalAmount.'</b>'; ?></span></br>
                           <span><?php echo 'Tax  ' .'<b style="float:right;">INR'.$totalTax.'</b>'; ?></span>
                           <hr style="margin: 10px 0 !important"></hr>
                           <span><?php echo 'Total  ' .'<b style="float:right;">INR'.$amount.'</b>'; ?></span>
                        </td>
                        <td><?php echo (isset($lrNumber) ? $lrNumber : ''); ?></td>
                        <td><?php echo $status;?></td>
                        <td><?php echo $single->order_id; ?></td>
                        <td><input class="btn btn-info buttonThemeColor" id="<?php echo $ctr;?>" type="button" name="submit_status" onclick="location.href='<?php echo base_url();?>dealer/manageorders/viewShipment/<?php echo $single->order_id;?>'" value="View Shipment"/>
                        <?php if($single->order_status=='3') {  ?> 
      						<input class="btn btn-info buttonThemeColor" id="<?php echo $ctr;?>" type="button" name="submit_status" onclick="location.href='<?php echo base_url();?>dealer/manageorders/orderPdfGenerator/<?php echo $single->order_id;?>'" value="Print Invoice"/>
      						<?php } ?>
						   </td>
                        
                     </tr>
                     <?php $ctr++; } } ?>
                  </tbody>
               </table>
               <?php
                  }	else { ?>    <div class="table-header tableThemeColor">   No records found. </div>  <?php }
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

         $('.goByDate').click(function() {
            var error_count = 0;

            if($( "#start_date" ).val() == '') {
               alert('Please Select Start Date.');
               error_count++;
               return false;
            } else if($( "#end_date" ).val() == '') {
               alert('Please Select End Date.');
               error_count++;
               return false;
            } else {
               return true;
            }

         });
	});
	</script>
<script>
   $(function(){
   		
   	<!--jQuery Table//Start-->
         var oTable1 = $('#sample-table-2').dataTable( {
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null, null,null,null,
           { "bSortable": false }
         ] } );
      <!--jQuery Table//End-->
   
   });
</script>
</body>
</html>