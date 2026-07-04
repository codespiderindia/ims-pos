<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<?php  $a = FALSE; $b = TRUE; ?>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
        
		 Add User
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
<style type="text/css">
   .phoneNumberClass {
  padding-left: 22px;
}
.cut_form_fok_sp .controls {
  display: inline-block;
  margin-left: 16px;
}
.cut_form_fok_sp .control-label {
  display: inline-block;
  float: none;
  vertical-align: middle;
}
</style>


   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('admin_full_name') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Full Name</label>
               <div class="controls">
                  <input type="text" id="admin_full_name" name="admin_full_name" value="<?php echo set_value('admin_full_name') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('admin_full_name') ?> </span>
               </div>
            </div>
            
            <div class="control-group <?php if(form_error('email') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Email</label>
               <div class="controls">
               <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('email') ?> </span>
               </div>
            </div>
            
            <div class="control-group <?php if(form_error('username') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Username</label>
               <div class="controls">
                  <input type="text" id="username" name="username" value="<?php echo set_value('username') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('username') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('password') != '') echo 'error'; ?>">
               <label class="control-label" for="user_password">Password</label>
               <div class="controls">
                  <input type="password" id="password" name="password" value="<?php echo set_value('password') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('password') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('cpassword') != '') echo 'error'; ?>">
               <label class="control-label" for="cpassword">Confirm Password</label>
               <div class="controls">
                  <input type="password" id="cpassword" name="cpassword" value="<?php echo set_value('cpassword') ?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('cpassword') ?> </span>
               </div>
            </div>
			
            <div class="control-group department_select <?php if(form_error('department') != '') echo 'error'; ?>">
               <label class="control-label" for="department">Select Department</label>
               <div class="controls">
                  <select name="department[]" class="role" id="department" multiple="multiple">
                     
                     <?php 
                        $department_details = department_details($uinfo['comp_code']);
                        foreach($department_details as $department){  
                        ?>
                      <option value="<?php echo $department['department_id'];?>"><?php echo $department['department_name'];?></option>
                     <?php
                        }
                        ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('department') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('location') != '') echo 'error'; ?>">
               <label class="control-label" for="location">
               Assign Location
               </label>		
               <div class="controls">
                  <select name="location" class="role" id="location">
                     <option value="">Select Location</option>
                     <?php $location = location($uinfo['comp_code']);				
                        foreach($location as $location){ ?>	
                     <option value="<?php echo $location['id']; ?>" <?php echo set_select('location',  $location['id']); ?>><?php echo $location['location_name']; ?></option>			
                     <!-- <option value="<?php// echo $location['id'];?>"><?php //echo $location['location_name'];?></option> -->
                     <?php }	?>			
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('location') ?></span>
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
                        
                        if($uinfo['user_level']<=$role['user_level']) {
                        ?>
                     <option value="<?php echo $role['role_code']."|".$role['user_level']; ?>" <?php echo set_select('role',  $role['role_code']."|".$role['user_level']); ?>><?php echo $role['role_name']; ?></option>   
                     <!-- <option value="<?php// echo $role['role_code']."|".$role['user_level'];?>"><?php// echo $role['role_name'];?></option> -->
                     <?php } 
                        }
                        ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('role') ?> </span>
               </div>
            </div>

             <div class="control-group cut_form_fok_sp">
                <label class="control-label" for="role">Store Manager</label>
                <div class="controls">
                  <input type="checkbox" style="opacity:1" name="store_manager" class="store_manager" value="1" />
                  <div class="phoneNumberClass">
                     <span style="font-size: 10px;">Note: "Store Manager" will be the only one in the user for each store.</span>
                  </div>
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
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#department').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
</body>
</html>
