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
	  
	  <a href="<?php echo site_url()."webadmin/manageoffer/addOffer";?>">
	  <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
		<i class="icon-ok bigger-110"></i>
		Add Offer
	  </button>
	  </a>
	  
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
				  $ctr=1;
                  if(isset($getAllOffer) && !empty($getAllOffer)){
                  ?>
               <div class="table-header tableThemeColor">Results for "Offer"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>Offer Name</th>
                        <th>Percentage/Fixed</th>
                        <th>Offer Discount</th>
                        <th>Start Date</th>
                        <th>End Date</th>
      						<th>Description</th>
      						<th>Ip Address</th>
                        <th>Create Date</th>
                        <th>Modified Date</th>
						      <th>Approved By Sub-admin</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                        $permission_array = checkPermissionByUserRole($uinfo['user_role'],17);
                        foreach($getAllOffer as $offer){
                        //if($uinfo['user_level']<$offer->user_level || $uinfo['user_level']==1){
						?>
                     <tr>
                        <td class="center"><?php echo $ctr; ?></td>
                        <td><?php echo $offer->offer_name; ?></td>
                        <td><?php 
							$percentage_or_fixed = $offer->percentage_or_fixed;
							if($percentage_or_fixed==1){echo 'Percentage';} else if($percentage_or_fixed==2){echo 'Fixed';}else{echo 'Free Product';}
						?></td>
                        <td><?php if($offer->offer_discount=="NULL"){echo $offer->free_product;}else{echo $offer->offer_discount;} ?></td>
                        <td><?php if($offer->date_duration_start!="NULL") {
                            echo date('jS F Y',strtotime($offer->date_duration_start));
                         }else{
                           echo date('jS F Y',strtotime($offer->start_date_free_product));}?></td>
                        <td><?php if($offer->date_duration_start!="NULL") { echo date('jS F Y',strtotime($offer->date_duration_end));} else{ echo 'Untill Free Product Stock end.';} ?></td>
						<td><?php echo $offer->offer_description; ?></td>
                        <td><?php echo $offer->ip_address;?></td>
                        <td><?php 
                                 $date_created = $offer->create_date; 
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                              ?>
                        </td>
                        <td><?php 
                                 $date_created = $offer->modified_date; 
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                              ?>
                        </td>
						<?php 
						if($uinfo['user_level']==3 || $uinfo['user_level']==1){
						if($permission_array[0]['edit']=='1') { ?>
						<td>
                           <label>
                           <input id="status_switch_<?php echo $offer->offer_id;?>" name="status_switch_<?php echo $offer->offer_id;?>" class="ace-switch ace-switch-3" type="checkbox" <?php if($offer->approved_by==1){echo "checked=checked";} ?> />
                           <span class="lbl"></span>												</label>
                           <?php if($offer->approved_by==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($offer->approved_by==0){echo '<span style=" visibility:hidden">off</span>';} ?>
                        </td>
						<?php } else{echo "<td>Access Denied</td>";}
						}else{
						?>
						<td><?php if($offer->approved_by==1){echo 'Yes';}else{echo 'No';}?></td>
						<?php }?>
                        <?php if($permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1') { ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <a href="<?php echo site_url()."webadmin/manageoffer/editOffer/".base64_encode($offer->offer_id); ?>" class="tooltip-info" data-rel="tooltip" title="Edit">		
                              <button class="btn btn-mini btn-info">
                              <i class="icon-edit bigger-120"></i>														
                              </button>
                              </a>
                              <?php } ?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <a id="delBtn_<?php echo $offer->offer_id; ?>" href="<?php echo site_url()."webadmin/manageoffer/deleteOffer/".base64_encode($offer->offer_id); ?>" class="tooltip-info delBtn" data-rel="tooltip" title="Delete">	
                              <button class="btn btn-mini btn-danger">
                              <i class="icon-trash bigger-120"></i></button>
                              </a>
                              <?php } ?>
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
		
		
		$( ".ace-switch-3" ).change(function() {
   			var change_status_to=0;
   			if($(this).is(":checked")) {
   			change_status_to=1;	
   			}
   			
   			ch=$(this).attr('id').split('status_switch_');
   			var url="<?php echo site_url();?>webadmin/manageoffer/changeOfferStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"status="+change_status_to+"&id="+ch[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		});
		
   		
   	    <!--jQuery Table//Start-->
   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null, null, null,null, null,null,null,null,
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