<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
#myTable.table.table-hover.dataTable.table-striped.table-bordered {
    display: table !important;
    overflow-x: scroll;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <?php
         if ($this->session->flashdata('error_msg')):
         ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php
            echo $this->session->flashdata('error_msg');
            ?> <br />
      </div>
      <?php endif; ?>
      <?php
         if ($this->session->flashdata('success_msg')):
         ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php
            echo $this->session->flashdata('success_msg');
            ?> </p>
      </div>
      <?php
         endif;
         ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
              
               <div class="table-header tableThemeColor"> Results for Product Category</div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Category Name</th>
						      <th>Create Date</th>
                        <th>Modify Date</th>
                        <th>Status</th>
						      <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                      $ctr = 1;
                   if (isset($product_category) && !empty($product_category)) {
                        foreach ($product_category as $product_category) { 
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr; ?></td>
                        <td><?php echo $product_category->cat_name; ?></td>   
                        <td><?php
                                 $date_created = $product_category->create_date;
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                              ?>
                        </td>
                        <td><?php
                                 $date_created = $product_category->modify_date;
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-M-Y h:i:s");
                              ?>
                        </td>
                        <?php
                           $permission_array = checkPermissionByUserRole($uinfo['user_role'], 15);
                           ?>
                        <?php
                           if ($permission_array[0]['edit'] == '1') {
                           ?>
                        
						<td><label>
                           <input id="product_cat_status_switch_<?php
                              echo $product_category->product_cat_id;
                              ?>" name="product_cat_status_switch_<?php
							  echo $product_category->cat_status;
                              ?>" class="ace-switch  ace-switch-3" type="checkbox" <?php
                              if ($product_category->cat_status == 1) {
                                  echo "checked=checked";
                              }
                              ?> />
                           <span class="lbl"></span> </label>
                           <?php
                              if ($product_category->cat_status == 1) {
                                  echo '<span style=" visibility:hidden">on</span>';
                              }
                              ?>
                           <?php
                              if ($product_category->cat_status == 0) {
                                  echo '<span style=" visibility:hidden">off</span>';
                              }
                              ?>
                        </td>
                        <?php
                           } else {
                               echo "<td>Access Denied</td>";
                           }
                           ?>
                        <?php
                           if ($permission_array[0]['edit'] == '1' || $permission_array[0]['delete'] == '1') {
                           ?>
                        <td>
                           <div class="hidden-phone visible-desktop btn-group">
                              <?php
                                 if ($permission_array[0]['edit'] == '1') {
                                 ?>
                              <a href="<?php
                                 echo site_url() . "webadmin/manageproductcategory/editProductCategory/" . $product_category->product_cat_id;
                                 ?>" class="tooltip-info" data-rel="tooltip" title="Edit">
                              <button class="btn btn-mini btn-info"> <i class="icon-edit bigger-120"></i> </button>
                              </a>
                              <?php
                                 }
                                 ?>
                              <?php
                                 if ($permission_array[0]['delete'] == '1') {
                                 ?>
                              <a id="delBtn_<?php
                                 echo $product_category->product_cat_id;
                                 ?>" class="delBtn tooltip-info" href="<?php
                                 echo site_url() . "webadmin/manageproductcategory/deleteProductCategory/" . $product_category->product_cat_id;
                                 ?>" data-rel="tooltip" title="Delete">
                              <button class="btn btn-mini btn-danger"> <i class="icon-trash bigger-120"></i></button>
                              </a>
                              <?php
                                 }
                                 ?>
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
                        <?php
                           } else {
                               echo "<td>Access Denied</td>";
                           }
                           ?>
                     </tr>
                     <?php
                        $ctr++;
                        } }
                        ?>
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
   			product_cat_id=$(this).attr('id').split('product_cat_status_switch_');
   			var url="<?php
      echo site_url();?>webadmin/manageproductcategory/changeProductCategoryStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"cat_status="+change_status_to+"&product_cat_id="+product_cat_id[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   			
   		});
   		
   	<!--jQuery Table//Start-->
   
   		var oTable1 = $('#myTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null,null,
   
   		  
   
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