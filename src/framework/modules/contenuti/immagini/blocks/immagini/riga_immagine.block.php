<tr>
    <td>
        <?= $id ?>
    </td>

    <td>
        <?= $nome ?>
    </td>
    <td>
        <img src="<?=$save_folder.$hash_name ?>" height="50" />
    </td>
    <td>
        <form name="modifica_immagine_<?=$id ?>" method="POST" action="/admin/contenuti/immagini/modifica_immagine.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit">
                <span>Modifica</span>
            </button>
        </form>
        <form name="elimina_immagine_<?=$id ?>" method="POST" action="/actions/immagini/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerla eliminare?');">
                <span>Elimina</span>
            </button>
            <? Form::on_success("/admin/contenuti/immagini/"); ?>
        </form>
    </td>
</tr>