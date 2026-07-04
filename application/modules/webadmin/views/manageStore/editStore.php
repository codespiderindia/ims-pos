<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');
  $storeId = $uinfo['store_id'];
?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
            <div class="control-group <?php if(form_error('store_name') != '') echo 'error'; ?>">
               <label class="control-label" for="store_name">Store Name</label>
               <div class="controls">
                  <input type="text" id="store_name" name="store_name" value="<?php if(isset($storeInfo->store_name) && !empty($storeInfo->store_name)){echo $storeInfo->store_name;}?>" />
                  <span for="name" class="help-inline"> <?php echo form_error('store_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(isset($error) && !empty($error)) echo $error; ?>">
               <label class="control-label" for="store_logo">Store Logo</label>
               <div class="controls">
                  <?php 
                     if(isset($storeInfo->store_logo) && !empty($storeInfo->store_logo)){
                     ?>
                  <img width="100" height="100" src="<?php echo base_url().'uploads/store_logo/thumbs/'.$storeInfo->store_logo; ?>">
                  <?php 
                     }
                     ?>
                  <input type="file" id="store_logo" name="store_logo" value="<?php if(isset($storeInfo->store_logo) && !empty($storeInfo->store_logo)){echo $storeInfo->store_logo;}?>" />
                  <input type="hidden" id="hdn_store_logo" name="hdn_store_logo" value="<?php if(isset($storeInfo->store_logo) && !empty($storeInfo->store_logo)){echo $storeInfo->store_logo;}?>" />
                  <span for="name" class="help-inline">
                  (e.q. gif, jpg, png, jpeg)
                  <?php if(isset($error) && !empty($error))
                     echo $error;
                     ?>
                  </span>
               </div>
            </div>
			<div class="control-group <?php if(form_error('store_country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="store_country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                     <?php if(isset($storeInfo->store_country_id) && $storeInfo->store_country_id!=""){?>
                     <option selected="selected" value="<?php echo getCountryName($storeInfo->store_country_id);?>" countryid="<?php echo $storeInfo->store_country_id;?>"><?php echo getCountryName($storeInfo->store_country_id);?></option>
                     <?php }?>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value="<?php echo $storeInfo->store_country_id;?>"/>
                  <span for="country" class="help-inline"> <?php echo form_error('store_country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('store_state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="store_state" class="states" id="stateId">
                     <option value="">Select State</option>
                    <?php if(isset($storeInfo->store_state_id) && $storeInfo->store_state_id!=""){
                        $getAllStateName = getAllStateName($storeInfo->store_country_id);
                        	foreach($getAllStateName as $valState){
                        		   if($valState->id==$storeInfo->store_state_id){
                        ?>
                     <option selected="selected" value="<?php echo $valState->name;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valState->name;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php 		}
                        }// end foreach
                         }
                        ?>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value="<?php echo $storeInfo->store_state_id;?>"/>
                  <span for="state" class="help-inline"> <?php echo form_error('store_state') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('store_city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <select name="store_city" class="cities" id="cityId">
                     <option value="">Select City</option>
                    
					 <?php if(isset($storeInfo->store_city_id) && $storeInfo->store_city_id!=""){
                        $getAllCityName = getAllCityName($storeInfo->store_state_id);
                        	foreach($getAllCityName as $valCity){
                        		   if($valCity->id==$storeInfo->store_city_id){
                        ?>
                     <option selected="selected" value="<?php echo $valCity->id;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valCity->id;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php 		}
                        }// end foreach
                        }	
                        ?>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value="<?php echo $storeInfo->store_city_id;?>"/>
                  <span for="city" class="help-inline"> <?php echo form_error('store_city') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('location') != '') echo 'error'; ?>">
               <label class="control-label" for="location">Assign Location</label>
               <div class="controls">
                  <select name="location" class="role" id="location">
                     <option value="">Select Location</option>
                     <?php 
                        $location = location($uinfo['comp_code']);
                        foreach($location as $location){ 
                        	if($location['id']==$storeInfo->store_location_id){
                        ?>
                     <option selected="selected" value="<?php echo $location['id'];?>"><?php echo $location['location_name'];?></option>
                     <?php }else{ ?>
                     <!--<option value="<?php echo $location['id'];?>"><?php echo $location['location_name'];?></option>-->
                     <?php }
                        }
                        ?>
                  </select>
                  <span for="country" class="help-inline"> <?php echo form_error('location') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('is_central') != '') echo 'error'; ?>">
               <label class="control-label" for="is_central">Is Central</label>
               <div class="controls">
                  <input type="checkbox" id="is_central" name="is_central" value="<?php echo $storeInfo->store_id; ?>" <?php if(isset($storeId) && !empty($storeId)){ if($storeId==$storeInfo->store_id) echo 'checked="checked"'; }?> style="opacity:1;">
                  <span for="is_central" class="help-inline"> <?php echo form_error('is_central') ?> </span>
              <div class="phoneNumberClass"> 
                     <span style="font-size: 10px;">Note: "Central" will be the only one in the Store</span>
                  </div>
               </div>
            </div>
            
            <input type="hidden" name="store_status" class="store_status" value="<?php echo $storeInfo->store_status; ?>" />

            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Update
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script type="text/javascript" language="javascript">
   $(function() {
         $("#countryId").change(function(){
         var countryid= $('#countryId :selected').val();
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('#stateId :selected').attr('stateid');
         $('#stateid_hidden').val(stateid);
      });
      
      $("#cityId").change(function(){
         var cityid= $('#cityId :selected').val();
       $('#cityid_hidden').val(cityid);
		 
		 var country_val = $('#countryid_hidden').val();
		 var state_val = $('#stateid_hidden').val();
		 var city_val = $('#cityid_hidden').val();
		 
		 var url="<?php echo site_url();?>webadmin/managestore/getLocationByCity";
			
				$.ajax({
				url: url,
				type:'POST',
				data:"country_val="+country_val+"&state_val="+state_val+"&city_val="+city_val,
				success: function(data){
					$('#location').html(data); 
				}
				});
      });
   });
</script>
</body>
</html>