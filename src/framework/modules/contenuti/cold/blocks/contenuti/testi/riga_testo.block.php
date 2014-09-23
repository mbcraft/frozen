<tr>
    <td>
        <?= $id ?>
    </td>
    <td>
        <?= $chiave ?>
    </td>
    <td>
        <?= $titolo ?>
    </td>
    <td>
        <?= $codice_lingua ?>
    </td>
    <td>
        <form name="modifica_contenuto_<?=$id ?>" method="POST" action="/admin/contenuti/testi/modifica_testo.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit">
                <span>Modifica</span>
            </button>
        </form>
        <form name="elimina_contenuto_<?=$id ?>" method="POST" action="/actions/testi/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
                <span>Elimina</span>
            </button>
            <? Form::on_success("/admin/contenuti/testi/"); ?>
        </form>
    </td>
</tr>