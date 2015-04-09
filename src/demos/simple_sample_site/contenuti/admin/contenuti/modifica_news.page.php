<?php

Html::set_title("Pannello di amministrazione - Modifica news");
Html::set_description("");
Html::set_keywords(array(""));

Html::set_layout("admin");


$news = call("news","get_from_id");

start_sector("/content");
?>

<form action="/actions/contenuti/modifica_news.php" method="POST">
<?php
include_block ("contenuti/form_modifica_testi",$news);
include_block("contenuti/form_modifica_news",$news);
?>


<br />
<input type="submit" name="Salva modifiche" value="Salva modifiche" />
</form>
<?
end_sector();



start_sector("/bottom");
?>
<center>
Powered by MBCRAFT
</center>
<?
end_sector();
?>
