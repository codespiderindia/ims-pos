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
            <div class="control-group <?php if(form_error('sortname') != '') echo 'error'; ?>">
               <label class="control-label" for="sortname">Country Code</label>
               <div class="controls">
                  <input type="text" id="sortname" name="sortname" value="<?php echo set_value('sortname') ?>" />
                  <span for="sortname" class="help-inline"><?php echo form_error('sortname') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('name') != '') echo 'error'; ?>">
               <label class="control-label" for="name">Country Name</label>
               <div class="controls">
                  <input type="text" id="name" name="name" value="<?php echo set_value('name') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('name') ?> </span>
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
<script src="http://lab.iamrohit.in/js/location.js"></script>
<script type="text/javascript" language="javascript">
   $(function() {
         $("#countryId").change(function(){
         var countryid= $('option:selected', this).attr('countryid');
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('option:selected', this).attr('stateid');
         $('#stateid_hidden').val(stateid);
      });
      
      $("#cityId").change(function(){
         var cityid= $('option:selected', this).attr('cityid');
		 $('#cityid_hidden').val(cityid);
		 
		});
   });
</script>
</body>
</html>