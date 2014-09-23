<tr>
    <td align="center"><a target="_immagine_gallery" href="<?=$path ?>"><img border="0px" alt="Immagine gallery" src="<?=ImagePicker::get_image_by_height($path,50) ?>" title="<?=$name ?>" /></a></td>
    <td><?=$name ?></td>
    <td>
        <!-- comandi per immagine -->
        <form action="/actions/gallery/delete_image.php" method="post" onsubmit="return window.confirm('Sei sicuro di voler cancellare questa immagine??');">
            <input type="hidden" name="image_name" value="<?=$name ?>" />
            <input type="submit" name="Elimina" value="Elimina" />
            <?
            Form::after("/admin/gallery/modifica_immagini.php");
            ?>
        </form>
    </td>
</tr>