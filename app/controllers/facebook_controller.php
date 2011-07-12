<?php
/**
 * Facebook class, this handles all of the facebook information,
 * 
 * @author Michael Pontin, Carl Saggs
 * @created Jan 5 2011
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class FacebookController extends AppController {

	public $uses = array();
	var $components = array('Facebook','SyncManager');
	
    public function index() 
    {
    	$this->Facebook;
    	$facebook = $this->Facebook->main();
		$session = $facebook[1];
		$me = $facebook[2];		
    	
		$first = $me[0]['first_name'];
    	$last = $me[0]['last_name'];
    	if($me[0]['birthday_date'] != '' AND $me[0]['birthday_date'] != null){
    		$dob =  date('Y-m-d',strtotime($me[0]['birthday_date']));
    	}else{
    		$dob = '';
    	}
    	$email = $me[0]['email'];
    	$uid = $me[0]['uid'];
    	//Check these exist
    	$tagline = (isset($me[0]['about_me']) AND $me[0]['about_me'] != null ) ? $me[0]['about_me'] : '';
    	$nickname = (isset($me[0]['username']) AND $me[0]['username'] != null) ? $me[0]['username'] : '';
    	$gender = (isset($me[0]['sex']) AND $me[0]['sex'] != null) ? $me[0]['sex'] : '';
    	//debug
    	$debug = $me[0]['first_name'].': '.$me[0]['birthday_date'].' '.$me[0]['birthday'].' '.$dob;
    	
    	$sig = $session['sig'];
    	$token = $session['access_token'];
    	$pic = 'https://graph.facebook.com/'.$uid.'/picture';
   	 	if($this->Session->check('create')) //only runs the create variable is set
		{
			$this->create($first, $last, $dob, $pic, $email, $uid, $nickname, $gender, $tagline, $sig, $token);
		}
		else
		{
			$this->SyncManager->saveFacebook($first, $last, $dob, $pic, $email, $uid, $nickname, $gender, $tagline);
			$this->saveApp($session, $nickname);
		}
    	
    }
    
	//Creates the identity
    public function create($first, $last, $dob, $pic, $email, $uid, $nickname, $gender, $tagline, $sig, $token)
    {		
    	$user = ClassRegistry::init('User')->findByUsername($this->Session->read('user')); //add the userid to the db    				
    	$userid = $user['User']['id'];
    	ClassRegistry::init('Identity')->set('user_id', $userid);
    	ClassRegistry::init('Identity')->set('first_name', $first);
    	ClassRegistry::init('Identity')->set('last_name', $last);
    	
    	$title = ($nickname == '') ? 'Facebook' : $nickname.' FB';
    	ClassRegistry::init('Identity')->set('name', $title);
    	ClassRegistry::init('Identity')->set('nickname', $nickname);
    	ClassRegistry::init('Identity')->set('gender', ucfirst($gender));
    	ClassRegistry::init('Identity')->set('tagline', $tagline);
    	if($dob != ''){
			ClassRegistry::init('Identity')->set('dob',	$dob);
    	}
    	if(ClassRegistry::init('Identity')->save($this->data)) 
		{     
			$this->getIdentity();
			$ident = $this->Session->read('ident'); 
			$this->setDefault();
			
			//set that they are using facebook in the app table
			ClassRegistry::init('Application')->set('identity_id', $ident);
    		ClassRegistry::init('Application')->set('name', 0);
    		ClassRegistry::init('Application')->set('attached', 1);  
    	 	ClassRegistry::init('Application')->set('token', $token);
    	 	ClassRegistry::init('Application')->set('account_identifier', $nickname);
    		ClassRegistry::init('Application')->set('secret', $uid);
    		ClassRegistry::init('Application')->set('sig', $sig);	    
    		if(ClassRegistry::init('Application')->save($this->data)) 
			{    
				$this->Session->setFlash('Your application data has been updated.');       
			}   
			if($pic != null )//checks if a picture exists, if so adds it to the database
			{
				ClassRegistry::init('Image')->set('identity_id', $ident);
    			ClassRegistry::init('Image')->set('name', 'Facebook Thumbnail for '.$first.$last);
    			ClassRegistry::init('Image')->set('url', $pic);
    			ClassRegistry::init('Image')->set('added', date('Y-m-d H:i'));  
	    		if(ClassRegistry::init('Image')->save($this->data)) 
				{    
					$this->Session->setFlash('Your profile picture has been updated.');       
				}   
			}
			if($email != null )//checks if an email exists, if so adds it to the database
			{
				ClassRegistry::init('Email')->set('identity_id', $ident);
    			ClassRegistry::init('Email')->set('email', $email);
    			ClassRegistry::init('Email')->set('primary', 1);
    			ClassRegistry::init('Email')->set('valid', 1);  
	    		if(ClassRegistry::init('Email')->save($this->data)) 
				{    
					$this->Session->setFlash('Your profile has been created.');            
					$this->redirect('/profile/'.$ident);
				}   
			}
			$this->Session->setFlash('Your profile has been created.');            
			$this->redirect('/profile/'.$ident);     
		}    
    }
   
	
	
 	//Creates a record in the application table with the access tokens 
    public function saveApp($session, $nickname)
    {
    	$ident = $this->Session->read('ident');
    	
    	//check we don't already have this app connected
    	if($this->SyncManager->appExists($ident, $nickname, '0')){
    		$this->Session->setFlash('This appliction is already connected to your profile.');            
			$this->redirect('/profile/'.$ident);
    		break;
    	} 
    	// if not, add it :)
    	ClassRegistry::init('Application')->set('identity_id', $ident);
    	ClassRegistry::init('Application')->set('name', 0);
    	ClassRegistry::init('Application')->set('attached', 1);
    	ClassRegistry::init('Application')->set('account_identifier', $nickname);
    	ClassRegistry::init('Application')->set('token', $session['access_token']);
    	ClassRegistry::init('Application')->set('secret', $session['uid']); //not sure about these values
    	ClassRegistry::init('Application')->set('sig', $session['sig']); //not sure about these values    
    	if(ClassRegistry::init('Application')->save($this->data)) 
		{    
			$this->Session->setFlash('Your application has been updated.');            
			$this->redirect('/profile/'.$ident);
		}   
    	
    }
	
	
	/* Depresiated functions - code moved to app_sync
    public function saveSync($first, $last, $dob, $pic, $email, $uid)
    {
    	$ident = $this->Session->read('ident');
    	$mrarray = array();
    	$mrarray[] = $this->syncSave('forname',$first,	$ident);
    	$mrarray[] = $this->syncSave('surname',	$last,	$ident);
    	$mrarray[] = $this->syncSave('dob',		$dob,	$ident);
    	$mrarray[] = $this->syncSave('avatar',	$pic,	$ident);
    	$mrarray[] = $this->syncSave('email',	$email,	$ident);
    	
    	ClassRegistry::init('app_sync')->saveAll($mrarray);
    }
    
    private function SyncSave($name,$value,$id){
    	//Load current data - ether overwrite or create new
    	//if change set synced to 1.
    	
    	//Query for extsing data
    	$dataz = ClassRegistry::init('app_sync')->find('all', array(
		        'conditions' => array(
			        'identity_id' => $id,
		    		'data_name' 	=> $name,
		    		'datasource' => 'facebook',
    			),
    			'limit' => 1));

    	//if not found add new data as none sycned
    	if(count($dataz[0]['app_sync']) < 1){
    		
    		return array('identity_id' => $id,
    				'datasource' => 'facebook',
    				'data_name' => $name,
    				'data_value' => $value,
    				'synced' => 0   	
    				);
    	}
    	
    	//Its found, see if its changed
    	if(($dataz[0]['app_sync']['data_value']!== $value) OR ($dataz[0]['app_sync']['synced']==0)){
    		$synced = 0; // its outa sync, so set zero
    	}else {
	    	$synced = 1;
    	}
    	//return with id to overwrite
 
    	
    	return array('id' => $dataz[0]['app_sync']['id'],
    				'identity_id' => $id,
    				'datasource' => 'facebook',
    				'data_name' => $name,
    				'data_value' => $value,
    				'synced' => $synced   	
    				);
    			
    }
    */
    
	public function sync()
    {
    	// $this->getFacebookSession fails hard. SO far have yet to figure out a fix
    	
    	//Mike?
    	
    	die(0);
    	/*
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
		    		'name' 	=> 		'0',
		    		'attached' => 	'1',
    				'id' => $sync_id,
    			),
    			'limit' => 1));
    			
    	//did we find record?		
    	if(count($app) < 1){
    		die('0');
    	}

    	$fb_data = $this->getFacebookSession($app[0]['applications']['token'],$app[0]['applications']['secret'],$app[0]['applications']['sig']);	
    	
    	print_r($fb_data);
    	
    	die();
    	
    	
    	
    	//Pull in data again
    	$key = $app[0]['applications']['token'];
    	$secret = $app[0]['applications']['secret'];
    	$data = $this->OauthConsumer->get('Twitter', $key, $secret, 'http://api.twitter.com/1/account/verify_credentials.json');
		$data = json_decode($data);		//convert from json
		//save it
		$this->SyncManager->saveTwitter($data);

    	die('1');
    	*/
    }
    
    
    public function getFacebookSession($token, $uid, $sig)
    {
    	$this->Facebook;
    	$data = array( 'acess_token' => $token, 'uid' => $uid, 'sig' => $sig );
    	$facebook = $this->Facebook->main($data);
    	return $facebook;    	//should return user session
    }

}
