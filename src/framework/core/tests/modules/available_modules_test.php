<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestAvailableModules extends UnitTestCase
{
    function testGetAllAvailableModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $all_available_modules = AvailableModules::get_all_available_modules();

        $this->assertEqual(count($all_available_modules),4+1,"Il numero dei moduli disponibili non corrisponde!!");
    }

    function testGetAvailableModulePath()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $path = AvailableModules::get_available_module_path("ecommerce","cart");

        $this->assertEqual("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/",$path,"Il percorso del modulo non corrisponde!! : ".$path);
    }

    function testGetAllByCategory()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $all_base_modules = AvailableModules::get_all_available_by_category("base");

        $this->assertEqual(count($all_base_modules),1);
        $this->assertEqual($all_base_modules[0],"gestione_contenuti");

        $all_ecommerce_modules = AvailableModules::get_all_available_by_category("ecommerce");

        $this->assertEqual(count($all_ecommerce_modules),3);
    }

    function testCategoryList()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $categories = AvailableModules::get_all_available_categories();

        $this->assertEqual(count($categories),4,"Il numero delle categorie non corrisponde al numero atteso!!");
    }

    function testEcommerceCartValid()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $this->assertTrue(ModuleUtils::validate_module("ecommerce","cart"),"L'xml di definizione del modulo ecommerce/cart non risulta essere valido!!");

    }

    function testGetAvailableModuleVersion()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");
        $version_data = $def->get_current_version();

        $version = $version_data["major_version"].".".$version_data["minor_version"].".".$version_data["revision"];

        $this->assertEqual("2.1.7",$version,"La versione del modulo non corrisponde!!");
    }

    function testGetRequiredServices()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $required_services = $def->get_required_services();

        $this->assertEqual(2,count($required_services),"Il numero di servizi richiesti non corrisponde!!");

        $k = array_keys($required_services);

        $this->assertEqual($k[0],"products/categories","Il servizio richiesto numero 0 non corrisponde!!");
        $this->assertEqual($k[1],"products/blabla","Il servizio richiesto numero 1 non corrisponde!!");
    }

    function testGetRequiredModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $required_modules = $def->get_required_modules();

        $this->assertEqual(2,count($required_modules),"Il numero di moduli richiesti non corrisponde!!");

        $k = array_keys($required_modules);

        $this->assertEqual($k[0],"ecommerce/base","Il modulo richiesto 0 non corrisponde!!");
        $this->assertEqual($k[1],"ecommerce/forms","Il modulo richiesto 1 non corrisponde!!");
    }
}

?>