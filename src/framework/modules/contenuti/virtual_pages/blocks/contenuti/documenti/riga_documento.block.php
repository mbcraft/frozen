<tr>
    <td>
        <?= $id ?>
    </td>
    <td>
        <?= $chiave ?>
    </td>
    <td>
        <?= $nome ?>
    </td>
    <td>
        <?= $codice_lingua ?>
    </td>
    <td>
        <form name="modifica_documento_<?=$id ?>" method="POST" action="/admin/contenuti/documenti/modifica_documento.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit">
                <span>Modifica</span>
            </button>
        </form>
        <form name="elimina_documento_<?=$id ?>" method="POST" action="/actions/documenti/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
                <span>Elimina</span>
            </button>
            <? Form::on_success("/admin/contenuti/documenti/"); ?>
        </form>
    </td>
</tr>