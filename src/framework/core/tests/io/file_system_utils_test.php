<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

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