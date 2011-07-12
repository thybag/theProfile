<?php
/**
 * Twitter class, this handles all of the google information,
 * 
 * @author Michael Pontin
 * @created Jan 5 2011
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class TwitterController extends AppController {
    public $uses = array();
    public $components = array('OauthConsumer','SyncManager');
	
    //Authenticates with Google
    public function index() 
    {
        //Google OAuth
		$requestToken = $this->OauthConsumer->getRequestToken('Twitter', 'https://api.twitter.com/oauth/request_token', 'http://theprofile.co.uk/twitcallback' );
        $this->Session->write('requestToken', $requestToken);
        $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token='.$requestToken->key);
    }
    
    //Once authenticated this method requests the actuall user data
    public function callback() 
    {
        $requestToken = $this->Session->read('requestToken');
        $accessToken = $this->OauthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);    
        $this->Session->write('accesstoken', $accessToken); 
    	if(!isset($accessToken->key))
    	{
    		$this->Session->setFlash('Something went wrong on Twitters end... Maybe they will be less cranky later!');
    		$this->redirect('/create');
    	}
		$data = $this->OauthConsumer->get('Twitter', $accessToken->key, $accessToken->secret, 'http://api.twitter.com/1/account/verify_credentials.json');
		$data = json_decode($data);		//convert from json
		$uid = $data->id; 
    	
		$this->SyncManager->saveTwitter($data);
		$this->saveApp($accessToken,$data->screen_name);
		
    }
    
    public function saveApp($accessToken,$account_id)
    {
		$ident = $this->Session->read('ident'); 
		
		//check we don't already have this app connected
    	if($this->SyncManager->appExists($ident, $account_id, '2')){
    		$this->Session->setFlash('This application is already connected to your profile.');            
			$this->redirect('/profile/'.$ident);
    		break;
    	} 
    	ClassRegistry::init('Application')->set('identity_id', $ident);
    	ClassRegistry::init('Application')->set('name', 2);
    	ClassRegistry::init('Application')->set('attached', 1);
    	ClassRegistry::init('Application')->set('account_identifier', $account_id);
    	ClassRegistry::init('Application')->set('token', $accessToken->key);
    	ClassRegistry::init('Application')->set('secret', $accessToken->secret);  
    	if(ClassRegistry::init('Application')->save($this->data)) 
		{    
			$this->Session->setFlash('Your application has been updated.');            
			$this->redirect('/profile/'.$ident);
			exit;   
		}   
    }
    /* Syncronise with account
     * 
     * 
     */
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
		    		'name' 	=> 		'2',
		    		'attached' => 	'1',
    				'id' => $sync_id,
    			),
    			'limit' => 1));
    			
    	//did we find record?		
    	if(count($app) < 1){
    		die('0');
    	}
    	
    	//Pull in data again
    	$key = $app[0]['applications']['token'];
    	$secret = $app[0]['applications']['secret'];
    	$data = $this->OauthConsumer->get('Twitter', $key, $secret, 'http://api.twitter.com/1/account/verify_credentials.json');
		$data = json_decode($data);		//convert from json
		//save it
		$this->SyncManager->saveTwitter($data);

    	die('1');
    }
    //Creates the identity
    public function create($data)
    {
    	  
    }
    
    //Stores the new identity id in the session
    public function getIdentity()
    {
    	$ident = ClassRegistry::init('Identity')->id;
    	$this->Session->write('ident', $ident);
    }
}