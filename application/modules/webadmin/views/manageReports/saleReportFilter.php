<?php $uinfo = $this->session->userdata('sales_session_info');?>
<style type="text/css">
	.grand_total {
		font-weight: 600;
		font-size: 15px;
	}
	.widget-body .table {
		margin-top: 10px;
	}
	.amount{
		text-align: right !important;
	}
</style>
	<div class="post-search-panel" id="sale_filter_report">
		 <table id="filter_table_dailysale" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Store Name</th>
                        <th>Payment Method</th>
                        <th>Credit Note</th>
                        <th>Remark</th>
                        <th class="amount">Amount</th>
            					</tr>
                  </thead>
                  <tbody>
                      <?php
                       if(isset($sale) && !empty($sale)) {
                      $sum='';
                      $i=1;
                      foreach($sale as $key1=>$sales) { 
                         ?>
                      <tr>
                        <td><?php echo $i; ?></td>
                        <td><?php $storeDetail=store_details_by_id($sales['store_id']);
                          if(isset($storeDetail) && !empty($storeDetail)) {
                            echo $storeDetail[0]['store_name']; } ?></td>
                        <td>
                          Cash: <?php echo (isset($sales['cash']) && $sales['cash'] != '') ? $sales['cash'] : '-' ; ?></br>
                          Debit Card: <?php echo (isset($sales['dcard']) && $sales['dcard'] != '') ? $sales['dcard'] : '-' ; ?></br>
                          Credit Card: <?php echo (isset($sales['ccredit']) && $sales['ccredit'] != '') ? $sales['ccredit'] : '-' ; ?></br>
                          Cheque/Coupon: <?php echo (isset($sales['check']) && $sales['check'] != '') ? $sales['check'] : '-' ; ?></br>
                        </td>
                        <td><?php echo (isset($sales['creditNote']) && $sales['creditNote'] != '') ? $sales['creditNote'] : '-' ; ?></td>
                        <td><?php echo (isset($sales['remark']) && $sales['remark'] != '') ? $sales['remark'] : '-'; ?></td>
                        <td class="amount"><?php echo $sales['total']; ?></td>
                      </tr>
                    <?php $i++; $sum+=$sales['total']; } ?> 
                    <?php } else {  ?>
                        <tr>
                          <td colspan="6"><?php echo 'No Record Found'; ?></td>
                        </tr>
                    <?php } ?>
                  </tbody>
                  <?php  if(isset($sale) && !empty($sale)) { ?>
                  <tfoot>
                    <tr>
                      <td></td>
                      <td>Grand Total</td>
                      <td></td>
                      <td></td>
                      <td></td>
                       <td class="amount"><?php 
                      if(is_float($sum)==true){
                        echo $sum;
                      } else {
                        echo $sum.'.00';
                      } ?></td>
                    </tr>
                  </tfoot>
                  <?php } ?>
            </table>
            <script type="text/javascript">
               jQuery(document).ready(function() {
                <?php if(isset($sale) && !empty($sale)) { ?>
                  var oTable1 = $("#filter_table_dailysale").dataTable({
           
                  "aoColumns": [
                      { "bSortable": false },
                      null, null,null, null, null,
                    ]
                  });
                   <?php } ?>
               });
            </script>
           

			<!--PAGE CONTENT ENDS-->
	</div><!--/.span-->