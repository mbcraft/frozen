<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

$full_dir = SITE_ROOT_PATH."/".FRAMEWORK_CORE_PATH."lib/functions/";

$all_files = scandir($full_dir);

foreach ($all_files as $f)
{
    if (strpos($f,".functions.php")===strlen($f)-strlen(".functions.php"))
        require_once(FRAMEWORK_CORE_PATH."lib/functions/".$f);
}

?>