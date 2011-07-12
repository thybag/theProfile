<?php 
/**
 * Website model
 * @author David Couch
 * @created Jan 25 2011
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */


Class Website extends AppModel{
	
	var $name = 'Website';

	//validation for the registration form
	var $validate = array(
		'webite' => array( 
        	'valid' => array(
        		'rule' => array('website', true), 'message' => 'Please supply a valid web address.'
        	),
        	'empty' => array(
             'rule' => 'notEmpty', 'message' => 'This field cannot be left blank.'
             )   
        )
	);
	
}
?>