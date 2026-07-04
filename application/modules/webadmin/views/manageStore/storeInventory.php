<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>

#myTable.table.table-hover.dataTable.table-striped.table-bordered {
    display: table !important;
    overflow-x: scroll;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <?php
         if ($this->session->flashdata('error_msg')):
         ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php
            echo $this->session->flashdata('error_msg');
            ?> <br />
      </div>
      <?php
         endif;
         ?>
      <?php
         if ($this->session->flashdata('success_msg')):
         ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php
            echo $this->session->flashdata('success_msg');
            ?> </p>
      </div>
      <?php
         endif;
         ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <div class="table-header tableThemeColor"> Results for "Store Inventory" </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Store Name</th>
      						<th>Product Name</th>
                        <!--<th>Batch Number</th>-->
                        <th>SKU</th>
                        <th>Variation</th>
      						<th>Product Image</th>
      						<th>Product Description</th>
                        <th>Stock Qty</th> 
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                      $ctr = 1;
                  if (isset($storeInventoryInfo) && !empty($storeInventoryInfo)) {

                        foreach ($storeInventoryInfo as $storeInventoryInfo) { 
                           $where=['sku'=>$storeInventoryInfo->sku];
                           $check=getStatus('product_variations_relations','flag',$where); 
                          
                           if($check->flag == 1) {
                              $status ='Active';
                           } else {
                              $status = 'Inactive';
                           }
                        ?>
                     <tr>
                        <td class="center"><?php
                           echo $ctr;
                           ?>
                        </td>
   						<td><?php
                              $get_store_details_by_id = get_store_details_by_id($storeInventoryInfo->store_id);
         							if(isset($get_store_details_by_id) && !empty($get_store_details_by_id)){
         								echo ucwords($get_store_details_by_id[0]['store_name']);
         							}
                        ?>
                     </td>
                        <td><?php
                           echo $storeInventoryInfo->product_name;
                           ?> 
                        </td>
                        <!--<td><?php echo $storeInventoryInfo->batch_number; ?></td>-->
                           <td><?php echo $storeInventoryInfo->sku; ?></td>
                           <td><?php
                              $sku=$storeInventoryInfo->sku;
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
                              echo (isset($mergeVariationName) ? $mergeVariationName : '-'); ?></td>
						         <td><img width="100" height="100" src="<?php
                           echo base_url() . 'uploads/product_image/thumbs/' . $storeInventoryInfo->product_image;
                           ;
                           ?>">
                        </td>
						<td><?php
                           echo $storeInventoryInfo->product_description;
                           ?>
                        </td>
                        <td class="stock_val_<?php echo $storeInventoryInfo->product_id; ?>"><?php
                           echo '<p id="qty_val_'.$storeInventoryInfo->product_id.'">'.$storeInventoryInfo->stock_qty.'</p>';
                           ?> 
						   <div style="display:none" id="update_qty_<?php echo $storeInventoryInfo->product_id; ?>">
						  
								<input id="quantity_<?php echo $storeInventoryInfo->product_id;?>" type="number" class="input_qty_val_<?php echo $storeInventoryInfo->product_id;?>"  value=""/>
								<button class="btn btn-info buttonThemeColor update" id="<?php echo $storeInventoryInfo->product_id; ?>" type="button" >Update</button>
						   
						   </div>
                           <div class="hidden-phone visible-desktop btn-group">
                             
                              <!--<a id="edit_qty_<?php echo $storeInventoryInfo->product_id; ?>" href="javascript:void(0)" class="tooltip-info" data-rel="tooltip" title="Edit">
                              <button class="btn btn-mini btn-info"> <i class="icon-edit bigger-120"></i> </button>
                              </a>-->
                           
                           </div>
                           <div class="hidden-desktop visible-phone">
                              <div class="inline position-relative">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog icon-only bigger-110"></i> </button>
                                 <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li> <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a> </li>
                                   
                                 </ul>
                              </div>
                           </div>
                        </td>
                        <td><?php echo $status; ?></td>
                     </tr>
                     <?php
                        $ctr++;
                        } }
                        ?>
                  </tbody>
               </table>
			  
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
<script>
   $(function(){
   		$(".tooltip-info").click(function(){
			var product_id=$(this).attr('id').split('edit_qty_');
			var stock_qty_val = $("#qty_val_"+product_id[1]).text();
			//alert(stock_qty_val);
			$("#update_qty_"+product_id[1]).toggle();
			$(".input_qty_val_"+product_id[1]).val(stock_qty_val);
			
			//called when key is pressed in textbox
			  $("#quantity_"+product_id[1]).keypress(function (e) {
				 //if the letter is not digit then display error and don't type anything
				 if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
					//display error message
				   alert("Digits Only");
						   return false;
				}
			   });
			
		
		});
		
		$( ".update" ).click(function() {
   			var product_id=$(this).attr('id');
			var stock_qty_val = $(".input_qty_val_"+product_id).val();
			//alert(stock_qty_val);
			var url="<?php echo site_url();?>webadmin/managewarehouse/changeStockQty";
			if(stock_qty_val!=""){
				$.ajax({
				url: url,
				type:'POST',
				data:"stock_qty="+stock_qty_val+"&product_id="+product_id,
				success: function(data){
					$("#qty_val_"+product_id).text(data);
					$("#update_qty_"+product_id).hide();
				}
				});
   			}
			else{
				alert("Please enter stock quantity");
			}
   		});
   		
   	<!--jQuery Table//Start-->
   
   		var oTable1 = $('#myTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null,null,null,null,null,null,
   		  
   
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