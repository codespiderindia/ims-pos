  <?php  $uinfo=$this->session->userdata('webadmin_session_info'); ?>
  <div class="table-header tableThemeColor">Vendors</div>
  <div class="table-header" id="product_filters" style=" margin-top:10px;  background-color: #9f9f9f;">

     Vendor Name <input type="text" placeholder="Enter Vendor Name" name="vendor_name" id="vendor_name" class="vendor_name" style="margin-top: 10px;" />

      Mobile Number <input type="text" placeholder="Enter Vendor Mobile Number" name="vendor_mob_number" id="vendor_mob_number" class="vendor_mob_number" style="margin-top: 10px;" />

     <?php 
      $vendorWhere=['comp_code'=>$uinfo['comp_code']];
      $selectval='city';
      $getVendorCity = getDataUsingGroupBy('vendor',$selectval,$vendorWhere,'city');
     ?>
     Select City <select name="dealer-city" id="dealer-city" style="margin-top: 10px; width: 13%;">
      <option value="">Select City</option>
      <?php foreach($getVendorCity as $getVendorCitys) { ?>
        <option value="<?php echo $getVendorCitys['city']; ?>"><?php echo $getVendorCitys['city']; ?></option>
      <?php } ?>
  </select>

   <button name="searchvendor" class="searchvendor btn btn_border search_product_byrange" id="searchvendor" style="margin-top: 10px;">Search</button>

</div>
  
  <div id="vender_result" class="vender_result">
   <table id="my-table-vendor" class="table table-striped table-borderedss table-hover">
          <thead>
             <tr>
                <th>#</th>
                <th>venders Name</th>
		            <th>Email</th>
                <th>City</th>
                <th>Address</th>
		            <th>Mobile</th>
	             <th>Firm Name</th>
             </tr>
          </thead>
              <tbody>
                <?php  if(!empty($venders)) { ?>
                  <?php $i = 1;
			             foreach($venders as $venders) { 
                  ?>
                  <tr>
                    <td><?php echo $i;?></td>  
				<td class=""><?php echo $venders->f_name." ".$venders->l_name; ?></td>
                    <td><?php echo $venders->email; ?></td>
				<td><?php echo $venders->city; ?></td>
				<td><?php echo $venders->address; ?></td>	
                    <td><?php echo $venders->mobile_number; ?></td>
				
                    
                    <td><?php echo $venders->firm_name; ?></td></tr>
                  <?php  $i++;} ?>
<?php } ?>
</tbody>
</table>
</div>
<div class="print_vendor">
  <input class="btn btn_border" name="print_all_vendor" value="Print All" id="print_all_vendor" style="" type="button">
</div>
<script type="text/javascript">
  $(document).ready(function(){


     $('#print_all_vendor').click(function() {

      var vendorName = $('#vendor_name').val();
      var mobNumber = $('#vendor_mob_number').val();
      var city = $('#dealer-city').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllVendor/?vendorName='+vendorName+'&mobNumber='+mobNumber+'&city='+city;
        return false;
  });



    var oTable1 = $('#my-table-vendor').dataTable( {
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, 
      ] } );

    $("#product_category").on("change",function(){
      var main_cat_id  = $(this).val();
    var url="<?php echo site_url();?>webadmin/managereport/getSubCategories";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"main_cat_id="+main_cat_id,
		    success: function(datas){
	        $('#product_sub_category').html(datas);
			//alert(data);
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
			
   			//alert(data);
   			}
   			
			});
	});
	
	
	 $("#searchvendor").on("click",function(){
       var vendor_name  = $('#vendor_name').val();
	     var vendor_mob_number  = $('#vendor_mob_number').val();
       var dealer_city  = $('#dealer-city').val();

      var url="<?php echo site_url();?>webadmin/managereport/getVendorInfoForFilter";
   			$.ajax({
   			url: url,
   			type:'POST',	
   			data:{vendor_name:vendor_name,vendor_mob_number:vendor_mob_number,dealer_city:dealer_city},
		    success: function(datas){
			$('#vender_result').html(datas);
			//alert(data);
   			}
   			});
	});
	
  
  
  
  });
       
    $( function() {
    $( "#slider-range" ).slider({
      range: true,
      min: 0,
      max: 100000,
      values: [ 0, 100000 ],
      slide: function( event, ui ) {
       
	    $( "#amount" ).val( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
		$( "#product_start_amt" ).val( ui.values[ 0 ]);
		$( "#product_end_amt" ).val( ui.values[ 1 ]);
		
      
	  }
    });
    $( "#amount" ).val( "Rs " + $( "#slider-range" ).slider( "values", 0 ) +
      " - Rs " + $( "#slider-range" ).slider( "values", 1 ) );
  } );
  </script>
  </script>
</script>
