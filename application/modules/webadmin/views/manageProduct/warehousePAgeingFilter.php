<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

        <div>
          <table id="warehouseTableFilter" class="table table-striped table-bordered table-hover">
              <thead>
                 <tr>
                    <th class="center">#</th>
                    <th>Product Name</th>
                    <!--<th>Batch Number</th>-->
                    <th>SKU</th>
                    <th>Warehouse Name</th>
                    <th>Stock Quantity</th>
                    <th>Last Update</th>
                 </tr>
              </thead>
            <tbody>
               <?php if(isset($getWarehouseProductInfo) && !empty($getWarehouseProductInfo)) {
                  $ctr = 1;
                  foreach($getWarehouseProductInfo as $getWarehouseProductInfos) {

                        if($getWarehouseProductInfos['batch_id'] != 0) {
                          $batchId = $getWarehouseProductInfos['batch_id'];
                          $batchNumber = batchNameByBatchId($batchId);
                        } else {
                          $batchNumber = '';
                        }

                     $modifyDate = $getWarehouseProductInfos['modify_date'];
                     $todayDate = date('Y-m-d H:i:s');

                     /* date difference function */
                     $wProductAgeing = getDaysByDateDiff($modifyDate,$todayDate);

                      /* Get Min Stock Quantity */
                      $getMinStock = getSku('product',['product_id'=>$getWarehouseProductInfos['master_product_id']]);

                     $wqty = $getWarehouseProductInfos['stock_qty'];
                   ?>
                  <tr>
                     <td><?php echo $ctr; ?></td>
                     <td><?php echo product_name($getWarehouseProductInfos['master_product_id']); ?></td>
                     <!--<td><?php echo $batchNumber; ?></td>-->
                     <td><?php echo $getWarehouseProductInfos['product_id']; ?></td>
                     <td><?php echo getWarehouseName($getWarehouseProductInfos['warehouse_id']); ?></td>

                     <!-- Manage the Less than 10 quantity in stock -->
                     <?php if($wqty < $getMinStock[0]['min_stock_qty']) { ?>
                        <td class="qty_notify" attrQty="<?php echo $getWarehouseProductInfos['stock_qty']; ?>"><?php echo $getWarehouseProductInfos['stock_qty']; ?>
                        </td>
                     <?php } else { ?>
                        <td><?php echo $getWarehouseProductInfos['stock_qty']; ?>
                        </td>
                      <?php } ?>

                     <td><?php echo $wProductAgeing; ?></td>
                  </tr>
               <?php $ctr++; } } ?>
            </tbody>
          </table>
        </div>

<!--/.page-content-->
<style type="text/css">
   .qty_notify {
     background-color: #ef9a9a !important;
     font-color: black;
     font-weight: 600; 
   }
</style>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
   $(function(){
      $( "#tabs" ).tabs();

      $('#warehouseTableFilter').dataTable({
         "aoColumns": [
            { "bSortable": false },
   
            null, null,null, null,null,null,
         ]
      });

      $('.qty_notify').hover(function() {
        var qtyVal = $(this).attr('attrQty');
        $(this).attr('title','Quantity is less than 10.');
      });


     /* $('.warehouseAgeing').click(function() {
        var pId = $('.warehouseageingfilter').val();
          $.ajax({
            type:'POST',
            url:"<?php echo site_url();?>webadmin/manageproduct/productAgeing",
            data:"product_id="+pId,
            success:function(data){
              console.log(data);
            }
          })
      });*/

   });
</script>