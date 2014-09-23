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


class TestArrayUtils extends UnitTestCase
{
    function testHasValue()
    {
        $data = array(1 => "ciao", 2=> "mondo");
        
        $this->assertTrue(ArrayUtils::has_value($data, "ciao"));
        $this->assertTrue(ArrayUtils::has_value($data, "mondo"));
        $this->assertFalse(ArrayUtils::has_value($data, "pippo"));
        
        $this->assertFalse(ArrayUtils::has_value($data, 0));
        $this->assertFalse(ArrayUtils::has_value($data, 1));
        $this->assertFalse(ArrayUtils::has_value($data, 2));
        $this->assertFalse(ArrayUtils::has_value($data, 3));
    }
    
    function testReorderFromZero()
    {
        $data = array(1 => "ciao", 2=> "mondo",7 => "hello" , 5=>"snaks");
        
        ArrayUtils::reorder_from_zero($data);
        $this->assertTrue(ArrayUtils::contains_key(0,$data));
        $this->assertTrue(ArrayUtils::contains_key(1,$data));
        $this->assertTrue(ArrayUtils::contains_key(2,$data));
        $this->assertTrue(ArrayUtils::contains_key(3,$data));
        $this->assertTrue(count($data),4);
        
        $this->assertEqual($data[0],"ciao");
        $this->assertEqual($data[1],"mondo");
        $this->assertEqual($data[2],"snaks");
        $this->assertEqual($data[3],"hello");
        
    }

    function testDeleteKeys()
    {
        $data = array("ciao" => "mondo","hello" => "world", "abla" => "espanol");
        $keys = array("ciao" => "prova", "abla" => "altro");

        $result = ArrayUtils::delete_keys($data,$keys);

        $this->assertFalse(isset($result["ciao"]),"La chiave non e' stata rimossa con successo!!");
        $this->assertFalse(isset($result["abla"]),"La chiave non e' stata rimossa con successo!!");

        $this->assertTrue(isset($result["hello"]),"La chiave che non doveva esser rimossa e' stata rimossa!!");
        $this->assertEqual($result["hello"],"world","Il valore rimasto non e' corretto!!");

        $this->assertEqual($data["ciao"],"mondo","L'array originale e' stato modificato!!");
        $this->assertEqual($data["hello"],"world","L'array originale e' stato modificato!!");
        $this->assertEqual($data["abla"],"espanol","L'array originale e' stato modificato!!");
    }
}

?>