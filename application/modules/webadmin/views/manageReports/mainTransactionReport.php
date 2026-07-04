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
    <li><a href="#fragment-1"><span>Bank Account</span></a></li>
	<li><a id="cash_book_tab" href="#cash_book"><span>Cash Book</span></a></li>
    <li><a href="#fragment-3"><span>Dealers</span></a></li>
    <li><a href="#fragment-4"><span>Vendors</span></a></li>
	<!--<li><a href="#fragment-5"><span>Products</span></a></li>-->
	<li><a id="daily_sale_report_tab" href="#fragment-6"><span>Daily Sale Report</span></a></li>
	<li><a href="#fragment-7"><span>Warehouse Inventory</span></a></li>
	<li><a href="#fragment-8"><span>Store Inventory</span></a></li>
	<li><a href="#fragment-9"><span>B2B Details</span></a></li>
	<li><a href="#fragment-10"><span>B2C Details</span></a></li>
	<li><a href="#fragment-11"><span>Daily Short Details</span></a></li>
  </ul>

  <div id="fragment-1">
  <div class="table-header tableThemeColor">Bank Account</div>
  <div class="table-header" id="filters" style="margin-top:10px;background-color: #9f9f9f;"> 
  Select From Date <input type="text" style="margin-top:10px;" readonly="" name="bank_from_date" id="bank_from_date" class="bank_date" />
  Select To Date <input type="text" style="margin-top:10px;" readonly="" name="bank_end_date" id="bank_end_date" class="bank_date" />

  	Select Type<select name="type" class="type" id="type" style="margin-top:10px;">
		  	<option value="">Select Type</option>
		  	<option value="all">All</option>
		  	<option value="1">Dealer</option>
		  	<option value="2">Vendor</option>
  		</select>
  
  <input class="btn btn_border" name="search" value="Search" id="search_bank_report" style="" type="button">
  
    <input class="btn btn_border" name="export_to_csv_all" value="Export All" id="export_to_csv_all" style="margin-bottom:10px;" type="button">
	
    <input class="btn btn_border" name="export_to_csv_with_filters" value="Export as per Filters" id="export_to_csv_with_filters" style="margin-bottom:10px;" type="button" >
	
   </div>

  	<div id="bank_account_result" class="bank_account_result">
  		
       <table id="myTables" class="table table-striped table-borderedss table-hover">
          <thead>
             <tr>
                <th>Date</th>
				<th>Trans No.</th>
                <th>Mode Of Payment</th>
                <th>Debit </th>
				<th>Credit</th>
				<th>Pay By</th>
				<th>Balance</th>
			 </tr>
          </thead>
          <tbody>
             <?php if(!empty($bankAcount)) {
             foreach($bankAcount as $bankAcountRow) {
             	if($bankAcountRow->dealer_vender_other == 1) {
             		$payBy = 'Dealer';
             	} else {
             		$payBy = 'Vendor';
             	}
             	if($bankAcountRow->total_balance >=0) {
             		$amt = $bankAcountRow->total_balance;
             	} else {
             		$amt = 0;
             	}
              ?>
             <tr>
                <td><?php echo $bankAcountRow->created_date;?></td> 
				<td><?php echo $bankAcountRow->transaction_id;?></td>
				<td><?php echo $bankAcountRow->mode_of_payment;?></td>  
                <td><?php echo $bankAcountRow->debit;?></td>
				<td><?php echo $bankAcountRow->credit;?></td>
				<td><?php echo $payBy;?></td>
				<td><?php echo $amt;?></td>
				</tr>
		  <?php } } ?>
			</tbody>
       </table>
	</div>
<br>
	<input class="btn btn_border" name="print_all" value="Print All" id="print_all" style="" type="button">
	
    <input class="btn btn_border" name="print_with_filters" value="Print as per Filters" id="print_with_filters" style="" type="button">
  </div>
  
  <div id="cash_book">
  <div class="table-header tableThemeColor">CashBook</div>
  <div class="table-header" id="filters" style="margin-top:10px;background-color: #9f9f9f;">  
  Select From Date <input type="text" style="margin-top:10px;" readonly="" name="cash_from_date" id="cash_from_date" class="bank_date"   /> 
  Select To Date <input type="text" style="margin-top:10px;" readonly="" name="cash_end_date" id="cash_end_date" class="bank_date"   /> 

  Select Type<select name="cash_type" class="cash_type" id="cash_type" style="margin-top:10px;">
		  	<option value="">Select Type</option>
		  	<option value="all">All</option>
		  	<option value="1">Dealer</option>
		  	<option value="2">Vendor</option>
  		</select>



  <!--Select Store <select name="cashStore" class="cashStore" id="cashStore">
  	<option value="">Select Store</option>
  	<?php 
  	foreach($store as $stores) { ?>
  	<option value="<?php echo $stores->store_id ?>"><?php echo $stores->store_name; ?></option>
  	<?php } ?>
  </select>-->

  
<input class="btn btn_border" name="search" value="Search" id="search_cash_report" style="" type="button" />
<input class="btn btn_border" name="export_to_csv_all_cash_book" value="Export All" id="export_to_csv_all_cash_book" style="margin-bottom:10px;" type="button" />
<input class="btn btn_border" name="export_to_csv_with_filters_csh_book" value="Export as per Filters" id="export_to_csv_with_filters_csh_book" style="margin-bottom:10px;" type="button" />
  </div>
  <div id="result_cashbook" class="result_cashbook">
  
  </div>
   <br>
  <input class="btn btn_border" name="print_all_cash_book" value="Print All" id="print_all_cash_book" style="" type="button" />
 
  <input class="btn btn_border" name="print_filters_cash_book" value="Print As per Filter" id="print_filters_cash_book" style="" type="button">
  </div>

    <div id="fragment-3">
			<div class="table-header tableThemeColor">Dealer's Payment</div>
			<div class="table-header" id="filters" style="margin-top:10px;  background-color: #9f9f9f;">  
			   Select Dealer <select name="dealer" id="dealer" style="margin-top:10px;"><option value="">Select Dealer</option>
			   <?php  foreach($users as $user) { ?>  
			   <option value="<?php echo  $user->dealer_id; ?>"><?php echo  $user->f_name." ".$user->l_name; ?></option>
			    <?php }?>
			   </select>
			     Select From Date <input style="margin-top:10px;" readonly="" name="dealer_from_date" id="dealer_from_date" class="bank_date" type="text"> 
  Select To Date <input style="margin-top:10px;" readonly="" name="dealer_end_date" id="dealer_end_date" class="bank_date" type="text"> 
<input class="btn btn_border" name="search" value="Search" id="search_dealer_report" style="" type="button"> <br />
<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_dealer" value="Export All" id="export_all_dealer"  type="button">
<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_dealer_by_filter" value="Export as per Filters" id="export_all_dealer_by_filter"  type="button">
			   
			   </div>
			   <div id="dealer_payment_result">
			   </div> 
			   <br>
			   <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_dealer" value="Print All" id="print_all_dealer"  type="button" />
			   
			   <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_dealer_by_filter" value="Print as per Filters" id="print_all_dealer_by_filter"  type="button" />
	</div>

<div id="fragment-4">
<div class="table-header tableThemeColor">Vendor's Payment</div>
<div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">  
			   Select Vendor <select name="vendor" id="vendor" style=" margin-top:10px;"><option value="">Select Vendor</option>
			   <?php  foreach($vendor as $vendor) { ?>  
			   <option value="<?php echo $vendor->vendor_id; ?>"><?php echo  $vendor->f_name." ".$vendor->l_name; ?></option>
			    <?php }?>
			   </select>
			    Select From Date <input style="margin-top:10px;" readonly="" name="vendor_from_date" id="vendor_from_date" class="bank_date" type="text"> 
  Select To Date <input style="margin-top:10px;" readonly="" name="vendor_end_date" id="vendor_end_date" class="bank_date" type="text"> 
<input class="btn btn_border" name="search" value="Search" id="search_vendor_report" style="" type="button">
<br />
<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_vendor" value="Export All" id="export_all_vendor"  type="button">
<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_vendor_by_filter" value="Export as per Filters" id="export_all_vendor_by_filter"  type="button">

			   </div>
			   <div id="vendor_payment_result">
			   </div> 
			   <br>
			   <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_vendor" value="Print All" id="print_all_vendor"  type="button">
				<input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_vendor_by_filter" value="Print as per Filters" id="print_all_vendor_by_filter"  type="button">
	</div>

	<!--<div id="fragment-5">
		<div class="table-header tableThemeColor">Products</div>
		<div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">
			Select Product<select name="product" id="product">
				<option value="">Select Product</option>
				<?php  foreach($product as $products) { ?>  
			   <option value="<?php echo $products->product_id; ?>">
			   	<?php echo $products->product_name; ?></option>
			    <?php }?>
				</select>

				Select From Date <input style="margin-top:10px;" readonly="" name="product_from_date" id="product_from_date" class="product_date" type="text"> 
  				Select To Date <input style="margin-top:10px;" readonly="" name="product_end_date" id="product_end_date" class="product_date" type="text"> 

				<input class="btn btn_border" name="search" value="Search" id="search_product_report" style="" type="button">
				<br />

				<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_product" value="Export All" id="export_all_product"  type="button">
				<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_product_by_filter" value="Export as per Filters" id="export_all_product_by_filter"  type="button">
		</div>
				<div id="product_payment_result">
			   </div>
		

		  <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_product" value="Print All" id="print_all_product"  type="button">
			<input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_product_by_filter" value="Print as per Filters" id="print_all_product_by_filter"  type="button">
	</div>-->

	<div id="fragment-6">
	</div>

	<div id="fragment-7">
		<div class="table-header tableThemeColor">Warehouse Inventory</div>
		<div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">

			<?php $category = getProductCategoryParentNull($uinfo['comp_code']); ?>

			Select Category<select name="category" id="warehousecategory" class="warehousefilter" style="margin-top: 10px;">
				<option value="">Select Category</option>
				<option value="all">All</option>
				<?php  foreach($category as $categorys) { ?> 
				 	<option value="<?php echo $categorys['product_cat_id']; ?>">
				   	<?php echo $categorys['cat_name']; ?></option>
				<?php }  ?>
			</select>


			Sub Category 
		    <select name="product_sub_category" id="product_sub_category" style="margin-top: 10px; width: 11%;" >
		    	<option value=""> Select Sub Category </option>
		    </select>


		    Sub Of Sub Category <select name="product_sub_category" id="product_sub_of_sub_category" style="margin-top: 10px; width: 11%;" >
		    <option value=""> Select Sub Of Sub Category </option>
		  	</select> 


		  	Select Attribute <select name="product_attribute" id="product_attribute" style="margin-top: 10px; width: 11%;">
		    <?php $attrWhere = ['comp_code'=>$uinfo['comp_code'], 'attribute_status'=>1];
			    $getAttribute = getSku('attributes', $attrWhere); ?>
			    <option value=""> Select Attribute </option>
			    <?php
			        foreach($getAttribute as $getAttributes) { ?>
			        <option value="<?php echo $getAttributes['attribute_id']; ?>"><?php echo $getAttributes['attribute_name']; ?></option>
			       <?php }
			     ?>
			</select>


			Select Product<select name="product" id="warehouseproduct" class="warehousefilter" style="margin-top: 10px;>
				<option value="">Select Product</option>
				<?php if(!empty($product)) { ?>
					<option value="allproduct">All</option>
				<?php } ?>
				<?php  foreach($product as $products) { ?>  
			   <option value="<?php echo $products->product_id; ?>">
			   	<?php echo $products->product_name; ?></option>
			    <?php }?>
			</select>


			<input class="btn btn_border" name="search" value="Search" id="search_warehouse_inventory_report" style="" type="button">
			<br />

			<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_warehouse_inventory" value="Export All" id="export_all_warehouse_inventory"  type="button">

		</div>

		<div id="warehouse_inventory_result">
		</div>
		<br>
		 <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_warehouse_inventory" value="Print All" id="print_all_warehouse_inventory"  type="button">

	</div>

	<div id="fragment-8">
		<div class="table-header tableThemeColor">Store Inventory</div>
		<div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">

			<?php $category = getProductCategoryParentNull($uinfo['comp_code']); ?>

			Select Category<select name="category" id="storecategory" class="warehousefilter"  style="margin-top:10px;">
				<option value="">Select Category</option>
				<option value="all">All</option>
				<?php  foreach($category as $categorys) { ?> 
				 	<option value="<?php echo $categorys['product_cat_id']; ?>">
				   	<?php echo $categorys['cat_name']; ?></option>
				<?php }  ?>
				</select>



			Select Attribute <select name="store_attribute" id="store_attribute" style="margin-top: 10px; width: 27%;">
		    <?php $attrWhere = ['comp_code'=>$uinfo['comp_code'], 'attribute_status'=>1];
			    $getAttribute = getSku('attributes', $attrWhere); ?>
			    <option value=""> Select Attribute </option>
			    <?php
			        foreach($getAttribute as $getAttributes) { ?>
			        <option value="<?php echo $getAttributes['attribute_id']; ?>"><?php echo $getAttributes['attribute_name']; ?></option>
			       <?php }
			     ?>
			</select>



			Select Product<select name="product" id="storeproduct"  style="margin-top:10px;">
				<option value="">Select Product</option>
				<?php if(!empty($product)) { ?>
					<option value="allproduct">All</option>
				<?php } ?>

				<?php  foreach($product as $products) { ?>  
			   <option value="<?php echo $products->product_id; ?>">
			   	<?php echo $products->product_name; ?></option>
			    <?php }?>
				</select>
			

			Select Store<select name="store" id="store" class="storefilter" style="margin-top:10px;">
				<option value="">Select Store</option>
				<?php  foreach($store as $stores) { ?> 
					<option value="<?php echo $stores->store_id; ?>">
				   	<?php echo $stores->store_name; ?></option>
				<?php } ?>
			</select>

			<input class="btn btn_border" name="search" value="Search" id="search_store_inventory_report" style="" type="button">
			<br />

			<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_store_inventory" value="Export All" id="export_all_store_inventory"  type="button">

		</div>

		<div id="store_inventory_result">
		</div>
		<br>
		 <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_store_inventory" value="Print All" id="print_all_store_inventory"  type="button">

	</div>


	<div id="fragment-9">
		<div class="table-header tableThemeColor filter_titlename">B2B Details</div>
		<div class="table-header" id="filters" style="margin-top:10px;  background-color: #9f9f9f;"> 

			Select From Date <input type="text" style="margin-top:10px;" readonly="" name="order_detail_from_date" id="order_detail_from_date"  /> 

		 	Select To Date <input type="text" style="margin-top:10px;" readonly="" name="order_detail_end_date" id="order_detail_end_date"   />


		 	<?php $getDealerGst = getSku('dealer',['comp_code'=>$uinfo['comp_code']]); ?>
		 	Select GSTN<select name="gst_number_b2b" id="gst_number_b2b" style="margin-top:10px;">
		 		<option value="">Select GSTIN</option>
		 		<?php foreach($getDealerGst as $getDealerGsts) { ?>
		 			<option value="<?php echo $getDealerGsts['dealer_id']; ?>"><?php echo $getDealerGsts['tin_number']; ?></option>
		 		<?php } ?>
		 	</select> 


		 	<button class="btn btn-primary" style="line-height: 19px;" onclick="orderDetail();">
				<i class="fa fa-file-text-o"></i>Show
			</button>

			<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_order_detail" value="Export All" id="export_all_order_detail"  type="button">

		</div>

		<div id="order_detail_result">
		</div>
		<br>
		 <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_order_detail" value="Print All" id="print_all_order_detail" type="button">
	</div>


	<div id="fragment-10">
		<div class="table-header tableThemeColor filter_titlename">B2C Details</div>

		<div class="table-header" id="filters" style="margin-top:10px;  background-color: #9f9f9f;"> 

			Select From Date <input type="text" style="margin-top:10px;" readonly="" name="sale_detail_from_date" id="sale_detail_from_date"  /> 

		 	Select To Date <input type="text" style="margin-top:10px;" readonly="" name="sale_detail_end_date" id="sale_detail_end_date"   /> 


		 	<?php $getSatateGst = getSku('gst_number',['user_id'=>$uinfo['user_ID'], 'comp_code'=>$uinfo['comp_code']]); ?>
		 	Select GST<select name="gst_number_b2c" id="gst_number_b2c" style="margin-top:10px;">
		 		<option value="">Select Gst Number</option>
		 		<?php foreach($getSatateGst as $getSatateGsts) { ?>
		 			<option value="<?php echo $getSatateGsts['gst_number_id']; ?>"><?php echo $getSatateGsts['gst_number']; ?></option>
		 		<?php } ?>
		 	</select>


		 	<button class="btn btn-primary" style="line-height: 19px;" onclick="saleDetail();">
				<i class="fa fa-file-text-o"></i>Show
			</button>
			<br>
			<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_sale_detail" value="Export All" id="export_all_sale_detail"  type="button">

		</div>

		<div id="sale_detail_result">
		</div>
<br>
		 <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_sale_detail" value="Print All" id="print_all_sale_detail" type="button">
	</div>


	<div id="fragment-11">
		<div class="table-header tableThemeColor filter_titlename">Daily Short Details</div>

		<div class="table-header" id="filters" style="margin-top:10px;  background-color: #9f9f9f;"> 


			Select Employee <select name="employee_name" class="employee_name" id="employee_name" style="margin-top:10px;">
								<option value="">Select Employee</option>
								<?php foreach($saleUser as $saleUsers) { ?>
									<option value="<?php echo $saleUsers->user_ID; ?>"><?php echo $saleUsers->user_full_name; ?></option>
								<?php } ?>
							</select>


			Select Store <select name="store_name" class="store_name" id="store_name" style="margin-top:10px;">
		        <option value="">Select Store</option>
		        <?php
		         $compCode = $uinfo['comp_code']; 
		        $allStore=getSku('store',['comp_code'=>$compCode]);
		        if(!empty($allStore)) {
		           foreach($allStore as $allStores) { ?>
		           <option value="<?php echo $allStores['store_id']; ?>"><?php echo trim($allStores['store_name']); ?></option>
		         <?php }
		        } ?>
		    </select>


		    Select From Date <input type="text" style="margin-top:10px;" name="daily_shot_date" id="daily_shot_date"  />


		 	<button class="btn btn-primary" style="line-height: 19px;" onclick="shotDetail();">
				<i class="fa fa-file-text-o"></i>Show
			</button>
			<br>
			<input class="btn btn_border" style="margin-bottom: 5px;" name="export_all_daily_shot" value="Export All" id="export_all_daily_shot"  type="button">

		</div>

		<div id="daily_shot_result">
		</div>
		<br>
		 <input class="btn btn_border" style="margin-bottom: 5px;" name="print_all_daily_shot" value="Print All" id="print_all_daily_shot" type="button">

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

<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>

<script type="text/javascript">

 $(document).ready(function(){

    var oTable1 = $('#myTables').dataTable({
   
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null, null, 
        ]
      });

   /* var oTable1cash = $('#myTables_cashbook').dataTable({
   
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, null, null,
        ]
      });*/

    });


	$(function() {

		$( "#export_all_sale_detail" ).click(function() {
			var from_date = $('#sale_detail_from_date').val();
			var end_date = $('#sale_detail_end_date').val();
			var gst_number = $('#gst_number_b2c').val();

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_sale_detail/?from_date='+from_date+'&end_date='+end_date+'&gst_number='+gst_number;
			return false;
		});

		$( "#print_all_sale_detail" ).click(function() {
			var from_date = $('#sale_detail_from_date').val();
			var end_date = $('#sale_detail_end_date').val();
			var gst_number = $('#gst_number_b2c').val();

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/pdfPrintSaleDetail/?from_date='+from_date+'&end_date='+end_date+'&gst_number='+gst_number;
			return false;
   		});



		$( "#export_all_order_detail" ).click(function() {
			var from_date = $('#order_detail_from_date').val();
			var end_date = $('#order_detail_end_date').val();

		   	window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_order_detail/?from_date='+from_date+'&end_date='+end_date;
			return false;
   		});


		$( "#print_all_order_detail" ).click(function() {
			var from_date = $('#order_detail_from_date').val();
			var end_date = $('#order_detail_end_date').val();

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/pdfPrintOrderDetail/?from_date='+from_date+'&end_date='+end_date;
			return false;
   		});


		$("#order_detail_from_date").datepicker({ 
	        maxDate: new Date(),
	        numberOfMonths: 1,
			dateFormat:"yy-mm-dd",
	        onSelect: function(selected) {
	           $(this).datepicker("option","maxDate", selected)
	        }
	    });

	  $("#order_detail_end_date").datepicker({ 
	        maxDate: new Date(),
	        numberOfMonths: 1,
			dateFormat:"yy-mm-dd",
	        onSelect: function(selected) {
	           $(this).datepicker("option","maxDate", selected)
	        }
	    });




		$("#sale_detail_from_date").datepicker({ 
	        maxDate: new Date(),
	        numberOfMonths: 1,
			dateFormat:"yy-mm-dd",
	        onSelect: function(selected) {
	           $(this).datepicker("option","maxDate", selected)
	        }
	    });

	  $("#sale_detail_end_date").datepicker({ 
	        maxDate: new Date(),
	        numberOfMonths: 1,
			dateFormat:"yy-mm-dd",
	        onSelect: function(selected) {
	           $(this).datepicker("option","maxDate", selected)
	        }
	    });


	  $('#daily_shot_date').datepicker({ 
	        maxDate: new Date(),
	        numberOfMonths: 1,
			dateFormat:"yy-mm-dd",
	        onSelect: function(selected) {
	           $(this).datepicker("option","maxDate", selected)
	        }
	    });

	});
  

  function orderDetail(page_num) {
	  	page_num = page_num?page_num:0;
	  	var keywords = $('#keywords').val();
		var sortBy = $('#sortBy').val();
		var gst_number = $('#gst_number_b2b').val();

		var startDate = $( "#order_detail_from_date" ).datepicker( "getDate" );
		startDate=$.datepicker.formatDate('dd-mm-yy', startDate);

		var endDate = $( "#order_detail_end_date" ).datepicker( "getDate" );
		endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

		if(startDate == '') {
			alert('Please select Start date.');
			return false;
		} else if(endDate == '') {
			alert('Please select End date.');
			return false;
		} else {
			var dataval='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate+'&gst_number='+gst_number;

			$.ajax({
				type: 'GET',
				url: '<?php echo base_url(); ?>webadmin/managereport/orderDetailReport/'+page_num,
				beforeSend : function() {
					$('#order_detail_result').html('<p>Loading.....</p>')
				},
				data:dataval,
				success: function (html) {
					$('#order_detail_result').html(html);
					//$('.loading').fadeOut("slow");

					if(html != '') {
						var orderDetailVal = $('#order_detail_result').find('#account-result').html();

						if(orderDetailVal != '') {

							var oTableorder_detail = $('.orderdetail').dataTable({
							 		"aoColumns": [
						                null, null,null,null, null, null, null, null, null, null, null, null, null, null
						              ]
							});
						}
					}
				}
			});
		}
  }


	function saleDetail(page_num) {
	  	page_num = page_num?page_num:0;
	  	var keywords = $('#keywords').val();
		var sortBy = $('#sortBy').val();

	  	var startDate = $( "#sale_detail_from_date" ).datepicker( "getDate" );
		startDate=$.datepicker.formatDate('dd-mm-yy', startDate);

		var endDate = $( "#sale_detail_end_date" ).datepicker( "getDate" );
		endDate=$.datepicker.formatDate('dd-mm-yy', endDate);

		var gstNumber = $( "#gst_number_b2c" ).val();


		var url='page='+page_num+'&keywords='+keywords+'&sortBy='+sortBy+'&start_date='+startDate+'&end_date='+endDate+'&gstNumber='+gstNumber;

		if(startDate == '') {
			alert('Please select Start date.');
			return false;
		} else if(endDate == '') {
			alert('Please select End date.');
			return false;
		} else {
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url(); ?>webadmin/managereport/saleDetailReport/',
				beforeSend : function() {
					$('#sale_detail_result').html('<p>Loading.....</p>')
				},
				data:url,
				success: function (html) {
					$('#sale_detail_result').html(html);
					//$('.loading').fadeOut("slow");

					if(html != '') {
						var saleDetailVal = $('#sale_detail_result').find('#account-result').html();
						
						if(saleDetailVal != '') {

							 var oTablesale_detail = $('.orderdetail').dataTable({
							 		"aoColumns": [
							 			{ "bSortable": false },
						                null, null,null, null, null, null, 
						              ]
							 });
						}
					}
				}
			});
		}
	}


    function shotDetail() {

		var startDate = $( "#daily_shot_date" ).datepicker( "getDate" );
		startDate=$.datepicker.formatDate('yy-mm-dd', startDate);

		var storeID = $( "#store_name" ).val();
		var employeeID = $( "#employee_name" ).val();

		var url='start_date='+startDate+'&storeID='+storeID+'&employeeID='+employeeID;

		if(startDate == '' && storeID == '' && employeeID == '')   {
			alert('Please select any one field.');
			return false;
		} else {
			$.ajax({
				type: 'GET',
				url: '<?php echo base_url(); ?>webadmin/managereport/dailyShotReport/',
				data:url,
				success: function (html) {
					$('#daily_shot_result').html(html);
					//$('.loading').fadeOut("slow");
				}
			});
		}
    }


		$( "#export_all_daily_shot" ).click(function() {
			var employee_name = $('#employee_name').val();
			var store_name = $('#store_name').val();
			var daily_shot_date = $('#daily_shot_date').val();
			if(employee_name != '' && store_name !='' && daily_shot_date != '') {
				alert('Please select any one field');
			}

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_daily_shot_detail/?employee_name='+employee_name+'&store_name='+store_name+'&daily_shot_date='+daily_shot_date;
			return false;
		});


		$( "#print_all_daily_shot" ).click(function() {
			var employee_name = $('#employee_name').val();
			var store_name = $('#store_name').val();
			var daily_shot_date = $('#daily_shot_date').val();
			if(employee_name != '' && store_name !='' && daily_shot_date != '') {
				alert('Please select any one field');
			}

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/pdfPrintDailyShotDetail/?employee_name='+employee_name+'&store_name='+store_name+'&daily_shot_date='+daily_shot_date;
			return false;
   		});

  
		$( "#print_all" ).click(function() {
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
		var type = $('.type').val();

			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_filters/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date+'&type='+type;
			return false;
   			
   		});
		
		$( "#print_with_filters" ).click(function() {
   		var bank_from_date = $('#bank_from_date').val();
		var bank_end_date = $('#bank_end_date').val();
		var type = $('#type').val();

			if(bank_from_date=='') {
				alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
				alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_bank_acount_filters/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date+'&type='+type;
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
			var cash_type = $('.cash_type').val();

			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/create_csv_for_bank_acount_filters_cash_book/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date+'&cash_type='+cash_type;
			return false;
   			
   		});

		$( "#print_filters_cash_book" ).click(function() {
	   		var bank_from_date = $('#cash_from_date').val();
			var bank_end_date = $('#cash_end_date').val();
			var cash_type = $('.cash_type').val();

			if(bank_from_date=='') {
			alert('Please select From Date.');return false;
			}
			if(bank_end_date=='') {
			alert('Please select To Date.');return false;
			}
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_filters_cash_book/?bank_from_date='+bank_from_date+'&bank_end_date='+bank_end_date+'&cash_type='+cash_type;
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
   		});





		$( "#export_all_product" ).click(function() {
   		var product = $('#product').val();
		if(product=='') {  alert("Please select Product."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_product/?product_id='+product;
			return false;
   		});

		$( "#print_all_product" ).click(function() {
   		var product = $('#product').val();
		if(product=='') {  alert("Please select Product."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_product/?product_id='+product;
			return false;
   		});

   		$( "#export_all_product_by_filter" ).click(function() {
   		var from_date = $('#product_from_date').val();
		var end_date = $('#product_end_date').val();
		var product = $('#product').val();
		if(product=='') {  alert("Please select product."); return false; }
			if(from_date=='') {  alert("Please select From Date."); return false; }
			if(end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_product_filter/?product_id='+product+'&from_date='+from_date+'&to_date='+end_date;
			return false;
   		});

   		$( "#print_all_product_by_filter" ).click(function() {
   		var from_date = $('#product_from_date').val();
		var end_date = $('#product_end_date').val();
		var product = $('#product').val();
		if(product=='') {  alert("Please select product."); return false; }
			if(from_date=='') {  alert("Please select From Date."); return false; }
			if(end_date=='') {  alert("Please select To Date."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_product_filter/?product_id='+product+'&from_date='+from_date+'&to_date='+end_date;
			return false;
   		});



   		$( "#export_all_warehouse_inventory" ).click(function() {
   			var warehousecat = $('#warehousecategory').val();
   			var warehouseproduct = $('#warehouseproduct').val();
   			var warehouseSubCat = $('#product_sub_category').val();
   			var warehouseSubSubCat = $('#product_sub_of_sub_category').val();
   			var attribute = $('#product_attribute').val();


		if(warehousecat=='') {  alert("Please select Category."); return false; }

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_warehouse_inventory/?product_id='+warehouseproduct+'&cat_id='+warehousecat+'&sub_cat='+warehouseSubCat+'&sub_sub_cat='+warehouseSubSubCat+'&attribute='+attribute;
			return false;
   		});

   		

		$( "#print_all_warehouse_inventory" ).click(function() {
			var warehousecat = $('#warehousecategory').val();
   			var warehouseproduct = $('#warehouseproduct').val();
   			var warehouseSubCat = $('#product_sub_category').val();
   			var warehouseSubSubCat = $('#product_sub_of_sub_category').val();
   			var attribute = $('#product_attribute').val();

   		
   		if(warehousecat=='') {  alert("Please select Category."); return false; }

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_warehouse_inventory/?product_id='+warehouseproduct+'&cat_id='+warehousecat+'&sub_cat='+warehouseSubCat+'&sub_sub_cat='+warehouseSubSubCat+'&attribute='+attribute;
			return false;
   		});


		$( "#export_all_store_inventory" ).click(function() {
   		var storeproduct = $('#storeproduct').val();
   		var storecategory = $('#storecategory').val();
   		var inventorystore = $('.storefilter').val();

		if(storecategory=='') {  alert("Please select Category."); return false; }

			window.location.href =  '<?php echo site_url();?>webadmin/managereport/export_all_store_inventory/?product_id='+storeproduct+'&cat_id='+storecategory+'&store='+inventorystore;
			return false;
   		});


   		$( "#print_all_store_inventory" ).click(function() {
   		var storeproduct = $('#storeproduct').val();
   		var storecategory = $('#storecategory').val();
   		var inventorystore = $('.storefilter').val();
   		
		if(storecategory=='') {  alert("Please select Category."); return false; }
			window.location.href =  '<?php echo site_url();?>webadmin/managereport/print_all_store_inventory/?product_id='+storeproduct+'&cat_id='+storecategory+'&store='+inventorystore;
			return false;
   		});

		
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
			var type = $('#type').val();

			if(bank_from_date=='') {  alert("Please select From Date"); return false;}
			if(bank_end_date=='') {  alert("Please select To Date"); return false;}

   			var url="<?php echo site_url();?>webadmin/managereport/bankReportByDate";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data: {bank_from_date:bank_from_date,bank_end_date:bank_end_date,type:type},
		    success: function(datas){
   			$('#bank_account_result').html(datas);
   				//alert(data);
   			}
   			});
   			
   		});
		
			$( "#search_cash_report" ).click(function() {
   		    var cash_from_date  = $('#cash_from_date').val(); 
			var cash_end_date  = $('#cash_end_date').val(); 
			var cash_type = $('#cash_type').val();


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
			beforeSend : function() {
					$('#result_cashbook').html('<p>Loading.....</p>')
				},
   			data: {cash_from_date:cash_from_date,cash_end_date:cash_end_date,cash_type:cash_type},
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
   		if(productId=='') {
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


   	$("#search_warehouse_inventory_report").click(function() {
   		var productId = $('#warehouseproduct').val(); 
   		var catId =  $('#warehousecategory').val(); 
   		var subCatId = $('#product_sub_category').val(); 
   		var subSubCatId = $('#product_sub_of_sub_category').val(); 
   		var attribute = $('#product_attribute').val(); 

   		if(catId=='') {
			alert('Please Select Category.');
			return false;
		}

		var url="<?php echo site_url();?>webadmin/managereport/getWarehouseInventoryByPId";
		$.ajax({
			url: url,
			type:'GET',
			data: {productId:productId,catId:catId,subCatId:subCatId,subSubCatId:subSubCatId,attribute:attribute},
			success: function(datas){
				$('#warehouse_inventory_result').html(datas);

				if(datas != '') {
					var warehouseVal = $('#warehouse_inventory_result').find('#warehouseInventory-table').html();
					if(warehouseVal != '') {

						 var oTablewarehouse_inventory = $('.warehouseInventory-table').dataTable({
						 		"aoColumns": [
					                null, null,null, null, null,
					              ]
						 });
					}
				}
			}
		});
   	});


   	$("#search_store_inventory_report").click(function() {
   		var productId  = $('#storeproduct').val(); 
   		var catId =  $('#storecategory').val(); 
   		var storeId =  $('#store').val(); 
   		var attrId =  $('#store_attribute').val(); 

   		if(catId=='') {
			alert('Please Select Category.');
			return false;
		} else {

		 var table_config = {
	        "bDestroy": true,
	        "paging": false,
	        "language": {
	            "zeroRecords": "No results found",
	            "processing": "<div align='center'><img src='/static/ajax-loader.gif'></div>",
	            "loadingRecords": "<div align='center'><img src='/static/ajax-loader.gif'></div>"
	        }
	    }; 

		var url="<?php echo site_url();?>webadmin/managereport/getStoreInventoryByPId";
			$.ajax({
				url: url,
				type:'GET',
				data: {productId:productId,catId:catId,storeId:storeId,attrId:attrId},
				success: function(response){
					/*table_config.data = response.data;
	                table_config.columns = response.columns;*/
					$('#store_inventory_result').html(response);

					if(response != '') {
						var storeVal = $('#store_inventory_result').find('#store_inventory').html();
						if(storeVal != '') {

							 var oTablestore_inventory = $('.store_inventory').dataTable({
							 		"aoColumns": [
						                null, null,null, null, null,
						              ]
							 });
						}
					}
					
				}
			});
		}
   	});
</script>


<script>
$(document).ready(function() {
          /*var oTable1 = $('.orderdetail').dataTable( {
   
            "aoColumns": [
         
                { "bSortable": false },
         
                null, null,null, null, null,null, null, null,
              ]
    
        } );*/
      });

 $(function(){

$("#cash_book_tab").click(function(){

 	$('#cash_book #result_cashbook').load('<?php echo base_url(); ?>webadmin/managereport/cashBook');
 	$('.cash_book_links').find('a').removeAttr('href');

 //	$("#cashbook-table").dataTable({"bSort": false,"iDisplayLength": 2 });
});


 $('#daily_sale_report_tab').click(function(){
		$('#fragment-6').load('<?php echo base_url(); ?>webadmin/managereport/salesReport');
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

	    $(".product_date").datepicker({ 
	    	dateFormat: "dd-mm-yy",
	    	maxDate: new Date()
	    	 });

	    $("#storecategory").on("change",function(){
	        var main_cat_id  = $(this).val();
	    	var url="<?php echo site_url();?>webadmin/managereport/getSubCategories";
	   			$.ajax({
	   			url: url,
	   			type:'POST',
	   			data:"main_cat_id="+main_cat_id,
			    success: function(datas){
			    	var res = JSON.parse(datas);
				
	   		  //  $('#product_sub_category').html(res.category);
	   		    	$('#storeproduct').html(res.product);
	   			}
	   			
			});
		});

	   
	    $("#warehousecategory").on("change",function(){
	        var main_cat_id  = $(this).val();
	    	var url="<?php echo site_url();?>webadmin/managereport/getSubCategories";
	   			$.ajax({
	   			url: url,
	   			type:'POST',
	   			data:"main_cat_id="+main_cat_id,
			    success: function(datas){
			    	var res = JSON.parse(datas);
				
	   		    $('#product_sub_category').html(res.category);
	   		    $('#warehouseproduct').html(res.product);
	   			}
	   			
				});
		});

		$("#product_sub_category").on("change",function(){
	        var sub_cat_id  = $(this).val();
	   		var url="<?php echo site_url();?>webadmin/managereport/getSubSubCategories";
	   			$.ajax({
	   			url: url,
	   			type:'POST',
	   			data:"sub_cat_id="+sub_cat_id,
			    success: function(datas){
				
	   		    $('#product_sub_of_sub_category').html(datas);
	   			}
	   			
				});
		});



	});
</script>
</body>
</html>