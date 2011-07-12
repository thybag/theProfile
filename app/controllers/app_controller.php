<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. 
 * Controllers will inherit these methods
 *
 * @author Michael Pontin
 * @created Nov 25 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 */
App::import('Sanitize');
class AppController extends Controller {
	var $components = array('RequestHandler','Session');
	
	/**
	 * Parent method for add, checks if they are logged in, redirects if not
	 * If logged in render edit functionality
	 */
	function add()
	{
		if(!$this->Session->check('user'))//prevent users from accessing other users identities
		{
			$this->redirect('/create');
		}
		$this->render('edit');
	}
	
	/**
	 * Parent method for edit, checks if they are logged in, redirects if not
	 * else adds/edits the data to the database
	 */
	function edit($id = null, $name)
	{
		$this->correctLogin();
		//actual adding part
		
		//Automatically set ajax view when requested via ajax
		if($this->RequestHandler->isAjax()){
			$this->layout = 'ajax';
		}
		
		
		if(!empty($this->params['pass']))
		{
			$id = $this->params['pass'][0];
 			$this->{$this->modelClass}->id = $id;
		} 
		if(empty($this->data)) 
		{        
			$this->data = $this->{$this->modelClass}->read();    
		} 
		elseif($this->{$this->modelClass}->validates()) 
		{   		
    		$this->{$this->modelClass}->set('identity_id', $this->Session->read('ident'));
    		$data = $this->sanitizeIt($this->data);
			if($this->{$this->modelClass}->save($data)) 
			{            
				$this->Session->setFlash('The '.$name.' has been updated.');  
				if(!$this->RequestHandler->isAjax()){          
					$this->redirect('/profile/'.$this->Session->read('ident'));
				}else { die(); }    
			}    
		}
	}
	
	/**
	 * Prevents users from accessing data that isn't theirs
	 */
	function correctLogin()
	{
		if(!$this->Session->check('user'))//prevent users from accessing other users identities
		{
			$this->redirect('/profile/'.$this->Session->read('ident'));  
		}
		if(!empty($this->params['pass']))
		{
			$id = $this->{$this->modelClass}->findById($this->params['pass'][0]); //gets the model populated
			if($id[$this->modelClass]['identity_id'] != $this->Session->read('ident'))
			{
				$this->redirect('/profile/'.$this->Session->read('ident'));  
				exit;
			}
		}
		return true;
	}
	
	/**
	 * Sanitizes the data before it is placed into the database 
	 */
	function sanitizeIt($data)
	{
		foreach($data as $k => $v)
    	{
    			foreach($v as $key => $value)
    			{
	    			$value = Sanitize::html($value, array('remove' => true)); //removes all tag elements sanitizing the data
	    			$v[$key] = $value;
    			}
    			$data[$k] = $v;
    	}
		return $data;
	}
	
	/**
	 * Deletes a specified address
	 */
	function delete($name)
	{
		$this->correctLogin();
		$id = $this->params['pass'][0];
		$this->{$this->modelClass}->delete($id);
		$this->Session->setFlash('Your '.$name.' has been deleted.');           
		$this->redirect('/profile/'.$this->Session->read('ident'));
		exit;     
	}
	
	/**
	 * Returns an array of arrays sorted by the specific index you give it
	 * keeps the index the same e.g. [0]=>[num]=>1, [1]=>[num]=>0, [2]=>[num]=>4
	 * would return [1][0][2] 
	 */
	function array_sort($array, $on, $order=SORT_ASC)
	{
	    $new_array = array();
	    $sortable_array = array();
	
	    if (count($array) > 0) {
	        foreach ($array as $k => $v) {
	            if (is_array($v)) {
	                foreach ($v as $k2 => $v2) {
	                    if ($k2 == $on) {
	                        $sortable_array[$k] = $v2;
	                    }
	                }
	            } else {
	                $sortable_array[$k] = $v;
	            }
	        }
	
	        switch ($order) {
	            case SORT_ASC:
	                asort($sortable_array);
	            break;
	            case SORT_DESC:
	                arsort($sortable_array);
	            break;
	        }
	
	        foreach ($sortable_array as $k => $v) {
	            $new_array[$k] = $array[$k];
	        }
	    }
	
	    return $new_array;
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
     * Sets the default profile when they create one for the first time
     */
    public function setDefault()
    {
    	$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db
    	$def = $user['User']['profile_default'];
    	
		if($def == 0 || $def == null) //checks to see if they have a profile and if they have set their default
		{
			ClassRegistry::init('User')->id = $user['User']['id']; //set which user is being changed
			ClassRegistry::init('User')->set('profile_default', $this->Session->read('ident')); 
    		ClassRegistry::init('User')->save($this->data); 
		} 
    }
	
}
