<?php
/**
 * Numbers class, this handles all of the telephone number information,
 * including creation of numbers
 * 
 * @author Michael Pontin
 * @created Nov 17 2010
 * @package theProfile
 * @license http://www.opensource.org/licenses/mit-license.php
 * 
 */
class NumbersController extends AppController {
	
	
	/**
	 * Add a number attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{
	
		parent::add();
	}
	
	/**
	 * Edit an existing number
	 */
	function edit($id = null)
	{
	
		parent::edit(null, "number");
	}
	
	/**
	 * Deletes a specified number
	 */
	function delete()
	{
		parent::delete("number");
	}
	
}