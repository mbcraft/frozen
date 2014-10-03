<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class RAWPhpDataFormat implements IDataFormat
{
    function loadInputData($params=null)
    {
        if ($params===null)
        {
            Params::importFromPost();
            Params::importFromGet(true);
        }
        else
            Params::importFromArray($params);
    }

    function formatOutputData($result)
    {
        if ($result instanceof IActionCommand)
            return $result->execute();
        else
            return $result;
    }

    function formatError($ex)
    {
        return $ex;
    }
}

?>