<tr width="100%">
    <td>
        <?=$id_prodotto_servizio_vetrina ?>
    </td>
    <td>
        <?
        if ($nome_immagine!=null)
        {
        ?>
        <img id="nome_immagine_<?=$id_prodotto_servizio_vetrina ?>" src="<?=image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio."/".$nome_immagine,50); ?>" alt="<?=$nome_immagine ?>" />
        <?
        }
        ?>
        </td>
    <td>
        <form name="form__modifica_prodotto_servizio_vetrina" method="post" action="/admin/vetrine/modifica_prodotto_servizio.php?id_vetrina=<?=$_GET["id_vetrina"] ?>">
            <input type="hidden" name="id_prodotto_servizio_vetrina" value="<?=$id_prodotto_servizio_vetrina ?>" />
            <input type="submit" name="Modifica prodotto/servizio" value="Modifica prodotto/servizio" />
        </form>
        <form name="form__elimina_prodotto_servizio_vetrina" method="post" action="/actions/vetrine/elimina_prodotto_servizio_vetrina.php" onsubmit="return window.confirm('Sei sicuro di volerlo eliminare??');">
            <input type="hidden" name="id_prodotto_servizio_vetrina" value="<?=$id_prodotto_servizio_vetrina ?>" />
            <input type="submit" name="Elimina prodotto/servizio" value="Elimina prodotto/servizio" />
            <?
            Form::after("/admin/vetrine/elenco_prodotti_servizi.php?id_vetrina=".$_GET["id_vetrina"]);
            ?>
        </form>
        <br />
    </td>
</tr>