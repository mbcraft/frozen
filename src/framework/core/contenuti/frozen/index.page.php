<?php

if (SuperAdminUtils::check_login() || SuperAdminUtils::is_logged())
{
    SuperAdminUtils::set_logged();
    header("Location: /frozen/modules.php");
}
else
{

Html::set_title("Pannello di amministrazione del framework");
Html::set_layout("admin_frozen");

start_sector("/pannello_centrale");
?>
<?
Flash::write_ok_messages();
Flash::write_warning_messages();
Flash::write_error_messages();
?>
Enter code :
<form name="admin_form" method="post" action="/frozen/index.php">
    <input type="password" name="code" value="" size="20"/>&nbsp;&nbsp;&nbsp;
    <input type="submit" name="Enter" value="Enter" />
</form>
<?
end_sector();
}
?>