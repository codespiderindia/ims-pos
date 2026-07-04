<table id="account-result" class="table table-striped table-bordered table-hover orderdetail">
        
        <thead>
            <tr>
                <th class="center" style="width: 25px;">#</th>
                <th>Type</th>
                <th>Place Of Supply</th>
                <th>Rate</th>
                <th>Taxable Value</th>
                <th>Cess Amount</th>
                <th>E-Commerce GSTIN</th>
            </tr>
        </thead>

        <tbody>
            <?php 
            if(isset($saleDetail) && !empty($saleDetail)){
            $i=1;
            foreach($saleDetail as $statename=>$saleDetails){

                if(isset($saleDetails) && !empty($saleDetails)){

                foreach($saleDetails as $tax=>$saleDetailss) {

            ?>
            <tr style="border-bottom: 1px solid;">
                <td class="center"><?php echo $i;?></td>
                <td><?php echo 'OE'; ?></td>
                <td><?php echo $statename; ?></td>
                <td><?php echo $tax; ?></td>
                <td><?php echo $saleDetailss['item_subtotal']; ?></td>
                <td><?php echo ((isset($saleDetailss['cess_amount']) && $saleDetailss['cess_amount'] > 0) ? round($saleDetailss['cess_amount'], 2) : ''); ?></td>
                <td><?php echo $saleDetailss['store_gst_number']; ?></td>
            </tr>
            <?php 
            $i++;
          } } }  }?>
        </tbody>
    </table>