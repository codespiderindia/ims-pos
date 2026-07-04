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
      <?php if($this->session->flashdata('success_mail')): ?>
      <div class="alert alert-block alert-success ">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-ok"></i> Done! </strong> <?php echo $this->session->flashdata('success_mail'); ?> </p>
      </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('error_mail')): ?>
      <div class="alert alert-error">
         <button type="button" class="close" data-dismiss="alert"> <i class="icon-remove"></i> </button>
         <p> <strong> <i class="icon-remove"></i> Error! </strong> <?php echo $this->session->flashdata('error_mail'); ?> </p>
      </div>
      <?php endif; ?>
   </div>
   <!--/.page-header-->
   <div class="row-fluid">
      <div class="span12">
         <!--PAGE CONTENT BEGINS-->
         <div class="row-fluid">
            <div  class="span12">
              <div> <lable>Select Dealer</lable>  <select name="dealer" id="dealer"><option value="">Select</option>
			  <?php if(!empty($dealers)) { foreach($dealers as $dealers) { ?>
			  <option value="<?php  echo $dealers->dealer_id; ?>"><?php echo ucfirst($dealers->f_name)." ".ucfirst($dealers->l_name);?> </option>
			  <?php } } ?>
			  </select> </div>
            </div>
			<div id="result"></div>
			
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
<script src="<?php echo base_url();?>/assets/js/jquery-ui.min.js"></script>
<script>
   $(function(){
   		$(".delBtn").on(ace.click_event, function() {
   			var del_loc=this.href;
   			bootbox.confirm("Are you sure you want to delete this record?", function(result) {
   				if(result) {
   					window.location.href=del_loc;
   					//bootbox.alert("You are sure!");
   				}
   			});
   			
   			return false;
   		});
   		$( ".ace-switch-3" ).change(function() {
   			var change_status_to=0;
   			if($(this).is(":checked")) {
   			change_status_to=1;	
   			}
   			dealer_id=$(this).attr('id').split('dealer_status_switch_');
   			var url="<?php echo site_url();?>webadmin/managedealer/changeDealerStatus";
   			$.ajax({
   			url: url,
   			type:'GET',
   			data:"dealer_status="+change_status_to+"&dealer_id="+dealer_id[1],
   			success: function(data){
   			
   				//alert(data);
   			}
   			});
   		
   		});
		
			$( "#dealer" ).change(function() {
   			
   			dealer_id=$(this).val();
   			var url="<?php echo site_url();?>webadmin/managedealer/dealerReportGetInvoice";
   			//alert(dealer_id);
			$.ajax({
   			url: url,
   			type:'GET',
   			data:"dealer_id="+dealer_id,
   			success: function(data){
   			
   				$('#result').html(data);
   			}
   			});
   		});
		
		
		
   	<!--jQuery Table//Start-->
   
   		var oTable1 = $('#myTable').dataTable( {
   
   		"aoColumns": [
   
   	      { "bSortable": false },
   
   	      null, null,null, null, null,null, null,null, null,null,null,null, null,null,
   
   
   		  
   
   		] } );
   
   		
   
   		
   
   		$('table th input:checkbox').on('click' , function(){
   
   			var that = this;
   
   			$(this).closest('table').find('tr > td:first-child input:checkbox')
   
   			.each(function(){
   
   				this.checked = that.checked;
   
   				$(this).closest('tr').toggleClass('selected');
   
   			});
   
   				
   
   		});
   
   		
   
   		$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
   
   		function tooltip_placement(context, source) {
   
   			var $source = $(source);
   
   			var $parent = $source.closest('table')
   
   			var off1 = $parent.offset();
   
   			var w1 = $parent.width();
   
   	
   
   			var off2 = $source.offset();
   
   			var w2 = $source.width();
   
   	
   
   			if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
   
   			return 'left';
   
   		}
   
   	<!--jQuery Table//End-->
   
   });
</script>
<script>
$(document).ready(function(){
$( ".dealer_bank_link").click(function(){
dealer_id=$(this).attr('id').split('id-btn-dialog_');
			
					var dialog = $( "#dialog-message_"+dealer_id[1] ).removeClass('hide').dialog({
						modal: true,
						title: "Bank Details",
						title_html: true,
						buttons: [ 
							{
								text: "Cancel",
								"class" : "btn btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							},
							{
								text: "OK",
								"class" : "btn btn-primary btn-minier",
								click: function() {
									$( this ).dialog( "close" ); 
								} 
							}
						]
					});
			
				});
	
});
</script>

</body>
</html>