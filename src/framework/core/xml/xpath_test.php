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

class TestSimpleXMLXpath extends UnitTestCase
{

    public function testXpath()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/xml/xml_file.xml");

        $xml_doc = new SimpleXMLElement(str_replace("xmlns","ns",$f->getContent()));

        $config_params = $xml_doc->xpath("/module-declaration/config-params");
        $this->assertTrue($config_params,"Impossibile leggere i parametri di configurazione!!");

        $install_data = $xml_doc->xpath('/module-declaration/action[@name="install"]');
        $this->assertTrue($install_data,"Impossibile leggere i dati per l'installazione!!");
    }




}

