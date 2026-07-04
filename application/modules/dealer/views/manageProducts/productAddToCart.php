<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('dealer_session_info');
    $userId=$uinfo['user_ID']; ?>
<?php $dealer_id =  $uinfo['dealer_id']; ?>
<style type="text/css">
  /*.product-desc {
    height: 40px;
  }*/
  .alert-success {
    display: none;
  }
  .return_to_shop {
    background-color: #438eb9;
    border: none;
    padding: 8px 25px;
    color: #fff;
    font-weight: bold;
    text-decoration: none;
    display: inline-block;
  }
  .return_to_shop a {
    color: white;
  }
</style>
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
     // if ($this->session->flashdata('success_msg')) {
      ?>
   <div class="alert alert-block alert-success">
      <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
      <p> <strong> <i class="icon-ok"></i> Done! Product Added successfully</strong>  </p>
   </div>
</div>
<!--/.page-header-->
<div class="row-fluid">
   <div class="span12">
      <!--PAGE CONTENT BEGINS-->
      <div class="row-fluid">
         <div class="span12">
            <div class="products-div">
               <?php
                   $cart_check = $this->cart->contents();
                   //echo '<pre>';
                   //print_r($cart_check);die;
                   $cart_array = array();
                   foreach ($cart_check as $value) {
                     $cart_array[] = $value['id'];
                   }
                   
                   $view_cart_count = count($this->cart->contents());
                ?>
                <div class="return_to_shop">
                  <a href="<?php echo base_url(); ?>dealer/manageproducts/viewProducts">Return To Shop</a>
                </div>
               <div class="cart-img">
                  <a href="<?php echo base_url() . 'dealer/manageproducts/viewCart'?>"><img src="<?php echo base_url();?>uploads/dealer/shopping_cart.png">View Cart </a><span id="cart_count"><?php echo count($this->cart->contents()); ?></span>
               </div>
               <div class="prod-div product-AddtoCart">
                  <?php $pId = $productId;

                  $product = getSku('product',['product_id'=>$pId]);

                   //$productPrice = $product[0]['product_price'];
                    if (in_array($pId, $cart_array))
                      {
                        $check_product_in_cart = "display:block";
                      }
                    else
                      {
                        $check_product_in_cart = "";
                      }
                    ?>
                     <?php $getVariation=getProductVariation($pId);
                     

                          $sku=[];
                          $val=[];
                        foreach($getVariation as $getVariations) {
                           $skuval=$getVariations['sku'];
                           $sku[]=$getVariations['sku'];
                           $variation=$getVariations['variation_ids'];

                           

                           if($variation != '') {
                              $arrayVariationId=explode(',',$variation);
                              $value=getAllVariationNamesOfGroup($arrayVariationId);
                              $val[$skuval]=$value[0]['attribute_value'];
                           } else {
                             $val[$skuval]=(isset($value[0]['attribute_value']) ? $value[0]['attribute_value'] : '');
                           }
                         } 


                  foreach($val as $key=>$vals) {

                      $where=['product_id'=>trim($key), 'dealer_id'=>$dealer_id, 'created_by'=>$userId];
                      $getDiscount=getSku('dealer_product_price',$where);

                      $productPrice = getVariations($key,$pId);
                      if(!empty($productPrice) && isset($productPrice))
                      {
                        $productPrice = $productPrice;
                      }
                      else{
                        $productPrice = $product[0]['product_price'];
                      }
                      
                    if(!empty($getDiscount)) {
                    
                      $type=$getDiscount[0]['type'];
                      $priceType=$getDiscount[0]['price_type'];
                      $discount=$getDiscount[0]['price'];

                      if($priceType==1) {
                        $disPrice = (($discount*$productPrice)/100);
                        $priceType = '%';
                        if($type==1) {
                          $disType='Discount';
                          $price=$productPrice-$disPrice;
                          //$discountAmount=$discount.$priceType.'('.$disType.')';
                          $originalprice[$key]=$price; // Orignial price for discount
                        }

                        if($type==2) {
                          $disType='Extra';
                          $price=$productPrice+$disPrice;
                          //$discountAmount=$discount.$priceType.'('.$disType.')';
                         // $discountAmount='';
                          $originalprice[$key]=$price; // Original price for add extra price in product price
                        }
                      }

                      if($priceType==2) {
                        $priceType = 'Fixed';
                        if($type==1) {
                          $disType='Discount';
                          $price=$productPrice-$discount;
                         // $discountAmount=$discount.'('.$priceType.' '.$disType.')';
                          $originalprice[$key]=$price; // Orignial price for discount
                        }

                        if($type==2) {
                          $disType='Extra';
                          $price=$productPrice+$discount;
                          //$discountAmount=$discount.'('.$priceType.' '.$disType.')';
                        //  $discountAmount='';
                          $originalprice[$key]=$price; // Original price for add extra price in product price
                        }
                      }
                    }
                  }

                         ?>
                    <table class="table table-bordered">
                      <thead>
                        <tr>
                          <th>Sr.</th>
                          <th>Image</th>
                          <th>Product name</th>
                          <th>Product Code</th>
                          <th>Product Variation</th>
                          <th>SKU</th>
                          <th>Quantity</th>
                          <th>Price</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>1</td>
                           <td>
                            <?php if($product[0]['product_image'] != '') { ?>
                              <img src="<?php echo base_url() . 'uploads/product_image/thumbs/' . $product[0]['product_image']; ?>">
                           <?php } else { ?>
                              <img src="<?php echo base_url() . 'assets/img/no_image.jpg' ?>">
                           <?php } ?>
                            </td>
                          <td><?php echo $product[0]['product_name'];?></td>
                          <td><?php echo $product[0]['product_code'];?></td>
                          <td><ul name="sku_Select">
                              <?php if(!empty($val)) { foreach($val as $key=>$vals) { ?>
                             <li value="<?php echo $key; ?>"><?php echo $vals; ?></li>
                              <?php } } else { echo '-';} ?>
                              </ul>
                          </td>
                          <td>
                            <ul name="sku_Select">
                              <?php if(!empty($val)) { foreach($val as $key=>$vals) { ?>
                                <li value="<?php echo $key; ?>"><?php echo $key; ?></li>
                              <?php } } else { echo '-';} ?>
                              </ul>
                          </td>
                          <td class="quantity_td">
                            <span class="quantity_val_error"></span>
                            <?php if(!empty($val)) { foreach($val as $key=>$vals) { ?>
                              <input type="number" name="quantity" placeholder="Enter Quantity" class="quantity" attrSku="<?php echo $key; ?>" attrPid="<?php echo $pId; ?>" min="0" attrPrice="<?php echo (isset($originalprice[$key]) && $originalprice[$key] != '') ? $originalprice[$key] : $productPrice; ?>"/>
                            <?php } }else { ?>
                              <input type="number" name="quantity" placeholder="Enter Qty" class="quantity" attrSku="<?php echo $pId; ?>" attrPid="<?php echo $pId; ?>" min="0" attrPrice="<?php echo $productPrice; ?>"/>
                           <?php } ?>
                          </td>
                          <td>
                            <ul name="sku_Select">
                              <?php 
                          if(!empty($val)) { foreach($val as $key=>$vals) { ?>
                               <li><?php if(isset($originalprice[$key]) && $originalprice[$key] != '') {
                                echo $originalprice[$key]; } else {
                                  //echo $product[0]['product_price']; 
                                  echo $productPrice; 
                                } ?>
                                </li>
                          <?php } }
                         // echo $product[0]['product_price']; 

                          ?></ul></td>
                          <td>
                            <?php 
                            $discount_price = discounted_price_by_dealer_product_id($dealer_id,$pId);

                            echo form_open();
                            echo form_hidden('product_id', $pId);
                            echo form_hidden('product_name', $product[0]['product_name']);
                            if($discount_price) {
                              $discount_price=$productPrice-$discount_price;
                              echo form_hidden('product_price', $discount_price);
                               } else {
                              echo form_hidden('product_price', $productPrice);
                            } ?>
                            <div class="qty_hidden_cls">
                            </div>
                            <div class="price_hidden_cls">
                            </div>
                            <div class="product-add-but">
                            <input type="submit" id="add_to_cart_<?php echo $pId;?>" name="add_to_cart" value="Add to Cart" />
                            <span style=" <?php echo "$check_product_in_cart";?>" class="icon-ok add_tocart_ok" id="cart_ok_<?php echo $pId;?>"></span>
                           </div>
                            <div style="display: none;" id="prod_added_<?php echo $pId;?>">Product Has Been added.</div>
                            <?php echo form_close();?>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                
                  <div class="clr"></div>
                 
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

   $(document).ready(function(){
     //  $('.alert-success').css('display','none');
     // $('.quantity').each(function() {
        $('.quantity').bind('change', function() {
           var qtyVal = $(this).val();
           var sku = $(this).attr('attrsku');
           var price = $(this).attr('attrPrice');
           var productId = $(this).attr('attrpid');
           $('.qty_hidden_cls').append('<input type="hidden" name="product_name['+sku+']" id="'+sku+'" pId="'+productId+'" value="'+qtyVal+'" />');
           //$('.price_hidden_cls').append('<input type="hidden" name="product_price['+sku+']" id="'+sku+'" pId="'+productId+'" value="'+price+'" />');
        });

       /* $('.product_quantity').keyup(function() {
           var qtyVal = $(this).val();
           var sku = $(this).attr('attrsku');
           var productId = $(this).attr('attrpid');
           $('.qty_hidden_cls').append('<input type="hidden" name="product_name['+productId+']" id="'+productId+'" pId="'+productId+'" value="'+qtyVal+'" />');
        });*/
     // });


        $(".Loader").hide();
        $("form").click(function(e){
          var error_count = 0;
          e.preventDefault();
            var url="<?php echo base_url();?>dealer/manageproducts/add_cart";
            var res = $(this).serialize();
            var array = res.split("&"); 
            var prod_id = array[0].split("="); 


            var $nonempty = $('.quantity').filter(function() {
              return this.value != ''
            });
          
            if ($nonempty.length == 0) {
              $(".quantity_val_error").text("Please Enter Quantity");
                error_count++;
            } else {
              $(".quantity_val_error").empty();
            }
          
              if(error_count>0) 
             {  
              //alert("if");
              return false;  
             } else {
               //alert("else");
                 $.ajax({
                    type: 'post',
                    url: url, 
                    data: $(this).serialize(),
                    beforeSend: function() {
                      $("#Loader_"+prod_id[1]).show();
                    },
                    success: function (result) {
                      $( "#cart_count" ).text(result);
                      $("#Loader_"+prod_id[1]).hide();
                      if(result!=0)
                      {
                       // $('#cart_ok_'+prod_id[1]).show();
                       $('.qty_hidden_cls').html('');
                       //$('.price_hidden_cls').html('');
                        $('.alert-success').css('display','block').delay(5000).fadeOut();
                        $('.quantity').val('');
                      }
                    }
                });
             }
      });
   })
</script>
</body>
</html>