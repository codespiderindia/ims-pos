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
        <div style="text-align:center; font-weight:bold; text-transform: uppercase;">Offer Report</div>
        
        <div>
            <table id="store-table" class="table table-striped table-borderedss table-hover" style="width:100%; border-collapse: collapse; margin-top: 20px;">
                  <thead>
                     <tr style="font-weight:bold; border-bottom:1px solid #ccc;">
                        <th style="padding:5px;">#</th>
                        <th style="padding:5px;">Offers Name</th>
                        <th style="padding:5px;">percentage or fixed</th>
                        <th style="padding:5px;">Discount</th>
                        <th style="padding:5px;">Free Product</th>
                        <th style="padding:5px;">Start</th>
                        <th style="padding:5px;">End</th>
                        <th style="padding:5px;">Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($allOffer)) {
                      $cnt3=1;
           foreach($allOffer as $allOffers) { ?>
            <tr>
                  <td><?php echo $cnt3;?></td>  
                  <td class=""><?php echo $allOffers->offer_name; ?></td>
                              <td><?php if($allOffers->percentage_or_fixed =='1') {
                  echo "%";
                  } ?>
                  <?php if($allOffers->percentage_or_fixed =='2') {
                  echo "Fixed";
                  } ?>
                  
                  <?php if($allOffers->percentage_or_fixed =='3') {
                  echo "Free Product";
                  } ?>
                  </td>
                  <td><?php echo $allOffers->offer_discount; ?></td>
                  <td><?php echo $allOffers->free_product; ?></td>
                  <td><?php echo $allOffers->date_duration_start; ?></td>
                  <td><?php echo $allOffers->date_duration_end; ?></td>  
                  <td><?php echo $allOffers->offer_description; ?></td>
          </tr>
  <?php $cnt3++; }
  } ?>
  </tbody>
               </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Offer Report</div>
    </div><!--wrapper-->
</body>
</html>