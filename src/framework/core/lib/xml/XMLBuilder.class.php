<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class XMLBuilder extends BasicObject
{
    private $doc;

    private $currentNode;
    private $lastElement;

    public function __construct($format_output=true)
    {
        $this->doc = new DOMDocument("1.0","utf-8");
        $this->doc->formatOutput = $format_output;
        $this->doc->preserveWhitespace = false;
        $this->currentNode = $this->doc;


    }

    public function back()
    {
        $this->currentNode = $this->currentNode->parentNode;
    }

    public function forward()
    {
        $this->currentNode = $this->currentNode->lastChild;
    }

    public function element($name,$value=null,$use_cdata = false)
    {
        if ($value==null)
            $element = $this->doc->createElement($name);
        else
        {
            if ($use_cdata)
            {
                $cdata_node = $this->doc->createCDATASection($value);
                $element = $this->doc->createElement($name);
                $element->appendChild($cdata_node);
            }
            else
                $element = $this->doc->createElement($name,"".$value);
        }
        
        $element = $this->currentNode->appendChild($element);
        $this->lastElement = $element;

        return $this;
    }

    public function attribute($name,$value)
    {
        $this->lastElement = $this->lastElement->setAttribute($name,"".$value);
        return $this;
    }

    public function getXML()
    {
        return $this->doc->saveXML();
    }
}

?>