<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class XMLDataFormat implements IDataFormat
{
    function loadInputData($params=null)
    {
        Params::importFromPost();
        Params::importFromGet();
    }

    private function __recursive_format_data($xml,$data)
    {
        foreach ($data as $key => $value)
        {
            if (is_array($value))
            {

                $xml->element($key);
                $xml->forward();
                $this->__recursive_format_data($xml,$value);
                $xml->back();
            }
            else
                $xml->element($key,$value,true);
        }
    }

    function formatOutputData($result)
    {
        $xml = new XMLBuilder();
        $xml->element("result");
        $xml->forward();
        if (is_array($result))
        {
            $xml->element("ok");
            $xml->forward();
            foreach ($result as $key => $value)
            {
                $xml->element("entry");
                $xml->forward();
                $this->__recursive_format_data($xml,$value);
                $xml->back();
            }

        }
        else
            $xml->element("ok",$result,true);

        echo $xml->getXML();
    }

    function formatError($ex)
    {
        $xml = new XMLBuilder();
        $xml->element("result");
        $xml->forward();
        $xml->element("error",$ex->getMessage());
        $xml->attribute("type",$ex->getException());
        $xml->back();
        $xml->back();

        echo $xml->getXML();
    }
}

?>