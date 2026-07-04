<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading; ?></h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										
         </button>
         <strong>
         <i class="icon-remove"></i>
         Error!										
         </strong>
         <?php echo $this->session->flashdata('error_msg'); ?>
         <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert">
         <i class="icon-remove"></i>										
         </button>
         <p>
            <strong>
            <i class="icon-ok"></i>
            Done!											
            </strong>
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
				  
				  //print_r($wareHouseAllRecords);
                  if(isset($wareHouseAllRecords) && !empty($wareHouseAllRecords)){
                  ?>
               <div class="table-header tableThemeColor">Results for "WareHouse"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>User Name</th>
                        <th>WareHouse Name</th>
                        <th>Country</th>
                        <th>State</th>
                        <th>City</th>
                        <th>Zipcode</th>
                        <th>WareHouse Phone</th>
                        <th>WareHouse Address</th>
						<th>Is Central</th>
                        <th>Create Date</th>
                        <th>Modified Date</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],13);
						foreach($wareHouseAllRecords as $warehouse){
                       // if($uinfo['user_level']<$warehouse->user_level || $uinfo['user_level']==1) {
						
						?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo get_user_name_by_user_ID($warehouse->user_ID); ?></td>
                        <td><?php echo $warehouse->warehouse_name;?></td>
                        <td><?php echo getCountryName($warehouse->warehouse_country);?></td>
                        <td><?php echo getStateName($warehouse->warehouse_state);?></td>
                        <td><?php echo getCityName($warehouse->warehouse_city);?></td>
                        <td><?php echo $warehouse->warehouse_zipcode;?></td>
                        <td><?php echo $warehouse->warehouse_phone;?></td>
                        <td><?php echo $warehouse->warehouse_address;?></td>
						<td><?php $is_central = $warehouse->is_central;
								  echo ($is_central=='1') ? 'Yes' : 'No';
							?>
						</td>
                        <td><?php 
                                 $date_created = $warehouse->create_date; 
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                           ?>
                        </td>
                        <td><?php 
                                 $date_created = $warehouse->modified_date; 
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                        ?>
                        </td>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/managewarehouse/editWarehouse/".$warehouse->warehouse_id;?>" class="tooltip-info" data-rel="tooltip" title="Edit">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														
                              </button>
                              </a>
                              <?php }?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <a id="delBtn_<?php echo $warehouse->warehouse_id;?>" href="<?php echo site_url()."webadmin/managewarehouse/deleteWarehouse/".$warehouse->warehouse_id;?>" class="tooltip-info delBtn" data-rel="tooltip" title="Delete">	
                              <button class="btn btn-mini btn-danger">
                              <i class="icon-trash bigger-120"></i></button>
                              </a>
                              <?php }?>
                           </div>
                           <div class="hidden-desktop visible-phone">
                              <div class="inline position-relative">
                                 <button class="btn btn-minier btn-primary dropdown-toggle" data-toggle="dropdown">
                                 <i class="icon-cog icon-only bigger-110"></i>															</button>
                                 <ul class="dropdown-menu dropdown-icon-only dropdown-yellow pull-right dropdown-caret dropdown-close">
                                    <li>
                                       <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                       <span class="blue">
                                       <i class="icon-zoom-in bigger-120"></i>
                                       </span>
                                       </a>																
                                    </li>
                                    <li>
                                       <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                       <span class="green">
                                       <i class="icon-edit bigger-120"></i>	
                                       </span>
                                       </a>																
                                    </li>
                                    <li>
                                       <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                       <span class="red">
                                       <i class="icon-trash bigger-120"></i>
                                       </span>	
                                       </a>
                                    </li>
                                 </ul>
                              </div>
                           </div>
                        </td>
                        <?php }else{ echo "<td>Access Denied</td>"; } ?>
                     </tr>
                     <?php //} 
                     $ctr++; }?>
                  </tbody>
               </table>
               <?php
                  }else{ 
                  echo '<div class="table-header">No Record Founds..!!!</div>';
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
   		
   	    <!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null, null, null,null,null,null, null,null,null,
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