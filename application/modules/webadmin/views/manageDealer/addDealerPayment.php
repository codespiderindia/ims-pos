<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
	   <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
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
   <!--/.page-header-->
   <div class="row-fluid">
   
   <?php  ?>
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" >
            <div class="control-group <?php if(form_error('dealer') != '') echo 'error'; ?>">
               <label class="control-label" for="dealer">Dealer</label>
               <div class="controls">
         <select required name="dealer" id="dealer">
		 <option value="">Select Dealer</option>
		
		 <?php  
		 foreach ($dealers as $dealers)
		  { ?>
		  <option value="<?php echo $dealers->dealer_id;?>"><?php echo $dealers->f_name." ".$dealers->f_name;?></option>
		 <?php }?>
               </select>
			      <span for="f_name" class="help-inline f_name"> <?php echo form_error('dealer') ?> </span>
               </div>
            </div>

			
			<div class="control-group  <?php if(form_error('bank_cash') != '') echo 'bank_cash'; ?>">
         <label class="control-label" for="title">Select Bank/Cash</label>
         <div class="controls ">
            <select name="bank_cash" id="bank_cash">
                <option value="bank">Bank</option>
	              <option value="cash">Cash</option>
	          </select>
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
                  <input  type="number" min="0" required id="amount" class="amount_txt" name="amount" value="<?php echo set_value('amount') ?>" />
                  <span for="name" class="help-inline amount amount_error"> <?php echo form_error('amount') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('date') != '') echo 'error'; ?>">
               <label class="control-label" for="date">Date</label>
               <div class="controls">
                  <input type="date" id="date" required name="date" value="<?php echo set_value('date') ?>" />
                  <span for="name" class="help-inline username"> <?php echo form_error('date') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('description') != '') echo 'error'; ?>">
               <label class="control-label" for="description">Description</label>
               <div class="controls">
                  <textarea  id="description" name="description"><?php echo set_value('description') ?></textarea>
                  <span for="name" class="help-inline password"> <?php echo form_error('description') ?> </span>
               </div>
            </div>
            
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" class="submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Dealer Payment
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
	  //    $( "#date" ).datepicker();
		    
			//$('#date').datepicker({ dateFormat: 'yy-mm-dd' }).val();
			 var currentYear = (new Date).getFullYear();
			 /* $("#date").datepicker({
	         changeMonth: true,
           changeYear: true,
           yearRange: currentYear+':2050',
           minDate: new Date()
        });*/
			
			//  $( "#end_date" ).datepicker();
	   //$('#start_date').datepicker();
	   
$( "#dealer" ).change(function() {
  var  dealer_id  = $(this).val();

$.ajax({ 
method: 'GET',
url: '<?php echo  base_url(); ?>webadmin/managedealer/getInvoicesByDealerId',
data: {'dealer_id':dealer_id},
success: function (dataCheck) {
                $('#invoice_id').html(dataCheck);
            }
});

});
	
	
	
	 $('input[type=radio][name=payment_for]').change(function() {
        if (this.value == '1') {
            $('.invoice_select').show();
        }
        else if (this.value == '0') {
            $('.invoice_select').hide();
        }
    });

    /*$('.submit').on('click', function() {
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
    });*/
	
	
	});

	
	</script>
<style>
.help-inline{color:red;}
</style>
</body>
</html>
