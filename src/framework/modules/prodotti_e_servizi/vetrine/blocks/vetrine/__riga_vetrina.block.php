<tr width="100%">
    <td><?=$id_vetrina ?></td>
    <td><?=$titolo ?></td>
    <td>
        <button type="button" onclick="document.location.href='/admin/vetrine/modifica_vetrina.php?id_vetrina=<?=$id_vetrina ?>'">
            <div>
                Modifica vetrina
            </div>
        </button>
        <br />
        <button type="button" onclick="document.location.href='/admin/vetrine/elenco_prodotti_servizi.php?id_vetrina=<?=$id_vetrina ?>'">
            <div>
                Modifica prodotti/servizi
            </div>
        </button>
        <br />
        <form name="form__elimina_vetrina" method="post" action="/actions/vetrine/elimina_vetrina.php" onsubmit="return window.confirm('Sei sicuro di volerla eliminare??');">
            <input type="hidden" name="id_vetrina" value="<?=$id_vetrina ?>" />
            <button type="submit">
                <div>
                    Elimina vetrina
                </div>
            </button>
            <?
            Form::after("/admin/vetrine/");
            ?>
        </form>
        <br />
    </td>
</tr>
