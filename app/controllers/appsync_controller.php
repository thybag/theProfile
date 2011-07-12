<?php
/**
 * Application Synchronization Controller
 * Provides a set of functions to enable users to merge data imported from connected applictions.
 * 
 * @author Carl Saggs (cs305@kent.ac.uk)
 * @created Feb 16 2011
 * @version 1.7
 * @package theProfile
 *
 */

class AppsyncController extends AppController {


	/**
	 * An array of all currently synchronizable profile data items. (Emails and other special case items are handled by an alternate function)
	 * @access public
	 * @var array|string
	 */
	public $merge_records = array('title','first_name','last_name','nickname','dob','gender','language','tagline','timezone');
	
	/**
	 * An array used to store a list of unique emails that need to be auto-merged with the current profile.
	 * @access private
	 * @var array
	 */
	private $emailList = array();
	
	/**
	 * Index. This function is unused and simply here to catch any lost users.
	 * 
	 * @access public
	 * 
	 */
	public function index() 
	{    	
		//Send user back to their profile.					
		$this->redirect('/profile/'.$ident);
	}
	
	/**
	 * Check function
	 * Determines whether or not the currently open identity needs to merge any data.
	 * Will attempt to auto merge data if possible.
	 * 
	 * @access public
	 *
	 * Will output text "1" if there is data to merge.
	 * Will output text "0" if there is no data to merge.
	 */
	public function check(){
		
		// Ensure this page does not get cached (I'm looking at your Internet Explorer)
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
		
		//Check the user's session exists. If not stop running and display 0.
		if(!$this->Session->check('ident')){ die('0'); }
		
		//Get current identity Id from User session.
		$ident = $this->Session->read('ident');
		
		//Check to see if we have any unsynced record's in the AppSync controller, that belong 
		//to the current identity. 
		$dataz = $this->Appsync->find('all', array(
			'conditions' => array(
				'identity_id' => $ident,
		    	'synced' 	=> '0'
    		),
    		'limit' => 1)); //Add limit 1 so we don't query unnessessry data.
    			
		//If records returned is less than 1, then no data needs sync-ing. Display 1
		if(count($dataz) < 1){	
			echo 0;
		}else{
			//Data is found, attempt to auto sync
			//PreMergeProccess returns true if merge is still needed after auto sync
			if($this->preMergeProccess($ident)){
				echo 1; //if merge is needed.
			}else{ 
				echo 0; //if merge isnt needed
			}
		}
		//Die now since we already outputted everything we need.		
		die();
	}
	
	/**
	 * PreMergeProccess
	 * Loads unsynchronized data and format it correctly, before passing to autoMergeing functions.
	 *
	 * @access private
	 * @param int $ident ID of current Identity
	 * @return Boolean Returns true if there is data that requires a manual merge.
	 * 
	 */
	private function preMergeProccess($ident){
	
		//Load all currently unsynced data from the AppSync db for the identity $ident
		$dataz = $this->Appsync->find('all', array(
			'conditions' => array(
				'identity_id' => $ident,
				'synced' 	=> '0'
    		)));
				
		//Proccess data cleans up the array for use in the later functions
		$formatted = $this->proccessData($dataz);
		
		//Attempt to auto add any new emails
		$this->addEmails($ident);
		
		//Load details currently set to this identity
		$current = ClassRegistry::init('Identity')->findById($ident);
		
		//Return result of lookForDifference function
		return $this->lookForDifference($formatted,$current['Identity'],$ident);	
	}
	
	/**
	 * proccessData
	 * Takes cake database array and formats it for use by merge functions
	 *
	 * @access private
	 * @param Array $data Cake DB output array
	 * @Return Array Processed array (A multi level array useing that uses
	 * syncable feilds as its index, each containing an array of all the values
	 * for that feild that could be found in the cake Array
	 * 
	 */
	private function proccessData($data){
		//Create new blank array
		$ident_array = array();
		
    	//Loop through every item in $data
    	foreach($data as $itm){
    		
			//Grab the appsync array
			$itm = $itm['Appsync']; 
			//Foreach of the syncable feilds, attempt to extract the value
			//and add it to the correct point in the proccessed array
			foreach($this->merge_records As $t){
				$ident_array = $this->grabItem($t,$itm,$ident_array);
			}
			//Attempt to grab email's in the data item
			$this->grabOther($itm);
    	}
    	
    	//Return proccessed array
    	return $ident_array;
	}
	
	/**
	 * grabItem
	 * Attempts to grab an Item of the given $type from the cake DB item array
	 * provided. If found item will be added to the $ident_array passed in.
	 * 
	 * @access private
	 * @param String $type Item type being searched for. Name, DOB etc
	 * @param Array $itm An Appsync DB item array
	 * @param Array $ident_array Array of proccesed data
	 */
	private function grabItem($type,$itm,$ident_array){
		//If the item is of the correct $type
		if($itm['data_name'] == $type){
			//Create the item in the $ident_array if it doesnt exist
			if(!isset($ident_array[$type])){ $ident_array[$type] = array();}
			
			//If this item does not already exist in the $ident_array for this $type
			if(!in_array($itm['data_value'],$ident_array[$type])){
				$ident_array[$type][] = $itm['data_value']; //Add item to the array
			}
		}
		//Return $ident_array with its updated value
		return $ident_array;
	}
	
	/**
	 * grabOther
	 * Checks if $itm is an email, if so adds it to $this->emailsList, filtering duplicates as it goes.
	 * 
	 * @access private
	 * @param Array $itm An Appsync DB item array
	 */
	private function grabOther($itm){
		//Is this item an email?
		if($itm['data_name'] == 'email'){
			//Have we already added this email to our list
			if(!in_array($itm['data_value'],$this->emailList)){
				//if not. Add this email to the list
				$this->emailList[] = $itm['data_value'];
			}
		}
	}
	
	/**
	 * addEmails
	 * attempt to add any  emails we found when proccesing the array to the profile
	 * 
	 * @access private
	 * @param int $ident ID of current identity
	 * 
	 */
	private function addEmails($ident){
		//Get email array
		$email_array = $this->emailList;
		
		//Return false if no emails need to be added
		if(count($email_array) < 1)return false;
		
		//Load all currently existing emails in the profile
		$emailz = ClassRegistry::init('emails')->find('all', array(
			'conditions' => array(
       			'identity_id' => $ident
    		)));
    		
    	//Create an array to hold any emails are going to need to add. This is the "save" array
    	$emailsToAdd = array();	
    	//For each email in are "to add" list ($email_array)
		foreach($email_array AS $newEmail){
			//If the new email $newEmail is  not already attached to the account (in $emailz)
			if(!$this->isInEmails($newEmail,$emailz)){
				//Add this email in cake db array format to our "save" array
				$emailsToAdd[] = array(	
					'identity_id' => $ident,
					'email'		=> $newEmail,
					'primary'	=> '0',
					'valid' 	=> '0'
				);
			}
		}
		
		//If the amount of emails in our save is not 0, add them to the profile
		if(count($emailsToAdd) > 0){
			ClassRegistry::init('emails')->saveAll($emailsToAdd);
		}
	}
	
	/**
	 * isInEmails
	 * Checks to see if $newEmail is within the cake email array $emailz
	 * 
	 * @access private
	 * @param array $emailz Cake DB array for emails
	 * @param String $newEmail the new email
	 * @return boolean Is newemail in the array
	 */
	private function isInEmails($newEmail, $emailz){
		//For each email in emailz (cake db array)
		foreach($emailz AS $nemail){
			//check if the email address matchs the $newEmail. If so return true
			if($newEmail == $nemail['emails']['email']){ 
				return true;
			}	
		}
		//Return false if email is not in the $emailz list
		return false;
	}
	
	/**
	 * lookForDifference
	 * Looks for any differences between the current profile data in $oldData and the 
	 * formatted array of new data in $newData, for the selected identity $ident.
	 * If differences are found and we can auto add, auto add it, if not add to the list of fields
	 * we need to manually merge
	 * 
	 * @access private
	 * @param array $newData Formatted array of new Data records
	 * @param array $oldData Cake DB array for an identity
	 * @param int $ident Current profile/identity ID
	 * @return boolean Is a manual merge required?
	 */
	private function lookForDifference($newData,$oldData,$ident){
		//Create the array to store items we will need to merge manually
		$merge_required = array();
		
		//For each syncable item AKA the stuff in ($this->merge_records)
		foreach($this->merge_records As $rec){
			//If there is a new item of this type
			if(isset($newData[$rec])){
				//If there is only one possible item of this type, attempt to autoMerge
				if(count($newData[$rec]) == 1){
					//If old data for this record is empty/null we can set it without bothering the user
					if($oldData[$rec] == '' OR $oldData[$rec] == Null){
						//Save the new item to the current profile
						ClassRegistry::init('Identity')->set('id', $ident);
						ClassRegistry::init('Identity')->set($rec, $newData[$rec][0]);
						ClassRegistry::init('Identity')->save();
					}else {
						//If the old item has data, check to see if it matchs the new Item
						//Since theres no point mergeing two items that are identical
						if($oldData[$rec] != $newData[$rec][0]){
							//If the new record isn't blank
							if($newData[$rec][0] != null && $newData[$rec][0] != ''){
								//Add this item to the merge_required array
								//This means a manual merge for this item will take place
								$merge_required[] = $rec;
							}
						}
					}
				}else{
					//If there are multiple possible new items for the type,
					//loop threw them
					foreach($newData[$rec] As $testible){
						//If the item does not match what we already have
						if($testible != $oldData[$rec]){
							//And the item is not blank
							if($testible != null && $testible != ''){
								//Set to the merge_required array to cause a merge to happen
								$merge_required[] = $rec;
							}	
						}
					}
				}
			}
		}
		// Build a query string to set all items we don't need to merge's sync status to synced.
		// This is items that are not in the merge_required array
		// Having the value set to synced will stop this script having to run on the same data agin
		$excluded = '';
		foreach($merge_required As $exclude){
			$excluded .= " AND data_name != '".$exclude."' ";
		}
		//Run the query with the query string we build above used to exclude
		//setting any records we actually need to merge's sync status to complete
		$this->Appsync->query("UPDATE appsyncs SET synced = 1 WHERE identity_id = '{$ident}' {$excluded} ");
		
		//If there are any records in the $merge_required list we want this function return true (in order to request a manual merge)
		//If not false. 
		return (count($merge_required) > 0);	
	}
	
	/**
	 * Merge
	 * Front end controller for the manual merge dialog. Outputs required information to the views.
	 * 
	 * @access public
	 * 
	 */
	public function merge(){
		//Avoid cacheing (IE.. *cough* *cough*)
		header("Cache-Control: no-cache, must-revalidate"); 
		header("Expires: Sat, 26 Jul 1997 05:00:00 GMT"); 
		//Set Ajax layout
		$this->layout = 'ajax';
		//Get current identity ID
		$ident = $this->Session->read('ident');
		//Pull out any unsynced records
		$dataz = $this->Appsync->find('all', array(
		        'conditions' => array(
			        'identity_id' => $ident,
		    		'synced' 	=> '0'
    			)));
		//Format the unsynced records nicely.
		$formatted = $this->proccessData($dataz);
		//Grab the details currently set to the identity/profile.
		$current = ClassRegistry::init('Identity')->findById($ident);
		//Pass the list of syncable records to the view
		$this->set('sync_data', $this->merge_records);
		//The formmated array of new data
		$this->set('new_data', 	$formatted);
		//The cake DB array of old data
		$this->set('cur_data', 	$current['Identity']);

	}
	
	/**
	 * Save Merge
	 * This function will keep the user's current data, and stop the merge
	 * dialog from showing again for the data it attmpted to sync
	 * 
	 * @access public
	 * @deprecated This function is no longer used. The merge form is saved by the
	 * Standard Save function within the Identities Controller
	 */
	public function save_merge(){
		//Get ID
		$ident = $this->Session->read('ident');
	
		//Set all unsynced records to synced.
		$this->Appsync->query("UPDATE appsyncs SET synced = 1 WHERE identity_id = '{$ident}'");
		//Send user back to their profile.					
		$this->redirect('/profile/'.$ident);
	}
	
}