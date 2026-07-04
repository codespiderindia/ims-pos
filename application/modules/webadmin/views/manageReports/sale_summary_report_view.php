<?php //echo '<pre>'; print_r($sales); ?>
<table id="sale_summary_view" class="table">
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Date</th>
                                                <th >Total Sale(s)</th>
                                                <th >Subtotal</th>
                                                <th>Remark</th>
                                                <th >Total</th>
                                                <th>IsDeleted</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            if(isset($sales) && !empty($sales)){
                                             $i=1;
                                            foreach($sales as $sale){
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $i; ?></td>
                                                <td><?php echo $sale['sale_date'];?></td>
                                                <td><?php echo $sale['no_of_sale'];?></td>
                                                <td><?php echo $sale['sub_total'];?></td>
                                                <td><?php echo $sale['remark']; ?></td>
                                        <td><?php echo $sale['total'];?></td>        <td>
                                            <!--<a href="<?php echo base_url() ?>webadmin/managereport/rePrintBilling/<?php echo $sale['sale_ID'];?>">
                                                <button class="reprint_bill" attrSaleId="<?php echo $sale['sale_ID'];?>">Reprint</button>
                                            </a>-->

                                            <?php if($sale['is_deleted'] == 0) { ?>
                                                <button class="sale_del" attrSaleId="<?php echo $sale['sale_ID'];?>">Deleted</button>
                                            <?php } else { ?>
                                                <label>Already Deleted</label>
                                            <?php } ?>
                                        </td>
                                            </tr>

                                            <?php $i++; } } else { ?>
                                            <tr>
                                                <td colspan="5">No Record.</td>
                                            </tr>
                                            <?php } ?>

<?php //if(isset($pagination) && !empty($pagination)){?>                                          
<tr><td colspan="10"><div class="row-fluid"><div class="span6"><!--<div class="dataTables_info" id="sample-table-2_info">Showing <?php //echo $pagination_from;?> to <?php //echo $pagination_to;?> of <?php // echo $pagination_total_rows;?> entries</div>--></div><div class="span6"><div class="dataTables_paginate paging_bootstrap pagination"><?php echo $this->ajax_pagination->create_links(); ?></div></div></div></td></tr>
                                        
                                        <?php //}?>   
                                        </tbody>
                                    </table>

                                    <script type="text/javascript">
        $(document).ready(function(){
            $('.sale_del').click(function() {
                var saleId = $(this).attr('attrSaleId');
                var postdata='saleId='+saleId;

                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>webadmin/managereport/delSaleBilling/',
                    data:postdata,
                    success: function (html) {
                       
                    }
                });
            });

           /* $('.reprint_bill').click(function() {
                var saleId = $(this).attr('attrSaleId');
                $.ajax({
                    type: 'POST',
                    url: '<?php echo base_url(); ?>webadmin/managereport/rePrintBilling/'+saleId,
                    success: function (data) {
                       var HTML = data.htmldata;
                       var WindowObject = window.open("", "PrintWindow", "width=750,height=650,top=50,left=50,toolbars=no,scrollbars=yes,status=no,resizable=yes");
                        WindowObject.document.writeln(HTML);
                        WindowObject.document.close();
                        WindowObject.focus();
                        WindowObject.print();
                        WindowObject.close();
                    }
                });
            });*/

       });

                                    /* $(document).ready(function(){

                                         var oTable1 = $('#sale_summary_view').dataTable({
                                       
                                          "aoColumns": [
                                              { "bSortable": false },
                                              null, null,null, null, null,
                                            ]
                                          });
                                     });*/
                                    </script>
