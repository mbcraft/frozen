<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestCoreDb extends UnitTestCase
{
    static $create_table_sql = "CREATE TABLE impiegati(
  id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),
  nome VARCHAR(255),
  livello INT,
  data_inserimento DATE);";

    static $drop_table_sql = "DROP TABLE impiegati;";

    public function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, Config::instance()->TEST_DB_HOST, Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);
    }

    public function tearDown()
    {
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
        $ii = new __MysqlInsert("impiegati");
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

    public function testDatabaseDescription()
    {
        $database_description = DB::newDatabaseDescription();
        $has_table = $database_description->hasTable("impiegati");
        $this->assertFalse($has_table,"La tabella impiegati esiste gia'!!");
        if (!$has_table)
        {
            $this->__createTable();

            $this->assertFalse($database_description->hasTable("impiegati"),"La tabella viene vista nonostate l'oggetto DatabaseDescription non sia stato ricreato!!");
            $database_description = DB::newDatabaseDescription();
            $this->assertTrue($database_description->hasTable("impiegati"),"La tabella impiegati non e' stata creata!!");
        }
        $this->__dropTable();

        $database_description = DB::newDatabaseDescription();
        $this->assertFalse($database_description->hasTable("impiegati"),"La tabella impiegati non e' stata eliminata!!");
    }

    public function testImportData()
    {
        $this->__dropTable();
        $this->__createTable();

        $import_path = "/framework/core/tests/db/import_export/import_test.xml";

        $f = new File($import_path);
        $all_import_content=<<<END_OF_DATA
<?xml version="1.0" encoding="utf-8"?>
<table name="impiegati">
    <row>
        <field name="id">1</field>
        <field name="nome">Nome della prova</field>
        <field name="livello">15</field>
        <field name="data_inserimento">2011/04/06</field>
    </row>
    <row>
        <field name="id">2</field>
        <field name="nome">Import ME!!</field>
        <field name="livello">3</field>
        <field name="data_inserimento">2011-04-03</field>
    </row>
</table>
END_OF_DATA;

        $f->setContent($all_import_content);

        $importer = new __MysqlTableDataImportExport("impiegati");

        $importer->import_data_from_file($import_path);
        $f->delete();

        $ss = new __MysqlSelect("impiegati");
        $ss->addConditionEquals("nome","Import ME!!");
        $results = $ss->exec_fetch_assoc_all();

        $this->assertEqual(count($results),1,"Il numero di risultati trovati non corrisponde!!");

        if (count($results)==1)
        {
            $result = $results[0];
            $this->assertEqual($result["id"],2,"L'id del dato importato non corrisponde!!");
            $this->assertEqual($result["livello"],3,"Il livello del dato importato non corrisponde!!");
            $this->assertEqual($result["data_inserimento"],"2011-04-03","La data non corrisponde!! : ".$result["data_inserimento"]);
        }

        $this->__dropTable();
    }

    public function testExportData()
    {
        $this->__dropTable();
        $this->__createTable();

        $this->__loadData(1,"Nome di <b>prova</b>",13);
        $this->__loadData(3,"Data to be exported",5);


        $exporter = new __MysqlTableDataImportExport("impiegati");

        $export_path = "/framework/core/tests/db/import_export/export_test.xml";

        $exporter->export_data_to_file("impiegati",$export_path);

        $export_file = new File($export_path);

        $xml_reader = new SimpleXMLElement($export_file->getContent());

        $data_with_html = $xml_reader->row[0]->field[1];

        $this->assertEqual("Nome di <b>prova</b>",$data_with_html,"I dati salvati in html non sono esportati correttamente!! : ".$data_with_html);


        $this->__dropTable();
    }

    public function testTableStatus()
    {
        $this->__dropTable();
        $this->__createTable();

        $this->__loadData(1,"Nome di prova",13);
        $this->__loadData(6,"Data to be exported",5);

        $table_description = new __MysqlTableStatus("impiegati");

        $this->assertTrue($table_description->getEngine()=="MyISAM" || $table_description->getEngine()=="InnoDB","L'engine non corrisponde!! : ".$table_description->getEngine());
        $this->assertEqual($table_description->getName(),"impiegati","Il nome della tabella non corrisponde!!");
        $this->assertEqual($table_description->getRows(),2,"Il numero di righe non corrisponde!!");
        $this->assertEqual($table_description->getAutoIncrement(),7,"Il numero di righe non corrisponde!!");

        $this->__dropTable();
    }

    public function testCreateDropTable()
    {
        $db_description = DB::newDatabaseDescription();

        $this->assertEqual(count($db_description->getAllTables()),0);

        $direct_sql = DB::newDirectSql(self::$create_table_sql);
        $direct_sql->exec();

        $db_description = DB::newDatabaseDescription();

        $tables = $db_description->getAllTables();
        $this->assertEqual(count($tables),1);


        $this->assertTrue($tables[0],"impiegati");

        $direct_sql = DB::newDirectSql(self::$drop_table_sql);
        $direct_sql->exec();
        $direct_sql = DB::newDirectSql("FLUSH TABLES;");
        $direct_sql->exec();

        $db_description = DB::newDatabaseDescription();

        $tables = $db_description->getAllTables();
        $this->assertEqual(count($tables),0);
    }

    public function testTableFieldsDescription()
    {

        $direct_sql = DB::newDirectSql(self::$create_table_sql);
        $direct_sql->exec();

        $table_description = DB::newTableFieldsDescription("impiegati");

        $fields = $table_description->getAllFields();
        $this->assertEqual(count($fields),4);
        $this->assertTrue(array_key_exists("id",$fields),"Il campo id non e' stato trovato nella tabella!!");
        $this->assertEqual($fields["id"]["type"],"int(11)","Il tipo del campo non corrisponde!! : ".$fields["id"]["type"]);

        $this->assertTrue(array_key_exists("livello",$fields),"Il campo livello non e' stato trovato nella tabella!!");

        $this->assertTrue(array_key_exists("nome",$fields),"Il campo nome non e' stato trovato nella tabella!!");
        $this->assertEqual($fields["nome"]["type"],"varchar(255)","Il tipo del campo non corrisponde!!");

        $this->assertFalse(array_key_exists("ruolo",$fields),"Il campo ruolo e' stato trovato nella tabella!!");

        $pk_fields = $table_description->getPrimaryKeyFields();
        $this->assertEqual(count($pk_fields),1);

        $this->assertEqual($pk_fields[0],"id");

        $direct_sql = DB::newDirectSql(self::$drop_table_sql);
        $direct_sql->exec();

    }
}

?>