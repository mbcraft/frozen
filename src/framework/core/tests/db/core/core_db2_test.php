<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestCoreDb2 extends UnitTestCase
{
    static $create_table_sql = "CREATE TABLE another_tab_bites_the_dust(
  id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),
  nome VARCHAR(255),
  livello INT);";

    static $drop_table_sql = "DROP TABLE another_tab_bites_the_dust;";

    public function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);
        $this->__dropTable();
        $this->__createTable();
        $this->__loadData(1,"Marco",2);
        $this->__loadData(2,"Federico",5);

    }

    public function tearDown()
    {
        $this->__dropTable();
        DB::closeConnection();
    }

    private function __createTable()
    {
        $direct_sql = DB::newDirectSql(self::$create_table_sql);
        $direct_sql->exec();
        $direct_sql = DB::newDirectSql("FLUSH TABLES;");
        $direct_sql->exec();
    }

    private function __loadData($id,$nome,$livello,$properties = null)
    {
        $ii = new __MysqlInsert("another_tab_bites_the_dust");
        $ii->add("id",$id);
        $ii->add("nome",$nome);
        $ii->add("livello",$livello);
        if ($properties!=null)
            $ii->add("properties",$properties);
        $ii->exec();
    }

    private function __dropTable()
    {
        $direct_sql = DB::newDirectSql(self::$drop_table_sql);
        $direct_sql->exec();
        $direct_sql = DB::newDirectSql("FLUSH TABLES;");
        $direct_sql->exec();
    }


    function testAlterTable()
    {

        $alter = DB::newAlterTable("another_tab_bites_the_dust");

        $factory = $alter->getFieldFactory();
        $alter->change_column("livello",$factory->create_unsigned_int_32("livello_ext",false));
        $alter->drop_column("nome");
        $alter->add_column($factory->create_text_64("ruolo",true));
        $alter->add_column($factory->create_index("ruolo"));

        $table_description = DB::newTableFieldsDescription("another_tab_bites_the_dust");

        $fields = $table_description->getAllFields();
        $this->assertEqual(count($fields),3);
        $this->assertTrue(array_key_exists("id",$fields));
        $this->assertTrue(array_key_exists("livello_ext",$fields));
        $this->assertFalse(array_key_exists("nome",$fields));
        $this->assertTrue(array_key_exists("ruolo",$fields));


    }



}

?>