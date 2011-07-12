<?php header('Content-Type: text/html; charset=UTF-8'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
  <head>
    <title>Clamshell: Administration</title>
    <link href="templates/core.css" rel="stylesheet" type="text/css" />
  </head>
  <body>    
  <?php include('title.tpl.php'); ?>
  <center>
    <div id="content">
      <h2>Currently registered users</h2>
        <form method='post'>
        <table class='list'><tr><th>Username</th><th>Edit?</th><th>Delete?</th></tr>
        <?php
          foreach(list_profiles() as $username) {
            print s("<tr><td width='90%'>%%1</td>
                   <td align='center'><input type='submit' name='edit[%%1]' value='Edit' /></td>
                   <td align='center'><input type='submit' name='delete[%%1]' value='Delete' />
                   </td></tr>", htmlspecialchars($username, ENT_QUOTES));
          }        
        ?>
        </table></form>
      <h2>Register a new user</h2>
      <form method="post">
        <input type="hidden" name="action" value="add" />
        <table class='list'><tr>
        <th colspan='2'>Enter a username and password:</th></tr>
        <tr><td>Username</td><td><input name="new" size="40" /></td></tr>
        <tr><td>Password</td><td><input name="pass" type="password" size="40" /></td></tr>
        <tr><td>Confirm password</td><td><input name="confirm" type="password" size="40" /></td></tr>
        <tr><td>Authentication type</td><td><?php print authentication_mode_choice(); ?></td></tr>
        <tr><td>Confirm OpenID requests?</td><td><?php print authentication_confirm_choice(); ?></td></tr>
        <tr><td colspan="2" align="right"><input type="submit" value="Add User" /></td></tr>
        </table>
      </form>
      <center><p><form method="post">
        <input type="hidden" name="action" value="logout" />
        <input type="submit" value="Log Out" />
      </form></p></center>
      <?php if ($message) print $message; ?>
    </div>
  </center>
  <?php include('footer.tpl.php'); ?>
  </body>
</html>