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

/**
 * Ritorna il valore del contatore
 *
 * @param <type> $nome_contatore Il nome del contatore
 * @return <type>
 */
 /*
function fg_counter_get_current_value($nome_contatore)
{
    $ss = DB::newSelect(GS_TAB_CONTATORI);
    $ss->addConditionEquals("nome_contatore", $nome_contatore);
    $ss->set_limit(1);

    $row = $ss->exec_fetch_assoc();
    if (!$row)
    {
        throw new Exception("Nessun contatore $nome_contatore trovato!");
    }
    $valore_contatore = $row['valore_contatore'];
    return $valore_contatore;
}

    /**
     * Ritorna il valore del contatore e lo incrementa.
     *
     * @param <type> $nome_contatore Il nome del contatore
     * @return <type> Il valore da utilizzare
     */
function fg_counter_next_value($nome_contatore)
{
    fg_db_check_connection_open();

    $val =  fg_counter_get_current_value($nome_contatore);

    $uu = DB::newUpdate(GS_TAB_CONTATORI);
    $uu->add("valore_contatore","valore_contatore+1",false);
    $uu->addConditionEquals("nome_contatore", $nome_contatore);
    $uu->set_limit(1);

    $uu->exec();

    return $val;

}


?>