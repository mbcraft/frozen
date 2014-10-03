<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

function module_installed($nome_categoria,$nome_modulo)
{
    return InstalledModules::is_installed($nome_categoria, $nome_modulo);
}

function module_not_found($nome_categoria,$nome_modulo)
{
    ?>
<center>
    <div align="center" style="max-width:60%;width:60%;border:1px;border-color: black;border-style: solid;">
        <table>
            <tr>
                <td><img width="40px" src="/framework/core/immagini/simboli/modulo_non_trovato.png" alt="modulo non installato" /></td>
                <td>Il modulo <?= $nome_categoria ?>/<?= $nome_modulo ?> non e' installato!!</td>
            </tr>
        </table>
    </div>
</center>
    <?php
}

class InstalledModules
{
    const INSTALLED_MODULE_CONFIG = "config";
    const INSTALLED_MODULES_STORAGE_DIR = "__installed_modules";
    const MODULE_DEFINITIONS_STORAGE_DIR = "__module_definitions";
    
    static function is_installed($nome_categoria,$nome_modulo)
    {
        $storage = self::__get_properties_storage($nome_categoria,$nome_modulo);
        if ($storage->exists())
            return true;
        else
        {
            $storage2 = self::__get_properties_storage($nome_categoria,$nome_modulo);
            if ($storage2->exists())
                return true;
            else
                return false;
        }
    }

    static function __get_xml_storage($nome_categoria,$nome_modulo)
    {
        return Storage::getXMLStorage(self::MODULE_DEFINITIONS_STORAGE_DIR,$nome_categoria."__".$nome_modulo);
    }

    static function __get_properties_storage($nome_categoria,$nome_modulo)
    {
        return Storage::getPropertiesStorage(self::INSTALLED_MODULES_STORAGE_DIR, $nome_categoria."__".$nome_modulo);
    }

    static function get_installed_module_data($nome_categoria,$nome_modulo)
    {
        $storage = self::__get_xml_storage($nome_categoria,$nome_modulo);

        return $storage->readXML();
    }

    static function get_installed_module_properties($nome_categoria,$nome_modulo)
    {
        $storage = self::__get_properties_storage($nome_categoria,$nome_modulo);
        if (!$storage->exists())
        {
            //$storage = Storage::get(self::INSTALLED_MODULES_STORAGE_DIR."/".$nome_categoria."/".$nome_modulo,self::INSTALLED_MODULE_CONFIG);
            throw new ModuloException("Il modulo non risulta installato : $nome_categoria / $nome_modulo.");
        }
        $all_props = $storage->readAll();

        return $all_props;
    }
    
    /*
     * Ritorna tutti i moduli installati
     */
    static function get_all_installed_modules()
    {
        $all_storages = Storage::getAll(self::INSTALLED_MODULES_STORAGE_DIR);
        
        $result = array();
        
        foreach ($all_storages as $store)
        {
            $result[] = $store->readAll();
        }
        
        
        
        return $result;
    }
    
    static function get_missing_required_modules($all_installed_modules,$nome_categoria,$nome_modulo)
    {
        $storage = self::__get_xml_storage($nome_categoria,$nome_modulo);

        $def = new ModuleDefinition($nome_categoria,$nome_categoria,$storage->readXML());

        return $def->get_missing_required_modules($all_installed_modules);
    }
    
    static function get_missing_required_services($all_provided_services,$nome_categoria,$nome_modulo)
    {
        $storage = self::__get_xml_storage($nome_categoria,$nome_modulo);

        $def = new ModuleDefinition($nome_categoria,$nome_categoria,$storage->readXML());

        return $def->get_missing_required_services($all_provided_services);

    }
    
    /*
     * Ritorna la versione di un modulo installato
     */
    static function get_installed_module_version($nome_categoria,$nome_modulo)
    {
        if (!self::is_installed($nome_categoria, $nome_modulo)) throw new InvalidParametersException();
        
        $storage = self::__get_properties_storage($nome_categoria,$nome_modulo);
        
        $all_props = $storage->readAll();
        
        if (isset($all_props["properties"]))
        {
            $properties = $all_props["properties"];
        
            if (isset($properties["version"]))
            {
                $installed_version = $properties["version"];

                return $installed_version;
            }
            else
                throw new IllegalStateException("Il modulo non risulta installato : ".$nome_categoria." / ".$nome_modulo.".");
        }
    }



    /*
     * Ritorna la definizione del modulo
     */
    static function get_installed_module_definition($nome_categoria,$nome_modulo)
    {
        if (!InstalledModules::is_installed($nome_categoria, $nome_modulo)) throw new InvalidParametersException();
        
        $mod_def_file = new File(AvailableModules::get_available_module_path($nome_categoria,$nome_modulo).AvailableModules::MODULE_DEFINITION_FILE);
        $data = new SimpleXMLElement($mod_def_file->getContent());
        
        return new ModuleDefinition($nome_categoria,$nome_modulo,$data);
    }

    /*
     * Ritorna tutte le azioni disponibili di un modulo.
     */
    public static function get_all_available_actions($nome_categoria,$nome_modulo)
    {
        if (!InstalledModules::is_installed($nome_categoria, $nome_modulo)) throw new InvalidParametersException();
         
        $def = self::get_installed_module_definition($nome_categoria,$nome_modulo);

        return $def->get_available_actions();

    }

    /*
     * Disinstalla un modulo
     */
    static function uninstall($nome_categoria,$nome_modulo)
    {
        if (!InstalledModules::is_installed($nome_categoria, $nome_modulo)) throw new InvalidParametersException();
        
        $mod_def = InstalledModules::get_installed_module_definition($nome_categoria,$nome_modulo);

        $uninstall_data = $mod_def->get_action_data("uninstall");
        $module_plug = ModuleUtils::getModulePlug($nome_categoria,$nome_modulo);
        $module_plug->execute($uninstall_data);

        //deleting module data : properties
        $prop_storage = self::__get_properties_storage($nome_categoria,$nome_modulo);
        if ($prop_storage->exists())
            return $prop_storage->delete();

        //definition file
        $xml_storage = self::__get_xml_storage($nome_categoria,$nome_modulo);
        if ($xml_storage->exists())
            return $xml_storage->delete();

        return true;

    }
    /*
     * Ritorna l'elenco dei servizi forniti da tutti i moduli.
     */
    static function get_all_provided_services()
    {
        $all_services = array();
        
        $all_modules = self::get_all_installed_modules();
        
        foreach ($all_modules as $module)
        {
            $services = $module["provided_services"];
            foreach ($services as $service)
                
            $all_services[] = $service;
        }
        
        return $all_services;
    }

}

?>