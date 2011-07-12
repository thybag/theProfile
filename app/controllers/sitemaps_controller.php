<?php 
/**
 * Displays sitemap
 * 
 * @author David Couch
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */
class SitemapsController extends AppController{ 

    var $name = 'Sitemaps'; 
    var $uses = array('Post', 'Info'); 
    var $helpers = array('Time'); 
    var $components = array('RequestHandler'); 

    function index (){    
    	$this->set('pages', $this->Info->find('all', array( 'conditions' => array('ispublished' => 1 ), 'fields' => array('date_modified','id','url'))));


	//debug logs will destroy xml format, make sure were not in debug mode 
	Configure::write ('debug', 0); 
    } 
} 