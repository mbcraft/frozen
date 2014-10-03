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

require_once("../../init.php");
require_once("../lib/simpletest/autorun.php");

define("TEST_ROOT",FRAMEWORK_CORE_PATH."tests/");

class AllTests extends TestSuite
{
    function AllTests()
    {
        $is_local = isset(Config::instance()->TEST_DB_HOST);
        
        $this->TestSuite('All tests');

        $test_list = array("images","request","env","base","modules","pages","controller","services","io","session","xml","utils");
        
        
        
        foreach ($test_list as $test_group_name)
            $this->{$test_group_name."Tests"}();

        //db
        //salto i test sul db se sono in remoto
        if ($is_local)
            $this->dbTests();

    }
    
    function contentTests()
    {
        $content_tests = new TestSuite("Content tests");
        
        $content_tests->addFile(TEST_ROOT.'content/text_editor_test.php');
        
        $this->add($content_tests);
    }

    function imagesTests()
    {
        //images
        $images_tests = new TestSuite("Images tests");

        $images_tests->addFile(TEST_ROOT.'images/images_test.php');

        //add to global test suite
        $this->add($images_tests);
    }

    function requestTests()
    {
        $request_tests = new TestSuite("Request tests");

        $request_tests->addFile(TEST_ROOT.'request/params_test.php');


        //add to global test suite
        $this->add($request_tests);
    }

    function envTests()
    {
        //
        //env tests

        $env_tests = new TestSuite("Env tests");

        $env_tests->addFile(TEST_ROOT.'env/environment_test.php');



        //add to global test suite
        $this->add($env_tests);
    }
    
    function baseTests()
    {
        //
        //base tests

        $base_tests = new TestSuite("Base tests");

        $base_tests->addFile(TEST_ROOT.'base/route_definition_test.php');
        $base_tests->addFile(TEST_ROOT.'base/abstract_autoloader_test.php');
        $base_tests->addFile(TEST_ROOT.'base/data_holder_test.php');
        $base_tests->addFile(TEST_ROOT.'base/benchmark_test.php');
        $base_tests->addFile(TEST_ROOT.'base/block_factory_test.php');
        $base_tests->addFile(TEST_ROOT.'base/indirect_data_holder_test.php');
        $base_tests->addFile(TEST_ROOT.'base/param_checker_test.php');
        $base_tests->addFile(TEST_ROOT.'base/result_test.php');

        $base_tests->addFile(TEST_ROOT.'base/redirect_test.php');
        $base_tests->addFile(TEST_ROOT.'base/sector_test.php');
        $base_tests->addFile(TEST_ROOT.'base/simplexml_test.php');
        //add to global test suite
        $this->add($base_tests);
    }

    function modulesTests()
    {
        //
        //modules tests

        $modules_tests = new TestSuite("Modules tests");
        $modules_tests->addFile(TEST_ROOT.'modules/module_spec_test.php');
        $modules_tests->addFile(TEST_ROOT.'modules/module_archiver_test.php');
        //$modules_tests->addFile(TEST_ROOT.'modules/available_modules_test.php');
        //$modules_tests->addFile(TEST_ROOT.'modules/installed_modules_test.php');
        
        
        $modules_tests->addFile(TEST_ROOT.'modules/gallery/gallery_test.php');
        //add to global test suite
        $this->add($modules_tests);
    }

    function pagesTests()
    {
        //
        //pages tests

        $pages_tests = new TestSuite("Pages tests");
        $pages_tests->addFile(TEST_ROOT.'pages/layout_test.php');
        //add to global test suite
        $this->add($pages_tests);
    }

    function controllerTests()
    {
        //
        //controller

        $controller_tests = new TestSuite("Controller tests");
        $controller_tests->addFile(TEST_ROOT.'controller/request_test.php');
        $controller_tests->addFile(TEST_ROOT.'controller/controller_factory_test.php');
        //add to global test suite
        $this->add($controller_tests);
    }

    function htmlTests()
    {
        //
        //html tests

        $html_tests = new TestSuite("Html tests");

        $html_tests->addFile(TEST_ROOT.'html/html_test.php');
        $html_tests->addFile(TEST_ROOT.'html/css_test.php');
        $html_tests->addFile(TEST_ROOT.'html/js_test.php');
        //add to global test suite
        $this->add($html_tests);
    }

    function servicesTests()
    {
        //
        //services tests

        $services_tests = new TestSuite("Services tests");
        $services_tests->addFile(TEST_ROOT.'services/services_test.php');
        //add to global test suite
        $this->add($services_tests);
    }

    function dbTests()
    {
        //
        //db tests

        $db_tests = new TestSuite("Local db tests");

        $db_tests->addFile(TEST_ROOT.'db/core/mysql/mysql_test.php');

        $db_tests->addFile(TEST_ROOT.'db/activerecord/active_record_test.php');
        $db_tests->addFile(TEST_ROOT.'db/activerecord/active_record_test2.php');

        $db_tests->addFile(TEST_ROOT.'db/activerecord/active_record_utils_test.php');
        $db_tests->addFile(TEST_ROOT.'db/activerecord/active_record_utils_test2.php');

        $db_tests->addFile(TEST_ROOT.'db/activerecord/abstract_peer_test.php');

        $db_tests->addFile(TEST_ROOT.'db/activerecord/simple_do_test.php');

        $db_tests->addFile(TEST_ROOT.'db/core/core_db_test.php');
        $db_tests->addFile(TEST_ROOT.'db/core/core_db2_test.php');
        $db_tests->addFile(TEST_ROOT.'db/core/core_db3_test.php');

        $db_tests->addFile(TEST_ROOT.'modules/module_plug_test.php');
        $db_tests->addFile(TEST_ROOT.'utils/backup_test.php');
        //add to global test suite
        $this->add($db_tests);
    }

    function ioTests()
    {
        //
        //io

        $io_tests = new TestSuite("IO tests.");

        $io_tests->addFile(TEST_ROOT.'io/file_props_test.php');
        $io_tests->addFile(TEST_ROOT.'io/file_system_utils_test.php');
        $io_tests->addFile(TEST_ROOT.'io/plain_dir_test.php');
        $io_tests->addFile(TEST_ROOT.'io/plain_file_test.php');
        $io_tests->addFile(TEST_ROOT.'io/black_hole_test.php');

        $io_tests->addFile(TEST_ROOT.'io/file_reader_test.php');
        $io_tests->addFile(TEST_ROOT.'io/file_writer_test.php');

        $io_tests->addFile(TEST_ROOT.'io/file_utils_test.php');
        $io_tests->addFile(TEST_ROOT.'io/properties_utils_test.php');
        $io_tests->addFile(TEST_ROOT.'io/storage_test.php');


        if (class_exists("ZipArchive"))
            $io_tests->addFile(TEST_ROOT.'io/zip_utils_test.php');
        //add to global test suite
        $this->add($io_tests);
    }
    
    
    
    function utilsTests()
    {
        //
        //utils

        $utils_tests = new TestSuite("Utils tests");

        $utils_tests->addFile(TEST_ROOT.'utils/array_utils_test.php');
        $utils_tests->addFile(TEST_ROOT.'utils/tree_test.php');
        $utils_tests->addFile(TEST_ROOT.'utils/string_utils_test.php');

        $utils_tests->addFile(TEST_ROOT.'utils/datetime_test.php');
        $utils_tests->addFile(TEST_ROOT.'utils/system_test.php');
        $utils_tests->addFile(TEST_ROOT.'utils/fgarchive_test.php');
        $utils_tests->addFile(TEST_ROOT.'utils/http_test.php');
        //add to global test suite
        $this->add($utils_tests);
    }
    
    function sessionTests()
    {
        //
        //session

        $session_tests = new TestSuite("Session tests.");

        $session_tests->addFile(TEST_ROOT.'session/session_test.php');
        $session_tests->addFile(TEST_ROOT.'session/flash_test.php');
        //add to global test suite
        $this->add($session_tests);
    }
    
    function xmlTests()
    {
        //
        //xml

        $xml_tests = new TestSuite("Xml tests.");

        $xml_tests->addFile(TEST_ROOT.'xml/xml_builder_test.php');
        $xml_tests->addFile(TEST_ROOT.'xml/simplexml_parser_test.php');
        $xml_tests->addFile(TEST_ROOT.'xml/xpath_test.php');
        //add to global test suite
        $this->add($xml_tests);
    }
    
}


?>