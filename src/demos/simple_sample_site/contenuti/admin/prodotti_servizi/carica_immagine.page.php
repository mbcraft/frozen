<?php
/*
 * Pagina con elenco delle gallery disponibili.
 * */
preload("AdminController");

admin_page("Pannello di amministrazione - Gestione prodotti/servizi");

start_admin_panel("/pannello_centrale","Carica immagine prodotto/servizio");

$id_prodotto_servizio = $_GET["id_prodotto_servizio"];

Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<form name="form__carica_immagine_prodotto_servizio" enctype="multipart/form-data" action="/actions/prodotto_servizio/aggiungi_immagine.php" method="post">
    <input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
    <input type="hidden" name="id_prodotto_servizio" value="<?=$id_prodotto_servizio ?>" />
    Seleziona un'immagine da caricare : <input type="file" name="file"/>

    <br />
    <br />
    <?
    $please_wait = false;
    if (isset(Config::instance()->PRODUCT_IMAGE_RESIZE_BY_WIDTH))
    {
        echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->PRODUCT_IMAGE_RESIZE_BY_WIDTH." pixel di larghezza.";
        $please_wait = true;
    }
    else if (isset(Config::instance()->PRODUCT_IMAGE_RESIZE_BY_HEIGHT))
    {
        echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->PRODUCT_IMAGE_RESIZE_BY_WIDTH." pixel di altezza.";
        $please_wait = true;
    }
    if ($please_wait)
        echo "<br />Questo processo potrebbe richiedere qualche istante.";
    ?>
    <br />
    <br />
    <a href="/admin/prodotti_servizi/carica_immagine.php?id_prodotto_servizio=<?= $id_prodotto_servizio?>">Annulla, torna alla gestione immagini</a>&nbsp;&nbsp;&nbsp;&nbsp;
    <button type="submit">
        <span>Carica</span>
    </button>

    <? Form::on_success("/admin/prodotti_servizi/index_immagini.php?id_prodotto_servizio=".$id_prodotto_servizio) ?>
    <? Form::on_failure("/admin/prodotti_servizi/carica_immagine.php?id_prodotto_servizio=".$id_prodotto_servizio) ?>

</form>
<?
end_admin_panel();

?>