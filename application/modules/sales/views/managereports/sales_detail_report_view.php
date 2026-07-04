<?php
                                    if(isset($sales) && !empty($sales)){
                                    ?>
                                    <div class="table-header">
                                    Reports - Sales Detail Report
                                </div>
                                    
                                    <table id="account-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Date</th>
                                                <th >Sold By</th>
                                                <th >Invoice Number</th>
                                               <!--  <th >Sold To</th> -->
                                                <th >Item Purchased</th>
                                                <th >Subtotal</th>
                                                <th >Total</th>
                                                <th >Tax</th>
                                                <th >Discount</th>
                                                <th >Payments</th>
                                                <th >Comments</th>
                                                <th >Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            $i=1;
                                            foreach($sales as $sale){

                                            ?>
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="center"><?php echo $i;?></td>
                                                <td><?php echo date("d-m-Y h:i", strtotime($sale['date_time_created']));?></td>
                                                <td><?php echo $sale['sold_by'];?></td>
                                                <td><?php echo $sale['itm_cnt'];?></td>
                                                <td><?php echo $sale['invoice_number']; ?></td>
                                                <td><?php echo $sale['sub_total'];?></td>
                                                <td><?php echo $sale['total_new'];?></td>
                                                
                                                <td>

                                                </td>


                                                <td></td>
                                                <td>
                                                    <?php
                        $pay_methods=$this->managereports_model->getPaymentsBySaleID($sale['sale_ID']);
                        if(!empty($pay_methods)) {
                        foreach ($pay_methods as $pm) {
                            # code...
                            echo $pm['payment_method'].": ".$pm['payment_amount']."<br>";
                            
                        } }  ?>
                                                </td>
                                                <td><?php echo $sale['remark'];?></td>
                                                <td>
                                                    <a target="_blank" href="<?php echo base_url() ?>sales/managereports/sales_invoice/<?php echo $sale['sale_ID']; ?>">Reprint</a>
                                                    <!--<button class="reprint_invoice" attr-sale-id="<?php echo $sale['sale_ID']; ?>">Reprint</button>-->
                                                </td>
                                            </tr>

                                            <?php 

                                            $i++;
                                            }?>

<?php //if(isset($pagination) && !empty($pagination)){?>                                          
<tr><td colspan="12"><div class="row-fluid"><div class="span6"><!--<div class="dataTables_info" id="sample-table-2_info">Showing <?php //echo $pagination_from;?> to <?php //echo $pagination_to;?> of <?php // echo $pagination_total_rows;?> entries</div>--></div><div class="span6"><div class="dataTables_paginate paging_bootstrap pagination"><?php echo $this->ajax_pagination->create_links(); ?></div></div></div></td></tr>
                                        
                                        <?php //}?>   
                                        </tbody>
                                    </table>
                                    <?php
                                    }   
                                    ?>
<script type="text/javascript">
    function salesPrintInvoice(saleId) {
        $.ajax({
            type: 'POST',
            url: '<?php echo base_url(); ?>sales/managereports/sales_invoice/'+saleId,
            success: function (html) {

            }
        })
    }
</script>