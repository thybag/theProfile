<?php 
/**
 * Identity model, contains identity information about the user
 *
 * @author Michael Pontin
 * @created Nov 17 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

class Identity extends AppModel{
	
	var $name = 'Identity';
	//this creates a link between the other tables, such that when one an identity gets deleted, everything else gets deleted to
	var $hasMany = array('Address' =>
	                         array( 'className'     => 'Address',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'identity_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         ),
                         'Email' =>  
	                         array( 'className'     => 'Email',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'identity_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         ),
                         'Number' =>  
	                         array( 'className'     => 'Number',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'identity_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         ),
                         'Application' =>  
	                         array( 'className'     => 'Application',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'identity_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         ),
                         'Image' =>  
	                         array( 'className'     => 'Image',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'identity_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         )                  
                         );
	
	//validation for the identity form
	var $validate = array(
		'first_name' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply Firstname.'),
		'last_name' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a Lastname.'),
		'dob' => array( 'rule' => array('notEmpty', true), 'message' => 'Please supply a date of birth.'),	
	);
	
}