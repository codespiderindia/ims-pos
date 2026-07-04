<footer id="footer">
        <div class="inner-wrapper driver_space"></div>
        <div class="inner-wrapper content">
          <div class="row-fluid">
            <div class="span3">
              <h3 >About <span class="font_hotel">Us</span></h3>
              <p>Sequester Software Solution. </p>
              <!--Start List Contact Info-->
              <ul class="unstyled contact_info">
                <li class="location">4 RNT ROAD<br>Indore, India</li>
                <li class="phone">phone:(0731)  4215279<br>fax: +</li>
                <li class="skype"><a href="skype:echo123?call">Skype Me : hemlata.seq</a></li>
              </ul>
              <!--End List Contact Info-->
              <h3 >Stay Connect  <span class="font_hotel"> Socials</span></h3>
              <!--Start List Links Social Network-->
              <div class="link_socials">
                <a href="#"><img src="<?php echo base_url();?>/assets_be/lobster/images/icons/facebook.png" alt="network"/></a>
                <a href="#"><img src="<?php echo base_url();?>/assets_be/lobster/images/icons/twitter.png" alt="network"/></a>
                <a href="#"><img src="<?php echo base_url();?>/assets_be/lobster/images/icons/google-plus.png" alt="network"/></a>
                <a href="#"><img src="<?php echo base_url();?>/assets_be/lobster/images/icons/vimeo.png" alt="network"/></a>
                <a href="#"><img src="<?php echo base_url();?>/assets_be/lobster/images/icons/youtube.png" alt="network"/></a>
              </div>
              <!--End List Links Social Network-->
            </div>
            <div class="span2">
              <h3 >Page  <span class="font_hotel"> Links</span></h3>
              <!--Start List Link pages-->
              <ul class="link_list_footer">
                <li><a href="#">Home</a></li>
                <li><a href="#">Accomodation</a></li>
                <li><a href="#">Restaurant</a></li>
                <li><a href="#">Offering</a></li>
                <li><a href="#">Events</a></li>
                <li><a href="#">Reservation</a></li>
                <li><a href="#">Location</a></li>
                <li><a href="#">Room VIP</a></li>
                <li><a href="#">Room Deluxe</a></li>
                <li><a href="#">Room Standart</a></li>
              </ul>
              <!--End List Link pages-->
            </div>
            <div class="span3">
              <h3 >Latest <span class="font_hotel"> Promotion</span></h3>
              <!--Start List Links Promotion-->
              <ul class="link_list_footer">
                <li><a href="#">Get <strong>30%</strong> promotion <strong>VIP</strong> room just for today</a></li>
                <li><a href="#">Get <strong>30%</strong> promotion <strong>Deluxe </strong> room for a limited time</a></li>
                <li><a href="#">Get <strong>30%</strong> promotion <strong>Economis</strong> room for a limited time</a></li>
                <li><a href="#">Get <strong>30%</strong> promotion <strong>Standart</strong> room for a limited time</a></li>
                
              </ul>
              <!--End List Links Promotion-->
            </div>
            <div class="span4">
              <h3 >Our <span class="font_hotel">Galeries</span></h3>
              <!--Start List Grid Galeries img-->
			  <?php $this->load->view('include/layout_footer_gallery');?>
              <!--End List Grid Galeries img-->
            </div>
          </div>
        </div>
        <!--Start Sucribe Panel-->
        <div class="subcrible">
          <div class="inner-wrapper">
            <div class="row-fluid">
              <div class="span3"><h2> <strong>Subscribe</strong> to get <span class="font_hotel">our latest</span> news</h2></div>
              <div class="span9">
                <!--Start Form Subcribe-->
                <form>
                  <input type="text" name="email" class="input-block-level" placeholder="Enter Your Email"/>
                  <input type="submit" name="send" value="Subcribe" class="btn flat btn-primary btn-large"/>
                </form>
                <!--End Form Subcribe-->
              </div>
            </div>
          </div>
        </div>
        <!--End Sucribe Panel-->
        <!--Start Footer Bottom-->
        <div class="footer_bottom">
          <div class="inner-wrapper">
            <div class="row-fluid ">
              <div class="span3"><p class="font_hotel">Sequester</p></div>
              <div class="span3">
                <!--Start List Flags-->
                <div class="languages">
                  <ul class="unstyled">
                    <li><a href="#"><img  src="<?php echo base_url();?>/assets_be/lobster/images/flag/germen.png" alt="flag"/> Germen</a></li>
                    <li><a href="#"><img  src="<?php echo base_url();?>/assets_be/lobster/images/flag/france.png" alt="flag"/> France</a></li>
                    <li><a href="#"><img  src="<?php echo base_url();?>/assets_be/lobster/images/flag/english.png" alt="flag"/> English</a></li>
                  </ul>
                </div>
                <!--End List Flags-->
              </div>
              <div class="span6 text_right"><p>Copyright &copy; 2013 sequestersol.com/. All Rights Reserved</p></div>
            </div>
          </div>
        </div><!--End Footer Bottom-->
        <!--Start Arrow Back To TOP Page-->
        <div id="back_to_top">
          <a href="#wrapper" class="localScroll btn flat btn-inverse hidden-phone">
            <i class="icon-3x icon-angle-up"></i>
          </a>
        </div><!--End Arrow Back To TOP Page-->
      </footer>