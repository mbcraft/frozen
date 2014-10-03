<?php

class TestJs extends UnitTestCase
{
    function testJsOrder()
    {
        JS::clean();

        JS::require_jquery();
        JS::require_script("/js/jquery/pippo.js");
        JS::require_script("/js/jquery/another_js.js");

        $required_javascripts = PageData::instance()->get("/page/headers/required_javascripts/list");

        $this->assertTrue(strstr("/framework/core/js/jquery/jquery.min.js",$required_javascripts[0]["script_path"])==0,"Il primo file non corrisponde!!");
        $this->assertTrue(strstr("/js/jquery/pippo.js",$required_javascripts[1]["script_path"])==0,"Il secondo file non corrisponde!!");
        $this->assertTrue(strstr("/js/jquery/another_js.js",$required_javascripts[2]["script_path"])==0,"Il terzo file non corrisponde!!");

    }
}

?>