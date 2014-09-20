<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");


if (isset($_POST["nome_modulo"]))
{
    $d = new Dir("/".FRAMEWORK_MODULES_PATH.$_POST["nome_modulo"]);
    
    $module_deleted = $d->delete(true) && $d->exists();
}


?>
<html>
    <head>
        
    </head>
    <body>
        <?
        if ($module_deleted)
            echo "Modulo eliminato!!";
        ?>
        
        <form name="form__elimina_modulo" method="POST" action="/framework/utilities/delete_module.php">
            Nome del modulo : <input type="text" name="nome_modulo" value="" />
            <br />
            <input type="submit" name="Elimina modulo" value="Elimina modulo" />
        </form>
    </body>
</html>
