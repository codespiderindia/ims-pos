<?php $this->load->view('include/layout_header'); ?>
<div class="page-content">
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="page-header position-relative">
            <h1 class="headingThemeColor">
               Edit Invoice Setting
               <small>
               <i class="icon-double-angle-right"></i>
               Edit Invoice Setting &amp;Update
               </small>
            </h1>
         </div>
         <!--/.page-header-->
         <form id="editproperty"  method="post" action="<?php echo base_url();?>webadmin/profilesetting/editInvoiceSetting" enctype="multipart/form-data"/>
            <table id="sample-table-1" class="table table-striped table-bordered table-hover">
              
               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('firm_name') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                        Invoice Header
                        </label>
                     </div>
                  </td>
                  <td class="hidden-480">
                     <div class="control-group
                        <?php if(form_error('firm_name') != '')echo 'error'; ?>">
                        <div class="controls">
                           <input type="text" name="invoice_header" class="invoice-header" value="<?php if(isset($invoiceDetails) && !empty($invoiceDetails)) { 
                                 echo $invoiceDetails->invoice_header;
                           } ?>">
                           <!--<input type="text" id="firm_name" 
                              name="firm_name" 
                              value="<?php if(isset($userInfo->firm_name) && 
                                 !empty($userInfo->firm_name)) 
                                  {echo $userInfo->firm_name;}?>"/>-->
                           <span for="invoice_header" class="help-inline"> 
                           <?php echo form_error('invoice_header') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>
               
               <tr>
                  <td class="span3">
                     <div class="control-group 
                        <?php if(form_error('firm_address') != '')echo 'error'; ?>">
                        <label class="control-label" for="form-field-1">
                        Invoice Footer(Comma separated conditions)
                        </label>
                     </div>
                  </td>
                  <td class="hidden-480">
                     <div class="control-group
                        <?php if(form_error('firm_address') != '')echo 'error'; ?>">
                        <div class="controls">
                           <textarea name="invoice_footer" class="invoice-footer" row="10" cols="20"><?php if(isset($invoiceDetails) && !empty($invoiceDetails)) { 
                                 echo $invoiceDetails->invoice_footer;
                           } ?></textarea>
                           <!--<input type="text" id="firm_address" 
                              name="firm_address"  value="<?php 
                                 if(isset($userInfo->firm_address) && !empty($userInfo->firm_address))
                                 {echo $userInfo->firm_address;}?>"/>-->
                           <span for="invoice_footer" class="help-inline"> 
                           <?php echo form_error('invoice_footer') ?> 
                           </span>
                        </div>
                        <!--controls-->
                     </div>
                     <!--control-group-->
                  </td>
               </tr>
            </table>
            <!--<div class="modal-footer">
               <button class="btn btn-info" id="bootbox" name="btn_updateroomtype">Update</button>
            </div>-->
            <div class="form-actions">
               <button class="btn btn-info buttonThemeColor" type="submit" id="bootbox" name="btn_updateroomtype">
               <i class="icon-ok bigger-110"></i>
               <?php
                  if(isset($invoiceDetails) && !empty($invoiceDetails)) { 
                     echo "Update";
                  }else{
                     echo "Submit";
                  }
               ?>
               
               </button>
               &nbsp; &nbsp; &nbsp;
               <!--<button class="btn" type="reset">
                  <i class="icon-undo bigger-110"></i>
                  Reset
                  </button>-->
            </div>
			
			
            <!--</div>-->
         </form>
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<style type="text/css">
   .help-inline {
      color: red;
   }
   .invoice-footer {
      height: 80px;
   }
</style>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
</body>
</html>