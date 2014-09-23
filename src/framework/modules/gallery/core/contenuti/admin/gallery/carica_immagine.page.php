<?php

preload("AdminController");

admin_page("Pannello di amministrazione - Gestione gallery");

start_admin_panel("/pannello_centrale","Carica immagine");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form__carica_immagine_gallery" enctype="multipart/form-data" action="/actions/gallery/add_image.php" method="post">
    <br />
    <label for="input_title">Titolo</label> : <input id="input_title" type="text" name="title" value="<?=$title ?>" size="70"/>
    <br />
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    Seleziona un'immagine da caricare : <input type="file" name="file"/>

    <br />
    <br />
    <?
    $please_wait = false;
    if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
    {
        echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->GALLERY_RESIZE_BY_WIDTH." pixel di larghezza.";
        $please_wait = true;
    }
    else if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
    {
        echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->GALLERY_RESIZE_BY_WIDTH." pixel di altezza.";
        $please_wait = true;
    }
    if ($please_wait)
        echo "<br />Questo processo potrebbe richiedere qualche istante.";
    ?>
    <br />
    <br />
    <a href="/admin/gallery/">Annulla, torna alla gestione gallery</a>&nbsp;&nbsp;
    <button type="submit">
        <span>Carica</span>
    </button>

    <? Form::on_success("/admin/gallery/modifica_immagini.php") ?>
    <? Form::on_failure("/admin/gallery/carica_immagine.php") ?>

</form>
<?
end_admin_panel();

?>