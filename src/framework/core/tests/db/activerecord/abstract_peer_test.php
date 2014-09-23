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

require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/ActiveRecordException.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/ActiveRecord.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/AbstractPeer.class.php");
require_once(FRAMEWORK_CORE_PATH."lib/db/activerecord/AbstractDO.class.php");


class SimpleBisPeer extends AbstractPeer
{
    function __getMyTable()
    {
        return "simple_bis";
    }
}

class SimpleBisDO extends AbstractDO
{

}

class TestAbstractPeer extends UnitTestCase
{
    public function setUp()
    {
        DB::openConnection(Config::instance()->TEST_DB_NAME, "localhost", Config::instance()->TEST_DB_USERNAME, Config::instance()->TEST_DB_PASSWORD, false);
        ActiveRecord::init("SimpleBis");
    }

    public function tearDown()
    {
        ActiveRecord::dispose();
        DB::closeConnection();
    }

    public function testSimpleSplit()
    {
        $method = "find_all_by_username_mail_AND_md5_password";
        $method = str_replace("find_all_by_", "", $method);
        $fields = explode("_AND_", $method);

        $this->assertEqual(count($fields),2);
    }

    public function testIsLinked()
    {
        $peer = new SimpleBisPeer();

        $this->assertFalse($peer->__isLinked(),"Il DO è linked senza la tabella!!");
    }
}


?>