<table id="cart_items"  class="table table-striped table-bordered table-hover">
                                                        <thead>
                                                                <tr>
                                                                        <th class="center">#</th>
                                                                        <th class="center">Item Name</th>
                                                                        <th class="center">Quantity</th>
                                                                        <th class="center">Unit</th>
                                                                        <th class="center">Rate</th>
                                                                        <th class="center">Dis.(%)</th>
                                                                        <!-- <th class="center">Dis.</th> -->
                                                                        <th class="center">Tax(%)</th>
                                                                        <!-- <th class="center">Tax</th> -->
                                                                        <th class="center">Amount</th>

                                                                
                                                                </tr>
                                                        </thead>

                                                        <tbody>
                                                        <?php foreach ($cart_items as $row): ?>
                                                                <tr>
                                                                        <td>
                                                                               
                                        
                                        <a href="<?php echo base_url(); ?>sales/managesales/delete_item/<?php echo $row['rowid'];?>" title="Click to remove item from cart">Remove</a>
                                                                                
                                                                        </td>
                                                                        <td><strong><?php echo $row['name'];?></strong><br/>
</td>
                                                                        <td style="text-align: right;">

                                                                        <a href="#" id="discount_all_percent" class="xeditable"  data-validate-number="true" data-placement="top" data-type="text"  data-pk="<?php echo $row['rowid'];?>" data-name="qty" data-url="<?php echo base_url();?>sales/managesales/edit_cart_item" data-title="Change Quantity" data-emptytext="Change Quantity" data-placeholder="Change Quantity">
                                                                                
                                                                                <?php echo $row['qty'];?>
                                                                        </a>

                                                                        

                                                                        </td>
                                                                        <td style="text-align: left;">Kg.</td>
                                                                        <td style="text-align: right;">

                                                                       
                                                                                
                                                                                <?php   echo $row['price'];?>
                                                                                 
                                                                        
                                                                        </td>
                                                                        <td style="text-align: right;">
                                                                               
                                                                                
                                                                                <?php   echo $row['discount'];?>
                                                                       

                                                                        </td>
                                                                       <!--  <td style="text-align: right;">0</td> -->
                                                                        <td style="text-align: right;">
                                                                              
                                                                                
                                                                                <?php   echo $row['tax'];?>
                                                                    

                                                                        <!-- <td style="text-align: right;">0</td> -->   
                                                                        <td style="text-align: right;">
                                                                           <?php   
echo  $row['subtotal_inc_discount_tax'];
                                                                             
                                                                        
                                                                              
                                                                        ?>
                                                                        </td>
                                                                </tr>
                                                        <?php endforeach; ?>
                                                                
                                                        </tbody>
                                                </table>

<script type="text/javascript">
        itemScannedSuccess();
</script>