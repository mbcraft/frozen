<?php
/*
 * NOTA DI COPYRIGHT
Questo framework è esclusiva proprietà di Frostlab gate. Ne è vietato l'utilizzo, la copia, la modifica o la redistribuzione 
sotto qualsiasi forma senza l'esplicito consenso da parte di Frostlab gate. Tutti i diritti riservati.
 *
 * COPYRIGHT NOTICE
This framework is exclusive property of Frostlab gate. Usage, copy, changes or redistribution in any form are forbidden
without an explicit agreement with Frostlab gate. All rights reserved.
 */

class TestInstalledModules extends UnitTestCase
{
    function testGetAllProvidedServices()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");
        Storage::set_storage_root(DS.FRAMEWORK_CORE_PATH."tests/modules/test_installed_modules_storage/");
    
        $all_provided_services = InstalledModules::get_all_provided_services();

        $this->assertEqual(count($all_provided_services),2,"Il numero dei servizi forniti non corrisponde!!");

        $k = array_keys($all_provided_services);

        $this->assertTrue($k[0],"gestione_utenti","Il servizio gestione_utenti non e' fornito!!");
        $this->assertTrue($k[1],"contenuti_statici","Il servizio contenuti_statici non e' fornito!!");
        
        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    
    function testMissingRequiredServices()
    {
        //imposto la modules path
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");
        //imposto lo storage root
        Storage::set_storage_root(DS.FRAMEWORK_CORE_PATH."tests/modules/test_installed_modules_storage/");
    
        $all_provided_services = InstalledModules::get_all_provided_services();
        
        $missing_ser_cd_base = InstalledModules::get_missing_required_services($all_provided_services, "contenuti_dinamici", "base");
        //test di un servizio mancante
        $this->assertEqual(count($missing_ser_cd_base),1,"Il numero dei servizi mancanti non corrisponde!!");


        $k = array_keys($missing_ser_cd_base);
        $this->assertEqual($k[0],"gestione_contenuti","Il nome del servizio mancante non corrisponde!!");
        //nessun servizio richiesto
        $missing_ser_gu_common = InstalledModules::get_missing_required_services($all_provided_services, "gestione_utenti", "common");
        $this->assertTrue(count($missing_ser_gu_common)==0);
        //un servizio richiesto ma fornito da gestione_utenti/common
        $missing_ser_gu_base = InstalledModules::get_missing_required_services($all_provided_services, "gestione_utenti", "base");
        $this->assertTrue(count($missing_ser_gu_base)==0);
        
        
        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    
    function testMissingRequiredModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");
        Storage::set_storage_root(DS.FRAMEWORK_CORE_PATH."tests/modules/test_installed_modules_storage/");
        
        $all_installed_modules = InstalledModules::get_all_installed_modules();

        $missing_mod_gu_base = InstalledModules::get_missing_required_modules($all_installed_modules, "gestione_utenti", "base");
        //test con un modulo mancante
        $this->assertEqual(count($missing_mod_gu_base),1,"Il numero di moduli richiesti non corrisponde!!");
        $all_missing_gu_base = array_keys($missing_mod_gu_base);
        $this->assertEqual($all_missing_gu_base[0],"gestione_permessi/base","Il nome del modulo mancante non corrisponde!!");
        //test nessun modulo mancante, nessuna richiesta di moduli
        $missing_mod_gu_common = InstalledModules::get_missing_required_modules($all_installed_modules, "gestione_utenti", "common");
        $this->assertTrue(count($missing_mod_gu_common)==0);
        //test nessun modulo mancante, un modulo richiesto ma installato
        $missing_mod_cd_base = InstalledModules::get_missing_required_modules($all_installed_modules, "contenuti_dinamici", "base");
        $this->assertTrue(count($missing_mod_cd_base)==0);

        Storage::set_storage_root(Storage::get_default_storage_root());
    }
    
    function testGetAllInstalledModules()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");
        Storage::set_storage_root(DS.FRAMEWORK_CORE_PATH."tests/modules/test_installed_modules_storage/");
        
        $all_installed_modules = InstalledModules::get_all_installed_modules();

        $this->assertEqual(count($all_installed_modules),2,"Il numero di moduli installati non corrisponde!!");
        

        Storage::set_storage_root(Storage::get_default_storage_root());
    }

}
?>