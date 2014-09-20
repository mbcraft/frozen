<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


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
