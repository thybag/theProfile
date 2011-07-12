<?php
/**
 * Address class, this handles all of the address information,
 * including creation of account
 * 
 * @author Michael Pontin
 * @created Nov 09 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class AddressesController extends AppController {

	/**
	 * Add and address attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{
	
		parent::add();
	}
	
	/**
	 * Edit an existing address
	 */
	function edit()
	{
		parent::edit(null, "address");
	}
	
	/**
	 * Deletes a specified address
	 */
	function delete()
	{
		parent::delete("address");
	}
	
}