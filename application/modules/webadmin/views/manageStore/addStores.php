<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
.help-inline {
   color: black;
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
}
.help-inline.sp{
	display: block;
	margin-left: 180px;
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
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('store_name') != '') echo 'error'; ?>">
               <label class="control-label" for="store_name">Store Name</label>
               <div class="controls">
                  <input type="text" id="store_name" name="store_name" value="<?php echo set_value('store_name') ?>" />
                  <span for="name" class="help-inline store_name"> <?php echo form_error('store_name') ?> </span>
               </div>
            </div>

             <div class="control-group <?php if(form_error('store_code') != '') echo 'error'; ?>">
               <label class="control-label" for="store_code">Store Code</label>
               <div class="controls">
                  <input type="text" id="store_code" name="store_code" value="<?php echo set_value('store_code') ?>" />
                  <span for="name" class="help-inline store_code"> <?php echo form_error('store_code') ?> </span>
               </div>
            </div>


            <div class="control-group <?php if(isset($error) && !empty($error)) echo $error; ?>">
               <label class="control-label" for="store_logo">Store Logo</label>
               <div class="controls">
                  <input type="file" id="store_logo" name="store_logo" value="<?php echo set_value('store_logo') ?>" />
               </div>
               <span for="name" class="help-inline sp">
                  (e.q. gif, jpg, png, jpeg)
                  <?php if(isset($error) && !empty($error))
                     echo $error;
                     ?>
                </span>
            </div>
            <div class="control-group <?php if(form_error('store_country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="store_country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
                  <span for="country" class="help-inline countryId"> <?php echo form_error('store_country') ?> </span>
                  
                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCountry" target="_blank">Other Country</a>
                  
               </div>
            </div>
            <div class="control-group <?php if(form_error('store_state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="store_state" class="states" id="stateId">
                     <option value="">Select State</option>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value=""/>
                  <span for="state" class="help-inline stateId"><?php echo form_error('store_state') ?></span>
                 
                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherState" target="_blank">Other State</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('store_city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <select name="store_city" class="cities" id="cityId">
                     <option value="">Select City</option>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value=""/>
                  <span for="city" class="help-inline cityId"> <?php echo form_error('store_city') ?> </span>
                 
                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCity" target="_blank">Other City</a>

               </div>
            </div>
			<div class="control-group <?php if(form_error('location') != '') echo 'error'; ?>">
               <label class="control-label" for="location">Assign Location</label>
               <div class="controls">
                  <select name="location" class="role" id="location">
                     <option value="">Select Location</option>
                  </select>
                  <span for="country" class="help-inline location"> <?php echo form_error('location') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor store_btn" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add
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
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script type="text/javascript" language="javascript">
   $(function() {
         $("#countryId").change(function(){
         var countryid= $('#countryId :selected').val();
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('#stateId :selected').val();
         $('#stateid_hidden').val(stateid);
      });
      
      $("#cityId").change(function(){
         var cityid= $('#cityId :selected').val();
       $('#cityid_hidden').val(cityid);
       
      
		 
		 var country_val = $('#countryid_hidden').val();
		 var state_val = $('#stateid_hidden').val();
		 var city_val = $('#cityid_hidden').val();
		 
		 var url="<?php echo site_url();?>webadmin/managestore/getLocationByCity";
			
				$.ajax({
				url: url,
				type:'POST',
				data:"country_val="+country_val+"&state_val="+state_val+"&city_val="+city_val,
				success: function(data){
					$('#location').html(data); 
				}
				});
      });


      $('.store_btn').on('click', function() {
         var error_count = 0;    

         var store_name =  $('#store_name').val(); 
         if(store_name=="") {
            $(".store_name").text("The Store Name field is required.");
            error_count++;
         } else {
            $(".store_name").empty();
         }


         var countryId =  $('#countryId').val(); 
         if(countryId=="") {
            $(".countryId").text("The Country field is required.");
            error_count++;
         } else {
            $(".countryId").empty();
         }


         var stateId =  $('#stateId').val(); 
         if(stateId=="") {
            $(".stateId").text("The State field is required.");
         } else {
            $(".stateId").empty();
         }


         var cityId =  $('#cityId').val(); 
         if(cityId=="") {
            $(".cityId").text("The City field is required.");
         } else {
            $(".cityId").empty();
         }


         var location =  $('#location').val(); 
         if(location=="") {
            $(".location").text("The Assign Location field is required.");
         } else {
            $(".location").empty();
         }

   
         var store_code =  $('#store_code').val(); 
         if(store_code=="") {
            $(".store_code").text("Please Enter Store Code.");
            error_count++;
         } else if(store_code!='') {

            var url="<?php echo base_url();?>webadmin/managestore/checkStoreCode";
               $.ajax({
                  type: 'post',
                  url: url, 
                  async:false,
                  data: {'code':store_code},
                  success:function (result) {
                     if(result == 1) {
                       $(".store_code").text("Store Code Already Exits.");
                       $(".store_code").css('color','red');
                       error_count++;
                     }
                  }
               });


         } else {
              $(".store_code").empty();
         }





         if(error_count>0) 
         {  
            return false;  
         }

      });

   });
</script>
</body>
</html>