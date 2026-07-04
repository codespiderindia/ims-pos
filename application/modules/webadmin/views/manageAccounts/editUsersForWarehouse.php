<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

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
   <?php 
      $roleId = $userInfo->user_role;
      $roleData = getRoleInfoById($roleId);
   ?>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
            <?php if(isset($roleHrApproval)) { ?>
               <div class="alert alert-block alert-warning alert-dismissable fade in">
                 <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong> Error! </strong>
                  <?php if(isset($roleHrApproval)) { echo $roleHrApproval; } ?>
                  <br />
               </div>
            <?php } ?>
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('warehouse') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse">Select Warehouse</label>
               <div class="controls">
                  <select name="warehouse" class="warehouse" id="warehouse">
                     <option value="">Select Warehouse</option>
                     <?php 
                        $warehouse_details = warehouse_details($uinfo['comp_code']);
                        foreach($warehouse_details as $warehouse){ 
                        	if($warehouse['warehouse_id']==$userInfo->warehouse_id){
                        ?>
                     <option selected="selected" value="<?php echo $warehouse['warehouse_id'];?>"><?php echo $warehouse['warehouse_name'];?></option>
                     <?php }else{
                        echo '<option value="'.$warehouse['warehouse_id'].'">'.$warehouse['warehouse_name'].'</option>';
                           }
                        }
                        ?>
                  </select>
                  <input type="hidden" name="role_hr_approval" value="<?php echo $roleData->hr_approval_for_special_role; ?>" />
                  <input type="hidden" name="hdnWarehouseId" value="<?php echo $userInfo->warehouse_id; ?>">
                  <input type="hidden" name="hdnApprovedByHr" value="<?php echo $userInfo->approved_by_hr; ?>"> 
                  <span for="warehouse" class="help-inline"> <?php echo form_error('warehouse') ?> </span>
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
</body>
 <script>
      $(document).ready(function() {
         window.setTimeout(function () {
          $(".alert-warning").fadeTo(400, 0).slideUp(500, function () {
              $(this).remove();
          });
         }, 5000);
      });
   </script>
</html>
