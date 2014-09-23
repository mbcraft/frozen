<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class __MysqlAlterView extends __AbstractEditView
{
    function __construct($view_name)
    {
        parent::__construct("ALTER",$view_name);
    }
}

?>