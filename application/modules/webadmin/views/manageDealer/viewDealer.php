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
                  if(isset($dealers) && !empty($dealers)){
                   ?>
               <div class="table-header tableThemeColor"> Results for "Registered Dealers" </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>Username</th>
                        <th>Password</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Zipcode</th>
                        <th>Contact Number</th>
                        <th>Firm Name</th>
						<th>Tin Number</th>
						<!--<th>Account Number</th>
						<th>IFSC Code</th>
						<th>Account Name</th>
						<th>Bank Name</th>-->
						<th>Bank Details</th>
                        <th>Dealer Status</th>
                        <th>Action</th>
						<th>Password Setting</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],18);
                        foreach($dealers as $dealer){
                       // print_r($dealer);
						?>
                     <?php //if($uinfo['user_level']<$dealer->user_level) {
					 //if($dealer->user_role!=5 || $uinfo['user_level']==1){
					 ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $dealer->f_name." ".$dealer->l_name." ";?></td>
                        <td><?php echo $dealer->email;?></td>
                        <td><?php echo $dealer->username;?></td>
                        <td><?php echo $dealer->cpassword;?></td>
                        <td><?php echo $dealer->city;?></td>
                        <td><?php echo $dealer->address; ?></td>
						<td><?php echo $dealer->zipcode; ?></td>
						<td><?php echo $dealer->contact_number; ?></td>
						<td><?php echo $dealer->firm_name; ?></td>
						<td><?php echo $dealer->tin_number; ?></td>
						<!--<td><?php echo $dealer->account_number; ?></td>
						<td><?php echo $dealer->ifsc_code; ?></td>
						<td><?php echo $dealer->account_name; ?></td>
						<td><?php echo $dealer->bank_name; ?></td>-->
						<td><a href="javascript:void(0);" id="id-btn-dialog_<?php echo $dealer->dealer_id;?>" class="btn btn-purple btn-sm dealer_bank_link">Bank Details</a></td>
						<?php $dealer_bank_details = getDealerBankDetailsById($dealer->dealer_id);?>
						<div id="dialog-message_<?php echo $dealer->dealer_id;?>" class="hide">
											<?php foreach($dealer_bank_details as $single){?>
											<p>
												Account Number => <?php echo $single['account_number']; ?>
											</p>

											<p>
												IFSC Code => <?php echo $single['ifsc_code']; ?>
											</p>
											
											<p>
												Account Name => <?php echo $single['account_name']; ?>
											</p>
											
											<p>
												Bank Name => <?php echo $single['bank_name']; ?>
											</p>
											
											<div class="hr hr-12 hr-double"></div>
											<?php }?>
						</div><!-- #dialog-message -->
                        <?php if($permission_array[0]['edit']=='1') { ?>
						<td>    
                           <label>
                           <input id="dealer_status_switch_<?php echo $dealer->dealer_id;?>" name="dealer_status_switch_<?php echo $dealer->dealer_id;?>" class="ace-switch ace-switch-3" type="checkbox" <?php if($dealer->dealer_status==1){echo "checked=checked";} ?> />
                           <span class="lbl"></span>												</label>
                           <?php if($dealer->dealer_status==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($dealer->dealer_status==0){echo '<span style=" visibility:hidden">off</span>';} ?>
                        </td>
						<?php } else{echo "<td>Access Denied</td>";}?>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/managedealer/editDealer/".$dealer->dealer_id;?>" class="tooltip-info" data-rel="tooltip" title="Edit">
                              <button class="btn btn-mini btn-info"> <i class="icon-edit bigger-120"></i> </button>
                              </a>
                              <?php }?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <a id="delBtn_<?php echo $dealer->dealer_id;?>" class="delBtn tooltip-info" href="<?php echo site_url()."webadmin/managedealer/deleteDealer/".$dealer->dealer_id;?>" data-rel="tooltip" title="Delete">
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
                        <?php }else{echo "<td>Access Denied</td>";}?>
						<td> 
							<a href="<?php echo site_url()."webadmin/managedealer/changePassword/".$dealer->dealer_id;?>" class="tooltip-info" data-rel="tooltip" title="Edit">
                              Edit Password</button>
                            </a>
						</td>
                     </tr>
                     <?php //}}?>
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
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
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
   			dealer_id=$(this).attr('id').split('dealer_status_switch_');
   			var url="<?php echo site_url();?>webadmin/managedealer/changeDealerStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"dealer_status="+change_status_to+"&dealer_id="+dealer_id[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		
   		
   		
   		});
   	<!--jQuery Table//Start-->
   
   		var oTable1 = $('#myTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null, null,null, null,null, null,null,null,null, null,null,
   
   
   		  
   
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
<script>
$(document).ready(function(){
$( ".dealer_bank_link").click(function(){
dealer_id=$(this).attr('id').split('id-btn-dialog_');
			
					var dialog = $( "#dialog-message_"+dealer_id[1] ).removeClass('hide').dialog({
						modal: true,
						title: "Bank Details",
						title_html: true,
						buttons: [ 
							{
								text: "Cancel",
								"class" : "btn btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							},
							{
								text: "OK",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			
				});
	
});
</script>

</body>
</html>