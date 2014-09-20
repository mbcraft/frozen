<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class FakePeer
{
    public $page_size=0,$page_num=0;
    
    function __PAGE($page_size,$page_num)
    {
        $this->page_size = $page_size;
        $this->page_num = $page_num;
    }
}

class TestActiveRecordUtils extends UnitTestCase
{
    /*
    function testUpdatePageFilter()
    {
        $fake_peer = new FakePeer();
        
        ActiveRecordUtils::updatePageFilters($fake_peer);
        
        $this->assertEqual($fake_peer->page_size,40,"La dimensione della pagina non e' stata impostata correttamente!!");
        $this->assertEqual($fake_peer->page_num,3,"Il numero della pagina non e' stato impostato correttamente");
        
    }
    */  
    
    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);

        $sql = DB::newDirectSql("CREATE TABLE simple3_table(
          id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id),
          nome VARCHAR(255),
          livello INT,
          properties TEXT);");
        $sql->exec();

        ActiveRecord::init("Simple3");
    }

    function tearDown()
    {
        $sql = DB::newDirectSql("DROP TABLE simple3_table;");
        $sql->exec();

        DB::closeConnection();

        ActiveRecord::dispose();
    }

    public function testFromDoToArrayWithProperties()
    {
        $do = new Simple3DO();

        $do->id = 1;
        $do->nome = "Ciao";
        $do->livello = 18;
        $do->properties = array("hello" => "world",1 => 12);

        $arr_result = ActiveRecordUtils::toArray($do);

        $this->assertEqual($arr_result["id"],1,"Il risultato della conversione non corrisponde!! : ".$arr_result["id"]);
        $this->assertEqual($arr_result["nome"],"Ciao","Il risultato della conversione non corrisponde!! : ".$arr_result["nome"]);
        $this->assertEqual($arr_result["livello"],18,"Il risultato della conversione non corrisponde!! : ".$arr_result["livello"]);
        $this->assertEqual($arr_result["properties"]["hello"],"world","Il risultato della conversione non corrisponde!!");
        $this->assertEqual($arr_result["properties"][1],12,"Il risultato della conversione non corrisponde!!");

        $new_do = ActiveRecordUtils::toDO($arr_result);

        $this->assertEqual($new_do->id,1,"Il risultato della conversione non corrisponde!! : ".$arr_result["id"]);
        $this->assertEqual($new_do->nome,"Ciao","Il risultato della conversione non corrisponde!! : ".$arr_result["nome"]);
        $this->assertEqual($new_do->livello,18,"Il risultato della conversione non corrisponde!! : ".$arr_result["livello"]);
        $this->assertEqual($new_do->properties["hello"],"world","Il risultato della conversione non corrisponde!!");
        $this->assertEqual($new_do->properties[1],12,"Il risultato della conversione non corrisponde!!");

    }
   
    public function testFromArrayDOToDO()
    {
        $array_version = array("id" => 3,"nome" => "Prova","livello" => 4,"___class" => "Simple3");
        
        $do = ActiveRecordUtils::fromArrayDOToDO($array_version);
        
        $this->assertTrue($do instanceof Simple3DO,"La classe creata non corrisponde!!");
        $this->assertEqual($do->id,3,"L'id salvato non corrisponde!!");
        $this->assertEqual($do->nome,"Prova","Il nome salvato non corrisponde!!");
        $this->assertEqual($do->livello,4,"Il livello salvato non corrisponde!!");
    }
    
    public function testToArrayDOFromDO()
    {
        $peer = new Simple3Peer();
        $do = $peer->new_do();

        $do->nome = "Prova";
        $do->livello = 7;

        $peer->save($do);

        $saved_id = $do->id;
        
        $array_version = ActiveRecordUtils::toArrayDOFromDO($do);
        
        $this->assertEqual(count($array_version),4,"Il numero dei campi nell'array risultante non e' corretto!!");
    
        $this->assertEqual($array_version[AbstractDO::CLASS_FIELD_KEY],"Simple3","Il nome della classe nell'array non corrisponde!!");
        $this->assertEqual($array_version["nome"],"Prova","Il nome nell'array non corrisponde!!");
        $this->assertEqual($array_version["livello"],7,"Il livello nell'array non corrisponde!!");
        
        
        $peer->delete_by_id($saved_id);
    }
    
    public function testToArray()
    {
        $test_data = array();
        
        $do1 = new Simple3DO();
        $do1->id = 7;
        $do1->nome = "Test";
        $do1->livello = 15;
        
        $test_data[] = $do1;
        
        $do2 = new Simple3DO();
        $do2->id = 5;
        $do2->nome = "Ancora";
        $do2->livello = 3;
        
        $test_data[] = $do2;
        
        $array_data = ActiveRecordUtils::toArray($test_data);
        
        $this->assertEqual(count($array_data),count($test_data),"Il numero dei dati non coincide!!");
        
        $array_do1 = $array_data[0];
        
        $this->assertEqual($array_do1[AbstractDO::CLASS_FIELD_KEY],"Simple3","La classe dell'entita' non corrisponde!!");
        $this->assertEqual($array_do1["id"],7,"L'id dell'entita' non corrisponde!!");
        $this->assertEqual($array_do1["nome"],"Test","Il nome dell'entita' non corrisponde!!");
        $this->assertEqual($array_do1["livello"],15,"Il livello dell'entita' non corrisponde!!");
        
        $array_do2 = $array_data[1];
        
        $this->assertEqual($array_do2[AbstractDO::CLASS_FIELD_KEY],"Simple3","La classe dell'entita' non corrisponde!!");
        $this->assertEqual($array_do2["id"],5,"L'id dell'entita' non corrisponde!!");
        $this->assertEqual($array_do2["nome"],"Ancora","Il nome dell'entita' non corrisponde!!");
        $this->assertEqual($array_do2["livello"],3,"Il livello dell'entita' non corrisponde!!");
        
    }
    
    public function testToDO()
    {
        $test_data = array();
        
        $ar1 = array();
        $ar1[AbstractDO::CLASS_FIELD_KEY] = "Simple3";
        $ar1["id"] = 3;
        $ar1["nome"] = "Ciao";
        $ar1["livello"] = 14;
        
        $test_data[] = $ar1;
        
        $ar2 = array();
        $ar2[AbstractDO::CLASS_FIELD_KEY] = "Simple3";
        $ar2["id"] = 4;
        $ar2["nome"] = "Hello";
        $ar2["livello"] = 12;
        
        $test_data[] = $ar2;
        
        $do_array = ActiveRecordUtils::toDO($test_data);
        
        $this->assertEqual(count($do_array),count($test_data),"Il numero dei dati non coincide!!");
        
        $do1 = $do_array[0];
        $this->assertTrue($do1 instanceof Simple3DO,"La classe del DO non corrisponde!!");
        $this->assertEqual($do1->id,3,"L'id dell'entita' non corrisponde!!");
        $this->assertEqual($do1->nome,"Ciao","Il nome dell'entita' non corrisponde!!");
        $this->assertEqual($do1->livello,14,"Il livello dell'entita' non corrisponde!!");
        
        $do2 = $do_array[1];
        $this->assertTrue($do2 instanceof Simple3DO,"La classe del DO non corrisponde!!");
        $this->assertEqual($do2->id,4,"L'id dell'entita' non corrisponde!!");
        $this->assertEqual($do2->nome,"Hello","Il nome dell'entita' non corrisponde!!");
        $this->assertEqual($do2->livello,12,"Il livello dell'entita' non corrisponde!!");
        
    }
}

class Simple3DO extends AbstractDO
{

}

class Simple3Peer extends AbstractPeer {
    
    public function __getMyTable()
    {
        return "simple3_table";
    }
}

?>