<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
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