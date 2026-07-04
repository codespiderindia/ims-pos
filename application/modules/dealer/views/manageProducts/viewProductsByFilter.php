<style type="text/css">
    .loadmore-content {
      text-align: center;
    }
</style>

<?php //$this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('dealer_session_info');?>
<?php $dealer_id =  $uinfo['dealer_id']; ?>

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
              
               <div class="prod-div" id="prod-content-id">
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
                  <?php } else { echo 'No Record..!!'; } //endif?>

               </div>
            </div>

            <div class="loadmore-content">
              <button class="load_more btn btn_border" attrVal="0">Load More</button>
            </div>


         </div>
       
<?php $this->load->view('include/layout_footer');?>
<script>
  /* $(function(){
         var oTable1 = $('#product_filter_table').dataTable( {
         "aoColumns": [
            { "bSortable": false,
            "aTargets": [0, 1, 2, 3]  },
         ] } );
   });*/
</script>

<script type="text/javascript">

   $(document).ready(function(){

        var theTotal = 0;
        var i;
        var offsetget = 0;
        $('.load_more').click(function() {

        if($(this).attr('attrVal') != '0') {
          theTotal = Number(theTotal) + Number($(this).attr('attrVal')) + 1;
        } else {
          theTotal = Number(theTotal) + 1;
        }
        
        $(this).attr('attrVal',theTotal);

        for(i=0; i<theTotal; i++) {

          if(i=theTotal) {

            if(i==6) {
               offsetget = 6 + 1;
            } else {
               offsetget = 6 * i;
            }
          }
        }


          <?php if($productName != '') { ?>
             var product_name = <?php echo $productName; ?>; 
          <?php } else { ?>
            var product_name = '';
         <?php } ?>


         <?php if($catId != '') { ?>
            var category_name =  <?php echo $catId; ?>;
          <?php } else { ?>
            var category_name = '';
          <?php } ?>

         
          var product_start_amt = <?php echo $startamt; ?>;
          var product_end_amt = <?php echo $endamt; ?>;

          var offsetval = offsetget;

          var url="<?php echo site_url();?>dealer/manageproducts/getProductByLoadMore";
          $.ajax({
            url: url,
            type:'POST',
            data: {product_name:product_name,category_name:category_name,product_start_amt:product_start_amt,product_end_amt:product_end_amt,offset:offsetval},
            success: function(datas){

              $('#prod-content-id').append(datas);
              var totalProduct = $('.no_more_record').val();
              if(totalProduct == 0) {
                $('.load_more').hide();
              }
            //  $('.loadmore-content').append('<input type="hidden" class="limit_val" attrOffset="'+offsetval+'" />');

            }
          });
        });
      });
</script>
</body>
</html>