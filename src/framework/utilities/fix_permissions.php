<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

$d = new Dir("/");

function fix_permissions($ff)
{
    $ff->setPermissions("-rwxrwxr-x");

    if ($ff->isDir())
    {
        $all_files = $ff->listFiles();
        foreach ($all_files as $f)
        {
            fix_permissions($f);
        }
    }
}

echo "<br /><br /><br />";
echo "Fixing permissions ...";

fix_permissions($d);

echo "All permissions fixed!!";
?>