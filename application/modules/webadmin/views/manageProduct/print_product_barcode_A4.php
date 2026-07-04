
<style type="text/css">
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

	<div class="a4-container">
		<div class="a-head">Product Barcode</div>
			<div class="a-table">
			<?php 
			$inputLabel='';
			$inputBarcode='';
			$inputKey='';
			for($i=0;$i<count($sku);$i++) {

				$inputKey.=$sku[$i].',';
				$inputLabel.=$label[$i].',';
				$inputBarcode.=$barcode[$i].','; 
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