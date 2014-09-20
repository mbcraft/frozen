<?php
/* This software is released under the BSD license. Full text at project root -> license.txt */


class TestParamsChecker extends UnitTestCase
{
    /*
    function testValueGetPost()
    {
        $myvar = "rex";
        $_GET["myvar"] = "bog";
        $_POST["myvar"] = "quack";

        Params::value_get_post($myvar, "myvar");

        $this->assertEqual($myvar,"rex");

        $myvar = null;

        Params::value_get_post($myvar, "myvar");

        $this->assertEqual($myvar,"bog");

        $myvar = null;
        $_GET["myvar"] = null;

        Params::value_get_post($myvar, "myvar");

        $this->assertEqual($myvar,"quack");

        $myvar = null;
        $_POST["myvar"] = null;

        Params::value_get_post($myvar, "myvar");

        $this->assertNull($myvar);
    }

    function testValuePost()
    {
        $myvar = "rex";
        $_GET["myvar"] = "doc";
        $_POST["myvar"] = "quack";

        Params::value_post($myvar, "myvar");

        $this->assertEqual($myvar,"rex");

        $myvar = null;

        Params::value_post($myvar, "myvar");

        $this->assertEqual($myvar,"quack");

        $myvar = null;
        $_POST["myvar"] = null;

        Params::value_post($myvar, "myvar");

        $this->assertNull($myvar);
    }
     * 
     */
    function testCheckWithFlags()
    {

        $myvar = null;
        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::NOT_NULL,$results);
        $this->assertTrue(count($results)!=0,"Non viene lanciata l'eccezione per myvar==null!");

        $myvar = 0;
        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::NOT_ZERO,$results);
        $this->assertTrue(count($results)!=0,"Non viene lanciata l'eccezione per myvar==0!");


        $myvar = array();


        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::NOT_NULL | ParamChecker::NOT_ZERO,$results);
        $this->assertTrue(count($results)==0,"Errore nell'utilizzo dei check : array considerato nullo o 0!");
     
        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::NOT_EMPTY,$results);
        $this->assertTrue(count($results)!=0,"Non viene lanciata l'eccezione per myvar==array()!");

        $myvar = -2;

        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::NOT_EMPTY | ParamChecker::NOT_NULL | ParamChecker::NOT_ZERO,$results);
        $this->assertTrue(count($results)==0,"Errore nell'utilizzo dei check : array considerato nullo o 0!");


        $myvar = -2;
        $results = array();
        ParamChecker::checkWithFlags($myvar, "myvar", ParamChecker::VALID_ID,$results);
        $this->assertTrue(count($results)!=0,"Non viene lanciata l'eccezione per myvar==-2!");

    }

}


