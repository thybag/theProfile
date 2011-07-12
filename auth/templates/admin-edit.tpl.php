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
      <h2>Change Password</h2>
      <?php print s("
      <table class='list'><tr><th>%%1</th></tr>
        <tr><td>
        <form method='POST'>
        <table border='0'>
          <tr><td>%%2</td><td>%%3</td></tr>
          <tr><td>%%4</td><td><input type='password' name='pass' /></td></tr>
          <tr><td>%%5</td><td><input type='password' name='confirm' /></td></tr>
          <tr><td><input type='submit' name='resetPwd[%%6]' value='%%7' />
          <input type='submit' name='cancel' value='%%8' /></td></tr>
          <input type='hidden' name='nonce' value='%%9' />
          </table>
        </form></td></tr></table>", 
        t('user_edit_caption'), t('user_edit_openid'), t('auth_username'), 
        t('msg_password'), t('msg_password_check'), htmlspecialchars($user, ENT_QUOTES),
        t('submit'), t('cancel'), $_SESSION['openid-admin']['nonce'] );
      ?>

      <h2>Edit Settings</h2>
      <?php print s("
      <table class='list'><tr><th>%%1</th></tr>
        <tr><td>
        <form method='POST'>
        <table border='0'>
          <tr><td>%%2</td><td>%%3</td></tr>
          <tr><td>%%4</td><td>%%5</td></tr>
          <tr><td>%%6</td><td>%%7</td></tr>
          <tr><td><input type='submit' name='edit[%%8]' value='%%9' />
          <input type='submit' name='cancel' value='%%10' /></td></tr>
          <input type='hidden' name='nonce' value='%%11' />
          </table>
        </form></td></tr></table>", 
        t('user_edit_caption'), t('user_edit_openid'), t('auth_username'), 
        t('msg_auth_mode'), authentication_mode_choice(), 
        t('msg_confirm_requests'), authentication_confirm_choice(), htmlspecialchars($user, ENT_QUOTES), 
        t('submit'), t('cancel'), $_SESSION['openid-admin']['nonce'] );
      ?>

      <h2>Edit Details</h2>
      <?php print s("
      <table class='list'><tr><th>%%1</th></tr>
        <tr><td>
        <form method='POST'>
        <table border='0'>
          <tr><td>%%2</td><td><input size='50' name='sreg[nickname]' value='%%3' /></td></tr>
          <tr><td>%%4</td><td><input size='50' name='sreg[email]' value='%%5' /></td></tr>
          <tr><td>%%6</td><td><input size='50' name='sreg[fullname]' value='%%7' /></td></tr>
          <tr><td>%%8</td><td>%%9</td></tr>
          <tr><td>%%10</td><td>%%11</td></tr>
          <tr><td>%%12</td><td><input size='10' name='sreg[postcode]' value='%%13' /></td></tr>
          <tr><td>%%14</td><td>%%15</td></tr>
          <tr><td>%%16</td><td>%%17</td></tr>
          <tr><td>%%18</td><td>%%19</td></tr>
          <tr><td></td><td><input type='checkbox' name='sreg[public]' %%21 value='TRUE' /> %%20</td></tr>
          <tr><td><input type='submit' name='simpleReg[%%22]' value='%%23' />
          <input type='submit' name='cancel' value='%%24' /></td></tr>
          <input type='hidden' name='nonce' value='%%25' />
          </table>
        </form></td></tr></table>", 
        t('msg_simple_reg_caption'),
        t('msg_simple_reg_nickname'), htmlspecialchars(t('openid.sreg.nickname'), ENT_QUOTES), 
        t('msg_simple_reg_email'), htmlspecialchars(t('openid.sreg.email'), ENT_QUOTES),
        t('msg_simple_reg_fullname'), htmlspecialchars(t('openid.sreg.fullname'), ENT_QUOTES),
        t('msg_simple_reg_dob'), simple_reg_dob_choice(), 
        t('msg_simple_reg_gender'), simple_reg_gender_choice(), 
        t('msg_simple_reg_postcode'), addslashes(t('openid.sreg.postcode')), 
        t('msg_simple_reg_country'), simple_reg_country_choice(), 
        t('msg_simple_reg_language'), simple_reg_language_choice(), 
        t('msg_simple_reg_timezone'), simple_reg_timezone_choice(), 
        t('msg_simple_reg_is_public'), t('openid.sreg.public') ? 'checked=\'checked\'' : '',
        htmlspecialchars($user, ENT_QUOTES), t('submit'), t('cancel'), $_SESSION['openid-admin']['nonce'] );
      ?>
    </div>
  </center>
  <?php include('footer.tpl.php'); ?>
  </body>
</html>