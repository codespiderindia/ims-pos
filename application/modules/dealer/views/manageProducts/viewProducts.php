<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('dealer_session_info');?>
<?php $dealer_id =  $uinfo['dealer_id']; ?>
<style type="text/css">
  .search-content .control-form, .search-content select {
  margin-top: 10px;
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
      <div class="search-content">
       
         Product Name <input type="text" name="product_name" id="product_name" class="control-form" />

          <?php $category = getProductCategoryParentNull($uinfo['comp_code']); ?>

          Select Category <select name="category_name" id="category_name_search" class="category_name_search">
            <option value="">Select Category</option>

            <?php  foreach($category as $categorys) { ?> 
              <option value="<?php echo $categorys['product_cat_id']; ?>">
                <?php echo $categorys['cat_name']; ?></option>
            <?php } ?>

            </select>

            <div class="range-container">
               <label for="amount" class="pricerange-label">Price range:</label>
                <label id="amount" style="border:0; color:#f6931f; font-weight:bold;"></label>
              <div id="slider-range" class="range-slider"></div>
            </div>

            <input type="hidden" value="0" id="product_start_amt" name="product_start_amt" />
            <input type="hidden" value="100000" id="product_end_amt" name="product_end_amt" />

            <input class="btn btn_border" style="margin-top: 10px;" name="search" value="Search" id="search_dealer_report" style="" type="submit">
        
      </div>
      <div class="row-fluid">
         <div class="span12">
            <div class="products-div">
               <?php
                  // echo '<pre>';
                   $cart_check = $this->cart->contents();
                   $cart_array = array();
                   foreach ($cart_check as $value) {
                     $cart_array[] = $value['id'];
                   }
                   
                   $view_cart_count = count($this->cart->contents());
                ?>
               <div class="cart-img">
                  <a href="<?php echo base_url() . 'dealer/manageproducts/viewCart'?>"><img src="<?php echo base_url();?>uploads/dealer/shopping_cart.png">View Cart </a><span id="cart_count"><?php echo count($this->cart->contents()); ?></span>
                    <?php //if(isset($view_cart_count) || $view_cart_count != '') 
                   // { echo $view_cart_count; } ?>
               </div>
             
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
                <a href="<?php echo base_url(); ?>dealer/manageproducts/productAddToCart/<?php echo $product->product_id; ?>">
                  <div class="product-div">
                  <div id="Loader_<?php echo $product->product_id;?>" class="Loader">
                         <div id="loading-image" class="loader"></div>
                      </div>
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
                  </div></a>
                  <?php }//endforeach?>
                  <div class="clr"></div>
                  <?php }//endif?>

                   <div class="pagination-div">
                    <ul>
                       <?php foreach ($links as $link) {
                          echo "<li>". $link."</li>";
                          } ?>
                    </ul>
                 </div>
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

        $('#search_dealer_report').click(function() {
          var product_name = $('#product_name').val(); 
          var category_name =  $('#category_name_search').val(); 
          var product_start_amt = $( "#product_start_amt" ).val();
          var product_end_amt = $( "#product_end_amt" ).val();

          var url="<?php echo site_url();?>dealer/manageproducts/getProductByFilter";
          $.ajax({
            url: url,
            type:'POST',
            beforeSend:function() {
                $('.prod-div').text('Loading...');
              },
            data: {product_name:product_name,category_name:category_name,product_start_amt:product_start_amt,product_end_amt:product_end_amt},
            success: function(datas){
              $('.prod-div').html(datas);
             // $('#warehouse_inventory_result').html(datas);
            }
          });
        });


        $(".Loader").hide();
        $("form").click(function(e){
          e.preventDefault();
          var url="<?php echo base_url();?>dealer/manageproducts/add_cart";
            var res = $( this).serialize();
            var array = res.split("&"); 
            var prod_id = array[0].split("="); 
            
          
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
                $('#cart_ok_'+prod_id[1]).show();
              }
            }
        });
        
      });
   });

    $( function() {
      $( "#slider-range" ).slider({
        range: true,
        min: 0,
        max: 100000,
        values: [ 0, 100000 ],
        slide: function( event, ui ) {
         $( "#amount" ).html( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
        //$( "#amount" ).val( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
      $( "#product_start_amt" ).val( ui.values[ 0 ]);
      $( "#product_end_amt" ).val( ui.values[ 1 ]);
      }
      });
       $( "#amount" ).html( "Rs " + $( "#slider-range" ).slider( "values", 0 ) +
        " - Rs " + $( "#slider-range" ).slider( "values", 1 ) );
      /*$( "#amount" ).val( "Rs " + $( "#slider-range" ).slider( "values", 0 ) +
        " - Rs " + $( "#slider-range" ).slider( "values", 1 ) );*/
    });

</script>
</body>
</html>