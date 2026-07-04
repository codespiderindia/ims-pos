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
        <a href="<?php echo base_url() ?>webadmin/manageproduct/addNewBatch">
            <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
              <i class="icon-ok bigger-110"></i>
               New Batch
            </button>
        </a>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">

            <div class="span12">
               <div class="table-header tableThemeColor"> Results for "Product Batches"</div>

                  <div>
                     <div class="batchageing_content">
                        <table id="batchTable" class="table table-striped table-bordered table-hover">
                          <thead>
                             <tr>
                                <th class="center">#</th>
                                <th>Product Name</th>
                                <th>Batch Number</th>
                                <th>Mfg Date</th>
                                <th>Expiry Date</th>
                             </tr>
                          </thead>
                          <tbody>
                             <?php if(isset($batchs) && !empty($batchs)) { 
                                foreach($batchs as $key=>$batch) { ?>
                                  <tr>
                                    <td><?php echo $key+1; ?></td>
                                    <td><?php echo $batch->product_name; ?></td>
                                    <td><?php echo $batch->batch_number; ?></td>
                                    <td><?php echo $batch->mfg_date; ?></td>
                                    <td><?php echo $batch->exp_date; ?></td>
                                  </tr>
                                <?php }
                              } ?>
                          </tbody>
                        </table>
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

      $('#batchTable').dataTable({
         "aoColumns": [
            { "bSortable": false },
            null, null,null, null,
         ]
      })

   
   		var oTable1 = $('#myTable').dataTable({
   
   		"aoColumns": [
            { "bSortable": false },
   	      null, null,null, null,null,
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