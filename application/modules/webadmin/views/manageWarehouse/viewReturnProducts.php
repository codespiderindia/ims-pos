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
	  
	  <a href="<?php echo site_url()."webadmin/managewarehouse/returnPolicy";?>">
	  <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
		<i class="icon-ok bigger-110"></i>
		Return Products
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
                  if(isset($returnProductsInfo) && !empty($returnProductsInfo)){
			   ?>
               <div class="table-header tableThemeColor">Results for "Return Products"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Return Number</th>
      						<th>Invoice Number</th>
      						<th>Product Name</th>
                        <!--<th>Batch Number</th>-->
      						<th>Quantity</th>
      						<th>Create Date</th>
                     </tr>
                  </thead>
                  <tbody>
				  	<?php 
						$permission_array = checkPermissionByUserRole($uinfo['user_role'],13);
						$ctr=1;
						foreach($returnProductsInfo as $invoice){
						
							//if($uinfo['user_level']<$invoice->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td>
						<?php 
						if(isset($invoice->return_number) && !empty($invoice->return_number)){
							echo $invoice->return_number;
						}else{
							echo 'Not added';
						}
						?>
						</td>
						<td>
						<?php 
						if(isset($invoice->invoice_number) && !empty($invoice->invoice_number)){
							echo $invoice->invoice_number;
						}else{
							echo 'Not added';
						}
						?>
						</td>
						<td><?php 
						  $product_name = product_name($invoice->master_product_id);
						  echo ucwords($product_name).'('.$invoice->product_id.')';
						?></td>
                  <!--<td><?php echo batchNameByBatchId($invoice->batch_id); ?></td>-->
						<td>
						<?php 
						if(isset($invoice->quantity) && !empty($invoice->quantity)){
							echo $invoice->quantity;
						}
						?>
						</td>
						<td><?php echo $invoice->create_date; ?></td>
						
					</tr>
					<?php $ctr++; 
						  //} //end if condition	
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
   	      null, null, null,null,
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
   			var $parent = $source.closest('table');
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
$( ".vendor_Challan_link").click(function(){
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