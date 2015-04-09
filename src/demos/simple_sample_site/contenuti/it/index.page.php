<?php

Html::set_title("Home - SimpleSampleSite");

Html::set_layout("simplesamplesite");

include("include/layouts/page_common.php.inc");

start_sector("/citazione/testo");
?>
Welcome to the SimpleSampleSite.
<?
end_sector();
set_sector("/citazione/firma","MBCRAFT");

?>
