<?
extract($modulo);
?>
<tr>
    <td colspan="4"><hr/></td>
</tr>
<tr>
    <td><?= $nome_categoria ?></td>
    <td><?= $nome_modulo ?></td>
    <td><?= $properties["major_version"].".".$properties["minor_version"].".".$properties["revision"] ?></td>
    <td>
        <div class="module_command_list">
        <form name="installa_modulo" method="post" action="/actions/modules/install.php">
            <input type="hidden" name="nome_categoria" value="<?=$nome_categoria ?>" />
            <input type="hidden" name="nome_modulo" value="<?=$nome_modulo ?>" />
            <input class="module_command_button" type="submit" name="Installa" value="Installa" onclick="javascript:return confirm('Sei sicuro di voler installare questo modulo?');" />
            <? Form::on_success("/admin/fg/"); ?>
        </form>
        <?
        if (isset(Config::instance()->FRAMEWORK_ENABLE_MODULES_DELETE) && Config::instance()->FRAMEWORK_ENABLE_MODULES_DELETE===true)
        {
        ?>
            <form name="installa_modulo" method="post" action="/actions/modules/delete.php">
                <input type="hidden" name="nome_categoria" value="<?=$nome_categoria ?>" />
                <input type="hidden" name="nome_modulo" value="<?=$nome_modulo ?>" />
                <input class="module_command_button" type="submit" name="Delete" value="Elimina" onclick="javascript:return confirm('Sei sicuro di voler eliminare questo modulo?');" />
                <? Form::after("/admin/fg/"); ?>
            </form>
        <?
        }
        ?>
        </div>
    </td>
</tr>
