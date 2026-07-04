<div class="span12">
               <?php
                  $ctr=1;
                  if(isset($dealers) && !empty($dealers)){
                   
				   ?>
				   <?php  $dealer_id = $_GET['dealer_id']; 
			

$sql = "SELECT SUM( amount ) AS amt FROM dealer_invoice WHERE credit = '1' GROUP BY '$dealer_id'";
$query =  $this->db->query($sql)->result_array();

$total_credit =  $query[0]['amt'];

$sql = "SELECT SUM( amount ) AS amt FROM dealer_invoice WHERE debit = '1' GROUP BY '$dealer_id'";
$query =  $this->db->query($sql)->result_array();

$total_debit =  $query[0]['amt'];

?>

			   <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        
                        <th>Total Credit ( In Rs.)</th>
						<th>Total Debit( In Rs.)</th>
                        <th>Amount Due ( In Rs.)</th>
                        
                     </tr>
                  </thead>
                  <tbody>
                   <tr>
				   <td><?php echo $total_credit;  ?> Rs</td>
				   <td><?php echo $total_debit; ?> Rs</td>
				   <td><?php echo $total_credit-$total_debit; ?> Rs</td>
				   </tr>
                  
				  </tbody>
               </table>
			   <div class="table-header"> Results for "Dealer's Payment" </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Date</th>
						<th>Pay For</th>
                        <th>Credit/Debit</th>
                        <th>Amount ( In Rs.)</th>
                        <th>Description</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php 
                      //  $permission_array = checkPermissionByUserRole($uinfo['user_role'],18);
                        foreach($dealers as $dealer){
                       // print_r($dealer);
						?>
                     <?php //if($uinfo['user_level']<$dealer->user_level) {
					 //if($dealer->user_role!=5 || $uinfo['user_level']==1){
					 ?>
                     <tr>
                        <td class="center"><?php echo $ctr;?></td>
                        <td><?php  echo $dealer->date;?></td>
						<td><?php  echo $dealer->title;?></td>
						 <td><?php if($dealer->credit=='1') { echo "Credit"; }
						 if($dealer->debit=='1') { echo "Debit"; }
						 ?></td>
						 <td><?php echo $dealer->amount;?></td>
						 <td><?php echo $dealer->description;?></td>
                      
                  </tr>  
                     <?php $ctr++; }?>
                  <tr><td></td></tr>
				  </tbody>
               </table>
               <?php
                  }	 else { echo "<h2>No Records Found.</h2>";	 }
                   ?>
            </div>