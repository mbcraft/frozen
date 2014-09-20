<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ErrorController extends AbstractController
{
    public function layout_not_found()
    {
        $this->missing_layout = $this->__layout;
    }

    public function mapping_not_found()
    {
        
    }
    
    protected function __get_default_layout()
    {
        return "error";
    }
}
?>