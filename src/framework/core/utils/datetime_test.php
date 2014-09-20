<?php

class TestDateTimeUtils extends UnitTestCase
{
    function testReverse_date_dd_mm_yyyy()
    {
        $test_date = "16-10-2011";

        $reversed_date = DateTimeUtils::reverse_date_dd_mm_yyyy($test_date);

        $this->assertEqual("2011-10-16",$reversed_date,"La data non e' stata ribaltata correttamente!!");

        $this->expectException("InvalidParameterException");
        DateTimeUtils::reverse_date_dd_mm_yyyy("2012-10-02");
    }

    function testReverse_date_yyyy_mm_dd()
    {
        $test_date = "2011-09-05";

        $reversed_date = DateTimeUtils::reverse_date_yyyy_mm_dd($test_date);

        $this->assertEqual("05-09-2011",$reversed_date,"La data non e' stata ribaltata correttamente!!");

        $this->expectException("InvalidParameterException");
        DateTimeUtils::reverse_date_yyyy_mm_dd("14-10-2012");
    }

    function testMysqlNow()
    {
        $mysql_now = DateTimeUtils::mysql_now();

        $matches = array();

        $this->assertTrue(preg_match("/\A\d\d\d\d-\d\d-\d\d \d\d:\d\d\Z/",$mysql_now,$matches),"Il formato ritornato non e' corretto!!");
    }

    function testDay_yyyy_mm_dd()
    {
        $date = "2011-10-16";

        $day = DateTimeUtils::day_yyyy_mm_dd($date);

        $this->assertEqual(16,$day,"Il giorno non corrisponde!!");

        /*
        try
        {
            DateTimeUtils::day_yyyy_mm_dd("10-07-2012");
            $this->fail("Viene accettata una data in un formato non corretto!");
        }
        catch(InvalidParameterException $ex)
        {
            //ok
        }
        */
    }

}

?>