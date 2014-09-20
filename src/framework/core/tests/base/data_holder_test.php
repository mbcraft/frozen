<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/utils/DataHolder.class.php");

class SimpleObject
{
    public $id_news;
    public $titolo;
    public $data;
    public $body;
}



class TestDataHolder extends UnitTestCase
{
    function testConstantDataHolder()
    {
        $dh = new DataHolder(true, false);

        $dh->prova = 10;
        $this->assertEqual(10,$dh->prova,"Valore non salvato");
        $this->assertEqual($dh->prova, $dh->{"prova"}, "La read non funziona correttamente!");

        $dh->CICCIA = "ok";
        $this->assertEqual("ok",$dh->CICCIA,"Valore non salvato");
        $this->assertEqual($dh->CICCIA, $dh->{"CICCIA"}, "La read non funziona correttamente!");

        
        $dh->prova = "hello";
        $this->assertEqual("hello",$dh->prova,"Valore non salvato");

        $dh->{"prova"} = "world";
        $this->assertEqual("world",$dh->prova,"Valore non salvato con la write");


        try
        {
            $dh->CICCIA = 70;
            $this->fail("Sovrascrittura di costanti senza eccezione");
        }
        catch(Exception $ex)
        {}

        try
        {
            $dh->{"CICCIA"} = 70;
            $this->fail("Write di costanti permesso!");
        }
        catch(Exception $ex)
        {}

        try
        {
            unset($dh->CICCIA);
            $this->fail("Costante eliminata con unset");
        }
        catch(Exception $ex)
        {}

        try
        {
            $dh->BOH;
            $this->fail("Accesso a costanti inesistenti senza eccezione");
        }
        catch(Exception $ex)
        {}

        try
        {
            $dh->hey;
            $this->fail("Accesso a variabili inesistenti senza eccezione");
        }
        catch(Exception $ex)
        {}

    }

    function testMergeSimpleObject()
    {
        $obj = new SimpleObject();
        $obj->titolo = "Titolo";
        $obj->data = "02-04-2010";
        $obj->body = "bla bla bla bla bla";
        $obj->__new = true;

        $dh = new DataHolder();
        $dh->titolo = "Vecchio Titolo";
        $dh->data = "01-04-2010";
        $dh->body = "old old old old old";

        $dh->__merge($obj);

 
        $this->assertEqual($dh->titolo,"Titolo","Merge fallito");
        $this->assertEqual($dh->data,"02-04-2010","Merge fallito");
        $this->assertEqual($dh->body,"bla bla bla bla bla","Merge fallito");
        $this->assertFalse(isset($dh->__new),"Merge di variabile che comincia con __ !");
    }

    function testMergeTwoDataHolders()
    {


        $dh = new DataHolder();
        $dh->titolo = "La mia citta";
        $dh->citta = "Bagnacavallo";
        $dh->provincia = "Ravenna";
        $dh->regione = "Emilia Romagna";

        
        $dh2 = new DataHolder();
        $dh2->titolo = "Vecchio Titolo";
        $dh2->data = "01-04-2010";
        $dh2->body = "old old old old old";
        $dh2->__new = true;

        $dh->__merge($dh2);

        $this->assertEqual($dh->titolo,"Vecchio Titolo","Merge fra due DH fallito");
        $this->assertEqual($dh->citta,"Bagnacavallo","Merge fra due DH fallito");
        $this->assertEqual($dh->provincia,"Ravenna","Merge fra due DH fallito");
        $this->assertEqual($dh->regione,"Emilia Romagna","Merge fra due DH fallito");
        $this->assertEqual($dh->data,"01-04-2010","Merge fra due DH fallito");
        $this->assertEqual($dh->body,"old old old old old","Merge fra due DH fallito");
        $this->assertFalse(isset($dh->__new));

    }

    function testFrozen()
    {
        $dh = new DataHolder();
        $dh->titolo = "Vecchio Titolo";
        $dh->data = "01-04-2010";
        $dh->body = "old old old old old";

        $dh->__freeze();

        $dh->titolo = "Titolo";
        $dh->data = "02-04-2010";
        $dh->body = "bla bla bla bla bla";

        $this->assertEqual($dh->titolo,"Vecchio Titolo","Freeze fallito");
        $this->assertEqual($dh->data,"01-04-2010","Freeze fallito");
        $this->assertEqual($dh->body,"old old old old old","Freeze fallito");

        $dh->__unfreeze();

        $dh->titolo = "Titolo";
        $dh->data = "02-04-2010";
        $dh->body = "bla bla bla bla bla";

        $this->assertEqual($dh->titolo,"Titolo","Unfreeze fallito");
        $this->assertEqual($dh->data,"02-04-2010","Unfreeze fallito");
        $this->assertEqual($dh->body,"bla bla bla bla bla","Unfreeze fallito");

    }

    function testNoConstantDataHolder()
    {
        $dh = new DataHolder(false, false);

        $this->assertFalse(isset($dh->prova),"isset vero per valore non impostato");

        $dh->prova = 10;
        $this->assertEqual(10,$dh->prova,"Valore non salvato");

        $this->assertTrue(isset($dh->prova),"isset false per valore impostato");

        $this->assertFalse(isset($dh->CICCIA),"isset vero per valore non impostato");

        $dh->CICCIA = "ok";
        $this->assertEqual("ok",$dh->CICCIA,"Valore non salvato");

        $this->assertTrue(isset($dh->CICCIA),"isset false per valore impostato");


        $dh->prova = "hello";
        $this->assertEqual("hello",$dh->prova,"Valore non salvato");

        try
        {
            $dh->CICCIA = 70;
            $this->assertEqual(70,$dh->CICCIA,"Valore non salvato");
        }
        catch(Exception $ex)
        {
            $this->fail("Eccezione su nome maiuscolo in modalita' senza costanti");
        }

        unset($dh->prova);
        $this->assertFalse(isset($dh->prova),"isset vero per valore non impostato");


    }

    function testLockedDataHolder()
    {
        $dh = new DataHolder(false, false);

        $this->assertFalse($dh->__locked(),"DataHolder lockato!");


        $this->assertFalse(isset($dh->prova),"isset vero per valore non impostato");

        $dh->prova = 10;
        $this->assertEqual(10,$dh->prova,"Valore non salvato");

        $this->assertTrue(isset($dh->prova),"isset false per valore impostato");

        $this->assertFalse(isset($dh->CICCIA),"isset vero per valore non impostato");

        $dh->CICCIA = "ok";
        $this->assertEqual("ok",$dh->CICCIA,"Valore non salvato");

        $this->assertTrue(isset($dh->CICCIA),"isset false per valore impostato");

        $this->assertFalse($dh->__locked(),"DataHolder lockato!");

        $dh->__lock();

        $this->assertTrue($dh->__locked(),"DataHolder non lockato!");


        try
        {
            $dh->CICCIA = 70;
            $this->fail("Scrittura variabili maiuscole dopo lock!");
        }
        catch(Exception $ex)
        {
            
        }

        try
        {
            $dh->prova = 20;
            $this->fail("Scrittura variabili minuscole dopo lock!");
        }
        catch(Exception $ex)
        {

        }

        try
        {
            $dh->bello = 20;
            $this->fail("Creazione nuove variabili minuscole dopo lock!");
        }
        catch(Exception $ex)
        {

        }

        try
        {
            $dh->BOMBA = 20;
            $this->fail("Creazione nuove variabili MAIUSCOLE dopo lock!");
        }
        catch(Exception $ex)
        {

        }

        try
        {
            unset($dh->prova);
            $this->fail("Rimozione variabili minuscole dopo il lock!");
        }
        catch(Exception $ex)
        {

        }

        try
        {
            unset($dh->CICCIA);
            $this->fail("Rimozione variabili maiuscole dopo il lock!");
        }
        catch(Exception $ex)
        {

        }
 
    }
}

