<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestHtml extends UnitTestCase
{
    function testEscapeSpecialChars()
    {
        $my_string = "à & >";
        
        $escaped = Html::escape_special_characters($my_string);
        
        $this->assertEqual($escaped,"&agrave; &amp; &gt;");
    }

}


?>