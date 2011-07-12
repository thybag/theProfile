<?php

$server = $_SERVER["SERVER_NAME"];

$currentFile = $server.$_SERVER['REQUEST_URI'];
if (strpos($currentFile, "?") !== false) $currentFile = reset(explode("?", $currentFile));

$username ='';
if(isset($this->params['name'])){
	$username = $this->params['name'];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>

	<title>theProfile - <?php echo $title_for_layout?></title>
	<meta name="description" content="theProfile Website" /> 
	<meta name="keywords" content="theProfile, the Profile, Profile Management, Identity Management, OpenID, OpenID Provider, OAuth, University of Kent, Kent, final year project" /> 
	<meta name="author" content="Michael Pontin, Carl Saggs, David Couch and Jared Bissenden" /> 
	<meta http-equiv="Content-Type" content="text/html;charset=windows-1252" />	
	<link rel="shortcut icon" href="<?php echo PROFILE_ROOT; ?>/img/favicon.ico" type="image/x-icon" />
	<link rel="stylesheet" type="text/css" href="<?php echo PROFILE_ROOT; ?>/css/global.css" />
	<style type="text/css"> 
			@import "<?php echo PROFILE_ROOT; ?>/js/dojo-1.5.0/dijit/themes/tundra/tundra.css";
			@import "<?php echo PROFILE_ROOT; ?>/js/dojo-1.5.0/dojo/resources/dojo.css";
	</style> 
	
	<script type="text/javascript" src="<?php echo PROFILE_ROOT; ?>/js/dojo-1.5.0/dojo/dojo.js" djConfig="parseOnLoad: true"></script> 
	<script type="text/javascript" src="<?php echo PROFILE_ROOT; ?>/js/dojo-1.5.0/dojo_magic.js"></script> 
    <script type="text/javascript" src="<?php echo PROFILE_ROOT; ?>/js/theprofile_functions.js" ></script> 
    <script type="text/javascript"> 
    	//ensure modules all importered.
	    dojo.require("dijit.form.Button");
		dojo.require("dijit.form.Form");
		dojo.require("dijit.form.TextBox");
		dojo.require("dijit.form.ValidationTextBox");
		dojo.require("dijit.form.DateTextBox");
		dojo.require("dijit.form.FilteringSelect");
		dojo.require("dijit.Dialog");
		dojo.require("dijit.form.CheckBox");
		dojo.require("dojox.validate.regexp");  
		dojo.require("dijit.Tooltip");
		dojo.require("dijit.form.Textarea");
	   	//set dyanmic Vars
		var siteRoot = '<?php echo PROFILE_ROOT; ?>';
		//test sync settings
		dojo.addOnLoad( function (){
			<?php if($this->Session->check("user")){ ?>
				//check sync once page is all loaded up.
				checkSync();
			<?php } ?>	
		 });
	</script> 
	
	<link rel="openid.server" 	href="http://<?php echo $server ; ?>/auth/<?php echo $username; ?>" />
	<link rel="openid.provider" href="http://<?php echo $server ; ?>/auth/<?php echo $username; ?>" />
	<link rel="openid.delegate" href="http://<?php echo $server ; ?>/auth/<?php echo $username; ?>" />
	<?php echo $scripts_for_layout ?>
</head>
<body class='tundra'>
	<div id="container">
		<?php echo $this->element ('header');   ?>
		<div id='flashZilla'>
		<?php echo $session->flash(); ?>
		</div>
		<?php echo $content_for_layout ?>
		<?php echo $this->element ('footer'); ?>
	</div>
	<script type="text/javascript">

	  var _gaq = _gaq || [];
	  _gaq.push(['_setAccount', 'UA-4678650-4']);
	  _gaq.push(['_trackPageview']);
	
	  (function() {
	    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	  })();
	
	</script>
</body>
</html>