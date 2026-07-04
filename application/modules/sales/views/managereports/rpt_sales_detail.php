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
		<div style="text-align:center; font-weight:bold">Sales Details</div><div style="font-size: 10px; text-align: center;">(<?php echo $frmDate?> to <?php echo $toDate?>)</div>
		
	
		
		<div>
			<table style="width:100%; border-bottom:1px solid #ccc;">
				<tr style="font-weight:bold; border-bottom:1px solid #ccc;">
					<td style="padding:5px; border-bottom:1px solid #ccc">#</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Date</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Sold By</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Item Purchased</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Subtotal</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Total</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Tax</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Discount</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Payments</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Comments</td>


					
				</tr>
				
				
				<?php if(!empty($sales)) { 
					$i=1;
					foreach($sales as $sale) {  
						?>

				<tr>
					<td style="padding:5px;"><?php echo $i;?></td> 
					<td style="padding:5px;"><?php echo date("d-m-Y h:i", strtotime($sale['date_time_created']));?></td>
					<td style="padding:5px;"><?php echo $sale['sold_by'];?></td>
					<td style="padding:5px;"><?php echo $sale['itm_cnt'];?></td>
					<td style="padding:5px;"><?php echo $sale['sub_total'];?></td>
					<td style="padding:5px;"><?php echo $sale['total'];?></td>
					<td style="padding:5px;"></td>
					<td style="padding:5px;"></td>
					<td>
                                                    <?php
                        $pay_methods=$this->managereports_model->getPaymentsBySaleID($sale['sale_ID']);
                        foreach ($pay_methods as $pm) {
                            # code...
                            echo $pm['payment_method'].": ".$pm['payment_amount']."<br>";
                            
                        }
                                                ?>
                                                </td>
					<td style="padding:5px;"><?php echo $sale['remark'];?></td>

		
					 
				</tr>
					<?php $i++; } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:8px; margin-top:15px;">Date of print:<?php echo date('d/m/Y'); ?></div>
	</div><!--wrapper-->
</body>
</html>
