<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Tax</h1>
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
               <div class="table-header tableThemeColor">
                  Results for "Tax"
               </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Country</th>
                        <th>State</th>
                        <!--<th>City</th>
                        <th>Zipcode</th>-->
                        <th>Tax Name</th>
                        <th>Rate(%)</th>
                        <th>Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                         $ctr=1;
                        if(isset($tax) && !empty($tax)){
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],10);
                       
						      foreach($tax as $tax){
                      //  if($uinfo['user_level']<$tax->user_level || $uinfo['user_level']==1) {
						?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo getCountryName($tax->country_id);?></td>
                        <td><?php echo getStateName($tax->state_id);?></td>
                        <!--<td><?php //echo getCityName($tax->city_id);?></td>
                        <td><?php echo $tax->zipcode;?></td>-->
                        <td><?php echo $tax->tax_name;?></td>
                        <td><?php echo $tax->rate;?></td>
                        <?php if($permission_array[0]['edit']=='1') { ?>
						<td>
                           <label>
                           <input id="status_switch_<?php echo $tax->tax_id;?>" name="status_switch_<?php echo $tax->tax_id;?>" class="ace-switch ace-switch-3" type="checkbox" <?php if($tax->tax_status==1){echo "checked=checked";} ?> />
                           <span class="lbl"></span>												</label>
                           <?php if($tax->tax_status==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($tax->tax_status==0){echo '<span style=" visibility:hidden">off</span>';} ?>
                        </td> 
						<?php } else{echo "<td>Access Denied</td>";}?>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/managetax/editTax/".$tax->tax_id;?>" class="tooltip-info" data-rel="tooltip" title="Edit">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														
                              </button>
                              </a>
                              <?php }?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <a id="delBtn_<?php echo $tax->tax_id;?>" href="<?php echo site_url()."webadmin/managetax/deleteTax/".$tax->tax_id;?>" class="tooltip-info delBtn" data-rel="tooltip" title="Delete">	
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
                     <?php //} 
                     $ctr++; } }?>
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
   			//alert($(this).attr('id').split('status_switch_'));
   			ch=$(this).attr('id').split('status_switch_');
   			var url="<?php echo site_url();?>webadmin/managetax/changeTaxStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"status="+change_status_to+"&acc_id="+ch[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		});
   	<!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null, null, null,null,
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