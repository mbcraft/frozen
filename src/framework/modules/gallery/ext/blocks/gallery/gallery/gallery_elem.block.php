<tr>
    <td align="center"><image src="/immagini/grafica/gallery/gallery.png" /></td>
    <td><?=$title ?></td>
    <td>
        
        <form name="form__gestisci_immagini_gallery" method="get" action="/admin/gallery/index_gallery.php" >
            <input type="hidden" name="id_gallery" value="<?=$id_gallery ?>" />
            <input type="submit" name="Gestisci immagini" value="Gestisci immagini" />
        </form>
        <form name="form__modifica_dettagli_gallery" method="get" action="/admin/gallery/modifica_gallery.php" >
            <input type="hidden" name="id_gallery" value="<?=$id_gallery ?>" />
            <input type="submit" name="Modifica dettagli gallery" value="Modifica dettagli gallery" />
        </form>
        <form name="form__elimina_gallery" method="post" action="/actions/gallery/delete_gallery.php" onsubmit="return window.confirm('Sei sicuro di volerla eliminare?');">
            <input type="hidden" name="id_gallery" value="<?=$id_gallery ?>" />
            <input type="submit" name="Elimina gallery" value="Elimina gallery" />
            <?
            Form::after("/admin/gallery/index_collection.php?id_gallery_collection=".$id_gallery_collection);
            ?>
        </form>
    </td>
</tr>