<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Edit Locations
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
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('location_name') != '') echo 'error'; ?>">
               <label class="control-label" for="location_name">Location Name</label>
               <div class="controls">
                  <input type="text" id="location_name" name="location_name" value="<?php echo $locationInfo->location_name; ?>" />
                  <span for="channel_name" class="help-inline"><?php echo form_error('location_name') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                     <?php if(isset($locationInfo->country_id) && $locationInfo->country_id!=""){?>
                     <option selected="selected" value="<?php echo getCountryName($locationInfo->country_id);?>" countryid="<?php echo $locationInfo->country_id;?>"><?php echo getCountryName($locationInfo->country_id);?></option>
                     <?php }?>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value="<?php echo $locationInfo->country_id;?>"/>
                  <span for="country" class="help-inline"> <?php echo form_error('country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="state" class="states" id="stateId">
                     <option value="">Select State</option>
                     <?php if(isset($locationInfo->state_id) && $locationInfo->state_id!=""){
					 
                            $getAllStateName = getAllStateName($locationInfo->country_id);
                        	foreach($getAllStateName as $valState){
                        		if($valState->id==$locationInfo->state_id){
					 ?>
					 <option selected="selected" value="<?php echo $valState->id;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valState->name;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php 	   }
                            }// end foreach
                         } // end isset
                        ?>					 
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value="<?php echo $locationInfo->state_id;?>"/>
                  <span for="state" class="help-inline"> <?php echo form_error('state') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('city') != '') echo 'error'; ?>">
               <label class="control-label" for="city">City</label>
               <div class="controls">
                  <select name="city" class="cities" id="cityId">
                     <option value="">Select City</option>
                     <?php if(isset($locationInfo->city_id) && $locationInfo->city_id!=""){ 
                        
						    $getAllCityName = getAllCityName($locationInfo->state_id);
                        	foreach($getAllCityName as $valCity){
                        		if($valCity->id==$locationInfo->city_id){
                        ?>
                     <option selected="selected" value="<?php echo $valCity->id;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valCity->name;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php 	   }
                        	}// end foreach
                          }// end if
						  
						  
                        ?>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value="<?php echo $locationInfo->city_id;?>"/>
                  <span for="city" class="help-inline"> <?php echo form_error('city') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('address') != '') echo 'error'; ?>">
               <label class="control-label" for="address">Address</label>
               <div class="controls">
                  <textarea id="address" name="address"><?php echo $locationInfo->address;?></textarea>
                  <span for="address" class="help-inline"><?php echo form_error('address') ?></span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Submit
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
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"> </script>-->
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script type="text/javascript" language="javascript">
   $(function() {
         $("#countryId").change(function(){
         var countryid= $('#countryId :selected').val();
         $('#countryid_hidden').val(countryid);
      });
      
      $("#stateId").change(function(){
         var stateid= $('#stateId :selected').val();
         var stateids;
         if($.isNumeric(stateid)){
            stateids = stateid;
         } else {
            stateids = $('#stateId :selected').attr('stateid');
         } 
         $('#stateid_hidden').val(stateids);
      });
      
      $("#cityId").change(function(){
           var cityid = $('#cityId :selected').val();
           var cityids;
           if($.isNumeric(cityid)){
               cityids = cityid;
           } else {
               cityids = $('#cityId :selected').attr('cityid');
           } 
        /* var cityid= $('#cityId :selected').attr('cityid');
         var cityids;
         if(typeof cityid === 'undefined') {
            cityids = $('#cityId :selected').val();
         } else {
            cityids = cityid;
         }*/
       $('#cityid_hidden').val(cityids);
      });
   });
</script>
</body>
</html>