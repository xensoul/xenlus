<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './../';
include( $xenlus_root . 'common.php' );

if (isset($_POST['add_category'])) {
	
	$newcat = htmlspecialchars(strip_tags($_POST['new_category']));
	
	if (empty($newcat)) {
		die("No category submitted! Please go back and enter one.");
	}

	if (!get_magic_quotes_gpc()) {
		$newcat = mysql_real_escape_string($newcat);
	}
	
	$insert = mysql_query("INSERT INTO " . CATEGORIES . " (`category_name`) VALUES ('$newcat')");
	
	if ($insert == true) {
		echo 'Category successfully added.';
	} else {
		echo 'The category could not be added to the database. ' . mysql_error();
	}

}

elseif (isset($_POST['edit_category'])) {
	
	if (isset($_POST['submit_category_edit'])) {
		$newcat = htmlspecialchars(strip_tags($_POST['new_name']));
		if (empty($newcat)) {
			die("No new category name entered, please go back and try again.");
		}
		$id = (int)$_POST['edit_category'];

		if (empty($id)) {
			die("Invalid category!");
		}
		if (!get_magic_quotes_gpc()) {
			$newcat = mysql_real_escape_string($newcat);
		}
		$edit = mysql_query("UPDATE php_blog_categories SET `category_name` = '$newcat' WHERE `category_id` = $id LIMIT 1");

		if ($edit == true) {
			echo 'Category successfully edited.';
		} else {
			echo 'Category could not be edited. ' . mysql_error();
		}
	} else {
		$category = (int)$_POST['category'];

		if (empty($category)) {
			die ("No category chosen! Please go back and choose a category to edit.");
		}
	
		$result = mysql_query("SELECT * FROM " . CATEGORIES . " WHERE `category_id` = $category LIMIT 1");
		$row = mysql_fetch_array($result);
	
		if (!$row) {
			die("There doesn't seem to be a category with the ID number submitted. Please go back and try again.");
		}
	
?>

		<form action="categories.php" method="post">
    		<p><input type="hidden" name="edit_category" value="<?php echo $row['category_id']; ?>" />
        	The current category name is <?php echo $row['category_name']; ?>. To change it, enter a new name in the box below.<br />
			Rename category to: <input type="text" name="new_name" id="new_name" /><br />

			<input type="submit" name="submit_category_edit" id="submit_category_edit" value="Submit new name" /></p>
        </form>

<?php
	}
}

elseif (isset($_POST['delete_category'])) {
	
	$category = (int)$_POST['category'];
	
	if (empty($category)) {
		die("No category chosen! Please go back and choose a category to delete.");
	}
	
	$delete = mysql_query("DELETE FROM " . CATEGORIES . " WHERE `category_id` = $category LIMIT 1");
	
	if ($delete == true) {
		echo 'Category successfully deleted.';
	} else {
		echo 'The category could not be deleted. ' . mysql_error();
	}
	
?>

	<form action="categories.php" method="post">
    	<p><input type="hidden" name="edit_category" value="<?php echo $row['category_id']; ?>" />
        The current category name is <?php echo $row['category_name']; ?>. To change it, enter a new name in the box below.<br />
		Rename category to: <input type="text" name="new_name" id="new_name" /><br />

		<input type="submit" name="submit_category_edit" id="submit_category_edit" value="Submit new name" /></p>

<?php

} else {

$result = mysql_query("SELECT * FROM " . CATEGORIES);
?>
<form action="categories.php" method="post"><p>

<?php
while($row = mysql_fetch_array($result)) {
?>

<input type="radio" name="category" value="<?php echo $row['category_id']; ?>" /> <?php echo $row['category_name']; ?><br />

<?php
}
?>

</p>
<p><input type="submit" name="edit_category" id="edit_category" value="Edit selected category" /> <input type="submit" name="delete_category" id="delete_category" value="Delete selected category" /></p>

</form>

<form action="categories.php" method="post">
<p>Add new category: <input type="text" name="new_category" id="new_category" /> <input type="submit" name="add_category" id="add_category" value="Add category" /></p>

</form>

<?php
}

mysql_close();
?>