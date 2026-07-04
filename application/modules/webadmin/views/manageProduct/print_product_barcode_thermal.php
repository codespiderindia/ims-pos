<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>

<style>
.roll-container {
	width:230px;
	margin:0 auto;
	padding:15px 5px;
	border:1px solid #ccc;
	border-radius:4px;
}
.roll-container p {
	margin:0;
}
.table table {
	width:100%;
}
.table {
	margin:0 0 10px;
}
.roll-top {
	text-align:center;
	font-size:12px;
}
.logo {
  background: #333333 none repeat scroll 0 0;
  border-radius: 50%;
  color: #ffffff;
  display: inline-block;
  font-size: 15px;
  height: 80px;
  line-height: 75px;
  margin: 0 0 10px;
  width: 80px;
}
.text {
	margin:0 0 5px;
}
.roll-ch {
	font-size:13px;
	margin:0 0 5px;
}
.roll-hd {
	display:inline-block;
	width:100%;
	margin:0 0 5px;
}
.rl-left {
	float:left;
	text-align:left;
}
.rl-right {
	float:right;
	text-align:right;
}
.table {
	text-align:left;
	width:100%;
}
.table th:first-child, .table td:first-child {
	text-align:left;
}
.table th, .table td {
	text-align:center;
	font-size:9px !important;
	padding: 0px !important;
}

.table th:last-child, .table td:last-child {
	text-align:right;
}
.rl-tax, .btm-roll {
	font-size:12px;
}
.terms ol {
	margin:0;
	padding-left: 20px;
}
.thnk {
	margin:8px 0;
	text-align:center;
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
</style>

</head>

<body>

<div class="roll-container">
  <div class="roll-top">
   	  <div class="logo">LOGO</div>
	  <div class="text">Lorem ipsum dolor sit amet, consectetuer adipiscing elit</div>
	  <div class="roll-ch">Product Barcode</div>
	  <div class="roll-hd">
		<?php 
			$inputLabel='';
			$inputBarcode='';
			$inputKey='';	
			for($i=0;$i<count($sku);$i++) {
				$inputKey.=$sku[$i].',';
				$inputBarcode.=$barcode[$i].','; 
				$inputLabel.=$label[$i].',';
				$inputBatchNumber.=$batch_number[$i].',';

				$barcodeName=$barcode[$i].'-'.$batch_number[$i];

				$where=['sku'=>$sku[$i]];
		        $variationName=getSku('product_variations_relations',$where);
		       
		        $allVariationName=[];
		        foreach($variationName as $variationNames) {
		           $variationId=$variationNames['variation_id'];
		           $where=['attribute_value_id'=>$variationId];
		           $variations=getSku('attribute_value',$where);
		           $allVariationName[]=$variations[0]['attribute_value'];
		        }

		        $mergeVariationName=implode(', ',$allVariationName); ?>

		        <h3><?php echo $mergeVariationName; ?></h3>
				<?php for($j=1;$j<=$label[$i];$j++) { ?>
				<div class="barcode_content">
					<label class="productBarcode_label">Barcode <?php echo $j; ?></label>
					<img class="barcode_img" src="<?php echo base_url(); ?>barcode/sample-gd.php?code=<?php echo base64_encode($barcodeName); ?>" width="500px" height="100px" />
				</div>
			<?php } } ?>
			<input type="hidden" class="sku" name="sku" value="<?php echo rtrim($inputKey,','); ?>" />	
			<input type="hidden" class="qty" name="qty" value="<?php echo rtrim($inputLabel,','); ?>" />	
			<input type="hidden" class="barcode" name="barcode" value="<?php echo rtrim($inputBarcode,','); ?>" />	
			<input type="hidden" class="batch_number" name="batch_number" value="<?php echo rtrim($inputBatchNumber,','); ?>">
	  </div>
  </div>
  
  <div class="btm-roll">
	<div class="thnk">|| Thank You Visit Again ||</div>
  </div>
</div>

</body>
</html>
