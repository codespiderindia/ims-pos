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
</style>
</head>

<body>
	<div class="wrapper">
		<div style="text-align:right; font-size:14px;">04/20/2017</div>		
		<div style="text-align:center; font-weight:bold">Dealer LEDGER</div>
		
		<div>
			<table>
				<tr>
					<td><strong>From Date : </strong> 4/1/2016</td>                          
					<td style="padding-left:60px;"><strong>To Date : </strong> 3/31/2017</td>
				</tr>
			</table>
		</div>
		
		<div style="border-bottom:1px solid #ccc; border-top:1px solid #ccc; padding:5px 0px; margin-top:15px;">
			<table>
				<tr>
					<td>
						<p>Customer Group CUSEXT</p>
						
					</td> 
					
					<td style="padding-left:25px;">
						<p>External Customers</p>
						<p><b>Dealer Name : </b> <span style="text-transform:uppercase">THE COMPUTER ASSOCIATES</span></p>
					</td> 
				</tr>
			</table>
		</div>
		
		<div>
			<table style="width:100%; border-bottom:1px solid #ccc;">
				<tr style="font-weight:bold; border-bottom:1px solid #ccc;">
					<td style="padding:5px; border-bottom:1px solid #ccc">Doc Dt.</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Trans Type</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Doc Ref. No.</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Cheque/D</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Dr. Amt</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Cr. Amt</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Bal Amt</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Dr / Cr</td>
				</tr>
				
				<tr>
					<td><b>Opening Balance As On</b></td>
				</tr>
				<?php if(!empty($res)) { foreach($res as $res)  {  ?>
				<tr>
					<td style="padding:5px;"><?php echo $res->DocDate;?></td> <?php 
			           if($res->credit>0) {
					 $trans_type = 'PAY';
					  } else  {
					  $trans_type = 'INV';
					
					  } ?>
					<td style="padding:5px;"><?php echo $trans_type;?></td>
					<td style="padding:5px;"><?php echo 'DLR'.$trans_type.$res->invoice_id.'--'.$res->DocDate;?></td>
					<td style="padding:5px;"><?php echo $res->invoice_id;?></td>
					<td style="padding:5px;"></td>
					<td style="padding:5px;"><?php echo $res->debit;?></td>
					<td style="padding:5px;"><?php echo $res->credit;?></td><?php 
					  if($account->total_amount>0) {
					  
					  $balnce_text = 'Cr'; 
					  } else {
					  $balnce_text = 'Dr';
					  
					  } ?>
					<td style="padding:5px;"><?php echo $balnce_text;?></td>
				</tr>
					<?php } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Dealer Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
