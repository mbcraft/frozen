<tr>
    <td align="center"><image src="/immagini/grafica/gallery/cartella_gallery.png" /></td>
    <td><?=$name ?></td>
    <td>
        <form name="form__modifica_gallery" method="POST" action="/actions/gallery/set_current_folder.php">
            <input type="hidden" name="folder" value="<?=call("gallery","get_current_folder").$name ?>" />
            <input type="submit" name="Modifica immagini" value="Modifica immagini" />
            <?
            Form::after("/admin/gallery/modifica_immagini.php");
            ?>
        </form>
        <form name="form__elimina_gallery" method="POST" action="/actions/gallery/delete_gallery.php" onsubmit="return window.confirm('Sei sicuro di volerla eliminare??');">
            <input type="hidden" name="gallery_name" value="<?=$name ?>" />
            <input type="submit" name="Elimina gallery" value="Elimina gallery" />
            <?
            Form::after("/admin/gallery/");
            ?>
        </form>
    </td>
</tr>