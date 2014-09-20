<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../../../init.php");

BrowserInfo::set_screen_width($_GET["screen_width"]);
BrowserInfo::set_screen_height($_GET["screen_height"]);
BrowserInfo::set_as_fetched();

?>