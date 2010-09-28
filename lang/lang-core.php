<?php

/**
 * Xenlus
 * Copyright 2010 Xenlus Group. All Rights Reserved.
 * */
$lang1 = strtolower($_SERVER['HTTP_ACCEPT_LANGUAGE']);
$lang1 = explode(';', addslashes($lang1));
$lang2 = explode('-', $lang1[0]);

if (isset($_SESSION['lang'])) {
    $language = $_SESSION['lang'];
} elseif ($lang2[0] == 'cn') {
    $language = "cn";
} else {
    $language = "en";
}

//$language = "en";

$languageElements = array();

function loadLanguage($language) {
    if ($language == "en") {
        include("lang-pack/en.php");
    } elseif ($language == "cn") {
        include("lang-pack/cn.php");
    } else {
        include("lang-pack/en.php");
    }

    $_SESSION['lang'] = $language;
    //include("lang-pack/en.php");
}

function initializeLang() {

    if (isset($_GET['lang'])) {
        loadLanguage($_GET['lang']);
    } elseif (isset($_SESSION['lang'])) {
        loadLanguage($_SESSION['lang']);
    } else {
        loadLanguage($language);
    }
    //include("lang-pack/en.php");
}

function textName($name, $value) {
    global $languageElements;
    $languageElements[$name] = $value;
}

function _t($name) {
    global $languageElements;
    if (!isset($languageElements[$name])) {
        return "Not translated `$name`";
    }
    return $languageElements[$name];
}

?>
