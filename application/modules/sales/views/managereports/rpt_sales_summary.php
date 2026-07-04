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
		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>		
		<div style="text-align:center; font-weight:bold">Sales Summary</div><div style="font-size: 10px; text-align: center;">(<?php echo $frmDate?> to <?php echo $toDate?>)</div>
		
	
		
		<div>
			<table style="width:100%; border-bottom:1px solid #ccc;">
				<tr style="font-weight:bold; border-bottom:1px solid #ccc;">
					<td style="padding:5px; border-bottom:1px solid #ccc">#</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Date</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Number of Sale(s)</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Subtotal</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Total</td>
					
				</tr>
				
				
				<?php if(!empty($sales)) { 
					$i=1;
					foreach($sales as $sale) {  
						?>
				<tr>
					<td style="padding:5px;"><?php echo $i;?></td> 
					<td style="padding:5px;"><?php echo $sale['sale_date'];?></td>
					<td style="padding:5px;"><?php echo $sale['no_of_sale'];?></td>
					<td style="padding:5px;"><?php echo $sale['sub_total'];?></td>
					<td style="padding:5px;"><?php echo $sale['total'];?></td>

					
					 
				</tr>
					<?php $i++; } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:8px; margin-top:15px;">Date of print:<?php echo date('d/m/Y'); ?></div>
	</div><!--wrapper-->
</body>
</html>
