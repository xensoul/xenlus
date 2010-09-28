<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
$query = "SELECT * FROM " . $table_prefix . "settings WHERE id='1'";
$mainresult = mysql_query($query);
if (!$mainresult) {
    die(mysql_error());
}

$row = mysql_fetch_array($mainresult);

$sitetitle = $row['sitetitle'];
$slogan = $row['slogan'];
$currenttheme = $row['currenttheme'];
$sitedescription = $row['metadescription'];
$sitekeywords = $row['metakeywords'];
$analyticscode = $row['analytics'];
$mailsetting = $row['enable_mail'];
$registrationsetting = $row['enable_registration'];
?>
