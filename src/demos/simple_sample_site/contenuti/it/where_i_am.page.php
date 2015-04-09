<?php

Html::set_title("Where i am - SimpleSampleSite");

Html::set_layout("simplesamplesite_dovesono");

include("include/layouts/page_common.php.inc");

start_sector("/contenuto");
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<?
end_sector();

start_sector("/main_menu");
MenuBuilder::build("main","/contenuti/it/");
end_sector();

?>