<?
JS::require_jquery();
JS::require_script("/js/tiny_mce/jquery.tinymce.js");
?>

<? if (isset($id)) { ?>
    <label for="input_id">ID : </label><input id="input_id" type="text" name="id" readonly="readonly" value="<?=$id ?>" /><br />
<? } ?>

    <label for="input_nome">Nome : </label><input id="input_nome" type="text" name="nome" value="<?=$nome ?>" /><br />