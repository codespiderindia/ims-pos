<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>                              
         </button>
         <strong>
         <i class="icon-remove"></i>
         Error!                              
         </strong>
         <?php echo $this->session->flashdata('error_msg'); ?>
         <br />
      </div>
      <?php endif; ?>
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
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            
            <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
                  <span for="country" class="help-inline"> <?php echo form_error('country') ?> </span>
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
               </div>
            </div>
            <div class="control-group <?php if(form_error('city_name') != '') echo 'error'; ?>">
               <label class="control-label" for="city_name">City Name</label>
               <div class="controls">
                  <input type="text" id="city_name" name="city_name" value="<?php echo set_value('city_name') ?>" />
                  <span for="city_name" class="help-inline"><?php echo form_error('city_name') ?></span>
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
       
   });
</script>
</body>
</html>