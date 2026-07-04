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
         
         <?php 
         $roleId = $userInfo->user_role;
         $roleData = getRoleInfoById($roleId);
          ?>
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('store') != '') echo 'error'; ?>">
               <label class="control-label" for="store">Select Store</label>
               <div class="controls">
                  <select name="store" class="role" id="store">
                     <option value="">Select Store</option>
                     <?php 
                        $store_details = store_details($uinfo['comp_code']);
                      //  echo '<pre>';print_r($store_details);
                        foreach($store_details as $store){ 
                        	if($store['store_id']==$userInfo->store_id){
                        ?>
                     <option selected="selected" value="<?php echo $store['store_id'];?>"><?php echo $store['store_name'];?></option>
                     <?php }else{
                        echo '<option value="'.$store['store_id'].'">'.$store['store_name'].'</option>';
                           }
                        }
                        ?>
                  </select>
               <input type="hidden" name="role_hr_approval" value="<?php echo $roleData->hr_approval_for_special_role; ?>" />
                  <input type="hidden" name="hdnStoreId" value="<?php echo $userInfo->store_id; ?>">
                  <input type="hidden" name="hdnApprovedByHr" value="<?php echo $userInfo->approved_by_hr; ?>"> 
                  <input type="hidden" name="newStoreId" class="newStoreId" id="newStoreId"> 
                  <span for="store" class="help-inline"> <?php echo form_error('store') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit" name="submit">
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
        /* window.setTimeout(function () {
          $(".alert-warning").fadeTo(400, 0).slideUp(500, function () {
              $(this).remove();
          });
         }, 5000);*/

         $('#store').change(function() {
            var storeid = jQuery("#store option:selected").val();
            $('.newStoreId').val(storeid);
         });
      });
   </script>
</html>
