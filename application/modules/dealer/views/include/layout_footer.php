		<?php $this->load->view('include/layout_ace_ctrl');?>
		<!--/#ace-settings-container-->
	</div><!--/.main-content-->
</div><!--/.main-container-->

<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-small btn-inverse"> <i class="icon-double-angle-up icon-only bigger-110"></i> </a>
<!--basic scripts-->
<!--[if !IE]>-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
<!--<![endif]-->
<!--[if IE]>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<![endif]-->
<!--[if !IE]>-->
<script type="text/javascript">
   window.jQuery || document.write("<script src='<?php echo base_url();?>/assets/js/jquery-2.0.3.min.js'>"+"<"+"/script>");
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
<script src="<?php echo base_url();?>/assets/js/bootstrap.min.js"></script>
<!--page specific plugin scripts-->
<!--[if lte IE 8]>
<script src="assets/js/excanvas.min.js"></script>
<![endif]-->
<script src="<?php echo base_url();?>/assets/js/jquery-ui-1.10.3.custom.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/bootbox.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.easy-pie-chart.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.gritter.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/spin.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/jquery.dataTables.bootstrap.js"></script>
<!--ace scripts-->
<script src="<?php echo base_url();?>/assets/js/ace-elements.min.js"></script>
<script src="<?php echo base_url();?>/assets/js/ace.min.js"></script>
<!--inline scripts related to this page-->

<!-- Theme Color Change Start-->
<script type="text/javascript">
//var cp = $.noConflict();
$(document).ready(function(){
	$('#skin-colorpicker').on('change',function(){
		//if(confirm("Are You Sure to change theme color?") == true){
		//	return true;
		//}else{
		//	return false;
		//}
		var colorCode = $(this).val();
		var lightColor = $('option:selected', this).attr('light-color');
		var themeName = $('option:selected', this).attr('mytag');
		
		$(".headingThemeColor").attr('style', 'color:'+colorCode+'!important;'); 
		$(".tableThemeColor").attr('style', 'background-color:'+colorCode+';'); 
		$(".buttonThemeColor").attr('style', 'background-color:'+colorCode+'!important;border-color:'+colorCode+';');
		$(".welcomeThemeColor").attr('style', 'background:'+lightColor+'!important;'); 
		
		$(".pagination ul > li.active > a, .pagination ul > li.active > a:hover").attr('style', 'background-color:'+colorCode+';border-color:'+colorCode+';');
		 
		$.ajax({
			type:'POST',
			url:"<?php echo site_url();?>webadmin/managetheme/changeThemeColor",
			data:'colorCode='+colorCode+'&lightColor='+lightColor+'&themeName='+themeName,
			success:function(html){
				//$('#state').html(html);
				//$('#city').html('<option value="">Select state first</option>'); 
			}
		}); 
	});
});
</script>
<!-- Theme Color Change End -->