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
<div style="min-width:<?=$total_width ?>px;">
    <div align="center">
        <h2 style="font-size:20px;font-family:fantasy;"><?=$prodotto_servizio["nome"] ?></h2>
        <br />
        <table>
            <tr>
                <?
                foreach ($immagini_prodotto_servizio as $img)
                {
                ?>
                <td>
                    <div style="padding:5px;">
                        <img src="<?= image_h(ProdottoServizioController::PRODUCT_IMAGE_DIR."/".$prodotto_servizio["id_prodotto_servizio"]."/".$img["nome_immagine"],200) ?>" alt="<?=$img["nome_immagine"] ?>" />
                    </div>
                </td>
                    
               <?
                }
                ?>
            </tr>
        </table>
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