<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

abstract class AbstractFieldFetcher implements IFieldFetcher
{
    function isWritable()
    {
        return true;
    }
}

?>