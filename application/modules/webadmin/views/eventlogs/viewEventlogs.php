<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
.add_user
{
	text-decoration:underline;
	font-size:12px;
}
.ace-switch-3 {
   position: static !important;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">Event Logs List</h1>
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
            <div class="span12">
               <div class="filter">
                  <label>Module Name</label>

                  <select class="module_name" id="module_name">
                     <?php foreach($modulename as $modulenames) {
                        $addSpace = $modulenames['affected_table'];
                        $affectedName = str_replace('_',' ',$addSpace);
                      ?>
                        <option value="<?php echo $modulenames['affected_table']; ?>"><?php echo $affectedName; ?></option>
                    <?php } ?>
                  </select>

                  <label>Select date</label>
                  <input type="text" name="selectDate" id="selectDate" class="selectDate">

                  <input class="btn btn_border" style="margin-bottom: 10px;" name="search" value="Search" id="search_event_log" style="" type="button">

                  <!--<button class="btn btn_border clear_all_log">Clear All Logs</button>-->
               </div>
               
               <div class="table-header tableThemeColor"> Results for "Event Logs" </div>
               <div class="event_log_content">
               <table id="eventTable" class="table table-striped table-bordered table-hover">
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
                     <?php
                  if(isset($eventlog) && !empty($eventlog)){
                    $ctr=1;
                     foreach($eventlog as $eventlogs) { ?>
                        <tr>
                           <td><?php echo $ctr; ?></td>
                           <td><?php echo $eventlogs['event_type']; ?></td>
                           <td><?php echo $eventlogs['modulename']; ?></td>
                           <td><?php echo $eventlogs['event_modified']; ?></td>
                           <td><?php echo $eventlogs['description']; ?></td>
                        </tr>
                     <?php $ctr++; }
                       } else { ?>
                        <tr>
                           <td><h6>No Records</h6></td>
                        </tr>
                      <?php } ?>
                  </tbody>
               </table>
            </div>
              
            </div>
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

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
      $("#selectDate").datepicker({ 
            dateFormat: "yy-mm-dd",
            maxDate: new Date()
          });

      $('#search_event_log').click(function() {

         var module_name  = $('#module_name').val(); 
         var selectDate  = $('#selectDate').val(); 

         if(module_name=='') {  alert("Please select Module Name"); return false;}
         if(selectDate=='') {  alert("Please select To Date"); return false;}

         var url="<?php echo site_url();?>webadmin/eventlogs/getLogs";
            
            $.ajax({
               url: url,
               type:'GET',
               data: {module_name:module_name,selectDate:selectDate},
               success: function(datas){
               $('.event_log_content').html(datas);
                  //alert(data);
               }
            });

      });

      $('.clear_all_log').click(function() {
         if(confirm('Do you want to clear all logs?')) {
            alert();
            $.ajax({
               url:'<?php echo site_url();?>webadmin/eventlogs/clearLogs',
               type:'GET',
               success: function(datas){
                  console.log(datas);
               }
            });
         }
      });
    });
 </script>

<script>
   <?php if(isset($eventlog) && !empty($eventlog)){ ?>
   $(function(){
   
   		var oTable1 = $('#eventTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null,
        ]
		
        });
   });
   <?php } ?>
</script>

</body>
</html>