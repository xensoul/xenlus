<?php

get_header();

?>

<table width="700" cellspacing="0" cellpadding="0">
<tr>
<td colspan="2" class="header" valign="top">
<div class="heading1">Xenlus</div>
<div class="heading2">Your source of Web Technology..</div>
</td>
</tr>
<tr>
<td width="180" class="menu" valign="top">
<div class="h1">Profile</div>
<b>Xenlus</b>
<br><br>
</td>
<td width="520" class="menu" style="border-left:1px solid #f5f5f5;" valign="top">
<?php
while($row = mysql_fetch_array($result)) :

    $date = date("l, d M Y, h:ia", $row['timestamp']);
	$id = stripslashes($row['id']);
    $title = stripslashes($row['title']);
    $entry = stripslashes($row['entry']);
	$get_categories = mysql_query("SELECT * FROM " . CATEGORIES . " WHERE `category_id` = $row[category]");
	$category = mysql_fetch_array($get_categories);
?>
<div class="h1"><?php echo $date; ?></div>
<div class="h2"><a href="/article.php?id=<?php echo $id; ?>"><?php echo $title; ?></a></div>
<br />
Posted in <a href="category.php?category=<?php echo $row['category']; ?>"><?php echo $category['category_name']; ?></a>
<br />
<br />
<?php 
	
	echo $entry; 
	
		$result2 = mysql_query ("SELECT id FROM " . COMMENTS . " WHERE entry='$id'");
        $num_rows = mysql_num_rows($result2);

        if ($num_rows > 0) {
            echo "<br /><br />
			<a href=\"article.php?id=" . $id . "\">" . $num_rows . " comments</a>";
        }
        else {
            echo "<br /><br />
			<a href=\"article.php?id=" . $id . "\">Leave a comment</a>";
        }
	?><br /><br />
<?php
endwhile;
?>

	<hr /></p>

<div align="center">
Page<br />
<?php
$total_results = mysql_fetch_array(mysql_query("SELECT COUNT(*) AS num FROM " . ENTRIES . ""));
$total_pages = ceil($total_results['num'] / $blog_postnumber);
if ($page > 1) {
    $prev = ($page - 1);
    echo "<a href=\"?page=$prev\">&lt;&lt;  Newer</a> ";
}
for($i = 1; $i <= $total_pages; $i++) {
    if ($page == $i) {
        echo "$i ";
    }
    else {
        echo "<a href=\"?page=$i\">$i</a> ";
    }
}
if ($page < $total_pages) {
   $next = ($page + 1);
   echo "<a href=\"?page=$next\">Older &gt;&gt;</a>";
}
?>
</div>
</td>
</tr>

<?php

get_footer();

?>