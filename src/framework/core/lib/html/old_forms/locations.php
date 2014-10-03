<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
//funzioni che scrivono le option nell'html tenendo conto di eventuali selezioni

function fg_write_stato($id_stato=0)
{
    echo "<select class=\"form_field_enabled\" id=\"select_stato\" name=\"id_stato\">";

    $yes_selected = "selected=\"selected\"";
    $no_selected = "";

    $ss = DB::newSelect("location_stati");
    $ss->add("id_stato");
    $ss->add("nome");
    $ss->addOrdering("nome");

    $result = $ss->exec();
    $selected = $id_stato>0 ? $no_selected : $yes_selected;
    echo "<option value=\"-1\" ".$selected.">(Seleziona uno stato)</option>\n";
    while ($row = mysql_fetch_assoc($result))
    {
        if ($row['id_stato']==$id_stato)
        $selected = $yes_selected;
        else
        $selected = $no_selected;
        echo "<option value=\"".$row['id_stato']."\" $selected>".$row['nome']."</option>\n";
    }
    mysql_free_result($result);

    echo "</select>";
}

function fg_write_regione($id_stato=0,$id_regione=0)
{
    
    if ($id_stato>0)
    {
        echo "<select class=\"form_field_enabled\" id=\"select_regione\" name=\"id_regione\">";


        $yes_selected = "selected=\"selected\"";
        $no_selected = "";

        $ss = DB::newSelect("location_regioni");
        $ss->add("id_regione");
        $ss->add("nome");

        $ss->addConditionEquals("id_stato", $id_stato);
        $ss->addOrdering("nome");

        $result = $ss->exec();



        $selected = $id_regione>0 ? $no_selected : $yes_selected;
        echo "<option value=\"-1\" $selected>(Seleziona una regione)</option>\n";
        while ($row = mysql_fetch_assoc($result))
        {
            if ($row['id_regione']==$id_regione)
            $selected = $yes_selected;
            else
            $selected = $no_selected;
            echo "<option value=\"${row['id_regione']}\" $selected>${row['nome']}</option>\n";
        }

        mysql_free_result($result);

    }
    else
        echo "<select class=\"form_field_disabled\" id=\"select_regione\" name=\"id_regione\">";


    echo "</select>";

 
}

function fg_write_provincia($id_regione=0,$id_provincia=0)
{
    
    if ($id_regione!=0)
    {
        echo "<select class=\"form_field_enabled\"  id=\"select_provincia\" name=\"id_provincia\">";


        $yes_selected = "selected=\"selected\"";
        $no_selected = "";

        //$peer = new LocationProvincePeer();
        //$peer->id_regione__EQUALS($id_regione);
        //$peer->__ORDER_DESCENDING("nome");

        $ss = DB::newSelect("location_province");
        $ss->add("id_provincia");
        $ss->add("nome");

        $ss->addConditionEquals("id_regione", $id_regione);
        $ss->addOrdering("nome");

        $result = $ss->exec();
        //$result = $ss->find();

        $selected = $id_provincia>0 ? $no_selected : $yes_selected;
        echo "<option value=\"-1\" $selected>(Seleziona una provincia)</option>\n";
        while ($row = mysql_fetch_assoc($result))
        {
            if ($row['id_provincia']==$id_provincia)
            $selected = $yes_selected;
            else
            $selected = $no_selected;
            echo "<option value=\"${row['id_provincia']}\" $selected>${row['nome']}</option>\n";
        }
        mysql_free_result($result);

    }
    else
        echo "<select class=\"form_field_disabled\"  id=\"select_provincia\" name=\"id_provincia\">";


    echo "</select>";
}

function fg_write_comune($id_provincia,$codice_istat_comune)
{
    
    if ($id_provincia!=0)
    {
        echo "<select class=\"form_field_enabled\" id=\"select_comune\" name=\"codice_istat_comune\">";

        $yes_selected = "selected=\"selected\"";
        $no_selected = "";

        $ss = DB::newSelect("location_comuni");

        $ss->add("codice_istat_comune");
        $ss->add("nome");

        $ss->addConditionEquals("id_provincia", $id_provincia);
        $ss->addOrdering("nome");

        $result = $ss->exec();

        $selected = $codice_istat_comune>0 ? $no_selected : $yes_selected;
        echo "<option value=\"-1\" $selected>(Seleziona un comune)</option>\n";
        while ($row = mysql_fetch_assoc($result))
        {
            if ($row['codice_istat_comune']==$codice_istat_comune)
                $selected = $yes_selected;
            else
                $selected = $no_selected;
            echo "<option value=\"${row['codice_istat_comune']}\" $selected>${row['nome']}</option>\n";
        }
        mysql_free_result($result);

    }
    else
        echo "<select class=\"form_field_disabled\" id=\"select_comune\" name=\"codice_istat_comune\">";


    echo "</select>";
}

?>