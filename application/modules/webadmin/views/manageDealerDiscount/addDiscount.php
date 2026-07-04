<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<!-- page specific plugin styles -->
<style>
.transfermenu ul li {
  border: 1px solid #ccc;
    display: none;
    float: left;
    margin-bottom: 10px;
    margin-right: 10px;
    padding: 10px;
    width: calc(100% - 20px);
    position: relative;
    max-height: 300px;
    overflow: auto;
}
.variationCheckbox {
  opacity:1 !important;
}
.product_lbl {
    font-weight: bold;
    font-size: 16px;
}
.discount_label {
    display: inline-block !important;
    padding-left: 20px !important;
    font-size: 13px;
    margin: 0 0 0 22px;
}
.variation_content {
    width: 30% !important;
    float: left !important;
    margin-right: 7px !important;
}
.margin_bottom {
    margin-bottom: 10px !important;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i> 
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
	  
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post">
            <div class="control-group <?php if(form_error('dealers') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_name">Dealers</label>
               <div class="controls">
                  <select name="dealer" class="dealer" id="dealer"><option value="">Select Dealer</option>
          				  <?php foreach($dealers as $dealers ) { ?>
          				  <option value="<?php echo $dealers->dealer_id ?>"><?php echo $dealers->f_name." ".$dealers->l_name; ?></option>
          				  <?php } ?>
        				  </select>
                  <span for="dealer_error" class="help-inline dealer_error"> <?php echo form_error('dealers') ?> </span>
               </div>
            </div>
			
			 <div class="control-group <?php if(form_error('product') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_name">Product</label>
               <div class="controls">
                  <select name="product" id="product"><option value="">Select Product</option>
				  <?php foreach($prodcuts as $prodcutss) { ?>
				  <option value="<?php echo $prodcutss->product_id ?>"><?php echo $prodcutss->product_name;?></option>
				  <?php } ?>
				  </select>
                  <span for="product_error" class="help-inline product_error"><?php echo form_error('dealers') ?> </span>
                   <div class="transfermenu">
                     <ul>
                      <input type="hidden" class="hid_dealerId" value="" />
                        <span for="product_variation" class="help-inline product_variation_error"> </span>
                        <?php             
                         $productIdName = productIdName($uinfo['comp_code']);
                         if(isset($productIdName) && !empty($productIdName)){
                            foreach($productIdName as $productIdName1){ 
                              $pId = $productIdName1->product_id;
                         ?>
                         <li id="li_<?php echo $productIdName1->product_id; ?>">
                           <input type="hidden" value="<?php echo $productIdName1->product_id;?>" name="dealerdiscount_product[]" class="dealerdiscount_product" id="dealerdiscount_product_<?php echo $productIdName1->product_id; ?>">
                           <p class="product_lbl"><?php echo $productIdName1->product_name;?></p>

                           
                           <!--<label>Select Batch</label>
                            <select name="batch_<?php echo $pId; ?>" class="batch">
                               <?php $batches = getProductBatchs($pId, $uinfo['comp_code']);
                               if(isset($batches) && !empty($batches)) {
                               
                                foreach($batches as $batch) { ?>
                                  <option value="<?php echo $batch['product_batch_id']; ?>"><?php echo $batch['batch_number']; ?></option>
                               <?php } } ?>
                            </select>-->

                            <?php
                               if(isset($batches) && !empty($batches)) {
                                 $firstBatch = $batches[0]['product_batch_id']; ?>
                              
                                 <input type="hidden" name="first_batch" class="first_batch_<?php echo $pId; ?>" value="<?php echo $firstBatch; ?>" />
                             <?php  } else {
                                  $firstBatch = 0;
                                }
                             ?>

                           <?php $productVariation=getProductVariation($productIdName1->product_id);

                            ?>

                           <div class="variation_div_<?php echo $pId; ?>">

                           </div>

                           <?php
                           if(!empty($productVariation)) {
                              if(count($productVariation) > 1) {
                                $commonFlag = 1;
                              } else {
                                $commonFlag = 0;
                              }
                             ?>
                             <input type="hidden" name="common_variation_flag" value="<?php echo $commonFlag; ?>" />
                           <ul id="quantity_<?php echo $productIdName1->product_id; ?>">
                             <?php 
                                foreach($productVariation as $productVariations) {
                                  $arrayVariationId=explode(',',$productVariations['variation_ids']);
                                  $variationName=getAllVariationNames($arrayVariationId);
                                   $allVariationName=[];
                                    foreach($variationName as $variationNames) {
                                       $allVariationName[]=$variationNames['attribute_value'];
                                    } 

                                $diswhere=['product_id'=>$productVariations['sku']]; 

                                $getDicountData=getStatus('dealer_product_price','price',$diswhere);
                                if(!empty($getDicountData)) {
                                  $price=$getDicountData->price;
                                  $checked='checked';
                                } else {
                                  $price='';
                                  $checked='';
                                }
                                 $mergeVariationName=implode(', ',$allVariationName);
                                 ?>
                              <li class="variation_content variation_<?php echo $productIdName1->product_id; ?>">
                                  <input type="checkbox" name="variationCheckbox[]" class="variationCheckbox" id="variationcheck_<?php echo $productVariations['sku']; ?>" value="<?php echo $productVariations['sku']; ?>" attrProductId="<?php echo $productIdName1->product_id; ?>" attrVariationRelation="<?php echo $productVariations['id']; ?>" />
                                  <label class="discount_label">Variation: <?php echo $mergeVariationName; ?></label>
                                  <label class="discount_label">SKU: <?php echo $productVariations['sku']; ?></label>

                                   <div class="quantity_<?php echo $productIdName1->product_id; ?>" style="padding-top: 10px;">
                                       <div class="dv-in">
                                          
                                  <span>Type</span>      
                                  <select name="price_type[<?php echo $productVariations['sku']; ?>]" id="price_type_<?php echo $productVariations['sku']; ?>" class="price_type margin_bottom">
                                      <option value="1">Percentage</option>
                                      <option value="2">Fixed</option>
                                  </select>

                                  <span>Price</span>
                                  <select name="discount_type[<?php echo $productVariations['sku']; ?>]" id="discount_type_<?php echo $productVariations['sku']; ?>" class="discount_type margin_bottom">
                                      <option value="1">Discount</option>
                                      <option value="2">Add More</option>
                                  </select>

                                          <span class="qty_keypress">
                                          <input class="quantity_input quantity_keypress" id="quantity_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="quantity[<?php echo $productVariations['sku']; ?>]" value="" placeholder="Enter Amount" />
                                          </span>
                                          <span for="name" class="stock-help-inline quantity_val_error_<?php echo $productVariations['sku'];?>">  </span>
                                          <input type="hidden" name="variation_price[<?php echo $productVariations['sku']; ?>]" value="<?php echo $productVariations['variation_price']; ?>">
                                       </div>
                                      </div>

                              </li>
                              <?php  }
                             ?>
                           </ul>
                              <?php 
                           } else {
                            echo 'No Variations !!';
                           } ?>
                         </li>
                         <?php } } ?>
                     </ul>
                  </div>
               </div>
            </div>
			
			<?php foreach($prodcuts as $prodcutss ) { ?>
            <div class="control-group p_details"  style="display:none;" id="p_details_<?php echo $prodcutss->product_id;?>">
               <label class="control-label" for="offer_name">Product Detail</label>
               <div class="controls">
                 <?php echo  "Product Price : ".$prodcutss->product_price.'</br>';
				 echo  "Product description : ".$prodcutss->product_description;
				   ?>
                 
               </div>
            </div>
			<?php } ?>
			 <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" value="discount_form" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Discount
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<!--inline scripts related to this page-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>-->

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	 $(document).on('click','.variationCheckbox',function() {
            //$('.variationCheckbox').each(function(index,el){
               var skuVal = $(this).val();
               if(this.checked) {
                //  $('.expiry_'+skuVal).removeAttr('disabled').datepicker();
               } else {
                  $('#quantity_keypress_'+skuVal).val('');
                  //$('.expiry_'+skuVal).val('');
                  //$('.expiry_'+skuVal).val('').attr('disabled','disabled');
               }
            //});
         });

 $(document).ready(function() {

  $('.batch').on('change', function() {
    var batchId = $(this).val();
    var productId = $('#product').val();
    var dealerId = $('#dealer').val();

      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>webadmin/managedealerdiscount/checkDiscountByBatch',
        data: {
          'batchId':batchId,
          'productId':productId,
          'dealerId':dealerId
        },
        success: function(data) {
          $('.variationCheckbox').removeAttr('checked');
          $('.quantity_input').val('');
          $('.discount_type').val('1');
          $('.price_type').val('1');
          var res = JSON.parse(data);
          $.each(res, function(i,v) {
            $('#variationcheck_'+i).prop('checked','checked');
            $('#price_type_'+i).val(v.price_type);
            $('#discount_type_'+i).val(v.type);
            $('#quantity_keypress_'+i).val(v.price);
          })
        }
      })

  });


$('.dealer').on('change', function() {
  var dealer_id  = $(this).val();
  $('.hid_dealerId').val(dealer_id);

  if($('#product').val()) {
    var p_id  = $('#product').val();
    //var batchId = $('.batch').val();
    //var firstBatchId = $('.first_batch_'+p_id).val();

    $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>webadmin/managedealerdiscount/checkDealerPriceByMasterPId/'+dealer_id+'/'+p_id,
      success: function(data){

        $('.variationCheckbox').removeAttr('checked');
        $('.quantity_keypress').val('');
        $('.variationCheckbox').removeAttr('checked');
        $('.quantity_keypress').val('');
      if(data!='') {
        var parseval=JSON.parse(data);
       
          $.each(parseval, function(index, value) {
 
            var sku=value.product_id;
            var price=value.price;
            var type=value.type;
            var pricetype=value.price_type;
           
            $('#quantity_keypress_'+sku).val(price);
            $('#variationcheck_'+sku).prop('checked','checked');
            $('#discount_type_'+sku).val(type).attr('selected','selected');
            if(pricetype!=0) {
              $('#price_type_'+sku).val(pricetype).attr('selected','selected');
            }
            
          });
        } 
      }
  });

  }

});

$( "#product" ).change(function() {
var p_id  = $(this).val();
var dealer_id  = $('.dealer').val();


 /*  $.ajax({
      type: "POST",
      url: '<?php echo base_url(); ?>webadmin/managedealerdiscount/checkDealerPriceByMasterPId/'+dealer_id+'/'+p_id,
      success: function(data){
        $('.variationCheckbox').removeAttr('checked');
        $('.quantity_keypress').val('');

      if(data!='') {
        var parseval=JSON.parse(data);

          $.each(parseval, function(index, value) {

            var sku=value.product_id;
            var price=value.price;
            var type=value.type;
            var pricetype=value.price_type;

            $('#quantity_keypress_'+sku).val(price);
            $('#variationcheck_'+sku).prop('checked','checked');
            $('#discount_type_'+sku).val(type).attr('selected','selected');
            if(pricetype!=0) {
              $('#price_type_'+sku).val(pricetype).attr('selected','selected');
            }
          });

        //alert('Discount has been addded already to the product.');
        } else {
        // alert('Discount price added.');
        }
      }
  });*/

  $('.p_details').hide();
  $('#p_details_'+p_id).show();
 $(".transfermenu ul li").css('display','none');
  var sku = $('#product option:selected').val();
      $(".transfermenu ul #li_"+sku).css('display','list-item');
      $(".variation_"+sku).css('display','list-item');
      $(".quantity_"+sku).css('display','list-item');

      var p_id  = $(this).val();
      var dealer_id  = $('.dealer').val();
      //var batchId = $('.first_batch_'+p_id).val();
      

      $.ajax({
        type: "POST",
        url: '<?php echo base_url(); ?>webadmin/managedealerdiscount/checkDealerPriceByMasterPId/'+dealer_id+'/'+p_id,
        success: function(data){

          $('.variationCheckbox').removeAttr('checked');
          $('.quantity_keypress').val('');
          $('.variationCheckbox').removeAttr('checked');
          $('.quantity_keypress').val('');
        if(data!='') {
          var parseval=JSON.parse(data);
         
            $.each(parseval, function(index, value) {
   
              var sku1=value.product_id;
              var price=value.price;
              var type=value.type;
              var pricetype=value.price_type;
             
              $('#quantity_keypress_'+sku1).val(price);
              $('#variationcheck_'+sku1).prop('checked','checked');
              $('#discount_type_'+sku1).val(type).attr('selected','selected');
              if(pricetype!=0) {
                $('#price_type_'+sku1).val(pricetype).attr('selected','selected');
              }
              
            });
          } 
        }
    });


});

$( ".submit" ).click(function() {
  var error_count = 0; 
var p_id  = $('#product').val();
var dealer_id  = $('#dealer').val();
var price = $('#price').val();

$('.variationCheckbox:checked').each(function() {
      var skuCheckbox = $(this).val();
      var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
     
      if(quantity_val==""){
         $(".quantity_val_error_"+skuCheckbox).text("Please Enter Discount Price.");
         //$("#exceed_error_"+skuCheckbox).empty();
         error_count++;
      }else {
         // hide message
         $(".quantity_val_error_"+skuCheckbox).empty();
      }
   });


  if(p_id=='') {
    $(".product_error").text("Please select product.");
    error_count++;
  }else if(parseInt($('.variationCheckbox:checked').length) <= 0) {
      $(".product_variation_error").text("Please select atleast one product.");
                error_count++;
  }else{
       $(".product_error").empty();
    }


if(dealer_id=='') {
  $(".dealer_error").text("Please select dealor.");
   error_count++;
}else{
     $(".dealer_error").empty();
  }

 
if(error_count>0){  
      //alert("Please Fill All Required Fields");
      return false;  
      } 


/*if(price=='') {
  $(".product_list_error").text("Please enter price.");
  error_count++;
}else{
     $(".product_list_error").empty();
  }

if(price<=0) {
   $(".product_list_error").text("Please enter correct price field value.");
   error_count++;
}else{
     $(".product_list_error").empty();
  }


        $.ajax({
            type: "GET",
            url: '<?php echo base_url(); ?>webadmin/managedealerdiscount/checkDisAddToProd',
            data: {p_id:p_id,dealer_id:dealer_id,price:price},
            success: function(data){
            if(data=='true') {
      				alert('Discount has been addded already to the product.');
      				} else {
      				alert('Discount price added.');
      				}
            }
        });*/
});
});
</script>
</body>
</html>