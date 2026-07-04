<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

<div class="page-content">
   <div class="page-header position-relative">
   
      <h1 class="headingThemeColor"><?php echo $heading; ?></h1>
	  
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										
         </button>
         <strong>
         <i class="icon-remove"></i>
         Error!										
         </strong>
         <?php echo $this->session->flashdata('error_msg'); ?>
         <br />
      </div>
      <?php endif; ?>
	  
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										
         </button>
         <p>
            <strong>
            <i class="icon-ok"></i>
            Done!											
            </strong>
            <?php echo $this->session->flashdata('success_msg'); ?>										
         </p>
      </div>
      <?php endif; ?>
	  
	  <a href="<?php echo site_url()."webadmin/managewarehouse/vendorToWarehouseTransfer";?>">
	  <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
		<i class="icon-ok bigger-110"></i>
		Vendor To Warehouse
	  </button>
	  </a>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
                  if(isset($wareHouseInvoiceAllRecords) && !empty($wareHouseInvoiceAllRecords)){
			   ?>
               <div class="table-header tableThemeColor">Results for "Invoice"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Vendor Name</th>
						<th>Invoice Number</th>
						<th>Chalan Details</th>
						<th>Invoice Date</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>IP Address</th>
                        <th>Create Date</th>
                        <th>Modified Date</th>
                        <th>Return Policy</th>
						<th>Action</th>
						
                     </tr>
                  </thead>
                  <tbody>
				  	<?php 
						$permission_array = checkPermissionByUserRole($uinfo['user_role'],13);
						$ctr=1;
						foreach($wareHouseInvoiceAllRecords as $invoice){
							if($uinfo['user_level']<$invoice->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td><?php 
						  $vendor_name = vendor_name($invoice->vendor_id);
						  echo ucfirst($vendor_name->f_name).' '.ucfirst($vendor_name->l_name);
						?></td>
						<td>
						<?php 
						if(isset($invoice->invoice_number) && !empty($invoice->invoice_number)){
							echo $invoice->invoice_number;
						}else{
							echo 'Not added';
						}
						?>
						</td>
						<td><a href="javascript:void(0);" id="id-btn-dialog_<?php echo $invoice->invoice_id;?>" class="btn btn-purple btn-sm  vendor_Challan_link">Challan Details</a>
						<?php //print_r(getChallanDetails($invoice->invoice_id));?>
						</td>
						
						<div id="dialog-message_<?php echo $invoice->invoice_id;?>" class="hide">
											<?php $challan_details = getChallanDetails($invoice->invoice_id); 
											foreach($challan_details as $single){
											?>
											<p>
												Challan Number => <?php echo $single->challan_number;?><br>
												Challan Date => <?php echo date("Y-m-d",strtotime($single->challan_date));?>
											</p>
											<div class="hr hr-12 hr-double"></div>
											<?php }?>
						</div><!-- #dialog-message -->
						<td>
						<?php 
						if(isset($invoice->invoice_date) && !empty($invoice->invoice_date)){
							echo date('jS F Y',strtotime($invoice->invoice_date));
						}else{
							echo 'Not added';
						}
						?>
						</td>
						<td><?php 
						  $status = $invoice->status;
						  echo ($status==1) ? 'complete' : 'incomplete';
						?></td>
						<td><?php echo $invoice->comments; ?></td>
						<td><?php echo $invoice->ip_address; ?></td>
						<td><?php 
								$date_created = $invoice->create_date;
								$date=date_create($date_created);
								echo date_format($date,"d-D-Y h:i:s"); 
							?>
						</td>
						<td><?php 
								$date_created = $invoice->modified_date;
								$date=date_create($date_created);
								echo date_format($date,"d-D-Y h:i:s");
							?>
						</td>
						<td>
						<?php $getReturnInvoicesCount = getReturnInvoicesCount($invoice->invoice_number);
						if($getReturnInvoicesCount==1){
						?>
						<a class="btn btn-purple btn-sm" href="<?php echo site_url()."webadmin/managewarehouse/viewReturnPolicy/".$invoice->invoice_number; ?>">View Returns</a>
						<?php } else{?>
						<a href="<?php echo site_url()."webadmin/managewarehouse/returnPolicy"; ?>">Add Returns</a>
						<?php }?>
						</td>
						<td><a href="<?php echo site_url()."webadmin/managewarehouse/viewVendorToWarehouseProduct/".base64_encode($invoice->invoice_id); ?>">View Invoice</a>
						<div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/managewarehouse/editInvoice/".$invoice->invoice_id; ?>" class="tooltip-info" data-rel="tooltip" title="Edit Invoice">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														
                              </button>
                              </a>
                              <?php }?>
                           </div>
						</td>
						
					</tr>
					<?php $ctr++; 
						  } //end if condition	
						} //end foreach
					?>
				  </tbody>
			   </table>
               <?php
                  }else{ 
                  	echo '<div class="table-header">No Record Founds..!!!</div>';
                  }		
                  ?>
            </div><!--/span-->
         </div><!--/row-->
         <!--PAGE CONTENT ENDS-->
      </div><!--/.span-->
   </div><!--/.row-fluid-->
</div><!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
<script>
   $(function(){
   	    <!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null, null, null, null, null,null, null, null,null,
   		  { "bSortable": false }
   		] } );
   		
   		$('table th input:checkbox').on('click' , function(){
   			var that = this;
   			$(this).closest('table').find('tr > td:first-child input:checkbox')
   			.each(function(){
   				this.checked = that.checked;
   				$(this).closest('tr').toggleClass('selected');
   			});
   				
   		});
   		
   		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
   		function tooltip_placement(context, source) {
   			var $source = $(source);
   			var $parent = $source.closest('table')
   			var off1 = $parent.offset();
   			var w1 = $parent.width();
   	
   			var off2 = $source.offset();
   			var w2 = $source.width();
   	
   			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
   			return 'left';
   		}
   	   <!--jQuery Table//End-->
   });
</script>
<script>
$(document).ready(function(){
	$('body').on('click', '.vendor_Challan_link', function() {
//$( ".vendor_Challan_link").click(function(){

vendor_id=$(this).attr('id').split('id-btn-dialog_');
			
					var dialog = $( "#dialog-message_"+vendor_id[1] ).removeClass('hide').dialog({
						modal: true,
						title: "Challan Details",
						title_html: true,
						buttons: [ 
							{
								text: "Cancel",
								"class" : "btn btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							},
							{
								text: "OK",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			
				});
	
});
</script>
</body>
</html>