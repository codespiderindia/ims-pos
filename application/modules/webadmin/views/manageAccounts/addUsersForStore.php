<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading; ?>
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" >
            <div class="control-group <?php if(form_error('store') != '') echo 'error'; ?>">
               <label class="control-label" for="store">Select Store</label>
               <div class="controls">
                  <select name="store" class="store" id="store">
                     <option value="">Select Store</option>
                     <?php 
                        $store_details = store_details($uinfo['comp_code']);
                        foreach($store_details as $store){  
                        ?>
                     <option value="<?php echo $store['store_id'];?>"><?php echo $store['store_name'];?></option>
                     <?php
                        }
                        ?>
                  </select>
                  <span for="store" class="help-inline"> <?php echo form_error('store') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
               <i class="icon-ok bigger-110"></i>
               Submit
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
