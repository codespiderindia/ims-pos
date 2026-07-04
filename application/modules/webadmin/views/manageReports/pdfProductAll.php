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
		<div>
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
					<td style="padding:5px; border-bottom:1px solid #ccc">#</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Product Name</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Category</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Sub Category</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Sub of Sub Category</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Attributes</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Product Price</td>
					<td style="padding:5px; border-bottom:1px solid #ccc">Product Status</td>
				</tr>
				
				<tr>
					<td><b>Opening Balance As On</b></td>
				</tr>
				<?php if(!empty($res)) { foreach($res as $res)  { 
					$image =$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/product_image/'.$res->product_image;
                           ?>
				<tr>
					<td style="padding:5px;">#</td>
					<td style="padding:5px;"><?php echo $res->product_name;?></td>
					<td style="padding:5px;"><?php echo $res->Category;?></td>
					<td style="padding:5px;"><?php 
					 $productSubCategory = getParentCategory($res->SubCategory);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		echo $productSubCategory->cat_name;
						   }
						    if($res->SubCategory==0)
						   {
							echo "Not Define";
						   }?></td>
					<td style="padding:5px;"><?php 
					$productSubCategory = getParentCategory($res->SubOfSubCategory);
					   if(isset($productSubCategory) && !empty($productSubCategory)){
                       		echo $productSubCategory->cat_name;
					   }
					   if($res->SubOfSubCategory==0)
					   {
						echo "Not Define";
					   }
					?></td>
					<td style="padding:5px;"><?php 
	 				$attr_name = get_attribute_by_productID($res->product_id);
					   if(isset($attr_name) && !empty($attr_name)){
						   $count_array = count($attr_name);
						   if(!empty($attr_name)){
							   for($i=0;$i<$count_array;$i++){
									echo $attr_name[$i]; 
							   }
						   }else{
							  echo "Not Set";
						   }
	          		}
					?></td>
					<td style="padding:5px;"><?php echo $res->product_price;?></td>
					<td style="padding:5px;"><?php echo $res->product_status;?></td>
				</tr>
					<?php } } ?>
			</table>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Vendor Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
