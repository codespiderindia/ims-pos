<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManagePermissions extends CI_Controller {
	public function __construct()
		{		
			parent::__construct();
			
			header("cache-Control: no-store, no-cache, must-revalidate");
			header("cache-Control: post-check=0, pre-check=0", false);
			header("Pragma: no-cache");
			header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
			
			global $uInfo;
			$uInfo = $this->session->userdata('webadmin_session_info');
			
			if (!isset($uInfo) || empty($uInfo)) {
				redirect('webadmin/login');
			}
			$this->load->model('managepermissions_model');
		}
	public function index()
	{
		$data['permissions']= $this->managepermissions_model->getAllPermissions();
		$data['title'] = 'Permission | Inventory';
		$data['heading'] = 'Permissions List';
		$this->load->view('managePermissions/viewPermissions',$data);
	}
	
	// Add Permissions
	public function addPermissions() {
		global $uInfo;
		
		$modulecode=$this->input->post('module_code');
		$create_val = $this->input->post('create');
		$edit_val = $this->input->post('edit');
		$delete_val = $this->input->post('delete');
		$view_val = $this->input->post('view');
		$primary_id = $this->input->post('primary_id');

		if ($this->form_validation->run('addPermissions') == TRUE){

    		$data =array();
			$primary_id_array = array();
			
			for($i=0; $i<count($modulecode); $i++) {
    		$primary_id_array[] = $primary_id[$i];
			$data[$i]  = array(
    			'rolecode' => $this->input->post('role_code'),
				'modulecode' => "$modulecode[$i]",
				'create' => "$create_val[$i]",
				'edit'   => "$edit_val[$i]",
				'delete' => "$delete_val[$i]",
				'view'   => "$view_val[$i]"
				);
			}
			//print_r($data);exit;
			foreach ($data as $index=>$value) {
				$module_value = $value['modulecode'];
				$role_code = $value['rolecode'];
				$primary_id_for_update = $primary_id_array[$index];
				$data['exist_module'] = $this->managepermissions_model->check_exist_module($module_value,$role_code);
				
				if($data['exist_module']==0)
				{
				 $id = $this->managepermissions_model->addPermissions($value);
					
					//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('insert',$uInfo['user_ID'],$id,'role_rights','PERMISSIONS',date("Y-m-d h:i:s"),'Added Permissions');
					}
				}
				else
				{
					$updated_id = $this->managepermissions_model->updatePermissions($primary_id_for_update,$value);
					
					//Entry for event logs
					if($this->db->affected_rows()==true)
					{
						event_log('update',$uInfo['user_ID'],$primary_id_for_update,'role_rights','PERMISSIONS',date("Y-m-d h:i:s"),'Updated Permissions');
					}
				}
			}
			//$this->session->set_flashdata('success_msg','Permissions assigned successfuly ! ! !');
    		//redirect(base_url().'webadmin/managepermissions/viewPermissions');
    	}
		$data['title'] = 'Permission | Inventory';
		$data['heading'] = 'Add Permissions';
		$this->load->view('managePermissions/addPermissions', $data);
	}
	
	// View Permissions List
	public function viewPermissions(){
		global $uInfo;
		$userId = $uInfo['user_ID'];
		$compCode = $uInfo['comp_code'];
		$role = $this->managepermissions_model->getAllRoleCode($userId);
		if(!empty($role)) {
			foreach($role as $roles) {
				$roleCode[] = $roles['role_code'];
			}
			
			$data['permissions']= $this->managepermissions_model->getAllPermissionByRolCode($roleCode);
		}
		//$data['permissions']= $this->managepermissions_model->getPermissionsInfoByID($uInfo['user_role']);
		//$data['permissions']= $this->managepermissions_model->getAllPermissions();

		$data['title'] = 'Permission | Inventory';
		$data['heading'] = 'Permissions List';
		$this->load->view('managePermissions/viewPermissions',$data);
	}
	
	// Update Permissions Info.
	public function editPermissions($ID){
		global $uInfo;

		//$userId = $uInfo['user_ID'];
			$primary_id = $this->input->post('primary_id');
			$modulecode=$this->input->post('module_code');
			$create_val = $this->input->post('create');
			$edit_val = $this->input->post('edit');
			$delete_val = $this->input->post('delete');
			$view_val = $this->input->post('view');
			$role_code = $this->input->post('role_code');
		
		if ($this->form_validation->run('updatePermissions') == TRUE){
		
			$data =array();
			for($i=0; $i<count($modulecode); $i++) {
    		$data[$i]  = array(
    			'id' => "$primary_id[$i]",
				'rolecode' => $this->input->post('role_code'),
				'modulecode' => "$modulecode[$i]",
				'create' => "$create_val[$i]",
				'edit'   => "$edit_val[$i]",
				'delete' => "$delete_val[$i]",
				'view'   => "$view_val[$i]"
				);
			}
			
			foreach ($data as $value){

				$data['exist_module'] = $this->managepermissions_model->check_exist_module($value['modulecode'],$value['rolecode']);
				if($data['exist_module']==1)
				{
					$id = $value['id'];
					$this->managepermissions_model->updatePermissions($id, $value);
				} 
				
				//Entry for event logs
				if($this->db->affected_rows()==true)
				{
					event_log('update',$uInfo['user_ID'],$id,'role_rights','PERMISSIONS',date("Y-m-d h:i:s"),'Updated Permissions');
				}
			}
			
    		$this->session->set_flashdata('success_msg','Permissions Updated Successfully ! ! !');
    		redirect(base_url().'webadmin/managepermissions/viewPermissions');
    	}
    	$data['userId'] = $ID;
		$data['permissionsInfo']=$this->managepermissions_model->getPermissionsInfoByID($ID);
		//echo $this->db->last_query();
		$data['title'] = 'Permission | Inventory';
		$data['heading'] = 'Edit Permissions';
		$this->load->view('managePermissions/editPermissions',$data);
	}
	
	/* Check Role Code Of Permission */
	public function checkPermissions()
	{
		global $uInfo;
		$role_id = $this->input->post('role_id');
		$data['permissionsInfo']=$this->managepermissions_model->getPermissionsInfoByRoleID($role_id);
		
			//print_r($data['permissionsInfo']);
		
		$result = '<div class="menu">
                     <ul>';
                           $module_details = module_name();
                           $module_index = 0;
                           $create =0;
                           $edit =0;
                           $delete =0;
                           $view =0;
                           foreach($module_details as $j=>$module){ 
						   $permission_array = checkPermissionByUserRole($role_id,$module['mod_moduleid']); 
						   if(isset($data['permissionsInfo'][$j]['id']))
							{
								$primary_id = $data['permissionsInfo'][$j]['id'];
							}
							else{
								$primary_id = "";
							}
						  if(isset($permission_array) && !empty($permission_array)){
						  	if(isset($data['permissionsInfo'][$j]['modulecode']) && isset($module['mod_moduleid'])) {
						  		if($data['permissionsInfo'][$j]['modulecode']==$module['mod_moduleid']){	
								$module_checked = "checked";
							  }
							  else{$module_checked = "";}
						  	}
						  }else{$module_checked = "";}
						  
						  if(isset($permission_array) && !empty($permission_array)){
						  if($permission_array[0]['create']=='1') { 
						  $created_flag = 1;
						  $create_checked = "checked";
						  
						  } else { $created_flag = "";  $create_checked = ""; }
						  }
						  else{$created_flag = "";  $create_checked = "";}
						  
						  if(isset($permission_array) && !empty($permission_array)){
						  if($permission_array[0]['edit']=='1') { 
						  $edit_flag = 1;
						  $edit_checked = 'checked';
						  } else { $edit_flag = "";  $edit_checked = ''; }
						  }else{$edit_flag = "";  $edit_checked = ''; }
						  
						  if(isset($permission_array) && !empty($permission_array)){
						  if($permission_array[0]['delete']=='1') { 
						  $delete_checked = 'checked';
						  $delete_flag = 1;
						  } else { $delete_flag = ""; $delete_checked = ''; }
						  } else { $delete_flag = ""; $delete_checked = ''; }
						  
						  if(isset($permission_array) && !empty($permission_array)){
						  if($permission_array[0]['view']=='1') { 
						  $view_flag = 1;
						  $view_checked = 'checked';
						  } else { $view_flag = ""; $view_checked = ''; }
						  } else { $view_flag = ""; $view_checked = ''; }
						  
						 
        $result .=          '<li>
                           <input type="hidden" name="primary_id['.$j.']" value="'.$primary_id.'" />
						   <input type="hidden" id="module_'.$module_index.'" class="module_code" name="module_code['.$module_index.']" value="'.$module['mod_moduleid'].'">
                           <input type="checkbox" id="module_'.$module['mod_moduleid'].'" class="module_code" name="module_code['.$module_index.']"  '.set_checkbox('module_code', 1).' value="'.$module['mod_moduleid'].'" '.$module_checked.'>
						   
                           <span class="lbl">'.$module['mod_modulecode'].'</span>
                           <ul id="red_'.$module['mod_moduleid'].'">';
                              
		$result .=					  '<li>
                                 <input type="hidden" name="create['.$create.']" value="0" />
                                 <input type="checkbox" id="create" name="create['.$create.']" '.set_checkbox('create', 1).' value="1" '.$create_checked.'>
                                 <span class="lbl">Create</span>
                              </li>';  
							 
							
        $result .=                '<li>
                                 <input type="hidden" name="edit['.$edit.']" value="0" />
                                 <input type="checkbox" id="edit" name="edit['.$edit.']" '.set_checkbox('edit', 1).' value="1" '.$edit_checked.'>
                                 <span class="lbl">Edit</span>
                              </li>';
								 
        $result .=                '<li>
                                 <input type="hidden" name="delete['.$delete.']" value="0" />
                                 <input type="checkbox" id="delete" name="delete['.$delete.']" '.set_checkbox('delete', 1).' value="1" '.$delete_checked.'>
                                 <span class="lbl">Delete</span>
                              </li>';
							  
							  
        $result .=                '<li>
                                 <input type="hidden" name="view['.$view.']" value="0" />
                                 <input type="checkbox" id="view" name="view['.$view.']" '.set_checkbox('view', 1).' value="1" '.$view_checked.'>
                                 <span class="lbl">View</span>
                              </li>';
							
        $result .=                   '</ul>
                        </li>';
                           $module_index++;
                           $create++;
                           $edit++;
                           $delete++;
                           $view++; 
                           } 
                         
        $result .=          '<div style="clear:both;"></div>
                     </ul>
                  </div>';
			  
		$result .=		  '<script type="text/javascript">
					   $(document).ready(function(){
						 $("input:checkbox[id^="+"module_"+"]:checked").each(function(){
							var module_id =$(this).attr("id");
							
							var res = module_id.replace("module_","");
							
								if ($("input[type=checkbox]").is(":checked")) {
								
								$("#red_"+res).show();
								}
							});	
						    
						   
						   $("input[id^="+"module_"+"]").click(function(){
								
							  var sel_id = this.value;
							  $("#red_"+sel_id).toggle();
							});
						});	
						</script>';
		
		echo $result;
		
	}
}
?>
