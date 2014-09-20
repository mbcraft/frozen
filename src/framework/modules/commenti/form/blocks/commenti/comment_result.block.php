<?
$success = call("commenti","is_comment_successfull");

$lang = Lang::current();

if ($success)
    include("include/messages/commenti/".$lang."/commento_ok.block.php");
else
    include("include/messages/commenti/".$lang."/errore_commento.block.php");
?>