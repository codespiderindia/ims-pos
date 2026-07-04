  <div class="dateWiseDayClose_content">
             
               <table id="sample-table-1" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">S.No.</th>
                        <th>User Name</th>
                        <th>Payment Method</th>
                        <th>Cnote</th>
                        <th>Total</th>
                     </tr>
                  </thead>
                  <tbody>
                    <?php if(isset($dayCloseFilterInfo) && !empty($dayCloseFilterInfo)) {
                     $ctr=1;
                    foreach($dayCloseFilterInfo as $dayCloseInfos) {
                     $userwhere = ['user_ID'=>$dayCloseInfos['user_id']];
                     $getStatus = getSku('user_master', $userwhere);
                           $dayStatus = $getStatus[0]['day_close'];
                           $userName = $getStatus[0]['user_name'];
                            ?>
                      <tr>
                        <td><?php echo $ctr; ?></td>
                        <td><?php echo $userName; ?></td>
                        <td>Cash: <?php echo $dayCloseInfos['cash']; ?></br>
                          Debit Card: <?php echo $dayCloseInfos['debit_card']; ?></br>
                          Credit Card: <?php echo $dayCloseInfos['credit_card']; ?></br>
                          Cheque/Coupon: <?php echo $dayCloseInfos['cheque']; ?></br>
                        </td>
                        <td><?php echo (isset($dayCloseInfos['cnote']) ? $dayCloseInfos['cnote'] : '-'); ?></td>
                        <td><?php echo $dayCloseInfos['total']; ?></td>
                      </tr>
                  <?php $ctr++; }  } ?>
                  </tbody>
               </table>
            </div>

<!--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>-->  
<script>
   $(function(){

   		var oTable1 = $('#sample-table-1').dataTable( {
   		"aoColumns": [
   	      { "bSortable": false },
   	      null, null,null, null,
   		] } );


         $( ".ace-switch-2" ).change(function() {
            var change_status_to=0;
            if($(this).is(":checked")) {
              change_status_to=1;  
            }

            acc_id=$(this).attr('id').split('account_status_switch_');
            var url="<?php echo site_url();?>webadmin/managedayclose/changeStatus";

            $.ajax({
            url: url,
            type:'GET',
            data:"status="+change_status_to+"&acc_id="+acc_id[1],
            success: function(data){
               //alert(data);
            }
            });

         });
   });
</script>