<?php
/**
 * sqlDB - Simple database class
 * Provides simple interface to perform basic sql operations on mySQL db.
 * 
 * @version: 0.6
 * @author: Carl Saggs
 * 
 */
class sqlDB
{
	//Login details
	var $sqlhost = '' ;
	var $sqluser = '';
	var $sqlpass = '';
	var $sqldatabase = '';
	//keep track of what belongs to this connection
	var $connection_id ='';
	var $query_id ='';

	/**
	 * Constructor class for DB. Takes database settings and creates a connection to mySQl DB.
	 * @param $host Database Host
	 * @param $user Database user
	 * @param $pass Database Password
	 * @param $database Database Name
	 */
	public function sqlDB($host, $user, $pass, $database ) {
		$this->sqlhost = $host;
		$this->sqluser = $user;
		$this->sqlpass = $pass;
		$this->sqldatabase = $database;
		
		$this->connect();
	}

	/**
	 * Creates a connection to a mysql DB
	 * 
	 */
	private function connect(){
		//Log us in to the db
		$this->connection_id = mysql_connect($this->sqlhost, $this->sqluser, $this->sqlpass) or die("Critical error: DB credentals Incorrect.");
		//select are db
		mysql_select_db($this->sqldatabase, $this->connection_id) or die ("Critical error: Selected database not found.");
	}

	/**
	 * Disconnect from mysql DB
	 * 
	 */
	function disconnect() {
		mysql_close($this->connection_id);
	}

	/**
	 * Ensure string is database safe
	 * 
	 * @param String $str
	 * @return String db safe value
	 */
	function cleanString($str){
		return mysql_real_escape_string($str,$this->connection_id);
	}
	
	/**
	 * Query the database this object is connected to.
	 * 
	 * @param $sql SQL Query String
	 */
	function query($sql)
	{
		$this->query_id = mysql_query($sql,$this->connection_id) or die(mysql_error());
	}

	/**
	 * Counts rows returned from previous query
	 * @return int rows selected.
	 */
	function countRows() {
		return mysql_num_rows($this->query_id);
	}

	/**
	 * Fetches next row from query results.
	 * @return misc
	 */
	function fetchRow() {
		return mysql_fetch_assoc($this->query_id);
	}
}
