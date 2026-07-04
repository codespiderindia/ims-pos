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
    height: 10px;
    padding: 0 5px;
    width: 20%;
}
.a-main.a-main1 tr:last-child td:last-child .a-main-in tr:last-child td {
    height: 50px;
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
    font-size: 13px !important;
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
            <div class="widget-body">
                <div class="widget-main padding-6" id="invoice_content">
                    <div class="a4-container">
                    <div class="a-head"><?php print_r($title); ?></div>
                    <div class="a-table">
                        <table class="a-main a-main1">
                             <tr>
                                <td colspan="3">
                                   
                                 </td>
                                 <td colspan="3">
                                   <table class="a-main-in">
                                     <tr>
                                        <td>Invoice No.</td>
                                        <td>Dated: <?php echo date("d-M-Y");?></td>
                                     </tr>
                                     <tr>
                                        <td>Delivery Note : Nil</td>
                                        <td>Mode/Terms of Payment : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Supplier's Ref. : Nil</td>
                                        <td>Other Reference(s) : Nil</td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>

                                <tr>
                                 <td colspan="4">
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

                                 </td>
                                 <td colspan="4">
                                   <table class="a-main-in">
                                     <tr>
                                        <td>Buyer's Order No. : Nil</td>
                                        <td>Dated : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Despatch Document No. : Nil</td>
                                        <td>Delivery Note Date : Nil</td>
                                     </tr>
                                     <tr>
                                        <td>Despatched through : Nil</td>
                                        <td>Destination : Nil</td>
                                     </tr>
                                     <tr>
                                        <td colspan="2">Terms of Delivery : Nil</td>
                                     </tr>
                                   </table>
                                 </td>
                               </tr>
                        </table>

                        <table class="a-main a-main1">
                            <tr>
                                <th>Sr. No.</th>
                                <th>Shipment Id</th>
                                <th>Address</th>
                                <th>LR Number</th>
                                <th>LR date</th>
                            </tr>
                            <?php
                                $j=1;
                                foreach($shipment as $shipments) { ?>
                                <tr>
                                    <td><?php echo $j; ?></td>
                                    <td><?php echo $shipments->shipment_id; ?></td>
                                    <td><?php echo $shipments->address; ?></td>
                                    <td><?php echo $shipments->lr_number; ?></td>
                                    <td><?php echo $shipments->lr_date; ?></td>
                                </tr>
                                <?php $j++; }  ?>
                        </table>
                    </div>
                        <div class="a-table">
                            <table class="a-main a-main1">
                                <tr>
                                    <th>Sr. No.</th>
                                    <th>Shipment Id</th>
                                    <th>Description Of Product</th>
                                    <th>Qty</th>
                                    <th>Mrp Price</th>
                                    <th>Discount</th>
                                    <th>Amount</th>
                                </tr>
                                <?php
                                    $i=1;
                                    foreach($shipmentDetail as $shipmentDetails) { 
                                        foreach($shipmentDetails as $shipmentDetailss) {

                                        $whereProduct = ['product_id'=>$shipmentDetailss->master_product_id];
                                        $getAmount = getSku('product',$whereProduct);
                                        $price = $shipmentDetailss->quantity * $getAmount[0]['product_price'];
                                        $productName = product_name($shipmentDetailss->master_product_id);

                                        $whereDiscount = ['product_id'=>$shipmentDetailss->product_id];
                                        $discount = getSku('dealer_product_price',$whereDiscount);
                                        ?>
                                    <tr>
                                        <td><?php echo $i; ?></td>
                                        <td><?php echo $shipmentDetailss->shipment_id; ?></td>
                                        <td><?php echo $productName.'('.$shipmentDetailss->product_id.')'; ?></td>
                                        <td><?php echo $shipmentDetailss->quantity; ?></td>
                                        <td><?php echo $getAmount[0]['product_mrp']; ?></td>
                                        <td><?php
                                            if(isset($discount[0]['price'])) {
                                             echo $discount[0]['price'].'%'; } else {
                                                echo '-';
                                             } ?></td>
                                        <td><?php echo $price; ?></td>
                                    </tr>
                                    <?php   $i++; }   } ?>
                            </table>
                        </div>  
                    </div>
                </div> 
            </div>
        </div>
    </div>

</div>

</body>
</html>