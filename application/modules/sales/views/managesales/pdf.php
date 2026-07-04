<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<title>Dashboard | Dealer</title>
		
		<meta name="description" content="" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0" />
		
		<!--basic styles-->
		
		<link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
		<link href="<?php echo base_url();?>/assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/font-awesome.min.css" />
		
		<!--[if IE 7]>
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/font-awesome-ie7.min.css" />
		<![endif]-->
		
		<!--page specific plugin styles-->
		
		<!--fonts-->
		<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">

		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
		
		<!--ace styles-->
		
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-skins.min.css" />
		
		<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-ie.min.css" />
		<![endif]-->
		
		<!--inline styles related to this page-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style type="text/css">
		.order_total_text {
			background-color: #438eb9;
			border: medium none;
			border-radius: 4px;
			color: #fff;
			padding: 5px 10px;
			margin-top:15px;
		}
		.control-label1 {
			float: left;
			width: 160px;
			padding-top: 5px;
			text-align: right;
		}
		.order_total_text label {
			font-size: 16px;
			font-weight: bold;
		}
		.total_price {
			font-size: 16px;
			font-weight: bold;
			margin: 5px;
		}

		</style>
		        <style type="text/css">
        @media print {
            body * {
                visibility:hidden;
            } 
            #invoice_content, #invoice_content * {
                visibility:visible;
            }
            #invoice_content { /* aligning the printable area */
                position:absolute;
                left:40;
                top:40;
            }
        }
        </style>
	</head>

	<body>
		<?php $this->load->view('include/layout_top_nav');?>

		<div class="main-container container-fluid">
			

			<?php $this->load->view('include/layout_left_nav');?>

			<div class="main-content">
				<?php $this->load->view('include/layout_breadcrumb');?>

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
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->

<div class="widget-box ui-sortable-handle">

Not to print!
	<div class="widget-header">
		<h5 class="widget-title smaller">With Label</h5>

		<div class="widget-toolbar">
			<button onclick="javascript:window.print();" class="btn btn-info" style="line-height: 20px;">
		
		<i class="ace-icon fa fa-print  align-top bigger-125 icon-on-right"></i>
		Print
	</button>
		</div>
	</div>

	<div class="widget-body">
		<div class="widget-main padding-6" id="invoice_content">
			<?php
//var_dump($sale_detail);
//var_dump($sale_items);
//var_dump($sale_payments);
			?>
		<table border="1" width="100%">
			<tr style="background: #000;">
				<td width="100%" style="color: #fff; text-align: center;"><h1><strong>INVOICE</strong></h1></td>
			</tr>
			<tr>
				<td>
					<!-- Item Info//Start -->
					
					<table border="1" width="100%" cellpadding="5px;">
						<tr align="center">
							<th width="5%">S.No</th>
							<th width="20%">Description of Goods</th>
							<th width="10%">HSN/SAC</th>
							<th width="10%">Discount(%)</th>
							<th width="10%">GST Rate</th>
							<th width="10%">Quantity</th>
							<th width="10%">Rate</th>
							<th width="10%">Unit Price</th>
							<th width="10%">Per</th>
							<th width="10%">Amount</th>
						</tr>
						<?php if(isset($sale_items) && !empty($sale_items)){ ?>
						<?php 
						$ctr=1;
						foreach($sale_items as $item){

							?>
							<tr>
							<td width="5%"><?php echo $ctr;?></td>
							<td width="20%"><?php echo $item['product_detail'];?></td>
							<td width="10%">HSN/SAC</td>
							<td width="10%" align="right"><?php echo $item['discount_per'];?></td>
							<td width="10%" align="right"><?php echo $item['tax_per'];?></td>
							<td width="10%" align="right"><?php echo $item['quantity'];?></td>
							<td width="10%" align="right"><?php echo $item['item_cost_price'];?></td>
							<td width="10%" align="right"><?php echo $item['item_unit_price'];?></td>
							<td width="10%" align="right"><?php echo $item['product_unit'];?></td>
							<td width="10%" align="right"><?php echo $item['item_subtotal'];?></td>
						</tr>
						<?php
							++$ctr;
							}
							?>
							<tr align="right">
							<td colspan="5" style="text-align: right;">Total</td>
							
							
							<td width="10%"><?php echo  $sale_detail['total_items'];?></td>
							
							<td width="10%" colspan="4"><?php echo $sale_detail['total'];?></td>
						</tr>
							<?php
							
						}
						?>

						
					</table>
					<!-- Item Info//End -->
				</td>
			</tr>
			<tr>
				<td>
					<table border="1" width="100%">
						<tr>
							<td width="60%" border="1">
									<table width="100%" >
										<tr><th width="50%">HSN/SAC</th><th>Taxable Value</th></tr>
										<?php
										$tot_tax=0;
										foreach($sale_items as $itm){
											$tot_tax+=$this->cart->get_item_tax($itm['quantity'],$itm['item_cost_price'],$itm['tax_per']);
										?>
										<tr>
										<td width="50%"><?php echo $itm['product_detail'];?></td>
										<td align="right"><?php
										echo $this->cart->get_item_tax($itm['quantity'],$itm['item_cost_price'],$itm['tax_per']);

										?></td></tr>
										<?php }?>
										<tr><td  colspan="2" align="right">Total | <?php echo $tot_tax;?></td></tr>
									</table>
									
							</td>
							
							<td width="40%"> 
								<table border="1" width="100%">
								<tr>
									<td width="50%">Central Tax</td>
									<td width="50%">State Tax</td>
								</tr>
								<tr>
									<td width="50%">
									<table>
										<tr>
											<td width="50%">
											Rate
											</td>
											<td width="50%">
												Amount
											</td>
										</tr>
									</table>
									</td>
									<td width="50%">
										<table>
										<tr>
											<td width="50%">
											Rate
											</td>
											<td width="50%">
												Amount
											</td>
										</tr>
									</table>

									</td>
								</tr>
									
								</table>
							</td>
						</tr>
						
					</table>
					<table border="1" width="100%">
						<tr>
							<td width="50%">fghfg</td>
							<td width="50%">dfg</td>
						</tr>
					</table>
				</td>
			</tr>
			
		</table>

		

		</div>
	</div>
</div>


							<!--PAGE CONTENT ENDS-->
						</div><!--/.span-->
					</div><!--/.row-fluid-->
				</div><!--/.page-content-->

				<?php $this->load->view('include/layout_ace_ctrl');?><!--/#ace-settings-container-->
			</div><!--/.main-content-->
		</div><!--/.main-container-->

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse">
			<i class="icon-double-angle-up icon-only bigger-110"></i>		</a>

		<!--basic scripts-->

		<!--[if !IE]>-->

		<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>

		<!--<![endif]-->

		<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->

		<!--[if !IE]>-->

		<script type="text/javascript">
			window.jQuery || document.write("<script src='<?php echo base_url();?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
		</script>

		<!--<![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
</script>
<![endif]-->

		<script type="text/javascript">
			if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="<?php echo base_url();?>/assets/js/bootstrap.min.js"></script>

		<!--page specific plugin scripts-->

		<!--ace scripts-->

		<script src="<?php echo base_url();?>/assets/js/ace-elements.min.js"></script>
		<script src="<?php echo base_url();?>/assets/js/ace.min.js"></script>

		<!--inline scripts related to this page-->
	</body>
</html>