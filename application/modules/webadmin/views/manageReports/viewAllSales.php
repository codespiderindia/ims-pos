<?php
  global $uInfo;
  $uInfo=$this->session->userdata('webadmin_session_info');
  $compCode = $uInfo['comp_code'];
?>
<style>
.grand_total {
    font-weight: 600;
    font-size: 15px;
}
#filters {
      padding-top: 10px;
}
.inline_label {
      display: inline-block;
}
</style>


<div class="table-header tableThemeColor">All Sales</div>
 <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">
    <label class="inline_label">Select From Date</label>
    <input type="text" name="daily_date" class="daily_date" id="daily_date">

    <label class="inline_label">Select To Date</label>
    <input type="text" name="daily_to_date" class="daily_to_date" id="daily_to_date">


    <label class="inline_label">Select employee</label>
    <select name="employee_name" class="sale_name_select">
      <option value="">Select Employee</option>
      <?php if(!empty($users)) {
      foreach($users as $userss) { ?>
          <option value="<?php echo $userss->user_ID; ?>"><?php echo $userss->user_name; ?></option>
     <?php } } ?>
    </select>

    <label class="inline_label">Select Store</label>
    <select name="store_name" class="store_name" style=" margin-top:10px;">
        <option value="">Select Store</option>
        <?php $compCode = $uInfo['comp_code']; 
        $allStore=getSku('store',['comp_code'=>$compCode]);
        if(!empty($allStore)) {
           foreach($allStore as $allStores) { ?>
           <option value="<?php echo $allStores['store_id']; ?>"><?php echo trim($allStores['store_name']); ?></option>
         <?php }
        } ?>
    </select>

    <input class="btn btn_border search_daily_sale" style="margin-bottom: 0px;" name="search_daily_sale" value="Search" id="search_daily_sale" type="button">

    <input class="btn btn_border" style="margin-bottom: 0px;" name="export_all_sale" value="Export All" id="export_all_sale" type="button">

  </div>

  
  <div id="vender_result" class="vender_result">
    <div class="allsale_content">
  <table id="mytable-dailysale" class="table table-striped table-borderedss table-hover all_sale_report">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Store Name</th>
                        <th>Payment Method</th>
                        <th>Credit Note</th>
                        <th>Remark</th>
                        <th class="amount">Amount</th>
            					</tr>
                  </thead>
                  <tbody>
                      <?php
                       if(isset($sale) && !empty($sale)) {
                      $sum='';
                      $i=1;
                      foreach($sale as $key1=>$sales) { 
                         ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php $storeDetail=store_details_by_id($sales['store_id']);
                            echo $storeDetail[0]['store_name']; ?></td>
                        <td>
                            Cash: <?php echo (isset($sales['cash']) && $sales['cash'] != '') ? $sales['cash'] : '-' ; ?></br>
                            Debit Card: <?php echo (isset($sales['dcard']) && $sales['dcard'] != '') ? $sales['dcard'] : '-' ; ?></br>
                            Credit Card: <?php echo (isset($sales['ccredit']) && $sales['ccredit'] != '') ? $sales['ccredit'] : '-' ; ?></br>
                            Cheque/Coupon: <?php echo (isset($sales['check']) && $sales['check'] != '') ? $sales['check'] : '-' ; ?></br>
                        </td>
                        
                        <td><?php echo (isset($sales['creditNote']) && $sales['creditNote'] != '') ? $sales['creditNote'] : '-' ; ?></td>

                        <td><?php echo (isset($sales['remark']) && $sales['remark'] != '') ? $sales['remark'] : '-'; ?></td>

                        <td class="amount"><?php echo $sales['total']; ?></td>
                      </tr>
                    <?php $i++; $sum+=$sales['total']; } ?> 
                    <?php } else { ?>
                        <tr><td colspan="8"><?php echo 'No Record Found'; ?></td></tr>
                    <?php } ?>
                  </tbody>
                  <?php if(isset($sale) && !empty($sale)) { ?>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td>Grand Total</td>
                      <td></td>
                      <td></td>
                      <td></td>
                       <td class="amount"><?php 
                      if(is_float($sum)==true){
                        echo $sum;
                      } else {
                        echo $sum.'.00';
                      } ?></td>
                    </tr>
                  </tfoot>
                  <?php } ?>
            </table>
          </div>

          <input class="btn btn_border" name="print_all_sale" value="Print All" id="print_all_daily_sale" style="" type="button">
</div>
<script type="text/javascript">
  jQuery(document).ready(function() {
    <?php if(isset($sale) && !empty($sale)) { ?>
      var oTable1 = $("#mytable-dailysale").dataTable({
   
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
        ]
      });
    <?php } ?>
    /* var oTable1 = $("#mytable-dailysale").dataTable({
   
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,
        ]
      });*/


   //$('#myTable').DataTable();
    $( "#export_all_sale" ).click(function() {
      var daily_date = $('#daily_date').val();
      var sale_name = $('.sale_name_select').val();
      var store_name = $('.store_name').val();

      window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_daily_sale/?daily_date='+daily_date+'&sale_name='+sale_name+'&store_name='+store_name;
      return false;
      });


    $( "#print_all_daily_sale" ).click(function() {
      var daily_date = $('#daily_date').val();
      var end_date = $('#daily_to_date').val();
      var sale_name = $('.sale_name_select').val();
      var store_name = $('.store_name').val();

      window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_daily_sale/?daily_date='+daily_date+'&end_date='+end_date+'&sale_name='+sale_name+'&store_name='+store_name;
      return false;
    });



      jQuery( ".daily_date" ).datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date(),
       /* onSelect: function(date, instance) {

          var toDate=$('.daily_to_date').val();
            var employee=$('.sale_name_select').val();
            var store=$('.store_name').val();
             $.ajax({
                url:"<?php echo site_url();?>webadmin/managereport/salesReport",
                type:'POST',
                data:"fromdateval="+date+"&todateval="+toDate+"&employee_id="+employee+"&store_id="+store+"&status="+1,
                success: function(data) {
                  $('.allsale_content').html(data);
                }
           })
          }*/
      });


      jQuery(".daily_to_date").datepicker({
        dateFormat: "yy-mm-dd",
        maxDate: new Date(),
       /* onSelect: function(date, instance) {

          var fromDate=$('.daily_date').val();
          var employee=$('.sale_name_select').val();
          var store=$('.store_name').val();
           $.ajax({
             url:"<?php echo site_url();?>webadmin/managereport/salesReport",
                type:'POST',
                data:"fromdateval="+fromDate+"&todateval="+date+"&employee_id="+employee+"&store_id="+store+"&status="+1,
                success: function(data) {
                  $('.allsale_content').html(data);
                }
           })
        }*/
      });



      /*$(".store_name").on('change', function() {
          $.ajax({
            url:"<?php echo site_url();?>webadmin/managereport/salesReport",
            type:'POST',
            data:{
              "fromdateval":$(".daily_date").val(),
              "todateval":$(".daily_to_date").val(),
              "employee_id":$('.sale_name_select').val(),
              "store_id":$(this).val(),
              "status":1,
            },
            success: function(result) {
                  $('.allsale_content').html(result);
                }
          })
      });

      $(".sale_name_select").on('change', function() {
          $.ajax({
            url:"<?php echo site_url();?>webadmin/managereport/salesReport",
            type:'POST',
            data:{
              "fromdateval":$(".daily_date").val(),
              "todateval":$(".daily_to_date").val(),
              "employee_id":$(this).val(),
              "store_id":$('.store_name').val(),
               "status":1,
            },
            success: function(result) {
                  $('.allsale_content').html(result);
                }
          })
      });*/

      jQuery('body').on('click', '.search_daily_sale',function() {

        if($(".daily_date").val() == '') {
          alert('Please select From date.');
          return false;
        } else if($(".daily_to_date").val() == '') {
          alert('Please select To date.');
          return false;
        } else {

           $.ajax({
            url:"<?php echo site_url();?>webadmin/managereport/salesReport",
            type:'POST',
            data:{
              "fromdateval":$(".daily_date").val(),
              "todateval":$(".daily_to_date").val(),
              "employee_id":$(".sale_name_select").val(),
              "store_id":$('.store_name').val(),
               "status":1,
            },
            success: function(result) {
                  $('.allsale_content').html(result);
                }
          })

        }
      });

  });
</script>