<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

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