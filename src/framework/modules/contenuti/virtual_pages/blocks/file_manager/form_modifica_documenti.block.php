<? if (isset($id)) { ?>
    <label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?=$id ?>" /><br />
<? } ?>

    <label for="input_chiave">Chiave : </label><input id="input_chiave" type="text" name="chiave" value="<?=$chiave ?>" /><br />
    <label for="input_nome">Nome : </label><input id="input_nome" type="text" name="nome" value="<?=$nome ?>" /><br />
    <label for="input_keywords">Keywords : </label><input id="input_keywords" type="text" name="keywords" value="<?=$keywords ?>" /><br />
    <label for="select_codice_lingua">Lingua : </label>
    <select name="codice_lingua" id="select_codice_lingua">
        <option value="it">Italiano</option>
    </select><br />
<? if (isset($id)) { ?>
    <label for="input_upload_file">Seleziona file :</label>
    <input id="input_upload_file" type="file" name="my_file" value="" size="80" />
    <input type="hidden" name="current_folder" value="<?=$current_folder ?>" />
<? } ?>