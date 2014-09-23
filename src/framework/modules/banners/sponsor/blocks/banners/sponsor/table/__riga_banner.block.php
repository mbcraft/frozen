<?
$immagine = call("immagini","get",array("id" => $id_immagine));
?>
<tr>
    <td>
        <?=$id_banner ?>
    </td>
    <td>
        <?= $immagine["nome"] ?>
    </td>
    <td>
        <img src="<?=$immagine["save_folder"].$immagine["hash_name"] ?>" height="50" />
    </td>
    <td>
        <a href="<?=$url ?>" target="_blank"><?=$url ?></a>
    </td>
    <td>
        <form name="form__modifica_banner" method="get" action="/admin/banners/sponsor/modifica_banner.php">
            <input type="hidden" name="id_banner" value="<?=$id_banner ?>" />
            <input type="hidden" name="id_banner_group" value="<?=$id_banner_group ?>" />
            <input type="submit" name="Modifica banner" value="Modifica banner" />
        </form>
        <br />
        <form name="form__elimina_banner" method="post" action="/actions/sponsor_banner/delete_banner.php">
            <input type="hidden" name="id_banner" value="<?=$id_banner ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
                <span>Elimina banner</span>
            </button>
            <? Form::on_success("/admin/banners/sponsor/index_banner.php?id_banner_group=".$id_banner_group); ?>
        </form>
    </td>
</tr>