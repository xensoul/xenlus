<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

function get_header() {
	include( $xenlus_root . 'theme/default/header.php');
}

function get_footer() {
	global $xenlus_version;
	include( $xenlus_root . 'theme/default/footer.php');
}

?>