<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Add Role
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>


   <style type="text/css">
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
            <div class="control-group <?php if(form_error('role_name') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Role Name</label>
               <div class="controls">
                  <input type="text" id="role_name" name="role_name" value="<?php echo set_value('role_name') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('role_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('user_level') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Select Level</label>		
               <div class="controls">
                  <select name="user_level" class="role_code" id="role_code">
                     <option value="">Select Level</option>
                     <?php 	$user_level = user_level();
                        foreach($user_level as $level){ 
                          if($uinfo['user_level']<$level['user_level_id']) {
                        ?>
                     <option value="<?php echo $level['user_level_id']; ?>" <?php echo set_select('user_level',  $level['user_level_id']); ?>><?php echo $level['level_name']; ?></option> 				
                     <?php } 

                        if($uinfo['user_level']==$level['user_level_id'] && $uinfo['user_level'] == 4) { ?>
                           <option value="<?php echo $level['user_level_id']; ?>" <?php echo set_select('user_level',  $level['user_level_id']); ?>><?php echo $level['level_name']; ?></option> 

                        <?php } }  ?>	

                  </select>
                  <span for="name" class="help-inline"> <?php echo form_error('user_level') ?> </span>		
               </div>
            </div>
            <div class="control-group <?php if(form_error('hr_approval') != '') echo 'error'; ?>">
               <label class="control-label" for="hr_approval">Hr Approval</label>
               <div class="controls">
               <input type="checkbox" name="hr_approval" v style="opacity:1" value="1" id="hr_approval" /> 
                 <span class="help-inline" for="hr_approval"> </span>  
              </div>
            </div>
			<!--<div class="control-group ">
               <label for="is_central" class="control-label">HR Approval Require</label>
               <div class="controls">
                  <input type="hidden" style="opacity:1;" value="0" name="hr_approval_require">
				  <input type="checkbox" style="opacity:1;" value="1" name="hr_approval_require" id="hr_approval_require">
                  <span class="help-inline" for="is_central">  </span>
				  <div class="phoneNumberClass">	
                     <span style="font-size: 12px;color:red">Note: If HR Approval Not Require Then Checked This Box.(For Special Role)</span>
                  </div>
               </div>
            </div>-->
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
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
<script>
   $(function(){
   		$( ".ace-switch-3" ).change(function() {
   			var change_status_to=0;
   			if($(this).is(":checked")) {
   			change_status_to=1;	
   			}
   			acc_id=$(this).attr('id').split('account_status_switch_');
   			var url="<?php echo site_url();?>webadmin/manageaccounts/changeStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"status="+change_status_to+"&acc_id="+acc_id[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		});
   
   
   });
   
   
</script>
<!--inline scripts related to this page-->
</body>
</html>