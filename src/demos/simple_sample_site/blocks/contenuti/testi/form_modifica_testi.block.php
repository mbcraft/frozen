<?
JS::require_jquery();
JS::require_script("/js/tiny_mce/jquery.tinymce.js");
?>
<form name="<?=$form_name ?>" action="<?=$action ?>" method="POST">
<?
include_block("contenuti/form/field__id",$testo);
include_block("contenuti/form/field__chiave",$testo);
include_block("contenuti/form/field__titolo",$testo);
include_block("contenuti/form/field__testo",$testo);
include_block("contenuti/form/field__keywords",$testo);
include_block("contenuti/form/field__codice_lingua",$testo);
?>
<br />
<br />
<a href="/admin/contenuti/testi/index.php">Annulla, torna all'elenco dei contenuti</a>&nbsp;&nbsp;
<button type="submit">
    <span><?=$submit_button_text ?></span>
</button>
<? Form::on_success("/admin/contenuti/testi/"); ?>
</form>