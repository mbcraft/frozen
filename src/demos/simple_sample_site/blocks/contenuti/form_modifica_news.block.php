
<? if (isset($id_news)) { ?>
<input type="hidden" name="id_news" value="<?=$id_news ?>" />
<? } ?>
<label for="select_stato_news">Stato news : </label>
<select name="stato_news">
    <option value="0">Nuova</option>
    <option value="1">Pubblicata</option>
    <option value="2">Archiviata</option>
</select><br />
<label for="input_dataora_creazione">Data creazione :</label><input id="input_dataora_creazione" type="text" name="dataora_creazione" value="<?=$dataora_creazione ?>" disabled="disabled" /><br />
<label for="input_dataora_pubblicazione">Data pubblicazione :</label><input id="input_dataora_pubblicazione" type="text" name="dataora_pubblicazione" value="<?=$dataora_pubblicazione ?>"/><br />
<label for="input_dataora_archiviazione">Data archiviazione :</label><input id="input_dataora_archiviazione" type="text" name="dataora_archiviazione" value="<?=$dataora_archiviazione ?>"/><br />
