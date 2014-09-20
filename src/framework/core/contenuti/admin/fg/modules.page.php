<?php

if (SuperAdminUtils::is_logged())
{
Html::set_title("Pannello di amministrazione del framework");
Html::set_layout("admin_fg");

start_sector("/pannello_centrale");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
<a href="/framework/utilities/index.php"><span style="padding:5px;margin:5px;border: 1px; border-style: solid;">Vai alle utilities</span></a><center><span style="font-size:20px;font-weight: bold; "><?=Host::current() ?></span></center>
<table style="width:100%; border:1px; border-color: #000100; border-width: 2px; border-style: solid;">
    <tr>
        <td style="padding: 20px; width: 50%; vertical-align: top; border-left:1px; border-left-color: #000100; border-left-width: 2px; border-left-style: solid;">
            <?
            include_block("modules/available_modules",array("available_modules" => call("modules","get_available_modules")));
            ?>
        </td>
        <td style="padding: 20px; width: 50%; vertical-align: top;  border-right:1px; border-right-color: #000100; border-right-width: 2px; border-right-style: solid;">
            <?
            include_block("modules/installed_modules",array("installed_modules" => call("modules","get_installed_modules")));
            ?>
        </td>
    </tr>
</table>
<?
end_sector();
}
?>