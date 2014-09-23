<tr>
    <td>
        <?= $id ?>
    </td>

    <td>
        <?= $nome ?>
    </td>
    <td>
        <form name="modifica_documento_<?=$id ?>" method="POST" action="/admin/media/documenti/modifica_documento.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit">
                <span>Modifica</span>
            </button>
        </form>
        <form name="elimina_documenti_<?=$id ?>" method="POST" action="/actions/documenti/delete.php">
            <input type="hidden" name="id" value="<?=$id ?>" />
            <button type="submit" onclick="return window.confirm('Sei sicuro di volerla eliminare?');">
                <span>Elimina</span>
            </button>
            <?
            $folder = $_GET["folder"];
            Form::on_success("/admin/media/documenti/?folder=".$folder); 
            ?>
        </form>
    </td>
</tr>