<?php 
/**
 * Address model, contains address information about the user
 *
 * @author Michael Pontin
 * @created Nov 9 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

class Address extends AppModel{
	
	var $name = 'Address';

	
	//validation for the address form
	var $validate = array(
		'addressline1' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply an address.'),
		'town' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a town.'),
		'county' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a county.'),
		'country' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a country.'),
		'postcode' => array(	
				'notempty' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a postcode.'),
				'alpha' => array( 'rule' => array('custom', '/^[a-z0-9 ]*$/i'), 'message' => 'Postcode can only contain numbers and letters.')
		)		
	);
	
}
