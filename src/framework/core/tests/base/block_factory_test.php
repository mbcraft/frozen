<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


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

