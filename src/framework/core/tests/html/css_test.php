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

require_once(FRAMEWORK_CORE_PATH."lib/html/CSS.class.php");

class TestCss extends UnitTestCase
{
    function testCssAddIntoResult()
    {
        CSS::clean();
        
        CSS::require_css_file("/".FRAMEWORK_CORE_PATH."tests/html/example_css/my_css_file.css");
        
        $this->assertEqual(1,CSS::get_loaded_css(),"Il numero di css caricati non corrisponde!!");
        
        $this->assertTrue(PageData::instance()->is_set("/page/headers/required_css_files"));
        $this->assertEqual(1,count(PageData::instance()->get("/page/headers/required_css_files/css_file_list")),"Il numero di css caricati non corrisponde!!");
    }
    
}

?>