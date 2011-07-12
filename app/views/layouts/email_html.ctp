<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
	<title>theProfile</title>
	<link rel="stylesheet" type="text/css" href="<?php echo PROFILE_ROOT; ?>/css/global.css" />
	<?php echo $scripts_for_layout ?>
</head>
<body>
	<div id="main">
	<div id="header">    
	</div>
	<div id="content" >
		<?php echo $content_for_layout ?>
		<?php echo $session->flash(); ?>
		<div class="clear">&nbsp;</div> 
	</div>
	</div>
</body>
</html>