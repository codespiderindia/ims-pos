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
            <div class="control-group <?php if(form_error('warehouse') != '') echo 'error'; ?>">
               <label class="control-label" for="store">Select Warehouse</label>
               <div class="controls">
                  <select name="warehouse" class="warehouse" id="warehouse">
                     <option value="">Select Warehouse</option>
                     <?php 
                        $warehouse_details = warehouse_details($uinfo['comp_code']);
                        foreach($warehouse_details as $warehouse){  
                        ?>
                     <option value="<?php echo $warehouse['warehouse_id'];?>"><?php echo $warehouse['warehouse_name'];?></option>
                     <?php
                        }
                        ?>
                  </select>
                  <span for="warehouse" class="help-inline"> <?php echo form_error('warehouse') ?> </span>
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
