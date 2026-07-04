<?php
                                    if(isset($sales) && !empty($sales)){
                                    ?>
                                    <div class="table-header">
                                    Reports - Sales Summary Report
                                </div>
                                    
                                    <table id="account-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Item Name</th>
                                                <!-- <th >Item Type</th> -->
                                                <th >Quantity</th>
                                                <th >MRP</th>
                                                <th >Amount</th>
                                               




                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            
                                            foreach($sales as $sale){
                                            ?>
                                            <tr>
                                                <td class="center">#</td>
                                                <td><?php echo $sale['product_name'];?></td>
                                                <!-- <td><?php echo $sale['sale_ID'];?></td> -->
                                                <!-- <td><?php echo $sale['product_ID'];?></td> -->
                                                <td><?php echo $sale['totQty'];?></td>
                                                <td><?php echo $sale['item_cost_price'];?></td>
                                                <td><?php echo $sale['itmTotal'];?></td>


                                           
                                                
                                                
                                            </tr>

                                            <?php }?>

<?php //if(isset($pagination) && !empty($pagination)){?>                                          
<tr><td colspan="10"><div class="row-fluid"><div class="span6"><!--<div class="dataTables_info" id="sample-table-2_info">Showing <?php //echo $pagination_from;?> to <?php //echo $pagination_to;?> of <?php // echo $pagination_total_rows;?> entries</div>--></div><div class="span6"><div class="dataTables_paginate paging_bootstrap pagination"><?php echo $this->ajax_pagination->create_links(); ?></div></div></div></td></tr>
                                        
                                        <?php //}?>   
                                        </tbody>
                                    </table>
                                    <?php
                                    }   
                                    ?>