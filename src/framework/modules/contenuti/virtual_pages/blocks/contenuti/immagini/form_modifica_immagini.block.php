<?
JS::require_jquery();
JS::require_script("/js/tiny_mce/jquery.tinymce.js");
?>

<? if (isset($id)) { ?>
    <label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?=$id ?>" /><br />
<? } ?>

    <label for="input_my_file">File : </label><input id="input_my_file" type="file" name="my_file" /><br />
    <label for="input_nome">Nome : </label><input id="input_nome" type="text" name="nome" value="<?=$nome ?>" /><br />
    <label for="input_descrizione">Descrizione : </label><br /><textarea id="input_descrizione" type="text" name="descrizione" ><?=$descrizione ?></textarea><br />
    <label for="input_keywords">Keywords : </label><input id="input_keywords" type="text" name="keywords" value="<?=$keywords ?>" /><br />