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

