<?php $country =  get_countries(); ?>
  <div class="table-header tableThemeColor">Taxes</div>
  <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">  Country <select name="tax_country" id="tax_country" style="margin-top: 10px; width: 11%;">
  <option value=""> Select Country </option>
  <?php 
  if(!empty($country)) {
  foreach($country as $c_val_s) { ?>
  <option value="<?php echo  $c_val_s['id'];?>"><?php echo  $c_val_s['name'];?></option>
  <?php }
  }
   ?>
  </select>
  State
  <select name="tax_state" id="tax_state" style="margin-top: 10px; width: 11%;">
  <option value=""> Select State </option>
  </select>
  City <select name="tax_city" id="tax_city" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select City </option>
  </select>
  
  
  <input class="search_tax btn" name="search_tax" value="Search" id="search_taxes" style="margin-bottom: 0px;margin-left: 10px;" type="button">
  
  </div>
  
  <div id="tax_result" class="tax_result">
   <table id="table-tax"  class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th>#</th>
                        <th>Tax Name</th>
						            <th>Rate</th>
                        <th>City</th>
            						<th>State</th>
            						<th>Country</th>
            						<th>Zip code</th>
            						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php  if(!empty($taxes)) { ?>
                      <?php $i = 1;
					             foreach($taxes as $taxes) { 
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>  
						<td class=""><?php echo $taxes->tax_name;?></td>
                        <td><?php echo $taxes->rate."%"; ?></td>
						<td><?php echo get_city_by_id($taxes->city_id); ?></td>
						<td><?php echo get_state_by_id($taxes->state_id); ?></td>
						<td><?php echo get_country_by_id($taxes->country_id); ?></td>	
                        <td><?php echo $taxes->zipcode; ?></td>
                        
                        <td><?php if($taxes->tax_status=='1') { echo "active"; } else { echo "Inactive"; } ?></td></tr>
                      <?php  $i++;} ?>
<?php } ?>
</tbody>
</table>
</div>
<div class="print_tax">
  <input class="btn btn_border" name="print_all_tax" value="Print All" id="print_all_tax" style="" type="button">
</div>
<script type="text/javascript">
  $(document).ready(function(){

    var oTable1 = $('#table-tax').dataTable( {
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, null, 
      ] } );


  
    $('#print_all_tax').click(function() {

      var tax_country = $('#tax_country').val();
      var tax_state = $('#tax_state').val();
      var tax_city = $('#tax_city').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllTax/?tax_country='+tax_country+'&tax_state='+tax_state+'&tax_city='+tax_city;
        return false;
  });



  $( "#tax_country" ).change(function() {
		
   			var user_country  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getStateByCountry";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"user_country="+user_country,
		    success: function(datas){
   		    $('#tax_state').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		
		$( "#tax_state" ).change(function() {
		
   			var state_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getCityByState";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"state_id="+state_id,
		    success: function(datas){
   		    $('#tax_city').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		$( "#search_taxes" ).click(function() {
		
   			var city_id  = $('#tax_city').val(); 
			var tax_state = $('#tax_state').val();
			var tax_country = $('#tax_country').val();
			if(tax_country=='Select Country') { 
			alert("Please select Country");
			return false;
			
			}
   			var url="<?php echo site_url();?>webadmin/managereport/getTaxesByCityState/";
   			$.ajax({
   			url: url,
   			type:'POST',	
   			data:{city_id:city_id,tax_country:tax_country,tax_state:tax_state},
		    success: function(datas){
   		    $('#tax_result').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
  
  
  });
       
  </script>
  </script>
</script>
