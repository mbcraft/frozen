<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestSector extends UnitTestCase
{

    
//    function testSectorDoubleOpen()
//    {
//        Sector::reset();
//        
//        Sector::start("/ciccia/pluto");
//        
//        try 
//        {
//            Sector::start("/altrove");
//            $this->fail("Sono riuscito ad aprire un settore annidato!!");
//        }
//        catch (Exception $ex)
//        {
//            Sector::reset();
//        }
//        
//    }

      
    
    function testSectorErrorOnOverwrite()
    {
        Sector::reset();
        
        Sector::start("/ciccia/pluto_error_on_overwrite");
        echo "Ciao!!";
        Sector::end();
        
        $this->assertEqual(Sector::get("/ciccia/pluto_error_on_overwrite"),"Ciao!!","I dati non sono stati memorizzati correttamente nel settore!!");
        
        try 
        {
            Sector::start("/ciccia/pluto_error_on_overwrite",Sector::STORE_MODE_ERROR_ON_OVERWRITE);
            $this->fail("L'overwrite non lancia l'eccezione!!");
        }
        catch (IllegalStateException $ex)
        {
            Sector::reset();
        }
        catch (InvalidParameterException $ex)
        {
            Sector::reset();
        }
        catch (Exception $ex)
        {
            Sector::reset();
        }
    }

    function testSectorOverwrite()
    {
        Sector::reset();
        
        Sector::start("/ciccia/pluto_overwrite");
        echo "Ciao!!";
        Sector::end();
        
        $this->assertEqual(Sector::get("/ciccia/pluto_overwrite"),"Ciao!!","I dati non sono stati memorizzati correttamente nel settore!!");
        
        try 
        {
            Sector::start("/ciccia/pluto_overwrite",Sector::STORE_MODE_OVERWRITE);
            echo "Mondo!!";
            Sector::end();
            
            $this->assertEqual(Sector::get("/ciccia/pluto_overwrite"),"Mondo!!","I dati non sono stati memorizzati correttamente nel settore!!");
            
        }
        catch (Exception $ex)
        {
            $this->fail("Non sono riuscito a sovrascrivere un settore con STORE_MODE_OVERWRITE!!");
            Sector::reset();
        }
    }

    function testSectorAppend()
    {
        Sector::reset();
        
        Sector::start("/ciccia/pluto_append");
        echo "Ciao!!";
        Sector::end();
        
        $this->assertEqual(Sector::get("/ciccia/pluto_append"),"Ciao!!","I dati non sono stati memorizzati correttamente nel settore!!");
        
        try 
        {
            Sector::start("/ciccia/pluto_append",Sector::STORE_MODE_APPEND);
            echo "Mondo!!";
            Sector::end();
            
            $this->assertEqual(Sector::get("/ciccia/pluto_append"),"Ciao!!Mondo!!","I dati non sono stati memorizzati correttamente nel settore!!");
            
        }
        catch (Exception $ex)
        {
            $this->fail("Errore durante un append!! con STORE_MODE_APPEND !!");
            Sector::reset();
        }
    }
    
    function testSectorPrepend()
    {
        Sector::reset();
        
        Sector::start("/ciccia/pluto_prepend");
        echo "Ciao!!";
        Sector::end();
        
        $this->assertEqual(Sector::get("/ciccia/pluto_prepend"),"Ciao!!","I dati non sono stati memorizzati correttamente nel settore!!");
        
        try 
        {
            Sector::start("/ciccia/pluto_prepend",Sector::STORE_MODE_PREPEND);
            echo "Mondo!!";
            Sector::end();
            
            $this->assertEqual(Sector::get("/ciccia/pluto_prepend"),"Mondo!!Ciao!!","I dati non sono stati memorizzati correttamente nel settore!!");
            
        }
        catch (Exception $ex)
        {
            Sector::reset();
            
            $this->fail("Errore durante un prepend!! con STORE_MODE_PREPEND !!");
            
        }
    }


}

