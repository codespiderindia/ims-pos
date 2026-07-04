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
	</head>

	<body>
		<?php $this->load->view('include/layout_top_nav');?>

		<div class="main-container container-fluid">
			

			<?php $this->load->view('include/layout_left_nav');?>

			<div class="main-content">
				<?php $this->load->view('include/layout_breadcrumb');?>

				<div class="page-content">
					<div class="row-fluid">
						<div class="span12">
							<!--PAGE CONTENT BEGINS-->

						Main Admin Dashboard
						<?php $uInfo=$this->session->userdata('mainadmin_session_info');
						print_r($uInfo['username']);
						//echo CI_VERSION;
						?>

						<?php
				/*		if(isset($creditDealerDetails) && !empty($creditDealerDetails)){
							//echo 'Credit Amount '.$creditDealerDetails->dealer_credit_limits;
							//echo '<br>';
							//echo 'Credit Limit Days '.$creditDealerDetails->number_of_days;
						?>
					   <div class="control-group order_total_text">
					   <label class="control-label1">Credit Amount </label>
					   <div class="controls">
						   <!-- "order Total" Display  -->
							<p class="total_price"><?php echo '&nbsp;'.number_format($creditDealerDetails->dealer_credit_limits,2); ?> &#8360;</p>
					   </div>
					   </div>
            			<?php } */ ?> 


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