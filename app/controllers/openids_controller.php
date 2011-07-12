<?php
/**
 * OpenID controller for handling data from an OpenID provider
 * 
 * @author David Couch
 * @created Feb 5 2011
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
 
class OpenidsController extends AppController {
 	public $components = array('Openid', 'RequestHandler', 'SyncManager');
	public $uses = array();


	/**
	*  Runs the OpenID data gathering
	*/
	public function login() {
	
		$whereToGoNext = $_REQUEST['data']['Openid']['type'];
	    $realm = 'http://'.$_SERVER['HTTP_HOST'];
	    $returnTo = $realm .'/'. $whereToGoNext;
	    
	    if ($this->RequestHandler->isPost() && !$this->Openid->isOpenIDResponse()) {
	        try {
				$this->makeOpenIDRequest($this->data['OpenidUrl']['openid'], $returnTo, $realm);
				} catch (InvalidArgumentException $e) {
	            //$this->set('error', 'Invalid OpenID');
				$this->Session->setFlash('Invalid OpenID');
				$this->redirect('/create');  
				}
	    } elseif ($this->Openid->isOpenIDResponse()) {
	        $this->handleOpenIDResponse($returnTo);
	    }
	}
	
	/**
	*  This function creates a valid OpenID request to the provider
	*/
    private function makeOpenIDRequest($openid, $returnTo, $realm) {
            $required = array('email');
            $optional = array('nickname', 'fullname', 'gender', 'dob');
            $this->Openid->authenticate($openid, $returnTo, $realm, array('sreg_required' => $required, 'sreg_optional' => $optional));
    }
	
	//handles the response from the OpenID provider
    private function handleOpenIDResponse($returnTo) {
            $response = $this->Openid->getResponse($returnTo);
    
            if ($response->status == Auth_OpenID_SUCCESS) {
                $sregResponse = Auth_OpenID_SRegResponse::fromSuccessResponse($response);
                $sregContents = $sregResponse->contents();
				}
    }
	
	/**
	*  This function acts as a test for what the OpenID provider returns
	*/
	public function callback() {
		$email = $_REQUEST['openid_sreg_email'];
		$nickname = $_REQUEST['openid_sreg_nickname'];
		$gender = $_REQUEST['openid_sreg_gender'];
		$fullname = $_REQUEST['openid_sreg_fullname'];
		
		$names = explode(" ", $fullname);
		
		$title = $names[0];
		$firstName = $names[1];
		$lastName = $names[2];
		
		echo 'Identity Name: OpenID'.'<br />';
		echo 'Title: '.$title.'<br />';
		echo 'First Name: '.$firstName.'<br />';
		echo 'Last Name: '.$lastName.'<br />';
		echo 'Nickname: '.$nickname.'<br />';
		echo 'Gender: '.$gender.'<br />';
		echo 'Email: '.$email.'<br />';
		
		exit;
		}
		
	/**
	*  Function to create an identity based off gathered OpenID data
	*/
	public function create()
	{
		$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db    				
		
		$this->getIdentity();
		$ident = $this->Session->read('ident'); 
		
		$userid = $user['User']['id'];
		ClassRegistry::init('Identity')->set('user_id', $userid);
		
		
		if(!empty($_REQUEST['openid_sreg_fullname']))
		{
			$fullname = $_REQUEST['openid_sreg_fullname'];
		}
		else{
			$this->Session->setFlash('Sadly your openID server does not provide us with enough information!');
			$this->redirect('/profile');  
			}			
				
		//If the OpenID server gives us a gender, assign it to $gender. If not set it to null.
		if(!empty($_REQUEST['openid_sreg_gender']))
		{
			$gender = $_REQUEST['openid_sreg_gender'];
		}
		else{
			$gender = NULL;
			}
				
		if(!empty($_REQUEST['openid_sreg_email']))
		{
			$email = $_REQUEST['openid_sreg_email'];
		}
		else{
			$email = NULL;
			}
		
		if(!empty($_REQUEST['openid_sreg_dob']))
		{
			$dob = strtotime($_REQUEST['openid_sreg_dob']);
		}
		
		//Separates the name so we can grab the first name
		$names = explode(" ", $fullname);
		$firstName = $names[0];
		//Takes the final part of the name so we can get a surname
		$lastName = array_pop($names);
		//As long as they are not null, put them into the profile	
		if($firstName !=null && $lastName !=null)
		{
			ClassRegistry::init('Identity')->set('first_name', $firstName);
			ClassRegistry::init('Identity')->set('last_name', $lastName);
		}
		//If they are null tell the user the profile does not contain enough information and take them back to their default profile
		else{
			$this->Session->setFlash('Sadly your openID server does not provide us with enough information!');
			$this->redirect('/profile');  
		}
		
		if(!empty($_REQUEST['openid_sreg_nickname']))
		{
			$nickname = $_REQUEST['openid_sreg_nickname'];
		}
		else{
			$nickname = $firstName.' '.$lastName;
			}
		
		
		//if a nickname is provided by the OpenID server, use it
		if($nickname != null )
		{
			ClassRegistry::init('Identity')->set('nickname', $nickname);
		}
		//if a gender is provided by the OpenID server, use it
		if($gender != null)
		{
			if($gender=='m' OR $gender=='M'){$gender = 'Male';}
			if($gender=='f' OR $gender=='F'){$gender = 'Female';}
			ClassRegistry::init('Identity')->set('gender', $gender);
		}
		//if a date of birth is provided by the OpenID server, use it
		if($dob != null)
		{
			ClassRegistry::init('Identity')->set('dob', date('Y-m-d', $dob));
		}
		
		if(!empty($_REQUEST['openid_sreg_nickname'])){
			ClassRegistry::init('Identity')->set('name', $_REQUEST['openid_sreg_nickname']);
		}else{
			ClassRegistry::init('Identity')->set('name', 'OpenID');
		}
		//Save all the data we have to the user's identity
		if(ClassRegistry::init('Identity')->save($this->data))
			{
				$this->getIdentity();
				$ident = $this->Session->read('ident'); 
				$this->setDefault();
				
				
				if(!empty($_REQUEST['openid1_claimed_id']))
				{
					$endpoint = $_REQUEST['openid1_claimed_id'];
				}
				else{
					$endpoint = null;
					}
				
				//Adds to the application field too
				ClassRegistry::init('Application')->set('identity_id', $ident);
				ClassRegistry::init('Application')->set('token', $endpoint);
				ClassRegistry::init('Application')->set('name', 3);
				ClassRegistry::init('Application')->set('account_identifier', $nickname);
				ClassRegistry::init('Application')->set('attached', 1);
				ClassRegistry::init('Application')->save($this->data); 
				
				//if an email address is provided by the OpenID server, use it
				if($email != null )//checks if an email exists, if so adds it to the database
				{
					ClassRegistry::init('Email')->set('identity_id', $ident);
					ClassRegistry::init('Email')->set('email', $email);
					ClassRegistry::init('Email')->set('primary', 1);
					ClassRegistry::init('Email')->set('valid', 1);
		  			ClassRegistry::init('Email')->save($this->data);   
				}
		
	
		//Redirect the user back to this new profile            
		$this->Session->setFlash('Your profile has been created.');
		$this->redirect('/profile/'.$ident);     
		}
	}
	
	/**
	*  Creates a record in the application table
	*/
	public function saveApp()
	{
		$ident = $this->Session->read('ident');
		
		if(!empty($_REQUEST['openid1_claimed_id']))
		{
			$endpoint = $_REQUEST['openid1_claimed_id'];
		}
		else{
			$this->Session->setFlash('Sadly your openID server does not provide us with enough information!');
			$this->redirect('/profile/'.$ident);
			}
		
		if(!empty($_REQUEST['openid_sreg_nickname']))
		{
			$acc_id = $_REQUEST['openid_sreg_nickname'];
		}
		else
		{
			$acc_id= 'OpenID';
		}
		
		$this->setMergeData();
			
		
		ClassRegistry::init('Application')->set('identity_id', $ident);
		ClassRegistry::init('Application')->set('token', $endpoint);
		ClassRegistry::init('Application')->set('name', 3);
		ClassRegistry::init('Application')->set('account_identifier', $acc_id);
		ClassRegistry::init('Application')->set('attached', 1);
		
		if(ClassRegistry::init('Application')->save($this->data)) 
		{    
			$this->Session->setFlash('Your application has been updated.');            
			$this->redirect('/profile/'.$ident);
		}   
	}  
	
	/**
	*  Adds the data to our merge table
	*/
	function setMergeData(){
		// see what we can get
		if(!empty($_REQUEST['openid_sreg_fullname']))
		{
			$fullname = $_REQUEST['openid_sreg_fullname'];
			$names = explode(" ", $fullname);
			
			$firstName = $names[0];
			$lastName = array_pop($names);
		}
		else{$firstName = null;}
			
		if(!empty($_REQUEST['openid_sreg_gender']))
		{
			$gender = $_REQUEST['openid_sreg_gender'];
		}
		else{$gender = null;}
		
		if(!empty($_REQUEST['openid_sreg_email']))
		{
			$email = $_REQUEST['openid_sreg_email'];
		}
		else{$email = null;}
		
		if(!empty($_REQUEST['openid_sreg_dob']))
		{
			$dob =  date('Y-m-d', strtotime($_REQUEST['openid_sreg_dob']));
		}
		else{ $dob = null;}
		
		if(!empty($_REQUEST['openid_sreg_nickname']))
		{
			$nick = $_REQUEST['openid_sreg_nickname'];
		}
		else{ $nick = null; }

		//Save it
		$this->SyncManager->saveOpenID($firstName, $lastName, $gender, $dob, $email, $nick);
		
	}
	
	/**
	*  Sync Function
	*/
	public function sync()
    {
    	//Stub method
    	die(0);
    }
		    
}