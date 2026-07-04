<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

<style type="text/css">
.tableTopBtn{
	float:right;
	margin:15px 0 6px;
}
</style>

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
	  
	  <div class="tableTopBtn">
		  <a href="<?php echo site_url()."webadmin/managestore/storeToStoreTransfer";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			Store To Store Transfer
		  </button>
		  </a>
		  
		  <a href="<?php echo site_url()."webadmin/managestore/viewStoreToStoreInvoice";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			View Store to Store Invoice
		  </button>
		  </a>
	  </div>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12"> 
               <?php
                  if(isset($storeToStoreTransferAllRecords) && !empty($storeToStoreTransferAllRecords)){
			   ?>
               <div class="table-header tableThemeColor">Results For "Store To Store Transfer Products"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Store From</th>
						<th>Store To</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Modified Date</th>
                     </tr>
                  </thead>
                  <tbody>
				  	<?php
						$ctr=1;
						foreach($storeToStoreTransferAllRecords as $storeToStoreProduct){
							//if($uinfo['user_level']<$vendorToWHProduct->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td>
						<?php 
						$get_store_details_by_id = get_store_details_by_id($storeToStoreProduct->store_from);
						if(isset($get_store_details_by_id) && !empty($get_store_details_by_id)){
							echo ucwords($get_store_details_by_id[0]['store_name']);
						}
						?></td>
						<td>
						<?php 
						$get_store_details_by_id = get_store_details_by_id($storeToStoreProduct->store_to);
						if(isset($get_store_details_by_id) && !empty($get_store_details_by_id)){
							echo ucwords($get_store_details_by_id[0]['store_name']);
						}
						?></td>
						<td>
						<?php 
						$product_name = product_name($storeToStoreProduct->product_id);
						if(isset($product_name) && !empty($product_name)){
							echo ucwords($product_name);
						}
						?>
						</td>
						<td><?php echo $storeToStoreProduct->quantity; ?></td>
						<td><?php echo $storeToStoreProduct->modify_date; ?></td>
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
<script>
   $(function(){
   	    <!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null, null, null,
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