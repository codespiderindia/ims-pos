<?php  $uinfo=$this->session->userdata('webadmin_session_info'); ?>
<div class="table-header tableThemeColor">Dealers</div>
  <div class="table-header" id="product_filters" style=" margin-top:10px;  background-color: #9f9f9f;"> 


  Dealer Name <input type="text" placeholder="Enter Dealer Name" name="dealer_name" id="dealer_name" class="dealer_name" style="margin-top: 10px;" />
  <?php 
    $dealerWhere = ['comp_code'=>$uinfo['comp_code']];
    $selectval = 'city';
    $getDealerCity = getDataUsingGroupBy('dealer',$selectval,$dealerWhere,'city');
  ?>
  Select City <select name="dealer-city" id="dealer-city" style="margin-top: 10px; width: 13%;">
    <option value="">Select City</option>
      <?php foreach($getDealerCity as $getDealerCitys) { ?>
        <option value="<?php echo $getDealerCitys['city']; ?>"><?php echo $getDealerCitys['city']; ?></option>
      <?php } ?>
  </select>


  <div class="range-container">
     <label for="range" class="creditrange-label">Credit Limit Range:</label>
      <!--<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">-->
      <label id="range" style="border:0; color:#f6931f; font-weight:bold;"></label>
    <div id="slider-creditrange" class="range-slider"></div>
  </div>

  <input type="hidden" value="0" id="product_start_amt" name="product_start_amt" />
  <input type="hidden" value="100000" id="product_end_amt" name="product_end_amt" />

  <button name="searchdealer" class="searchdealer btn btn_border search_product_byrange" id="searchdealer">Search</button>
</div>
  
  <div id="dealer_result" class="dealer_result">
   <table id="my-table"  class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Dealer Name</th>
						<th>Email</th>
                        <th>City</th>
                        <th>Address</th>
						<th>Mobile</th>
						<th>Credit Limit</th>
					    <th>Firm Name</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                    <?php  if(!empty($dealers)) { ?>
                      <?php $i = 1;
					             foreach($dealers as $dealers) { 
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>  
						<td class=""><?php echo $dealers->f_name." ".$dealers->l_name; ?></td>
                        <td><?php echo $dealers->email; ?></td>
						<td><?php echo $dealers->city; ?></td>
						<td><?php echo $dealers->address; ?></td>	
                        <td><?php echo $dealers->mobile_number; ?></td>
						<td><?php echo $dealers->dealer_credit_limits; ?></td>
                        
                        <td><?php echo $dealers->firm_name; ?></td></tr>
                      <?php  $i++;} ?>
<?php } ?>
</tbody>
</table>
</div>
<div class="print_dealer">
  <input class="btn btn_border" name="print_all_dealer" value="Print All" id="print_all_dealer" style="" type="button">
</div>

<script type="text/javascript">
  $(document).ready(function(){

    var oTable1 = $('#my-table').dataTable( {
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, null, 
      ] } );

    $('#print_all_dealer').click(function() {

      var dealerName = $('#dealer_name').val();
      var dealerCity = $('#dealer-city').val();
      var productStartAmt = $('#product_start_amt').val();
      var productEndAmt = $('#product_end_amt').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllDealer/?name='+dealerName+'&city='+dealerCity+'&startamt='+productStartAmt+'&endamt='+productEndAmt;
        return false;
  });


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
	
	
	 $("#searchdealer").on("click",function(){
      var dealer_name  = $('#dealer_name').val();
	    var dealer_city  = $('#dealer-city').val();
	    var  start_price = $( "#product_start_amt" ).val();
      var  end_price = $( "#product_end_amt" ).val();

    var url="<?php echo site_url();?>webadmin/managereport/getDealerInfoForFilter";
   			$.ajax({
   			url: url,
   			type:'POST',	
   			data:{dealer_name:dealer_name,dealer_city:dealer_city,start_price:start_price,end_price:end_price},
		    success: function(datas){
			   $('#dealer_result').html(datas);
			//alert(data);
   			}
   			});
	});
	
  
  
  
  });
       
    $( function() {
    $( "#slider-creditrange" ).slider({
      range: true,
      min: 0,
      max: 100000,
      values: [ 0, 100000 ],
      slide: function( event, ui ) {
       //alert(ui.values[ 0 ]);
	    $( "#range" ).html( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
		$( "#product_start_amt" ).val( ui.values[ 0 ]);
		$( "#product_end_amt" ).val( ui.values[ 1 ]);
		
	  }
    });
    $( "#range" ).html( "Rs " + $( "#slider-creditrange" ).slider( "values", 0 ) +
      " - Rs " + $( "#slider-creditrange" ).slider( "values", 1 ) );
  } );
  </script>
  </script>
</script>
