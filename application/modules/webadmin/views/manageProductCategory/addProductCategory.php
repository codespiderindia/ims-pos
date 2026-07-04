<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

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

<style>
.help-inline {
  font-size: 13px;
  padding-left: 0;
}
</style>
   <!--/.page-header-->
   <div class="row-fluid">
   <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <?php if($this->input->get('status') == 1) { ?>
               <input type="hidden" name="addproduct-url" value="<?php echo base_url() ?>webadmin/manageproduct/addProduct">
           <?php } ?>

            <div class="control-group <?php if(form_error('parent_category') != '') echo 'error'; ?>">
               <label class="control-label" for="parent_category">Parent Category</label>
               <div class="controls">
                  <select name="cat_parent_id" class="cat_parent_id" id="cat_parent_id">
                    <option value="">Select Parent Category</option>
      					<?php 
      						$getProductCategory = getProductCategory($uinfo['comp_code']);
                         
      						foreach($getProductCategory as $singlecat)
      						{
      							if($singlecat["cat_parent_id"]==0){
                              if($parentCategory == $singlecat["product_cat_id"]) {
                                 $selected = 'selected';
                              } else {
                                 $selected = '';
                              }

      							echo '<option class="optionGroup"  value='.$singlecat["product_cat_id"].' '.$selected.'>'.$singlecat["cat_name"].'</option>';		
      								$getSubCategory = getSubCategory($singlecat["product_cat_id"]);
      								/*foreach($getSubCategory as $singleSubcat)
      								{
      									echo '<option class="optionChild" value='.$singleSubcat["product_cat_id"].'>'.$singleSubcat["cat_name"].'</option>';	
      								} */
      							}
      						}
      					?> 
                  </select>
                  <span for="parent_category" class="help-inline"> <?php echo form_error('parent_category') ?> </span>
               </div>
            </div>
			
			<div class="control-group subcat" id="subcat" style="display:none;">
               <label class="control-label" for="category_name">Sub Category Name</label>
               <div class="controls subcatelement" id="subcatelement">
                  
                  
               </div>
            </div>
			 <div class="control-group <?php if(form_error('category_name') != '') echo 'error'; ?>">
               <label class="control-label" for="category_name">Category Name</label>
               <div class="controls">
                  <input type="text" id="category_name" name="category_name" value="<?php echo set_value('category_name') ?>" />
                  <span for="category_name" class="help-inline"> <?php echo form_error('category_name') ?> </span>
               </div>
            </div>
			
			
			
			 <div class="control-group royalty_point" >
               <label class="control-label" for="royalty_point">1 Point Price </label>
               <div class="controls">
                  <input type="text" id="royalty_point" name="royalty_point" value="<?php echo set_value('royalty_point') ?>" />
				  <br /><span for="category_name" class="help-inline"> <?php echo form_error('category_name') ?> Example: 1 point = 500Rs on product of this category.</span>
                  
               </div>
            </div>
			
			<div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit_btn" name="product_submit" value="product_form" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Category
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
<script type="text/javascript">
$(document).ready(function(){

$(document).on('change','#cat_parent_id',function() {
var cat_id = $(this).val();

if(cat_id!='') {


				

var url="<?php echo base_url(); ?>webadmin/manageproductcategory/getSubCatByParID";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {cat_id:cat_id},
		    success: function(datas){
   			$('#dealer_payment_result').html(datas);
   			$('#subcat').show();
			   $('#subcatelement').html(datas);
			
   			}
   			});

}

}); 
});
</script> 
</body>
</html>