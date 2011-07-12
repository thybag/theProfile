<?php
/**
 * Identity class, this handles all of the identity information,
 * including creation of identities
 * 
 * @author Michael Pontin, Carl Saggs, David Couch
 * @created Nov 17 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class IdentitiesController extends AppController {
	
	var $components = array('Facebook'); 
	
	/**
	 * Add and profile attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{
		$this->set('isAjax', $this->RequestHandler->isAjax());
		parent::add();
	}
	
	/**
	 * Edit an existing profile
	 */
	function edit($id = null)
	{
		//$this->layout = 'ajax';
		$this->set('isAjax', $this->RequestHandler->isAjax());
		
		if(!empty($this->params['pass']))
		{
			$id = $this->params['pass'][0];
 			$this->Identity->id = $id;
 			if($this->Identity->id != $this->Session->read('ident'))//checks to see if the identity being edited belongs to the users session
 			{
 				$this->redirect('/redirect');
				exit;
 			}
		} 		
		if(empty($this->data)) 
		{        
			$this->data = $this->Identity->read();    
		} 
		else 
		{   			
			$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db    				
    		$userid = $user['User']['id'];
    		$this->Identity->set('user_id', $userid);
			//capitals
			$this->data['Identity']['first_name'] =  ucfirst($this->data['Identity']['first_name']);
			$this->data['Identity']['last_name'] = ucfirst($this->data['Identity']['last_name']);
			//remove htmlz
    		$data = $this->sanitizeIt($this->data);
			if ($this->Identity->save($data)) 
			{           
				if(!$this->Session->check('ident')) //if they don't have an identity use specail redirect method that sets their ident
				{
					$this->getIdentity();
					$this->setDefault();

					$this->Session->setFlash('Your profile has been created.');
					$this->redirect('/redirect');
					exit;
				} 
				$this->getIdentity();
				$this->Session->setFlash('Your profile has been updated.');   
				if(!$this->RequestHandler->isAjax()){        
					$this->redirect('/profile/'.$this->Session->read('ident'));  
					exit;   
				}   
				exit;
			}    
		}
	}
	/**
	* Sets appsync cache for user to synced
	* @deprecated
	*/
	function  save(){
		//Save Changes
    	$this->Identity->set('id', $this->Session->read('ident'));	
		$this->Identity->save($this->data);
		//Stop nag's
		//(bad form i know, but we're in a rush here)
		ClassRegistry::init('Appsync')->query("UPDATE appsyncs
							SET synced = 1
							WHERE identity_id = '{$this->Session->read('ident')}'");
		//redirect
		$this->redirect('/profile/'.$this->Session->read('ident'));
	}
	/**
	* Displays users profile
	*/
	function index()
	{	
		if(!$this->Session->check('user')) //check to see if logged in, else redirect
		{
			$this->redirect('/redirect');
			exit;
		}
		$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db
		$oneid = $this->Identity->findByUserId($user['User']['id']);
		$id = $this->params['id'];		
		$def = $user['User']['profile_default'];
		//deperciated
		/*
		if($oneid && ($def == 0 || $def == null)) //checks to see if they have a profile and if they have set their default
		{
			ClassRegistry::init('User')->id = $user['User']['id']; //set which user is being changed
			ClassRegistry::init('User')->set('profile_default', $id); 
			ClassRegistry::init('User')->set(($this->data)); //make sure the model has been set with the data
    		ClassRegistry::init('User')->save($this->data); 
		}    	
		*/			
		$userid = $user['User']['id'];
		$identity = $this->Identity->findById($id);
		if($identity['Identity']['user_id'] != $userid)//prevent users from accessing other users identities
		{
			$this->redirect('/redirect');
			exit;
		}
		$this->Session->write('ident',$id);
		$this->set('user', $user);
    	$this->set('identity', $identity['Identity']);	
    	$this->set('addresses', $identity['Address'] );
    	$this->set('numbers', $identity['Number'] );
    	$this->set('images', $this->array_sort($identity['Image'], 'added', SORT_DESC) );
    	$this->set('emails', $identity['Email'] );
    	$this->set('apps', $identity['Application'] );
    	$this->Facebook;
	}
	/**
	* Display users public profile
	*
	*/
	function public_view()
	{
	
		//$this->layout = 'ajax';
		if(array_key_exists('name',$this->params))
		{
			$name = $this->params['name'];
		}
		else
		{
			$name = substr($_SERVER['HTTP_HOST'], 0, strpos($_SERVER['HTTP_HOST'], '.'));
		}
		$user = ClassRegistry::init('User')->findByUsername($name); //add the userid to the db
		$def = $user['User']['profile_default'];
		
		$identity = $this->Identity->findById($def );
		
		$this->set('identity', $identity['Identity']);	
		$this->set('images', $identity['Image'] );
		$this->set('privacy', $user['User']['privacy']);
		$this->set('name', $name );
		

		
	}
	/**
	* Loads content area independenty of main page, without wrapper
	*
	*/
	function ajax_zone(){
		$this->layout = 'ajax';
		$identity = $this->Identity->findById($this->Session->read('ident'));
		
    	$this->set('identity', $identity['Identity']);	
    	$this->set('addresses', $identity['Address'] );
    	$this->set('numbers', $identity['Number'] );
    	$this->set('images', $this->array_sort($identity['Image'], 'added', SORT_DESC) );
    	$this->set('emails', $identity['Email'] );
    	$this->set('apps', $identity['Application'] );
    	
		$this->set('zone',$this->params['name']);
	}
	
	
	/**
	 * Deletes a specified profile
	 */
	function delete($id = null)
	{
		if($this->params['pass'][0] != $this->Session->read('ident'))//checks to see if the identity being edited belongs to the users session
 		{
 			$this->redirect('/redirect');
			exit;
 		}
 		else
 		{
			$id = $this->params['pass'][0];
			$this->Identity->delete($id);
			$this->Session->delete('ident');
			$this->Session->setFlash('Your identity has been deleted.');
			$this->redirect('/redirect');
			exit;
 		}    
	}
	
    /**
	* Stores the new identity id in the session
	*/
    public function getIdentity()
    {
    	$ident = ClassRegistry::init('Identity')->id;
    	$this->Session->write('ident', $ident);
    }

	/**
	* Allows a user to edit their existing tagline
	*/
	function editTagline($id = null)
	{

		$this->set('isAjax', $this->RequestHandler->isAjax());
 		
		$this->Identity->id = $this->Session->read('ident');
		
		if(empty($this->data)) 
		{        
			$this->data = $this->Identity->read(); 
		} 
		else 
		{   			
			//remove htmlz
    		$data = $this->sanitizeIt($this->data);
			if ($this->Identity->save($data)) 
			{           
				
				$this->Session->setFlash('Your tagline has been updated.');   
				if(!$this->RequestHandler->isAjax()){        
					$this->redirect('/profile/'.$this->Session->read('ident'));  
					exit;   
				}   
				exit;
			}    
		}
	}
	
}