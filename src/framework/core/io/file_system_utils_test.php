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

class TestFileSystemUtils extends UnitTestCase
{

    function testCurrentAndParentDirectory()
    {
        $this->assertTrue(FileSystemUtils::isCurrentDirName("."));
        $this->assertTrue(FileSystemUtils::isParentDirName(".."));
    }

    function testIsDir()
    {
        $this->assertTrue(FileSystemUtils::isDir("/".FRAMEWORK_CORE_PATH."tests/io/"));
        
    }

    function testIsFile()
    {
        $this->assertTrue(FileSystemUtils::isFile("/".FRAMEWORK_CORE_PATH."tests/io/file_system_utils_test.php"));
        $this->assertTrue(FileSystemUtils::isFile("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/.hidden_file"));
    }

}


?>