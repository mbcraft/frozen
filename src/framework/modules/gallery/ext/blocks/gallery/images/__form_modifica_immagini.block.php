
<br />
<input type="hidden" name="id_gallery" value="<?=$id_gallery ?>" />
<label for="input_title">Titolo</label> : <input id="input_title" type="text" name="title" value="" size="40"/>
<br />
<?
if (isset($id_gallery_image)) {
?>
<input type="hidden" name="id_gallery_image" value="<?=$id_gallery_image ?>" />
<?
}
else
{
?>
<br />
<input type="hidden" name="MAX_FILE_SIZE" value="10000000" />
Seleziona un'immagine da caricare : <input type="file" name="file"/>
<br />
<?
$please_wait = false;
if (isset(Config::instance()->GALLERY_RESIZE_BY_WIDTH))
{
    echo "<br />";
    echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->GALLERY_RESIZE_BY_WIDTH." pixel di larghezza.";
    $please_wait = true;
}
else if (isset(Config::instance()->GALLERY_RESIZE_BY_HEIGHT))
{
    echo "<br />";
    echo "L'immagine sar&agrave; ridimensionata per avere un massimo di ".Config::instance()->GALLERY_RESIZE_BY_WIDTH." pixel di altezza.";
    $please_wait = true;
}
if ($please_wait)
    echo "<br />Questo processo potrebbe richiedere qualche istante.<br />";
}
?>