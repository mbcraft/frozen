<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

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