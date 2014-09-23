<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

if (isset($_POST["do"]))
{

    $username = $_POST["username"];
    $password = $_POST["password"];

    $co_command = "svn co --username ".$username." --password ".$password." http://svn.frostlab.it/common/Charme/trunk/framework/ ".SITE_ROOT_PATH."/";

    system($co_command);
}
?>
<html>
<head>
    <title>Frostlab gate framework updater</title>
</head>
<body>
<form name="form__framework_updater" action="/framework/utilities/framework_update.php">
    <input type="hidden" name="do" value="do" />
    <br />
    Username : <input type="text" name="username" value="" />
    <br />
    Password  :<input type="password" name="password" value="" />
    <br />
    <button type="submit">
        <div>
            Aggiorna framework
        </div>
    </button>
</form>
</body>
</html>