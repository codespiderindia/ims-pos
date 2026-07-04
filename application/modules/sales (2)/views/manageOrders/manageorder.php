<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<div>
	<div style="width:595px; margin:0 auto; padding:15px;box-shadow: 0 0 3px #999;">
    	<div style="display:inline-block;width:100%;">
		<?php //print_r($_SERVER['PHPRC']); ?>
        	
            <div style="float:left;width:78%;text-align:center;margin:8px 0">
            	<p style="margin:0; font-size:20px;text-decoration:underline;">Tax Invoice</p>
                <h1 style="margin:0; font-size:42px;"><img width="20%" height="10%" src="<?php echo $_SERVER['PHPRC'].'/inventory/uploads/store_logo/'.$firm_data[0]->firm_logo; ?>" /><?php echo $firm_data[0]->firm_name;?></h1>
            </div>
        </div>
        <div style="margin:10px 0;font-size:18px;">
           <marquee><?php echo $firm_data[0]->firm_address;?></marquee>
        </div>
        <div style="display:inline-block;width:100%;border:1px solid #000;">
        	<table align="center">
			<tr> <td>
			<div style="float:left;width:46.5%;padding:10px;border-right:1px solid #000;min-height: 135px;">
            	<h4 style="margin:0 0 10px; font-size:20px;"><?php echo $firm_data[0]->firm_name;?></h4>
                <p style="margin:0; font-size:18px;">Survey No 21<br />
                    Hissa No 323<br />
					TEEN No <?php echo $firm_data[0]->firm_teen_num;?><br />
                    <?php echo $firm_data[0]->firm_address;?>
					</p>
            </div>
			</td>
			<td>
            <div style="float:left;width:46.5%;padding:10px;min-height: 135px;">
            	<table>
                	<tr>
                    	<td>Invoice</td>
                        <td>:</td>
                        <td>3</td>
                    </tr>
                    <tr>
                    	<td>Date</td>
                        <td>:</td>
                        <td>1-Apr-2007</td>
                    </tr>
                    <tr>
                    	<td>P.O. No</td>
                        <td>:</td>
                        <td>Order No 01</td>
                    </tr>
                    <tr>
                    	<td>Date</td>
                        <td>:</td>
                        <td>1-Apr-2007</td>
                    </tr>
                    <tr>
                    	<td>Vendor Cord No.</td>
                        <td>:</td>
                        <td>Vendor Cord 34</td>
                    </tr>
                </table>
            </div>
			</td>
			</tr>	
			</table>
        </div>
        
        <div style="margin:10px 0 0;">
        	<table style="width:100%;border:1px solid #000;border-collapse:collapse;">
            	<tr>
                	<th style="padding:5px;border:1px solid #000;">Sr. No.</th>
                    <th style="padding:5px;border:1px solid #000;">Description Of Product</th>
                    <th style="padding:5px;border:1px solid #000;">Qty</th>
                    <th style="padding:5px;border:1px solid #000;">Amount</th>
                </tr>
                <tr>
                	<td style="padding:5px;border-right:1px solid #000;">01</td>
                    <td style="padding:5px;border-right:1px solid #000;">Item Name</td>
                    <td style="padding:5px;border-right:1px solid #000;">01</td>
                    <td style="padding:5px;border-right:1px solid #000;">2000</td>
                </tr>
                <tr>
                	<td style="padding:5px;border-right:1px solid #000;">02</td>
                    <td style="padding:5px;border-right:1px solid #000;">Item Name</td>
                    <td style="padding:5px;border-right:1px solid #000;">01</td>
                    <td style="padding:5px;border-right:1px solid #000;">2000</td>
                </tr>
                <tr>
                	<td style="padding:5px;border-right:1px solid #000;">03</td>
                    <td style="padding:5px;border-right:1px solid #000;">Item Name</td>
                    <td style="padding:5px;border-right:1px solid #000;">01</td>
                    <td style="padding:5px;border-right:1px solid #000;">2000</td>
                </tr>
                <tr style="height:300px;">
                	<td style="padding:5px;border-right:1px solid #000;"></td>
                    <td style="padding:5px;border-right:1px solid #000;"></td>
                    <td style="padding:5px;border-right:1px solid #000;"></td>
                    <td style="padding:5px;border-right:1px solid #000;"></td>
                </tr>
                <tr style="border-top:1px solid #000;">
                	<td style="padding:5px;border-right:1px solid #000;"></td>
                    <th style="padding:5px;border-right:1px solid #000;">Total:</th>
                    <td style="padding:5px;border-right:1px solid #000;">03</td>
                    <td style="padding:5px;border-right:1px solid #000;">6000</td>
                </tr>
            </table> 
            <table style="width:100%;border:1px solid #000;border-collapse:collapse;margin:-1px 0 0;">
            	<tr>
                	<td colspan="2" style="padding:5px;vertical-align: top;">
                    	<h4 style="margin:0 0 5px;">TERMS & CONDITIONS:</h4>
                        <p style="margin:0;">Demo Text</p>
                    </td>
                    <td colspan="">
                    	<table style="width:100%;border-collapse:collapse;margin:-2px 2px;">
                        	<tr>
                            	<td style="width:50%;padding:5px;border:1px solid #000;">Excise Duty</td>
                                <td style="width:50%;padding:5px;border:1px solid #000;"">Rs...</td>
                            </tr>
                            <tr>
                            	<td style="width:50%;padding:5px;border:1px solid #000;">Edu Cess 2%</td>
                                <td style="width:50%;padding:5px;border:1px solid #000;"">Rs...</td>
                            </tr>
                            <tr>
                            	<td style="width:50%;padding:5px;border:1px solid #000;">See Cess 1%</td>
                                <td style="width:50%;padding:5px;border:1px solid #000;"">Rs...</td>
                            </tr>
                            <tr>
                            	<td style="width:50%;padding:5px;border:1px solid #000;">Vat @4%</td>
                                <td style="width:50%;padding:5px;border:1px solid #000;"">Rs...</td>
                            </tr>
                            <tr>
                            	<td style="width:50%;padding:5px;border:1px solid #000;font-size:15px;">GRANT TOTAL</td>
                                <td style="width:50%;padding:5px;border:1px solid #000;font-size:15px;">Rs...</td>
                            </tr>
                        </table>
                    </td>
                </tr>
                <tr>
                	<td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">GRANT TOTAL</td>
                    <td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">Rs...</td>
                    <td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">Rs...</td>
                </tr>
                <tr>
                	<td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">GRANT TOTAL</td>
                    <td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">Rs...</td>
                    <td style="width:33%;padding:5px;border:1px solid #000;font-size:15px;">Rs...</td>
                </tr>
            </table>       
        </div>

    </div>
</div>

</body>
</html>
