<?php  $uinfo = $this->session->userdata('webadmin_session_info'); 
	/*echo '<pre>';
	print_r($uinfo);*/
?>
<style>
.fa-street-view:before {
	font-size: 20px;
    padding: 8px;
}
</style>
<a class="menu-toggler" id="menu-toggler" href="#">
				<span class="menu-text"></span>
			</a>

			<div class="sidebar" id="sidebar">
				<!--<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div>--><!--#sidebar-shortcuts-->

				<ul class="nav nav-list">
					<li>
						<a href="<?php echo site_url()."webadmin/dashboard";?>">
							<i class="fa icon-home" aria-hidden="true"></i>
							<span class="menu-text"> Dashboard </span>
						</a>
					</li>					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],1); 
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1') { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-group" aria-hidden="true"></i>
							<span class="menu-text">Groups</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">							
						<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageroles/viewRoles";?>">
									<i class="icon-double-angle-right"></i>
									Groups
								</a>
							</li>							
							<?php }?>							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageroles/addRoles";?>">
									<i class="icon-double-angle-right"></i>
									New Group
								</a>
							</li>							
							<?php }?>


				<?php $permission_array1 = checkPermissionByUserRole($uinfo['user_role'],7); 
					if(isset($permission_array1) && !empty($permission_array1)){ 
						if($permission_array1[0]['create']=='1' || $permission_array1[0]['edit']=='1' || $permission_array1[0]['delete']=='1' || $permission_array1[0]['view']=='1' ) {
						?>
							<li>
								<a href="#" class="dropdown-toggle">
									<!--<i class="icon-shield"></i>-->
									<img width="16px" height="23px" style="padding-right:3px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-permission.png" />
									<span class="menu-text">Group Permissions</span>

									<b class="arrow icon-angle-down"></b>
								</a>

								<ul class="submenu">
									<?php if($permission_array1[0]['create']=='1') { ?>
									<li>
										<a href="<?php echo site_url()."webadmin/managepermissions/addPermissions";?>">
											<i class="icon-double-angle-right"></i>
											Add Group Permissions
										</a>
									</li>
									<?php } ?>
									<?php if($permission_array1[0]['view']=='1') { ?>
									<li>
										<a href="<?php echo site_url()."webadmin/managepermissions/viewPermissions";?>">
											<i class="icon-double-angle-right"></i>
											View Group Permissions
										</a>
									</li>
									<?php } ?> 
								</ul>
							</li>
							<?php } } ?>
						</ul>
					</li>					
					<?php }
					}else{echo '<li>
						<a href="#">
							<i class="icon-group"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>';} ?>

					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],9);
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<img width="20px" height="23px" style="padding-right:6px;padding-left:5px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-department.png" />
							<!--<i class="fas icon-tags"></i>-->
							<span class="menu-text">Department</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managedepartment/viewDepartment";?>">
									<i class="icon-double-angle-right"></i>
									Department
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managedepartment/addDepartment";?>">
									<i class="icon-double-angle-right"></i>
									Add Department
								</a>
							</li>
							<?php } ?>		
							
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-building-o"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					
					<?php //echo '<pre>';print_r($uinfo);die;
					$permission_array = checkPermissionByUserRole($uinfo['user_role'],5);
					//echo '<pre>';print_r($permission_array);die;
					
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-user"></i>
							<span class="menu-text">Users/Employees</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageaccounts/viewUsers";?>">
									<i class="icon-double-angle-right"></i>
									Users
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageaccounts/addUsers";?>">
									<i class="icon-double-angle-right"></i>
									New Users
								</a>
							</li>
							<?php } ?>		
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<!--<li>
								<a href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForWarehouse";?>">
									<i class="icon-double-angle-right"></i>
									New Users For Warehouse
								</a>
							</li>-->
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<!--<li>
								<a href="<?php echo site_url()."webadmin/manageaccounts/viewUsersForStore";?>">
									<i class="icon-double-angle-right"></i>
									New Users For Store
								</a>
							</li>-->
							<?php } ?>
							<?php 
							$checkHrRole = checkHrRoleOfUser($uinfo['user_role'], $uinfo['comp_code']);
							if(!empty($checkHrRole)) { ?>
								<li>
									<a href="<?php echo site_url()."webadmin/manageaccounts/viewUserTransferStore";?>">
										<i class="icon-double-angle-right"></i>
										Store to Store Transfer
									</a>
								</li>
							<?php } ?>
						</ul>
					</li>
					<?php }
					}else{echo '<li>
						<a href="#">
							<i class="icon-user"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					

					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],8);
					if(isset($permission_array) && !empty($permission_array)){
					?>		
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="fa fa-street-view storeicon" aria-hidden="true"></i>
							<span class="menu-text"> Stores </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managestore/viewStores";?>">
									<i class="icon-double-angle-right"></i>
									View Stores
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managestore/addStores";?>">
									<i class="icon-double-angle-right"></i>
									New Store
								</a>
							</li>
							<?php } ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managestore/storeInventory";?>">
									<i class="icon-double-angle-right"></i>
									Store Inventory
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managestore/viewWarehouseToStoreReceive";?>">
									<i class="icon-double-angle-right"></i>
									Wh To Store Receive
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managestore/viewStoreToWhInvoice";?>">
									<i class="icon-double-angle-right"></i>
									Store To WH Transfer
								</a>
							</li>
							<?php 
							$permission_array1 = checkPermissionByUserRole($uinfo['user_role'],6);
							if(isset($permission_array1) && !empty($permission_array1)){

							if($permission_array1[0]['create']=='1' || $permission_array1[0]['edit']=='1' || $permission_array1[0]['delete']=='1' || $permission_array1[0]['view']=='1' ) {
							?>
							<li>
						<a href="#" class="dropdown-toggle">
							<img width="20px" height="23px" style="padding-right: 6px;padding-left: 5px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-location.png" />
							<!--<i class="fa icon-location-arrow" aria-hidden="true"></i>-->
							<span class="menu-text"> Locations </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array1[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managelocations/viewlocations";?>">
									<i class="icon-double-angle-right"></i>
									 View Locations
								</a>
							</li>
							<?php } ?>
							<?php if($permission_array1[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managelocations/addlocation";?>">
									<i class="icon-double-angle-right"></i>
									New Location
								</a>
							</li>
							<?php } ?>
							
						</ul>
					</li>
					<?php } } ?>
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-shopping-cart"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					
					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],12);
					if(isset($permission_array) && !empty($permission_array)){
					?>		
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<img width="20px" height="23px" style="padding-right:6px;padding-left:5px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-product.png" />
							<!--<i class="icon-product-hunt"></i>-->
							<span class="menu-text"> Products </span>
							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/viewProduct";?>">
									<i class="icon-double-angle-right"></i>
									View Product
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/addProduct";?>">
									<i class="icon-double-angle-right"></i>
									New Product
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/generateProductBarcode";?>">
									<i class="icon-double-angle-right"></i>
									Gernerate Product Barcode
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/generateProductSku";?>">
									<i class="icon-double-angle-right"></i>
									Generate Product SKU
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/productAgeing";?>">
									<i class="icon-double-angle-right"></i>
									Product Ageing
								</a>
							</li>
							<!--<li>
								<a href="<?php echo site_url()."webadmin/manageproduct/viewProductBatch";?>">
									<i class="icon-double-angle-right"></i>
									Product Batch
								</a>
							</li>-->
							<?php } ?>

				<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],15);
					if(isset($permission_array) && !empty($permission_array)){
					?>		
				<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
							<li>
								<a href="#" class="dropdown-toggle">
									<i class="icon-folder-open"></i>
									<span class="menu-text">Products Category</span>

									<b class="arrow icon-angle-down"></b>
								</a>

								<ul class="submenu">
									<?php if($permission_array[0]['view']=='1') { ?>
									<li>
										<a href="<?php echo site_url()."webadmin/manageproductcategory/viewProductCategory";?>">
											<i class="icon-double-angle-right"></i>
											View Category
										</a>
									</li>
									<?php } ?>
									
									<?php if($permission_array[0]['create']=='1') { ?>
									<li>
										<a href="<?php echo site_url()."webadmin/manageproductcategory/addProductCategory";?>">
											<i class="icon-double-angle-right"></i>
											New Category
										</a>
									</li>
									<?php } ?>
									
								</ul>
							</li>
							<?php } ?>


						<?php $permission_array2 = checkPermissionByUserRole($uinfo['user_role'],11);
					if(isset($permission_array2) && !empty($permission_array2)){
					?>		
					<?php if($permission_array2[0]['create']=='1' || $permission_array2[0]['edit']=='1' || $permission_array2[0]['delete']=='1' || $permission_array2[0]['view']=='1' ) { ?>	
						<li>
							<a href="#" class="dropdown-toggle">
								<img width="20px" height="23px" style="padding-right:6px;padding-left:5px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-attribute.png" />
								<!--<i class="icon-plus"></i>-->
								<span class="menu-text"> Attributes </span>

								<b class="arrow icon-angle-down"></b>
							</a>

							<ul class="submenu">
								<?php if($permission_array[0]['view']=='1') { ?>
								<li>
									<a href="<?php echo site_url()."webadmin/manageattributes/viewAttributes";?>">
										<i class="icon-double-angle-right"></i>
										View Attributes
									</a>
								</li>
								<?php } ?>
								<?php if($permission_array[0]['create']=='1') { ?>
								<li>
									<a href="<?php echo site_url()."webadmin/manageattributes/addAttributes";?>">
										<i class="icon-double-angle-right"></i>
										New Attributes
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } } ?>
						</ul>
					</li>
					<?php } 
					} }else{echo '<li>
						<a href="#">
							<i class="icon-product-hunt"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],10);
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-percent"></i>
							<span class="menu-text"> Taxes </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managetax/viewTax";?>">
									<i class="icon-double-angle-right"></i>
									View Taxes
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managetax/addTax";?>">
									<i class="icon-double-angle-right"></i>
									New Taxes
								</a>
							</li>
							<?php } ?>
							
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-percent"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>';}
					?>
					
					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],13);
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-database"></i>
							<span class="menu-text"> Warehouse </span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouse";?>">
									<i class="icon-double-angle-right"></i>
									View Warehouse
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/addWarehouse";?>">
									<i class="icon-double-angle-right"></i>
									New Warehouse
								</a>
							</li>
							<?php } ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/warehouseInventory";?>">
									<i class="icon-double-angle-right"></i>
									Warehouse Inventory
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToWarehouseInvoice";?>">
									<i class="icon-double-angle-right"></i>
									WH to WH Transfer
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToWarehouseReceive";?>">
									<i class="icon-double-angle-right"></i>
									WH to WH Receive
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewWarehouseToStoreInvoice";?>">
									<i class="icon-double-angle-right"></i>
									WH to Store Transfer
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewInvoice";?>">
									<i class="icon-double-angle-right"></i>
									Add Purchase
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managewarehouse/viewOpeningStock";?>">
									<!--<a href="<?php echo site_url()."webadmin/managewarehouse/viewInvoice";?>">-->
									<i class="icon-double-angle-right"></i>
									Add Opening Stock
								</a>
							</li>
							
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-database"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],16); 
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-user"></i>
							<span class="menu-text">Vendors</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managevendor/addVendor";?>">
									<i class="icon-double-angle-right"></i>
									Add Vendor
								</a>
							</li>
							<?php } ?>
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managevendor/viewVendor";?>">
									<i class="icon-double-angle-right"></i>
									View Vendor
								</a>
							</li>
							<?php } ?> 
							
							<li>
								<a href="<?php echo site_url()."webadmin/managevendor/addVendorPayment";?>">
									<i class="icon-double-angle-right"></i>
									Add Vendor Payment
								</a>
							</li>
							
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-shield"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>
					
					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],18); 
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-user"></i>
							<span class="menu-text">Dealer</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managedealer/addDealer";?>">
									<i class="icon-double-angle-right"></i>
									Add Dealer
								</a>
							</li>
							<?php } ?>
							
							<?php if($permission_array[0]['create']=='1' && $permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managedealer/addDealerPayment";?>">
									<i class="icon-double-angle-right"></i>
									Add Payment
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managedealer/dealerReport";?>">
									<i class="icon-double-angle-right"></i>
									Dealer Payment Report
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/managedealer/addExpenses";?>">
									<i class="icon-double-angle-right"></i>
									Add Expenses
								</a>
							</li>
						
							<?php } ?>
						
							
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managedealer/viewDealer";?>">
									<i class="icon-double-angle-right"></i>
									View Dealer
								</a>
							</li>
							<?php } ?> 
							<?php
								$permission_array1 = checkPermissionByUserRole($uinfo['user_role'],23); 
							if(isset($permission_array1) && !empty($permission_array1)){
								if($permission_array1[0]['create']=='1' || $permission_array1[0]['edit']=='1' || $permission_array1[0]['delete']=='1' || $permission_array1[0]['view']=='1' ) {
							?>
							<li>
							<a href="#" class="dropdown-toggle">
								<img width="15px" height="23px" style="padding-right:6px;padding-left:5px;" src="<?php echo base_url(); ?>assets/images/grey-Icons/grey-discount.png" />
								<span class="menu-text">Dealer Discount</span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<?php if($permission_array1[0]['create']=='1') { ?>
								<li>
									<a href="<?php echo site_url()."webadmin/managedealerdiscount/viewDiscount";?>">
										<i class="icon-double-angle-right"></i>
										View Discount
									</a>
								</li>
								<?php } ?>
								<?php if($permission_array1[0]['view']=='1') { ?>
								<li>
									<a href="<?php echo site_url()."webadmin/managedealerdiscount/addDiscount";?>">
										<i class="icon-double-angle-right"></i>
										Add Discount
									</a>
								</li>
								<?php } ?>
							</ul>
						</li>
						<?php } } ?>

						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-shield"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>';}
					?>


					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],19); 
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<i class="icon-building-o"></i>
							<span class="menu-text">Orders</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageorders/viewOrders";?>">
									<i class="icon-double-angle-right"></i>
									View Orders
								</a>
							</li>
							<?php } ?> 
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-shield"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>	';}
					?>

					<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],17); 
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['create']=='1' || $permission_array[0]['edit']=='1' || $permission_array[0]['delete']=='1' || $permission_array[0]['view']=='1' ) { ?>
					<li>
						<a href="#" class="dropdown-toggle">
						
							<i class="icon-gift"></i>
							<span class="menu-text">Offers</span>

							<b class="arrow icon-angle-down"></b>
						</a>

						<ul class="submenu">
							<?php if($permission_array[0]['create']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageoffer/addOffer";?>">
									<i class="icon-double-angle-right"></i>
									Add Offer
								</a>
							</li>
							<?php } ?>
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/manageoffer/viewOffer";?>">
									<i class="icon-double-angle-right"></i>
									View Offer
								</a>
							</li>
							<?php } ?> 
						</ul>
					</li>
					<?php } 
					}else{echo '<li>
						<a href="#">
							<i class="icon-shield"></i>
							<span class="menu-text"> Access Denied </span>
						</a>
					</li>';}
					?>
					
					
					<li>
						<a href="#" class="dropdown-toggle">
						
							<i class="icon-book"></i>
							<span class="menu-text">REPORTS</span>
							<b class="arrow icon-angle-down"></b>
						</a>
					
						<?php $permission_array = checkPermissionByUserRole($uinfo['user_role'],21); 
						
					if(isset($permission_array) && !empty($permission_array)){
					?>
					<?php if($permission_array[0]['view']=='1') { ?>
					

						<ul class="submenu">
							<?php if($permission_array[0]['view']=='1') { ?>
							<li>
								<a href="<?php echo site_url()."webadmin/managereport/generalreport";?>">
									<i class="icon-double-angle-right"></i>
									General Report
								</a>
							</li>
							
							<li>
								<a href="<?php echo site_url()."webadmin/managereport/transactionreport";?>">
									<i class="icon-double-angle-right"></i>
									Transaction Report
								</a>
							</li>

							<li>
								<a href="<?php echo site_url()."webadmin/managereport/salereport";?>">
									<i class="icon-double-angle-right"></i>
									Sale Report
								</a>
							</li>
							
							<?php } ?>
							
						</ul>
					</li>
					<?php 
					   } } ?>

					
					<?php //echo '<pre>';print_r($uinfo);
					if($uinfo['store_manager']=='1') { ?>
						<li>
							<a href="#" class="dropdown-toggle">
								<img width="20px" height="20px" src="<?php echo base_url() ?>/assets/img/stopwatch.jpg" />
								<span class="menu-text">Manage Day Close</span>
								<b class="arrow icon-angle-down"></b>
							</a>
							<ul class="submenu">
								<li>
									<a href="<?php echo site_url()."webadmin/managedayclose";?>">
										<i class="icon-double-angle-right"></i>
										Day Close
									</a>
								</li>
							</ul>
						</li>
					<?php } ?>
					

					<?php if($uinfo['user_level']=='1') { ?>
					<li>
						<a href="#" class="dropdown-toggle">
							<img width="20px" height="23px" src="<?php echo base_url() ?>assets/img/loyalty2.png" />
							<span class="menu-text">Loyalty Points</span>
							<b class="arrow icon-angle-down"></b>
						</a>
						<ul class="submenu">
							<li>
								<a href="<?php echo site_url()."webadmin/manageloyaltypoint/viewPoints";?>">
									<i class="icon-double-angle-right"></i>
									View Points
								</a>
							</li>
							<li>
								<a href="<?php echo site_url()."webadmin/manageloyaltypoint/addPoints";?>">
									<i class="icon-double-angle-right"></i>
									Add Points
								</a>
							</li>
						</ul>
					</li>
					<?php } ?>


					<?php if($uinfo['user_level']=='1') { ?>
						<li>
							<a href="<?php echo site_url()."webadmin/eventlogs"; ?>" class="dropdown-toggle">
						
								<i class="icon-book"></i>
								<span class="menu-text">Event Logs</span>
								<b class="arrow icon-angle-down"></b>
							</a>
						</li>
					<?php } ?>

					
				</ul><!--/.nav-list-->

				<div class="sidebar-collapse" id="sidebar-collapse">
					<i class="icon-double-angle-left"></i>
				</div>
			</div>
