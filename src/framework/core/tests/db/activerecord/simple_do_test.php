<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/AbstractPeer.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/AbstractDO.class.php");

class TestSimpleDO extends UnitTestCase
{
    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);

        $sql = DB::newDirectSql("CREATE TABLE simple_table(
  id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),
  nome VARCHAR(255),
  livello INT);");
        $sql->exec();

        ActiveRecord::init("Simple");
    }

    function tearDown()
    {
        $sql = DB::newDirectSql("DROP TABLE simple_table;");
        $sql->exec();
        
        DB::closeConnection();

        ActiveRecord::dispose();
    }

    public function testCreateSaveDelete()
    {
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple", "id"));

        $peer = new SimplePeer();

        $do = $peer->new_do();
        $do->id = 1;
        $do->nome = "Paolino Paperino";
        $do->livello = 16;

        $peer = new SimplePeer();
        $objects = $peer->find_all();

        $this->assertEqual(count($objects),0);

        $peer->save($do);
        $objects = $peer->find_all();

        $this->assertEqual(count($objects),1);

        $ob = $objects[0];

        $this->assertEqual($ob->id,1);
        $this->assertEqual($ob->nome,"Paolino Paperino");
        $this->assertEqual($ob->livello,16);

        $peer->delete_by_id(1);

        $objects = $peer->find_all();

        $this->assertEqual(count($objects),0);



    }
}

class SimpleDO extends AbstractDO
{

}

class SimplePeer extends AbstractPeer {
    
    public function __getMyTable()
    {
        return "simple_table";
    }
}

?>