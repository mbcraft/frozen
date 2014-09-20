<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class HTMLDataFormat implements IDataFormat
{
    function loadInputData($params=null)
    {
        Params::importFromPost();
        Params::importFromGet();
    }

    function formatOutputData($result)
    {
        if (Result::is_result($result))
        {
            if (Result::is_ok($result))
                $result = Redirect::success();
            else
                $result = Redirect::failure();
        }

        if ($result instanceof IActionCommand)
            return $result->execute();


        echo render_result($result);
    }

    function formatError($ex)
    {
        return var_export($ex);
    }
}

?>