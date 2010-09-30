<?php

/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 * */
$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './../';
include( $xenlus_root . 'core/load.php' );

$sql = "CREATE TABLE " . ENTRIES . " (
  entryid int(20) NOT NULL auto_increment,
  timestamp int(20) NOT NULL,
  entry_title varchar(255) NOT NULL,
  entry_content longtext NOT NULL,
  PRIMARY KEY  (id)
)";

$result = mysql_query($sql) or print ("Can't create the table " . ENTRIES . " in the database.<br />" . $sql . "<br />" . mysql_error());

if ($result != false) {
    echo "Table " . ENTRIES . " was successfully created.";
}

$sql1 = "CREATE TABLE " . COMMENTS . " (
  id int(20) NOT NULL auto_increment,
  entry_id int(20) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  comment longtext NOT NULL,
  timestamp int(20) NOT NULL,
  PRIMARY KEY  (id)
)";

$result1 = mysql_query($sql1) or print("Can't create the table " . COMMENTS . " in the database.<br />" . $sql1 . "<br />" . mysql_error());

if ($result1 != false) {
    echo "Table " . COMMENTS . " was successfully created.";
}

$result2 = mysql_query("CREATE TABLE " . CATEGORIES . "
(`category_id` smallint(4) UNSIGNED AUTO_INCREMENT NOT NULL,
`category_name` varchar(255) NOT NULL DEFAULT '',
PRIMARY KEY (`category_id`))");

if ($result2 == true)
    echo 'Table created successfully.';
else
    'Table could not be created. ' . mysql_error();

$result3 = mysql_query("ALTER TABLE " . ENTRIES . " ADD `category_id` smallint(4) UNSIGNED NOT NULL");

if ($result3 == true)
    echo 'Table altered successfully.';
else
    'Table could not be altered. ' . mysql_error();

mysql_close();
?>