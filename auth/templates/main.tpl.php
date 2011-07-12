<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>theProfile OpenID Server</title>
    <link href="templates/core.css" rel="stylesheet" type="text/css" />
    <link rel="openid.server" href="<?php print t('req_url'); ?>" />
    <link rel="openid.delegate" href="<?php print t('idp_url'); ?>" />
  </head>
  <body>
  <div id="container">
	  <?php include('title.tpl.php'); ?>
	  	<div id='clear'></div>
	    <div id="content">      
	      <table class='list'><tr>
	        <th><?php if ($header) print $header; else print "Status"; ?></th>
	      </tr><tr><td>
	        <?php print $message; ?>
	        </td></tr>
	      </table>
	    </div>
	  </div>
  </body>
  <?php include('footer.tpl.php'); ?>
</html>