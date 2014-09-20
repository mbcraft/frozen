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

class TestModulePlug extends UnitTestCase
{
    public function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);
    }

    public function tearDown()
    {
       DB::closeConnection();
    }

    function testAdd()
    {
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        $module_plug_test_root->newSubdir("blocks")->touch();
        
        ModulePlug::setRootDir($module_plug_test_root->getPath());
        
        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));     
        
        $plug->add("js/");
        $plug->add("blocks/test.block.php");
        
        
        $f_block = new File("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/blocks/test.block.php");
        $this->assertTrue($f_block->exists(),"Il file test.block.php non e' stato copiato!!");
        
        $f_no_plug = new File("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/blocks/no_plug.block.php");
        $this->assertFalse($f_no_plug->exists(),"Il file no_plug.block.php e' stato copiato!!");
        
        $f_jslib1 = new File("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/js/my_js_lib/mylib.js");
        $this->assertTrue($f_jslib1->exists(),"Il file libreria js1 non e' stato copiato!!");
        
        $f_jslib2 = new File("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/js/my_js_lib/mylib2.js");
        $this->assertTrue($f_jslib2->exists(),"Il file libreria js2 non e' stato copiato!!");
        
        ModulePlug::setRootDir("/");
        
        $all_module_plug_files = $module_plug_test_root->listFiles();
        foreach ($all_module_plug_files as $ff)
            $ff->delete(true);
    }
    
    function testRemove()
    {
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        ModulePlug::setRootDir($module_plug_test_root);
        
        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));     

        $sub_dir = $module_plug_test_root->newSubdir("blocks");
        
        $block_file = $sub_dir->newFile("test.block.php");
        $block_file->setContent("BLA BLA BLA");
        
        $this->assertTrue($block_file->exists(),"Il file test.block.php non e' presente!!");
        
        $plug->remove("blocks/test.block.php");
        
        $this->assertFalse($block_file->exists(),"Il file test.block.php non e' stato rimosso!!");
        
        $js_dir = $module_plug_test_root->newSubdir("js");
        $js_dir->touch();
        
        $my_js_lib_subdir = $js_dir->newSubdir("my_js_lib");
        $my_js_lib_subdir->touch();
        
        $mylib_file = $my_js_lib_subdir->newFile("mylib.js");
        $mylib_file->setContent("HELLO!!");
        $this->assertTrue($mylib_file->exists(),"Il file non e' stato creato!!");
        
        $mylib3_file = $my_js_lib_subdir->newFile("mylib3.js");
        $mylib3_file->setContent("WORLD!!");
        $this->assertTrue($mylib3_file->exists(),"Il file non e' stato creato!!");
        
        $plug->remove("js/");
        $this->assertFalse($mylib_file->exists(),"Il file mylib.js non e' stato rimosso!!");
        $this->assertTrue($mylib3_file->exists(),"Il file mylib3.js e' stato rimosso!!");
        
        ModulePlug::setRootDir("/");
        
        $all_module_plug_files = $module_plug_test_root->listFiles();
        foreach ($all_module_plug_files as $ff)
            $ff->delete(true);
    }

    
    function testMkdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/prova/");
        
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        ModulePlug::setRootDir($module_plug_test_root->getPath());
        
        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));     
        
        $this->assertFalse($dir->exists(),"La directory da creare esiste gia'!!");
        
        $plug->mkdir("prova");
        $this->assertTrue($dir->exists(),"La directory non è stata creata!!");
        $dir->delete();
        
        ModulePlug::setRootDir("/");
    }

    function testRmdir()
    {
        $dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/prova/");
        
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        ModulePlug::setRootDir($module_plug_test_root->getPath());
        
        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));     
        
        $this->assertFalse($dir->exists(),"La directory c'e' gia'!!");
        $dir->touch();
        $this->assertTrue($dir->exists(),"La directory non e' stata creata!!");
        
        $plug->rmdir("prova");
        
        $this->assertFalse($dir->exists(),"La directory non e' stata eliminata!!");
        
        ModulePlug::setRootDir("/");
    }

    /*
    function testExtract()
    {
        $f = new File(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/products/files/rotator_gallery.fga");
        $f->delete();

        $props = array("description" => "Rotator gallery");

        FGArchive::compress($f,FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/products/files/",$props);

        //dove innesto i moduli
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        ModulePlug::setRootDir($module_plug_test_root->getPath());

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/products/"));

        $plug->extract("files/rotator_gallery.fga","/");

        $expanded_rotator_gallery = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/rotator_gallery/");

        $this->assertTrue($expanded_rotator_gallery->exists(),"La directory 'rotator_gallery' non e' stata creata!!");

        $images_dir = $expanded_rotator_gallery->newSubdir("images");

        $this->assertTrue($images_dir->exists(),"La directory 'images' non e' stata creata!!");
        $this->assertTrue(count($images_dir->listFiles()),4,"La directory non contiene le 4 immagini!!");

        $expanded_rotator_gallery->delete(true);

        $archive_file = new File("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/rotator_gallery.fga");
        $this->assertFalse($archive_file->exists(),"Il file con l'archivio e' rimasto nella cartella in cui e' stato decompresso!!");

        $this->assertFalse($expanded_rotator_gallery->exists(),"La directory non e' stata eliminata!!");

        ModulePlug::setRootDir("/");
    }
    */

    function testExecute()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $ciccia_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/ciccia/");

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("my_entity"),"La tabella my_entity e' gia' presente nel database!!");

        $this->assertFalse($ciccia_dir->exists(),"La directory 'ciccia' esiste gia'!!");

        //dove innesto i moduli
        $module_plug_test_root = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/");
        ModulePlug::setRootDir($module_plug_test_root->getPath());

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $install_data = $def->get_action_data("install");

        $plug->execute($install_data);

        $db_desc = DB::newDatabaseDescription();
        $this->assertTrue($db_desc->hasTable("my_entity"),"La tabella my_entity non e' stata creata!!");

        $sel = DB::newSelect("my_entity");
        $sel->count("*","num_entries");
        $result = $sel->exec_fetch_assoc();

        $this->assertEqual($result["num_entries"],2,"Il numero di righe nella tabella non corrisponde!!");

        $table_desc = DB::newTableFieldsDescription("my_entity");
        $this->assertTrue($table_desc->hasField("new_field"),"Il campo new_field non e' stato aggiunto!!");
        $this->assertTrue($table_desc->hasField("int_field"),"Il campo int_field non e' stato aggiunto!!");


        $ciccia_dir = new Dir("/".FRAMEWORK_CORE_PATH."tests/modules/module_plug_root/ciccia/");

        $this->assertTrue($ciccia_dir->exists(),"La directory 'ciccia' non e' stata creata!!");

        $uninstall_data = $def->get_action_data("uninstall");

        $plug->execute($uninstall_data[0]);

        $this->assertFalse($ciccia_dir->exists(),"La directory ciccia non e' stata eliminata!!");

        ModulePlug::setRootDir("/");
    }

    function testExecute2()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("tab_prova"),"La tabella tab_prova e' gia' presente nel database!!");

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $def = AvailableModules::get_available_module_definition("sample","sample_01");

        $install_data = $def->get_action_data("install");

        $plug->execute($install_data);

        $db_desc = DB::newDatabaseDescription();

        $this->assertTrue($db_desc->hasTable("tab_prova"),"La tabella tab_prova non e' stata creata!!");

        $table_desc = DB::newTableFieldsDescription("tab_prova");
        $field_count = count($table_desc->getAllFields());
        $this->assertTrue($table_desc->hasField("useless_f1"),"Il campo useless_f1 non e' stato trovato!!");
        $this->assertTrue($table_desc->hasField("useless_f2"),"Il campo useless_f2 non e' stato trovato!!");

        $this->assertEqual($field_count,21,"Il numero dei campi nella tabella non corrisponde!! : ".$field_count);

        $drop_fields_data = $def->get_action_data("drop_some_fields");

        $plug->execute($drop_fields_data);

        $table_desc = DB::newTableFieldsDescription("tab_prova");
        $field_count = count($table_desc->getAllFields());

        $this->assertEqual($field_count,19,"Il numero dei campi nella tabella non corrisponde!! : ".$field_count);

        $uninstall_data = $def->get_action_data("uninstall");

        $plug->execute($uninstall_data);

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("tab_prova"),"La tabella tab_prova non e' stata eliminata!!");

        ModulePlug::setRootDir("/");
    }

    function testExecute3RenamePrimaryKey()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("tab_prova"),"La tabella tab_prova e' gia' presente nel database!!");

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $def = AvailableModules::get_available_module_definition("sample","sample_01");

        $install_data = $def->get_action_data("install");

        $plug->execute($install_data);

        $rename_primary_key_data = $def->get_action_data("rename_primary_key");

        $plug->execute($rename_primary_key_data);

        $table_desc = DB::newTableFieldsDescription("tab_prova");

        $this->assertTrue($table_desc->hasField("id_account_rinominato"),"Il campo useless_f1 non e' stato trovato!!");

        $uninstall_data = $def->get_action_data("uninstall");

        $plug->execute($uninstall_data[0]);

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("tab_prova"),"La tabella tab_prova non e' stata eliminata!!");

        ModulePlug::setRootDir("/");

    }

    function testExecuteSqlIfFound()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/products/"));

        $install_found = $plug->execute_sql_if_found("install");
        $this->assertTrue($install_found,"Il file sql 'install.sql' non e' stato trovato!!");

        $db_desc = DB::newDatabaseDescription();

        $this->assertTrue($db_desc->hasTable("test_table"),"Tabella di test non creata!");

        $uninstall_found = $plug->execute_sql_if_found("uninstall");
        $this->assertTrue($uninstall_found,"Il file sql 'uninstall.sql' non e' stato trovato!!");

        $db_desc = DB::newDatabaseDescription();

        $this->assertFalse($db_desc->hasTable("test_table"),"Tabella di test non creata!");

        $strange_script_found = $plug->execute_sql_if_found("strange_script");

        $this->assertFalse($strange_script_found,"Errore nel valore di ritorno della funzione.");
    }

    function testRunScriptIfFound()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/products/"));

        $my_script_found = $plug->run_script_if_found("my_script");
        $this->assertTrue($my_script_found,"Lo script non e' stato trovato!!");


        $this->assertTrue(defined("MY_MODULE_SCRIPT_HAS_RUN"),"Lo script del modulo non è stato eseguito!!");
        $this->assertTrue($my_script_found,"Errore nel valore di ritorno della funzione.");

        $strange_script_found = $plug->run_script_if_found("strange_script");
        $this->assertFalse($strange_script_found,"Errore nel valore di ritorno della funzione.");
    }

    private $create_for_view = "
    CREATE TABLE IF NOT EXISTS `destinatari` (
`id_destinatario` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
`nome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
`cognome` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
UNIQUE KEY `id_destinatario` (`id_destinatario`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
INSERT INTO `destinatari` (`id_destinatario`, `nome`, `cognome`) VALUES
(1, 'Marco', 'Bagnaresi'),
(2, 'Michele', 'Rispoli');

CREATE TABLE IF NOT EXISTS `prodotti` (
  `id_prodotto` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `nome_prodotto` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8_unicode_ci NOT NULL,
  `prezzo` float NOT NULL,
  UNIQUE KEY `id_prodotto` (`id_prodotto`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=3 ;
INSERT INTO `prodotti` (`id_prodotto`, `nome_prodotto`, `descrizione`, `prezzo`) VALUES
(1, 'Riso', 'riso scotti', 12.5),
(2, 'Pasta', 'Pasta rigata', 4.5);

CREATE TABLE IF NOT EXISTS `vendite` (
  `id_vendita` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `quantita` int(11) NOT NULL,
  `id_prodotto` bigint(20) NOT NULL,
  `id_destinatario` bigint(20) NOT NULL,
  UNIQUE KEY `id_vendita` (`id_vendita`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=4 ;
INSERT INTO `vendite` (`id_vendita`, `quantita`, `id_prodotto`, `id_destinatario`) VALUES
(1, 4, 1, 2),
(2, 3, 2, 2),
(3, 3, 2, 1),
(4, 7, 2, 1);
    ";

    private $create_view = "
    CREATE ALGORITHM=MERGE VIEW `vendite_full` AS select `vendite`.`id_vendita` AS `id_vendita`,`vendite`.`quantita` AS `quantita`,`destinatari`.`nome` AS `nome`,`destinatari`.`cognome` AS `cognome`,`prodotti`.`nome_prodotto` AS `nome_prodotto`,`prodotti`.`descrizione` AS `descrizione`,`prodotti`.`prezzo` AS `prezzo` from ((`vendite` join `prodotti`) join `destinatari`) where ((`vendite`.`id_destinatario` = `destinatari`.`id_destinatario`) and (`vendite`.`id_prodotto` = `prodotti`.`id_prodotto`));
    ";
    private $drop_view = "DROP VIEW `vendite_full`;";
    private $drop_for_view = "
    DROP TABLE `vendite`;
    DROP TABLE `destinatari`;
    DROP TABLE `prodotti`;
    ";


    function testCreateOrUpdateViewFields()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("vendite_full"),"La vista vendite_full esiste gia'!!");

        DB::newDirectSql($this->create_for_view)->exec();

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $create_view = $def->get_action_data("create_view");

        $plug->execute($create_view);

        $db_desc = DB::newDatabaseDescription();
        $this->assertTrue($db_desc->hasTable("vendite_full"),"La vista vendite_full non e' stata creata!!");

        DB::newDirectSql($this->drop_view)->exec();
        DB::newDirectSql($this->drop_for_view)->exec();
    }


    function testDropView()
    {
        ModuleUtils::set_modules_path(FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/");

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("vendite_full"),"La vista vendite_full esiste gia'!!");

        DB::newDirectSql($this->create_for_view)->exec();
        DB::newDirectSql($this->create_view)->exec();

        $db_desc = DB::newDatabaseDescription();
        $this->assertTrue($db_desc->hasTable("vendite_full"),"La vista vendite_full non e' stata creata!!");

        $plug = new ModulePlug(new Dir("/".FRAMEWORK_CORE_PATH."tests/base/fakeroot/modules/ecommerce/cart/"));

        $def = AvailableModules::get_available_module_definition("ecommerce","cart");

        $drop_view = $def->get_action_data("drop_view");

        $plug->execute($drop_view);

        $db_desc = DB::newDatabaseDescription();
        $this->assertFalse($db_desc->hasTable("vendite_full"),"La vista vendite_full non e' stata rimossa!!");

        DB::newDirectSql($this->drop_for_view)->exec();
    }


}

?>