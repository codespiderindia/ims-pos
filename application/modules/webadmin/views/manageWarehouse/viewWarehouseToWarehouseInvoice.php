<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');
?>

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
	  
	  <a href="<?php echo site_url()."webadmin/managewarehouse/warehouseToWarehouseTransfer";?>">
	  <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
		<i class="icon-ok bigger-110"></i>
		Warehouse To Warehouse Transfer
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
               
                  if(isset($wareHouseToWarehouseInvoiceAllRecords) && !empty($wareHouseToWarehouseInvoiceAllRecords)){
			   ?>
               <div class="table-header tableThemeColor">Results for "Warehouse To Warehouse Invoice"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Warehouse From</th>
						      <th>Warehouse To</th>
                        <th>Status</th>
                        <th>Comments</th>
                        <th>Create Date</th>
                        <th>Modified Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
				  	<?php 
			
						$ctr=1;
			   
						$permission_array = checkPermissionByUserRole($uinfo['user_role'],13);
						foreach($wareHouseToWarehouseInvoiceAllRecords as $invoice){
							//if($uinfo['user_level']<$invoice->user_level || $uinfo['user_level']==1) {
							//if($invoice->warehouse_from==$uinfo['warehouse_id']){
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td><?php 
						  $getWarehouseIdByWarehouseName = getWarehouseIdByWarehouseName($invoice->warehouse_from);
							if(isset($getWarehouseIdByWarehouseName) && !empty($getWarehouseIdByWarehouseName)){
								echo ucwords($getWarehouseIdByWarehouseName->warehouse_name);
							}
						?></td>
						<td><?php 
						  $getWarehouseIdByWarehouseName = getWarehouseIdByWarehouseName($invoice->warehouse_to);
							if(isset($getWarehouseIdByWarehouseName) && !empty($getWarehouseIdByWarehouseName)){
								echo ucwords($getWarehouseIdByWarehouseName->warehouse_name);
							}
						?></td>
						<td><?php 
						  $status = $invoice->status;
						  echo ($status==1) ? 'complete' : 'incomplete';
						?></td>
						<?php if(isset($invoice->comments) && !empty($invoice->comments))
							{
								$comments = $invoice->comments;
							}
							else{
								$comments = "Comments Not Set";
							}
						?>
						<td><?php echo $comments; ?></td>
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
						<td><a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToWarehouseTransfer/".base64_encode($invoice->invoice_id); ?>">View Invoice</a></td>
					</tr>
					<?php $ctr++; 
						  //}
						//  } //end if condition	
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
<script>
   $(function(){
   		$(".delBtn").on(ace.click_event, function() {
   			var del_loc=this.href;
   			bootbox.confirm("Are you sure you want to delete this record?", function(result) {
   				if(result) {
   					window.location.href=del_loc;
   					//bootbox.alert("You are sure!");
   				}
   			});
   			return false;
   		});
   		
   	    <!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null, null, null, null, null,
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
</body>
</html>