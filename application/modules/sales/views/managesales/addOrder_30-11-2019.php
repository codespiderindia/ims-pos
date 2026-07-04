<?php $this->load->view('include/layout_header'); ?>

<?php  $uInfo=$this->session->userdata('sales_session_info');

//$saleId = $this->session->unset_userdata('saleID');
//$this->session->unset_userdata('chk_have_invoice');
//$this->session->unset_userdata('_product_loyalty_point_');
	//var_dump($this->session->userdata('_product_offer_'));
$where=['user_id'=>$uInfo['user_ID']];
$getUserInfo = getSku('user_master',$where);
$dayCloseStatus = $getUserInfo[0]['day_close'];

	$stype1=0;
	$flg_st=$this->session->userdata('sale_type');
	if(isset($flg_st)){
		$stype1=$this->session->userdata('sale_type');
	}

?>    

<style type="text/css">
	.error{
		border: 1px solid red !important;
	}

	.amt-grn{
		color: #6fd64b;
    font-size: 16px;
    font-weight: 400;
    text-align: center;
	}

	.amt-orng{
	color: #ff9e28;
    font-size: 16px;
    font-weight: 400;
    text-align: center;
	}
	.customer_label {
		text-align: left !important;
		padding-left: 5px !important;
		/*width: 100px !important;*/
	}
	.error_color {
		color: red;
	}
</style>
  

<div class="page-content">
	<?php if($dayCloseStatus == 1) {
		echo 'Your Account has been closed for today !!';
	} else { ?>
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Sale Info.</h1>
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
   </div>
   <!--/.page-header-->
   
   <!--/.row-fluid-->
   <div class="row-fluid">
		<div class="span12">
			<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Order Information
						
					</h4>
				</div>

				<div class="widget-body">
				
					<div class="widget-main ">
					<table>
						<tr>
							<td width="100px;"> <label style="margin-top: -10px;text-align: right;ext-align: right;" >Company : &nbsp;</label> </td>
							<td width="20%;">

							<label style="margin-top: -10px;" for="form-field-1"><?php echo getCompanyNameByID($uInfo['comp_code']); ?></label>
							
							</td>
							
							<td width="100px;"> <label style="margin-top: -10px;margin-left: 10px;margin-left: 10px; text-align: right;" >Store : &nbsp;</label> </td>
							<td width="20%;">


							<label style="margin-top: -10px;" for="form-field-1">
								<?php echo getStoreNameByID($uInfo['store']); ?>
							</label>

							</td>
							<td width="100px;"> <label style="margin-top: -10px;margin-left: 10px; text-align: right;" >Date/Time : &nbsp;</label> </td>
							<td width="20%;">
							
							
							<label style="margin-top: -10px;" for="form-field-1">
								<?php echo date("Y-m-d h:i")?>
							</label>
							</td>

							<?php /*$chk_have_invoice=$this->session->userdata('chk_have_invoice');
							if(isset($chk_have_invoice) && !empty($chk_have_invoice) && $chk_have_invoice != 0) {*/ ?>
							<td class="reprint-td">
								<!--<a href="<?php echo base_url() ?>managesales/sales_invoice/<?php echo $saleId; ?>"><button class="re-print-invoice">Re-Print</button></a>-->
							</td>
							<?php //} ?>
					</table>

					</div>
					
				</div>
			</div>
		</div>
	</div>

   <div class="row-fluid">
		<div class="span9" style="width: 74.359%;">
			<!--PAGE CONTENT BEGINS-->

						<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Item Information
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
						<table width="100%">
<tr>

	<td colspan="2" width="60%">
		<table>
	<tr>
		<td width="10%">
					Type

		</td>
		<td>
			<select name="sale_type" id="sale_type" style="width: 75px;">
				<option value="0" <?php if($sale_type==0){ echo "selected";}?>>Sale</option>
				<option value="1" <?php if($sale_type==1){ echo "selected";}?>>Return</option>
			</select>
		</td>
	</tr>
	<form style="margin: 0px;" name="item_info_frm" id="item_info_frm" method="post" action="<?php echo base_url();?>sales/managesales/addItemToCart">
	<tr id="div_chk_stype" style="<?php if($sale_type==1){ echo "display: none;";}?>">
		<td>Have Credit Note</td>
		<td>
			<input type="checkbox" name="chk_sri" id="chk_sri" value="1" style="opacity:1; position: relative;" />
		</td>
	</tr>
	<tr id="div_chk_sale_invoice" style="<?php if($sale_type==0){ echo "display: none;";}?>">
		<td>Have Invoice</td>
		<td>
			<input type="checkbox" name="chk_sale_invoice" id="chk_sale_invoice" value="1" style="opacity:1; position: relative;" />
		</td>
	</tr>
	<tr>
		<td width="25%">
			Find or Scan Item
		</td>
		<td>
			<input type="text" id="item" name="item"  placeholder="Enter Item SKU or Scan Barcode" data-title="Item Name" autocomplete="off" style="width: 100%;">
			<input type="hidden" name="hid_sale_type_1" id="hid_sale_type_1" value="<?php echo $stype1;?>">
		</td>
	</tr>
</form>
		</table>	
					
		
	</td>
	<td width="30%"></td>
</tr>
	
</table>
						

						
						<div class="clear"></div>
					</div>
					
				</div>
			</div>
	<div id="div_cart">
		
			<?php $this->load->view('managesales/cart_view'); ?>
	</div>
						

			<!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
				<div class="span3" style="width: 25.077%; margin-left: 0.5%;">
				<!-- Start -->
				
				<!-- End -->
				<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Customer Info.
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
					<?php
					$custInfo=$this->session->userdata('sale_customer_info');
					?>
					<div  id="div_customer_info_1" style="<?php if(isset($custInfo) && !empty($custInfo)){echo "display: none";}?>" >
						<table width="100%" style="text-align: center;">
						<tr>
							<td>

							<!-- Add Customer form/start -->
									<form style="margin: 0px;" name="customer_info_frm" id="customer_info_frm" method="post" action="<?php echo base_url();?>sales/managesales/add_sell_customer">

									<input type="text" id="customer" name="customer"  placeholder="Type customer mobile number..." data-title="Item Name" autocomplete="off">

									</form>
							<!-- Add Customer form/end -->
								
							</td>
						</tr>
						<tr>
							<td>
								<button class="btn btn-sm btn-success" id="btn_add_customer" >
								<i class="ace-icon fa fa-plus"></i>
								<span class="bigger-110 no-text-shadow">New Customer</span>
							</button>
							</td>
						</tr>
						</table>
					</div>

					<div id="div_customer_info_2">

						<?php
							$custInfo=$this->session->userdata('sale_customer_info');
							if(isset($custInfo) && !empty($custInfo)){
								//$cName=$custInfo['customer_name']."" .$custInfo['lname'];

								echo $txt='<table width="100%" style="text-align: center;">
								<tr>
									<td>
											
										<table>
											<tr><td width="50%">Name:</td><td width="50%">'.$custInfo['customer_name'].'</td></tr>
											<tr><td width="50%">Email:</td><td width="50%">'.$custInfo['customer_email'].'</td></tr>
											<tr><td width="50%">Phone:</td><td width="50%">'.$custInfo['customer_phone'].'</td></tr>
										</table>
										
									</td>
								</tr>
								<tr>
									<td>
										<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="remove_customer();">
														<i class="ace-icon fa fa-plus"></i>
														<span class="bigger-110 no-text-shadow">Remove Customer</span>
													</button>
									</td>
								</tr>
								</table>';
							}
						?>
					</div>
					</div>
					
						
					<!-- <div class="widget-toolbox padding-8 clearfix">
						<button class="btn btn-xs btn-danger pull-left">
							<i class="ace-icon fa fa-times"></i>
							<span class="bigger-110">I don't accept</span>
						</button> -->

						
					</div>
</div>
			<div class="offer_info_content">
				<div id="offer_info_1">
					<?php 

					$this->load->view('managesales/product_offer'); ?>
				</div>
				<div id="offer_info_2">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="smaller">
								Offer Info.
							</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main ">
								<div class="row-fluid" id="offer_info_load">
								<!-- <div class="form-horizontal"> -->
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>


			<div class="tax_info_content">
				<div id="tax_info_1">
					<?php 
					$this->load->view('managesales/product_tax'); ?>
				</div>
				<div id="tax_info_2">
					<div class="widget-box">
						<div class="widget-header">
							<h4 class="smaller">
								Tax Info.
							</h4>
						</div>
						<div class="widget-body">
							<div class="widget-main ">
								<div class="row-fluid" id="tax_info_load">
								<!-- <div class="form-horizontal"> -->
								</div>
							</div>
						</div>		
					</div>
				</div>
			</div>

			<div id="div_cart_total">
			
				<?php $this->load->view('managesales/cart_total'); ?>	
			</div>

				<div id="dialog-message" class="hide">
					
					<form class="form-horizontal" name="frm_add_customer" id="frm_add_customer" action="<?php echo base_url();?>sales/managesales/addNewCustomer" method="post">
			            
						<div class="control-group ">
			               <label class="control-label customer_label" for="cust_fname">First name</label>
			               <div class="controls">
			                  <input id="cust_fname" name="cust_fname" value="" type="text">
			                  <span for="name" class="help-inline cust_fname"> <?php echo form_error('cust_fname') ?> </span>
			               </div>
			            </div>
			            <div class="control-group ">
			               <label class="control-label customer_label" for="cust_lname">Last name</label>
			               <div class="controls">
			                  <input id="cust_lname" name="cust_lname" value="" type="text">
			                  <span for="name" class="help-inline cust_lname"> <?php //echo form_error('cust_lname') ?> </span>
			               </div>
			            </div>
			            <div class="control-group ">
			               <label class="control-label customer_label" for="cust_email">Email</label>
			               <div class="controls">
			                  <input id="cust_email" name="cust_email" value="" type="text">
			                  <span for="name" class="help-inline cust_email error_color"> <?php //echo form_error('cust_email') ?>  </span>
			               </div>
			            </div>
			            <div class="control-group ">
			               <label class="control-label customer_label" for="cust_phone">Phone:</label>
			               <div class="controls">
			                  <input id="cust_phone" name="cust_phone" value="" type="text">
			                  <span for="name" class="help-inline cust_phone error_color"> <?php echo form_error('cust_phone') ?> </span>
			               </div>
			            </div>
			            <div class="control-group ">
			               <label class="control-label customer_label" for="store_name">Address:</label>
			               <div class="controls">
			                  <textarea name="cust_address" id="cust_address"></textarea>
			                  <span for="name" class="help-inline cust_address error_color"> <?php //echo form_error('cust_address') ?> </span>
			               </div>
			            </div>
			            <div class="control-group ">
			               <label class="control-label customer_label" for="cust_zip">ZIP:</label>
			               <div class="controls">
			                  <input id="cust_zip" name="cust_zip" value="" type="text">
			                  <span for="name" class="help-inline cust_zip error_color"> <?php //echo form_error('cust_zip') ?> </span>
			               </div>
			            </div>
			            			
			            <div class="control-group <?php //if(form_error('store_country') != '') echo 'error'; ?>">
			               <label class="control-label customer_label" for="country">Country</label>
			               <div class="controls">
			                  <select name="store_country" id="store_country" class="countries" id="countryId">
			                     <option value="">Select Country</option>
			                  </select>
			                  <input type='hidden' id="countryid_hidden" name="countryid" value=""/>
			                  <span for="country" class="help-inline store_country error_color"> <?php //echo form_error('store_country') ?> </span>
			               </div>
			            </div>
			            <div class="control-group <?php //if(form_error('store_state') != '') echo 'error'; ?>">
			               <label class="control-label customer_label" for="state">State</label>
			               <div class="controls">
			                  <select name="store_state" id="store_state" class="states" id="stateId">
			                     <option value="">Select State</option>
			                  </select>
			                  <input type='hidden' id="stateid_hidden" name="stateid" value=""/>
			                  <span for="state" class="help-inline store_state error_color"><?php //echo form_error('store_state') ?></span>
			               </div>
			            </div>
			            <div class="control-group <?php //if(form_error('store_city') != '') echo 'error'; ?>">
			               <label class="control-label customer_label" for="city">City</label>
			               <div class="controls">
			                  <select name="store_city" id="store_city" class="cities" id="cityId">
			                     <option value="">Select City</option>
			                  </select>
			                  <input type='hidden' id="cityid_hidden" name="cityid" value=""/>
			                  <span for="city" class="help-inline store_city error_color"> <?php //echo form_error('store_city') ?> </span>
			               </div>
			            </div>
			            
			            <!--<div class="form-actions">
			               <button class="btn btn-info buttonThemeColor" type="submit">
			               <i class="icon-ok bigger-110"></i>
			               Submit
			               </button>-->
			               &nbsp; &nbsp; &nbsp;
			              
			            </div>
			         </form>
				</div><!-- #dialog-message -->
				
				</div>
				
			</div>
		</div>
	</div><!--/.row-fluid-->
<?php } ?>
</div>


<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>

</body>
</html>



<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
  <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
 

  <!-- Editable -->
<!-- <link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet"> -->
  <!--   <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>  -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

     <link href="<?php echo base_url();?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/bootstrap3-editable/js/bootstrap-editable.js"></script>
<!-- End -->
<script src="<?php echo base_url();?>assets/js/browser/browser.js"></script>


<!-- Added for add customer pop-up-Start -->
<!-- page specific plugin scripts -->
<script src="<?php echo base_url();?>assets/js/jquery-ui.min.js"></script>
<!-- Added for add customer pop-up-End -->		

<!-- Added for add customer pop-up country state dropdown - Start -->
<!-- page specific plugin scripts -->
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<!-- Added for add customer pop-up country state dropdown - End -->	
 <script>
	jQuery(document).ready(function() {
		//$('.re-print-invoice').hide();
		$('.light-blue').on('click', function() {
			var getStatus = $(this).attr('status');
			if(getStatus == 0) {
				$(this).attr('status', 1);
				$(this).addClass('open');
			} else {
				$(this).attr('status', 0);
				$(this).removeClass('open');
			}
		});
	});
</script>


<script type="text/javascript">

//$j=$.noConflict();
$.noConflict();
var submitting = false;
	jQuery(function($) {
var temp = true;
jQuery.fn.editable.defaults.mode = 'popup';     
    itemScannedSuccess();
    
/*Item Autocomplete-Start*/		
			$( "#item" ).autocomplete({
		 		source: "<?php echo base_url();?>sales/managesales/itemAutoSuggest",
				delay: 300,
		 		autoFocus: true,
		 		minLength: 0,
		 		async: true,
       			cache: false,
		 		select: function( event, ui ) 
		 		{
					$( "#item" ).val(ui.item.value);
					//alert(ui.item.value);

		 			$('#item_info_frm').ajaxSubmit({target: "#div_cart", beforeSubmit: salesBeforeSubmit, success: itemScannedSuccess, clearForm: true});

				return false;
	 		},
			}).data("ui-autocomplete")._renderItem = function (ul, item) {
		         return $("<li class='item-suggestions'></li>")
		             .data("item.autocomplete", item)
			           .append('<div class="details">' +
									'<div class="name">' + 
										item.label +
									'</div>' +
									
								'</div>')
		             .appendTo(ul);
		     };
/*Item Autocomplete-End*/		

/*Customer Autocomplete-Start*/
		     $("#customer" ).autocomplete({
		 		source: "<?php echo base_url();?>sales/managesales/customerAutoSuggest",
				delay: 150,
		 		autoFocus: false,
		 		minLength: 0,
		 		select: function( event, ui ) 
		 		{
					//alert(ui.item.value);
					
					$( "#customer" ).val(ui.item.value);

		 			$('#customer_info_frm').ajaxSubmit({success: afterCustomerAdded});

					return false;
	 		},
			}).data("ui-autocomplete")._renderItem = function (ul, item) {
				$(".ui-autocomplete").css({"overflow-x":"scroll", "height":"200px"});
		         return $("<li style='width:220px' class='item-suggestions'></li>")
		             .data("item.autocomplete", item)
			           .append('<div class="details">' +
									'<div class="name">' + 
										item.label +
									'</div>' +
									
								'</div>')
		             .appendTo(ul);
		     };

/*Customer Autocomplete-End*/



//$('#item').focus();



	$('#item').keypress(function (e) {
		if(e.which == 13) {
			//alert('ifif');

			/*$.ajax({
	            url: "<?php echo base_url();?>sales/managesales/addItemToCart",
	            type: 'post',
	            data: {
	            	chk_sri:$('#chk_sri').val(),
	            	hid_sale_type_1:$('#hid_sale_type_1').val(),
	            	chk_sale_invoice:$('#chk_sale_invoice').val(),
	            	item:$('#item').val()
	            },
	            success: function (data) {
		                $("#div_cart").html(data);
		            },
		            data: "item_id="+itm
	        });*/



			$('#item_info_frm').ajaxForm({target: "#div_cart",success: itemScannedSuccess});
			
			// Load customer info on sale return

			//$('#div_customer_info_2').html(obj.op);

			/*=================================*/
				/*var url="<?php //echo base_url();?>sales/managesales/load_sale_customer/";
					$.ajax({
					url: url,
					type:'GET',
					//data:"stype="+sType,
					success: function(data){
						$('#div_customer_info_2').html(data);

						alert(data);
					}
					});*/
			/*=================================*/
			
		}
	});




	var clear_fields = function()
	{
		if($(this).val().match("Start Typing item's name or scan barcode...|Start Typing customer's name..."))
		{
			$(this).val('');
		}
	};



	$('#item, #customer').click(clear_fields).dblclick(function(event)
	{
		//$(this).autocomplete("search");
	});


	//$('#frm_add_payment').ajaxSubmit({target: "#xvx",success: add_pay_success});

/*Add Customer Popup - Start */
$.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
	_title: function(title) {
		var $title = this.options.title || '&nbsp;'
		if( ("title_html" in this.options) && this.options.title_html == true )
			title.html($title);
		else title.text($title);
	}
}));	

$( "#btn_add_customer" ).on('click', function(e) {
	e.preventDefault();

	var dialog = $( "#dialog-message" ).removeClass('hide').dialog({
		modal: true,
		title: "<h4 class='smaller'>New Customer</h4>",
		title_html: true,
		height: 600,
		width: 530,
		buttons: [ 
			{
				text: "Cancel",
				"class" : "btn",
				click: function() {
					$( this ).dialog( "close" ); 
				} 
			},
			{
				text: "OK",
				"class" : "btn btn-primary",
				click: function() {
					//$( this ).dialog( "close" ); 
					$('#frm_add_customer').ajaxSubmit({ success: addNewCustomer});
				} 
			}
		]
	});

	/**
	dialog.data( "uiDialog" )._title = function(title) {
		title.html( this.options.title );
	};
	**/
});

function addNewCustomer(responseText, statusText, xhr, $form){
	
	var obj = jQuery.parseJSON(responseText);
	if(obj.error){
		if(obj.cust_fname!=""){
		$("#cust_fname").addClass("error");
		$(".cust_fname").html(obj.cust_fname);
		}else{$("#cust_fname").removeClass("error");}

		/*if(obj.cust_lname!=""){
		$("#cust_lname").addClass("error");
		$(".cust_lname").html(obj.cust_lname);
		}
		else{
			$("#cust_lname").removeClass("error");
		}

		if(obj.cust_email!=""){
			$("#cust_email").addClass("error");
			$(".cust_email").html(obj.cust_email);
		}
		else{
			$("#cust_email").removeClass("error");
		}*/

		if(obj.cust_phone!=""){
		$("#cust_phone").addClass("error");
		$(".cust_phone").html(obj.cust_phone);
		}else{$("#cust_phone").removeClass("error");}

		/*if(obj.store_country!=""){
		$("#store_country").addClass("error");
		$(".store_country").html(obj.store_country);
		}else{$("#store_country").removeClass("error");}

		if(obj.store_state!=""){
		$("#store_state").addClass("error");
		$(".store_state").html(obj.store_state);
		}else{$("#store_state").removeClass("error");}
		if(obj.store_city!=""){
		$("#store_city").addClass("error");
		$(".store_city").html(obj.store_city);
		}else{$("#store_city").removeClass("error");}*/

	}else{
		$('#div_customer_info_1').hide();
    	$('#div_customer_info_2').html(obj.op);
    	$('#div_customer_info_2').show();
    	$( "#dialog-message" ).dialog( "close" );
	}
}
/*Add Customer Popup - End */

/*Country state dropdown*/
$("#countryId").change(function(){
         var countryid= $('#countryId :selected').val();
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('#stateId :selected').val();
         $('#stateid_hidden').val(stateid);
      });
      
      $("#cityId").change(function(){
         var cityid= $('#cityId :selected').val();
       $('#cityid_hidden').val(cityid);
   });
/*End*/

/*
* Change Sale Type
*/
$('#sale_type').change(function(){

	var sType=$(this).val();
	$("#hid_sale_type").val(sType);
	$("#hid_sale_type_1").val(sType);
	
					var url="<?php echo base_url();?>sales/managesales/change_sale_type/";
					$.ajax({
					url: url,
					type:'GET',
					data:"stype="+sType,
					success: function(data){
						
						if(sType==1){
							$("#div_return_pay_mode").show();
							$("#div_sale_pay_mode").hide();

							/*Credit Note Check Box Hide*/
							$("#div_chk_stype").hide();
							$("#chk_sri").prop('checked', false);

							/*Credit Sale Invoice Box Show*/
							$("#div_chk_sale_invoice").show();
						}

						if(sType==0){
							$("#div_return_pay_mode").hide();
							$("#div_sale_pay_mode").show();

							/*Credit Note Check Box Show */
							$("#div_chk_stype").show();

							/*Credit Sale Invoice Box Hide*/
							$("#div_chk_sale_invoice").hide();
							$("#chk_sale_invoice").prop('checked', false);
						}

						reloadCartTotal();
					}
					});

});


				});




	function salesBeforeSubmit(formData, jqForm, options)
	{
		
		//return false;
					
	}
	

	function itemScannedSuccess(responseText, statusText, xhr, $form)
	{
				
			
		jQuery("#item").val(null);
		jQuery("#item").blur();
			

		reloadCartTotal();
		jQuery('.xeditable').editable({
			success: function(response, newValue) {
			$("#div_cart").html(response);
			reloadCartTotal();

			}
		});
    	
		setTimeout(function(){jQuery('#item').focus();}, 10);
		
		var url="<?php echo base_url();?>sales/managesales/load_sale_customer/";
					$.ajax({
					url: url,
					type:'GET',
					//data:"stype="+sType,
					success: function(data){
						if(data!=""){
							$('#div_customer_info_1').hide();
							$('#div_customer_info_2').html(data);
							$('#div_customer_info_2').show();	
						}else{
							$('#div_customer_info_1').show();
							$('#div_customer_info_2').hide();
						}
					}
					});

        var offerUrl="<?php echo base_url();?>sales/managesales/load_item_offer/";
					$.ajax({
						url: offerUrl,
						type:'GET',
						success: function(data){
						if(data!=""){
							$('#offer_info_1').hide();
							$('#offer_info_load').html(data);
							$('#offer_info_2').show();	
						}else{
							$('#offer_info_1').show();
							$('#offer_info_2').hide();
						}
					}
					});
		var fixedOffer="<?php echo base_url();?>sales/managesales/fixedOffer_discount/";
		$.ajax({
			url: fixedOffer,
			type:'GET',
			success: function(data){
				$('.fixed_offer').html(data);
			}
		})

		var taxUrl="<?php echo base_url();?>sales/managesales/load_item_tax/";
		$.ajax({
				url: taxUrl,
				type:'GET',
				success: function(data){
					//alert('load_item_tax');
				if(data!=""){
					$('#tax_info_1').hide();
					$('#tax_info_load').html(data);
					$('#tax_info_2').show();	
				}else{
					$('#tax_info_1').show();
					$('#tax_info_2').hide();
				}
			}
			});


		var reprintUrl="<?php echo base_url();?>sales/managesales/reprint_button/";
		$.ajax({
			url: reprintUrl,
			type:'GET',
			success: function(data){
				$('.reprint-td').html(data);
			}
		})

	}

	setTimeout(function(){$('#item').focus();}, 10);

	$("#btn_add_payment").click(function(){
		
	})

	function addPayment(){
		
		jQuery('#frm_add_payment').ajaxSubmit({target: "#div_cart_total", success: reloadCartTotal});
	}


	function itemScannedSuccess1(responseText, statusText, xhr, $form)
	{
				//reloadCartTotal();


				//alert(responseText);
				$("#div_cart_total").html(responseText);
		//alert(responseText);
    	//jQuery(".xeditable").editable();
    	/*reloadCartTotal();
    	jQuery('.xeditable').editable({
        	success: function(response, newValue) {
			//alert(response);
			  $("#div_cart").html(response);
			  
		}*/

    }

	

	

   function addItemToCart(itm){
    	
           //$('#target').html('sending..');
        $.ajax({
            url: "<?php echo base_url();?>sales/managesales/addItemToCart",
            type: 'post',
             success: function (data) {
             	//alert('addItemToCart');
                //$('#target').html(data.msg);

			//	$(".re-print-invoice").show();
                $("#div_cart").html(data);
            },
            data: "item_id="+itm
        });

    }

    function reloadCartTotal(responseText, statusText, xhr, $form)
    {
    	//alert(responseText);
    	
    	$.ajax({
            url: "<?php echo base_url();?>sales/managesales/reloadCartTotal",
            type: 'post',
            success: function (data) {
                //$('#target').html(data.msg);
               
              $("#div_cart_total").html(data);

              jQuery('.xeditable').editable({
        	success: function(response, newValue) {
			//alert(response);
			  //$("#div_cart").html(response);
			 reloadCartTotal();
			  
		}



    });
            }
           
        });

        


    }

    function remove_payment(type){
    	 $.ajax({
            url: "<?php echo base_url();?>sales/managesales/remove_payment",
            type: 'post',
             success: function (data) {
                //$('#target').html(data.msg);
              // alert(data);
               // $("#div_cart").html(data);
               //$("#div_cart_total").html(data);
               reloadCartTotal();
            },
            data: "pay_id="+type
        });

    }

    function afterCustomerAdded(responseText, statusText, xhr, $form){
    	//alert(responseText);
    	$('#div_customer_info_1').hide();
    	$('#div_customer_info_2').html(responseText);
    	$('#div_customer_info_2').show();
    }

    function remove_customer(){

    	 $.ajax({
            url: "<?php echo base_url();?>sales/managesales/remove_customer",
            
             success: function (data) {
             	$('#customer').val('');
               $('#div_customer_info_1').show();
    		   $('#div_customer_info_2').hide();
            },
            
        });

    }
    
</script>