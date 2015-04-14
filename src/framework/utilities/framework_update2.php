<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
$real_script_name = str_replace("/",DIRECTORY_SEPARATOR,$_SERVER['SCRIPT_NAME']);
$site_root_path = str_replace($real_script_name, "", $_SERVER['SCRIPT_FILENAME']);
define ("SITE_ROOT_PATH",$site_root_path);
$inc_path = get_include_path().PATH_SEPARATOR.$site_root_path;

set_include_path($inc_path);

require_once("io/__FileSystemElement.class.php");
require_once("io/FileSystemUtils.class.php");
require_once("io/Dir.class.php");
require_once("io/File.class.php");
require_once("io/FileReader.class.php");
require_once("io/FileWriter.class.php");
require_once("utils/FFArchive.class.php");



?>
<html>
<head>
    <title>Frostlab gate framework updater</title>
</head>
<body>
<?
if (isset($_POST["do"]))
{
    echo "Archiving ...";
    FFArchive::compress(new File("/framework/utilities/framework.ffa"),new Dir("/framework/core"));
}
else
{
?>
<form name="form__framework_updater" action="/framework/utilities/framework_update2.php" method="POST">
    <input type="hidden" name="do" value="do" />
    <br />
    <button type="submit">
        <div>
            Aggiorna framework
        </div>
    </button>
</form>
<?
}
?>
</body>
</html>