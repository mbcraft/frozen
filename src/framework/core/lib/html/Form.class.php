<?php

/* This software is released under the BSD license. Full text at project root -> license.txt */

class Form
{

    public static function open($type,$name,$action)
    {
        list($form_class_prefix,$function_name) = explode("/",$type);

        $class_name = StringUtils::underscored_to_camel_case($form_class_prefix)."FormFieldFactory";

        $form_field_factory = __create_instance($class_name);

        $form_field_factory->{$function_name}($name,$action);
    }

    public static function create($type,$name,$value=null)
    {
        list($form_class_prefix,$function_name) = explode("/",$type);

        $class_name = StringUtils::underscored_to_camel_case($form_class_prefix)."FormFieldFactory";

        $form_field_factory = __create_instance($class_name);

        $form_field_factory->{$function_name}($name,$value);
    }

    public static function after($path)
    {
        self::on_success($path);
        self::on_failure($path);
    }

    public static function on_success($path)
    {
        echo "<input type=\"hidden\" name=\"__on_success\" value=\"".$path."\" />";
    }

    public static function on_failure($path)
    {
        echo "<input type=\"hidden\" name=\"__on_failure\" value=\"".$path."\" />";
    }

    public static function close()
    {
        echo "</form>";
    }

}

?>