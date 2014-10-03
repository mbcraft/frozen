<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
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