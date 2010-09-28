<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './';
include( $xenlus_root . 'common.php' );

if (isset($_POST['submit_comment'])) {

    if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['comment'])) {
        die("You have forgotten to fill in one of the required fields! Please make sure you submit a name, e-mail address and comment.");
    }

    $entry = htmlspecialchars(strip_tags($_POST['entry']));
    $timestamp = htmlspecialchars(strip_tags($_POST['timestamp']));
    $name = htmlspecialchars(strip_tags($_POST['name']));
    $email = htmlspecialchars(strip_tags($_POST['email']));
    $url = htmlspecialchars(strip_tags($_POST['url']));
    $comment = htmlspecialchars(strip_tags($_POST['comment']));
    $comment = nl2br($comment);

    if (!get_magic_quotes_gpc()) {
        $name = addslashes($name);
        $url = addslashes($url);
        $comment = addslashes($comment);
    }

    if (!eregi("^([_a-z0-9-]+)(\.[_a-z0-9-]+)*@([a-z0-9-]+)(\.[a-z0-9-]+)*(\.[a-z]{2,4})$", $email)) {
         die("The e-mail address you submitted does not appear to be valid. Please go back and correct it.");
    }

    $result = mysql_query("INSERT INTO " . COMMENTS . " (entry, timestamp, name, email, url, comment) VALUES ('$entry','$timestamp','$name','$email','$url','$comment')");

    header("Location: article.php?id=" . $entry);
}
else {
    die("Error: you cannot access this page directly.");
}
?>