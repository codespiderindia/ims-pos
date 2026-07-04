<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');
  /* echo '<pre>';
   print_r($permissionsInfo);*/
?>

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
           
            $modulecode = $this->uri->segment(5);
            $get_role_code = $this->uri->segment(4);
            $uinfo =$this->session->userdata('webadmin_session_info');
            /*$permission_array = checkPermissionByUserRole($uinfo['user_role'],$modulecode); 
            //print_r($permission_array);
             if($permission_array[0]['edit']!='1' && $get_role_code<=$permission_array[0]['rolecode']) {
            	echo "You dont have permission for edit.";
            } */ 
            if('foo' == 'baar') {}
            else{
            ?>
         <form id="myForm" class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('role_code') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Role</label>
               <div class="controls">
                  <select  name="role_code" class="role_code" id="role_code">
                     <option value="">Select Role</option>
                     <?php 
                        $role_details = role_id($uinfo['comp_code']);
                        foreach($role_details as $i=>$role){ //echo $index.$role['role_code'];
                        if($uinfo['user_level']<$role['role_code']) {
                        if($role['role_code'] == $permissionsInfo[$i]->rolecode)
                        {
                        	 $user_role_name = get_user_role($permissionsInfo[$i]->rolecode);
                        	 echo "<option  selected='selected' value='".$permissionsInfo[$i]->rolecode."'>".$user_role_name."</option>";
                        }
                        /* else
                        { 	echo "<option value='".$role['role_code']."'>".$role['role_name']."</option>";
                        } */
                        }
                        ?>
                     <!--<option value="<?php echo $role['role_code'];?>"><?php echo $role['role_name'];?></option>-->
                     <?php } 
                   
               /*foreach ($role_details as $key => $value) {
                      if($uinfo['user_level']<$value['role_code']) {
                     if($value['role_code']==$permissionsInfo[0]->rolecode){
                        $user_role_name = get_user_role($permissionsInfo[0]->rolecode);
                    echo "<option selected value='".$permissionsInfo[0]->rolecode."'>".$user_role_name."</option>"; 
                  }
                  }
               }
   */


                     ?>
                  </select>
                  <span for="name" class="help-inline"> <?php echo form_error('role_code') ?> </span>
               </div>
            </div>

            <div class="control-group <?php if(form_error('module_code') != '') echo 'error'; ?>">
               <label class="control-label" for="email">Module</label>
               <div class="controls">
                  <span for="name" class="help-inline"> <?php echo form_error('module_code') ?> </span>
                  <div class="menu">
                     <ul>
                        <?php 
                           $module_details = module_name();
                           $create =0;
                           $edit =0;
                           $delete =0;
                           $view =0;
                           
                           foreach($module_details as $j=>$module){ 
                           $permission_array = checkPermissionByUserRole($uinfo['user_role'],$module['mod_moduleid']); 
                          
						       if(!empty($permission_array)) {
                        // echo $permissionsInfo[$j]->modulecode.'===>'.$module['mod_moduleid'];
                           ?>
                           <?php //echo ($permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>
                        <li>
                           <input type="checkbox" id="module_<?php if($permissionsInfo[$j]->modulecode==$module['mod_moduleid']){ echo $permissionsInfo[$j]->modulecode;}else{echo $module['mod_moduleid'];} ?>" class="module_code" name="module_code[]"  <?php echo set_checkbox('module_code', 1);?> value="<?php echo $module['mod_moduleid']?>"  <?php echo ($permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>>

                           <span class="lbl"><?php echo $module['mod_modulecode'];?></span>
                           <input type="hidden" name="primary_id[<?php echo $j?>]" value="<?php echo $permissionsInfo[$j]->id?>" />

                           <ul id="red_<?php if($permissionsInfo[$j]->modulecode==$module['mod_moduleid']){ echo $permissionsInfo[$j]->modulecode;}else{echo $module['mod_moduleid'];}?>">
                              <?php if($permission_array[0]['create']=='1') { ?>
                              <li>
                                 <input type="hidden" name="create[<?php echo $create;?>]" value="0" />
                                 <input type="checkbox" id="create" name="create[<?php echo $create;?>]" <?php echo set_checkbox('create', 1);?> value="1" <?php echo ($permissionsInfo[$j]->create==1 && $permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>>
                                 <?php ?>
                                 <span class="lbl">Create</span>
                              </li>
                              <?php } ?>
                              <?php if($permission_array[0]['edit']=='1') { ?>
                              <li>
                                 <input type="hidden" name="edit[<?php echo $edit;?>]" value="0" />
                                 <input type="checkbox" id="edit" name="edit[<?php echo $edit;?>]" <?php echo set_checkbox('edit', 1);?> value="1" <?php echo ($permissionsInfo[$j]->edit==1 && $permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>>
                                 <span class="lbl">Edit</span>
                              </li>
                              <?php }?>
                              <?php if($permission_array[0]['delete']=='1') { ?>
                              <li>
                                 <input type="hidden" name="delete[<?php echo $delete;?>]" value="0" />
                                 <input type="checkbox" id="delete" name="delete[<?php echo $delete;?>]" <?php echo set_checkbox('delete', 1);?> value="1" <?php echo ($permissionsInfo[$j]->delete==1 && $permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>>
                                 <span class="lbl">Delete</span>
                              </li>
                              <?php }?>
                              <?php if($permission_array[0]['view']=='1') { ?>
                              <li>
                                 <input type="hidden" name="view[<?php echo $view;?>]" value="0" />
                                 <input type="checkbox" id="view" name="view[<?php echo $view;?>]" <?php echo set_checkbox('view', 1);?> value="1" <?php echo ($permissionsInfo[$j]->view==1 && $permissionsInfo[$j]->modulecode==$module['mod_moduleid'] ? 'checked' : '');?>>
                                 <span class="lbl">View</span>
                              </li>
                              <?php }?>
                           </ul>
                        </li>
                        <?php  }
                           $create++;
                           $edit++;
                           $delete++;
                           $view++; 
                           }
                           
                           ?>
                        <div style="clear:both;"></div>
                     </ul>
                  </div>
                  <!--menu-->
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
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span--><?php }// end else ?>
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
    	$('input:checkbox[id^="module_"]:checked').each(function(){
       var module_id =$(this).attr("id");
   	//alert(module_id);
   	//var module_id = $('input:checked').attr('id');
   	var res = module_id.replace("module_","");
   	
   		if ($('input[type=checkbox]').is(':checked')) {
   		
   		$('#red_'+res).show();
   		}
   	});	
   
   	$('input[id^="module_"]').click(function(){
   
           var sel_id = this.value;
   		//alert(sel_id);
   		  $('#red_'+sel_id).toggle();
   		});
   	
   	});
   
</script>
<!--inline scripts related to this page-->
</body>
</html>