<?php $this->load->view('include/layout_header'); ?>

<?php $uinfo = $this->session->userdata('webadmin_session_info');?>

<div class="page-content">
   <div class="page-header position-relative">
      <h1 class="headingThemeColor"><?php echo $heading;?></h1>
      <?php if($this->session->flashdata('error_msg')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_msg'); ?> <br />
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('success_msg')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_msg'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div class="span12">
               <div class="table-header tableThemeColor"> Results for "Loyalty Points" </div>
               <table id="myTable" class="table table-striped table-bordered table-hover">
                  <thead>
                     <tr>
                        <th class="center">#</th>
                        <th>Category Name</th>
                        <th>Price</th>
                        <th>Loyalty Points</th>
                        <td>Status</td>
                     </tr>
                      </thead>
                     <tbody>
                     <?php if(isset($loyaltypoint) && !empty($loyaltypoint)) {
                        $ctr=1;
                        foreach($loyaltypoint as $loyaltypoints) {
                           $where=['product_cat_id'=>$loyaltypoints['category_id'],'cat_parent_id'=>0];
                           $getCategory=getSku('product_category',$where); ?>
                        <tr>
                           <td><?php echo $ctr; ?></td>
                           <td><?php echo $getCategory[0]['cat_name']; ?></td>
                           <td><?php echo $loyaltypoints['price']; ?></td>
                           <td><?php echo $loyaltypoints['loyalty_point']; ?></td>
                           <td>
                              <label>
                           <input id="product_cat_status_switch_<?php
                              echo $loyaltypoints['id'];
                              ?>" name="product_cat_status_switch_<?php
                                 echo $loyaltypoints['status'];
                              ?>" class="ace-switch  ace-switch-3" type="checkbox" <?php
                              if ($loyaltypoints['status'] == 1) {
                                  echo "checked=checked";
                              }
                              ?> />
                           <span class="lbl"></span> </label>
                           <?php
                              if ($loyaltypoints['status'] == 1) {
                                  echo '<span style=" visibility:hidden">on</span>';
                              }
                              ?>
                           <?php
                              if ($loyaltypoints['status'] == 0) {
                                  echo '<span style=" visibility:hidden">off</span>';
                              }
                              ?>
                           </td>
                        </tr>
                     <?php $ctr++; }
                     } ?>
                  </tbody>
               </table>
            </div>
            <!--/span-->
         </div>
         <!--/row-->
         <!--PAGE CONTENT ENDS-->
      </div>
      <!--/.span-->
   </div>
   <!--/.row-fluid-->
</div>
<!--/.page-content-->
<?php $this->load->view('include/layout_footer');?>
<script>
   $(function(){
      $( ".ace-switch-3" ).change(function() {
            var change_status_to=0;
            if($(this).is(":checked")) {
            change_status_to=1;  
            }
            product_cat_id=$(this).attr('id').split('product_cat_status_switch_');
            var url="<?php echo site_url();?>webadmin/manageloyaltypoint/changePointStatus";
            $.ajax({
            url: url,
            type:'GET',
            data:"cat_status="+change_status_to+"&product_cat_id="+product_cat_id[1],
            success: function(data){;
            }
            });
            
         });

     var oTable1 = $('#myTable').dataTable( {
   
         "aoColumns": [
            { "bSortable": false },
            null, null,null, null,
         ]});

   });
</script>
</body>
</html>