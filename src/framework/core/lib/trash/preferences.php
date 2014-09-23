<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


function fg_get_preference_value($key)
{
    fg_db_check_connection_open();

    $sql = "SELECT * FROM gs_preferenze WHERE chiave_preferenza='".$key."' LIMIT 1;";
    $result = mysql_query($sql);
    $row = mysql_fetch_assoc($result);
    $valore_preferenza = $row['valore_preferenza'];

    return $valore_preferenza;
}

function fg_set_preference_value($key,$value)
{
    fg_db_check_connection_open();
    $sql = "UPDATE gs_preferenze SET valore_preferenza='".$value."' WHERE chiave_preferenza='".$key."' LIMIT 1;";
    $result = mysql_query($sql);
}

?>