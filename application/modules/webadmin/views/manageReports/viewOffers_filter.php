<?php $uinfo = $this->session->userdata('sales_session_info');?>
<style type="text/css">
  .grand_total {
    font-weight: 600;
    font-size: 15px;
  }
  .widget-body .table {
    margin-top: 10px;
  }
  .amount{
    text-align: right !important;
  }
</style>
  <div class="post-search-panel" id="sale_filter_report">
    <table id="table-offer-filter"  class="table table-striped table-borderedss table-hover">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>Offers Name</th>
                        <th>percentage or fixed</th>
                        <th>Discount</th>
                        <th>Free Product</th>
                        <th>Start</th>
                        <th>End</th>
                        <th>Description</th>
                      </tr>
                  </thead>
                  <tbody>
                    <?php  if(!empty($offers)) { ?>
                      <?php $i = 1;
                       foreach($offers as $offers) { 
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>  
                        <td class=""><?php echo $offers->offer_name; ?></td>
                                    <td><?php if($offers->percentage_or_fixed =='1') {
                        echo "%";
                        } ?>
                        <?php if($offers->percentage_or_fixed =='2') {
                        echo "Fixed";
                        } ?>
                        
                        <?php if($offers->percentage_or_fixed =='3') {
                        echo "Free Product";
                        } ?>
                        </td>
                        <td><?php echo $offers->offer_discount; ?></td>
                        <td><?php echo $offers->free_product; ?></td>
                        <td><?php echo $offers->date_duration_start; ?></td>
                        <td><?php echo $offers->date_duration_end; ?></td>  
                        <td><?php echo $offers->offer_description; ?></td>
                      </tr>
                      <?php  $i++;} ?>
        <?php } else { ?>
         <tr><td colspan="8"><?php echo 'No Record Found'; ?></td></tr>
        <?php } ?>
        </tbody>
        </table>
        <script>
        var oTable1 = $('#table-offer-filter').dataTable( {
           "aoColumns": [
              { "bSortable": false },
              null, null,null, null, null,null, null, 
          ] } );

        </script>
      <!--PAGE CONTENT ENDS-->
  </div><!--/.span-->