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
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <p><b style="padding-left: 5%;"><h5>Last Expense Amount: Rs. <?php echo $expenses; ?></h5></b></p>

         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >


            <!--<div class="control-group <?php if(form_error('dealer') != '') echo 'error'; ?>">
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
               <span for="dealer" class="help-inline dealer"> <?php echo form_error('dealer') ?> </span>
               </div>
            </div>-->


            <div class="control-group <?php if(form_error('payment_for') != '') echo 'error'; ?>">
               <label class="control-label" for="title">Payment For</label>
               <div class="controls payment_for" style="margin-top: 5px;">
                 Cheque <input type="radio" style="opacity: 1;position: unset; margin-top: 0;" required id="title" name="payment_for" value="1" /> 

                 Direct Pay <input type="radio" required id="title" name="payment_for" value="0" style="opacity: 1;position: unset; margin-top: 0;" />
                  <span for="title" class="help-inline title payment_for_error"> <?php echo form_error('payment_for') ?> </span>
               </div>
            </div>

            <div class="control-group bank_cash <?php if(form_error('bank_cash') != '') echo 'bank_cash'; ?>">
               <label class="control-label" for="title">Select Bank/Cash</label>
               <div class="controls ">
                  <select name="bank_cash" id="bank_cash">
                     <option value="1">Bank</option>
                     <option value="2">Cash</option>
             </select>
              <span for="bank_cash" class="help-inline bank_cash_error"> <?php echo form_error('bank_cash') ?> </span>
               </div>
            </div>

            <div class="control-group cheque_number <?php if(form_error('cheque_number') != '') echo 'error'; ?>">
               <label class="control-label" for="cheque_number">Cheque Number</label>
               <div class="controls">
                  <input type="text" id="cheque_number" name="cheque_number" value="<?php echo set_value('cheque_number') ?>" />
                  <span for="cheque_number" class="help-inline cheque_number_error"> <?php echo form_error('cheque_number') ?> </span>
               </div>
            </div>
            

             <div class="control-group <?php if(form_error('mode_of_payment') != '') echo 'error'; ?>">
               <label class="control-label" for="mode_of_payment">Mode Of Payment</label>
               <div class="controls">
                  <input type="text" id="mode_of_payment" name="mode_of_payment" value="<?php echo set_value('mode_of_payment') ?>" placeholder="Cheque, Cash, NEFT" />
                  <span for="mode_of_payment" class="help-inline mode_of_payment_error"> <?php echo form_error('mode_of_payment') ?> </span>
               </div>
            </div>



            <div class="control-group <?php if(form_error('expense_amount') != '') echo 'error'; ?>">
               <label class="control-label" for="expense_amount">Expense Amount</label>
               <div class="controls">
                  <input type="text" id="expense_amount" name="expense_amount" value="<?php echo set_value('expense_amount') ?>" />
                  <span for="expense_amount" class="help-inline expense_amount_error"> <?php echo form_error('expense_amount') ?> </span>
               </div>
            </div>


            <div class="control-group <?php if(form_error('date') != '') echo 'error'; ?>">
               <label class="control-label" for="date">Date</label>
               <div class="controls">
                  <input type="date" id="date" required name="date" value="<?php echo set_value('date') ?>" />
                  <span for="date" class="help-inline date_error"> <?php echo form_error('date') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('description') != '') echo 'error'; ?>">
               <label class="control-label" for="description">Description</label>
               <div class="controls">
                  <textarea  id="description" name="description"><?php echo set_value('description') ?></textarea>
                  <span for="name" class="help-inline description_error"> <?php echo form_error('description') ?> </span>
               </div>
            </div>
			
			
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit expenseBtn" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Expense
               </button>
               &nbsp; &nbsp; &nbsp;
              
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script>
   $(function() {
         $('input[type=radio][name=payment_for]').change(function() {
        if (this.value == '1') {
            $('.cheque_number').show();
            $('.bank_cash').hide();
        }
        else if (this.value == '0') {
            $('.cheque_number').hide();
            $('.bank_cash').show();
        }
    });

      $('.expenseBtn').on('click', function() {
          var error_count = 0; 

         if($('input[type=radio][name=payment_for]').val() == "") {
            $(".payment_for_error").text("Please Select Payment Method.");
             error_count++;
         } else {
             $(".payment_for_error").empty();
         }

       
         if($('input[type=radio][name=payment_for]:checked').val() == 1) { //1 For Bank
            if($('#cheque_number').val() == "") {
               $(".cheque_number_error").text("Please Select Cheque Number.");
               error_count++;
            } else {
               $(".cheque_number_error").empty();
            }
         }


         if($('input[type=radio][name=payment_for]:checked').val() == 0) { //1 For Bank
            if($('#bank_cash').val() == "") {
               $(".bank_cash_error").text("Please Select Bank/Cash.");
               error_count++;
            } else {
               $(".bank_cash_error").empty();
            }
         }

         if($('#mode_of_payment').val() == "") {
            $(".mode_of_payment_error").text("Please Enter Mode Of Payment.");
            error_count++;
         } else {
             $(".mode_of_payment_error").empty();
         }

         
         if($('#expense_amount').val() == "") {
            $(".expense_amount_error").text("Please Enter Amount.");
            error_count++;
         } else {
             $(".expense_amount_error").empty();
         }


         if($('#date').val() == "") {
            $(".date_error").text("Please Enter Date.");
            error_count++;
         } else {
             $(".date_error").empty();
         }


         if($('#description').val() == "") {
            $(".description_error").text("Please Enter Description.");
            error_count++;
         } else {
             $(".description_error").empty();
         }

          if(error_count>0) 
         { 
            return false;
         }

      });

   });

</script>

<style>
.help-inline{color:red;}
</style>
</body>
</html>
