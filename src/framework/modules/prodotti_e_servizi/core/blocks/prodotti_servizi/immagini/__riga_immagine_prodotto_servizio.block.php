<tr>
    <td>
        <img src="<?=image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio."/".$nome_immagine,50); ?>" alt="<?=$nome_immagine ?>"/>
    </td>
    <td>
        <?=$nome_immagine ?>
    </td>
    <td>
        <form name="form__elimina_immagine_prodotto_servizio" method="post" action="/actions/prodotto_servizio/elimina_immagine.php" onsubmit="return window.confirm('Sei sicuro di volerlo eliminare??');">
            <input type="hidden" name="id_prodotto_servizio" value="<?=$id_prodotto_servizio ?>" />
            <input type="hidden" name="image_name" value="<?=$nome_immagine ?>" />
            <input type="submit" name="Elimina immagine" value="Elimina immagine" />
            <?
            Form::after("/admin/prodotti_servizi/modifica.php?id_prodotto_servizio=".$id_prodotto_servizio);
            ?>
        </form>
    </td>
</tr>