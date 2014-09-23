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

class TestBlockFactory extends UnitTestCase
{
    function testFindBlocks()
    {
        BlockFactory::clear();
        
        $this->assertFalse(BlockFactory::can_create("documenti/visualizza"),"Può creare il blocco documenti/visualizza");
        $this->assertFalse(BlockFactory::can_create("documenti/altro"),"Può creare il blocco documenti/visualizza");
        
        
        BlockFactory::add_directory("/".FRAMEWORK_CORE_PATH."tests/base/blocks/");
        
        $this->assertTrue(BlockFactory::can_create("documenti/visualizza"),"Non puo' creare il blocco documenti/visualizza");
        $this->assertFalse(BlockFactory::can_create("documenti/altro"),"Può creare il blocco documenti/altro");
        
        
    }
}

