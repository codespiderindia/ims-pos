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
.remove_button {
  margin-left: 10px;
}
</style>


   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal cut_form_fok_sp" action="" method="post" >
            <div class="control-group <?php if(form_error('f_name') != '') echo 'error'; ?>">
               <label class="control-label" for="f_name">First Name</label>
               <div class="controls">
                  <input type="text" id="f_name" name="f_name" value="<?php echo set_value('f_name') ?>" />
                  <span for="f_name" class="help-inline f_name"> <?php echo form_error('f_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('l_name') != '') echo 'error'; ?>">
               <label class="control-label" for="l_name">Last Name</label>
               <div class="controls">
                  <input type="text" id="l_name" name="l_name" value="<?php echo set_value('l_name') ?>" />
                  <span for="l_name" class="help-inline l_name"> <?php echo form_error('l_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('email') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Email</label>
               <div class="controls">
                  <input type="text" id="email" name="email" value="<?php echo set_value('email') ?>" />
                  <span for="name" class="help-inline email"> <?php echo form_error('email') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('username') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Username</label>
               <div class="controls">
                  <input type="text" id="username" name="username" value="<?php echo set_value('username') ?>" />
                  <span for="name" class="help-inline username"> <?php echo form_error('username') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('password') != '') echo 'error'; ?>">
               <label class="control-label" for="user_password">Password</label>
               <div class="controls">
                  <input type="password" id="password" name="password" value="<?php echo set_value('password') ?>" />
                  <span for="name" class="help-inline password"> <?php echo form_error('password') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('cpassword') != '') echo 'error'; ?>">
               <label class="control-label" for="cpassword">Confirm Password</label>
               <div class="controls">
                  <input type="password" id="cpassword" name="cpassword" value="<?php echo set_value('cpassword') ?>" />
                  <span for="name" class="help-inline cpassword"> <?php echo form_error('cpassword') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
                  <span for="country" class="help-inline"> <?php echo form_error('store_country') ?> </span>
               </div>
            </div>

             <div class="control-group <?php if(form_error('store_state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="store_state" class="states" id="stateId">
                     <option value="">Select State</option>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value=""/>
                  <span for="state" class="help-inline"><?php echo form_error('store_state') ?></span>
               </div>
            </div>

			<div class="control-group <?php if(form_error('city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <input type="text" id="city" name="city" value="<?php echo set_value('city') ?>" />
                  <span for="city" class="help-inline city"> <?php echo form_error('city') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Address</label>
               <div class="controls">
                  <textarea id="address" name="address"></textarea>
                  <span for="address" class="help-inline address"> <?php echo form_error('address') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="zipcode">Zipcode</label>
               <div class="controls">
                  <input type="text" id="zipcode" name="zipcode" value="<?php echo set_value('zipcode') ?>" />
                  <span for="zipcode" class="help-inline zipcode"> <?php echo form_error('zipcode') ?> </span>
               </div>
            </div>
			<div class="field_wrapper1">
			<div>
				<div class="control-group <?php if(form_error('contact_number') != '') echo 'error'; ?>">
				   <label class="control-label" for="contact_number">Contact Number</label>
				   <div class="controls">
					  <input type="text" id="contact_number_1" class="contact_no" name="contact_number[]" value="<?php echo set_value('contact_number') ?>" />
					  <span for="contact_number" class="help-inline contact_number_1"> <?php echo form_error('contact_number') ?> </span>
				   </div>
				</div>
			<a href="javascript:void(0);" class="add_button1" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			</div>
			</div>
			<div class="field_wrapper2">
			<div>
				<div class="control-group <?php if(form_error('mobile_number') != '') echo 'error'; ?>">
				   <label class="control-label" for="mobile_number">Mobile Number</label>
				   <div class="controls">
					  <input type="number"   id="mobile_number_1" class="mobile_no" name="mobile_number[]" value="<?php echo set_value('mobile_number') ?>" />
					  <span for="mobile_number" class="help-inline mobile_number_1"> <?php echo form_error('mobile_number') ?> </span>
				   </div>
				</div>
			<a href="javascript:void(0);" class="add_button2" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			</div>
			</div>
			<div class="control-group <?php if(form_error('firm_name') != '') echo 'error'; ?>">
               <label class="control-label" for="firm_name">Firm Name</label>
               <div class="controls">
                  <input type="text" id="firm_name" name="firm_name" value="<?php echo set_value('firm_name') ?>" />
                  <span for="firm_name" class="help-inline firm_name"> <?php echo form_error('firm_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('tin_number') != '') echo 'error'; ?>">
               <label class="control-label" for="tin_name">GST Number</label>
               <div class="controls">
                  <input type="text" min="1" id="tin_number" name="tin_number" value="<?php echo set_value('tin_number') ?>" />
                  <span for="tin_name" class="help-inline tin_number"> <?php echo form_error('tin_number') ?> </span>
               </div>
            </div>
			
			
			<div class="control-group <?php if(form_error('dealer_credit_limits') != '') echo 'error'; ?>">
               <label class="control-label" for="dealer_credit_limits">Credit Amount</label>
               <div class="controls">
                  <input type="number" min="1" id="dealer_credit_limits" name="dealer_credit_limits" value="<?php echo set_value('dealer_credit_limits') ?>" />
                  <span for="dealer_credit_limits" class="help-inline dealer_credit_limits"> <?php echo form_error('dealer_credit_limits') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('number_of_days') != '') echo 'error'; ?>">
               <label class="control-label" for="number_of_days">Credit Limit Days</label>
               <div class="controls">
                  <input type="number" min="1" id="number_of_days" name="number_of_days" value="<?php echo set_value('number_of_days') ?>" />
                  <span for="number_of_days" class="help-inline number_of_days"> <?php echo form_error('number_of_days') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('interest_rate') != '') echo 'error'; ?>">
               <label class="control-label" for="interest_rate">Interest Rate</label>
               <div class="controls">
                  <input type="number" min="1" id="interest_rate" name="interest_rate" value="<?php echo set_value('interest_rate') ?>" />
                  <span for="interest_rate" class="help-inline interest_rate"> <?php echo form_error('interest_rate') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('contact_person') != '') echo 'error'; ?>">
               <label class="control-label" for="contact_person">Contact Person</label>
               <div class="controls">
                  <input type="text" id="contact_person" name="contact_person" value="<?php echo set_value('contact_person') ?>" />
                  <span for="contact_person" class="help-inline contact_person"> <?php echo form_error('contact_person') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('date_of_birth') != '') echo 'error'; ?>">
               <label class="control-label" for="date_of_birth">Date Of Birth</label>
               <div class="controls">
                  <input type="text" id="date_of_birth" name="date_of_birth" value="<?php echo set_value('date_of_birth') ?>" />
                  <span for="date_of_birth" class="help-inline date_of_birth"> <?php echo form_error('date_of_birth') ?> </span>
               </div>
            </div>
			
			
						
			
			<!--start add more Bank form--> 
			<div class="field_wrapper">
			<div>
			<div class="page-content">
			<div class="page-header position-relative">
				  <h1 class="headingThemeColor">
					Bank Details
				  </h1>
			</div>
			</div>
			<div class="control-group <?php if(form_error('account_number') != '') echo 'error'; ?>">
               <label class="control-label" for="account_number">Account Number</label>
               <div class="controls">
                  <input type="text" id="account_number_1" class="1" name="account_number[]" value="<?php echo set_value('account_number') ?>" />
                  <span for="account_number" class="help-inline account_number_1"> <?php echo form_error('account_number') ?> </span>
               </div>
         </div>
			<div class="control-group <?php if(form_error('ifsc_code') != '') echo 'error'; ?>">
               <label class="control-label" for="ifsc_code">IFSC Code</label>
               <div class="controls">
                  <input type="text" min="1" id="ifsc_code_1" name="ifsc_code[]" value="<?php echo set_value('ifsc_code') ?>" />
                  <span for="ifsc_code" class="help-inline ifsc_code_1"> <?php echo form_error('ifsc_code') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('account_name') != '') echo 'error'; ?>">
               <label class="control-label" for="account_name">Account Name</label>
               <div class="controls">
                  <input type="text" id="account_name_1" name="account_name[]" value="<?php echo set_value('account_name') ?>" />
                  <span for="account_name" class="help-inline account_name_1"> <?php echo form_error('account_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('bank_name') != '') echo 'error'; ?>">
               <label class="control-label" for="bank_name">Bank Name</label>
               <div class="controls">
                  <input type="text" id="bank_name_1" class="increment_account" name="bank_name[]" value="<?php echo set_value('bank_name') ?>" />
                  <span for="bank_name" class="help-inline bank_name_1"> <?php echo form_error('bank_name') ?> </span>
               </div>
            </div>
			<a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/> <strong>Add Bank Detail</strong> </a>
			</div>
			</div>
			<!--End add more Bank form-->
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Add Dealer
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
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script>
   $(function() {
         $("#countryId").change(function(){
         var countryid= $('#countryId :selected').val();
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('#stateId :selected').val();
         $('#stateid_hidden').val(stateid);
      });
   });
$( function() {
   var currentYear = (new Date).getFullYear();
	$( "#date_of_birth" ).datepicker({
	  changeMonth: true,
	  changeYear: true,
     dateFormat: 'dd/mm/yy',
     yearRange: '1950:'+currentYear,
     maxDate: new Date()
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	
	var x = 2; //Initial field counter is 2
	$(addButton).click(function(){;//Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			var fieldHTML = '<div><div class="page-content"><div class="page-header position-relative"><h1 class="headingThemeColor">Bank Details '+(x-1)+'</h1></div></div><div class="control-group '+'<?php if(form_error('account_number') != '') echo 'error'; ?>'+'"><label class="control-label" for="account_number">Account Number</label><div class="controls"><input type="text" id="account_number_'+x+'" name="account_number[]" value="'+'<?php echo set_value('account_number') ?>'+'"/><span for="account_number" class="help-inline account_number_'+x+'">'+'<?php echo form_error('account_number') ?>'+'</span></div></div><div class="control-group '+'<?php if(form_error('ifsc_code') != '') echo 'error'; ?>'+'"><label class="control-label" for="ifsc_code">IFSC Code</label><div class="controls"><input type="text" id="ifsc_code_'+x+'" name="ifsc_code[]" value="'+'<?php echo set_value('ifsc_code');?>'+'"/><span for="ifsc_code" class="help-inline ifsc_code_'+x+'">'+'<?php echo form_error('ifsc_code');?>'+' </span></div></div><div class="control-group '+'<?php if(form_error('account_name') != '') echo 'error'; ?>'+'"><label class="control-label" for="account_name">Account Name</label><div class="controls"><input type="text" id="account_name_'+x+'" name="account_name[]" value="'+'<?php echo set_value('account_name') ?>'+'" /><span for="account_name" class="help-inline account_name_'+x+'">'+'<?php echo form_error('account_name') ?>'+'</span></div></div><div class="control-group '+'<?php if(form_error('bank_name') != '') echo 'error'; ?>'+'"><label class="control-label" for="bank_name">Bank Name</label><div class="controls"><input type="text" id="bank_name_'+x+'" class="'+x+' increment_account" name="bank_name[]" value="'+'<?php echo set_value('bank_name') ?>'+'" /><span for="bank_name" class="help-inline bank_name_'+x+'">'+'<?php echo form_error('bank_name') ?>'+'</span></div></div><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="'+'<?php echo base_url().'assets/img/remove-icon.png';?>'+'"/></a></div>'; //New input field html
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
	
	
	
	
	function ValidateEmail(email) {
        var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        return expr.test(email);
    };
	//form validation
   $( ".submit" ).on("click",function() { 
   var error_count = 0;	
   var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
  var only_numeric = /^([7-9]{1}[0-9]{9})$/;


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
		$(".email").text("Please Enter EmailId.");
		error_count++;
	   }
	   else if(!ValidateEmail(email)) {
            $(".email").text("Invalid email address.");
			error_count++;
        }
		else if(email)
		{
		
		$('body').removeClass("still_error");
			var url="<?php echo site_url();?>webadmin/managevendor/checkEmailExist";
   				$.ajax({
   				url: url,
   				type:'POST',
				async: false ,
   				data:"email="+email,
   				success: function(data){
					
						   if(data=="true")	
						   {
							$(".email").empty();
							
								
						   }
						   else
						   {
							error_count++;
							$('.email').text(data);
							$('body').addClass("still_error");
							//alert(error_count);
								return false;
						   } 
					}
   				});
		}
		else
		 {
		  $(".email").empty();
		 }
	   
		
	var username =  $('#username').val();
	   if(username=="")
	   {
		$(".username").text("Please Enter Username.");
		error_count++;
	   }
	   else {
		 $(".username").empty();
		}
	
	var password =  $('#password').val();
	   if(password=="")
	   {
		$(".password").text("Please Enter Password.");
		error_count++;
	   }
	   else {
		 $(".password").empty();
		}
	
	var cpassword =  $('#cpassword').val();
	   if(cpassword=="")
	   {
		$(".cpassword").text("Please Enter Confirm Password.");
		error_count++;
	   }
	   else if(cpassword!=password)
	   {
		$(".cpassword").text("Password Not Matched.");
		error_count++;
	   }
	   else {
		 $(".cpassword").empty();
		}
		
	var city =  $('#city').val();
	   if(city=="")
	   {
		$(".city").text("Please Enter City.");
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
		$(".address").text("Please Enter Address.");
		error_count++;
	   }
	   else {
		 $(".address").empty();
		}
		
	var zipcode =  $('#zipcode').val();
	   if(zipcode=="")
	   {
		$(".zipcode").text("Please Enter Zipcode.");
		error_count++;
	   }
	   else if(!$.isNumeric(zipcode)) {
				$(".zipcode").text("Please Enter Numbers Only.");
				error_count++;
		}
	   else {
		 $(".zipcode").empty();
		}
	
		
	
	var firm_name =  $('#firm_name').val();
	   if(firm_name=="")
	   {
		$(".firm_name").text("Please Enter Firm Name.");
		error_count++;
	   } else if (!firm_name.match(only_alpha_space)) {
      $(".firm_name").text("Allow only letters and space.");
      error_count++;
      }
	   else {
		 $(".firm_name").empty();
		}
	
	var tin_number =  $('#tin_number').val();
	   if(tin_number=="")
	   {
		$(".tin_number").text("Please Enter Tin Number.");
		error_count++;
	   }
	   else {
		 $(".tin_number").empty();
		}
		
		
	var dealer_credit_limits =  $('#dealer_credit_limits').val();
	   if(dealer_credit_limits=="")
	   {
		$(".dealer_credit_limits").text("Please Enter credit amount.");
		error_count++;
	   } 
	   else {
		 $(".dealer_credit_limits").empty();
		}

	var number_of_days =  $('#number_of_days').val();
	   if(number_of_days=="")
	   {
		$(".number_of_days").text("Please Enter credit limit days.");
		error_count++;
	   }
	   else {
		 $(".number_of_days").empty();
		}
	var interest_rate =  $('#interest_rate').val();
	   if(interest_rate=="")
	   {
		$(".interest_rate").text("Please Enter Interest rate.");
		error_count++;
	   }
	   else {
		 $(".interest_rate").empty();
		}
	var contact_person =  $('#contact_person').val();
	   if(contact_person=="")
	   {
		$(".contact_person").text("Please Enter Contact person.");
		error_count++;
	   } else if (!contact_person.match(only_alpha_space)) {
      $(".contact_person").text("Allow only letters and space.");
      error_count++;
      }
	   else {
		 $(".contact_person").empty();
		}
	var date_of_birth =  $('#date_of_birth').val();
	   if(date_of_birth=="")
	   {
		$(".date_of_birth").text("Please Select Date of birth.");
		error_count++;
	   }
	   else {
		 $(".date_of_birth").empty();
		}

		
   
   //phone_number validation 
   $(".contact_no").each(function () {
   var id = $(this).attr("id").split('contact_number_');
   
   var contact_number =  $('#contact_number_'+id[1]).val();
	   if(contact_number=="")
	   {
		$('.contact_number_'+id[1]).text("Please Enter Contact Number.");
		error_count++;
	   }
	   else if(!$.isNumeric(contact_number)) {
			$(".contact_number_"+id[1]).text("Please Enter Numbers Only.");
			error_count++;
		}
	   else {
		 $('.contact_number_'+id[1]).empty();
		}
   });
   
   $(".mobile_no").each(function () {
   var id = $(this).attr("id").split('mobile_number_');
   var mobile_number_ =  $('#mobile_number_'+id[1]).val();
	   if(mobile_number_=="")
	   {
		$('.mobile_number_'+id[1]).text("Please Enter Mobile Number.");
		error_count++;
	   }
      else if (!mobile_number_.match(only_numeric)) {
	   //else if(!$.isNumeric(mobile_number_)) {
         if(mobile_number_.length > 10 || mobile_number_.length < 10) {
            $(".mobile_number_"+id[1]).text("Mobile Number length must be minimum 10 Digits.");
            error_count++;
         } else {
            $(".mobile_number_"+id[1]).text("Please Enter Correct Format.");
            error_count++;
         }
		}
		/*else if(mobile_number_.length > 10) {
			$(".mobile_number_"+id[1]).text("Mobile Number length must be minimum 10 Digits.");
				error_count++;
			}*/
	   else {
		 $('.mobile_number_'+id[1]).empty();
		}
   });
   
   //start bank detals validations
   $(".increment_account").each(function () {
   var id = $(this).attr("id").split('bank_name_');
	 
	   var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
    //  var only_alpha_numeric = /^\s*[~!@#$%^&*\s]+\s*$/;
      var iChars = "!`@#$%^&*()+=-[]\\\';,./{}|\":<>?~_";   

	   var account_number =  $('#account_number_'+id[1]).val();
		   if(account_number=="")
		   {
			//alert("Please enter p name");
			$(".account_number_"+id[1]).text("Please Enter Account Number.");
			error_count++;
		   }
		   else if(!$.isNumeric(account_number)) {
				$(".account_number_"+id[1]).text("Please Enter Numbers Only.");
				error_count++;
			}
			
		   else if (!(account_number.length >= 6)) {
			$(".account_number_"+id[1]).text("Account Number length must be minimum 6 Digits.");
				error_count++;
			}
		   else {
			 // hide message
			 $(".account_number_"+id[1]).empty();
			}
		
		var account_name =  $('#account_name_'+id[1]).val();
		   if(account_name=="")
		   {
			//alert("Please enter p name");
			$(".account_name_"+id[1]).text("Please Enter Account Name.");
			error_count++;
		   } else if (!account_name.match(only_alpha_space)) {
            $(".account_name_"+id[1]).text("Allow only letters and space.");
            error_count++;
         }
		   else {
			 // hide message
			 $(".account_name_"+id[1]).empty();
			}
		
		var ifsc_code =  $('#ifsc_code_'+id[1]).val();
      var parse_fl = parseFloat(ifsc_code);
		   if(ifsc_code=="")
		   {
			//alert("Please enter p name");
			$(".ifsc_code_"+id[1]).text("Please Enter IFSC Code.");
			error_count++;
		   } 
        /* else if(!$.isNumeric(ifsc_code) || isNaN(parse_fl) || (parse_fl === 0)) {
            $(".ifsc_code_"+id[1]).text("Please Enter Numbers Only.");
            error_count++;
         }*/
		   else {
			 // hide message
			 $(".ifsc_code_"+id[1]).empty();
			}
		
		var bank_name =  $('#bank_name_'+id[1]).val();
		   if(bank_name=="")
		   {
			//alert("Please enter p name");
			$(".bank_name_"+id[1]).text("Please Enter Bank Name.");
			error_count++;
		   } else if (!bank_name.match(only_alpha_space)) {
         $(".bank_name_"+id[1]).text("Allow only letters and space.");
         error_count++;
         }
		   else {
			 // hide message
			 $(".bank_name_"+id[1]).empty();
			}
   });
   //End bank detals validations
   	
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
   });
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	var maxField = 5; //Input fields increment limitation
	var addButton = $('.add_button1'); //Add button selector
	var wrapper = $('.field_wrapper1'); //Input field wrapper
	
	var x = 2; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
		var fieldHTML = '<div><div class="control-group <?php if(form_error('contact_number') != '') echo 'error'; ?>"><label class="control-label" for="contact_number">Contact Number</label><div class="controls"><input type="text" id="contact_number_'+x+'" name="contact_number[]" class="contact_no" value="'+'<?php echo set_value('contact_number') ?>'+'" /><span for="contact_number" class="help-inline contact_number_'+x+'">'+'<?php echo form_error('contact_number') ?>'+'</span></div></div><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="'+'<?php echo base_url().'assets/img/remove-icon.png';?>'+'"/></a></div>'; //New input field html 
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>

<script type="text/javascript">
$(document).ready(function(){
	var maxField = 5; //Input fields increment limitation
	var addButton = $('.add_button2'); //Add button selector
	var wrapper = $('.field_wrapper2'); //Input field wrapper
	var x = 2; //Initial field counter is 1
	$(addButton).click(function(){ //Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
		var fieldHTML = '<div><div class="control-group <?php if(form_error('mobile_number') != '') echo 'error'; ?>"><label class="control-label" for="mobile_number">Mobile Number</label><div class="controls"><input type="text" id="mobile_number_'+x+'" name="mobile_number[]" class="mobile_no" value="'+'<?php echo set_value('mobile_number') ?>'+'" /><span for="mobile_number" class="help-inline mobile_number_'+x+'">'+'<?php echo form_error('mobile_number') ?>'+'</span></div></div><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="'+'<?php echo base_url().'assets/img/remove-icon.png';?>'+'"/></a></div>'; //New input field html 
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
});
</script>


<style>
.help-inline{color:red;}
</style>
</body>
</html>
