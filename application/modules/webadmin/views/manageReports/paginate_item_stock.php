    <div class="table-header">
                                    Reports - Item Stock (<?php echo $storeName;?>)
                                </div>
                                    
                                    <table id="account-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Item Name</th>
                                                <th>SKU</th>
                                                <th >Quantity</th>
                                                <th >MRP</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            if(isset($prd_stock) && !empty($prd_stock)){
                                                $i=1;
                                            foreach($prd_stock as $stk){
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $i; ?></td>
                                                <td><?php echo $stk['prdName'];?></td>
                                                <td><?php echo $stk['sku'];?></td>

                                                <td>
                                                <?php if(isset($stk['stockqty'])) {
                                                     echo $stk['stockqty'];
                                                 } else {
                                                    echo 0;
                                                 }
                                                ?>
                                                </td>
                                                <td><?php echo $stk['prdPrice'];?></td>
                                            </tr>

                                            <?php $i++; } } else { ?>
                                                <tr>
                                                    <td colspan="5">No Record</td>
                                                </tr>
                                            <?php } ?>

<?php //if(isset($pagination) && !empty($pagination)){?>                                          
<tr><td colspan="10"><div class="row-fluid"><div class="span6"><!--<div class="dataTables_info" id="sample-table-2_info">Showing <?php //echo $pagination_from;?> to <?php //echo $pagination_to;?> of <?php // echo $pagination_total_rows;?> entries</div>--></div><div class="span6"><div class="dataTables_paginate paging_bootstrap pagination"><?php echo $this->ajax_pagination->create_links(); ?></div></div></div></td></tr>
                                        
                                        <?php //}?>   
                                        </tbody>
                                    </table>