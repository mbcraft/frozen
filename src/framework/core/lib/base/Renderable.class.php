<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

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