<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config = array(
				'loginform' => array(
								 	array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									),
									array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required'
									)
								),
				'addUsers' => array(
								 	array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email|is_unique[user_master.user_email]'
									),
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required|is_unique[user_master.user_name]'
									),
									array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[password]'
									),
									array(
										'field' => 'admin_full_name',
										'label' => 'Admin Full Name',
										'rules' => 'required'
									),
									array(
										'field' => 'department',
										'label' => 'Assign Department',
										'rules' => 'required'
									),
									array(
										'field' => 'location',
										'label' => 'Assign Location',
										'rules' => 'required'
									),
									array(
										'field' => 'role',
										'label' => 'Assign Role',
										'rules' => 'required'
									)
								
								),
					'editUsers' => array(
								 	array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									),
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required'
									),
									array(
										'field' => 'admin_full_name',
										'label' => 'Admin Full Name',
										'rules' => 'required'
									),
									array(
										'field' => 'department',
										'label' => 'Assign Department',
										'rules' => 'required'
									),
									array(
										'field' => 'location',
										'label' => 'Assign Location',
										'rules' => 'required'
									),
									array(
										'field' => 'role',
										'label' => 'Assign Role',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'matches[password]'
									)
								),
				'addCompany' => array(
								array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[password]'
									),
									array(
										'field' => 'comp_username',
										'label' => 'Username',
										'rules' => 'required|is_unique[companies.comp_username]'
									),
									array(
										'field' => 'comp_name',
										'label' => 'Company',
										'rules' => 'required'
									),
									array(
										'field' => 'comp_email',
										'label' => 'Email',
										'rules' => 'required|is_unique[companies.comp_email]'
									),
								),
				'editCompany' => array(
									array(
										'field' => 'comp_name',
										'label' => 'Company Name',
										'rules' => 'required'
									),
									array(
										'field' => 'comp_address',
										'label' => 'Company Address',
										'rules' => 'required'
									),
									array(
										'field' => 'current_pwd',
										'label' => 'Current Password',
										'rules' => 'required'
									),
									array(
										'field' => 'new_pwd',
										'label' => 'New Password',
										'rules' => 'required'
									),
									array(
										'field' => 'confirm_pwd',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[new_pwd]'
									),
								),
				'addLocation' => array(
								 	array(
										'field' => 'location_name',
										'label' => 'Location Name',
										'rules' => 'required'
									),
									array(
										'field' => 'country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required'
									),
								),
				'updateLocation' => array(
								 	
								 	array(
										'field' => 'location_name',
										'label' => 'Location Name',
										'rules' => 'required'
									),
									array(
										'field' => 'country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required'
										),
									),
				'addRoles' => array(									
									array(
										'field' => 'role_name',
										'label' => 'Role Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkRoleName'
										),
									array(										
										'field' => 'user_level',										'label' => 'Select Level',										  'rules' => 'required'										),									),
				'updateRoles' => array(
								 	array(
										'field' => 'role_name',
										'label' => 'Role Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkRoleNameOnEditCase'
										),									
									array(										
										'field' => 'user_level',	
										'label' => 'Select Level',		
										'rules' => 'required'							
										),
									),
				'addPermissions' => array(
								 	array(
										'field' => 'role_code',
										'label' => 'Role',
										'rules' => 'required'
										),
									array(
										'field' => 'module_code',
										'label' => 'Module',
										'rules' => 'required'
										),
									),
													
				'updatePermissions' => array(
								 	array(
										'field' => 'role_code',
										'label' => 'Role',
										'rules' => 'required'
										),
									array(
										'field' => 'module_code',
										'label' => 'Module',
										'rules' => 'required'
										),
									),
				'updateFirm'    => array(
									array(
										'field' => 'firm_name',
										'label' => 'Firm Name',
										'rules' => 'required'
										),
									array(
										'file' => 'firm_logo',
										'label' => 'Firm Logo',
										'rules' => 'required'
										),
									array(
										'field' => 'firm_address',
										'label' => 'Firm Address',
										'rules' => 'required'
										),
									array(
										'field' => 'firm_teen_num',
										'label' => 'Firm Teen Number',
										'rules' => 'required'
										),
									),
				'updateInvoiceSetting' => array(
										array(
											'field' => 'invoice_header',
											'label' => 'Invoice Header',
											'rules' => 'required'
										),
										array(
											'field' => 'invoice_footer',
											'label' => 'Invoice Footer',
											'rules' => 'required'
										)
									),
				'updateProfile' => array(
								 	array(
										'field' => 'userfullName',
										'label' => 'User Full Name',
										'rules' => 'required'
										),
									array(
										'field' => 'user_email',
										'label' => 'User Email',
										'rules' => 'required'
										),
									array(
										'field' => 'status',
										'label' => 'Status',
										'rules' => 'required'
										),
									array(
										'field' => 'user_name',
										'label' => 'User Name',
										'rules' => 'required'
										),
									),		
	
				'forgotpassword' => array(
								 	
								 	
									array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									)
								),
				'resetpassword' => array(
								 	
								 	
									array(
										'field' => 'reset_pass',
										'label' => 'Password',
										'rules' => 'required|matches[reset_passconf]'
									),
									array(
										'field' => 'reset_passconf',
										'label' => 'Confirm Password',
										'rules' => 'required'
									)
								),
				
				'updatePassword' => array( 
									array(
										'field' => 'password',
										'label' => 'Current Password',
										'rules' => 'required'
									),
									array(
										'field' => 'npassword',
										'label' => 'New Password',
										'rules' => 'required|matches[cpassword]'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required'
									)    
								),
				'addStores' => array(
									array(
										'field' => 'store_name',
										'label' => 'Store Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkUniqueStore'
									),
									array(
										'field' => 'store_code',
										'label' => 'Store Code',
										'rules' => 'required'
									),
									array(
										'field' => 'store_country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'store_state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'store_city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'location',
										'label' => 'Assign Location',
										'rules' => 'required'
									)
								),
				'editStore' => array(
									array(
										'field' => 'store_name',
										'label' => 'Store Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkStoreNameOnEditCase'
									),
									array(
										'field' => 'store_country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'store_state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'store_city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'location',
										'label' => 'Assign Location',
										'rules' => 'required'
									)
								),					
				'addDepartment' => array(
									array(
										'field' => 'department_name',
										'label' => 'Department Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkDepartmentName'
									),
									/* array(
										'field' => 'weekly_off',
										'label' => 'Weekly Off',
										'rules' => 'required'
									) */
								),
				/* 'editDepartment' => array(
									array(
										'field' => 'department_name',
										'label' => 'Department Name',
										'rules' => 'required'
									),
									/* array(
										'field' => 'weekly_off',
										'label' => 'Weekly Off',
										'rules' => 'required'
									) 
								), */
				'addTax' => array(
									array(
										'field' => 'country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'tax_name',
										'label' => 'Tax Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkTaxName'
									),
									array(
										'field' => 'rate',
										'label' => 'Rate',
										'rules' => 'required'
									),
								),
				'editTax' => array(
									array(
										'field' => 'country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'rate',
										'label' => 'Rate',
										'rules' => 'required'
									),
									array(
										'field' => 'tax_name',
										'label' => 'Tax Name',
										'rules' => 'required|callback_lettersOnly_check'
									),
								),
				'addAttributes' => array(
									array(
										'field' => 'attribute_name',
										'label' => 'Attributes Name',
										//'rules' => 'required|callback_lettersOnly_check|callback_attributeName_check'
										'rules' => 'required|callback_attributeName_check'									
									),
								),
				'editAttributes' => array(
									array(
										'field' => 'attribute_name',
										'label' => 'Attributes Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkAttributeNameOnEditCase'
									),
								),
				'addWarehouse' => array(
									array(
										'field' => 'warehouse_name',
										'label' => 'Warehouse Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkWarehouseName'
									),
									array(
										'field' => 'warehouse_country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_zipcode',
										'label' => 'Zipcode',
										'rules' => 'required|numeric|min_length[4]|max_length[8]'
									),
									array(
										'field' => 'warehouse_phone',
										'label' => 'WareHouse Phone',
										'rules' => 'required|callback_phoneNumber_check'
									),
									array(
										'field' => 'warehouse_address',
										'label' => 'Address',
										'rules' => 'required'
									)
								),
				'editWarehouse' => array(
									array(
										'field' => 'warehouse_name',
										'label' => 'Warehouse Name',
										'rules' => 'required|callback_lettersOnly_check|callback_checkWarehouseNameOnEditCase'
									),
									array(
										'field' => 'warehouse_country',
										'label' => 'Country',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_state',
										'label' => 'State',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_city',
										'label' => 'City',
										'rules' => 'required'
									),
									array(
										'field' => 'warehouse_zipcode',
										'label' => 'Zipcode',
										'rules' => 'required|numeric|min_length[4]|max_length[8]'
									),
									array(
										'field' => 'warehouse_phone',
										'label' => 'WareHouse Phone',
										'rules' => 'required|callback_phoneNumber_check'
									),
									array(
										'field' => 'warehouse_address',
										'label' => 'Address',
										'rules' => 'required'
									)
								),
			'addProductCategory' => array(
									array(
										'field' => 'category_name',
										'label' => 'Category Name',
										'rules' => 'required|callback_lettersOnly_check|callback_categoryNameCheck'
									),
								),
			'warehouseToStoreTransfer' => array(
									array(
										'field' => 'store_name',
										'label' => 'Store Name',
										'rules' => 'required'
									),
									array(
										'field' => 'product_in_warehouse',
										'label' => 'Product Name',
										'rules' => 'required'
									),
									array(
										'field' => 'quantity',
										'label' => 'Quantity',
										'rules' => 'required'
									),
								),
		    /*'addVendor' => array(
								 	 array(
										'field' => 'f_name',
										'label' => 'First Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'l_name',
										'label' => 'Last Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email|is_unique[vendor.email]'
									),
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required|is_unique[vendor.username]'
									),
									array(
										'field' => 'password',
										'label' => 'Password',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[password]'
									),
									array(
										'field' => 'city',
										'label' => 'City',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required'
									),
									array(
										'field' => 'zipcode',
										'label' => 'Zipcode',
										'rules' => 'required|numeric|min_length[4]|max_length[8]'
									),
									array(
										'field' => 'contact_number',
										'label' => 'Contact Number',
										'rules' => 'required|numeric'
									),
									array(
										'field' => 'firm_name',
										'label' => 'Firm Name',
										'rules' => 'required'
									),
									array(
										'field' => 'tin_number',
										'label' => 'Tin Number',
										'rules' => 'required'
									),
									array(
										'field' => 'account_number',
										'label' => 'Account Number',
										'rules' => 'required|numeric|min_length[6]'
									),
									array(
										'field' => 'ifsc_code',
										'label' => 'IFSC Code',
										'rules' => 'required|alpha_numeric'
									),
									array(
										'field' => 'account_name',
										'label' => 'Account Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'bank_name',
										'label' => 'Bank Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									)
								
								), */
			'editVendor' => array(
								 	array(
										'field' => 'f_name',
										'label' => 'First Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'l_name',
										'label' => 'Last Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'email',
										'label' => 'Email',
										'rules' => 'required|valid_email'
									),
									array(
										'field' => 'username',
										'label' => 'Username',
										'rules' => 'required'
									),
									array(
										'field' => 'city',
										'label' => 'City',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'address',
										'label' => 'Address',
										'rules' => 'required'
									),
									array(
										'field' => 'zipcode',
										'label' => 'Zipcode',
										'rules' => 'required|numeric|min_length[4]|max_length[8]'
									),
									array(
										'field' => 'contact_number',
										'label' => 'Contact Number',
										'rules' => 'required|numeric'
									),
									array(
										'field' => 'firm_name',
										'label' => 'Firm Name',
										'rules' => 'required'
									),
									array(
										'field' => 'tin_number',
										'label' => 'Tin Number',
										'rules' => 'required'
									),
									array(
										'field' => 'account_number',
										'label' => 'Account Number',
										'rules' => 'required|numeric|min_length[6]'
									),
									array(
										'field' => 'ifsc_code',
										'label' => 'IFSC Code',
										'rules' => 'required|alpha_numeric'
									),
									array(
										'field' => 'account_name',
										'label' => 'Account Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									),
									array(
										'field' => 'bank_name',
										'label' => 'Bank Name',
										'rules' => 'required|callback_onlyAlphaSpace'
									)
								
								),
		'updateVendorPassword' => array( 
									array(
										'field' => 'password',
										'label' => 'Current Password',
										'rules' => 'required'
									),
									array(
										'field' => 'npassword',
										'label' => 'New Password',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[npassword]'
									)    
								),
			'vendorToWarehouseTransfer' => array(
									array(
										'field' => 'vendor_name',
										'label' => 'Vendor Name',
										'rules' => 'required'
									)
								 ),
			'editInvoice' => array(
									array(
										'field' => 'vendor_name',
										'label' => 'Vendor Name',
										'rules' => 'required'
									)
								 ),
			'warehouseToWarehouseTransfer' => array(
									array(
										'field' => 'warehouse_name',
										'label' => 'warehouse Name',
										'rules' => 'required'
									),
									array(
										'field' => 'product_in_warehouse',
										'label' => 'Product Name',
										'rules' => 'required'
									),
									array(
										'field' => 'quantity',
										'label' => 'Quantity',
										'rules' => 'required'
									),
								),
			'addOffer' => array(
								array(
									'field' => 'offer_name',
									'label' => 'Offer Name',
									'rules' => 'required'
								),
								array(
									'field' => 'percentage_or_fixed',
									'label' => 'Percentage/Fixed',
									'rules' => 'required'
								),
								array(
									'field' => 'offer_discount',
									'label' => 'Offer Discount',
									'rules' => 'required|numeric|xss_clean'
								),
								array(
									'field' => 'date_duration_start',
									'label' => 'Start Date',
									'rules' => 'required'
								),
								array(
									'field' => 'date_duration_end',
									'label' => 'End Date',
									'rules' => 'required'
								),
								array(
									'field' => 'offer_description',
									'label' => 'Offer Description',
									'rules' => 'required'
								),
							),
			'editOffer' => array(
								array(
									'field' => 'offer_name',
									'label' => 'Offer Name',
									'rules' => 'required'
								),
								array(
									'field' => 'percentage_or_fixed',
									'label' => 'Percentage/Fixed',
									'rules' => 'required'
								),
								array(
									'field' => 'offer_discount',
									'label' => 'Offer Discount',
									'rules' => 'required|numeric|xss_clean'
								),
								array(
									'field' => 'date_duration_start',
									'label' => 'Start Date',
									'rules' => 'required'
								),
								array(
									'field' => 'date_duration_end',
									'label' => 'End Date',
									'rules' => 'required'
								),
								array(
									'field' => 'offer_description',
									'label' => 'Offer Description',
									'rules' => 'required'
								),
							),
		'addUsersForWarehouse' => array(
								array(
									'field' => 'warehouse',
									'label' => 'Warehouse Name',
									'rules' => 'required'
								)
							 ),
		'addUsersForStore' => array(
								array(
									'field' => 'store',
									'label' => 'Store Name',
									'rules' => 'required'
								)
							 ),
		/*'editUsersForStore' => array(
								array(
									'field' => 'store',
									'label' => 'Store Name',
									'rules' => 'required'
								)
							 ),*/
		'editUsersForWarehouse' => array(
								array(
									'field' => 'warehouse',
									'label' => 'Warehouse Name',
									'rules' => 'required'
								)
							 ),
							 
	'warehouseToWarehouseReceive' => array(
									array(
										'field' => 'status',
										'label' => 'Status',
										'rules' => 'required'
									),
								),
	'warehouseToStoreReceive' => array(
									array(
										'field' => 'status',
										'label' => 'Status',
										'rules' => 'required'
									),
								),
	'updateDealerPassword' => array( 
									array(
										'field' => 'password',
										'label' => 'Current Password',
										'rules' => 'required'
									),
									array(
										'field' => 'npassword',
										'label' => 'New Password',
										'rules' => 'required'
									),
									array(
										'field' => 'cpassword',
										'label' => 'Confirm Password',
										'rules' => 'required|matches[npassword]'
									)    
								),
	'otherCountry' => array(
								 	
								 	array(
										'field' => 'sortname',
										'label' => 'Country sortname',
										'rules' => 'required|strtoupper|max_length[2]|alpha'
									),
									array(
										'field' => 'name',
										'label' => 'Country Name',
										'rules' => 'required|callback_customAlpha'
									)
								),
	'otherState' => array(
								 	
								 	array(
										'field' => 'state_name',
										'label' => 'State name',
										'rules' => 'required|callback_customAlpha'
									),
									array(
										'field' => 'country',
										'label' => 'Country Name',
										'rules' => 'required'
									)
								),
	'otherCity' => array(
								 	
								 	array(
										'field' => 'city_name',
										'label' => 'City name',
										'rules' => 'required|callback_customAlpha'
									),
									array(
										'field' => 'country',
										'label' => 'Country Name',
										'rules' => 'required'
									),
									array(
										'field' => 'state',
										'label' => 'State Name',
										'rules' => 'required'
									)
								),
	'editDayClosePayment' => array(
									array(
										'field' => 'total_cash_payment',
										'label' => 'Cash Payment',
										'rules' => 'required'
									),
									array(
										'field' => 'shot',
										'label' => 'Shot',
										'rules' => 'required'
									),
								)
				        );