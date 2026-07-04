<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>
<style>
		/* .transfermenu{
			margin-top:50px;
		} */
		.transfermenu ul{
			list-style:none;
			margin-left:0px!important;
			
			
		}
		.transfermenu ul li {
			border: 1px solid #ccc;
			display: none;
			float: left;
			margin-bottom: 20px !important;
			margin-right: 50px;
			padding: 10px;
			width: 240px;
			position:relative;
		}
		.transfermenu ul li ul li{
			margin-left:0px;
			margin-top: 10px;
			display:block;
			border:none;
			padding:0;
		}
		/*.transfermenu ul li:hover ul{
			display:block;
		}*/
		.transfermenu ul li ul li{
			float:none;
		}
		.transfermenu input{
			opacity:1;
		}
		.product_in_warehouse{
			height:25px!important;
			width:15px!important;
		}
		.product_list .checkbox >input{
			opacity:1!important;
		}
		.product_lbl{
			font-weight:bold;
			font-size: 16px;
		}
		.quantity_input{
			width:auto;
		}
		.stock-help-inline{
			position:absolute;
			left:20%;
			color:red;
		}
		.help-inline{
			color:red;
		}
</style>
<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor">
         <?php echo $heading;?>
      </h1>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <form class="form-horizontal" action="" method="post" enctype="multipart/form-data">
           <div class="control-group <?php if(form_error('status') != '') echo 'error'; ?>">
               <label class="control-label" for="status">Status</label>
               <div class="controls">
                  <select name="status" class="status" id="status">
                     <option value="1" <?php if(isset($warehouseToWarehouseReceiveInfo[0]->status) && ($warehouseToWarehouseReceiveInfo[0]->status==1)) echo "selected";?>>Complete</option>
					 <option value="2" <?php if(isset($warehouseToWarehouseReceiveInfo[0]->status) && ($warehouseToWarehouseReceiveInfo[0]->status==2)) echo "selected";?>>Incomplete</option>
                  </select>
                  <span for="warehouse_country" class="help-inline"> <?php echo form_error('warehouse_country') ?> </span>
               </div>
            </div>
            <div class="control-group <?php if(form_error('comments') != '') echo 'error'; ?>">
               <label class="control-label" for="comments">Comments</label>
               <div class="controls">
                  <textarea id="comments" name="comments"><?php if(isset($warehouseToWarehouseReceiveInfo[0]->comments) && !empty($warehouseToWarehouseReceiveInfo[0]->comments)) echo $warehouseToWarehouseReceiveInfo[0]->comments; ?></textarea>
                  <span for="comments" class="help-inline"> <?php echo form_error('comments') ?> </span>
               </div>
            </div>
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor transfer" type="submit">
               <i class="icon-ok bigger-110"></i>
               Receive 
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