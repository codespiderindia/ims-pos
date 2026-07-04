<?php $this->load->view('include/layout_header'); ?>




<?php $uinfo = $this->session->userdata('sales_session_info');?>
<style type="text/css">
	
	.error{

		border: 1px solid red !important;

	}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Department</h1>
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
				<input type="text" name="country" id="autocomplete-ajax" style="position: absolute; z-index: 2; background: transparent;"  />
					<div class="widget-main ">
					<table>
						<tr>
							<td width="100px;"> <label style="margin-top: -10px;text-align: right;ext-align: right;" >Counter : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td>
							<td width="150px;"> <label style="margin-top: -10px;margin-left: 10px;text-align: right;" >Invoice No. : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td>
							<td width="100px;"> <label style="margin-top: -10px;margin-left: 10px;margin-left: 10px; text-align: right;" >Date : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td>
							<td width="100px;"> <label style="margin-top: -10px;margin-left: 10px; text-align: right;" >Vendor : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td>
							
							
							
					</table>
					</div>
					
				</div>
			</div>
		</div>
	</div>

   <div class="row-fluid">
		<div class="span9" style="width: 79.359%;">
			<!--PAGE CONTENT BEGINS-->

			

						<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Item Information
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
						<form name="item_info_frm" id="item_info_frm" method="post" action="<?php echo base_url();?>sales/managesales/addorder">


						<table >
							
							<tr>
								
								<td width="70%">
								
									<table cellpadding="5">
							<tr>
								<td>
									<div>
								<label for="form-field-mask-2">Barcode</label>
								
								

								<input style="width: 100px;" class="form-control" id="item_bcode" name="item_bcode" type="text">
								
									</div>
								</td>
								<td>
									<div>
								<label for="form-field-mask-2">Item Code</label>
								<input style="width: 100px;" class="form-control" id="item_code" name="item_code" type="text">
									</div>
								</td>
								
								
								<td>
									<div>
										<label for="form-field-mask-2">Item Name</label>
										<input style="width: 125px;" class="form-control " id="item_name" name="item_name" type="text">
									</div>
								</td>
								<td>
									<div>
										<label for="form-field-mask-2">Quantity</label>
										<input style="width: 75px;" class="form-control " id="item_qty" name="item_qty" type="text">
									</div>
								</td>
								<td>
									<div>
										<label for="form-field-mask-2">Unit</label>
										<select style="width: 75px;" id="item_unit" name="item_unit" class="form-control ">
											<option>kg</option>
											<option>Pair</option>
										</select>
										
									</div>
								</td>
							</tr>
							</table>
							<table cellpadding="5px">
							<tr>
								<td>
									<div>
								<label for="form-field-mask-2">Rate</label>
								<input style="width: 75px;" class="form-control " id="item_rate" name="item_rate" type="text">
									</div>
								</td>
								<td>
									<div>
								<label for="form-field-mask-2">Amount</label>
								<input style="width: 75px;" class="form-control " id="item_amount" name="item_amount" type="text">
									</div>
								</td>
								
								
								<td>
									<div>
										<label for="form-field-mask-2">Discount(%)</label>
										<input style="width: 75px;" class="form-control " id="item_desc_per" name="item_desc_per" type="text">
									</div>
								</td>
								<td>
									<div>
										<label for="form-field-mask-2">Discount</label>
										<input style="width: 75px;" class="form-control" id="item_desc" name="item_desc" type="text">
									</div>
								</td>
								<td>
									<div>
										<label for="form-field-mask-2">Tax(%)</label>
										<input style="width: 75px;" class="form-control " id="item_tax_per" name="item_tax_per" type="text">
									</div>
								</td>
								<td>
									<div>
										<label for="form-field-mask-2">Tax</label>
										<input style="width: 75px;" class="form-control " id="item_tax" name="item_tax" type="text">
									</div>
								</td>
							</tr>
						</table>
								</td>
								<td width="20%">
								<table cellpadding="10">
									<tr>
										<td>

										<button id="btn_add"   style="width: 125px;">Add</button></td>

									</tr>
									<tr>
										<td><button style="width: 125px;">Update</button></td>
									</tr>
									<tr>
										<td><button style="width: 125px;" id="btn_del">Delete</button></td>
									</tr>
								</table>
								

								</td>
							</tr>
						</table>
						
						</form>

						
						<div class="clear"></div>
					</div>
					
				</div>
			</div>
						<div id="div_cart">
							
								<?php $this->load->view('managesales/cart_view'); ?>
						</div>
						
						
					
			

			<!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
		<div class="span3" style="width: 20.077%; margin-left: 0.5%;">
		<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Total
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
						
						
						<div class="row-fluid">
						<div class="span3">
							<form class="form-horizontal" action="" method="post" />
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 75px; text-align: left;">Amount</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 75px; text-align: left;">Total Tax</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 80px; text-align: left;">Bill Disc.(%)</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 75px; text-align: left;">Bill Disc.</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 80px; text-align: left;">Bill Amount</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								<div>
									<table>
										<tr>
											<td>Remark</td>
										</tr>
										<tr>
											<td>
												<textarea style="width: 175px;"></textarea>
											</td>
										</tr>
									</table>
								</div>
								<div style="border-top: 2px solid #ccc; width: 100%"></div>
						<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 80px; text-align: left;">Cash :</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>
								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 80px; text-align: left;">Card :</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="" />
										<span for="name" class="help-inline"><?php echo form_error('school_name') ?></span>
									</div>
								</div>

							</form>

						</div>
					</div>
						
					</div>
					
						
					<!-- <div class="widget-toolbox padding-8 clearfix">
						<button class="btn btn-xs btn-danger pull-left">
							<i class="ace-icon fa fa-times"></i>
							<span class="bigger-110">I don't accept</span>
						</button> -->

						
					</div>
				</div>
			</div>
				
			</div>
		</div>
	</div><!--/.row-fluid-->
</div>


<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>

</body>
</html>


<script type="text/javascript" src="<?php echo base_url();?>assets/js/autocomplete/jquery-1.8.2.min.js"></script>



<script src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
 

	<script>
	

	

    $("#btn_add").click(function() {


	$("#item_info_frm").ajaxForm({success: add_order});  
});

function add_order(responseText, statusText, xhr, $form){
	//alert(responseText);
var obj = $.parseJSON(responseText);
	
//alert(obj);

$.each( obj, function( key, value ) {
//  alert( key + ": " + value );
  $("#"+key).addClass("error");
});
	

	if(obj.item_bcode!=""){
		//$("#item_bcode").addClass("error");

		//window.location.href="<?php echo base_url();?>booking/confirm";
		//alert("sdf");
	}

	/*var obj = jQuery.parseJSON(responseText);
	if(obj.result ==='success'){
		
		window.location.href="<?php echo base_url();?>booking/confirm";
	}else{
		$('#coupon_msg_bar').html(obj.msg);
		$('#coupon_msg_bar').fadeIn().show();

	}*/
}
 // Initialize ajax autocomplete:




    
   


 
/*
   $(document).ready(function() {
$('#item_info_frm').submit(function(){

	alert("hi");
	
	$.post($('#frm').attr('action'), $('#frm').serialize(), function( data ) {
	if(data.st == 0)
		{
		 $('#validation-error').html(data.msg);
		}
				
		if(data.st == 1)
		{
		  $('#validation-error').html(data.msg);
		}
				
	}, 'json');
	return false;			
   });
});
	*/

    $("#btn_del").click(function(){alert("sdfsd");})


//Upload Gallery Image

    


</script>



<script type="text/javascript" src="<?php echo base_url();?>assets/js/autocomplete/jquery.mockjax.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/autocomplete/jquery.autocomplete.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/js/autocomplete/countries.js"></script>
<!-- <script type="text/javascript" src="<?php echo base_url();?>assets/js/autocomplete/demo.js"></script> -->
<script type="text/javascript">
	

// Initialize ajax autocomplete:
    $('#autocomplete-ajax').autocomplete({
        serviceUrl: '<?php echo base_url();?>sales/managesales/itemAutoSuggest',
        paramName: 'term',
        deferRequestBy:500,
        onSelect: function(suggestion) {
            
           
           $(this).autocomplete('close').val('');
            addItemToCart(suggestion.data);
            //$('#selction-ajax').html('You selected: ' + suggestion.value + ', ' + suggestion.data);
           // reloadCart();


        },
        onHint: function (hint) {
            $('#autocomplete-ajax-x').val(hint);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });
   function addItemToCart(itm){
    	
           //$('#target').html('sending..');
        $.ajax({
            url: "<?php echo base_url();?>sales/managesales/addItemToCart",
            type: 'post',
             success: function (data) {
                //$('#target').html(data.msg);
              // alert(data);
                $("#div_cart").html(data);
            },
            data: "item_id="+itm
        });

    }
    


/* https://www.devbridge.com/sourcery/components/jquery-autocomplete/ */
</script>