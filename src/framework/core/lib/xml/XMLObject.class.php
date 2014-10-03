<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

class XMLObject extends BasicObject
{
    private $attributes;
    private $childs = array();

    function setAttributes($attributes)
    {
        $this->attributes = $attributes;
    }

    function addChild($child)
    {
        $this->childs[] = $child;
        
    }

    function getChilds()
    {
        return $this->childs;
    }

    function hasAttribute($key)
    {
        return isset($this->attributes[$key]);
    }

    function getAttribute($key)
    {
        return isset($this->attributes[$key]);
    }

    function setAttribute($key,$value)
    {
        $this->attributes[$key] = $value;
    }
}

?>