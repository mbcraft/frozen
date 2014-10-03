<?php
/* This software is released under the GPLv2 license. Full text at : http://www.gnu.org/licenses/gpl-2.0.html */

/*
 * Classe per ispezionare i moduli disponibili nella cartella dei moduli.
 */

class AvailableModules extends BasicObject
{
    const MODULE_DEFINITION_FILE = "module.xml";

    /*
     * Ritorna tutti i moduli disponibili
     * */
    static function get_all_available_modules()
    {
        $result = array();

        $categories = self::get_all_available_categories();

        foreach ($categories as $nome_categoria)
        {
            $names = self::get_all_available_by_category($nome_categoria);

            if (is_array($names))
            foreach ($names as $nome_modulo)
            {
                $def = self::get_available_module_definition($nome_categoria,$nome_modulo);
                
                $mod = array();
                $mod["show"] = $def->get_show();
                $mod["nome_categoria"] = $nome_categoria;
                $mod["nome_modulo"] = $nome_modulo;
                $version = $def->get_current_version();
                $mod["properties"] = $version;
                $result[] = $mod;
                
            }
            else echo "Errore per la categoria : ".$nome_categoria;

        }

        return $result;
    }

    /*
     * Ritorna l'elenco delle categorie di moduli disponibili
     */
    static function get_all_available_categories()
    {
        //moduli primari
        $modules_root = new Dir(DS.ModuleUtils::get_modules_path());

        $all_folders = $modules_root->listFolders();

        $result = array();

        foreach ($all_folders as $cat)
        {
            if ($cat->isDir())
            {
                $result[] = $cat->getName();
            }
        }

        //aggiungo la categoria framework se non è presente.
        if (!ArrayUtils::has_value($result, ModuleUtils::FRAMEWORK_CATEGORY_NAME))
            $result[] = ModuleUtils::FRAMEWORK_CATEGORY_NAME;
        //ok

        return $result;
    }

  /*
     * Ritorna L'elenco dei moduli di una determinata categoria
     */
    static function get_all_available_by_category($nome_categoria)
    {
        $result = array();

        $category_root = new Dir(DS.ModuleUtils::get_modules_path().DS.$nome_categoria.DS);

        if ($category_root->exists() && $category_root->isDir())
        {
            $all_folders = $category_root->listFolders();

            foreach ($all_folders as $mod)
            {
                //aggiunto controllo su esistenza modulo definizione
                $mod_def = new File($mod->getPath().self::MODULE_DEFINITION_FILE);
                if ($mod_def->exists())
                {
                    $result[] = $mod->getName();
                }
            }

        }

        if ($nome_categoria==ModuleUtils::FRAMEWORK_CATEGORY_NAME)
            $result[] = ModuleUtils::FRAMEWORK_MODULE_NAME;

        return $result;
    }

    /*
     * Ritorna il percorso completo di un determinato modulo
     */
    static function get_available_module_path($nome_categoria,$nome_modulo)
    {
        // framework/core

        if ($nome_categoria===ModuleUtils::FRAMEWORK_CATEGORY_NAME && $nome_modulo===ModuleUtils::FRAMEWORK_MODULE_NAME)
            return DS.ModuleUtils::get_framework_core_path();

        //moduli primari
        $module_dir = new Dir(DS.ModuleUtils::get_modules_path().$nome_categoria.DS.$nome_modulo.DS);
        //ok aggiunto controllo su definizione del modulo
        $module_def = new File($module_dir->getPath().self::MODULE_DEFINITION_FILE);

        if ($module_def->exists())
            return $module_dir->getPath();

        //eccezione, modulo non trovato
        throw new Exception("Il modulo di categoria $nome_categoria di nome $nome_modulo non esiste!");
    }

    /*
     * Ritorna true se un modulo è disponibile (con tanto di definizione), false altrimenti
     */
    static function is_module_available($nome_categoria,$nome_modulo)
    {
        if ($nome_categoria===ModuleUtils::FRAMEWORK_CATEGORY_NAME && $nome_modulo===ModuleUtils::FRAMEWORK_MODULE_NAME)
            return DS.ModuleUtils::get_framework_core_path();

        //moduli primari
        $module_dir = new Dir(DS.ModuleUtils::get_modules_path().$nome_categoria.DS.$nome_modulo.DS);
        //ok aggiunto controllo su definizione del modulo
        $module_def = new File($module_dir->getPath().self::MODULE_DEFINITION_FILE);
        
        if ($module_def->exists()) return true;
        else return false;
    }

    static function get_available_module_definition($nome_categoria,$nome_modulo)
    {
        $mod_def_file = new File(self::get_available_module_path($nome_categoria,$nome_modulo).self::MODULE_DEFINITION_FILE);
        $data = new SimpleXMLElement($mod_def_file->getContent());
        return new ModuleDefinition($nome_categoria,$nome_modulo,$data);
    }

    static function install($nome_categoria,$nome_modulo)
    {
        $def = self::get_available_module_definition($nome_categoria,$nome_modulo);

        //checking for required modules ...
        $properties_storage = InstalledModules::__get_properties_storage($nome_categoria,$nome_modulo);
        $properties_storage->create();
        $properties_storage->add("global", array("nome_categoria" => $nome_categoria,"nome_modulo" => $nome_modulo));

        $version = $def->get_current_version();

        $properties_storage->add("properties", $version);

        //eventualmente altro ...

        $module_def_storage = InstalledModules::__get_xml_storage($nome_categoria,$nome_modulo);
        $module_def_storage->saveXML($def->get_data());

        $install_data = $def->get_action_data("install");
        $module_plug = ModuleUtils::getModulePlug($nome_categoria,$nome_modulo);
        $module_plug->execute($install_data);

    }
   
}

?>