<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */
/*
 * Le azioni vanno definite prima di aprire la form.
 */

class FormWriter
{
    private $form_name;
    
    private $form_model;
    private $form_data;
    
    private $form_actions = array();
    
    private $default_action = null;
    
    private static $form_opened = false;
    private static $current_form_name = null;
    
    private static $fieldset_opened = false;
    private static $current_fieldset_title = null;
    
    function define_action($key,$path)
    {
        if ($this->default_action === null) $this->default_action = $path;
        $this->form_actions[$key] = $path;
    }
        
    function __construct($form_name,$model)
    {
        if ($form_name==null)
            throw new FormException("Il nome della form è nullo!!");
        if ($model==null)
            throw new FormException("Il modello della form è nullo!!");
        
        $this->form_name = $form_name;
        $this->form_model = $model;
        $this->form_data = new FormData();
        $this->action_count = 0;
    }
    
    /*
     * Apre la form. Viene automaticamente impostato il tipo a seconda del modello in uso.
     */
    function open_form()
    {
        if (self::form_opened) throw new FormException("Impossibile aprire una form : una form risulta gia' aperta : ".self::$current_form_name);
        self::$form_opened = true;
        self::$current_form_name = $this->form_name;
        
        if ($this->form_model->__get_form_type()==FormModel::FORM_TYPE_UPLOAD)
        {
            ?>
<form name="<?=$this->form_name ?>" action="<?=$this->default_action ?>" method="POST" id="form__<?=$this->form_name ?>_<?=$this->form_model->__rendering_count() ?>" enctype="multipart/form-data">
            <?
        }
        else
        {
            ?>
<form name="<?=$this->form_name ?>" action="<?=$this->default_action ?>" method="POST" id="form__<?=$this->form_name ?>_<?=$this->form_model->__rendering_count() ?>" >
            <?
        }
    }
    
    /*
     * Funzione utilizzata per raggruppare un insieme di campi fra loro. 
     */
    function open_fieldset($title)
    {
        if (self::$fieldset_opened) throw new FormException("Impossibile aprire un fieldset : un fieldset risulta gia' aperto : ".self::$current_fieldset_title);
        self::$fieldset_opened = true;
        self::$current_fieldset_title = $title;
        
        ?>
    <fieldset>
        <legend><?=$title ?></legend>
        <?
    }
    /*
     * Chiude il fieldset.
     */
    function close_fieldset()
    {
        ?>
    </fieldset>
        <?
        
        self::$fieldset_opened = false;
        self::$current_fieldset_title = null;
    }
    
    /*
     * Chiude la form.
     */
    function close_form()
    {
        ?>
</form>
        <?
        
        self::$form_opened = false;
        self::$current_form_name = null;
    }
    
    /*
     * Scrive una label data la chiave.
     */
    function write_label($key)
    {
        $this->form_model->__write_label($key);
    }
    
    /*
     * Scrive un campo data la chiave.
     */
    function write_field($key)
    {        
        $value = $this->form_data->get_value_or_null($key);
        $this->form_model->__write_field($key,$value);
    }
    
    /*
     * Scrive una action data la chiave.
     */
    function write_action($key)
    {
        if (isset($this->form_actions[$key]))
                throw new FormException("L'azione non e' stata definita!!");
        ?>
    <input type="submit" name="<?=$key ?>" value="<?=$this->form_actions[$key] ?>" ></input>
        <?
        $this->form_action_count += 1;
    }
    
    function set_form_data($form_data)
    {
        if ($form_data==null) throw new FormException("I dati impostati al writer non sono validi!!");
        
        $this->form_data = $form_data;
    }
    
    function get_form_data()
    {
        return $this->form_data;
    }
    
    function get_form_model()
    {
        return $this->form_model;
    }
}
?>