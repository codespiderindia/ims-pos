<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info'); ?>

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
         <form class="form-horizontal" action="" method="post">
            <div class="control-group <?php if(form_error('warehouse_name') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_name">WareHouse Name</label>
               <div class="controls">
                  <input type='text' id="warehouse_name" name="warehouse_name" value="<?php if(isset($warehouseInfo->warehouse_name) && !empty($warehouseInfo->warehouse_name)){echo $warehouseInfo->warehouse_name;}?>"/>
                  <input type="hidden" id="hdn_warehouse_name" name="hdn_warehouse_name" value="<?php if(isset($warehouseInfo->warehouse_name) && !empty($warehouseInfo->warehouse_name)){echo $warehouseInfo->warehouse_name;}?>" />
                  <span for="warehouse_name" class="help-inline"> <?php echo form_error('warehouse_name') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_country') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_country">Country</label>
               <div class="controls">
                  <select name="warehouse_country" class="countries" id="countryId">
                     <option value="">Select Country</option>
                     <?php if(isset($warehouseInfo->warehouse_country) && $warehouseInfo->warehouse_country!=""){?>
                     <option selected="selected" value="<?php echo getCountryName($warehouseInfo->warehouse_country);?>" countryid="<?php echo $warehouseInfo->warehouse_country;?>"><?php echo getCountryName($warehouseInfo->warehouse_country);?></option>
                     <?php }?>
                  </select>
                  <input type='hidden' id="countryid_hidden" name="countryid" value="<?php echo $warehouseInfo->warehouse_country;?>"/>
                  <span for="warehouse_country" class="help-inline"> <?php echo form_error('warehouse_country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_state') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_state">State</label>
               <div class="controls">
                  <select name="warehouse_state" class="states" id="stateId">
                     <option value="">Select State</option>
                     <?php if(isset($warehouseInfo->warehouse_state) && $warehouseInfo->warehouse_state!=""){
                        $getAllStateName = getAllStateName($warehouseInfo->warehouse_country);
                        	foreach($getAllStateName as $valState){
                        		   if($valState->id==$warehouseInfo->warehouse_state){
                        ?>
                     <option selected="selected" value="<?php echo $valState->name;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valState->name;?>" stateid="<?php echo $valState->id;?>"><?php echo $valState->name;?></option>
                     <?php 		}
                        }// end foreach
                         }
                        ?>
                  </select>
                  <input type='hidden' id="stateid_hidden" name="stateid" value="<?php echo $warehouseInfo->warehouse_state;?>"/>
                  <span for="warehouse_state" class="help-inline"> <?php echo form_error('warehouse_state') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_city') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_city">City</label>
               <div class="controls">
                  <select name="warehouse_city" class="cities" id="cityId">
                     <option value="">Select City</option>
                     <?php if(isset($warehouseInfo->warehouse_city) && $warehouseInfo->warehouse_city!=""){
                        $getAllCityName = getAllCityName($warehouseInfo->warehouse_state);
                        	foreach($getAllCityName as $valCity){
                        		   if($valCity->id==$warehouseInfo->warehouse_city){
                        ?>
                     <option selected="selected" value="<?php echo $valCity->name;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php     }else{ ?>
                     <option value="<?php echo $valCity->name;?>" cityid="<?php echo $valCity->id;?>"><?php echo $valCity->name;?></option>
                     <?php 		}
                        }// end foreach
                        }	
                        ?>
                  </select>
                  <input type='hidden' id="cityid_hidden" name="cityid" value="<?php echo $warehouseInfo->warehouse_city;?>"/>
                  <span for="warehouse_city" class="help-inline"> <?php echo form_error('warehouse_city') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_zipcode') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_zipcode">Zipcode</label>
               <div class="controls">
                  <input type="text" id="warehouse_zipcode" name="warehouse_zipcode" value="<?php if(isset($warehouseInfo->warehouse_zipcode) && !empty($warehouseInfo->warehouse_zipcode)){echo $warehouseInfo->warehouse_zipcode;}?>" />
                  <span for="warehouse_zipcode" class="help-inline"><?php echo form_error('warehouse_zipcode') ?></span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_phone') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_phone">WareHouse Phone</label>
               <div class="controls">
                  <input type='text' id="warehouse_phone" name="warehouse_phone" value="<?php if(isset($warehouseInfo->warehouse_phone) && !empty($warehouseInfo->warehouse_phone)){echo $warehouseInfo->warehouse_phone;}?>"/>
                  <span for="warehouse_phone" class="help-inline"> <?php echo form_error('warehouse_phone') ?> </span>
                  <div class="phoneNumberClass">	
                     <span style="font-size: 10px;">Valid formats: (123) 456-7890 , 123-456-7890 , 123.456.7890 , 1234567890 , +31636363634 , 075-63546725</span>
                  </div>
               </div>
            </div>
            <div class="control-group <?php if(form_error('warehouse_address') != '') echo 'error'; ?>">
               <label class="control-label" for="warehouse_address">Address</label>
               <div class="controls">
                  <textarea id="warehouse_address" name="warehouse_address"><?php if(isset($warehouseInfo->warehouse_address) && !empty($warehouseInfo->warehouse_address)){echo $warehouseInfo->warehouse_address;}?></textarea>
                  <span for="warehouse_address" class="help-inline"> <?php echo form_error('warehouse_address') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('is_central') != '') echo 'error'; ?>">
               <label class="control-label" for="is_central">Is Central</label>
               <div class="controls">
                  <input type="checkbox" id="is_central" name="is_central" value="1" <?php if(isset($warehouseInfo->is_central) && !empty($warehouseInfo->is_central)){ if($warehouseInfo->is_central=='1') echo 'checked="checked"'; }?> style="opacity:1;">
                  <span for="is_central" class="help-inline"> <?php echo form_error('is_central') ?> </span>
				  <div class="phoneNumberClass">	
                     <span style="font-size: 10px;">Note: "Central" will be the only one in the warehouse</span>
                  </div>
               </div>
            </div>
			
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
         <?php //endforeach;?>
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
         if(countryid == '') {
            $('#cityId option:first-child').attr("selected", true);
            $('#cityid_hidden').val('');
            $('#stateid_hidden').val('');
         }
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
         $('#cityid_hidden').val(cityids);
      });
   });
</script>
</body>
</html>