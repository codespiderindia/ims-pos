<?php $uinfo = $this->session->userdata('dealer_session_info');
$user_ID = $uinfo['user_ID'];
$user_level = $uinfo['user_level'];
/*
$userSelectThemeColor = userSelectThemeColor($user_ID, $user_level);
if(isset($userSelectThemeColor) && !empty($userSelectThemeColor)){
	 $theme_color = $userSelectThemeColor->theme_color;
	 $theme_name = $userSelectThemeColor->theme_name;
	 $light_color = $userSelectThemeColor->light_theme_color;
	 $bodyClass = "class=".$theme_name."";
}*/
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8" />
      <title><?php echo $title; ?></title>
      <meta name="description" content="" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
      <!--basic styles-->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/style.css" />
      <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet" />
      <link href="<?php echo base_url();?>assets/css/bootstrap-responsive.min.css" rel="stylesheet" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/font-awesome.min.css" />
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />
      <!--[if IE 7]>
      <link rel="stylesheet" href="<?php echo base_url();?>/assets/css/font-awesome-ie7.min.css" />
      <![endif]-->
      <!--page specific plugin styles-->
      <!--fonts-->
      <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
      <!--ace styles-->
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace.min.css" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-responsive.min.css" />
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-skins.min.css" />
      <!--[if lte IE 8]>
      <link rel="stylesheet" href="<?php echo base_url();?>assets/css/ace-ie.min.css" />
      <![endif]-->
      <!--inline styles related to this page-->
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<style>
		/**** Hr Approval Css Start ****/
		input.ace-switch.hr_approval[type="checkbox"]:checked + .lbl::after {
			content: "";
		}
		input.ace-switch.hr_approval[type="checkbox"] + .lbl::after {
			content: "";
			font-family: FontAwesome;
			font-size: 13px;
			line-height: 23px;
			top: -1px;
		}
		/**** Hr Approval Css End ****/
		
		/**** Permission Css Start ****/
		.menu{
			margin-top:-15px;
		}
		.menu ul{
			list-style:none;
			margin-left:0px!important;
			
		}
		.menu ul li{
			float:left;
			margin-right: 10px;
		}
		.menu ul li ul{
			display:none;
			margin-left:0px;
			 margin-top: 10px;
			 width:66px;
		}
		/*.menu ul li:hover ul{
			display:block;
		}*/
		.menu ul li ul li{
			float:none;
		}
		/**** Permission Css End ****/
		
		/**** Product Css Start ****/	
		.productMenu ul{
			list-style:none;
			margin-left:0px!important;
		}
		.productMenu ul li{
			margin-right: 10px;
		}
		.productMenu li{
			line-height: 25px;
		}
		.attribute_parameter{
			margin-left: 60px;
		}
		.fstResultItem.fstSelected {
			display:none;
		}
		.product_help-inline{
			color:#d16e6c;
		}
		.weekly_of_checkbox .checkbox > input{
			opacity:1;
		}
		.department_select .checkbox > input{
			opacity:1;
		}
		/**** Product Css End ****/	
		
		<?php if(isset($theme_color) && !empty($theme_color)){ ?>
		.headingThemeColor{
			color:<?php echo $theme_color; ?> !important;
		}
		.tableThemeColor{
			background-color:<?php echo $theme_color; ?>;
		}
		.buttonThemeColor, .buttonThemeColor:hover{
			background-color:<?php echo $theme_color; ?> !important;
			border-color:<?php echo $theme_color; ?>;
		}
		.welcomeThemeColor{
			background:<?php echo $light_color; ?> !important;
		}
		.pagination ul > li.active > a, .pagination ul > li.active > a:hover {
			background-color: <?php echo $theme_color; ?> ;
			border-color: <?php echo $theme_color; ?> ;
		}
		.btn.btn-primary, .btn.btn-primary:hover{
			background-color: <?php echo $theme_color; ?> !important;
			border-color: <?php echo $theme_color; ?> !important;
		}
		<?php } ?>
		/* Start css for option child */
		.optionGroup {
		font-weight: bold;
		font-style: italic;
		}

		.optionChild {
		padding-left: 15px;
		}
		/* End css for option child */
	  </style>
	  <!--- Product Page for autocomplete css --->
	  <link rel="stylesheet" href="<?php echo base_url();?>assets/css/fastselect.css">
	  <!--- Product Page for autocomplete css --->
	  
	  <!-- date range css start -->
	  <link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">		      <!-- date range css end -->
   </head>
   <body <?php if(isset($bodyClass) && !empty($bodyClass)){ echo $bodyClass; }?>>
      <?php $this->load->view('include/layout_top_nav');?>
	  <div class="main-container container-fluid">
		   <?php $this->load->view('include/layout_left_nav');?>
		   <div class="main-content">
		   	    <?php $this->load->view('include/layout_breadcrumb');?>