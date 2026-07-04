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
            <?php 
            $getCompImg = getCompanyDetail($comp_code, 'comp_image');
             $compImg = $getCompImg[0]->comp_image;
              $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>
            <img src="<?php echo $image; ?>" width="50" />
          </div>

		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y H:i:s'); ?></div>		
		<div style="text-align:center; font-weight:bold">Daily Sale Report</div>
		
		<div>
		<?php if(isset($fromdate)) {  ?>
			<table>
				<tr>
					<td><strong>From Date : </strong> <?php echo  $fromdate;?></td>                          
					<td style="padding-left:60px;"><strong>To Date : </strong> <?php echo  $todate;?></td>
				</tr>
			</table>
			<?php } ?>
		</div>
		
		<div style="border-bottom:1px solid #ccc; border-top:1px solid #ccc; padding:5px 0px; margin-top:15px;">
		</div>
		
		<div>
			<table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
				<thead>
					<tr style="font-weight:bold;">
                        <th>#</th>
                        <th>Store Name</th>
                        <th>Payment Method</th>
                        <th>Credit Note</th>
                        <th class="amount">Amount</th>
            		</tr>
				</thead>
				<tbody>
					<?php if(isset($sale) && !empty($sale)) {
						$k=1; $sum=0;
						foreach($sale as $sales) { ?>
							<tr>
								<td><?php echo $k; ?></td>
								<td><?php $storeDetail=store_details_by_id($sales['store_id']);
                            echo $storeDetail[0]['store_name']; ?></td>
	                            <td>
	                            Cash: <?php echo (isset($sales['cash']) && $sales['cash'] != '') ? $sales['cash'] : '-' ; ?></br>
	                            Debit Card: <?php echo (isset($sales['dcard']) && $sales['dcard'] != '') ? $sales['dcard'] : '-' ; ?></br>
	                            Credit Card: <?php echo (isset($sales['ccredit']) && $sales['ccredit'] != '') ? $sales['ccredit'] : '-' ; ?></br>
	                            Check: <?php echo (isset($sales['check']) && $sales['check'] != '') ? $sales['check'] : '-' ; ?></br>
	                        </td>
	                        <td><?php echo (isset($sales['creditNote']) && $sales['creditNote'] != '') ? $sales['creditNote'] : '-' ; ?></td>
                        <td class="amount"><?php echo $sales['total']; ?></td>
							</tr>
						<?php $k++;   $sum+=$sales['total']; } ?>
						<tr class="grand_total">
		                    <td></td>
		                    <td>Grand Total</td>
		                    <td></td>
		                    <td></td>
		                    <td class="amount"><?php 
		                      if(is_float($sum)==true){
		                        echo $sum;
		                      } else {
		                        echo $sum.'.00';
		                    } ?></td>
                    	</tr>
					<?php } else { ?>
                        <tr><td colspan="8"><?php echo 'No Record Found'; ?></td></tr>
                    <?php } ?>
				</tbody>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Vendor Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
