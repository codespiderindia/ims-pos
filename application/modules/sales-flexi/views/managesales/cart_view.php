
<table id="cart_items" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="center">#</th>
									<th class="center">Item Name</th>
									<th class="center">Quantity</th>
									<th class="center">Unit</th>
									<th class="center">Rate</th>
									<th class="center">Dis.(%)</th>
									<th class="center">Dis.</th>
									<th class="center">Tax(%)</th>
									<th class="center">Tax</th>
									<th class="center">Amount</th>

								
								</tr>
							</thead>

							<tbody>
							<?php 
								if (! empty($cart_items)) {
									$i = 0;
									foreach($cart_items as $row) { $i++;
							?>
								<tr>
									<td>
										<input type="hidden" name="items[<?php echo $i;?>][row_id]" value="<?php echo $row['row_id'];?>"/>
										
										<a href="<?php echo base_url(); ?>sales/managesales/delete_item/<?php echo $row['row_id'];?>" title="Click to remove item from cart">Remove</a>
									</td>
									<td><strong><?php echo $row['name'];?></strong><br/>
</td>
									<td style="text-align: right;">

									<a href="#" id="discount_all_percent" class="xeditable"  data-validate-number="false" data-placement="top" data-type="text"  data-pk="<?php echo $row['row_id'];?>" data-name="quantity" data-url="<?php echo base_url();?>sales/managesales/edit_cart_item" data-title="Discount all Items by Percent" data-emptytext="Set Discount" data-placeholder="Set Discount">
										
										<?php echo $row['quantity'];?>
									</a>

									

									</td>
									<td style="text-align: left;">Kg.</td>
									<td style="text-align: right;">

									<a href="#" id="change_price" class="xeditable"  data-validate-number="false" data-placement="top" data-type="text"  data-pk="1" data-name="discount_all_percent" data-url="<?php echo base_url();?>sales/managesales/addItemToCart" data-title="Discount all Items by Percent" data-emptytext="Set Discount" data-placeholder="Set Discount">
										
										<?php	echo $row['price'];?>
									</a>		
									
									</td>
									<td style="text-align: right;">
										<a href="#" id="change_disc_per" class="xeditable"  data-validate-number="false" data-placement="top" data-type="text"  data-pk="1" data-name="discount_all_percent" data-url="<?php echo base_url();?>sales/managesales/addItemToCart" data-title="Discount all Items by Percent" data-emptytext="Set Discount" data-placeholder="Set Discount">
										
										1%
									</a>

									</td>
									<td style="text-align: right;">0</td>
									<td style="text-align: right;">
										<a href="#" id="change_tax_per" class="xeditable"  data-validate-number="false" data-placement="top" data-type="text"  data-pk="1" data-name="discount_all_percent" data-url="<?php echo base_url();?>sales/managesales/addItemToCart" data-title="Discount all Items by Percent" data-emptytext="Set Discount" data-placeholder="Set Discount">
										
										1%
									</a>

									<td style="text-align: right;">0</td>	
									<td style="text-align: right;">
											<?php 
										// If an item discount exists, strike out the standard item total and display the discounted item total.
										if ($row['discount_quantity'] > 0)
										{
											echo '<span class="strike">'.$row['price_total'].'</span><br/>';
											echo $row['discount_price_total'].'<br/>';
										}
										// Else, display item total as normal.
										else
										{
											echo $row['price_total'];
										}
									?>

									</td>
								</tr>
								
								<?php } } else { ?>
								<tr>
									<td colspan="5" class="empty">
										<h4>! You currently have no items in your shopping cart !</h4>
										<a href="<?php echo base_url(); ?>lite_library/item_link_examples">View examples of items that can be added to the cart</a>
									</td>
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
<script type="text/javascript">
	itemScannedSuccess();
</script>