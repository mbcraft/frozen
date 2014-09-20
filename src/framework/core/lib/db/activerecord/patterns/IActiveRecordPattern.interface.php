<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

interface IActiveRecordPattern
{
    function needs_apply($peer,$object);
    
    function apply($peer,$object);
    
    function get_pointcut();
}

?>