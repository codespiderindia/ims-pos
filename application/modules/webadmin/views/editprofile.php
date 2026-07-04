<?php $this->load->view('include/layout_header'); ?>
<style type="text/css">
   .gstinput {
      
   }
</style>
<div class="page-content">
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="page-header position-relative">
            <h1 class="headingThemeColor">
               Edit Profile
               <small>
               <i class="icon-double-angle-right"></i>
               Edit profile &amp;Update
               </small>
            </h1>
         </div>
         <!--/.page-header-->
         <form id="editproperty"  method="post" action="<?php echo base_url();?>webadmin/profilesetting/editProfile"/>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('userfullName') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                        User Full Name
                        </label>
                     </div>
                  </td>
                  <td class="hidden-480">
                     <div class="control-group
                        <?php if(form_error('userfullName') != '')echo 'error'; ?>">
                        <div class="controls">
                           <input type="text" id="userfullName" 
                              name="userfullName" 
                              value="<?php if(isset($userInfo->user_full_name) && 
                                 !empty($userInfo->user_full_name)) 
                                  {echo $userInfo->user_full_name;}?>"/>
                           <span for="name" class="help-inline"> 
                           <?php echo form_error('userfullName') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>
               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('user_email') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                        User Email
                        </label>
                     </div>
                  </td>
                  <td class="hidden-480">
                     <div class="control-group
                        <?php if(form_error('user_email') != '')echo 'error'; ?>">
                        <div class="controls">
                           <input type="text" id="user_email" 
                              name="user_email"  value="<?php 
                                 if(isset($userInfo->user_email) && !empty($userInfo->user_email))
                                 {echo $userInfo->user_email;}?>"/>
                           <span for="name" class="help-inline"> 
                           <?php echo form_error('user_email') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>
               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('user_name') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                        User Name
                        </label>
                     </div>
                  </td>
                  <td class="hidden-480">
                     <div class="control-group
                        <?php if(form_error('user_name') != '')echo 'error'; ?>">
                        <div class="controls">
                           <input type="text" id="user_name" 
                              name="user_name"  value="<?php 
                                 if(isset($userInfo->user_name) && !empty($userInfo->user_name))
                                 {echo $userInfo->user_name;}?>"/>
                           <span for="name" class="help-inline"> 
                           <?php echo form_error('user_name') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>
               <tr>
                  <td class="hidden-480">
                     <div class="control-group 
                        <?php if(form_error('status') != '')
                           echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">                                    Status
                        </label>
                     </div>
                  </td>
                  <td class="hidden-phone">
                     <div class="control-group 
                        <?php if(form_error('status') != '') 
                           echo 'error'; ?>">
                        <div class="controls">
                           <select id="status"  name= "status">
                              <option value="">--select--</option>
                              <option value="<?php echo $userInfo->user_account_status;?>" 
                                 selected="selected" />
                                 <?php if($userInfo->user_account_status==0)
                                    {
                                    $notavial='Disable';
                                    echo $notavial;
                                    ?>
                              <option value="1">Enable</option>
                              <?php
                                 }
                                 ?>
                              <?php
                                 if($userInfo->user_account_status==1)
                                 	{
                                 	$available='Enable';
                                 	echo $available;
                                 	?>
                              <option value="0">Disable</option>
                              <?php
                                 }
                                 ?>
                           </select>
                           <span for="name" class="help-inline"> 
                           <?php echo form_error('status') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>

               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('Gst Number') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                         GST Number
                        </label>
                     </div>
                  </td>
                  <td>
                  <?php foreach($gstNumbers as $gstNumberss) { ?>
                  <table>
                     <tr>
                        <td>
                           <?php echo get_country_by_id($gstNumberss['country_id']).' ('.get_state_by_id($gstNumberss['state_id']).')'; ?>
                        </td>
                        <td>
                           <?php echo $gstNumberss['gst_number']; ?>
                        </td>
                        <td><input type="text" name="gstnumber" style="display: none;" class="gstinput" id="gstNumberss_<?php echo $gstNumberss['gst_number_id']; ?>" /><div class="action_div" id="action_div_<?php echo $gstNumberss['gst_number_id']; ?>"><p class="editGst mousehoverbtn" attrgstId="<?php echo $gstNumberss['gst_number_id']; ?>">Edit</p></div></td>
                     </tr>
                  </table>
                  <?php } ?>
               </td>
               </tr>
            </table>

               <!--start add more Bank form--> 
         <div class="field_wrapper">
         <div>
         <div class="page-content">
         <div class="page-header position-relative">
              <h1 class="headingThemeColor">
               Add GST Number
              </h1>
         </div>
         </div>
         <div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>">
               <label class="control-label" for="country">Country</label>
               <div class="controls">
                  <select name="country[]" class="countries common_country" id="countryId_1" countryId='1'>
                     <option value="">Select Country</option>
                  </select>
                  <input type='hidden' id="country_hidden_1" name="countryid[]" value=""/>
                  <span for="country" class="help-inline country_hidden_1"> <?php echo form_error('profile_country') ?> </span>
               </div>
            </div>

             <div class="control-group <?php if(form_error('store_state') != '') echo 'error'; ?>">
               <label class="control-label" for="state">State</label>
               <div class="controls">
                  <select name="state[]" class="common_states states" id="stateId_1" stateid="1">
                     <option value="">Select State</option>
                  </select>
                  <input type='hidden' id="stateid_hidden_1" name="stateid[]" value=""/>
                  <span for="state" class="help-inline stateid_hidden_1"><?php echo form_error('profile_state') ?></span>
               </div>
            </div>

         <div class="control-group <?php if(form_error('gst_number') != '') echo 'error'; ?>">
               <label class="control-label" for="gst_number">GST Number</label>
               <div class="controls">
                  <input type="text" min="1" class="gst_number" id="gst_number_1" name="gst_number[]" value="<?php echo set_value('gst_number') ?>" />
                  <span for="gst_number" class="help-inline gst_number_1"> <?php echo form_error('gst_number') ?> </span>
               </div>
            </div>
        
         <a href="javascript:void(0);" class="add_button" title="Add field"><img src="<?php echo base_url().'assets/img/add-icon.png';?>"/></a>
         </div>
         </div>
         <!--End add more Bank form-->

            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor submit" type="submit" id="bootbox" name="btn_updateroomtype">
               <i class="icon-ok bigger-110"></i>
               Update
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
			
			
            <!--</div>-->
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<style>
.help-inline {
   color: red;
}
.mousehoverbtn {
   cursor: pointer;
}
</style>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo base_url();?>locations/js/location.js"></script>
<script>

   $(document).on('change','.common_country', function() {
         var id = $(this).attr('countryid');
         var countryid= $('#countryId_'+id).val();
         $('#country_hidden_'+id).val(countryid);
   });

    $(document).on('change','.common_states', function() {
         var id = $(this).attr('stateid');
         var countryid= $('#stateId_'+id).val();
         $('#stateid_hidden_'+id).val(countryid);
   });

   $(document).on('click','.editGst', function() {
      var gstId = $(this).attr('attrgstid');
      $('#gstNumberss_'+gstId).show();
      $('#action_div_'+gstId).html('<p class="gst_rror" id="gst_error_'+gstId+'" style="color: red;"></p><p class="save mousehoverbtn" id="save_'+gstId+'" attrsaveId="'+gstId+'">Save</p><p class="cancel mousehoverbtn" id="cancel_'+gstId+'" attrcancelId="'+gstId+'">Cancel</p>');
   });

   $(document).on('click','.save',function() {
    
      var url="<?php echo site_url();?>webadmin/profilesetting/updateGstNumber";

      var Id = $(this).attr('attrsaveid');
      var gstInput = $('#gstNumberss_'+Id).val();

      if(gstInput == '') {
         $('#gst_error_'+Id).html('Please Enter GST Number.!!');
      } else {
         $.ajax({
            url: url,
            type:'GET',
            data:"gstInput="+gstInput+"&id="+Id,
            success: function(data){
               alert('Successfully Updated !!');
               location.reload();
            }
         });
      }
     
   });

   $(document).on('click','.cancel',function() {
       var Id = $(this).attr('attrcancelid');
       $('#gstNumberss_'+Id).css('display','none');
       $('#action_div_'+Id).html('<p class="editGst" attrgstId="'+Id+'">Edit</p>');
   });

</script>

<script type="text/javascript">
$(document).ready(function(){

   var maxField = 10; //Input fields increment limitation
   var addButton = $('.add_button'); //Add button selector
   var wrapper = $('.field_wrapper'); //Input field wrapper
   
   var x = 1; //Initial field counter is 2
   
   $(addButton).click(function(){ //Once add button is clicked
     // alert($('.field_wrapper').find('.remove_button').length);
      if($('.field_wrapper').find('.remove_button').length == 0) {
         x = 1;
      }
      alert(x);
      if(x < maxField){ //Check maximum number of input fields
         alert(x);
         var fieldHTML = '<div id="gst_content_'+x+'"><div class="page-content"><div class="page-header position-relative"><h1 class="headingThemeColor">Add GST Number '+x+'</h1></div></div><div class="control-group <?php if(form_error('country') != '') echo 'error'; ?>"><label class="control-label" for="country">Country</label><div class="controls"><select name="country[]" class="countries common_country"  id="countryId_'+x+'" countryId='+x+'><option value="">Select Country</option></select><input type="hidden" id="country_hidden_'+x+'" name="countryid[]" value=""/><span for="country" class="help-inline country_hidden_'+x+'"> <?php echo form_error('profile_country') ?> </span></div></div> <div class="control-group <?php if(form_error('profile_state') != '') echo 'error'; ?>"><label class="control-label" for="state">State</label><div class="controls"><select name="state[]" class="common_states stateId_'+x+'" id="stateId_'+x+'" stateid='+x+'><option value="">Select State</option></select><input type="hidden" id="stateid_hidden_'+x+'" name="stateid[]" value=""/><span for="state" class="help-inline stateid_hidden_'+x+'"><?php echo form_error('profile_state') ?></span></div></div><div class="control-group <?php if(form_error('gst_number') != '') echo 'error'; ?>"><label class="control-label" for="gst_number">GST Number</label><div class="controls"><input type="text" min="1" class="gst_number" id="gst_number_'+x+'" name="gst_number[]" value="<?php echo set_value('gst_number') ?>" /><span for="gst_number" class="help-inline gst_number_'+x+'"> <?php echo form_error('gst_number') ?> </span></div></div><a href="javascript:void(0);" class="remove_button" attrId="'+x+'" title="Remove field"><img src="'+'<?php echo base_url().'assets/img/remove-icon.png';?>'+'"/></a></div>'; 
       
         $(wrapper).append(fieldHTML); // Add field html

         var loc = new locationInfo();
         loc.getCountries();

         $("#countryId_"+x).on("change", function() {
           var y = $(this).attr('countryId');
           var countryId = $(this).val();

           if(countryId != ''){
              // loc.getStates(countryId);
               var rootUrl = "http://infowindtech.com.cp-in-13.webhostbox.net/inventory/locations/api.php"; 
               var call = new ajaxCall();
              
                    $("#stateId_"+y+" option:gt(0)").remove(); 
                    var url = rootUrl+'?type=getStates&countryId=' + countryId;
                    var method = "post";
                    var data = {};
                    $('#stateId_'+y).find("option:eq(0)").html("Please wait..");
                    call.send(data, url, method, function(data) {
                        $('.stateId_'+y).find("option:eq(0)").html("Select State");

                        if(data.tp == 1){

                            $.each(data['result'], function(key, val) {
                           
                               var option = $('<option />');
                                option.attr('value', key).text(val);
                                $('.stateId_'+y).append(option);

                            });
                             $('.stateId_'+y).append(option);
                          
                            $('.stateId_'+y).prop("disabled",false);
                        }
                        else{
                            alert(data.msg);
                        }
                    }); 
           }
           else{
               $("#stateId_"+y+" option:gt(0)").remove();
           }
         });
            x++; //Increment field counter
      }

      $(wrapper).on('click', '.remove_button', function(e){ 
         e.preventDefault();
         $(this).parent('div').remove(); 
         x--; 
      });

   });

      $('.submit').on('click', function() {
         var error_count = 0;
         $('.gst_number').each(function() {
            var id = $(this).attr("id").split('gst_number_');

            var url="<?php echo site_url();?>webadmin/profilesetting/checkStateIdExist";

            var countryId =  $('#countryId_'+id[1]).val();
               if(countryId=="")
               {
                  $(".country_hidden_"+id[1]).text("Please Select Country.");
                  error_count++;
               } else {
                  $(".country_hidden_"+id[1]).empty();
               }

              
             var stateId =  $('#stateId_'+id[1]).val();
               
               if(stateId=="")
               {
                  $(".stateid_hidden_"+id[1]).text("Please Select State.");
                  error_count++;
               } else {
                  var checkStatus = null;
                  $.ajax({
                  url: url,
                  type:'GET',
                  async: false ,
                  data:"stateId="+stateId,
                  success: function(data){
                     
                     if(data == 1) {
                         $(".stateid_hidden_"+id[1]).text('Already Added Gst Number For This State.');
                           error_count++;
                     } else {
                        $(".stateid_hidden_"+id[1]).empty();
                     }
                    
                     }
                  });
                   
               }  


             var gstnumber =  $('#gst_number_'+id[1]).val();
               if(gstnumber=="")
               {
                  $(".gst_number_"+id[1]).text("Please Enter GST Number.");
                  error_count++;
               } else {
                  $(".gst_number_"+id[1]).empty();
               }

         });

         if(error_count > 0) {
            return false;
         }
      });

    });
   </script>

</body>
</html>