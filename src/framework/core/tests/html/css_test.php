<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


require_once(FRAMEWORK_CORE_PATH."lib/html/CSS.class.php");

class TestCss extends UnitTestCase
{
    function testCssAddIntoResult()
    {
        CSS::clean();
        
        CSS::require_css_file("/".FRAMEWORK_CORE_PATH."tests/html/example_css/my_css_file.css");
        
        $this->assertEqual(1,CSS::get_loaded_css(),"Il numero di css caricati non corrisponde!!");
        
        $this->assertTrue(PageData::instance()->is_set("/page/headers/required_css_files"));
        $this->assertEqual(1,count(PageData::instance()->get("/page/headers/required_css_files/css_file_list")),"Il numero di css caricati non corrisponde!!");
    }
    
}

?>