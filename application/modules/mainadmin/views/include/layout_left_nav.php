<?php  $uinfo = $this->session->userdata('dealer_session_info');?>
<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">
			<div class="sidebar-shortcuts" id="sidebar-shortcuts">
			<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>
						<span class="btn btn-info"></span>
						<span class="btn btn-warning"></span>
						<span class="btn btn-danger"></span>
					</div>
				</div><!--#sidebar-shortcuts-->
			<ul class="nav nav-list">
				<li>
						<a href="<?php echo site_url()."mainadmin/dashboard";?>">
							<i class="icon-dashboard"></i>
							<span class="menu-text">Dashboard</span>
						</a>
					</li>					
					
					<li>
						<a href="#" class="dropdown-toggle">
						<i class="icon-edit"></i>
						<span class="menu-text">Companies</span>
						<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">							
						<li>
								<a href="<?php echo site_url()."mainadmin/managecompanies/viewCompanies";?>">
									<i class="icon-double-angle-right"></i>
									View Companies
								</a>
							</li>			
							
							
							<li>
								<a href="<?php echo site_url()."mainadmin/managecompanies/addCompanies";?>">
									<i class="icon-double-angle-right"></i>
									Add Company
								</a>
							</li>							
							
						</ul>
					</li>	

									
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>
