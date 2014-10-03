<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

/*
 * Contiene l'elenco dei mapping tag -> classe da istanziare durante la costruzione dell'albero.
 */

class XMLObjectFactory
{
    private $mappings = array();

    private static $factories = array();

    static function initFactory($name,$mappings)
    {
        if (!isset(self::$factories[$name]))
            self::$factories[$name] = new XMLObjectFactory ();

        $factory = self::$factories[$name];
        foreach ($mappings as $key => $value)
            $factory->addClassMapping($key,$value);
    }

    static function getFactory($name)
    {
        return self::$factories[$name];
    }

    private function addClassMapping($tag_name,$class_name)
    {
        $this->mappings[$tag_name] = $class_name;
    }

    private function createXMLObject($tag_name,$attributes)
    {
        $class_name = $this->mappings[$tag_name];

        $tag = new $class_name();
        $tag->setAttributes($attributes);

        return $tag;
    }

    function parseXMLFile($file)
    {
        if ($file instanceof File)
        {
            return $this->parseXMLString($file->getContent());
        }
    }

    function parseXMLString($xml)
    {
        $root = new SimpleXMLElement(trim($xml));  //uso il trim per sicurezza.
        return $this->internalParseXML($root);
    }

    private function internalParseXML($simple_xml_element)
    {
        $ob = $this->createXMLObject($simple_xml_element->getName(), $simple_xml_element->attributes());

        foreach($simple_xml_element->children() as $child)
        {
            $ob->addChild($this->internalParseXML($child));
        }

        return $ob;
    }
}

?>