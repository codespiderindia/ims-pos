<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('cat_id') != '') echo 'error'; ?>">
               <label class="control-label" for="cat_id">Category</label>
               <div class="controls">
               	 <select name="cat_id" id="cat_id" class="category_id">
                    <option value="">Select Category</option>
                    <?php 
      						$getProductCategory = getCategoryForLoyaltyPoint($uinfo['comp_code']);
                         
      						foreach($getProductCategory as $singlecat)
      						{
      							if($singlecat["cat_parent_id"]==0 || $singlecat['cat_status']==1){

  								echo '<option class="optionGroup"  value='.$singlecat["product_cat_id"].'>'.$singlecat["cat_name"].'</option>';		
  								$getSubCategory = getSubCategory($singlecat["product_cat_id"]);

  								}
      						}
      					?> 
                </select>
                  <span for="cat_id" class="help-inline cat_id"> <?php echo form_error('cat_id') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('price') != '') echo 'error'; ?>">
               <label class="control-label" for="price">Price</label>
               <div class="controls">
                  <input type="text" id="price" name="price" value="<?php echo set_value('price') ?>" />
                  <span for="price" class="help-inline price"> <?php echo form_error('price') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('loyalty_point') != '') echo 'error'; ?>">
               <label class="control-label" for="loyalty_point">Loyalty Point</label>
               <div class="controls">
                  <input type="number" min="0" id="loyalty_point" name="loyalty_point" value="<?php echo set_value('loyalty_point') ?>" />
                  <span for="loyalty_point" class="help-inline loyalty_point"> <?php echo form_error('loyalty_point') ?> </span>
               </div>
            </div>

            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" value="submit_form" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Points
               </button>
               &nbsp; &nbsp; &nbsp;
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
<script type="text/javascript">
	$(document).ready(function() {
		$('.category_id').on('change', function() {
			var cat_id=$(this).val();
			var url="<?php echo site_url();?>webadmin/manageloyaltypoint/checkCategoryExist";
			$.ajax({
				url:url,
				type:'post',
				data:"cat_id="+cat_id,
				success:function(response) {
					if(response!='') {
						var res=JSON.parse(response);
						var price=res.price;
						var categoryId=res.category_id;
						var loyaltyPoint=res.loyalty_point;

						$('#price').val(price);
						$('#loyalty_point').val(loyaltyPoint);
					}
				}
			});
		});

		$( ".submit" ).on("click",function() {
			var error_count = 0;	

			var cat_id =  $('#cat_id').val();
		    if(cat_id=="")
		    {
				$(".cat_id").text("Please Select Category.");
				error_count++;
		    }
		    else {
			    $(".cat_id").empty();
			} 

			var price = $('#price').val();
			if(price=="") {
				$(".price").text("Please Enter Price.");
				error_count++;
			 } else if(!$.isNumeric(price)) {
			 	$(".price").text("Please Enter Digit Only!!.");
				error_count++;
			 }
			else {
				$(".price").empty();
			}


			var loyalty_point = $('#loyalty_point').val();
			if(loyalty_point=="") {
				$(".loyalty_point").text("Please Enter Point.");
				error_count++;
			} else {
				$(".loyalty_point").empty();
			}


			if(error_count>0) 
		   {  
		   	//var body = $("html, body");
			//body.stop().animate({scrollTop:0});
			return false;  
		   } 

		});
	});
</script>
<style>
.help-inline{color:red;}
</style>
</body>
</html>
