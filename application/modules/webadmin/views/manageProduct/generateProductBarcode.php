<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style type="text/css">
   .category_cls {
      float: left;
   }
   .newcategory {
      width: 150px;
      float: left;
      text-align: center;
      color: #438EB9;
   }
   .transfermenu ul{
      list-style:none;
      margin-left:0px!important;
      margin-top: 10px;
      width: 100%;
      display: inline-block;
   }
   .transfermenu ul ul {
         margin-top: 0;
   }
   .transfermenu ul ul ul {
         margin: 5px 0 0;
   }
   .transfermenu ul li {
      border: 1px solid #ccc;
      display: none;
      float: left;
      margin-bottom: 10px;
      margin-right: 10px;
      padding: 10px;
      width: calc(100% - 20px);
      position:relative;
      max-height: 300px;
      overflow: auto;
   }
   .transfermenu ul li ul li {
      border: 1px solid #cccccc;
      display: inline-block;
      margin-left: 0;
      margin-right: 0;
      margin-top: 0;
      padding: 12px;
      width: 20%;
      overflow: inherit;
      vertical-align: top;
     /* min-height: 160px;*/
   }
   .transfermenu ul li ul li span input {
       width: calc(100% - 15px);
       font-size: 12px;
   }
   .transfermenu ul li ul li ul li {
      width: auto;
      padding: 0;
      border: none;
      margin: 0;
      display: block;
   }
   .transfermenu ul li ul li label {
      font-size: 13px;
      margin: 0 0 0 22px;
   }
   /*.transfermenu ul li:hover ul{
   display:block;
   }*/
   .transfermenu ul li ul li{
   float:none;
   }
   .transfermenu input{
   opacity:1;
   }
   .help-inline {
    color: red;
   }
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?> 
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
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('product_name') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Product Name</label>
               <div class="controls">
                  <select name="product_name" id="product_list" class="product_list">
                      <option value="">Select Product</option>
                     <?php $allproduct = productIdName($uinfo['comp_code']);
                        foreach($allproduct as $allproducts) { ?>
                           <option value="<?php echo $allproducts->product_id; ?>"><?php echo $allproducts->product_name; ?></option>
                       <?php }
                      ?>
                  </select>
                   <span for="country" class="help-inline product_list_error"> </span>
                  <div class="transfermenu">
                     <ul>
                        <span for="product_variation" class="help-inline product_variation_error"> </span>
                        <?php             
                         $productIdName = productIdName($uinfo['comp_code']);
                         if(isset($productIdName) && !empty($productIdName)){
                            foreach($productIdName as $productIdName1){ 
                              $pID = $productIdName1->product_id;
                         ?>
                         <li id="li_<?php echo $productIdName1->product_id; ?>">
                           <input type="hidden" value="<?php echo $productIdName1->product_id;?>" name="product_in_warehouse[]" class="product_in_warehouse" id="product_in_warehouse_<?php echo $productIdName1->product_id; ?>">
                           <b><p class="product_lbl"><?php echo $productIdName1->product_name;?></p></b>

                           <!--<label>Select Batch</label>
                           <select name="batch_<?php echo $pID; ?>" class="batchcls">
                            <?php $batches = getProductBatchs($pID, $uinfo['comp_code']);
                              foreach($batches as $batch) { ?>
                                <option value="<?php echo $batch['product_batch_id']; ?>"><?php echo $batch['batch_number']; ?></option>
                             <?php } ?>
                           </select>-->

                           <?php $productVariation=getProductVariation($productIdName1->product_id);
                           if(!empty($productVariation)) {
                           ?>
                           <ul id="quantity_<?php echo $productIdName1->product_id; ?>">
                              <?php 
                                  foreach($productVariation as $productVariations) {
                                    $arrayVariationId=explode(',',$productVariations['variation_ids']);
                                    $variationName=getAllVariationNames($arrayVariationId);
                                    //echo $productVariations['variation_ids'];
                                    $allVariationName=[];
                                    foreach($variationName as $variationNames) {
                                       $allVariationName[]=$variationNames['attribute_value'];
                                    }
                                    $mergeVariationName=implode(', ',$allVariationName); ?>
                                 <li class="variation_<?php echo $productIdName1->product_id; ?>">
                                    <input type="checkbox" name="variationCheckbox[]" class="variationCheckbox" value="<?php echo $productVariations['sku']; ?>" attrProductId="<?php echo $productIdName1->product_id; ?>" attrVariationRelation="<?php echo $productVariations['id']; ?>">
                                    <label>Variation: <?php echo $mergeVariationName; ?></label>
                                    <label>SKU: <?php echo $productVariations['sku']; ?></label>
                                    <ul>
                                      <li class="quantity_<?php echo $productIdName1->product_id; ?>">
                                       <div class="dv-in">
                                          <span>Label</span>
                                          <span class="qty_keypress">
                                          <input class="quantity_input quantity_keypress" id="quantity_keypress_<?php echo $productVariations['sku']; ?>" type="text"  name="quantity[<?php echo $productVariations['sku']; ?>]" value="" />
                                          </span>
                                          <span for="name" class="help-inline stock-help-inline quantity_val_error_<?php echo $productVariations['sku'];?>">  </span>
                                       </div>
                                      </li>
                                   </ul>
                                 </li>
                              <?php }  ?>
                           </ul>
                           <?php } else { echo '<h4>'.'No Variation'.'</h4>'; } ?>
                         </li>
                         <?php } } ?>
                     </ul>
                  </div>
               </div>
            </div>
			
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit_btn transfer" name="productbarcode_submit" value="product_form" type="submit">
               <i class="icon-ok bigger-110"></i>
               Generate Barcode
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
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>

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
         $('#product_list').on('change',function() {
            $('.variationCheckbox').attr('checked',false);
            $(".transfermenu ul li").css('display','none');
            var sku = $('#product_list option:selected').val();
             $(".transfermenu ul #li_"+sku).css('display','list-item');
             $(".variation_"+sku).css('display','list-item');
             $(".quantity_"+sku).css('display','list-item');
         });


         //form validation
        $( ".transfer" ).on("click",function() { 
            var error_count = 0; 


         $('.variationCheckbox:checked').each(function() {
            var skuCheckbox = $(this).val();

            var quantity_val = $('#quantity_keypress_'+skuCheckbox).val();
           
            if(quantity_val==""){
               $(".quantity_val_error_"+skuCheckbox).text("Please Enter Quantity value");
               //$("#exceed_error_"+skuCheckbox).empty();
               error_count++;
            }else {
               // hide message
               $(".quantity_val_error_"+skuCheckbox).empty();
            }

         });

            var product_list =  $('#product_list').val();
            if(product_list==null || product_list==""){
               //alert("Please enter p name");
               $(".product_list_error").text("Please select Product.");
               error_count++;
            }else if(parseInt($('.variationCheckbox:checked').length) <= 0) {
                $(".product_variation_error").text("Please select atleast one product.");
                error_count++;
             }else{
               // hide message
               $(".product_list_error").empty();
            }

            if(error_count>0){  
            //alert("Please Fill All Required Fields");
            return false;  
            }

        });

      });
   </script>

<!--multiselect scripts related to this page-->
<!--multiselect scripts related to this page-->
<!--autocomplete scripts related to this page-->
</body>
</html>