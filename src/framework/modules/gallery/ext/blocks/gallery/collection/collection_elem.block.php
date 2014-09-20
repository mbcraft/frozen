<tr>
    <td align="center"><img src="/immagini/grafica/gallery/gallery_collection.png" alt="Collezione" /></td>
    <td><?=$title ?></td>
    <td>
        <form name="form__gestisci_collection" method="get" action="/admin/gallery/index_collection.php" >
            <input type="hidden" name="id_gallery_collection" value="<?=$id_gallery_collection ?>" />
            <input type="submit" name="Gestisci gallery" value="Gestisci gallery" />
        </form>
        <form name="form__modifica_dettagli_collection" method="get" action="/admin/gallery/modifica_collection.php" >
            <input type="hidden" name="id_gallery_collection" value="<?=$id_gallery_collection ?>" />
            <input type="submit" name="Modifica dettagli raccolta" value="Modifica dettagli raccolta" />
        </form>
        <form name="form__elimina_collection" method="post" action="/actions/gallery_collection/delete_collection.php" onsubmit="return window.confirm('Sei sicuro di volerla eliminare?');">
            <input type="hidden" name="id_gallery_collection" value="<?=$id_gallery_collection ?>" />
            <input type="submit" name="Elimina raccolta" value="Elimina raccolta" />
            <?
            Form::after("/admin/gallery/")
            ?>
        </form>
    </td>
</tr>