<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Untitled Document</title>
<style>
.wrapper{
	width:700px;
	margin:50px auto;
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px;
}
p{
	margin:3px;
}
</style>
</head>
<body>	
		<div class="wrapper">
		<div style="text-align:right; font-size:14px;"><?php echo date('d/m/Y'); ?></div>		
		<div style="text-align:center; font-weight:bold"><?php echo $titlename; ?></div>
		
		<div>
			<?php echo $filterinfo; ?>
		</div>
		
		<div style="text-align:left; font-size:14px; margin-top:15px;">Cash Book Full Ledger</div>
	</div><!--wrapper-->
</body>
</html>
