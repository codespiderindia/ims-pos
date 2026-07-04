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
        <div style="text-align:center; font-weight:bold; text-transform: uppercase;">Dealer Report</div>
        
        <div>
            <table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-bottom:1px solid #ccc; border-collapse: collapse; margin-top: 20px;">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Dealer Name</th> 
                        <th>Email</th>
                        <th>City</th>
                        <th>Address</th>
                        <th>Mobile</th>
                        <th>Credit Limit</th>
                        <th>Firm Name</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($allDealer)) {
                      $cnt3=1;
           foreach($allDealer as $allDealers) { ?>
            <tr>
                <td><?php echo $cnt3; ?></td>  
                <td class=""><?php echo $allDealers->f_name." ".$allDealers->l_name; ?></td>
                <td><?php echo $allDealers->email; ?></td> 
              <td><?php  echo $allDealers->city; ?></td>
              <td><?php echo $allDealers->address; ?></td>
               <td><?php echo $allDealers->mobile_number; ?></td>
                <td><?php echo $allDealers->dealer_credit_limits; ?></td>
                <td><?php echo $allDealers->firm_name; ?></td>
            </tr>
  <?php $cnt3++; }
  } ?>
  </tbody>
               </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Dealer Report</div>
    </div><!--wrapper-->
</body>
</html>