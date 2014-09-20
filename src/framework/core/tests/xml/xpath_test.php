<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


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

