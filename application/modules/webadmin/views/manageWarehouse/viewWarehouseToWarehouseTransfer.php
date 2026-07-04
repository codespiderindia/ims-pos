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
		  <a href="<?php echo site_url()."webadmin/managewarehouse/warehouseToWarehouseTransfer";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			Warehouse To Warehouse Transfer
		  </button>
		  </a>
		  
		  <a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToWarehouseInvoice";?>">
		  <button class="btn btn-info buttonThemeColor" type="submit">
			<i class="icon-ok bigger-110"></i>
			View Warehouse to Warehouse Invoice
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
               
               <div class="table-header tableThemeColor">Results For "Warehouse To Warehouse Transfer Products"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Warehouse From</th>
						      <th>Warehouse To ( MY Warehouse )</th>
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
                  if(isset($warehouseToWarehouseTransferAllRecords) && !empty($warehouseToWarehouseTransferAllRecords)){
						foreach($warehouseToWarehouseTransferAllRecords as $warehouseToWarehouseProduct){
							//if($uinfo['user_level']<$vendorToWHProduct->user_level || $uinfo['user_level']==1) {
					?>
				  	<tr>
						<td><?php echo $ctr; ?></td>
						<td>
						<?php 
						$getWarehouseIdByWarehouseName = getWarehouseIdByWarehouseName($warehouseToWarehouseProduct->warehouse_from);
							if(isset($getWarehouseIdByWarehouseName) && !empty($getWarehouseIdByWarehouseName)){
								echo ucwords($getWarehouseIdByWarehouseName->warehouse_name);
							}
						?></td>
						<td>
						<?php 
						$getWarehouseIdByWarehouseName = getWarehouseIdByWarehouseName($warehouseToWarehouseProduct->warehouse_to);
							if(isset($getWarehouseIdByWarehouseName) && !empty($getWarehouseIdByWarehouseName)){
								echo ucwords($getWarehouseIdByWarehouseName->warehouse_name);
							}
						?></td>
						<td>
						<?php 
                  $masterPId = $warehouseToWarehouseProduct->master_product_id;
						$pID = $warehouseToWarehouseProduct->product_id;

                  if($masterPId != 0) {
                     $product_name = product_name($masterPId);
                     echo ucwords($product_name);

                  } else {
                     $product_name = product_name($pID);
                     echo ucwords($product_name);
                  }
						?>
						</td>
                  <td><?php echo $warehouseToWarehouseProduct->product_id; ?></td>
                  <td>
                     <?php
                        $sku=$warehouseToWarehouseProduct->product_id;
                        $where=['sku'=>$sku];
                        $variationName=getSku('product_variations_relations',$where);
                       
                        if(!empty($variationName)) {
                           $allVariationName=[];
                           foreach($variationName as $variationNames) {
                              $variationId=$variationNames['variation_id'];
                              $where=['attribute_value_id'=>$variationId];
                              $variations=getSku('attribute_value',$where);

                              if(isset($variations) && !empty($variations)) {
                                 $allVariationName[]=$variations[0]['attribute_value'];
                              }
                              
                           }

                           $mergeVariationName=implode(', ',$allVariationName);
                           echo $mergeVariationName;
                        } else {
                           echo '-';
                        }
                         ?>
                  </td>
						<td><?php echo $warehouseToWarehouseProduct->quantity; ?></td>
						<td><?php 
                           $date_created = $warehouseToWarehouseProduct->modify_date;
                           $date=date_create($date_created);
                           echo date_format($date,"d-D-Y h:i:s");
                        ?>
                  </td>
					</tr>
					<?php $ctr++;
						    //} //end if condition
						} //end foreach
               }
					?>
				  </tbody>
			   </table>
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
   	      null, null, null,null, null, null,
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