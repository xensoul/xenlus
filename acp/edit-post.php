<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './../';
include( $xenlus_root . 'common.php' );

if (isset($_POST['update'])) {

    $id = htmlspecialchars(strip_tags($_POST['id']));
    $month = htmlspecialchars(strip_tags($_POST['month']));
    $date = htmlspecialchars(strip_tags($_POST['date']));
    $year = htmlspecialchars(strip_tags($_POST['year']));
    $time = htmlspecialchars(strip_tags($_POST['time']));
    $entry = $_POST['entry'];
    $title = htmlspecialchars(strip_tags($_POST['title']));
	
    $entry = nl2br($entry);
	$category = (int)$_POST['category'];

    if (!get_magic_quotes_gpc()) {
        $title = addslashes($title);
        $entry = addslashes($entry);
    }

    $timestamp = strtotime ($month . " " . $date . " " . $year . " " . $time);

    $result = mysql_query("UPDATE " . ENTRIES . " SET timestamp='$timestamp', title='$title', entry='$entry', category='$category' WHERE id='$id' LIMIT 1") or print ("Can't update entry.<br />" . mysql_error());

    header("Location: ./../article.php?id=" . $id);

}

if (isset($_POST['delete'])) {
    $id = (int)$_POST['id'];
    $result = mysql_query("DELETE FROM " . ENTRIES . " WHERE id='$id'") or print ("Can't delete entry.<br />" . mysql_error());
    if ($result != false) {
        print "The entry has been successfully deleted from the database.";
        exit;
    }
}

if (!isset($_GET['id']) || empty($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid entry ID.");
}
else {
    $id = (int)$_GET['id'];
}

$result = mysql_query ('SELECT * FROM ' . ENTRIES . ' WHERE id=' . $id) or print ("Can't select entry.<br />" . $sql . "<br />" . mysql_error());

while ($row = mysql_fetch_array($result)) {
    $old_timestamp = $row['timestamp'];
    $old_title = stripslashes($row['title']);
    $old_entry = stripslashes($row['entry']);
	$old_category = $row['category'];

    $old_title = str_replace('"','\'',$old_title);
    $old_entry = str_replace('<br />', '', $old_entry);

    $old_month = date("F",$old_timestamp);
    $old_date = date("d",$old_timestamp);
    $old_year = date("Y",$old_timestamp);
    $old_time = date("H:i",$old_timestamp);
}
?>

<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">

<p><input type="hidden" name="id" value="<?php echo $id; ?>" />

<strong><label for="month">Date (month, day, year):</label></strong> 

<select name="month" id="month">
<option value="<?php echo $old_month; ?>"><?php echo $old_month; ?></option>

<option value="January">January</option>
<option value="February">February</option>
<option value="March">March</option>
<option value="April">April</option>

<option value="May">May</option>
<option value="June">June</option>
<option value="July">July</option>
<option value="August">August</option>

<option value="September">September</option>
<option value="October">October</option>
<option value="November">November</option>
<option value="December">December</option>

</select>

<input type="text" name="date" id="date" size="2" value="<?php echo $old_date; ?>" />

<select name="year" id="year">
<option value="<?php echo $old_year; ?>"><?php echo $old_year; ?></option>
<option value="2004">2004</option>

<option value="2005">2005</option>
<option value="2006">2006</option>
<option value="2007">2007</option>
<option value="2008">2008</option>

<option value="2009">2009</option>
<option value="2010">2010</option>
</select>

<strong><label for="time">Time:</label></strong> <input type="text" name="time" id="time" size="5" value="<?php echo $old_time; ?>" /></p>

<?php
$result2 = mysql_query("SELECT * FROM " . CATEGORIES);

echo '<p><strong><label for="category">Category:</label></strong> <select name="category" id="category">';

while($row2 = mysql_fetch_array($result2)) { ?>

    <option value="<?php echo $row2['category_id']; ?>" <?php if ($old_category == $row2['category_id']) echo ' selected="selected"'; ?>><?php echo $row2['category_name']; ?></option>
    <?php
}
?>
</select></p>

<p><strong><label for="title">Title:</label></strong> <input type="text" name="title" id="title" value="<?php echo $old_title; ?>" size="40" /> </p>

<p><textarea cols="80" rows="20" name="entry" id="entry"><?php echo $old_entry; ?></textarea></p>

<p><input type="submit" name="update" id="update" value="Update"></p>

</form>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

<input type="hidden" name="id" id="id" value="<?php echo $id; ?>" />
<input type="submit" name="delete" id="delete" value="Yes, I am absolutely and positively sure I want to delete this entry." />

</form>

<?php

mysql_close();

?>