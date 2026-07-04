<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading; ?></h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
                  $ctr=1;
                  //echo '<pre>';
                  //print_r($storeAllRecordsByUser);
                  
                  if(isset($storeAllRecordsByUser) && !empty($storeAllRecordsByUser)){
                   ?>
               <div class="table-header tableThemeColor"> Results for "User Stores" </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>User Role</th>
                        <th>Location</th>
                        <th>Department</th>
                        <th>Store</th>
                        <th>Users Created</th>
                        <th>Account Status</th>
                        <th>HR Approval</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],5);
                        foreach($storeAllRecordsByUser as $account){
                        //print_r($account);
                         ?>
                     <?php if($uinfo['user_level']<=$account->user_role) { ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $account->user_full_name;?></td>
                        <td><?php echo $account->user_email;?></td>
                        <td><?php echo $account->user_name;?></td>
                        <td><?php echo role_name($account->user_role) ;;?></td>
                        <td><?php echo get_location_by_id($account->location); ?></td>
                        <td>
                           <?php 
                              $department_details = get_department_details_by_id($account->department_id);
                              foreach($department_details as $department)
                              {
                              	echo $department['department_name'];
                              }?>
                        </td>
                        <td>
                           <?php 
                              $store_details = get_store_details_by_id($account->store_id);
                              foreach($store_details as $store)
                              {
                              	echo $store['store_name'];
                              }?>
                        </td>
                        <td><?php echo $account->user_created;?></td>
                        <?php if($permission_array[0]['rolecode']!='5'){?>
                        <td><label>

                           <input id="account_status_switch_<?php echo $account->user_ID;?>" name="account_status_switch_<?php echo $account->user_ID;?>" class="ace-switch ace-switch-3" type="checkbox" <?php if($account->user_account_status==1){echo "checked=checked";} ?> />
                           <span class="lbl"></span> </label>
                           <?php if($account->user_account_status==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($account->user_account_status==0){echo '<span style=" visibility:hidden">off</span>';} ?>
                        </td>
                        <?php }else{?>
                        <td><?php if($account->user_account_status==1){echo "YES";}else{echo "NO";}?></td>
                        <?php }?>
                        <?php if($permission_array[0]['rolecode']!='5'){?>
                        <td>
                           <?php if($account->approved_by_hr==1){echo "YES";}else{echo "NO";}?>
                        </td>
                        <?php }else{?>
                        <td><label>
                           <input id="hr_approval_status_switch_<?php echo $account->user_ID;?>" name="hr_approval_status_switch_<?php echo $account->user_ID;?>" class="ace-switch  hr_approval" type="checkbox" <?php if($account->approved_by_hr==1){echo "checked=checked";} ?> />
                           <span class="lbl"></span> </label>
                           <?php if($account->approved_by_hr==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($account->approved_by_hr==0){echo '<span style=" visibility:hidden">off</span>';} ?>
                        </td>
                        <?php }?>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/manageaccounts/editUsers/".$account->user_ID;?>" class="tooltip-info" data-rel="tooltip" title="Edit">
                              <button class="btn btn-mini btn-info"> <i class="icon-edit bigger-120"></i> </button>
                              </a>
                              <?php }?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <a id="delBtn_<?php echo $account->user_ID;?>" class="delBtn tooltip-info" href="<?php echo site_url()."webadmin/manageaccounts/deleteUsers/".$account->user_ID;?>" data-rel="tooltip" title="Delete">
                              <button class="btn btn-mini btn-danger"> <i class="icon-trash bigger-120"></i></button>
                              </a>
                              <?php }?>
                           </div>
                           <div class="hidden-desktop visible-phone">
                              <div class="inline position-relative">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown"> <i class="icon-cog icon-only bigger-110"></i> </button>
                                 <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li> <a href="#" class="tooltip-info" data-rel="tooltip" title="View"> <span class="blue"> <i class="icon-zoom-in bigger-120"></i> </span> </a> </li>
                                    <li> <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit"> <span class="green"> <i class="icon-edit bigger-120"></i> </span> </a> </li>
                                    <li> <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete"> <span class="red"> <i class="icon-trash bigger-120"></i> </span> </a> </li>
                                 </ul>
                              </div>
                           </div>
                        </td>
                        <?php  }else{ echo "<td>Access Denied</td>";} ?>
                     </tr>
                     <?php } ?>
                     <?php $ctr++; }?>
                  </tbody>
               </table>
               <?php
                  }else{
                  	echo '<div class="table-header"> No Results Founds ...!!!</div>';
                  }	
                   ?>
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
   		$(".delBtn").on(ace.click_event, function() {
   			var del_loc=this.href;
   			bootbox.confirm("Are you sure you want to delete this record?", function(result) {
   				if(result) {
   					window.location.href=del_loc;
   					//bootbox.alert("You are sure!");
   				}
   			});
   			
   			return false;
   		});
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
   		
   		$( ".hr_approval" ).change(function() {
   			 if (confirm("Are You Sure to Send Email Notification ?") == true) {
   					var confirm_result = true;
   				} else {
   					var confirm_result = false;
   				}
   			var change_status_to=0;
   			if($(this).is(":checked")) {
   			change_status_to=1;	
   			}
   			acc_id=$(this).attr('id').split('hr_approval_status_switch_');
   			var url="<?php echo site_url();?>webadmin/manageaccounts/changeHrStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"status="+change_status_to+"&acc_id="+acc_id[1]+"&confirm_result="+confirm_result,
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		});
   	<!--jQuery Table//Start-->
   
   		var oTable1 = $('#myTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null, null,null, null,null, null,null,
   
   
   		  
   
   		] } );
   
   		
   
   		
   
   		$('table th input:checkbox').on('click' , function(){
   
   			var that = this;
   
   			$(this).closest('table').find('tr > td:first-child input:checkbox')
   
   			.each(function(){
   
   				this.checked = that.checked;
   
   				$(this).closest('tr').toggleClass('selected');
   
   			});
   
   				
   
   		});
   
   		
   
   		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
   
   		function tooltip_placement(context, source) {
   
   			var $source = $(source);
   
   			var $parent = $source.closest('table')
   
   			var off1 = $parent.offset();
   
   			var w1 = $parent.width();
   
   	
   
   			var off2 = $source.offset();
   
   			var w2 = $source.width();
   
   	
   
   			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
   
   			return 'left';
   
   		}
   
   	<!--jQuery Table//End-->
   
   });
   
   
</script>
</body>
</html>