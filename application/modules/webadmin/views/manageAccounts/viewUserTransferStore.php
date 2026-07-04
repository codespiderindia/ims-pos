<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>
<style type="text/css">
   .success_msguser_store {
      display: none;
   }
</style>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>

      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>

       <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />
      </div>
      <?php endif; ?>


      <div class="alert alert-block alert-success success_msguser_store">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <span class="msg_p"></span> </p>
      </div>
      
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php //echo '<pre>'; print_r($userInfo); ?>
               <div class="table-header tableThemeColor"> Results for "Store Transer" </div>
               <table id="myTable" class="table table-striped table-bordered">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>User Full Name</th>
                        <th>Store From</th>
                        <th>Store To</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $ctr=1;
                        if(isset($userInfo) && !empty($userInfo)){
                   
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],5);
                        foreach($userInfo as $userInfos){
                           $store_from = get_store_details_by_id($userInfos->store_from); 
                           $store_to = get_store_details_by_id($userInfos->store_to); 
                           if(!empty($store_to)) {
                        ?>
                        <tr>
                           <td><?php echo $ctr; ?></td>
                           <td><?php $userName = get_user_name_by_user_ID($userInfos->user_id);
                                 echo $userName; ?></td>
                           <td><?php echo (isset($store_from[0]['store_name']) ? $store_from[0]['store_name'] : '-'); ?></td>
                           <td><?php echo $store_to[0]['store_name']; ?></td>
                           <td><input type="checkbox" style="opacity:1" name="hr_approval" class="hr_approval" transfer_id="<?php echo $userInfos->id; ?>" attr_hr_id="<?php echo $uinfo['user_ID']; ?>" user_id="<?php echo $userInfos->user_id; ?>" /></td>
                        </tr>
                     <?php  } $ctr++; } }?>
                  </tbody>
               </table>
            </div>
            <!--/span-->
         </div>
         <!--/row-->
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
   		 $('#myTable').dataTable();

         $('.hr_approval').click(function() {
            var url="<?php echo site_url();?>webadmin/manageaccounts/updateHrTransferStatus";
            var status;
            var hrId = $(this).attr('attr_hr_id');
            var transferId = $(this).attr('transfer_id');
            var userId = $(this).attr('user_id');
            if ($(this).is(":checked")) {
               var status = 1;
            } else {
               var status = 0;
            }
            $.ajax({
               url: url,
               type:'GET',
               data: {
                  'hrId':hrId,
                  'transferId':transferId,
                  'userId':userId,
                  'status':status
               },
               success: function(data){
                  $('.msg_p').html('Successfully Transfer Store !!');
                  $('.success_msguser_store').css('display','block').fadeOut(4000, function() {
                     location.reload();
                  });
               }
            })
         });
   });
</script>
</body>
</html>