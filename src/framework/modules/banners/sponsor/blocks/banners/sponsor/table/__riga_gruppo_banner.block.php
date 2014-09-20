<tr>
    <td>
        <?=$id_banner_group ?>
    </td>
    <td>
        <?=$name ?>
    </td>
    <td>
        <form name="form__modifica_gruppo_banner" method="get" action="/admin/banners/sponsor/modifica_gruppo_banner.php">
            <input type="hidden" name="id_banner_group" value="id_banner_group" />
            <input type="submit" name="Modifica gruppo banner" value="Modifica gruppo banner" />
        </form>
        <form name="form__gestisci_banner" method="get" action="/admin/banners/sponsor/index_banner.php">
            <input type="hidden" name="id_banner_group" value="<?= $id_banner_group ?>" />
            <input type="submit" name="Gestisci banner" value="Gestisci banner" />
        </form>
        <form name="form__elimina_gruppo_banner" method="post" action="/actions/sponsor_banner/delete_banner_group.php">
            <input type="hidden" name="id_banner_group" value="<?=$id_banner_group ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
                <span>Elimina gruppo banner</span>
            </button>
            <? Form::on_success("/admin/banners/sponsor/index.php"); ?>
        </form>
    </td>
</tr>