
                                    <table id="account-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Date</th>
                                                <th >Sold By</th>
                                               <!--  <th >Sold To</th> -->
                                                <th >Item Purchased</th>
                                                <th >Subtotal</th>
                                                <th >Total</th>
                                                <th >Tax</th>
                                                <th >Discount</th>
                                                <th >Payments</th>
                                                <th >Comments</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                             if(isset($sales) && !empty($sales)){
                                            $i=1;
                                            //echo '<pre>';
                                            //print_r($sales);
                                            foreach($sales as $sale){

                                            ?>
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="center"><?php echo $i;?></td>
                                                <td><?php echo date("d-m-Y h:i", strtotime($sale['date_time_created']));?></td>
                                                <td><?php echo $sale['sold_by'];?></td>
                                                <td><?php echo $sale['itm_cnt'];?></td>
                                                <td><?php echo $sale['sub_total'];?></td>
                                                <td><?php echo $sale['total'];?></td>
                                                
                                                <td>
                                                    Cgst:<?php echo $sale['cgst_amt']; ?></br>
                                                    Sgst:<?php echo $sale['sgst_amt']; ?></br>
                                                    Igst:<?php echo $sale['igst_amt']; ?></br>
                                                </td>

                                                <td><?php echo $sale['discount_amt']; ?></td>
                                                <td>
                                                    <?php
                        $pay_methods=$this->managereports_model->getPaymentsBySaleID($sale['sale_ID']);
                        if(!empty($pay_methods)) {
                            foreach ($pay_methods as $pm) {
                                if($pm['payment_method'] == 'check') {
                                    $method='cheque';
                                } else {
                                    $method=$pm['payment_method'];
                                }
                            # code...
                            echo $method.": ".$pm['payment_amount']."<br>";
                            }
                        } else {
                            echo '-';
                        }
                                                ?>
                                                </td>
                                                <td><?php echo $sale['remark'];?></td>
                                                
                                            </tr>

                                            <?php 

                                            $i++;
                                            } } else { ?>
                                            <tr>
                                                <td colspan="10">No Records</td>
                                            </tr>
                                            <?php } ?>

<?php //if(isset($pagination) && !empty($pagination)){?>                                          
<tr><td colspan="10"><div class="row-fluid"><div class="span6"><!--<div class="dataTables_info" id="sample-table-2_info">Showing <?php //echo $pagination_from;?> to <?php //echo $pagination_to;?> of <?php // echo $pagination_total_rows;?> entries</div>--></div><div class="span6"><div class="dataTables_paginate paging_bootstrap pagination"><?php echo $this->ajax_pagination->create_links(); ?></div></div></div></td></tr>
                                        
                                        <?php //}?>   
                                        </tbody>
                                    </table>