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
</style>
</head>
<body>  
        <div class="wrapper">

          <div>
            <?php $getCompImg = getCompanyDetail($comp_code, 'comp_image');
             $compImg = $getCompImg[0]->comp_image;
             if($compImg != '') {
                $image = 'file://'.$_SERVER['DOCUMENT_ROOT'].'/inventory/uploads/company_image/'.$compImg;
             ?>
            <img src="<?php echo $image; ?>" width="50" />
            <?php } ?>
          </div>
          
        <div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y H:i:s'); ?></div>       
        <div style="text-align:center; font-weight:bold">Short Details Report</div>
        
        <div>
          <table id="daily-shot-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th>User Name</th>
                                                <th>Store Name</th>
                                                <th>Payment Method</th>
                                                <th>CNote</th>
                                                <th>Total Payment</th>
                                                <th>Short</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                             if(isset($shotDetail) && !empty($shotDetail)){
                                            $i=1; $totalshort = 0;
                                            foreach($shotDetail as $shotDetails){
                                                $totalshort += $shotDetails->shot;

                                            ?>
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="center">
                                                    <?php echo $i;?>
                                                </td>

                                                <td><?php echo get_user_name_by_user_ID($shotDetails->user_id); ?></td>
                                                <td><?php if(isset($shotDetails->store_id) && $shotDetails->store_id != 0) { echo getStoreName($shotDetails->store_id); } else { echo '-'; }?></td>

                                                <td>Cash: <?php echo $shotDetails->cash; ?></br>
                                                    Debit Card: <?php echo $shotDetails->debit_card; ?></br>
                                                    Credit Card: <?php echo $shotDetails->credit_card; ?></br>
                                                    Cheque: <?php echo $shotDetails->cheque; ?></td>

                                                <td><?php echo $shotDetails->cnote; ?></td>
                                                
                                                <td><?php echo $shotDetails->total_payment; ?></td>

                                                <td><?php echo $shotDetails->shot; ?></td>
                                                <td><?php echo date("Y-m-d", strtotime($shotDetails->modify_date));?></td>
                                            </tr>

                                            <?php 
                                            $i++;
                                            } } else { ?>
                                            <tr>
                                                <td>No Records</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                            </tr>
                                            <?php } ?>

                                            <?php if(isset($shotDetail) && !empty($shotDetail)) { ?>
                                                <tr>
                                                <td></td>
                                                <td>Total Short</td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td></td>
                                                <td><?php echo 'INR'.$totalshort; ?></td>
                                                <td></td>
                                            </tr>
                                           <?php } ?>
                                        </tbody>
                                    </table>
  </div>
        
        <div style="text-align:left; font-size:14px; margin-top:15px;">Short Details Report</div>
    </div><!--wrapper-->
</body>
</html>