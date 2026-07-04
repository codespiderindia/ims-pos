<?php
$uInfo=$this->session->userdata('sales_session_info');

?>
<!DOCTYPE html>
<html lang="en">
<head>
		<meta charset="utf-8" />
		<title>Print Barcode</title>
		
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

        <style>
/**
*CSS for Invoice
*Start
**/
.a4-container {
	width:210mm;
	margin:0 auto;
	padding: 15px 5px;
	/*border:1px solid #ccc;
	border-radius:4px;*/
	box-shadow: 0 0 3px #ccc;
}
.a-head {
	text-align: center;
	font-size: 20px;
	margin:0 0 10px;
}
.a-table table {
	width:100%;
	border-collapse: collapse;
}
.a-table td {
	padding: 0;
	vertical-align:top;
}
.a-table p {
	margin: 0;
}
.a-main {
	border:1px solid #ccc;
}
.a-main.a-main1 td:first-child {
	padding:0 5px;
	border-bottom: 1px solid #ccc;
}
.a-main.a-main1 .a-main-in td {
    border-bottom: 1px solid #ccc;
    border-left: 1px solid #ccc;
    height: 40px;
    padding: 0 5px;
    width: 50%;
}
.a-main.a-main1 tr:last-child td:last-child .a-main-in tr:last-child td {
	height: 150px;
}
.a-main.a-main2 tr:first-child {
	border-bottom: 1px solid #ccc;
	text-align:center;
}
.a-main.a-main2 tr:first-child td, .a-main.a-main2 tr td:first-child {
	text-align:center;
}
.a-main.a-main2 tr td:nth-child(2) {
	text-align:left;
}
.a-main.a-main2 tr:first-child td {
	height: 40px;
}
.a-main.a-main2 td {
	border-right:1px solid #ccc;
	padding:0 5px;
	text-align:right;
}
.a-main.a-main2 td.ttl {
	border-top:1px solid #ccc;
	height:25px;
}
.a-main.a-main2 tr.total {
	border-top:1px solid #ccc;
	height:25px;
}
.mn-text {
	border:1px solid #ccc;
	padding:5px;
}
.mn-text p {
	font-size:15px;
	padding:0 0 5px;
}
.mn-text p span {
    float: right;
}
.mn-text2 {
	min-height:55px;
}
.mn-text2 p {
	display:inline-block;
}
.mn-text p:nth-child(2) {
	font-size:18px;
	font-weight:500;
}
.a-main td {
    height: 22px;
}
.a-main.a-main4 .a-main4-left {
	vertical-align:bottom;
	padding:5px;
}
.a-main.a-main4 .a-main4-left p:first-child {
	font-size:12px;
	text-decoration:underline;
}
.a-main.a-main4 td:nth-child(2) tr:last-child .a-main-in td {
	text-align:right;
}
.a-main.a-main4 td:nth-child(2) tr:last-child .a-main-in {
	border-top: 1px solid #ccc;
	border-left: 1px solid #ccc;
}
.a-main4-left, .a-main4-right {
	width:50%;
}
.a-main4-right .a-main-in .a-main-in tr:first-child td {
	height:50px;
}
.a-main4-right .a-main-in .a-main-in tr td {
	padding:0 5px;
}
.a-terms p {
	text-align:center;
}
.a-main.a-main3 tr td:first-child {
	border-right: 1px solid #ccc;
}
.a-main.a-main3 tr:first-child td {
	text-align: center;
}
.a-main.a-main3 tr:last-child td {
	text-align: right;
}
.a-main.a-main3 tr td:nth-child(1) {
	text-align: left;
	border-right: 1px solid #ccc;
}
.a-main.a-main3 tr td {
	text-align: right;
	border-right: 1px solid #ccc;
}
.a-main.a-main3 td {
	padding: 0 5px;
}
.a-main.a-main3 tr:nth-child(2) td {
	text-align: center;
}
.a-main.a-main3 tr:last-child td {
	text-align: right;
}
.a-main.a-main3 tr td:first-child {
	width:200px;
}
.a-main-title p {
	text-align: left;
    font-size: 18px;
    font-weight: 500;
    padding-top: 3px;
    padding-bottom: 3px;
}
.payment_content {
	font-size: 14px;
}
.pay_td {
    padding-left: 7px !important;
    font-size: 13px !important;
}
.invBarcode_label {
	width: 20%;
    float: left;
    line-height: 120px !important;
    height: 81px;
    font-size: 17px;
    font-weight: 600;
}
.productBarcode_label {
	font-size: 15px;
    font-weight: 600;
}
.barcode_img {
	width: 100%;
	height: 140px;
}
.barcode_content {
	padding-top: 10px;
    padding-bottom: 10px;
}
/**
*CSS for Invoice
*End
**/
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
						<h1 class="headingThemeColor">Print Invoice</h1>
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
							<select id="inv_print_opt">
								<option value="0">Print Option</option>
								<option value="A4">A4</option>
								<option value="A5">A5</option>
								<option value="THRML">Thermal</option>
							</select>
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
										<div class="a4-container">
											
											<div class="a-head">Product Barcode</div>
											<div class="a-table">
								<?php
									$inputLabel='';
									$inputBarcode='';
									$inputKey='';
									//$inputBatchNumber='';
									foreach($response as $key => $responses) {
										$inputLabel.=$responses['label'].',';
										$inputBarcode.=$responses['barcode'].','; 
										$inputKey.=$key.',';
										//$inputBatchNumber.=$responses['batch_number'].',';

									$label=$responses['label'];
									$barcode=$responses['barcode'];
									//$batch_number=$responses['batch_number'];
									$base64_barcode=$responses['convert_barcode'];
									
			                        $where=['sku'=>$key];
			                        $variationName=getSku('product_variations_relations',$where);
			                       
			                        $allVariationName=[];
			                        foreach($variationName as $variationNames) {
			                           $variationId=$variationNames['variation_id'];
			                           $where=['attribute_value_id'=>$variationId];
			                           $variations=getSku('attribute_value',$where);
			                           if(!empty($variations)) {
			                           		$allVariationName[]=$variations[0]['attribute_value'];
			                           }
			                        }

			                        $mergeVariationName=implode(', ',$allVariationName);
			                    ?>
			                    <h3><?php echo $mergeVariationName; ?></h3>

			
									
									<?php 
											for($i=1;$i<=$label;$i++) { ?>
<div class="barcode_content">
		<label class="productBarcode_label">Barcode <?php echo $i; ?></label>
		<img class="barcode_img" src="<?php echo base_url(); ?>barcode/sample-gd.php?code=<?php echo base64_encode($base64_barcode); ?>" width="500px" height="100px" />
	</div>
					<?php } } 	?>

			<input type="hidden" class="sku" name="sku" value="<?php echo rtrim($inputKey,','); ?>" />	
			<input type="hidden" class="qty" name="qty" value="<?php echo rtrim($inputLabel,','); ?>" />	
			<input type="hidden" class="barcode" name="barcode" value="<?php echo rtrim($inputBarcode,','); ?>" />	
			<input type="hidden" class="batch_number" name="batch_number" value="<?php //echo rtrim($inputBatchNumber,','); ?>">
												
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				

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
<script type="text/javascript">
	
$('#inv_print_opt').change(function(){

	var format_opt=$(this).val();
	var qty=$('.qty').val();
	var barcode=$('.barcode').val();
	var sku=$('.sku').val();
	var batch_number=$('.batch_number').val();
	
	var url="<?php echo base_url();?>webadmin/manageproduct/change_format/";
	$.ajax({
	url: url,
	type:'POST',
	data:"format_opt="+format_opt+"&sku="+sku+"&product_qty="+qty+"&barcode="+barcode+"&batch_number="+batch_number,
	success: function(data){
	
		$("#invoice_content").html(data);
		//alert(data);
	}
	});

});	
</script>