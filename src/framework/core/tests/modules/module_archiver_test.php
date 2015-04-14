<?php

class TestModuleArchiver extends UnitTestCase
{
    function testSaveAsArchive()
    {
        $result_file = new File(ModuleArchiver::MODULES_ARCHIVE_DIR."test__category-1_2_3.ffa");
        
        $this->assertFalse($result_file->exists(),"Il file del modulo non e' stato creato!!");
        
        
        ModuleUtils::set_modules_path("/".FRAMEWORK_CORE_PATH."tests/modules/fakeroot2/modules/");
        
        $this->assertTrue(AvailableModules::is_module_available("test", "category"),"Il modulo test/category non e' disponibile!!");
        
        ModuleArchiver::save_as_archive("test", "category");
        
        $this->assertTrue($result_file->exists(),"Il file del modulo non e' stato creato!!");
        $this->assertTrue($result_file->getSize()>0,"Il file e' vuoto!!");
        
        $result_file->delete();
        
        ModuleUtils::set_modules_path("/framework/modules/");
    }
    
    function testExtractFromArchive()
    {
        $result_file = new File(ModuleArchiver::MODULES_ARCHIVE_DIR."test__category-1_2_3.ffa");
        
        $this->assertFalse($result_file->exists(),"Il file del modulo non e' stato creato!!");
        
        
        ModuleUtils::set_modules_path("/".FRAMEWORK_CORE_PATH."tests/modules/fakeroot2/modules/");
        
        ModuleArchiver::save_as_archive("test", "category");
        
        ModuleUtils::set_modules_path("/".FRAMEWORK_CORE_PATH."tests/modules/fakeroot2/modules_out/");
        
        ModuleArchiver::extract_from_archive("test__category-1_2_3.ffa");
        
        $extracted_module_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/fakeroot2/modules_out/test/category/");
        $this->assertTrue($extracted_module_dir->exists(),"La cartella del modulo non e' stata creata!!");
        $module_file = $extracted_module_dir->newFile(AvailableModules::MODULE_DEFINITION_FILE);
        $this->assertTrue($module_file->exists(),"Il file di definizione del modulo non esiste!!");
        
        $parent_module_dir = $extracted_module_dir->getParentDir();
        $parent_module_dir->delete(true);
        
        ModuleUtils::set_modules_path("/framework/modules/");
    }
    
    function testGetAvailableArchives()
    {
        $d = new Dir(ModuleArchiver::MODULES_ARCHIVE_DIR);
        $a1 = $d->newFile("test__category-1_2_3.ffa");
        $a1->touch();
        
        $a2 = $d->newFile("test__product-4_3_1.ffa");
        $a2->touch();
        
        $f3 = $d->newFile("element__list-1_0_0.ffa");
        $f3->touch();
        
        $available_module_archives = ModuleArchiver::get_available_module_archives();
        
        $this->assertTrue(count($available_module_archives)==3,"Il numero di archivi disponibili non corrisponde!! : ".count($available_module_archives));
        
        $a1->delete();
        $a2->delete();
        $f3->delete();
    }
}

?>