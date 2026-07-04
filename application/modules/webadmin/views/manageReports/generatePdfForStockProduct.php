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
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y H:i:s'); ?></div>       
        <div style="text-align:center; font-weight:bold">Sale Summary Report</div>
        
        <div>
            <table id="account-result" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Item Name</th>
                                                <th>SKU</th>
                                                <th>Store Name</th>
                                                <th >Quantity</th>
                                                <th >MRP</th> 
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php if(!empty($prd_stock)) {
                                            $i=1;
                                                foreach($prd_stock as $stk){
                                            ?>
                                            <tr>
                                                <td class="center"><?php echo $i; ?></td>
                                                <td><?php echo $stk['prdName'];?></td>
                                                <td><?php echo (isset($storeName) ? $storeName : '-'); ?></td>
                                                <td><?php echo $stk['sku'];?></td>

                                                <td>
                                                <?php if(isset($stk['stockqty'])) {
                                                     echo $stk['stockqty'];
                                                 } else {
                                                    echo 0;
                                                 }
                                                ?>
                                                    
                                                </td>
                                                <td><?php echo $stk['prdPrice'];?></td>
                                                
                                            </tr>

                                            <?php $i++; }  } else { ?>
                                            <tr><td colspan="5">No Record Found.</td></tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Sale Summary Full Ledger</div>
    </div><!--wrapper-->
</body>
</html>