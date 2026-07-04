<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style type="text/css">
	.btn_border {
		border: none !important;
	}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Reports</h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
<strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
      <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> 
		 <a target="_blank" href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForStore";?>"></a> | <a target="_blank" href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForWarehouse";?>"></a>
		 </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_mail')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p><strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_mail'); ?></p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('error_mail')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_mail'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
  <div class="row-fluid">
  <script src="//code.jquery.com/jquery-1.12.4.js"></script>
  <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div id="tabs">
  <ul>
    <li><a href="#fragment-1"><span>Sales Summary</span></a></li>
	<li><a href="#fragment-2"><span>Sales Detail</span></a></li>
    <li><a href="#fragment-3"><span>Best Selling Product</span></a></li>
	<li><a href="#fragment-5"><span>Stock Detail</span></a></li>
  </ul>

  <div id="fragment-1">
	  <div class="table-header tableThemeColor filter_titlename">Sales Summary</div>
	  <div class="table-header" id="filters" style="margin-top:10px;background-color: #9f9f9f;"> 
	  	<table>		
	  		<tr>
				<td><label style="margin-top: -10px;text-align: left;" >Start Date : &nbsp;</label> </td>

				<td><label style="margin-top: -10px;text-align: left;" >End Date : &nbsp;</label></td>

			</tr>
			<tr>
				<td>
					<input type="text" id="start_date" name="start_date" />
				</td>
				<td>
					<input type="text" id="end_date" name="end_date"  />
				</td>
				<td width="150px;" style="vertical-align: top; padding-left: 10px; padding-bottom: 12px;"> 

					<button class="btn btn-primary" style="line-height: 19px;" onclick="searchFilter();">
						<i class="fa fa-file-text-o"></i>Show
					</button>
				</td>
			</tr>
		</table>

	   </div>

	    <div class="post-list data_container" id="postList">

            <?php if(!empty($posts)): foreach($posts as $post): ?>

                <div class="list-item"><a href="javascript:void(0);"><h2><?php echo $post['sale_ID']; ?></h2></a></div>

            <?php endforeach; else: ?>

            <p>Sale(s) not available.</p>

            <?php endif; ?>

            <?php //echo $this->ajax_pagination->create_links(); ?>

        </div>

		<input class="btn btn_border print_all" name="print_all" value="Print All" id="print_all_sale_summary" style="" type="button">
  </div>


  
  <div id="fragment-2">
	  <div class="table-header tableThemeColor filter_titlename">Sales Detail</div>
	  <div class="table-header" id="filters" style="margin-top:10px;background-color: #9f9f9f;">  
	  Select From Date <input type="text" style="margin-top:10px;" readonly="" name="detail_from_date" id="detail_from_date"  /> 
	  Select To Date <input type="text" style="margin-top:10px;" readonly="" name="detail_end_date" id="detail_end_date"   /> 

	  Select Store <select name="sale_detail_store" id="sale_detail_store" class="sale_detail_store" style="margin-top:10px;">
	  		<option value=''>Select Store</option>
	  			<?php foreach ($store as $key => $stores) { ?>
	  				<option value="<?php echo $stores->store_id ?>">
	  					<?php echo $stores->store_name; ?></option>
	  			<?php } ?>
	  </select>

		<button class="btn btn-primary" style="line-height: 19px;" onclick="searchFilterSaleDetail();">
			<i class="fa fa-file-text-o"></i>Show
		</button>
	  
	  </div>
	  <div class="post-list data_container" id="postListSaleDetail">

            <?php if(!empty($posts)): foreach($posts as $post): ?>

                <div class="list-item"><a href="javascript:void(0);"><h2><?php echo $post['sale_ID']; ?></h2></a></div>

            <?php endforeach; else: ?>

            <p>Sale(s) not available.</p>

            <?php endif; ?>

            <?php //echo $this->ajax_pagination->create_links(); ?>

        </div>
	  <input class="btn btn_border print_all" name="print_all_sale_detail" value="Print All" id="print_all_sale_detail" style="" type="button" />
  </div>



    <div id="fragment-3">
		<div class="table-header tableThemeColor filter_titlename">Best Selling Product</div>
		<div class="table-header" id="filters" style="margin-top:10px;  background-color: #9f9f9f;"> 

		   Select From Date <input type="text" style="margin-top:10px;" readonly="" name="best_Selling_from_date" id="best_Selling_from_date"  /> 
		  Select To Date <input type="text" style="margin-top:10px;" readonly="" name="best_Selling_end_date" id="best_Selling_end_date"   /> 

		  Select Store <select name="best_selling_store" id="best_selling_store" class="best_selling_store" style="margin-top:10px;">
	  		<option value=''>Select Store</option>
	  			<?php foreach ($store as $key => $stores) { ?>
	  				<option value="<?php echo $stores->store_id ?>">
	  					<?php echo $stores->store_name; ?></option>
	  			<?php } ?>
	  		</select>

			<button class="btn btn-primary" style="line-height: 19px;" onclick="bestSellingProduct();">
				<i class="fa fa-file-text-o"></i>Show
			</button>
					   
		   </div>
		    <div class="post-list data_container" id="best_selling_product_container">

            <?php if(!empty($posts)): foreach($posts as $post): ?>

                <div class="list-item"><a href="javascript:void(0);"><h2><?php echo $post['sale_ID']; ?></h2></a></div>

            <?php endforeach; else: ?>

            <p>Sale(s) not available.</p>

            <?php endif; ?>

            <?php //echo $this->ajax_pagination->create_links(); ?>

        </div>

		   <input class="btn btn_border print_all" style="margin-bottom: 5px;" name="print_all_best_selling_product" value="Print All" id="print_all_best_selling_product"  type="button" />
	</div>

	<div id="fragment-5">
		<div class="table-header tableThemeColor filter_titlename">Stock Detail</div>
		<div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">
			
			Location : <select id="dd_loc" name="dd_loc" class="txtwidth" style="margin-top:10px;">

						<option value="">Select Location</option>

						<?php 
						if(isset($locs) && !empty($locs)){ ?>
						<?php foreach($locs as $loc) { ?>
						<option value="<?php echo $loc['id'];?>">
							<?php echo $loc['location_name'];?>
						</option>
						<?php
							}
						}
						?>
				</select>

				Store: <select id="dd_store" name="dd_store" class="txtwidth" style="margin-top:10px;">
						<option value="">Select Store</option>
						
					</select>

				Product: <select id="dd_item" name="dd_item" class="txtwidth" style="margin-top:10px;">
					<option value="">Select Product</option>
					<option value="all">All</option>
						<option value="">Select Product</option>
							<?php 
							if(isset($products) && !empty($products)){
							foreach($products as $prd) { ?>
							<option value="<?php echo $prd['product_id'];?>">
								<?php echo $prd['product_name'];?>
							</option>
							<?php }	} ?>
						</select>	

			<button class="btn btn-primary" style="line-height: 22px;" onclick="stockDetail();">
							<i class="fa fa-file-text-o"></i>
							Show
						</button>
				<br />
				</div>

				<div class="data_container" id="stock_detail_container">
			   </div>
			   <br>
		  <input class="btn btn_border print_all" style="margin-bottom: 5px;" name="print_all_stock_detail" value="Print All" id="print_all_stock_detail"  type="button">
	</div>

</div>
 
<script>
$( "#tabs" ).tabs();
</script>
            <!--/span-->
         </div>
         <!--/row-->
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>

<script>

$( "#print_all_sale_summary" ).click(function() {

	var from_date = $('#start_date').val();
	var end_date = $('#end_date').val();
		if(from_date=='') {
			alert('Please select From Date.');return false;
		}
		if(end_date=='') {
			alert('Please select To Date.');return false;
		}
		window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfSaleSummary/?from_date='+from_date+'&end_date='+end_date;
		return false;
});


$( "#print_all_sale_detail" ).click(function() {

	var from_date = $('#detail_from_date').val();
	var end_date = $('#detail_end_date').val();
		if(from_date=='') {
			alert('Please select From Date.');return false;
		}
		if(end_date=='') {
			alert('Please select To Date.');return false;
		}
		window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfSaleDetail/?from_date='+from_date+'&end_date='+end_date;
		return false;
});



$( "#print_all_best_selling_product" ).click(function() {

	var from_date = $('#best_Selling_from_date').val();
	var end_date = $('#best_Selling_end_date').val();
		if(from_date=='') {
			alert('Please select From Date.');return false;
		}
		if(end_date=='') {
			alert('Please select To Date.');return false;
		}
		window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfSellingProduct/?from_date='+from_date+'&end_date='+end_date;
		return false;
});



$( "#print_all_stock_detail" ).click(function() {

	var dd_loc = $('#dd_loc').val();
	var dd_store = $('#dd_store').val();
	var dd_item = $('#dd_item').val();

		if(dd_loc=='') {
			alert('Please select Location.');return false;
		}
		if(dd_store=='') {
			alert('Please select Store.');return false;
		}
	/*	if(dd_item=='') {
			alert('Please select To Date.');return false;
		}*/
		window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfStockDetail/?loc_id='+dd_loc+'&store_id='+dd_store+'&item_id='+dd_item;
		return false;
});

/*$('.print_all').on('click', function() {
	var filterinfo = $(this).parent('.ui-tabs-panel').find('.data_container').html();
	var filter_titlename = $(this).parent('.ui-tabs-panel').find('.filter_titlename').html();

	//window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdf/'+filterinfo+'/'+filter_titlename;

	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>webadmin/managereport/generatePdf/',
		data:{filterinfo:filterinfo,filter_titlename:filter_titlename},
		success: function (html) {

		}
	});

return false;
});*/


// For Sale Summary
function searchFilter(page_num) {


	page_num = page_num?page_num:0;

	var keywords = $('#keywords').val();

	var sortBy = $('#sortBy').val();

	var startDate = $( "#start_date" ).datepicker( "getDate" );

	startDate=$.datepicker.formatDate('dd-mm-yy', startDate);

	var endDate = $( "#end_date" ).datepicker( "getDate" );

	endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

	if(startDate == '') {
		alert('Please Select Start Date.');
		return false;
	} else if(endDate == '') {
		alert('Please Select End Date.');
		return false;
	} else {
		var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate;

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>webadmin/managereport/sales_summary/'+page_num,
			data:url,
			success: function (html) {
				$('#postList').html(html);

				$('.loading').fadeOut("slow");
			}
		});
	}

	
}



// For Sale Detail
function searchFilterSaleDetail(page_num) {
	page_num = page_num?page_num:0;

	var keywords = $('#keywords').val();

	var sortBy = $('#sortBy').val();

	var startDate = $( "#detail_from_date" ).datepicker( "getDate" );

	startDate=$.datepicker.formatDate('dd-mm-yy', startDate);

	var endDate = $( "#detail_end_date" ).datepicker( "getDate" );

	endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

	if(startDate == '') {
		alert('Please Select Start Date.');
		return false;
	} else if(endDate == '') {
		alert('Please Select End Date.');
		return false;
	} else {
		var saleDetailStore = $("#sale_detail_store").val();

		var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate+'&storeId='+saleDetailStore;

		//alert(url);

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>webadmin/managereport/sales_detail/'+page_num,
			data:url,
			success: function (html) {
				$('#postListSaleDetail').html(html);
				$('.loading').fadeOut("slow");
			}
		});
	}

	
}


function bestSellingProduct(page_num) {
	page_num = page_num?page_num:0;
	var keywords = $('#keywords').val();
	var sortBy = $('#sortBy').val();

	var startDate = $( "#best_Selling_from_date" ).datepicker( "getDate" );
	startDate=$.datepicker.formatDate('dd-mm-yy', startDate);
	var endDate = $( "#best_Selling_end_date" ).datepicker( "getDate" );
	endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

	if(startDate == '') {
		alert('Please Select Start Date.');
		return false;
	} else if(endDate == '') {
		alert('Please Select End Date.');
		return false;
	} else {
		var storeId = $("#best_selling_store").val();
		var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate+'&storeId='+storeId;
		//alert(url);

		$.ajax({
			type: 'POST',
			url: '<?php echo base_url(); ?>webadmin/managereport/best_selling/'+page_num,
			data:url,
			success: function (html) {
				$('#best_selling_product_container').html(html);
				$('.loading').fadeOut("slow");
			}
		});
	}
	
}



function stockDetail(page_num) {
	page_num = page_num?page_num:0;
	var keywords = $('#keywords').val();
	var sortBy = $('#sortBy').val();

	var itemID= $('#dd_item').val();
	var locID= $('#dd_loc').val();
	var storeID= $('#dd_store').val();
	
	if(locID=="" || storeID==""){
		alert("Please select location and store!");
		return false;
	}

	var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&itemID='+itemID+'&locID='+locID+"&storeID="+storeID;

	$.ajax({
		type: 'POST',
		url: '<?php echo base_url(); ?>webadmin/managereport/item_stock/'+page_num,
		data:url,
		beforeSend: function () {
			//$('.loading').show();
		},
		success: function (html) {
			//alert(html);
			$('#stock_detail_container').html(html);
			$('.loading').fadeOut("slow");
		}
	});
}


  
  
/*$( "#print_all" ).click(function() {
window.location.href =  '<?php echo site_url();?>webadmin/managereport/pdfPrintBankActAll';
return false;
   			});
  $( "#export_to_csv_all" ).click(function() {
   	window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_all';
	return false;
   		});
		
		
  $( "#export_to_csv_with_filters" ).click(function() {
   		var bank_from_date = $('#bank_from_date').val();
		var bank_end_date = $('#bank_end_date').val();
			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_filters/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date;
			return false;
   			
   		});
		
		$( "#print_with_filters" ).click(function() {
   		var bank_from_date = $('#bank_from_date').val();
		var bank_end_date = $('#bank_end_date').val();
			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_bank_acount_filters/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date;
			return false;
   		});
		
		$( "#export_to_csv_all_cash_book" ).click(function() {
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_all_cash_book';
			return false;
   		});
		
		$( "#print_all_cash_book" ).click(function() {
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_cash_book';
			return false;
   		});
		
		 $( "#export_to_csv_with_filters_csh_book" ).click(function() {
   		var bank_from_date = $('#cash_from_date').val();
		var bank_end_date = $('#cash_end_date').val();
			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_filters_cash_book/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date;
			return false;
   			
   		});
		 $( "#print_filters_cash_book" ).click(function() {
   		var bank_from_date = $('#cash_from_date').val();
		var bank_end_date = $('#cash_end_date').val();
			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_filters_cash_book/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date;
			return false;
   			
   		});
		
		$( "#export_all_dealer" ).click(function() {
   		var dealer = $('#dealer').val();
		if(dealer=='') {  alert("Please select dealer."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_dealer/?dealer_id='+dealer;
			return false;
   			
   		});
		
		
		$( "#print_all_dealer" ).click(function() {
   		var dealer = $('#dealer').val();
		if(dealer=='') {  alert("Please select dealer."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_dealer/?dealer_id='+dealer;
			return false;
   			
   		});
		
		
		$( "#export_all_dealer_by_filter" ).click(function() {
   		var dealer_from_date = $('#dealer_from_date').val();
				var dealer_end_date = $('#dealer_end_date').val();
				var dealer = $('#dealer').val();
		if(dealer=='') {  alert("Please select dealer."); return false; }
			if(dealer_from_date=='') {  alert("Please select From Date."); return false; }
			if(dealer_end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_dealer_filter/?dealer_id='+dealer+'&from_date='+dealer_from_date+'&to_date='+dealer_end_date;
			return false;
   			
   		});
		
		
			
		$( "#print_all_dealer_by_filter" ).click(function() {
   		var dealer_from_date = $('#dealer_from_date').val();
				var dealer_end_date = $('#dealer_end_date').val();
				var dealer = $('#dealer').val();
		if(dealer=='') {  alert("Please select dealer."); return false; }
			if(dealer_from_date=='') {  alert("Please select From Date."); return false; }
			if(dealer_end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_dealer_filter/?dealer_id='+dealer+'&from_date='+dealer_from_date+'&to_date='+dealer_end_date;
			return false;
   			
   		});
		
		$( "#export_all_vendor" ).click(function() {
   		var vendor = $('#vendor').val();
		if(vendor=='') {  alert("Please select Vendor."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_vendor/?vendor_id='+vendor;
			return false;
   		});
		$( "#print_all_vendor" ).click(function() {
   		var vendor = $('#vendor').val();
		if(vendor=='') {  alert("Please select Vendor."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_vendor/?vendor_id='+vendor;
			return false;
   		});
		
		$( "#export_all_vendor_by_filter" ).click(function() {
   		var from_date = $('#vendor_from_date').val();
		var end_date = $('#vendor_end_date').val();
		var vendor = $('#vendor').val();
		if(vendor=='') {  alert("Please select vendor."); return false; }
			if(from_date=='') {  alert("Please select From Date."); return false; }
			if(end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_vendor_filter/?vendor_id='+vendor+'&from_date='+from_date+'&to_date='+end_date;
			return false;
   			
   		});
			$( "#print_all_vendor_by_filter" ).click(function() {
   		var from_date = $('#vendor_from_date').val();
		var end_date = $('#vendor_end_date').val();
		var vendor = $('#vendor').val();
		if(vendor=='') {  alert("Please select vendor."); return false; }
			if(from_date=='') {  alert("Please select From Date."); return false; }
			if(end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_vendor_filter/?vendor_id='+vendor+'&from_date='+from_date+'&to_date='+end_date;
			return false;
   			
   		});*/
		
		
  	$( "#dealer" ).change(function() {
   		
			var dealer_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getDealerPayments";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {dealer_id:dealer_id},
		    success: function(datas){
   			$('#dealer_payment_result').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		
			$( "#vendor" ).change(function() {
			var vendor_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getVendorPayments";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {vendor_id:vendor_id},
		    success: function(datas){
   			$('#vendor_payment_result').html(datas);
   				//alert(data);
   			}
   			});
   			
   		});
		
		$( "#search_bank_report" ).click(function() {
   		
			var bank_from_date  = $('#bank_from_date').val(); 
			var bank_end_date  = $('#bank_end_date').val(); 
			if(bank_from_date=='') {  alert("Please select From Date"); return false;}
			if(bank_end_date=='') {  alert("Please select To Date"); return false;}
   			var url="<?php echo site_url();?>webadmin/managereport/bankReportByDate";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {bank_from_date:bank_from_date,bank_end_date:bank_end_date},
		    success: function(datas){
   			$('#bank_account_result').html(datas);
   				//alert(data);
   			}
   			});
   			
   		});
		
			$( "#search_cash_report" ).click(function() {
   		    var cash_from_date  = $('#cash_from_date').val(); 
			var cash_end_date  = $('#cash_end_date').val(); 
			if(cash_from_date=='') {
			alert('Please select From Date');
			return false;
			} 
			
			if(cash_end_date=='') {
			alert('Please select To Date');
			return false;
			} 
   			var url="<?php echo site_url();?>webadmin/managereport/cashReportByDate";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {cash_from_date:cash_from_date,cash_end_date:cash_end_date},
		    success: function(datas){
   			$('#result_cashbook').html(datas);
   				//alert(data);
   			}
   			});
   			
   		});
		
		$( "#search_dealer_report" ).click(function() {
   		
			var dealer_from_date  = $('#dealer_from_date').val(); 
			var dealer_end_date  = $('#dealer_end_date').val(); 
			var dealer_id  = $('#dealer').val(); 
   			if(dealer_id=='') {
			alert('Please Select Dealer.');
			return false;
			}
			if(dealer_from_date=='') {
			alert('Please Select From Date.');
			return false;
			}
			
			if(dealer_end_date=='') {
			alert('Please Select To Date.');
			return false;
			}
			var url="<?php echo site_url();?>webadmin/managereport/dealerReportByDate";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {dealer_from_date:dealer_from_date,dealer_end_date:dealer_end_date,dealer_id:dealer_id},
		    success: function(datas){
   			$('#dealer_payment_result').html(datas);
   			//alert(data);
   			}
   			});
   		});
		
		$( "#search_vendor_report" ).click(function() {
			var vendor_from_date  = $('#vendor_from_date').val(); 
			var vendor_end_date  = $('#vendor_end_date').val(); 
			var vendor_id  = $('#vendor').val(); 
   			if(vendor_id=='') {
			alert('Please Select Vendor.');
			return false;
			}
			if(vendor_from_date=='') {
			alert('Please Select From Date.');
			return false;
			}
			
			if(vendor_end_date=='') {
			alert('Please Select To Date.');
			return false;
			}
			var url="<?php echo site_url();?>webadmin/managereport/vendorReportByDate";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {vendor_from_date:vendor_from_date,vendor_end_date:vendor_end_date,vendor_id:vendor_id},
		    success: function(datas){
   			$('#vendor_payment_result').html(datas);
   			//alert(data);
   			}
   			});
   		});

   		
   	$("#search_product_report").click(function() {
   		var productId  = $('#product').val(); 
   		if(product=='') {
			alert('Please Select Product Name.');
			return false;
		}
		var url="<?php echo site_url();?>webadmin/managereport/getProductById";
		$.ajax({
			url: url,
			type:'GET',
			data: {productId:productId},
	    success: function(datas){
			$('#product_payment_result').html(datas);
			//alert(data);
			}
			});
   	});
</script>
<script type="text/javascript">

$(function() {

	 $("#dd_loc").on("change",function(){
    	var locID  = $(this).val();
   		var url="<?php echo site_url();?>webadmin/managereport/getStoresByLoc";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"locID="+locID,
		    success: function(data){
			
   		    $('#dd_store').html(data);
   			}
   			
			});
	});


    $("#start_date").datepicker({
        maxDate: new Date(),
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
        var date = $(this).datepicker('getDate');
        }

    });

	$("#end_date").datepicker({ 
       defaultDate: "+1w",
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
           $(this).datepicker("option","maxDate", selected)
        }
    });

     $("#detail_from_date").datepicker({
        maxDate: new Date(),
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
        var date = $(this).datepicker('getDate');
        }

    });

	$("#detail_end_date").datepicker({ 
       defaultDate: "+1w",
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
           $(this).datepicker("option","maxDate", selected)
        }
    });

    $("#best_Selling_from_date").datepicker({ 
       defaultDate: "+1w",
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
           $(this).datepicker("option","maxDate", selected)
        }
    });


    $("#best_Selling_end_date").datepicker({ 
       defaultDate: "+1w",
        numberOfMonths: 1,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
           $(this).datepicker("option","maxDate", selected)
        }
    });
});
</script>

<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>

<script>
 $(function(){
 $("#cash_book_tab").click(function(){
 $('#cash_book #result_cashbook').load('<?php echo base_url(); ?>webadmin/managereport/cashBook');
 	$('.cash_book_links').find('a').removeAttr('href');
 	//$("#cashbook-table").dataTable({"bSort": false,"iDisplayLength": 2 });
   });
  });
</script>
<!-- Theme Color Change End -->
<script src="<?php echo base_url(); ?>/assets/js/jquery-ui.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
	jQuery(function($) {
	    $(".bank_date").datepicker({ 
	    	dateFormat: "dd-mm-yy",
	    	maxDate: new Date()
	    	 });
	   //   $( ".bank_date" ).datepicker();
		      //$( "#end_date" ).datepicker();
	   //$('#start_date').datepicker();
	   
	   $('.cash_book_links a').click(function() {
	   	  alert('test');
	   	  alert($(this).attr('href'));
	   });
	});
</script>
</body>
</html>