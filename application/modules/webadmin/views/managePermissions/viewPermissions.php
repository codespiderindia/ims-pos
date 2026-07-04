<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										</button>
         <strong>
         <i class="icon-remove"></i>
         Error!										</strong>
         <?php echo $this->session->flashdata('error_msg'); ?>
         <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										</button>
         <p>
            <strong>
            <i class="icon-ok"></i>
            Done!											</strong>
            <?php echo $this->session->flashdata('success_msg'); ?>										
         </p>
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
				  $id=1;
                 // if(isset($permissions) && !empty($permissions)){
                  ?>
               <div class="table-header tableThemeColor">
                  Results for "Permissions"
               </div>
               <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Role Name</th>
                        <th>Module Name</th>
                        <th>Create</th>
                        <th>Edit</th>
                        <th>Delete</th>
                        <th>View</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        $uinfo =$this->session->userdata('webadmin_session_info');
                         if(!empty($permissions)) {
                        foreach($permissions as $permissions){
                           $permission_array = checkPermissionByUserRole($uinfo['user_role'],$permissions->modulecode);
                          /* if($permissions->create==1 || $permissions->edit==1 || $permissions->delete==1 || $permissions->view==1) {
                              $icon = "<img src='".base_url()."/assets/img/tick.png' />";
                           } else {
                              $icon = "<img src='".base_url()."/assets/img/cross.png' />";
                           }*/
						      ?>
                     <?php if($uinfo['user_level']<$permissions->rolecode) { ?>
                     <tr>
                        <td class="center_<?php echo $id; ?>"><?php echo $id;?></td>
                        <td><?php echo role_name($permissions->rolecode) ;?></td>
                        <td><?php echo get_modulename($permissions->modulecode) ;?></td>
                        <td>
                           <?php
                            if($permissions->create==1)
                              echo "<img src='".base_url()."assets/img/tick.png' />";
                              else 
                              echo "<img src='".base_url()."assets/img/cross.png' />";?>
                        </td>
                        <td>
                           <?php if($permissions->edit==1)
                              echo "<img src='".base_url()."assets/img/tick.png' />";
                              else echo "<img src='".base_url()."assets/img/cross.png' />";?>
                        </td>
                        <td>
                           <?php if($permissions->delete==1)
                              echo "<img src='".base_url()."assets/img/tick.png' />";
                              else echo "<img src='".base_url()."assets/img/cross.png' />";?>
                        </td>
                        <td>
                           <?php if($permissions->view==1)
                              echo "<img src='".base_url()."assets/img/tick.png' />";
                              else echo "<img src='".base_url()."assets/img/cross.png' />";?>
                        </td>
                        <?php //if($permission_array[0]['edit']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <a href="<?php echo site_url()."webadmin/managepermissions/editPermissions/".$permissions->rolecode."/".$permissions->modulecode;?>" class="tooltip-info" data-rel="tooltip" title="Edit">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														</button></a>
                           </div>
                        </td>
                     </tr>
                     <?php //}
                        /* else echo "<td><img src='".base_url()."/assets/img/edit-not-validated.png' /></td>";*/
                        } ?>	
                     <?php $id++; } }?>
                  </tbody>
               </table>
               <?php
                 // }	
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
   	<!--jQuery Table//Start-->
   		var oTable1 = $('#dynamic-table').DataTable( {
   		"asSorting": [ "desc"], "aTargets": [ 1 ],
   		bAutoWidth: false,					
   		"aoColumns": [					  
   		{ "bSortable": false },
   		null, null, null, null, null, null,
   		{ "bSortable": false }
   		],				
   		} );
   		
   		
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