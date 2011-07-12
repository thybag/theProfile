<?php 
/**
 * Number model, contains telephone number information about the user
 *
 * @author Michael Pontin
 * @created Nov 17 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

class Number extends AppModel{
	
	var $name = 'Number';
	
	//validation for the number form
	var $validate = array(
		'number' => array(	
				'notempty' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a telephone number.'),
				'alpha' => array( 'rule' => array('numeric', true), 'message' => 'Telephone number can only contain numbers.')
		)	
	);
	
}