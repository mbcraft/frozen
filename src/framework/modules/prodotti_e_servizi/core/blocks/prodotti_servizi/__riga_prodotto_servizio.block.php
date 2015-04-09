<tr>
    <td>
        <?= $id_prodotto_servizio ?>
    </td>
    <td>
        <?= $nome ?>
    </td>
    <td>
        <table>
            <tr>
                <td>
                    <form name="form__modifica_prodotto_servizio" method="get" action="/admin/prodotti_servizi/modifica.php">
                        <input type="hidden" name="id_prodotto_servizio" value="<?=$id_prodotto_servizio ?>" />
                        <button type="submit">
                            <div>Modifica</div>
                        </button>
                    </form>
                </td>
            </tr>
            <tr>
                <td>
                    <form name="form__elimina_prodotto_servizio" method="post" action="/actions/prodotto_servizio/elimina.php" onsubmit="return window.confirm('Sei sicuro di volerlo eliminare??');">
                        <input type="hidden" name="id_prodotto_servizio" value="<?=$id_prodotto_servizio ?>" />
                        <button type="submit">
                            <div>Elimina</div>
                        </button>
                        <?
                        Form::after("/admin/prodotti_servizi/");
                        ?>
                    </form>
                </td>
            </tr>
        </table>
    </td>
</tr>