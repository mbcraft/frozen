<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

interface Renderable
{
    //differenza dai blocchi? solo un altro nome?
    const RENDERABLE_TYPE_LAYOUT="layout";
    
    //static content
    const RENDERABLE_TYPE_PAGE="page";
        
    //this models layout
    const RENDERABLE_TYPE_BLOCK="block";
    
    //this models data
    const RENDERABLE_TYPE_SQL="sql";

    function render();

    function getRenderableType();
    function getName();
}

?>