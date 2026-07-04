<?php
$igst_tot_amt=0;
$sgst_tot_amt=0;
$cgst_tot_amt=0;
$ret_items_cp=$ret_items;
$uInfo=$this->session->userdata('sales_session_info');

$retInvoiceBarcode=$ret_detail['ret_invoice_number']; // Return Invoice Barcode

$cnoteNumber=$ret_credit_note[0]['cnote_number']; // Credit Note Number
$cnoteBarcode=$ret_credit_note[0]['cnote_barcode']; // Credit Note Of Barcode
?>
<style>
.a5-container {
	width:148mm;
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
.a-main.a-main3 .a-main-in td {
	border-right:1px solid #ccc;
	padding:0 5px;
	text-align:right;
}
.a-main.a-main3 td:first-child {
	border-right:1px solid #ccc;
}
.a-main.a-main3 td:first-child .a-main-in td {
	border:none;
}
.a-main.a-main3 td:first-child .a-main-in td:first-child {
	text-align:left;
}
.a-main.a-main3 td:last-child .a-main-in  tr:first-child td {
	text-align:center;
	border-bottom: 1px solid #ccc;
}
.a-main.a-main3 td:nth-child(2) .a-main-in tr:first-child td,
.a-main.a-main3 td:last-child .a-main-in tr:nth-child(2) td {
	text-align:center;
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
	text-align:left;
	font-weight: 700;
}
</style>


	<div class="a5-container">
		<div class="a-head">
			<?php echo isset($ret_store_info['comp_name']) ? $ret_store_info['comp_name'] : (isset($companyDetails) ? $companyDetails->comp_name : ''); ?>
		</div>
	<b><div class="a-head">Tax Invoice</div></b>
	<?php if(isset($companyDetails) && !empty($companyDetails)) {
		$headerDatas = $companyDetails->invoice_header;
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
		}
	} ?>
	<div class="a-table">
	 <table class="a-main a-main1">
	 
	   <tr>
	     <td colspan="4">
		   <p>Company Name : <b><?php echo isset($ret_store_info['comp_name']) ? $ret_store_info['comp_name'] : (isset($companyDetails) ? $companyDetails->comp_name : ''); ?></b></p>
		   <p>Company Address : <b><?php echo isset($ret_store_info['comp_address']) ? $ret_store_info['comp_address'] : (isset($companyDetails) ? $companyDetails->comp_address : ''); ?></b></p>
		   <p>Store Name : <?php echo $ret_store_info['store_name'];?></p>
		   <!-- <p>GST Rel 6.0 Preview</p> -->
		   <!-- <p>Madurai</p> -->
		   <p>GSTIN/UIN : <?php echo $ret_detail['store_gst_number'];?></p>
		 </td>
		 <td colspan="4">
		   <table class="a-main-in">
		     <tr>
				<td>Invoice No. <?php echo $retInvoiceBarcode;?></td>
				<td>Dated: <?php echo date("d-M-Y");?></td>
			 </tr>
			<!--<tr>
				<td>Delivery Note : Nil</td>
				<td>Mode/Terms of Payment : Nil</td>
			 </tr>
			 <tr>
				<td>Supplier's Ref. : Nil</td>
				<td>Other Reference(s) : Nil</td>
			 </tr>-->
		   </table>
		 </td>
	   </tr>
	   
	   <tr>
	     <td colspan="5">
	     <p>Customer Info.</p>
	     <?php
	     	if(isset($ret_customer) && !empty($ret_customer)){
	     		?>
					<p><b><?php echo $ret_customer['fname']." ".$ret_customer['lname'];?></b></p>
					
					<p>GSTIN/UIN : 33AAAAA1234A1Z5</p>
					<p>Place of Supply : <?php echo getStateNameByID($ret_customer['state_id']);?></p>
	     		<?php

	     	}else{
	     		?>
	     		NIL
	     		<?php
	     	}
	     ?>
		  
	     <hr>
		   <?php if(isset($companyFirmInfo) && !empty($companyFirmInfo)) { ?>
		   	<p>FirmInfo : <?php echo $companyFirmInfo->firm_name; ?></p>
		   	<p>FirmAddress : <?php echo $companyFirmInfo->firm_address; ?></p>
		   	<p>FirmTeenNumber : <?php echo $companyFirmInfo->firm_teen_num; ?></p>
		   <?php } ?>
		   
		 </td>
		 <!--<td colspan="4">
		   <table class="a-main-in">
		     <tr>
				<td>Buyer's Order No. : Nil</td>
				<td>Dated : Nil</td>
			 </tr>
			 <tr>
				<td>Despatch Document No. : Nil</td>
				<td>Delivery Note Date : Nil</td>
			 </tr>
			 <tr>
				<td>Despatched through : Nil</td>
				<td>Destination : Nil</td>
			 </tr>
			 <tr>
				<td colspan="2">Terms of Delivery : Nil</td>
			 </tr>
		   </table>
		 </td>-->
	   </tr>

	 </table>
	 
	 <table class="a-main a-main2">
	 
	   <tr>
	     <td>Sl No.</td>
		 <td>Description of Goods</td>
		 <td>HSN/SAC</td>
		 <td>GST Rate</td>
		 <td>Quantity</td>
		 <td>MRP</td>
		 <td>Unit</td>
		 <td>Amount</td>
	   </tr>
	   <?php if(isset($ret_items) && !empty($ret_items)){ ?>
						<?php 
						$ctr=1;
						foreach($ret_items as $item){
							$cgst_tot_amt= $cgst_tot_amt+$item['cgst_amt'];
							$sgst_tot_amt= $sgst_tot_amt+$item['sgst_amt'];
							$igst_tot_amt= $igst_tot_amt+$item['igst_amt'];

							?>
	   <tr>
	     <td><?php echo $ctr;?></td>
		 <td><?php echo $item['product_detail'];?></td>
		 <td>12345678</td>
		 <td><?php echo $item['tax_per'];?> %</td>
		 <td><?php echo $item['quantity'];?></td>
		 <td><?php echo $item['product_mrp'];?></td>
		 <td><?php echo $item['product_unit'];?></td>
		 <!-- <td><?php echo $item['item_subtotal'];?></td> -->
		 <td><?php echo $item['item_subtotal_without_tax_and_dis'];?></td>


	   </tr>
	   <?php ++$ctr; } ?>
	  
	   <tr>
	     <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td class="ttl"><?php echo  number_format($ret_detail['sub_total'], 2);?></td>
	   </tr>
	<?php } ?>

	   <!--<tr>
		 <td></td>
		 <td>CGST</td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td><?php echo round($cgst_tot_amt,2);?></td>
	   </tr>
	   <tr>
		 <td></td>
		 <td>SGST</td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td><?php echo round($sgst_tot_amt,2);?></td>
	   </tr>
	   <tr>
		 <td></td>
		 <td>IGST</td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td><?php echo round($igst_tot_amt,2);?></td>
	   </tr>-->
	   <tr>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
		 <td></td>
	   </tr>
	   <tr class="total">
		 <td></td>
		 <td>Total</td>
		 <td></td>
		 <td></td>
		 <td><?php echo  $ret_detail['total_items'];?> nos</td>
		 <td></td>
		 <td></td>
		 <td><b>Rs. <?php echo  $ret_detail['sub_total'];?></b></td>
	   </tr>
	   
	 </table>


	 &nbsp;
	 <table class="a-main a-main2">
	 	<tr>
	 		<td colspan="6" class="a-main-title a-main-title22" style="height:32px;"><p>Offer Detail</p></td>
	 	</tr>
	 	<tr class="payment_content" style="border-bottom: 1px solid #ccc">
	 		<td class="pay_td">Sn.</td>
	 		<td class="pay_td">Item Name</td>
	 		<td class="pay_td">Taxable Value</td>
	 		<td class="pay_td">Offer Name</td>
	 		<td class="pay_td">Discount/Free Product</td>
	 		<td class="pay_td">Amount</td>
	 	</tr>
	 	<?php if(isset($ret_items) && !empty($ret_items)){
	 		$ctr=1;
		 	$totalOffer=0;
		 	foreach($ret_items as $item){ 
		 		$offerWhere=['offer_id'=>$item['offer_id']];
					$getOffer=getSku('offer',$offerWhere);
					if(!empty($getOffer)) {
						$offerType=$getOffer[0]['percentage_or_fixed'];

						$endDate=$getOffer[0]['date_duration_end'];
						$todayDate = date('Y-m-d');

						if((date('Y-m-d', strtotime($endDate))) >= (date('Y-m-d', strtotime($todayDate)))) {

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
				 		 	<td><?php echo $ctr; ?></td>
				 		 	<td><?php echo $item['product_detail']; ?></td>
				 		 	<td><?php echo $item['item_subtotal_without_tax_and_dis']; ?></td>
				 		 	<td><?php echo $getOffer[0]['offer_name']; ?></td>
				 		 	<td><?php echo $offerType; ?></td>
				 		 	<td><?php echo $amt; ?></td>
				 		 </tr>
						<?php } } $ctr++; } ?>
	 	<tr class="total">
	 		<td></td>
	 		<td>Total</td>
	 		<td>Rs. <?php echo  $ret_detail['sub_total'];?></td>
	 		<td></td>
	 		<td></td>
	 		<td><?php echo  $totalOffer;?></td>
	 	</tr>
	 	<?php } else { ?>
	 	<tr>
	 		<td colspan="5"><?php echo 'No Offer'; ?></td>
	 	</tr>
	 	<?php } ?>
	 </table>


	  &nbsp;
	  <!--<table class="a-main a-main2">
	  	<tr>
	 		<td colspan="6" class="a-main-title a-main-title22" style="height:32px;"><p>Tax Detail</p></td>
	 	</tr>
	 	<tr class="payment_content" style="border-bottom: 1px solid #ccc">
	 		<td class="pay_td">Sn.</td>
	 		<td class="pay_td">Item Name</td>
	 		<td class="pay_td">Taxable Value</td>
	 		<td class="pay_td">Tax Name</td>
	 		<td class="pay_td">Rate</td>
	 		<td class="pay_td">Amount</td>
	 	</tr>
	 	<?php if(isset($ret_items) && !empty($ret_items)) {
	 		 $ctr=1;
	 		 $totalOffer=0;
	 		 $totalTax=$amt=0;$offerVal='';
	 		foreach($ret_items as $item) {

	 			if($item['offer_id']!='') {
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
	 	  		<td><?php 
	 	  		if($tmp==$item['product_ID']) {
	 	  		} else {
	 	  			echo $ctr;
	 	  		}
	 	  		 ?></td>
				<td><?php 
				if($tmp==$item['product_ID']) {
					echo '';
				} else {
					echo $item['product_detail'].' ('.$item['product_ID'].')';
				}
				?></td>
				<td><?php if($tmp==$item['product_ID']) {
					echo '';
				} else {
					echo $item['item_subtotal_without_tax_and_dis']; 
				}	
				?></td>
				<td><?php echo $getTaxs['tax_name']; ?></td>
				<td><?php echo $getTaxs['rate'].'%'; ?></td>
				<td><?php echo $amtval; ?></td>
			</tr>
	 	 <?php $a=$item['product_ID'];
	 	 	   $tmp=$a;
	 	} } } ++$ctr;  } ?>
	 	 <tr class="total">
	 		<td></td>
	 		<td>Total</td>
	 		<td>Rs. <?php echo  $ret_detail['sub_total'];?></td>
	 		<td></td>
	 		<td></td>
	 		<td><?php echo  $totalTax;?></td>
	 	</tr>
	 	<?php  } ?>
	  </table>-->
	  
	 
	 <div class="mn-text mn-text1">
	   <p>AmountChargeable (in words)<span>E.&O.E </span></p>
	   <p><b><?php echo ucwords(@getIndianCurrency($ret_detail['sub_total']));?></b> Only</p>
	 </div>
	 <table class="a-main a-main3">
	 <tr>
	 	<td colspan="2" style="text-align:center;">HSN/SAC</td>
	 	<td colspan="2">Taxable Value</td>
	 	<td colspan="2" style="border-bottom:1px solid #ccc">Central Tax</td>
	 	<td colspan="2" style="border-bottom:1px solid #ccc">State Tax</td>

	 	<td colspan="2" style="border-bottom:1px solid #ccc">IGST</td>
	 </tr>
	 <tr>
	 	<td colspan="2"></td>
	 	<td colspan="2"></td>
	 	<td>Rate</td>
	 	<td>Amount</td>
	 	<td>Rate</td>
	 	<td>Amount</td>
	 	<td>Rate</td>
	 	<td>Amount</td>
	 </tr>
	 	   <?php if(isset($ret_items_cp) && !empty($ret_items_cp)){ ?>
						<?php 
						$ctr=1;
						foreach($ret_items_cp as $item_cp){
							//$cgst_tot_amt= $cgst_tot_amt+$item['cgst_amt'];
							//$sgst_tot_amt= $sgst_tot_amt+$item['sgst_amt'];
							//$igst_tot_amt= $igst_tot_amt+$item['igst_amt'];

							?>
	 <tr>
	 	<td colspan="2"><?php echo $item_cp['product_detail'];?></td>
	 	<td colspan="2"><?php echo $item_cp['item_subtotal_without_tax_and_dis'];?></td>
	 	<td><?php echo $item_cp['cgst_per'];?>%</td>
	 	<td><?php echo $item_cp['cgst_amt'];?></td>
	 	<td><?php echo $item_cp['sgst_per'];?>%</td>
	 	<td><?php echo $item_cp['sgst_amt'];?></td>
	 	<td><?php echo $item_cp['igst_per'];?>%</td>
	 	<td><?php echo $item_cp['igst_amt'];?></td>
	 </tr>

	  <?php
							++$ctr;
							}
							?>
	  

	 <tr>
	 	<td colspan="2">Total</td>
	 	<td colspan="2"><?php echo  $ret_detail['sub_total'];?></td>
	 	<td></td>
	 	<td><?php echo number_format($cgst_tot_amt,2);?></td>
	 	<td></td>
	 	<td><?php echo number_format($sgst_tot_amt,2);?></td>
	 	<td></td>
	 	<td><?php echo number_format($igst_tot_amt,2);?></td>
	 </tr>
	 </table>
	 
	<?php } ?>
	 
	 
	 <div class="mn-text mn-text2">
	   <p>AmountChargeable (in words) :</p>
	   <p><b><?php echo ucwords(@getIndianCurrency($ret_detail['sub_total']));?></b> Only</p>
	 </div>
	 
	 <table class="a-main a-main4">
	 
	   <tr>
	     <td class="a-main4-left">
		   <table class="a-main-in">
		   	<tr>
		   		<div class="a-terms">
	  <p>This is a Computer Generated Invoice</p>
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
		   	</tr>
		     <!--<tr>
			   <td>
			     <p>Declaration</p>
				 <p>Lorem ipsum dolor sit amet, consectetuer <br> adipiscing elitLorem ipsum dolor sit amet,</p>
			   </td>
			 </tr>-->
		   </table>
		 </td>
		 <td class="a-main4-right">
		  <table class="a-main-in">
		     <!--<tr>
			   <td colspan="2">Company's Bank Details</td>
			 </tr>
			 <tr>
			   <td>Bank Name :</td>
			   <td>Bank Name</td>
			 </tr>
			 <tr>
			   <td>A/c No. :</td>
			   <td></td>
			 </tr>
			 <tr>
			   <td>Branch & IFS Code </td>
			   <td></td>
			 </tr>-->
			 <tr>
			   <td colspan="2">
			     <table class="a-main-in">
					 <!--<tr>
					   <td>for GST Rel 6.0 Preview</td>
					 </tr>-->
					 <tr>
					   <td>
					   			<p><?php 
		  	if(isset($uInfo['user_full_name']) && !empty($uInfo['user_full_name'])){
		  		
		  		echo $uInfo['user_full_name'];
		  	}

		  	?></p>
		  	<p> Authorised Signatory</p>

					   </td>
					 </tr>
				   </table>
			   </td>
			 </tr>
		   </table>
		 </td>
		 
	   </tr>

	 </table>
	 
	</div>

	<!-- Invoice Barcode -->
	<div>
		<label class="invretBarcode_label">Credit Note Barcode</label>
		<img src="<?php echo base_url(); ?>barcode/sample-gd.php?code=<?php echo base64_encode($cnoteNumber); ?>" width="300px" height="100px" />
	</div>
	<div>
		<label class="invretBarcode_label">Return Invoice Barcode</label>
		<img src="<?php echo base_url(); ?>barcode/sample-gd.php?code=<?php echo base64_encode($retInvoiceBarcode); ?>" width="300px" height="100px" />
	</div>
	<!-- Invoice Barcode -->
	
	

</div>