<?php

class FakeController extends AbstractController
{
    function get_hello()
    {
        return Params::get("hello");
    }
}

class TestParams extends UnitTestCase
{
    function testParamsImportFromGet()
    {
        $_GET["hello"] = 5;
        $_GET["ciccia"] = "prova";

        Params::clear();
        Params::importFromGet();

        $this->assertTrue(Params::is_set("hello"),"Il parametro hello non e' stato importato correttamente!!");
        $this->assertEqual(Params::get("hello"),5,"Il valore non e' stato importato correttamente!!");

        unset($_GET["hello"]);
        unset($_GET["ciccia"]);


    }

    function testParamsImportFromPost()
    {
        $_POST["hello"] = 5;
        $_POST["ciccia"] = "prova";

        Params::clear();
        Params::importFromPost();

        $this->assertTrue(Params::is_set("hello"),"Il parametro hello non e' stato importato correttamente!!");
        $this->assertEqual(Params::get("hello"),5,"Il valore non e' stato importato correttamente!!");

        unset($_POST["hello"]);
        unset($_POST["ciccia"]);
    }

    function testNestedImportFromPost()
    {
        $_POST["hello"] = array("ciccia" => 5);

        Params::clear();
        Params::importFromPost();

        $this->assertTrue(Params::is_set("hello"),"Il parametro hello non e' stato importato correttamente!!");

        $hello = Params::get("hello");

        $this->assertEqual($hello["ciccia"],5,"Il valore non e' stato importato correttamente!!");

        unset($_POST["hello"]);
    }

    function testParamsNotset()
    {
        $_POST["__not_set_hello"] = 5;

        Params::clear();
        Params::importFromPost();

        $this->assertTrue(Params::is_set("hello"),"Il parametro hello non e' stato caricato!!");
        $this->assertEqual(Params::get("hello"),"5","Il parametro hello non e' stato caricato!!");

        unset($_POST["__not_set_hello"]);
    }

    function testParamsPassingToController()
    {
        Params::clear();

        $result = call("fake","get_hello",array("hello" => 5));

        $this->assertEqual($result,5,"Il valore ritornato dalla call non e' corretto!!");
    }
}

?>