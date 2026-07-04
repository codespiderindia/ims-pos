
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
		<table id="myTables" class="table table-striped table-borderedss table-hover">
			<thead>
				<tr>
					<th>#</th>
					<th>Store Name</th>
					<th>Cash</th>
					<th>Credit Card</th>
					<th>Debit Card</th>
					<th>Check</th>
					<th>Credit Note</th>
					<th class="amount">Amount</th>
				</tr>
			</thead>
			<tbody>
				<?php if(isset($report) && !empty($report)) {
					$sum='';
					$i=1;
					foreach($report as $key1=>$reports) { 
						 ?>
					<tr>
						<td><?php echo $i; ?></td>
						<td><?php if(isset($reports['store_id']) && $reports['store_id'] != '') {
								$storeDetail = store_details_by_id($reports['store_id']);
								echo $storeDetail[0]['store_name'];
							} 
						  ?></td>
						<td><?php echo (isset($reports['cash']) && $reports['cash'] != '') ? $reports['cash'] : '-' ; ?></td>

						<td><?php echo (isset($reports['ccredit']) && $reports['ccredit'] != '') ? $reports['ccredit'] : '-' ; ?></td>

						<td><?php echo (isset($reports['dcard']) && $reports['dcard'] != '') ? $reports['dcard'] : '-' ; ?></td>

						<td><?php echo (isset($reports['check']) && $reports['check'] != '') ? $reports['check'] : '-' ; ?></td>
						
						<td><?php echo (isset($reports['creditNote']) && $reports['creditNote'] != '') ? $reports['creditNote'] : '-' ; ?></td>
						<td class="amount"><?php echo $reports['total']; ?></td>
					</tr>
				<?php $i++; $sum+=$reports['total']; } ?>
				<tr class="grand_total">
					<td>Grand Total</td>
					<td></td>
					<td></td>
					<td></td>
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
				<?php  } else { ?>
					<tr><td colspan="8"><?php echo 'No Record Found'; ?></td></tr>
				<?php } ?>
			</tbody>
			<tr>
				
			</tr>
		</table>

<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>
<?php if(isset($report) && !empty($report)) { ?>
<script type="text/javascript">
	$(document).ready(function() {
		var oTable1 = $('#myTables').dataTable( {
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null, null,null, null,
        ]
        });
	});
</script> 
<?php } ?>

			<!--PAGE CONTENT ENDS-->
	</div><!--/.span-->