<?php

class XMLStorage extends Storage
{
    function __construct($folder,$name)
    {
        parent::__construct($folder,$name,Storage::XML_STORAGE);
    }

    function readXML()
    {
        $this->create();
        return new SimpleXMLElement($this->storage_file->getContent());
    }

    function saveXML($xml_data)
    {
        $this->create();
        $this->storage_file->setContent($xml_data->asXML());
    }
}

?>