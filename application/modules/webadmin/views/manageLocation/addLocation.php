<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Add Location
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
<style>
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

</style>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" >
            <div class="control-group <?php if(form_error('location_name') != '') echo 'error'; ?>">
               <label class="control-label" for="location_name">Location Name</label>
               <div class="controls">
                  <input type="text" id="location_name" name="location_name" value="<?php echo set_value('location_name') ?>" />
                  <span for="channel_name" class="help-inline"><?php echo form_error('location_name') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
                  <span for="country" class="help-inline"> <?php echo form_error('country') ?> </span>

                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCountry" target="_blank">Other Country</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="state" class="states" id="stateId">
                     <option value="">Select State</option>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value=""/>
                  <span for="state" class="help-inline"> <?php echo form_error('state') ?> </span>

                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherState" target="_blank">Other State</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <select name="city" class="cities" id="cityId">
                     <option value="">Select City</option>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value=""/>
                  <span for="city" class="help-inline"> <?php echo form_error('city') ?> </span>

                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCity" target="_blank">Other City</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Address</label>
               <div class="controls">
                  <textarea id="address" name="address"><?php echo set_value('address') ?></textarea>
                  <span for="address" class="help-inline"><?php echo form_error('address') ?></span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Submit
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>--> 
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
		 
		});
   });
</script>
</body>
</html>