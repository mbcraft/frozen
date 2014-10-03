<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Questa classe definisce come un determinato campo viene letto/scritto sul database
 * */
interface IFieldFetcher
{
    /*
     * Prende il valore trovato sul db e lo trasforma in un valore logico.
     * Viene chiamato ogni volta che deve esser letto il valore da una query per salvarlo nel DO.
     *
     * */
    function rawToLogic($raw_value);
    /*
     * Prende il valore logico e lo trasforma in un valore per il db
     * */
    function logicToRaw($logic_value);
    /*
     * Ritorna true se è possibile scrivere sul campo, false altrimenti.
     * */
    function isWritable();
}

?>