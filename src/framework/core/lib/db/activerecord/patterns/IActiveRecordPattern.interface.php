<?php

/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

interface IActiveRecordPattern
{
    function needs_apply($peer,$object);
    
    function apply($peer,$object);
    
    function get_pointcut();
}

?>