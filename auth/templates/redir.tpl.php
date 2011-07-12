<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>theProfile OpenID Server</title>
    <link href="templates/core.css" rel="stylesheet" type="text/css" />
    <meta http-equiv="refresh" content="0;url='<?php print $url; ?>'">
  </head>
  <body>
  <div id="container">
	  <?php include('title.tpl.php'); ?>
  	  	<div id='clear'></div>
	    <div id="content">
	      <table class='list'><tr>
	        <th><?php if ($header) print $header; else print "Status"; ?></th>
	      </tr>
	        <tr><td>
	        <strong>Operation in progress...</strong><br/>
	        <?php 
	          if ($message) print $message; 
	            else print "Redirecting to <a href='$url'>$url</a>";
	        ?>
	        </td></tr>
	      </table>
	    </div>
	 </div>
  <?php include('footer.tpl.php'); ?>
  </body>
</html>