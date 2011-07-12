<?php
/**
* Create an instance of the google appliction object
*
* @package theProfile
* @license http://www.opensource.org/licenses/mit-license.php
*/
class GoogleComponent extends Object {
	
	
	function main() {
		App::import('Core', 'HttpSocket');	
		$Http = new HttpSocket();
		$request_get = array( 
			'GET /m8/feeds/profiles/domain/theProfile.co.uk/full HTTP/1.1',
			'Content-Type: application/x-www-form-urlencoded', 
			'Host: www.google.com', 
			'Connection: keep-alive', 
			'User-Agent: CakePHP',
			'Authorization: AuthSub token="yourSessionToken"'
			); 
		$response = $Http->request($request_get); 

	}
}
?>
