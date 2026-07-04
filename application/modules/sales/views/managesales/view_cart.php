<table id="cart_items" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<th class="center">#</th>
									<th class="center">Item Name</th>
									<th class="center">Quantity</th>
									<th class="center">Unit</th>
									<th class="center">MRP</th>
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
										
										<a href="<?php echo base_url(); ?>sales/manageorders/delete_item/<?php echo $row['row_id'];?>" title="Click to remove item from cart">Remove</a>
									</td>
									<td>ace</td>
									<td style="text-align: right;">2</td>
									<td style="text-align: left;">Kg.</td>
									<td style="text-align: right;">50</td>
									<td style="text-align: right;">0</td>
									<td style="text-align: right;">0</td>
									<td style="text-align: right;">0</td>
									<td style="text-align: right;">0</td>	
									<td style="text-align: right;">100</td>
								</tr>
								
								<?php } } else { ?>
								<tr>
									<td colspan="5" class="empty">
										<h4>! You currently have no items in your shopping cart !</h4>
										<a href="<?php echo $base_url; ?>lite_library/item_link_examples">View examples of items that can be added to the cart</a>
									</td>
								</tr>
							<?php } ?>
								
							</tbody>
						</table>
						
=====================================================

<table id="cart_items">
							<thead>
								<tr>
									<th class="spacer_75">Remove</th>
									<th>Item</th>
									<th class="spacer_100 align_ctr">Price</th>
									<th class="spacer_100 align_ctr">Quantity</th>
									<th class="spacer_100 align_ctr">Total</th>
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
										<!-- 
											The name of each input field is structured as a multi-dimensional array, using the looped '$i' value to group each rows data together.
											When submitting input data to the 'update_cart()' function, the id of the cart row being updated must also be submitted.
											An example of this is done below by including a hidden field with the carts row id.
										-->
										<input type="hidden" name="items[<?php echo $i;?>][row_id]" value="<?php echo $row['row_id'];?>"/>
										
										<a href="<?php echo base_url(); ?>sales/manageorders/delete_item/<?php echo $row['row_id'];?>" title="Click to remove item from cart">Remove</a>
									</td>
									<td>
										<strong><?php echo $row['name'];?></strong><br/>

									
									
									</td>
									<td class="align_ctr">
									<?php
											echo $row['price'];
									
									?>
									</td>
									<td class="align_ctr">
										<!-- 
											The input name 'quantity' must be the same as the item array column that it is updating.
											In this example, it is defined via the config file var $config['cart']['items']['columns']['item_quantity'] = 'quantity'
										-->
										<input type="text" name="items[<?php echo $i;?>][quantity]" value="<?php echo $row['quantity'];?>" maxlength="3" class="width_50 align_ctr validate_decimal"/>
										<input type="submit" name="update" value="&plusmn;" title="Update Quantity" class="link_button grey"/>
									</td>
									<td class="align_ctr">
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
							<?php 
								// To display a description of the discount, this example submits a 2nd parameter to the item_discount_status() function.
								// This sets the function to show item shipping discounts as well as the standard item price discounts. 
								if ($this->flexi_cart->item_discount_status($row['row_id'], FALSE)) { 
							?>
								<tr class="discount">
									<td colspan="5">
										Discount: <?php echo $this->flexi_cart->item_discount_description($row['row_id']);?>
										: <a href="<?php echo $base_url; ?>standard_library/unset_discount/<?php echo $this->flexi_cart->item_discount_id($row['row_id']);?>">Remove</a>
									</td>
								</tr>
							<?php } ?>
								<tr>
									<td colspan="5" class="hidden_vars">
										<!-- This row is only intended to show some of the internal values of the cart-->
										<span class="toggle">View Hidden Item Data</span>
										<small class="hide_toggle">
											<strong>Hidden item values:</strong> 
											Weight: <em><?php echo $row['weight'];?></em>, 
											Tax Rate: <em><?php echo $row['tax_rate'];?></em>, 
											Tax: <em>
												<?php 
													// If a discount is set, the tax of the discounted items is shown in brackets.
													// Note: The $row data does not include the item tax including the discount, instead use the function $this->flexi_cart->item_tax($row['row_id'], TRUE).
													echo $row['tax'];
													echo ($this->flexi_cart->item_discount_status($row['row_id'])) ? ' ('.$this->flexi_cart->item_tax($row['row_id'], TRUE).')' : NULL; 
												?></em>,
											Reward Points: <em><?php echo $row['reward_points'];?></em>, 
											Shipping: <em><?php echo (is_numeric($row['shipping_rate'])) ? $row['shipping_rate'] : 'Default Rate';?></em><br/>

											<strong>Hidden item totals:</strong> 
											Total Weight: <em><?php echo $row['weight_total'];?></em>, 
											Total Tax: <em><?php 
													// If a discount is set, the discounted tax total is shown in brackets.
													// Note: The $row data does not include the item tax total including the discount, instead use the function $this->flexi_cart->item_tax_total($row['row_id'], TRUE).
													echo $row['tax_total'];
													echo ($this->flexi_cart->item_discount_status($row['row_id'])) ? ' ('.$this->flexi_cart->item_tax_total($row['row_id'], TRUE).')' : NULL; 
												?></em>, 
											Total Reward Points: <em><?php echo $row['reward_points_total'];?></em>
										</small>	
									</td>
								</tr>
							<?php } } else { ?>
								<tr>
									<td colspan="5" class="empty">
										<h4>! You currently have no items in your shopping cart !</h4>
										<a href="<?php echo $base_url; ?>lite_library/item_link_examples">View examples of items that can be added to the cart</a>
									</td>
								</tr>
							<?php } ?>
							</tbody>
							<tfoot>
							<?php 
								// Ensure the 'item_summary_savings_total()' functions format argument is set to 'FALSE' to prevent comparing a formatted STRING against an INT of '0'.
								if ($this->flexi_cart->item_summary_savings_total(FALSE) > 0) { 
							?>
								<tr class="discount">
									<th colspan="4">Item Summary Discount Savings Total</th> 
									<td><?php echo $this->flexi_cart->item_summary_savings_total();?></td>
								</tr>
							<?php } ?>
								<tr>
									<th colspan="4">Item Summary Total</th>
									<td><?php echo $this->flexi_cart->item_summary_total();?></td>
								</tr>
							</tfoot>
						</table>