<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class __MysqlCreateView extends __AbstractEditView
{
    function __construct($view_name)
    {
        parent::__construct("CREATE",$view_name);
    }
}

?>