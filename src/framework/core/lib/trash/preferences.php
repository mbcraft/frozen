<?php
/*
 * NOTA DI COPYRIGHT
Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione 
sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
 *
 * COPYRIGHT NOTICE
This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
without an explicit agreement with Frostlab gate. All rights reserved.
 */

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