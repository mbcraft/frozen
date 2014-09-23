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

require_once(FRAMEWORK_CORE_PATH."lib/utils/IndirectDataHolder.class.php");

class TestIndirectDataHolder extends UnitTestCase
{
    function testIndirectDH()
    {
        $dh = new DataHolder();
        $idh1 = new IndirectDataHolder();
        $idh1->__set_data_holder($dh);
        $idh2 = new IndirectDataHolder();
        $idh2->__set_data_holder($idh1);

        $dh->prova = "hello";

        $this->assertTrue(isset($dh->prova));
        $this->assertTrue(isset($idh1->prova));
        $this->assertTrue(isset($idh2->prova));

        $this->assertEqual($dh->prova,"hello","Il valore non corrisponde");
        $this->assertEqual($idh1->prova,"hello","Il valore non corrisponde");
        $this->assertEqual($idh2->prova,"hello","Il valore non corrisponde");

        $idh2->prova = "world";

        $this->assertEqual($dh->prova,"world","Il valore non corrisponde");
        $this->assertEqual($idh1->prova,"world","Il valore non corrisponde");
        $this->assertEqual($idh2->prova,"world","Il valore non corrisponde");

        $idh2->prova = "great";

        $this->assertEqual($dh->prova,"great","Il valore non corrisponde");
        $this->assertEqual($idh1->prova,"great","Il valore non corrisponde");
        $this->assertEqual($idh2->prova,"great","Il valore non corrisponde");

        unset($idh2->prova);

        $this->assertFalse(isset($dh->prova));
        $this->assertFalse(isset($idh1->prova));
        $this->assertFalse(isset($idh2->prova));


    }

    function testDhNotSet()
    {
        $idh1 = new IndirectDataHolder();

        try
        {
            $idh1->prova;
            $this->fail();
        }
        catch (Exception $ex) {}

        try
        {
            $idh1->prova = 10;
            $this->fail();
        }
        catch (Exception $ex) {}

        try
        {
            isset($idh1->prova);
            $this->fail();
        }
        catch (Exception $ex) {}

        try
        {
            unset($idh1->prova);
            $this->fail();
        }
        catch (Exception $ex) {}
        
    }
}

