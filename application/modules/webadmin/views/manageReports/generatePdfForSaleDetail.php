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
        <div style="text-align:center; font-weight:bold">Sale Detail Report</div>
        
        <div>
            <table id="account-result" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th >Date</th>
                                                <th >Sold By</th>
                                               <!--  <th >Sold To</th> -->
                                                <th >Item Purchased</th>
                                                <th >Subtotal</th>
                                                <th >Total</th>
                                                <th >Tax</th>
                                                <th >Discount</th>
                                                <th >Payments</th>
                                                <th >Comments</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                            if(!empty($sales)) {
                                            $i=1;
                                            foreach($sales as $sale){

                                            ?>
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="center"><?php echo $i;?></td>
                                                <td><?php echo date("d-m-Y h:i", strtotime($sale['date_time_created']));?></td>
                                                <td><?php echo $sale['sold_by'];?></td>
                                                <td><?php echo $sale['itm_cnt'];?></td>
                                                <td><?php echo $sale['sub_total'];?></td>
                                                <td><?php echo $sale['total'];?></td>
                                                
                                                <td>
                                                    Cgst:<?php echo $sale['cgst_amt']; ?></br>
                                                    Sgst:<?php echo $sale['sgst_amt']; ?></br>
                                                    Igst:<?php echo $sale['igst_amt']; ?></br>
                                                </td>

                                                <td><?php echo $sale['discount_amt']; ?></td>
                                                <td>
                                                    <?php
                        $pay_methods=$this->managereports_model->getPaymentsBySaleID($sale['sale_ID']);
                        if(!empty($pay_methods)) {
                            foreach ($pay_methods as $pm) {
                                if($pm['payment_method'] == 'check') {
                                    $method='cheque';
                                } else {
                                    $method=$pm['payment_method'];
                                }
                            # code...
                            echo $method.": ".$pm['payment_amount']."<br>";
                            }
                        } else {
                            echo '-';
                        }
                                                ?>
                                                </td>
                                                <td><?php echo $sale['remark'];?></td>
                                      
                                                
                                                
                                            </tr>

                                            <?php 

                                            $i++;
                                            } } else { ?>
                                            <tr><td colspan="10"> No Result Found.</td></tr>
                                            <?php }?> 
                                        </tbody>
                                    </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Sale Detail Full Ledger</div>
    </div><!--wrapper-->
</body>
</html>
