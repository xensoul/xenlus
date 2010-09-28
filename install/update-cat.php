<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './';
include( $xenlus_root . 'common.php' );

$result = mysql_query("ALTER TABLE " . ENTRIES . " ADD `category` smallint(4) UNSIGNED NOT NULL");

if ($result == true) echo 'Table altered successfully.';
else 'Table could not be altered. ' . mysql_error();

mysql_close();

?>