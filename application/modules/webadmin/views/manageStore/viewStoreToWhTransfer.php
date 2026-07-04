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
		  <a href="<?php echo site_url()."webadmin/managestore/storeToWhTransfer";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			Store To Wh Transfer
		  </button>
		  </a>
		  
		  <a href="<?php echo site_url()."webadmin/managestore/viewStoreToWhInvoice";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			View Store To Wh Invoice
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

               if(isset($storeToWhTransferAllRecords) && !empty($storeToWhTransferAllRecords)){
			   ?>
               <div class="table-header tableThemeColor">Results for "Transfer" </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Store From</th>
						      <th>Warehouse To</th>
                        <th>Product Name</th>
                        <!--<th>Batch Number</th>-->
                        <th>SKU</th>
                        <th>Variation</th>
                        <th>Quantity</th>
						      <th>IP Address</th>
                        <th>Create Date</th>
                        <th>Modified Date</th>
                     </tr>
                  </thead>
                  <tbody>
				  	<?php
						$ctr=1;
						foreach($storeToWhTransferAllRecords as $storeToWhProduct){
							//if($uinfo['user_level']<$vendorToWHProduct->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td>
						<?php 
						$store_name = get_store_details_by_id($storeToWhProduct->store_from);
						if(isset($store_name) && !empty($store_name)){
							echo ucwords($store_name[0]['store_name']);
						}
						?></td>
						<td>
						<?php 
						$warehouse_name = getWarehouseName($storeToWhProduct->warehouse_to);
						if(isset($warehouse_name) && !empty($warehouse_name)){
							echo ucwords($warehouse_name);
						}
						?></td>
						<td>
						<?php 
						$product_name = product_name($storeToWhProduct->master_product_id);
						if(isset($product_name) && !empty($product_name)){
							echo ucwords($product_name);
						}
						?>
						</td>
                  <!--<td><?php echo $storeToWhProduct->batch_number; ?></td>-->
                  <td><?php echo $storeToWhProduct->product_id;?></td>
                  <td><?php $sku=$storeToWhProduct->product_id;

                        $where=['sku'=>$sku];
                        $variationName=getSku('product_variations_relations',$where);
                        
                        $allVariationName=[];
                        if(isset($variationName) && !empty($variationName)) {
                           foreach($variationName as $variationNames) {
                              $variationId=$variationNames['variation_id'];
                              $where=['attribute_value_id'=>$variationId];
                              $variations=getSku('attribute_value',$where);
                              if(isset($variations) && !empty($variations)) {
                                 $allVariationName[]=$variations[0]['attribute_value'];
                              }
                           }
                        }

                        $mergeVariationName=implode(', ',$allVariationName);
                        echo $mergeVariationName; ?>
                  </td>
						<td><?php echo $storeToWhProduct->quantity;?></td>
						<td><?php echo $storeToWhProduct->ip_address; ?></td>
						<td><?php echo $storeToWhProduct->create_date; ?></td>
						<td><?php echo $storeToWhProduct->modified_date; ?></td>
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
   	      null, null, null, null, null, null, null, null,
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