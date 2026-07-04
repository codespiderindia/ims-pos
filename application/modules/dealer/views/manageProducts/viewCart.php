<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('dealer_session_info');?>
<div class="page-content">
<div class="page-header position-relative">
   <h1 class="headingThemeColor"><?php echo $heading;?></h1>
   <?php
      if ($this->session->flashdata('error_msg')):
      ?>
   <div class="alert alert-error">
      <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
      <strong> <i class="icon-remove"></i> Error! </strong> <?php
         echo $this->session->flashdata('error_msg');
         ?> <br />
   </div>
   <?php
      endif;
      ?>
   <?php
      if ($this->session->flashdata('success_msg')):
      ?>
   <div class="alert alert-block alert-success ">
      <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
      <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php
         echo $this->session->flashdata('success_msg');
         ?> </p>
   </div>
   <?php
      endif;
      ?>
</div>
<!--/.page-header-->
<div class="row-fluid">
   <div class="span12">
      <!--PAGE CONTENT BEGINS-->
      <div class="row-fluid">
         <div class="span12">
            <div class="products-div"> 
               <div id="text"> 
                  <?php  $cart_check = $this->cart->contents();
                     // If cart is empty, this will show below message.
                      if(empty($cart_check)) {
                      echo '<p>Your cart is currently empty.</p>';

                      echo '<div class="product-add-but"><a href="'.base_url().'dealer/manageproducts/viewProducts">Return To Shop</a></div>';  
                      }  ?> 
               </div>
               <table id="cart_table" border="1px" cellpadding="5px" cellspacing="1px">
                  <?php
                     // All values of cart store in "$cart". 
                     if ($cart = $this->cart->contents()): ?>
                  <tr id= "main_heading">
                     <th>Serial</th>
                     <th>Name</th>
                     <th>Sku</th>
                     <!--<th>Price</th>-->
                     <th>Qty</th>
                     <!--<th>Discount</th>-->
                     <th>Amount</th>
                     <th>Cancel Product</th>
                  </tr>
                  <?php
                     // Create form and send all values in "shopping/update_cart" function.
                     echo form_open('dealer/manageproducts/update_cart');
                     $grand_total = 0;
                     $i = 1;
                     
                     foreach ($cart as $item)://print_r($item);
                        //   echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                        //  Will produce the following output.
                        // <input type="hidden" name="cart[1][id]" value="1" />
                        
                        echo form_hidden('cart[' . $item['id'] . '][id]', $item['id']);
                        echo form_hidden('cart[' . $item['id'] . '][rowid]', $item['rowid']);
                        echo form_hidden('cart[' . $item['id'] . '][name]', $item['name']);
                        echo form_hidden('cart[' . $item['id'] . '][price]', $item['price']);
                         echo form_hidden('cart[' . $item['id'] . '][discount]', $item['discount']);
                        echo form_hidden('cart[' . $item['id'] . '][qty]', $item['qty']);
                        ?>
                  <tr>
                     <td>
                        <?php echo $i++; ?>
                     </td>
                     <td>
                        <?php echo $item['name']; ?>
                     </td>
                     <td><?php echo $item['id']; ?></td>
                    <!-- <td>
                        <?php echo number_format($item['original_price'], 2); ?> &#8360;
                     </td>-->
                     <td>
                        <?php //echo form_input('cart[' . $item['id'] . '][qty]', $item['qty'], 'maxlength="3" size="1" style="text-align: right" type ="number"'); ?>
                        <input type="number" style="text-align: right" size="1" min="1" value="<?php echo $item['qty'];?>" name="<?php echo 'cart[' . $item['id'] . '][qty]';?>">
                     </td>
                     <!--<td><?php echo ($item['discount']!='' ? $item['discount'] : ''); ?></td>-->
                     <?php $grand_total = $grand_total + $item['subtotal']; ?>
                     <td>
                        <?php echo number_format($item['subtotal'], 2) ?> &#8360;
                     </td>
                     <td>
                        <?php 
                           // cancle image.
                           $path = "<img src='".base_url()."uploads/dealer/cart_cross.jpg' width='25px' height='20px'>";
                     //      echo anchor('dealer/manageproducts/remove/' . $item['rowid'], $path); ?>
						  <a href="#" onclick="clear_cart_by_row_id('<?php echo $item['rowid']; ?>');"><?php echo $path;?></a>
						   
						   
                     </td>
                     <?php endforeach; ?>
                  </tr>
                  <tr>
                     <td colspan="8" align="right" class="btns">
                        <input type="button" class ='fg-button teal' value="Clear Cart" onclick="clear_cart()">
                        <?php //submit button. ?>
                        <input type="submit" class ='fg-button teal' value="Update Cart">
                        <?php echo form_close(); ?>
                     </td>
                  </tr>
                  
               </table>

                  <div class="cart-collaterals">
                     <div class="cart_totals">
                        <h2>Cart Totals</h2>
                        <table cellspacing="0" class="shop_table shop_table_responsive">
                           <tbody>
                              <tr class="order-total">
                                 <th><b>Order Total:</b> </th>
                                 <td><span><?php 
                                    //Grand Total.
                                    echo number_format($grand_total, 2); ?> &#8360;</span>
                                 </td>
                              </tr>
                           </tbody>
                        </table>
                        <div class="wc-proceed-to-checkout">
                           <!-- "Place order button" on click send "billing" controller  -->
                           <input type="button" class ='fg-button teal' value="Proceed to Checkout" onclick="window.location = '<?php echo base_url() . 'dealer/manageproducts/checkout'?>'">
                        </div>
                     </div>
                  </div>
               <?php endif; ?>
            </div>
         </div>
         <!--/row-->
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script type="text/javascript">
   // To conform clear all data in cart.
   function clear_cart() {
       var result = confirm('Are you sure want to clear all products?');
   
       if (result) {
           window.location = "<?php echo base_url(); ?>dealer/manageproducts/remove/all";
       } else {
           return false; // cancel button
       }
   }
   
    function clear_cart_by_row_id(row_id) {
       alert(row_id);
           window.location.href = "<?php echo base_url(); ?>dealer/manageproducts/remove/"+row_id;
       
   }
   
</script>
</body>
</html>