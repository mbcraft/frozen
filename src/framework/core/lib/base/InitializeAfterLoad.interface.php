<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

interface InitializeAfterLoad
{
    public static function __classLoaded($class_name);
}

?>