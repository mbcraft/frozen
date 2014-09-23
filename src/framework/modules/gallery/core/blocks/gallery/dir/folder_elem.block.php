<tr>
    <td align="center"><image src="/immagini/grafica/gallery/cartella.png" alt="Cartella" /></td>
    <td><a href="/actions/gallery/set_current_folder.php?folder=<?=call("gallery","get_current_folder").$name ?>"><?=$name ?></a></td>
    <td>
        <form name="form__elimina_cartella" method="post" action="/actions/gallery/delete_folder.php" onsubmit="return window.confirm('Sei sicuro di volerla eliminare?');">

            <input type="submit" name="Elimina cartella" value="Elimina cartella" />
            <?
            Form::after("/admin/gallery/")
            ?>
        </form>
    </td>
</tr>