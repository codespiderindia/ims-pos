<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<style type="text/css">
   .form-horizontal.cutm_form_sp .controls {
  display: inline-block;
  margin-left: 17px;

}
.form-horizontal.cutm_form_sp .control-label {
  display: inline-block;
  text-align: right;
  vertical-align: middle;
  width: 160px;
  padding-top: 0;
  float: none;
}   
</style>


<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Add Tax
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
         <form class="form-horizontal cutm_form_sp" action="" method="post" >
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
          
            <div class="control-group <?php if(form_error('tax_name') != '') echo 'error'; ?>">
               <label class="control-label" for="tax_name">Tax Name</label>
               <div class="controls">
                  <input type="text" class="tax_name" id="tax_name" name="tax_name" value="<?php echo set_value('tax_name') ?>" />
                  <span for="tax_name" class="help-inline checkTaxName"><?php echo form_error('tax_name') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('rate') != '') echo 'error'; ?>">
               <label class="control-label" for="location_name">Rate (%)</label>
               <div class="controls">
                  <input type="number" step="any" max="99" id="rate" name="rate" value="<?php echo set_value('rate') ?>" />
                  <span for="rate" class="help-inline"><?php echo form_error('rate') ?></span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Tax
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
         var stateids;
         if($.isNumeric(stateid)){
            stateids = stateid;
         } else {
            stateids = $('#stateId :selected').attr('stateid');
         } 
         $('#stateid_hidden').val(stateids);
      });

      
      $("#cityId").change(function(){
        var cityid = $('#cityId :selected').val();
        var cityids;
        if($.isNumeric(cityid)){
            cityids = cityid;
        } else {
            cityids = $('#cityId :selected').attr('cityid');
        } 
       $('#cityid_hidden').val(cityids);
      });


      /*$('.tax_name').on('keyup', function() {
         var taxname = $(this).val();
         var taxurl = '<?php echo base_url(); ?>webadmin/managetax/getCessTaxName';

        $.ajax({
            type:'GET',
            url:taxurl,
            data:'taxname='+taxname,
            success:function(res) {
               if(res==0) {
                  $('.checkTaxName').html('Tax Name Already Exits.');
               }
            }
         })
      });*/

   });
</script>
</body>
</html>