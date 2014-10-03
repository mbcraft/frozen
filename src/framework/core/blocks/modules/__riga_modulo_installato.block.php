<?php
if (isset($modulo))
    extract($modulo);
if (isset($global))
    extract($global);
if (isset($properties))
    extract($properties);
if (isset($additional))
    extract($additional);
?>
<tr>
    <td colspan="6"><hr/></td>
</tr>
<tr>
    <td><?= $nome_categoria ?></td>
    <td><?= $nome_modulo ?></td>
    <td><?= $major_version.".".$minor_version.".".$revision ?></td>
    <td>
        <?php
        if (!isset($missing_modules))
            $missing_modules = array();
        if (count($missing_modules)==0)
            echo "OK";
        else
        {
            foreach ($missing_modules as $m)
            {
                echo $m.",";
            }
        }
        ?>
    </td>
    <td>
        <?php
        if (!isset($missing_services))
            $missing_services = array();
        if (count($missing_services)==0)
            echo "OK";
        else
        {
            foreach ($missing_services as $s)
            {
                echo $s.",";
            }
        }
        ?>
    </td>
    <td>
        <div class="module_command_list">
        <?php
        $commands = InstalledModules::get_all_available_actions($nome_categoria,$nome_modulo);

        foreach ($commands as $cmd)
            if ($cmd!="install" && $cmd!="uninstall")
        {
            ?>
            <form method="post" action="/actions/modules/execute_action.php">
                <input type="hidden" name="nome_categoria" value="<?=$nome_categoria ?>" />
                <input type="hidden" name="nome_modulo" value="<?=$nome_modulo ?>" />
                <input type="hidden" name="command" value="<?=$cmd ?>" />
                <input class="module_command_button" type="submit" name="<?=$cmd ?>" value="<?=$cmd ?>" onclick="javascript:return confirm('Sei sicuro?');" />
                <? Form::on_success("/admin/fg/"); ?>
            </form>
            <?php
        }
        ?>
        <form method="post" action="/actions/modules/uninstall.php">
            <input type="hidden" name="nome_categoria" value="<?=$nome_categoria ?>" />
            <input type="hidden" name="nome_modulo" value="<?=$nome_modulo ?>" />
            <input class="module_command_button" type="submit" name="Disinstalla" value="Disinstalla" onclick="javascript:return confirm('Sei sicuro di voler disinstallare questo modulo?');" />
            <? Form::on_success("/admin/fg/"); ?>
        </form>
        </div>
    </td>
</tr>