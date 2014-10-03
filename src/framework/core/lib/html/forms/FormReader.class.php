<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
class FormReader
{
    private $form_name;
    private $form_model;
    private $form_data;
    
    function __construct($form_name,$model)
    {
        if ($form_name==null)
            throw new FormException("Il nome della form è nullo!!");
        if ($model==null)
            throw new FormException("Il modello della form è nullo!!");
        
        $this->form_name = $form_name;
        $this->form_model = $model;
        $this->form_data = new FormData();
        
    }
}
?>