<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

session_start();


class TestFlash extends UnitTestCase
{

    function testOkFlashes()
    {
        Flash::clean();
        
        Flash::__load_from_session();
        
        $this->assertFalse(Flash::has_oks(),"Il flash ha gia' dentro del contenuto!!");
        Flash::ok("Ciao!");
        Flash::ok("Boom!");
        
        $this->assertTrue(Flash::has_oks(),"Il flash non ha salvato il messaggio");
        
        $messages = Flash::get_ok_messages();
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
        $this->assertEqual("Ciao!",$messages[0]);
        $this->assertEqual("Boom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $messages = Flash::get_ok_messages();
        
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
       
        $this->assertEqual("Ciao!",$messages[0]);
        $this->assertEqual("Boom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $this->assertEqual(count(Flash::get_ok_messages()),0,"Il numero dei messaggi salvati non corrisponde!!");
        
    }
    
    function testWarningFlashes()
    {
        Flash::clean();
        
        Flash::__load_from_session();
        
        $this->assertFalse(Flash::has_oks(),"Il flash ha gia' dentro del contenuto!!");
        Flash::warning("asdCiao!");
        Flash::warning("asdBoom!");
        
        $this->assertTrue(Flash::has_warnings(),"Il flash non ha salvato il messaggio");
        
        $messages = Flash::get_warning_messages();
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
        $this->assertEqual("asdCiao!",$messages[0]);
        $this->assertEqual("asdBoom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $messages = Flash::get_warning_messages();
        
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
       
        $this->assertEqual("asdCiao!",$messages[0]);
        $this->assertEqual("asdBoom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $this->assertEqual(count(Flash::get_warning_messages()),0,"Il numero dei messaggi salvati non corrisponde!!");
        
    }
    
    function testErrorFlashes()
    {
        Flash::clean();
        
        Flash::__load_from_session();
        
        $this->assertFalse(Flash::has_errors(),"Il flash ha gia' dentro del contenuto!!");
        Flash::error("qweCiao!");
        Flash::error("qweBoom!");
        
        $this->assertTrue(Flash::has_errors(),"Il flash non ha salvato il messaggio");
        
        $messages = Flash::get_error_messages();
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
        $this->assertEqual("qweCiao!",$messages[0]);
        $this->assertEqual("qweBoom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $messages = Flash::get_error_messages();
        
        $this->assertEqual(count($messages),2,"Il numero dei messaggi salvati non corrisponde!!");
       
        $this->assertEqual("qweCiao!",$messages[0]);
        $this->assertEqual("qweBoom!",$messages[1]);
        
        Flash::__save_to_session();
        Flash::__load_from_session();
        
        $this->assertEqual(count(Flash::get_error_messages()),0,"Il numero dei messaggi salvati non corrisponde!!");
        
    }


}

?>