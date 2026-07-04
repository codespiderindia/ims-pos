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


      <a href="<?php echo site_url()."webadmin/managewarehouse/addOpeningStock";?>">
        <button class="btn btn-info buttonThemeColor" type="submit" style="float:right;margin:15px 0 6px;">
         <i class="icon-ok bigger-110"></i>
         Add Stock
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
                  if(isset($openingStocks) && !empty($openingStocks)) {
                  ?>
               <div class="table-header tableThemeColor">Results Of "Opening Stock"</div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <!--<th>Batch Number</th>-->
                        <th>#</th>
                        <th>Product Name</th>
                        <!--<th>Batch Number</th>-->
                        <th>Sku</th>
                        <th>Quantity</th>
                        <th>Warehouse Id</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php foreach($openingStocks as $key => $openingStock) {

                        /*if($openingStock['batch_id'] != 0) {
                           $batchid = $openingStock['batch_id'];
                           $batchNumber = batchNameByBatchId($batchid);
                        } else {
                           $batchNumber = '';
                        }*/
                      ?>
                      <tr>
                        <td><?php echo $key+1; ?></td>
                        <!--<td><?php //echo $openingStock['batch_number']; ?></td>-->
                        <td><?php echo get_product_name_by_ID($openingStock['master_product_id']); ?></td>
                        <!--<td><?php echo $batchNumber; ?></td>-->
                        <td><?php echo $openingStock['sku']; ?></td>
                        <td><?php echo $openingStock['quantity']; ?></td>
                        <td><?php echo $openingStock['warehouse_id']; ?></td>
                      </tr>
                   <?php } ?>
                  </tbody>
               </table>
               <?php } else {
                  echo '<div class="table-header">No Record Founds..!!!</div>';
               } ?>
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
   	      null, null, null, null, 
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