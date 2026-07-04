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
         <p><strong><i class="icon-ok"></i>Done!</strong><?php echo $this->session->flashdata('success_msg'); ?> 
		 <a target="_blank" href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForStore";?>"></a> | <a target="_blank" href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForWarehouse";?>"></a>
		 </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_mail')): ?>
      <div class="alert alert-block alert-success">
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
    <li class="tab-li" id="tab-1"><a href="#fragment-1" target="1" class="showSingle"><span>Users</span></a></li>
    <li class="tab-li" id="tab-2"><a href="#fragment-2" target="2" class="showSingle"><span>Stores</span></a></li>
    <li class="tab-li" id="tab-3"><a href="#fragment-3" id="product_tab" target="3" class="showSingle"><span>Products</span></a></li>
	<li class="tab-li" id="tab-4"><a href="#fragment-4" id="dealer_tab" target="4" class="showSingle"><span>Dealers</span></a></li>
	<li class="tab-li" id="tab-5"><a href="#fragment-5" id="vender_tab" target="5" class="showSingle"><span>Vendors</span></a></li>
	<li class="tab-li" id="tab-6"><a href="#fragment-6" id="tax_tab" target="6" class="showSingle"><span>Taxes</span></a></li>
	<li class="tab-li" id="tab-7"><a href="#fragment-7" id="offer_tab" target="7" class="showSingle"><span>Offers</span></a></li>
  <!--<li class="tab-li" id="tab-8"><a href="#fragment-8" id="sale_tab" target="8" class="showSingle"><span>Daily Sale Report</span></a></li>-->
 </ul>
   
   <?php 
   $compCode = $uinfo['comp_code'];
   // $store_state = get_states(); 
   $allStores =  store_details($uinfo['comp_code']); 
   // $allDepartments = department_details();
   $country =  get_countries();
   ?>
  <div id="fragment-1" class="targetDiv">
  <?php if(!empty($users)) { ?>
  <div class="table-header tableThemeColor"> All Users</div>
  <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">  <div id="user_state_city_store">
  Country <select name="user_country" id="user_country" style="margin-top: 10px; width: 12%;" >
  <option value=""> Select Country </option>
  <?php 
  if(!empty($country)) {
  foreach($country as $c_val) { ?>
  <option value="<?php echo $c_val['id'];?>"><?php echo $c_val['name'];?></option>
  <?php } } ?>
  </select>
  
  State <select name="user_state" id="user_state" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select State </option>
  <?php 
  if(!empty($store_state)) {
  foreach($store_state as $user_state) { ?>
  <option value="<?php echo $user_state['id'];?>"><?php echo  $user_state['name'];?></option>
  <?php }
  }
   ?>
  </select>
  City <select name="user_city" id="user_city" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select City </option>
  </select>
  Store <select name="user_store" id="user_store" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select Store </option>
  </select>
   Department <select name="user_depart" id="user_depart" style="margin-top: 10px; width: 15%;" >
  <option value=""> Select Department </option>
  <?php $department = department_details($compCode);
      foreach($department as $departments) { ?>
      <option value="<?php echo $departments['department_id']; ?>"><?php echo $departments['department_name']; ?></option>
     <?php }
   ?>
  </select>

  </div> <!---  user_state_city_store close -->
  
  <!--<div id="user_department" style="display:none">
  <div>
 
  Departments <select name="user_depart" id="user_depart" style="margin-top: 10px; width: 11%;" >
  <option> All </option>
  <?php if(!empty($allDepartments)) { foreach($allDepartments as $d_val ) {  ?>
  <option value="<?php echo $d_val['department_id'];?>"><?php echo $d_val['department_name'];?></option>
  <?php } } ?>
  </select>
  
  </div>
  
  </div>
  -->
  </div>
  
  <div id="result" class="result_first">
               <table id="myTables-user" class="common-datatable table table-striped table-borderedss table-hover">
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
                  <tbody>
                     <?php $cnt1=1;
                        foreach($users as $val) { ?>
                        
                      <tr>
                        <td class="center"><?php echo $cnt1;?></td>
                        <td><?php echo $val->user_full_name;?></td> 
            						<td>
                          <?php if($cnt1 == 1) {
                              $stores = getStores($val->user_ID);
                                if(!empty($stores)) {
                                   foreach($stores as $stores) {
                                    echo $stores['store_name']."</br>";
                                } } 
                            } else {
                              $stores = store_details_by_id($val->store_id);
                              if(!empty($stores)) {
                                echo $stores[0]['store_name']."</br>";
                                }  else  { echo "Not Assigned."; }
                            }
                           ?>
            						</td>
            						<td><?php
                              if($cnt1 == 1) {
                                 $warehouses = getWarehouses($val->user_ID);
                                 if(!empty($warehouses)) {
                                 foreach($warehouses as $warehouses) {
                                 echo $warehouses['warehouse_name']."</br>";
                                 } } 
                              } else {
                                  $warehouses = warehouse_details_by_id($val->warehouse_id);
                                 if(!empty($warehouses)) {
                                 echo $warehouses[0]['warehouse_name']."</br>";
                                 }  else  { echo "Not Assigned."; }
                              }
                           ?>
                        </td>  
                        <td><?php  echo $val->user_email;?></td>
						            <td><?php  if($val->user_account_status=='1')  { echo "Active";  } else { 'Inactive'; } ?></td>
						        </tr>
  
  <?php $cnt1++; } 
  } ?>
	</tbody>
               </table>
			   </div>
  <?php if(!empty($users)) { ?>
  <div id="result_second" class="result_second" style="display:none;">
               <table id="myTables-user" class="common-datatable table table-striped table-borderedss table-hover">
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
                  <tbody>
                     <?php $cnt2=1;
                        foreach($users as $key=>$users) { ?>
                        
                     <tr>
                        <td class="center"><?php echo $cnt2; ?>
                        </td>
                        <td><?php echo $users->user_full_name;?></td> 
						<td><?php $stores = getStores($users->user_ID);
						  if(!empty($stores)) {
						   foreach($stores as $stores) {
						    echo $stores['store_name']."</br>";
						    } } else  { echo "Not Assigned."; } ?>
						   </td>
						   
						  <td><?php $warehouses = getWarehouses($users->user_ID);
						  if(!empty($warehouses)) {
						   foreach($warehouses as $warehouses) {
						    echo $warehouses['warehouse_name']."</br>";
						    } } else  { echo "Not Assigned."; } ?></td>  
                        <td><?php echo $users->user_email;?></td>
						<td><?php if($users->user_account_status=='1')  { echo "Active";  } else { 'Inactive'; } ?></td>
						</tr>
  
  <?php $cnt2++; } 
  } ?>
	</tbody>
               </table>
  
			   </div>
      <input class="btn btn_border" name="print_all_user" value="Print All" id="print_all_user" style="" type="button">
  </div>
  <div id="fragment-2" class="targetDiv">
    
	
	<?php if(!empty($allStores)) { ?>
 
  <div class="table-header tableThemeColor">  Stores</div>
  
  <div class="table-header" id="filters" style=" margin-top:10px;  background-color: #9f9f9f;">

    Country <select name="store_country" id="store_country" style="margin-top: 10px; width: 11%;">
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
  <select name="store_state" id="store_state" style="margin-top: 10px; width: 11%;">
  <option value=""> Select State </option>
  </select>
  City <select name="store_city" id="store_city" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select City </option>
  </select>
  Location<select name="store_location" id="store_location" style="margin-top: 10px; width: 11%;" >
  <option value=""> Select Location </option>
  
  </select>
  
  </div>
  
  <div id="store_result" class="store_result">
   <table id="store-table" class="table table-striped table-borderedss table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Store Name</th>
						            <th>Location</th>
                        <th>City</th>
						            <th>State</th>
                     </tr>
                  </thead>
                  <tbody>
                     <?php $cnt3=1;
					 foreach($allStores as $stores) { ?>
            <tr>
                <td><?php echo $cnt3; ?></td>  
		            <td class=""><?php echo $stores['store_name']; ?></td>
                <td><?php echo  get_location_by_id($stores['store_location_id']	);?></td> 
  						<td><?php echo  get_city_by_id($stores['store_city_id']);?></td>
  						<td><?php echo  get_state_by_id($stores['store_state_id']);?></td>
		        </tr>
  <?php $cnt3++; }
  } ?>
	</tbody>
               </table>
			   </div>
           <input class="btn btn_border" name="print_all_store" value="Print All" id="print_all_store" style="" type="button">
	
  </div>

  <div id="fragment-3" class="targetDiv">
   
   
  </div>
  
   <div id="fragment-4" class="targetDiv">
  
  </div>
  
   <div id="fragment-5" class="targetDiv">
    
  </div>
  
  
   <div id="fragment-6" class="targetDiv">
    
  </div>
  
   <div id="fragment-7" class="targetDiv">
    
  </div>

  <div id="fragment-8" class="targetDiv">
    
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
 $(function(){
  
  $('#print_all_user').click(function() {

      var country = $('#user_country').val();
      var state = $('#user_state').val();
      var city = $('#user_city').val();
      var store = $('#user_store').val();
      var depart = $('#user_depart').val();
      
        window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllUser/?country='+country+'&state='+state+'&city='+city+'&store='+store+'&depart='+depart;
        return false;

  });



  $('#print_all_store').click(function() {

      var country = $('#store_country').val();
      var state = $('#store_state').val();
      var city = $('#store_city').val();
      var location = $('#store_location').val();
      
      window.location.href =  '<?php echo site_url();?>webadmin/managereport/generatePdfAllStore/?country='+country+'&state='+state+'&city='+city+'&location='+location;
        return false;
  });



  

  

  $('.tab-li').click(function(){
    $('.tab-li').removeClass('ui-tabs-active');
    $('.targetDiv').hide();
    var target = $(this).find('a').attr('target');
    //var IDs = $(this).attr('id');
   
     $('#fragment-'+target).toggle().show(function() {
         if(target == 3) {
            $('#tab-'+target).addClass('ui-tabs-active');
            $('#fragment-3').load('<?php echo base_url(); ?>webadmin/managereport/Products');
         }
         if(target == 4) {
           $('#tab-'+target).addClass('ui-tabs-active');
            $('#fragment-4').load('<?php echo base_url(); ?>webadmin/managereport/Dealers');
         }
         if(target == 5) {
            $('#fragment-5').load('<?php echo base_url(); ?>webadmin/managereport/Venders');
         }
         if(target == 6) {
            $('#fragment-6').load('<?php echo base_url(); ?>webadmin/managereport/Taxes');
         }
         if(target == 7) {
            $('#fragment-7').load('<?php echo base_url(); ?>webadmin/managereport/Offers');
         }
         if(target == 8) {

            $('#fragment-8').load('<?php echo base_url(); ?>webadmin/managereport/salesReport');
         }
     });
  });
  
 /* $('.showSingle').click(function(){
    $('.tabs ul li').removeClass('ui-tabs-active ui-state-active');
    $('.targetDiv').hide();
    var target = $(this).attr('target');
    $('#fragment-'+target).show(function() {
        if(target == 3) {
            $('#fragment-3').load('<?php echo base_url(); ?>webadmin/managereport/Products');
         }
         if(target == 4) {
            $('#fragment-4').load('<?php echo base_url(); ?>webadmin/managereport/Dealers');
         }
         if(target == 5) {
            $('#fragment-5').load('<?php echo base_url(); ?>webadmin/managereport/Venders');
         }
         if(target == 6) {
            $(this).before('li').addClass('ui-tabs-active');
            $('#fragment-6').load('<?php echo base_url(); ?>webadmin/managereport/Taxes');
         }
         if(target == 7) {
            $(this).before('li').addClass('ui-tabs-active');
            $('#fragment-7').load('<?php echo base_url(); ?>webadmin/managereport/Offers');
         }
    });
  });*/

/* $("#product_tab").click(function(){
   $('.targetDiv').hide();
      $('#fragment-'+$(this).attr('target')).show();
      $('#fragment-3').load('<?php echo base_url(); ?>webadmin/managereport/Products');
   });
   
   
   $("#dealer_tab").click(function(){
     $('.targetDiv').hide();
     $('#fragment-'+$(this).attr('target')).show();
    $('#fragment-4').load('<?php echo base_url(); ?>webadmin/managereport/Dealers');
   });
   
    $("#vender_tab").click(function(){
       $('.targetDiv').hide();
       $('#fragment-'+$(this).attr('target')).show();
       $('#fragment-5').load('<?php echo base_url(); ?>webadmin/managereport/Venders');
   });
   
     $("#tax_tab").click(function(){
       $('.targetDiv').hide();
       $('#fragment-'+$(this).attr('target')).show();
        $('#fragment-6').load('<?php echo base_url(); ?>webadmin/managereport/Taxes');
   });
   
    $("#offer_tab").click(function(){
       $('.targetDiv').hide();
       $('#fragment-'+$(this).attr('target')).show();
       $('#fragment-7').load('<?php echo base_url(); ?>webadmin/managereport/Offers');
   });*/
   
           $("input[type='radio']").click(function(){
           var radioValue = $("input[name='user_filter_type']:checked").val();
           if(radioValue){

                if(radioValue=='department') {
				$('#user_state_city_store').hide();
				$('.result_first').hide();
				$('#user_department').show();
				$('.result_second').show();
				} else {
				$('#user_state_city_store').show();
				$('#user_department').hide();
				$('.result_first').show();
				$('.result_second').hide();
				}

            }

        });
   
   
   		$(".delBtn").on(ace.click_event, function() {
   			var del_loc=this.href;
   			bootbox.confirm("Are you sure you want to delete this record?", function(result) {
   				if(result) {
   					window.location.href=del_loc;
   					//bootbox.alert("You are sure!");
   				}
   			});
   			
   			return false;
   		});
   		$( "#user_state" ).change(function() {
		
   			var state_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getCityByState";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"state_id="+state_id,
		    success: function(datas){
   		    $('#user_city').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		$( "#user_country" ).change(function() {
		
   			var user_country  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getStateByCountry";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"user_country="+user_country,
		    success: function(datas){
   		    $('#user_state').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		
		$( "#store_country" ).change(function() {
		
   			var user_country  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getStateByCountry";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"user_country="+user_country,
		    success: function(datas){
   		    $('#store_state').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		
		$( "#store_state" ).change(function() {
		
   			var state_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getCityByState";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"state_id="+state_id,
		    success: function(datas){
   		    $('#store_city').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		$( "#store_city" ).change(function() {
		
   			var city_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getLocationByCity/";
   			$.ajax({
   			url: url,
   			type:'POST',	
   			data:"city_id="+city_id,
		    success: function(datas){
   		    $('#store_location').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		$( "#store_location" ).change(function() {
		
   			var location_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getStoresByLocation/";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"location_id="+location_id,
		    success: function(datas){
          
   		    $('#store_result').html(datas);
          if($('#store_result').find('#store-table-filter')) {
             /* $('#store-table-filter').dataTable({
   
                  "aoColumns": [
                      { "bSortable": false },
                      null, null,null, null,
                    ]
             });*/
          }
   			//alert(data);
   			}
   			});
   			
   		});
		
		
		
		
			$( "#user_depart" ).change(function() {
		
   			var depart_id  = $(this).val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getUsersByDepart";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"depart_id="+depart_id,
		    success: function(datas){
   		    $('.result_first').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
		
		
		
		
		$( "#user_city" ).change(function() {
		
   			var city_id  = $(this).val(); 
			var url="<?php echo site_url();?>webadmin/managereport/getStoresByCity";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"city_id="+city_id,
		    success: function(datas){
   		    $('#user_store').html(datas);
   			//alert(data);
   			}
   			});
   			
   		});
   		
		$( "#user_store" ).change(function() {
   			var store_id  = $(this).val(); 
			
			if(store_id!='') { 
   			//var url="<?php echo site_url();?>webadmin/managereport/getUsersStoreWise";
			var url="<?php echo site_url();?>webadmin/managereport/getDepartmentStoreWise";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data:"store_id="+store_id,
		    success: function(datas){
   			$('#user_depart').html(datas);
			//$('#fragment-1 .result_first').html(datas);
   				//alert(data);
   			}
   			});
   			} else {
			$('#fragment-1 .result_first').html('<h2>No Records Found.</h2>');
			}
   		});
		
		$( ".store_filters" ).change(function() {
   			var location_id  = $('#store_location').val();
			var city_id  = $('#store_city').val(); 
			var state_id  = $('#store_state').val(); 
   			var url="<?php echo site_url();?>webadmin/managereport/getStoresFilters";
   			$.ajax({
   			url: url,
   			type:'POST',
   			data: {location_id:location_id,city_id:city_id,state_id:state_id},
		    success: function(datas){
   			$('#fragment-2 .result').html(datas);
   				//alert(data);
   			}
   			});
   			
   		});
		
		
   		$( ".hr_approval" ).change(function() {
   			 if (confirm("Are You Sure to Send Email Notification ?") == true) {
   					var confirm_result = true;
   				} else {
   					var confirm_result = false;
   				}
   			var change_status_to=0;
   			if($(this).is(":checked")) {
   			change_status_to=1;	
   			}
   			acc_id=$(this).attr('id').split('hr_approval_status_switch_');
   			var url="<?php echo site_url();?>webadmin/manageaccounts/changeHrStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"status="+change_status_to+"&acc_id="+acc_id[1]+"&confirm_result="+confirm_result,
   			success: function(data){
   				//alert(data);
   			}
   			});
   			
   		});
   	<!--jQuery Table//Start-->

  var oTable1 = $('#myTables-user').dataTable( {
   
      "aoColumns": [
   
          { "bSortable": false },
   
          null, null,null, null, null,
        ]
    
        } );

   var oTable1 = $('#store-table').dataTable( {
   
      "aoColumns": [
   
          { "bSortable": false },
   
          null, null,null, null, 
        ]
    
        } );


   
   		var oTable1 = $('#account-result').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null, null,null, null,null, null,null,null,null,null,null,
        ]
		
        } );


     /* var oTable2 = $('#store-table').dataTable( {
   
      "aoColumns": [
   
          { "bSortable": false },
   
          null, null,null, null,
        ]
    
        } );*/
   
   		$('table th input:checkbox').on('click' , function(){
   
   			var that = this;
   
   			$(this).closest('table').find('tr > td:first-child input:checkbox')
   
   			.each(function(){
   
   				this.checked = that.checked;
   
   				$(this).closest('tr').toggleClass('selected');
   
   			});
   
   				
   
   		});
   
   		
   
   		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
   
   		function tooltip_placement(context, source) {
   
   			var $source = $(source);
   
   			var $parent = $source.closest('table')
   
   			var off1 = $parent.offset();
   
   			var w1 = $parent.width();
   
   			var off2 = $source.offset();
   
   			var w2 = $source.width();
   		if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
   
   			return 'left';
   
   		}
   
   
   });
</script>

  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  
  <script>
   

    jQuery(document).on('change', '.employee_name', function() {
      var dateval = $(".daily_date").val();
      var employee = $('.employee_name option:selected').val();
         $.ajax({
                url:"<?php echo site_url();?>webadmin/managereport/salesReport",
                type:'POST',
                data:"dateval="+dateval+"&employee_id="+employee,
                success: function(data) {
                  $('.allsale_content').html(data);
                }
           })
    });

  </script>
</body>
</html>