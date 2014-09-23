<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
if (isset($_POST["do"]))
{
    mysql_connect("localhost","root","root");
    mysql_query("CREATE DATABASE ".$_POST["database_name"].";");
    mysql_query("GRANT ALL ON ".$_POST["database_name"].".* TO '".$_POST["user_name"]."' IDENTIFIED BY 'local';");
}
?>

<form action="/framework/utilities/create_database.php" name="form__crea_database">
    <input type="hidden" name="do" value="do" />
    <br />
    Nome database : <input type="text" name="database_name" value="" />
    <br />
    Nome utente :<input type="text" name="user_name" value="" />
    <br />
    Password : local
    <br />
    <br />
    <button type="submit">
        Crea database!
    </button>

</form>