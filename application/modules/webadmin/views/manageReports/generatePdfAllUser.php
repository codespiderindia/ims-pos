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
#myTables {
  font-size: 12px 
}
#myTables th, #myTables td{
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
            <?php if($image != '') { ?>
              <img src="<?php echo $image; ?>" width="50" />
            <?php } else { ?>
            <img src="" width="50" />
            <?php } ?>
            
 
          </div>
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>       
        <div style="text-align:center; font-weight:bold; text-transform:uppercase;">User Report</div>
        
        <div>
            <table id="myTables" class="table table-striped table-borderedss table-hover" style="width:100%;  border-collapse: collapse; margin-top: 20px;">
                  <thead>
                     <tr style="font-weight:bold; border-bottom:1px solid #ccc;">
                        <th class="center">#</th>
                        <th style="padding:5px;">Name</th>
                        <th style="padding:5px;">Assigned Store</th>
                        <th style="padding:5px;">Assigned Warehouse</th>
                        <th style="padding:5px;">Email</th>
                        <th style="padding:5px;">Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php if(!empty($users)) {
                     $cnt1=1;
                        foreach($users as $val) { ?>
                        
                      <tr>
                        <td class="center"><?php echo $cnt1;?></td>
                        <td><?php echo $val->user_full_name;?></td> 
                                    <td> 
                          <?php if($cnt1 == 1) {
                              $stores = getStores($val->user_ID);
                                if(!empty($stores)) {
                                   foreach($stores as $stores) {
                                    echo $stores['store_name']."</br>";
                                } } 
                            } else {
                              $stores = store_details_by_id($val->store_id);
                              if(!empty($stores)) {
                                echo $stores[0]['store_name']."</br>";
                                }  else  { echo "Not Assigned."; }
                            }
                           ?>
                                    </td>
                                    <td><?php
                              if($cnt1 == 1) {
                                 $warehouses = getWarehouses($val->user_ID);
                                 if(!empty($warehouses)) {
                                 foreach($warehouses as $warehouses) {
                                 echo $warehouses['warehouse_name']."</br>";
                                 } } 
                              } else {
                                  $warehouses = warehouse_details_by_id($val->warehouse_id);
                                 if(!empty($warehouses)) {
                                 echo $warehouses[0]['warehouse_name']."</br>";
                                 }  else  { echo "Not Assigned."; }
                              }
                           ?>
                        </td>  
                        <td><?php  echo $val->user_email;?></td>
                                    <td><?php  if($val->user_account_status=='1')  { echo "Active";  } else { 'Inactive'; } ?></td>
                                </tr>
  
  <?php $cnt1++; } 
  } ?>
    </tbody>
               </table>
        </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">User Report</div>
    </div><!--wrapper-->
</body>
</html>
