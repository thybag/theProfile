<?php
/**
 * Routes configuration
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different urls to chosen controllers and their actions (functions).
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.app.config
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Here, we are connecting '/' (base path) to controller called 'Pages',
 * its action called 'display', and we pass a param to select the view file
 * to use (in this case, /app/views/pages/home.ctp)...
 */
 

//Router::connect('/',array('controller' => 'users', 'action' => 'login', 'login'));
//$subdomain = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.'));
// define values that should NOT be affected by this test:
//$donot = array('theprofile');
//if (!in_array($subdomain, $donot)) {
	//Router::connect('/',  array('controller' => 'identities', 'action' => 'public_view'), array( 'user' => '[a-zA-Z0-9]+', 'pass' => array($subdomain)));
//} else {
Router::connect('/' , array('controller' => 'pages', 'action' => 'display', 'home'));
//}
Router::parseExtensions('rss','xml');

Router::connect('/registered' , array('controller' => 'pages', 'action' => 'display', 'registered'));

Router::connect('/account' , array('controller' => 'users', 'action' => 'edit'));
Router::connect('/reset' , array('controller' => 'users', 'action' => 'reset'));
Router::connect('/activation' , array('controller' => 'users', 'action' => 'activate'));
Router::connect('/logout', array('controller' => 'users', 'action' => 'logout'));
Router::connect('/login', array('controller' => 'users', 'action' => 'login'));
Router::connect('/register', array('controller' => 'users', 'action' => 'register'));
Router::connect('/create', array('controller' => 'users', 'action' => 'index'));
Router::connect('/openid' , array('controller' => 'pages', 'action' => 'display', 'openidLogin'));
Router::connect('/acknowledgments' , array('controller' => 'pages', 'action' => 'display', 'acknowledgments'));
Router::connect('/developers' , array('controller' => 'pages', 'action' => 'display', 'developers'));
Router::connect('/downloads' , array('controller' => 'pages', 'action' => 'display', 'downloads'));
Router::connect('/downloads/wordpress' , array('controller' => 'pages', 'action' => 'display', 'wordpress'));
Router::connect('/sitemap', array('controller' => 'sitemaps', 'action' => 'index'));
Router::connect('/legal' , array('controller' => 'pages', 'action' => 'display', 'legal'));
Router::connect('/faq' , array('controller' => 'pages', 'action' => 'display', 'faq'));
Router::connect('/licensing', array('controller' => 'pages', 'action' => 'display', 'licensing')); 
Router::connect('/gettingstarted', array('controller' => 'pages', 'action' => 'display', 'gettingstarted'));

Router::connect('/sync/check' , array('controller' => 'appsync', 'action' => 'check'));
Router::connect('/sync/load' , array('controller' => 'appsync', 'action' => 'merge'));

Router::connect('/sync/Twitter/:sync_id' , array('controller' => 'twitter', 'action' => 'sync'));
Router::connect('/sync/Google/:sync_id' , array('controller' => 'google', 'action' => 'sync'));
Router::connect('/sync/Facebook/:sync_id' , array('controller' => 'facebook', 'action' => 'sync'));
Router::connect('/sync/OpenID/:sync_id' , array('controller' => 'openids', 'action' => 'sync'));
/*
Router::connect('/p/:user_name', 
	array('controller' => 'users', 'action' => 'profile', 'profile'),
	array( 'user' => '[a-zA-Z0-9]+', 'pass' => array('user_name'))
	);
*/


Router::connect('/profile/:id',  array('controller' => 'identities', 'action' => 'index'));
Router::connect('/profile',  array('controller' => 'identities', 'action' => 'index'));
Router::connect('/p/:name',  array('controller' => 'identities', 'action' => 'public_view'), array( 'user' => '[a-zA-Z0-9]+', 'pass' => array('user')));

Router::connect('/google',  array('controller' => 'google', 'action' => 'index'));
Router::connect('/callback',  array('controller' => 'google', 'action' => 'callback'));

Router::connect('/twitter',  array('controller' => 'twitter', 'action' => 'index'));
Router::connect('/twitcallback',  array('controller' => 'twitter', 'action' => 'callback'));
Router::connect('/twittest',  array('controller' => 'twitter', 'action' => 'test'));

Router::connect('/openidcallback',  array('controller' => 'openids', 'action' => 'create'));
Router::connect('/openidapp',  array('controller' => 'openids', 'action' => 'saveApp'));

Router::connect('/facebook',  array('controller' => 'facebook', 'action' => 'index'));

Router::connect('/ajax_check',  array('controller' => 'users', 'action' => 'ajax_check'));

Router::connect('/redirect', array('controller' => 'users', 'action' => 'changepath'));
Router::connect('/api/:username.:type', array('controller' => 'users', 'action' => 'api',array('pass' => array('user'))));
Router::connect('/api/:username', array('controller' => 'users', 'action' => 'api',array('pass' => array('user'))));
Router::connect('/ajax_zone/:name',  array('controller' => 'identities', 'action' => 'ajax_zone'));
/*
//Router::connect('/writings/:action/*', array('controller' => 'openid')); 
Router::connect('/about', array('controller' => 'openid', 'action' => 'index', 'index')); 


Router::connect('/profile/:user', array('controller' => 'p', 'action' => 'index', 'index')); 


Router::connect('/identman/p/test', 
 array('action' => 'index'),    
 array('user' => '[a-zA-Z0-9]'));


 Router::connect(PROFILE_ROOT .'/openid/user/:user',
	 				array('controller' => 'openidcontroller', 'action' => 'user'), 
	 				array( 'user' => '[a-zA-Z0-9]', 'pass' => Array('user'))	 				
	 				
	 );
	
Router::connect('identman/p/:user',
	 array('action' => 'index'), 
	 array( 'user' => '[a-zA-Z0-9]', 'pass' => Array('user'))	 				
	 				
	 );
	
 Router::connect(PROFILE_ROOT , array('controller' => 'pages', 'action' => 'display', 'home'));
*/

/**
 * ...and connect the rest of 'Pages' controller's urls.
 */
	//Router::connect(PROFILE_ROOT .'/pages/*', array('controller' => 'pages', 'action' => 'display'));
	
	
