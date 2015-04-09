<?
$selected_string = isset($__selected) && $__selected ? 'checked="checked"' : "";

?>
<div align="center" style="padding:3px;margin:3px;border:#000000 1px solid;">
    <label for="immagine_prodotto_servizio_<?=$id_immagine_prodotto_servizio ?>">
        <img style="padding-bottom:3px;" src="<?= image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio."/".$nome_immagine,50); ?>" alt="<?=$obj["nome_immagine"] ?>" /><br />
    </label>
    <input id="immagine_prodotto_servizio_<?=$id_immagine_prodotto_servizio ?>" type="radio" name="nome_immagine" value="<?=$nome_immagine ?>" <?=$selected_string ?>/>
</div>





