<?php
/**
* Create an instance of the facebook appliction object
*
* @package theProfile
* @license http://www.opensource.org/licenses/mit-license.php
*/
// Create our Application instance (replace this with your appId and secret).

class FacebookComponent extends Object {
	
	function main($data=false) {
		App::import('Vendor', 'facebook/facebook');	
		$facebook = new Facebook(array(
		  'appId'  => FB_APP_ID, //my dev's appId, live is 127911270604003
		  'secret' => FB_DEV_SECRET, //my dev's secret, live is d28ec32267f56885525aa87912efcaef
		  'cookie' => true,
		));
		
		if($data)
		{
			$facebook->validateSessionObject($data);
		}
		// We may or may not have this data based on a $_GET or $_COOKIE based session.
		//
		// If we get a session here, it means we found a correctly signed session using
		// the Application Secret only Facebook and the Application know. We dont know
		// if it is still valid until we make an API call using the session. A session
		// can become invalid if it has already expired (should not be getting the
		// session back in this case) or if the user logged out of Facebook.
		$session = $facebook->getSession();
		$me = null;
		// Session based API call.
		if ($session) {
		  try {
		    $uid = $facebook->getUser();
		     $fbme = $facebook->api('/me');
		     $param  =   array(
	                'method'  => 'users.getinfo',
	                'uids'    => $fbme['id'],
	                'fields'  => 'first_name,last_name,birthday,birthday_date,email,profile_url,about_me,sex,username', //enter the information here, that we wish to add
	                'callback'=> ''
	            );
		    $me = $facebook->api($param);
		  } catch (FacebookApiException $e) {
		    error_log($e);
		  }
		}
		
		// login or logout url will be needed depending on current user state.
		if ($me) {
		  $logoutUrl = $facebook->getLogoutUrl();
		} else {
		  $loginUrl = $facebook->getLoginUrl();
		}
		return array($facebook,$session,$me);
	}
}
?>
