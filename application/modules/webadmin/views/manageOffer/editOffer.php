<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>
<style>
.help-inline {
	 color: red;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <?php //print_r($getIdByOffer);?>
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post">
            <div class="control-group <?php if(form_error('offer_name') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_name">Offer Name</label>
               <div class="controls">
                  <input type='text' id="offer_name" name="offer_name" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo $getIdByOffer->offer_name; } ?>"/>
                  <span for="offer_name" class="help-inline offer_name"> <?php echo form_error('offer_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('percentage_or_fixed') != '') echo 'error'; ?>">
               <label class="control-label" for="percentage_or_fixed">Percentage/Fixed</label>
               <div class="controls">
                  <select name="percentage_or_fixed" id="percentage_or_fixed">
                     <option value="" <?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ if($getIdByOffer->percentage_or_fixed==''){ echo 'selected=selected'; }} ?>>-Select-</option>
					 <option value="1" <?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ if($getIdByOffer->percentage_or_fixed=='1'){ echo 'selected=selected'; }} ?>>Percentage</option>
					 <option value="2" <?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ if($getIdByOffer->percentage_or_fixed=='2'){ echo 'selected=selected'; }} ?>>Fixed</option>
					 <option value="3" <?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ if($getIdByOffer->percentage_or_fixed=='3'){ echo 'selected=selected'; }} ?>>Free Product</option>
                  </select>
                  <span for="percentage_or_fixed" class="help-inline percentage_or_fixed"> <?php echo form_error('percentage_or_fixed') ?> </span>
               </div>
            </div>
			
			<div style="display:none" id="free_product_div" class="control-group <?php if(form_error('free_product') != '') echo 'error'; ?>"><label class="control-label" for="free_product">Free Product Name</label><div class="controls"><input type="text" id="free_product" name="free_product" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo $getIdByOffer->free_product; } ?>"/><span for="free_product" class="help-inline free_product"> <?php echo form_error('free_product') ?> </span></div></div>
			
            <div id="offer_discount_div" class="control-group <?php if(form_error('offer_discount') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_discount">Offer Discount</label>
               <div class="controls">
				<input type="text" id="offer_discount" name="offer_discount" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo $getIdByOffer->offer_discount; } ?>" />
				  <?php if( ($getIdByOffer->percentage_or_fixed==1) || ($this->input->post('percentage_or_fixed')==1) ){ ?>
				  	<span id="percentageSign">%</span>
				  <?php }else{ ?>
				  	<span id="percentageSign" style="display:none;">%</span>
				  <?php } ?>
                  <span for="offer_discount" class="help-inline offer_discount"><?php echo form_error('offer_discount'); ?></span>
               </div>
            </div>
			<div id="date_duration_start_div" class="control-group <?php if(form_error('date_duration_start') != '') echo 'error'; ?>">
               <label class="control-label" for="date_duration_start">Start Date</label>
               <div class="controls">
				  <input type="text" id="date_duration_start" name="date_duration_start" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo date('Y-m-d', strtotime( $getIdByOffer->date_duration_start)); } ?>" readonly/>
				  <!--<span class="input-group-addon"><i class="fa fa-exchange"></i></span> -->
				  <span for="date_duration_start" class="help-inline date_duration_start"><?php echo form_error('date_duration_start'); ?></span>
               </div>
            </div>
			
			<div style="display:none" id="start_date_free_product_div" class="control-group <?php if(form_error('start_date_free_product_div') != '') echo 'error'; ?>">
               <label class="control-label" for="start_date_free_product">Start Date Free Product</label>
               <div class="controls">
				  <input type="text" id="start_date_free_product" name="start_date_free_product" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo date('Y-m-d', strtotime( $getIdByOffer->start_date_free_product)); } ?>" readonly="readonly"/>
				  <span for="start_date_free_product" class="help-inline start_date_free_product"><?php echo form_error('start_date_free_product'); ?></span>
               </div>
            </div>
			
			<div id="date_duration_end_div" class="control-group <?php if(form_error('date_duration_end') != '') echo 'error'; ?>">
               <label class="control-label" for="date_duration_end">End Date</label>
               <div class="controls">
				  <!--<span class="input-group-addon"><i class="fa fa-exchange"></i></span> -->
				  <input type="text" id="date_duration_end" name="date_duration_end" value="<?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo date('Y-m-d', strtotime( $getIdByOffer->date_duration_end)); } ?>" readonly/>
				  	
				  <span for="date_duration_end" class="help-inline date_duration_end"><?php echo form_error('date_duration_end'); ?></span>
               </div>
            </div>
			
            <div class="control-group <?php if(form_error('offer_description') != '') echo 'error'; ?>">
               <label class="control-label" for="offer_description">Offer Description</label>
               <div class="controls">
                  <textarea id="offer_description" name="offer_description"><?php if(isset($getIdByOffer) && !empty($getIdByOffer)){ echo $getIdByOffer->offer_description; } ?></textarea>
                  <span for="offer_description" class="help-inline offer_description"> <?php echo form_error('offer_description') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update Offer
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>-->
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
	   $('#date_duration_start').datepicker({ 
            minDate: 0,
             dateFormat: 'yy-mm-dd',
            beforeShow: function() {
            	$(this).datepicker('option', 'maxDate', $('#date_duration_end').val());
            }
       });
	   $('#date_duration_end').datepicker({
            defaultDate: "+1w",
             dateFormat: 'yy-mm-dd',
            beforeShow: function() {
				$(this).datepicker('option', 'minDate', $('#date_duration_start').val());
				if ($('#date_duration_start').val() === '') $(this).datepicker('option', 'minDate', 0); 
			}
       });
	   
	   $('#start_date_free_product').datepicker();
	});
	
	$(document).ready(function() {
		$("#percentage_or_fixed").change(function(){
			var val = $(this).val();
			if(val==1) {
				$("#percentageSign").show();
		
			}else{
				$("#percentageSign").hide();
				
			}
			
			if(val==3) {
				$("#free_product_div").show();
				$("#offer_discount_div").hide();
				$('#offer_discount').val('NULL');
				$("#date_duration_end_div").hide();
				$('#date_duration_end').val('NULL');
				$('#start_date_free_product_div').show();
				$('#date_duration_start_div').hide();
				$('#date_duration_start').val('NULL');
				
			}
			else{
				$("#free_product_div").hide();
				$("#free_product").val('NULL');
				$('#start_date_free_product').val('NULL');
				$("#offer_discount_div").show();
				$("#date_duration_end_div").show();
				$('#offer_discount').val('');
				$('#date_duration_end').val('');
				$('#start_date_free_product_div').hide();
				$('#date_duration_start_div').show();
				$('#date_duration_start').val('');
				
			}
			
		});
		
		
		if($("#percentage_or_fixed").val()==3)
			{
				
				$("#free_product_div").show();
				$("#offer_discount_div").hide();
				$('#offer_discount').val('NULL');
				$("#date_duration_end_div").hide();
				$('#date_duration_end').val('NULL');
				$('#start_date_free_product_div').show();
				$('#date_duration_start_div').hide();
				$('#date_duration_start').val('NULL');
			}
			
		/*var percentage_or_fixed = $("#percentage_or_fixed").val();
		if(percentage_or_fixed==1) {
			$("#percentage").show();
			$("#fixed").hide();
		}else{
			$("#fixed").show();
			$("#percentage").hide();
			
		}*/
		
		$('.submit').click(function(){
			var error_count = 0;
			
		    var offer_name =  $('#offer_name').val();
			   if(offer_name=="")
			   {
				$(".offer_name").text("Please Enter Offer Name.");
				error_count++;
			   }
			   else {
				 $(".offer_name").empty();
				}
			
		    var percentage_or_fixed =  $('#percentage_or_fixed').val();
			   if(percentage_or_fixed=="")
			   {
				$(".percentage_or_fixed").text("Please Select Percentage or Fixed or Free Product.");
				error_count++;
			   }
			   else {
				 $(".percentage_or_fixed").empty();
				}
				
			var free_product =  $('#free_product').val();
			   if(free_product=="")
			   {
				$(".free_product").text("Please Enter Free Product.");
				error_count++;
			   }
			   else {
				 $(".free_product").empty();
				}
			
			var offer_discount =  $('#offer_discount').val();
			   if(offer_discount=="")
			   {
				$(".offer_discount").text("Please Enter Offer Discount.");
				error_count++;
			   }
			   else {
				 $(".offer_discount").empty();
				}
			
			var date_duration_start =  $('#date_duration_start').val();
			   if(date_duration_start=="")
			   {
				$(".date_duration_start").text("Please Enter Offer Start Date.");
				error_count++;
			   }
			   else {
				 $(".date_duration_start").empty();
				}
					
			var date_duration_end =  $('#date_duration_end').val();
			   if(date_duration_end=="")
			   {
				$(".date_duration_end").text("Please Enter Offer End Date.");
				error_count++;
			   }
			   else {
				 $(".date_duration_end").empty();
				}
				
			var start_date_free_product =  $('#start_date_free_product').val();
			   if(start_date_free_product=="")
			   {
				$(".start_date_free_product").text("Please Enter Offer Start Date.");
				error_count++;
			   }
			   else {
				 $(".start_date_free_product").empty();
				}
				
			var offer_description =  $('#offer_description').val();
			   if(offer_description=="")
			   {
				$(".offer_description").text("Please Enter Offer Description.");
				error_count++;
			   }
			   else {
				 $(".offer_description").empty();
				}
		
			
			if(error_count>0) 
			   {  
				return false;  
			   } 	
		});
	});
</script>
</body>
</html>