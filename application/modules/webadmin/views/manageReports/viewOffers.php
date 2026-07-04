<style type="text/css">
#product_filters label {
  display: inline-block;
}
</style>

<div class="offer_content">
  <div class="header_content">
 <div class="table-header tableThemeColor">Offers</div>
  <div class="table-header" id="product_filters" style=" padding-top: 8px; margin-top:10px;  background-color: #9f9f9f;"> 
     <label class="inline_label">Offer Name</label>
     <input type="text" name="offer_name" class="offer_name" />
     <label class="inline_label">Start Date</label>
     <input type="text" name="start_date" class="start_date" />
     <label class="inline_label">End Date</label>
     <input type="text" name="end_date" class="end_date" />
  </div>
</div>

  <div id="vender_result" class="vender_result">
  <table id="table-offer"  class="table table-striped table-borderedss table-hover">
                  <thead>
                      <tr>
                        <th>#</th>
                        <th>Offers Name</th>
            						<th>percentage or fixed</th>
            						<th>Discount</th>
            						<th>Free Product</th>
                        <th>Start</th>
                        <th>End</th>
						            <th>Description</th>
					            </tr>
                  </thead>
                  <tbody>
                    <?php  if(!empty($offers)) { ?>
                      <?php $i = 1;
					             foreach($offers as $offers) { 
                      ?>
                      <tr>
                        <td><?php echo $i;?></td>  
            						<td class=""><?php echo $offers->offer_name; ?></td>
                                    <td><?php if($offers->percentage_or_fixed =='1') {
            						echo "%";
            						} ?>
            						<?php if($offers->percentage_or_fixed =='2') {
            						echo "Fixed";
            						} ?>
            						
            						<?php if($offers->percentage_or_fixed =='3') {
            						echo "Free Product";
            						} ?>
            						</td>
            						<td><?php echo $offers->offer_discount; ?></td>
            						<td><?php echo $offers->free_product; ?></td>
            						<td><?php echo $offers->date_duration_start; ?></td>
            						<td><?php echo $offers->date_duration_end; ?></td>	
                        <td><?php echo $offers->offer_description; ?></td>
                      </tr>
                      <?php  $i++;} ?>
<?php } ?>
</tbody>
</table>
</div>

<div class="print_offer">
  <input class="btn btn_border" name="print_all_offer" value="Print All" id="print_all_offer" style="" type="button">
</div>

</div>
<script type="text/javascript">
  $(document).ready(function(){

    var oTable1 = $('#table-offer').dataTable( {
      "aoColumns": [
          { "bSortable": false },
          null, null,null, null, null,null, null, 
      ] } );


    $('#print_all_offer').click(function() {

      var offername = $('.offer_name').val();
      var startdate = $('.start_date').val();
      var enddate = $('.end_date').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllOffer/?offername='+offername+'&startdate='+startdate+'&enddate='+enddate;
        return false;
  });



       jQuery( ".start_date" ).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date, instance) {
           var offerName=$('.offer_name').val();
           var endDate=$('.end_date').val();
          $.ajax({
             url:"<?php echo site_url();?>webadmin/managereport/viewOfferFilter",
             type:'POST',
             data:"offername="+offerName+"&startdate="+date+"&enddate="+endDate,
             success: function(data) {
                $('.vender_result').html(data);
             }
          })
        }
      });


       jQuery( ".end_date" ).datepicker({
        dateFormat: "yy-mm-dd",
        onSelect: function(date, instance) {
           var offerName=$('.offer_name').val();
           var startDate=$('.start_date').val();
          $.ajax({
             url:"<?php echo site_url();?>webadmin/managereport/viewOfferFilter",
             type:'POST',
             data:"offername="+offerName+"&startdate="+startDate+"&enddate="+date,
             success: function(data) {
                $('.vender_result').html(data);
             }
          })
        }
      });


	   $('.offer_name').keyup(function() {
      var offerName=$('.offer_name').val();
      var startDate=$('.start_date').val();
          var endDate=$('.end_date').val();
      if(offerName!='') {
           $.ajax({
              url:"<?php echo site_url();?>webadmin/managereport/viewOfferFilter",
              type:'POST',
              data:"offername="+offerName+"&startdate="+startDate+"&enddate="+endDate,
              success: function(data) {
                $('.vender_result').html(data);
              }
           })
         } else {
          $.ajax({
              url:"<?php echo site_url();?>webadmin/managereport/Offers",
              type:'POST',
              data:"offername="+offerName+"&startdate="+startDate+"&enddate="+endDate,
              success: function(data) {
                $('.offer_content').html(data);
              }
           })
         }
     });
  });
  </script>
  </script>
</script>