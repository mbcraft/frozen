<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class Framework
{
    public static function init()
    {       
        Log::info("Framework::init","Initializing framework ...");
        self::doAllInitialization();
        Log::info("Framework::init","Framework initialized!");



        new ModulesController();
    }
    
    /*
     * Qui va inserito tutto il codice necessario per effettuare l'inizializzazione di un modulo, da definire uno standard.
     */
    private static function initializeModule($nome_categoria,$nome_modulo)
    {
        ModuleUtils::runScriptIfFound($nome_categoria, $nome_modulo, "load");
        
    }

    private static function doAllInitialization()
    {
        /*
         * Se il core non è installato si installa
         * */

        if (!InstalledModules::is_installed(ModuleUtils::FRAMEWORK_CATEGORY_NAME,ModuleUtils::FRAMEWORK_MODULE_NAME))
        {
            AvailableModules::install(ModuleUtils::FRAMEWORK_CATEGORY_NAME,ModuleUtils::FRAMEWORK_MODULE_NAME);
        }

        //il core è sicuramente installato, ora per tutti i moduli eseguo il load ...
        return ;
        $all_installed_modules = InstalledModules::get_all_installed_modules();

        foreach ($all_installed_modules as $module)
        {
            extract($module["global"]);
            
            if ($nome_categoria != ModuleUtils::FRAMEWORK_CATEGORY_NAME && $nome_modulo != ModuleUtils::FRAMEWORK_MODULE_NAME)
            {
                if (AvailableModules::is_module_ok($nome_categoria, $nome_modulo))
                {
                    extract($module["properties"]);
                    
                    //$installed_version = $major_version.".".$minor_version.".".$revision;
                    //$filesystem_version = AvailableModules::get_available_module_version($nome_categoria, $nome_modulo);
                    /*
                    if ($installed_version==$filesystem_version)
                        self::initializeModule($nome_categoria,$nome_modulo);
                    else
                    {
                        Log::warn("doAllInitialization", "Module version mismatch ".$nome_categoria."/".$nome_modulo." : installed ($installed_version) - filesystem ($filesystem_version)" );
                    }
                    */
                }
                else
                {
                    //attenzione : modulo installato non presente su filesystem : errore!!
                    throw new Exception("Modulo $nome_categoria/$nome_modulo installato ma non presente su filesystem.");
                }
            }
        }
         
    }
}

?>