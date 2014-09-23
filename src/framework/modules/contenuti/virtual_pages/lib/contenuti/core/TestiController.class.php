<?php

/*
 * Per le gallery serve, oltre a una descrizione, una descrizione sommaria nelle foto.
 * Per ovviare a questo inconveniente si può adottare questa soluzione :
 *
 * A monte, una gestione di file e cartelle fatta col classico "files & folders", nella quale è possibile la gestione
 * dei file.
 *
 * A valle, una gestione delle gallery tramite database per inserire effetti, descrizioni e quant'altro.
 * Ovviamente in futuro la gestione delle cartelle terrà conto dei permessi.
 * E' inoltre possibile visualizzare una gallery anche senza mapping sul db, con dei ragionevoli default.
 * */

class TestiController extends AbstractKeyedFolderEntityController
{
    function __myPeer()
    {
        return new TestiPeer();
    }
    function __createMessage()
    {
        return "Contenuto creato con successo!!";
    }
    function __modifyMessage()
    {
        return "Contenuto modificato con successo!!";
    }
    function __deleteMessage()
    {
        return "Contenuto eliminato con successo!!";
    }
}
?>