<?php
	$slt=0;
	$st=$this->session->userdata('sale_type');
	if(isset($st)){
		$slt=$this->session->userdata('sale_type');
	}
?>



<div class="widget-box">
				<div class="widget-header">
					<h4 class="smaller">
						Total
					</h4>
				</div>

				<div class="widget-body">
					<div class="widget-main ">
                                                <?php //echo "<br>".$this->cart->total();?>

						<div class="row-fluid">
						<!-- <div class="form-horizontal"> -->
						<div>
								
								<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">

									<tr>
										<td width="50%" style="text-align: left"><label>Loyalty Point</label></td>
										<td width="50%" style="text-align: right">
										<?php

										   	echo $this->cart->get_sale_loyalty_point();
		   								?>
										</td>
									</tr>
									
									<tr>
										<td width="50%" style="text-align: left"><label class="control-label" for="form-field-1" >Discount(%)</label></td>
										<td width="50%" style="text-align: right">

										<a href="#" id="discount_sale_per" class="xeditable"  data-validate-number="true" data-placement="left" data-type="text"  data-pk="discount_per" data-name="discount_per" data-url="<?php echo base_url();?>sales/managesales/apply_percent_discount" data-title="Set Discount" data-emptytext="Set Discount" data-placeholder="Set Discount">
                                                                        
                                                <?php
                                               	echo $this->cart->get_sale_discount_per();
                                                ?>                               
                                        </a>
									</tr>
									<tr>
										<td width="50%" style="text-align: left"><label class="control-label" for="form-field-1" >Discount(Amount)</label></td>
										<td width="50%" style="text-align: right">

										<a href="#" id="discount_sale_amount" class="xeditable"  data-validate-number="true" data-placement="left" data-type="text"  data-pk="discount_amt" data-name="discount_amt" data-url="<?php echo base_url();?>sales/managesales/apply_fixed_discount" data-title="Set Discount" data-emptytext="Set Discount" data-placeholder="Set Discount">
                                                                        
                                                <?php
                                                	echo $this->cart->get_sale_discount_amount();
                                                ?>                               
                                        </a>
									</tr>
									
								</table>

								<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
									
									<tr>
									
										<td width="50%" style="text-align: left"><label class="control-label" for="form-field-1" >Sub Total</label></td>
										<td width="50%" style="text-align: right"><label class="control-label" for="form-field-1" >
										<?php //echo $this->cart->total_inc_discount_tax();
							echo $this->cart->total_inc_sale_discount();
										?>
										</label></td>
									</tr>
									
								</table>

								<!--<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
									<tr>
										<td width="50%" style="text-align: left"><label class="control-label" for="form-field-1" >Fixed Offer</label></td>
										<td width="50%" style="text-align: right"><label class="control-label fixed_offer" for="form-field-1" >
										<?php 
										/*$offerDiscount=$this->session->userdata('_offer_discount');
										echo $offerDiscount[0];*/

										//echo $this->cart->get_offerfixed_discount_amount();
										?>
										</label></td>
									</tr>
								</table>-->

								<table style="border-bottom: 2px solid #ccc; width: 100%; border-collapse: separate;">
									
									<tr>
										<td width="50%" style="text-align: center;"><label class="control-label" for="form-field-1" >Total</label></td>
										<td width="50%" style="text-align: center;"><label class="control-label" for="form-field-1" >Amount Due</td>
									</tr>
									<tr>

									<td width="50%" style="text-align: center;" class="amt-grn"><?php echo $this->cart->total_inc_sale_discount();?></td>
									
										
										<td width="50%" style="text-align: center;" class="amt-orng"><?php echo $this->cart->amount_due();?></td>
									</tr>
								</table>
<?php 
$cart_total=$this->cart->total();
if($cart_total>0){


?>
								<!-- <table style="border-bottom: 2px solid #ccc; border-collapse: separate;width: 100%">
									<tr>
										<td width="50%"><label class="control-label" for="form-field-1" style="text-align: left;">Paid Total</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->paid_total();?></td>

									</tr>
									<tr>
										<td width="60%"><label class="control-label" for="form-field-1" style="text-align: left;">Amount Due</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->amount_due();?></td>
									</tr>
								</table> -->
								<?php  }?>
								<!-- <div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 75px; text-align: left;">Amount</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="school_name" name="school_name" value="<?php echo $this->cart->total_inc_discount_tax();?>" />
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
								
								<div style="border-top: 2px solid #ccc; width: 100%"></div>-->	
								<?php if($cart_total>0){?>
								<form class="form-horizontal" method="post" name="frm_add_payment" id="frm_add_payment" action="<?php echo base_url();?>sales/managesales/add_payment">
								
								<table style="border-bottom: 2px solid #ccc; border-collapse: separate;width: 100%">
									<tr>
										<td width="60%"><label style="text-align: left;">Payment Mode</label></td>
										<td width="50%" style="text-align: right;">
											<div id="div_sale_pay_mode" style="<?php if($slt==1){ echo "display: none;";}?>">
											
											<select id="pay_mode" name="pay_mode" style="width: 94px;">
												<option value="cash">Cash</option>
												<option value="dcard">Debit Card</option>
												<option value="ccard">Credit Card</option>
												<option value="check">Cheque/Coupon</option>
											</select>
												
											</div>
											<div id="div_return_pay_mode" style="<?php if($slt==0){ echo "display: none;";}?>">
											<select id="ret_pay_mode" name="ret_pay_mode" style="width: 94px;">
												<!-- <option value="cash">Cash</option> -->
												<option value="cnote">Credit Note</option>
												
											</select>
												
											</div>
											

										</td>

									</tr>

									<tr>
										<td width="50%"><label style="text-align: left;">Amount Due</label></td>
										<td width="50%" style="text-align: right;">
											<input style="width: 80px;" type="text" id="pay_amount" name="pay_amount" value="<?php echo $this->cart->amount_due();?>" />
										</td>
									</tr>
									<tr>
										<td>
											<input type="hidden" name="hid_sale_type" id="hid_sale_type" value="<?php echo $slt;?>">
										</td>
									</tr>
								</table>
								
								
								
								</form>
<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="addPayment();">
												<i class="ace-icon fa fa-plus"></i>
												<span class="bigger-110 no-text-shadow">Add Payment</span>
											</button>


								
								<div id="pay_block_2" class="control-group">
									
									<?php
										

										
										$payData=$this->cart->pay_contents();
										if(isset($payData) && !empty($payData)){
									?>
									<table width="100%">
										<thead>
										<tr>
											<th style="text-align: center;">Delete</th>
											<th style="text-align: right;">Mode</th>
											<th style="text-align: right;">Amount</th>
										</tr>
											
										</thead>
										<tbody>
										<?php

										foreach ($payData as $key => $val) {
											# code...
										
										?>
											<tr>
											<td width="10%">
												<button class="btn btn-danger btn-minier" onclick="remove_payment('<?php echo $key;?>')">
												<i class="ace-icon fa fa-times  icon-only"></i>
											</button>
												
											</td>
											<td width="40%" style="text-align: right;">
												<?php echo $key;?>
											</td>
											<td width="50%" style="text-align: right;">
												<?php echo $val;?>
											</td>
											</tr>
											<?php
}
											?>
										</tbody>
										
									</table>
<?php }?>
								</div>
							<?php }?>
							<?php
								$amt_due=$this->cart->amount_due();
								if($cart_total>0 && $amt_due<=0){
							?>
								<div id="comment_block">
								<!-- 	<form class="form-horizontal" method="post" name="frm_complete_sale" id="frm_complete_sale" action="<?php echo base_url();?>sales/managesales/complete_sale"> -->

									<?php
										echo form_open(base_url()."sales/managesales/complete_sale", 'class="form-horizontal" method="post" name="frm_complete_sale" id="frm_complete_sale"');
									?>
									<table width="100%">
										<tr><td style="text-align: center;">Comments</td></tr>
										<tr>
											<td>
												<textarea style="width: 190px;" id="sale_comment" name="sale_comment"></textarea>
											</td>
										</tr>
										
										<tr>
											<td style="text-align: right;padding-top: 10px;">
												<button class="btn btn-sm btn-success" type="submit">
												<i class="ace-icon fa fa-check"></i>
												<span class="bigger-110 no-text-shadow">Complete</span>
												</button>
											</td>
										</tr>
									</table>
									<?php echo form_close();?>
								</div>
							<?php }?>
							

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
