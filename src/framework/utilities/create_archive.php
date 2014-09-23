<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

if (isset($_POST["compress"]))
{
    FGArchive::compress(new File($_POST["target_file"]),new Dir($_POST["root_dir"]),$_POST["description"],$_POST["properties"]);
    $result = "Archive created.";
}
else
    $result = null;


?>
<html>
    <head>
        <title>Create a Frostlab gate archive (FGA)</title>
    </head>
    <body>
        <?
            if ($result!==null) echo "<h1>".$result."</h1>";
        ?>
        <form name="create_archive" method="post" action="/framework/utilities/create_archive.php">
            <input type="hidden" name="compress" value="compress" />
            Description : <input type="text" name="description" value="" size="40"/><br />
            Properties : <br />
            <textarea name="properties" rows="7" cols="30"></textarea><br />
            Root dir : <input type="text" name="root_dir" value="/" /><br />
            Target file : <input type="text" name="target_file" value="/package.fga" /><br />
            <br />
            <button type="submit">
                <div>
                    Create
                </div>
            </button>
        </form>
    </body>
</html>