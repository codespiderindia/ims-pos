<?php  $uinfo=$this->session->userdata('webadmin_session_info'); ?>
<style>
.pricerange-label {
    width: 8%;
    float: left;
}
.range-slider {
    width: 85%;
}
.range-container {
    padding: 10px 0;
}
.search_product_byrange {
    margin-bottom: 10px;
}
.btn_border {
  border: none !important;
}
</style>
  <div class="table-header tableThemeColor">Products</div>
  <div class="table-header" id="product_filters" style=" margin-top:10px;  background-color: #9f9f9f;"> 
  Category
  <select name="product_category" id="product_category" style="margin-top: 10px; width: 11%;">
    <option value=""> Select Category </option>
	<?php 
	$main_Cat =  getProductCategoryParentNull($uinfo['comp_code']);
	foreach($main_Cat as $main_Cat) { ?>
<option value="<?php echo $main_Cat['product_cat_id'];?>"><?php echo $main_Cat['cat_name'];?></option>
<?php } ?>
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

  <div class="range-container">
     <label for="amount" class="pricerange-label">Price range:</label>
      <!--<input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">-->
      <label id="amount" style="border:0; color:#f6931f; font-weight:bold;"></label>
    <div id="slider-range" class="range-slider"></div>
  </div>

  <input type="hidden" value="0" id="product_start_amt" name="product_start_amt" />
  <input type="hidden" value="100000" id="product_end_amt" name="product_end_amt" />
 <input type="button" class="btn btn_border search_product_byrange" name="search" value="Search" id="search_product" style="margin-bottom: 12px;" />

</div>
  
  <div id="product_result" class="product_result">
   <table id="myTable"  class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Product Name</th>
						             <th>Category</th>
                        <th>Sub Category</th>
                        <th>Sub of Sub Category</th>
						            <th>Attributes</th>
						            <th>Product Image</th>
					              <th>Product Price</th>
                        <th>Product Status</th>
                     </tr>
                  </thead>
                  <tbody>
                      <?php if(!empty($products)) {
                        $i=1;
					             foreach($products as $key => $product) { 
                      ?>
                      <tr>
                        <td><?php echo $key+1;?></td>  
						            <td class=""><?php echo $product->product_name; ?></td>
                        <td><?php
                           $productCategory = getParentCategory($product->product_category);
          						   if(isset($productCategory) && !empty($productCategory)){
                                     		echo $productCategory->cat_name;
          						   }
						   ?></td>
						<td><?php
						   $productSubCategory = getParentCategory($product->product_sub_category);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		echo $productSubCategory->cat_name;
						   }
						    if($product->product_sub_category==0)
						   {
							echo "Not Define";
						   }
                           ?></td>
						<td><?php
						   $productSubCategory = getParentCategory($product->product_sub_of_sub_category);
						   if(isset($productSubCategory) && !empty($productSubCategory)){
                           		echo $productSubCategory->cat_name;
						   }
						   if($product->product_sub_of_sub_category==0)
						   {
							echo "Not Define";
						   }
                           ?></td>	
                        <td><?php
                           $attr_name = get_attribute_by_productID($product->product_id);
            						   if(isset($attr_name) && !empty($attr_name)){
            							   $count_array = count($attr_name);
            							   if(!empty($attr_name)){
            								   for($i=0;$i<$count_array;$i++){
            										echo $attr_name[$i]; 
            								   }
            							   }else{
            								  echo "Not Set";
            							   }
                          }
						              ?>
                        </td>
						<td><img src="<?php echo base_url().'uploads/product_image/'.$product->product_image; ?>" width="30px" height="30px"></td>
                        <td><?php echo $product->product_price;?></td>
                        <td><?php if($product->product_status == "1"){echo "active";}else{echo "inactive";}?></td></tr>
                      <?php $i++; } ?>
<?php } ?>
</tbody>
</table>
</div>
<div class="print_product">
<input class="btn btn_border" name="print_all_product" value="Print All" id="print_all_product" style="" type="button">
</div>
<script type="text/javascript">
  $(document).ready(function(){

     var oTable1 = $('#myTable').dataTable({
   
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, null,null,
        ]
      });

$('#print_all_product').click(function() {

      var productCategory = $('#product_category').val();
      var productSubCategory = $('#product_sub_category').val();
      var productSubOfSubCategory = $('#product_sub_of_sub_category').val();
      var productAttribute = $('#product_attribute').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllProduct/?pcat='+productCategory+'&psubcat='+productSubCategory+'&psubofsubcat='+productSubOfSubCategory+'&pattr='+productAttribute;
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
			     var aa = JSON.parse(datas);
   		    $('#product_sub_category').html(aa.category);
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
	
	
	 $("#search_product").on("click",function(){
      var main_cat  = $('#product_category').val();
	    var sub_cat  = $('#product_sub_category').val();
	   var sub_sub_cat  = $('#product_sub_of_sub_category').val();
	   var  start_price = $( "#product_start_amt" ).val();
      var  end_price = $( "#product_end_amt" ).val();
      var product_attribute = $( "#product_attribute" ).val();
    var url="<?php echo site_url();?>webadmin/managereport/getproductsbycatandprice";
   			$.ajax({
   			url: url,
   			type:'POST',	
   			data:{main_cat:main_cat,sub_cat:sub_cat,sub_sub_cat:sub_sub_cat,start_price:start_price,end_price:end_price,product_attribute:product_attribute},
		    success: function(datas){
         

			$('#product_result').html(datas);
      if($('#product_result').find('#myTable-filter')) {
        /* $('#myTable-filter').dataTable({
   
            "aoColumns": [
                { "bSortable": false },
                null, null,null, null, null,null, null,null,
              ]
       });*/
      }
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
       $( "#amount" ).html( "Rs " + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	    //$( "#amount" ).val( "Rs " + ui.values[ 0 ] + " - Rs " + ui.values[ 1 ] );
		$( "#product_start_amt" ).val( ui.values[ 0 ]);
		$( "#product_end_amt" ).val( ui.values[ 1 ]);
	  }
    });
     $( "#amount" ).html( "Rs " + $( "#slider-range" ).slider( "values", 0 ) +
      " - " + $( "#slider-range" ).slider( "values", 1 ) );
    /*$( "#amount" ).val( "Rs " + $( "#slider-range" ).slider( "values", 0 ) +
      " - Rs " + $( "#slider-range" ).slider( "values", 1 ) );*/
  } );
  </script>
  </script>
</script>
