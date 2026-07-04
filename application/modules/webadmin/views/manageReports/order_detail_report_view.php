<table id="account-result" class="table table-striped table-bordered table-hover orderdetail">                                 
                                        <thead>
                                            <tr>
                                                <th class="center">#</th>
                                                <th>GSTIN/UIN of Recipient</th>
                                                <th>Receiver Name</th>
                                                <th>Invoice Number</th>
                                                <th>Invoice Date</th>
                                                <th>Invoice Value</th>
                                                <th>Place Of Supply</th>
                                                <th>Reverse Charge</th>
                                                <th>Invoice Type</th>
                                                <th>E-Commerce GSTIN</th>
                                                <th>Rate</th>
                                                <th>Application % of Tax Rate</th>
                                                <th>Taxable Value</th>
                                                <th>Cess Amount</th>
                                             </tr>
                                        </thead>

                                        <tbody>
                                            <?php 

                                             if(isset($orderDetail) && !empty($orderDetail)){
                                            $i=1;$chkGstExits=0;
                                            foreach($orderDetail as $invoiceId=>$orderDetails){

                                              foreach($orderDetails as $gstRate=>$orderval) {

                                             if($orderval['order_status'] == 3) {

                              $status = 'Completed';
                           } elseif($orderval['order_status'] == 2) {
                               $status = 'processing';
                           } else {
                               $status = 'pending';
                           }

                           if($orderval['payment_for'] == 1) {
                              $invoiceType = 'Regular';
                           } else {
                              $invoiceType = 'Direct Pay';
                           }

                        $dealer_name = dealer_name($orderval['dealer_user_id']);
                        foreach($dealer_name as $dealer_names) {
                            $dName = $dealer_names->f_name.' '.$dealer_names->l_name;
                        }

                        $getDealerData = getSku('dealer',['dealer_id'=>$orderval['dealer_user_id']]);

                        ?>
                     <tr>
                        <td class="center"><?php echo $i;?></td>
                        <td><?php echo $getDealerData[0]['tin_number']; ?></td>
                        <td><?php echo $getDealerData[0]['firm_name']; ?></td>
                        <td><?php echo (isset($orderval['invoice_id']) ? $orderval['invoice_id'] : ''); ?></td>
                        <td><?php echo $orderval['invoice_date']; ?></td>
                        <td><?php echo $orderval['taxable_value']; ?></td>
                        <td><?php echo $orderval['place_of_supply']; ?></td>
                        <td><?php echo 'N'; ?></td>
                        <td><?php echo $invoiceType; ?></td>
                        <td></td>
                        <td><?php
                            if($gstRate != '') {
                              echo str_pad($gstRate, 5, '.00', STR_PAD_RIGHT);
                            }
                         ?></td>
                        <td></td>
                        <td><?php echo $orderval['total']; ?></td>
                        <td><?php echo $orderval['cess_amount']; ?></td>
                     </tr>

                    <?php $i++; } } }  ?>  
      </tbody>
</table>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.dataTables.bootstrap.js"></script>
    <script>
     /* $(document).ready(function() {
          var oTable1 = $('.orderdetail').dataTable( {
   
            "aoColumns": [
         
                { "bSortable": false },
         
                null, null,null, null, null,null, null, null,
              ]
    
        } );
      });*/


        $(function() {

    function orderDetail(page_num) {
        page_num = page_num?page_num:0;
        var keywords = $('#keywords').val();
        var sortBy = $('#sortBy').val();

        var startDate = $( "#order_detail_from_date" ).datepicker( "getDate" );
        startDate=$.datepicker.formatDate('dd-mm-yy', startDate);

        var endDate = $( "#order_detail_end_date" ).datepicker( "getDate" );
        endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

        var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate;

        $.ajax({
            type: 'GET',
            url: '<?php echo base_url(); ?>webadmin/managereport/orderDetailReport/'+page_num,
            data:url,
            success: function (html) {
                $('#order_detail_result').html(html);
                $('.loading').fadeOut("slow");
            }
        });
  }
        });
 
</script>