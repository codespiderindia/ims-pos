<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('dealer_session_info');?>

<?php
$grand_total = 0;
// Calculate grand total. 
if ($cart = $this->cart->contents()):
    foreach ($cart as $item):
        $grand_total = $grand_total + $item['subtotal'];
    endforeach;
endif;
?>
<style>
.new_lab {
    width: 48%;
    float: right;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="<?php echo base_url() . 'dealer/manageproducts/save_order' ?>" method="post" >

         	<input type="hidden" id="dealer_id" name="dealer_id" value="<?php echo $uinfo['dealer_id']; ?>" />
			
			<div class="control-group order_total_text">
               <label class="control-label" for="f_name">Order Total</label>
               <div class="controls">
                   <!-- "order Total" Display  -->
			   		<p class="total_price"><?php echo number_format($grand_total, 2); ?> &#8360;</p>
               </div>
            </div>
            <div class="billingClass" style="float:left;width:48%;">

            <div class="control-group <?php if(form_error('f_name') != '') echo 'error'; ?>">
               <label class="control-label" for="f_name">First Name</label>
               <div class="controls">
                  <input type="text" id="f_name" name="fname" value="<?php echo $uinfo['f_name']; ?>" />
                  <span for="f_name" class="help-inline f_name"> <?php echo form_error('f_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('l_name') != '') echo 'error'; ?>">
               <label class="control-label" for="l_name">Last Name</label>
               <div class="controls">
                  <input type="text" id="l_name" name="lname" value="<?php echo $uinfo['l_name']; ?>" />
                  <span for="l_name" class="help-inline l_name"> <?php echo form_error('l_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('email') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Email</label>
               <div class="controls">
                  <input type="text" id="email" name="email" value="<?php echo $uinfo['email']; ?>" />
                  <span for="email" class="help-inline email"> <?php echo form_error('email') ?> </span>
               </div>
            </div>
            
            
			<div class="control-group <?php if(form_error('city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <input type="text" id="city" name="city" value="<?php echo $uinfo['city']; ?>" />
                  <span for="city" class="help-inline city"> <?php echo form_error('city') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Address</label>
               <div class="controls">
                  <textarea id="address" name="address"><?php echo $uinfo['address'];?></textarea>
                  <span for="address" class="help-inline address"> <?php echo form_error('address') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('cust_ship_address_notes') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Shipping Address Notes:</label>
               <div class="controls">
                  <textarea id="shipaddressnotes" name="cust_ship_address_notes"><?php // echo $uinfo['cust_ship_address_notes'];?></textarea>
                  <span for="address" class="help-inline shipaddressnotes"> <?php echo form_error('cust_ship_address_notes') ?> </span>
               </div>
            </div>
			
				
			<div class="control-group <?php if(form_error('zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="zipcode">Zipcode</label>
               <div class="controls">
                  <input type="text" id="zipcode" name="zipcode" value="<?php echo $uinfo['zipcode']; ?>" />
                  <span for="zipcode" class="help-inline zipcode"> <?php echo form_error('zipcode') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('mobile_number') != '') echo 'error'; ?>">
			   <label class="control-label" for="mobile_number">Mobile Number</label>
			   <div class="controls">
				  <input type="text" id="mobile_number" class="mobile_no" name="mobile_number" value="<?php echo $uinfo['mobile_number']; ?>" />
				  <span for="mobile_number" class="help-inline mobile_number"> <?php echo form_error('mobile_number') ?> </span>
			   
				</div>
			</div>
			
            <div class="form-actions" id="billingBtn">
               <button class="btn btn-info buttonThemeColor submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Place Order
               </button>
               &nbsp; &nbsp; &nbsp;
               
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
            <input type="hidden" name="grandTotal" id="grandTotal" value="<?php echo $grand_total; ?>" />
			
			<?php if(isset($creditDealerDetails) && !empty($creditDealerDetails)){ ?>
			<input type="hidden" name="dealerCreditLimits" id="dealerCreditLimits" value="<?php echo $creditDealerDetails->dealer_credit_limits; ?>" />
			<!--<input type="hidden" name="numberOfDays" id="numberOfDays" value="<?php echo $creditDealerDetails->number_of_days; ?>" />-->
			<?php } ?>
			
			</div>
			
			
			<input type="checkbox" name="shippingCkb" id="shippingCkb" value="1" style="opacity:1;" />
			<label class="new_lab">Shipping address same as Billing address</label>
			
			
			
			
			<div class="shippingClass" style="float:right;width:48%;display:none;">
			
			<div class="control-group <?php if(form_error('shipping_address') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_address">Shipping Address</label>
               <div class="controls">
                  <textarea id="shipping_address" name="shipping_address"><?php //echo $uinfo['shipping_address'];?></textarea>
                  <span for="shipping_address" class="help-inline shipping_address"> <?php echo form_error('shipping_address') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('shipping_city') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_city">Shipping City</label>
               <div class="controls">
                  <input type="text" id="shipping_city" name="shipping_city" value="<?php //echo $uinfo['shipping_city']; ?>" />
                  <span for="shipping_city" class="help-inline shipping_city"> <?php echo form_error('shipping_city') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('shipping_state') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_state">Shipping State</label>
               <div class="controls">
                  <input type="text" id="shipping_state" name="shipping_state" value="<?php //echo $uinfo['shipping_state']; ?>" />
                  <span for="shipping_state" class="help-inline shipping_state"> <?php echo form_error('shipping_state') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('shipping_country') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_country">Shipping Country</label>
               <div class="controls">
                  <input type="text" id="shipping_country" name="shipping_country" value="<?php //echo $uinfo['shipping_country']; ?>" />
                  <span for="shipping_country" class="help-inline shipping_country"> <?php echo form_error('shipping_country') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('shipping_zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_zipcode">Shipping Zipcode</label>
               <div class="controls">
                  <input type="text" id="shipping_zipcode" name="shipping_zipcode" value="<?php //echo $uinfo['shipping_zipcode']; ?>" />
                  <span for="shipping_zipcode" class="help-inline shipping_zipcode"> <?php echo form_error('shipping_zipcode') ?> </span>
               </div>
            </div>
			
			<div class="control-group <?php if(form_error('shipping_mobile_number') != '') echo 'error'; ?>">
			   <label class="control-label" for="shipping_mobile_number">Shipping Mobile Number</label>
			   <div class="controls">
				  <input type="text" id="shipping_mobile_number" name="shipping_mobile_number" value="<?php //echo $uinfo['shipping_mobile_number']; ?>" />
				  <span for="shipping_mobile_number" class="help-inline shipping_mobile_number"> <?php echo form_error('shipping_mobile_number') ?> </span>
			   
				</div>
			</div>
			
			<div class="control-group <?php if(form_error('shipping_notes') != '') echo 'error'; ?>">
               <label class="control-label" for="shipping_notes">Shipping Notes</label>
               <div class="controls">
                  <textarea id="shipping_notes" name="shipping_notes"><?php //echo $uinfo['shipping_notes'];?></textarea>
                  <span for="shipping_notes" class="help-inline shipping_notes"> <?php echo form_error('shipping_notes') ?> </span>
               </div>
            </div>
			
            <div class="form-actions" id="shippingBtn">
               <button class="btn btn-info buttonTh
			   emeColor shippingSubmit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Place Order
               </button>
               &nbsp; &nbsp; &nbsp;

               
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
			
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
<script type="text/javascript">
$(document).ready(function(){
	function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	//form validation
   $( ".submit" ).on("click",function() { 
   var error_count = 0;	
   var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
	var f_name =  $('#f_name').val();
	   if(f_name=="")
	   {
		$(".f_name").text("Please Enter First Name.");
		error_count++;
	   }
	   else if (!f_name.match(only_alpha_space)) {
		$(".f_name").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".f_name").empty();
		}
		
	var l_name =  $('#l_name').val();
	   if(l_name=="")
	   {
		$(".l_name").text("Please Enter Last Name.");
		error_count++;
	   }
	   else if (!l_name.match(only_alpha_space)) {
		$(".l_name").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".l_name").empty();
		}
	
	var email =  $('#email').val();
	   if(email=="")
	   {
		$(".email").text("Please Enter Email Name.");
		error_count++;
	   }
	   else if(!ValidateEmail(email)) {
            $(".email").text("Invalid email address.");
			error_count++;
        }
		else
		 {
		  $(".email").empty();
		 }
	   
		
	var username =  $('#username').val();
	   if(username=="")
	   {
		$(".username").text("Please Enter Username Name.");
		error_count++;
	   }
	   else {
		 $(".username").empty();
		}
	
	
		
	var city =  $('#city').val();
	   if(city=="")
	   {
		$(".city").text("Please Enter City Name.");
		error_count++;
	   }
	   else if (!city.match(only_alpha_space)) {
		$(".city").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".city").empty();
		}
		
	var address =  $('#address').val();
	   if(address=="")
	   {
		$(".address").text("Please Enter Address Name.");
		error_count++;
	   }
	   else {
		 $(".address").empty();
		}


	var shipaddressnotes =  $('#shipaddressnotes').val();
	   if(shipaddressnotes=="")
	   {
		$(".shipaddressnotes").text("Please Enter Address Name.");
		error_count++;
	   }
	   else {
		 $(".shipaddressnotes").empty();
		}

		
	var zipcode =  $('#zipcode').val();
	   if(zipcode=="")
	   {
		$(".zipcode").text("Please Enter Zipcode Name.");
		error_count++;
	   }
	   else if(!$.isNumeric(zipcode)) {
				$(".zipcode").text("Please Enter Numbers Only.");
				error_count++;
		}
	   else {
		 $(".zipcode").empty();
		}

   
   var mobile_number_ =  $('#mobile_number').val();
	   if(mobile_number_=="")
	   {
		$('.mobile_number').text("Please Enter Mobile Number.");
		error_count++;
	   }
	   else if(!$.isNumeric(mobile_number_)) {
				$(".mobile_number").text("Please Enter Numbers Only.");
				error_count++;
		}
		else if (!(mobile_number_.length >= 10)) {
			$(".mobile_number").text("Mobile Number length must be minimum 10 Digits.");
				error_count++;
			}
	   else {
		 $('.mobile_number').empty();
		}
  
	
	
		
   if(error_count>0) 
   {  
	//alert("Please Fill All Required Fields");
   	var body = $("html, body");
	body.stop().animate({scrollTop:0});
	return false;  
   } 
   
   if($('body').hasClass('still_error')) {
   return false;  
   }
  // return false;

		var grandTotal         =  $('#grandTotal').val();
		  var dealerCreditLimits =  $('#dealerCreditLimits').val();
		  //alert(grandTotal);
		  //alert(dealerCreditLimits);
		  if(parseInt(dealerCreditLimits) >= parseInt(grandTotal)){
		  	  return true;
		  }else{
		  	  alert('Your dealer credit limits not sufficient.');
		  	  return false;
		  }
   });
$("#shippingCkb").click(function() {
		if($(this).is(":checked")) {
			$(".shippingClass").show();
			$("#billingBtn").hide();
		} else {
			$(".shippingClass").hide();
			$("#billingBtn").show();
		}
	});   
   
   $( ".shippingSubmit" ).on("click",function() { 
   var error_count = 0;	
   var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
	var f_name =  $('#f_name').val();
	   if(f_name=="")
	   {
		$(".f_name").text("Please Enter First Name.");
		error_count++;
	   }
	   else if (!f_name.match(only_alpha_space)) {
		$(".f_name").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".f_name").empty();
		}
		
	var l_name =  $('#l_name').val();
	   if(l_name=="")
	   {
		$(".l_name").text("Please Enter Last Name.");
		error_count++;
	   }
	   else if (!l_name.match(only_alpha_space)) {
		$(".l_name").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".l_name").empty();
		}
	
	var email =  $('#email').val();
	   if(email=="")
	   {
		$(".email").text("Please Enter Email Name.");
		error_count++;
	   }
	   else if(!ValidateEmail(email)) {
            $(".email").text("Invalid email address.");
			error_count++;
        }
		else
		 {
		  $(".email").empty();
		 }
	   
		
	var username =  $('#username').val();
	   if(username=="")
	   {
		$(".username").text("Please Enter Username Name.");
		error_count++;
	   }
	   else {
		 $(".username").empty();
		}
	
	
		
	var city =  $('#city').val();
	   if(city=="")
	   {
		$(".city").text("Please Enter City Name.");
		error_count++;
	   }
	   else if (!city.match(only_alpha_space)) {
		$(".city").text("Allow only letters and space.");
		error_count++;
	   }
	   else {
		 $(".city").empty();
		}
		
	var address =  $('#address').val();
	   if(address=="")
	   {
		$(".address").text("Please Enter Address Name.");
		error_count++;
	   }
	   else {
		 $(".address").empty();
		}
		
	var zipcode =  $('#zipcode').val();
	   if(zipcode=="")
	   {
			$(".zipcode").text("Please Enter Zipcode Name.");
			error_count++;
	   }
	   else if(!$.isNumeric(zipcode)) {
			$(".zipcode").text("Please Enter Numbers Only.");
			error_count++;
		}
	   else {
		 $(".zipcode").empty();
		}

   
   var mobile_number_ =  $('#mobile_number').val();
	   if(mobile_number_=="")
	   {
		$('.mobile_number').text("Please Enter Mobile Number.");
		error_count++;
	   }
	   else if(!$.isNumeric(mobile_number_)) {
				$(".mobile_number").text("Please Enter Numbers Only.");
				error_count++;
		}
		else if (!(mobile_number_.length >= 10)) {
			$(".mobile_number").text("Mobile Number length must be minimum 10 Digits.");
				error_count++;
			}
	   else {
		 $('.mobile_number').empty();
		}
  
	
	/* shipping form validation start */
	
	   var shipping_address =  $('#shipping_address').val();
	   if(shipping_address==""){
			$(".shipping_address").text("Please Enter Address Name.");
			error_count++;
	   }else {
			$(".shipping_address").empty();
	   }
	   
	   var shipping_city =  $('#shipping_city').val();
	   if(shipping_city==""){
			$(".shipping_city").text("Please Enter City Name.");
			error_count++;
	   }else if (!shipping_city.match(only_alpha_space)) {
			$(".shipping_city").text("Allow only letters and space.");
			error_count++;
	   }else{
			$(".shipping_city").empty();
	   }
	   
	   var shipping_state =  $('#shipping_state').val();
	   if(shipping_state==""){
			$(".shipping_state").text("Please Enter State Name.");
			error_count++;
	   }else if (!shipping_state.match(only_alpha_space)) {
			$(".shipping_state").text("Allow only letters and space.");
			error_count++;
	   }else{
			$(".shipping_state").empty();
	   }
	   
	   var shipping_country =  $('#shipping_country').val();
	   if(shipping_country==""){
			$(".shipping_country").text("Please Enter Country Name.");
			error_count++;
	   }else if (!shipping_country.match(only_alpha_space)) {
			$(".shipping_country").text("Allow only letters and space.");
			error_count++;
	   }else{
			$(".shipping_country").empty();
	   }
	   
	   var shipping_zipcode =  $('#shipping_zipcode').val();
	   if(shipping_zipcode==""){
			$(".shipping_zipcode").text("Please Enter Zipcode Name.");
			error_count++;
	   }else if(!$.isNumeric(shipping_zipcode)) {
			$(".shipping_zipcode").text("Please Enter Numbers Only.");
			error_count++;
	   }else{
		 	$(".shipping_zipcode").empty();
	   }
   
  	   var shipping_mobile_number =  $('#shipping_mobile_number').val();
	   if(shipping_mobile_number==""){
			$('.shipping_mobile_number').text("Please Enter Mobile Number.");
			error_count++;
	   }else if(!$.isNumeric(shipping_mobile_number)) {
			$(".shipping_mobile_number").text("Please Enter Numbers Only.");
			error_count++;
	   }else if (!(shipping_mobile_number.length >= 10)) {
			$(".shipping_mobile_number").text("Mobile Number length must be minimum 10 Digits.");
			error_count++;
	   }else {
		 	$('.shipping_mobile_number').empty();
	   }
	   
	   var shipping_notes =  $('#shipping_notes').val();
	   if(shipping_notes==""){
			$(".shipping_notes").text("Please Enter Note Name.");
			error_count++;
	   }else {
			$(".shipping_notes").empty();
	   }
	
	/* shipping form validation end */
	
		
   if(error_count>0) 
   {  
	//alert("Please Fill All Required Fields");
   	var body = $("html, body");
	body.stop().animate({scrollTop:0});
	return false;  
   } 
   
   if($('body').hasClass('still_error')) {
   return false;  
   }
  // return false;
   
  
	  var grandTotal         =  $('#grandTotal').val();
	  var dealerCreditLimits =  $('#dealerCreditLimits').val();

	  if(parseInt(dealerCreditLimits) >= parseInt(grandTotal)){
	  	  return true;
	  }else{
	  	  alert('Your dealer credit limits not sufficient.');
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