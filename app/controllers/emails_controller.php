<?php
/**
 * E-mail class, this handles all of the e-mail information,
 * 
 * @author Michael Pontin
 * @created Nov 25 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class EmailsController extends AppController {
	
	
	/**
	 * Add an email attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{
		parent::add();
	}
	
	/**
	 * Edit an existing email
	 */
	function edit($id = null)
	{
		if(!array_key_exists(0, $this->params['pass']))
		{
			//check to see if the e-mail being added is already attached to that profile
			$record = $this->Email->query("SELECT * FROM emails WHERE identity_id =".$this->Session->read('ident')." AND emails.email = '".$this->data['Email']['email']."' ;");
			if(array_key_exists(0,$record))//checks if any records exist
			{
				$this->Session->setFlash('This e-mail address is already attached to this profile');           
				$this->redirect('/emails/add');
				exit;
			}
		}
		//changes which e-mail address is set as primary
		if($this->data['Email']['primary'] == 1)//check to see they are setting primary
		{
			$rec = $this->Email->query("SELECT * FROM emails WHERE identity_id = ".$this->Session->read('ident')." AND emails.primary = 1; ");
			if(array_key_exists(0, $rec))//check to see a record exists
			{
				$this->Email->id = $rec[0]['emails']['id'];
				$this->Email->set('primary', 0);
				$this->Email->save();
				unset($this->Email->id);
			}					
		}
		parent::edit(null, "e-mail");
	}
	
	/**
	 * Deletes a specified email
	 */
	function delete()
	{
		parent::delete("e-mail");
	}
	
	//this function is not yet used as it didn't seem to send
	function send($email) 
	{ 
            $this->Email->template = 'email/default'; 
            // You can use customised thmls or the default ones you setup at the start
            $data = "This message is just to confirm that you have an e-mail address to your identity"; 
            $this->set('data', $data); 
            $this->Email->to = $email; 
            $this->Email->from = 'no-reply@theprofile.co.uk';
            $this->Email->subject = 'Notification';            
            // You can attach as many files as you like. 
            $result = $this->Email->send(); 
  			return $result; 
    }
	
}