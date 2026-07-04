<?php $this->load->view('include/layout_header'); ?>
<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
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
         <?php 
            $uinfo = $this->session->userdata('webadmin_session_info');
            //print_r($uinfo);
         //print_r($permissionsInfo);
         
         ?>
         
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('role_code') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Role</label>
               <div class="controls">
                  <select name="role_code" class="role_code" id="role_code">
                     <option value="">Select Role</option>
                     <?php 
                        $role_details = role_id($uinfo['comp_code']);
                        foreach($role_details as $role){ 
                        if($uinfo['user_level']<$role['role_code'] || $uinfo['user_level']==1) {
                        ?>
                     <option value="<?php echo $role['role_code'];?>"><?php echo $role['role_name'];?></option>
                     <?php  }  }?>
                  </select>
                  <span for="name" class="help-inline"> <?php echo form_error('role_code') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('module_code') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Module</label>
               <div class="controls">
                  <!--<select name="module_code" class="module_code" id="module_code">
                     <option value="">Select Module</option>
                     <?php 
                        $module_details = module_name();
                        foreach($module_details as $module){ 
                        ?>
                     <option value="<?php echo $module['mod_moduleid']?>"><?php echo $module['mod_modulecode'];?></option>
                     <?php }?>
                     </select>-->
                  <span for="name" class="help-inline"> <?php echo form_error('module_code') ?> </span>
                  <div id="res">
               <div class="menu">
                     <ul>
                        <?php 
                           $module_details = module_name();
                           $module_index = 0;
                           $create =0;
                           $edit =0;
                           $delete =0;
                           $view =0;
                           foreach($module_details as $module){ 
                           ?>
                        <li>
                           <input type="hidden" id="module_<?php echo $module_index?>" class="module_code" name="module_code[<?php echo $module_index; ?>]" value="<?php echo $module['mod_moduleid']?>">
                           <input type="checkbox"  id="module_<?php echo $module['mod_moduleid']?>" class="module_code" name="module_code[<?php echo $module_index; ?>]"  <?php echo set_checkbox('module_code', 1);?> value="<?php echo $module['mod_moduleid']?>">
                           <span class="lbl"> <?php echo $module['mod_modulecode'];?></span>
                           <ul id="red_<?php echo $module['mod_moduleid']?>">
                              <li>
                                 <input type="hidden" name="create[<?php echo $create;?>]" value="0" />
                                 <input type="checkbox" id="create" name="create[<?php echo $create;?>]" <?php echo set_checkbox('create', 1);?> value="1">
                                 <span class="lbl"> Create</span>
                              </li>
                              <li>
                                 <input type="hidden" name="edit[<?php echo $edit;?>]" value="0" />
                                 <input type="checkbox" id="edit" name="edit[<?php echo $edit;?>]" <?php echo set_checkbox('edit', 1);?> value="1">
                                 <span class="lbl"> Edit</span>
                              </li>
                              <li>
                                 <input type="hidden" name="delete[<?php echo $delete;?>]" value="0" />
                                 <input type="checkbox" id="delete" name="delete[<?php echo $delete;?>]" <?php echo set_checkbox('delete', 1);?> value="1">
                                 <span class="lbl"> Delete</span>
                              </li>
                              <li>
                                 <input type="hidden" name="view[<?php echo $view;?>]" value="0" />
                                 <input type="checkbox" id="view" name="view[<?php echo $view;?>]" <?php echo set_checkbox('view', 1);?> value="1">
                                 <span class="lbl"> View</span>
                              </li>
                           </ul>
                        </li>
                        <?php
                           $module_index++;
                           $create++;
                           $edit++;
                           $delete++;
                           $view++; 
                           }
                           ?>
                        <div style="clear:both;"></div>
                     </ul>
                  </div>
              </div>
                  <!--menu-->
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Save
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
<script>
   $(function(){
         $( ".ace-switch-3" ).change(function() {
            var change_status_to=0;
            if($(this).is(":checked")) {
            change_status_to=1;  
            }
            acc_id=$(this).attr('id').split('account_status_switch_');
            var url="<?php echo site_url();?>webadmin/manageaccounts/changeStatus";
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
<script type="text/javascript">
   $(document).ready(function(){
       $('input[id^="module_"]').click(function(){
   
           var sel_id = this.value;
         //alert(sel_id);
           $('#red_'+sel_id).toggle();
         });
      
      //on change function
      $("#loadingDiv").hide();
      $("#role_code").on('change',function(){
         var role_val = $(this).val();
         //alert(role_val);
         var url="<?php echo site_url();?>webadmin/managepermissions/checkPermissions";
            if(role_val!=""){
            $.ajax({
            url: url,
            type:'POST',
            data:"role_id="+role_val,
            beforeSend: function(){
                $("#loadingDiv").show();
               },
               complete: function(){
                $("#loadingDiv").hide();
               },
            success: function(data){
               //alert(data);
              $("#res").html(data);
            }
            });
         }
         else{
            window.location.reload();
         }
      });
      });
   
</script>
<!--inline scripts related to this page-->
 <div id="loadingDiv" style="background:#000;width: 100%;height:100%;border:1px solid black;position:fixed;top:0%;left:0%;padding:208px 642px;opacity: 0.7; z-index: 1111;"><img src='<?php echo base_url()?>assets/img/ajax-loader.gif' width="64" height="64" /><br>Loading...</div>
</body>
</html>