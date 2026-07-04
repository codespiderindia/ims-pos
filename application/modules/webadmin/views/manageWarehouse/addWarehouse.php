<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

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
.phoneNumberClass{
   margin-left: 180px;
}

</style>

   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post">
            <div class="control-group <?php if(form_error('warehouse_name') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_name">WareHouse Name</label>
               <div class="controls">
                  <input type='text' id="warehouse_name" name="warehouse_name" value="<?php echo set_value('warehouse_name'); ?>"/>
                  <span for="warehouse_name" class="help-inline"> <?php echo form_error('warehouse_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_country') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_country">Country</label>
               <div class="controls">
                  <select name="warehouse_country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
                  <span for="warehouse_country" class="help-inline"> <?php echo form_error('warehouse_country') ?> </span>

                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCountry" target="_blank">Other Country</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_state') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_state">State</label>
               <div class="controls">
                  <select name="warehouse_state" class="states" id="stateId">
                     <option value="">Select State</option>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value=""/>
                  <span for="warehouse_state" class="help-inline"> <?php echo form_error('warehouse_state') ?> </span>

                   <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherState" target="_blank">Other State</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_city') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_city">City</label>
               <div class="controls">
                  <select name="warehouse_city" class="cities" id="cityId">
                     <option value="">Select City</option>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value=""/>
                  <span for="warehouse_city" class="help-inline"> <?php echo form_error('warehouse_city') ?> </span>

                  <a class="btn btn-info buttonThemeColor" href="<?php echo site_url();?>webadmin/managelocations/otherCity" target="_blank">Other City</a>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_zipcode">Zipcode</label>
               <div class="controls">
                  <input type="text" id="warehouse_zipcode" name="warehouse_zipcode" value="<?php echo set_value('warehouse_zipcode'); ?>" />
                  <span for="warehouse_zipcode" class="help-inline"><?php echo form_error('warehouse_zipcode') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_phone') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_phone">WareHouse Phone</label>
               <div class="controls">
                  <input type='text' id="warehouse_phone" name="warehouse_phone" value="<?php echo set_value('warehouse_phone'); ?>"/>
                  <span for="warehouse_phone" class="help-inline"> <?php echo form_error('warehouse_phone') ?> </span>
                  
               </div>
               <div class="phoneNumberClass">   
                     <span style="font-size: 10px;">Valid formats: (123) 456-7890 , 123-456-7890 , 123.456.7890 , 1234567890 , +31636363634 , 075-63546725</span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_address') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_address">Address</label>
               <div class="controls">
                  <textarea id="warehouse_address" name="warehouse_address"><?php echo set_value('warehouse_address'); ?></textarea>
                  <span for="warehouse_address" class="help-inline"> <?php echo form_error('warehouse_address') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('is_central') != '') echo 'error'; ?>">
               <label class="control-label" for="is_central">Is Central</label>
               <div class="controls">
                  <input type="checkbox" id="is_central" name="is_central" value="1" style="opacity:1;">
                  <span for="is_central" class="help-inline"> <?php echo form_error('is_central') ?> </span>
				  	
                     <span style="font-size: 10px; padding-left: 20px;">Note: "Central" will be the only one in the warehouse</span>
                  
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add WareHouse
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