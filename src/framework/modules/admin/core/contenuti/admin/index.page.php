<?php

preload("AdminController");

admin_page("Benvenuto",false);

if (!call("admin","is_logged"))
{
    start_admin_panel("/pannello_centrale","Pannello di amministrazione");
    include("include/messages/admin/admin_welcome.php.inc");
    end_admin_panel();
}
else
{
    start_admin_panel("/pannello_centrale","Pannello di amministrazione");
    include("include/messages/admin/admin_welcome_logged.php.inc");
    end_admin_panel();
}

?>