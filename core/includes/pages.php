<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
$querypageid = mysql_real_escape_string($_GET['pageid']);
if ($querypageid == "") {
    $querypageid = "1";
}

if ($querypageid == "sitemap") {
    $query = "SELECT `pageid`, `pagetitle` FROM " . $table_prefix . "pages ORDER BY `pageid` ASC";
    $result = mysql_query($query);
    if (!$result) {
        die(mysql_error());
    }
    $pagetext = "<ul style=\"margin-left: 20px;\" type=\"none\">";
    while ($row = mysql_fetch_assoc($result)) {
        $pagetext .= "<li><a href=\"./index.php?pageid=" . $row['pageid'] . "\" title=\"" . $row['pagetitle'] . "\">" . $row['pagetitle'] . "</a></li>";
    }
    $pagetext .= "</ul>";
    $pagetitle = "sitemap";
    $pageid = "sitemap";
    $needlogin = "0";
} elseif ($querypageid == "ext") {
    $ext = mysql_real_escape_string($_GET['ext']);
    $query = mysql_query("SELECT * FROM `" . $table_prefix . "extensions` WHERE name='" . $ext . "' LIMIT 1");
    $NumRows = mysql_num_rows($query);

    if ($NumRows == 1) {
        $ExtData = mysql_fetch_array($query);
        include("./extensions/" . $ExtData['extension'] . "/frontend/pagedisplay.php");
    } else {
        $pagetitle = "This extension doesnt exists";
        $pagetext = "The extension youve requested to display a page could not be found";
    }
} else {
    $blog_postnumber = 5;

    if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
        $page = 1;
    } else {
        $page = (int) $_GET['page'];
    }
    $from = (($page * $blog_postnumber) - $blog_postnumber);

    $query = "SELECT * FROM " . ENTRIES . " ORDER BY timestamp DESC LIMIT $from, $blog_postnumber";

    $contentpagesresult = mysql_query($query) or die(mysql_error());
    $numpages = mysql_num_rows($contentpagesresult) or die(mysql_error());

    if ($numpages == 0) {
        $entry_title = "Doesnt exists";
        $entry_content = "this page doesnt exists";
        $entryid = 0;
    } else {
        $row = mysql_fetch_assoc($contentpagesresult);
        $entryid = stripslashes($row['entryid']);
        $entry_title = stripslashes($row['entry_title']);
        $entry_content = stripslashes($row['entry_content']);
    }
}

if ($needlogin == "on") {
    if (!IsSet($_SESSION['siteuser'])) {
        $pagetitle = "permission denied";
        $pagetext = "you need to login to view this page, to create a account now <a href=\"./index.php?pageid=register.php&returnurl=http://www." . $_SERVER["SERVER_NAME"] . $_SERVER['PHP_SELF'] . "\"><u>click here</u></a>";

        //why the $loggedin? well because of the comments below
        $loggedin = 0;
    } else {
        $loggedin = 1;
    }
} else {
    $loggedin = 1;
}

class createf {

    public function create() {
        global $row, $footertext, $xenlus_version;
        $themedata = $this->getthemedata();
        $privatetext = $this->getprivatetext();

        $result = '<div style="float: left;"><p>&nbsp;';
        if ($privatetext != "") {
            $result .= $privatetext . '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
        }
        $result .= '<a href="./index.php?pageid=sitemap" title="sitemap">Sitemap</a>';
        $result .= '</p></div><div style="float: right;"><p>';
        if ($themedata != "") {
            $result .= $themedata . '&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;';
        }
        //you are not allowed to edit without permission the line below
        $result .= '<small><a href="http://www.xenlus.com" class="cmslink">Powered by Xenlus ' . $xenlus_version . '</a></small></p></div><div style="clear: both;"></div>';
        //you are not allowed to edit without permission the line above
        $footertext = $result;
        return;
    }

//end function create

    private function getthemedata() {
        global $table_prefix, $currenttheme;
        $query = mysql_query("SELECT * FROM `" . $table_prefix . "themes` WHERE themename='" . $currenttheme . "' LIMIT 1");
        if (!$query) {
            $themedata = "error while fetching theme data";
        } else {
            $row = mysql_fetch_array($query);
            if ($row['author_name'] == "") {
                //name is empty so no link is required to place on the website
                $themedata = "";
            } else {
                if ($row['author_website'] == "") {
                    $themedata = '<small>design by: ' . $row["author_name"] . '</small>';
                } else {
                    $themedata = '<small><a href="' . $row["author_website"] . '">design by: ' . $row["author_name"] . '</a></small>';
                }
            }
        }
        return $themedata;
    }

//end function getthemedata

    private function getprivatetext() {
        global $table_prefix;

        $query = mysql_query("SELECT footertext FROM `" . $table_prefix . "settings` WHERE id='1' LIMIT 1");
        $query = mysql_fetch_array($query);
        $privatetext = $query['footertext'];

        return $privatetext;
    }

//end function getprivatetext
}

$create = new createf();
$create->create();
?>
