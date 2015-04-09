<div onclick="open_shower('/vetrine/ajax/load_prodotto.php',{ id_prodotto_servizio : <?=$id_prodotto_servizio ?>});" align="center" style="margin:3px;border:5px;cursor: pointer;">
    <img style="border:0px;" src="<?= image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$id_prodotto_servizio."/".$nome_immagine,80) ?>" alt="<?=$nome_immagine ?>" title="Clicca sull'immagine per maggiori dettagli."/>
</div>
