<tr>
    <td align="center"><a target="_immagine_gallery" href="<?=$path ?>"><img border="0px" alt="Immagine gallery" src="<?= image_h($path,50) ?>" title="<?=$title ?>" /></a></td>
    <td><?=$title ?></td>
    <td>
        <form action="/admin/gallery/modifica_immagine.php" method="get">
            <input type="hidden" name="id_gallery_image" value="<?=$id_gallery_image ?>" />
            <input type="submit" name="Modifica dettagli immagine" value="Modifica dettagli immagine" />
            <?
            Form::after("/admin/gallery/index_gallery.php?id_gallery=".$id_gallery);
            ?>
        </form>
        <form action="/actions/gallery_image/delete_from_gallery.php" method="post" onsubmit="return window.confirm('Sei sicuro di voler cancellare questa immagine??');">
            <input type="hidden" name="id_gallery_image" value="<?=$id_gallery_image ?>" />
            <input type="hidden" name="id_gallery" value="<?=$id_gallery ?>" />
            <input type="submit" name="Elimina" value="Elimina" />
            <?
            Form::after("/admin/gallery/index_gallery.php?id_gallery=".$id_gallery);
            ?>
        </form>
    </td>
</tr>