<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<style>
.ui-slider .ui-slider-handle {
    height: 15px;
    width: 5px;
    padding-left: 5px; 
}
.bold-range {
  margin-top: 4px;
  width: 4.5%;
  float: left;
}
.qty {
  margin-top: 5px;
  width: 7%;
  float: left;
}
#slider-range-store, #slider-range {
  width: 60% !important;
  float: left !important;
  margin-top: 10px;
}
.search_ageing_product {
  margin-left: 10px;
}
.qtyrange-label {
  margin-bottom: 0;
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
               <div class="table-header tableThemeColor"> Results for "Product Ageing"</div>

               <div id="tabs">
                 <ul>
                   <li><a href="#tabs-1">Warehouse</a></li>
                   <li><a href="#tabs-2">Store</a></li>
                 </ul>
                 <div id="tabs-1">
                    <div class="filter_content"> 
                        <label>Select Product</label>
                         <select name="wproduct" id="warehouseageingproduct" class="warehouseageingfilter product_id">
                            <option value="">Select Product</option>
                            <?php if(!empty($product)) { ?>
                              <option value="allproduct">All</option>
                            <?php } ?>
                            <?php  foreach($product as $products) { ?>  
                             <option value="<?php echo $products->product_id; ?>">
                              <?php echo $products->product_name; ?></option>
                              <?php }?>
                        </select>


                      <div class="range-container">
                          <label for="quantity" class="qtyrange-label">Quantity range:</label>
                          <b class="bold-range">Range:</b><label id="qty_warehouse" class="qty" style="border:0; color:#f6931f; font-weight:bold;"></label>
                          <div id="slider-range" class="range-slider"></div>
                      </div>

                      <input type="hidden" value="0" class="product_start_qty" id="product_start_qty" name="product_start_qty" />
                      <input type="hidden" value="100000" class="product_end_qty" id="product_end_qty" name="product_end_qty" />

                        <button name="warehouseAgeing" attrType="warehouse" class="warehouseAgeing search_ageing_product btn" style="margin-bottom: 10px;">Search</button>
                    </div>
                     <div class="warehouseageing_content">
                     
                        <table id="warehouseTable" class="table table-striped table-bordered table-hover">
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
                            foreach($getWarehouseProductInfo as $warehousekey=>$getWarehouseProductInfos) {

                             /* if($getWarehouseProductInfos['batch_id'] != 0) {
                                $batchId = $getWarehouseProductInfos['batch_id'];
                                $batchNumber = batchNameByBatchId($batchId);
                              } else {
                                $batchNumber = '';
                              }*/

                               $modifyDate = $getWarehouseProductInfos['modify_date'];
                               $todayDate = date('Y-m-d H:i:s');

                               /* date difference function */
                               $wProductAgeing = getDaysByDateDiff($modifyDate,$todayDate);


                               /* Get Min Stock Quantity */
                               $getMinStock = getSku('product',['product_id'=>$getWarehouseProductInfos['master_product_id']]);

                               $wqty = $getWarehouseProductInfos['stock_qty'];
                             ?>
                            <tr class="warehouse_row">
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
              
                 </div>
                 <div id="tabs-2">
                     <div class="filter_content"> 
                        <label>Select Product</label>
                         <select name="sproduct" id="storeageingproduct" class="storeageingfilter product_id">
                            <option value="">Select Product</option>
                            <?php if(!empty($product)) { ?>
                              <option value="allproduct">All</option>
                            <?php } ?>
                            <?php  foreach($product as $products) { ?>  
                             <option value="<?php echo $products->product_id; ?>">
                              <?php echo $products->product_name; ?></option>
                              <?php }?>
                        </select>


                        <label>Select Store</label>
                        <select name="sstore" id="" class="storeageingfilter store_id">
                           <option value="">Select Store</option>
                           <?php if(!empty($store)) { ?>
                             <option value="allstore">All</option>
                           <?php }?>

                           <?php  foreach($store as $stores) { ?>  
                             <option value="<?php echo $stores->store_id; ?>">
                              <?php echo $stores->store_name; ?></option>
                            <?php }?>
                        </select>

                        <div class="range-container">
                            <label for="quantity" class="qtyrange-label">Quantity range:</label>
                            <b class="bold-range">Range: </b><label id="qty_store" class="qty" style="border:0; color:#f6931f; font-weight:bold;"></label>
                            <div id="slider-range-store" class="range-slider-store"></div>
                        </div>

                        <input type="hidden" value="0" class="product_start_qty" id="product_start_qty_store" name="product_start_qty" />
                        <input type="hidden" value="100000" class="product_end_qty" id="product_end_qty_store" name="product_end_qty" />


                        <button name="storeAgeing" style="margin-bottom: 10px;" attrType="store" class="storeAgeing search_ageing_product btn">Search</button>
                    </div>
                    <div class="storeageing_content">
                      <table id="storeTable" class="table table-striped table-bordered table-hover">
                           <thead>
                              <tr>
                                 <th class="center">#</th>
                                 <th>Product Name</th>
                                 <!--<th>Batch Number</th>-->
                                 <th>SKU</th>
                                 <th>Store Name</th>
                                 <th>Stock Quantity</th>
                                 <th>Last Update</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php if(isset($getStoreProductinfo) && !empty($getStoreProductinfo)) {
                                 $storeCtr = 1;
                                 foreach($getStoreProductinfo as $storekey=>$getStoreProductinfos) {

                                    if($getStoreProductinfos['batch_id'] != 0) {
                                      $batchId = $getStoreProductinfos['batch_id'];
                                      $batchNumber = batchNameByBatchId($batchId);
                                    } else {
                                      $batchNumber = '';
                                    }
                              
                                    $modifyDate = $getStoreProductinfos['modify_date'];
                                    $todayDate = date('Y-m-d H:i:s');

                                    $sProductAgeing = getDaysByDateDiff($modifyDate,$todayDate);

                              /* Get Min Stock Quantity */
                              $getMinStock = getSku('product',['product_id'=>$getWarehouseProductInfos['master_product_id']]);


                              $sqty = $getStoreProductinfos['stock_qty'];
                            ?>
                              <tr class="store_row">
                                 <td><?php echo $storeCtr; ?></td>
                                 <td><?php echo product_name($getStoreProductinfos['master_product_id']);  ?></td>
                                 <!--<td><?php echo $batchNumber; ?></td>-->
                                 <td><?php echo $getStoreProductinfos['product_id']; ?></td>
                                 <td><?php echo getStoreName($getStoreProductinfos['store_id']); ?></td>

                                 <!-- Manage the Less than 10 quantity in stock -->
                                 <?php if($sqty < $getMinStock[0]['min_stock_qty']) { ?>
                                    <td class="qty_notify" attrQty="<?php echo $getStoreProductinfos['stock_qty']; ?>"><?php echo $getStoreProductinfos['stock_qty']; ?>
                                    </td>
                                  <?php }  else { ?>
                                    <td><?php echo $getStoreProductinfos['stock_qty']; ?></td>
                                  <?php } ?>
                                 
                                 <td><?php echo $sProductAgeing; ?></td>
                              </tr>
                              <?php $storeCtr++; } } ?>
                           </tbody>
                      </table>
                    </div>
                 </div>
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

      $('#warehouseTable').dataTable({
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,
         ]
      })

      $('#storeTable').dataTable({
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,
         ]
      })
   
   		var oTable1 = $('#myTable').dataTable({
   
   		"aoColumns": [
            { "bSortable": false },
   	      null, null,null,null,
   		]});

      $('.qty_notify').hover(function() {
        var qtyVal = $(this).attr('attrQty');
        $(this).attr('title','Quantity is less than 10.');
      });


      $('.search_ageing_product').click(function() {
        var type=$(this).attr('attrType');
        var pId=$(this).parent('.filter_content').find('.product_id').val();
        var startQty=$(this).parent('.filter_content').find('.product_start_qty').val();
        var endQty=$(this).parent('.filter_content').find('.product_end_qty').val();

        var storeID = $(this).parent('.filter_content').find('.store_id').val();
   
        if(pId == '') {
          alert('Please select Product.');
          return false;
        } else {
           $.ajax({
            type:'POST',

            url:"<?php echo site_url();?>webadmin/manageproduct/productAgeing",

            data:"product_id="+pId+'&type='+type+'&store_id='+storeID+'&startQty='+startQty+'&endQty='+endQty,

            success:function(data){
              if(data != '') {
                if(type == 'warehouse')  {
                  $('.warehouseageing_content').html(data);
                }

                if(type == 'store') {
                  $('.storeageing_content').html(data);
                }
              }
            }
          });
        }
      });
   });


  $( function() {

      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 1000,
        orientation: "horizontal",
        values: [ 0, 1000 ],
        slide: function( event, ui ) {
          $('#qty_warehouse').html(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );
         // $( "#amount" ).html( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
        //$( "#amount" ).val( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
          $( "#product_start_qty" ).val( ui.values[ 0 ]);
          $( "#product_end_qty" ).val( ui.values[ 1 ]);
        }
      });
      $( "#qty_warehouse" ).html( $( "#slider-range" ).slider( "values", 0 ) +
        " - " + $( "#slider-range" ).slider( "values", 1 ));


        $( "#slider-range-store" ).slider({
          range: true,
          min: 0,
          max: 1000,
          values: [ 0, 1000 ],
          orientation: "horizontal",
          slide: function( event, ui ) {
             $('#qty_store').html(  ui.values[ 0 ] + " - " + ui.values[ 1 ] );

            //$( "#amount" ).html( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
           //$( "#amount" ).val( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
            $( "#product_start_qty_store" ).val( ui.values[ 0 ]);
            $( "#product_end_qty_store" ).val( ui.values[ 1 ]);
          }
        });
      $( "#qty_store" ).html( $( "#slider-range-store" ).slider( "values", 0 ) +
        " - " + $( "#slider-range-store" ).slider( "values", 1 ));

  });

  function qtyrange(min, max) {
    this.min = min;
    this.max = max;
    return this;
  }
  qtyrange.prototype.getrange = function() {
    //qtyrange.min = min;
    return this.min;
  }

</script>
</body>
</html>