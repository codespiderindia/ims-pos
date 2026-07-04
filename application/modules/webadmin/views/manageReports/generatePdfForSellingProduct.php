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
#account-result {
  font-size: 12px 
}
#account-result th, #account-result td{
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
                if(!empty($comp_code)) {
                     $getCompImg = getCompanyDetail($comp_code, 'comp_image');
                     $compImg = $getCompImg[0]->comp_image;
                      $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
                 ?>
                <img src="<?php echo $image; ?>" width="50" />
                <?php } ?>
            </div>
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>       
        <div style="text-align:center; font-weight:bold">Best Selling Report</div>
        
        <div>
             <table id="account-result" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Item Name</th>
                                                <th >SKU</th>
                                                <th >Quantity</th>
                                                <th >MRP</th>
                                                <th >Amount</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            if(!empty($sales)) {
                                            $i=1;
                                            foreach($sales as $sale){
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $i; ?></td>
                                                <td><?php echo $sale['product_name'];?></td>
                                                 <td><?php echo $sale['product_ID'];?></td>
                                                <!-- <td><?php echo $sale['sale_ID'];?></td> -->
                                                <!-- <td><?php echo $sale['product_ID'];?></td> -->
                                                <td><?php echo $sale['totQty'];?></td>
                                                <td><?php echo $sale['item_cost_price'];?></td>
                                                <td><?php echo $sale['itmTotal'];?></td>

                                            </tr>

                                            <?php $i++; }  } else { ?>
                                            <tr><td colspan="6"><?php echo 'No Result Found.' ?></td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Best Selling Full Ledger</div>
    </div><!--wrapper-->
</body>
</html>
