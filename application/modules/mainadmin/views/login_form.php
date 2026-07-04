<!DOCTYPE html>
<html lang="en">
   <head>
      <?php $this->load->view('include/layout_meta')?>
   </head>
   <body class="login-layout">
      <div class="main-container container-fluid">
         <div class="main-content">
            <div class="row-fluid">
               <div class="span12">
                  <div class="login-container">
                     <div class="row-fluid">
                        <div class="center">
                           <h1>
                              <i class="icon-leaf green"></i>
                              <span class="red">Mainadmin</span>
                              <span class="white">Login</span>									
                           </h1>
                           <!--<h4 class="blue">&copy; Company Name</h4>-->
                        </div>
                     </div>
                     <div class="space-6"></div>
                     <div class="row-fluid">
                        <div class="position-relative">
                           <div id="login-box" class="login-box visible widget-box no-border">
                              <div class="widget-body">
                                 <div class="widget-main">
                                    <h4 class="header blue lighter bigger">
                                       <i class="icon-coffee green"></i>
                                       <?php
                                          if(isset($msg) && !empty($msg)){echo $msg;}else{
                                          ?>
                                       Please Enter Your Information
                                       <?php
                                          }
                                                ?>											
                                    </h4>
                                    <div class="space-6">	</div>
                                    <form name="login_form" id="login_form" method="post" action="<?php echo site_url();?>mainadmin/login" />
                                       <fieldset>
                                          <label>
                                          <span class="block input-icon input-icon-right">
                                          <input type="text" class="span12" placeholder="Username" id="username" name="username" />
                                          <i class="icon-user"></i>															</span>														</label>
                                          <label>
                                          <span class="block input-icon input-icon-right">
                                          <input type="password" class="span12" placeholder="Password" id="password" name="password" />
                                          <i class="icon-lock"></i>															</span>														</label>
                                          <div class="space"></div>
                                          <div class="clearfix">
                                             <label class="inline">
                                             <input type="checkbox" />
                                             <span class="lbl"> Remember Me</span>															</label>
                                             <button  class="width-35 pull-right btn btn-small btn-primary">
                                             <i class="icon-key"></i>
                                             Login															</button>
                                          </div>
                                          <div class="space-4"></div>
                                       </fieldset>
                                    </form>
                                    
                                 </div>
                                 <!--/widget-main-->
                                 <div class="toolbar clearfix">
                                    <div>
                                       <a href="javascript:void(0);" onClick="show_box('forgot-box'); return false;" class="forgot-password-link">
                                       <i class="icon-arrow-left"></i>
                                       I forgot my password													</a>												
                                    </div>
                                 </div>
                              </div>
                              <!--/widget-body-->
                           </div>
                           <!--/login-box-->
                           <div id="forgot-box" class="forgot-box widget-box no-border">
                              <div class="widget-body">
                                 <div class="widget-main">
                                    <h4 class="header red lighter bigger">
                                       <i class="icon-key"></i>
                                       Retrieve Password												
                                    </h4>
                                    <div class="space-6"></div>
                                    <form  action="<?php echo site_url();?>dealer/login/forgotpassword" name="forgetpassword_frm" id="forgetpassword_frm" enctype="multipart/form-data">
                                       <fieldset>
                                          <div id="showmsg">
                                             <label>
                                             <span class="block input-icon input-icon-right">
                                             <input type="email" name="email" id="email" class="span12" placeholder="Email" />
                                             <i class="icon-envelope"></i></span>														           </label>
                                             <div class= "clearfix">
                                                <button type="submit" name="btn_send" id="btn_send" class="width-35 pull-right btn btn-small btn-danger">
                                                <i class="icon-lightbulb"></i>
                                                Send Me!															</button>
                                             </div>
                                          </div>
                                       </fieldset>
                                    </form>
                                 </div>
                                 <!--/widget-main-->
                                 <div class="toolbar center">
                                    <a href="#" onClick="show_box('login-box'); return false;" class="back-to-login-link">
                                    Back to Login
                                    <i class="icon-arrow-right"></i>												</a>											
                                 </div>
                              </div>
                              <!--/widget-body-->
                           </div>
                           <!--/forgot-box-->
                           <!--/signup-box-->
                        </div>
                        <!--/position-relative-->
                     </div>
                  </div>
               </div>
               <!--/.span-->
            </div>
            <!--/.row-fluid-->
         </div>
      </div>
      <!--/.main-container-->
      <!--basic scripts-->
      <!--[if !IE]>-->
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
      <!--<![endif]-->
      <!--[if IE]>
      <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
      <![endif]-->
      <!--[if !IE]>-->
      <script type="text/javascript">
         window.jQuery || document.write("<script src='assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
      </script>
      <!--<![endif]-->
      <!--[if IE]>
      <script type="text/javascript">
         window.jQuery || document.write("<script src='assets/js/jquery-1.10.2.min.js'>"+"<"+"/script>");
      </script>
      <![endif]-->
      <script type="text/javascript">
         if("ontouchend" in document) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
      </script>
      <script src="assets/js/bootstrap.min.js"></script>
      <!--page specific plugin scripts-->
      <script src="<?php echo base_url();?>assets/js/jquery-ui-1.10.3.custom.min.js"></script>
      <script src="http://code.jquery.com/jquery-1.7.min.js"></script>
      <script src="<?php echo base_url();?>assets/js/jquery.form.min.js"></script>
      <!--ace scripts-->
      <script src="assets/js/ace-elements.min.js"></script>
      <script src="assets/js/ace.min.js"></script>
      <!--inline scripts related to this page-->
      <script type="text/javascript">
         function show_box(id) {
          $('.widget-box.visible').removeClass('visible');
          $('#'+id).addClass('visible');
         }
         
         $(document).ready(function(){
         
         $("#btn_send").click(function(){
         // alert('hi');
         $("#forgetpassword_frm").ajaxForm({success: showResponse});  
           });
         
         function showResponse(responseText,statusText, xhr, $form){
         if(responseText.indexOf("Error##")==0){
         alert("Error");
         }else{
              $("#showmsg").html(responseText);
             }
         }
         
         });
      </script>
   </body>
</html>