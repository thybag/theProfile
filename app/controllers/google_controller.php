<?php
/**
 * Google class, this handles all of the google information,
 * 
 * @author Michael Pontin, Carl Saggs
 * @created Jan 5 2011
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class GoogleController extends AppController {
    public $uses = array();
    public $components = array('OauthConsumer','SyncManager');
	
    //Authenticates with Google
    public function index() 
    {
        //Google OAuth
		$requestToken = $this->OauthConsumer->getRequestToken('Google', 'https://www.google.com/accounts/OAuthGetRequestToken', 'http://theprofile.co.uk/callback', 'POST', array('scope' => 'https://www.google.com/m8/feeds/ https://www-opensocial.googleusercontent.com/api/people/'));
        $this->Session->write('requestToken', $requestToken);
        $this->redirect('https://www.google.com/accounts/OAuthAuthorizeToken?oauth_token='.$requestToken->key);
    }
	
    
    //Once authenticated this method requests the actuall user data
    public function callback() 
    {
        $requestToken = $this->Session->read('requestToken');
        $accessToken = $this->OauthConsumer->getAccessToken('Google', 'https://www.google.com/accounts/OAuthGetAccessToken', $requestToken);    
        $this->Session->write('accesstoken', $accessToken); 
		$data = $this->OauthConsumer->get('Google', $accessToken->key, $accessToken->secret, 'https://www-opensocial.googleusercontent.com/api/people/@me');
		
		//Massive overkill, we get a ton of contacts but at least we know our own email
		$contacts = $this->OauthConsumer->get('Google', $accessToken->key, $accessToken->secret, 'https://www.google.com/m8/feeds/contacts/default/property-email');
		$contacts = simplexml_load_string($contacts);
		$email = $contacts->id;

		//rest of the data
		$data = json_decode($data);		//convert from json
		
		if($this->Session->check('create')) //only runs the create when there is no identity
		{
			//$this->SyncManager->saveGoogle($data); this needs to be called after the create function
			$this->create($data, $accessToken, $email);
		}
		else
		{
			$this->SyncManager->saveGoogle($data, $email);
			$this->saveApp($accessToken, $email);
		}
    }
    
	
	public function pull_data($ident){
	
		$data = $this->OauthConsumer->get('Google', $accessToken->key, $accessToken->secret, 'https://www-opensocial.googleusercontent.com/api/people/@me');
		print_r($this->OauthConsumer->get('Google', $accessToken->key, $accessToken->secret, 'https://www.google.com/m8/feeds/contacts/default/full'));die();
		
		$data = json_decode($data); //convert from json
		return $data;
	}
	
	/* update data from  google */
 	public function sync()
    {
    	
	    if(isset($this->params['sync_id'])){
	    	$sync_id = $this->params['sync_id'];
	    }else{
			die('0');
	    }
    	
    	$ident = $this->Session->read('ident');
    	//Query for extsing data
    	$app = ClassRegistry::init('applications')->find('all', array(
		        'conditions' => array(
			        'identity_id' => $ident,
		    		'name' 	=> 		'1',
		    		'attached' => 	'1',
    				'id' => $sync_id,
    			),
    			'limit' => 1));
    	//did we find record?		
    	if(count($app) < 1){die('0');}
    	
    	//Pull in data again
    	$key = $app[0]['applications']['token'];
    	$secret = $app[0]['applications']['secret'];
    	$contacts = $this->OauthConsumer->get('Google', $key, $secret, 'https://www-opensocial.googleusercontent.com/api/people/@me');
		$data = json_decode($data);		//convert from json
		//save it
		$this->SyncManager->saveGoogle($data,'');
    	
    	return 1;	
    	die();
    }
    
    //Creates the identity
    public function create($data, $accessToken, $email)
    {
    	$lastname = $data->entry->name->familyName;
		$firstname = $data->entry->name->givenName;
		$pic = $data->entry->thumbnailUrl;
    	$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db    				
    	$userid = $user['User']['id'];
    	ClassRegistry::init('Identity')->set('user_id', $userid);
    	ClassRegistry::init('Identity')->set('first_name', $firstname);
    	ClassRegistry::init('Identity')->set('last_name', $lastname);
    	$tmp = explode('@',$email);
    	ClassRegistry::init('Identity')->set('nickname', $tmp[0]);
    	ClassRegistry::init('Identity')->set('name', $tmp[0].' G');
		ClassRegistry::init('Identity')->set('dob', date('Y-m-d'));
    	if(ClassRegistry::init('Identity')->save($this->data)) 
		{     
			$this->getIdentity();
			$ident = $this->Session->read('ident'); 
			$this->setDefault();
						
			//EmailZorz
			if($email != null )//checks if an email exists, if so adds it to the database
			{
				ClassRegistry::init('Email')->set('identity_id', $ident);
    			ClassRegistry::init('Email')->set('email', $email);
    			ClassRegistry::init('Email')->set('primary', 1);
    			ClassRegistry::init('Email')->set('valid', 1);  
	    		ClassRegistry::init('Email')->save($this->data) ;
			}
			if($pic != null )//checks if a picture exists, if so adds it to the database
			{
				ClassRegistry::init('Image')->set('identity_id', $ident);
    			ClassRegistry::init('Image')->set('name', 'Google Thumbnail for '.$firstname.$lastname);
    			ClassRegistry::init('Image')->set('url', $pic);  
    			ClassRegistry::init('Image')->set('added', date('Y-m-d H:i'));  
	    		if(ClassRegistry::init('Image')->save($this->data)) 
				{    
					//$this->saveApp($accessToken);
				}   
			}
			$this->saveApp($accessToken, $email);
			$this->Session->setFlash('Your profile has been created.');            
			$this->redirect('/profile/'.$ident);     
			exit;
		}    
    }
    
    //Creates a record in the application table with the access tokens 
    public function saveApp($accessToken, $email)
    {
    	$ident = $this->Session->read('ident');
    	
    	//check we don't already have this app connected
    	if($this->SyncManager->appExists($ident, $email, '1')){
    		$this->Session->setFlash('This appliction is already connected to your profile.');            
			$this->redirect('/profile/'.$ident);
    		break;
    	} 
    	
    	ClassRegistry::init('Application')->set('identity_id', $ident);
    	ClassRegistry::init('Application')->set('name', 1);
    	ClassRegistry::init('Application')->set('attached', 1);
    	ClassRegistry::init('Application')->set('account_identifier', $email);
    	ClassRegistry::init('Application')->set('token', $accessToken->key);
    	ClassRegistry::init('Application')->set('secret', $accessToken->secret);  
    	if(ClassRegistry::init('Application')->save($this->data)) 
		{    
			$this->Session->setFlash('Your application has been updated.');            
			$this->redirect('/profile/'.$ident);
			exit;
		}   
    	
    }
    

}