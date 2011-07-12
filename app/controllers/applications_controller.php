<?php
/**
 * Applications class, this handles all of the application information,
 * 
 * @author Michael Pontin, Carl Saggs
 * @created Nov 25 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class ApplicationsController extends AppController {
	
	var $components = array('Facebook');
	/**
	 * Add an application attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{	
		$this->Session->delete('create'); //make sure that is saves to the app table instead of creatint a new one
		$this->Facebook;
		$facebook = $this->Facebook->main();
		$this->set('facebook', $facebook[0]);
		$this->set('session', $facebook[1]);
		$this->set('me', $facebook[2]);
		parent::add();
	}
	
	/**
	 * Edit an existing application
	 * @param int $id ID of appliction to edit
	 */
	function edit($id = null)
	{
	
		//THIS FUNCTIONALITY SHOULD NOW BE DEFUNCT
		parent::edit(null, "application");
		$this->Facebook;
		$facebook = $this->Facebook->main();
		$this->set('facebook', $facebook[0]);
		$this->set('session', $facebook[1]);
		$this->set('me', $facebook[2]);
	}
	
	/**
	 * Deletes a specified appliction
	 * @param int $id ID of appliction to remove
	 */
	function delete($id = null)
	{
		
		$this->correctLogin();
		//get appliction info
		$appinfo = $this->Application->find('all', array(
		        'conditions' => array(
			        'id' => $id
    			),
    			'limit' => 1));
    			
    			
    	//check app exists
    	if(count($appinfo) < 1){ 
    		$this->Session->setFlash('Application could not be removed. It appears not to exist?'); 
    		$this->redirect('/profile/'.$this->Session->read('ident'));
    		exit;
    	}
    	
		//kill all appsync records related to this account. (regardless of source)
		$this->clearCache();

		$this->Application->delete($id);
		$this->Session->setFlash('Your application has been deleted.');           
		$this->redirect('/profile/'.$this->Session->read('ident'));
		exit;   
		
		//parent::delete("application");  
	}
	/**
	* Clears appliction sync cache, then returns user to profile.
	*/
	public function clean(){
		$this->clearCache();
		$this->Session->setFlash('Sync cache cleared successfully');           
		$this->redirect('/profile/'.$this->Session->read('ident'));
		
	}
	/**
	* Clears users appliction sync cache
	*/
	private function clearCache(){
		
		$ident = $this->Session->read('ident');
		//kill all appsync records related to this account. (regardless of source)
		ClassRegistry::init('Appsync')->query("DELETE FROM appsyncs
		WHERE identity_id = '{$ident}'");
	}
	
}
