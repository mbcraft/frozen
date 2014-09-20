<tr>
    <td>
        <?= $id ?>
    </td>
    <td>
        <?= $nome ?>
    </td>
    <td>
        <form name="modifica_cartella_<?=$id ?>" method="POST" action="/admin/contenuti/cartelle/modifica_cartella.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit">
                <span>Modifica</span>
            </button>
        </form>
        <form name="elimina_cartella_<?=$id ?>" method="POST" action="/actions/folders/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerla eliminare?');">
                <span>Elimina</span>
            </button>
            <? Form::on_success("/admin/contenuti/cartelle/"); ?>
        </form>
    </td>
</tr>