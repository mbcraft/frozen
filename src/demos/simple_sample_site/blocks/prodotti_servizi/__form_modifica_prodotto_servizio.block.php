<?
if (isset($id_prodotto_servizio)) {
    ?>
<input type="hidden" name="id_prodotto_servizio" value="<?=$id_prodotto_servizio ?>" />
<?
}
?>
Nome del prodotto : <input type="text" name="nome" value="<?= isset($nome) ? $nome : "" ?>" /><br />
<br />
Descrizione :
<textarea id="textarea_testo" name="descrizione"><?=isset($descrizione) ? $descrizione : "" ?></textarea><br />
<?
include_block("widgets/html_editor",array("htmleditor_field_name" => "descrizione"));
?>
<br />
Prezzo (iva esclusa) : <input type="text" name="prezzo_iva_esclusa" value="<?=isset($prezzo_iva_esclusa) ? $prezzo_iva_esclusa : "" ?>" />


