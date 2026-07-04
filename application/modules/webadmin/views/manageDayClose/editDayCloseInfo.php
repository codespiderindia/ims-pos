<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
.height-padding {
   padding-left: 10px;
   line-height: 2;
}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         Edit User
         <!--<small>
            <i class="icon-double-angle-right"></i>
            Common form elements and layouts
            </small>-->
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <?php $where=['id'=>$id];
         $getInfo = getSku('day_close',$where); 
         $userId = $getInfo[0]['user_id']; ?>
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post">

            <div class="control-group">
               <label class="control-label">User Name: </label>
               <span class="height-padding"><?php echo get_user_name_by_user_ID($userId); ?></span>
            </div>

            <div class="control-group">
               <label class="control-label">Cash Payment: </label>
               <span class="height-padding"><?php echo $getInfo[0]['cash']; ?></span>
            </div>


            <div class="control-group <?php if(form_error('total_cash_payment') != '') echo 'error'; ?>">
               <label class="control-label" for="total_cash_payment">Total Cash Payment</label>
               <div class="controls">
                  <input type="text" id="total_cash_payment" name="total_cash_payment" value="" />
               </div>
            </div>


            <div class="control-group <?php if(form_error('shot') != '') echo 'error'; ?>">
               <label class="control-label" for="shot">Shot</label>
               <div class="controls">
                  <input type="text" id="shot" name="shot" value="" />
               </div>
            </div>

            
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit">
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
<!--multiselect scripts related to this page-->
<link href="<?php echo base_url();?>/assets/css/bootstrap-multiselect.css"
   rel="stylesheet" type="text/css" />
<script src="<?php echo base_url();?>/assets/js/bootstrap-multiselect.js"
   type="text/javascript"></script>
<script type="text/javascript">
   $('#department').multiselect({
   		includeSelectAllOption: true
   	});
</script>
<!--multiselect scripts related to this page-->
</body>
</html>