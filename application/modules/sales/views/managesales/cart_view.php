<table id="cart_items"  class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th class="center">#</th>
            <th class="center">Item Name</th>
            <th class="center">SKU</th>
            <th class="center">Quantity</th>
            <th class="center">Unit</th>
            <th class="center">MRP</th>
            <!-- <th class="center">Dis.(%)</th> -->
            <!-- <th class="center">Dis.</th> -->
            <th class="center">GST(%)</th>
            <!-- <th class="center">Tax</th> -->
            <th class="center">Amount</th>
        </tr>
    </thead>

    <tbody>
        <?php 
          foreach ($cart_items as $row): ?>
            <tr>
                <td>
                    <a class="btn btn-danger btn-minier" href="<?php echo base_url(); ?>sales/managesales/delete_item/<?php echo $row['rowid'];?>/<?php echo $row['id']; ?>" title="Click to remove item from cart"><i class="ace-icon fa fa-times  icon-only"></i></a>
                </td>
                <td><strong><?php echo $row['name'];?></strong><br/>
                </td>
                <td><?php echo $row['id']; ?></td>
                <td style="text-align: right;">

                    <a href="#" id="discount_all_percent" class="xeditable"  data-validate-number="true" data-placement="top" data-type="text"  data-pk="<?php echo $row['rowid'];?>" data-sku="<?php echo $row['id']; ?>" data-name="qty" data-url="<?php echo base_url();?>sales/managesales/edit_cart_item" data-title="Change Quantity" data-emptytext="Change Quantity" data-placeholder="Change Quantity">

                     <?php echo $row['qty'];?>
                 </a>

             </td>
             <td style="text-align: left;"><?php   echo $row['unit'];?></td>
             <td style="text-align: right;">

                <?php   echo $row['product_mrp'];?>
            </td>
                <!-- <td style="text-align: right;">
                                                                               
                                                                                
                <?php   echo $row['discount'];?>
                                                                       
</td> -->
           <!--  <td style="text-align: right;">0</td> -->
           <td style="text-align: right;">


           <?php   echo $row['tax_inc_gst_rate'];?>%


              <!-- <td style="text-align: right;">0</td> -->   
                    <td style="text-align: right;">
                      <?php   echo  $row['subtotal'];   ?>
                                                                               </td>
                                                                           </tr>
                                                                       <?php endforeach; ?>

                                                                   </tbody>
                                                               </table>

                                                               <script type="text/javascript">
                                                                itemScannedSuccess();
                                                            </script>