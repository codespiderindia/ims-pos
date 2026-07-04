<?php $this->load->view('include/layout_header'); ?>

<?php global $uInfo;
$uinfo = $this->session->userdata('sales_session_info');?>

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
	margin: 2px;*/
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

.txtwidth{
	width: 200px;
	margin-left: 2px;
}
.daily_report_content {
	width:100%;
}
.grand_total {
	font-weight: 600;
	font-size: 15px;
}
.report_body {
	padding: 20px;
}
.widget-body .table {
	margin-top: 10px;
}
.report_body_header {
    padding: 10px 0px 0px 15px !important;
}
.date_label, .inline_label {
	vertical-align: middle;
    display: inline-block;
    margin-bottom: 10px;
}
.amount{
		text-align: right !important;
	}
.selector_div {
	width: 30%;
	float: left;
}
</style>
  

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Daily Sales Report</h1>
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
						Daily Report
					</h4>
				</div>

				<div class="widget-body report_body">

					<div class="widget-main table-header report_body_header">
						<div class="selector_div">
							<label class="date_label">Select Date</label>
							<input type="text" placeholder="Select date" name="select_date" id="select_date" class="select_date" />
						</div>
						<div class="">
							<label class="date_label">Select Store</label>
						    <select name="store_name" class="store_name">
						        <option value="">Select Store</option>
						        <?php $compCode = $uInfo['comp_code']; 
						        $allStore=getSku('store',['comp_code'=>$compCode]);
						        if(!empty($allStore)) {
						           foreach($allStore as $allStores) { ?>
						           <option value="<?php echo $allStores['store_id']; ?>"><?php echo trim($allStores['store_name']); ?></option>
						         <?php }
						        } ?>
						    </select>
					    </div>
					</div>

					<div class="container daily_report_content">
    
		<div class="post-search-panel">
			<!-- <input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/> -->
			<?php //echo '<pre>';print_r($report); ?>
			<table id="myTable" class="table table-striped table-borderedss table-hover">
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
							<td><?php 
							$storeDetail=store_details_by_id($reports['store_id']);
							if(isset($storeDetail) && !empty($storeDetail))
							{ echo $storeDetail[0]['store_name']; }
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
					<?php } else { ?>
							<tr><td colspan="8"><?php echo 'No Record Found'; ?></td></tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
			</div>
				</div>

			</div>
		</div>
	</div>
		</div>

<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>

<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>
<?php if(isset($report) && !empty($report)) { ?>
<script type="text/javascript">
	$(document).ready(function() {
		var oTable1 = $('#myTable').DataTable( {
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null, null, null, null, null, null, 
        ]
        });
	});
</script>
<?php } ?>

<script type="text/javascript">

$(function() {

    $('#select_date').datepicker({
		maxDate: new Date(),
		dateFormat:"yy-mm-dd",
		onSelect: function(selected) {
           var date=$(this).val();
           var storeId=$('.store_name').val();
           $.ajax({
           		url:"<?php echo site_url();?>sales/managereports/dailySaleReport/",
           		type:'GET',
           		data:"date="+date+"&store_id="+storeId,
           		success: function(data) {
           			$('.daily_report_content').html(data);
           		}
           })
        }
    });

    $('.store_name').on('change', function() {
    	var date=$('.select_date').val();
        var storeId=$('.store_name').val();
        if(storeId=='') {
        	storeId = 'No Stores';
        }

    	$.ajax({
    		url:"<?php echo site_url();?>sales/managereports/dailySaleReport/",
       		type:'GET',
       		data:"date="+date+"&store_id="+storeId,
       		success: function(data) {
           			$('.daily_report_content').html(data);
           		}
    	})
    });

});
</script>