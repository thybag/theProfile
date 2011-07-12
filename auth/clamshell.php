<?php
/*
 * Clamshell - A standalone OpenID Identity Provider
 * Version: 0.6.7
 *
 * Modified by Stephen Bounds (C) 2007-2008.
 *
 * Original phpMyID code by CJ Niemira (c) 2006-2007
 *
 * This code is licensed under the GNU General Public License
 * http://www.gnu.org/licenses/gpl.html
 *
 */

require_once 'modules/core.module';

clamshell_setup();
clamshell_fix_post($_POST);

if (!read_user_profile()) {
  if (t('auth_username')) {
    error_500(t(err('no_profile'), 'auth_username'), err('no_profile_fixes'));
  } else {
    error_500(err('no_username'), err('no_username_fixes'));
  }
}
set_profile();

// Run in the determined runmode
debug($_REQUEST, 'Request params');

if (isset($_GET['admin']) && get_run_mode() != 'cancel') {
  require_once 'modules/admin.module';

  if (admin_authorize()) {
    admin_display();
  }
} else {
  call_user_func(get_run_mode() . '_mode');
}

?>
