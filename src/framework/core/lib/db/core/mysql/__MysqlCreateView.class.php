<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class __MysqlCreateView extends __AbstractEditView
{
    function __construct($view_name)
    {
        parent::__construct("CREATE",$view_name);
    }
}

?>