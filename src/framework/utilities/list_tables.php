<?
/* This software is released under the BSD license. Full text at project root -> license.txt */
require_once("../init.php");

DB::openDefaultConnection();

$db_description = DB::newDatabaseDescription();

$all_tables = $db_description->getAllTables();

foreach ($all_tables as $table_name)
{
    echo "<br />Tabella : ".$table_name."<br /><br />";
    $fields_description = DB::newTableFieldsDescription($table_name);
    $all_fields = $fields_description->getAllFields();

    echo "<table border='1px'>";
    foreach ($all_fields as $field => $props)
    {
    echo "  <tr>";
        echo "      <td>";
        echo $field;
        echo "      </td>";
    echo "  </tr>";
    }
    echo "</table>";
}

DB::closeConnection();

?>