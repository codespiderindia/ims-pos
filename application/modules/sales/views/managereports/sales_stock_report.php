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
	padding: 0.5em 0.64em 0.43em 0.64em;
	margin: 2px;
	background-color: #FD1C5B;
	color: #fff;
}
div.pagination span.current {
		padding: 0.5em 0.64em 0.43em 0.64em;
		margin: 2px;
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

</style>
  

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Stock Detail</h1>
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
						Choose Criteria
						
					</h4>
				</div>

				<div class="widget-body">
				
					<div class="widget-main ">
					
						<table>

						<tr>
							
							<td><label style="margin-top: -10px;text-align: left;" >Location : &nbsp;</label> </td>
							
							<td><label style="margin-top: -10px;text-align: left;" >Store : &nbsp;</label></td>
							<td><label style="margin-top: -10px;text-align: left;" >Item : &nbsp;</label> </td>
							<td  style="width: 200px;"><label style="margin-top: -10px;text-align: left;" > &nbsp;</label> </td>

						</tr>

						<tr>
							
							
							<td width="20%">
								<select id="dd_loc" name="dd_loc" class="txtwidth">

									<option value="">Select</option>
									<?php 
									if(isset($locs) && !empty($locs)){
									foreach($locs as $loc) { ?>
									<option value="<?php echo $loc['id'];?>">
										<?php echo $loc['location_name'];?>
									</option>
									<?php
										}
									}
									?>
								</select>	
							</td>
							
							<td width="20%">
								<select id="dd_store" name="dd_store" class="txtwidth">
									<option value="">Select</option>
									
								</select>	
							</td>
							<td width="20%">
								<select id="dd_item" name="dd_item" class="txtwidth">
								<option value="">Select</option>
									<?php 
									if(isset($products) && !empty($products)){
									foreach($products as $prd) { ?>
									<option value="<?php echo $prd['product_id'];?>">
										<?php echo $prd['product_name'];?>
									</option>
									<?php
										}
									}
									?>
									
								</select>	
							</td>
							<td width="200px">
								<button class="btn btn-primary" style="line-height: 22px; margin-bottom: 10px;" onclick="searchFilter();">
									<i class="fa fa-file-text-o"></i>
									Show
								</button>
							</td>
							
						</tr>

							
							
							
						</tr>
							
							
							
					</table>

						
					
					
					</div>
					
				</div>
			</div>
		</div>
	</div>

   <div class="row-fluid">
		<div class="span12 ">
			<!--PAGE CONTENT BEGINS-->

			<div class="">

    
    
				<div class="post-search-panel">
					<!-- <input type="text" id="keywords" placeholder="Type keywords to filter posts" onkeyup="searchFilter()"/> -->
					<table>
						<tr>
							<!-- <td>
								<select id="sortBy" onchange="searchFilter()">
								<option value="">Sort By</option>
								<option value="asc">Ascending</option>
								<option value="desc">Descending</option>
								</select>
							</td> -->
							<td  style="vertical-align: top;"> 
									
									
									</td>
							<td style="vertical-align: top;">
								<button class="btn btn-primary" style="line-height: 22px;" id="btn_download" name="btn_download">
								<i class="ace-icon fa fa-download "></i>
								Download
								</button>

							</td>
							<td style="vertical-align: top;">
								<button class="btn btn-primary" style="line-height: 22px;" id="btn_print" name="btn_print" >
								<i class="ace-icon fa fa-print"></i>
								Print
								</button>

							</td>
						</tr>
					</table>
					
					
				</div>
		        <div class="post-list" id="postList">
		            <?php if(!empty($posts)): foreach($posts as $post): ?>
		                <div class="list-item"><a href="javascript:void(0);"><h2><?php echo $post['sale_ID']; ?></h2></a></div>
		            <?php endforeach; else: ?>
		            <p>Sale(s) not available.</p>
		            <?php endif; ?>
		            <?php echo $this->ajax_pagination->create_links(); ?>
		        </div>
        		<div class="loading" style="display: none;"><div class="content"><img src="<?php echo base_url().'assets/images/loading.gif'; ?>"/></div></div>
    
			</div>

			
						
			<div id="div_cart">

							
								<?php //$this->load->view('managereports/sale_report_view'); ?>
			</div>
						
						
						
						
						
					
			

			<!--PAGE CONTENT ENDS-->
		</div><!--/.span-->
				<!-- <div class="span3" style="width: 20.077%; margin-left: 0.5%;">
					<div id="div_cart_total">
					
						<?php //$this->load->view('managesales/cart_total'); ?>	
					</div>
				
				
				</div> -->
				
			</div>
		</div>
	


<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
</div><!--/.row-fluid-->
</div>
</body>
</html>



<script src="https://code.jquery.com/jquery-1.11.1.js"></script>
<script src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
<script src="https://code.jquery.com/ui/1.11.1/jquery-ui.js"></script>

<script src="<?php echo base_url();?>assets/js/browser/browser.js"></script>



<script type="text/javascript">

$(function() {
    


	    $("#dd_loc").on("change",function(){
    	var locID  = $(this).val();
   		var url="<?php echo site_url();?>sales/managereports/getStoresByLoc";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"locID="+locID,
		    success: function(data){
			
   		    $('#dd_store').html(data);
			
			
			//alert(data);
   			
   			}
   			
			});
	});
	
	
	$("#dd_item_subcat1").on("change",function(){
	    var catID  = $(this).val();
	    var url="<?php echo site_url();?>sales/managereports/getSubCatsBySubCat";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"catID="+catID,
		    success: function(data){
			
   		    	$('#dd_item_subcat2').html(data);

   			}
   			
			});
	});

	$("#dd_item_cat,#dd_item_subcat2,#dd_item_subcat1").on("change",function(){


		var catID  = $('#dd_item_cat').val();
		var subCatID1  = $('#dd_item_subcat1').val();
		var subCatID2  = $('#dd_item_subcat2').val();

	    

	    var url="<?php echo site_url();?>sales/managereports/getProductsByCat";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"catID="+catID+"&subcat1="+subCatID1+"&subcat2="+subCatID2,
		    success: function(data){
			
   		    	$('#dd_item').html(data);
   		    	//alert(data);

   			}
   			
			});
	});

	$("#dd_item_cat,#dd_item_subcat2,#dd_item_subcat1").on("change",function(){


		var catID  = $('#dd_item_cat').val();
		var subCatID1  = $('#dd_item_subcat1').val();
		var subCatID2  = $('#dd_item_subcat2').val();
		var productID= $('#dd_item').val();
	    

	    var url="<?php echo site_url();?>sales/managereports/getProductVendors";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"catID="+catID+"&subcat1="+subCatID1+"&subcat2="+subCatID2+"&prdID="+productID,
		    success: function(data){
			
   		    	//$('#dd_item').html(data);
   		    	alert(data);

   			}
   			
			});
	});


});



	

</script>
<script>

$( "#btn_download").click(function(page_num) {
   		
	var page_num = 0;

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
	window.location.href =  '<?php echo base_url(); ?>sales/managereports/export_item_stock?'+url;
	return false;
   			
});
$('#btn_print').click(function(page_num){
	var page_num = 0;

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
	
	window.location.href =  '<?php echo base_url(); ?>sales/managereports/print_item_stock?'+url;
	return false;

});


function searchFilter(page_num) {
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
	//alert(url);

	$.ajax({


		type: 'POST',
		url: '<?php echo base_url(); ?>sales/managereports/paginate_item_stock/'+page_num,
		data:url,
		beforeSend: function () {
			//$('.loading').show();
		},
		success: function (html) {

			//alert(html);
			$('#postList').html(html);
			$('.loading').fadeOut("slow");
		}
	});
}


</script>


 

	