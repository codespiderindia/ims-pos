<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>
<style>
.display_inline {
    display: inline-block;
}
</style>
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
             
               <div class="table-header tableThemeColor">Results for Discount on Products</div>
               <div class="table-header" id="filters" style=" padding-top: 8px; margin-top:10px;  background-color: #9f9f9f;">

                  <label class="inline_label display_inline">Select date</label>
                  <input type="text" name="select_date" class="select_datecls" id="select_dateid" />

                   <label class="inline_label display_inline">Select employee</label>
                   <select name="employee_name" class="sale_name_select" id="select_sale_Id">
                     <option value="">Select Employee</option>
                     <?php if(!empty($users)) {
                     foreach($users as $userss) { ?>
                         <option value="<?php echo $userss->user_ID; ?>"><?php echo $userss->user_name; ?></option>
                    <?php } } ?>
                   </select>

               </div>
               <div class="dayClose_content">
               <table id="sample-table-2" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>User Name</th>
                        <th>Payment Method</th>
                        <th>Cnote</th>
                        <th>Total</th>
                        <th>Closed Status</th>
                        <th>Action</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($dayCloseInfo) && !empty($dayCloseInfo)) {
                     $ctr=1;
                    foreach($dayCloseInfo as $dayCloseInfos) {
                     $userwhere = ['user_ID'=>$dayCloseInfos['user_id']];
                     $getStatus = getSku('user_master', $userwhere);
                           $dayStatus = $getStatus[0]['day_close'];
                           $userName = $getStatus[0]['user_name'];
                            ?>
                     <tr>
                        <td><?php echo $ctr; ?></td>
                        <td><?php echo $userName; ?></td>
                        <td>Cash: <?php echo $dayCloseInfos['cash']; ?></br>
                            Debit Card: <?php echo $dayCloseInfos['debit_card']; ?></br>
                            Credit Card: <?php echo $dayCloseInfos['credit_card']; ?></br>
                            Cheque/Coupon: <?php echo $dayCloseInfos['cheque']; ?></br>
                        </td>
                        <td><?php echo $dayCloseInfos['cnote']; ?></td>
                        <td><?php echo $dayCloseInfos['total']; ?></td>
                        <td>
                           
                           <label>
                              <input id="account_status_switch_<?php echo $dayCloseInfos['user_id'];?>" name="account_status_switch_<?php echo $dayCloseInfos['user_id'];?>" class="ace-switch ace-switch-3" type="checkbox" <?php if($dayStatus==1){echo "checked=checked";} ?> />
                              <span class="lbl"></span> 
                           </label>

                           <?php 
                           if($dayStatus==1){echo '<span style=" visibility:hidden">on</span>';} ?>
                           <?php if($dayStatus==0){echo '<span style=" visibility:hidden">off</span>';} ?>

                        </td>
                        <td>
                           <a href="<?php echo site_url(); ?>webadmin/managedayclose/editPaymentInfo/<?php echo $dayCloseInfos['id']; ?>" class="tooltip-info" data-rel="tooltip" title="" data-original-title="Edit">
                              <button class="btn btn-mini btn-info"> <i class="icon-edit bigger-120"></i> </button>
                           </a>
                        </td>
                     </tr>
                  <?php $ctr++; }  } ?>
                  </tbody>
               </table>
            </div>
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

   		var oTable1 = $('#sample-table-2').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null, null,null, null,
   		] } );


         $( ".ace-switch-3" ).change(function() {
            var change_status_to=0;
            if($(this).is(":checked")) {
            change_status_to=1;  
            }

            acc_id=$(this).attr('id').split('account_status_switch_');
            var url="<?php echo site_url();?>webadmin/managedayclose/changeStatus";

            $.ajax({
            url: url,
            type:'GET',
            data:"status="+change_status_to+"&acc_id="+acc_id[1],
            success: function(data){
               //alert(data);

            }
            });

         });
   
   });
</script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(function(){
         $( "#select_dateid" ).datepicker({
             dateFormat: "yy-mm-dd",
             maxDate: new Date(),
             onSelect: function(date, instance) {
               var saleId = $('#select_sale_Id :selected').val();
                $.ajax({
                   url:"<?php echo site_url();?>webadmin/managedayclose/getCloseDataByDate",
                   type:'POST',
                   data:"selected_date="+date+"&sale_id="+saleId,
                   success: function(data) {
                     // $('.vender_result').html(data);
                      $('.dayClose_content').html(data);
                   }
                });
             }
         });

         $(".sale_name_select").change(function(){
            
            var uId = $(this).val();
            var selectDate = $(".select_datecls").val();
           
            if($(".select_datecls").val() == 'undefined') {
               var selectDateVal = '';
            } else { 
              var selectDateVal = selectDate;
            }

             $.ajax({
                   url:"<?php echo site_url();?>webadmin/managedayclose/getCloseDataByDate",
                   type:'POST',
                   data: {
                        "selected_date":selectDateVal,
                        "sale_id":uId
                    },
                   success: function(data) {
                     // $('.vender_result').html(data);
                      $('.dayClose_content').html(data);
                   }
                });
         });
    });
</script>
</body>
</html>