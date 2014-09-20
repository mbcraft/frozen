<!-- included css files -->
<?php

foreach ($css_file_list as $css)
{
?>
<link rel="stylesheet" href="<?=$css["path"] ?>" type="text/css" media="<?=$css["media"] ?>" >
<?
}
?>