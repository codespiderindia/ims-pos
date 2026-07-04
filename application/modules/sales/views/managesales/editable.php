   <!DOCTYPE html>
   <html>
   <head>
   	<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="http://code.jquery.com/jquery-2.0.3.min.js"></script> 
    <script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>

        <link href="<?php echo base_url();?>assets/bootstrap3-editable/css/bootstrap-editable.css" rel="stylesheet">
    <script src="<?php echo base_url();?>assets/bootstrap3-editable/js/bootstrap-editable.js"></script>
   </head>
   <body>
    	<table>
    		
    		<tr>
    			<td>
   <a href="#" id="username" data-type="text" data-placement="right" data-title="Enter username">superuser
    			</td>
    		</tr>
    	</table>
    
    </body>
   </html>
    
    
<script type="text/javascript">
    	$.fn.editable.defaults.mode = 'popup';
    	    $(document).ready(function() {
            $('#username').editable({
        type: 'text',
        pk: 1,
        
        title: 'Enter username'
    });
    });
    </script>
   

