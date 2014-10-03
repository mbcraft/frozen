<?
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
require_once("../../../init.php");

BrowserInfo::set_screen_width($_GET["screen_width"]);
BrowserInfo::set_screen_height($_GET["screen_height"]);
BrowserInfo::set_as_fetched();

?>