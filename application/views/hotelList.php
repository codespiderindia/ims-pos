<!DOCTYPE html>
<html>
  <head>
    <title>CHMS - Booking Engine</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="keywords" content="bootstrap, Templatte bootstrap, Template bootstrap hotel, bootstrap hotel , wrapbootstrap, yobio"/>
    <meta name="description" content="HTML Responsive, Best HTML template for your hotel website"/>
    <meta name="author" content="yobio studio"/>
	
	
    <link rel="shortcut icon" href="<?php echo base_url();?>/assets_be/lobster/images/faicon.png"/>
    <!-- styles Bootsrap -->
    <link href="<?php echo base_url();?>/assets_be/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>/assets_be/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <!-- end styles Bootsrap -->

    <!-- FONTAWESOME STYLE -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets_be/lobster/css/font/FortAwesome/css/font-awesome.css"/>
    <!--[if IE 7]>
    <link rel="stylesheet" href="lobster/css/font/FortAwesome/css/font-awesome-ie7.min.css">
    <![endif]-->
    <!--[if lt IE 9]>
    <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
	
	<!--css for datepicker-->
	
	
    <!-- Style Lightbox -->
    <link rel="stylesheet" href="<?php echo base_url();?>/assets_be/lobster/css/light_box/magnific-popup.css"/>
    <!-- End Style Lightbox -->

    <!-- Style Full Calendar-->
    <link href="<?php echo base_url();?>/assets_be/lobster/css/fullcalendar/fullcalendar.css" rel="stylesheet" />
    <!-- Style Datatatbles-->
    <link href="<?php echo base_url();?>/assets_be/lobster/css/datatables/css/jquery.dataTables.css" rel="stylesheet" />

    <!-- styles Lobster Theme -->
    <link href="<?php echo base_url();?>/assets_be/lobster/css/style.css" rel="stylesheet" />
    <link href="<?php echo base_url();?>/assets_be/lobster/css/color_theme.css" rel="stylesheet" />
    <!-- place for your custom styles -->
    <link href="<?php echo base_url();?>/assets_be/lobster/css/mystyle.css" rel="stylesheet" />
    <!-- End Lobster Theme -->
	
	
	<!--css for datepicor of admin-->
			<!--basic styles-->
		<!--page specific plugin styles-->
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/jquery-ui-1.10.3.custom.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/datepicker.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/daterangepicker.css" />
		
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ui-lightness/jquery-ui-1.9.2.custom.css" />


		
		<!--fonts-->
		<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Open+Sans:400,300" />
		<!--ace styles-->
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-responsive.min.css" />
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-skins.min.css" />
		
		<!--[if lte IE 8]>
		<link rel="stylesheet" href="<?php echo base_url();?>/assets/css/ace-ie.min.css" />
		<![endif]-->
		
		<!--inline styles related to this page-->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
	select{
	height:auto !important;
	}
	</style>
  </head>
  <body class="theme_default">
    <div id="wrapper">
     <?php $this->load->view('include/layout_top_nav');?>
	  <!--Start main Title content-->
	   <section id="content_top">
        <div class="bg_content_top general_bg">
          <div class="inner-wrapper text_center">
           <h1 class="no_margin main_title">Hotel<small>Available Hotel</small></h1>
          </div>
        </div>
      </section>
      <!--end main Title content-->
      <!-- Start section logo message area -->
	  <?php $this->load->view('include/layout_top_logo');?>
      <!-- End section logo message area -->
      
	  <!-- Start section content page -->
     
	  <section id="content">
        <div class="inner-wrapper">
          <div class="row-fluid">
            <div class="span12">
			 <h2 class="text_center">CHMS Hotel</h2>
			  <div class="gridmasonry grid_list_event">
			  <?php foreach ($hotel as $hoteldetail){?>
			    <div class="item_grid item3">
                  <div class="panel">
                    <h4 class="recent-post-header">
                     <p class="text_center"><a href="<?php echo base_url()?>booking/?p=<?php echo $hoteldetail->hotel_ID?>"><?php echo $hoteldetail->hotel_name?></a></p> 
                    </h4>
                   <img  src="<?php echo base_url()?>uploads/<?php echo $hoteldetail->image_name?>" style="height:150px;width:313px;" alt="150x150">
                    <p><?php echo $hoteldetail->hotel_address?>,&nbsp;&nbsp;<?php echo $hoteldetail->hotel_city?>,&nbsp;&nbsp;<?php echo $hoteldetail->hotel_state?></p>
                    <p><a href="<?php echo base_url()?>booking/?p=<?php echo $hoteldetail->hotel_ID?>" class="btn btn-primary flat"> Book Now <i class="icon-angle-right"></i></a></p>
                  </div>
                </div>
				<?php }?>   
			  </div>
			  
            </div>
          </div>
        <div class="divater"><div class="line"></div><span><img src="<?php echo base_url();?>/assets_be/lobster/images/deviter.png" alt=""></span></div>
		
		
		</div>
      </section>
	  
	  <!-- End section content page -->

      <!--Start Footer Section-->
	   <?php $this->load->view('include/layout_footer');?>
      <!--End Footer Section-->

      <!-- Start Control Color Theme -->
	   <?php //$this->load->view('include/layout_color_ctrl');?>
      <!-- End Control Color Theme -->
    </div>

  
   <!--=========================================================================-->
    <!--Load JS JQUERY-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery-1.9.1.min.js"></script>
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery-ui-1.10.2.custom.min.js"></script>

    <!--Load JS Bootstrap-->
    <script src="<?php echo base_url();?>/assets_be/bootstrap/js/bootstrap.min.js"></script>
    <!--=========================================================================-->
    <!--Load JS plugins-->
    <!--=========================================================================-->
    <!--End JS Grid masonry-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/masonry.pkgd.min.js"></script>
    <!--End JS Grid slider sequence-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.sequence-min.js"></script>

    <!--Load JS scrool smoothest-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.scrollTo-1.4.3.1-min.js"></script>
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.localScroll.min.js"></script>
    <!--End JS scrool smoothest-->

    <!--Load JS Datatables plugin-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.dataTables.min.js"></script>
    <!--Load JS fullcalendar plugin-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/fullcalendar.min.js"></script>
    <!--Load JS magnific lightbox plugin-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.magnific-popup.min.js"></script>
    <!--Load JS lazy load image unveil-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.unveil.min.js"></script>
    <!--Load JS jquery validation -->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.validate.min.js"></script>

    <!--Load JS jquery shintact remove it if unnecessary-->
    <link href="<?php echo base_url();?>/assets_be/documentation/assets/shi_default.min.css" rel="stylesheet" />
    <script src="<?php echo base_url();?>/assets_be/documentation/assets/shi_jquery.min.js"></script>
    <!-- end Load JS plugins-->

    <!--load js cookie #[optional]-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/jquery.cookie.js"></script>
    <!--end load js cookie-->

    <!--Load JS config application-->
    <script src="<?php echo base_url();?>/assets_be/lobster/js/app.js"></script>

		<script src="<?php echo base_url();?>/assets/js/cal/jquery-ui-1.9.2.custom.js"></script>

   



	<script>
	//$j=$.noConflict();
	$(document).ready(function() {
	
	<!--Date Picker Start-->
	 $("#arrivalDt").datepicker({
        minDate: 0,
        maxDate: "+730D",
        numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
        var date = $(this).datepicker('getDate');
        if(date){
            date.setDate(date.getDate() + 1);
        }
		
          $("#departureDt").datepicker("option","minDate", date);
		  $("#departureDt").datepicker("setDate", date);
		  
		  
        }
    });
	$("#departureDt").datepicker({ 
        minDate: 0,
        maxDate:"+730D",
        numberOfMonths: 2,
		dateFormat:"yy-mm-dd",
        onSelect: function(selected) {
           $("#arrivalDt").datepicker("option","maxDate", selected)
        }
    });
	
	//$("#arrivalDt").datepicker();
	$("#datepickerImage").click(function() { 
		$("#arrivalDt").datepicker("show");
	});
	
	//$("#departureDt").datepicker();
	$("#datepickerImage1").click(function() { 
		$("#departureDt").datepicker("show");
	});    
	<!--Date Picker End-->
 });
		
</script>
<!--Script ends here-->

  </body>
</html>
