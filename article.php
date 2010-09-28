<?php
/**
 * Xenlus
 * Copyright 2009 Xenlus Group. All Rights Reserved.
 **/

$xenlus_root = (defined('XENLUS_ROOT')) ? XENLUS_ROOT : './';
include( $xenlus_root . 'common.php' );

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid ID specified.");
}

$id = $_GET['id'];
$sql = 'SELECT * FROM ' . ENTRIES . ' WHERE id=' . $id . ' LIMIT 1';

$result = mysql_query($sql) or print ("Can't select entry from table " . ENTRIES . ".<br />" . $sql . "<br />" . mysql_error());

while($row = mysql_fetch_array($result)) {

    $date = date("l F d Y", $row['timestamp']);

    $title = stripslashes($row['title']);
    $entry = stripslashes($row['entry']);

    ?>

    <p><strong><?php echo $title; ?></strong><br /><br />
    <?php echo $entry; ?><br /><br />
    Posted on <?php echo $date; ?><br /><br />
	<?php
	$commenttimestamp = strtotime("now");

$sql = "SELECT * FROM " . COMMENTS . " WHERE entry='$id' ORDER BY timestamp";
$result = mysql_query ($sql) or print ("Can't select comments from table " . COMMENTS . ".<br />" . $sql . "<br />" . mysql_error());
while($row = mysql_fetch_array($result)) {
    $timestamp = date("l F d Y", $row['timestamp']);
    printf("<hr />");
    print("<p>" . stripslashes($row['comment']) . "</p>");
    printf("<p>Comment by <a href=\"%s\">%s</a> @ %s</p>", stripslashes($row['url']), stripslashes($row['name']), $timestamp);
    printf("<hr />");
}
	?>

        <hr /></p>
		<form method="post" action="./../../comment.php">

<p><input type="hidden" name="entry" id="entry" value="<?php echo $id; ?>" />

<input type="hidden" name="timestamp" id="timestamp" value="<?php echo $commenttimestamp; ?>">

<strong><label for="name">Name:</label></strong> <input type="text" name="name" id="name" size="25" /><br />

<strong><label for="email">E-mail:</label></strong> <input type="text" name="email" id="email" size="25" /><br />

<strong><label for="url">URL:</label></strong> <input type="text" name="url" id="url" size="25" value="http://" /><br />

<strong><label for="comment">Comment:</label></strong><br />
<textarea cols="25" rows="5" name="comment" id="comment"></textarea></p>

<p><input type="submit" name="submit_comment" id="submit_comment" value="Add Comment" /></p>

</form>

        <?php
    }
?>