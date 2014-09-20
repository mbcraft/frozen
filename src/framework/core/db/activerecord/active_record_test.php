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

class TestActiveRecord extends UnitTestCase
{
    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);

        $sql = DB::newDirectSql("CREATE TABLE simple2_table(
          id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),
          nome VARCHAR(255),
          livello INT,
          properties TEXT NULL,
          data_inserimento DATE,
          working tinyint(1));");
        $sql->exec();

        ActiveRecord::init("Simple2");
    }

    function __loadData($id,$nome,$livello,$properties,$date,$working)
    {
        $ii = new __MysqlInsert("simple2_table");
        
        $ii->add("id",$id);
        $ii->add("nome",$nome);
        $ii->add("livello",$livello);
        $ii->add("properties",$properties);
        $ii->add("data_inserimento",$date);
        $ii->add("working",$working);

        $ii->exec();
    }

    function tearDown()
    {
        $sql = DB::newDirectSql("DROP TABLE simple2_table;");
        $sql->exec();

        DB::closeConnection();

        ActiveRecord::dispose();
    }

    public function testActiveRecordFunctioning()
    {
        //OK FUNZIONA
        $this->assertTrue(ActiveRecord::has_table_for_class("Simple2"));
        $this->assertTrue(ActiveRecord::get_table_for_class("Simple2"),"simple2_table");
        //NON FUNZIONA
        $this->assertEqual(count(ActiveRecord::getPrimaryKeyFields("Simple2")),1);

        $pk_fields = ActiveRecord::getPrimaryKeyFields("Simple2");
        $this->assertEqual($pk_fields[0],"id");

        //NON FUNZIONA
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple2", "id"));
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple2", "nome"));
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple2", "livello"));
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple2", "properties"));
        $this->assertTrue(ActiveRecord::has_field_for_class("Simple2", "working"));
    }

    /*
    public function testFindByDate()
    {
        $this->__loadData(1,"Livello di prova",7,"chiave1=valore1\nprova=Questa è una prova\n","2011-03-02");

        $peer = new Simple2Peer();
        $peer->data_inserimento__EQUAL("02-03-2011");
        $results = $peer->find();

        $this->assertEqual(count($results),1,"La query non ha trovato tramite data rovesciata!!");
    }
    */

    public function testDateReadWrite()
    {
        $this->__loadData(1,"Livello di prova",7,"chiave1=valore1\nprova=Questa è una prova\n","2011-03-02",true);

        $peer = new Simple2Peer();
        $do = $peer->find_by_id(1);

        $this->assertEqual($do->data_inserimento,"02-03-2011","La data non viene ribaltata!! : ".$do->data_inserimento);

        //ok fin qui tutto ok

        $do->data_inserimento = "12-12-1890";
        $peer->save($do);

        $new_do = $peer->find_by_id(1);
        $this->assertEqual($do->data_inserimento,"12-12-1890","La data non salvata ribaltata!! : ".$new_do->data_inserimento);


     }

    public function testPropertiesFetch()
    {
        $this->__loadData(1,"Livello di prova",7,"chiave1=valore1\nprova=Questa è una prova\n","2011-03-02",false);

        $peer = new Simple2Peer();
        $do = $peer->find_by_id(1);

        $this->assertTrue(isset($do->properties),"Il campo properties non e' presente nell'array!!");
        $this->assertFalse(is_string($do->properties),"Il campo properties e' di tipo string, properties non lette correttamente!!");
        $this->assertTrue(is_array($do->properties),"Il campo non e' di tipo array, properties non lette correttamente!!");
        $this->assertEqual(count($do->properties),2,"Il numero delle property non corrisponde!!");
        $this->assertEqual($do->properties["chiave1"],"valore1","Il valore della property non corrisponde!!");

        //ok fin qui tutto ok

        $do->properties["nuova"] = "Questa è una nuova prop!!";
        $do->livello = 8;

        $this->assertEqual($do->properties["nuova"],"Questa è una nuova prop!!","Il valore della property non corrisponde!! : ".$do->properties["nuova"]);

        $peer->save($do);
        
        $new_do = $peer->find_by_id(1);

        $this->assertEqual(count($new_do->properties),3,"Il numero delle property non corrisponde!! : ".count($new_do->properties));
            
        $this->assertEqual($new_do->properties["nuova"],"Questa è una nuova prop!!","Il valore della property non corrisponde!! : ".$new_do->properties["nuova"]);
    }

    public function testSaveAndDelete()
    {
        $peer = new Simple2Peer();
        $do = $peer->new_do();

        $do->nome = "Prova";
        $do->livello = 3;
        $do->data_inserimento = "1982-06-03";
        $do->working = true;

        $peer->save($do);

        $saved_id = $do->id;

        $found_do = $peer->find_by_id($saved_id);

        $this->assertEqual("Prova",$found_do->nome,"Il nome dell'entita' non e' corretto!!");
        $this->assertEqual(3,$found_do->livello,"Livello non letto correttamente!!");
        $this->assertEqual("03-06-1982",$found_do->data_inserimento,"La data in lettura non viene rovesciata!! : ".$found_do->data_inserimento);
        $this->assertEqual(true,$found_do->working,"L'attributo working non viene letto correttamente!! : ".$found_do->working);

        $peer->delete_by_id($saved_id);

        $found_do = $peer->find_by_id($saved_id);

        $this->assertNull($found_do);
    }

    function testIsLinked()
    {
        $peer = new Simple2Peer();

        $this->assertTrue($peer->__isLinked(),"Il peer non trova la tabella!!");
    }
}

class Simple2DO extends AbstractDO
{
}

class Simple2Peer extends AbstractPeer
{
    function __getMyTable()
    {
        return "simple2_table";
    }
    
    protected function setup()
    {
        $this->fetchAsProperties("properties");
    }
}

?>