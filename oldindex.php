<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './';
include( $xenlus_root . 'common.php' );

# Begin GZip Compression
if(extension_loaded('zlib')) {
	ini_set('zlib.output_compression_level', 1);  
	ob_start('ob_gzhandler'); 
}

$blog_postnumber = 5;

if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
	$page = 1;
}
else {
	$page = (int)$_GET['page'];
}
$from = (($page * $blog_postnumber) - $blog_postnumber);

$sql = "SELECT * FROM " . ENTRIES . " ORDER BY timestamp DESC LIMIT $from, $blog_postnumber";

$result = mysql_query($sql) or print ("Can't select entries from table " . ENTRIES . ".<br />" . $sql . "<br />" . mysql_error());

include( $xenlus_root . 'theme/default/index.php' );

?>