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
						<a href="<?php echo site_url()."sales/dashboard";?>">
							<i class="icon-dashboard"></i>
							<span class="menu-text">Dashboard</span>
						</a>
					</li>					
					
					<li>
						<a href="#" class="dropdown-toggle">
						<i class="icon-edit"></i>
						<span class="menu-text">Sales</span>
						<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">							
						<li>
							<a href="<?php echo site_url()."sales/managesales";?>">
								<i class="icon-double-angle-right"></i>
								Add Sale
							</a>
						</li>			
							
						<li>	
							<a href="<?php echo site_url()."sales/managesales/dailyDayClose";?>">
								<i class="icon-double-angle-right"></i>
								Day Close
							</a>
						</li>	
							
						</ul>
					</li>
					<li>
						<a href="#" class="dropdown-toggle">
						<i class="icon-edit"></i>
						<span class="menu-text">Reports</span>
						<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">			
						<li>
							<a href="<?php echo site_url()."sales/managereports/sales_summary";?>">
								<i class="icon-double-angle-right"></i>
								Sales Summary
							</a>
						</li>			
						<li>
							<a href="<?php echo site_url()."sales/managereports/sales_detail";?>">
								<i class="icon-double-angle-right"></i>
								Sales Detail
							</a>
						</li>
						<li>
							<a href="<?php echo site_url()."sales/managereports/rpt_best_selling";?>">
								<i class="icon-double-angle-right"></i>
								Best Selling Products
							</a>
						</li>	
						<!--<li>
							<a href="<?php echo site_url()."sales/managereports/rpt_emp_wise_sells";?>">
								<i class="icon-double-angle-right"></i>
								Emp. wise Sales 
							</a>
						</li>-->
						<li>
							<a href="<?php echo site_url()."sales/managereports/rpt_sales_profit";?>">
								<i class="icon-double-angle-right"></i>
								Sale Profit
							</a>
						</li>	
						<li>
							<a href="<?php echo site_url()."sales/managereports/rpt_stock_detail";?>">
								<i class="icon-double-angle-right"></i>
								Stock Detail
							</a>
						</li>		
						<li>
							<a href="<?php echo site_url()."sales/managereports/dailySaleReport";?>">
								<i class="icon-double-angle-right"></i>
								Daily Sales Report
							</a>
						</li>		
							
						</ul>
					</li>	

									
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>
