<?php

class TestModuleSpec extends UnitTestCase
{
    function testIsCompatibleWith()
    {
        $sp1 = new Specification("simple_spec/test","1.3");
        $sp2 = new Specification("simple_spec/world","");
        $sp3 = new Specification("simple_spec/test","2");

        $this->assertFalse($sp2->is_compatible_with($sp1),"La specifica simple_spec/world e' compatibile con simple_spec/test-1.0!!");
        $this->assertFalse($sp2->is_compatible_with($sp3),"La specifica sp3 e' compatibile con sp2!!");
        $this->assertTrue($sp2->is_compatible_with($sp2),"La specifica simple_spec/world non e' compatibile con se stessa!!");
        $this->assertTrue($sp1->is_compatible_with($sp1),"La specifica simple_spec/test-1.3 non e' compatibile con se stessa!!");
        $this->assertTrue($sp3->is_compatible_with($sp1),"La specifica simple_spec/test-2 non e' compatibile con simple_spec/test-1.3 stessa!!");



    }

    function testWithNoVersion()
    {
        $sp = new Specification("simple_spec",array());
        $this->assertEqual($sp->get_name(),"simple_spec","Il nome della specifica non corrisponde!!");
    }

    function testIsSameSpec()
    {
        $sp1 = new Specification("simple_spec/test","1.0");
        $sp2 = new Specification("simple_spec/world","");
        $sp3 = new Specification("simple_spec/test","2");

        $this->assertTrue($sp1->is_same_spec($sp3),"Le specifiche non corrispondono!!");
        $this->assertTrue($sp2->is_same_spec($sp2),"Le specifiche non corrispondono!!");
        $this->assertTrue($sp1->is_same_spec($sp1),"Le specifiche non corrispondono!!");
        $this->assertFalse($sp1->is_same_spec($sp2),"Le specifiche corrispondono!!");
    }

    function testWithNoName()
    {
        $this->expectException("InvalidParameterException");
        $sp = new Specification("","1.0.0");

    }
}

?>