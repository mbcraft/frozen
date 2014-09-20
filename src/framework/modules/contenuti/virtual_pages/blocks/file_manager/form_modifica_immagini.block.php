<? if (isset($id)) { ?>
    <label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?=$id ?>" /><br />
<? } ?>

    <label for="input_nome">Nome : </label><input id="input_nome" type="text" name="nome" value="<?=$nome ?>" /><br />
<? if (isset($id)) { ?>
    <label for="input_upload_file">Seleziona file :</label>
    <input id="input_upload_file" type="file" name="my_file" value="" size="80" />
    <input type="hidden" name="current_folder" value="<?=$current_folder ?>" />
<? } ?>