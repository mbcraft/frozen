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
        <form name="modifica_contenuto_<?=$id ?>" method="POST" action="/admin/contenuti/modifica_contenuto.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <input type="submit" name="Modifica" value="Modifica" />
        </form>
        <form name="elimina_contenuto_<?=$id ?>" method="POST" action="/actions/contenuti/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <input type="submit" name="Elimina" value="Elimina" />
            <? Form::on_success("/admin/contenuti/"); ?>
        </form>
    </td>
</tr>