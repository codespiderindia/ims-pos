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
   .attribute_input_div {
      position: relative !important;
   }
.cut_form_fok_sp .control {
  display: inline-block !important;
  margin-left: 16px;
}
.cut_form_fok_sp .control-label {
  display: inline-block;
  float: none;
  vertical-align: middle;
  padding-top: 0;
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

   <?php if(isset($success_msg) && $success_msg != ''): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $success_msg; ?> </p>
      </div>
   <?php endif; ?>

   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post">
            <div class="control-group">
               <label class="control-label" for="role">Select Product</label>
               <div class="control">
                  <select name="product_id" id="product_id" class="product_id">
                     <?php $where=['comp_code'=>$uinfo['comp_code']];
                      $allProduct=getSku('product',$where);
                      foreach($allProduct as $allProducts){ ?>
                      <option value="<?php echo $allProducts['product_id']; ?>"><?php echo $allProducts['product_name']; ?></option>
                      <?php } ?>
                  </select>
                  <span for="add_product" class="help-inline product_id">  </span>
               </div>
            </div>
			
            <div class="control-group <?php if(form_error('attr_value') != '') echo 'error'; ?>" id="attrVal_content">
               <label class="control-label" for="product_name">Attribute</label>
               <div class="controls productMenu">
                  <?php //$attributs = get_attributes();
                     $attributs = getAttributesByCompCode($uinfo['comp_code']);
                     if(!empty($attributs)) { ?>
                  <ul>
                     <?php foreach($attributs as $attributs){?>
                     <li id="attribute_enter_<?php echo $attributs['attribute_id']; ?>">
                        <input type="checkbox" class="attribute_id" id="attribute_id_<?php echo $attributs['attribute_id']; ?>" name="attribute_id" value="<?php echo $attributs['attribute_id']?>">


                        <span class="lbl labelname__<?php echo $attributs['attribute_id']; ?>"> <?php echo $attributs['attribute_name']?></span>
                        
                        <div style="display:none" class="attribute_input_div" id="attribute_add_div_<?php echo $attributs['attribute_id']; ?>">
                           <select id="text_<?php echo $attributs['attribute_id']; ?>" class="multipleSelect" multiple name="attr_value[<?php echo $attributs['attribute_id']; ?>][]">
                              <?php 
                                 $get_attribute_values = get_attribute_values($attributs['attribute_id']);
                                 if(!empty($get_attribute_values)) {

                                 foreach($get_attribute_values as $attributes){
                                 ?>
                              <option label="<?php echo $attributes['attribute_value'];?>" data_id="<?php echo $attributes['attribute_value_id'];?>" value="<?php echo $attributes['attribute_value_id'];?>"><?php echo $attributes['attribute_value'];?></option>
                              <?php }  }?>
                           </select>
                           <button type="button" id="<?php echo $attributs['attribute_id']; ?>" class="addnew btn btn-info buttonThemeColor">Add new</button>
                           <span id="error_<?php echo $attributs['attribute_id']; ?>" for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
                        </div>
                     </li>
                     <?php }?>
                  </ul>
                  <?php } else {
                     echo '<h5>No Attributes..</h5>';
                  } ?>
                  <span for="attr_value" class="product_help-inline attribute_value"> <?php //echo form_error('attr_value') ?> </span>
               </div>
            </div>
			
            <div class="form-actions">
               <input class="submit_btn" name="productSku_submit" value="Add Product SKU" type="submit" />
              
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
   $('#add_tax').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
<!--multiselect scripts related to this page-->
<!--autocomplete scripts related to this page-->
<script src="<?php echo base_url();?>/assets/js/fastselect.standalone.js"></script>
<script>
   $('.multipleSelect').fastselect();
</script>
<!--autocomplete scripts related to this page-->
<script>
   function uniqId() {
        return Math.round(new Date().getTime() + (Math.random() * 100));
      }

   $(document).ready(function(){
   
   	$( ".attribute_id" ).on('click',function() { 
   	  var h3_id = $(this).attr("id").split('attribute_id_');
   	  //alert(h3_id[1]);
   	  $( "#attribute_add_div_"+h3_id[1] ).toggle();

      //  $( "#attribute_add_div_"+h3_id[1] ).css({'position':'relative','z-index':'9999'});

   	  $( "#error_"+h3_id[1] ).empty();
   	});
   	

     /* $('.product_id').on('change',function() {
         var pId = $(this).val();
         $.ajax({
            url: "<?php echo site_url();?>webadmin/manageproduct/getAttrValue",
            type:'POST',
            data:"product_id="+pId,
            success: function(data){
               if(data!=''){
                  $('#attrVal_content').html(data); 
               }
            }
            });
      });*/

    $('body').on('click', '.addnew', function(event) {

 //  $( ".addnew" ).click(function(event) {
      event.preventDefault();

         var attrValue = prompt("Enter a name for the new attribute value:", "");
         var attr_id = $(this).attr("id");
         var pId = uniqId();

         var selected_value = '';
         $('#text_'+attr_id).prev('.fstControls').find('.fstChoiceItem').each(function() {
            selected_value += $(this).attr('data-text') + ',';
         });


         if (attrValue != null && attrValue.length>0) {
            //$("#text_"+attr_id).val(person);
            var url="<?php echo site_url();?>webadmin/manageproduct/addAttrValue";
               $.ajax({
                  url: url,
                  type:'POST',
                  data:"attribute_value="+attrValue+"&attribute_id="+attr_id+"&prodcut_id="+uniqId()+"&selected_value="+selected_value,
                  success: function(data){

                     /*alert(res);
                     var returnedData = jQuery.parseJSON(res);*/
                     
                     $('#attribute_add_div_'+attr_id).html(data); 

                  }
               });
         }
         else{
            alert("Please enter value");
         }
      });
   });


   $(".productMenu input[type=checkbox]:checked").each(function() {
      var attributeId = $(this).val();
      $('#attribute_add_div_'+attributeId).css('display','block');
   });
   
   
   
   //form validation
   $( ".submit_btn" ).on("click",function() { 
   var error_count = 0;		
   
  /* var product_id =  $('#product_id').val(); 
   if(product_id=="")
   {
   	//alert("Please enter p name");
   	$(".product_id").text("Please Select Product.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".product_id").empty();
   }*/
   if($(".productMenu input[type=checkbox]:checked").length > 0) {
      $('.attribute_value').empty();
   } else {
      $('.attribute_value').text('Please select attribute.');
      error_count++;
   }
	
	
	$(".productMenu input[type=checkbox]").each(function () {
         if (this.checked) {
            var attribute_id =  $(this).val();

            var attribute_value =  $(".labelname__"+attribute_id).text();
            //console.log($(this).val());

            if ($("#attribute_add_div_"+attribute_id+" .fstChoiceItem").length === 0) 
            { 
            //alert(attribute_id);
               $( "#error_"+attribute_id ).text( "Please Enter "+attribute_value+" Value." );
               error_count++;
            // show message 
            }  
         else {
          // hide message
          $( "#error_"+attribute_id ).empty();
         }
      } 
   });
	
/*Commented By :Manoj as discussed with manish ji*/
/*
   if(image_name=='') {  // show message 
   //alert("Please enter p image_name");
   $(".product_image").text("Please Enter Product Image.");
   error_count++;
   }    
   else {   
   	// hide message
   	$(".product_image").empty();
   	
   }

*/ 

   if(error_count>0) 
   {  
   	//alert("Please Fill All Required Fields");
   	return false;  
   }
   
   });
   	

   $(document).ready(function() {
      $('.newcategory').click(function() {
         var url="<?php echo site_url();?>webadmin/manageproductcategory/addProductCategory?status=1";
         window.location.assign(url);
      });
   });
   
</script>
</body>
</html>