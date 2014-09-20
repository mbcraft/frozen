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

class TestFileUtils extends UnitTestCase
{
    function testRandomFromFolderNoMtime()
    {
        $count = 0;
        
        $css_count = 0;
        $ext_count = 0;
        $test_count = 0;
        
        for($i=0;$i<30;$i++)
        {
            $result = FileUtils::randomFromFolder("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/",false);

            $this->assertNotNull($result);
            
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/css_test.css") $css_count+=1;
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/ext_test.plug.txt") $ext_count += 1;
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/test_file.txt") $test_count += 1;
        
            $sum = $css_count+$ext_count+$test_count;
            $this->assertTrue($count==$sum-1);
            $count +=1;
        }
    }
    
    function testRandomFromFolderWithFoldersNoMtime()
    {
        $count = 0;
        
        $another_count = 0;
        $css_count = 0;
        $ext_count = 0;
        $test_count = 0;
        
        for($i=0;$i<30;$i++)
        {
            $result = FileUtils::randomFromFolder("/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/",false,true);

            $this->assertNotNull($result);
            
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/another_dir/") $another_count+=1;
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/css_test.css") $css_count+=1;
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/ext_test.plug.txt") $ext_count += 1;
            if ($result=="/".FRAMEWORK_CORE_PATH."tests/io/test_dir/content_dir/test_file.txt") $test_count += 1;
        
            $sum = $another_count+$css_count+$ext_count+$test_count;
            $this->assertTrue($count==$sum-1);
            $count +=1;
        }
    }


}
?>