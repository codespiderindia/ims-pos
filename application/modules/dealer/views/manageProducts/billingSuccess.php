<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('dealer_session_info');?>
<?php
$grand_total = 0;
$orderId=$orderInfo[0]->order_id;
$country = $uinfo['country'];
$state = $uinfo['state'];

/* Get CGST And Sgst tax Details */
   $taxWhere=['order_id'=>$orderId];
   $getTotalTax=getSku('dealer_item',$taxWhere);
   $cgst=0;$sgst=0;$igst=0;
   foreach($getTotalTax as $getTotalTaxs) {
      $cgst += $getTotalTaxs['cgst_amt'];
      $sgst += $getTotalTaxs['sgst_amt'];
      $igst += $getTotalTaxs['igst_amt'];
   }
/* Get tax Details */

// Calculate grand total. 
if ($cart = $this->cart->contents()):
    foreach ($cart as $item):
        $grand_total = $grand_total + $item['subtotal'];
    endforeach;
endif;

$grand_total = $grand_total + $cgst + $sgst + $igst;
?>
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
            <div class="products-div pro-div"> 
               
               <div class="woocommerce">
                  <div class="pro-hd">
                    <p class="woocommerce-thankyou-order-received">Thank you. Your order has been received.</p>
                     <?php 
                        echo '<div class="product-add-but"><a href="'.base_url().'dealer/manageproducts/viewProducts">Return To Shop</a></div>';
                     ?>
                     <div class="clear"></div>
                  </div>
                  <ul class="woocommerce-thankyou-order-details order_details">
                     <li class="order">
                        Order Number:           <strong><?php echo $orderInfo[0]->order_id;?></strong>
                     </li>
                     <li class="date">
                        Date:          <strong><?php echo date('F j , Y',strtotime($orderInfo[0]->date));?></strong>
                     </li>
                     <li class="total">
                        Total:            <strong><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><?php echo number_format($grand_total, 2); ?> &#8360;</span></strong>
                     </li>
                  </ul>
                  
                  <h2>Order Details</h2>
                  
                  <table class="shop-table order-details">
                     <thead>
                        <tr>
                           <th class="product-name">Product</th>
                           <th class="product_sku">Attribute</th>
                           <th class="product_gstrate">GST Rate</th>
                           <th class="product-total">Total</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php foreach($orderInfo as $orderDetail){
                           $sku=$orderDetail->product_id;
                           if($sku!='') {
                              $skuVal=$sku;
                           } else {
                              $where=['relation_common_id'=>0,'product_id'=>$orderDetail->master_product_id,'flag'=>0];
                              $getSku=getSku('product_variations_relations',$where);
                              $skuVal=$getSku[0]['sku'];
                           }

                           /* Get tax Details */
                              $taxWhere=['product_ID'=>$skuVal, 'master_product_id'=>$orderDetail->master_product_id, 'order_id'=>$orderId];
                              $getTax=getSku('dealer_item',$taxWhere);
                              /* Get tax Details */
                           ?>
                        <tr class="order_item">
                           <td class="product-name">
                              <a href="javascript:void(0)"><?php echo product_name($orderDetail->master_product_id);?>(<?php echo $skuVal; ?>)</a> <strong class="product-quantity">× <?php echo $orderDetail->quantity;?></strong>   
                           </td>
                           <td>
                              <?php //echo $orderDetail->product_id.'</br>'; 
                                 $variationWhere=[
                                    'product_id'=>$orderDetail->master_product_id,
                                    'flag'=>1,
                                    'sku'=>$orderDetail->product_id];
                                    $getVariationId=getSku('product_variations_relations',$variationWhere);
                                    $variationId='';
                                    foreach($getVariationId as $getVariationIds) {
                                       $variationId .= $getVariationIds['variation_id'].',';
                                    }
                                    $Ids=rtrim($variationId, ',');
                                    $arrayVariation=explode(',',$Ids);
                              $allVariationName=getAllVariationNamesOfGroup($arrayVariation);
                              if($allVariationName[0]['attribute_value'] != '') {
                                  echo $allVariationName[0]['attribute_value'];
                               } else {
                                 echo $orderDetail->product_id;
                               }
                            ?>
                           </td>
                           <td>
                              <?php echo $getTax[0]['tax_per'].'% '; 
                                 echo ($getTax[0]['gst_inc'] == 0) ? '(Exclude)' : '(Include)';
                              ?>
                           </td>
                           <td class="product-total">
                              <span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span><?php echo round($orderDetail->price*$orderDetail->quantity, 2);?></span>   
                           </td>
                        </tr>
                        <?php }//endforeach?>
                        <tr>
                           <td>CGST</td>
                           <td></td>
                           <td></td>
                           <td><?php echo round($cgst, 2); ?></td>
                        </tr>
                        <tr>
                           <td>SGST</td>
                           <td></td>
                           <td></td>
                           <td><?php echo round($sgst, 2); ?></td>
                        </tr>
                        <tr>
                           <td>IGST</td>
                           <td></td>
                           <td></td>
                           <td><?php echo round($igst, 2); ?></td>
                        </tr>
                     </tbody>
                     <tfoot>
                        <tr>
                           <th scope="row">Total:</th>
                           <th></th>
                           <th></th>
                           <td  scope="row"><span class="woocommerce-Price-amount amount"><span class="woocommerce-Price-currencySymbol"></span>&#8360; <?php echo number_format($grand_total, 2); ?></span></td>
                        </tr>
                     </tfoot>
                  </table>
                  
                  <?php  $customerInfo = getCustomerDetailsById($orderInfo[0]->customer_id);?>

                  <header>
                     <h2>Customer Details</h2>
                  </header>


                  <table class="shop-table customer_details">
                     <tbody>
                        <tr>
                           <th>First Name:</th>
                           <td><?php echo $customerInfo->fname; ?></td>
                        </tr>
                        <tr>
                           <th>Last Name:</th>
                           <td><?php echo $customerInfo->lname; ?></td>
                        </tr>
                        <tr>
                           <th>Email:</th>
                           <td><?php echo $customerInfo->email; ?></td>
                        </tr>
                        <tr>
                           <th>Telephone:</th> 
                           <td><?php echo $customerInfo->mobile_number; ?></td>
                        </tr>
                     </tbody>
                  </table>
                  <header class="title">
                     <h3>Billing Address</h3>
                  </header>
                  <address>
                     <?php echo $customerInfo->address; ?>
                  </address>
               </div>


















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
</body>
</html>