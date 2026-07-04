<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style type="text/css">
   .category_cls {
      float: left;
   }
   
   .cut_form_fok_sp .controls {
  display: inline-block;
  margin-left: 16px;
}
.cut_form_fok_sp .control-label {
  display: inline-block;
  float: none;
  vertical-align: middle;
  padding-top: 0;
  margin-bottom: 0;
}
.newcategory {
  color: #438eb9;
  display: inline-block;
  float: none;
  margin-bottom: 0;
  padding-top: 3px;
  text-align: center;
  vertical-align: middle;
  width: 150px;
}
.product_help-inline {
  color: #d16e6c;
  display: inline-block;
  float: right;
}
.phoneNumberClass {
  margin-left: 180px;
}
.help-inline {
  color: red;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo (isset($heading) ? $heading : ''); ?> 
      </h1>

       
   </div>
    <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-block alert-success ">
               <button type="button" class="close" data-dismiss="alert">
               <i class="icon-remove"></i>                    
               </button>
               <p>
                  <strong>
                  <i class="icon-ok"></i>
                  Done!                     
                  </strong>
                  <?php echo $this->session->flashdata('success_msg'); ?>
               </p>
            </div>
        <?php endif; ?>
   <?php //echo validation_errors(); ?>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('product_name') != '') echo 'error'; ?>">
               <label class="control-label" for="product_name">Product Name</label>
               <div class="controls">
                  <select name="product_name" id="product_name">
                    <?php if(isset($products) && !empty($products)) {
                        foreach($products as $product) { ?>
                          <option value="<?php echo $product['product_id']; ?>"><?php echo $product['product_name']; ?></option>
                    <?php } } ?>
                  </select>
                  <span for="product_name" class="product_name_help-inline help-inline product_name"> <?php //echo form_error('product_code') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('batch_number') != '') echo 'error'; ?>">
               <label class="control-label" for="batch_number">Batch Number</label>
               <div class="controls">
                  <input type="text" id="batch_number" name="batch_number" value="<?php echo set_value('batch_number') ?>" />
                  <span for="batch_number" class="batch_number_help-inline help-inline batch_number"> <?php //echo form_error('product_code') ?> </span>
               </div>
            </div>
			
			
			     <div class="control-group <?php if(form_error('mfg_date') != '') echo 'error'; ?>">
               <label class="control-label" for="mfg_date">Mfg Date</label>
               <div class="controls">
                  <input type="date" id="mfg_date" name="mfg_date" value="<?php echo set_value('mfg_date') ?>" />
                  <span for="mfg_date" class="mfg_date_help-inline help-inline mfg_date">  </span>
               </div>
            </div>


         <div class="control-group <?php if(form_error('exp_date') != '') echo 'error'; ?>">
            <label class="control-label" for="exp_date">Exp dae</label>
            <div class="controls">
               <input type="date" id="exp_date" min="10" name="exp_date" value="<?php echo set_value('exp_date') ?>" />
               <span for="exp_date" class="exp_date_help-inline help-inline exp_date"> <?php //echo form_error('product_name') ?> </span>
            </div>
         </div>

            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit_btn" name="product_submit" value="product_form" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Batch
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
   $(document).ready(function(){
   $('#add_tax').multiselect({
   		includeSelectAllOption: true
   	});
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

   $(document).ready(function(){
   
   //form validation
   $( ".submit_btn" ).on("click",function() { 
   var error_count = 0;		
   
   var product_name =  $('#product_name').val(); 
   
   if(product_name=="")
   {
   	//alert("Please enter p name");
   	$(".product_name").text("Please Select Product.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".product_name").empty();
   	}
	

   var batch_number = $('#batch_number').val();
   var res;

   if(batch_number=="") {
      $(".batch_number").text("Please Enter Batch Number.");
      error_count++;
   } else if(batch_number!='') {

      var url="<?php echo base_url();?>webadmin/manageproduct/checkBatchNumber";
      $.ajax({
         type: 'post',
         url: url, 
         async:false,
         data: {'batch_number':batch_number, 'product_id':product_name},
         success:function (result) {
            if(result == 1) {
              $(".batch_number").text("Batch Number Already Exits.");
              error_count++;
            }
         }
      });
    
   } else {
      $(".batch_number").empty();
   }


	
	var mfg_date =  $('#mfg_date').val();
   if(mfg_date=="")
   {
   	//alert("Please enter p name");
   	$(".mfg_date").text("Please Enter Mfg Date.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".mfg_date").empty();
   	}
	
  
   
   var exp_date =  $("#exp_date").val();
   if(exp_date=="")
   {
   	//alert("Please enter p description");
   	$(".exp_date").text("Please Enter Expiry Date.");
   	error_count++;
   }
   else {
   	 // hide message
   	 $(".exp_date").empty();
   	}

    if(error_count > 0) {
      return false;
    }

    });
  });
   
</script>
</body>
</html>