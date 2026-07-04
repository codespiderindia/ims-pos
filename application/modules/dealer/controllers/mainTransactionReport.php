<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

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
    <li><a href="#fragment-1"><span>Dealers</span></a></li>
    <li><a href="#fragment-2"><span>Dealres Payments</span></a></li>
    <li><a href="#fragment-3"><span>Departments</span></a></li>
	<li><a href="#fragment-4"><span>Products</span></a></li>
	<li><a href="#fragment-5"><span>Dealers</span></a></li>
	<li><a href="#fragment-6"><span>Venders</span></a></li>
  </ul>
   
  <div id="fragment-1">
  
  <?php if(!empty($users)) { ?>
 
  <div class="table-header tableThemeColor"> All Users</div>
  
  <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;"> 
  
  
  </div>
  
  <div id="result" class="result">
               <table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Full Name</th>
						<th>Email</th>
                        <th>Credit Balance</th>
                        <th>Username </th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php
                        foreach($users as $users) { ?>
                        
                     <tr>
                        <td class="center"><?php
                          
                           ?>
                        </td>
                        <td><?php echo $users->f_name." ".$users->l_name;?></td> 
						<td><?php echo $users->email;?></td>
						<td><?php echo $users->dealer_credit_limits;?></td>  
                        <td><?php echo $users->username;?></td>
						<td><?php if($users->dealer_status=='1')  { echo "Active";  } else { 'Inactive'; } ?></td>
						</tr>
                  
  
  <?php }
  } ?>
	</tbody>
               </table>
			   </div>
			   
			  
  </div>
    <div id="fragment-2">
			<div class="table-header tableThemeColor">Dealer's Payment</div>
			   </div>
			   <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">  
			   
			   <div id="dealer_payment">
			   
			   </div> 
			   
			   <div id="result" class="result_first"><table id="myTables" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Name</th>
						<th>Assigned Store</th>
                        <th>Assigned Warehouse</th>
                        <th>Email</th>
						<th>Status</th>
                     </tr>
                  </thead>
                  <tbody><tr>
                        <td class="center">
                        </td>
                        <td>chetna </td> 
						   <td>Not Assigned.</td>
						   <td>Not Assigned.</td>  
                        <td>chetna@gmail.com</td>
						<td>Active</td>
						</tr><tr>
                        <td class="center">
                        </td>
                        <td>neha </td> 
						   <td>apna sweet<br></td>
						   <td>Not Assigned.</td>  
                        <td>neha@gmail.com</td>
						<td>Active</td>
						</tr></tbody>
               </table></div>
  
  
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
<script>
  
</script>
</body>
</html>