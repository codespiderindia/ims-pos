<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Edit User
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
            <input type="hidden" name="hdnApprovedByHr" value="<?php echo $userInfo->approved_by_hr; ?>" />
             <input type="hidden" name="hdnStoreId" value="<?php echo $userInfo->store_id; ?>" />
            <div class="control-group <?php if(form_error('admin_full_name') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Full Name</label>
               <div class="controls">
                  <input type="text" id="admin_full_name" name="admin_full_name" value="<?php if(isset($userInfo->user_full_name) && !empty($userInfo->user_full_name)){echo $userInfo->user_full_name;}?>" />
                  <span for="name" class="help-inline"> 
                     <?php echo form_error('admin_full_name') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('username') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Username</label>
               <div class="controls">
                  <input type="text" id="username" name="username" value="<?php if(isset($userInfo->user_name) && !empty($userInfo->user_name)){echo $userInfo->user_name;}?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('username') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('email') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Email</label>
               <div class="controls">
                  <input type="text" id="email" name="email" value="<?php if(isset($userInfo->user_email) && !empty($userInfo->user_email)){echo $userInfo->user_email;}?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('email') ?> </span>
               </div>
            </div>

            <div class="control-group department_select <?php if(form_error('department') != '') echo 'error'; ?>">
               <label class="control-label" for="department">Select Department</label>
               <div class="controls">
					<?php $arr_course = explode(",",$userInfo->department_id);?>
                  <select name="department[]" class="role" id="department" multiple="multiple">
                     <?php 
                        $department_details = department_details($uinfo['comp_code']);
                        foreach($department_details as $department){
                        ?>
                     <option <?php if(isset($userInfo->department_id) and in_array($department['department_id'],$arr_course)) echo 'selected="selected"'; ?> value="<?php echo $department['department_id'];?>"><?php echo $department['department_name'];?></option>
                     <?php } ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('department') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('location') != '') echo 'error'; ?>">
               <label class="control-label" for="location">Assign Location</label>
               <div class="controls">
                  <select name="location" class="role" id="location">
                     <option value="">Select Location</option>
                     <?php 
                        $location = location($uinfo['comp_code']);
                        
                        foreach($location as $location){ 
                        
                        //if($location['id']==$userInfo->location){
                        
                        ?>
                     <option <?php echo ($location['id']==$userInfo->location) ? "selected" : '' ?> value="<?php echo $location['id'];?>"><?php echo $location['location_name'];?></option>
                     <?php  
                    //    }else{
                        	
                      //  	echo '<option value="'.$location['id'].'">'.$location['location_name'].'</option>';
                        	
                        	//}
                        }
                        ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('location') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('role') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Assign Role</label>
               <div class="controls">
                  <select name="role" class="role" id="role">
                     <option value="">Select Role</option>
                     <?php 
                        $role_details = role_id($uinfo['comp_code']);
                        foreach($role_details as $role){
                        if($uinfo['user_level']<$role['role_code']) {					
                        if($role['role_code'] == $userInfo->user_role)
                        {
                        	 $user_role_name = get_user_role($userInfo->user_role);
                        	 echo "<option selected='selected' value='".$userInfo->user_role."|".$userInfo->user_level."'>".$user_role_name."</option>";
                        }
                        else
                        { 	echo "<option value='".$role['role_code']."|".$role['user_level']."'>".$role['role_name']."</option>";
                        }
                        ?>
                     <?php } 
                        }
                        ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('role') ?> </span>
               </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="role">Store Manager</label>
                <div class="controls">
                  <input type="checkbox" style="opacity:1" name="store_manager" class="store_manager" value="1" <?php if(isset($userInfo->store_manager) && !empty($userInfo->store_manager)){ if($userInfo->store_manager=='1') echo 'checked="checked"'; }?> />
                  <div style="padding-top: 15px;">
                     <span style="font-size: 10px;">Note: "Store Manager" will be the only one in the user for each store.</span>
                  </div>
                </div>
            </div>


             <div class="control-group">
               <label class="control-label" for="role">New Password</label>
               <div class="controls">
                  <input type="password" id="password" name="password" value="" />
                  <span for="name" class="help-inline"> <?php echo form_error('password') ?> </span>
               </div>
            </div>

             <div class="control-group <?php if(form_error('cpassword') != '') echo 'error'; ?>">
               <label class="control-label" for="role">Confirm Password</label>
               <div class="controls">
                  <input type="password" id="cpassword" name="cpassword" value="" />
                  <span for="name" class="help-inline confirmpwd"> <?php echo form_error('cpassword') ?> </span>
               </div>
            </div>



            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor editUser" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update
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
   $('#department').multiselect({
		includeSelectAllOption: true
	});

   $(document).ready(function() {
      $('.editUser').on('click', function() {

         var pwd = $('#password').val();
         if(pwd != '') {
            if($('#cpassword').val() == '') {
               $('.confirmpwd').html('Please Enter Confirm Password!!');
               return false
            }
         }
      });
   });
   
</script>
<!--multiselect scripts related to this page-->
</body>
</html>