<?php

class TestEnvironment extends UnitTestCase
{
    function testEnvironmentFunctions()
    {
        $this->assertTrue(function_exists("mysql_connect"),"La libreria mysql non risulta essere installata!!");
        
        $this->assertTrue(function_exists("curl_init"),"La libreria curl non risulta essere installata!!");
    
        $this->assertTrue(function_exists("simplexml_load_string"),"La libreria simplexml non risulta essere installata!!");
        
        $this->assertTrue(function_exists("gzcompress"),"La libreria zlib non risulta essere installata!!");
    }
}

?>
