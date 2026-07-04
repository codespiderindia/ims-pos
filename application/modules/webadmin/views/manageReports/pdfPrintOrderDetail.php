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
.row_border {
  border: 1px solid;
}
table { border-collapse: collapse; }
#store-table td{
  border:1px solid #333; 
  padding:5px;
   font-size: 10px;
}
#store-table th{ 
  font-size: 10px;
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
          
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y H:i:s'); ?></div>       
        <div style="text-align:center; font-weight:bold">Order Details Report</div>
        
        <div>
          <table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px; font-size: 13px;"> 
            <thead>
                  <tr>
                      <th class="center">#</th>
                      <th>GSTIN/UIN of Recipient</th>
                      <th>Receiver Name</th>
                      <th>Invoice Number</th>
                      <th>Invoice Date</th>
                      <th>Invoice Value</th>
                      <th>Place Of Supply</th>
                      <th>Reverse Charge</th>
                      <th>Invoice Type</th>
                      <th>E-Commerce GSTIN</th>
                      <th>Rate</th>
                      <th>Application % of Tax Rate</th>
                      <th>Taxable Value</th>
                      <th>Cess Amount</th>
                   </tr>
              </thead>

              <tbody>
                  <?php 

                  if(isset($orderDetail) && !empty($orderDetail)){
                  $i=1;$chkGstExits=0;
                  foreach($orderDetail as $invoiceId=>$orderDetails){

                    foreach($orderDetails as $gstRate=>$orderval) {

                           if($orderval['payment_for'] == 1) {
                              $invoiceType = 'Regular';
                           } else {
                              $invoiceType = 'Direct Pay';
                           }

                        $dealer_name = dealer_name($orderval['dealer_user_id']);
                        foreach($dealer_name as $dealer_names) {
                            $dName = $dealer_names->f_name.' '.$dealer_names->l_name;
                        }

                        $getDealerData = getSku('dealer',['dealer_id'=>$orderval['dealer_user_id']]);

                        ?>
                     <tr>
                        <td class="center"><?php echo $i;?></td>
                        <td><?php echo $getDealerData[0]['tin_number']; ?></td>
                        <td><?php echo $getDealerData[0]['firm_name']; ?></td>
                        <td><?php echo (isset($orderval['invoice_id']) ? $orderval['invoice_id'] : ''); ?></td>
                        <td><?php echo $orderval['invoice_date']; ?></td>
                        <td><?php echo $orderval['taxable_value']; ?></td>
                        <td><?php echo $orderval['place_of_supply']; ?></td>
                        <td><?php echo 'N'; ?></td>
                        <td><?php echo $invoiceType; ?></td>
                        <td></td>
                        <td><?php
                            if($gstRate != '') {
                              echo str_pad($gstRate, 5, '.00', STR_PAD_RIGHT);
                            }
                         ?></td>
                        <td></td>
                        <td><?php echo $orderval['total']; ?></td>
                        <td><?php echo $orderval['cess_amount']; ?></td>
                     </tr>

                    <?php $i++; } } } else { ?>
                    <tr>
                      <td>No Record</td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                       <td></td>
                    </tr>
                    <?php } ?>  
      </tbody>
          </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Order Details Report</div>
    </div><!--wrapper-->
</body>
</html>