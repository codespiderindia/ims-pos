<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Edit Department
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
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('department_name') != '') echo 'error'; ?>">
               <label class="control-label" for="department">Department Name</label>
               <div class="controls">
                  <input type="text" id="department_name" name="department_name" value="<?php if(isset($departmentInfo->department_name) && !empty($departmentInfo->department_name)){echo $departmentInfo->department_name;}?>" />
                  <input type="hidden" id="hidden_department_name" name="hidden_department_name" value="<?php echo $departmentInfo->department_name;?>" />
                  <span for="department_name" class="help-inline"> <?php echo form_error('department_name') ?> </span>
               </div>
            </div>
            <div class="control-group weekly_of_checkbox <?php if(form_error('weekly_off') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Weekly Off</label>
               <?php 
                  $arr_course=explode(",",$departmentInfo->weekly_off);
                  ?>
               <div class="controls">
                  <select name="weekly_off[]" class="role" id="weekly_off" multiple="multiple">
                     
                     <!--<option value="none" <?php //if(isset($departmentInfo->weekly_off) and in_array("none",$arr_course)) echo "selected='selected'";?>>Not Off</option>-->
                     <option value="sunday" <?php if(isset($departmentInfo->weekly_off) and in_array("sunday",$arr_course)) echo "selected='selected'";?>>Sunday</option>
                     <option value="monday" <?php if(isset($departmentInfo->weekly_off) and in_array("monday",$arr_course)) echo "selected='selected'";?>>Monday</option>
                     <option value="tuesday" <?php if(isset($departmentInfo->weekly_off) and in_array("tuesday",$arr_course)) echo "selected='selected'";?>>Tuesday</option>
                     <option value="wednesday" <?php if(isset($departmentInfo->weekly_off) and in_array("wednesday",$arr_course)) echo "selected='selected'";?>>Wednesday</option>
                     <option value="thrusday" <?php if(isset($departmentInfo->weekly_off) and in_array("thrusday",$arr_course)) echo "selected='selected'";?>>Thrusday</option>
                     <option value="friday" <?php if(isset($departmentInfo->weekly_off) and in_array("friday",$arr_course)) echo "selected='selected'";?>>Friday</option>
                     <option value="saturday" <?php if(isset($departmentInfo->weekly_off) and in_array("saturday",$arr_course)) echo "selected='selected'";?>>Saturday</option>
                     <option value="2 saturday" <?php if(isset($departmentInfo->weekly_off) and in_array("2 saturday",$arr_course)) echo "selected='selected'";?>>2 Saturday</option>
                     <option value="2/4 saturday" <?php if(isset($departmentInfo->weekly_off) and in_array("2/4 saturday",$arr_course)) echo "selected='selected'";?>>2/4 Saturday</option>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('weekly_off') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update Department
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
   $(function () {
   	$('#weekly_off').multiselect({
   		includeSelectAllOption: true
   	});
   });
</script>
<!--multiselect scripts related to this page-->
</body>
</html>