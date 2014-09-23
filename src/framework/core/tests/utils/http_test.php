<?php

class TestHttp extends UnitTestCase
{
    function testGetToFile()
    {
        $target_file = new File("/".FRAMEWORK_CORE_PATH."tests/utils/http_test/output/result.txt");
        
        $this->assertFalse($target_file->exists(),"Il file da scaricare esiste gia'!!");
        
        $url = "http://".Host::current()."/framework/core/tests/utils/http_test/input/hello.php";
        
        Http::get_to_file($url, $target_file);
        
        $this->assertTrue($target_file->exists(),"Il file da scaricare non e' stato creato!!");
        
        $this->assertEqual("Hello!",$target_file->getContent(),"Il contenuto salvato non corrisponde!!");
        
        $target_file->delete();
    }
    
    function testGet()
    {
        
        $url = "http://".Host::current()."/framework/core/tests/utils/http_test/input/hello.php";
        
        $result = Http::get($url);
        
        $this->assertEqual("Hello!",$result,"Il risultato ritornato non corrisponde!!");
    }
    
}
?>