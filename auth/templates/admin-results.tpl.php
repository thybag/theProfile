<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<?php
  function admin_home_uri() {
    $proto = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == 'on') ? 'https' : 'http';
    if ($_SERVER['SERVER_PORT'] && $_SERVER['SERVER_PORT'] != ($proto == 'http' ? 80 : 443)) { 
      $port = ":$port"; 
    } else { 
      $port = '';
    }
    $uri = s("%%1://%%2%%3%%4?admin=true", $proto, $_SERVER['HTTP_HOST'], $port, $_SERVER['PHP_SELF']);
    return "<input type='Button' onClick='document.location=\"".$uri."\";' value='Back' />";
  }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Clamshell: Administration</title>
    <link href="templates/core.css" rel="stylesheet" type="text/css" />
  </head>
  <body>
  <center>
    <?php include('title.tpl.php'); ?>
    <div id="content">
      <table class='list'><tr>
        <th><?php if ($header) print $header; else print "Results"; ?></th>
      </tr>
      <tr><td>
        <?php print $body ?>
        <?php 
          if ($footer) print "<form>".admin_home_uri()."</form>";
        ?>
      </td></tr>
      </table>
    </div>
  </center>
  <?php include('footer.tpl.php'); ?>
  </body>
</html>