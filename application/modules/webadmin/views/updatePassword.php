<?php $this->load->view('include/layout_header'); ?>
<div class="page-content">
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->	
         <div class="page-header position-relative">
            <h1 class="headingThemeColor">
               change Password
               <small>
               <i class="icon-double-angle-right"></i>
               change Password
               </small>
            </h1>
            <?php if($this->session->flashdata('error_msg')): ?>
            <div class="alert alert-error">
               <button type="button" class="close" data-dismiss="alert">
               <i class="icon-remove"></i>
               </button>
               <strong>
               <i class="icon-remove"></i>
               Error!										
               </strong>
               <?php echo $this->session->flashdata('error_msg'); ?>
               <br />
            </div>
            <?php endif; ?>
            <?php if($this->session->flashdata('success_msg')): ?>
            <div class="alert alert-block alert-success ">
               <button type="button" class="close" data-dismiss="alert">
               <i class="icon-remove"></i>							
               </button>
               <p>
                  <strong>
                  <i class="icon-ok"></i>
                  Done!											
                  </strong>
                  <?php echo $this->session->flashdata('success_msg'); ?>
               </p>
            </div>
            <?php endif; ?>
         </div>
         <!--/.page-header-->
         <form id="Changpassword" action="<?php echo base_url();?>webadmin/profilesetting/change_password" method="post"/>
            <div>
               <table id="sample-table-1" style="width:65%;" class="table table-striped table-bordered table-hover">
                  <tr>
                     <td class="hidden-480 span3">
                        <div class="control-group 
                           <?php if(form_error('password') != '')
                              echo 'error'; ?>">
                           <label class="control-label" for="form-field-1">                                        Current Password</label>
                        </div>
                     </td>
                     <td class="hidden-480 " >
                        <div class="control-group 
                           <?php if(form_error('password') != '') 
                              echo 'error'; ?>">
                           <div class="controls">
                              <input type="password" name="password" id="password"  value="<?php echo set_value('password') ?>"    />
                              <span for="name" class="help-inline"> 
                              <?php echo form_error('password') ?> 
                              </span>
                           </div>
                           <!--controls-->
                        </div>
                        <!--control-group-->
                     </td>
                  </tr>
                  <tr>
                     <td class="hidden-480 span3">
                        <div class="control-group 
                           <?php if(form_error('npassword') != '')
                              echo 'error'; ?>">
                           <label class="control-label" for="form-field-1">                                        New Password</label>
                        </div>
                     </td>
                     <td class="hidden-480 " >
                        <div class="control-group 
                           <?php if(form_error('npassword') != '') 
                              echo 'error'; ?>">
                           <div class="controls">
                              <input type="password" name="npassword" id="npassword"  value="<?php echo set_value('npassword') ?>"    />
                              <span for="name" class="help-inline"> 
                              <?php echo form_error('npassword') ?> 
                              </span>
                           </div>
                           <!--controls-->
                        </div>
                        <!--control-group-->
                     </td>
                  </tr>
                  <tr>
                     <td>
                        <div class="control-group 
                           <?php if(form_error('cpassword') != '')
                              echo 'error'; ?>">
                           <label class="control-label" for="form-field-1">                                         Confirm Password</label>
                        </div>
                     </td>
                     <td class="hidden-480">
                        <div class="control-group 
                           <?php if(form_error('cpassword') != '') 
                              echo 'error'; ?>">
                           <div class="controls">
                              <input type="password" name="cpassword" id="npassword"  value="<?php echo set_value('cpassword') ?>">  
                              <span for="name" class="help-inline"> 
                              <?php echo form_error('cpassword') ?> 
                              </span>
                           </div>
                           <!--controls-->
                        </div>
                        <!--control-group-->
                     </td>
                  </tr>
               </table>
            </div>
            <!--<div class="modal-footer">
               <button type="submit"  id="btn_updatepass" name="btn_updatepass" class="btn btn-info">Update</button>
            </div>-->
			
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit" id="btn_updatepass" name="btn_updatepass" >
               <i class="icon-ok bigger-110"></i>
               Update
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
			
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
</body>
</html>