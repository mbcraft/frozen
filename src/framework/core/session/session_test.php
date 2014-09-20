<?php

class TestSession extends UnitTestCase
{

    function testSomeTreeing()
    {
        Session::clear();
        
        Session::set("/prova/utente",array("nome" => "marco","cognome" => "bagnaresi"));
        
        $this->assertEqual(count(Session::get("/prova/utente")),2,"Il numero dei valori trovati non corrisponde!!");
    
        Session::merge("/prova/utente",array("amico" => "stefano"));
        
        $this->assertEqual(count(Session::get("/prova/utente")),3,"Il numero dei valori trovati non corrisponde!!");
    
        $v = Session::view("/prova/utente");
        
        $v->set("/amico","antonio");
        
        $this->assertEqual(Session::get("/prova/utente/amico"),"antonio","Il valore impostato da una view non corrisponde!!");
    }
    
    /*
    function testUltraAdvancedTreeing()
    {
        Session::clear();
        
        Session::set("/prova/utente",array("nome" => "marco","cognome" => "bagnaresi"));
        
        $this->assertEqual(count(Session::get("/prova/utente")),2,"Il numero dei valori trovati non corrisponde!!");
    
        Session::merge("/prova/utente",array("amico" => "stefano"));
        
        
        $t = new Tree();
        $t->set("/somedata",array("plain","old","values"));
        $t->set("/bridge/session/utente",Session::view("/prova/utente"));
        
        $this->assertEqual(count($t->get("/bridge/session/utente")),3,"Il bridging dei valori nella sessione non e' riuscito!!");
    
        Session::set("/prova/utente","eliminato");
        
        $this->assertEqual(Session::get("/prova/utente"),"eliminato","Il valore impostato non corrisponde!!");
        $this->assertEqual($t->get("/bridge/session/utente"),"eliminato","Il valore impostato non corrisponde!!");
        
        //var_dump(Session::get("/prova/utente"));
        //$this->assertEqual(Session::get("/prova/utente"),"eliminato","Il bridge non ha funzionato!!");
        
    }
    */
    
    function testGetWithDefaultParam()
    {
        Session::clear();
        
        $this->assertFalse(Session::is_set("/prova"),"La variabile prova e' gia' impostata.");
        
        $result = Session::get("/prova","Ciao!!!");
        
        $this->assertEqual($result,"Ciao!!!","Il dato di default non viene restituito!!!");
        
        Session::set("/prova", "ok");
        
        $this->assertTrue(Session::get("/prova"),"ok","Il valore della chiave non corrisponde!!");
    }
    
    function testGetSet()
    {
        Session::clear();
        
        $this->assertFalse(Session::is_set("/prova"),"La variabile prova e' gia' impostata.");
        
        Session::set("/prova", "ok");
        
        $this->assertTrue(Session::is_set("/prova"),"la chiave prova non è stata trovata.");
        
        $this->assertTrue(Session::get("/prova"),"ok","Il valore della chiave non corrisponde!!");
        
    }
    
    function testClear()
    {
        Session::clear();
        
        $this->assertFalse(Session::is_set("/prova"),"La variabile prova e' gia' impostata!!");
        
        Session::set("/prova", "ok");
        
        $this->assertTrue(Session::is_set("/prova"),"la chiave prova non e' stata trovata.");
        
        $this->assertTrue(Session::get("/prova"),"ok","Il valore della chiave non corrisponde!!");
        
        Session::clear();
        
        $this->assertFalse(Session::is_set("/prova"),"la chiave prova e' stata trovata.");
        
        
        
    }
}
?>