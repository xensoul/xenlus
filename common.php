<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

# Report all errors, except notices
error_reporting(E_ALL ^ E_NOTICE);


/*
 * Turn Register Global Off
 */
function deregister_globals() {
	if ( !ini_get('register_globals') )
		return;

	if ( isset($_REQUEST['GLOBALS']) )
		die('GLOBALS overwrite attempt detected');

	// Variables that shouldn't be unset
	$noUnset = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', 'table_prefix');

	$input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
	foreach ( $input as $k => $v )
		if ( !in_array($k, $noUnset) && isset($GLOBALS[$k]) ) {
			$GLOBALS[$k] = NULL;
			unset($GLOBALS[$k]);
		}
}

deregister_globals();

if ( version_compare( '4.3', phpversion(), '>' ) ) {
	die( sprintf( 'Your server is running PHP version %s but Xenlus requires at least 4.3.', phpversion() ) );
}

# If we are on PHP >= 6.0.0 we do not need some code
if (version_compare(PHP_VERSION, '6.0.0-dev', '>='))
{
	/**
	* @ignore
	*/
	define('STRIP', false);
}
else
{
	@set_magic_quotes_runtime(0);

	# Be paranoid with passed vars
	if (@ini_get('register_globals') == '1' || strtolower(@ini_get('register_globals')) == 'on' || !function_exists('ini_get'))
	{
		deregister_globals();
	}

	define('STRIP', (get_magic_quotes_gpc()) ? true : false);
}

if ( !extension_loaded('mysql') )
	die( 'Your PHP installation appears to be missing the MySQL extension which is required by Xenlus.' );

include_once('includes/class.php');	
require($xenlus_root . 'config.php');

include($xenlus_root . 'includes/constants.php');
include($xenlus_root . 'includes/functions.php');

$obj = new xen();
/* CHANGE THESE SETTINGS FOR YOUR OWN DATABASE */
$obj->host = $dbhost;
$obj->username = $dbuser;
$obj->password = $dbpasswd;
$obj->table = $dbname;
$obj->connect();

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);

?>