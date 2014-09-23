<?php


/* This software is released under the BSD license. Full text at project root -> license.txt */

require_once("../init.php");

$modules = AvailableModules::get_all_available_modules();

echo "Validating all available modules ...<br /><br />";

foreach ($modules as $mod)
{

    echo "Modulo : ".$mod["nome_categoria"]."/".$mod["nome_modulo"]."<br />";
    $ok = ModuleUtils::validate_module($mod["nome_categoria"], $mod["nome_modulo"]);
    if ($ok) echo "Ok.<br />";
    echo "<br /><br />";
}

?>