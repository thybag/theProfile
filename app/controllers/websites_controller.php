<?php
/**
 * Websites class
  * 
 * @author David Couch
 * @created January 25 2010
 * 
 */
class WebsitesController extends AppController {
	
	
	/**
	 * Add an website attaching it to the user, redirect to edit as 
	 * they have duplicate functionality
	 */
	function add()
	{
		parent::add();
	}
	
	/**
	 * Edit an existing website
	 */
	function edit($id = null)
	{
		parent::edit(null, "website");
	}
	
	/**
	 * Deletes a specified website
	 */
	function delete()
	{
		parent::delete("website");
	}
	
}