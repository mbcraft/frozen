<?
if (isset($id_gallery_collection))
{
?>
<input type="hidden" name="id_gallery_collection" value="<?=$id_gallery_collection ?>" />
<?
}
?>
Titolo : <input type="text" name="title" value="<?=$title ?>" /><br />
Descrizione : <textarea name="description" rows="5" cols="10"><?=$description ?></textarea><br />   
<br />
Chiave : <input type="text" name="key" value="<?=$key ?>" /><br />