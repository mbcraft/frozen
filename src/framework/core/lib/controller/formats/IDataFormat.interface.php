<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
interface IDataFormat
{
    function loadInputData($input_params=null);
    function formatOutputData($result);
    function formatError($ex);
}

?>