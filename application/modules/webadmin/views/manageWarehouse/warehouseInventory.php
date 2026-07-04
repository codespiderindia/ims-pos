<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('webadmin_session_info'); 
?>
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
         <strong> <i class="icon-remove"></i> Error! </strong> 
			<?php echo $this->session->flashdata('error_msg');?> 
			<br />
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
               <div>
                  <select id="warehouse">
                     <option value="">Select Warehouse Name</option>
                     <?php $warehouse = getWarehousesOfCompCode($uinfo['comp_code']);
                        if(isset($warehouse) && !empty($warehouse)) {
                           foreach($warehouse as $warehouses) {
                              echo '<option value="'.$warehouses['warehouse_id'].'">'.$warehouses['warehouse_name'].'</option>';
                           }
                        }
                      ?>
                  </select>
                  <select id="product">
                      <option value="">Select Product Name</option>
                      <?php $product = productIdName($uinfo['comp_code']);
                        if(isset($product) && !empty($product)) {
                           foreach($product as $products) {
                              echo '<option value="'.$products->product_id.'">'.$products->product_name.'</option>';
                           }
                        }
                      ?>
                  </select>
                  <select id="attribute">
                      <option value="">Select Attribute</option>
                      <?php $attribute = getAttributesByCompCode($uinfo['comp_code']);
                      if(isset($attribute) && !empty($attribute)) {
                        foreach($attribute as $attributes) {
                           echo '<option value="'.$attributes['attribute_id'].'">'.$attributes['attribute_name'].'</option>';
                        }
                      }
                      ?>
                  </select>
                  <button name="search" class="search" style="margin-bottom: 10px;">Search</button>
               </div>
               <div class="inventory_content">
              
               <div class="table-header tableThemeColor"> Results for Warehouse Inventory </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Warehouse Name</th>
                        <th>Product Name</th>
                        <!--<th>Batch Number</th>-->
                        <th>Product Image</th>
                        <th>Product Description</th>
                        <th>SKU</th>
                        <th>Variation</th>
                        <th>Stock Qty</th>
                        <th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                     $ctr = 1;
                  if (isset($warehouseInventoryInfo) && !empty($warehouseInventoryInfo)) {
                        foreach ($warehouseInventoryInfo as $warehouseInventoryInfo) {

                           /*if($warehouseInventoryInfo->batch_id != 0) {
                             $batchId = $warehouseInventoryInfo->batch_id;
                             $batchNumber = batchNameByBatchId($batchId);
                           } else {
                             $batchNumber = '';
                           }*/


                           $where=['sku'=>$warehouseInventoryInfo->sku];
                           $check=getStatus('product_variations_relations','flag',$where); 
                          
                           if($check->flag == 1) {
                              $status ='Active';
                           } else {
                              $status = 'Inactive';
                           }
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr; ?></td>
                        <td><?php echo getWarehouseName($warehouseInventoryInfo->warehouse_id); ?></td>
                        <td><?php echo $warehouseInventoryInfo->product_name;
                           ?></td>
                        <!--<td><?php echo $batchNumber; ?></td>-->
                        <td><img width="100" height="100" src="<?php
                           echo base_url() . 'uploads/product_image/thumbs/' . $warehouseInventoryInfo->product_image;
                           ?>">
                        </td>
                        <td><?php echo $warehouseInventoryInfo->product_description; ?></td>
                        <td><?php echo $warehouseInventoryInfo->sku; ?></td>
                        <td><?php $where=['sku'=>$warehouseInventoryInfo->sku];

                        $getVariation=getSku('product_variations_relations',$where);
                          $arrayVariationId='';
                           foreach($getVariation as $getVariations) {
                              $arrayVariationId.=$getVariations['variation_id'].',';
                           }
                           
                           $variationIds = rtrim($arrayVariationId, ',');

                           $arrayVariationId=explode(',',$variationIds);
                           $variationName=getAllVariationNames($arrayVariationId);
                           //echo $productVariations['variation_ids'];
                           $allVariationName=[];
                           foreach($variationName as $variationNames) {
                              $allVariationName[]=$variationNames['attribute_value'];
                           }
                           
                          echo $mergeVariationName=implode(', ',$allVariationName); 

                         ?></td>
                        <td class="stock_val_<?php echo $warehouseInventoryInfo->product_id; ?>">
                           <?php
                              echo '<p id="qty_val_'.$warehouseInventoryInfo->product_id.'">'.$warehouseInventoryInfo->stock_qty.'</p>';
                              ?> 
                           <div style="display:none" id="update_qty_<?php echo $warehouseInventoryInfo->product_id; ?>">
                              <input id="quantity_<?php echo $warehouseInventoryInfo->product_id;?>" type="number" class="input_qty_val_<?php echo $warehouseInventoryInfo->product_id;?>"  value=""/>
                              <button class="btn btn-info buttonThemeColor update" id="<?php echo $warehouseInventoryInfo->product_id; ?>" type="button" >Update</button>
                           </div>
                           <div class="hidden-phone visible-desktop btn-group">
                            
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

   $(document).ready(function() {
      $('.search').click(function() {

          if($('#warehouse').val() != '') {
              var warehouse = $('#warehouse :selected').val();
            } else {
              var warehouse = '';
            }

            
            if($('#product').val() != '') {
              var product = $('#product :selected').val();
            } else {
              var product = '';
            }

            if($('#attribute').val() != '') {
              var attribute = $('#attribute :selected').val();
            } else {
              var attribute = '';
            }
            
            $.ajax({
               url: '<?php echo site_url();?>webadmin/managewarehouse/filterWarehouseInventory',
               type:'POST',
               data:"warehouse="+warehouse+"&product="+product+"&attribute="+attribute,
               success: function(data){
                  $('.inventory_content').html(data);
                  var oTable1 = $('#myTable').dataTable({
   
                  "aoColumns": [
                     { "bSortable": false },
                     null, null,null, null,null,null,null,null,null,
                  ] } );
               }
            });
      });
   });
   
</script>
</body>
</html>