<section id="top_header">
        <div class="inner-wrapper text_center">
          <!--Start Main Navigation-->
          <div class="togle_menu_mobile"><a class="btn btn-primary flat" data-toggle="collapse" data-target=".main_navbar"> <i class="icon-th-list icon-2x"></i> </a> <strong>&nbsp;&nbsp;Lobster </strong> Hotel</div>
          <nav class="main_navbar collapse">
            <ul class="unstyled">
              <li><a href="<?php echo base_url()?>booking/booking">Home</a></li>
              <li><a href="<?php echo base_url()?>booking/accomodation/accomodationdetail/?p=100">Accomodation</a></li>
			   <li><a href="about.html">About Us</a></li>
			   <?php if ($this->session->userdata('client_session_info')): ?>
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">My Account <b class="caret"></b></a>
					<ul class="dropdown-menu">
						<li><a href="">Profile</a></li>
						<li><a href="">Bookings</a></li>
						<li><a href="">Logout</a></li>
					</ul>
				</li>
			   <?php endif; ?>
			   
              <!--<li><a href="offering.html">Offering</a></li>
              <li><a href="events.html">Events</a></li>
              <li><a href="reservation.html">Reservations</a></li>
             
              <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Member <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="login.html">Login</a></li>
                  <li><a href="singup.html">SignUp</a></li>
                </ul>
              </li>
              <li class="dropdown active">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
                <ul class="dropdown-menu">
                  <li><a href="index_simple.html">Home Simple</a></li>
                  <li><a href="blog.html">Blog</a></li>
                  <li><a href="blog_detail.html">Blog Detail</a></li>
                  <li><a href="galeries.html">Galeries</a></li>
                  <li><a href="blank.html">Blank page</a></li>
                  <li><a href="<?php //echo base_url();?>/assets_be/documentation/index.html">Documentation</a></li>
                </ul>
              </li>
            </ul>
          </nav>
         <!--ENd Main Navigation-->
        </div>
      </section>