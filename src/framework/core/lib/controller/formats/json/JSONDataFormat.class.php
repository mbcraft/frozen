<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class JSONDataFormat implements IDataFormat
{
    function loadInputData($params=null)
    {
        Params::importFromPost();
        Params::importFromGet();
    }

    function formatOutputData($result)
    {
        if ($result instanceof IActionCommand)
            return $result->execute();
        else
            echo json_encode($result);
        return null;
    }

    function formatError($ex)
    {
        return json_encode(array("error" => $ex->getMessage()));
    }
}

?>