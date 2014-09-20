<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestSection extends UnitTestCase
{
    function testSectionOpenCloseAndCurrent()
    {
        Section::reset();

        Section::open(); //_1

        $this->assertEqual("_1",Section::current());

        Section::open(); //_1_1

        $this->assertEqual("_1_1",Section::current());

        Section::close(); //_1

        Section::open();  //_1_2

        $this->assertEqual("_1_2",Section::current());

        Section::open();

        $this->assertEqual("_1_2_1",Section::current());

        Section::close(); //_1_2

        Section::open(); //_1_2_2

        $this->assertEqual("_1_2_2",Section::current());

        Section::close(); //_1_2

        Section::open(); //_1_2_3

        $this->assertEqual("_1_2_3",Section::current());

        Section::close(); //_1_2

        Section::open(); //_1_2_4

        $this->assertEqual("_1_2_4",Section::current());

        Section::close(); //_1_2

        Section::open(); //_1_2_5

        $this->assertEqual("_1_2_5",Section::current());

        Section::close(); //_1_2

        Section::close(); //_1

        Section::close();

        Section::open();

        $this->assertEqual("_2", Section::current());

        Section::close();
    }
}

