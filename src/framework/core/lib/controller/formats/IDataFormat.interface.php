<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
interface IDataFormat
{
    function loadInputData($input_params=null);
    function formatOutputData($result);
    function formatError($ex);
}

?>