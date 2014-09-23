<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
class FormModel
{
    
    
    const DEFAULT_CURRENCY_LENGTH = 8;
    const DEFAULT_CURRENCY_DECIMALS = 2;
    
    const DEFAULT_CODICE_FISCALE_LENGTH = 16;
    const DEFAULT_PARTITA_IVA_LENGTH = 11;
    const DEFAULT_PASSWORD_LENGTH = 32;
    const DEFAULT_PHONE_LENGTH = 14;
    
    const FORM_TYPE_STANDARD = "standard";
    const FORM_TYPE_UPLOAD = "upload";
    
    private $form_type;
    private $nome_form;
    private $fields = array();
    
    private $data = array();
    
    private $rendering_count;
    

    function __construct($nome_form) 
    {
        $this->form_type = self::FORM_TYPE_STANDARD;
        $this->nome_form = $nome_form;
        
        $this->rendering_count = 0;        
    }
    
    function __get_rendering_count()
    {
        return $this->rendering_count;
    }
    
    function __increase_rendering_count()
    {
        $this->rendering_count += 1;
    }
    
    function __get_form_type()
    {
        return $this->form_type;
    }
    
    function __write_label($key)
    {
        if (!isset($this->fields[$key]))
            throw new FormException("Il campo $key non e' stato definito!!");
        
        $this->fields[$key]->render_label($this->nome_form,$this->rendering_count);
    }
    
    function __write_field($key,$value)
    {
        if (!isset($this->fields[$key]))
                throw new FormException("Il campo $key non e' stato definito!!");
        
        $this->fields[$key]->render_field($this->nome_form,$this->rendering_count,$value);
    }
    
    private function check_already_defined_field($key)
    {
        if (isset($this->fields[$key]))
            throw new FormException("Il campo $key e' gia' stato definito!!");
    }

    public function text($key, $label, $length) 
    {
        $this->check_already_defined_field($key);        
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_TEXT, $label, $length);
    }

    public function number($key, $label, $length, $num_decimals) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_NUMBER, $label, $length, $num_decimals);
    }

    public function percentage($key, $label, $num_decimals) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_PERCENTACE, $label, self::DEFAULT_PERCENTAGE_LENGTH, $num_decimals);
    }

    public function currency($key, $label, $length = self::DEFAULT_CURRENCY_LENGTH, $num_decimals=self::DEFAULT_CURRENCY_DECIMALS) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_CURRENCY, $label, $length, $num_decimals);
    }

    public function date($key, $label) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_DATE, $label);
    }

    public function mail($key, $label) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_MAIL, $label);
    }

    public function phone($key, $label) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_PHONE, $label);
    }

    public function picklist($key, $label, $picklist_values) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_PICKLIST, $label,0,0, $picklist_values);
    }

    public function url($key, $label) 
    {
        $this->check_already_defined_field($key);     
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_URL, $label);
    }

    public function checkbox($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_CHECKBOX, $label);
    }

    public function textarea($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_TEXTAREA, $label);
    }

    public function multiselection($key, $label, $picklist_values) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_MULTISELECTION, $label, 0, 0, $picklist_values);
    }

    public function skype($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_SKYPE, $label);
    }

    public function codice_fiscale($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_CURRENCY, $label, self::DEFAULT_CODICE_FISCALE_LENGTH);
    }
    
    public function partita_iva($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_PARTITA_IVA, $label, self::DEFAULT_PARTITA_IVA_LENGTH);
    }

    public function file($key, $label) 
    {
        $this->check_already_defined_field($key);
        
        $this->form_type = self::FORM_TYPE_UPLOAD;
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_FILE, $label);
    }

    public function captcha($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_CAPTCHA, $label);
    }

    public function password($key, $label) 
    {
        $this->check_already_defined_field($key);
        $this->fields[$key] = new FormField($key, IFormFieldTypes::TYPE_PASSWORD, $label, self::DEFAULT_PASSWORD_LENGTH);
    }

}

?>