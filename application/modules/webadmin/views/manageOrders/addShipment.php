<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

<style>
   /*.transfermenu{
   margin-top:50px;
   }*/
   .transfermenu ul{
   list-style:none;
   margin-left:0px!important;
   }
   .transfermenu ul li {
   border: 1px solid #ccc;
   float: left;
   margin-bottom: 20px !important;
   margin-right: 50px;
   padding: 10px;
   width: 240px;
   position:relative;
   }
   .transfermenu ul li ul li{
   margin-left:0px;
   margin-top: 10px;
   display:block;
   border:none;
   padding:0;
   }
   /*.transfermenu ul li:hover ul{
   display:block;
   }*/
   .transfermenu ul li ul li{
   float:none;
   }
   .transfermenu input{
   opacity:1;
   }
   .product_in_warehouse{
   height:25px!important;
   width:15px!important;
   }
   .product_list .checkbox >input{
   opacity:1!important;
   }
   .product_lbl{
   font-weight:bold;
   font-size: 16px;
   }
   .quantity_input{
   width:auto;
   }
   .stock-help-inline{
   position:absolute;
   left:20%;
   color:red;
   }
   .help-inline{
   color:red;
   }
   .form-horizontal .controls {
    display: inline-block;
    margin-left: 20px;
	}
	.controls .help-inline {
		display: block;
		width: auto;
	}
</style>


<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            
			reset_otp('user_id',)
			</small>-->
			
      </h1>
	  
	  <?php
         if ($this->session->flashdata('error_msg')):
         ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php
            echo $this->session->flashdata('error_msg');
            ?> <br />
      </div>
      <?php
         endif;
         ?>
      <?php
         if ($this->session->flashdata('success_msg')):
         ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php
            echo $this->session->flashdata('success_msg');
            ?> </p>
      </div>
      <?php
         endif;
         ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" id="frm-shipment-order" action="" method="post">
			
			<div class="control-group product_list <?php if(form_error('product_list') != '') echo 'error'; ?>">
			   <label class="control-label" for="role"> </label>
			   <div class="controls product_select">
				 <div class="transfermenu"> 
            <ul>
						 <?php 				
						 $getOrderByOrderId = getOrderByOrderId($order_id); ?>

						<?php $product_count = count($getOrderByOrderId);
						 if(isset($getOrderByOrderId) && !empty($getOrderByOrderId)){
							 foreach($getOrderByOrderId as $productIdName1){

                $where=['order_id'=>$order_id, 'product_id'=>$productIdName1->product_id];
               // $getShipmentData=getSku('order_shipment_detail',$where);

						 ?>
              <input type="hidden" name="master_product_id[<?php echo $productIdName1->product_id; ?>]" value="<?php echo $productIdName1->master_product_id; ?>"/>

						<input type="hidden" name="product_count" value="<?php echo $product_count;?>"/>
						<li id="li_<?php echo $productIdName1->product_id; ?>">
                           <p class="product_lbl"><?php echo product_name($productIdName1->master_product_id).' ('.$productIdName1->product_id.')';?></p>
						   <ul class="order_qty_container" attrsku="<?php echo $productIdName1->product_id; ?>" id="quantity_<?php echo $productIdName1->product_id; ?>">
							  <li>
                  <?php //echo $shipment_qty[$productIdName1->product_id]; ?>
								<span>Orders</span> :   
                  <?php $orderQty = $productIdName1->quantity .'</br>';
                  if(isset($shipment_qty)) {

                   $shipmentQty = $shipment_qty[$productIdName1->product_id];
                  } else {
                    $shipmentQty = 0;
                  }
                 
                  $remainingQty = $orderQty-$shipmentQty;
               
                   ?>
									<span id="stock_<?php echo $productIdName1->product_id; ?>" style="color:red"> <?php echo $orderQty;?></span>

                <span>Shipped</span> :
							       <span id="shipped_<?php echo $productIdName1->product_id; ?>" style="color:red"> <?php echo $shipmentQty;?></span>

                <span>Remaining</span> :
                    <span id="remaining_<?php echo $productIdName1->product_id; ?>" style="color:red"> <?php echo $remainingQty;?></span>
                      <br>
								<span>Quantity</span>
									
								<span class="qty_keypress">
								<input class="quantity_input quantity_keypress" id="quantity_keypress_<?php echo $productIdName1->product_id; ?>" type="text"  name="quantity[<?php echo $productIdName1->product_id; ?>]" value="" />
								</span> 
								<br>
								<span for="name" class="stock-help-inline quantity_val_error_<?php echo $productIdName1->product_id;?>">  </span>
								
							  </li>
						   </ul>
						</li>						
						<?php } // end foreach
						 } // end if condition 
						?>
					</ul>
				  </div>
			   </div>
			</div>
			
			<div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
            <label class="control-label" for="chalan_number">Customer Shipping Address Notes</label>
            <div class="controls">
		      <?php   ?>
               <p><?php  echo get_cust_notes($order_id); ?></p>
               <span for="address" class="help-inline"> <?php echo form_error('address') ?> </span>
            </div>
			</div>
			
			<div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="chalan_number">Address</label>
               <div class="controls">
                  <textarea class="address" id="address" name="address"><?php echo set_value('address') ?></textarea>
                  <span for="address" class="help-inline address_error"> <?php echo form_error('address') ?> </span>
               </div>
			</div>
			
			<div class="control-group <?php if(form_error('shipment_status') != '') echo 'error'; ?>">
            <label class="control-label" for="status">Shipment Status</label>
            <div class="controls">
               <select name="shipment_status" class="status" id="shipment_status">
                  <option value="">Select</option>
                  <option value="1">Pending</option>
                  <option value="2">Processing</option>
                  <option value="3">Shipped</option>
               </select>
               <span for="shipment_status" class="help-inline shipment_status_error"> <?php echo form_error('shipment_status') ?> </span>
            </div>
         </div>

         <div class="control-group <?php if(form_error('lr_number') != '') echo 'error'; ?>">
             <label class="control-label" for="status">LR Number</label>
             <div class="controls">
               <input type="text" name="lr_number" id="lr_number" value="<?php echo set_value('lr_number'); ?>" />
               <span for="lr_number" class="help-inline lr_number_error"> <?php echo form_error('lr_number') ?> </span>
             </div>
         </div>


          <div class="control-group <?php if(form_error('lr_date') != '') echo 'error'; ?>">
             <label class="control-label" for="status">LR Date</label>
             <div class="controls">
               <input type="text" name="lr_date" id="lr_date" value="<?php echo set_value('lr_date'); ?>" />
               <span for="lr_date" class="help-inline lr_date_error"> <?php echo form_error('lr_date') ?> </span>
             </div>
         </div>




            <div class="control-group <?php if(form_error('remark') != '') echo 'error'; ?>">
               <label class="control-label" for="comments">Remarks</label>
               <div class="controls">
                  <textarea id="remark" name="remark"><?php echo set_value('remark'); ?></textarea>
                  <span for="remark" class="help-inline"> <?php echo form_error('remark') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor transfer" type="button">
               <i class="icon-ok bigger-110"></i>
               Transfer
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
<!--inline scripts related to this page-->
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>-->

<script>
   $(document).ready(function(){
      $('#lr_date').datepicker({
         dateFormat: 'dd/mm/yy',
         minDate: new Date()
      });

      $('.order_qty_container').each(function() {
        var sku = $(this).attr('attrsku');

        var remainingstockval = $('#remaining_'+sku).text();
        if(remainingstockval<=0) {
          $('#quantity_keypress_'+sku).attr('disabled','disabled');
        }

        var stockval = $('#stock_'+sku).text();
        $.ajax({
          url: "<?php echo base_url(); ?>webadmin/manageorders/checkStock/",
          type: "post",
          data: {product_id:sku},
          success: function (response) {
            if(response <= 0) {
              $('.quantity_val_error_'+sku).text('Out Of Stock.');
              $('#quantity_keypress_'+sku).attr('disabled','disabled');
            }
          }
        });

      });


   	//called when key is pressed in textbox
	  $(".quantity_input").keyup(function (e) {
		 //if the letter is not digit then display error and don't type anything
		
		 var this_id =   $(this).attr('id');
     this_ids =  this_id.split('quantity_keypress_');
     var p_id = this_ids[1];
     var qty1 = $(this).val();
    
     if(qty1 != '') {
        if(!$.isNumeric(qty1)) {
          $('.quantity_val_error_'+p_id).html('Please Enter Digit Only !!');
          $('.quantity_val_error_'+p_id).show();
          return false;
       } 
     } else {
          $('.quantity_val_error_'+p_id).html('');
          $('.quantity_val_error_'+p_id).hide();
          return false;
       }
    

   /* if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
			//display error message
		   alert("Digits Only");
		}*/
 var qty = parseInt($(this).val());
		var stockVal;
 		$.ajax({
        url: "<?php echo base_url(); ?>webadmin/manageorders/checkStock/",
        type: "post",
        data: {product_id:p_id,qty:qty},
        success: function (response) {
		var avail_stock =  parseInt(response);

    var orderqty = $('#stock_'+p_id).text();
		
		if(avail_stock>=qty) {
  		$('.quantity_val_error_'+p_id).html('');
  		$('.quantity_val_error_'+p_id).hide();
  		var submit_frm = true;
		} else {
        if(avail_stock<=0) {
            stockVal = 0;
          } else {
            stockVal = avail_stock;
          }
          $('.quantity_val_error_'+p_id).html('Available stock is only '+stockVal);
          $('.quantity_val_error_'+p_id).show();
          var submit_frm = false;
          return false;

      /*if(orderqty>qty) {
          
      } else {
        $('.quantity_val_error_'+p_id).html('Your order quantity is more than order');
          $('.quantity_val_error_'+p_id).show();
          var submit_frm = false;
          return false;
      }*/
     
		} 
        },
        error: function(jqXHR, textStatus, errorThrown) {
           console.log(textStatus, errorThrown);
        }


    });
		
		});
		
   	    //form validation
        $( ".transfer" ).on("click",function() {
          var only_alpha_space = /^[a-zA-Z-,]+(\s{0,1}[a-zA-Z-, ])*$/;
			    var error_count = 0;		
			
    			$('.product_list ul li ul').each(function(){

            var attrdisabled = $(this).attr('disabled');

           //if (typeof attr !== typeof undefined && attr !== false) {
            
                var product_list =  $(this).attr('id');
                var product_id = product_list.replace('quantity_','');
                var quantity_val = $('#quantity_keypress_'+product_id).val();

                var orderqty = $('#stock_'+product_id).text();

                if(quantity_val==""){
                  
                  $(".quantity_val_error_"+product_id).text("Please Enter Quantity value");
                  error_count++;
                } else if(parseInt(quantity_val) > parseInt(orderqty)) {
                  
                   $(".quantity_val_error_"+product_id).text("Please Check Quantity");
                  error_count++;
                }else {
                  // hide message
                  $(".quantity_val_error_"+product_id).empty();
                }
            //} 
    			});


         /* $('.order_qty_container').each(function() {
              var sku = $(this).attr('attrsku');
              var orderqty = $('#stock_'+sku).text();
              var shipmentqty = $('#quantity_keypress_'+sku).val();
              if(shipmentqty>orderqty) {
                $(".quantity_val_error_"+sku).text("Your order quantity is more than order.");
                  error_count++;
              } else {
                  // hide message
                  $(".quantity_val_error_"+sku).empty();
                }
          });*/


         var address = $('#address').val();
         if(address=="") {
            $(".address_error").text("Please Enter Address.");
            error_count++;
         }  /*else if (!address.match(only_alpha_space)) {
            $(".address_error").text("Allow only letters and space.");
            error_count++;
         }*/ else {
            $(".address_error").empty();
         }

			var shipment_status =  $('#shipment_status').val();
			   if(shipment_status=="")
			   {
				//alert("Please enter p name");
				$(".shipment_status_error").text("Please select Shipment Status.");
				error_count++;
			   }
			   else {
				 // hide message
				 $(".shipment_status_error").empty();
				}

         var lr_number = $('#lr_number').val();
         if(lr_number=="")
         {
            $(".lr_number_error").text("Please Enter LR Number.");
            error_count++;
         } else if(!$.isNumeric(lr_number)) {
             $(".lr_number_error").text("Please Enter Numeric Number.");
             error_count++;
         } else {
            $(".lr_number_error").empty();
         }

         var lr_date = $('#lr_date').val();
         if(lr_date=="")
         {
            $(".lr_date_error").text("Please Enter LR Number.");
            error_count++;
         } else {
            $(".lr_date_error").empty();
         }

			if(error_count>0){  
				alert("Please Fill All Required Fields");
				return false;  
   	  		} else {
			$('#frm-shipment-order').submit();
			}
        });
   });
   				   
</script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
</body>
</html>