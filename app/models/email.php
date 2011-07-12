<?php 
/**
 * E-mail model
 *
 * @author Michael Pontin
 * @created Nov 25 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

class Email extends AppModel{
	
	var $name = 'Email';

	//validation for the registration form
	var $validate = array(
		'email' => array( 
        	'valid' => array(
        		'rule' => array('email', true), 'message' => 'Please supply a valid email address.'
        	),
        	'empty' => array(
             'rule' => 'notEmpty', 'message' => 'This field cannot be left blank.'
             )   
        )
	);
	
}
