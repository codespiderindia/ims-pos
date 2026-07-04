<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

               <?php
                  if(isset($getLog) && !empty($getLog)){
                   ?>
               <table id="eventTableFilter" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Event Type</th>
                        <th>Module Name</th>
                        <th>Event Modified</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $ctr=1;
                     foreach($getLog as $getLogs) { ?>
                        <tr>
                           <td><?php echo $ctr; ?></td>
                           <td><?php echo $getLogs['event_type']; ?></td>
                           <td><?php echo $getLogs['modulename']; ?></td>
                           <td><?php echo $getLogs['event_modified']; ?></td>
                           <td><?php echo $getLogs['description']; ?></td>
                        </tr>
                     <?php $ctr++; } ?>
                  </tbody>
               </table>
               <?php } ?>


<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<script>
   $(function(){
   
   		var oTable1 = $('#eventTableFilter').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null,
        ]
		
        });
   });
</script>

</body>
</html>