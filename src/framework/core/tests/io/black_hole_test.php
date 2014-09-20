<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestFileBlackHole extends UnitTestCase
{
    function testBlackHole()
    {
        $f = new File("/".FRAMEWORK_CORE_PATH."tests/io/black_hole_test.php");

        $this->assertTrue($f->exists(),"Il file del test non esiste!!");

        $content = $f->getContent();

        $f->delete();

        $this->assertFalse($f->exists(),"Il file del test black hole non e' stato eliminato!!");

        $f->touch();

        $f->setContent($content);

        $this->assertTrue($f->exists(),"Il file del test black hole non e' stato rigenerato!!");


    }
}

?>