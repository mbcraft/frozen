<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestMysql extends UnitTestCase
{
    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);
    }

    function tearDown()
    {
        DB::closeConnection();
    }

    function testAvailableEngines()
    {
        $mm = new __MysqlInfo();

        $engines = $mm->getAvailableEngines();

        $this->assertTrue(isset($engines["ARCHIVE"]),"Archive engine is not available!!");
        $this->assertTrue(isset($engines["MyISAM"]),"MyISAM engine is not available!!");
        $this->assertTrue(isset($engines["MEMORY"]),"MEMORY engine is not available!!");
    }

    function testAvailablePrivileges()
    {
        $mm = new __MysqlInfo();

        $privileges = $mm->getAvailablePrivileges();

        $this->assertTrue(isset($privileges["Select"]),"Il privilegio di SELECT non e' concesso!!");
        $this->assertTrue(isset($privileges["Update"]),"Il privilegio di UPDATE non e' concesso!!");
        $this->assertTrue(isset($privileges["Insert"]),"Il privilegio di INSERT non e' concesso!!");
        $this->assertTrue(isset($privileges["Delete"]),"Il privilegio di DELETE non e' concesso!!");
        $this->assertTrue(isset($privileges["Alter"]),"Il privilegio di Alter non e' concesso!!");
        $this->assertTrue(isset($privileges["Create"]),"Il privilegio di Create non e' concesso!!");
        $this->assertTrue(isset($privileges["Drop"]),"Il privilegio di Drop non e' concesso!!");

    }
}

?>