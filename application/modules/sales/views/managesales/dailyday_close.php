<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('sales_session_info');?>

<style type="text/css">

	.error{

		border: 1px solid red !important;

	}

</style>

<style>

.row{position: relative;}

.post-list{ 

    margin-bottom:20px;

}

div.list-item {

    border-left: 4px solid #7ad03a;

    margin: 5px 15px 2px;

    padding: 1px 12px;

    background-color:#F1F1F1;

    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);

    height: 60px;

}

div.list-item p {

    margin: .5em 0;

    padding: 2px;

    font-size: 13px;

    line-height: 1.5;

}

.list-item a {

    text-decoration: none;

    padding-bottom: 2px;

    color: #0074a2;

    -webkit-transition-property: border,background,color;

    transition-property: border,background,color;-webkit-transition-duration: .05s;

    transition-duration: .05s;

    -webkit-transition-timing-function: ease-in-out;

    transition-timing-function: ease-in-out;

}

.list-item a:hover{text-decoration:underline;}

.list-item h2{font-size:25px; font-weight:bold;text-align: left;}



/* search & filter */

.post-search-panel input[type="text"]{

	width: 220px;

    height: 28px;

    color: #333;

    font-size: 16px;

}

.post-search-panel select{

    height: 34px;

    color: #333;

    font-size: 16px;

}



/* Pagination */

div.pagination {

	font-family: "Lucida Sans Unicode", "Lucida Grande", LucidaGrande, "Lucida Sans", Geneva, Verdana, sans-serif;

	padding:2px;

	margin: 20px 10px;

    float: right;

}



div.pagination a {

	margin: 2px;

	padding: 0.5em 0.64em 0.43em 0.64em;

	background-color: #FD1C5B;

	text-decoration: none; /* no underline */

	color: #fff;

}

div.pagination a:hover, div.pagination a:active {

	/*padding: 0.5em 0.64em 0.43em 0.64em;

	margin: 2px;
*/
	background-color: #FD1C5B;

	color: #fff;

}

div.pagination span.current {

		/*padding: 0.5em 0.64em 0.43em 0.64em;

		margin: 2px;*/

		background-color: #f6efcc;

		color: #6d643c;

	}

div.pagination span.disabled {

		display:none;

	}

.pagination ul li{display: inline-block;}

.pagination ul li a.active{opacity: .5;}



/* loading */

.loading{position: absolute;left: 0; top: 0; right: 0; bottom: 0;z-index: 2;background: rgba(255,255,255,0.7);}

.loading .content {

    position: absolute;

    transform: translateY(-50%);

     -webkit-transform: translateY(-50%);

     -ms-transform: translateY(-50%);

    top: 50%;

    left: 0;

    right: 0;

    text-align: center;

    color: #555;

}
.bold {
	font-weight: 600;
}

</style>


<div class="page-content">

   <div class="page-header position-relative">

      <h1 class="headingThemeColor">Daily Day Close</h1>

      <?php if($this->session->flashdata('error_msg')): ?>

      <div class="alert alert-error">

         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>

         <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />

      </div>

      <?php endif; ?>

      <?php if($this->session->flashdata('success_msg')): ?>

      <div class="alert alert-block alert-success ">

         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>

         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>

      </div>

      <?php endif; ?>

   </div>

   <!--/.page-header-->

   

   <!--/.row-fluid-->

   <div class="row-fluid">

		<div class="span12">

			<div class="widget-box">

				<div class="widget-header">

					<h4 class="smaller">

						Daily Day Close

					</h4>

				</div>


				<div class="widget-body">

					<div class="widget-main">
						<table id="mytable" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th class="center">#</th>
								<th>Cash</th>
								<th>Debit Card</th>
								<th>Credit Card</th>
								<th>Check</th>
								<th>Credit Note</th>
								<th>Total Payment</th>
							</tr>
						</thead>
						<tbody>
							<?php 
						if(!empty($daily_result)) {
							$ctr=1;$cash=0;$dcard=0;$ccard=0;$check=0;$subtotal=0;
							foreach($daily_result as $key=>$daily_results) {

								$cash += (isset($daily_results['cash']) && $daily_results['cash'] != '') ? $daily_results['cash'] : '0' ;

								$dcard += (isset($daily_results['dcard']) && $daily_results['dcard'] != '') ? $daily_results['dcard'] : '0' ;

								$ccard += (isset($daily_results['ccard']) && $daily_results['ccard'] != '') ? $daily_results['ccard'] : '0' ;

								$check += (isset($daily_results['check']) && $daily_results['check'] != '') ? $daily_results['check'] : '0' ;

								$subtotal += (isset($daily_results['sub_total']) && $daily_results['sub_total'] != '') ? $daily_results['sub_total'] : '0' ;
							 ?>
								<tr>	
									<td><?php echo $ctr; ?></td>
									<td class="cash"><?php echo (isset($daily_results['cash']) && $daily_results['cash'] != '') ? $daily_results['cash'] : '-' ; ?></td>

									<td class="dcard"><?php echo (isset($daily_results['dcard']) && $daily_results['dcard'] != '') ? $daily_results['dcard'] : '-' ; ?></td>

									<td class="ccard"><?php echo (isset($daily_results['ccard']) && $daily_results['ccard'] != '') ? $daily_results['ccard'] : '-' ; ?></td>

									<td class="check"><?php echo (isset($daily_results['check']) && $daily_results['check'] != '') ? $daily_results['check'] : '-' ; ?></td>

									<td>-</td>
									<td class="subtotal"><?php echo $daily_results['sub_total']; ?></td>

								</tr>
							<?php $ctr++; } 
							if(isset($daily_retresult) && !empty($daily_retresult))  {
							$key=$ctr;
							$retSubTotal=0;$cnotetotal=0;
							foreach($daily_retresult as $daily_retresults) {
								$retSubTotal += $daily_retresults['sub_total'];

								$cnotetotal += (isset($daily_retresults['cnote']) && $daily_retresults['cnote'] != '') ? $daily_retresults['cnote'] : '0' ;
								 ?>
								<tr>
									<td><?php echo $key; ?></td>
									<td></td>
									<td></td>
									<td></td>
									<td></td>
									<td class="cnote"><?php echo (isset($daily_retresults['cnote']) && $daily_retresults['cnote'] != '') ? $daily_retresults['cnote'] : '-' ; ?></td>
									<td class="subtotal"><?php echo $daily_retresults['sub_total']; ?></td>
								</tr>
							<?php $key++; } } 
							
							/*if($retSubTotal == '') {
								$retSubTotal = 0;
							}*/

							if($subtotal == '') {
								$subtotal = 0;
							}

							?>
							</tbody>
							<tfoot>
								<tr class="bold">
									<td>Total</td>
									<td class="totalcash"><?php echo $cash; ?></td>
									<td class="totaldcard"><?php echo $dcard; ?></td>
									<td class="totalccard"><?php echo $ccard; ?></td>
									<td class="totalcheck"><?php echo $check; ?></td>
									<td class="totalcnote"><?php echo (isset($cnotetotal)) ? $cnotetotal : '-'; ?></td>
									<td class="paymentsubtotal"><?php echo $subtotal+(isset($retSubTotal) ? $retSubTotal : 0); ?></td>
								</tr>
							<?php } ?>
						</tfoot>
					</table>
					<?php 
					/*echo '<pre>';
					print_r($getDayCloseInfo);*/
					if(isset($getDayCloseInfo) && $getDayCloseInfo['userInfo']->day_close == 0) { ?>
					<br>
					<div class="closing_content">
						<label style="width: 20%;display: inline-block; vertical-align: middle;">Do you want to close day.?</label><button class="day_close btn btn-info buttonThemeColor" style="border: none;">Day Close</button>
					</div>
					<?php } ?>

					</div>

				</div>

			</div>

		</div>

	</div>	

			</div>

	</div><!--/.row-fluid-->

</div>

<!--/.page-content-->


<?php $this->load->view('include/layout_footer');?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		var oTable1 = jQuery('#mytable').dataTable({
   		"aoColumns": [
	   	      { "bSortable": false },
	   	      null, null,null, null,null,null,
	        ]
        });

		var url="<?php echo site_url();?>sales/managesales/dayClose";

        $('.day_close').click(function(event){
        	if (confirm('Are you sure you want to closed for today?')) {
        		$.ajax({
	        		url:url,
	        		type:'POST',
	        		data:{
	        			'cash':$('.totalcash').text(),
	        			'dcard':$('.totaldcard').text(),
	        			'ccard':$('.totalccard').text(),
	        			'check':$('.totalcheck').text(),
	        			'cnote':$('.totalcnote').text(),
	        			'total':$('.paymentsubtotal').text()
	        		},
	        		success:function(res) {
	        			if(res != '') {
	        				$('.closing_content').hide();
	        			}
	        		}
	        	});
        	}
        });
	});

</script>

</body>

</html>