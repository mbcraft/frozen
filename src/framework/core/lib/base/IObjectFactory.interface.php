<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

interface IObjectFactory
{
    function create($name,$parent_context);
    function add_directory($dir);
    function can_create($name);
    function get_available_keys();
    function reset();
}

?>