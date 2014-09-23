<?php

class TestLayout extends UnitTestCase {

    function testGetSectorCount() {
        $f = new File("/framework/core/tests/pages/layout/my_test.layout.php");

        $l = new Layout();
        $l->__setup($f->getPath(), "my_test.layout.php", new Tree());

        $this->assertEqual($l->getSectorCount(), 3, "Il numero dei settori non coincide!!");
    }

    function testSectorPatternMatch() {
        $pattern = "/##((\/\w+)+)##/";

        $text = "This is a ##/sample/text## example text.";

        $matches = array();

        preg_match_all($pattern, $text, $matches, PREG_OFFSET_CAPTURE);

        $this->assertEqual($matches[1][0][0], "/sample/text", "Il match del pattern non corrisponde!!");
    }

    function testGetSectorNames() {
        $f = new File("/framework/core/tests/pages/layout/my_test.layout.php");

        $l = new Layout();
        $l->__setup($f->getPath(), "my_test.layout.php", new Tree());

        $this->assertEqual(count($l->getSectorNames()), 3, "Il numero dei settori non coincide!!");

        $sector_names = $l->getSectorNames();

        $this->assertEqual($sector_names[0], "/page/headers", "Il nome del settore non coincide!! : " . $sector_names[0]);
        $this->assertEqual($sector_names[1], "/content", "Il nome del settore non coincide!! : " . $sector_names[1]);
        $this->assertEqual($sector_names[2], "/footer", "Il nome del settore non coincide!! : " . $sector_names[2]);
    }

}

?>