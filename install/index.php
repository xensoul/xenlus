<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './../';
include( $xenlus_root . 'common.php' );

$sql = "CREATE TABLE " . ENTRIES . " (
  id int(20) NOT NULL auto_increment,
  timestamp int(20) NOT NULL,
  title varchar(255) NOT NULL,
  entry longtext NOT NULL,
  PRIMARY KEY  (id)
)";

$result = mysql_query($sql) or print ("Can't create the table " . ENTRIES . " in the database.<br />" . $sql . "<br />" . mysql_error());

if ($result != false) {
    echo "Table " . ENTRIES . " was successfully created.";
}

$sql1 = "CREATE TABLE " . COMMENTS . " (
  id int(20) NOT NULL auto_increment,
  entry int(20) NOT NULL,
  name varchar(255) NOT NULL,
  email varchar(255) NOT NULL,
  url varchar(255) NOT NULL,
  comment longtext NOT NULL,
  timestamp int(20) NOT NULL,
  PRIMARY KEY  (id)
)";

$result1 = mysql_query($sql1) or print("Can't create the table " . COMMENTS . " in the database.<br />" . $sql . "<br />" . mysql_error());

if ($result1 != false) {
    echo "Table " . COMMENTS . " was successfully created.";
}

mysql_close();

?>