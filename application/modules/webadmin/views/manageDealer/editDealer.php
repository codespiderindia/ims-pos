<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<?php
$contact_number = explode(",",$dealerInfo->contact_number);
$mobile_number = explode(",",$dealerInfo->mobile_number);
?>
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
		 <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('f_name') != '') echo 'error'; ?>">
               <label class="control-label" for="f_name">First Name</label>
               <div class="controls">
                  <input type="text" id="f_name" name="f_name" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->f_name;} ?>" />
                  <span for="f_name" class="help-inline f_name"> <?php echo form_error('f_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('l_name') != '') echo 'error'; ?>">
               <label class="control-label" for="l_name">Last Name</label>
               <div class="controls">
                  <input type="text" id="l_name" name="l_name" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->l_name;}  ?>" />
                  <span for="l_name" class="help-inline l_name"> <?php echo form_error('l_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('email') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Email</label>
               <div class="controls">
                  <input type="text" readonly="readonly" id="email" name="email" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->email;}  ?>" />
				  <input type="hidden"  name="email_hdn" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->email;}  ?>" />
                  <span for="name" class="help-inline email"> <?php echo form_error('email') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('username') != '') echo 'error'; ?>">
               <label class="control-label" for="username">Username</label>
               <div class="controls">
                  <input type="text" id="username" name="username" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->username;} ?>" />
                  <span for="name" class="help-inline username"> <?php echo form_error('username') ?> </span>
               </div>
            </div>
            

            <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <?php if(isset($dealerInfo->country) && $dealerInfo->country != 0){   ?>
                     <select name="country" id="countryId">
                         <option value="">Select Country</option>
                         <option selected="selected" value="<?php echo getCountryName($dealerInfo->country);?>" countryid="<?php echo $dealerInfo->country;?>"><?php echo getCountryName($dealerInfo->country);?>
                     </option>
                     </select>
                  <?php } else {  ?>
                     <select name="country" class="countries" id="countryId">
                         <option value="">Select Country</option>
                     </select>
                  <?php } ?>
                  <input type='hidden' id="countryid_hidden" name="countryid" value="<?php echo $dealerInfo->country;?>"/>
                  <span for="country" class="help-inline"> <?php echo form_error('country') ?> </span>
               </div>
            </div>



            <div class="control-group <?php if(form_error('state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="store_state" class="states" id="stateId">
                     <option value="">Select State</option>
                    <?php if(isset($dealerInfo->state) && $dealerInfo->state!=""){
                        $getAllStateName = getAllStateName($dealerInfo->country);

                           foreach($getAllStateName as $valState){
                                 if($valState->id==$dealerInfo->state){
                        ?>
                     <option selected="selected" value="<?php echo $valState->id;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valState->id;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php       }
                        }// end foreach
                         }
                        ?>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value="<?php echo $dealerInfo->state;?>"/>
                  <span for="state" class="help-inline"> <?php echo form_error('state') ?> </span>
               </div>
            </div>



            <div class="control-group <?php if(form_error('city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <input type="text" id="city" name="city" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->city;}  ?>" />
                  <span for="city" class="help-inline city"> <?php echo form_error('city') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Address</label>
               <div class="controls">
                  <textarea id="address" name="address"><?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->address;} ?></textarea>
                  <span for="address" class="help-inline address"> <?php echo form_error('address') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="zipcode">Zipcode</label>
               <div class="controls">
                  <input type="text" id="zipcode" name="zipcode" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->zipcode;} ?> " />
                  <span for="zipcode" class="help-inline zipcode"><?php echo form_error('zipcode') ?> </span>
               </div>
            </div>
			
			<div class="field_wrapper1">
			<?php for($i=0;$i<count($contact_number);$i++){?>
			<div>
				<div class="control-group <?php if(form_error('contact_number') != '') echo 'error'; ?>">
				   <label class="control-label" for="contact_number">Contact Number</label>
				   <div class="controls">
					  <input type="text" id="contact_number_<?php echo $i;?>" class="contact_no" name="contact_number[]" value="<?php echo $contact_number[$i]; ?>" />
					  <span for="contact_number" class="help-inline contact_number_<?php echo $i;?>"> <?php echo form_error('contact_number') ?> </span>
				   </div>
				</div>
			<?php if($i==0 || count($contact_number)==1){ ?>
			<a href="javascript:void(0);" class="add_button1" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			<?php }else{?>
			<a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="<?php echo base_url().'assets/img/remove-icon.png';?>"/></a>
			<?php }?>
			<input type="hidden" value="<?php echo count($contact_number); ?>" id="count_of_contact_number"/>
			</div>
			<?php }?>
			</div>
			
			<div class="field_wrapper2">
			<?php for($k=0;$k<count($mobile_number);$k++){?>
			
			<div>
				<div class="control-group <?php if(form_error('mobile_number') != '') echo 'error'; ?>">
				   <label class="control-label" for="mobile_number">Mobile Number</label>
				   <div class="controls">
					  <input type="text" id="mobile_number_<?php echo $k;?>" class="mobile_no" name="mobile_number[]" value="<?php echo $mobile_number[$k]; ?>" />
					  <span for="mobile_number" class="help-inline mobile_number_<?php echo $k;?>"> <?php echo form_error('mobile_number') ?> </span>
				   </div>
				</div>
			<?php if($k==0 || count($mobile_number)==1){ ?>
			<a href="javascript:void(0);" class="add_button2" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			<?php }else{?>
			<a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="<?php echo base_url().'assets/img/remove-icon.png';?>"/></a>
			<?php }?>
			<input type="hidden" value="<?php echo count($mobile_number); ?>" id="count_of_mobile_number"/>
			</div>
			<?php }?>
			</div>
			
			
			<div class="control-group <?php if(form_error('firm_name') != '') echo 'error'; ?>">
               <label class="control-label" for="firm_name">Firm Name</label>
               <div class="controls">
                  <input type="text" id="firm_name" name="firm_name" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->firm_name;}  ?>" />
                  <span for="firm_name" class="help-inline firm_name"> <?php echo form_error('firm_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('tin_number') != '') echo 'error'; ?>">
               <label class="control-label" for="tin_name">Tin Number</label>
               <div class="controls">
                  <input type="text" min="1" id="tin_name" name="tin_number" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->tin_number;}  ?>" />
                  <span for="tin_name" class="help-inline tin_number"><?php echo form_error('tin_number') ?>  </span>
               </div>
            </div>
			
			
			<div class="control-group <?php if(form_error('dealer_credit_limits') != '') echo 'error'; ?>">
               <label class="control-label" for="dealer_credit_limits">Credit Amount</label>
               <div class="controls">
                  <input type="number" min="1" id="dealer_credit_limits" name="dealer_credit_limits" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->dealer_credit_limits;}  ?>" />
                  <span for="dealer_credit_limits" class="help-inline dealer_credit_limits"> <?php echo form_error('dealer_credit_limits') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('number_of_days') != '') echo 'error'; ?>">
               <label class="control-label" for="number_of_days">Credit Limit Days</label>
               <div class="controls">
                  <input type="number" min="1" id="number_of_days" name="number_of_days" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->number_of_days;}  ?>" />
                  <span for="number_of_days" class="help-inline number_of_days"> <?php echo form_error('number_of_days') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('interest_rate') != '') echo 'error'; ?>">
               <label class="control-label" for="interest_rate">Interest Rate</label>
               <div class="controls">
                  <input type="number" min="1" id="interest_rate" name="interest_rate" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->interest_rate;}  ?>" />
                  <span for="interest_rate" class="help-inline interest_rate"> <?php echo form_error('interest_rate') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('contact_person') != '') echo 'error'; ?>">
               <label class="control-label" for="contact_person">Contact Person</label>
               <div class="controls">
                  <input type="text" id="contact_person" name="contact_person" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->contact_person;}  ?>" />
                  <span for="contact_person" class="help-inline contact_person"> <?php echo form_error('contact_person') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('date_of_birth') != '') echo 'error'; ?>">
               <label class="control-label" for="date_of_birth">Date Of Birth</label>
               <div class="controls">
                  <input type="text" id="date_of_birth" name="date_of_birth" value="<?php if(isset($dealerInfo) && !empty($dealerInfo)){echo $dealerInfo->date_of_birth;}  ?>" />
                  <span for="date_of_birth" class="help-inline date_of_birth"> <?php echo form_error('date_of_birth') ?> </span>
               </div>
            </div>
			
			
	
			<!--start add more Bank form--> 
			<div class="field_wrapper">
			<?php 
			$j=0;
			foreach($dealerBankInfo as $single){?>
			<div>
			<div class="page-content">
			<div class="page-header position-relative">
				  <h1 class="headingThemeColor"> 
					Bank Details <?php if($j!=0) echo $j;?>
				  </h1>
			</div>
			</div>
			<div class="control-group <?php if(form_error('account_number') != '') echo 'error'; ?>">
               <label class="control-label" for="account_number">Account Number</label>
               <div class="controls">
                  <input type="text" id="account_number_<?php echo $j;?>" class="1" name="account_number[]" value="<?php echo $single->account_number;?>" />
                  <span for="account_number" class="help-inline account_number_<?php echo $j;?>"> <?php echo form_error('account_number') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('ifsc_code') != '') echo 'error'; ?>">
               <label class="control-label" for="ifsc_code">IFSC Code</label>
               <div class="controls">
                  <input type="text" id="ifsc_code_<?php echo $j;?>" name="ifsc_code[]" value="<?php echo $single->ifsc_code;?>" />
                  <span for="ifsc_code" class="help-inline ifsc_code_<?php echo $j;?>"> <?php echo form_error('ifsc_code') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('account_name') != '') echo 'error'; ?>">
               <label class="control-label" for="account_name">Account Name</label>
               <div class="controls">
                  <input type="text" id="account_name_<?php echo $j;?>" name="account_name[]" value="<?php echo $single->account_name;?>" />
                  <span for="account_name" class="help-inline account_name_<?php echo $j;?>"> <?php echo form_error('account_name') ?> </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('bank_name') != '') echo 'error'; ?>">
               <label class="control-label" for="bank_name">Bank Name</label>
               <div class="controls">
                  <input type="text" id="bank_name_<?php echo $j;?>" class="increment_account" name="bank_name[]" value="<?php echo $single->bank_name;?>" />
                  <span for="bank_name" class="help-inline bank_name_<?php echo $j;?>"> <?php echo form_error('bank_name') ?> </span>
               </div>
            </div>
			<?php if($j==0 || count($dealerBankInfo)==1){ ?>
			<a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
			<?php }else{?>
			<a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="<?php echo base_url().'assets/img/remove-icon.png';?>"/></a>
			<?php }?>
			<input type="hidden" value="<?php echo count($dealerBankInfo); ?>" id="count_of_bank_details"/>
			</div>
			<?php $j++;}//end foreach loop?>
			</div>
			<!--End add more Bank form-->
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" name="submit" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update Dealer
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
//Bank Details add more
$(document).ready(function(){
	var maxField = 10; //Input fields increment limitation
	var addButton = $('.add_button'); //Add button selector
	var wrapper = $('.field_wrapper'); //Input field wrapper
	
	var count_of_bank_details = $("#count_of_bank_details").val();
	var x = count_of_bank_details; //Initial field counter is 1
	$(addButton).click(function(){;//Once add button is clicked
		if(x < maxField){ //Check maximum number of input fields
			var fieldHTML = '<div><div class="page-content"><div class="page-header position-relative"><h1 class="headingThemeColor">Bank Details '+x+'</h1></div></div><div class="control-group '+'<?php if(form_error('account_number') != '') echo 'error'; ?>'+'"><label class="control-label" for="account_number">Account Number</label><div class="controls"><input type="text" id="account_number_'+x+'" name="account_number[]" value="'+'<?php echo set_value('account_number') ?>'+'"/><span for="account_number" class="help-inline account_number_'+x+'">'+'<?php echo form_error('account_number') ?>'+'</span></div></div><div class="control-group '+'<?php if(form_error('ifsc_code') != '') echo 'error'; ?>'+'"><label class="control-label" for="ifsc_code">IFSC Code</label><div class="controls"><input type="text" id="ifsc_code_'+x+'" name="ifsc_code[]" value="'+'<?php echo set_value('ifsc_code');?>'+'"/><span for="ifsc_code" class="help-inline ifsc_code_'+x+'">'+'<?php echo form_error('ifsc_code');?>'+' </span></div></div><div class="control-group '+'<?php if(form_error('account_name') != '') echo 'error'; ?>'+'"><label class="control-label" for="account_name">Account Name</label><div class="controls"><input type="text" id="account_name_'+x+'" name="account_name[]" value="'+'<?php echo set_value('account_name') ?>'+'" /><span for="account_name" class="help-inline account_name_'+x+'">'+'<?php echo form_error('account_name') ?>'+'</span></div></div><div class="control-group '+'<?php if(form_error('bank_name') != '') echo 'error'; ?>'+'"><label class="control-label" for="bank_name">Bank Name</label><div class="controls"><input type="text" id="bank_name_'+x+'" class="'+x+' increment_account" name="bank_name[]" value="'+'<?php echo set_value('bank_name') ?>'+'" /><span for="bank_name" class="help-inline bank_name_'+x+'">'+'<?php echo form_error('bank_name') ?>'+'</span></div></div><a href="javascript:void(0);" class="remove_button" title="Remove field"><img src="'+'<?php echo base_url().'assets/img/remove-icon.png';?>'+'"/></a></div>'; //New input field html
			x++; //Increment field counter
			$(wrapper).append(fieldHTML); // Add field html
		}
	});
	$(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
		e.preventDefault();
		$(this).parent('div').remove(); //Remove field html
		x--; //Decrement field counter
	});
	
	
	
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
	
	
		
	
	var firm_name =  $('#firm_name').val();
	   if(firm_name=="")
	   {
		$(".firm_name").text("Please Enter Firm Name Name.");
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
		$(".tin_number").text("Please Enter Tin Number Name.");
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
	   else {
		 $('.mobile_number_'+id[1]).empty();
		}
   });
   
   //start bank detals validations
   $(".increment_account").each(function () {
   var id = $(this).attr("id").split('bank_name_');
	 
	   var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
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
		   }else if (!account_name.match(only_alpha_space)) {
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
			$(".ifsc_code_"+id[1]).text("Please Enter IFSC Code Name.");
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
//contact number add more
$(document).ready(function(){
	var maxField = 5; //Input fields increment limitation
	var addButton = $('.add_button1'); //Add button selector
	var wrapper = $('.field_wrapper1'); //Input field wrapper
	var count_of_contact_number = $("#count_of_contact_number").val();
	var x = count_of_contact_number; //Initial field counter is 1
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
//Mobile number add more
$(document).ready(function(){
	var maxField = 5; //Input fields increment limitation
	var addButton = $('.add_button2'); //Add button selector
	var wrapper = $('.field_wrapper2'); //Input field wrapper
	var count_of_mobile_number = $("#count_of_mobile_number").val();
	var x = count_of_mobile_number; //Initial field counter is 1
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
