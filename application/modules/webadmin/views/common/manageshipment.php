<?php
$cgst_tot_amt=0;
$sgst_tot_amt=0;
$igst_tot_amt=0;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <meta charset="utf-8" />
        <title>Sales | Print Invoice</title>
        
        <meta name="description" content="" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        
        <!--basic styles-->
        
        <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
        <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
        
        
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
        <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
        
        <!--inline styles related to this page-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


        <style type="text/css">
        .order_total_text {
            background-color: #438eb9;
            border: medium none;
            border-radius: 4px;
            color: #fff;
            padding: 5px 10px;
            margin-top:15px;
        }
        .control-label1 {
            float: left;
            width: 160px;
            padding-top: 5px;
            text-align: right;
        }
        .order_total_text label {
            font-size: 16px;
            font-weight: bold;
        }
        .total_price {
            font-size: 16px;
            font-weight: bold;
            margin: 5px;
        }

        </style>
                <style type="text/css">
        @media print {
            body * {
                visibility:hidden;
            } 
            #invoice_content, #invoice_content * {
                visibility:visible;
            }
            #invoice_content { /* aligning the printable area */
                position:absolute;
                left:40;
                top:40;
            }
        }
        </style>

        <style>
/**
*CSS for Invoice
*Start
**/
.a4-container {
    width:210mm;
    margin:0 auto;
    padding: 15px 5px;
    /*border:1px solid #ccc;
    border-radius:4px;*/
    box-shadow: 0 0 3px #ccc;
    font-family:Arial, Helvetica, sans-serif

}
.a-head {
    text-align: center;
    font-size: 20px;
    margin:0 0 10px;
}
.a-table table {
    width:100%;
    border-collapse: collapse;
}
.a-table td {
    padding: 0;
    vertical-align:top;
}
.a-table p {
    margin: 0;
}
.a-main {
    border:1px solid #ccc;
}
.a-main.a-main1 td:first-child {
    padding:0 5px;
    border-bottom: 1px solid #ccc;
}
.a-main.a-main1 .a-main-in td {
    border-bottom: 1px solid #ccc;
    border-left: 1px solid #ccc;
   /* height: 10px;*/
    padding: 0 5px;
    /*width: 20%;*/
}
.a-main.a-main1 tr:last-child td:last-child .a-main-in tr:last-child td {
    height: 5px;
    padding-top: 10px;
}
.a-main.a-main2 tr:first-child {
    border-bottom: 1px solid #ccc;
    text-align:center;
}
.a-main.a-main2 tr:first-child td, .a-main.a-main2 tr td:first-child {
    text-align:center;
}
.a-main.a-main2 tr td:nth-child(2) {
    text-align:left;
}
.a-main.a-main2 tr:first-child td {
    height: 40px;
}
.a-main.a-main2 td {
    border-right:1px solid #ccc;
    padding:0 5px;
    text-align:right;
}
.a-main.a-main2 td.ttl {
    border-top:1px solid #ccc;
    height:25px;
}
.a-main.a-main2 tr.total {
    border-top:1px solid #ccc;
    height:25px;
}
.mn-text {
    border:1px solid #ccc;
    padding:5px;
}
.mn-text p {
    font-size:15px;
    padding:0 0 5px;
}
.mn-text p span {
    float: right;
}
.mn-text2 {
    min-height:55px;
}
.mn-text2 p {
    display:inline-block;
}
.mn-text p:nth-child(2) {
    font-size:18px;
    font-weight:500;
}
.a-main td {
    height: 22px;
}
.a-main.a-main4 .a-main4-left {
    vertical-align:bottom;
    padding:5px;
}
.a-main.a-main4 .a-main4-left p:first-child {
    font-size:12px;
    text-decoration:underline;
}
.a-main.a-main4 td:nth-child(2) tr:last-child .a-main-in td {
    text-align:right;
}
.a-main.a-main4 td:nth-child(2) tr:last-child .a-main-in {
    border-top: 1px solid #ccc;
    border-left: 1px solid #ccc;
}
.a-main4-left, .a-main4-right {
    width:50%;
}
.a-main4-right .a-main-in .a-main-in tr:first-child td {
    height:10px;
}
.a-main4-right .a-main-in .a-main-in tr td {
    padding:0 5px;
}
.a-terms p {
    text-align:center;
    font-size: 12px;
}
.a-main.a-main3 tr td:first-child {
    border-right: 1px solid #ccc;
}
.a-main.a-main3 tr:first-child td {
    text-align: center;
}
.a-main.a-main3 tr:last-child td {
    text-align: right;
}
.a-main.a-main3 tr td:nth-child(1) {
    text-align: left;
    border-right: 1px solid #ccc;
}
.a-main.a-main3 tr td {
    text-align: right;
    border-right: 1px solid #ccc;
}
.a-main.a-main3 td {
    padding: 0 5px;
}
.a-main.a-main3 tr:nth-child(2) td {
    text-align: center;
}
.a-main.a-main3 tr:last-child td {
    text-align: right;
}
.a-main.a-main3 tr td:first-child {
    width:200px;
}
.a-main-title p {
    text-align: left;
    font-size: 18px;
    font-weight: 500;
    padding-top: 3px;
    padding-bottom: 3px;
}
.payment_content {
    font-size: 14px;
}
.pay_td {
    padding-left: 7px !important;
    font-size: 11px !important;
}
.invBarcode_label {
    width: 20%;
    float: left;
    line-height: 120px !important;
    height: 81px;
    font-size: 17px;
    font-weight: 600;
}
.remark_span {

}
.bordertop {
    border-top: 1px solid #ccc;
}
.alignCenter {
    text-align: left;
    
}
.border-right {
    border-right: 1px solid #ccc;
}
.border-bottom {
    border-bottom: 1px solid #ccc;
}
.border-left {
   border-right: 1px solid #ccc;
  text-indent: 10px;
}
.de-info{
   text-indent: 10px;
}
.a-main-title22{
    font-size: 14px;
}
/**
*CSS for Invoice
*End
**/

</style>
    </head>

<body>

<div>
    <div class="row-fluid">
        <div class="span12">
            <div class="widget-body" style="font-size: 10px;">
                <div class="widget-main padding-6 bordertop" id="invoice_content">
                    <div class="a4-container">
                    <div class="a-head" style="font-size: 14px; margin-top: -15px;"><?php print_r($title); ?></div>
                    <?php if(isset($companyDetails) && !empty($companyDetails)) {
                        $headerDatas = $companyDetails->invoice_header;


                        if($headerDatas != '') {
                            if(strpos($headerDatas, ',')) {
                                $headerDatasEx = explode(',',$headerDatas);
                            } else {
                                $headerDatasEx = $headerDatas;
                            }

                            if(isset($headerDatasEx) && !empty($headerDatasEx) && is_array($headerDatasEx)) { 
                                ?>
                                <ol>
                                    <?php foreach($headerDatasEx as $headerData) { ?>
                                        <li><?php echo $headerData; ?></li>
                                    <?php } ?>
                                  </ol>
                            <?php } else { ?>
                                <b><p><?php echo $headerDatasEx; ?></p></b>
                            <?php }
                        }
                    } ?>
                    <div class="a-table" style="width: 770px;">
                        <table class="a-main a-main1" style="width: 760px; border-bottom: none">
                             <tr>
                                <td colspan="3">
                                   <p>Company Name : <?php echo $companyname; ?></p>
                                   <!-- <p>GST Rel 6.0 Preview</p> -->
                                   <!-- <p>Madurai</p> -->
                                    <p>Company Address : <?php echo $companyaddress; ?></p>
                                   <p>TIN Number : <?php echo $dealerInfo[0]['tin_number'];?></p>
                                </td>
                                <td colspan="3">
                                   <table class="a-main-in">
                                     <tr>
                                        <td>Invoice No. <?php echo $dealerInvoice[0]['invoice_id']; ?></td>
                                        <td class="border-right">Dated: <?php echo date("d-M-Y");?></td>
                                     </tr>
                                     <tr>
                                        <td>Delivery Note : Nil</td>
                                        <td class="border-right">Mode/Terms of Payment : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Supplier's Ref. : Nil</td>
                                        <td class="border-right">Other Reference(s) : Nil</td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>

                                <tr>
                                 <td colspan="4" class="de-info border-bottom">
                                 <p>Dealer Info.</p>
                                 <?php 
                                    if(isset($dealerInfo) && !empty($dealerInfo)){
                                        ?>
                                            <p><?php echo $dealerInfo[0]['f_name']." ".$dealerInfo[0]['l_name'];?></p>
                                            <p>Address : <?php echo $dealerInfo[0]['address'];?></p>
                                            <p>Contact Number : <?php echo $dealerInfo[0]['contact_number'];?></p>
                                            <p>Firm Name : <?php echo $dealerInfo[0]['firm_name']; ?></p>
                                            <p>Tin Number : <?php echo $dealerInfo[0]['tin_number'];?></p>
                                        <?php
                                    }else{
                                        ?>
                                        NIL
                                        <?php
                                    }
                                 ?>

            <hr>
           <?php if(isset($companyFirmInfo) && !empty($companyFirmInfo)) { ?>
            <p>FirmInfo : <?php echo $companyFirmInfo->firm_name; ?></p>
            <p>FirmAddress : <?php echo $companyFirmInfo->firm_address; ?></p>
            <p>FirmTeenNumber : <?php echo $companyFirmInfo->firm_teen_num; ?></p>
           <?php } ?>

                                 </td>
                                 <td colspan="4">
                                   <table class="a-main-in" style="width:359px;">
                                     <tr>
                                        <td>Buyer's Order No. : Nil</td>
                                        <td class="border-right">Dated : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Despatch Document No. : Nil</td>
                                        <td class="border-right">Delivery Note Date : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Despatched through : Nil</td>
                                        <td class="border-right">Destination : Nil</td>
                                     </tr>
                                     <tr>
                                        <td colspan="2" class="border-right">Terms of Delivery : Nil</td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                        </table>

                        <table class="a-main a-main1" style="margin-top: 10px; width: 700px;">
                            <tr class="">
                                    <td colspan="5" class="a-main-title a-main-title22 border-right" style="height:32px;">
                                        <p style="font-size: 13px;">Shipment Info</p>
                                    </td>
                                </tr>
                            <tr style="text-align: left;">
                                <th class="bordertop border-left border-bottom">Sr. No.</th>
                                <th class="bordertop border-left border-bottom">Shipment Id</th>
                                <th class="bordertop border-left border-bottom">Address</th>
                                <th class="bordertop border-left border-bottom">LR Number</th>
                                <th class="bordertop border-left border-bottom">LR date</th>
                            </tr>
                            <?php
                                $j=1;
                                foreach($shipment as $shipments) { ?>
                                <tr>
                                    <td class="alignCenter border-left"><?php echo $j; ?></td>
                                    <td class="alignCenter border-left"><?php echo $shipments['shipment_id']; ?></td>
                                    <td class="alignCenter border-left"><?php echo $shipments['address']; ?></td>
                                    <td class="alignCenter border-left"><?php echo $shipments['lr_number']; ?></td>
                                    <td class="alignCenter border-left" style="text-align: right; padding-right: 10px;"><?php echo $shipments['lr_date']; ?></td>
                                </tr>
                                <?php $j++; }  ?>
                        </table>
                    </div>
                        <div class="a-table">
                            <table class="a-main a-main1" style="margin-top: 10px; width: 700px;">
                                <tr class="bordertop">
                                    <td colspan="7" class="a-main-title a-main-title22" style="height:32px; font-size: 14px">
                                        <p style="font-size: 13px;">Shipment Details</p></td>
                                </tr>
                                <tr>
                                    <th class="bordertop border-left border-bottom">Sr. No.</th>
                                    <th class="bordertop border-left border-bottom">Shipment Id</th>
                                    <th class="bordertop border-left border-bottom">Description Of Product</th>
                                    <th class="bordertop border-left border-bottom">Qty</th>
                                    <th class="bordertop border-left border-bottom">Mrp Price</th>
                                    <th class="bordertop border-left border-bottom">Discount</th>
                                    <th class="bordertop border-left border-bottom">Amount</th>
                                </tr>
                                <?php $totalVal=0;$totalQty=0;
                                    $i=1;
                                    if(isset($shipmentDetail) && !empty($shipmentDetail)) {
                                   // foreach($shipmentDetail as $shipmentDetails) { 
                                        foreach($shipmentDetail as $shipmentDetailss) {

                                        $whereProduct = ['product_id'=>$shipmentDetailss->master_product_id];
                                        $getAmount = getSku('product',$whereProduct);

                                        $whereOrderDetail = ['product_id'=>$shipmentDetailss->product_id, 'order_id'=>$shipmentDetailss->order_id];
                                        $getOrderDetail = getSku('order_detail', $whereOrderDetail);

                                        if(!empty($getOrderDetail)) {
                                            $price = $shipmentDetailss->quantity * $getOrderDetail[0]['price'];
                                        } else {
                                            $price = $shipmentDetailss->quantity * $getAmount[0]['product_price'];
                                        }

                                        $productName = product_name($shipmentDetailss->master_product_id);

                                        $whereDiscount = ['product_id'=>$shipmentDetailss->product_id];
                                        $discount = getSku('dealer_product_price',$whereDiscount);

                                        $totalVal += $price;
                                        $totalQty += $shipmentDetailss->quantity;
                                        //$cgstAmt += $shipmentDetailss->cgst_amt;
                                       // $sgstAmt += $shipmentDetailss->sgst_amt;
                                        //$igstAmt += $shipmentDetailss->igst_amt;

                                    $cgst_tot_amt= $cgst_tot_amt+$shipmentDetailss->cgst_amt;
                                    $sgst_tot_amt= $sgst_tot_amt+$shipmentDetailss->sgst_amt;
                                    $igst_tot_amt= $igst_tot_amt+$shipmentDetailss->igst_amt;

                                        ?>
                                    <tr>
                                        <td class="alignCenter border-left"><?php echo $i; ?></td>
                                        <td class="alignCenter border-left"><?php echo $shipmentDetailss->shipment_id; ?></td>
                                        <td class="alignCenter border-left"><?php echo $productName.'('.$shipmentDetailss->product_id.')'; ?></td>
                                        <td class="alignCenter border-left"><?php echo $shipmentDetailss->quantity; ?></td>
                                        <td class="alignCenter border-left"><?php echo $price; ?></td>
                                        <td class="alignCenter border-left"><?php
                                            if(isset($discount[0]['price'])) {
                                             echo $discount[0]['price'].'%'; } else {
                                                echo '-';
                                             } ?></td>
                                        <td  style="text-align: right; padding-right: 15px;"><?php echo round($price, 2); ?></td>
                                    </tr>
                                    <?php   $i++; }   }  //} ?>
                                     <tr>
                                         <td class="border-left"></td>
                                         <td class="border-left"></td>
                                         <td class="alignCenter border-left">SGST</td>
                                         <td class="border-left"></td>
                                        <td class="border-left"></td>
                                        <td class="border-left"></td>
                                         <td class="alignCenter border-left"  style="text-align: right; padding-right: 15px;"><?php echo round($sgst_tot_amt, 2); ?></td>
                                   </tr>
                                     <tr>
                                         <td class="border-left"></td>
                                         <td class="border-left"></td>
                                        <td class="alignCenter border-left">CGST</td>
                                        <td class="border-left"></td>
                                        <td class="border-left"></td>
                                        <td class="border-left"></td>
                                         <td class="alignCenter border-left"  style="text-align: right; padding-right: 15px;"><?php echo round($cgst_tot_amt, 2); ?></td>
                                   </tr>
                                    <tr>
                                         <td class="border-left"></td>
                                         <td class="border-left"></td>
                                        <td class="alignCenter border-left">IGST</td>
                                         <td class="border-left"></td>
                                        <td class="border-left"></td>
                                         <td class="border-left"></td>
                                         <td class="alignCenter border-left"  style="text-align: right; padding-right: 15px;"><?php echo round($igst_tot_amt, 2); ?></td>
                                   </tr>
                                    <tr class="total">
                                        <td class="border-left bordertop"></td>
                                        <td class="border-left bordertop"></td>
                                        <td class="alignCenter border-left bordertop"><strong>Total</strong></td>
                                        <td class="border-left  bordertop"><?php echo $totalQty; ?> nos</td>
                                       <td class="border-left bordertop"></td>
                                       <td class="border-left bordertop"></td>
                                       <td class="border-left  bordertop"  style="text-align: right; padding-right: 15px;"><?php echo $totalVal; ?></td>
                                    </tr>
                            </table>

                             &nbsp;
                             <table class="a-main a-main2" style="width: 700px; margin-top: -10px;">
                                <tr>
                                    <td colspan="3" class="a-main-title a-main-title22" style="height:32px;">
                                        <p style="font-size: 13px;">Payment Details</p></td>
                                </tr>
                                <tr class="payment_content" style="border-bottom: 1px solid #ccc">
                                    <th class="pay_td border-left bordertop border-bottom">Sn.</th>
                                    <th class="pay_td border-left bordertop border-bottom">Payment Method</th>
                                    <th class="pay_td border-left bordertop border-bottom">Amount</th>
                                </tr>
                                <tr>
                                <?php 
                                    $i=1;
                                    if(isset($dealerInvoice) && !empty($dealerInvoice)) { ?>
                                        <td><?php echo $i; ?></td>
                                        <td><?php if($dealerInvoice[0]['payment_for'] ==1) {
                                            echo 'Invoice';
                                        } else {
                                            echo 'Direct pay';
                                        } ?></td>
                                        <td><?php echo $totalVal; ?></td>
                                    <?php }
                                ?>
                                </tr>
                             </table>

                              &nbsp;
                    <div class="mn-text mn-text1" style="width: 690px;">
                       <p style="font-size: 11px;">AmountChargeable (in words)<span>E.&O.E </span></p>
                       <p style="font-size: 12px;"><?php echo ucwords(@getIndianCurrency($dealerInvoice[0]['amount']));?> Only</p>
                    </div>

    <table class="a-main a-main2 a-main-two">
        <tr class="total">
            <th colspan="2" style="text-align:center;border-bottom:1px solid #ccc">HSN/SAC</th>
            <th colspan="2" style="text-align:center;border-bottom:1px solid #ccc">Taxable Value</td>
            <th colspan="2" style="border-bottom:1px solid #ccc">Central Tax</th>
            <th colspan="2" style="border-bottom:1px solid #ccc">State Tax</th>
            <th colspan="2" style="border-bottom:1px solid #ccc">IGST</th>
         </tr>
         <tr>
            <td colspan="2"></td>
            <td colspan="2"></td>
            <td>Rate</td>
            <td>Amount</td>
            <td>Rate</td>
            <td>Amount</td>
            <td>Rate</td>
            <td>Amount</td>
         </tr>

        <?php
            $totalVal1=0;$totalQty1=0;
            $j=1;
            if(isset($shipmentDetail) && !empty($shipmentDetail)) {
               // foreach($shipmentDetail as $shipmentDetails) { 
                foreach($shipmentDetail as $shipmentDetailss) {
                 $productName = product_name($shipmentDetailss->master_product_id);

                $whereProduct = ['product_id'=>$shipmentDetailss->master_product_id];
                $getAmount = getSku('product',$whereProduct);

                $whereOrderDetail = ['product_id'=>$shipmentDetailss->product_id, 'order_id'=>$shipmentDetailss->order_id];
                $getOrderDetail = getSku('order_detail', $whereOrderDetail);

                if(!empty($getOrderDetail)) {
                    $price = $shipmentDetailss->quantity * $getOrderDetail[0]['price'];
                } else {
                    $price = $shipmentDetailss->quantity * $getAmount[0]['product_price'];
                }

                $totalVal1 += $price;
                $totalQty1 += $shipmentDetailss->quantity;

                $cgst_tot_amt= $cgst_tot_amt+$shipmentDetailss->cgst_amt;
                $sgst_tot_amt= $sgst_tot_amt+$shipmentDetailss->sgst_amt;
                $igst_tot_amt= $igst_tot_amt+$shipmentDetailss->igst_amt;
                 ?>
                <tr>
                    <td colspan="2"><?php echo $productName; ?></td>
                    <td colspan="2"><?php echo round($price, 2); ?></td>
                    <td><?php echo '-'; ?>%</td>
                    <td><?php echo $shipmentDetailss->cgst_amt; ?></td>
                    <td><?php echo '-'; ?>%</td>
                    <td><?php echo $shipmentDetailss->sgst_amt; ?></td>
                    <td><?php echo '-'; ?>%</td>
                    <td><?php echo $shipmentDetailss->igst_amt; ?></td>
                 </tr>
                <?php $i++; } ?>
                <tr class="total">
                    <td colspan="2">Total</td>
                    <td colspan="2"><?php echo $totalVal1; ?></td>
                    <td></td>
                    <td><?php echo round($cgst_tot_amt, 2); ?></td>
                    <td></td>
                    <td><?php echo round($sgst_tot_amt, 2); ?></td>
                    <td></td>
                    <td><?php echo round($igst_tot_amt, 2); ?></td>
                 </tr>
            <?php }
       ?>
    </table>

                    <table class="a-main a-main4" style="width: 701px; margin-top: -1px;">
     
       <tr>
         <td class="a-main4-left">
           <table class="a-main-in">
             <tr>
               <td>
                 <p>Declaration</p>
                 <p>Lorem ipsum dolor sit amet, consectetuer <br> adipiscing elitLorem ipsum dolor sit amet,</p>
               </td>
             </tr>
           </table>
         </td>
         <td class="a-main4-right">
          <table class="a-main-in" style="padding:10px; ">
             <tr>
               <td class="CBD padding-top" colspan="2">Company's Bank Details</td>
             </tr>
             <tr>
               <td>Account Name :</td>
               <td><?php echo $dealerBankDetail[0]['account_name']; ?></td>
             </tr>
             <tr>
               <td>Bank Name :</td>
               <td><?php echo $dealerBankDetail[0]['bank_name']; ?></td>
             </tr>
             <tr>
               <td>A/c No. :</td>
               <td><?php echo $dealerBankDetail[0]['account_number']; ?></td>
             </tr>
             <tr>
               <td>Branch & IFS Code </td>
               <td><?php echo $dealerBankDetail[0]['ifsc_code']; ?></td>
             </tr>
             <tr>
               <td colspan="2" class="a-12">
                 <table class="a-main-in">
                     <tr>
                       <td>for GST Rel 6.0 Preview</td>
                     </tr>
                     <tr>
                       <td class="Users">
                                <p><?php 
            if(isset($uInfo['user_full_name']) && !empty($uInfo['user_full_name'])){
                
                echo $uInfo['user_full_name'];
            }

            ?></p>
            <p> Authorised Signatory</p>

                       </td>
                     </tr>
                   </table>
               </td>
             </tr>
           </table>
         </td>
       </tr>
     </table>

                        </div>  

    <div class="a-terms">
      <p>This is a Computer Generated Invoice</p>
      <?php //echo '<pre>';print_r($companyDetails);
            if(isset($companyDetails) && !empty($companyDetails)) {
            $footerDatas = $companyDetails->invoice_footer;

            if($footerDatas != '') {
                if(strpos($footerDatas, ',')) {
                    $footerDataEx = explode(',',$footerDatas);
                } else {
                    $footerDataEx = $footerDatas;
                }

                if(isset($footerDataEx) && !empty($footerDataEx) && is_array($footerDataEx)) { ?>
                    <ol>
                        <?php foreach($footerDataEx as $footerData) { ?>
                            <li><?php echo $footerData; ?></li>
                        <?php } ?>
                        <!--<li>Please keep bill and while changing.</li>
                        <li>No Claim No Guarantee.</li>
                        <li>Exchange within 10 Days Only.</li>
                        <li>Goods once sold will not taken back.</li>-->
                      </ol>
                <?php } else { ?>
                    <b><p><?php echo $footerDataEx; ?></p></b>
                <?php }
            }  } ?>
    </div>

                    </div>
                </div> 
            </div>
        </div>
    </div>

</div>

</body>
</html>