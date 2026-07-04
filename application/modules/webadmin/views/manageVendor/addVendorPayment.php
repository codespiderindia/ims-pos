<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<style>
.cut_form_fok_sp .controls {
  display: inline-block;
  margin-left: 16px;
}
.cut_form_fok_sp .control-label {
  display: inline-block;
  float: none;
  vertical-align: middle;
  padding-top: 0;
}

</style>






<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
      </h1>
	   <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
   
   <?php  ?>
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" >
            <div class="control-group <?php if(form_error('vendor') != '') echo 'error'; ?>">
               <label class="control-label" for="dealer">vendor</label>
               <div class="controls">
         <select required name="vendor" id="vendor">
		 <option value="">Select Vendor</option>
		
		 <?php  
		 foreach ($vendor as $vendor)
		  { ?>
		  <option value="<?php echo $vendor->vendor_id;?>"><?php echo $vendor->f_name." ".$vendor->f_name;?></option>
		 <?php }?>
               </select>
			      <span for="f_name" class="help-inline f_name"> <?php echo form_error('vendor') ?> </span>
               </div>
            </div>

			<div class="control-group  <?php if(form_error('bank_cash') != '') echo 'bank_cash'; ?>">
               <label class="control-label" for="title">Select Bank/Cash</label>
               <div class="controls ">
                  <select name="bank_cash" id="bank_cash"><option value="bank">Bank</option>
				  <option value="cash">Cash</option>
				 
				 </select>
             <span for="bank_cash" class="help-inline bank_cash_error"> <?php echo form_error('bank_cash') ?> </span>
               </div>
            </div>


			<div class="control-group  <?php if(form_error('mode_of_payment') != '') echo 'mode_of_payment'; ?>">
               <label class="control-label" for="title">Mode of Payment</label>
               <div class="controls ">
                  <input type="text"  required id="mode_of_payment" name="mode_of_payment" value="" placeholder="Cash , Bank,NEFT etc"/> 
               </div>
            </div>
			
			<div class="control-group  <?php if(form_error('transaction_id') != '') echo 'transaction_id'; ?>">
               <label class="control-label" for="title">Transaction Id</label>
               <div class="controls ">
                  <input type="text"  required id="transaction_id" name="transaction_id" value="" /> 
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('amount') != '') echo 'error'; ?>">
               <label class="control-label" for="amount">Amount</label>
               <div class="controls">
                  <input type="number" min="1" required class="amount_txt" id="amount" name="amount" value="<?php echo set_value('amount') ?>" />
                  <span for="name" class="help-inline amount amount_error"> <?php echo form_error('amount') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('date') != '') echo 'error'; ?>">
               <label class="control-label" for="date">Date</label>
               <div class="controls">
                  <input type="text" id="date" required name="date" value="<?php echo set_value('date') ?>" />
                  <span for="name" class="help-inline username"> <?php echo form_error('date') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('description') != '') echo 'error'; ?>">
               <label class="control-label" for="description">Description</label>
               <div class="controls">
                  <textarea  id="description" required name="description"><?php echo set_value('description') ?></textarea>
                  <span for="name" class="help-inline password"> <?php echo form_error('description') ?> </span>
               </div>
            </div>
            
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Vendor
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script type="text/javascript">
	jQuery(function($) {
		    
			$('#date').datepicker({
          dateFormat: 'dd-mm-yy',
           minDate: new Date()
           });

      $('input[type=radio][name=payment_for]').change(function() {
        if (this.value == '1') {
            $('.invoice_select').show();
        }
        else if (this.value == '0') {
            $('.invoice_select').hide();
        }
    });

     jQuery(document).ready(function() {
         $('.submit').on('click', function() {
            var error_count = 0; 

            if($('#bank_cash').val() == 'cash') {

               var amt = $('.amount_txt').val();
               var url="<?php echo site_url();?>webadmin/managevendor/checkCashAmtExist";

               $.ajax({
                  url: url,
                  type:'GET',
                  async: false ,
                  data:"amount="+amt,
                  success: function(data){
                     if(data == 1) {
                        $('.amount_error').text('Amount not available.!!');
                        error_count++;
                     } else {
                        $('.amount_error').empty();
                     }
                  }
               });
            }

            if(error_count > 0) {
               return false;  
            }
         });
      });


      /*$('#vendor').on('change', function() {
         var vendorId = $(this).val();

         $.ajax({
            type:'GET',
            url: '<?php echo  base_url(); ?>webadmin/managevendor/getInvoicesByVendorId',
            data: {'vendorId':vendorId},
            success: function (dataCheck) {
               $('#invoice_id').html(dataCheck);
            }
         });

      });*/


     /* $('.submit').on('click', function() {
         var payFor = $('input[type=radio][name=payment_for]').val();

         var error_count = 0;

         if(payFor == 1) {
            if($('#invoice_id').val() == '') {
               $('.invoice_id_error').text('Please select Invoice.');
               error_count++;
            } else {
               $('.invoice_id_error').text('');
            }
         } else {
            if($('#bank_cash').val() == '') {
               $('.bank_cash_error').text('Please Select Bank/Cash.');
               error_count++;
            } else {
               $('.bank_cash_error').text('');
            }
         }
      });*/

	   
	});
	</script>
<style>
.help-inline{color:red;}
</style>
</body>
</html>
