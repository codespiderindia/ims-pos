<?php $uinfo = $this->session->userdata('dealer_session_info');?>
<?php $dealer_id =  $uinfo['dealer_id']; ?>

               <?php
                  // echo '<pre>';
                   $cart_check = $this->cart->contents();
                   $cart_array = array();
                   foreach ($cart_check as $value) {
                     $cart_array[] = $value['id'];
                   }
                   
                   $view_cart_count = count($this->cart->contents());
                ?>
              
               <div class="prod-div">
                  <?php if(isset($product) && !empty($product)){?>
                  <?php foreach ($product as $product) {
                    $productId = $product->product_id;
                    if (in_array($product->product_id, $cart_array))
                      {
                        $check_product_in_cart = "display:block";
                      }
                    else
                      {
                        $check_product_in_cart = "";
                      }
                    ?>
                
                  <div class="product-div">
                    <a href="<?php echo base_url(); ?>dealer/manageproducts/productAddToCart/<?php echo $product->product_id; ?>">

                     <div class="product-img">
                      <?php if($product->product_image != '') { ?>
                      <img src="<?php echo base_url() . 'uploads/product_image/thumbs/' . $product->product_image; ?>">
                      <?php }  else { ?>
                       <img src="<?php echo base_url() . 'assets/img/no_image.jpg' ?>">
                      <?php } ?>
                    </div>
    
                    <?php $discount_price = discounted_price_by_dealer_product_id($dealer_id,$product->product_id) ?>
                     <div class="product-info">
                        <div class="product-name"><?php echo $product->product_name;?>
                          
                        </div>

                        <div class="product-desc"><?php echo substr($product->product_description, 0, 45).' ...';?></div>
                        <div class="product-price">
                          <!-- Product MRP Price -->
                          <?php
                            $whereMini = ['master_product_id'=>$productId,'dealer_id'=>$dealer_id, 'dealer_original_price !='=>0];
                            $whereInArray = array(0,1);
                            $whereInColumnName = 'flag';

$getMini = getDataByOrderAndGroupBy('dealer_product_price',$whereMini,$whereInArray,$whereInColumnName,'dealer_original_price','asc','');

                            if(!empty($getMini)) {
                              $firstArr = current($getMini);
                              $price = $firstArr['dealer_original_price'];
                            } else {
                              $price = $product->product_price;
                            }

                          ?>
                          <span>
                            Price: <span><?php echo $price; ?></span> 
                          </span>
                        </div>
                     </div>
                      </a>
                  </div>

                  <?php } //endforeach?>
                  <div class="clr"></div>
                  <?php } else {  ?>
                    <div class="no_more_record" attrProduct="<?php echo $total_product; ?>" style="font-size: 16px;text-align: center;padding: 10px;">
                   <?php echo 'No More Record..!!'; } //endif?>
                      </div>
               </div>