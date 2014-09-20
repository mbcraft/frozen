<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class ModuleUtils
{
    const MODULE_REQUIRED_SERVICES = "required_services";
    const MODULE_REQUIRED_MODULES = "required_modules";

    const MODULE_PROVIDED_SERVICES = "provided_services";

    const FRAMEWORK_CATEGORY_NAME = "framework";
    const FRAMEWORK_MODULE_NAME = "core";

    const SECONDARY_MODULES_PATH = "/include/modules/";

    public static $framework_core_path = FRAMEWORK_CORE_PATH;
    public static $modules_path = FRAMEWORK_MODULES_PATH;

    static function get_framework_core_path()
    {
        return self::$framework_core_path;
    }

    static function set_framework_core_path($new_core_path)
    {
        $dir = new Dir(DS.$new_core_path);
        if (!$dir->exists())
        {
            Log::error("ModuleUtils::set_framework_core_path", "Error : core root directory must exist -> ".$new_core_path);
        }
        else
            self::$framework_core_path = $new_core_path;
    }

    static function get_modules_path()
    {
        return self::$modules_path;
    }

    static function set_modules_path($new_modules_path)
    {
        $dir = new Dir(DS.$new_modules_path);
        if (!$dir->exists())
        {
            Log::error("ModuleUtils::set_modules_path", "Error : modules root directory must exist -> ".$new_modules_path);
        }
        else
            self::$modules_path = $new_modules_path;
    }

    static function getModulePlug($nome_categoria,$nome_modulo)
    {
        $module_path = AvailableModules::get_available_module_path($nome_categoria,$nome_modulo);
        $module_dir = new Dir($module_path);
        return new ModulePlug($module_dir);
    }

    static function validate_module($nome_categoria,$nome_modulo)
    {
        $module_file = new File(AvailableModules::get_available_module_path($nome_categoria,$nome_modulo).AvailableModules::MODULE_DEFINITION_FILE);

        $schema_url = "http://www.frostlab.it/schemas/2011/module.rnc";

        $validator_url = "http://validator.nu?level=error&out=xml&schema=".urlencode($schema_url);

        $ch = curl_init($validator_url);

        $headers = array("Content-Type: application/xml","Referer: Frostlab gate - Italy - info@frostlab.it");

        curl_setopt($ch,CURLOPT_HEADER,0);
        curl_setopt($ch,CURLOPT_VERBOSE,0);
        curl_setopt($ch,CURLOPT_HTTPHEADER,$headers);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$module_file->getContent());
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

        $result = curl_exec($ch);

        $xml_result = new SimpleXMLElement($result);

        foreach ($xml_result->error as $error)
        {
            //$attribs = $error->attributes();
            var_dump($error);
            //echo $attribs->line_number." : ".$error->message."<br />";
        }

        return count($xml_result->children())==0;
    }
}

?>