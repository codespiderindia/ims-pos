
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
										<td width="50%"><label class="control-label" for="form-field-1" style="text-align: left;">Sub Total</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->total_inc_discount_tax();?></td>
									</tr>
									<tr>
										<td width="50%"><label class="control-label" for="form-field-1" style="text-align: left;">Total</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->total_inc_discount_tax();?></td>
									</tr>
								</table>
<?php 
$cart_total=$this->cart->total();
if($cart_total>0){


?>
								<table style="border-bottom: 2px solid #ccc; border-collapse: separate;width: 100%">
									<tr>
										<td width="50%"><label class="control-label" for="form-field-1" style="text-align: left;">Paid Total</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->paid_total();?></td>

									</tr>
									<tr>
										<td width="60%"><label class="control-label" for="form-field-1" style="text-align: left;">Amount Due</label></td>
										<td width="50%" style="text-align: right;"><?php echo $this->cart->amount_due();?></td>
									</tr>
								</table>
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
											<select id="pay_mode" name="pay_mode" style="width: 80px;">
												<option value="cash">Cash</option>
												<option value="dcard">Debit Card</option>
												<option value="ccard">Credit Card</option>
												<option value="check">Check</option>
											</select>
										</td>

									</tr>
									<tr>
										<td width="50%"><label style="text-align: left;">Amount Due</label></td>
										<td width="50%" style="text-align: right;">
											<input style="width: 80px;" type="text" id="pay_amount" name="pay_amount" value="<?php echo $this->cart->amount_due();?>" />
										</td>
									</tr>
								</table>
								
								<!-- <div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 100px; text-align: left;">Payment Mode</label>

									<div class="controls" style="margin-left: 105px;">
										<select id="pay_mode" name="pay_mode" style="width: 75px;">
											<option value="cash">Cash</option>
											<option value="dcard">Debit Card</option>
											<option value="ccard">Credit Card</option>
											<option value="check">Check</option>
										</select>
										
									</div>
								</div>

								<div class="control-group" style="margin-bottom: 0px;">
									<label class="control-label" for="form-field-1" style=" width: 80px; text-align: left;">Amount</label>

									<div class="controls" style="margin-left: 105px;">
										<input style="width: 75px;" type="text" id="pay_amount" name="pay_amount"/>
										
									</div>
								</div>
								 -->
								
								</form>
<!-- <button id="btn_add_payment" onclick="sayhello();">Add</button> -->
<button class="btn btn-sm btn-success" id="btn_add_payment" onclick="sayhello();">
												<i class="ace-icon fa fa-plus bigger-110"></i>
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
												<button class="btn btn-danger btn-xs" onclick="remove_payment('<?php echo $key;?>')">
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
								if($amt_due<=0){
							?>
								<div id="comment_block">
									<table width="100%">
										<tr><td style="text-align: center;">Comments</td></tr>
										<tr>
											<td>
												<textarea style="width: 190px;"></textarea>
											</td>
										</tr>
										<tr>
											<td style="text-align: right;">
												<button class="btn btn-sm btn-success">
												<i class="ace-icon fa fa-check"></i>
												<span class="bigger-110 no-text-shadow">Complete</span>
											</button>
											</td>
										</tr>
									</table>

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
	