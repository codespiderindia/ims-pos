<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); 
?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Role List</h1>
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
                 /* $ctr=1;
                  if(isset($roles) && !empty($roles)){*/
                  ?>
               <div class="table-header tableThemeColor">
                  Results for "Registered Roles"
               </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Role Name</th>
						      <th>Created By</th>
                        <th>Created date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $ctr=1;
                        if(isset($roles) && !empty($roles)){
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],1);
                        foreach($roles as $roles){
                        //print_r($roles);											
                        ?>
                     <?php if($uinfo['user_level']<=$roles->user_level) {?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $roles->role_name;?></td>
                        <td><?php echo $roles->created_by_name;?></td>
                        <td><?php $date_created = $roles->created_date;
                              $date=date_create($date_created);
                              echo date_format($date,"d-M-Y");
                        ?></td>
                        <?php if($permission_array[0]['edit']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <a href="<?php echo site_url()."webadmin/manageroles/editRoles/".$roles->role_code;?>" class="tooltip-info" data-rel="tooltip" title="Edit">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														
                              </button>
                              </a>
							  <a id="delBtn_<?php echo $roles->role_code; ?>" href="<?php echo site_url()."webadmin/manageroles/deleteRoles/".base64_encode($roles->role_code); ?>" class="tooltip-info delBtn" data-rel="tooltip" title="Delete">	
                              <button class="btn btn-mini btn-danger">
                              <i class="icon-trash bigger-120"></i></button>
                              </a>
							  
							  
                           </div>
                           <div class="hidden-desktop visible-phone">
                              <div class="inline position-relative">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                 <i class="icon-cog icon-only bigger-110"></i>															</button>
                                 <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li>
                                       <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                       <span class="blue">
                                       <i class="icon-zoom-in bigger-120"></i>																		</span>																	</a>																
                                    </li>
                                    <li>
                                       <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                       <span class="green">
                                       <i class="icon-edit bigger-120"></i>																		</span>																	</a>																
                                    </li>
                                    <li>
                                       <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                       <span class="red">
                                       <i class="icon-trash bigger-120"></i>																		</span>																	</a>																
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </td>
                        <?php }else{echo "<td>Access Denied</td>";}?>
                     </tr>
                     <?php }?>
                     <?php $ctr++; } } ?>
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
   		$(".delBtn").on(ace.click_event, function() {
   			var del_loc=this.href;
   			bootbox.confirm("Are you sure you want to delete this record?", function(result) {
               var status;
               if(result == true) {
                  status = 1;
               } else {
                  status = 0;
               }

               /* $.ajax({
                  url: url,
                  type:'GET',
                  data:"status="+status+"&acc_id="+acc_id[1],
                  success: function(data){
                    
                  }
                });*/
   				/*if(result) {
   					window.location.href=del_loc;
   					//bootbox.alert("You are sure!");
   				}*/
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
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null,
   		  { "bSortable": false }
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