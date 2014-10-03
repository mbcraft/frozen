<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */
/*
 * Installazione e disinstallazione di moduli, sembra essere ok
 */
class ModulesController extends AbstractController
{
    function upgrade()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");

        //$result = InstalledModules::upgrade($nome_categoria, $nome_modulo);

        throw new UnsupportedOperationException();
    }

    /*
     * Installa un modulo (core compreso)
     */
    function install()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");

        //salvo il modulo sullo storage con le varie proprietà
        AvailableModules::install($nome_categoria, $nome_modulo);

        Flash::ok("Installazione effettuata con successo.");

        return Redirect::success();
    }

    /*
     * Ritorna la versione di un modulo (core compreso)
     */

    function get_module_version()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");

        return InstalledModules::get_installed_module_version($nome_categoria,$nome_modulo);
    }

    function execute_action()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");
        $command = Params::get("command");

        if ($command!="install" && $command!="uninstall" && $command!=null)
        {
            $def = AvailableModules::get_available_module_definition($nome_categoria,$nome_modulo);

            $action_data = $def->get_action_data($command);

            $plug = ModuleUtils::getModulePlug($nome_categoria,$nome_modulo);
            $plug->execute($action_data);

            Flash::ok("Azione '".$command."' eseguita con successo.");

            return Redirect::success();
        }
        else
            return Redirect::failure();
    }
    /*
     * Disinstalla un modulo (core compreso)
     */
    function uninstall()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");
        
        //running uninstall script
        InstalledModules::uninstall($nome_categoria, $nome_modulo);
        //end deleting module data ...

        Flash::ok("Disinstallazione effettuata con successo.");
            
        return Redirect::success();
    }

    function delete()
    {
        $nome_categoria = Params::get("nome_categoria");
        $nome_modulo = Params::get("nome_modulo");

        if ($nome_categoria!==ModuleUtils::FRAMEWORK_CATEGORY_NAME && $nome_modulo!==ModuleUtils::FRAMEWORK_MODULE_NAME)
        {

            $path = AvailableModules::get_available_module_path($nome_categoria,$nome_modulo);

            $d = new Dir($path);
            $d->delete(true);
            Flash::ok("Modulo ".$nome_categoria."/".$nome_modulo." eliminato con successo!!");
            return Redirect::success();
        }
        else
        {
            Flash::error("Impossibile eliminare il modulo ".$nome_categoria."/".$nome_modulo);
            return Redirect::failure();
        }
    }

    function get_installed_modules()
    {
        $installed_modules = InstalledModules::get_all_installed_modules();
        $all_provided_services = InstalledModules::get_all_provided_services();

        foreach ($installed_modules as $mod)
        {
            $mod["additional"] = array();
            //$mod["additional"]["missing_modules"] = InstalledModules::get_missing_required_modules($installed_modules, $mod["global"]["nome_categoria"], $mod["global"]["nome_modulo"]);
            //$mod["additional"]["missing_services"] = InstalledModules::get_missing_required_services($all_provided_services, $mod["global"]["nome_categoria"], $mod["global"]["nome_modulo"]);
        }
        
        return $installed_modules;
    }
    
    function get_available_modules()
    {
        return AvailableModules::get_all_available_modules();
    }
    
    function get_provided_services()
    {
        //return InstalledModules::get_all_provided_services();
    }
    
}

?>