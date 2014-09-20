<table class="tabella_admin">
    <thead>
        <tr>
            <th>
                Nome rotator
            </th>
            <th>
                Comandi
            </th>
        </tr>
    </thead>
    <tbody>
    <?
    foreach ($elenco_rotator as $rotator)
    {
?>
    <tr>
        <td>
            <?=$rotator ?>
        </td>
        <td>
            <form name="form__modifica_rotator" method="GET" action="/admin/rotator/modifica_rotator.php">
                <input type="hidden" name="rotator_name" value="<?=$rotator ?>" />
                <button type="submit">
                    <div>
                        Modifica
                    </div>
                </button>
            </form>
        </td>
    </tr>
    <?
    }
    ?>
    </tbody>

</table>