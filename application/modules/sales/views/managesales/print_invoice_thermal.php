<?php
$igst_tot_amt=0;
$sgst_tot_amt=0;
$cgst_tot_amt=0;
$sale_items_cp=$sale_items;
$uInfo=$this->session->userdata('sales_session_info');

$incoiceBarcode = $sale_detail['invoice_barcode'];
$saleId = $sale_detail['sale_ID'];
//var_dump($sale_payments);
?>
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
	border-radius:50%;
	font-size: 15px;
    padding: 10px 45px;
	/*background:#333;*/
	color:#fff;
	margin:0 0 10px;
	display:inline-block;
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
.table td, .widget-body .table {
	border-top: none !important;
}
</style>
</head>

<body>

<div class="roll-container">
  <div class="roll-top">
   	  <div class="logo">
   	    <?php 
   	    	$companyInfo = getCompanyDetail($companyID, 'comp_image');
   	    	
   	    	if(isset($companyInfo) && !empty($companyInfo)) {
   	    		$companyImage = $companyInfo[0]->comp_image;
	   	  		if($companyImage != '') {
	   	  		?>
	   	  			<img width="27px" height="27px" style="border-radius: 50px" src="<?php echo base_url() ?>uploads/company_image/<?php echo $companyImage; ?>" />
	   	  		<?php
	   	  		}
   	    	}
   	  	?>
   	 </div>
	  <div class="text"><?php if(isset($companyDetails) && !empty($companyDetails)) 
	  { $headerDatas = $companyDetails->invoice_header; 
	  					if($headerDatas != '') {
			if(strpos($headerDatas, ',')) {
	  			$headerDatasEx = explode(',',$headerDatas);
	  		} else {
	  			$headerDatasEx = $headerDatas;
	  		}

	  		if(isset($headerDatasEx) && !empty($headerDatasEx) && is_array($headerDatasEx)) { 
	  			?>
	  			<ol>
				  	<?php foreach($headerDatasEx as $headerData) { ?>
				  		<li><?php echo $headerData; ?></li>
				  	<?php } ?>
				  </ol>
	  		<?php } else { ?>
		   		<b><p><?php echo $headerDatasEx; ?></p></b>
	  		<?php }
		}} ?></div>
	  <div class="roll-ch">Cash Memo</div>
	  <div class="roll-hd">
		<div class="rl-left">
		  <p>Invoice No.: <?php echo $sale_detail['invoice_number'];?></p>
		  <?php
	     	if(isset($sale_customer) && !empty($sale_customer)){
	     		?>
					<p>To: <?php echo $sale_customer['fname']." ".$sale_customer['lname'];?></p>
				<?php
	     	}else{
	     		?>
	     		<p>To: Nil</p>
	     		<?php
	     	}
	     ?>
		</div>
		<div class="rl-right">
		  <p>Date: <?php echo date("d-M-Y");?></p>
		</div>
	  </div>
  </div>
  <div class="table table1">
  	<table>
	  <tr>
	  	<th>Sr No</th>
	    <th>Particular</th>
		<th>Qty</th>
		<th>Amount</th>
	  </tr>
	   <?php if(isset($sale_items) && !empty($sale_items)){ 
	   	
			$ctr=1;
			foreach($sale_items as $key=>$item){
				$cgst_tot_amt= $cgst_tot_amt+$item['cgst_amt'];
				$sgst_tot_amt= $sgst_tot_amt+$item['sgst_amt'];
				$igst_tot_amt= $igst_tot_amt+$item['igst_amt'];

		?>
	  <tr>
	  	<td><?php echo $ctr ; ?></td>
	    <td><?php echo $item['product_detail'];?></td>
		<td><?php echo $item['quantity'];?></td>
		<td><?php echo $item['item_subtotal_without_tax_and_dis'];?></td>
	  </tr>
	  <?php
		++$ctr;
			}
		?>
	  <tr>
	    <td><b>Total Amount</b></td>
		<td></td>
		<td></td>
		<td><?php echo  $sale_detail['sub_total'];?></td>
	  </tr>

	  <tr>
	    <td><b>Discount</b></td>
		<td></td>
		<td></td>
		<td><?php echo $sale_detail['discount_amt']; ?></td>
	  </tr>

	  <tr>
	    <td><b>Net Amount</b></td>
		<td></td>
		<td></td>
		<td><?php echo  $sale_detail['sub_total'];?></td>
	  </tr>
	  
<?php  } ?>
	</table>
  </div>

  <div class="table table1">
	 <table class="">
	 	<tr>
	 		<td colspan="5" class=""><p style="text-align:left;"><b>Offer Detail</b></p></td>
	 	</tr>
	 	<tr class="" style="">
	 		<td class=""><b>Offer Name</b></td>
	 		<td class=""><b>Discount/Free Product</b></td>
	 		<td class=""><b>Amount</b></td>
	 	</tr>
	 		<?php if(isset($sale_items) && !empty($sale_items)){
		 	$ctr=1;
		 	 $totalOffer=$amt=0;
		 	foreach($sale_items as $item){
		 		 /* Get Offer Details */
				 	$offerWhere=['offer_id'=>$item['offer_id']];
					$getOffer=getSku('offer',$offerWhere);
					if(!empty($getOffer)) {
						$offerType=$getOffer[0]['percentage_or_fixed'];

						$endDate=$getOffer[0]['date_duration_end'];
						$todayDate = date('Y-m-d');

						if((date('Y-m-d', strtotime($endDate))) > (date('Y-m-d', strtotime($todayDate)))) {

						if($offerType==1 || $offerType==2) {
							$offer=$getOffer[0]['offer_discount'];
						} else {
							$offer=$getOffer[0]['free_product'];
						}

						switch($offerType) {
							case 1: 
								$amt=round(($item['product_mrp'] * $offer)/100, 2);
								$totalOffer+=$amt;
							   $offerType=$offer.'(%)';
							   break;
							case 2:
								$amt=($item['product_mrp'] - $offer);
								$totalOffer+=$amt;
								$offerType=$offer.'(Fixed)';
								break;
							case 3:
								$amt='';
								$offerType=$offer.'(FreeProduct)';
								break;
						} ?>
						 <tr>
					 		 	<td><?php if(!empty($getOffer) ) { echo $getOffer[0]['offer_name']; } ?></td>
					 		 	<td><?php echo $offerType; ?></td>
					 		 	<td><?php echo $amt; ?></td>
					 		 </tr>
						<?php
					} }
					
				 /* END Of Offer Details */
		 		 ?>
	 		
	 	 <?php $ctr++; }   ?>
	 	 <tr class="total">
	 		<td>Total</td>
	 		<td></td>
	 		<td><?php echo  $totalOffer;?></td>
	 	</tr>
	 	 <?php } ?>
	 </table>
	</div>

	<div class="table table1">
	 <table class="">
	 	<tr>
	 		<td colspan="5" class=""><p style="text-align:left;"><b>Taxable Value</b></p></td>
	 	</tr>
	 	<tr class="" style="">
	 		<td class=""><b>Tax Name</b></td>
	 		<td class=""><b>Rate</b></td>
	 		<td class=""><b>Amount</b></td>
	 	</tr>
	 	<?php if(isset($sale_items) && !empty($sale_items)){
	 	 $ctr=1;
	 	 $totalTax=0;
	 	 $totalOffer=0;
	 	 foreach($sale_items as $item){

	 	 	$offerWhere=['offer_id'=>$item['offer_id']];
			$getOffer=getSku('offer',$offerWhere);
			if(!empty($getOffer)) {
					$offerType=$getOffer[0]['percentage_or_fixed'];

					$endDate=$getOffer[0]['date_duration_end'];
					$todayDate = date('Y-m-d');

					if((date('Y-m-d', strtotime($endDate))) > (date('Y-m-d', strtotime($todayDate)))) {

					if($offerType==1 || $offerType==2) {
						$offer=$getOffer[0]['offer_discount'];
					} else {
						$offer=$getOffer[0]['free_product'];
					}
					switch($offerType) {
						case 1: 
						   $amt=round(($item['product_mrp'] * $offer)/100, 2);
						   $offerVal = $item['product_mrp']-$amt;
						   $offerType='%(Discount)';
						   break;
						case 2:
							$amt=$offer;
							$offerVal = $item['product_mrp']-$amt;
							//$amt=$itemArr['product_mrp'] - $offer;
							$offerType='(Fixed Discount)';
							break;
						case 3:
							$amt=$item['product_mrp'];
							$offerVal = $item['product_mrp'];
							$offerType='(FreeProduct)';
							break;
					}
				}
			}


	 	 	if($item['product_tax']!='') {
	 	 	 	$explodeArray=explode(',',$item['product_tax']);
	 	 	 	$getTax=$this->managesales_model->getTaxesByTaxId($explodeArray);
	 	 	 	if(!empty($getTax)) {
	 	 	 		$taxRate=0;
					$taxName='';$taxIds='';
					$tmp='';
					foreach($getTax as $getTaxs) {
						if(isset($offerVal) && $offerVal!='') {
							$amtval=round(($offerVal * $getTaxs['rate'])/100, 2);
						} else {
							$amtval=round(($item['product_mrp'] * $getTaxs['rate'])/100, 2);
						}
					
					$totalTax+=$amtval;
	 	  	?>
	 	  <tr>
				<td><?php echo $getTaxs['tax_name']; ?></td>
				<td><?php echo $getTaxs['rate'].'%'; ?></td>
				<td><?php echo $amtval; ?></td>
			</tr>
	 	 <?php $a=$item['product_ID'];
	 	 	$tmp=$a; 
	 	  } } }  ++$ctr; } ?>

	 	 <tr class="total">
	 	 	<td>Total</td>
	 		<td></td>
	 		<td><?php echo  $totalTax;?></td>
	 	</tr>
	 	 <?php } ?>
	 </table>
  </div>

  <div class="rl-tax">
	<p><b>Total Value</b></p>
  </div>
  <div class="table table2">
    <table>
    	<tr>
    		<td>SGST</td>
    		<td><?php echo $sale_items_cp[0]['sgst_per'].'%'; ?></td>
    		<td><?php echo $sale_items_cp[0]['sgst_amt']; ?></td>
    	</tr>
    	<tr>
    		<td>CGST</td>
    		<td><?php echo $sale_items_cp[0]['cgst_per'].'%'; ?></td>
    		<td><?php echo $sale_items_cp[0]['cgst_amt']; ?></td>
    	</tr>
    	<tr>
    		<td>IGST</td>
    		<td><?php echo $sale_items_cp[0]['igst_per'].'%'; ?></td>
    		<td><?php echo $sale_items_cp[0]['igst_amt']; ?></td>
    	</tr>

    	<tr>
		    <td><b>Total Tax Value</b></td>
			<td></td>
			<td><?php echo number_format(($sale_items_cp[0]['sgst_amt']+$sale_items_cp[0]['cgst_amt']+$sale_items_cp[0]['igst_amt']),2);?></td>
	    </tr>
	 
	</table>
  </div>
  <div class="btm-roll">
    <div class="roll-hd">
		<div class="rl-left">
		  <p>
		  	<?php 
		  	if(isset($uInfo['user_full_name']) && !empty($uInfo['user_full_name'])){
		  		
		  		echo $uInfo['user_full_name'];
		  	}
		  	?>
		  	</p>
		</div>
		<div class="rl-right">
		  <p>Authorised Signatory</p>
		</div>
	</div>
	<div class="roll-hd">
		<div class="rl-left">
		  <b><p>GSTIN: <?php echo $sale_detail['store_gst_number'];?></p></b>
		</div>
		<div class="rl-right">
		  <p>E. % O.E.</p>
		</div>
	</div>
	<div class="terms">
	  <p>Terms & Cond.</p>
	  <?php //echo '<pre>';print_r($companyDetails);
	  		if(isset($companyDetails) && !empty($companyDetails)) {
	  		$footerDatas = $companyDetails->invoice_footer;

	  		if($footerDatas != '') {
	  			if(strpos($footerDatas, ',')) {
		  			$footerDataEx = explode(',',$footerDatas);
		  		} else {
		  			$footerDataEx = $footerDatas;
		  		}

		  		if(isset($footerDataEx) && !empty($footerDataEx) && is_array($footerDataEx)) { ?>
		  			<ol>
					  	<?php foreach($footerDataEx as $footerData) { ?>
					  		<li><?php echo $footerData; ?></li>
					  	<?php } ?>
					    <!--<li>Please keep bill and while changing.</li>
						<li>No Claim No Guarantee.</li>
						<li>Exchange within 10 Days Only.</li>
						<li>Goods once sold will not taken back.</li>-->
					  </ol>
		  		<?php } else { ?>
		  			<b><p><?php echo $footerDataEx; ?></p></b>
		  		<?php }
	  		}  } ?>
	</div>
	<div class="thnk">|| Thank You Visit Again ||</div>
  </div>
</div>

</body>
</html>
