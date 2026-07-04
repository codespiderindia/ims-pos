<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
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
      <?php if($this->session->flashdata('success_mail')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_mail'); ?> </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('error_mail')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_mail'); ?> </p>
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
                  if(isset($user_accounts) && !empty($user_accounts)){
                   ?>
               <div class="table-header tableThemeColor"> Results for "Add Users For Warehouse" </div>
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
                        <th>Users Created</th>
						<th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],5);
                        foreach($user_accounts as $account){
                        ?>
                     <?php if($uinfo['user_level']<$account->user_level) {
					 if($account->user_role!=5 || $uinfo['user_level']==1){
					 ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $account->user_full_name;?></td>
                        <td><?php echo $account->user_email;?></td>
                        <td><?php echo $account->user_name;?></td>
                        <td><?php echo role_name($account->user_role) ;;?></td>
                        <td><?php echo get_location_by_id($account->location); ?></td>
                        <td>
                           <?php 
						    $deparment_id = explode(',',$account->department_id);
						    $count_department_id = count($deparment_id);
							for($i=0;$i<$count_department_id;$i++){
                              $department_details = get_department_details_by_id($deparment_id[$i]);
                              foreach($department_details as $department)
                              {
                              	$department_name = $department['department_name'].' ,';
								echo $department_name;
                              }
							  
							}?>
                        </td>
                        
                        <td><?php echo $account->user_created;?></td>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        
						<?php if($account->warehouse_id==0){?>
						<td><a href="<?php echo site_url()."webadmin/manageaccounts/addUsersForWarehouse/".$account->user_ID; ?>">Add Users For Warehouse</a></td>
						<?php }else{?>
						<td><?php 
							echo "Warehouse Name => ".getWarehouseName($account->warehouse_id);
						?></td>
						<?php }?> 
						
						
                        <?php } ?>
                     </tr>
                     <?php }}?>
                     <?php $ctr++; }?>
                  </tbody>
               </table>
               <?php
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