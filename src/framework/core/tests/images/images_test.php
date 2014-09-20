<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestImages extends UnitTestCase
{
    function testGdAreSupported()
    {
        $this->assertTrue(function_exists("imagecreatetruecolor"),"La funzione imagecreatetruecolor non e' supportata. Installare le librerie GD per PHP!!");
    }
}

?>