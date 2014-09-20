<tr>
    <td><img src="<?=RotatorController::ROTATOR_GALLERIES_ROOT_PATH.$rotator_name."/".$image ?>" width="100" /></td>
    <td>
        <form name="form__elimina_immagine_rotator" method="POST" action="/actions/rotator/delete_rotator_image.php">
            <input type="hidden" name="rotator_name" value="<?=$rotator_name ?>" />
            <input type="hidden" name="image" value="<?=$image ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerlo eliminare?');">
                <div>
                    Elimina
                </div>
            </button>
            <?
            Form::after("/admin/rotator/modifica_rotator.php?rotator_name=".$rotator_name);
            ?>
        </form>
    </td>
</tr>