<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
require_once("tpl_functions.php");

//define what template to use
$tpl = new tpl_Magic("./themes/" . $currenttheme);

//define what .tpl files to use
$tpl->define("LAYOUT", "layout.tpl");

//define the replacements
$tpl->assign("{THEMEDIR}", $currenttheme);
$tpl->assign("{METADESCRIPTION}", $sitedescription);
$tpl->assign("{METAKEYWORDS}", $sitekeywords);
$tpl->assign("{HEADERDATA}", '<meta name="powered-by" content="xenlus" />' . $headerdata);
$tpl->assign("{MAINTITLE}", $sitetitle);
$tpl->assign("{SLOGAN}", $slogan);
$tpl->assign("{MENU}", $menutabs);
$tpl->assign("{PAGETITLE}", $entry_title);
$tpl->assign("{PAGECONTENT}", $entry_content);
$tpl->assign("{COMMENTS}", $posts);
$tpl->assign("{LEFTSIDEBARCONTENT}", $leftsidebarcontent);
$tpl->assign("{RIGHTSIDEBARCONTENT}", $rightsidebarcontent);
$tpl->assign("{SINGLESIDEBAR}", $singlesidebarcontent);
$tpl->assign("{FOOTER}", $footertext);
$tpl->assign("{ANALYTICSCODE}", $analyticscode);

//give these vars their new values and echo them
$layout = $tpl->parse("LAYOUT");

print $layout;

@mysql_close();
?>
