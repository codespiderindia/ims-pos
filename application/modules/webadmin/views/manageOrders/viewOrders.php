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
   
   <div class="view_order_sp"> <form action="" >
   Order Created in last <select name="days" id="days">
   <option value="0">Days</option>
   <option value="7" <?php if(isset($_GET['days'])) { if($_GET['days']=='7') { echo "selected='selected'"; } } ?>>7Days</option>
   <option value="30" <?php if(isset($_GET['days'])) { if($_GET['days']=='30') { echo "selected='selected'"; } } ?>>30Days</option>
   <option value="60" <?php if(isset($_GET['days'])) { if($_GET['days']=='60') { echo "selected='selected'"; } } ?>>60Days</option>
   <option value="90" <?php if(isset($_GET['days'])) { if($_GET['days']=='90') { echo "selected='selected'"; } } ?>>90Days</option>
   </select> <input type="submit" value="Go" style="margin-bottom: 10px;"/>
   </form>
   <form action="" >
   Order Between <input type="text" name="start_date" <?php if(isset($_GET['start_date'])) { ?> value="<?php echo $_GET['start_date']; ?>" <?php  } ?> id="start_date"/>  and <input type="text" name="end_date" id="end_date" <?php if(isset($_GET['end_date'])) { ?> value="<?php echo $_GET['end_date']; ?>" <?php  } ?>/>
   </select> <input type="submit" class="goByDate" value="Go" style="margin-bottom: 10px;" />
   </form>
     </div>
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <?php
                  $ctr=1;
                  if(isset($orders) && !empty($orders)){ 
                   ?>
               <div class="table-header tableThemeColor"> Results for "Registered Orders" </div>
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Order Id</th>
                        <th>Dealer Name</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Add Shipment</th>
                        <th>View Shipment</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                  foreach($orders as $single){
                   
                    if($single->order_status == 3) {
                        $status = 'Completed';
                     } elseif($single->order_status == 2) {
                         $status = 'processing';
                     } else {
                         $status = 'pending';
                     }

					    $dealer_name = dealer_name($single->dealer_id);
                  if(!empty($dealer_name)) {
                       $name = $dealer_name[0]->f_name.' '.$dealer_name[0]->l_name;
                  }
                 
                        ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php echo $single->order_id;?></td>
                        <td><?php echo (isset($name) ? $name : '');?></td>
                        <td>
                           <?php 
                                 $date_created = $single->date;
                                 $date=date_create($date_created);
                                 echo date_format($date,"d-D-Y");
                              ?>
                        </td>
                        <td><?php echo $status;?></td>
                        <td><input class="btn btn-info buttonThemeColor" <?php if($single->order_status=='3') { ?> onclick="alert('Status is completed already. Therefore you can\'\ t add more shipment.');return false;"   <?php } else { ?> onclick="location.href='<?php echo base_url();?>webadmin/manageorders/addShipment/<?php echo $single->order_id;?>'" <?php } ?> id="<?php echo $ctr;?>" type="button" name="submit_status" value="Add Shipment"/>
                        </td>
                        <td><input class="btn btn-info buttonThemeColor" id="<?php echo $ctr;?>" type="button" name="submit_status" onclick="location.href='<?php echo base_url();?>webadmin/manageorders/viewShipment/<?php echo $single->order_id;?>'" value="View Shipment"/>
                       
					    <?php //if($single->order_status=='3') { ?> 
						<!--<input class="btn btn-info buttonThemeColor" id="<?php echo $ctr;?>" type="button" name="submit_status" onclick="location.href='<?php echo base_url();?>webadmin/manageorders/orderPdfGenerator/<?php echo $single->order_id;?>'" value="Print Invoice"/>-->
					<?php //} ?>
						</td>
                        
                     </tr>
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
<div class="manage_order"><a href="<?php echo base_url();?>webadmin/manageorders/orderPdfGenerator/">Order PDF</a></div>
<?php $this->load->view('include/layout_footer');?>
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
	      $( "#start_date" ).datepicker({ maxDate: new Date()});
		      $( "#end_date" ).datepicker({ maxDate: new Date()});
	   //$('#start_date').datepicker();

      $('.goByDate').click(function() {
         var error_count = 0;

         if($( "#start_date" ).val() == '') {
            alert('Please Select Start Date.');
            error_count++;
            return false;
         } else if($( "#end_date" ).val() == '') {
            alert('Please Select End Date.');
            error_count++;
            return false;
         } else {
            return true;
         }

      });
	   
	});
	</script>
<script>
   $(function(){
   		
   	<!--jQuery Table//Start-->
         var oTable1 = $('#sample-table-2').dataTable( {
         "aoColumns": [
            { "bSortable": false },
            null, null,null,null,null,
           { "bSortable": false }
         ] } );
      <!--jQuery Table//End-->
   
   });
</script>
</body>
</html>