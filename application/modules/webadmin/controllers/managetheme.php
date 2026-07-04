<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class ManageTheme extends CI_Controller {

	public function __construct(){		
		parent::__construct();
		
		global $uInfo;
		$this->load->library('email');
		$uInfo = $this->session->userdata('webadmin_session_info');
		
		if (!isset($uInfo) || empty($uInfo)) {
			redirect('webadmin/login');
		}
		$this->load->model('managetheme_model');
	}

	public function changeThemeColor(){
		global $uInfo;
		$user_ID = $uInfo['user_ID'];
		$user_level = $uInfo['user_level'];
		$colorCode = $this->input->post('colorCode');
		$themeName = $this->input->post('themeName');
		$lightColor = $this->input->post('lightColor');
		
		$selectThemeColor = $this->managetheme_model->selectThemeColor($user_ID, $user_level);
		
		if(isset($selectThemeColor) && !empty($selectThemeColor)){
			$data = array(
					'theme_color'   => $colorCode,
					'theme_name'    => $themeName,
					'light_theme_color' => $lightColor,
					'modified_date' => date("Y-m-d h:i:s")
					);
			$this->managetheme_model->updateThemeColor($user_ID, $user_level, $data);
			// Entry for event logs
			$themeId = $selectThemeColor->theme_id;
			if($this->db->affected_rows()==true){
				event_log('update', $user_ID, $themeId, 'themes_setting', 'THEME', date("Y-m-d h:i:s"), 'Update theme color successfully.');
			}
			// End Entry for event logs
		}else{
			$data = array(
					'user_ID'       => $user_ID,
					'user_level'    => $user_level,
					'theme_color'   => $colorCode,
					'theme_name'    => $themeName,
					'light_theme_color' => $lightColor,
					'create_date'   => date("Y-m-d h:i:s"),
					'modified_date' => date("Y-m-d h:i:s")
					);
			$this->managetheme_model->insertThemeColor($data);
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert', $user_ID, $last_inserted_id, 'themes_setting', 'THEME', date("Y-m-d h:i:s"), 'Added theme color successfully.');
			}
			// End Entry for event logs
		}
	}

	public function themeColor() {
		global $uInfo;
		$user_ID = $uInfo['user_ID'];
		$user_level = $uInfo['user_level'];
		$colorCode = $this->input->post('colorCode');
		$themeName = $this->input->post('themeName');
		$selectThemeColor = $this->managetheme_model->selectThemeColor($user_ID, $user_level);

		if(isset($selectThemeColor) && !empty($selectThemeColor)){
			$data = array(
					'theme_color'   => $colorCode,
					'theme_name'    => $themeName,
					'light_theme_color' => $colorCode,
					'modified_date' => date("Y-m-d h:i:s")
					);
			$this->managetheme_model->updateThemeColor($user_ID, $user_level, $data);
			// Entry for event logs
			$themeId = $selectThemeColor->theme_id;
			if($this->db->affected_rows()==true){
				event_log('update', $user_ID, $themeId, 'themes_setting', 'THEME', date("Y-m-d h:i:s"), 'Update theme color successfully.');
			}
			// End Entry for event logs
		}else{
			$data = array(
					'user_ID'       => $user_ID,
					'user_level'    => $user_level,
					'theme_color'   => $colorCode,
					'theme_name'    => $themeName,
					'light_theme_color' => $colorCode,
					'create_date'   => date("Y-m-d h:i:s"),
					'modified_date' => date("Y-m-d h:i:s")
					);
			$this->managetheme_model->insertThemeColor($data);
			// Entry for event logs
			$last_inserted_id = $this->db->insert_id();
			if($this->db->affected_rows()==true){
				event_log('insert', $user_ID, $last_inserted_id, 'themes_setting', 'THEME', date("Y-m-d h:i:s"), 'Added theme color successfully.');
			}
			// End Entry for event logs
		}
	}

	public function getThemeColor() {
		global $uInfo;
		$user_ID = $uInfo['user_ID'];
		$user_level = $uInfo['user_level'];
		$selectThemeColor = $this->managetheme_model->selectThemeColor($user_ID, $user_level);
		$color = $selectThemeColor->theme_color;
		echo $color;
	}
	
}