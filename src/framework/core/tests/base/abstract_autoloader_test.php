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

require_once(FRAMEWORK_CORE_PATH."lib/base/AbstractLoader.class.php");

class MockAutoloader extends AbstractLoader
{
    function __construct($recursive,$namespaced=false)
    {
        parent::__construct(".prova.php", $recursive,$namespaced);
    }
    
    function add_directory($dir)
    {
        
    }

    function autoconfigure()
    {
        $this->scan_from_site_root("/".FRAMEWORK_CORE_PATH."tests/base/scantest/");
    }
}

class TestAbstractAutoloader extends UnitTestCase
{
    function testAutoloaderDeepSubdir()
    {
        $autoloader = new MockAutoloader(true,true);
        $autoloader->autoconfigure();

        $this->assertTrue($autoloader->has_found_element("another_subdir/framework/core/tests/base/scantest/second_subdir/deep/a_hidden_page"));
        $this->assertEqual($autoloader->get_element_content_by_name("another_subdir/framework/core/tests/base/scantest/second_subdir/deep/a_hidden_page"),":)");
    }

    function testAutoloaderNotConfigured()
    {
        $autoloader = new MockAutoloader(true);

        $this->assertFalse($autoloader->has_found_element("pluto"),"Deve essere vuoto prima della configurazione");
        $this->assertFalse($autoloader->has_found_element("pippo"),"Deve essere vuoto prima della configurazione");
        $this->assertFalse($autoloader->has_found_element("paperino"),"Deve essere vuoto prima della configurazione");
        $this->assertFalse($autoloader->has_found_element("altro"),"Deve essere vuoto prima della configurazione");
    }

    function testAutoloaderConfigured()
    {
        $autoloader = new MockAutoloader(true);
        $autoloader->autoconfigure();

        $this->assertTrue($autoloader->has_found_element("pluto"),"Elemento non trovato");
        $this->assertTrue($autoloader->has_found_element("pippo"),"Elemento non trovato");
        $this->assertTrue($autoloader->has_found_element("paperino"),"Elemento non trovato");
        $this->assertFalse($autoloader->has_found_element("altro"),"Elemento da non trovare");
    }

    function testAutoloaderMisc()
    {
        $autoloader = new MockAutoloader(true);
        $autoloader->autoconfigure();

        $this->assertEqual($autoloader->get_element_name_from_filename("123.prova.php"),"123","Il nome dell'elemento non e' valido");
        $this->assertEqual($autoloader->get_element_name_from_filename("ciao_mondo.prova.php"),"ciao_mondo","Il nome dell'elemento non e' valido");

        $this->assertTrue($autoloader->is_valid_filename("ciao_mondo.prova.php"),"Il nome del file non risulta valido!");
        $this->assertFalse($autoloader->is_valid_filename("ciao_mondo.block.php"),"Il nome del file risulta valido!");

        $this->assertEqual($autoloader->get_element_path_by_name("pluto"),FRAMEWORK_CORE_PATH."tests/base/scantest/pluto.prova.php","Il path non corrisponde");
        $this->assertEqual($autoloader->get_element_path_by_name("paperino"),FRAMEWORK_CORE_PATH."tests/base/scantest/subdir/paperino.prova.php","Il path non corrisponde");

    }
    
    function testNonRecursiveAutoloader()
    {
        $autoloader = new MockAutoloader(false);
        $autoloader->autoconfigure();

        $this->assertTrue($autoloader->has_found_element("pippo"),"Elemento non trovato");
        $this->assertFalse($autoloader->has_found_element("paperino"),"Elemento da non trovare");
      
       
    }

    function testRecursiveNamespacedAutoloader()
    {
        $autoloader = new MockAutoloader(true,true);
       $autoloader->autoconfigure();

        $this->assertEqual($autoloader->get_element_name_from_filename("123.prova.php"),"123","Il nome dell'elemento non e' valido");
        $this->assertEqual($autoloader->get_element_name_from_filename("ciao_mondo.prova.php"),"ciao_mondo","Il nome dell'elemento non e' valido");

        $this->assertTrue($autoloader->is_valid_filename("ciao_mondo.prova.php"),"Il nome del file non risulta valido!");
        $this->assertFalse($autoloader->is_valid_filename("ciao_mondo.block.php"),"Il nome del file risulta valido!");

        $this->assertEqual($autoloader->get_element_path_by_name("pluto"),FRAMEWORK_CORE_PATH."tests/base/scantest/pluto.prova.php","Il path non corrisponde");
        $this->assertEqual($autoloader->get_element_path_by_name("subdir/paperino"),FRAMEWORK_CORE_PATH."tests/base/scantest/subdir/paperino.prova.php","Il path non corrisponde");

    }


}

