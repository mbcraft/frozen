<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestXMLBuilder extends UnitTestCase
{
    public function testXPATH1()
    {
        $doc = new DOMDocument("1.0","utf-8");
        // we want a nice output
        $doc->formatOutput = false;
        $doc->preserveWhitespace = false;

        $root = $doc->createElement('book');
        $root = $doc->appendChild($root);

        $title = $doc->createElement('title');
        $title = $root->appendChild($title);

        $text = $doc->createTextNode('This is the title');
        $text = $title->appendChild($text);

        $output="<?xml version=\"1.0\" encoding=\"utf-8\"?>\n<book><title>This is the title</title></book>\n";
    
        $this->assertEqual($doc->saveXML(),$output,"L'esempio non corrisponde!");
        //OK FUNZIONA!
    }

    public function testBasic()
    {
        $rb = new XMLBuilder(false);
        $rb->element("GeteBayOfficialTimeRequest")->attribute("xmlns", "urn:ebay:apis:eBLBaseComponents");
        $rb->forward();
        $rb->element("RequesterCredentials");
        $rb->forward();
        $rb->element("eBayAuthToken","QWERTYUIOP");
        
        $requestXmlBody = "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        $requestXmlBody .= "<GeteBayOfficialTimeRequest xmlns=\"urn:ebay:apis:eBLBaseComponents\">";
        $requestXmlBody .= "<RequesterCredentials><eBayAuthToken>QWERTYUIOP</eBayAuthToken></RequesterCredentials>";
        $requestXmlBody .= "</GeteBayOfficialTimeRequest>\n";

        $this->assertEqual($rb->getXML(),$requestXmlBody,"L'xml generato non corrisponde! : ".$rb->getXML());

        //echo htmlentities($rb->getXML());
        //echo htmlentities($requestXmlBody);
    }
     
     
}

