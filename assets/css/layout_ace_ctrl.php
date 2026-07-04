				<div class="ace-settings-container" id="ace-settings-container">
					<div class="btn btn-app btn-mini btn-warning ace-settings-btn" id="ace-settings-btn">
						<i class="icon-cog bigger-150"></i>
					</div>

					<div class="ace-settings-box" id="ace-settings-box">
						<div>
							<div class="pull-left">
							<?php 
							$uinfo = $this->session->userdata('webadmin_session_info');
							$user_ID = $uinfo['user_ID'];
							$user_level = $uinfo['user_level'];
							
							$userSelectThemeColor = userSelectThemeColor($user_ID,$user_level);
							if(isset($userSelectThemeColor) && !empty($userSelectThemeColor)){
								 $theme_color = $userSelectThemeColor->theme_color;
							}
							?>
								<select id="skin-colorpicker" class="hide">
									<option mytag="default" light-color="#62a8d1" data-class="default" value="#438EB9" <?php if(isset($theme_color) && !empty($theme_color)){ if($theme_color=='#438EB9'){ echo 'selected="selected"'; } }?> />#438EB9
									<option mytag="skin-1" light-color="#3b86c7" data-class="skin-1" value="#222A2D" <?php if(isset($theme_color) && !empty($theme_color)){ if($theme_color=='#222A2D'){ echo 'selected="selected"'; } }?> />#222A2D
									<option mytag="skin-2" light-color="#ea609b" data-class="skin-2" value="#C6487E" <?php if(isset($theme_color) && !empty($theme_color)){ if($theme_color=='#C6487E'){ echo 'selected="selected"'; } }?> />#C6487E
									<option mytag="skin-3" light-color="#616060" data-class="skin-3" value="#D0D0D0" <?php if(isset($theme_color) && !empty($theme_color)){ if($theme_color=='#D0D0D0'){ echo 'selected="selected"'; } }?> />#D0D0D0
									<option mytag="skin-4" light-color="#50D900" data-class="skin-4" value="#3FAB24" <?php if(isset($theme_color) && !empty($theme_color)){ if($theme_color=='#3FAB24'){ echo 'selected="selected"'; } }?> />#3FAB24
								</select>
							</div>
							<span>&nbsp; Choose Skin</span>
						</div>
						<div>
							<h2>Example 1</h2>
							Color: <input class="jscolor" value="ab2567">
						</div>
					</div>

				</div><!--/#ace-settings-container-->