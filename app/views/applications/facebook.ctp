<?php 
/*
 * Facebook static page used to allow the 
 * user to login to facebook so as to create a profile
 * @author David Couch
 */
$me = null;
// Session based API call.
if ($session) {
  try {
    $uid = $facebook->getUser();
    $me = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
  }
}
$loginUrl = $facebook->getLoginUrl();
?>

<div id="facebook_section" class="section">
<div id="fb-root"></div>
<h2>Facebook</h2>
<p>Use Facebook to gather information</p>

<a href="<?php echo $loginUrl; ?>">
    <img src="http://static.ak.fbcdn.net/rsrc.php/zB6N8/hash/4li2k73z.gif">
  </a>


</div>