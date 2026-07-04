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
		  <a href="<?php echo site_url()."webadmin/managewarehouse/warehouseToStoreTransfer";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			Warehouse To Store Transfer
		  </button>
		  </a>
		  
		  <a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToStoreInvoice";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			View Warehouse To Store Invoice
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

                  if(isset($warehouseToStoreTransferAllRecords) && !empty($warehouseToStoreTransferAllRecords)){
			   ?>
               <div class="table-header tableThemeColor">Results For "Warehouse To Store Transfer"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Warehouse Name</th>
						      <th>Store Name</th>
                        <th>Batch Id</th>
                        <th>Product Name</th>
                        <th>Sku</th>
                        <th>Variation</th>
                        <th>Quantity</th>
                        <th>Modified Date</th>
                     </tr>
                  </thead>
                  <tbody>
				  	<?php
						$ctr=1;
						foreach($warehouseToStoreTransferAllRecords as $warehouseToStoreProduct){
							//if($uinfo['user_level']<$vendorToWHProduct->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td>
						<?php 
						$getWarehouseIdByWarehouseName = getWarehouseIdByWarehouseName($warehouseToStoreProduct->warehouse_id);
						if(isset($getWarehouseIdByWarehouseName) && !empty($getWarehouseIdByWarehouseName)){
							echo ucwords($getWarehouseIdByWarehouseName->warehouse_name);
						}
						?></td>
						<td>
						<?php $store_name = get_store_details_by_id($warehouseToStoreProduct->store_id);
						  echo ucfirst($store_name[0]['store_name']);?>
						</td>
                  <td><?php echo $warehouseToStoreProduct->batch_number; ?></td>
						<td>
						<?php 
                  if($warehouseToStoreProduct->master_product_id != 0) {
                     $product_name = product_name($warehouseToStoreProduct->master_product_id);
                     if(isset($product_name) && !empty($product_name)){
                        echo ucwords($product_name).' ('.$warehouseToStoreProduct->product_id.')';
                     }
                  } else {
                      $product_nameForId = product_name($warehouseToStoreProduct->product_id);
                     if(isset($product_nameForId) && !empty($product_nameForId)) {
                       echo ucwords($product_nameForId);
                     }
                  }
						?>
						</td>
                  <td><?php echo $warehouseToStoreProduct->product_id; ?></td>
                   <td>
                      <?php
                        $sku=$warehouseToStoreProduct->product_id;
                        $where=['sku'=>$sku];
                        $variationName=getSku('product_variations_relations',$where);
                       
                        $allVariationName=[];
                        foreach($variationName as $variationNames) {
                           $variationId=$variationNames['variation_id'];
                           if($variationId != 0) {
                              $where=['attribute_value_id'=>$variationId];
                               $variations=getSku('attribute_value',$where);
                               if(isset($variations) && !empty($variations)) {
                                 $allVariationName[]=$variations[0]['attribute_value'];
                               }
                           }
                        }

                        $mergeVariationName=implode(', ',$allVariationName);
                        echo (isset($mergeVariationName) ? $mergeVariationName : '-'); ?>
                   </td>
						<td><?php echo $warehouseToStoreProduct->quantity; ?></td>
						<td><?php echo $warehouseToStoreProduct->modify_date; ?></td>
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
   	      null, null, null, null,null, null, null, 
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