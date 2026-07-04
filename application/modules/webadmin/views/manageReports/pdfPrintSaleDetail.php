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
table { border-collapse: collapse; }

table tr td, table tr th {
  border: 1px solid black !important;
  padding: 0px 10px;
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
                if($compImg != '') {
                $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>
            <img src="<?php echo $image; ?>" width="50" />
            <?php } ?>
          </div>
          
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>
        <div style="text-align:center; font-weight:bold">Sale Details Report</div>
        
        <div>
          <table id="store-table" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
            <thead>
                <tr>
                    <th class="center">#</th>
                    <th>Type</th>
                    <th>Place Of Supply</th>
                    <th>Rate</th>
                    <th>Taxable Value</th>
                    <th>Cess Amount</th>
                    <th>GST</th>
                </tr>
            </thead>
             <tbody>
                  <?php 
                   if(isset($saleDetail) && !empty($saleDetail)) {
                    $i=1;
                    foreach($saleDetail as $statename=>$saleDetails) {

                      foreach($saleDetails as $tax=>$saleDetailss) {
                  ?>
                  <tr style="border-bottom: 1px solid;">
                      <td class="center"><?php echo $i;?></td>
                      <td><?php echo 'OE'; ?></td>
                      <td><?php echo $statename; ?></td>
                      <td><?php echo $tax; ?></td>
                      <td><?php echo $saleDetailss['item_subtotal']; ?></td>
                      <td><?php echo round($saleDetailss['cess_amount'], 2); ?></td>
                      <td><?php echo $saleDetailss['store_gst_number']; ?></td>
                  </tr>
                  <?php 
                  $i++;
                  } } } else { ?>
                  <tr>
                      <td colspan="7">No Records</td>
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
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Sale Details Report</div>
    </div><!--wrapper-->
</body>
</html>