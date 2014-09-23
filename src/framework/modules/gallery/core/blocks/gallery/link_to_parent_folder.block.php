<div class="azione">
    <table>
        <tr>
            <td>
                <image src="/immagini/grafica/gallery/cartella_back.png" alt="Back" />
            </td>
            <td></td>
            <td>
                <form name="form__torna_su" method="post" action="/actions/gallery/set_current_folder.php">
                    <input type="hidden" name="folder" value="<?=call("gallery","get_parent_folder"); ?>" />
                    <input type="submit" name="Torna su" value="Torna su" />
                    <? Form::after("/admin/gallery/"); ?>
                </form>
            </td>
        </tr>
    </table>
</div>