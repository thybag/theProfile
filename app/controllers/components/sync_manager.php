<?php
/**
 * Sync Manager Component
 * Provides functions needed to save data from Facebook, Twitter, OpenID and Google for mergeing
 * 
 * @author Carl Saggs (cs305@kent.ac.uk)
 * @version 1.6
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 *
 */

class SyncManagerComponent extends Object {
	
	//Import session object
	var $components = array('Session');
	
	/**
	 * App Exists
	 * Check to see if this account is already added to a given profile
	 * 
	 * @access public
	 * @param int $profile_id Identity id of current profile
	 * @param String $identifier Identifies this account on an app
	 * @param int $appType Identifies type of app (fb/twitter/etc)
	 */
	public function appExists($profile_id, $identifier, $appType){
		//Find out if an app with this name and identifier exist on the profile
		$app = ClassRegistry::init('Application')->find(
			'all', array(
				'conditions' => array(
					'identity_id' => $profile_id,
					'account_identifier' => $identifier,
					'name' => $appType,
				),
	    		'limit' => 1)
			);
  		//return true if app was found, false otherwize
   		return (count($app) > 0);		
	}
	
	/**
	 * SaveOpenID
	 * Adds data from OpenID to app sync
	 * 
	 * @access public
	 * @param String $first Users first name
	 * @param String $last Users last name
	 * @param String $gender Users gender
	 * @param String $dob Users date of birth
	 * @param String $email users email
	 * @param String $nick Users online handle
	 */
	public function saveOpenID($first, $last, $gender, $dob, $email, $nick){
		//get current profile id
		$ident = $this->Session->read('ident');
		$acc_id = 'OpenID';
		
		$mrarray = array();
		//If nick is set, use it as the identifer for this app.
		if($nick != null){
			$acc_id = 'OpenID_'.$nick;
			//Add nickname save row to save array
			$mrarray[] = $this->saveFormat('nickname', $nick, $ident, $acc_id);
		}
		//Add name save rows to save array if it exists
		if($first != null){
			$mrarray[] = $this->saveFormat('first_name',$first,	$ident, $acc_id);
			$mrarray[] = $this->saveFormat('last_name',	$last, $ident, $acc_id);
		}
		//Add gender save row to save array if it exists
		if($gender != null){
			//fix format
			if($gender=='m' OR $gender=='M'){$gender = 'Male';}
			if($gender=='f' OR $gender=='F'){$gender = 'Female';}
			$mrarray[] = $this->saveFormat('gender',ucfirst($gender), $ident, $acc_id);
		}
		//Add new email row to save array if it exists
		if($email != null){
			$mrarray[] = $this->saveFormat('email',	$email,	$ident, $acc_id);
		}
		//Same again with dob
		if($dob != null){
			$mrarray[] = $this->saveFormat('dob', $dob,	$ident, $acc_id);
		}
		//Save the array to the DB
		ClassRegistry::init('appsync')->saveAll($mrarray);
	}
	
	/**
	 * SaveTwitter
	 * Adds data from Twitter to app sync
	 * 
	 * @access public
	 * @param Array $data Twitter user data
	 */
	public function saveTwitter($data){
		//Get Identity
		$ident = $this->Session->read('ident');
		//create UID/identifier for app
		$app_uid = 'twitter_'.$data->screen_name;
		
		//Add stuff to sync arrays
		$mrarray = array();
		$mrarray[] = $this->saveFormat('tagline', $data->description, $ident, $app_uid );
		$mrarray[] = $this->saveFormat('nickname', $data->screen_name, $ident, $app_uid );
		$mrarray[] = $this->saveFormat('avatar', $data->profile_image_url, $ident, $app_uid );
		$mrarray[] = $this->saveFormat('language', $data->lang, $ident, $app_uid );
		$mrarray[] = $this->saveFormat('timezone', $data->time_zone, $ident, $app_uid );
		
		//Get first/last names from full name
		$twitter_name = explode(' ', $data->name);
		$mrarray[] = $this->saveFormat('first_name', $twitter_name[0], $ident, $app_uid );
		$mrarray[] = $this->saveFormat('last_name',	array_pop($twitter_name), $ident, $app_uid );
		
		//Save it all
		ClassRegistry::init('appsync')->saveAll($mrarray);
	
	
	}
	
	/**
	 * SaveGoogle
	 * Adds data from Google to app sync
	 * 
	 * @access public
	 * @param Array $data Google user data
	 * @param String $email User email
	 */
	public function saveGoogle($data, $email){
		$ident = $this->Session->read('ident');
		
		$app_uid = 'google';
		
		$mrarray = array();
		//If email exist's
		if($email != ''){
			//split email and use front half as nick.
			$tmp = explode('@',$email);
			//Use nick to create UID/ identifier
			$app_uid = 'google_'.$tmp[0];
			//add to arrays
			$mrarray[] = $this->saveFormat('email', $email, $ident, $app_uid);
			$mrarray[] = $this->saveFormat('nickname', $tmp[0], $ident, $app_uid);
		}
		//Check values are set
		$first_name 	= (isset($data->entry->name->givenName) AND $data->entry->name->givenName != null) ? $data->entry->name->givenName : '';
		$last_name 		= (isset($data->entry->name->familyName) AND $data->entry->name->familyName != null) ? $data->entry->name->familyName : '';
		$avatar 		= (isset($data->entry->thumbnailUrl) AND $data->entry->thumbnailUrl != null) ? $data->entry->thumbnailUrl : '';
		
		//add other data
		$mrarray[] = $this->saveFormat('first_name', $first_name, $ident, $app_uid);
		$mrarray[] = $this->saveFormat('last_name',	$last_name,	$ident, $app_uid);
		$mrarray[] = $this->saveFormat('avatar', $avatar, $ident, $app_uid);
		//Save it all
		ClassRegistry::init('appsync')->saveAll($mrarray);
	}
	
	/**
	 * SaveFacebook
	 * Adds data from Facebook to app sync
	 * 
	 * @access public
	 * @param String $first Users first name
	 * @param String $last Users last name
	 * @param String $dob Users date of birth
	 * @param String $pic Avatar location
	 * @param String $email users email
	 * @param String $uid Facebook account id
	 * @param String $nickname users online handle
	 * @param String $gender Users gender
	 * @param String $tagline user BIO
	 */
	public function saveFacebook($first, $last, $dob, $pic, $email, $uid, $nickname, $gender, $tagline)
	{
		//Get session ID
		$ident = $this->Session->read('ident');
		//set app UID
		$app_uid = 'facebook';
		
		//If nickname was found create app UID useing it
		if($nickname != null && $nickname != ''){ $app_uid = 'facebook_'.$nickname ;}
		
		$mrarray = array();
		//Add data to save array
		$mrarray[] = $this->saveFormat('nickname', $nickname,$ident, $app_uid);
		$mrarray[] = $this->saveFormat('first_name', $first,$ident, $app_uid);
		$mrarray[] = $this->saveFormat('last_name',	$last,$ident, $app_uid);
		
		//if DOB is set, add it to sync array
		if($dob != ''){
			$mrarray[] = $this->saveFormat('dob',$dob,$ident, $app_uid);
		}
		
		//add rest of data to array
		$mrarray[] = $this->saveFormat('avatar', $pic, $ident, $app_uid);
		$mrarray[] = $this->saveFormat('email',	$email,	$ident, $app_uid);
		$mrarray[] = $this->saveFormat('gender', ucfirst($gender), $ident, $app_uid);//ucfirst so it matchs what we use
		$mrarray[] = $this->saveFormat('tagline',$tagline, $ident, $app_uid);
		
		//Save it
		ClassRegistry::init('appsync')->saveAll($mrarray);
	}
    
    /**
	 * SaveFormat
	 * Creates a appSync record array to add to save arrays
	 * 
	 * @access public
	 * @param String $name Data feild name
	 * @param String $value Data feilds value
	 * @param String $id Current profile/identities ID
	 * @param String $source UID/Identifier for profile
	 * @return Array Cake formatted record array
	 */
	private function saveFormat($name,$value,$id, $source){
  
		//Attempt to grab this record from the appsync db
		$dataz = ClassRegistry::init('appsync')->find(
			'all', array(
				'conditions' => array(
					'identity_id' => $id,
					'data_name' 	=> $name,
					'datasource' => $source,
				),
			'limit' => 1)
		);

		//if record is not found, return array to add record as new
		if(count($dataz[0]['appsync']) < 1){
			return array(
				'identity_id' => $id,
				'datasource' => $source,
				'data_name' => $name,
				'data_value' => $value,
				'synced' => 0   	
			);
		}
		
		//If data is found
		//See if the new version matches what we already have in our cached copy
		//If it matches, then leave the sync status as done, 
		//if its changed set it to 0 to indicate it needs syncing
		if(($dataz[0]['appsync']['data_value']!== $value) OR ($dataz[0]['appsync']['synced']==0)){
			$synced = 0; // its outa sync, so set zero
		}else {
			$synced = 1;
		}
		
		//Use ID of record we are updating so it overwrites the previous
		//instead of adding a new one.
		return array(
    		'id' => $dataz[0]['appsync']['id'],
			'identity_id' => $id,
			'datasource' => $source,
			'data_name' => $name,
			'data_value' => $value,
			'synced' => $synced   	
		);			
	}
}