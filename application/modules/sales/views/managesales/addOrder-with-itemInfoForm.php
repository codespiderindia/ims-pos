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
				
					<div class="widget-main ">
					<table>
						<tr>
							<td width="100px;"> <label style="margin-top: -10px;text-align: right;ext-align: right;" >Counter : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td>
							<!-- <td width="150px;"> <label style="margin-top: -10px;margin-left: 10px;text-align: right;" >Invoice No. : &nbsp;</label> </td>
							<td><input type="text" placeholder="Type something…" style="width: 75px;"></td> -->
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
						<form name="item_info_frm" id="item_info_frm" method="post" action="<?php echo base_url();?>sales/managesales/addItemToCart">

<input type="text" id="item" name="item"  placeholder="Enter item name or scan barcode" data-title="Item Name" autocomplete="off">
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
								<!-- <table cellpadding="10">
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
								</table> -->
								

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
					<div id="div_cart_total">
					
						<?php $this->load->view('managesales/cart_total'); ?>	
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



<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
  <script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
  <!-- Editable -->
<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
  <!--   <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script>  -->
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

     <link href="<?php echo base_url();?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/bootstrap3-editable/js/bootstrap-editable.js"></script>
<!-- End -->
<script type="text/javascript">
var matched, browser;

jQuery.uaMatch = function( ua ) {
    ua = ua.toLowerCase();

    var match = /(chrome)[ \/]([\w.]+)/.exec( ua ) ||
        /(webkit)[ \/]([\w.]+)/.exec( ua ) ||
        /(opera)(?:.*version|)[ \/]([\w.]+)/.exec( ua ) ||
        /(msie) ([\w.]+)/.exec( ua ) ||
        ua.indexOf("compatible") < 0 && /(mozilla)(?:.*? rv:([\w.]+)|)/.exec( ua ) ||
        [];

    return {
        browser: match[ 1 ] || "",
        version: match[ 2 ] || "0"
    };
};

matched = jQuery.uaMatch( navigator.userAgent );
browser = {};

if ( matched.browser ) {
    browser[ matched.browser ] = true;
    browser.version = matched.version;
}

// Chrome is Webkit, but Webkit is also Safari.
if ( browser.chrome ) {
    browser.webkit = true;
} else if ( browser.webkit ) {
    browser.safari = true;
}

jQuery.browser = browser;
//$j=$.noConflict();
$.noConflict();
var submitting = false;
	jQuery(function($) {
var temp = true;
$.fn.editable.defaults.mode = 'popup';     
    itemScannedSuccess();
   
		
				$( "#item" ).autocomplete({
		 		source: "<?php echo base_url();?>sales/managesales/itemAutoSuggest",
				delay: 150,
		 		autoFocus: false,
		 		minLength: 0,
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





//$('#item').focus();


	$('#item').keypress(function (e) {
		if(e.which == 13) {
			$('#item_info_frm').ajaxSubmit({target: "#div_cart",success: itemScannedSuccess, clearForm: true});
			
			//return false;
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




				});


function add_order(responseText, statusText, xhr, $form){
	//alert(responseText);
var obj = $.parseJSON(responseText);
	
//alert(obj);

$.each( obj, function( key, value ) {
//  alert( key + ": " + value );
  $("#"+key).addClass("error");
});
	

	
	
}

	function salesBeforeSubmit(formData, jqForm, options)
	{
		
		//return false;
					
	}
	

	function itemScannedSuccess(responseText, statusText, xhr, $form)
	{
				
		//alert(responseText);
    	//jQuery(".xeditable").editable();
    	reloadCartTotal();
    	jQuery('.xeditable').editable({
        	success: function(response, newValue) {
			//alert(response);
			  $("#div_cart").html(response);
			  
		}
    });

		setTimeout(function(){$('#item').focus();}, 10);
		
		
	}

	setTimeout(function(){$('#item').focus();}, 10);

	$("#btn_add_payment").click(function(){
		alert('sdf');
	})

	function sayhello(){
		//alert('sdfsdf');
		jQuery('#frm_add_payment').ajaxSubmit({target: "#div_cart_total", success: itemScannedSuccess1});
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
</script>



 

	<script>
	


   
 




    
   


 
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

     //autocomplete
				 

	


</script>




<script type="text/javascript">
	

// Initialize ajax autocomplete:
   /* $('#autocomplete-ajax').autocomplete({
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
    });*/
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

    function reloadCartTotal(){
    	$.ajax({
            url: "<?php echo base_url();?>sales/managesales/reloadCartTotal",
            type: 'post',
            success: function (data) {
                //$('#target').html(data.msg);
              // alert(data);
              $("#div_cart_total").html(data);
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
               $("#div_cart_total").html(data);
            },
            data: "pay_id="+type
        });

    }
    

 // Initialize ajax autocomplete:

/* https://www.devbridge.com/sourcery/components/jquery-autocomplete/ */
</script>