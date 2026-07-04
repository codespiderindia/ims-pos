<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.wrapper{
	width:700px;
	margin:50px auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
p{
	margin:3px;
}
#store-table {
  font-size: 12px 
}
#store-table th, #store-table td{
  border:1px solid #333; 
  padding:5px;
}
.pdf-logo{
  text-align: center;
}
</style>
</head>
<body>	
		<div class="wrapper">
			<div class="pdf-logo">
            <?php $getCompImg = getCompanyDetail($comp_code, 'comp_image');
             $compImg = $getCompImg[0]->comp_image;
              $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>
            <img src="<?php echo $image; ?>" width="50" />
          </div>
          
		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y H:i:s'); ?></div> 	
		<div style="text-align:center; font-weight:bold">Cash Book LEDGER</div> 
		<div>
		<?php if(isset($fromdate)) {  ?>
			<table>
				<tr>
					<td><strong>From Date : </strong><?php echo $fromdate; ?></td>
					<td><strong>To Date : </strong> <?php echo $todate; ?></td>
				</tr> 
			</table>
			<?php } ?>
		</div>
		<div>
			<table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
				<tr">
					<th>Doc Dt.</th>
					<th>Trans No.</th>
					<th>Mode Of Payment</th>
					<th>Dr. Amt</th>
					<th>Cr. Amt</th>
					<th>Pay By</th>
					<th>Bal Amt</th>
				</tr>
				
				<tr>
					<td colspan="9" style="background: #ccc;"><b>Opening Balance As On</b></td>
				</tr>
				<?php if(!empty($res)) { 
					$i=1;
				 foreach($res as $res) {
				 		if($res->dealer_vender_other=='1') {
							$from = 'Dealer';
						}
						if($res->dealer_vender_other=='2') {
							$from = 'Vendor';
						}
						if($res->dealer_vender_other=='3') {
							$from = 'Other';
						}

						$getExpense = getSku('expense',['comp_code'=>$comp_code]); 
						$expense = $getExpense[0]['total'];

						if($res->total_balance>=0) {
						 $balancetxt = "Cr"; } 
						 else {
						  $balancetxt = "Dr";  }
				  ?>
				<tr>
					<td><?php echo $res->Date; ?></td>
					<td><?php echo $res->TransNo; ?></td>
					<td><?php echo $res->mode_of_payment; ?></td>
					<td><?php echo $res->debit; ?></td>
					<td><?php echo $res->credit; ?></td>
					<th><?php echo $from; ?></th>
					<td><?php echo $res->total_balance.' '.$balancetxt; ?></td>
				</tr>
				<?php $i++; } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Cash Book Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
