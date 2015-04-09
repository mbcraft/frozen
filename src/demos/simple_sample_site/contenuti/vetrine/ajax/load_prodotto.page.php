<?
$prodotto_servizio = call("prodotto_servizio","get",array("id_prodotto_servizio" => Params::get("id_prodotto_servizio")));

$immagini_prodotto_servizio = call("prodotto_servizio","index_immagini",array("__filter_id_prodotto_servizio__EQUAL"=> Params::get("id_prodotto_servizio")));

$total_width = 0;
foreach ($immagini_prodotto_servizio as $img)
{
    $image_data = ImageUtils::get_image_data(image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$prodotto_servizio["id_prodotto_servizio"]."/".$img["nome_immagine"],200));

    $total_width += $image_data["width"]+10;
}

?>
<div>
    <div align="center">
        <h2 style="font-size:20px;font-family:fantasy;"><?=$prodotto_servizio["nome"] ?></h2>
        <br />

        <?
        foreach ($immagini_prodotto_servizio as $img)
        {
        ?>
            <div style="padding:5px;display:inline-block;">
                <img src="<?= image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$prodotto_servizio["id_prodotto_servizio"]."/".$img["nome_immagine"],200) ?>" alt="" />
            </div>
       <?
        }
        ?>

        <br />
        <br />
        <div align="left">
            <?=$prodotto_servizio["descrizione"] ?>
        </div>
        
        <br />
        <br />
    </div>
    <?

?>
</div>