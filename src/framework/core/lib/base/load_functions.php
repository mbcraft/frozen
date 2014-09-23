<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

$full_dir = SITE_ROOT_PATH."/".FRAMEWORK_CORE_PATH."lib/functions/";

$all_files = scandir($full_dir);

foreach ($all_files as $f)
{
    if (strpos($f,".functions.php")===strlen($f)-strlen(".functions.php"))
        require_once(FRAMEWORK_CORE_PATH."lib/functions/".$f);
}

?>