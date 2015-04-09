<?php

$supported_languages = array("it","en");
$default_language = "it";

if (isset($_GET["lang"]))   //set new language
{
    Language::setCurrent($_GET["lang"]);
}
    
$current_lang = Language::getCurrent();
$current_host = Host::current();

header("Location: http://".$current_host."/".$current_lang."/index.php");

//require_once("include/portfolio.php");
//probe_portfolio_ping("65632473556990386535131");
?>
