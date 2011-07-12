<?php
/**
 * User class, this handles all of the user information,
 * including creation of account
 *
 * @author Michael Pontin, Carl Saggs and David Couch
 * @created Nov 09 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 *
 */
class UsersController extends AppController {

	var $components = array('Email', 'Facebook', 'OauthConsumer');
	var $helpers = array('Html', 'Form', 'Ajax');
	var $name = 'Users';

	/**
	 * Registers a new user
	 */
	function register()
	{
		if (!empty($this->data))//checks that the data is entirely empty
		{
			$this->User->set(($this->data));
			if($this->User->validates())//validates the data with the rules set in the model
			{
				$this->data['User']['password'] = Security::hash($this->data['User']['password']); //hash the password
				$this->data['User']['password_confirm'] = Security::hash($this->data['User']['password_confirm']);  //hash the confirm password otherwise it errors
				$code = substr(md5(uniqid(mt_rand(), true)), 0, 25); //create a random string
				$this->data['User']['activation_code'] = $code; //save code to database
				if($this->User->save($this->data))//saves the data to the database
				{
					$this->flash('Your registration information was accepted.', '/users/register');
					$this->send($this->data['User']['email'], $code);
					$this->redirect('/activation');
					exit;
				}
			}
		}
	}

	/**
	 * ajax check to see if the username has been used
	 */
	function ajax_check()
	{
		if(!empty($_POST['username']))
		{			
			$username = $this->User->findByUsername($_POST['username']);
			if(!$username) {
				echo 1; exit;
			} else {
				echo 0; exit;
			}
		}
		else
		{
			echo 0; exit;
		}
	}


	/**
	 * Displays the main page, requires a user session
	 */
	function index()
	{
		if($this->Session->check('user'))
		{
			$this->Session->write('create', true );
			$user = $this->User->findByUsername($this->Session->read('user'));
			$this->set('knownuser', $user);
			$oneid = ClassRegistry::init('Identity')->findByUserId($user['User']['id']);
			$this->set('hasIdent', $oneid );//check to see if they have an identity associated with the account yet
			//checks to see if they have added facebook
			if($oneid)
			{
				$hasFB = ClassRegistry::init('Application')->query("SELECT * FROM `applications` WHERE identity_id = ".$oneid['Identity']['id']." AND name = 0;");
				$this->set('hasFB', $hasFB);
				//checks to see if they have added Google
				$hasG = ClassRegistry::init('Application')->query("SELECT * FROM `applications` WHERE identity_id = ".$oneid['Identity']['id']." AND name = 1;");
				$this->set('hasG', $hasG);
			}
			$this->set('identities', $user['Identity'] );
			//Facebook GraphAPI
			$this->Facebook;
			$facebook = $this->Facebook->main();
			$this->set('facebook', $facebook[0]);
			$this->set('session', $facebook[1]);
			$this->set('me', $facebook[2]);
		}
		else
		{
			$this->redirect('login'); //if not logged in, redirect
			exit;
		}
	}
	
	/**
	 * Used to reset a password on a users account
	 */
	function reset()
	{
		if(isset($this->data['User']['user']))
		{
			$user = $this->User->findByUsername($this->data['User']['user']);
			if($user) //check the user exists
			{
				if($user['User']['email'] != '' ) //check an e-mail address is attached to the account
				{
					$rand = substr(sha1(uniqid(mt_rand(), true)), 0, 8); //create a random password
					$this->User->id = $user['User']['id']; //set the user object
					$this->data['User']['password'] = Security::hash($rand);
					$this->data['User']['password_confirm'] = Security::hash($rand); //validation error if this does not get set
					$this->User->set('password', Security::hash($rand)); //saves the new password to the database
					$this->User->save($this->data);
					$this->sendReset($user['User']['email'],$rand); //sends the e-mail out to the user
					$this->Session->setFlash('An e-mail containing your new password has been sent to you');
					$this->redirect('/login'); //redirects to login, so that they can login
					exit;
				}
				$this->Session->setFlash('There is no e-mail address associated with your account, please contact support');
				$this->redirect('/reset');
				exit;
			}
			$this->Session->setFlash('The username you provided does not exist');
			$this->redirect('/reset');
			exit;
		}
	}
	
	/**
	 * Method used to redirect back to 'home page' making sure they have an identity
	 */	
	function changepath()
	{
		if($this->Session->check('user'))
		{
			$user = $this->User->findByUsername($this->Session->read('user'));
			if($user['Identity'][0]['id'])
			{
				$this->redirect('/profile/'.$user['Identity'][0]['id']);
			}
			else
			{
				$this->redirect('/create');
			}
		}
		else
		{
			$this->redirect('/');
		}
		exit;
	}

	/**
	 * Login for the user
	 */
	function login()
	{
		$user = $this->User->findByUsername($this->data['User']['username']);
		if(!empty($this->data))
		{
			if($user['User']['activated'] == 1 )
			{
				if($user['User']['password'] == Security::hash($this->data['User']['password']))
				{
					$this->Session->write('user', $this->data['User']['username']);
					$this->flash('Welcome back.', '/users/index');
					$this->changePath();
					exit;
				}
				else
				{
					$this->Session->setFlash('Login details are incorrect');
				}
			}
			else
			{
				$this->Session->setFlash('Your account is not active');
			}
		}
	}

	/**
	 * Logout the user by destroying the session
	 */
	function logout()
	{
		$this->Session->destroy('user');
		$this->Session->setFlash('You\'ve successfully logged out.');
		$this->redirect('/');
		exit;
	}

	/**
	 * method to edit a user's account
	 */
	function edit()
	{
	
		$user = $this->User->findByUsername($this->Session->read('user')); //collects the users model information
		$oneid = ClassRegistry::init('Identity')->findByUserId($user['User']['id']);
		$this->set('hasIdent', $oneid );//check to see if they have an identity associated with the account yet
		$this->set('default', $user['User']['profile_default']);
		$this->set('privacy', $user['User']['privacy']);
		$this->set('identities', $user['Identity'] );
		if($this->data != NULL) //checks to see if the form has been submitted
		{
			$this->User->id = $user['User']['id']; //set which user is being changed
			if(Security::hash($this->data['User']['current_password']) == $user['User']['password']) //checks the old password matches
			{
				$this->User->set(($this->data)); //make sure the model has been set with the data
				if($this->User->validates()) //validates the password against the db validators
				{
					$this->data['User']['password'] = Security::hash($this->data['User']['password']); //hash the password
					$this->data['User']['password_confirm'] = Security::hash($this->data['User']['password_confirm']);  //hash the confirm password otherwise it errors
					$data = $this->sanitizeIt($this->data);
					if($this->User->save($data))//saves the data to the database
					{
						$this->Session->setFlash('Your password has been updated.');
						$this->redirect('/profile/'.$this->Session->read('ident')); //redirects the user back to their homepage
						exit;
					}
					else
					{
						$this->Session->setFlash('Your password could not be changed, please try again.');
					}

				}
			}
			else
			{
				$this->Session->setFlash('Password details are incorrect');
			}
		}
	}

	/**
	 * Set the default profile to be used
	 */
	function set_default()
	{
		$user = $this->User->findByUsername($this->Session->read('user')); //collects the users model information
		if($this->data != NULL) //checks to see if the form has been submitted
		{
			$this->User->id = $user['User']['id']; //set which user is being changed
			$this->User->set(($this->data)); //make sure the model has been set with the data
			if($this->User->validates()) //validates the password against the db validators
			{
				if($this->User->save($this->data))//saves the data to the database
				{
					$this->Session->setFlash('Your default profile has been updated.');
					$this->redirect('/profile/'.$this->Session->read('ident')); //redirects the user back to their homepage
					exit;
				}
				else
				{
					$this->Session->setFlash('Your default profile could not be changed, please try again.');
				}
			}
		}
	}
	
	/**
	 * Set the profile privacy setting
	 */
	function set_priv()
	{
		$user = $this->User->findByUsername($this->Session->read('user')); //collects the users model information
		if($this->data != NULL) //checks to see if the form has been submitted
		{
			$this->User->id = $user['User']['id']; //set which user is being changed
			$this->User->set(($this->data)); //make sure the model has been set with the data
			if($this->User->validates()) //validates the password against the db validators
			{
				if($this->User->save($this->data))//saves the data to the database
				{
					$this->Session->setFlash('Your privacy settings have been updated.');
					$this->redirect('/profile/'.$this->Session->read('ident')); //redirects the user back to their homepage
					exit;
				}
				else
				{
					$this->Session->setFlash('Your privacy settings could not be changed at this time.');
				}
			}
		}
	}
	/**
	 * method to delete a user's account
	 */
	function delete() {

	}
	
	/**
	 * Sends an account welcome e-mail along with an acitvation code
	 */
	function send($email, $code)
	{
		$data = $code;
		$this->set('data', $data);
		$this->Email->to = $email;
		$this->Email->subject = 'Your New Account';
		// $this->Email->attach($fully_qualified_filename, optionally $new_name_when_attached);
		// You can attach as many files as you like.
		$result = $this->Email->send();
		return $result;
	}
	
	/**
	 * Sends a password reset e-mail
	 */
	function sendReset($email, $pass)
	{
		$this->Email->template = 'email/reset';
		$this->set('data', $pass);
		$this->Email->to = $email;
		$this->Email->subject = "Your New Password";
		return $this->Email->send();
	}
	/**
	 * Activate the users account and then log them in
	 */
	function activate()
	{	
		if(array_key_exists('code', $this->params['url']))//check to see if the code has been submitted
		{
			$code = $this->params['url']['code'];
			if($code != null || $code != '')
			{
				$code = str_replace(' ', '', $code);
				$user = $this->User->findByActivation_code($code);
				if(!$user)
				{
					$this->Session->setFlash('The code you supplied is incorrect');
					$this->redirect('/activation');					
					exit;
				}
				$this->User->id = $user['User']['id']; //set which user is being changed
				if($user['User']['activated'] == 1) //checks to see if the account is already active
				{
					$this->Session->setFlash('The code you supplied is no longer active');
					$this->redirect('/activation');					
					exit;
				}
				$this->data['User']['activated'] = 1;
				$this->User->set(($this->data)); //make sure the model has been set with the data
				if($this->User->save($this->data))//saves the data to the database
				{
					$this->Session->write('user', $user['User']['username']);
					$this->redirect('/gettingstarted');
					exit;
				}
			}
		}

		
	}
	function profile($username)
	{
		$user = $this->User->findByUsername($username);
		$this->set('user_exists',(!empty($user)));
		$this->set('knownuser', $user);
	}
	
	/**
	 * Returns all of the viewable data on a user
	 */
	function viewableData($username)
	{
		$user = $this->User->findByUsername($username);
		$def = $user['User']['profile_default'];
		$identity = ClassRegistry::init('Identity')->findById($def);
		
		if(isset($identity['Identity']['nickname'])){
			$data['nickName'] = $identity['Identity']['nickname'];
		}
		//0 = public
		//1 = private
		if($user['User']['privacy'] == 0){
			if(isset($identity['Identity']['title'])){
				$data['title'] = $identity['Identity']['title'];
			}
			if(isset($identity['Identity']['first_name'])){
				$data['firstname'] = $identity['Identity']['first_name'];
			}
			if(isset($identity['Identity']['last_name'])){
				$data['lastname'] = $identity['Identity']['last_name'];
			}
			if(isset($identity['Identity']['dob'])){
				$data['dateOfBirth'] = $identity['Identity']['dob'];
			}
			if(isset($identity['Identity']['gender'])){
				$data['gender'] = $identity['Identity']['gender'];
			}
			if(isset($identity['Email']['0']['email'])){
				$data['email'] = $identity['Email']['0']['email'];
			}
			$images = $this->array_sort($identity['Image'], 'added', SORT_DESC); // make sure you are using the newest image		
			$image = array_shift($images); //gets the first image from the array (the newest image)
			if(isset($image['url']))
			{
		 		$data['imageURL'] = $image['url'];
			}
			elseif(isset($image['name']))
			{
				$data['imageURL'] = 'http://theprofile.co.uk/img/uploads/'.$image['name'];
			}
		}
		return $data;
	}
	/**
	* Display json/xml feed of user for API data
	*/
	function api($username)
	{
		
		if(!isset($this->params['type'])){
			$type='xml';
		}else{
			$type = $this->params['type'];
		}
		
		$name = $this->params['username'];
		$data = $this->viewableData($name);	
		if($type=='json'){
			header("Content-Type:application/json");
			echo "{";
			echo '"user": {';
			foreach($data as $k => $v )
			{
				echo '"'.$k.'": "'.$v.'", ';
			}
			echo '"datasource": "theprofile.co.uk"';
			echo "}";
			
			echo "}";
			
			
			}
			else{
				header ("Content-Type:text/xml");
				echo "<?xml version='1.0'?>";
				echo "<user>";
				foreach($data as $k => $v )
				{
					echo '<'.$k.'>'.$v.'</'.$k.'>';
				}
				echo "</user>";
			}
			exit;	
	}
	/**
	* gets flash
	*/
	public function getFlash(){
		$this->layout = 'ajax';
		
	}
}