<?php

class TestModuleDefinition extends UnitTestCase
{
    function testActions()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $actions = $def->get_available_actions();

        $this->assertEqual(count($actions),4,"Il numero di azioni trovate non corrisponde!!");

        $this->assertEqual($actions[0],"install","Il nome dell'azione non corrisponde!!");
        $this->assertEqual($actions[1],"create_view","Il nome dell'azione non corrisponde!!");
        $this->assertEqual($actions[2],"drop_view","Il nome dell'azione non corrisponde!!");
        $this->assertEqual($actions[3],"uninstall","Il nome dell'azione non corrisponde!!");

        $this->assertNotNull($def->get_action_data("install"),"L'azione ritornata e' nulla!!");
        $this->assertTrue($def->get_action_data("install") instanceof SimpleXMLElement,"Il tipo ritornato non corrisponde!!");

    }

    function testRequiredModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $required_modules = $def->get_required_modules();

        $this->assertEqual(count($required_modules),2,"Il numero di moduli richiesti non corrisponde!!");
    }

    function testRequiredServices()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $required_services = $def->get_required_services();

        $this->assertEqual(count($required_services),2,"Il numero di servizi richiesti non corrisponde!!");
    }

    function testProvidedServices()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $provided_services = $def->get_provided_services();

        $this->assertEqual(count($provided_services),1,"Il numero di servizi forniti non corrisponde!!");
    }

    function testCurrentVersion()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $current_version = $def->get_current_version();

        $this->assertEqual($current_version["major_version"],2,"Major version non corrispondente!!");
        $this->assertEqual($current_version["minor_version"],1,"Minor version non corrispondente!!");
        $this->assertEqual($current_version["revision"],7,"Revision non corrispondente!!");
    }

    function testMissingRequiredModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $all_installed_modules = array("ecommerce/forms" => array(),"contenuti/gestione_contenuti" => array());

        $missing_required_modules = $def->get_missing_required_modules($all_installed_modules);

        $k = array_keys($missing_required_modules);

        $this->assertTrue(count($missing_required_modules)==1,"Il numero di moduli mancanti non corrisponde!!");
        $this->assertEqual($k[0],"ecommerce/base","Il nome del modulo mancante non corrisponde!!");
    }

    function testMissingRequiredServices()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $all_provided_services = array("products/blabla" => array(),"products/storage" => array());

        $missing_required_services = $def->get_missing_required_services($all_provided_services);

        $k = array_keys($missing_required_services);

        $this->assertTrue(count($missing_required_services)==1,"Il numero di servizi mancanti non corrisponde!!");
        $this->assertEqual($k[0],"products/categories","Il nome del modulo mancante non corrisponde!!");
    }

    function testDescription()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $this->assertEqual($def->get_description(),"Modulo ecommerce cart di test.","La descrizione del modulo non corrisponde!!");
    }


}

?>