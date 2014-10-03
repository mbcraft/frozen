<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/**
 * Description of IUserService
 *
 * @author marco
 */
interface IUserService 
{
    /*
     * Crea un nuovo peer per la gestione degli utenti.
     */
    function newUserPeer();
    
    /*
     * Crea un nuovo DO per contenere i dati degli utenti.
     */
    function newUserDO();
    
    
}

?>