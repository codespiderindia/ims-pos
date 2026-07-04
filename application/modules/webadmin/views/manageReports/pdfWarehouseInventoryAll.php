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

		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>		
		<div style="text-align:center; font-weight:bold">Vendor LEDGER</div>
		
		<div>
		<?php if(isset($fromdate)) {  ?>
			 <table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
				<tr>
					<td><strong>From Date : </strong> <?php echo  $fromdate;?></td>                          
					<td style="padding-left:60px;"><strong>To Date : </strong> <?php echo  $todate;?></td>
				</tr>
			</table>
			<?php } ?>
		</div>
		
		 <table> 
			<table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse;">
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
				<tr style="font-weight:bold; width: 100%;">
					<th>#</th>
					<th>Product Name</th>
					<th colspan="3">SKU</th>
					<th colspan="4">Stock Quantity</th>
					<th colspan="4">Warehouse Name</th>
				</tr>
				
				<tr colspan="12">
					<td colspan="13" style="background: #ccc;"><b>Opening Balance As On</b></td>
				</tr>
				<?php if(!empty($res)) { 
					$k=0;
					foreach($res as $res)  { 
					$productName = product_name($res->master_product_id);

					$explodeSku = explode(',',$res->SKU);

					$explodeQty = explode(',',$res->stock_qty);
                           ?>
				<tr>
					<td><?php echo $k; ?></td>
					<td><?php echo $productName;?></td>
					<td colspan="10">
						 <table style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse;"> 
							<tbody>
					<?php for($i=0; $i<count($explodeSku); $i++) { ?>
					<tr>
						<td><?php echo $explodeSku[$i]; ?></td>
						<td><?php echo $explodeQty[$i]; ?></td>
						
					</tr>
				<?php } ?>
					</tbody></table></td>
					<td><?php echo getWarehouseName($res->warehouse_id); ?></td>
				</tr>
					<?php $k++; } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Vendor Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
