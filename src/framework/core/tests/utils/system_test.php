<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */

class TestSystem extends UnitTestCase
{
    function testSystemCall()
    {
        $command = "touch ".SITE_ROOT_PATH."/tmp/prova.txt";

        system($command);

        $f = new File("/tmp/prova.txt");

        $this->assertTrue($f->exists(),"Il file non e' stato creato!!");

        if ($f->exists())
            $f->delete();
    }
}

