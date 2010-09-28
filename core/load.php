<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
session_start();

# Report all errors, except notices
error_reporting(E_ALL ^ E_NOTICE);

$xcore = (defined('XENLUS_CORE')) ? XENLUS_CORE : './core/includes/';

# Configuration file
include('config.php');

# set the charset to the right type which we are using
header("Content-type: text/html; charset=UTF-8");

if (isset($HTTP_X_FORWARDED_FOR)) {
    if ($HTTP_X_FORWARDED_FOR) {
        $ipaddress = $HTTP_X_FORWARDED_FOR;
        $proxy = $HTTP_VIA;
    }
} else {
    $ipaddress = $_SERVER['REMOTE_ADDR'];
    $proxy = "none / highly anonymously";
}

if (version_compare('5.1', phpversion(), '>')) {
    die(sprintf('Your server is running PHP version %s but Xenlus requires at least 5.1.', phpversion()));
}

if (!extension_loaded('mysql'))
    die('Your PHP installation appears to be missing the MySQL extension which is required by Xenlus.');

# Check if Xenlus had been installed
if (file_exists($xenlus . 'install/index.php')) {
    echo '<meta http-equiv="refresh" content="0;url=' . $xenlus . '/install/index.php" />';
    exit;
}

/*
 * Turn Register Global Off
 */

function deregister_globals() {
    if (!ini_get('register_globals'))
        return;

    if (isset($_REQUEST['GLOBALS']))
        die('GLOBALS overwrite attempt detected');

    // Variables that shouldn't be unset
    $noUnset = array('GLOBALS', '_GET', '_POST', '_COOKIE', '_REQUEST', '_SERVER', '_ENV', '_FILES', 'table_prefix');

    $input = array_merge($_GET, $_POST, $_COOKIE, $_SERVER, $_ENV, $_FILES, isset($_SESSION) && is_array($_SESSION) ? $_SESSION : array());
    foreach ($input as $k => $v)
        if (!in_array($k, $noUnset) && isset($GLOBALS[$k])) {
            $GLOBALS[$k] = NULL;
            unset($GLOBALS[$k]);
        }
}

deregister_globals();

# Connecting to the database
mysql_connect($dbhost, $dbuser, $dbpasswd) or die("Could not connect. " . mysql_error());
mysql_select_db($dbname) or die("Could not select database. " . mysql_error());

# Constants
include($xenlus . 'core/constants.php');

# Language pack
include($xenlus . 'lang/lang-core.php');
initializeLang();

# check if you are logged-in
if (IsSet($_SESSION['siteuser'])) {
    $siteusername = $_SESSION['siteuser'];
}

# check if GD is supported
if (function_exists("gd_info")) {
    $GD_enabled = "true";
} else {
    $GD_enabled = "false";
}

/*# Includes Core files
include($xcore . 'functions/functions.php');
include($xcore . 'settings.php');
include($xcore . 'menu.php');
include($xcore . 'sidebar.php');
include($xcore . 'pages.php');

if (($comments == 1) && ($loggedin = 1)) {
    include($xcore . 'functions/comments.php');
    $posts = comments();
}
*/

# include the page which parses the template and creates the website
include($xenlus . 'core/tpl_core.php');

// We do not need this any longer, unset for safety purposes
unset($dbpasswd);
?>
