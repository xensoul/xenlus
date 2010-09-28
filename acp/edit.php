<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './../';
include( $xenlus_root . 'common.php' );

$result = mysql_query("SELECT timestamp, id, title FROM " . ENTRIES . " ORDER BY id DESC");

while($row = mysql_fetch_array($result)) {
    $date  = date("l F d Y",$row['timestamp']);
    $id = $row['id'];
    $title = strip_tags(stripslashes($row['title']));

    if (mb_strlen($title) >= 20) {
        $title = substr($title, 0, 20);
        $title = $title . "...";
    }
    print("<a href=\"edit-post.php?id=" . $id . "\">" . $date . " -- " . $title . "</a><br />");
}

mysql_close();

?>