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

class TestSimpleXML extends UnitTestCase
{
    function testSimpleParsing()
    {
        $doc = <<<HEREDOC
        <?xml version="1.0" encoding="utf-8"?>
            <template name="default">
                <page_header>
                    <page_title value="Ciao mondo!"/>
                    <page_meta />
                    <page_css />
                    <page_js />
                </page_header>
                <page_body>
                    <layout_vertical width="80%">
                        <content_file name="header" file="header"/>
                        <content_from_url source="file" name="content" />
                        <content_file name="footer" file="footer" />
                    </layout_vertical>
            </page_body>
        </template>
HEREDOC;

        $p = new SimpleXMLElement(trim($doc));

        
        $this->assertEqual($p["name"],"default","Non riesco a trovare il nome del template!!");

        $this->assertEqual($p->page_header->page_title["value"],"Ciao mondo!","Il titolo non coincide!");

        foreach ($p->children() as $child)
            echo $child;
        
        
    }


}
