<?php

class TestResult extends UnitTestCase
{
    function setUp()
    {
        PageData::instance()->set("/ciao/mondo","Come va?");
    }
    
    function testSectionPersists()
    {
        $this->assertEqual(PageData::instance()->get("/ciao/mondo"),"Come va?");
    }
    
    function tearDown() 
    {
        PageData::instance()->clear();
        
    }
}
