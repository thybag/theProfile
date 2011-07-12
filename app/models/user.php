<?php 
/**
 * User model
 *
 * @author Michael Pontin
 * @created Nov 9 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */

class User extends AppModel{
	
	var $name = 'User';
	var $hasMany = array('Identity' =>
	                         array( 'className'     => 'Identity',
	                         		'conditions'    => '',
	                         		'order'         => '',                               
	                         		'limit'         => '',                               
	                         		'foreignKey'    => 'user_id',                               
	                         		'dependent'     => true,                               
	                         		'exclusive'     => false,                               
	                         		'finderQuery'   => '',                               
	                         		'fields'        => '',                               
	                         		'offset'        => '',                               
	                         		'counterQuery'  => ''                         
	                         )
					);
					
	//validation for the registration form
	var $validate = array(
		'username' =>  array(        
			'unqiue' => array( 
	           'rule' => 'isUnique', 'message' => 'This username has already been taken.'                  
			 ),       
		   'empty' => array(
             'rule' => 'notEmpty', 'message' => 'This field cannot be left blank.'
             ),
           'matches' => array(
             'rule' => '/^[a-zA-Z0-9_-]*$/', 'message' => 'Only letters, numbers, _ and - are allowed.')    
        ),
        'email' => array( 
        	'valid' => array(
        		'rule' => array('email', true), 'message' => 'Please supply a valid email address.'
        	),
        	'empty' => array(
             'rule' => 'notEmpty', 'message' => 'This field cannot be left blank.'
             )   
        ),
		'password' => array( 
			'min' => array(
        		'rule' => array('minLength', 8), 'message' => 'Password must be at least 8 characters long.'
        	),
        	'empty' => array(
        	    'rule' => array('notEmpty', true), 'message' => 'This field cannot be left blank.'
        	),
        	'identical' => array(
        		'rule' => array('identicalFields', 'password_confirm'), 'message' => 'The passwords do not match.'
        	)
        )	
	);
	
	/*
	 * Custom validation function to compare the two passwords with each other
	 */
	function identicalFields( $field=array(), $compare_field=null )  
	{ 
		foreach( $field as $key => $value )
		{ 
			$v1 = $value; 
            $v2 = $this->data[$this->name][ $compare_field ];                  
            if($v1 !== $v2) { 
                return FALSE; 
            } else { 
                continue; 
            } 
        } 
        return TRUE; 
	} 
	
}