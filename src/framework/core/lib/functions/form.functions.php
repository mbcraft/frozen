<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
function edit_button($entity_name,$id,$edit_path)
{
    ?>
    <form name="modifica_<?=$entity_name ?>_<?=$id ?>" method="POST" action="<?=$edit_path ?>">
        <input type="hidden" name="id" value="<?=$id ?>" />
        <input type="hidden" name="source_page" value="<?=Request::getRequestUri() ?>" />
        <button type="submit">
            <span>Modifica</span>
        </button>
    </form>
    <?php
}

function delete_button($entity_name,$id,$delete_path)
{
    ?>

<form name="elimina_<?=$entity_name ?>_<?=$id ?>" method="POST" action="<?=$delete_path ?>">
    <input type="hidden" name="id" value="<?=$id ?>" />
    <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
        <span>Elimina</span>
    </button>
    <?php 
    Form::after(Request::getRequestUri()); 
    ?>
</form>
    <?php
}

?>