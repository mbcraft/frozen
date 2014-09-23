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

class TestActiveRecord2 extends UnitTestCase
{

    function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);

        $sql1 = DB::newDirectSql("CREATE TABLE test_tab_dipinti(
          id_dipinto INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id_dipinto),
          nome VARCHAR(255),
          id_autore INT NOT NULL,
          periodo INT NOT NULL,
          properties TEXT NOT NULL);");
        $sql1->exec();

        $sql2 = DB::newDirectSql("CREATE TABLE test_tab_colori_dipinto(
                  id_colore_dipinto INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id_colore_dipinto),
                  id_dipinto INT NOT NULL,
                  id_colore INT NOT NULL);");
        $sql2->exec();

        $sql3 = DB::newDirectSql("CREATE TABLE test_tab_colori(
          id_colore INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id_colore),
          nome INT NOT NULL,
          rgb VARCHAR(6) NOT NULL);");
        $sql3->exec();

        $sql4 = DB::newDirectSql("CREATE TABLE test_tab_autori(
          id_autore INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(id_autore),
          nome VARCHAR(64) NOT NULL,
          cognome VARCHAR(64) NOT NULL,
          stile VARCHAR(32));");
        $sql4->exec();

        ActiveRecord::init("TestDipinto");
        ActiveRecord::init("TestAutore");
        ActiveRecord::init("TestColore");
        ActiveRecord::init("TestColoreDipinto");
    }

    function __loadDipinto($id_dipinto,$nome,$id_autore,$periodo,$properties)
    {
        $ii = new __MysqlInsert("test_tab_dipinti");

        $ii->add("id_dipinto",$id_dipinto);
        $ii->add("nome",$nome);
        $ii->add("id_autore",$id_autore);
        $ii->add("periodo",$periodo);
        $ii->add("properties",$properties);

        $ii->exec();
    }
    function __loadAutore($id_autore,$nome,$cognome,$stile)
    {
        $ii = new __MysqlInsert("test_tab_autori");

        $ii->add("id_autore",$id_autore);
        $ii->add("nome",$nome);
        $ii->add("cognome",$cognome);
        $ii->add("stile",$stile);

        $ii->exec();
    }

    function __loadColore($id_colore,$nome,$rgb)
    {
        $ii = new __MysqlInsert("test_tab_colori");

        $ii->add("id_colore",$id_colore);
        $ii->add("nome",$nome);
        $ii->add("rgb",$rgb);

        $ii->exec();
    }

    function __loadColoreDipinto($id_dipinto,$id_colore)
    {
        $ii = new __MysqlInsert("test_tab_colori_dipinto");

        $ii->add("id_dipinto",$id_dipinto);
        $ii->add("id_colore",$id_colore);

        $ii->exec();
    }

    /*
     * Funzione per caricare dati di test (non veritieri ma buon caso d'uso)
     * */
    function defaultLoad()
    {
        //AUTORI
        $this->__loadAutore(1,"Pablo","Picasso","Impressionista");
        $this->__loadAutore(2,"Vincent","Van gogh","Futurista");
        $this->__loadAutore(3,"Marco","Bagnaresi","Contemporaneo");

        //QUADRI
        $this->__loadDipinto(1,"Guernica",1,1937,"");
        $this->__loadDipinto(2,"Dora Maar e il gatto",1,1889,"");
        $this->__loadDipinto(3,"Nudo su un armadio nero",1,1900,"");

        $this->__loadDipinto(4,"Pellegrino sulla via di Canterbury al tempo di Chaucer",2,1867,"");

        //nessun quadro per me

        //COLORI
        $this->__loadColore(1,"Giallo","ffff00");
        $this->__loadColore(2,"Rosso","ff0000");
        $this->__loadColore(3,"Verde","00ff00");
        $this->__loadColore(4,"Blu","0000ff");
        $this->__loadColore(5,"Bianco","ffffff");
        $this->__loadColore(6,"Nero","000000");

        //COLORI QUADRI
        $this->__loadColoreDipinto(1,6);

        $this->__loadColoreDipinto(2,1);
        $this->__loadColoreDipinto(2,2);
        $this->__loadColoreDipinto(2,4);

        $this->__loadColoreDipinto(4,1);
        $this->__loadColoreDipinto(4,2);
        $this->__loadColoreDipinto(4,3);

    }
    function tearDown()
    {
        $sql1 = DB::newDirectSql("DROP TABLE test_tab_colori_dipinto;");
        $sql1->exec();
        $sql2 = DB::newDirectSql("DROP TABLE test_tab_dipinti;");
        $sql2->exec();
        $sql3 = DB::newDirectSql("DROP TABLE test_tab_colori;");
        $sql3->exec();
        $sql4 = DB::newDirectSql("DROP TABLE test_tab_autori;");
        $sql4->exec();

        DB::closeConnection();

        ActiveRecord::dispose();
    }

    public function testActiveRecordFunctioning()
    {
        //OK FUNZIONA
        $this->assertTrue(ActiveRecord::has_table_for_class("TestDipinto"));

    }
    /*
    public function testCascadingFetchFromDipinto()
    {
        $peer = new TestDipintoPeer();

        $dipinto = $peer->find_by_id(2);

        $this->assertTrue(isset($dipinto->autore),"L'autore non e' stato caricato!");
        $this->assertEqual($dipinto->autore->nome,"Pablo","Il nome dell'autore non e' stato caricato!");
        $this->assertEqual($dipinto->autore->cognome,"Picasso","Il cognome dell'autore non e' stato caricato!");

        $this->assertTrue(isset($dipinto->colori),"I colori non sono stati caricati!!");
        $this->assertEqual(count($dipinto->colori),3,"Il numero di colori caricati non corrisponde!!");
    }

    public function testCascadingFetchFromAutore()
    {
        $peer = new TestAutorePeer();

        $autore = $peer->find_by_id(2);

        $this->assertTrue(isset($autore->dipinti),"I dipinti dell'autore non sono stati caricati!");
        $this->assertEqual(count($autore->dipinti),1,"Il numero di dipinti dell'autore non corrisponde!");

        $this->assertEqual($autore->dipinti[0]->nome,"Pellegrino sulla via di Canterbury al tempo di Chaucer","Il nome del dipinto non corrisponde!");
    }

    public function testCascadingFetchFromAutoreNoEntities()
    {
        $peer = new TestAutorePeer();

        $autore = $peer->find_by_id(3);

        $this->assertTrue(isset($autore->dipinti),"I dipinti non sono stati caricati!");
        $this->assertEqual(count($autore->dipinti),0,"Il numero di dipinti non corrisponde!");

    }

    /*
    public function testChangeIdAutore()
    {
        $autore_peer = new TestAutorePeer();
        $new_autore = new TestAutoreDO();
        $new_autore->nome = "Minnie";
        $new_autore->cognome = "Blablabla";
        $new_autore->stile = "casual";
        $autore_peer->save($new_autore);

        $peer = new TestDipintoPeer();
        $dipinto = $peer->find_by_id(1);
        $dipinto->autore = $new_autore;
        $peer->save($dipinto);
    }

    public function testChangeAutore()
    {
        $autore_peer = new TestAutorePeer();
        $new_autore = new TestAutoreDO();
        $new_autore->nome = "Minnie";
        $new_autore->cognome = "Blablabla";
        $new_autore->stile = "casual";
        $autore_peer->save($new_autore);

        $peer = new TestDipintoPeer();
        $dipinto = $peer->find_by_id(1);
        $dipinto->
    }

    public function testCascadingFetchFromColore()
    {
        $peer = new TestColorePeer();

        $colore = $peer->find_by_id(2);

        $this->assertTrue(isset($colore->dipinti),"I dipinti non sono stati caricati!");
        $this->assertEqual(count($colore->dipinti),2,"Il numero di dipinti non corrisponde!");

        $this->assertEqual($colore->dipinti[0]->nome,"Dora Maar e il gatto","Il nome del dipinto non corrisponde!");
        $this->assertEqual($colore->dipinti[1]->nome,"Pellegrino sulla via di Canterbury al tempo di Chaucer","Il nome del dipinto non corrisponde!");
    }
    */
}

class TestDipintoDO extends AbstractDO
{

}

class TestAutoreDO extends AbstractDO
{

}

class TestColoreDO extends AbstractDO
{

}

class TestColoreDipintoDO extends AbstractDO
{

}

class TestDipintoPeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "test_tab_dipinti";
    }
    
    protected function setup()
    {
        $this->fetchAsProperties("properties");
        //$this->fetchAsEntity("autore","id_autore","TestAutorePeer");
    }
}

class TestAutorePeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "test_tab_autori";
    }
}

class TestColorePeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "test_tab_colori";
    }
}

class TestColoreDipintoPeer extends AbstractPeer
{
    public function __getMyTable()
    {
        return "test_tab_colori_dipinto";
    }
}

?>