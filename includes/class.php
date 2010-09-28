<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/
 
class xen {
	var $host;
	var $username;
	var $password;
	var $table;
	
	public function connect() {
		mysql_connect($this->host,$this->username,$this->password) or die("Could not connect. " . mysql_error());
		mysql_select_db($this->table) or die("Could not select database. " . mysql_error());
	}
}

?>