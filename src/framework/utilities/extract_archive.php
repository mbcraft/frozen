<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

if (isset($_POST["extract"]))
{
    FFArchive::extract(new File($_POST["target_file"]),new Dir($_POST["target_dir"]));
    $result = "Archive extracted.";
}
else
    $result = null;


?>
<html>
<head>
    <title>Extract a Frozen Framework Archive (FFA)</title>
</head>
<body>
<?
if ($result!==null) echo "<h1>".$result."</h1>";
?>
<form name="create_archive" method="post" action="/framework/utilities/extract_archive.php">
    <input type="hidden" name="extract" value="extract" />
    Archive file : <input type="text" name="target_file" value="/package.ffa" /><br />
    Target dir : <input type="text" name="target_dir" value="/" /><br />
    <br />
    <button type="submit">
        <div>
            Extract
        </div>
    </button>
</form>
</body>
</html>