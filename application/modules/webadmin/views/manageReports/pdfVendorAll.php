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
	<?php 
	   global $uInfo;
	   $uInfo=$this->session->userdata('webadmin_session_info');
	   $comp_code = $uInfo['comp_code'];
	  ?>
	<div class="wrapper">
		<div class="pdf-logo">
            <?php $getCompImg = getCompanyDetail($comp_code, 'comp_image');
             $compImg = $getCompImg[0]->comp_image;
              $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>
            <img src="<?php echo $image; ?>" width="50" /> 
          </div>

		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>
		<div style="text-align:center; font-weight:bold">Vendor LEDGER</div>
		
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
		
		<table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%;">
			<table style="width:100%; border-collapse: collapse;">
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
			<table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
				<tr style="font-weight:bold; border-bottom:1px solid #ccc;">
					<td>#</td>
					<td>Date</td>
					<td>Trans. Type</td>
					<td>Reference ID</td>
					<td>Dr. Amt</td>
					<td>Cr. Amt</td>
					<td>Bal Amt</td>
				</tr>
				
				<tr>
					<td colspan="7" style="background: #ccc;"><b>Opening Balance As On</b></td>
				</tr>
				<?php if(!empty($res)) { $ctn=1; foreach($res as $res)  {  ?>
				<tr>
					<td><?php echo $ctn; ?></td>
					<td style="padding:5px;"><?php echo $res->DocDate;?></td> <?php 
			           if($res->credit>0) {
						   $trans_type = 'INV';
					  	    $invoice_no = $res->invoice_id;
					  	} else  {
					  	    $trans_type = 'PAY';
						    $invoice_no = "By Cash";
					  	    
					    } 

					    if($res->Balance>0) {
						  	$balnce_text = 'Cr';
						} else {
						  	$balnce_text = 'Dr';
						}
					    ?>
					<td style="padding:5px;"><?php echo $trans_type;?></td>
					<td style="padding:5px;"><?php echo $invoice_no; ?></td>
					<td style="padding:5px;"><?php echo $res->debit;?></td>
					<td style="padding:5px;"><?php echo $res->credit;?></td>
					<td><?php echo $res->Balance.' '.$balnce_text; ?></td>
				</tr>
					<?php $ctn++; } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Vendor Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
