<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

interface IObjectFactory
{
    function create($name,$parent_context);
    function add_directory($dir);
    function can_create($name);
    function get_available_keys();
    function reset();
}

?>