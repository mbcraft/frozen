<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

interface InitializeAfterLoad
{
    public static function __classLoaded($class_name);
}

?>